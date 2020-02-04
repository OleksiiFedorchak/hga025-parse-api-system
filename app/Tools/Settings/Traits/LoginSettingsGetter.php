<?php

/**
 * Class namespace
 */
namespace App\Tools\Settings\Traits;

/**
 * Used packages
 */
use App\Tools\Settings\LoginSettings;
use App\Tools\Settings\UrlSettings;
use Illuminate\Support\Facades\Log;

/**
 * Trait for getting settings
 *
 * Trait LoginSettingsGetter
 * @package App\Tools\Settings\Traits
 */
trait LoginSettingsGetter
{
    /**
     * get url
     *
     * @return string
     */
    public static function url()
    {
        return LoginSettings::LOGIN_URL
            . UrlSettings::URL_SEPARATOR
            . str_replace(LoginSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::LOGIN)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(LoginSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::PASSWORD)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(LoginSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::LL)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(LoginSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::AUTO)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(LoginSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::BLACK_BOX)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(LoginSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::NEW_SITE);
    }
}
