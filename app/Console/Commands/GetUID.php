<?php

/**
 * Class namespace
 */
namespace App\Console\Commands;

/**
 * Used packages
 */
use App\Jobs\ProcessSpecificMatch;
use App\Tools\HgaClient;
use App\Tools\HgaConnector;
use App\Tools\Settings\SportTypes;
use App\Traits\Processors;
use Illuminate\Console\Command;

/**
 * Class for processing data with Hga025
 *
 * Class GetUID
 * @package App\Console\Commands
 */
class GetUID extends Command
{
    use Processors;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:odds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get uid for sending requests';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Running processors');

        $guzzle = new \GuzzleHttp\Client(['headers' =>
            [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'en-US,en;q=0.9',
                'Cache-Control' => 'max-age=0',
                'Connection' => 'keep-alive',
                'Cookie' => '_ga=GA1.2.1646811937.1581251963; _gid=GA1.2.253348605.1582564206; protocolstr=https',
                'Host' => 'hga025.com',
                'Upgrade-Insecure-Requests' => 1,
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36',
            ]
        ]);

        $res = $guzzle->request('GET', 'https://hga025.com/');
        dd($res->getBody()->getContents());

        try {
            $connector = (new HgaConnector())->refreshConnection();
            $hgaClient = new HgaClient($connector);

            $this->dispatchPreMatch($hgaClient, $connector);
            $this->dispatchLive($hgaClient, $connector);

            sleep(env('SLEEP_TIME'));
            $this->call('process:odds');
        } catch (\Exception $e) {

            $this->info('Server falling.. Retry in fifteen seconds..');
            sleep(env('SLEEP_TIME'));

            $this->call('process:odds');
        }
    }

    /**
     * dispatch pre match workers
     *
     * @param HgaClient $hgaClient
     * @param HgaConnector $connector
     */
    private function dispatchPreMatch(HgaClient $hgaClient, HgaConnector $connector)
    {
        foreach (collect($hgaClient->matches())->chunk(15) as $chunkedMatches) {

            $counter = 1;
            foreach ($chunkedMatches as $key => $matchId) {
                ProcessSpecificMatch::dispatch($connector->uid(), SportTypes::BASKETBALL, false, $matchId)
                    ->onQueue('p' . $counter);

                $counter++;
            }
        }
    }

    /**
     * dispatch live matches
     *
     * @param HgaClient $hgaClient
     * @param HgaConnector $connector
     */
    private function dispatchLive(HgaClient $hgaClient, HgaConnector $connector)
    {
        foreach (collect($hgaClient->matches(SportTypes::BASKETBALL, true))->chunk(5) as $chunkedMatches) {

            $counter = 1;
            foreach ($chunkedMatches as $key => $matchId) {
                ProcessSpecificMatch::dispatch($connector->uid(), SportTypes::BASKETBALL, true, $matchId)
                    ->onQueue('pL' . $counter);

                $counter++;
            }
        }
    }
}
