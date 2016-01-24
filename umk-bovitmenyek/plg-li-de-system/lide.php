<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.plugin.plugin' );
 
/**
 * Example system plugin
 */
class plgSystemLide extends JPlugin
{
/**
* Constructor.
*
* @access protected
* @param object $subject The object to observe
* @param array   $config  An array that holds the plugin configuration
* @since 1.0
*/
public function __construct( &$subject, $config )
{
parent::__construct( $subject, $config );
 
// Do some extra initialisation in this constructor if required
}
 
/**
* Do something onAfterInitialise
*/
function onAfterInitialise()
{
}
 
/**
* Do something onAfterRoute
*/
function onAfterRoute()
{
		if (JRequest::getVar('option') == '') {
			$w = explode('/',$_SERVER['REQUEST_URI']);
			$i = 0;
			while ($i < count($w)) {
				if ($w[$i] == 'SU') {
					JRequest::setVar('option','com_'.$w[$i+1]);
					JRequest::setVar('view',$w[$i+2]);
					JRequest::setVar('task',$w[$i+3]);
					JRequest::setVar('temakor',$w[$i+4]);
					JRequest::setVar('szavazas',$w[$i+5]);
					JRequest::setVar('limit',$w[$i+6]);
					JRequest::setVar('limitstart',$w[$i+7]);
					JRequest::setVar('order',$w[$i+8]);
					JRequest::setVar('filterStr',urldecode($w[$i+9]));
					$i = count($w); // kilép a ciklusból 	
				}
				$i = $i + 1;
			}
		}
		return true;
 
}
 
/**
* Do something onAfterDispatch
*/
function onAfterDispatch()
{
}
 
/**
* Do something onAfterRender
*/
function onAfterRender()
{
}
}

