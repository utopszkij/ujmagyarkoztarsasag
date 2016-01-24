<?php
/**
 * mod_lide_primitiv.pgp
 * egyszerű (egy alternativát választó) szavazás modul
 * cookie -val próbálja megneheziteni, hogy egy ember többször szavazzon
 * Licensz: GNU/GPL
 * Author: Fogler Tibor  tibor.fogler@gmail.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//JHtml::_('jquery.framework', false);
/*
$lang = JFactory::getLanguage();
$extension = 'mod_lide_primitiv';
$base_dir = JPATH_SITE;
$language_tag = 'hu-HU';
$reload = true;
$lang->load($extension, $base_dir, $language_tag, $reload);
*/

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$pollId = $params->get('poll_id');
?>
<div class="lide_poll<?php echo $moduleclass_sfx ?>">
  <div id="pollModulForm_<?php echo $pollId; ?>" class="pollModulForm">
  </div>
  <div id="pollModulResult_<?php echo $pollId; ?>" class="pollModulResult">
  </div>
  <center>
  <a href="http://li-de.tk">
  <img src="https://scontent-vie1-1.xx.fbcdn.net/hprofile-xtf1/v/t1.0-1/c8.0.50.50/p50x50/11870691_978963548792060_7863904581434713566_n.jpg?oh=2283879020ff37f56343a104e4d15279&oe=56B58BA8">
  </a>
  </center>
</div>

<script type="text/javascript">
szinek = ['red','blue','orange','green','black','red','blue','orange'];
pollName_<?php echo $params->get('poll_id'); ?> = '';

function setCookie(key, value, expDay) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expDay * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}


/**
  * Gombrutin, szavazat beküldése, eredmény megjelenítése
  */  
function btnOkClick() {
	var pollId = <?php echo $params->get('poll_id'); ?>;
	var selected = jQuery('input[name=voks_'+pollId+']:checked');
	if (selected.val()) {
	    setCookie("pollmodul"+pollId,1,100);
		 // szavazat beküldése
		jQuery.support.cors = true;
		var params = {url: "http://li-de.tk/lideapi.php", tiemout:30000, datatype:"txt"};
	    params.data = '{"task":"setSimpleVoks", "poll_id":'+pollId+', "alt_id":'+selected.val() + '}';

		params.success = function(data, txtStatus) {
		  // process data (data is string. It is a JSON encoded object)
		  var pollId = <?php echo $params->get('poll_id'); ?>;
		  dataObj = jQuery.parseJSON( data );
		  if (dataObj.api_status.substr(0,2) == 'OK') {
			 // eredmény megmutatása
			 btnResultClick();
		  } else {
			  html = dataObj.api_status;
		      jQuery('#pollModulForm_'+pollId).html(dataObj.api_status);
		  }
		};
		
		params.error = function(jqXHR, textStatus, ex) {
		  // process ajax comunication' error event
		  var pollId = <?php echo $params->get('poll_id'); ?>;
		  jQuery('#pollModulForm_'+pollId).html("kommunikációs hiba "+textStatus);
		};
		jQuery.ajax(params);
	} else {
	     alert("Válassz a lehetőségek közül!");
	}
}

/**
  * Gomb rutin, szavazó ürlap elrejtése, eredmény lekérése, eredmény megmutatása
  */ 
