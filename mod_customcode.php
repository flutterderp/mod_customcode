<?php
/**
 * Custom Code
 *
 * Parsing/cleaning functions adapted from Flexi Custom Code by RBO Team > Project::: RumahBelanja.com & AppsNity.com.
 * https://extensions.joomla.org/extension/flexi-custom-code/
 *
 * @version 1.0.3
 * @author flutterderp
 * @package Joomla
 * @license GNU General Public License v3.0 or later; see LICENSE
 */

defined('_JEXEC') or die;
require_once(__DIR__ . '/helper.php');

$append_moduleclass = (int) $params->get('append_moduleclass', 1);
$moduleclass_sfx    = $params->get('moduleclass_sfx', '');
$load_plugincontent = (int) $params->get('load_plugincontent', 0);

$customcode      = new Customcode($params);
// Allow included scripts to see options we select in the module admin (e.g. header_tag, header_class, etc.)
$module->config  = $params;
$module->content = $customcode->parseCode($module);

if (!empty($module->content))
{
	require JModuleHelper::getLayoutPath('mod_customcode', $params->get('layout', 'default'));
}
