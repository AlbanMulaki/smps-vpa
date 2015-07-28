<?php
/**
 * This file is part of Related Threads plugin for MyBB.
 * Copyright (C) Lukasz Tkacz <lukasamd@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */ 

/**
 * Disallow direct access to this file for security reasons
 * 
 */
if (!defined("IN_MYBB")) exit;

/**
 * Create plugin object
 * 
 */
$plugins->objects['relatedThreads'] = new relatedThreads();

/**
 * Standard MyBB info function
 * 
 */
function relatedThreads_info()
{
    global $lang;

    $lang->load('relatedThreads');
    
    $lang->relatedThreadsDesc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' . 
        '<input type="hidden" name="hosted_button_id" value="3BTVZBUG6TMFQ">' .
        '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->relatedThreadsDesc;

    return Array(
        'name' => $lang->relatedThreadsName,
        'description' => $lang->relatedThreadsDesc,
        'website' => 'http://lukasztkacz.com',
        'author' => 'Lukasz "LukasAMD" Tkacz',
        'authorsite' => 'http://lukasztkacz.com',
        'version' => '1.0.1',
        'compatibility' => '18*'
    );
}

/**
 * Standard MyBB installation functions 
 * 
 */
function relatedThreads_install()
{
    require_once('relatedThreads.settings.php');
    relatedThreadsInstaller::install();
}

function relatedThreads_is_installed()
{
    global $mybb;

    return (isset($mybb->settings['relatedThreadsLength']));
}

function relatedThreads_uninstall()
{
    require_once('relatedThreads.settings.php');
    relatedThreadsInstaller::uninstall();
}

/**
 * Standard MyBB activation functions 
 * 
 */
function relatedThreads_activate()
{
    require_once('relatedThreads.tpl.php');
    relatedThreadsActivator::activate();
}

function relatedThreads_is_activated()
{
    global $mybb;

    return (isset($mybb->settings['relatedThreadsLength']));
}

function relatedThreads_deactivate()
{
    require_once('relatedThreads.tpl.php');
    relatedThreadsActivator::deactivate();
}

/**
 * Plugin Class
 * 
 */
class relatedThreads
{

    // Where statement for sql
    private $where = '';
     
    /**
     * Constructor - add plugin hooks
     */
    public function __construct()
    {
        global $plugins;

        $plugins->hooks["xmlhttp"][10]["relatedThreads_displayThreads"] = array("function" => create_function('','global $plugins; $plugins->objects[\'relatedThreads\']->displayThreads();')); 
        $plugins->hooks["newthread_start"][10]["relatedThreads_injectNewthread"] = array("function" => create_function('','global $plugins; $plugins->objects[\'relatedThreads\']->injectNewthread();')); 
        $plugins->hooks["pre_output_page"][10]["relatedThreads_pluginThanks"] = array("function" => create_function('&$arg', 'global $plugins; $plugins->objects[\'relatedThreads\']->pluginThanks($arg);'));
    }

    /**
     * Inject hidden fields for javascript code in newthread template.
     * 
     * @return bool False.
     */
    public function injectNewthread()
    {
        global $forum, $lang, $mybb, $relatedThreadsJavaScript, $templates;

        $lang->load('relatedThreads');
        if ($this->getConfig('Timer') == 0)
        {
            $this->setConfig('Timer', '1000');
        }
        if ($this->getConfig('Length') == 0)
        {
            $this->setConfig('Length', '4');
        }
        
        eval("\$relatedThreadsJavaScript = \"" . $templates->get("relatedThreads_javascript") . "\";");
    }

