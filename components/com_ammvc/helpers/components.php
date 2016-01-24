<?php
/**
 * @version		$Id: route.php 125 2012-10-09 11:09:48Z michel $
 * @package		Joomla site
 * @subpackage	amcomponent components helper
 * @copyright	Copyright (C) 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// Component Helper
jimport('joomla.application.component.helper');

/**
 * Alaps Component Route Helper
 *
 * @static
 * @package		Joomla site
 * @subpackage amcomponent components helper 
 * @subpackage	Helpers

 */
class ComponentsHelper {
  /**
   * the user is admin?
   * @param JUser $user
   * @return boolean      
   */    
  protected function isAdmin($user)	{
		jimport( 'joomla.user.helper' );
		$result = false;
    if ($user) {
      $groups = JUserHelper::getUserGroups($user->id);
      //DBG foreach($groups as $fn => $fv) echo '<p>'.$fn.'='.$fv.'</p>'; exit();
  		$admin_groups = array(); //put all the groups that you consider to be admins
      $admin_groups[] = "Super Users";
      $admin_groups[] = "Administrator";
      $admin_groups[] = "8";
  		foreach($admin_groups as $temp)	{
  			if(!empty($groups[$temp])) {
  				$result = true;
  			}
  		}
		}
    return $result;
	}
  /** 
   *  check acces right
   *  @param sqlRecordObject|sqlRecordsObjectArray $item
   *  @param string $mode add|edit|delete|show
   *  @param Juser $user
   *  @return boolean            
   */     
  public function accessRight($item,$mode,$user=false) {
    if ($user==false) $user = JFactory::getUser();
    return ($this->isAdmin($user));
  }
}
?>