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
// ’ » “ ” …
//


$lang = array_merge($lang, [
	'CLICK_DONATE' 				=> 'Klicke hier, um zu spenden',
	'DONATE'					=> 'Spende',
	'DONATE_EXTENSIONS'			=> 'Spende für meine Erweiterungen',
	'DONATE_EXTENSIONS_EXPLAIN'	=> 'Diese Extension ist, wie alle meine Extensionen, vollständig kostenlos. Wenn du von der Nutzung profitiert hast, dann denke bitte über eine Spende nach, die du mittels einem Klick auf den PayPal-Button durchführen könntest, oder verwende das nebenstehende QR-Bild „Scannen, Bezahlen, Loslegen (Scan, Pay, Go)“ - ich würde mich freuen. Ich verspreche, dass es keinen Spam oder Anfragen für künftige Spenden geben wird, auch wenn solche jederzeit willkommen sind.',

	'NEW_VERSION'				=> 'Neue Version - %s',
	'NEW_VERSION_EXPLAIN'		=> 'Version %1$s dieser Erweiterung ist nun zum Download verfügbar.<br>%2$s',
	'NEW_VERSION_LINK'			=> 'Download hier',
	'NO_JS' 					=> 'Scheinbar hast du Javascript deaktiviert.<br>Bitte <a href="https://enablejavascript.co/">aktiviere</a> es in deinem Browser, it in your browser um alle Funktionen dieser Seite nutzen zu können.',	
	'NO_VERSION_EXPLAIN'		=> 'Versionsupdate Information ist nicht verfügbar.',

	'PAYPAL_BUTTON'				=> 'Spende mit PayPal-Button',
	'PAYPAL_TITLE'				=> 'PayPal - einfach und sicher online bezahlen',
	'PHP_NOT_VALID' 			=> 'Deine PHP-Version ist nicht kompatibel mit dieser Erweiterung.',
	'PHPBB_NOT_VALID' 			=> 'Deine phpBB-Version ist nicht kompatibel mit dieser Erweiterung.',	

	'SAVE'						=> 'Speichern',
	'SAVE_CHANGES'				=> 'Änderungen speichern',	

	'VERSION'					=> 'Version',
]);