    /**
     * Search for related threads and display output list.
     * 
     * @return bool False if there are not related threads or string if there are.
     */
    public function displayThreads()
    {
        global $mybb, $db, $lang, $relatedThreads, $templates;

        if ($mybb->input['action'] != 'relatedThreads')
        {
            return;
        }
        header("Content-type: text/xml; charset=UTF-8");

        // Fix MyBB setting type 
        if ($this->getConfig('Length') == 0)
        {
            $this->setConfig('Length', '4');
        }

        $userSubject = trim($mybb->input['subject']);
        if (!$mybb->user['uid'] || my_strlen($userSubject) < $this->getConfig('Length'))
        {
            return;
        }

        // Fix MyBB setting type 
        if ($this->getConfig('Limit') == 0)
        {
            $this->setConfig('Limit', '5');
        }

        // Prepare sql statements
        $this->where = '';
        $this->getStandardWhere();
        $this->getForumCheck();
        $this->getExceptions();
        $this->getTimeLimit();
        $this->getPermissions();
        $this->getUnsearchableForums();
        $this->getInactiveForums();

        // Use fulltext search index...
        if ($this->getConfig('Fulltext') && $db->supports_fulltext("threads"))
        {
            $this->where .= " AND MATCH(subject) AGAINST('" . $db->escape_string($userSubject) . "') ";
        }
        // ...or build LIKE query
        else
        {
            $keywords = $this->getKeywords($userSubject);
            $countKeywords = count($keywords);

            if (!$countKeywords)
            {
                return;
            }

            $this->where .= " AND subject LIKE '%" . $db->escape_string($keywords[0]) . "%' ";
            for ($i = 1; $i < $countKeywords; $i++)
            {
                $this->where .= "OR subject LIKE '%" . $db->escape_string($keywords[$i]) . "%' ";
            }
        }

        $sql = "SELECT tid, fid, subject, prefix
                FROM " . TABLE_PREFIX . "threads
                WHERE {$this->where} 
                LIMIT " . $this->getConfig('Limit');
        $result = $db->query($sql);
        
        if (!$db->num_rows($result))
        {
            return;
        }

        $tids = array();
        $threadsList = array();
        while ($row = $db->fetch_array($result))
        {
            $tids[] = $row['fid'];

            $threadsList[$row['tid']] = array(
                'subject' => stripslashes($row['subject']),
                'link' => ($this->getConfig('LinkLastPost')) ? get_thread_link($row['tid'], 0, 'lastpost') : get_thread_link($row['tid']),
                'fid' => $row['fid'],
				'threadprefix' => '',
            );
			
			// Thread prefix
			if($this->getConfig('ShowPrefixes') != 0 && $row['prefix'] != 0)
			{
				$threadprefix = build_prefixes($row['prefix']);
				$threadsList[$row['tid']]['threadprefix'] = $threadprefix['displaystyle'].'&nbsp;';
			}
        }

        // Get forums data
        if ($this->getConfig('ForumGet'))
        {
            $forumsList = array();

            $sql = "SELECT name, fid
                    FROM " . TABLE_PREFIX . "forums 
                    WHERE fid IN (" . implode(',', $tids) . ")";
            $result = $db->query($sql);
            while ($row = $db->fetch_array($result))
            {
                $forumsList[$row['fid']] = array(
                    'name' => stripslashes($row['name']),
                    'link' => get_forum_link($row['fid']),
                );
            }
        }

        // Prepare variable for templates
        $linkTarget = ($this->getConfig('NewWindow')) ? 'target="_blank" ' : '';

        // Display additional code
        if ($this->getConfig('CodeStatus'))
        {
            echo $templates->get("relatedThreads_code");
        }

        // Display all elements
        $relatedThreads['list'] = '';
        foreach ($threadsList as $thread)
        {
            if ($this->getConfig('ForumGet'))
            {
                $forum['link'] = $forumsList[$thread['fid']]['link'];
                $forum['name'] = $forumsList[$thread['fid']]['name'];
                eval("\$relatedThreads['element'] = \"" . $templates->get("relatedThreads_withForum") . "\";");
            }
            else
            {
                eval("\$relatedThreads['element'] = \"" . $templates->get("relatedThreads_withoutForum") . "\";");
            }

            eval("\$relatedThreads['list'] .= \"" . $templates->get("relatedThreads_listElement") . "\";");
        }
        eval("\$relatedThreads['content'] = \"" . $templates->get("relatedThreads_list") . "\";");
        echo $relatedThreads['content'];
    }

    /**
     * Additional function for get keywords from string 
     * 
     * @param string String to analyze
     * @return array Table with keywords.
     */
    private function getKeywords($string)
    {
        $string = preg_replace('#\s+#i', ' ', $string);

        $keywords = explode(' ', $string);
        $keywords = array_map('trim', $keywords);
        $keywords = array_filter($keywords, array($this, 'checkKeywords'));
        $keywords = array_unique($keywords);
        shuffle($keywords);

        return $keywords;
    }

