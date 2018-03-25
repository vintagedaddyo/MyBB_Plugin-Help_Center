<?php
/***************************************************************************
 *
 *  Help Center plugin (/inc/plugins/helpcenter.php)
 *  Authors: Pirata Nervo, Vintagedaddyo
 *  Copyright: © 2009-2010 Pirata Nervo
 *  Website: http://mybb-plugins.com
 *
 *  Vintagedaddyo: http://community.mybb.com/user-6029.html
 *  
 *  License: license.txt
 *
 *  Adds a powerful Help Center to MyBB.
 *
 *  MyBB Version: 1.8
 *
 *  Plugin Version: 1.7
 *
 ***************************************************************************/
 
/****************************************************************************
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
****************************************************************************/

if(!defined("IN_MYBB"))
	die("This file cannot be accessed directly.");
	
$plugins->add_hook('admin_load', 'helpcenter_admin');
$plugins->add_hook('admin_tools_menu', 'helpcenter_admin_tools_menu');
$plugins->add_hook('admin_tools_action_handler', 'helpcenter_admin_tools_action_handler');
$plugins->add_hook('admin_tools_permissions', 'helpcenter_admin_permissions');
$plugins->add_hook("build_friendly_wol_location_end", "helpcenter_online");

function helpcenter_info()
{
    global $lang;

    $lang->load("helpcenter");
    
    $lang->helpcenter_Desc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' . 
        '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' .
        '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->helpcenter_Desc;

    return Array(
        'name' => $lang->helpcenter_Name,
        'description' => $lang->helpcenter_Desc,
        'website' => $lang->helpcenter_Web,
        'author' => $lang->helpcenter_Auth,
        'authorsite' => $lang->helpcenter_AuthSite,
        'version' => $lang->helpcenter_Ver,
        'guid' => 'c3456f45ddf1e02b9ed68e1513b50644',
        'compatibility' => $lang->helpcenter_Compat
    );
}


function helpcenter_install()
{
	global $db, $lang;
	// create settings group
	$insertarray = array(
		'name' => 'helpcenter', 
		'title' => ''.$lang->helpcenter_option_0_Title.'', 
		'description' => ''.$lang->helpcenter_option_0_Description.'', 
		'disporder' => 100, 
		'isdefault' => 0
	);
	$gid = $db->insert_query("settinggroups", $insertarray);
	
	// add settings
	$setting1 = array(
		"sid"			=> 0,
		"name"			=> "helpcenter_enabled",
		"title"         => ''.$lang->helpcenter_option_1_Title.'', 
		"description"   => ''.$lang->helpcenter_option_1_Description.'', 
		"optionscode"	=> "yesno",
		"value"			=> "1",
		"disporder"		=> 1,
		"gid"			=> $gid
	);

	$db->insert_query("settings", $setting1);

	$setting2 = array(
		"sid"			=> 0,
		"name"			=> "helpcenter_modgroups",
		"title"         => ''.$lang->helpcenter_option_2_Title.'', 
		"description"   => ''.$lang->helpcenter_option_2_Description.'', 
		"optionscode"	=> "text",
		"value"			=> "4",
		"disporder"		=> 2,
		"gid"			=> $gid
	);

	$db->insert_query("settings", $setting2);
	
	$setting3 = array(
		"sid"			=> 0,
		"name"			=> "helpcenter_newtickets_enabled",
		"title"         => ''.$lang->helpcenter_option_3_Title.'', 
		"description"   => ''.$lang->helpcenter_option_3_Description.'', 
		"optionscode"	=> "yesno",
		"value"			=> "1",
		"disporder"		=> 3,
		"gid"			=> $gid
	);

	$db->insert_query("settings", $setting3);
	
	$setting4 = array(
		"sid"			=> 0,
		"name"			=> "helpcenter_docs_enabled",
		"title"         => ''.$lang->helpcenter_option_4_Title.'', 
		"description"   => ''.$lang->helpcenter_option_4_Description.'', 
		"optionscode"	=> "yesno",
		"value"			=> "1",
		"disporder"		=> 4,
		"gid"			=> $gid
	);

	$db->insert_query("settings", $setting4);
	
	$setting5 = array(
		"sid"			=> 0,
		"name"			=> "helpcenter_tickets_emailmode",
		"title"         => ''.$lang->helpcenter_option_5_Title.'', 
		"description"   => $lang->helpcenter_option_5_Description, 
		"optionscode"	=> "yesno",
		"value"			=> "0",
		"disporder"		=> 5,
		"gid"			=> $gid
	);

	$db->insert_query("settings", $setting5);
	
	$setting6 = array(
		"sid"			=> 0,
		"name"			=> "helpcenter_tickets_email",
		"title"         => ''.$lang->helpcenter_option_6_Title.'', 
		"description"   => ''.$lang->helpcenter_option_6_Description.'', 
		"optionscode"	=> "text",
		"value"			=> "",
		"disporder"		=> 6,
		"gid"			=> $gid
	);

	$db->insert_query("settings", $setting6);
	
	rebuild_settings();
	
	
	$db->write_query("CREATE TABLE `".TABLE_PREFIX."helpcenter_tickets` (
	  `tid` bigint(30) UNSIGNED NOT NULL auto_increment,
	  `uid` bigint(30) UNSIGNED NOT NULL default '0',
	  `date` bigint(30) UNSIGNED NOT NULL default '0',
	  `name` varchar(300) NOT NULL default '',
	  `messages` int(10) UNSIGNED NOT NULL default '0',
	  `opened` smallint(1) UNSIGNED NOT NULL default '1',
	  `priority` smallint(1) UNSIGNED NOT NULL default '0',
	  `cid` bigint(30) UNSIGNED NOT NULL default '0',
	  PRIMARY KEY  (`tid`)
		) ENGINE=MyISAM");
	
	$db->write_query("CREATE TABLE `".TABLE_PREFIX."helpcenter_messages` (
	  `mid` bigint(30) UNSIGNED NOT NULL auto_increment,
	  `tid` bigint(30) UNSIGNED NOT NULL default '0',
	  `uid` bigint(30) UNSIGNED NOT NULL default '0',
	  `date` bigint(30) UNSIGNED NOT NULL default '0',
	  `message` TEXT NOT NULL,
	  `first` smallint(1) UNSIGNED NOT NULL default '0',
	  PRIMARY KEY  (`mid`)
		) ENGINE=MyISAM");
	
	$db->write_query("CREATE TABLE `".TABLE_PREFIX."helpcenter_categories` (
	  `cid` bigint(30) UNSIGNED NOT NULL auto_increment,
	  `name` varchar(300) NOT NULL default '',
	  `description` varchar(300) NOT NULL default '',
	  `tickets` bigint(30) UNSIGNED NOT NULL default '0',
	  PRIMARY KEY  (`cid`)
		) ENGINE=MyISAM");
	
	$db->write_query("CREATE TABLE `".TABLE_PREFIX."helpcenter_priorities` (
	  `pid` bigint(30) UNSIGNED NOT NULL auto_increment,
	  `name` varchar(300) NOT NULL default '',
	  `description` varchar(300) NOT NULL default '',
	  `level` smallint(2) UNSIGNED NOT NULL default '1',
	  `format` varchar(300) NOT NULL default '{priority}',
	  PRIMARY KEY  (`pid`)
		) ENGINE=MyISAM");
	
	$db->write_query("CREATE TABLE `".TABLE_PREFIX."helpcenter_docs_cat` (
	  `cid` bigint(30) UNSIGNED NOT NULL auto_increment,
	  `name` varchar(300) NOT NULL default '',
	  `description` varchar(300) NOT NULL default '',
	  `docs` int(10) UNSIGNED NOT NULL default '0',
	  PRIMARY KEY  (`cid`)
		) ENGINE=MyISAM");
	
	$db->write_query("CREATE TABLE `".TABLE_PREFIX."helpcenter_docs` (
	  `did` bigint(30) UNSIGNED NOT NULL auto_increment,
	  `name` varchar(300) NOT NULL default '',
	  `description` varchar(300) NOT NULL default '',
	  `content` TEXT NOT NULL,
	  `cid` bigint(30) UNSIGNED NOT NULL default '0',
	  PRIMARY KEY  (`did`)
		) ENGINE=MyISAM");
	
	$insert_query = array('name' => ''.$lang->helpcenter_priority_1_Name.'', 'description' => ''.$lang->helpcenter_priority_1_Description.'', 'level' => '1', 'format' => ''.$lang->helpcenter_priority_1_Format.'');
	$db->insert_query('helpcenter_priorities', $insert_query);

	$insert_query = array('name' => ''.$lang->helpcenter_priority_2_Name.'', 'description' => ''.$lang->helpcenter_priority_2_Description.'', 'level' => '2', 'format' => ''.$lang->helpcenter_priority_2_Format.'');
	$db->insert_query('helpcenter_priorities', $insert_query);
	
	$insert_query = array('name' => ''.$lang->helpcenter_priority_3_Name.'', 'description' => ''.$lang->helpcenter_priority_3_Description.'', 'level' => '3', 'format' => ''.$lang->helpcenter_priority_3_Format.'');
	$db->insert_query('helpcenter_priorities', $insert_query);
	
}

