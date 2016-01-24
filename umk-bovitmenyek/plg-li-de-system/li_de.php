<?php

// No direct access

// system li-de plugin

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemLi_de extends JPlugin
{
	
    /**
     * Constructor.
     *
     * @param object $subject The object to observe
     * @param array $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

	public function onAfterInitialise() {
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
	}
   
}

// globálisan használható saját rutinok

/**
  * távoli szolgáltatás hívás
  * @param string url
  * @param string 'GET' vagy 'POST'
  * @param array data  paraméterek ["név" => "érték",....]
  * @param string extra header sor (elhagyható)
  * @return string
*/
function remoteCall($url,$method,$data,$extraHeader='') {
	$result = '';
	if ($extraHeader != '') {
		$extraHeader .= "\r\n";
	}	
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n".$extraHeader,
			'method'=> $method,
			'content' => http_build_query($data)
	    )
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	return $result;
}


/**
  * get avatar
  * @return string  html img tag
  * @param integer user.id
*/  
function getAvatar($userId) {
	$noImage = 'http://li-de.tk/images/stories/noavatar.jpg';
	if ($userId <= 0) {
		$result = $noImage;
	} else {
		$user = JFactory::getUser($userId);
		if ($user->id <= 0) {
			$result = $noImage;
		} else {
			$result = 'http://www.gravatar.com/avatar/'.md5($user->email).'?s=100&d=blank';
		}
	}
	return '<img src="'.$result.'" />';
}

/**
  * utf8 substr html entity -ket nem vág félbe
*/  
function utf8Substr($str,$start,$length) {
	$s = mb_substr(striptags($str),$start,$length);
	$i = strlen($s) - 1;
	while (($i > strlen($s) - 10) & ($s[$i] != ';')) {
		if ($s[$i] == '&') {
			$s = mb_substr($s,0,$i);
		}
	}
	return $s;
}


