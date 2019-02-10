<?php
/***************************************************************************
 *
 *  Help Center plugin (inc/languages/arabic/admin/helpcenter.lang.php)
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

$l['helpcenter_Name'] = 'مركز المساعدة';
$l['helpcenter_Desc'] = 'لإضافة مركز مساعدة قوي إلى MyBB.';
$l['helpcenter_Web'] = 'http://mybb-plugins.com';
$l['helpcenter_Auth'] = 'Pirata Nervo & تحديث بواسطة Vintagedaddyo';
$l['helpcenter_AuthSite'] = 'http://community.mybb.com/user-6029.html';
$l['helpcenter_Ver'] = '1.8';
$l['helpcenter_Compat'] = '18*';


$l['helpcenter'] = 'مركز المساعدة';
$l['helpcenter_index'] = 'مركز المساعدة';

$l['helpcenter_option_0_Title'] = 'مركز المساعدة';
$l['helpcenter_option_0_Description'] = 'إعدادات مركز المساعدة';

$l['helpcenter_option_1_Title'] = 'هل ممكن؟';
$l['helpcenter_option_1_Description'] = 'اضبط على لا لتعطيل مركز المساعدة.';

$l['helpcenter_option_2_Title'] = 'مجموعات المستخدم المشرف';
$l['helpcenter_option_2_Description'] = "أدخل معرفات المجموعة (مفصولة بفواصل) للمجموعات التي يمكنها إدارة مركز المساعدة.";

$l['helpcenter_option_3_Title'] = 'السماح بتذاكر جديدة؟';
$l['helpcenter_option_3_Description'] = "اضبط على نعم إذا كنت تريد أن يتمكن المستخدمون من تقديم تذاكر دعم جديدة. في حالة التعيين على لا ، سيتم عرض رسالة تخبر المستخدمين عن تعطيل عمليات إرسال التذاكر الجديدة.";

$l['helpcenter_option_4_Title'] = 'هل ساعدت محرّر المستندات؟';
$l['helpcenter_option_4_Description'] = "اضبط على لا إذا كنت تريد تعطيل مستندات المساعدة. ملاحظة: لا تتعلق مستندات مركز المساعدة بوثائق مساعدة MyBBs.";

$l['helpcenter_option_5_Title'] = 'إرسال تذاكر للبريد الإلكتروني؟';
$l['helpcenter_option_5_Description'] = "هل تريد أن يتم إرسالك بالبريد الإلكتروني كلما تم تقديم بطاقة جديدة؟";

$l['helpcenter_option_6_Title'] = 'البريد الإلكتروني الدعم';
$l['helpcenter_option_6_Description'] = "إذا تم تعيين الإعداد أعلاه على نعم ، يجب عليك إدخال البريد الإلكتروني الذي يتلقى طلبات إرسال جديدة ، هنا.";

$l['helpcenter_priority_1_Name'] = 'منخفض';
$l['helpcenter_priority_1_Description'] = 'لا يتطلب الدعم الفوري.';
$l['helpcenter_priority_1_Format'] = '<span style="color: #F5B800;">{priority}</span>';

$l['helpcenter_priority_2_Name'] = 'متوسط';
$l['helpcenter_priority_2_Description'] = 'لا يتطلب دعمًا فوريًا ، ولكن يجب تقديم الدعم مرة واحدة.';
$l['helpcenter_priority_2_Format'] = '<span style="color: #F53D00;">{priority}</span>';

$l['helpcenter_priority_3_Name'] = 'متوسط';
$l['helpcenter_priority_3_Description'] = 'يتطلب الدعم الفوري.';
$l['helpcenter_priority_3_Format'] = '<span style="color: #990000;">{priority}</span>';

// Tabs
$l['helpcenter_priorities'] = 'أولويات';
$l['helpcenter_priorities_desc'] = 'إدارة الأولويات.';
$l['helpcenter_priorities_add'] = 'إضافة';
$l['helpcenter_priorities_add_desc'] = 'أضف أولوية.';
$l['helpcenter_priorities_edit'] = 'تصحيح';
$l['helpcenter_priorities_edit_desc'] = 'تحرير أولوية موجودة.';
$l['helpcenter_priorities_delete'] = 'حذف';
$l['helpcenter_priorities_delete_desc'] = 'حذف والأولوية القائمة.';

$l['helpcenter_helpcategories'] = 'فئات المساعدة';
$l['helpcenter_helpcategories_desc'] = 'إدارة فئات المساعدة.';
$l['helpcenter_helpcategories_add'] = 'إضافة';
$l['helpcenter_helpcategories_add_desc'] = 'إضافة فئة جديدة.';
$l['helpcenter_helpcategories_edit'] = 'تصحيح';
$l['helpcenter_helpcategories_edit_desc'] = 'تحرير فئة موجودة.';
$l['helpcenter_helpcategories_delete'] = 'حذف';
$l['helpcenter_helpcategories_delete_desc'] = 'حذف فئة موجودة.';

$l['helpcenter_ticketcategories'] = 'فئات التذاكر';
$l['helpcenter_ticketcategories_desc'] = 'إدارة فئات التذاكر.';
$l['helpcenter_ticketcategories_add'] = 'إضافة';
$l['helpcenter_ticketcategories_add_desc'] = 'إضافة فئة جديدة.';
$l['helpcenter_ticketcategories_edit'] = 'تصحيح';
$l['helpcenter_ticketcategories_edit_desc'] = 'تحرير فئة موجودة.';
$l['helpcenter_ticketcategories_delete'] = 'حذف';
$l['helpcenter_ticketcategories_delete_desc'] = 'حذف فئة موجودة.';

// General
$l['helpcenter_edit'] = 'تصحيح';
$l['helpcenter_delete'] = 'حذف';
$l['helpcenter_submit'] = 'خضع';
$l['helpcenter_reset'] = 'إعادة تعيين';

// Error messages
$l['helpcenter_nopriorities'] = 'لا توجد اولويات.';
$l['helpcenter_nocategories'] = 'لم يتم العثور على فئات.';
$l['helpcenter_invalid_priority'] = 'أولوية غير صالحة.';
$l['helpcenter_invalid_category'] = 'فئة غير صالحة.';
$l['helpcenter_missing_field'] = 'واحد أو أكثر من الحقول مفقودة.';
$l['helpcenter_unknown_error'] = 'حدث خطأ غير معروف.';

// Table header
$l['helpcenter_name'] = 'اسم';
$l['helpcenter_description'] = 'وصف';
$l['helpcenter_level'] = 'مستوى';
$l['helpcenter_format'] = 'شكل';
$l['helpcenter_action'] = 'عمل';
$l['helpcenter_docs'] = 'مستندات';
$l['helpcenter_tickets'] = 'تذاكر';

// Priorities - Add
$l['helpcenter_addpriority'] = 'أضف الأولوية';
$l['helpcenter_addpriority_name'] = 'اسم';
$l['helpcenter_addpriority_name_desc'] = 'أدخل اسم الأولوية.';
$l['helpcenter_addpriority_description'] = 'وصف';
$l['helpcenter_addpriority_description_desc'] = 'أدخل وصفاً لهذه الأولوية.';
$l['helpcenter_addpriority_level'] = 'مستوى';
$l['helpcenter_addpriority_level_desc'] = 'أدخل مستوى لهذه الأولوية. عادة ، 1 هو أدنى مستوى من الأولوية. لا يتم تعريف مستوى الأولوية الأعلى. <br /> يتم استخدام هذا بواسطة المكون الإضافي لتحديد الأولوية الأعلى عند مقارنة التذاكر.';
$l['helpcenter_addpriority_format'] = 'شكل';
$l['helpcenter_addpriority_format_desc'] = '<span style="color: #FFFFFF;">{priority}</span>أدخل تنسيق عرض لهذه الأولوية. مثلا';
$l['helpcenter_priority_added'] = 'تم إضافة أولوية جديدة بنجاح.';

// Priorities - Edit
$l['helpcenter_editpriority'] = 'تحرير الاولوية';
$l['helpcenter_editpriority_name'] = 'اسم';
$l['helpcenter_editpriority_name_desc'] = 'أدخل اسم الأولوية.';
$l['helpcenter_editpriority_description'] = 'وصف';
$l['helpcenter_editpriority_description_desc'] = 'أدخل وصفاً لهذه الأولوية.';
$l['helpcenter_editpriority_level'] = 'مستوى';
$l['helpcenter_editpriority_level_desc'] = 'أدخل مستوى لهذه الأولوية. عادة ، 1 هو أدنى مستوى من الأولوية. لا يتم تعريف مستوى الأولوية الأعلى. <br /> يتم استخدام هذا بواسطة المكون الإضافي لتحديد الأولوية الأعلى عند مقارنة التذاكر.';
$l['helpcenter_editpriority_format'] = 'شكل';
$l['helpcenter_editpriority_format_desc'] = '<span style="color: #FFFFFF;">{priority}</span>دخل تنسيق عرض لهذه الأولوية. مثلا ';
$l['helpcenter_priority_edited'] = 'تم تحرير الأولوية المحددة بنجاح.';

// Priorities - Delete
$l['helpcenter_priority_deleted'] = 'تم حذف الأولوية المحددة بنجاح.';
$l['helpcenter_confirm_deletepriority'] = 'هل أنت متأكد من أنك تريد حذف الأولوية المختارة؟';

// Help Categories - Add
$l['helpcenter_addcategory'] = 'إضافة فئة';
$l['helpcenter_addcategory_name'] = 'اسم';
$l['helpcenter_addcategory_name_desc'] = 'أدخل اسم الفئة.';
$l['helpcenter_addcategory_description'] = 'وصف';
$l['helpcenter_addcategory_description_desc'] = 'أدخل وصفا لهذه الفئة.';
$l['helpcenter_category_added'] = 'تمت إضافة فئة جديدة بنجاح.';

// Help Categories - Edit
$l['helpcenter_editcategory'] = 'تحرير الفئة';
$l['helpcenter_editcategory_name'] = 'اسم';
$l['helpcenter_editcategory_name_desc'] = 'أدخل اسم الفئة.';
$l['helpcenter_editcategory_description'] = 'وصف';
$l['helpcenter_editcategory_description_desc'] = 'أدخل وصفا لهذه الفئة.';
$l['helpcenter_category_edited'] = 'تم تحرير الفئة المحددة بنجاح.';

// Help Categories - Delete
$l['helpcenter_category_deleted'] = 'تم حذف الفئة المحددة بنجاح.';
$l['helpcenter_confirm_deletecategory'] = 'هل أنت متأكد من أنك تريد حذف الفئة المختارة؟ سيتم حذف جميع الوثائق ضمن هذه الفئة أيضًا ، ولا يمكن التراجع عن هذه العملية!';

// Ticket Categories - Add
$l['helpcenter_addticketcategory'] = 'إضافة فئة';
$l['helpcenter_addticketcategory_name'] = 'اسم';
$l['helpcenter_addticketcategory_name_desc'] = 'أدخل اسم الفئة.';
$l['helpcenter_addticketcategory_description'] = 'وصف';
$l['helpcenter_addticketcategory_description_desc'] = 'أدخل وصفا لهذه الفئة.';
$l['helpcenter_ticketcategory_added'] = 'تمت إضافة فئة جديدة بنجاح.';

// Ticket Categories - Edit
$l['helpcenter_editticketcategory'] = 'تحرير الفئة';
$l['helpcenter_editticketcategory_name'] = 'اسم';
$l['helpcenter_editticketcategory_name_desc'] = 'أدخل اسم الفئة.';
$l['helpcenter_editticketcategory_description'] = 'وصف';
$l['helpcenter_editticketcategory_description_desc'] = 'أدخل وصفا لهذه الفئة.';
$l['helpcenter_ticketcategory_edited'] = 'تم تحرير الفئة المحددة بنجاح.';

// Ticket Categories - Delete
$l['helpcenter_ticketcategory_deleted'] = 'تم حذف الفئة المحددة بنجاح.';
$l['helpcenter_confirm_deleteticketcategory'] = 'هل أنت متأكد من أنك تريد حذف الفئة المختارة؟ سيتم حذف جميع التذاكر ضمن هذه الفئة أيضًا ، ولا يمكن التراجع عن هذه العملية!';

// Ticket Category - Cid
$l['helpcenter_ticket_category'] = 'الفئة';

?>