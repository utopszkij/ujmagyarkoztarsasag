<?php

/**
 * 
 * The author is Hayato Sugimoto. https://hs-shelf.com
 * 
 * @version		1.0.2
 * @package 	pkg_hs_users
 * @subpackage  lib_hs
 * @copyright   Copyright (C) 2012 Hayato Sugimoto. All rights reserved.
 * @license     GNU / GPL version 2 or later
 *  
 * FT 2014.11.21 próbáljunk a #__users_authentications -ból image url-t olvasni
 *       
 */
defined('_JEXEC') or die;


/**
 * HsUser Base Class
 *
 * @package     Joomla.Site
 * @subpackage  lib_hs
 * @since       1.6
 */
class HsUser extends JObject
{
	
	static $instances = array();
	
	
	static $_onceLoaded = false;
	
	
	//protected $user =null;
	
	
	protected $_db = null;
	
	
	
	public $db_exid = null;
	
	
	/**
	 * Return Image Tag. Return null if it doesn't exist
	 * 
	 */
	public $image = null;
	
	
	/**
	 * 
	 * 
	 */
	public $imageName = null;
	
	
	public $imageRawName = null;	
	
	
	public $imageFolder = null;
	
	
	public $imagePath = null;
	
	//protected $imageTag = null;

	
	
	public $description = null;
	
	
	
	/**
	 * Constructor activating the default information of the language
	 *
	 * @param   integer  $identifier  The primary key of the user to load (optional).
	 *
	 * @since   11.1
	 */
	public function __construct($identifier = 0)
	{
		// Create the user parameters object
		$this->_params = new JRegistry;


		$user = JFactory::getUser($identifier);
		$vars = get_object_vars ($user);
		
		foreach($vars as $name=>$value){
			$this->set($name, $value);
		}

		

		// Load the user if it exists

		if (!$user->guest)
		{
			$this->load($identifier);
		}else{
			//default data
		}
	}
	
	
		
	/**
	 * Returns the global HsUser object, only creating it if it
	 * doesn't already exist.
	 *
	 * @param   integer  $identifier  The user to load - Can be an integer or string - If string, it is converted to ID automatically.
	 *
	 * @return  HsUser object with JUser's properties.
	 *
	 * @since   11.1
	 */
	static public function getInstance($identifier = 0)
	{
		
		if(self::$_onceLoaded===false){
			self::_onceLoader();
		}
		
		if($identifier===0){
			$user = JFactory::getUser();
			$identifier = $user->get('id');
		}
		
		
		if(empty(self::$instances[$identifier])){
			self::$instances[$identifier] = new HsUser($identifier);
		}
		
		
		
		return self::$instances[$identifier];	
	}	

	
	static function _onceLoader(){
			
		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_hs_users/tables');
		
		require_once JPATH_SITE.'/components/com_hs_users/defs.php';
		
		self::$_onceLoaded = true;
	}
	
	
	
	/**
	 * Method to load a JUser object by user id number
	 *
	 * @param   mixed  $id  The user id of the user to load
	 *
	 * @return  boolean  True on success
	 *
	 * @since   11.1
	 */
	public function load($id)
	{		
		// Create the user table object
		//$tableEx = $this->getTable();
		//
		$db = $this->_getDbo();
		$query = $db->getQuery(true);
		$query->select('id AS db_exid, image_folder, image_name,image_raw_name,created_at,modified_at,description');
		$query->from('#__users_extended');
		$query->where('user_id='.$db->quote($id));
		$db->setQuery($query,0,1);
		$r = $db->loadObject();
		// Load the JUserModel object based on the user id or throw a warning.
		if (empty($r))
		{
			//no ex data
			$this->db_exid = null;
			$this->image = null;
			$this->imageName = null;
			$this->imageRawName = null;
			$this->imageFolder = null;
			$this->imagePath  = null;
			$this->description = null;
			//FT 2014.11.21. return;
		}
		$this->db_exid = (int)$r->db_exid;		
		$this->description = $r->description;
		if(mb_strlen($r->image_folder)>0&&mb_strlen($r->image_name)>0){
			$this->imagePath = 'images/hsu/'.$r->image_folder.'/'.$r->image_name;		
		}else{
			$this->imagePath = null;
		}
				
    //+ FT 2014.11.21 próbáljunk a #__users_authentications -ból image url-t olvasni
 		if (($this->imagePath == null) | ($this->imagePath == '')) {
      $db->setQuery('select photo_url
      from #__users_authentications
      where user_id = '.$db->quote($id));
      $res = $db->loadObject();
      if ($res) {
        $this->imagePath = $res->photo_url;
  			$this->imageName = 'social_profile_image';
	  		$this->imageRawName = 'social_profile_image';
		  	$this->imageFolder = 'social_profile';
      }
    } 
    //- FT 2014.11.21 próbáljunk a #__users_authentications -ból image url-t olvasni     
   $this->image = $this->getImageTag();
	}
	
	
	
	
	public function getTable($name="Userextended", $prefix='Hs_usersTable'){
		
		return JTable::getInstance($name, $prefix);
	}
	
	
	
	
	static function getBasePath(){
		if(self::$_onceLoaded===false){
			self::_onceLoader();
		}
		return HS_USER_PATH_USER_IMAGE;
	}	
	
	
	
	/**
	 * 
	 * 
	 * @param $width image width
	 * @param $height image height
	 * @param $noimage return noimage tag if it sets true. otherwise, return null
	 * @param $alt alternative text for img tag
	 * 
	 */
	public function getImageTag($width=50, $height=50, $noimage=true, $alt=null){
		
		if(empty($this->imagePath)){
			if($noimage===false){
				return null;
			}
			
			return $this->getUserNoImage($width,$height,$alt);
		}
		
		
		if($alt===null){
			$alt = 'user image of '.$this->name;
		}
		
		return '<img src="'.$this->imagePath.'" alt="User Image" width="'.$width.'" height="'.$height.'" />'; 
	}
	
	
	
		
	public function getUserNoImage($width=50, $height=50,$alt=null){
		if(empty($alt)){
			$alt = 'No Image Data Of the user';
		}
		
		return '<img src="libraries/hs/user/images/noimage.png" alt="'.$alt.'" width="'.$width.'" height="'.$height.'" />';
	}
	
	
	
	
	
	
	private function _getDbo(){
		if($this->_db===null){
			$this->_db=JFactory::getDbo();
		}
		return $this->_db;
	}
}