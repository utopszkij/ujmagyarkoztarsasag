<?php
/**
 * más web oldalakra iframe -ben beépithető egyszerü szavazó form
 * chokiban tárolt változóval védi a dupla szavazást
 * @JRequeust integer szavzas_id
 * @JRequest optional urlencoded string cssurl
 * @JRequest optional integer alternativa_id
 * @Jrequest optional integer answer
 */ 
if ($_GET['alternativa_id'] != '') {
	$szavazas_id = $_GET['szavazas_id'];
    $_COOKIE['pollmudul_'.$szavazas_id] = 1;
	setcookie('pollmudul_'.$szavazas_id, "1", time()+3600000);  // 200 óra élettartam
}
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;
$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();
$params = &JComponentHelper::getParams('com_ammvc');
$db = JFactory::getDBO();
$szavazas_id = JRequest::getVar('szavazas_id');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu-hu" lang="hu-hu" dir="ltr">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <?php if (JRequest::getVar('cssurl') == '') { ?>
	  <style type="text/css">
	  html {font-family:Ariel; font-size:12px; line-height:110%; font-weight:midle; text-decoration:none;}
	  body {margin:1px; padding:1px; border-style:none;}
	  div {margin:1px; padding:1px; border-style:none; text-indent:0px;}
	  p {margin:1px; padding:1px; border-style:none; text-indent:0px;}
	  input {height:14px; width:14ox; margin:1px; padding:1px;}
	  h1 {font-size:14px; font-weight:bold;}
	  h2 {font-size:14px; font-weight:midle;}
	  h3 {font-size:13px; font-weight:midle;}
	  h4 {font-size:12px; font-weight:bold;}
	  h5 {font-size:12px; font-weight:bold;}
	  </style>
  <?php } else { ?>
    <link type="text/css" href="<?php echo JRequest::getVar('cssurl'); ?>" />
  <?php } ?>
</head>
<body>  
<?php 
if (($szavazas_id == 0) | ($szavazas_id == '')) {
	 echo '<p>Invalid activation szavazas_id is null.</p>';
	 exit();
}  
 
if (JRequest::getVar('answer')==1) {
	 // eredmény megjelenitése
	 $db->setQuery('select * from #__szavazasok where id='.$db->quote($szavazas_id));
	 $szavazas = $db->loadObject();
	 $db->setQuery('select a.id, a.megnevezes, 
	                       sum(szv.pozicio) spoz, 
						   count(szv.id) cc,
						   sum(if(szv.pozicio=1,1,0)) cc1
	 from #__szavazatok szv, #__alternativak a 
	 where a.id = szv.alternativa_id and szv.szavazas_id='.$szavazas_id.'
	 group by a.id, a.megnevezes
	 order by 4
	 ');
	 $res = $db->loadObjectList();
	 $cc = 0;
	 $info = '';
	 if (count($res) > 0) $cc = $res[0]->cc;
	 if (count($res) > 5) $info = '(első öt)';
     echo '<div class="lidePollModul">
	 <h2>'.$szavazas->megnevezes.'</h2>
	 <h3>Eredmény'.$info.'</h3>
	 <p>'.$cc.' leadott szavazat alapján</p>
	 <hr />
	 <div class="eredmeny">
	 ';
	 $i=0;
	 foreach ($res as $res1) {
	   if ($i < 5) {
		   echo '<p>
		   '.$res1->cc1.' db '.$res1->megnevezes.'
		   </p>
		   ';
		   $i++;
	   }
	   $cc = $res1->cc;
	 }
	 echo '</div>
	 <p><a href="'.JURI::base().'pollmodul.php?szavazas_id='.$szavazas_id.'#cssurl='.JRequest::getVar('cssurl').'">Vissza a szavazáshoz</a></p>
	 </div>
	 </body>
	 </html>
	 ';
	 exit();
} 
if (JRequest::getVar('alternativa_id')!='') {
	$db->setQuery('select * from #__szavazasok where id='.$db->quote($szavazas_id));
	$szavazas = $db->loadObject();
	if ($szavazas->szavazas == 1) {
	 // szavazat tárolása
	 $db->setQuery('select * from #__alternativak where szavazas_id='.$db->quote($szavazas_id));
	 $res = $db->loadObjectList();
	 $w = time();
	 foreach ($res as $res1) {
		 if ($res1->id == JRequest::getVar('alternativa_id')) {
			 // tárolás pozicio = 1
			 $db->setQuery(
				 'INSERT INTO `li-de`.`#__szavazatok` 
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
					"'.$szavazas->id.'", 
					"'.$w.'", 
					0, 
					"'.$res1->id.'", 
					1
					);
			');
		 } else {
			 // tárolás pozicio = 2
			 $db->setQuery(
				 'INSERT INTO `li-de`.`#__szavazatok` 
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
					"'.$szavazas->id.'", 
					"'.$w.'", 
					0, 
					"'.$res1->id.'", 
					2
					);
			 ');
		 }
		 $db->query();
	 } //foreach $res
	} 
}	
// szavazó form megjelenítése
$db->setQuery('select * from #__szavazasok where id='.$db->quote($szavazas_id));
$szavazas = $db->loadObject();
if ($szavazas) {
    $db->setQuery('select * from #__alternativak where szavazas_id='.$db->quote($szavazas_id).' order by id');
    $alternativak = $db->loadObjectList();	
} else {
	echo '<p>Nem jó szavazas_id '.$szavazas_id.'</p>';
}
echo '<div class="lidePollModul">
<h2>'.$szavazas->megnevezes.'</h2>
<form method="get" action="'.JURI::base().'pollmodul.php">
<input type="hidden" name="szavazas_id" value="'.$szavazas_id.'" />
<input type="hidden" name="cssurl" value="'.JRequest::getVar('cssurl').'" />
<table border="0">
';
  foreach ($alternativak as $alternativa) {
	 echo '<tr><td valign="top"><input type="radio" name="alternativa_id" value="'.$alternativa->id.'"></td>
	 <td>'.$alternativa->megnevezes.'</td>
	 </tr>
	 ';
} 
echo '</table>
<p>
'; 

//TEST  
//unset($_COOKIE['pollmudul_'.$szavazas_id]);

if ($szavazas->lezart == 1) {
	// lezárt szavazás
	echo '<span class="lezartszavazas">Lezárt szavazás</span>';
} else if (isset($_COOKIE['pollmudul_'.$szavazas_id])) {
	// már szavazatott
	echo '<span class="marszavazott">Ön már szavazott</span>';
} else {
	// még nem szavazott
	echo '<button type="submit">Szavazok</button>';
}
echo '&nbsp;<button type="submit" name="answer" value="1">Eredmény</button>
</p>
</form>
</div>
';
?>
</body>
</html>
