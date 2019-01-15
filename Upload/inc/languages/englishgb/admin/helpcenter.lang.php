<?php
/***************************************************************************
 *
 *  Help Center plugin (inc/languages/english/admin/helpcenter.lang.php)
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
 *  Plugin Version: 1.8
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

// plugin_info

$l['helpcenter_Name'] = 'Help Center';
$l['helpcenter_Desc'] = 'Adds a powerful Help Center to MyBB.';
$l['helpcenter_Web'] = 'http://mybb-plugins.com';
$l['helpcenter_Auth'] = 'Pirata Nervo & updated by Vintagedaddyo';
$l['helpcenter_AuthSite'] = 'http://community.mybb.com/user-6029.html';
$l['helpcenter_Ver'] = '1.8';
$l['helpcenter_Compat'] = '18*';


$l['helpcenter'] = 'Help Center';
$l['helpcenter_index'] = 'Help Center';

$l['helpcenter_option_0_Title'] = 'Help Center';
$l['helpcenter_option_0_Description'] = 'Settings for Help Center';

$l['helpcenter_option_1_Title'] = 'Is enabled?';
$l['helpcenter_option_1_Description'] = 'Set to No to disable the Help Center.';

$l['helpcenter_option_2_Title'] = 'Moderator User Groups';
$l['helpcenter_option_2_Description'] = "Enter the group ids (seperated by a comma) of the groups that can manage the Help Center.";

$l['helpcenter_option_3_Title'] = 'Allow new tickets?';
$l['helpcenter_option_3_Description'] = "Set to yes if you want users to be able to submit new support tickets. If set to no, a message will be shown informing the users about new ticket submissions being disabled.";

$l['helpcenter_option_4_Title'] = 'Help Docs Enabled?';
$l['helpcenter_option_4_Description'] = "Set to No if you want to disable help docs. Note: Help Center docs are not related to MyBBs help docs.";

$l['helpcenter_option_5_Title'] = 'Submit tickets to email?';
$l['helpcenter_option_5_Description'] = "Do you want to be emailed whenever a new ticket is submitted?";

$l['helpcenter_option_6_Title'] = 'Support email';
$l['helpcenter_option_6_Description'] = "if the above setting is set to Yes, you must enter the email that receives new ticket submissions, here.";

$l['helpcenter_priority_1_Name'] = 'Low';
$l['helpcenter_priority_1_Description'] = 'Does not require immediate support.';
$l['helpcenter_priority_1_Format'] = '<span style="color: #F5B800;">{priority}</span>';

$l['helpcenter_priority_2_Name'] = 'Medium';
$l['helpcenter_priority_2_Description'] = 'Does not require immediate support, however support should be given once possible.';
$l['helpcenter_priority_2_Format'] = '<span style="color: #F53D00;">{priority}</span>';

$l['helpcenter_priority_3_Name'] = 'High';
$l['helpcenter_priority_3_Description'] = 'Requires immediate support.';
$l['helpcenter_priority_3_Format'] = '<span style="color: #990000;">{priority}</span>';

// Tabs
$l['helpcenter_priorities'] = 'Priorities';
$l['helpcenter_priorities_desc'] = 'Manage priorities.';
$l['helpcenter_priorities_add'] = 'Add';
$l['helpcenter_priorities_add_desc'] = 'Add a priority.';
$l['helpcenter_priorities_edit'] = 'Edit';
$l['helpcenter_priorities_edit_desc'] = 'Edit an existing priority.';
$l['helpcenter_priorities_delete'] = 'Delete';
$l['helpcenter_priorities_delete_desc'] = 'Delete and existing priority.';

$l['helpcenter_helpcategories'] = 'Help Categories';
$l['helpcenter_helpcategories_desc'] = 'Manage help categories.';
$l['helpcenter_helpcategories_add'] = 'Add';
$l['helpcenter_helpcategories_add_desc'] = 'Add a new category.';
$l['helpcenter_helpcategories_edit'] = 'Edit';
$l['helpcenter_helpcategories_edit_desc'] = 'Edit an existing category.';
$l['helpcenter_helpcategories_delete'] = 'Delete';
$l['helpcenter_helpcategories_delete_desc'] = 'Delete an existing category.';

$l['helpcenter_ticketcategories'] = 'Ticket Categories';
$l['helpcenter_ticketcategories_desc'] = 'Manage ticket categories.';
$l['helpcenter_ticketcategories_add'] = 'Add';
$l['helpcenter_ticketcategories_add_desc'] = 'Add a new category.';
$l['helpcenter_ticketcategories_edit'] = 'Edit';
$l['helpcenter_ticketcategories_edit_desc'] = 'Edit an existing category.';
$l['helpcenter_ticketcategories_delete'] = 'Delete';
$l['helpcenter_ticketcategories_delete_desc'] = 'Delete an existing category.';

// General
$l['helpcenter_edit'] = 'Edit';
$l['helpcenter_delete'] = 'Delete';
$l['helpcenter_submit'] = 'Submit';
$l['helpcenter_reset'] = 'Reset';

// Error messages
$l['helpcenter_nopriorities'] = 'No priorities found.';
$l['helpcenter_nocategories'] = 'No categories found.';
$l['helpcenter_invalid_priority'] = 'Invalid priority.';
$l['helpcenter_invalid_category'] = 'Invalid category.';
$l['helpcenter_missing_field'] = 'One or more fields are missing.';
$l['helpcenter_unknown_error'] = 'An unknown error has occurred.';

// Table header
$l['helpcenter_name'] = 'Name';
$l['helpcenter_description'] = 'Description';
$l['helpcenter_level'] = 'Level';
$l['helpcenter_format'] = 'Format';
$l['helpcenter_action'] = 'Action';
$l['helpcenter_docs'] = 'Documents';
$l['helpcenter_tickets'] = 'Tickets';

// Priorities - Add
$l['helpcenter_addpriority'] = 'Add Priority';
$l['helpcenter_addpriority_name'] = 'Name';
$l['helpcenter_addpriority_name_desc'] = 'Enter the name of the priority.';
$l['helpcenter_addpriority_description'] = 'Description';
$l['helpcenter_addpriority_description_desc'] = 'Enter a description for this priority.';
$l['helpcenter_addpriority_level'] = 'Level';
$l['helpcenter_addpriority_level_desc'] = 'Enter a level for this priority. Usually, 1 is the lowest level of priority. The highest priority level is not defined.<br />This is used by the plugin to identify which priority is higher when comparing tickets.';
$l['helpcenter_addpriority_format'] = 'Format';
$l['helpcenter_addpriority_format_desc'] = 'Enter a display format for this priority. E.g. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_added'] = 'A new priority has been added successfully.';

// Priorities - Edit
$l['helpcenter_editpriority'] = 'Edit Priority';
$l['helpcenter_editpriority_name'] = 'Name';
$l['helpcenter_editpriority_name_desc'] = 'Enter the name of the priority.';
$l['helpcenter_editpriority_description'] = 'Description';
$l['helpcenter_editpriority_description_desc'] = 'Enter a description for this priority.';
$l['helpcenter_editpriority_level'] = 'Level';
$l['helpcenter_editpriority_level_desc'] = 'Enter a level for this priority. Usually, 1 is the lowest level of priority. The highest priority level is not defined.<br />This is used by the plugin to identify which priority is higher when comparing tickets.';
$l['helpcenter_editpriority_format'] = 'Format';
$l['helpcenter_editpriority_format_desc'] = 'Enter a display format for this priority. E.g. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_edited'] = 'The selected priority has been edited successfully.';

// Priorities - Delete
$l['helpcenter_priority_deleted'] = 'The selected priority has been deleted successfully.';
$l['helpcenter_confirm_deletepriority'] = 'Are you sure you want to delete the selected priority?';

// Help Categories - Add
$l['helpcenter_addcategory'] = 'Add Category';
$l['helpcenter_addcategory_name'] = 'Name';
$l['helpcenter_addcategory_name_desc'] = 'Enter the name of the category.';
$l['helpcenter_addcategory_description'] = 'Description';
$l['helpcenter_addcategory_description_desc'] = 'Enter a description for this category.';
$l['helpcenter_category_added'] = 'A new category has been added successfully.';

// Help Categories - Edit
$l['helpcenter_editcategory'] = 'Edit Category';
$l['helpcenter_editcategory_name'] = 'Name';
$l['helpcenter_editcategory_name_desc'] = 'Enter the name of the category.';
$l['helpcenter_editcategory_description'] = 'Description';
$l['helpcenter_editcategory_description_desc'] = 'Enter a description for this category.';
$l['helpcenter_category_edited'] = 'The selected category has been edited successfully.';

// Help Categories - Delete
$l['helpcenter_category_deleted'] = 'The selected category has been deleted successfully.';
$l['helpcenter_confirm_deletecategory'] = 'Are you sure you want to delete the selected category? All documents within this category will be deleted as well and this process CANNOT be undone!';

// Ticket Categories - Add
$l['helpcenter_addticketcategory'] = 'Add Category';
$l['helpcenter_addticketcategory_name'] = 'Name';
$l['helpcenter_addticketcategory_name_desc'] = 'Enter the name of the category.';
$l['helpcenter_addticketcategory_description'] = 'Description';
$l['helpcenter_addticketcategory_description_desc'] = 'Enter a description for this category.';
$l['helpcenter_ticketcategory_added'] = 'A new category has been added successfully.';

// Ticket Categories - Edit
$l['helpcenter_editticketcategory'] = 'Edit Category';
$l['helpcenter_editticketcategory_name'] = 'Name';
$l['helpcenter_editticketcategory_name_desc'] = 'Enter the name of the category.';
$l['helpcenter_editticketcategory_description'] = 'Description';
$l['helpcenter_editticketcategory_description_desc'] = 'Enter a description for this category.';
$l['helpcenter_ticketcategory_edited'] = 'The selected category has been edited successfully.';

// Ticket Categories - Delete
$l['helpcenter_ticketcategory_deleted'] = 'The selected category has been deleted successfully.';
$l['helpcenter_confirm_deleteticketcategory'] = 'Are you sure you want to delete the selected category? All tickets within this category will be deleted as well and this process CANNOT be undone!';

// Ticket Category - Cid
$l['helpcenter_ticket_category'] = 'Category';

?>