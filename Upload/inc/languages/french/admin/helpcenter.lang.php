<?php
/***************************************************************************
 *
 *  Help Center plugin (inc/languages/french/admin/helpcenter.lang.php)
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

$l['helpcenter_Name'] = 'Centre d\'aide';
$l['helpcenter_Desc'] = 'Ajoute à un puissant centre d\'aide à MyBB.';
$l['helpcenter_Web'] = 'http://mybb-plugins.com';
$l['helpcenter_Auth'] = 'Pirata Nervo & updated by Vintagedaddyo';
$l['helpcenter_AuthSite'] = 'http://community.mybb.com/user-6029.html';
$l['helpcenter_Ver'] = '1.8';
$l['helpcenter_Compat'] = '18*';


$l['helpcenter'] = 'Centre d\'aide';
$l['helpcenter_index'] = 'Centre d\'aide';

$l['helpcenter_option_0_Title'] = 'Centre d aide';
$l['helpcenter_option_0_Description'] = 'Paramètres du centre d aide';

$l['helpcenter_option_1_Title'] = 'Est-ce activé?';
$l['helpcenter_option_1_Description'] = 'Définissez sur Non pour désactiver le centre d aide.';

$l['helpcenter_option_2_Title'] = 'Groupes d utilisateurs du modérateur';
$l['helpcenter_option_2_Description'] = "Entrez les identifiants de groupes (séparés par une virgule) des groupes pouvant gérer le centre d aide.";

$l['helpcenter_option_3_Title'] = 'Autoriser de nouveaux tickets?';
$l['helpcenter_option_3_Description'] = "Définissez sur yes si vous souhaitez que les utilisateurs puissent soumettre de nouveaux tickets de support. Si ce paramètre est défini sur no, un message s affiche pour informer les utilisateurs de la désactivation des nouvelles soumissions de tickets.";

$l['helpcenter_option_4_Title'] = 'Aidez Docs Activé?';
$l['helpcenter_option_4_Description'] = "Définissez sur Non si vous souhaitez désactiver les documents d aide. Remarque: les documents du centre d aide ne sont pas liés aux documents d aide de MyBBs.";

$l['helpcenter_option_5_Title'] = 'Soumettre des billets à envoyer par courriel?';
$l['helpcenter_option_5_Description'] = "Voulez-vous recevoir un e-mail chaque fois qu un nouveau ticket est envoyé?";

$l['helpcenter_option_6_Title'] = 'Email de support';
$l['helpcenter_option_6_Description'] = "Si le paramètre ci-dessus est défini sur Oui, vous devez entrer le courrier électronique qui reçoit les nouvelles soumissions de ticket, ici.";

$l['helpcenter_priority_1_Name'] = 'Faible';
$l['helpcenter_priority_1_Description'] = 'Ne nécessite pas de support immédiat.';
$l['helpcenter_priority_1_Format'] = '<span style="color: #F5B800;">{priority}</span>';

$l['helpcenter_priority_2_Name'] = 'Moyen';
$l['helpcenter_priority_2_Description'] = 'Ne nécessite pas de support immédiat, cependant le support devrait être donné une fois possible.';
$l['helpcenter_priority_2_Format'] = '<span style="color: #F53D00;">{priority}</span>';

$l['helpcenter_priority_3_Name'] = 'Haute';
$l['helpcenter_priority_3_Description'] = 'Nécessite un soutien immédiat.';
$l['helpcenter_priority_3_Format'] = '<span style="color: #990000;">{priority}</span>';

// Tabs
$l['helpcenter_priorities'] = 'Priorités';
$l['helpcenter_priorities_desc'] = 'Gérer les priorités';
$l['helpcenter_priorities_add'] = 'Ajouter';
$l['helpcenter_priorities_add_desc'] = 'Ajouter une priorité';
$l['helpcenter_priorities_edit'] = 'modifier';
$l['helpcenter_priorities_edit_desc'] = 'Modifier une priorité existante';
$l['helpcenter_priorities_delete'] = 'Effacer';
$l['helpcenter_priorities_delete_desc'] = 'Supprimer et priorité existante';

$l['helpcenter_helpcategories'] = 'Catégories d\'aide';
$l['helpcenter_helpcategories_desc'] = 'Gérer les catégories d\'aide';
$l['helpcenter_helpcategories_add'] = 'Ajouter';
$l['helpcenter_helpcategories_add_desc'] = 'Ajouter une nouvelle catégorie';
$l['helpcenter_helpcategories_edit'] = 'modifier';
$l['helpcenter_helpcategories_edit_desc'] = 'Modifier une catégorie existante';
$l['helpcenter_helpcategories_delete'] = 'Effacer';
$l['helpcenter_helpcategories_delete_desc'] = 'Supprimer une catégorie existante';

$l['helpcenter_ticketcategories'] = 'Catégories de billets';
$l['helpcenter_ticketcategories_desc'] = 'Gérer les catégories de billets';
$l['helpcenter_ticketcategories_add'] = 'Ajouter';
$l['helpcenter_ticketcategories_add_desc'] = 'Ajouter une nouvelle catégorie';
$l['helpcenter_ticketcategories_edit'] = 'modifier';
$l['helpcenter_ticketcategories_edit_desc'] = 'Modifier une catégorie existante';
$l['helpcenter_ticketcategories_delete'] = 'Effacer';
$l['helpcenter_ticketcategories_delete_desc'] = 'Supprimer une catégorie existante.';

// General
$l['helpcenter_edit'] = 'modifier';
$l['helpcenter_delete'] = 'Effacer';
$l['helpcenter_submit'] = 'Soumettre';
$l['helpcenter_reset'] = 'Réinitialiser';

// Error messages
$l['helpcenter_nopriorities'] = 'Aucune priorité trouvée.';
$l['helpcenter_nocategories'] = 'Aucune catégorie trouvée.';
$l['helpcenter_invalid_priority'] = 'Priorité non valide.';
$l['helpcenter_invalid_category'] = 'Catégorie invalide.';
$l['helpcenter_missing_field'] = 'Un ou plusieurs champs sont manquants.';
$l['helpcenter_unknown_error'] = 'Une erreur inconnue s\'est produite.';

// Table header
$l['helpcenter_name'] = 'prénom';
$l['helpcenter_description'] = 'La description';
$l['helpcenter_level'] = 'Niveau';
$l['helpcenter_format'] = 'Format';
$l['helpcenter_action'] = 'Action';
$l['helpcenter_docs'] = 'Documents';
$l['helpcenter_tickets'] = 'Des billets';

// Priorities - Add
$l['helpcenter_addpriority'] = 'Ajouter une priorité';
$l['helpcenter_addpriority_name'] = 'prénom';
$l['helpcenter_addpriority_name_desc'] = 'Entrez le nom de la priorité.';
$l['helpcenter_addpriority_description'] = 'La description';
$l['helpcenter_addpriority_description_desc'] = 'Entrez une description pour cette priorité.';
$l['helpcenter_addpriority_level'] = 'Niveau';
$l['helpcenter_addpriority_level_desc'] = 'Entrez un niveau pour cette priorité. Habituellement, 1 est le niveau de priorité le plus bas. Le niveau de priorité le plus élevé n\'est pas défini.<br />Ceci est utilisé par le plugin pour identifier la priorité la plus élevée lors de la comparaison de tickets.';
$l['helpcenter_addpriority_format'] = 'Format';
$l['helpcenter_addpriority_format_desc'] = 'Entrez un format d\'affichage pour cette priorité. Par exemple. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_added'] = 'Une nouvelle priorité a été ajoutée avec succès.';

// Priorities - Edit
$l['helpcenter_editpriority'] = 'Modifier la priorité';
$l['helpcenter_editpriority_name'] = 'prénom';
$l['helpcenter_editpriority_name_desc'] = 'Entrez le nom de la priorité.';
$l['helpcenter_editpriority_description'] = 'La description';
$l['helpcenter_editpriority_description_desc'] = 'Entrez une description pour cette priorité.';
$l['helpcenter_editpriority_level'] = 'Niveau';
$l['helpcenter_editpriority_level_desc'] = 'Entrez un niveau pour cette priorité. Habituellement, 1 est le niveau de priorité le plus bas. Le niveau de priorité le plus élevé n\'est pas défini.<br />Ceci est utilisé par le plugin pour identifier la priorité la plus élevée lors de la comparaison de tickets.';
$l['helpcenter_editpriority_format'] = 'Format';
$l['helpcenter_editpriority_format_desc'] = 'Entrez un format d\'affichage pour cette priorité. Par exemple. <span style="color: #FFFFFF;">{priority}</span>';
$l['helpcenter_priority_edited'] = 'La priorité sélectionnée a été modifiée avec succès.';

// Priorities - Delete
$l['helpcenter_priority_deleted'] = 'La priorité sélectionnée a été supprimée avec succès.';
$l['helpcenter_confirm_deletepriority'] = 'Êtes-vous sûr de vouloir supprimer la priorité sélectionnée?';

// Help Categories - Add
$l['helpcenter_addcategory'] = 'ajouter une catégorie';
$l['helpcenter_addcategory_name'] = 'prénom';
$l['helpcenter_addcategory_name_desc'] = 'Entrez le nom de la catégorie.';
$l['helpcenter_addcategory_description'] = 'La description';
$l['helpcenter_addcategory_description_desc'] = 'Entrez une description pour cette catégorie.';
$l['helpcenter_category_added'] = 'Une nouvelle catégorie a été ajoutée avec succès.';

// Help Categories - Edit
$l['helpcenter_editcategory'] = 'Modifier la catégorie';
$l['helpcenter_editcategory_name'] = 'prénom';
$l['helpcenter_editcategory_name_desc'] = 'Entrez le nom de la catégorie.';
$l['helpcenter_editcategory_description'] = 'La description';
$l['helpcenter_editcategory_description_desc'] = 'Entrez une description pour cette catégorie.';
$l['helpcenter_category_edited'] = 'La catégorie sélectionnée a été modifiée avec succès.';

// Help Categories - Delete
$l['helpcenter_category_deleted'] = 'La catégorie sélectionnée a été supprimée avec succès.';
$l['helpcenter_confirm_deletecategory'] = 'Êtes-vous sûr de vouloir supprimer la catégorie sélectionnée? Tous les documents de cette catégorie seront également supprimés et ce processus NE PEUT PAS être annulé!';

// Ticket Categories - Add
$l['helpcenter_addticketcategory'] = 'ajouter une catégorie';
$l['helpcenter_addticketcategory_name'] = 'prénom';
$l['helpcenter_addticketcategory_name_desc'] = 'Entrez le nom de la catégorie.';
$l['helpcenter_addticketcategory_description'] = 'La description';
$l['helpcenter_addticketcategory_description_desc'] = 'Entrez une description pour cette catégorie.';
$l['helpcenter_ticketcategory_added'] = 'Une nouvelle catégorie a été ajoutée avec succès.';

// Ticket Categories - Edit
$l['helpcenter_editticketcategory'] = 'Modifier la catégorie';
$l['helpcenter_editticketcategory_name'] = 'prénom';
$l['helpcenter_editticketcategory_name_desc'] = 'Entrez le nom de la catégorie.';
$l['helpcenter_editticketcategory_description'] = 'La description';
$l['helpcenter_editticketcategory_description_desc'] = 'Entrez une description pour cette catégorie.';
$l['helpcenter_ticketcategory_edited'] = 'La catégorie sélectionnée a été modifiée avec succès.';

// Ticket Categories - Delete
$l['helpcenter_ticketcategory_deleted'] = 'La catégorie sélectionnée a été supprimée avec succès.';
$l['helpcenter_confirm_deleteticketcategory'] = 'Êtes-vous sûr de vouloir supprimer la catégorie sélectionnée? Tous les billets de cette catégorie seront également supprimés et ce processus NE PEUT PAS être annulé!';

// Ticket Category - Cid
$l['helpcenter_ticket_category'] = 'Categorie';

?>