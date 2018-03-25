<?php

/***************************************************************************
 *
 *  Help Center plugin (helpcenter.php)
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

define("IN_MYBB", 1);
define('THIS_SCRIPT', 'helpcenter.php');
define('IN_HELPCENTER', 1);

// Templates used by Help Center
$templatelist  = "helpcenter,helpcenter_regular,helpcenter_manager,helpcenter_do_action,helpcenter_regular_helpdocs_doc,helpcenter_regular,helpcenter_helpdocs_cat,helpcenter_manager_helpdocs_doc,helpcenter_helpdocs_regular,helpcenter_helpdocs_cats,helpcenter_manager_newdoc,helpcenter_manager_editdoc,helpcenter_do_action,helpcenter_supportteam,helpcenter_supportteam_group,helpcenter_warning,helpcenter,helpcenter_manager,helpcenter_manager_nav,helpcenter_nav,helpcenter_helpdocs_manager,helpcenter_not_found,helpcenter_regular_nav,helpcenter_manager_tickets_ticket,helpcenter_regular_submitticket,helpcenter_manager_tickets,helpcenter_regular_tickets,helpcenter_regular_tickets_ticket,helpcenter_helpdocs_viewdoc,helpcenter_regular_tickets,helpcenter_regular_tickets_ticket,helpcenter_viewticket,helpcenter_reply,";
$templatelist .= "multipage_page_current,multipage_nextpage,multipage_page,multipage,multipage_prevpage,multipage_start,multipage_end"; // multi page templates

require_once "./global.php";

require_once MYBB_ROOT."inc/class_parser.php";
$parser = new postParser;

$plugins->run_hooks("helpcenter_start");

// load language
$lang->load("helpcenter");

if (!$mybb->user['uid'])
	error_no_permission();

if ($mybb->settings['helpcenter_enabled'] == 0)
	error($lang->helpcenter_disabled);

if (!helpcenter_check_permissions($mybb->settings['helpcenter_modgroups']))
{
	$manager = false;
}
else
{
	$manager = true;
}

if ($mybb->settings['helpcenter_newtickets_enabled'] == 0)
{
	$warningmsg = $lang->helpcenter_newtickets_disabled;
	eval("\$info = \"".$templates->get("helpcenter_warning")."\";");
}

// Add link in breadcrumb
add_breadcrumb($lang->helpcenter, "helpcenter.php");

if (!$mybb->input['action'])
{
	if ($manager)
	{
		// Add link in breadcrumb
		add_breadcrumb($lang->helpcenter_breadcrumb_manager, "helpcenter.php");
	
		// get total number of opened tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened=1");
		$tickets['openedtickets'] = $db->fetch_field($query, 'tickets');
		
		// get total number of closed tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened=0");
		$tickets['closedtickets'] = $db->fetch_field($query, 'tickets');
		
		eval("\$cptable = \"".$templates->get("helpcenter_manager")."\";");
		eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	}
	else {
	
		// Add link in breadcrumb
		add_breadcrumb($lang->helpcenter_breadcrumb_customer, "helpcenter.php");
	
		// get total number of opened tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened=1 AND uid='".$mybb->user['uid']."'");
		$tickets['openedtickets'] = $db->fetch_field($query, 'tickets');
		
		// get total number of closed tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened=0 AND uid='".$mybb->user['uid']."'");
		$tickets['closedtickets'] = $db->fetch_field($query, 'tickets');
		
		eval("\$cptable = \"".$templates->get("helpcenter_regular")."\";");
		eval("\$navmenu = \"".$templates->get("helpcenter_regular_nav")."\";");
	}
	
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'myopened' || $mybb->input['action'] == 'myclosed')
{
	//if ($manager)
	//	error_no_permission();
		
	if ($mybb->input['action'] == 'myopened')
	{
		// Add link in breadcrumb
		add_breadcrumb($lang->helpcenter_breadcrumb_mytickets, "helpcenter.php?action=myopened");
	
		// get total number of opened tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened='1' AND uid='".$mybb->user['uid']."'");
		$total_tickets = $db->fetch_field($query, 'tickets');
		$opened = 1;
		
		$lang->helpcenter_tickets = $lang->helpcenter_tickets_opened;
	}
	elseif ($mybb->input['action'] == 'myclosed')
	{
		// Add link in breadcrumb
		add_breadcrumb($lang->helpcenter_breadcrumb_mytickets, "helpcenter.php?action=myclosed");
	
		// get total number of closed tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened='0' AND uid='".$mybb->user['uid']."'");
		$total_tickets = $db->fetch_field($query, 'tickets');
		$opened = 0;
		
		$lang->helpcenter_tickets = $lang->helpcenter_tickets_closed;
	}
	
	if ($mybb->input['priority'] != '')
	{
		$extra = 'AND t.priority=\''.intval($mybb->input['priority']).'\'';
	}
	else
		$extra = '';
	
	// pagination
	$per_page = 15;
	$mybb->input['page'] = intval($mybb->input['page']);
	if($mybb->input['page'] && $mybb->input['page'] > 1)
	{
		$mybb->input['page'] = intval($mybb->input['page']);
		$start = ($mybb->input['page']*$per_page)-$per_page;
	}
	else
	{
		$mybb->input['page'] = 1;
		$start = 0;
	}
	
	// multi-page
	if ($total_tickets > $per_page)
		$multipage = multipage($total_tickets, $per_page, $mybb->input['page'], $mybb->settings['bburl']."/helpcenter.php?action=".htmlspecialchars_uni($mybb->input['action']));
	
	$query = $db->query("
		SELECT p.*, p.name as pname, t.*
		FROM ".TABLE_PREFIX."helpcenter_tickets t
		LEFT JOIN ".TABLE_PREFIX."helpcenter_priorities p ON (p.pid=t.priority)
		WHERE t.opened=".$opened." AND t.uid=".$mybb->user['uid']." {$extra}
		ORDER BY t.date DESC LIMIT {$start}, {$per_page}
	");
	
	$tickets = '';
	
	while ($ticket = $db->fetch_array($query))
	{
		$bgcolor = alt_trow();
		$ticket['title'] = "<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=viewticket&amp;tid={$ticket['tid']}\">".htmlspecialchars_uni($ticket['name'])."</a>";
		$ticket['replies'] = intval($ticket['messages']);
		$ticket['priority'] = "<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=".htmlspecialchars($mybb->input['action'])."&amp;priority={$ticket['priority']}\" title=\"\">".helpcenter_format_priority($ticket['priority'], $ticket['pname'], $ticket['format'])."</a>";
		$ticket['date'] = my_date($mybb->settings['dateformat'], $ticket['date'], '', false).", ".my_date($mybb->settings['timeformat'], $ticket['date']);
		
		eval("\$tickets .= \"".$templates->get("helpcenter_regular_tickets_ticket")."\";");
	}
	
	if (!$tickets)
	{
		$bgcolor = 'trow1';
		$colspan = 6;
		$notfound = $lang->helpcenter_tickets_notfound; 
		eval("\$tickets = \"".$templates->get("helpcenter_not_found")."\";");
	}
	
	eval("\$navmenu = \"".$templates->get("helpcenter_regular_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_regular_tickets")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'manage_opened' || $mybb->input['action'] == 'manage_closed')
{
	if (!$manager)
		error_no_permission();
		
	if ($mybb->input['action'] == 'manage_opened')
	{
		// Add link in breadcrumb
		add_breadcrumb($lang->helpcenter_breadcrumb_manage_tickets, "helpcenter.php?action=manage_opened");
	
		// get total number of opened tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened='1'");
		$total_tickets = $db->fetch_field($query, 'tickets');
		$opened = 1;
		
		$lang->helpcenter_tickets = $lang->helpcenter_tickets_opened;
	}
	elseif ($mybb->input['action'] == 'manage_closed')
	{
		// Add link in breadcrumb
		add_breadcrumb($lang->helpcenter_breadcrumb_manage_tickets, "helpcenter.php?action=manage_closed");
	
		// get total number of closed tickets
		$query = $db->simple_select("helpcenter_tickets", "COUNT(*) as tickets", "opened='0'");
		$total_tickets = $db->fetch_field($query, 'tickets');
		$opened = 0;
		
		$lang->helpcenter_tickets = $lang->helpcenter_tickets_closed;
	}
	
	if ($mybb->input['priority'] != '')
	{
		$extra = 'AND t.priority=\''.intval($mybb->input['priority']).'\'';
	}
	else
		$extra = '';
	
	// pagination
	$per_page = 15;
	$mybb->input['page'] = intval($mybb->input['page']);
	if($mybb->input['page'] && $mybb->input['page'] > 1)
	{
		$mybb->input['page'] = intval($mybb->input['page']);
		$start = ($mybb->input['page']*$per_page)-$per_page;
	}
	else
	{
		$mybb->input['page'] = 1;
		$start = 0;
	}
	
	// multi-page
	if ($total_tickets > $per_page)
		$multipage = multipage($total_tickets, $per_page, $mybb->input['page'], $mybb->settings['bburl']."/helpcenter.php?action=".htmlspecialchars_uni($mybb->input['action']));
	
	$query = $db->query("
		SELECT u.username, p.*, p.name as pname, t.*
		FROM ".TABLE_PREFIX."helpcenter_tickets t
		LEFT JOIN ".TABLE_PREFIX."users u ON (u.uid=t.uid)
		LEFT JOIN ".TABLE_PREFIX."helpcenter_priorities p ON (p.pid=t.priority)
		WHERE t.opened=".$opened." {$extra}
		ORDER BY t.date DESC LIMIT {$start}, {$per_page}
	");
	
	$tickets = '';
	
	while ($ticket = $db->fetch_array($query))
	{
		$bgcolor = alt_trow();
		$ticket['title'] = "<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=viewticket&amp;tid={$ticket['tid']}\">".htmlspecialchars_uni($ticket['name'])."</a>";
		$ticket['replies'] = intval($ticket['messages']);
		$ticket['username'] = "<a href=\"{$mybb->settings['bburl']}/member.php?action=profile&amp;uid={$ticket['uid']}\">".htmlspecialchars_uni($ticket['username'])."</a>";
		$ticket['priority'] = "<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=".htmlspecialchars($mybb->input['action'])."&amp;priority={$ticket['priority']}\" title=\"\">".helpcenter_format_priority($ticket['priority'], $ticket['pname'], $ticket['format'])."</a>";
		$ticket['date'] = my_date($mybb->settings['dateformat'], $ticket['date'], '', false).", ".my_date($mybb->settings['timeformat'], $ticket['date']);
		
		// action
		if ($opened)
		{
			$ticket['action'] = "<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=closeticket&amp;tid={$ticket['tid']}\">".$lang->helpcenter_close."</a> - <a href=\"".$mybb->settings['bburl']."/helpcenter.php?action=deleteticket&amp;tid=".$ticket['tid']."\">".$lang->helpcenter_delete."</a>";
		}
		else {
			$ticket['action'] = "<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=openticket&amp;tid={$ticket['tid']}\">".$lang->helpcenter_open."</a> - <a href=\"".$mybb->settings['bburl']."/helpcenter.php?action=deleteticket&amp;tid=".$ticket['tid']."\">".$lang->helpcenter_delete."</a>";
		}
		
		eval("\$tickets .= \"".$templates->get("helpcenter_manager_tickets_ticket")."\";");
	}
	
	if (!$tickets)
	{
		$bgcolor = 'trow1';
		$colspan = 7;
		$notfound = $lang->helpcenter_tickets_notfound; 
		eval("\$tickets = \"".$templates->get("helpcenter_not_found")."\";");
	}
	
	eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_manager_tickets")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'supportteam')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_support_team, "helpcenter.php?action=supportteam");

	$usergroups = explode(',', $mybb->settings['helpcenter_modgroups']);
	$groups = '';
	
	foreach($usergroups as $group)
	{
		$additional_sql = '';
		$search_sql = '';
		$group_members = '';
		
		$bgcolor = alt_trow();
		$usergroup = helpcenter_get_group($group);
		$usergroup['title'] = htmlspecialchars_uni($usergroup['title']);
		
		$gid = $group;
		
		// get users that belong to this group
		$total_rows = 0;
		
		$shownleaderssep = $shownregularsep = false;
		
		switch($db->type)
		{
			case "pgsql":
			case "sqlite3":
			case "sqlite2":
				$additional_sql .= " OR ','||additionalgroups||',' LIKE '%,{$gid},%'";
				break;
			default:
				$additional_sql .= "OR CONCAT(',',additionalgroups,',') LIKE '%,{$gid},%'";
		}
		$search_sql .= " (usergroup='{$gid}' {$additional_sql})";
		
		// total users
		$total_rows = $db->fetch_field($db->simple_select("users", "COUNT(uid) as users", $search_sql), "users");
		
		$users = array();
		
		$sep = '';
		
		// get group members
		$query = $db->simple_select("users", "*",$search_sql);
		while ($user = $db->fetch_array($query))
		{
			$bgcolor = alt_trow();
			
			$user['username'] = build_profile_link(htmlspecialchars_uni($user['username']), $user['uid']);
			
			$group_members .= $sep.$user['username'];
			
			$sep = ' - ';
		}
		
		eval("\$groups .= \"".$templates->get("helpcenter_supportteam_group")."\";");
	}
	
	if (!$groups)
	{
		$colspan = 2;
		$bgcolor = 'trow1';
		$notfound = $lang->helpcenter_groups_notfound;
		eval("\$groups = \"".$templates->get("helpcenter_not_found")."\";");
	}
	
	if ($manager)
	{
		eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	}
	else {
		eval("\$navmenu = \"".$templates->get("helpcenter_regular_nav")."\";");
	}
	
	eval("\$cptable = \"".$templates->get("helpcenter_supportteam")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'helpdocs')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_help_docs, "helpcenter.php?action=helpdocs");

	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	$cid = intval($mybb->input['cid']);
	// show categories as we haven't selected one yet
	if (!$cid)
	{
		$helpcats = '';
		$query = $db->simple_select('helpcenter_docs_cat', '*', '', array('order_by' => 'cid', 'order_dir' => 'desc'));
		while ($cat = $db->fetch_array($query))
		{
			$bgcolor = alt_trow();
			$cat['name'] = htmlspecialchars_uni($cat['name']);
			$cat['description'] = htmlspecialchars_uni($cat['description']);
			$cat['docs'] = intval($cat['docs']);
			eval("\$helpcats .= \"".$templates->get("helpcenter_helpdocs_cat")."\";");
		}
		
		if (!$helpcats)
		{
			$bgcolor = 'trow1';
			$colspan = 2;
			$notfound = $lang->helpcenter_helpdocs_cat_notfound; 
			eval("\$helpcats = \"".$templates->get("helpcenter_not_found")."\";");
		}
		
		eval("\$cptable = \"".$templates->get("helpcenter_helpdocs_cats")."\";");
	}
	// we are browsing a category
	else {
		$query = $db->simple_select("helpcenter_docs_cat", '*', 'cid='.$cid);
		$cat = $db->fetch_array($query);
		if (!$cat)
			error($lang->helpcenter_cat_invalid);

		$query = $db->simple_select('helpcenter_docs', '*', 'cid='.$cid, array('order_by' => 'did', 'order_dir' => 'desc'));
		
		$helpdocs = '';
		
		while ($doc = $db->fetch_array($query))
		{
			$bgcolor = alt_trow();
			$doc['title'] = htmlspecialchars_uni($doc['name']);
			$doc['description'] = htmlspecialchars_uni($doc['description']);
			if (!$manager)
				eval("\$helpdocs .= \"".$templates->get("helpcenter_regular_helpdocs_doc")."\";");
			else
			{
				$doc['action'] = "<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=deletedoc&amp;did={$doc['did']}\">".$lang->helpcenter_delete."</a>"." - "."<a href=\"{$mybb->settings['bburl']}/helpcenter.php?action=editdoc&amp;did={$doc['did']}\">".$lang->helpcenter_edit."</a>";
				eval("\$helpdocs .= \"".$templates->get("helpcenter_manager_helpdocs_doc")."\";");
			}
		}
		
		if (!$helpdocs)
		{
			$bgcolor = 'trow1';
			$colspan = 7;
			$notfound = $lang->helpcenter_helpdocs_notfound; 
			eval("\$helpdocs = \"".$templates->get("helpcenter_not_found")."\";");
		}

		if (!$manager)
			eval("\$cptable = \"".$templates->get("helpcenter_helpdocs_regular")."\";");
		else
			eval("\$cptable = \"".$templates->get("helpcenter_helpdocs_manager")."\";");
	}
	
	if ($manager)
	{
		eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	}
	else {
		eval("\$navmenu = \"".$templates->get("helpcenter_regular_nav")."\";");
	}
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'createdoc')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_create_doc, "helpcenter.php?action=createdoc");

	if (!$manager)
		error_no_permission();

	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	$smilieinserter = build_clickable_smilies();
	$codebuttons = build_mycode_inserter();
	
	$categories = '<select name="categories">
<option value="0" selected=\"selected\">'.$lang->helpcenter_select_category.'</option>';

	$cats = '';

	$query = $db->simple_select('helpcenter_docs_cat', '*');
	while ($cat = $db->fetch_array($query))
	{
		$cats .= "<option value=\"".$cat['cid']."\">".htmlspecialchars_uni($cat['name'])."</option>";
	}

	$categories .= $cats.'</select>';
	
	if (!$cats)
		error($lang->helpcenter_no_categories);
	
	eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_manager_newdoc")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_createdoc')
{
	if (!$manager)
		error_no_permission();

	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	verify_post_check($mybb->input['postcode']);
	
	if ($mybb->request_method != 'post')
		error();
		
	if (!$mybb->input['title'])
		error($lang->helpcenter_enter_title);
		
	if (!$mybb->input['description'])
		error($lang->helpcenter_enter_description);
		
	if (!$mybb->input['message'])
		error($lang->helpcenter_enter_content);
		
	if (!($cid = intval($mybb->input['categories'])))
		error($lang->helpcenter_select_category);
		
	$category = $db->fetch_array($db->simple_select('helpcenter_docs_cat', '*', "cid = $cid"));
	if (!$category)
		error($lang->helpcenter_invalid_category);
	
	$title = $db->escape_string($mybb->input['title']);
	$description = $db->escape_string($mybb->input['description']);
	$content = $db->escape_string($mybb->input['message']);
	
	$insert_array = array('name' => $title, 'description' => $description, 'content' => $content, 'cid' => $category['cid']);
	$did = $db->insert_query('helpcenter_docs', $insert_array);

	$cat = $db->fetch_array($db->simple_select('helpcenter_docs_cat', '*', "cid = ".$cid));
	$db->update_query('helpcenter_docs_cat', array('docs' => $cat['docs']+1), 'cid=\''.$category['cid'].'\'');
	
	redirect($mybb->settings['bburl']."/helpcenter.php?action=viewdoc&amp;did=".$did, $lang->helpcenter_doc_created, $lang->helpcenter_doc_created_title);
}
elseif ($mybb->input['action'] == 'editdoc')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_edit_doc, "helpcenter.php?action=editdoc");

	if (!$manager)
		error_no_permission();

	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	$did = intval($mybb->input['did']);
	$doc = $db->fetch_array($db->simple_select('helpcenter_docs', '*', "did = $did"));
	if (!$doc)
		error($lang->helpcenter_invalid_document);
		
	$doc['title'] = $doc['name'];
	
	$smilieinserter = build_clickable_smilies();
	$codebuttons = build_mycode_inserter();
	
	$categories = '<select name="categories">
<option value="0">'.$lang->helpcenter_select_category.'</option>';

	$cats = '';

	$query = $db->simple_select('helpcenter_docs_cat', '*');
	while ($cat = $db->fetch_array($query))
	{
		if ($cat['cid'] == $doc['cid'])
			$selected = "selected=\"selected\"";
		else
			$selected = '';
			
		$cats .= "<option value=\"".$cat['cid']."\" ".$selected.">".htmlspecialchars_uni($cat['name'])."</option>";
	}

	$categories .= $cats.'</select>';
	
	if (!$cats)
		error($lang->helpcenter_no_categories);
	
	eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_manager_editdoc")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_editdoc')
{
	if (!$manager)
		error_no_permission();

	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	verify_post_check($mybb->input['postcode']);
	
	if ($mybb->request_method != 'post')
		error();
		
	$did = intval($mybb->input['did']);
	$doc = $db->fetch_array($db->simple_select('helpcenter_docs', '*', "did = $did"));
	if (!$doc)
		error($lang->helpcenter_invalid_document);
		
	if (!$mybb->input['title'])
		error($lang->helpcenter_enter_title);
		
	if (!$mybb->input['description'])
		error($lang->helpcenter_enter_description);
		
	if (!$mybb->input['message'])
		error($lang->helpcenter_enter_content);
		
	if (!($cid = intval($mybb->input['categories'])))
		error($lang->helpcenter_select_category);
		
	$category = $db->fetch_array($db->simple_select('helpcenter_docs_cat', '*', "cid = $cid"));
	if (!$category)
		error($lang->helpcenter_invalid_category);
	
	$title = $db->escape_string($mybb->input['title']);
	$description = $db->escape_string($mybb->input['description']);
	$content = $db->escape_string($mybb->input['message']);
	
	$update_array = array('name' => $title, 'description' => $description, 'content' => $content, 'cid' => $category['cid']);
	$db->update_query('helpcenter_docs', $update_array, 'did='.$did);
	
	if ($doc['cid'] != $category['cid'])
	{
		$oldcat = $db->fetch_array($db->simple_select('helpcenter_docs_cat', '*', "cid = ".$doc['cid']));
	
		$db->update_query('helpcenter_docs_cat', array('docs' => $oldcat['docs']-1), 'cid=\''.$oldcat['cid'].'\'');
		$db->update_query('helpcenter_docs_cat', array('docs' => $category['docs']+1), 'cid=\''.$category['cid'].'\'');
	}

	redirect($mybb->settings['bburl']."/helpcenter.php?action=viewdoc&amp;did=".$doc['did'], $lang->helpcenter_doc_edited, $lang->helpcenter_doc_edited_title);
}
elseif ($mybb->input['action'] == 'deletedoc')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_delete_doc, "helpcenter.php?action=deletedoc");

	if (!$manager)
		error_no_permission();
		
	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	$did = intval($mybb->input['did']);
	$doc = $db->fetch_array($db->simple_select('helpcenter_docs', '*', "did = $did"));
	if (!$doc)
		error($lang->helpcenter_invalid_document);
		
	$action = 'do_deletedoc';
	$action_title = $lang->helpcenter_delete_doc;
	$fields = '<input type="hidden" name="did" value="'.$did.'">';
	$lang->helpcenter_confirm_message = $lang->helpcenter_confirm_delete_doc;
	
	eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_do_action")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_deletedoc')
{
	if (!$manager)
		error_no_permission();
		
	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	verify_post_check($mybb->input['postcode']);
	
	$did = intval($mybb->input['did']);
	$doc = $db->fetch_array($db->simple_select('helpcenter_docs', '*', "did = $did"));
	if (!$doc)
		error($lang->helpcenter_invalid_document);
		
	$db->delete_query('helpcenter_docs', 'did='.$did);
	
	$cat = $db->fetch_array($db->simple_select('helpcenter_docs_cat', '*', "cid = ".$doc['cid']));

	$db->update_query('helpcenter_docs_cat', array('docs' => $cat['docs']-1), 'cid=\''.$doc['cid'].'\''); // no quote (last parameter) is set to true
	
	redirect($mybb->settings['bburl']."/helpcenter.php?action=helpdocs&amp;cid=".$doc['cid'], $lang->helpcenter_doc_deleted, $lang->helpcenter_doc_deleted_title);
}
elseif ($mybb->input['action'] == 'viewdoc')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_view_doc, "helpcenter.php?action=viewdoc");

	if ($mybb->settings['helpcenter_docs_enabled'] == 0)
	{
		error($lang->helpcenter_docs_disabled);
	}
	
	$did = intval($mybb->input['did']);
		
	$document = $db->fetch_array($db->simple_select('helpcenter_docs', '*', "did = $did"));
	if (!$document)
		error($lang->helpcenter_invalid_document);
	
	$doc['author'] = helpcenter_get_username($doc['uid']);
	$doc['title'] = htmlspecialchars_uni($document['name']);
	$doc['description'] = htmlspecialchars_uni($document['description']);
	
	require_once MYBB_ROOT."inc/class_parser.php";
	$parser = new postParser;
	
	$parser_options = array(
		'allow_mycode' => 1,
		'allow_smilies' => 1,
		'allow_imgcode' => 1,
		'allow_html' => 0,
		'filter_badwords' => 1
	);
	
	$doc['content'] = $parser->parse_message($document['content'], $parser_options);
	$doc['did'] = $document['did'];
	
	eval("\$cptable = \"".$templates->get("helpcenter_helpdocs_viewdoc")."\";");
	
	if ($manager)
	{
		eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	}
	else {
		eval("\$navmenu = \"".$templates->get("helpcenter_regular_nav")."\";");
	}
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'submitticket')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_submit_ticket, "helpcenter.php?action=submitticket");

	//if ($manager) // managers cannot submit tickets
	//	error_no_permission();

	if ($mybb->settings['helpcenter_newtickets_enabled'] == 0)
	{
		error($lang->helpcenter_newtickets_disabled);
	}
	
	$categories = '<select name="categories">
<option value="0" selected=\"selected\">'.$lang->helpcenter_select_category.'</option>';

	$cats = '';
	$query = $db->simple_select('helpcenter_categories', '*');
	while ($cat = $db->fetch_array($query))
	{
		$cats .= "<option value=\"".$cat['cid']."\">".htmlspecialchars_uni($cat['name'])."</option>";
	}
	
	$categories .= $cats.'</select>';
	if (!$cats)
		error($lang->helpcenter_no_ticket_categories);
		
	$priorities = '<select name="priorities">
<option value="0" selected=\"selected\">'.$lang->helpcenter_select_priority.'</option>';

	$prio = '';
	$query = $db->simple_select('helpcenter_priorities', '*');
	while ($priority = $db->fetch_array($query))
	{
		$prio .= "<option value=\"".$priority['pid']."\">".htmlspecialchars_uni($priority['name'])."</option>";
	}

	$priorities .= $prio.'</select>';
	
	if (!$prio)
		error($lang->helpcenter_no_priorities);
		
	if ($mybb->settings['helpcenter_tickets_emailmode'] == 1 && $mybb->settings['helpcenter_tickets_email'] != '')
	{
		$enteremail = "<tr>
<td class=\"trow1\" width=\"20%\"><strong>{$lang->helpcenter_ticket_email}:</strong></td><td class=\"trow1\" width=\"80%\"><input name=\"email\" type=\"textbox\" value=\"\" class=\"textbox\"></td>
</tr>";
		$lang->helpcenter_ticket_notes = $lang->helpcenter_ticket_notes_email;
	}
	
	eval("\$navmenu = \"".$templates->get("helpcenter_regular_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_regular_submitticket")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_submitticket')
{
	//if ($manager) // managers cannot submit tickets
	//	error_no_permission();

	if ($mybb->settings['helpcenter_newtickets_enabled'] == 0)
	{
		error($lang->helpcenter_newtickets_disabled);
	}
	
	verify_post_check($mybb->input['postcode']);
	
	if ($mybb->request_method != 'post')
		error();
		
	if (!$mybb->input['title'])
		error($lang->helpcenter_enter_title);
		
	if (!$mybb->input['message'])
		error($lang->helpcenter_enter_message);
	
	if (!($pid = intval($mybb->input['priorities'])))
		error($lang->helpcenter_must_select_priority);
		
	$priority = $db->fetch_array($db->simple_select('helpcenter_priorities', '*', "pid = $pid"));
	if (!$priority)
		error($lang->helpcenter_invalid_priority);
		
	if (!($cid = intval($mybb->input['categories'])))
		error($lang->helpcenter_select_category);
		
	$category = $db->fetch_array($db->simple_select('helpcenter_categories', '*', "cid = $cid"));
	if (!$category)
		error($lang->helpcenter_invalid_category);
		
	if ($mybb->settings['helpcenter_tickets_emailmode'] == 1 && $mybb->settings['helpcenter_tickets_email'] != '')
	{
		if ($mybb->input['email'] == '')
			error($lang->helpcenter_enter_email);
		else
			$email = $mybb->input['email'];
	}
	
	$title = $db->escape_string($mybb->input['title']);
	$message = $db->escape_string($mybb->input['message']);
	
	$insert_array = array('name' => $title, 'date' => TIME_NOW, 'opened' => 1, 'priority' => $priority['pid'], 'cid' => $category['cid'], 'uid' => $mybb->user['uid']);
	$tid = $db->insert_query('helpcenter_tickets', $insert_array);
	
	$insert_array = array('tid' => $tid, 'date' => TIME_NOW, 'uid' => $mybb->user['uid'], 'message' => $message, 'first' => 1);
	$mid = $db->insert_query('helpcenter_messages', $insert_array);

	$cat = $db->fetch_array($db->simple_select('helpcenter_categories', '*', "cid = ".$cid));
	$db->update_query('helpcenter_categories', array('tickets' => $cat['tickets']+1), 'cid=\''.$category['cid'].'\'');
	
	if ($mybb->settings['helpcenter_tickets_emailmode'] == 1 && $mybb->settings['helpcenter_tickets_email'] != '')
	{
		$now = my_date($mybb->settings['dateformat'], TIME_NOW, '', false).", ".my_date($mybb->settings['timeformat'], TIME_NOW);
		
		 my_mail($mybb->settings['helpcenter_tickets_email'], $lang->sprintf($lang->helpcenter_ticket_emailtitle, $tid, $title), $lang->sprintf($lang->helpcenter_ticket_emailmessage, htmlspecialchars_uni($mybb->user['username']), $email, $tid, $now, $priority['name'], nl2br(str_replace(array("\\r\\n", "\\r", "\\n"), "<br />", $message)), $mybb->settings['bburl']."/helpcenter.php?action=viewticket&amp;tid=".$tid), "", "", "", false, "html", "");
	}
	
	redirect($mybb->settings['bburl']."/helpcenter.php?action=viewticket&amp;tid=".$tid, $lang->helpcenter_ticket_submitted, $lang->helpcenter_ticket_submitted_title);
}
elseif ($mybb->input['action'] == 'closeticket')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_close_ticket, "helpcenter.php?action=closeticket");

	if (!$manager)
		error_no_permission();
	
	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
		
	$action = 'do_closeticket';
	$action_title = $lang->helpcenter_close_ticket;
	$fields = '<input type="hidden" name="tid" value="'.$tid.'">';
	$lang->helpcenter_confirm_message = $lang->helpcenter_confirm_close_ticket;
	
	eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_do_action")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_closeticket')
{
	if (!$manager) // only managers can close tickets
		error_no_permission();
	
	verify_post_check($mybb->input['postcode']);
	
	if ($mybb->request_method != 'post')
		error();
		
	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
		
	if ($ticket['opened'] == 0)
		error($lang->helpcenter_already_closed);

	helpcenter_send_pm(array('receivepms' => 1, 'subject' => $lang->helpcenter_send_pm_ticket_closed_title, 'message' => $lang->sprintf($lang->helpcenter_send_pm_ticket_closed, $ticket['tid'], $mybb->user['username'], $ticket['name']), 'touid' => $ticket['uid']), -1);
	
	$db->update_query('helpcenter_tickets', array('opened' => 0), 'tid='.$tid);
	
	redirect($mybb->settings['bburl']."/helpcenter.php?action=viewticket&amp;tid=".$tid, $lang->helpcenter_ticket_closed, $lang->helpcenter_ticket_closed_title);
}
elseif ($mybb->input['action'] == 'openticket')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_open_ticket, "helpcenter.php?action=openticket");

	if (!$manager)
		error_no_permission();
	
	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
		
	$action = 'do_openticket';
	$action_title = $lang->helpcenter_open_ticket;
	$fields = '<input type="hidden" name="tid" value="'.$tid.'">';
	$lang->helpcenter_confirm_message = $lang->helpcenter_confirm_open_ticket;
	
	eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_do_action")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_openticket')
{
	if (!$manager) // only managers can open tickets
		error_no_permission();
	
	verify_post_check($mybb->input['postcode']);
	
	if ($mybb->request_method != 'post')
		error();
		
	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
		
	if ($ticket['opened'] == 1)
		error($lang->helpcenter_already_opened);

	helpcenter_send_pm(array('receivepms' => 1, 'subject' => $lang->helpcenter_send_pm_ticket_opened_title, 'message' => $lang->sprintf($lang->helpcenter_send_pm_ticket_closed, $ticket['tid'], $mybb->user['username'], $ticket['name']), 'touid' => $ticket['uid']), -1);
	
	$db->update_query('helpcenter_tickets', array('opened' => 1), 'tid='.$tid);
	
	redirect($mybb->settings['bburl']."/helpcenter.php?action=viewticket&amp;tid=".$tid, $lang->helpcenter_ticket_opened, $lang->helpcenter_ticket_opened_title);
}
elseif ($mybb->input['action'] == 'deleteticket')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_delete_ticket, "helpcenter.php?action=deleteticket");

	if (!$manager)
		error_no_permission();
	
	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
		
	$action = 'do_deleteticket';
	$action_title = $lang->helpcenter_delete_ticket;
	$fields = '<input type="hidden" name="tid" value="'.$tid.'">';
	$lang->helpcenter_confirm_message = $lang->helpcenter_confirm_delete_ticket;
	
	eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	eval("\$cptable = \"".$templates->get("helpcenter_do_action")."\";");
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_deleteticket')
{
	if (!$manager) // only managers can delete tickets
		error_no_permission();
	
	verify_post_check($mybb->input['postcode']);
	
	if ($mybb->request_method != 'post')
		error();
		
	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
	
	$db->delete_query('helpcenter_tickets', 'tid='.$tid);
	
	$cat = $db->fetch_array($db->simple_select('helpcenter_categories', '*', "cid = ".$ticket['cid']));
	$db->update_query('helpcenter_categories', array('tickets' => $cat['tickets']-1), 'cid=\''.$cat['cid'].'\'');
	
	redirect($mybb->settings['bburl']."/helpcenter.php", $lang->helpcenter_ticket_deleted, $lang->helpcenter_ticket_deleted_title);
}
elseif ($mybb->input['action'] == 'viewticket')
{
	// Add link in breadcrumb
	add_breadcrumb($lang->helpcenter_breadcrumb_view_ticket, "helpcenter.php?action=viewticket");
	
	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
		
	if (!$manager && $ticket['uid'] != $mybb->user['uid'])
		error_no_permission();
	
	$ticket['author'] = build_profile_link(helpcenter_get_username($ticket['uid']), $ticket['uid']);
	$ticket['replies'] = intval($ticket['messages']);
	$ticket['date'] = my_date($mybb->settings['dateformat'], $ticket['date'], '', false).", ".my_date($mybb->settings['timeformat'], $ticket['date']);
	
	if ($manager) {
		$actionopen = ' (<a href="'.$mybb->settings['bburl'].'/helpcenter.php?action=openticket&amp;tid='.$ticket['tid'].'">'.$lang->helpcenter_open.'</a> - <a href="'.$mybb->settings['bburl'].'/helpcenter.php?action=deleteticket&amp;tid='.$ticket['tid'].'">'.$lang->helpcenter_delete.'</a>)';
		$actionclose = ' (<a href="'.$mybb->settings['bburl'].'/helpcenter.php?action=closeticket&amp;tid='.$ticket['tid'].'">'.$lang->helpcenter_close.'</a> - <a href="'.$mybb->settings['bburl'].'/helpcenter.php?action=deleteticket&amp;tid='.$ticket['tid'].'">'.$lang->helpcenter_delete.'</a>)';
	}
	else
		$actionopen = $actionclose = '';
	
	if ($ticket['opened'] == 1)
		$ticket['status'] = $lang->helpcenter_opened.$actionclose;
	else
		$ticket['status'] = $lang->helpcenter_closed.$actionopen;
		
	$ticket['priority'] = helpcenter_format_priority($ticket['priority']);
	
	$ticket['title'] = htmlspecialchars_uni($ticket['name']);
	$ticket['description'] = htmlspecialchars_uni($ticket['description']);
	
	require_once MYBB_ROOT."inc/class_parser.php";
	$parser = new postParser;
	
	$parser_options = array(
		'allow_mycode' => 0,
		'allow_smilies' => 0,
		'allow_imgcode' => 0,
		'allow_html' => 0,
		'filter_badwords' => 1
	);
	
	$ticketmessage = $db->fetch_array($db->simple_select('helpcenter_messages', '*', "tid = $tid AND first = 1"));
	if (!$ticketmessage)
		error($lang->helpcenter_invalid_ticket);
	
	$ticket['message'] = $parser->parse_message($ticketmessage['message'], $parser_options);
	
	$replies = '';
	$count = 1;
	
	$query = $db->simple_select("helpcenter_messages", "COUNT(*) as replies", "tid = $tid AND first = 0", array('order_by' => 'date', 'order_dir' => 'desc'));
	$total_replies = intval($db->fetch_field($query, 'replies'));
	
	$parser_options = array(
		'allow_mycode' => 1,
		'allow_smilies' => 0,
		'allow_imgcode' => 0,
		'allow_html' => 0,
		'filter_badwords' => 1
	);
	
	$query = $db->simple_select('helpcenter_messages', '*', "tid = $tid AND first = 0", array('order_by' => 'date', 'order_dir' => 'desc'));
	while ($reply = $db->fetch_array($query))
	{
		$reply['number'] = ($total_replies+1)-$count;
		$reply['author'] = build_profile_link(helpcenter_get_username($reply['uid']), $reply['uid']);
		$reply['date'] = my_date($mybb->settings['dateformat'], $reply['date'], '', false).", ".my_date($mybb->settings['timeformat'], $reply['date']);

		$reply['message'] = $parser->parse_message($reply['message'], $parser_options);
		
		if ($manager)
		{
			$delete_reply = '
	<form action="'.$mybb->settings['bburl'].'/helpcenter.php?action=do_deletereply" method="post" onSubmit="return confirm(\''.$lang->helpcenter_confirmdelete.'\');">
			<input type="hidden" name="my_post_key" value="'.$mybb->post_code.'" />
			<input type="hidden" name="mid" value="'.$reply['mid'].'" />
			<input type="submit" value="'.$lang->helpcenter_delete.'" class="button" />
	</form>';
		}
		else
			$delete_reply = '';

		$count++;
		eval("\$replies .= \"".$templates->get("helpcenter_reply")."\";");
	}
	
	eval("\$cptable = \"".$templates->get("helpcenter_viewticket")."\";");
	
	if ($manager)
	{
		eval("\$navmenu = \"".$templates->get("helpcenter_manager_nav")."\";");
	}
	else {
		eval("\$navmenu = \"".$templates->get("helpcenter_regular_nav")."\";");
	}
	eval("\$cpnav = \"".$templates->get("helpcenter_nav")."\";");
}
elseif ($mybb->input['action'] == 'do_reply')
{
	verify_post_check($mybb->input['postcode']);

	$tid = intval($mybb->input['tid']);
	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = $tid"));
	if (!$ticket)
		error($lang->helpcenter_invalid_ticket);
		
	if (!$manager && $ticket['uid'] != $mybb->user['uid'])
		error_no_permission();
	
	if (!$mybb->input['reply'])
		error($lang->helpcenter_enter_message);
		
	$message = $db->escape_string($mybb->input['reply']);
		
	$insert_array = array('tid' => $tid, 'date' => TIME_NOW, 'uid' => $mybb->user['uid'], 'message' => $message, 'first' => 0);
	$mid = $db->insert_query('helpcenter_messages', $insert_array);

	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = ".$tid));
	$db->update_query('helpcenter_tickets', array('messages' => $ticket['messages']+1), 'tid=\''.$ticket['tid'].'\'');
	
	// inform author about the new reply if we are not the author
	if ($manager)
	{
		helpcenter_send_pm(array('receivepms' => 1, 'subject' => $lang->helpcenter_send_pm_newreply_title, 'message' => $lang->sprintf($lang->helpcenter_send_pm_newreply, $mybb->user['username'], $ticket['tid'], $ticket['name']), 'touid' => $ticket['uid']), -1);
	}
	
	redirect($mybb->settings['bburl']."/helpcenter.php?action=viewticket&amp;tid=".$tid, $lang->helpcenter_replied, $lang->helpcenter_replied_title);
}
elseif ($mybb->input['action'] == 'do_deletereply')
{		
	if (!$manager)
		error_no_permission();
		
	verify_post_check($mybb->input['my_post_key']);

	$mid = intval($mybb->input['mid']);
	// get reply from database (mid must exist and it must not be the message of the ticket)
	$reply = $db->fetch_array($db->simple_select('helpcenter_messages', '*', "mid = $mid AND first=0"));
	if (!$reply)
		error($lang->helpcenter_invalid_reply);
		
	$db->delete_query('helpcenter_messages', 'mid='.$mid);

	$ticket = $db->fetch_array($db->simple_select('helpcenter_tickets', '*', "tid = ".$reply['tid']));
	$db->update_query('helpcenter_tickets', array('messages' => $ticket['messages']-1), 'tid=\''.$reply['tid'].'\'');
	
	redirect($mybb->settings['bburl']."/helpcenter.php?action=viewticket&amp;tid=".$reply['tid'], $lang->helpcenter_reply_deleted, $lang->helpcenter_reply_deleted_title);
}
else
	error();

// get our downloads page
eval("\$helpcenter = \"".$templates->get("helpcenter")."\";");

$plugins->run_hooks("helpcenter_end");

output_page($helpcenter);

exit;

?>