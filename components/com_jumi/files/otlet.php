<?php
  /**
    * kezdőlapon lévő ötlet beküldés képernyői, és feldolgozó eljárása
	* komponensként és modulként is müködik
	* JRequest action,txt, token, nev, email, irsz
	* action = 'modul'(default) | 'form' | 'send'
	*    URL = JURI::base() index.php?option=com_jumi&view=application&fileid=5
	*/
?>
<?php 
$db = JFactory::getDBO();
$action = JRequest::getVar('action','modul');
if ($action == 'modul') {
	?>
	<div class="otletForm1">
	  <form name="otletForm1" id="otletForm1">
	    <h2>Ötlet, javaslat, észrevétel:</h2>
		<input type="text" name="txt" value="" size="100" />
		<input type="hidden" name="action" value="form" />
		<?php echo JHTML::_( 'form.token' ); ?>
		<p><button class="btnSend" type="button" id="otletSend1">Tovább</button>
	  </form>
	</div>
	<script type="text/javascript">
		jQuery(window).load(function(){
		  jQuery('#otletSend1').click(function()  {
			 var url = '<?php echo JURI::base(); ?>index.php?option=com_jumi&view=application&fileid=5&action=form&txt='+
               encodeURIComponent(document.forms.otletForm1.txt.value)+'&tmpl=component';
			 var options = {size: {x: 400, y: 400}, overlayOpacity: 0.4};
			 SqueezeBox.open(url,options);   
		  });
		});	
	</script>
	<?php
} else {
	if (JRequest::getVar('txt') == '') {
		echo '<div class="errorMsg">Üzenet szöveget nem adott meg!</div>';
		$action = "error";
	}
	if ($action == 'send') {
	   JRequest :: checkToken() or jexit('Invalid Token');
	   $errorMsg = '';
	   // hiba ellenörzések. rá csorog az alatta lévő ifre - és hiba esetén teljesül a feltétel  
	   if (JRequest::getVar('nev') == '') 
		   $errorMsg = 'A név nem lehet üres<br />';
	   if (JRequest::getVar('email') == '') 
		   $errorMsg .= 'Az e-mail cím nem lehet üres<br />';
	   if (JRequest::getVar('irsz') == '') 
		   $errorMsg .= 'Az irányító szám nem lehet üres';
	   if ($errorMsg == '') {
		   if ((strpos(JRequest::getVar('email'),'@') <= 0) |
			   (strpos(JRequest::getVar('email'),'.') <= 0)) 
			   $errorMsg .= 'Az email cím formailag hibás';
	   }	   
	   if ($errorMsg != '') {
		   echo '<div class="errorMsg">'.$errorMsg.'<div>';
		   $action = 'form';
	   } else {
		   // privát üzenet küldése az adminoknak
		   $msg = 'Üzenet érkezett a web oldal kezdőlapjáról'."\n".
				  'Beküldő neve:'.JRequest::getVar('nev')."\n". 
				  'Beküldő email:'.JRequest::getVar('email')."\n". 
				  'Beküldő irányítószám:'.JRequest::getVar('irsz')."\n\n\n". 
				  JRequest::getVar('txt');
		   $db->setQuery('INSERT INTO #__uddeim 
			(`id`, 
			`replyid`, 
			`fromid`, 
			`toid`, 
			`message`, 
			`datum`, 
			`toread`, 
			`totrash`, 
			`totrashdate`, 
			`totrashoutbox`, 
			`totrashdateoutbox`, 
			`expires`, 
			`disablereply`, 
			`systemflag`, 
			`delayed`, 
			`systemmessage`, 
			`archived`, 
			`cryptmode`, 
			`flagged`, 
			`crypthash`, 
			`publicname`, 
			`publicemail`
			)
			select distinct 0 id, 
			0 replyid, 
			0 fromid, 
			u.id toid, 
			'.$db->quote($msg).', 
			'.time().' datum, 
			0 toread, 
			0 totrash, 
			"" totrashdate, 
			"" totrashoutbox, 
			0 totrashdateoutbox, 
			0 expires, 
			0 disablereply, 
			1 systemflag, 
			0 `delayed`, 
			"Ötlet a címlapról" systemmessage, 
			0 archived, 
			0 cryptmode, 
			0 flagged, 
			"" crypthash, 
			"" publicname, 
			"" publicemail
			from #__users u
			inner join #__user_usergroup_map g on g.user_id = u.id and (g.group_id in (6,7,8))
		   ');
		   if ($db->query() ) {
			  // email küldése az adminoknak
			  $mail = JFactory::getmailer();
			  $db->setQuery('select u.email
							from #__users u
							inner join #__user_usergroup_map g on g.user_id = u.id and (g.group_id in (6,7,8))
			  ');
			  $res = $db->loadObjectList();
			  foreach ($res as $res1) {	
				$mail->addRecipient($res1->email);
			  }
			  $mail->isHTML(false);
			  $mail->setBody($msg);
			  $mail->setSubject('Üzenet érkezett a web oldal kezdőlapjáról');
			  $mail->send();  
			  echo '<div class="infoMsg">Köszönjük az ötletet, javaslatot, észrevételt. 
			  <p>A rendszer üzemeltetői hamarosan felveszik önnel a kapcsolatot.</p></div>';
		   } else {
				echo '<div class="errorMsg">Hiba történt az adat tárolás közben.'.$db->getErrorMsg().'</div>';
		   }	
	   } // a képernyőn minden adat meg volt adva	   
	}  // action == send
	if ($action == 'form') {
		$txt = urldecode(JRequest::getVar('txt'));
		?>
		<div class="otletForm2">
		  <form method="post" action="<?php echo JURI::base(); ?>index.php?option=com_jumi&view=application&fileid=5&tmpl=component">
			<h2>Ötlet, javaslat, észrevétel beküldése</h2>
			<p><var><?php echo $txt; ?></var></p> 
			<p><label>Az Ön neve:</label><input type="text" name="nev" value="<?php echo JRequest::getVar('nev',''); ?>" size="60" /></p>
			<p><label>Az Ön e-mail címe:</label><input name="email" type="text" value="<?php echo JRequest::getVar('email',''); ?>" size="60" /></p>
			<p><label>Az Ön postai irányító száma:</label><input name="irsz" type="text" value="<?php echo JRequest::getVar('irsz',''); ?>" size="6" /></p>
			<input type="hidden" name="txt" value="<?php echo $txt; ?>" />
			<input type="hidden" name="action" value="send" />
			<?php echo JHTML::_( 'form.token' ); ?>
			<p><button class="btnSend" type="submit">Beküldöm</button>
		  </form>
		</div>
		<?php
	}
} // modul vagy componens ?
?>
 