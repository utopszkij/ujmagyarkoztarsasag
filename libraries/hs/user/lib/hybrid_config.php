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
 */

defined('_JEXEC') or die;

/**
 * Users Route Helper
 *
 * @package     Joomla.Site
 * @subpackage  com_hs_users
 */
class HsUserHybridConfig
{
	
	static $config = null;
	
	static $params = null;
	
	static $activeProviders = null;
	
	
	
	static $base_url = null;
	
	
	static $providers = array( "Facebook", "Twitter",  "Google", "Yahoo", "OpenID", "AOL", 'Live', 'MySpace','Foursquare','LinkedIn');
	
	static $debug = true;
	
	
	/**
	 * Get Config
	 * 
	 * 
	 */
	static function getConfig(){
		if(empty(self::$config)){
			$params = self::_getParams();
			
			$config = array();
			
			//providers
			$config['providers'] = array();
			foreach(self::$providers as $provider){
				$config['providers'][$provider] = array();
				$lowerName = strtolower($provider);
				$config['providers'][$provider]['enabled'] = (int)$params->get('enable_'.$lowerName, 0);
				

				if($config['providers'][$provider]['enabled']===1){
					
					//parse to boolean
					$config['providers'][$provider]['enabled']= true;
					
					
					$secret = $params->get('appsecret_'.$lowerName, 0);
					if(isset($secret)){
						$config['providers'][$provider]['keys'] = array(
							'id'=>null, 'secret'=>null
						);							
						$config['providers'][$provider]['keys']['id'] = $params->get('appid_'.$lowerName, 0);
						$config['providers'][$provider]['keys']['key'] = $params->get('appkey_'.$lowerName, 0);
						$config['providers'][$provider]['keys']['secret'] = $params->get('appsecret_'.$lowerName, 0);	
						
						
						//Specific parameters
						//for google
						if($provider=='Google'){
							/*
							$config['providers'][$provider]['access_type'] = 'online';
							$config['providers'][$provider]['approval_prompt'] = 'force';
							*/
						}					
					}

				}
				

			}	
			
			//base path			
			//$config['base_url']	= JUri::base().'index.php?option=com_hs_users&task=authentications.endpoint';	
			$config['base_url']	= JRoute::_('index.php?option=com_hs_users&task=authentications.endpoint',false,-1);
			
			//debug
			$debug = (int)$params->get('debug', 0);	
			if($debug===1){
				
				$config['debug_mode']	= true;	
				$config['debug_file']	=  JPATH_SITE.$params->get('debug_file');	
				
			}else{
				$config['debug_mode'] = false;
			}
			
			self::$config = $config;
		}	
			

		return self::$config;
	}	
	
	
	
	/**
	 * Get params
	 * 
	 *  
	 */
	static function _getParams(){
		if(empty(self::$params)){
			self::$params = JComponentHelper::getParams('com_hs_users');
		}
		
		return self::$params;
	}
	
	
	
	/**
	 * Get enabled providers
	 * 
	 * @param string lowercase, uppercase, raw 
	 * @return array Providers
	 */
	static function getActiveProviders($format='lowercase'){
		if(self::$activeProviders===null){
			$activeProviders = array();
			$config = self::getConfig();
			foreach($config['providers'] as $name=>$row){
				if($row['enabled']===true){
					$activeProviders[] = $name;
				}
			}	
		
			self::$activeProviders = $activeProviders;		
		}
		
		
		
		if($format==='raw'){
			return self::$activeProviders;
		}		
		
		
		$arr = array();
		if($format==='lowercase'){
			foreach(self::$activeProviders as $provider){
				$arr[] = strtolower($provider);
			}			
		}else{
			foreach(self::$activeProviders as $provider){
				$arr[] = strtoupper($provider);
			}			
		}

		
		
		return $arr;
	}
}