function btnResultClick() {
		var pollId = <?php echo $params->get('poll_id'); ?>;
		jQuery.support.cors = true;
		var params = {url: "http://li-de.tk/lideapi.php", tiemout:30000, datatype:"txt"};
		params.data = '{"task":"getSimpleResult", "poll_id":'+pollId+'}';

		params.success = function(data, txtStatus) {
		  // process data (data is string. It is a JSON encoded object)
		  var pollId = <?php echo $params->get('poll_id'); ?>;
		  var dataObj = jQuery.parseJSON( data );
		  var html = '<h2>'+pollName_<?php echo $params->get('poll_id'); ?>+'</h2>';
		  if (dataObj.voters) {
			  html += '<p>'+dataObj.voters+' <?php echo JText::_('MOD_LIDE_VOKS_COUNT'); ?></p>';
			  var szorzo = 100 / dataObj.result[0].darab;
			  var i = 0;
			  var w = 0;
			  for (i in dataObj.result) {
				  if (i <= 7) {
				    w = dataObj.result[i].darab * szorzo;
				    html += '<div style="display:inline-block; width:30px; height:'+w+'px; background-color:'+szinek[i]+'; vertical-align:bottom; ">&nbsp;</div>';
			      }	
			  }
			  html += '<div style="clear:boot"></div>';
			  var j = 0;
			  for (i=0; i<dataObj.result.length; i++) {
				j = i;
				if (j > 7) j = 4;	
				html += '<p><var style="background-color:'+szinek[j]+'">&nbsp;&nbsp;</var>&nbsp;'+
				'<var>'+dataObj.result[i].darab+'</var>&nbsp;'+
				dataObj.result[i].megnevezes+'</p>';
			  }
		  } else {
			  html += '<p><?php echo JText::_('MOD_LIDE_NO_VOKS')?></p>';
		  }
		  
		  html += '<button type="button" id="btnCancel" onclick="btnCancelClick()"><?php echo JText::_('MOD_LIDE_BACK')?></button></p>';
		  
		  jQuery('#pollModulResult_'+pollId).html(html);
		  jQuery('#pollModulForm_'+pollId).hide();
		  jQuery('#pollModulResult_'+pollId).show();
		};
		
		params.error = function(jqXHR, textStatus, ex) {
		  // process ajax comunication' error event
		  var pollId = <?php echo $params->get('poll_id'); ?>;
		  $('#pollModulResult_'+pollId).html("communication error "+textStatus);
		  $('#pollModulForm_'+pollId).hide();
		  $('#pollModulResult_'+pollId).show();
		};

		jQuery.ajax(params);
}

/**
  * Gomb rutin; eredmény elrejtése, szavazó ürlap megjelenítése
  */  
function btnCancelClick() {
	var pollId = <?php echo $params->get('poll_id'); ?>;
	jQuery('#pollModulResult_'+pollId).hide();
	jQuery('#pollModulForm_'+pollId).show();
}

/**
  * poll_id szavazó form kirajzolása #pollModulForm -ba
  */
jQuery(document).ready(function() {
		var pollId = <?php echo $params->get('poll_id'); ?>;
		jQuery.support.cors = true;
		var params = {url: "http://li-de.tk/lideapi.php", tiemout:30000, datatype:"txt"};
		params.data = '{"task":"getPoll", "poll_id":'+pollId+'}';

		params.success = function(data, txtStatus) {
		  // process data (data is string. It is a JSON encoded object)
		  var pollId = <?php echo $params->get('poll_id'); ?>;
		  var dataObj = jQuery.parseJSON( data );
		  pollName_<?php echo $params->get('poll_id'); ?> = dataObj.megnevezes;
		  var html = '<h2>'+dataObj.megnevezes+'</h2><table border="0">';
		  var i = 0;
		  for (i=0; i < dataObj.alternatives.length; i++) {
		    html += '<tr><td valign="top">'+
			'<input type="radio" name="voks_'+pollId+'" value="'+dataObj.alternatives[i].id+'" /></td>'+
			'<td>'+dataObj.alternatives[i].megnevezes+'<br /><br /></td></tr>';
		  }
		  html += '</table>';
		  if (getCookie("pollmodul"+pollId) == 1) {
		    html += '<p><?php echo JText::_('MOD_LIDE_ALREDY_VOKSED'); ?>&nbsp;';
		  } else {
		    html += '</p><button type="button" id="btnSend" onclick="btnOkClick()"><?php echo JText::_('MOD_LIDE_SEND')?></button>&nbsp;';
		  }
		  html += '<button type="button" id="btnResult" onclick="btnResultClick()"><?php echo JText::_('MOD_LIDE_RESULT'); ?></button></p>';
		  html += '</div>';
		  jQuery('#pollModulForm_'+pollId).html(html);
		  jQuery('#pollModulResult_'+pollId).hide();
		  jQuery('#pollModulForm_'+pollId).show();
		};
		
		params.error = function(jqXHR, textStatus, ex) {
		  // process ajax comunication' error event
		  var pollId = <?php echo $params->get('poll_id'); ?>;
		  jQuery('#pollModulForm_'+pollId).html("Communication error "+textStatus);
		  jQuery('#pollModulResult_'+pollId).hide();
		  jQuery('#pollModulForm_'+pollId).show();
		};

		jQuery.ajax(params);
   
}); // document.ready function
</script>
