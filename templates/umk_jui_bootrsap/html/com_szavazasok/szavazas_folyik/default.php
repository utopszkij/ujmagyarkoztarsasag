<?php
/**
 * szavazasok szavazás folyik állapotban böngésző képernyő
 * bemenet:
 * $this->Items
 *      ->Akciok      [name=>link,...]
 *      ->reorderLink
 *      ->dofilterLink
 *      ->itemLink
 *      ->Lapozosor
 *  Jrequest:  filterStr             
 */ 
// no direct access
defined('_JEXEC') or die('Restricted access');
$session = JFactory::getSession();
$kepviselosegemMenu = '';
$db = JFactory::getDBO();
$user = JFactory::getUser();
$this->temakor_id = JRequest::getVar('temakor');

// segéd funckció a th order -függő szinezéséhez
function thClass($col) {
  $order = JRequest::getVar('order');	
  if ($order == $col.' DESC') {
	 $result = 'colHeaderOrderedUp'; 
  } else if ($order == $col) {
	 $result = 'colHeaderOrderedDown'; 
  } else {
	 $result = 'colHeader'; 
  }
  return $result;  
}

// segéd funckció új order paraméter előállításához
function newOrder($col) {
  $order = JRequest::getVar('order');	
  if ($order == $col.' DESC') {
	 $result = $col; 
  } else if ($order == $col) {
	 $result = $col.' DESC'; 
  } else {
	 $result = $col; 
  }
  return $result;  
}


?>

