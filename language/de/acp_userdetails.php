<?php
/**
*
* @package User Details Extension
* @copyright (c) 2020 david63
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
	$lang = [];
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
// ’ » « “ ” …
//

$lang = array_merge($lang, array(
	'ACP_USER_DETAILS'			=> 'User details',
	'ALL'						=> 'Alle',

	'CLEAR_FILTER'				=> ' Filter zurücksetzen ',

	'DEFAULT_STYLE'				=> '<strong>** %1$s **</strong>',

	'ERROR_EXPLAIN'				=> '<strong>Hinweis:</strong> Alle Attribute, die von “<strong>**</strong>” umgeben sind, bedeuten, dass dieses Detail für den Benutzer in der Datenbank fehlt, oder ungültig ist.',

	'FILTER_BY'					=> 'Filtern nach',

	'HASH'						=> '#',

	'NO_ATTRIBUTES_SELECTED'	=> 'Keine Attribute ausgewählt',
	'NO_DATA'					=> 'Die Anfrage hat keine Daten zur Ausgabe bereitgestellt',
	'NO_GROUP'					=> '<strong>** Keine Gruppe **</strong>',
	'NO_VISIT'					=> 'Niemals besucht',

	'OTHER'						=> 'Andere',

	'TOTAL_USERS'				=> 'Gesamte Benutzer',

	'UD_BACK'					=> ' « Zurück zur Auswahl ',
	'UD_GO'						=> ' Sortierung/Filter ',
	'USER_ALLOW_PM'				=> 'Erlaubt PN',
	'USER_ALLOW_VIEWONLINE'		=> 'Online sehen',
	'USER_ALLOW_VIEWEMAIL'		=> 'Email sehen',
	'USER_ALLOW_MASSEMAIL'		=> 'Massenmail',
	'USER_AOL'					=> 'AOL',
	'USER_AVATAR'				=> 'Avatar',
	'USER_AVATAR_TYPE'			=> 'Avatartyp',
	'USER_BIRTHDAY'				=> 'Geburtstag',
	'USER_DATE_FORMAT'			=> 'Datumsformat',
	'USER_DETAILS_DISPLAY'		=> 'Dies ist die Anzeige der Benutzerattribute, die du ausgewählt hast.',
	'USER_EMAIL'				=> 'Email',
	'USER_EMAILTIME'			=> 'Emailzeit',
	'USER_GROUP'				=> 'Gruppe',
	'USER_ID'					=> 'Benutzer-ID',
	'USER_INACTIVE_REASON'		=> 'Grund Inaktivität',
	'USER_INACTIVE_TIME'		=> 'Zeit Inaktivität',
	'USER_IP'					=> 'Benutzer-IP (Reg)',
	'USER_JABBER'				=> 'Jabber',
	'USER_LANG'					=> 'Sprache',
	'USER_LASTMARK'				=> 'Letzte Markierung',
	'USER_LAST_PAGE'			=> 'Letzte Seite',
	'USER_LAST_PRIVMSG'			=> 'Letzte private Nachricht',
	'USER_LAST_SEARCH'			=> 'Letzte Suche',
	'USER_LAST_WARNING'			=> 'Letzte Verwarnung',
	'USER_LASTPOST_TIME'		=> 'Zeit letzter Beitrag',
	'USER_LASTVISIT'			=> 'Letzter Besuch',
	'USER_LOGIN_ATTEMPTS'		=> 'Login-Versuche',
	'USER_NEW_PRIVMSG'			=> 'Neue private Nachrichten',
	'USER_NOTIFY'				=> 'Benachrichtigung Beitrag',
	'USER_NOTIFY_PM'			=> 'Benachrichtigung PN',
	'USER_NOTIFY_TYPE'			=> 'Benachrichtigungstyp',
	'USER_PASS_CHANGE'			=> 'Passwortänderung',
	'USER_POSTS'				=> 'Beiträge',
	'USER_RANK'					=> 'Rang',
	'USER_REGDATE'				=> 'Reg-Datum',
	'USER_SIG'					=> 'Signatur',
	'USER_STYLE'				=> 'Style',
	'USER_TIMEZONE'				=> 'Zeitzone',
	'USER_TYPE'					=> 'Benutzertyp',
	'USER_UNREAD_PRIVMSG'		=> 'Ungelesene private Nachrichten',
	'USER_WARNINGS'				=> 'Verwarnungen',

	// Translators - set these to whatever is most appropriate in your language
	// These are used to populate the filter keys
	'START_CHARACTER'	=> 'A',
	'END_CHARACTER'		=> 'Z',

	'avatar_type' => array(
		AVATAR_UPLOAD				=> 'Hochgeladenes Avatar',
		AVATAR_REMOTE				=> 'Remote-Avatar',
		AVATAR_GALLERY				=> 'Galerie-Avatar',
		'avatar.driver.gravatar'	=> 'Gravatar',
	),

	'inactive_type' => array(
		INACTIVE_REGISTER	=> 'Neu registriertes Konto',
		INACTIVE_PROFILE	=> 'Profildetails geändert',
		INACTIVE_MANUAL		=> 'Account deaktiviert durch Administrator',
		INACTIVE_REMIND		=> 'Account Reaktivierung erzwungen',
	),

	'month_types' => array(
		'1'  => 'Januar',
		'2'  => 'Februar',
		'3'  => 'März',
		'4'  => 'April',
		'5'  => 'Mai',
		'6'  => 'Juni',
		'7'  => 'Juli',
		'8'  => 'August',
		'9'  => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Dezember',
	),

	'notify_type' => array(
		NOTIFY_EMAIL	=> 'Email',
		NOTIFY_IM		=> 'Jabber',
		NOTIFY_BOTH		=> 'Email & Jabber',
	),

	'user_type' => array(
		USER_NORMAL 	=> 'Normal',
		USER_INACTIVE	=> 'Inaktiv',
		USER_IGNORE 	=> 'Ignoriert',
		USER_FOUNDER 	=> 'Gründer',
	),
));
