<?php
/**
 * @version        $Id: route.php 125 2012-10-09 11:09:48Z michel $
 * @package        Joomla site
 * @subpackage    amcomponent masodik helper
 * @copyright    Copyright (C) 2013 Open Source Matters, Inc. All rights reserved.
 * @license        GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');

/**
 * Alaps Component Route Helper
 *
 * @static
 * @package        Joomla site
 * @subpackage amcomponent masodik helper 
 * @subpackage    Helpers

 */
class MasodikHelper {
  /** 
   *  check acces right
   *  @param mysql_record|mysql_records $item
   *  @param string $mode add|edit|read|list
   *  @param Juser $user
   *  @return boolean            
   */     
  public function accessRight($item,$mode,$user=false) {
    if ($user==false) $user = JFactory::getUser();
    return true;
  }
}
?>