    /**
     * Additional function for array_filter when we build LIKE query - delete too short keywords 
     * 
     * @return bool False if there keyword is too short.
     */
    private function checkKeywords($val)
    {
        $badWords = explode(',', $this->getConfig('BadWords'));
        if (my_strlen($val) >= $this->getConfig('Length') && !in_array($val, $badWords))
        {
            return true;
        }
        return false;
    }

    /**
     * Get standard SQL WHERE statement - closed and moved threads are not allowed
     */
    private function getStandardWhere()
    {
        $this->where .= "visible = 1 AND closed NOT LIKE 'moved|%'";
    }

    /**
     * Additional function to build all WHERE statements - privilages, exceptions, groups etc.
     * 
     * @return string	- query part.
     */
    private function getTimeLimit()
    {
        global $mybb;

        $timeLimit = (int) $this->getConfig('TimeLimit');
        if (!$this->getConfig('LimitSelect') || $timeLimit < 1)
        {
            return;
        }

        switch ($this->getConfig('TimeLimitSelect'))
        {
            case 'h':
            default:
                $timeLimit *= 3600;
                break;

            case 'd':
                $timeLimit *= 3600 * 24;
                break;
                
            case 'w':
                $timeLimit *= 3600 * 24 * 7;
                break;
                
            case 'm':
                $timeLimit *= 3600 * 24 * 30;
                break;
                
            case 'y':
                $timeLimit *= 3600 * 24 * 365;
                break;
        }

        $timeLimit = TIME_NOW - $timeLimit;

        if ($this->getConfig('TimeLimitMethodDesc') == 'firstPost')
        {
            $this->where .= " AND dateline > " . $timeLimit . " ";
        }
        else
        {
            $this->where .= " AND lastpost > " . $timeLimit . " ";
        }
    }

    /**
     * Additional function to check if script should search threads on the same forum.
     */
    private function getForumCheck()
    {
        global $mybb;

        if (!$this->getConfig('ForumOnly'))
        {
            return;
        }

        $actualFid = (int) $mybb->input['fid'];
        if ($actualFid > 0)
        {
            $this->where .= " AND fid = '{$actualFid}' ";
        }
    }

    /**
     * Get all forums exceptions to SQL WHERE statement
     */
    private function getExceptions()
    {
        if ($this->getConfig('Exceptions') == '')
        {
            return;
        }

        $exceptions_list = explode(',', $this->getConfig('Exceptions'));
        $exceptions_list = array_map('intval', $exceptions_list);

        if (sizeof($exceptions_list) > 0)
        {
            $this->where .= " AND fid NOT IN (" . implode(',', $exceptions_list) . ")";
        }
    }

    /**
     * Build a comma separated list of the forums this user cannot search
     *
     * @param int The parent ID to build from
     * @param int First rotation or not (leave at default)
     * @return return a CSV list of forums the user cannot search
     */
    private function getUnsearchableForums($pid="0", $first=1)
    {
        global $db, $forum_cache, $permissioncache, $mybb, $unsearchableforums, $unsearchable, $templates, $forumpass;

        $pid = intval($pid);

        if (!is_array($forum_cache))
        {
            // Get Forums
            $query = $db->simple_select("forums", "fid,parentlist,password,active", '', array('order_by' => 'pid, disporder'));
            while ($forum = $db->fetch_array($query))
            {
                $forum_cache[$forum['fid']] = $forum;
            }
        }
        if (!is_array($permissioncache))
        {
            $permissioncache = forum_permissions();
        }
        foreach ($forum_cache as $fid => $forum)
        {
            if ($permissioncache[$forum['fid']])
            {
                $perms = $permissioncache[$forum['fid']];
            }
            else
            {
                $perms = $mybb->usergroup;
            }

            $pwverified = 1;
            if ($forum['password'] != '')
            {
                if ($mybb->cookies['forumpass'][$forum['fid']] != md5($mybb->user['uid'] . $forum['password']))
                {
                    $pwverified = 0;
                }
            }

            $parents = explode(",", $forum['parentlist']);
            if (is_array($parents))
            {
                foreach ($parents as $parent)
                {
                    if ($forum_cache[$parent]['active'] == 0)
                    {
                        $forum['active'] = 0;
                    }
                }
            }

            if ($perms['canview'] != 1 || $perms['cansearch'] != 1 || $pwverified == 0 || $forum['active'] == 0)
            {
                if ($unsearchableforums)
                {
                    $unsearchableforums .= ",";
                }
                $unsearchableforums .= "'{$forum['fid']}'";
            }
        }
        $unsearchable = $unsearchableforums;

        // Get our unsearchable password protected forums
        $pass_protected_forums = $this->getPasswordProtectedForums();

        if ($unsearchable && $pass_protected_forums)
        {
            $unsearchable .= ",";
        }

        if ($pass_protected_forums)
        {
            $unsearchable .= implode(",", $pass_protected_forums);
        }

        if ($unsearchable)
        {
            $this->where .= " AND fid NOT IN ($unsearchable)";
        }
    }

