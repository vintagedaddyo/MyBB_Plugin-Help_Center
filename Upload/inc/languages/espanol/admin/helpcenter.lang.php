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

// plugin_info

$l['helpcenter_Name'] = 'Centro de ayuda';
$l['helpcenter_Desc'] = 'Agrega un poderoso Centro de Ayuda a MyBB.';
$l['helpcenter_Web'] = 'http://mybb-plugins.com';
$l['helpcenter_Auth'] = 'Pirata Nervo & updated by Vintagedaddyo';
$l['helpcenter_AuthSite'] = 'http://community.mybb.com/user-6029.html';
$l['helpcenter_Ver'] = '1.7';
$l['helpcenter_Compat'] = '18*';


$l['helpcenter'] = 'Centro de ayuda';
$l['helpcenter_index'] = 'Centro de ayuda';

$l['helpcenter_option_0_Title'] = 'Centro de ayuda';
$l['helpcenter_option_0_Description'] = 'Configuraciones para el Centro de ayuda';

$l['helpcenter_option_1_Title'] = '¿Está habilitado?';
$l['helpcenter_option_1_Description'] = 'Establezca en No para deshabilitar el Centro de ayuda.';

$l['helpcenter_option_2_Title'] = 'Grupos de usuarios moderadores';
$l['helpcenter_option_2_Description'] = "Ingrese los ID de grupo (separados por una coma) de los grupos que pueden administrar el Centro de ayuda.";

$l['helpcenter_option_3_Title'] = 'Permitir nuevas entradas?';
$l['helpcenter_option_3_Description'] = "Establezca Sí si desea que los usuarios puedan enviar nuevos tickets de soporte. Si se establece en no, se mostrará un mensaje informando a los usuarios sobre la desactivación de nuevos envíos de entradas.";

$l['helpcenter_option_4_Title'] = '¿Docs de ayuda habilitados?';
$l['helpcenter_option_4_Description'] = "Establezca en No si desea deshabilitar los documentos de ayuda. Nota: Los documentos del Centro de ayuda no están relacionados con los documentos de ayuda de MyBB.";

$l['helpcenter_option_5_Title'] = '¿Presentar boletos para el correo electrónico?';
$l['helpcenter_option_5_Description'] = "¿Desea que le enviemos un correo electrónico cada vez que se envía un nuevo ticket?";

$l['helpcenter_option_6_Title'] = 'Correo electrónico de soporte';
$l['helpcenter_option_6_Description'] = "si la configuración anterior está establecida en Sí, debe ingresar aquí el correo electrónico que recibe nuevos envíos de boletos.";

$l['helpcenter_priority_1_Name'] = 'Bajo';
$l['helpcenter_priority_1_Description'] = 'No requiere soporte inmediato.';
$l['helpcenter_priority_1_Format'] = '<span style="color: #F5B800;">{priority}</span>';

$l['helpcenter_priority_2_Name'] = 'Medio';
$l['helpcenter_priority_2_Description'] = 'No requiere soporte inmediato, sin embargo, se debe brindar soporte una vez que sea posible.';
$l['helpcenter_priority_2_Format'] = '<span style="color: #F53D00;">{priority}</span>';

$l['helpcenter_priority_3_Name'] = 'Alto';
$l['helpcenter_priority_3_Description'] = 'Requiere soporte inmediato.';
$l['helpcenter_priority_3_Format'] = '<span style="color: #990000;">{priority}</span>';

// Tabs
$l['helpcenter_priorities'] = 'Prioridades';
$l['helpcenter_priorities_desc'] = 'Administrar prioridades';
$l['helpcenter_priorities_add'] = 'Añadir';
$l['helpcenter_priorities_add_desc'] = 'Agrega una prioridad';
$l['helpcenter_priorities_edit'] = 'Editar';
$l['helpcenter_priorities_edit_desc'] = 'Editar una prioridad existente.';
$l['helpcenter_priorities_delete'] = 'Borrar';
$l['helpcenter_priorities_delete_desc'] = 'Eliminar y prioridad existente.';

