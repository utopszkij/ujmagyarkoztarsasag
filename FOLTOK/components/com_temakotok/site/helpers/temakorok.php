<?php
/**
 * @version		$Id: #component#.php 125 2012-10-09 11:09:48Z michel $
 * @package		Joomla.Framework
 * @subpackage	temakorok
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
class TemakorokHelper {
  /**
   * the user is admin?
   * @param JUser $user
   * @return boolean      
   */    
  public function isAdmin($user=false)	{
		jimport( 'joomla.user.helper' );
		if ($user == false) $user = JFactory::getUser();
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
}
?>