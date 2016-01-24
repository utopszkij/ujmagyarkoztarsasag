<?php
/**
  * Legújabb ötletek modul
  */
  $db = JFactory::getDBO();
  $db->setQuery('select *
  from #__szavazasok sz
  where sz.vita1 = 1 and sz.elutasitva = "" 
  order by sz.letrehozva DESC
  limit 10
  ');
  $ujSzavazasok = $db->loadObjectList();
  $itemClass = 'row0';
?>
<div class="ujOtletek">
<?php foreach($ujSzavazasok as $item) : ?>
  <div class="item <?php echo $itemClass; ?>">
    <h3><a href="<?php echo JURI::base().'SU/alternativak/alternativaklist/browse/'.$item->temakor_id.'/'.$item->id.'/10/0/1/' ;?>">
	       <?php echo $item->megnevezes; ?>
		</a>
	</h3>
	<div class="leiras"><?php echo utf8Substr($item->leiras,0,400); ?></div>
  </div>
  <?php if ($itemClass=='row0') $itemClass='row1'; else $itemClass='row0'; ?>
<?php endforeach; ?>
</div>