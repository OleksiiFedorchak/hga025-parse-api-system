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
     * @throws TelegramSDKException
     */
    public function notify(string $property, float $oldValue, float $newValue)
    {
        (new Api(env('TELEGRAM_API_TOKEN')))->sendMessage([
            'chat_id' => '@hga025_notifications',
            'text' => '<b>Changes detected</b>' . "\r\n"
                . '<i>' . $property . ': </i>' . ($newValue - $oldValue) . ' (' . $newValue . ' - ' . $oldValue . '). ' . "\r\n",

            'parse_mode' => 'HTML',
        ]);
    }
}
