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



jimport('hs.user.lib.hybrid_config');

/**
 * Users Html
 * 
 * 
 * 2013/04/18  Solved cache problem by Riccardo Zorn's idea
 * 
 *
 * @package     Joomla.Site
 * @subpackage  com_hs_users
 * @since       1.6
 */
class HsUserHTML
{
	
	static $_loadLang = false;
	
	static $_loadAssetCSS = false;
	
	static $_loadTokenJs = false;
	
	static $_loadTokenForm = false;
	
	
	static $_loadOpenIdJS = false;
	
	static $_params = null;
	
	static $_linkBase = null;
	
	
	
	static function getLinkBase($task='authentications.authenticatewith'){
		if(self::$_linkBase===null){
			$token = JSession::getFormToken();
			//self::$_linkBase= 'index.php?option=com_hs_users&task='.$task.'&'.$token.'=1';	
			self::$_linkBase= 'index.php?option=com_hs_users&task='.$task;		
			
			//add return URL
			//$returnURL = JRequest::getVar('return',null);
			//if($returnURL!==null){
			//	self::$_linkBase .= '&return='.$returnURL;
			//}
		}
		
		return self::$_linkBase;
	}
	
	
	/**
	 * Get social list
	 * 
	 * 
	 */
	static function getSocialList($task='authentications.authenticatewith', $returnURL=null){
		$providers = HsUserHybridConfig::getActiveProviders();
		
		self::loadLanguage();
		self::loadAssetCSS();
		self::loadTokenJs();
		
		//$token = JSession::getFormToken();
		$linkBase = self::getLinkBase($task);
		
		$lis = array();
		
		$includedOpenId = false;
		
		
		//check return url setting
		$returnURL = self::getReturnUrl($returnURL);
		
		
		
		foreach($providers as $provider){
			$lowerName = strtolower($provider);
			if($provider==='openid'){
				$includedOpenId = true;
			}
			$lis[] = '<li class="socials '.$lowerName.'">'
						.'<a class="hbox hs_token_target" href="'.self::getLinkOf($lowerName, $returnURL).'" alt="'.$provider.'">' 
							.'<span class="icon"></span>'
							.'<span class="name">'.JText::_('COM_HS_USERS_SIGNIN_WITH_'.strtoupper($provider)).'</span>'
						.'</a></li>';
		}
		
		
		
		if($includedOpenId===true){
			self::loadOpenIdJS();
		}
		
		return '<ul class="hs_social_list">'.implode('', $lis).'</ul>'.self::getTokenForm();
	}
	
	/**
	 * Get a url link of $provider
	 * 
	 * a class name of 'hs_token_target' must be added to the element and 
	 * must call self::loadTokenJs() to add token to the link.
	 * 
	 * 
	 * @param String $provider social service name
	 * @param String $returnURL Raw URL of landing page. If the value is 'home', then the top page url is used.
	 * @return String parsed url
	 * 
	 */	
	static function getLinkOf($provider, $returnURL=null){
		$link = self::getLinkBase().'&provider='.strtolower($provider);
		
		if($returnURL!=null){
			if($returnURL=='home'){
				$returnURL = JUri::base();
			}
			switch($returnURL){
				case 'home':
					$returnURL = JUri::base();
					break;
				case 'current':
					$returnURL = JUri::current();
					break; 
			}		
				
			$link = $link.'&return='.base64_encode($returnURL);
		}
		
		return JRoute::_($link);
	}
	
	
	/**
	 * Load language file
	 * 
	 * 
	 */
	static function loadLanguage(){
		if(!self::$_loadLang){
			$language = JFactory::getLanguage();
			$r = $language->load('com_hs_users');
			
			self::$_loadLang = true;
		}
	}
	
	/**
	 * Load css file
	 * 
	 * 
	 */
	static function loadAssetCSS(){
		if(!self::$_loadAssetCSS){
			$doc = JFactory::getDocument();
			$doc->addStyleSheet('components/com_hs_users/asset/css/asset.css');
			
			
			self::$_loadAssetCSS = true;
		}
	}	
	
	
	/**
	 * Load a javascript to add a token to a link
	 * 
	 * 
	 */
	static function loadTokenJs(){
		if(!self::$_loadTokenJs){
			$doc = JFactory::getDocument();
			$doc->addScript('components/com_hs_users/asset/js/formtoken.js');
			
			self::$_loadTokenJs = true;			
		}
	}
	
	
	static function loadOpenIdJS(){
		if(!self::$_loadOpenIdJS){
			$doc = JFactory::getDocument();
			$doc->addScript('components/com_hs_users/asset/js/openid.js');
			
			$urlTitle = JText::_('COM_HS_USERS_HTML_OPENID_ENTER_TITLE');
			$btnSubmit = JText::_('COM_HS_USERS_HTML_OPENID_SUBMIT_DATA');
			$errorMissedField = JText::_('COM_HS_USERS_HTML_OPENID_ERROR_MISSED_FIELD');
$js=<<<EOF
window.addEvent('domready',function(){
	new HSJS.coms.users.openid({
		language:{
			enterUrlTitle:'$urlTitle',
			btnSubmit:'$btnSubmit',
			errorMissedField:'$errorMissedField'			
		}
	});
});
EOF;
			$doc->addScriptDeclaration($js);
			
			self::$_loadOpenIdJS = true;
		}
	}		
	
	
	/**
	 * 
	 * 
	 */
	static function getTokenForm(){
		if(self::$_loadTokenForm==true){
			return;
		}
		
		self::$_loadTokenForm=true;
		
		return'<div id="hs_social_token_form">'
				.JHTML::_( 'form.token' ).
				'</div>';
	}
	
	
	/**
	 * generate rturn url
	 * 
	 */
	static function getReturnUrl($url){
		if($url==null){
			$params = self::_getParams();
			$url = trim($params->get('redirect_url_after_login', null));			
		}

		if($url==null||mb_strlen($url)<1){
			return null;
		}
		
		
		return $url;
	}
	
	
	
	static function _getParams(){
		if(empty(self::$_params)){
			self::$_params = JComponentHelper::getParams('com_hs_users');
		}
		
		return self::$_params;
	}		
}