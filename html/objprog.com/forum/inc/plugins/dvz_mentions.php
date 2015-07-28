<?php
/* by Tomasz 'Devilshakerz' Mlynski [devilshakerz.com]; Copyright (C) 2014
 released under Creative Commons BY-NC-SA 3.0 license: http://creativecommons.org/licenses/by-nc-sa/3.0/ */

$plugins->add_hook('parse_message', ['dvz_mentions', 'parse']);
$plugins->add_hook('pre_output_page', ['dvz_mentions', 'global_replace']);

function dvz_mentions_info ()
{
    return [
        'name'           => 'DVZ Mentions',
        'description'    => 'Parses <i>@username</i> into profile link with group color.',
        'website'        => 'http://devilshakerz.com/',
        'author'         => 'Tomasz \'Devilshakerz\' Mlynski',
        'authorsite'     => 'http://devilshakerz.com/',
        'version'        => '0.2',
        'codename'       => 'dvz_mentions',
        'compatibility'  => '18*',
    ];
}

if (THIS_SCRIPT == 'xmlhttp.php' || THIS_SCRIPT == 'newreply.php') {
    dvz_mentions::$global = false;
}

class dvz_mentions {

    // configuration
    static $keepPrefix = true;
    static $color      = true;
    static $ignore     = [];

    static $usernames  = [];
    static $global     = true;

    static function parse (&$message)
    {

        preg_match_all('/(?:^|\s)@(?:([^"<>,;!?()\[\]{}&\'\s\\\]{3,})|"([^"<>,;&\'\\\]{3,})")/', $message, $regexMatches, PREG_OFFSET_CAPTURE);

        $matches = [];

        // merge regex catch groups
        if ($regexMatches) {
            foreach ($regexMatches[1] as $match) {
                if (!empty($match[0]) && !in_array($match[0], dvz_mentions::$ignore)) {
                    $match['quotes'] = false;
                    $matches[] = $match;
                }
            }
            foreach ($regexMatches[2] as $match) {
                if (!empty($match[0])) {
                    $match['quotes'] = true;
                    $matches[] = $match;
                }
            }
        }

        // sort by match offset
        usort($matches, function($a, $b){
            if ($a[1] > $b[1]) return 1;
            if ($a[1] < $b[1]) return -1;
            return 0;
        });

        // gather data for single message
        if (!dvz_mentions::$global) {

            $usernames = [];

            foreach ($matches as $match) {
                $usernames[] = $match[0];
            }

            $usernames = array_unique($usernames);

            $users = dvz_mentions::get_users($usernames);

        }

        // offset correction
        $correction = 0;

        foreach ($matches as $index => $match) {

            if (dvz_mentions::$global) {

                // build global cache
                if (!in_array($match[0], dvz_mentions::$usernames)) {
                    dvz_mentions::$usernames[] = $match[0];
                }
                $cacheIndex = array_search($match[0], dvz_mentions::$usernames);

                $replacement = '<DVZ_ME#' . $cacheIndex . '>';

            } else {

                // insert mentions locally
                $user = &$users[ mb_strtolower($match[0]) ];

                if (isset($user)) {

                    $username = dvz_mentions::$color
                        ? format_name($user['username'], $user['usergroup'], $user['displaygroup'])
                        : $username
                    ;

                    $replacement = (dvz_mentions::$keepPrefix ? '@' : null) . build_profile_link($username, $user['uid'])
;
                } else {
                    $replacement = '@' . ($match['quotes'] ? '"' . $match[0] . '"' : $match[0]);
                }

            }

            // offset, quotation mark, call character, correction
            $start  = $match[1] - ($match['quotes'] ? 1 : 0) - 1 + $correction;

            // call character, quotation marks, match length
            $length = 1 + ($match['quotes'] ? 2 : 0) + strlen($match[0]);

            $message = substr_replace($message, $replacement, $start, $length);

            $correction += strlen($replacement) - $length;

        }

        return $message;

    }

    static function global_replace (&$content)
    {
        global $db;

        if (dvz_mentions::$usernames) {

            // get user data

            $users = dvz_mentions::get_users(dvz_mentions::$usernames);

            // replace mentions

            foreach (dvz_mentions::$usernames as $index => $username) {

                if (isset( $users[ mb_strtolower($username) ] )) {

                    $user = $users[ mb_strtolower($username) ];

                    $username = dvz_mentions::$color
                        ? format_name($user['username'], $user['usergroup'], $user['displaygroup'])
                        : $username
                    ;

                    $replacement = (dvz_mentions::$keepPrefix ? '@' : null) . build_profile_link($username, $user['uid']);

                } else {
                    $replacement = '@' . $username;
                }

                $content = str_replace('<DVZ_ME#' . $index . '>', $replacement, $content);

            }

        }

        return $content;

    }

    static function get_users ($usernames)
    {
        global $db;

        $users = [];

        if ($usernames) {

            array_walk($usernames, function(&$username) use ($db){
                $username = "'" . $db->escape_string( mb_strtolower($username) ) . "'";
            });

            $data = $db->simple_select('users', 'uid' . (dvz_mentions::$color ? ',username,usergroup,displaygroup' : null), 'LOWER(username) IN (' . implode(',', $usernames) . ')');

            while ($row = $db->fetch_array($data)) {
                $users[ mb_strtolower($row['username']) ] = $row;
            }

        }

        return $users;

    }

}