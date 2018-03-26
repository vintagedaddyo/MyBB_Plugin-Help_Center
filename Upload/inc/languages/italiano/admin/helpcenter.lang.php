<?php
/***************************************************************************
 *
 *  Help Center plugin (inc/languages/italiano/admin/helpcenter.lang.php)
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

$l['helpcenter_Name'] = 'Centro assistenza';
$l['helpcenter_Desc'] = 'Aggiunge un potente Centro assistenza a MyBB.';
$l['helpcenter_Web'] = 'http://mybb-plugins.com';
$l['helpcenter_Auth'] = 'Pirata Nervo & updated by Vintagedaddyo';
$l['helpcenter_AuthSite'] = 'http://community.mybb.com/user-6029.html';
$l['helpcenter_Ver'] = '1.7';
$l['helpcenter_Compat'] = '18*';


$l['helpcenter'] = 'Centro assistenza';
$l['helpcenter_index'] = 'Centro assistenza';

$l['helpcenter_option_0_Title'] = 'Centro assistenza';
$l['helpcenter_option_0_Description'] = 'Impostazioni per Centro assistenza';

$l['helpcenter_option_1_Title'] = 'È abilitato?';
$l['helpcenter_option_1_Description'] = 'Impostare su No per disabilitare il Centro assistenza.';

$l['helpcenter_option_2_Title'] = 'Gruppi di utenti moderatore';
$l['helpcenter_option_2_Description'] = "Inserisci gli ID di gruppo (separati da una virgola) dei gruppi che possono gestire il Centro assistenza.";

$l['helpcenter_option_3_Title'] = 'Consenti nuovi biglietti?';
$l['helpcenter_option_3_Description'] = "Impostare su Sì se si desidera che gli utenti siano in grado di inviare nuovi ticket di supporto. Se impostato su no, verrà visualizzato un messaggio che informa gli utenti che i nuovi ticket inviati sono disabilitati.";

$l['helpcenter_option_4_Title'] = 'Aiuta i documenti abilitati?';
$l['helpcenter_option_4_Description'] = "Impostare su No se si desidera disabilitare i documenti di aiuto. Nota. I documenti del Centro assistenza non sono correlati ai documenti di assistenza di MyBB.";

$l['helpcenter_option_5_Title'] = 'Invia i biglietti per email?';
$l['helpcenter_option_5_Description'] = "Vuoi essere inviato via email ogni volta che viene inviato un nuovo ticket?";

$l['helpcenter_option_6_Title'] = 'Email di supporto';
$l['helpcenter_option_6_Description'] = "se l impostazione sopra è impostata su Sì, è necessario inserire l email che riceve i nuovi ticket di invio, qui.";

$l['helpcenter_priority_1_Name'] = 'Basso';
$l['helpcenter_priority_1_Description'] = 'Non richiede supporto immediato.';
$l['helpcenter_priority_1_Format'] = '<span style="color: #F5B800;">{priority}</span>';

$l['helpcenter_priority_2_Name'] = 'medio';
$l['helpcenter_priority_2_Description'] = 'Non richiede supporto immediato, tuttavia il supporto dovrebbe essere dato una volta possibile.';
$l['helpcenter_priority_2_Format'] = '<span style="color: #F53D00;">{priority}</span>';

$l['helpcenter_priority_3_Name'] = 'alto';
$l['helpcenter_priority_3_Description'] = 'Richiede supporto immediato.';
$l['helpcenter_priority_3_Format'] = '<span style="color: #990000;">{priority}</span>';

// Tabs
$l['helpcenter_priorities'] = 'priorità';
$l['helpcenter_priorities_desc'] = 'Gestisci le priorità.';
$l['helpcenter_priorities_add'] = 'Inserisci';
$l['helpcenter_priorities_add_desc'] = 'Aggiungi una priorità.';
$l['helpcenter_priorities_edit'] = 'modificare';
$l['helpcenter_priorities_edit_desc'] = 'Modifica una priorità esistente.';
$l['helpcenter_priorities_delete'] = 'Elimina';
$l['helpcenter_priorities_delete_desc'] = 'Elimina e priorità esistente.';

$l['helpcenter_helpcategories'] = 'Categorie di aiuto';
$l['helpcenter_helpcategories_desc'] = 'Gestisci le categorie di aiuto.';
$l['helpcenter_helpcategories_add'] = 'Inserisci';
$l['helpcenter_helpcategories_add_desc'] = 'Aggiungi una nuova categoria.';
$l['helpcenter_helpcategories_edit'] = 'modificare';
$l['helpcenter_helpcategories_edit_desc'] = 'Modifica una categoria esistente.';
$l['helpcenter_helpcategories_delete'] = 'Elimina';
$l['helpcenter_helpcategories_delete_desc'] = 'Elimina una categoria esistente.';

$l['helpcenter_ticketcategories'] = 'Ticket Categories';
$l['helpcenter_ticketcategories_desc'] = 'Manage ticket categories.';
$l['helpcenter_ticketcategories_add'] = 'Inserisci';
$l['helpcenter_ticketcategories_add_desc'] = 'Aggiungi una nuova categoria.';
$l['helpcenter_ticketcategories_edit'] = 'modificare';
$l['helpcenter_ticketcategories_edit_desc'] = 'Modifica una categoria esistente.';
$l['helpcenter_ticketcategories_delete'] = 'Elimina';
$l['helpcenter_ticketcategories_delete_desc'] = 'Elimina una categoria esistente.';

// General
$l['helpcenter_edit'] = 'modificare';
$l['helpcenter_delete'] = 'Elimina';
$l['helpcenter_submit'] = 'Sottoscrivi';
$l['helpcenter_reset'] = 'Reset';

// Error messages
$l['helpcenter_nopriorities'] = 'Nessuna priorità trovata.';
$l['helpcenter_nocategories'] = 'Nessuna categoria trovata';
$l['helpcenter_invalid_priority'] = 'Priorità non valida.';
$l['helpcenter_invalid_category'] = 'Categoria non valida';
$l['helpcenter_missing_field'] = 'Mancano uno o più campi.';
$l['helpcenter_unknown_error'] = 'Si è verificato un errore sconosciuto.';

// Table header
$l['helpcenter_name'] = 'Nome';
$l['helpcenter_description'] = 'Descrizione';
$l['helpcenter_level'] = 'Livello';
$l['helpcenter_format'] = 'Formato';
$l['helpcenter_action'] = 'Azione';
$l['helpcenter_docs'] = 'Documenti';
$l['helpcenter_tickets'] = 'Biglietti';

// Priorities - Add
$l['helpcenter_addpriority'] = 'Add Priority';
$l['helpcenter_addpriority_name'] = 'Nome';
$l['helpcenter_addpriority_name_desc'] = 'Inserisci il nome della priorità.';
$l['helpcenter_addpriority_description'] = 'Descrizione';
$l['helpcenter_addpriority_description_desc'] = 'Inserisci una descrizione per questa priorità.';
$l['helpcenter_addpriority_level'] = 'Livello';
$l['helpcenter_addpriority_level_desc'] = 'Inserisci un livello per questa priorità. Di solito, 1 è il livello più basso di priorità. Il livello di priorità più alto non è definito.<br />Questo è usato dal plugin per identificare quale priorità è più alta quando si confrontano i ticket.';
$l['helpcenter_addpriority_format'] = 'Formato';
$l['helpcenter_addpriority_format_desc'] = 'Inserisci un formato di visualizzazione per questa priorità. Per esempio. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_added'] = 'Una nuova priorità è stata aggiunta con successo.';

// Priorities - Edit
$l['helpcenter_editpriority'] = 'Modifica priorità';
$l['helpcenter_editpriority_name'] = 'Nome';
$l['helpcenter_editpriority_name_desc'] = 'Inserisci il nome della priorità.';
$l['helpcenter_editpriority_description'] = 'Descrizione';
$l['helpcenter_editpriority_description_desc'] = 'Inserisci una descrizione per questa priorità.';
$l['helpcenter_editpriority_level'] = 'Livello';
$l['helpcenter_editpriority_level_desc'] = 'Inserisci un livello per questa priorità. Di solito, 1 è il livello più basso di priorità. Il livello di priorità più alto non è definito.<br />Questo è usato dal plugin per identificare quale priorità è più alta quando si confrontano i ticket.';
$l['helpcenter_editpriority_format'] = 'Formato';
$l['helpcenter_editpriority_format_desc'] = 'Inserisci un formato di visualizzazione per questa priorità. Per esempio. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_edited'] = 'La priorità selezionata è stata modificata correttamente.';

// Priorities - Delete
$l['helpcenter_priority_deleted'] = 'La priorità selezionata è stata cancellata con successo.';
$l['helpcenter_confirm_deletepriority'] = 'Sei sicuro di voler eliminare la priorità selezionata?';

// Help Categories - Add
$l['helpcenter_addcategory'] = 'Aggiungi categoria';
$l['helpcenter_addcategory_name'] = 'Nome';
$l['helpcenter_addcategory_name_desc'] = 'Inserisci il nome della categoria.';
$l['helpcenter_addcategory_description'] = 'Descrizione';
$l['helpcenter_addcategory_description_desc'] = 'Inserisci una descrizione per questa categoria.';
$l['helpcenter_category_added'] = 'Una nuova categoria è stata aggiunta con successo.';

// Help Categories - Edit
$l['helpcenter_editcategory'] = 'Modifica categoria';
$l['helpcenter_editcategory_name'] = 'Nome';
$l['helpcenter_editcategory_name_desc'] = 'Inserisci il nome della categoria.';
$l['helpcenter_editcategory_description'] = 'Descrizione';
$l['helpcenter_editcategory_description_desc'] = 'Inserisci una descrizione per questa categoria.';
$l['helpcenter_category_edited'] = 'La categoria selezionata è stata modificata con successo.';

// Help Categories - Delete
$l['helpcenter_category_deleted'] = 'La categoria selezionata è stata cancellata con successo.';
$l['helpcenter_confirm_deletecategory'] = 'Sei sicuro di voler eliminare la categoria selezionata? Tutti i documenti all\'interno di questa categoria verranno eliminati e questo processo NON PU CAN essere annullato!';

// Ticket Categories - Add
$l['helpcenter_addticketcategory'] = 'Aggiungi categoria';
$l['helpcenter_addticketcategory_name'] = 'Nome';
$l['helpcenter_addticketcategory_name_desc'] = 'Inserisci il nome della categoria.';
$l['helpcenter_addticketcategory_description'] = 'Descrizione';
$l['helpcenter_addticketcategory_description_desc'] = 'Inserisci una descrizione per questa categoria.';
$l['helpcenter_ticketcategory_added'] = 'Una nuova categoria è stata aggiunta con successo.';

// Ticket Categories - Edit
$l['helpcenter_editticketcategory'] = 'Modifica categoria';
$l['helpcenter_editticketcategory_name'] = 'Nome';
$l['helpcenter_editticketcategory_name_desc'] = 'Inserisci il nome della categoria.';
$l['helpcenter_editticketcategory_description'] = 'Descrizione';
$l['helpcenter_editticketcategory_description_desc'] = 'Inserisci una descrizione per questa categoria.';
$l['helpcenter_ticketcategory_edited'] = 'La categoria selezionata è stata modificata con successo.';

// Ticket Categories - Delete
$l['helpcenter_ticketcategory_deleted'] = 'La categoria selezionata è stata cancellata con successo.';
$l['helpcenter_confirm_deleteticketcategory'] = 'Sei sicuro di voler eliminare la categoria selezionata? Tutti i biglietti all\'interno di questa categoria verranno eliminati e questo processo NON PU CAN essere annullato!';

?>