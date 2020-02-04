<?php

/**
 * Class namespace
 */
namespace App\Tools\Settings\Traits;

/**
 * Used packages
 */
use App\Tools\DataSettings;
use App\Tools\Settings\LoginSettings;
use App\Tools\Settings\SportTypes;
use App\Tools\Settings\UrlSettings;

/**
 * Trait for getting data url
 *
 * Trait DataSettingsGetter
 * @package App\Tools\Settings\Traits
 */
trait DataSettingsGetter
{
    /**
     * get data url | uid->langx->gtype->showtype->gid->ltype->date
     *
     * @param array $urlData
     * @param bool $isLive
     * @param string $sportType
     * @return string
     */
    public static function url(array $urlData, string $sportType = SportTypes::BASKETBALL, bool $isLive = false)
    {
        return DataSettings::DATA_URL
            . UrlSettings::URL_SEPARATOR
            . 'uid'
            . UrlSettings::URL_PARAMS_EQUAL
            . $urlData['uid']
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(LoginSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::LL)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, $sportType === SportTypes::BASKETBALL ? DataSettings::G_TYPE_BK : DataSettings::G_TYPE_FT)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, DataSettings::SHOW_TYPE)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . 'gid'
            . UrlSettings::URL_PARAMS_EQUAL
            . $urlData['gid']
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, DataSettings::L_TYPE)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . 'date'
            . UrlSettings::URL_PARAMS_EQUAL
            . $urlData['date'];
    }

    /**
     * get matches list
     *
     * @param string $uid
     * @param string $sport
     * @param bool $isLive
     * @return string
     */
    public static function matchesListUrl(string $uid, string $sport = 'BK', $isLive = false)
    {
        return str_replace('{ST}', $sport, DataSettings::MATCH_LIST_URL)
            . UrlSettings::URL_SEPARATOR
            . 'uid'
            . UrlSettings::URL_PARAMS_EQUAL
            . $uid
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, LoginSettings::LL)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, !$isLive ? DataSettings::R_TYPE_MAIN : DataSettings::R_TYPE_LIVE)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, DataSettings::M_TYPE)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, DataSettings::PAGE_NO)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, DataSettings::LEAGUE_ID)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, DataSettings::HOT_GAME)
            . UrlSettings::URL_PARAMS_SEPARATOR
            . str_replace(DataSettings::SETTINGS_SEPARATOR, UrlSettings::URL_PARAMS_EQUAL, DataSettings::I_SIE_11);
    }
}
