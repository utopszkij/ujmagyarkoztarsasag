<?php
/**
 * @version SVN: $Id: mod_#module#.php 122 2012-10-04 15:07:57Z michel $
 * @package    ##Module##
 * @subpackage Base
 * @author     ##author##
 * @license    ##license##
 */

defined('_JEXEC') or die('Restricted access'); // no direct access

require_once __DIR__ . '/helper.php';
$item = mod##Module##Helper::getItem($params);
require(JModuleHelper::getLayoutPath('mod_##module##'));
require_once ('helper.php');

?>