function helpcenter_is_installed()
{
	global $db, $lang;
	
	if ($db->table_exists('helpcenter_docs')) return true;
	
	return false;
}

function helpcenter_activate()
{
	global $db, $lang;

	// add templates
		$template = array(
		"tid" => "0",
		"title" => "helpcenter_do_action",
		"template" => $db->escape_string('
<form action="{$mybb->settings[\'bburl\']}/helpcenter.php?action={$action}" method="POST">
<input type="hidden" name="postcode" value="{$mybb->post_code}">
{$fields}
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead"><strong>{$lang->helpcenter} - {$action_title}</strong></td>
</tr>
<tr>
<td class="trow1" width="100%">{$lang->helpcenter_confirm_message}</td>
</tr>
<tr>
<td class="tfoot" width="100%" align="center" colspan="2"><input type="submit" name="submit" value="{$lang->helpcenter_submit}"></td>
</tr>
</table>
</form>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_regular_helpdocs_doc",
		"template" => $db->escape_string('


<tr>
<td class="{$bgcolor}" width="50%"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=viewdoc&amp;did={$doc[\'did\']}">{$doc[\'title\']}</a></td>
<td class="{$bgcolor}" width="50%">{$doc[\'description\']}</td>
</tr>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_regular",
		"template" => $db->escape_string('


<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter}</strong></td>
</tr>
<tr>
<td class="trow2" width="50%"><strong>{$lang->helpcenter_yourtickets_opened}:</strong></td>
<td class="trow2" width="50%"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=myopened">{$tickets[\'openedtickets\']}</a> {$lang->helpcenter_tickets}</td>
</tr>
<tr>
<td class="trow1" width="50%"><strong>{$lang->helpcenter_yourtickets_closed}:</strong></td>
<td class="trow1" width="50%"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=myclosed">{$tickets[\'closedtickets\']}</a> {$lang->helpcenter_tickets}</td>
</tr>
<tr>
<td class="tfoot" width="50%" align="center"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=submitticket">{$lang->helpcenter_submit_ticket}</a></td>
<td class="tfoot" width="50%" align="center"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=helpdocs">{$lang->helpcenter_help_docs}</a></td>
</tr>
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_helpdocs_cat",
		"template" => $db->escape_string('


<tr>
<td class="{$bgcolor}" width="50%"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=helpdocs&amp;cid={$cat[\'cid\']}">{$cat[\'name\']}</a><br /><span class="smalltext">{$cat[\'description\']}</span></td>
<td class="{$bgcolor}" width="50%" align="center">{$cat[\'docs\']}</td>
</tr>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_manager_helpdocs_doc",
		"template" => $db->escape_string('


<tr>
<td class="{$bgcolor}" width="30%"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=viewdoc&amp;did={$doc[\'did\']}">{$doc[\'title\']}</a></td>
<td class="{$bgcolor}" width="50%">{$doc[\'description\']}</td>
<td class="{$bgcolor}" width="20%" align="center">{$doc[\'action\']}</td>
</tr>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_helpdocs_regular",
		"template" => $db->escape_string('


<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$lang->helpcenter_help_docs}</strong></td>
</tr>
<tr>
<td class="tcat" width="50%"><strong>{$lang->helpcenter_doc_title}</strong></td>
<td class="tcat" width="50%"><strong>{$lang->helpcenter_doc_description}</strong></td>
</tr>
{$helpdocs}
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_helpdocs_cats",
		"template" => $db->escape_string('



<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$lang->helpcenter_help_cats}</strong></td>
</tr>
<tr>
<td class="tcat" width="50%"><strong>{$lang->helpcenter_cat_name}</strong></td>
<td class="tcat" width="50%" align="center"><strong>{$lang->helpcenter_cat_docs}</strong></td>
</tr>
{$helpcats}
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_manager_newdoc",
		"template" => $db->escape_string('
<script type="text/javascript" src="jscripts/post.js?ver=1400"></script>
<form action="{$mybb->settings[\'bburl\']}/helpcenter.php?action=do_createdoc" method="POST">
<input type="hidden" name="postcode" value="{$mybb->post_code}" />
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$lang->helpcenter_create_doc}</strong></td>
</tr>
<tr>
<td class="trow1" width="20%"><strong>{$lang->helpcenter_doc_title}:</strong></td><td class="trow1" width="80%"><input name="title" type="textbox" value="" class="textbox"></td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_doc_description}:</strong></td><td class="trow2" width="80%"><input name="description" type="textbox" value="" class="textbox"></td>
</tr>
<tr>
<td class="trow1" width="20%" valign="top"><strong>{$lang->helpcenter_doc_content}:</strong>{$smilieinserter}</td>
<td class="trow1" width="80%">
<textarea name="message" id="message" rows="20" cols="70" tabindex="2"></textarea>
{$codebuttons}
</td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_doc_category}:</strong></td><td class="trow2" width="80%">{$categories}</td>
</tr>
</table>
<br />
<div align="center"><input type="submit" name="submit" value="{$lang->helpcenter_submit}" /></div>
</form>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);
	
	$template = array(
		"tid" => "0",
		"title" => "helpcenter_manager_editdoc",
		"template" => $db->escape_string('
<script type="text/javascript" src="jscripts/post.js?ver=1400"></script>
<form action="{$mybb->settings[\'bburl\']}/helpcenter.php?action=do_editdoc" method="POST">
<input type="hidden" name="postcode" value="{$mybb->post_code}" />
<input type="hidden" name="did" value="{$doc[\'did\']}" />	
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$lang->helpcenter_edit_doc}</strong></td>
</tr>
<tr>
<td class="trow1" width="20%"><strong>{$lang->helpcenter_doc_title}:</strong></td><td class="trow1" width="80%"><input name="title" type="textbox" value="{$doc[\'title\']}" class="textbox"></td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_doc_description}:</strong></td><td class="trow2" width="80%"><input name="description" type="textbox" value="{$doc[\'description\']}" class="textbox"></td>
</tr>
<tr>
<td class="trow1" width="20%" valign="top"><strong>{$lang->helpcenter_doc_content}:</strong>{$smilieinserter}</td>
<td class="trow1" width="80%">
<textarea name="message" id="message" rows="20" cols="70" tabindex="2">{$doc[\'content\']}</textarea>
{$codebuttons}
</td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_doc_category}:</strong></td><td class="trow2" width="80%">{$categories}</td>
</tr>
</table>
<br />
<div align="center"><input type="submit" name="submit" value="{$lang->helpcenter_submit}" /></div>
</form>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_do_action",
		"template" => $db->escape_string('

<form action="{$mybb->settings[\'bburl\']}/helpcenter.php?action={$action}" method="POST">
<input type="hidden" name="postcode" value="{$mybb->post_code}">
{$fields}
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead"><strong>{$lang->helpcenter} - {$action_title}</strong></td>
</tr>
<tr>
<td class="trow1" width="100%">{$lang->helpcenter_confirm_message}</td>
</tr>
<tr>
<td class="tfoot" width="100%" align="center" colspan="2"><input type="submit" name="submit" value="{$lang->helpcenter_submit}"></td>
</tr>
</table>
</form>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_supportteam",
		"template" => $db->escape_string('



<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$lang->helpcenter_supportteam}</strong></td>
</tr>
<tr>
<td class="tcat" width="50%"><strong>{$lang->helpcenter_group_title}</strong></td>
</tr>
{$groups}
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_supportteam_group",
		"template" => $db->escape_string('
<tr>
<td class="{$bgcolor}" width="50%"><strong>{$usergroup[\'title\']}</strong><br />{$group_members}</td>
</tr>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_warning",
		"template" => $db->escape_string('</p><div style="background: #FBEEF1; text-align: left; margin-left: 5px; padding: 13px 20px 13px 45px; border-top: 2px solid #FE8FA2; border-bottom: 2px solid #FE8FA2; line-height: 150%; margin-top: 5px; margin-bottom: 5px;">{$warningmsg}</div><p>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter",
		"template" => $db->escape_string('
<html>
<head>
<title>{$lang->helpcenter}</title>
{$headerinclude}
</head>
<body>
{$header}
{$info}
<br />
<table width="100%" border="0" align="center">
<tr>
{$cpnav}
<td valign="top">
{$cptable}
</td>
</tr>
</table>
{$footer}
</body>
</html>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_manager",
		"template" => $db->escape_string('



<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter}</strong></td>
</tr>
<tr>
<td class="trow2" width="50%" align="center"><strong>{$lang->helpcenter_tickets_opened}:</strong></td>
<td class="trow2" width="50%" align="center"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=manage_opened">{$tickets[\'openedtickets\']} {$lang->helpcenter_tickets}</a></td>
</tr>
<tr>
<td class="trow1" width="50%" align="center"><strong>{$lang->helpcenter_tickets_closed}:</strong></td>
<td class="trow1" width="50%" align="center"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=manage_closed">{$tickets[\'closedtickets\']} {$lang->helpcenter_tickets}</a></td>
</tr>
<tr>
<td class="tfoot" width="50%" align="center"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=createdoc">{$lang->helpcenter_create_doc}</a></td>
<td class="tfoot" width="50%" align="center"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=helpdocs">{$lang->helpcenter_help_docs}</a></td>
</tr>
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_manager_nav",
		"template" => $db->escape_string('



<tr>
	<td class="tcat tcat_menu">
		<div class="expcolimage"><img src="{$theme[\'imgdir\']}/collapse{$collapsedimg[\'helpcentermanagement\']}.png" id="helpcentermanagement_img" class="expander" alt="[-]" title="[-]" /></div>
		<div><span class="smalltext"><strong>{$lang->helpcenter_management}</strong></span></div>
	</td>
</tr>
<tbody style="{$collapsed[\'helpcentermanagement_e\']}" id="helpcentermanagement_e">

    <tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=submitticket">{$lang->helpcenter_submit_ticket}</a></td></tr>
    <tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=myopened">{$lang->helpcenter_yourtickets_opened}</a></td></tr>
    <tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=myclosed">{$lang->helpcenter_yourtickets_closed}</a></td></tr>

	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=manage_opened">{$lang->helpcenter_tickets_opened}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=manage_closed">{$lang->helpcenter_tickets_closed}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=supportteam">{$lang->helpcenter_support_team}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=helpdocs">{$lang->helpcenter_help_docs}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=createdoc">{$lang->helpcenter_create_doc}</a></td></tr>
</tbody>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_nav",
		"template" => $db->escape_string('



<td width="180" valign="top">
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
	<tr>
		<td class="thead"><strong>{$lang->helpcenter_menu}</strong></td>
	</tr>
	<tr>
		<td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php">{$lang->helpcenter_home}</a></td>
	</tr>
{$navmenu}
{$navstats}
</table>
</td>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_helpdocs_manager",
		"template" => $db->escape_string('


<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="3"><strong>{$lang->helpcenter} - {$lang->helpcenter_help_docs}</strong></td>
</tr>
<tr>
<td class="tcat" width="30%"><strong>{$lang->helpcenter_doc_title}</strong></td>
<td class="tcat" width="50%"><strong>{$lang->helpcenter_doc_description}</strong></td>
<td class="tcat" width="20%" align="center"><strong>{$lang->helpcenter_doc_action}</strong></td>
</tr>
{$helpdocs}
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_not_found",
		"template" => $db->escape_string('



<tr>
<td class="{$bgcolor}" width="100%" colspan="{$colspan}">{$notfound}</td>
</tr>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_regular_nav",
		"template" => $db->escape_string('


<tr>
	<td class="tcat tcat_menu">
		<div class="expcolimage"><img src="{$theme[\'imgdir\']}/collapse{$collapsedimg[\'helpcenterregular\']}.png" id="helpcenterregular_img" class="expander" alt="[-]" title="[-]" /></div>
		<div><span class="smalltext"><strong>{$lang->helpcenter_support}</strong></span></div>
	</td>
</tr>
<tbody style="{$collapsed[\'helpcenterregular_e\']}" id="helpcenterregular_e">
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=submitticket">{$lang->helpcenter_submit_ticket}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=myopened">{$lang->helpcenter_yourtickets_opened}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=myclosed">{$lang->helpcenter_yourtickets_closed}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=helpdocs">{$lang->helpcenter_help_docs}</a></td></tr>
	<tr><td class="trow1 smalltext"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=supportteam">{$lang->helpcenter_support_team}</a></td></tr>
</tbody>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_manager_tickets_ticket",
		"template" => $db->escape_string('

<tr>
<td class="{$bgcolor}" width="20%">{$ticket[\'username\']}</td>
<td class="{$bgcolor}" width="25%">{$ticket[\'title\']}</td>
<td class="{$bgcolor}" width="10%" align="center">{$ticket[\'replies\']}</td>
<td class="{$bgcolor}" width="15%" align="center">{$ticket[\'priority\']}</td>
<td class="{$bgcolor}" width="15%" align="center">{$ticket[\'date\']}</td>
<td class="{$bgcolor}" width="15%" align="center">{$ticket[\'action\']}</td>
</tr>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_regular_submitticket",
		"template" => $db->escape_string('


<form action="{$mybb->settings[\'bburl\']}/helpcenter.php?action=do_submitticket" method="POST">
<input type="hidden" name="postcode" value="{$mybb->post_code}" />
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$lang->helpcenter_submit_ticket}</strong></td>
</tr>
<tr>
<td class="trow1" width="20%"><strong>{$lang->helpcenter_ticket_title}:</strong></td><td class="trow1" width="80%"><input name="title" type="textbox" value="" class="textbox"></td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_ticket_category}:</strong><br /><span class="smalltext">{$lang->helpcenter_ticket_category_desc}</span></td><td class="trow2" width="80%">{$categories}</td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_ticket_priority}:</strong></td><td class="trow2" width="80%">{$priorities}</td>
</tr>
<tr>
<td class="trow1" width="20%" valign="top"><strong>{$lang->helpcenter_tickets_message}:</strong></td>
<td class="trow1" width="80%">
<textarea name="message" id="message" rows="20" cols="70" tabindex="2"></textarea>
</td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_ticket_note}:</strong></td><td class="trow2" width="80%">{$lang->helpcenter_ticket_notes}</td>
</tr>
{$enteremail}
</table>
<br />
<div align="center"><input type="submit" name="submit" value="{$lang->helpcenter_submit}" /></div>
</form>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_manager_tickets",
		"template" => $db->escape_string('
{$multipage}
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="7"><strong>{$lang->helpcenter} - {$lang->helpcenter_tickets}</strong></td>
</tr>
<tr>
<td class="tcat" width="20%"><strong>{$lang->helpcenter_username}</strong></td>
<td class="tcat" width="25%"><strong>{$lang->helpcenter_title}</strong></td>
<td class="tcat" width="10%" align="center"><strong>{$lang->helpcenter_replies}</strong></td>
<td class="tcat" width="15%" align="center"><strong>{$lang->helpcenter_priority}</strong></td>
<td class="tcat" width="15%" align="center"><strong>{$lang->helpcenter_date}</strong></td>
<td class="tcat" width="15%" align="center"><strong>{$lang->helpcenter_action}</strong></td>
</tr>
{$tickets}
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_regular_tickets",
		"template" => $db->escape_string('
{$multipage}
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="5"><strong>{$lang->helpcenter} - {$lang->helpcenter_tickets}</strong></td>
</tr>
<tr>
<td class="tcat" width="55%"><strong>{$lang->helpcenter_title}</strong></td>
<td class="tcat" width="10%" align="center"><strong>{$lang->helpcenter_replies}</strong></td>
<td class="tcat" width="15%" align="center"><strong>{$lang->helpcenter_priority}</strong></td>
<td class="tcat" width="20%" align="center"><strong>{$lang->helpcenter_date}</strong></td>
</tr>
{$tickets}
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_regular_tickets_ticket",
		"template" => $db->escape_string('
<tr>
<td class="{$bgcolor}" width="55%">{$ticket[\'title\']}</td>
<td class="{$bgcolor}" width="10%" align="center">{$ticket[\'replies\']}</td>
<td class="{$bgcolor}" width="15%" align="center">{$ticket[\'priority\']}</td>
<td class="{$bgcolor}" width="20%" align="center">{$ticket[\'date\']}</td>
</tr>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_helpdocs_viewdoc",
		"template" => $db->escape_string('
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$doc[\'title\']}</strong></td>
</tr>
<tr>
<td class="trow1" width="20%"><strong>{$lang->helpcenter_description}</strong></td>
<td class="trow1" width="80%">{$doc[\'description\']}</td>
</tr>
<tr>
<td class="trow2" width="20%" valign="top"><strong>{$lang->helpcenter_document}</strong></td>
<td class="trow2" width="80%">{$doc[\'content\']}</td>
</tr>
<tr>
<td class="tfoot" colspan="2" align="center"><a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=deletedoc&amp;did={$doc[\'did\']}">{$lang->helpcenter_delete}</a> - <a href="{$mybb->settings[\'bburl\']}/helpcenter.php?action=editdoc&amp;did={$doc[\'did\']}">{$lang->helpcenter_edit}</a>
</td>
</tr>
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_viewticket",
		"template" => $db->escape_string('
<table width="100%" border="0">
<tr>
<td width="70%" valign="top">
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter} - {$lang->helpcenter_viewticket} - {$ticket[\'title\']}</strong></td>
</tr>
<tr>
<td class="trow2" width="20%"><strong>{$lang->helpcenter_ticket_title}:</strong></td>
<td class="trow2" width="80%">{$ticket[\'title\']}</td>
</tr>
<tr>
<td class="trow1" width="20%" valign="top"><strong>{$lang->helpcenter_ticket_message}:</strong></td>
<td class="trow1" width="80%">{$ticket[\'message\']}</td>
</tr>
</table>
<br />
<form method="post" action="{$mybb->settings[\'bburl\']}/helpcenter.php?action=do_reply" name="reply_form" id="reply_form">
<input type="hidden" name="postcode" value="{$mybb->post_code}">
	<input type="hidden" name="my_post_key" value="{$mybb->post_code}" />	
	<input type="hidden" name="tid" value="{$ticket[\'tid\']}" />	
	<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="width: 100%;">
		<thead>
			<tr>
				<td class="thead thead_collapsed" colspan="2">
					<div class="expcolimage"><img src="{$mybb->settings[\'bburl\']}/images/collapse_collapsed.png" id="reply_img" class="expander" alt="[+]" title="[+]" /></div>
					<div><strong>{$lang->helpcenter_reply_ticket}</strong></div>
				</td>
			</tr>
		</thead>
		<tbody id="reply_e" style="display: none;">
			<tr>
				<td class="tcat" valign="top">
					<strong>{$lang->helpcenter_message}</strong>
				</td>
			</tr>
			<tr>
				<td class="trow1">
					<div style="width: 95%">
						<textarea rows="8" cols="120" tabindex="1" name="reply" style="width: 100%; padding: 4px; margin: 0pt;"></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="tfoot"><input type="submit" class="button" value="{$lang->helpcenter_submit}" tabindex="2" accesskey="s" id="reply_submit" /></td>
			</tr>
		</tbody>
	</table>
</form>
<br />
{$replies}
</td>
<td width="30%" valign="top">
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
<tr>
<td class="thead" colspan="2"><strong>{$lang->helpcenter_info}</strong></td>
</tr>
<tr>
<td class="trow1" width="50%"><strong>{$lang->helpcenter_author}:</strong></td>
<td class="trow1" width="50%">{$ticket[\'author\']}</td>
</tr>
<tr>
<td class="trow2" width="50%"><strong>{$lang->helpcenter_datesubmitted}:</strong></td>
<td class="trow2" width="50%">{$ticket[\'date\']}</td>
</tr>
<tr>
<td class="trow1" width="50%"><strong>{$lang->helpcenter_status}:</strong></td>
<td class="trow1" width="50%">{$ticket[\'status\']}</td>
</tr>
<tr>
<td class="trow2" width="50%"><strong>{$lang->helpcenter_replies}:</strong></td>
<td class="trow2" width="50%">{$ticket[\'replies\']}</td>
</tr>
<tr>
<td class="trow1" width="50%"><strong>{$lang->helpcenter_priority}:</strong></td>
<td class="trow1" width="50%">{$ticket[\'priority\']}</td>
</tr>
</table>
</td>
</tr>
</table>'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);

	$template = array(
		"tid" => "0",
		"title" => "helpcenter_reply",
		"template" => $db->escape_string('
<div align="center">
<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="width: 90%;">
	<thead>
		<tr>
			<td class="thead" colspan="2">
				<div><strong>{$lang->helpcenter_message_number}{$reply[\'number\']}</strong></div>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="trow1" class="post_author">
				<div style="float: right;">{$delete_reply}</div> <strong><span class="largetext">{$reply[\'author\']}</span></strong><br /><span class="smalltext">{$reply[\'date\']}</span>
			</td>
		</tr>
		<tr>
			<td class="trow2">
				<div class="post_body">
				{$reply[\'message\']}	
				</div>
			</td>
		</tr>
	</tbody>
</table>
</div>
<br />'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);
}


function helpcenter_deactivate()
{
	global $db, $mybb;
	
	/*$query = $db->query('SELECT * FROM mybb_templates');
	while ($template = $db->fetch_array($query))
	{
		if (substr($template['title'], 0, 10) != 'helpcenter')
			continue;
		echo '<pre>'.htmlspecialchars('
	$template = array(
		"tid" => "0",
		"title" => "'.$template['title'].'",
		"template" => $db->escape_string(\'
'.str_replace('\'', '\\\'', stripslashes($template['template'])).'\'),
		"sid" => "-1",
	);
	$db->insert_query("templates", $template);').'</pre>';
	}
	exit;*/
	
	/*$query = $db->query('SELECT * FROM mybb_templates');
	while ($template = $db->fetch_array($query))
	{
		if (substr($template['title'], 0, 10) != 'helpcenter')
			continue;
		$temps .= '\\\''.$template['title'].'\\\',';
	}
	
	echo '<pre>$db->delete_query(\'templates\', \'title IN ('.$temps.')\');</pre>';
	exit;*/
	
	// delete templates
	$db->delete_query('templates', 'title IN (\'helpcenter_do_action\',\'helpcenter_regular_helpdocs_doc\',\'helpcenter_regular\',\'helpcenter_helpdocs_cat\',\'helpcenter_manager_helpdocs_doc\',\'helpcenter_helpdocs_regular\',\'helpcenter_helpdocs_cats\',\'helpcenter_manager_newdoc\',\'helpcenter_manager_editdoc\',\'helpcenter_do_action\',\'helpcenter_supportteam\',\'helpcenter_supportteam_group\',\'helpcenter_warning\',\'helpcenter\',\'helpcenter_manager\',\'helpcenter_manager_nav\',\'helpcenter_nav\',\'helpcenter_helpdocs_manager\',\'helpcenter_not_found\',\'helpcenter_regular_nav\',\'helpcenter_manager_tickets_ticket\',\'helpcenter_regular_submitticket\',\'helpcenter_manager_tickets\',\'helpcenter_regular_tickets\',\'helpcenter_regular_tickets_ticket\',\'helpcenter_helpdocs_viewdoc\',\'helpcenter_regular_tickets\',\'helpcenter_regular_tickets_ticket\',\'helpcenter_viewticket\',\'helpcenter_reply\')');
}
	
function helpcenter_uninstall()
{
	global $db, $mybb;
	
	// delete settings group
	$db->delete_query("settinggroups", "name = 'helpcenter'");

	// remove settings
	$db->delete_query('settings', 'name IN (\'helpcenter_enabled\',\'helpcenter_modgroups\',\'helpcenter_newtickets_enabled\',\'helpcenter_docs_enabled\',\'helpcenter_tickets_emailmode\',\'helpcenter_tickets_email\')');

	rebuild_settings();

	if ($db->table_exists('helpcenter_tickets'))
		$db->drop_table('helpcenter_tickets');
	
	if ($db->table_exists('helpcenter_messages'))
		$db->drop_table('helpcenter_messages');
		
	if ($db->table_exists('helpcenter_categories'))
		$db->drop_table('helpcenter_categories');
		
	if ($db->table_exists('helpcenter_priorities'))
		$db->drop_table('helpcenter_priorities');
		
	if ($db->table_exists('helpcenter_docs_cat'))
		$db->drop_table('helpcenter_docs_cat');
		
	if ($db->table_exists('helpcenter_docs'))
		$db->drop_table('helpcenter_docs');
}

function helpcenter_online(&$plugin_array)
{
	if (preg_match('/helpcenter\.php/',$plugin_array['user_activity']['location']))
	{
		global $lang, $mybb;
		$lang->load("helpcenter");
		
		$plugin_array['location_name'] = "Viewing <a href=\"".$mybb->settings['bburl']."/helpcenter.php\">".$lang->helpcenter."</a>";
	}

	return $plugin_array;
}

function helpcenter_check_permissions($groups_comma)
{
	global $mybb;
	
	if ($groups_comma == '')
		return false;
	
	$groups = explode(",", $groups_comma);
	$add_groups = explode(",", $mybb->user['additionalgroups']);
	
	if (!in_array($mybb->user['usergroup'], $groups)) { // primary user group not allowed
		// check additional groups
		if ($add_groups) {
			if (count(array_intersect($add_groups, $groups)) == 0)
				return false;
			else
				return true;
		}
		else 
			return false;
	}
	else
		return true;
}

function helpcenter_get_group($gid)
{
	global $db;
	
	$query = $db->simple_select('usergroups', '*', 'gid='.intval($gid));
	$group = $db->fetch_array($query);
	
	return $group;
}

function helpcenter_get_priority($pid)
{
	global $db;
	$query = $db->simple_select('helpcenter_priorities', '*', 'pid='.intval($pid));
	$priority = $db->fetch_array($query);
	return $priority;
}

function helpcenter_format_priority($pid, $name='', $format='')
{
	global $db;
	
	if ($name == '' || $format == '')
	{
		$priority = helpcenter_get_priority($pid);
	}
	else {
		$priority['name'] = $name;
		$priority['format'] = $format;
	}
	
	$priority = str_replace('{priority}', htmlspecialchars_uni($priority['name']), $priority['format']); 
	
	return $priority;
}

function helpcenter_get_username($uid)
{
	global $db;
	$query = $db->simple_select('users', 'username', 'uid=\''.intval($uid).'\'', 1);
	return $db->fetch_field($query, 'username');
}

/**
 * Sends a PM to a user, with Admin Override
 * 
 * @param array: The PM to be sent; should have 'subject', 'message', 'touid'
 * @param int: from user id (0 if you want to use the uid the person that sends it. -1 to use MyBB Engine
 * @return bool: true if PM sent
 */
function helpcenter_send_pm($pm, $fromid = 0)
{
	global $lang, $mybb, $db;
	if($mybb->settings['enablepms'] == 0) return false;
	if (!is_array($pm))	return false;
	if (!$pm['subject'] ||!$pm['message'] || !$pm['touid'] || !$pm['receivepms']) return false;
	
	$lang->load('messages'); // required for email notification
	
	require_once MYBB_ROOT."inc/datahandlers/pm.php";
	
	$pmhandler = new PMDataHandler();
	
	$subject = $pm['subject'];
	$message = $pm['message'];
	$toid = $pm['touid'];
	
	require_once MYBB_ROOT."inc/datahandlers/pm.php";

	$pmhandler = new PMDataHandler();
	
	if (is_array($toid))
		$recipients_to = $toid;
	else
		$recipients_to = array($toid);
	$recipients_bcc = array();
	
	if (intval($fromid) == 0)
		$fromid = intval($mybb->user['uid']);
	elseif (intval($fromid) < 0)
		$fromid = 0;

	$pm = array(
		"subject" => $subject,
		"message" => $message,
		"icon" => -1,
		"fromid" => 0,
		"toid" => $recipients_to,
		"bccid" => $recipients_bcc,
		"do" => '',
		"pmid" => ''
	);

	$pm['options'] = array(
		"signature" => 0,
		"disablesmilies" => 0,
		"savecopy" => 0,
		"readreceipt" => 0
	);
	$pm['saveasdraft'] = 0;
	$pmhandler->admin_override = 1;
	$pmhandler->set_data($pm);
	if($pmhandler->validate_pm())
	{
		$pmhandler->insert_pm();
	}
	else
	{
		return false;
	}
	
	return true;
}

/*************************************************************************************/
// ADMIN PART
/*************************************************************************************/

function helpcenter_admin_tools_menu(&$sub_menu)
{
	global $lang;
	
	$lang->load('helpcenter');
	$sub_menu[] = array('id' => 'helpcenter', 'title' => $lang->helpcenter_index, 'link' => 'index.php?module=tools-helpcenter');
}

function helpcenter_admin_tools_action_handler(&$actions)
{
	$actions['helpcenter'] = array('active' => 'helpcenter', 'file' => 'helpcenter');
}

function helpcenter_admin_permissions(&$admin_permissions)
{
  	global $db, $mybb, $lang;
  
	$lang->load("helpcenter", false, true);
	$admin_permissions['helpcenter'] = $lang->helpcenter_canmanage;
	
}

function helpcenter_messageredirect($message, $error=0, $action='')
{
  	global $db, $mybb, $lang;
	
	if (!$message)
		return;
		
	if ($action)
		$parameters = '&amp;action='.$action;
  
	if ($error)
	{
		flash_message($message, 'error');
		admin_redirect("index.php?module=tools-helpcenter".$parameters);
	}
	else {
		flash_message($message, 'success');
		admin_redirect("index.php?module=tools-helpcenter".$parameters);
	}
}

function helpcenter_admin()
{
	global $db, $lang, $mybb, $page, $run_module, $action_file, $mybbadmin, $plugins;
	
	$lang->load("helpcenter", false, true);
	
	if($run_module == 'tools' && $action_file == 'helpcenter')
	{
		if ($mybb->request_method == "post")
		{
			switch ($mybb->input['action'])
			{
				case 'do_addpriority':
					if ($mybb->input['name'] == '' || $mybb->input['description'] == '' || $mybb->input['level'] == '' || $mybb->input['format'] == '')
					{
						helpcenter_messageredirect($lang->helpcenter_missing_field, 1);
					}
					
					$name = $db->escape_string($mybb->input['name']);
					$description = $db->escape_string($mybb->input['description']);
					$level = intval($mybb->input['level']);
					$format = $db->escape_string($mybb->input['format']);
					
					$insert_query = array('name' => $name, 'description' => $description, 'level' => $level, 'format' => $format);
					$db->insert_query('helpcenter_priorities', $insert_query);
					
					helpcenter_messageredirect($lang->helpcenter_priority_added);
				break;
				case 'do_editpriority':
					$pid = intval($mybb->input['pid']);
					if ($pid <= 0 || (!($priority = $db->fetch_array($db->simple_select('helpcenter_priorities', '*', "pid = $pid")))))
					{
						helpcenter_messageredirect($lang->helpcenter_invalid_priority, 1);
					}
				
					if ($mybb->input['name'] == '' || $mybb->input['description'] == '' || $mybb->input['level'] == '' || $mybb->input['format'] == '')
					{
						helpcenter_messageredirect($lang->helpcenter_missing_field, 1);
					}
					
					$name = $db->escape_string($mybb->input['name']);
					$description = $db->escape_string($mybb->input['description']);
					$level = intval($mybb->input['level']);
					$format = $db->escape_string($mybb->input['format']);
					
					$update_query = array('name' => $name, 'description' => $description, 'level' => $level, 'format' => $format);
					$db->update_query('helpcenter_priorities', $update_query, 'pid=\''.$pid.'\'');
					
					helpcenter_messageredirect($lang->helpcenter_priority_edited);
				break;
				
				case 'do_addcategory':
					if ($mybb->input['name'] == '' || $mybb->input['description'] == '')
					{
						helpcenter_messageredirect($lang->helpcenter_missing_field, 1, 'helpcategories');
					}
					
					$name = $db->escape_string($mybb->input['name']);
					$description = $db->escape_string($mybb->input['description']);
					
					$insert_query = array('name' => $name, 'description' => $description);
					$db->insert_query('helpcenter_docs_cat', $insert_query);
					
					helpcenter_messageredirect($lang->helpcenter_category_added, 0, 'helpcategories');
				break;
				case 'do_editcategory':
					$cid = intval($mybb->input['cid']);
					if ($cid <= 0 || (!($category = $db->fetch_array($db->simple_select('helpcenter_docs_cat', '*', "cid = $cid")))))
					{
						helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'helpcategories');
					}
				
					if ($mybb->input['name'] == '' || $mybb->input['description'] == '')
					{
						helpcenter_messageredirect($lang->helpcenter_missing_field, 1, 'helpcategories');
					}
					
					$name = $db->escape_string($mybb->input['name']);
					$description = $db->escape_string($mybb->input['description']);
					
					$update_query = array('name' => $name, 'description' => $description);
					$db->update_query('helpcenter_docs_cat', $update_query, 'cid=\''.$cid.'\'');
					
					helpcenter_messageredirect($lang->helpcenter_category_edited, 0, 'helpcategories');
				break;
				
				case 'do_addticketcategory':
					if ($mybb->input['name'] == '' || $mybb->input['description'] == '')
					{
						helpcenter_messageredirect($lang->helpcenter_missing_field, 1, 'ticketcategories');
					}
					
					$name = $db->escape_string($mybb->input['name']);
					$description = $db->escape_string($mybb->input['description']);
					
					$insert_query = array('name' => $name, 'description' => $description);
					$db->insert_query('helpcenter_categories', $insert_query);
					
					helpcenter_messageredirect($lang->helpcenter_ticketcategory_added, 0, 'ticketcategories');
				break;
				case 'do_editticketcategory':
					$cid = intval($mybb->input['cid']);
					if ($cid <= 0 || (!($category = $db->fetch_array($db->simple_select('helpcenter_categories', '*', "cid = $cid")))))
					{
						helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'ticketcategories');
					}
				
					if ($mybb->input['name'] == '' || $mybb->input['description'] == '')
					{
						helpcenter_messageredirect($lang->helpcenter_missing_field, 1, 'ticketcategories');
					}
					
					$name = $db->escape_string($mybb->input['name']);
					$description = $db->escape_string($mybb->input['description']);
					
					$update_query = array('name' => $name, 'description' => $description);
					$db->update_query('helpcenter_categories', $update_query, 'cid=\''.$cid.'\'');
					
					helpcenter_messageredirect($lang->helpcenter_ticketcategory_edited, 0, 'ticketcategories');
				break;
			}
		}
		
		if ($mybb->input['action'] == 'do_deletepriority')
		{
			$page->add_breadcrumb_item($lang->helpcenter, 'index.php?module=tools-helpcenter');
			$page->output_header($lang->helpcenter);
			
			$pid = intval($mybb->input['pid']);
			if (!$pid)
				helpcenter_messageredirect($lang->helpcenter_invalid_priority, 1);
		
			if($mybb->input['no']) // user clicked no
			{
				admin_redirect("index.php?module=tools-helpcenter");
			}
		
			if($mybb->request_method == "post")
			{
				if ($pid <= 0 || (!($priority = $db->fetch_array($db->simple_select('helpcenter_priorities', 'pid', "pid = $pid")))))
				{
					helpcenter_messageredirect($lang->helpcenter_invalid_priority, 1);
				}
				
				$db->delete_query('helpcenter_priorities', "pid = $pid");
				
				helpcenter_messageredirect($lang->helpcenter_priority_deleted);
			}
			else
			{
				$mybb->input['pid'] = intval($mybb->input['pid']);
				$form = new Form("index.php?module=tools-helpcenter&amp;action=do_deletepriority&amp;pid={$mybb->input['pid']}&amp;my_post_key={$mybb->post_code}", 'post');
				echo "<div class=\"confirm_action\">\n";
				echo "<p>{$lang->helpcenter_confirm_deletepriority}</p>\n";
				echo "<br />\n";
				echo "<p class=\"buttons\">\n";
				echo $form->generate_submit_button($lang->yes, array('class' => 'button_yes'));
				echo $form->generate_submit_button($lang->no, array("name" => "no", 'class' => 'button_no'));
				echo "</p>\n";
				echo "</div>\n";
				$form->end();
			}
		}
		elseif ($mybb->input['action'] == 'do_deletecategory')
		{
			$page->add_breadcrumb_item($lang->helpcenter, 'index.php?module=tools-helpcenter');
			$page->output_header($lang->helpcenter);
			
			$cid = intval($mybb->input['cid']);
			if (!$cid)
				helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'helpcategories');
		
			if($mybb->input['no']) // user clicked no
			{
				admin_redirect("index.php?module=tools-helpcenter&amp;action=helpcategories");
			}
		
			if($mybb->request_method == "post")
			{
				if ($cid <= 0 || (!($cat = $db->fetch_array($db->simple_select('helpcenter_docs_cat', 'cid', "cid = $cid")))))
				{
					helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'helpcategories');
				}
				
				// delete documents assigned to this category
				$db->delete_query('helpcenter_docs', "cid = $cid");
				
				// delete category
				$db->delete_query('helpcenter_docs_cat', "cid = $cid");
				
				helpcenter_messageredirect($lang->helpcenter_category_deleted, 0, 'helpcategories');
			}
			else
			{
				$mybb->input['cid'] = intval($mybb->input['cid']);
				$form = new Form("index.php?module=tools-helpcenter&amp;action=do_deletecategory&amp;cid={$mybb->input['cid']}&amp;my_post_key={$mybb->post_code}", 'post');
				echo "<div class=\"confirm_action\">\n";
				echo "<p>{$lang->helpcenter_confirm_deletecategory}</p>\n";
				echo "<br />\n";
				echo "<p class=\"buttons\">\n";
			    echo $form->generate_submit_button($lang->yes, array('class' => 'button_yes'));
				echo $form->generate_submit_button($lang->no, array("name" => "no", 'class' => 'button_no'));
				echo "</p>\n";
				echo "</div>\n";
				$form->end();
			}
		}
		elseif ($mybb->input['action'] == 'do_deleteticketcategory')
		{
			$page->add_breadcrumb_item($lang->helpcenter, 'index.php?module=tools-helpcenter');
			$page->output_header($lang->helpcenter);
			
			$cid = intval($mybb->input['cid']);
			if (!$cid)
				helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'ticketcategories');
		
			if($mybb->input['no']) // user clicked no
			{
				admin_redirect("index.php?module=tools-helpcenter&amp;action=ticketcategories");
			}
		
			if($mybb->request_method == "post")
			{
				if ($cid <= 0 || (!($cat = $db->fetch_array($db->simple_select('helpcenter_categories', 'cid', "cid = $cid")))))
				{
					helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'ticketcategories');
				}
				
				// delete tickets within this category
				$db->delete_query('helpcenter_tickets', "cid = $cid");
				
				// delete category
				$db->delete_query('helpcenter_categories', "cid = $cid");
				
				helpcenter_messageredirect($lang->helpcenter_category_deleted, 0, 'ticketcategories');
			}
			else
			{
				$mybb->input['cid'] = intval($mybb->input['cid']);
				$form = new Form("index.php?module=tools-helpcenter&amp;action=do_deleteticketcategory&amp;cid={$mybb->input['cid']}&amp;my_post_key={$mybb->post_code}", 'post');
				echo "<div class=\"confirm_action\">\n";
				echo "<p>{$lang->helpcenter_confirm_deleteticketcategory}</p>\n";
				echo "<br />\n";
				echo "<p class=\"buttons\">\n";
				echo $form->generate_submit_button($lang->yes, array('class' => 'button_yes'));
				echo $form->generate_submit_button($lang->no, array("name" => "no", 'class' => 'button_no'));
				echo "</p>\n";
				echo "</div>\n";
				$form->end();
			}
		}
		
		if (!$mybb->input['action'] || $mybb->input['action'] == 'priorities' || $mybb->input['action'] == 'helpcategories' || $mybb->input['action'] == 'ticketcategories' || $mybb->input['action'] == 'addpriority' || $mybb->input['action'] == 'editpriority' || $mybb->input['action'] == 'addcategory' || $mybb->input['action'] == 'editcategory' || $mybb->input['action'] == 'addticketcategory' || $mybb->input['action'] == 'editticketcategory')
		{
			$page->add_breadcrumb_item($lang->helpcenter, 'index.php?module=tools-helpcenter');
						
			$page->output_header($lang->helpcenter);
				
			$sub_tabs['helpcenter_priorities'] = array(
				'title'			=> $lang->helpcenter_priorities,
				'link'			=> 'index.php?module=tools-helpcenter',
				'description'	=> $lang->helpcenter_priorities_desc
			);
			
			if (!$mybb->input['action'] || $mybb->input['action'] == 'priorities' || $mybb->input['action'] == 'addpriority' || $mybb->input['action'] == 'editpriority')
			{
				$sub_tabs['helpcenter_priorities_add'] = array(
					'title'			=> $lang->helpcenter_priorities_add,
					'link'			=> 'index.php?module=tools-helpcenter&amp;action=addpriority',
					'description'	=> $lang->helpcenter_priorities_add_desc
				);
				//$sub_tabs['helpcenter_priorities_edit'] = array(
				//	'title'			=> $lang->helpcenter_priorities_edit,
				//	'link'			=> 'index.php?module=tools-helpcenter&amp;action=editpriority',
				//	'description'	=> $lang->helpcenter_priorities_edit_desc
				//);
				//$sub_tabs['helpcenter_priorities_delete'] = array(
				//	'title'			=> $lang->helpcenter_priorities_delete,
				//	'link'			=> 'index.php?module=tools-helpcenter&amp;action=do_deletepriority',
				//	'description'	=> $lang->helpcenter_priorities_delete_desc
				//);
			}
			
			$sub_tabs['helpcenter_helpcategories'] = array(
				'title'			=> $lang->helpcenter_helpcategories,
				'link'			=> 'index.php?module=tools-helpcenter&amp;action=helpcategories',
				'description'	=> $lang->helpcenter_helpcategories_desc
			);

			if ($mybb->input['action'] == 'helpcategories' || $mybb->input['action'] == 'addcategory' || $mybb->input['action'] == 'editcategory')
			{
				$sub_tabs['helpcenter_helpcategories_add'] = array(
					'title'			=> $lang->helpcenter_helpcategories_add,
					'link'			=> 'index.php?module=tools-helpcenter&amp;action=addcategory',
					'description'	=> $lang->helpcenter_helpcategories_add_desc
				);
				//$sub_tabs['helpcenter_helpcategories_edit'] = array(
				//	'title'			=> $lang->helpcenter_helpcategories_edit,
				//	'link'			=> 'index.php?module=tools-helpcenter&amp;action=editcategory',
				//	'description'	=> $lang->helpcenter_helpcategories_edit_desc
				//);
				//$sub_tabs['helpcenter_helpcategories_delete'] = array(
				//	'title'			=> $lang->helpcenter_helpcategories_delete,
				//	'link'			=> 'index.php?module=tools-helpcenter&amp;action=do_deletecategory',
				//	'description'	=> $lang->helpcenter_helpcategories_delete_desc
				//);
			}
			
			$sub_tabs['helpcenter_ticketcategories'] = array(
				'title'			=> $lang->helpcenter_ticketcategories,
				'link'			=> 'index.php?module=tools-helpcenter&amp;action=ticketcategories',
				'description'	=> $lang->helpcenter_ticketcategories_desc
			);

			if ($mybb->input['action'] == 'ticketcategories' || $mybb->input['action'] == 'addticketcategory' || $mybb->input['action'] == 'editticketcategory')
			{
				$sub_tabs['helpcenter_ticketcategories_add'] = array(
					'title'			=> $lang->helpcenter_ticketcategories_add,
					'link'			=> 'index.php?module=tools-helpcenter&amp;action=addticketcategory',
					'description'	=> $lang->helpcenter_ticketcategories_add_desc
				);
				//$sub_tabs['helpcenter_helpcategories_edit'] = array(
				//	'title'			=> $lang->helpcenter_ticketcategories_edit,
				//	'link'			=> 'index.php?module=tools-helpcenter&amp;action=editticketcategory',
				//	'description'	=> $lang->helpcenter_ticketcategories_edit_desc
				//);
				//$sub_tabs['helpcenter_helpcategories_delete'] = array(
				//	'title'			=> $lang->helpcenter_ticketcategories_delete,
				//	'link'			=> 'index.php?module=tools-helpcenter&amp;action=do_deleteticketcategory',
				//	'description'	=> $lang->helpcenter_ticketcategories_delete_desc
				//);
			}
		}
		
		if (!$mybb->input['action'] || $mybb->input['action'] == 'priorities')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_priorities');
			
			// table
			$table = new Table;
			$table->construct_header($lang->helpcenter_name, array('width' => '20%'));
			$table->construct_header($lang->helpcenter_description, array('width' => '30%'));
			$table->construct_header($lang->helpcenter_level, array('width' => '10%', 'class' => 'align_center'));
			$table->construct_header($lang->helpcenter_format, array('width' => '20%'));
			$table->construct_header($lang->helpcenter_action, array('width' => '20%', 'class' => 'align_center'));
			
			$query = $db->simple_select('helpcenter_priorities', '*');
			
			while ($prio = $db->fetch_array($query))
			{
				$priority = $prio;
					
				$table->construct_cell(helpcenter_format_priority($priority['pid'], $priority['name'], $priority['format']));
				$table->construct_cell(htmlspecialchars_uni($priority['description']));
				$table->construct_cell(intval($priority['level']), array('class' => 'align_center'));
				$table->construct_cell(htmlspecialchars_uni($priority['format']));
				
				// actions column
				$table->construct_cell("<a href=\"index.php?module=tools-helpcenter&amp;action=editpriority&amp;pid=".intval($priority['pid'])."\">".$lang->helpcenter_edit."</a> - <a href=\"index.php?module=tools-helpcenter&amp;action=do_deletepriority&amp;pid=".intval($priority['pid'])."\">".$lang->helpcenter_delete."</a>", array('class' => 'align_center'));
				
				$table->construct_row();
			}
			
			if (!$priority)
			{
				$table->construct_cell($lang->helpcenter_nopriorities, array('colspan' => 6));
				
				$table->construct_row();
			}
			
			$table->output($lang->helpcenter_priorities);
		}
		elseif ($mybb->input['action'] == 'addpriority')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_priorities_add');
			
			$form = new Form("index.php?module=tools-helpcenter&amp;action=do_addpriority", "post", "helpcenter");
	
			$form_container = new FormContainer($lang->helpcenter_addpriority);
			$form_container->output_row($lang->helpcenter_addpriority_name, $lang->helpcenter_addpriority_name_desc, $form->generate_text_box('name', '', array('id' => 'name')), 'name');
			$form_container->output_row($lang->helpcenter_addpriority_description, $lang->helpcenter_addpriority_description_desc, $form->generate_text_box('description', '', array('id' => 'description')), 'description');
			$form_container->output_row($lang->helpcenter_addpriority_level, $lang->helpcenter_addpriority_level_desc, $form->generate_text_box('level', '0', array('id' => 'level')), 'level');
			$form_container->output_row($lang->helpcenter_addpriority_format, htmlspecialchars_uni($lang->helpcenter_addpriority_format_desc), $form->generate_text_box('format', '{priority}', array('id' => 'format')), 'format');
			
			$form_container->end();
			
			//$buttons = "";
			$submit_options = array('name' => 'save');
			$buttons = array();

			$buttons[] = $form->generate_submit_button($lang->helpcenter_submit);
			$buttons[] = $form->generate_reset_button($lang->helpcenter_reset);
			$form->output_submit_wrapper($buttons);
			$form->end();
		}
		elseif ($mybb->input['action'] == 'editpriority')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_priorities_edit');
			
			$pid = intval($mybb->input['pid']);
			if ($pid <= 0 || (!($priority = $db->fetch_array($db->simple_select('helpcenter_priorities', '*', "pid = $pid")))))
			{
				helpcenter_messageredirect($lang->helpcenter_invalid_priority, 1);
			}
			
			$form = new Form("index.php?module=tools-helpcenter&amp;action=do_editpriority", "post", "helpcenter");
	
			$form_container = new FormContainer($lang->helpcenter_editpriority);
			echo $form->generate_hidden_field('pid', $pid);
			$form_container->output_row($lang->helpcenter_editpriority_name, $lang->helpcenter_editpriority_name_desc, $form->generate_text_box('name', htmlspecialchars_uni($priority['name']), array('id' => 'name')), 'name');
			$form_container->output_row($lang->helpcenter_editpriority_description, $lang->helpcenter_editpriority_description_desc, $form->generate_text_box('description', htmlspecialchars_uni($priority['description']), array('id' => 'description')), 'description');
			$form_container->output_row($lang->helpcenter_editpriority_level, $lang->helpcenter_editpriority_level_desc, $form->generate_text_box('level', intval($priority['level']), array('id' => 'level')), 'level');
			$form_container->output_row($lang->helpcenter_editpriority_format, htmlspecialchars_uni($lang->helpcenter_editpriority_format_desc), $form->generate_text_box('format', $priority['format'], array('id' => 'format')), 'format');
			
			$form_container->end();

			//$buttons = "";
			$submit_options = array('name' => 'save');
			$buttons = array();
			$buttons[] = $form->generate_submit_button($lang->helpcenter_submit);
			$buttons[] = $form->generate_reset_button($lang->helpcenter_reset);
			$form->output_submit_wrapper($buttons);
			$form->end();
		}
		else if ($mybb->input['action'] == 'helpcategories')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_helpcategories');
			
			// table
			$table = new Table;
			$table->construct_header($lang->helpcenter_name, array('width' => '30%'));
			$table->construct_header($lang->helpcenter_description, array('width' => '40%'));
			$table->construct_header($lang->helpcenter_docs, array('width' => '10%', 'class' => 'align_center'));
			$table->construct_header($lang->helpcenter_action, array('width' => '20%', 'class' => 'align_center'));
			
			$query = $db->simple_select('helpcenter_docs_cat', '*');
			
			while ($cat = $db->fetch_array($query))
			{
				$category = $cat;
					
				$table->construct_cell(htmlspecialchars_uni($category['name']));
				$table->construct_cell(htmlspecialchars_uni($category['description']));
				$table->construct_cell(intval($category['docs']), array('class' => 'align_center'));
				
				// actions column
				$table->construct_cell("<a href=\"index.php?module=tools-helpcenter&amp;action=editcategory&amp;cid=".intval($category['cid'])."\">".$lang->helpcenter_edit."</a> - <a href=\"index.php?module=tools-helpcenter&amp;action=do_deletecategory&amp;cid=".intval($category['cid'])."\">".$lang->helpcenter_delete."</a>", array('class' => 'align_center'));
				
				$table->construct_row();
			}
			
			if (!$category)
			{
				$table->construct_cell($lang->helpcenter_nocategories, array('colspan' => 4));
				
				$table->construct_row();
			}
			
			$table->output($lang->helpcenter_helpcategories);
		}
		elseif ($mybb->input['action'] == 'addcategory')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_helpcategories_add');
			
			$form = new Form("index.php?module=tools-helpcenter&amp;action=do_addcategory", "post", "helpcenter");
	
			$form_container = new FormContainer($lang->helpcenter_addcategory);
			$form_container->output_row($lang->helpcenter_addcategory_name, $lang->helpcenter_addcategory_name_desc, $form->generate_text_box('name', '', array('id' => 'name')), 'name');
			$form_container->output_row($lang->helpcenter_addcategory_description, $lang->helpcenter_addcategory_description_desc, $form->generate_text_box('description', '', array('id' => 'description')), 'description');
	
			$form_container->end();
			
			//$buttons = "";
			$submit_options = array('name' => 'save');
			$buttons = array();

			$buttons[] = $form->generate_submit_button($lang->helpcenter_submit);
			$buttons[] = $form->generate_reset_button($lang->helpcenter_reset);
			$form->output_submit_wrapper($buttons);
			$form->end();
		}
		elseif ($mybb->input['action'] == 'editcategory')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_helpcategories_edit');
			
			$cid = intval($mybb->input['cid']);
			if ($cid <= 0 || (!($category = $db->fetch_array($db->simple_select('helpcenter_docs_cat', '*', "cid = $cid")))))
			{
				helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'helpcategories');
			}
			
			$form = new Form("index.php?module=tools-helpcenter&amp;action=do_editcategory", "post", "helpcenter");
	
			$form_container = new FormContainer($lang->helpcenter_editcategory);
			echo $form->generate_hidden_field('cid', $cid);
			$form_container->output_row($lang->helpcenter_editcategory_name, $lang->helpcenter_editcategory_name_desc, $form->generate_text_box('name', htmlspecialchars_uni($category['name']), array('id' => 'name')), 'name');
			$form_container->output_row($lang->helpcenter_editcategory_description, $lang->helpcenter_editcategory_description_desc, $form->generate_text_box('description', htmlspecialchars_uni($category['description']), array('id' => 'description')), 'description');
			
			$form_container->end();
			
			//$buttons = "";
			$submit_options = array('name' => 'save');
			$buttons = array();

			$buttons[] = $form->generate_submit_button($lang->helpcenter_submit);
			$buttons[] = $form->generate_reset_button($lang->helpcenter_reset);
			$form->output_submit_wrapper($buttons);
			$form->end();
		}
		elseif ($mybb->input['action'] == 'ticketcategories')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_ticketcategories');
			
			// table
			$table = new Table;
			$table->construct_header($lang->helpcenter_name, array('width' => '30%'));
			$table->construct_header($lang->helpcenter_description, array('width' => '40%'));
			$table->construct_header($lang->helpcenter_tickets, array('width' => '10%', 'class' => 'align_center'));
			$table->construct_header($lang->helpcenter_action, array('width' => '20%', 'class' => 'align_center'));
			
			$query = $db->simple_select('helpcenter_categories', '*');
			
			while ($cat = $db->fetch_array($query))
			{
				$category = $cat;
					
				$table->construct_cell(htmlspecialchars_uni($category['name']));
				$table->construct_cell(htmlspecialchars_uni($category['description']));
				$table->construct_cell(intval($category['tickets']), array('class' => 'align_center'));
				
				// actions column
				$table->construct_cell("<a href=\"index.php?module=tools-helpcenter&amp;action=editticketcategory&amp;cid=".intval($category['cid'])."\">".$lang->helpcenter_edit."</a> - <a href=\"index.php?module=tools-helpcenter&amp;action=do_deleteticketcategory&amp;cid=".intval($category['cid'])."\">".$lang->helpcenter_delete."</a>", array('class' => 'align_center'));
				
				$table->construct_row();
			}
			
			if (!$category)
			{
				$table->construct_cell($lang->helpcenter_nocategories, array('colspan' => 4));
				
				$table->construct_row();
			}
			
			$table->output($lang->helpcenter_ticketcategories);
		}
		elseif ($mybb->input['action'] == 'addticketcategory')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_ticketcategories_add');
			
			$form = new Form("index.php?module=tools-helpcenter&amp;action=do_addticketcategory", "post", "helpcenter");
	
			$form_container = new FormContainer($lang->helpcenter_addticketcategory);
			$form_container->output_row($lang->helpcenter_addticketcategory_name, $lang->helpcenter_addticketcategory_name_desc, $form->generate_text_box('name', '', array('id' => 'name')), 'name');
			$form_container->output_row($lang->helpcenter_addticketcategory_description, $lang->helpcenter_addticketcategory_description_desc, $form->generate_text_box('description', '', array('id' => 'description')), 'description');
	
			$form_container->end();
			
			//$buttons = "";
			$submit_options = array('name' => 'save');
			$buttons = array();

			$buttons[] = $form->generate_submit_button($lang->helpcenter_submit);
			$buttons[] = $form->generate_reset_button($lang->helpcenter_reset);
			$form->output_submit_wrapper($buttons);
			$form->end();
		}
		elseif ($mybb->input['action'] == 'editticketcategory')
		{
			$page->output_nav_tabs($sub_tabs, 'helpcenter_ticketcategories_edit');
			
			$cid = intval($mybb->input['cid']);
			if ($cid <= 0 || (!($category = $db->fetch_array($db->simple_select('helpcenter_categories', '*', "cid = $cid")))))
			{
				helpcenter_messageredirect($lang->helpcenter_invalid_category, 1, 'ticketcategories');
			}
			
			$form = new Form("index.php?module=tools-helpcenter&amp;action=do_editticketcategory", "post", "helpcenter");
	
			$form_container = new FormContainer($lang->helpcenter_editticketcategory);
			echo $form->generate_hidden_field('cid', $cid);
			$form_container->output_row($lang->helpcenter_editticketcategory_name, $lang->helpcenter_editticketcategory_name_desc, $form->generate_text_box('name', htmlspecialchars_uni($category['name']), array('id' => 'name')), 'name');
			$form_container->output_row($lang->helpcenter_editticketcategory_description, $lang->helpcenter_editticketcategory_description_desc, $form->generate_text_box('description', htmlspecialchars_uni($category['description']), array('id' => 'description')), 'description');
			
			$form_container->end();
			
			//$buttons = "";
			$submit_options = array('name' => 'save');
			$buttons = array();

			$buttons[] = $form->generate_submit_button($lang->helpcenter_submit);
			$buttons[] = $form->generate_reset_button($lang->helpcenter_reset);
			$form->output_submit_wrapper($buttons);
			$form->end();
		}
		
		$page->output_footer();
		exit;
	}
}

?>