<?php

namespace App\Observers;

use App\Match;
use App\Traits\Notifiable;
use Telegram\Bot\Exceptions\TelegramSDKException;

class MatchObserver
{
    use Notifiable;

    /**
     * Handle the match "created" event.
     *
     * @param  Match  $match
     * @throws TelegramSDKException
     * @return void
     */
    public function created(Match $match)
    {
        $prevMatch = Match::where('id', '<', $match->id)
            ->where('match_id', $match->match_id)
            ->orderBy('id', 'DESC')
            ->first();

        if (!$prevMatch)
            return;

        foreach ($prevMatch->getTrackableProperties() as $property) {
            if ($prevMatch->$property == 0 || $match->$property == 0)
                return;

            if (($match->$property - $prevMatch->$property) < 2)
                return;

            $this->notify($property, (float) $match->$property, (float) $prevMatch->$property);
        }
    }

    /**
     * Handle the match "updated" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function updated(Match $match)
    {
        //
    }

    /**
     * Handle the match "deleted" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function deleted(Match $match)
    {
        //
    }

    /**
     * Handle the match "restored" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function restored(Match $match)
    {
        //
    }

    /**
     * Handle the match "force deleted" event.
     *
     * @param  \App\Match  $match
     * @return void
     */
    public function forceDeleted(Match $match)
    {
        //
    }
}
