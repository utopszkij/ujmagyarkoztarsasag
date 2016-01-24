<?php
  $session = JFactory::getSession();
  $Kepviselo = $session->get('kepviselo');
  $AltKepviselo = $session->get('altkepviselo');
  $kepviselosegemMenu = '';
?>
	<?php if (is_array($Kepviselo) | is_array($AltKepviselo) ) : ?>
		<div class="kepviseloDoboz">
		  <!--
		  <?php if ($AltKepviselo['kepviselojeLink'] != '') : ?>
			<div class="altKepviselo">
				 <a class="btnKepviselo" href="<?php echo $AltKepviselo['kepviselojeLink']; ?>">
				 <div class="avatar"><?php echo $AltKepviselo['image']; ?></div>
				 <br /><?php echo $AltKepviselo['nev']; ?>
				 <br /><?php echo JText::_('GLOBALISKEPVISELO'); ?>
				 </a>
			 </div>
		  <?php endif; ?> 
		  -->      
		  <?php if ($Kepviselo['kepviselojeLink'] != '') : ?>
			<div class="temaKepviselo">
				 <a class="btnKepviselo" href="<?php echo $Kepviselo['kepviselojeLink']; ?>">
				 <div class="avatar"><?php echo $Kepviselo['image']; ?></div>
				 <br /><?php echo $Kepviselo['nev']; ?>
				 <br /><?php echo JText::_('TEMAKORKEPVISELO'); ?>
				 </a>
			</div>
		  <?php endif; ?>
		  <?php if ($Kepviselo['kepviselotValasztLink'] != '') : ?>
			<div class="temaKepviseloValasztas">
				 <a class="btnKepviselo" href="<?php echo $Kepviselo['kepviselotValasztLink']; ?>">
				 Témakör képviselőt választok
				 </a>
			</div>
		  <?php endif; ?>
		  <?php if ($Kepviselo['kepviseloJeloltLink'] != '') : ?>
			<!--
			<div class="temaKepviseloJelolt">
				 <a class="btnKepviseloJelolt" href="<?php echo $Kepviselo['kepviseloJelolt']; ?>">
				 Témakör képviselői adatlapom
				 </a>
			</div>
			-->	 
			<?php $kepviselosegemMenu .= '<a class="akcioGomb btnJelolt" href="'.$Kepviselo['kepviseloJeloltLink'].'">
				  Témakör képviselő adatlapom
				  </a>
				  '; 
			?>	  
		  <?php endif; ?>
		  <?php if ($Kepviselo['ujJeloltLink'] != '') : ?>
			<!--  
			<div class="temaKepviseloJelolt">
				 <a class="btnKepviseloJelolt" href="<?php echo $Kepviselo['ujJeloltLink']; ?>">
				 Témakör képviseletet vállalok
				 </a>
			</div>
			-->	 
			<?php $kepviselosegemMenu .= '<a class="akcioGomb btnJelolt" href="'.$Kepviselo['kepviseloJeloltLink'].'">
				  Témakör képviseletet vállalok
				  </a>
				  '; 
			?>	  
		  <?php endif; ?>
		  <?php $session->set('kepviselosegemMenu',$kepviselosegemMenu); ?>
		</div><!-- kepviseloDoboz -->
	<?php endif; ?>