<div class="vita1List">
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php if (JRequest::getVar('temakor') > 0) : ?>
		<div class="temakorDoboz">
			<div class="dobozFejlec">
				<img class="temakorKep" src="<?php echo kepLeirasbol($this->temakor_leiras); ?>" />
				Témakör: <h2><?php echo $this->temakor_megnevezes; ?></h2>
			</div>
			<?php if ($this->Akciok['temakoredit']) :?>
			<a class="editIcon" href="<?php echo $this->Akciok[temakoredit]; ?>" title="Módosít">&nbsp;<span>Edit</span></a>
			<?php endif; ?>
			<?php if ($this->Akciok['temakortorles']) : ?>
			<a class="deleteIcon" href="<?php echo $this->Akciok[temakortorles];?>" title="Töröl">&nbsp;<span>Törlés</span></a>
			<?php endif; ?>
			<div class="temakorLeiras"><?php echo utf8Substr($this->temakor_leiras,0,10000); ?></div>
		</div>
		<?php endif; ?>
	</div><!-- componetheading -->
	<div class="clr"></div>

	<div class="kozepsoTerulet">
		<?php
		  if (JRequest::getVar('filter') > 0)
			  $filter = 'sz.temakor_id = '.$db->quote(JRequest::getVar('temakor'));
		  else
		      $filter = '1';
		  $db->setQuery('select count(*) cc 
		  from #__szavazasok sz
		  where '.$filter.' and sz.szavazas=1
		  ');
		  $res = $db->loadObject();
		  $szTotal = $res->cc;

		  $db->setQuery('select count(*) cc 
		  from #__szavazasok sz
		  where '.$filter.' and sz.lezart=1
		  ');
		  $res = $db->loadObject();
		  $lezartTotal = $res->cc;
		  
		  $rowClass == 'row0'
		  
		?>
		<div class="szavazasFolyik">
			<div class="fulek">
				<div class="aktivFul">Szavazások (<?php echo $szTotal; ?>)</div>
				<div class="inaktivFul">
				   <a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=lezart&task=lezart&temakor=<?php echo $this->temakor_id; ?>">
				    Lezárt szavazások (<?php echo $lezartTotal; ?>)
				   </a>	
				</div>
			</div>
			<div class="clr"></div>
			<div class="tablazat">
			<div class="tableSzavazas<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
				<table border="0" width="100%">
					<thead>
						<tr>
							<th class="colHeader"><?php echo JText::_('SZAVAZASMEGNEVEZES'); ?></th>
							<th class="rejtett _colHeaderOrderedDown">Szavazás vége</th>
							<th class="rejtett _colHeader">Titkos</th>
							<th class="rejtett _colHeader">Szavaztál</th>
						</tr>
					</thead>
					<tbody>
					  <?php foreach ($this->Items as $item) : ?> 
							  <?php if ($item->hatravan < 30) $surgos = ' surgos'; else $surgos = ''; ?>	
							  <tr class="<?php echo $rowClass.$surgos; ?>">
								  <td class="szavazasItem">
								    <div class="megnevezes">
									    <a href="<?php 
										           $s = str_replace('szavazas',$item->id,$this->itemLink); 
												   $s = str_replace('temakor',$item->temakor_id,$s);
												   echo $s;
											     ?>">
										<img src="<?php echo kepLeirasbol($item->leiras); ?>" /><?php echo $item->megnevezes; ?>
									  </a>
									</div>
								    <div class="hatarido">
									  szavazás vége:&nbsp;<b><?php echo str_replace('-','.',$item->szavazas_vege); ?></b>
									</div>
									<div class="hatravan">
									  szavazás végéig&nbsp;<var><?php echo $item->hatravan; ?></var>&nbsp;nap
									</div>
								    <div class="nyilt_titkos">
								      <?php if ($item->titkos == 1) echo '<span class="titkos" title="titkos szavazás">&nbsp;</span><i>titkos</i>'; 
									      else echo '<span class="nyilt" title="nyilt szavazás">&nbsp;</span><i>nyilt</i>'; 
									  ?>
									</div>
								    <div class="szavaztal_nemszavaztal">
								    <?php if ($item->sz2id > 0) echo '<span class="szavaztal" title="már szavaztál">&nbsp;</span><i>szavaztál</i>'; 
									      else echo '<span class="nemSzavaztal" title="még nem szavaztál">&nbsp;</span><i>nem szavaztál</i>'; 
									?>
								    </div>
								  </td>
								  <td class="rejtett _hatarido"><b><?php echo str_replace('-','.',$item->szavazas_vege).'</b><span class="hatravan">'.$item->hatravan.'</span>'; ?></td>
								  <td class="rejtett _nyilt_titkos">
								    <?php if ($item->titkos == 1) echo '<span class="titkos">&nbsp;</span>'; 
									      else echo '<span class="nyilt">&nbsp;</span>'; ?>
								  </td>
								  <td class="rejtett _szavaztal_nemszavaztal">
								    <?php if ($item->sz2id > 0) echo '<span class="szavaztal">&nbsp;</span>'; 
									      else echo '<span class="nemSzavaztal">&nbsp;</span>'; ?>
								  </td>
							 </tr>
							 <?php  if ($rowClass == 'row0') $rowClass='row1'; else $rowClass='row0'; ?>
					  <?php endforeach; ?>
					</tbody>
					<tfoot>
					<?php if ($szTotal == 0) :?>
					  <tr><td colspan="4">Ebben a témakörben jelenleg nincs aktív szavazás</td></tr>
					<?php endif; ?>
					</tfoot>
				</table>
			</div><!-- tableSzavazas -->
			</div><!-- tablazat -->
			<div class="lapozoSor">
				<?php echo $this->LapozoSor; ?>
			</div>
		</div><!-- szavazasFolyik -->
	
	
		<?php	  
		  $db->setQuery('select count(*) cc 
		  from #__szavazasok sz
		  where '.$filter.' and sz.elbiralas_alatt=1
		  ');
		  $res = $db->loadObject();
		  $publikalandoTotal = $res->cc;

		  $db->setQuery('select count(*) cc 
		  from #__szavazasok sz
		  where '.$filter.' and sz.elutasitva <> ""
		  ');
		  $res = $db->loadObject();
		  $elutasitvaTotal = $res->cc;

		  $db->setQuery('select count(*) cc 
		  from #__szavazasok sz
		  where '.$filter.' and sz.vita1=1  
		  ');
		  $res = $db->loadObject();
		  $vTotal = $res->cc;

		  $db->setQuery('select sz.id, sz.megnevezes, sz.leiras, sz.vita1_vege, sz.titkos, 
		                        sz.letrehozo, u.username, sz.temakor_id,
								sz2.id sz2id, datediff(sz.szavazas_vege, curdate()) hatravan
		  from #__szavazasok sz
		  left outer join #__users u on u.id = sz.letrehozo
		  left outer join #__szavazok sz2 on sz2.szavazas_id = sz.id and sz2.user_id='.$user->id.'
		  where '.$filter.' and sz.vita1=1
		  order by sz.szavazas_vege DESC
		  limit 5');
		  $Items = $db->loadObjectList();
		  //DBG echo '<br>'.$db->getQuery().'<br>';
		  $rowClass = 'row0';

		  ?>
		
		<div class="vitakList">
			<div class="fulek">
				<div class="aktivFul">Viták (<?php echo $vTotal; ?>)</div>
				<div class="inaktivFul">
					<a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=elutasitottak&task=elutasitottak&temakor=<?php echo $this->temakor_id; ?>">
					   Megszakított viták (<?php echo $elutasitvaTotal; ?>)
					</a>
				</div>
				<?php if ($this->Akciok['temakoredit'] != '') : ?>
				<div class="inaktivFul">
				  <a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=publikalandok&task=publikalandok&temakor=<?php echo $this->temakor_id; ?>">
				  Jóváhagyásra váró javaslatok (<?php echo $publikalandoTotal; ?>)
				  </a>
				</div>
				<?php endif; ?>
			</div><!--  fulek-->
			<div class="clr"></div>
			<div class="tablazat">
				<div class="szuroKepernyo">
				  <form action="<?php echo $this->doFilterLink; ?>" method="post">
					<div class="szurourlap">
					  <?php echo JText::_('SZURES'); ?>
					  <input type="text" name="filterStr" size="40" value="<?php echo JRequest::getVar('filterStr'); ?>" />
					  <button type="submit" class="btnFilter"><?php echo JText::_('SZURESSTART'); ?></button>
					  <button type="button" class="btnClrFilter" onclick="location='<?php echo $this->doFilterLink; ?>&filterStr=';">
						<?php echo JText::_('SZURESSTOP'); ?>
					  </button>
					</div>
				  </form>
				</div> <!-- szurokepernyo -->
				
				<div class="tableSzavazasVita1<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
					<table border="0">
						<thead>
							<tr>
								<th class="<?php echo thClass(1); ?>">
									<a href="<?php echo $this->reorderLink; ?>&order=<?php echo newOrder(1); ?>">
										<?php echo JText::_('SZAVAZASMEGNEVEZES'); ?>
									</a>  
								</th>
								<th class="rejtett <?php echo thClass(9); ?>">
									<a href="<?php echo $this->reorderLink; ?>&order=<?php echo newOrder(9); ?>">
										Vita vége
									</a>
								</th>
								<th class="rejtett <?php echo thClass(13); ?>">
									<a href="<?php echo $this->reorderLink; ?>&order=<?php echo newOrder(13); ?>">
										Vita indító
									</a>
								</th>
								<th class="rejtett">
								  Értékelés
								</th>
							</tr>
						</thead>
						<tbody>
							<?php $rowClass = 'row0'; ?>
							<?php foreach ($Items as $item) : ?> 
								<?php if ($item->hatravan < 3) $surgos = ' surgos'; else $surgos = ''; ?>	
								<tr class="<?php echo $rowClass.$surgos; ?>">
									<td class="vitaItem">
									  <div class="megnevezes">
									    <a href="<?php 
										           $s = str_replace('szavazas',$item->id,$this->itemLink); 
												   $s = str_replace('temakor',$item->temakor_id,$s);
												   echo $s;
											     ?>">
										  <h4><img src="<?php echo kepLeirasbol($item->leiras); ?>" />
											 <?php echo $item->megnevezes; ?>
										  </h4>
										  <div class="leiras">
											<?php echo utf8Substr($item->leiras,0,200); ?>
										  </div>	
									    </a>
									  </div>
									  <div class="hatarido">
									    vita vége:&nbsp;<b><?php echo str_replace('-','.',$item->vita1_vege); ?></b>
									  </div>
									  <div class="hatravan">
									     szavazásig még&nbsp;<var><?php echo $item->hatravan; ?></var>&nbsp;nap
									  </div>
									  <div class="ertekeles"><?php
										   if ($item->rating_count > 0) 
											   $ertekeles  = round($item->rating_sum / $item->rating_count);
										   else
											   $ertekeles = 0;
										   for ($i=0; $i < 5; $i++) {
											   if ($i <= $ertekeles) 
												   echo '<var class="csillagSzines"><span>*</span></var>';
											   else
												   echo '<var class="csillag"><span>*</span></var>';
										   }
													
										?>
									  </div>
									</td>
									<td class="rejtett _hatarido"><b><?php echo str_replace('-','.',$item->vita1_vege).'</b> <span class="hatravan">szavazásig még&nbsp;'.$item->hatravan.'&nbsp;nap</span>'; ?></td>
									<td class="rejtett _letrehozo"><?php echo $item->username; ?></td>
									<td class="rejtett _ertekeles"><?php
										   if ($item->rating_count > 0) 
											   $ertekeles  = round($item->rating_sum / $item->rating_count);
										   else
											   $ertekeles = 0;
										   for ($i=0; $i < 5; $i++) {
											   if ($i <= $ertekeles) 
												   echo '<var class="csillagSzines"><span>*</span></var>';
											   else
												   echo '<var class="csillag"><span>*</span></var>';
										   }
													
										?>
									</td>
								</tr>
								<?php if ($rowClass == 'row0') $rowClass='row1'; else $rowClass='row0'; ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<?php if (count($this->items) == 0) : ?>
								<tr colspan="4"><td class="nincsAdat">Ebben a témakörben jelenleg nincs aktív vita</td></tr>	  
							<?php endif; ?>
						</tfoot>
					</table>
					<?php if ($vTotal > 5) : ?>
					<div>
					  <a href="<?php echo JURI::base(); ?>index.php?option=com_szavazasok&view=vita_alt&task=vita_alt&temakor=<?php echo JRequest::getVar('temakor'); ?>">További ötletek</a>
					</div>
					<?php endif; ?>
				</div><!-- tableSzavazasVita1 -->		
			</div><!-- tablazat -->
			<div class="lapozoSor">
				<?php echo $this->LapozoSor; ?>
			</div>
			<?php if ($this->CommentId > 0) : ?>
				<?php echo JComments::show($this->CommentId, 'com_content', $this->Szavazas->megnevezes); ?>
			<?php endif; ?>
			<?php //adat átadás az almenu modulnak
				$session->set('akciok',$this->Akciok);  
				$session->set('kepviselo',$this->Kepviselo);  
				$session->set('altkepviselo',$this->AltKepviselo);  
			?>
			
		</div><!-- vitakList -->
		<div class="clr"></div>
	</div><!-- kozepso terulet -->
	<div class="clr"></div>

<form name="adminForm" method="get" action="<?php echo JURI::base(); ?>index.php">
  <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
  <input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
  <input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
  <input type="hidden" name="order" value="<?php echo JRequest::getVar('order'); ?>" />
  <input type="hidden" name="limit" value="<?php echo JRequest::getVar('limit'); ?>" />
  <input type="hidden" name="filterStr" value="<?php echo JRequest::getVar('filterStr'); ?>" />
  <input type="hidden" name="temakor" value="<?php echo JRequest::getVar('temakor'); ?>" />
  <input type="hidden" name="limitstart" value="<?php echo JRequest::getVar('limitstart'); ?>" />
</form>
<script type="text/javascript">
  Joomla.submitform = function () {
	document.forms.adminForm.submit();  
  }
</script>
</div><!-- vita1List -->
