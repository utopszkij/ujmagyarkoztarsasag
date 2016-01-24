<?php
/**
  * következő esemény modul
*/
$db = JFactory::getDBO();
$db->setQuery('select startdate, title
from #__icagenda_events
where startdate >= "'.date('Y-m-d').'"
order by startdate
limit 1');
//DBG echo $db->getQuery();
$res = $db->loadObject();
echo '<div class="esemeny">
';
if ($res) {
  $res->title = str_replace('Ugrás a szavazás oldalára','',$res->title);	
  $res->title = str_replace('vita2','vita',$res->title);	
  $datum = substr($res->startdate,0,10);
  $datum = str_replace('-','.',$datum);  
  $szepDatum = '<span>'.substr($datum,0,1).'</span>'.
               '<span>'.substr($datum,1,1).'</span>'.
               '<span>'.substr($datum,2,1).'</span>'.
               '<span>'.substr($datum,3,1).'</span>'.
               substr($datum,4,1).
               '<span>'.substr($datum,5,1).'</span>'.
               '<span>'.substr($datum,6,1).'</span>'.
               substr($datum,7,1).
               '<span>'.substr($datum,8,1).'</span>'.
               '<span>'.substr($datum,9,1).'</span>';
			   
  
  echo '<label>Legközelebbi esemény:</label><var>'.$szepDatum.' '.utf8Substr($res->title,0,60).'</var>
  ';
} else {
  echo '<label>Nincs közelgő esemény</label>';	
}
echo '<div class="esemenyekLink"><a title="események" href="'.JURI::base().'index.php?option=com_icagenda&view=list&Itemid=782">»</span></a></div>
</div>
';
?>
  