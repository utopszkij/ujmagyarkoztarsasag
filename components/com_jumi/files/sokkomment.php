<?php
/**
  * Legtöbbet kommentezett ötletek modul
  */
  $db = JFactory::getDBO();
  $db->setQuery('select sz.id, sz.megnevezes, sz.leiras, count(comment.id) cc, sz.letrehozva
  from #__szavazasok sz
  left outer join #__content c on c.alias = concat("sz",sz.id)
  left outer join #__jcomments comment on comment.object_id = c.id
  where sz.elutasitva = "" 
  group by sz.id, sz.megnevezes, sz.leiras
  order by 4 DESC,5
  limit 5
  ');
  $nepszeruSzavazasok = $db->loadObjectList();
  $itemClass = 'row0';
  
  //DBG echo $db->getQuery();
?>
<div class="nepszeruOtletek">
<?php foreach($nepszeruSzavazasok as $item) : ?>
  <div class="item <?php echo $itemClass; ?>">
    <h3><a href="<?php echo JURI::base().'SU/alternativak/alternativaklist/browse/'.$item->temakor_id.'/'.$item->id.'/10/0/1/' ;?>">
	       <?php echo $item->megnevezes; ?>
		</a>
		<var>(<?php echo $item->cc; ?>)</var>
	</h3>
	<div class="leiras"><?php echo utf8Substr($item->leiras,0,400); ?></div>
  </div>
  <?php if ($itemClass=='row0') $itemClass='row1'; else $itemClass='row0'; ?>
<?php endforeach; ?>
</div>