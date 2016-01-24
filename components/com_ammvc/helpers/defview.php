<?php
/**
 * @version		$Id: route.php 125 2012-10-09 11:09:48Z michel $
 * @package		Joomla site
 * @subpackage	amcomponent defview helper
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
 * @subpackage amcomponent defview helper 
 * @subpackage	Helpers

 */
class DefviewHelper {
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
  		$admin_groups = array(); //put all the groups that you consider to be admins
        	$admin_groups[] = "Super Users";
        	$admin_groups[] = "Administrator";
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
   *  @param mixed $item
   *  @param string $mode add|edit|read|list
   *  @param Juser $user
   *  @return boolean
   *  if $mode=='list' $item is mysql_objectList
   *  if $mode=='edit' $item is mysql_objec
   *  if $mode=='add' $item is mysql_objec
   *  if $mode=='show' $item is mysql_objec
   *  if $mode=='save' $item is record_array
   */     
  public function accessRight($item,$mode,$user=false) {
    if ($user==false) $user = JFactory::getUser();
    return true;
  }
}
?>