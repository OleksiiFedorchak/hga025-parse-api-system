<?php

/**
 * Trait namespace
 */
namespace App\Traits;

/**
 * Used packages
 */
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Carbon\Carbon;

/**
 * Noifiable trait for sending messages to telegram
 *
 * Trait Notifiable
 * @package App\Traits
 */
trait Notifiable
{
    /**
     * Notify using telegram
     *
     * @param string $property
     * @param float $oldValue
     * @param float $newValue
     * @param boolean $isRed
     * @throws TelegramSDKException
     */
    public function notify(string $property, float $oldValue, float $newValue, bool $isRed = false)
    {
        if ($isRed) {
            $EmojiUtf8Byte = '\xF0\x9F\x94\xB4';
        } else {
            $EmojiUtf8Byte = '\xF0\x9F\x94\xB5';
        }

        $pattern = '@\\\x([0-9a-fA-F]{2})@x';
        $emoji = preg_replace_callback($pattern, function ($captures) {
                return chr(hexdec($captures[1]));
            },$EmojiUtf8Byte
        );

        $message =
            '<i>' . $emoji . '</i>' . "\r\n"
            . '<i>It seems, there is something worthy to check...</i>' . "\r\n"
            . 'The property ' . $property . ' has been changed!' . "\r\n"
            . 'The difference: <b>' . ($newValue - $oldValue) . '</b>: ' . "\r\n"
            . 'Scores: (' . $newValue . '-' . $oldValue . ')' . "\r\n"
            . 'Time: ' . Carbon::now();

        (new Api(env('TELEGRAM_API_TOKEN')))->sendMessage([
            'chat_id' => '@hga025_notifications',
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
}
