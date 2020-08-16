<?php
/**
*
* @package User Details Extension
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'USER_DETAILS_SELECT'			=> '&bull;&nbsp;Hier kannst du die Benutzerdetails auswählen, die du anzeigen möchtest. <br>&bull;&nbsp;Sei dir dessen bewusst, dass eine größere Anzahl ausgewählter Attribute möglicherweise nicht auf die Seite passt, und die Darstellung daher nicht korrekt ist (abhängig von der Breite deiner Browserseite).',

	'ATTRIBUTE'						=> 'Attribute',
	'ATTRIBUTE_EXPLAIN'				=> 'Beschreibung Attribute',
	'SIZE'							=> 'Attribute Spaltengröße',
	'CAN_FILTER'					=> 'Kann filtern',
	'CLEAR_ATTRIB'					=> 'Attributauswahl zurücksetzen',
	'CSV'							=> 'CSV Export',

	'USER_ALLOW_PM_EXPLAIN'			=> 'Erlaubt anderen Benutzern, diesem Benutzer eine private Nachricht zu senden.',
	'USER_ALLOW_VIEWONLINE_EXPLAIN'	=> 'Versteckt der Benutzer seinen Online-Status?',
	'USER_ALLOW_VIEWEMAIL_EXPLAIN'	=> 'Kann ein Benutzer diesen Benutzer per Email kontaktieren?',
	'USER_ALLOW_MASSEMAIL_EXPLAIN'	=> 'Kann der Benutzer vom Administrator per Massenmail kontaktiert werden?',
	'USER_AOL_EXPLAIN'				=> 'Die AOL Addresse des Benutzers.',
	'USER_AVATAR_EXPLAIN'			=> 'Zeigt das Avatar des Benutzers an.',
	'USER_AVATAR_TYPE_EXPLAIN'		=> 'Avatartyp des Benutzers.',
	'USER_BIRTHDAY_EXPLAIN'			=> 'Geburtsdatum und Alter des Benutzers, wenn eingegeben.',
	'USER_DATE_FORMAT_EXPLAIN'		=> 'Das Format, in dem der Benutzer Datum und Zeit sieht.',
	'USER_EMAIL_EXPLAIN'			=> 'Emailadresse des Benutzers.',
	'USER_EMAILTIME_EXPLAIN'		=> 'Datum und Zeit der letzten Email des Benutzers.',
	'USER_GROUP_EXPLAIN'			=> 'Standardgruppe des Benutzers.',
	'USER_ID_EXPLAIN'				=> 'ID des Benutzers auf diesem Board.',
	'USER_INACTIVE_REASON_EXPLAIN'	=> 'Der Grund, warum das Konto des Benutzers inaktiv ist.',
	'USER_INACTIVE_TIME_EXPLAIN'	=> 'Datum und Zeit, wann das Benutzerkonto inaktiv wurde.',
	'USER_IP_EXPLAIN'				=> 'Benutzer-IP während der Registrierung auf diesem Board.',
	'USER_JABBER_EXPLAIN'			=> 'Jabber-Adresse dieses Benutzers.',
	'USER_LANG_EXPLAIN'				=> 'Spracheinstellung dieses Benutzers.',
	'USER_LASTMARK_EXPLAIN'			=> 'Das letzte Mal, wann der Benutzer alle Foren als gelesen markiert hat.',
	'USER_LAST_PAGE_EXPLAIN'		=> 'Die letzte Seite, die der Benutzer besucht hat.',
	'USER_LAST_PRIVMSG_EXPLAIN'		=> 'Datum und Zeit der letzten privaten Nachricht des Benutzers.',
	'USER_LAST_SEARCH_EXPLAIN'		=> 'Datum und Zeit, wann der Benutzer zuletzt die Suche benutzt hat.',
	'USER_LAST_WARNING_EXPLAIN'		=> 'Das Datum, wann der Benutzer zuletzt eine Verwarnung erhalten hat.',
	'USER_LASTPOST_TIME_EXPLAIN'	=> 'Datum und Zeit, wann der Benutzer zuletzt auf diesem Board einen Beitrag erstellt hat.',
	'USER_LASTVISIT_EXPLAIN'		=> 'Datum und Zeit des letzten Besuchs auf diesem Board von diesem Benutzer.',
	'USER_LOGIN_ATTEMPTS_EXPLAIN'	=> 'Die Anzahl fehlgeschlagener Anmeldeversuche dieses Benutzers.',
	'USER_NEW_PRIVMSG_EXPLAIN'		=> 'Die Anzahl neuer privater Nachrichten, die der Benutzer derzeit hat.',
	'USER_NOTIFY_EXPLAIN'			=> 'Empfängt der Benutzer Benachrichtigungen über neue Beiträge für Foren, die er abonniert hat?',
	'USER_NOTIFY_PM_EXPLAIN'		=> 'Empfängt der Benutzer Benachrichtigungen über private Nachrichten?',
	'USER_NOTIFY_TYPE_EXPLAIN'		=> 'Welchen Typ von Benachrichtigungen empfängt der Benutzer?',
	'USER_PASS_CHANGE_EXPLAIN'		=> 'Das Datum, an dem das Kennwort des Benutzers geändert werden soll.',
	'USER_POSTS_EXPLAIN'			=> 'Die Anzahl der Beiträge, die der Benutzer in diesem Board erstellt hat.',
	'USER_RANK_EXPLAIN'				=> 'Der Rang des Benutzers.',
	'USER_REGDATE_EXPLAIN'			=> 'Das Datum, wann der Benutzer sich in diesem Board registriert hat.',
	'USER_SIG_EXPLAIN'				=> 'Zeigt die Benutzersignatur an.',
	'USER_STYLE_EXPLAIN'			=> 'Der eingestellte Style des Benutzers.<br>Hinweis: Dies mag nicht der Style sein, den der Benutzer wirklich sieht - das hängt davon ab, ob womöglich das Überschreiben des Boardstyles vom Administrator boardweit eingestellt worden ist.',
	'USER_TIMEZONE_EXPLAIN'			=> 'Die Zeitzone des Benutzers.',
	'USER_TYPE_EXPLAIN'				=> 'Der Benutzertyp.',
	'USER_UNREAD_PRIVMSG_EXPLAIN'	=> 'Die Anzahl ungelesener privater Nachrichten, die der Benutzer derzeit hat.',
	'USER_WARNINGS_EXPLAIN'			=> 'Die Anzahl an Verwarnungen, die dem Benutzer erteilt wurden.',
));
