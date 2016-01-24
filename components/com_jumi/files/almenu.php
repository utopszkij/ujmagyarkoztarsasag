<?php
    $db = JFactory::getDBO();
	$session = JFactory::getSession();
	$user = JFactory::getUser();
	$temakor_id = JRequest::getVar('temakor');
	$temakor_tag = false;
	if ($session->get('secret') == '') {
	  $secret = md5(date('ymdhis'));
	  $session->set('secret',$secret);
	}
	
	// download file catid és cikk catid meghatározása 
	// ===============================================
	$alias = "@@@@";
	if ((JRequest::getVar('temakor') > 0) &
	    (JRequest::getVar('szavazas') == ''))
		$alias = 't'.JRequest::getVar('temakor');
	if (JRequest::getVar('szavazas') > 0) 
		$alias = 'sz'.JRequest::getVar('szavazas');
	
	$downloadCatid = 0;
	$cikkCatid = 0;
	$db->setQuery('select id 
	from #__categories
	where alias="'.$alias.'" and extension="com_content"
	limit 1
	');
	$res = $db->loadObject();
	if ($res) $cikkCatid = $res->id;
	  
	$db->setQuery('select id 
	from #__jdownloads_categories
	where alias="'.$alias.'" 
	limit 1
	');
	$res = $db->loadObject();
	if ($res) $downloadCatid = $res->id;
	  
	// témakör tag?
	if (($temakor_id > 0) & ($user->id > 0)) {
		$db->setQuery('select * from #__tagok where temakor_id = '.$temakor_id.' and user_id='.$user->id);
		$res = $db->loadObject();
		if ($res) $temakor_tag = true;
	}
	
	$Akciok = $session->get('akciok');
	$Kepviselo = $session->get('kepviselo');
	$AltKepviselo = $session->get('altkepviselo');
	$user = JFactory::getUser();
?>
	<div class="alMenu">
	  <?php if (is_array($Akciok) | is_array($Kepviselo) | is_array($AltKepviselo)) : ?>
		<?php if(JRequest::getVar('temakor') > 0) : ?>
			<?php if ($Akciok['ujSzavazas'] != '') : ?>
			  <div>
			  <a href="<?php echo $Akciok['ujSzavazas']; ?>" class="btnAlmenu btnAdd">Új vitát javaslok</a>
			  </div>
			<?php else : ?>
			  <div class="btnAlmenu btnAdd disabled">Új vitát javaslok</div>
			<?php endif; ?>  
			<?php if ($cikkCatid > 0) : ?>
			<div>
			  <a href="<?php echo JURI::base(); ?>index.php?option=com_content&view=category&layout=blog&id=<?php echo $cikkCatid; ?>&Itemid=887" class="btnAlmenu btnVittainditok">
				 Cikkek, elemzések
			  </a>
			</div>	
			<?php endif; ?>
			<?php if ($downloadCatid > 0) : ?>
			<div>
			  <a href="<?php echo JURI::base(); ?>index.php?option=com_jdownloads&view=category&catid=<?php echo $downloadCatid; ?>" class="btnAlmenu btnFileok">
				Letölthető háttér anyagok
			  </a>
			</div>	
			<?php endif ?>
			<?php if (($user->id > 0) & (JRequest::getVar('temakor') > 0)) : ?>
				<div>
				<?php if ($temakor_tag == false) : ?>
				<a href="<?php echo JURI::base(); ?>index.php?option=com_tagok&view=tagok&task=jelentkezes&temakor=<?php echo JRequest::getVar('temakor'); ?>&user=<?php echo $user->id; ?>" class="btnAlmenu btnTagLennek" title="Témakör tag lennék">
				  Témakör tag lennék
				</a>
				<?php else : ?>
				<a href="<?php echo JURI::base(); ?>index.php?option=com_tagok&view=tagok&task=delete&temakor=<?php echo JRequest::getVar('temakor'); ?>&tag=<?php echo $user->id; ?>&<?php echo $session->get('secret'); ?>=1" class="btnAlmenu btnTagTorles" title="Témakör tagság törlése">
				  Megszüntetem a Témakör tagságom
				</a>
				<?php endif; ?>
				</div>	
			<?php else : ?>
				<div class="btnAlmenu btnTagLennek disabled">Témakör tag lennék</div>
			<?php endif; ?>
			<?php if (($user->id > 0) & (JRequest::getVar('temakor') > 0)) : ?>
				<div><a class="btnAlmenu btnTagok" href="index.php?option=com_tagok&temakor=<?php echo JRequest::getVar('temakor'); ?>">Témakör tagok</a></div>		
			<?php endif; ?>
			<?php if ($Kepviselo['ujJeloltLink'] != '') : ?>
				<div style="display:none">
				<a href="<?php echo $Kepviselo['ujJeloltLink']; ?>" class="btnAlmenu btnKepvieloLennek">Témakör képviseletet vállalok</a>
				</div>	
			<?php elseif ($Kepviselo['kepviseloJeloltLink'] != '') : ?>
				<div style="display:none">
				<a href="<?php echo $Kepviselo['kepviselojelotLink']; ?>" class="btnAlmenu btnKepvieloLennek">Témakör képviselő adatlapom</a>
				</div>	
			<?php else : ?>
				<div  style="display:none" class="btnAlmenu btnKepviseloLennek disabled">Témakör képviseletet vállalok</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php if ($Akciok['ujAlternativa'] != '') : ?>
		  <div><a href="<?php echo $Akciok['ujAlternativa']; ?>" class="btnAlemnu btnAdd">
		        Új alternatívát javaslok
			  </a>
		  </div>
		<?php endif; ?> 
        <?php if ($Akciok['szavazok'] != '') : ?>
           <div>
		     <a href="<?php echo $Akciok['szavazok']; ?>" class="btnAlmenu btnSzavazok" >Szavazok</a>
		   </div>	 
        <?php endif; ?>
	    <?php if ($Akciok['eredmeny'] != '') : ?>
			<div>
			  <a class="btnAlmenu btnEredmeny" onClick="eredmenyClick();" style="cursor:pointer">Eredmény</a>
			</div>  
        <?php endif; ?>
	  <?php endif; ?>	
	  <div>
	    <?php if ($Akciok['sugo'] != '') : ?>
			<div>
			  <a class="btnAlmenu btnSugo modal" href="<?php echo $Akciok['sugo']; ?>">Súgó</a>
			</div>  
		<?php else : ?>
			<a href="<?php echo JURI::base(); ?>index.php?option=com_content&view=article&id=19&Itemid=435&tmpl=component" class="modal btnAlemu btnHelp">
				 Súgó
			</a>
		<?php endif; ?>
	  </div>
	  <div class="clr"></div>
	</div><!-- alMenu -->	
	<?php
	  $session->set('akciok','');
	  $session->set('kepviselo','');
	  $session->set('altkepviselo','');
	?>	
