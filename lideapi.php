<?php
/**
 * JavaScipt API
 * =============
 * li-de AJAX request server 
 * this file must in li-de joomla site root path.
 *
 * call this servis in client side:
 *
 * in Joomla: "JHtml::_('jquery.framework', false);"
 * jQuery.support.cors = true;
 * $.ajax({
 *     url: "http://..../lideapi.php",
 *     data: "{ ....... }",
 *     timeout: 30000,
 *     dataType: "txt", 
 *     success: function(data) {
 *       process data	 
 *     },
 *     error: function(jqXHR, textStatus, ex) {
 *       process error	 
 *     }
 * });
 * input and output data structure:
 * {"task":"login", "usr":"....", "psw":"..."} --> }"api_status":"OK"}
 *                                                 {"api_staus":"error acces voiolation"}
 * {"task":"logout"}  --> {"status":"OK"}
 * {"task":"getPoll","poll_id":"..."}  --> {"api_status":"OK", szavazas'fields...,"alternatives":[{alternative' fields},....]}
 *                                         {"api_staus":"error poll not found"}
 * ("task":"getSimpleResult","poll_id":"...")  --> {"api_status":"OK", "voters":"...", 
 *                                                  "result:[{"alernativa_id":"...","megnevezes"."firstPosCoont":"..."},...]}
 *                                                 {"api_staus":"error poll not found"}
 * {"task":"setSimpleVoks","poll_id","alt_id","voter_id":"..."}  --> {"api_status":"OK"}
 *                                                                   {"api_staus":"error poll not found"}
 *                                                                   {"api_staus":"error poll status is wrong"}
 *                                                                   {"api_staus":"error this voter alredy voted"}
 *                                            set selected alertative is 1. position, another alernatives in 99. position
 * ("task":"getResult","poll_id":"...")  --> {"api_status":"OK", "result":[{....},{...}...]}
 *                                           {"api_staus":"error poll not found"}
 * {"task":"setVoks","poll_id":szám,"voter_id":szám,
 *         "voks":[{"alt_id":szám,"position":szám},...]}  --> {"api_status":"OK"}
 *                                                            {"api_staus":"error poll not found"}
 *                                                            {"api_staus":"error poll status is wrong"}
 *                                                            {"api_staus":"error this voter alredy voted"}
 *
 * REST stilusú hivás esetén:  REQUEST_URI:  domain/api/poll/szám és opcionálisan POST alt_id=szám}
 *
 
 
Továbbfejlesztési elképzelés titkositott adatforgalom):
==========================================================

 szimetrikus kulcsos titkositás (AES): 
 http://stackoverflow.com/questions/24337317/encrypt-with-php-decrypt-with-javascript-cryptojs

 aszimetrikus kulcsos titkositás (RSA)
 http://www.codeproject.com/Questions/835484/How-to-encrypt-in-javascript-and-decrypt-in-php-us
 

 1. connect  a server visszaküldi a public_key -t
 2. kliens RSA encoded -en küldi a {usr:xxxx, psw:xxxxx, skey:xxxxxx} (skey egy véletlen szám > 10000)
 3. szerver dekodolja a usr,psw és skey értékeket, ellenörzi, hogy valós login-e?
 4. mint a szerver, mint a kliens képzi az 'szimkey' stringet: substr(usr+psw+skey+usr+psw+skey+usr+psw+skey, 40)
 5. ezentul minden szerver - kliens kommunikáció a 'szimkey' stringgel AES kodolva történik
	
 
 
 
 
*/ 
header("Access-Control-Allow-Origin: *");
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
require_once ( JPATH_BASE .DS.'components'.DS.'com_szavazasok'.DS.'condorcet.php');
JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
jimport('joomla.plugin.helper');
$db = JFactory::getDBO();
$session = JFactory::getSession();
$querystr = $_SERVER['QUERY_STRING'];
if ($querystr != '') {
  $data = JSON_decode(rawurldecode($querystr));
} else {	
  $data = new stdClass(); 
  $data->task = 'getPoll';
  $uriStr = $_SERVER['REQUEST_URI'];
  $w = explode('/',$uriStr);
  for ($i = 0; $i < count($w); $i++) {
	 if ($w[$i] == 'poll') {
		$data->poll_id = $w[$i+1]; 
	 }
	 if ($w[$i] == 'result') {
		$data->task = 'getSimpleResult'; 
	 }
  }
  if (isset($_POST['alt_id']) {
	  $data->task = 'setSimpleVoks';
	  $data->alt_id = $_POST['alt_id'];
  }  
}

if (isset($data->task))
  $task = $data->task;
else
  $task = '';
$result = new stdClass();
$result->api_status = "error invalid task (".$task.")";	 

if ($task == 'login') {
	if (!isset($data->usr)) $data->usr='';
	if (!isset($data->psw)) $data->psw='';
	$credentials = array();
	$credentials['username'] = $data->usr;
	$credentials['password'] = $data->psw;
	$mainframe->login($credentials);
	$logged_user = JFactory::getUser();
    if ($logged_user->id > 0)
	   $result->api_status = "OK ".JSON_encode($logged_user);
    else
	   $result->api_status = "error abc ";
} else if ($task == 'logout') {
	$logged_user = JFactory::getUser();
    if ($logged_user->id > 0)
  	   $mainframe->logout();
	$result = new stdClass();
	$result->api_status= "OK";
} else if ($task == 'opensql') {
	$logged_user = JFactory::getUser();
    if (in_array (8, $logged_user->groups)) {
		$db->setQuery($data->sql);
		try {
		  $res = $db->loadObjectList();
		  if ($db->getErrorNum() == 0) {
			$result->records = $res;	
			$result->api_status= "OK";
		  } else {
			$result->api_status= "error ".$db->getErrorNum().' '.$db->getErrorMsg();
		  }	
		} catch (Exception $e) {
		  $result->api_status="error ".$db->getErrorNum().' '.$db->getErrorMsg();
		}
	} else {
		$result->api_status="error access violation";
	}
} else if ($task == 'execsql') {
	$logged_user = JFactory::getUser();
    if (in_array (8, $logged_user->groups)) {
		$db = JFactory::getDBO();
		$db->setQuery($data->sql);
		try {
		  $res = $db->query();
		  if ($res) {
			$result->api_status= "OK";
		  } else {
			$result->api_status= "error ".$db->getErrorNum().' '.$db->getErrorMsg();
		  }
		} catch (Exception $e) {
		  $result->api_status="error ".$db->getErrorNum().' '.$db->getErrorMsg();
		}
	} else {
		$result->api_status="error access violation";
	}
} else if ($task == 'getPoll') {
	$user = JFactory::getUser();
    $result = new stdClass();
	if (!isset($data->poll_id)) $data->poll_id=0;
	$db->setQuery('select sz.* 
	from #__szavazasok sz
	left outer join #__temakorok t on t.id = sz.temakor_id
	left outer join #__tagok ta on ta.temakor_id = sz.temakor_id
	where sz.id='.$db->quote($data->poll_id).' and
	((ta.user_id = '.$db->quote($user->id).') or (t.lathatosag = 0))
	limit 1');
	$result = $db->loadObject();
	if ($result) {
		$db->setQuery('select * from #__alternativak where szavazas_id='.$db->quote($data->poll_id).' order by id' );
		$result->alternatives = $db->loadObjectList();
		$result->api_status = 'OK';
	} else {
		$result = new stdClass();
		$result->api_status = "error poll not found";
	}
} else if ($task == 'getSimpleResult') {
	// láthatja ezt a szavazást?
	$user = JFactory::getUser();
	$db->setQuery('select sz.* 
	from #__szavazasok sz
	left outer join #__temakorok t on t.id = sz.temakor_id
	left outer join #__tagok ta on ta.temakor_id = sz.temakor_id
	where sz.id='.$db->quote($data->poll_id).' and
	((ta.user_id = '.$db->quote($user->id).') or (t.lathatosag = 0))
	limit 1');
	$res = $db->loadObject();
	if ($res) {
		$result = new stdClass();
		if (!isset($data->poll_id)) $data->poll_id=0;
		$db->setQuery('select sz.alternativa_id, a.megnevezes, sum(if(sz.pozicio=1,1,0)) darab 
		from #__szavazatok sz, #__alternativak a
		where sz.szavazas_id='.$db->quote($data->poll_id).' and a.id = sz.alternativa_id
		group by sz.alternativa_id, a.megnevezes
		order by  3 desc');
		$res = $db->loadObjectList();
		for ($i=0; $i<count($res); $i++) {
			unset($res[$i]->user_id);
		}
		if ($res == false) {
			$result = new stdClass();
			$result->api_status = "error voks not found (getSimpleResult )";
		} else {
		  $result->api_status = 'OK';
		  $result->result = $res;
		  $db->setQuery('select count(distinct szavazo_id) darab
		  from #__szavazatok
		  where szavazas_id='.$db->quote($data->poll_id)
		  );
		  $res = $db->loadObject();
		  $result->voters = $res->darab;
		}
	} else {
		$result = new stdClass();
		$result->api_status = "error poll not found (getSimpleResult )";
	}
} else if ($task == 'setSimpleVoks') {
	$user = JFactory::getUser();
	$db = JFactory::getDBO();
    $result = new stdClass();
	if (!isset($data->poll_id)) $data->poll_id=0;
	if (!isset($data->alt_id)) $data->alt_id=0;
	if (!isset($data->voter_id)) $data->voter_id=time();
	$db->setQuery('select sz.* 
	from #__szavazasok sz
	left outer join #__temakorok t on t.id = sz.temakor_id
	left outer join #__tagok ta on ta.temakor_id = sz.temakor_id
	where sz.id='.$db->quote($data->poll_id).' and
	((ta.user_id = '.$db->quote($user->id).') or (t.lathatosag = 0)) and
	((sz.szavazok = 0) or 
	 (sz.szavazok = 1 and '.$user->id.' > 0) or
	 (ta.user_id = '.$db->quote($user->id).'))
	limit 1');
	$szavazas = $db->loadObject();
	if ($szavazas == false) {
		$result->api_status = "error poll not found (setSimpleVoks) ";
	} else if ($szavazas->szavazas != 1) {
		$result->api_status = "error poll status is wrong";
	} else {
		$szavazo_id = $data->voter_id;
		// ellenörzés; szavazott már?
		$db->setQuery('select * from #__szavazok where user_id='.$db->quote($data->voter_id).' and szavazas_id='.$db->quote($data->poll_id));
		$res = $db->loadObject();
		if ($res == false) {
			$db->setQuery('select * from #__alternativak where szavazas_id='.$db->quote($data->poll_id));
			$res = $db->loadObjectList();
			foreach ($res as $res1) {
				if ($res1->id == $data->alt_id)
					$pozicio = 1;
				else
					$pozicio= 99;
				$db->setQuery(
						 'INSERT INTO #__szavazatok 
							(`id`, 
							`temakor_id`, 
							`szavazas_id`, 
							`szavazo_id`, 
							`user_id`, 
							`alternativa_id`, 
							`pozicio`
							)
							VALUES
							(0, 
							"'.$szavazas->temakor_id.'", 
							"'.$data->poll_id.'", 
							"'.$data->voter_id.'", 
							"'.$user->id.'", 
							"'.$res1->id.'", 
							"'.$pozicio.'"
							);
				');
				$db->query();
			} // for
			// irás a szavazok tálába
			$db->setQuery('INSERT INTO #__szavazok 
							(`id`, 
							`temakor_id`, 
							`szavazas_id`, 
							`user_id`, 
							`idopont`, 
							`kepviselo_id`
							)
							VALUES
							(0, 
							"'.$szavazas->temakor_id.'", 
							"'.$szavazas->id.'", 
							'.$db->quote($data->voter_id).', 
							"'.date('Y-m-d H:i:s').'", 
							0
							);
			');
			$db->query();	
			$result->api_status = "OK";
		} else {
		  $result->api_status = "error this voter alredy vote";
		}
	} // szavazas record found
} else if ($task == 'setVoks') {
	$user = JFactory::getUser();
	$db = JFactory::getDBO();
    $result = new stdClass();
	if (!isset($data->poll_id)) $data->poll_id=0;
	if (!isset($data->alt_id)) $data->alt_id=0;
	if (!isset($data->voter_id)) $data->voter_id=time();
	$db->setQuery('select sz.* 
	from #__szavazasok sz
	left outer join #__temakorok t on t.id = sz.temakor_id
	left outer join #__tagok ta on ta.temakor_id = sz.temakor_id
	where sz.id='.$db->quote($data->poll_id).' and
	((ta.user_id = '.$db->quote($user->id).') or (t.lathatosag = 0)) and
	((sz.szavazok = 0) or 
	 (sz.szavazok = 1 and '.$user->id.' > 0) or
     (ta.user_id = '.$db->quote($user->id).')) 
	limit 1');
	$szavazas = $db->loadObject();
	if ($szavazas == false) {
		$result->api_status = "error poll not found (setVoks) ";
	} else if ($szavazas->szavazas != 1) {
		$result->api_status = "error poll status is wrong";
	} else {
		foreach ($data->voks as $voks) {
				$db->setQuery(
						 'INSERT INTO #__szavazatok 
							(`id`, 
							`temakor_id`, 
							`szavazas_id`, 
							`szavazo_id`, 
							`user_id`, 
							`alternativa_id`, 
							`pozicio`
							)
							VALUES
							(0, 
							"'.$szavazas->temakor_id.'", 
							"'.$data->poll_id.'", 
							"'.$data->voter_id.'", 
							"'.$user->id.'", 
							"'.$voks->alt_id.'", 
							"'.$voks->position.'"
							);
				');
				$db->query();
		}
		$db->setQuery('INSERT INTO #__szavazok 
							(`id`, 
							`temakor_id`, 
							`szavazas_id`, 
							`user_id`, 
							`idopont`, 
							`kepviselo_id`
							)
							VALUES
							(0, 
							"'.$szavazas->temakor_id.'", 
							"'.$szavazas->id.'", 
							'.$db->quote($data->voter_id).', 
							"'.date('Y-m-d H:i:s').'", 
							"'.$user->id.'"
							);
		');
		$db->query();	
	    $result = new stdClass();
		$result->api_status = 'OK';	
	}	
} else if ($task == 'getResult') {
    // likvid + condorcet feldolgozás
    $result = new stdClass();
	if (!isset($data->poll_id)) $data->poll_id=0;
	$db = JFactory::getDBO();
	$user = JFactory::getUser();
	$db->setQuery('select sz.* 
	from #__szavazasok sz
	left outer join #__temakorok t on t.id = sz.temakor_id
	left outer join #__tagok ta on ta.temakor_id = sz.temakor_id
	where sz.id='.$db->quote($data->poll_id).' and
	((ta.user_id = '.$db->quote($user->id).') or (t.lathatosag = 0)) 
	limit 1');
	$szavazas = $db->loadObject();
	JRequest::setVar('szavazas',$szavazas->id);
	JRequest::setVar('temakor',$szavazas->temakor_id);
    if ($szavazas) {
	  // ha van cachelt eredmény beolvasom azt  és azt használom
	  $db->setQuery('select * from #__poll_value_cache where pollid="'.$szavazas->id.'" and vote_count = -1');
	  $res = $db->loadObject();
	  if ($res) {
		$result1 = JSON_decode($res->report);
		$result = $result->result;	
		$result->voters = $result1->voters;
		$result->api_status = $result1->api_status;
	  } else {
	    // ha nincs most képzem az eredményt
  	    $c = new Condorcet($db, $szavazas->temmakor_id, $szavazas->id);
        $result = $c->report('json');
	    $db->setQuery('select count(*) cc from #__szavazok where szavazas_id = '.$db->quote($szavazas->id));
	    $res = $db->loadObject();
	    $result->voters = $res->cc;
	    $result->api_status = "OK";
		// ha lezárt szavazás akkor tárolom a cache -be
		if ($szavazas->lezart == 1) {
			$db->setQuery('INSERT INTO #__poll_value_cache 
	        VALUES ('.$szavazas->temakor_id.', 
	         '.$szavazas->id.', 
	         -1, 
	         '.$db->quote(JSON_encode($result)).'
	        )'
	        );
			/*
			$fp = fopen('debug.txt','w+');
			fwrite($fp,$db->getQuery().'<br />'.$db->getErrorMsg());
			fclose($fp);
			$db->query();
			*/
		}
	  }
	} else {
		$result = new stdClass();
		$result->api_status = "error poll not found ".$data->poll_id;
	}  
}	

echo JSON_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES);
?>		