$l['helpcenter_helpcategories'] = 'Categorías de ayuda';
$l['helpcenter_helpcategories_desc'] = 'Administrar categorías de ayuda.';
$l['helpcenter_helpcategories_add'] = 'Añadir';
$l['helpcenter_helpcategories_add_desc'] = 'Agrega una nueva categoría';
$l['helpcenter_helpcategories_edit'] = 'Editar';
$l['helpcenter_helpcategories_edit_desc'] = 'Editar una categoría existente.';
$l['helpcenter_helpcategories_delete'] = 'Borrar';
$l['helpcenter_helpcategories_delete_desc'] = 'Eliminar una categoría existente.';

$l['helpcenter_ticketcategories'] = 'Categorías de entradas';
$l['helpcenter_ticketcategories_desc'] = 'Administrar categorías de tickets.';
$l['helpcenter_ticketcategories_add'] = 'Añadir';
$l['helpcenter_ticketcategories_add_desc'] = 'Agrega una nueva categoría';
$l['helpcenter_ticketcategories_edit'] = 'Editar';
$l['helpcenter_ticketcategories_edit_desc'] = 'Editar una categoría existente.';
$l['helpcenter_ticketcategories_delete'] = 'Borrar';
$l['helpcenter_ticketcategories_delete_desc'] = 'Eliminar una categoría existente.';

// General
$l['helpcenter_edit'] = 'Editar';
$l['helpcenter_delete'] = 'Borrar';
$l['helpcenter_submit'] = 'Enviar';
$l['helpcenter_reset'] = 'Reiniciar';

// Error messages
$l['helpcenter_nopriorities'] = 'No se encontraron prioridades';
$l['helpcenter_nocategories'] = 'No se encontraron categorías';
$l['helpcenter_invalid_priority'] = 'Prioridad inválida.';
$l['helpcenter_invalid_category'] = 'Categoría inválida';
$l['helpcenter_missing_field'] = 'Faltan uno o más campos.';
$l['helpcenter_unknown_error'] = 'Un error desconocido a ocurrido.';

// Table header
$l['helpcenter_name'] = 'Nombre';
$l['helpcenter_description'] = 'Descripción';
$l['helpcenter_level'] = 'Nivel';
$l['helpcenter_format'] = 'Formato';
$l['helpcenter_action'] = 'Acción';
$l['helpcenter_docs'] = 'Documentos';
$l['helpcenter_tickets'] = 'Entradas';

// Priorities - Add
$l['helpcenter_addpriority'] = 'Agregar prioridad';
$l['helpcenter_addpriority_name'] = 'Nombre';
$l['helpcenter_addpriority_name_desc'] = 'Ingrese el nombre de la prioridad.';
$l['helpcenter_addpriority_description'] = 'Descripción';
$l['helpcenter_addpriority_description_desc'] = 'Ingrese una descripción para esta prioridad.';
$l['helpcenter_addpriority_level'] = 'Nivel';
$l['helpcenter_addpriority_level_desc'] = 'Ingrese un nivel para esta prioridad. Por lo general, 1 es el nivel más bajo de prioridad. El nivel de prioridad más alto no está definido.<br />Esto es utilizado por el complemento para identificar qué prioridad es más alta cuando se comparan tickets.';
$l['helpcenter_addpriority_format'] = 'Formato';
$l['helpcenter_addpriority_format_desc'] = 'Ingrese un formato de visualización para esta prioridad. P.ej. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_added'] = 'Se ha agregado una nueva prioridad con éxito.';

