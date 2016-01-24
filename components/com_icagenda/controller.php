<?php
/**
 *------------------------------------------------------------------------------
 *  iCagenda v3 by Jooml!C - Events Management Extension for Joomla! 2.5 / 3.x
 *------------------------------------------------------------------------------
 * @package     com_icagenda
 * @copyright   Copyright (c)2012-2015 Cyril Rezé, Jooml!C - All rights reserved
 *
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Cyril Rezé (Lyr!C)
 * @link        http://www.joomlic.com
 *
 * @version 	3.5.4 2015-04-11
 * @since       1.0
 *------------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die();

require_once(JPATH_COMPONENT_SITE . '/helpers/iCicons.class.php');

/**
 * Controller class for iCagenda.
 */
class iCagendaController extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = false)
	{
//		$cachable = true;

		$paramsC 	= JComponentHelper::getParams('com_icagenda');
		$cache 		= $paramsC->get('enable_cache', 0);
		$cachable 	= false;

		if ($cache == 1)
		{
			$cachable 	= true;
		}

		$document = JFactory::getDocument();

		$safeurlparams = array(
			'catid' => 'INT',
			'id' => 'INT',
			'cid' => 'ARRAY',
			'year' => 'INT',
			'month' => 'INT',
			'limit' => 'UINT',
			'limitstart' => 'UINT',
			'showall' => 'INT',
			'return' => 'BASE64',
			'filter' => 'STRING',
			'filter_order' => 'CMD',
			'filter_order_Dir' => 'CMD',
			'filter-search' => 'STRING',
			'print' => 'BOOLEAN',
			'lang' => 'CMD',
			'Itemid' => 'INT');

		parent::display($cachable, $safeurlparams);

		return $this;
	}

	public function payment()
	{

// Set base path
JLayoutHelper::$defaultBasePath = JPATH_PLUGINS . '/content/ic_paypal/layouts';

// Render mylayout.php
$renderedLayout = JLayoutHelper::render('payment_test');
echo $renderedLayout;
	}
}