    /**
     * Build a array list of the forums this user cannot search due to password protection
     *
     * @param int the fids to check (leave null to check all forums)
     * @return return a array list of password protected forums the user cannot search
     */
    private function getPasswordProtectedForums($fids=array())
    {
        global $forum_cache, $mybb;

        if (!is_array($fids))
        {
            return false;
        }

        if (!is_array($forum_cache))
        {
            $forum_cache = cache_forums();
            if (!$forum_cache)
            {
                return false;
            }
        }

        if (empty($fids))
        {
            $fids = array_keys($forum_cache);
        }

        $pass_fids = array();
        foreach ($fids as $fid)
        {
            if (empty($forum_cache[$fid]['password']))
            {
                continue;
            }

            if (md5($mybb->user['uid'] . $forum_cache[$fid]['password']) != $mybb->cookies['forumpass'][$fid])
            {
                $pass_fids[] = $fid;
                $child_list = get_child_list($fid);
            }

            if (is_array($child_list))
            {
                $pass_fids = array_merge($pass_fids, $child_list);
            }
        }
        return array_unique($pass_fids);
    }

    /**
     * Get all forums premissions to SQL WHERE statement
     */
    private function getPermissions()
    {
        $onlyusfids = array();

        // Check group permissions if we can't view threads not started by us
        $group_permissions = forum_permissions();
        foreach ($group_permissions as $fid => $forum_permissions)
        {
            if ($forum_permissions['canonlyviewownthreads'] == 1)
            {
                $onlyusfids[] = $fid;
            }
        }
        if (!empty($onlyusfids))
        {
            $this->where .= " AND ((fid IN(" . implode(',', $onlyusfids) . ") AND uid='{$mybb->user['uid']}') OR fid NOT IN(" . implode(',', $onlyusfids) . "))";
        }
    }

    /**
     * Get all inactive forums
     */
    private function getInactiveForums()
    {
        $inactiveforums = get_inactive_forums();
        if ($inactiveforums)
        {
            $this->where .= " AND fid NOT IN ($inactiveforums)";
        }
    }

    /**
     * Helper function to get variable from config
     * 
     * @param string $name Name of config to get
     * @return string Data config from MyBB Settings
     */
    private function getConfig($name)
    {
        global $mybb;

        return $mybb->settings["relatedThreads{$name}"];
    }

    /**
     * Helper function to set variable in config
     * 
     * @param string $name Name of config to set
     * @param string $val Value of config to get
     */
    private function setConfig($name, $val)
    {
        global $db;

        $name = (string) $name;
        $val = (string) $val;

        if (empty($name) || empty($val))
        {
            return;
        }

        $db->update_query("settings", array("value" => $db->escape_string($val)), "name = 'relatedThreads" . $db->escape_string($name) . "'");
        rebuild_settings();
    }
    
    /**
     * Say thanks to plugin author - paste link to author website.
     * Please don't remove this code if you didn't make donate
     * It's the only way to say thanks without donate :)     
     */
    public function pluginThanks(&$content)
    {
        global $session, $lukasamd_thanks;
        
        if (!isset($lukasamd_thanks) && $session->is_spider)
        {
            $thx = '<div style="margin:auto; text-align:center;">This forum uses <a href="http://lukasztkacz.com">Lukasz Tkacz</a> MyBB addons.</div></body>';
            $content = str_replace('</body>', $thx, $content);
            $lukasamd_thanks = true;
        }
    }

}
