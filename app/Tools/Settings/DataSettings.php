<?php

/**
 * Class namespace
 */
namespace App\Tools;

/**
 * Used packages
 */
use App\Tools\Settings\Traits\DataSettingsGetter;

/**
 * Class for getting data settings
 *
 * Class DataSettings
 * @package App\Tools
 */
class DataSettings
{
    /**
     * Data getter trait
     */
    use DataSettingsGetter;

    const DATA_URL = 'http://w849.hga025.com/app/member/get_game_allbets.php';
    const MATCH_LIST_URL = 'http://w849.hga025.com/app/member/{ST}_browse/body_var.php';

    const G_TYPE = 'gtype||BK';
    const G_TYPE_BK = 'gtype||BK';
    const G_TYPE_FT = 'gtype||FT';
    const SHOW_TYPE = 'showtype||FT';
    const L_TYPE = 'ltype||4';
    const R_TYPE_MAIN = 'rtype||r_main';
    const R_TYPE_LIVE = 'rtype||re';
    const M_TYPE = 'mtype||4';
    const PAGE_NO = 'page_no||0';
    const LEAGUE_ID = 'league_id||';
    const HOT_GAME = 'hot_game||';
    const I_SIE_11 = 'isie11||%27N%27';

    const SETTINGS_SEPARATOR = '||';

    CONST URL_FOOTBALL_TYPE = 'FT';
    CONST URL_BASKETBALL_TYPE = 'BK';

    CONST MATCHES_IDS_IDENTIFIER = 'Y\']); g([\'';
    CONST MATCHES_EXPLODE_DELIMETER = '\',\'';
}