// Priorities - Edit
$l['helpcenter_editpriority'] = 'Editar Prioridad';
$l['helpcenter_editpriority_name'] = 'Nombre';
$l['helpcenter_editpriority_name_desc'] = 'Ingrese el nombre de la prioridad.';
$l['helpcenter_editpriority_description'] = 'Descripción';
$l['helpcenter_editpriority_description_desc'] = 'Ingrese una descripción para esta prioridad.';
$l['helpcenter_editpriority_level'] = 'Nivel';
$l['helpcenter_editpriority_level_desc'] = 'Ingrese un nivel para esta prioridad. Por lo general, 1 es el nivel más bajo de prioridad. El nivel de prioridad más alto no está definido.<br />Esto es utilizado por el complemento para identificar qué prioridad es más alta cuando se comparan tickets.';
$l['helpcenter_editpriority_format'] = 'Formato';
$l['helpcenter_editpriority_format_desc'] = 'Ingrese un formato de visualización para esta prioridad. P.ej. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_edited'] = 'La prioridad seleccionada ha sido editada con éxito.';

// Priorities - Delete
$l['helpcenter_priority_deleted'] = 'La prioridad seleccionada ha sido eliminada exitosamente.';
$l['helpcenter_confirm_deletepriority'] = '¿Seguro que quieres eliminar la prioridad seleccionada?';

// Help Categories - Add
$l['helpcenter_addcategory'] = 'añadir categoría';
$l['helpcenter_addcategory_name'] = 'Nombre';
$l['helpcenter_addcategory_name_desc'] = 'Ingrese el nombre de la categoría.';
$l['helpcenter_addcategory_description'] = 'Descripción';
$l['helpcenter_addcategory_description_desc'] = 'Ingrese una descripción para esta categoría.';
$l['helpcenter_category_added'] = 'Se ha agregado una nueva categoría con éxito.';

// Help Categories - Edit
$l['helpcenter_editcategory'] = 'Editar categoria';
$l['helpcenter_editcategory_name'] = 'Nombre';
$l['helpcenter_editcategory_name_desc'] = 'Ingrese el nombre de la categoría.';
$l['helpcenter_editcategory_description'] = 'Descripción';
$l['helpcenter_editcategory_description_desc'] = 'Ingrese una descripción para esta categoría.';
$l['helpcenter_category_edited'] = 'La categoría seleccionada ha sido editada con éxito.';

// Help Categories - Delete
$l['helpcenter_category_deleted'] = 'La categoría seleccionada ha sido eliminada exitosamente.';
$l['helpcenter_confirm_deletecategory'] = '¿Seguro que quieres eliminar la categoría seleccionada? ¡Todos los documentos dentro de esta categoría serán eliminados también y este proceso NO PUEDE deshacerse!';

// Ticket Categories - Add
$l['helpcenter_addticketcategory'] = 'añadir categoría';
$l['helpcenter_addticketcategory_name'] = 'Nombre';
$l['helpcenter_addticketcategory_name_desc'] = 'Ingrese el nombre de la categoría.';
$l['helpcenter_addticketcategory_description'] = 'Descripción';
$l['helpcenter_addticketcategory_description_desc'] = 'Ingrese una descripción para esta categoría.';
$l['helpcenter_ticketcategory_added'] = 'Se ha agregado una nueva categoría con éxito.';

// Ticket Categories - Edit
$l['helpcenter_editticketcategory'] = 'Editar categoria';
$l['helpcenter_editticketcategory_name'] = 'Nombre';
$l['helpcenter_editticketcategory_name_desc'] = 'Ingrese el nombre de la categoría.';
$l['helpcenter_editticketcategory_description'] = 'Descripción';
$l['helpcenter_editticketcategory_description_desc'] = 'Ingrese una descripción para esta categoría.';
$l['helpcenter_ticketcategory_edited'] = 'La categoría seleccionada ha sido editada con éxito.';

// Ticket Categories - Delete
$l['helpcenter_ticketcategory_deleted'] = 'La categoría seleccionada ha sido eliminada exitosamente.';
$l['helpcenter_confirm_deleteticketcategory'] = '¿Seguro que quieres eliminar la categoría seleccionada? ¡Todas las entradas dentro de esta categoría serán eliminadas también y este proceso NO PUEDE deshacerse!';

?>