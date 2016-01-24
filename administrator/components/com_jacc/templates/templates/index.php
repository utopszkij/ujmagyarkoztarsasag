<?php
defined( '_JEXEC' ) or die;
$showLeftColumn = ($this->countModules('position-7') or $this->countModules('position-4') or $this->countModules('position-5'));
$showRightColumn = ($this->countModules('position-6') or $this->countModules('position-8') or $this->countModules('position-3'));


$pageWidth	= $this->params->get("pageWidth", "960");
$rightColumnWidth	= $this->params->get("rightColumnWidth", "200");
$leftColumnWidth	= $this->params->get("leftColumnWidth", "200");


if ($showLeftColumn && $showRightColumn) {
   $contentWidth = $pageWidth - $leftColumnWidth - $rightColumnWidth - 60;
} elseif (!$showLeftColumn && $showRightColumn) {
   $contentWidth = $pageWidth - $rightColumnWidth - 30;
} elseif ($showLeftColumn && !$showRightColumn) {
   $contentWidth = $pageWidth - $leftColumnWidth - 30;
} else {
   $contentWidth = $pageWidth - 15 ;
}

?>
<?php echo '<?'; ?>xml version="1.0" encoding="<?php echo $this->_charset ?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/positions.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
</head>
<body>
<div id="header">   
<div id="top" style="width:<?php echo $pageWidth; ?>px;">
		<div id="logo"><a href="<?php echo JRoute::_('index.php')?>" title="Home" alt="Home"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/logo.png" title="Logo" alt="Logo"></img></a></div>
		 <div class="clr"></div>
        <?php if($this->countModules('position-1')) : ?>        	
			<div id="topmenu">
				 <jdoc:include type="modules" name="position-1" />
			<div class="clr"></div>
         </div> 
		<?php endif; ?>
        <div class="clr"></div>
  </div>	
</div>  
<div id="pageouter"  style="width:<?php echo $pageWidth; ?>px;">

<div id="wrap">
  <?php if($this->countModules('position-2')) : ?>
	  <div class="clr"></div>
	  <div id="pathway">
        <jdoc:include type="modules" name="position-2" />
      <div class="clr"></div>
	  </div>
  <?php endif; ?> 
  <div id="main">
  <?php if($showLeftColumn) : ?>
  <div id="sidebar-left"  style="width:<?php echo $leftColumnWidth; ?>px;">     
      <jdoc:include type="modules" name="position-7" style="xhtml" />
      <jdoc:include type="modules" name="position-4" style="xhtml" />
      <jdoc:include type="modules" name="position-5" style="xhtml" />    
  </div>
  <?php endif; ?>
  <div id="content-outer" style="width:<?php echo $contentWidth; ?>px;">    
      <?php if ($this->getBuffer('message')) : ?>
				<div class="error">
					<h2>
						<?php echo JText::_('Message'); ?>
					</h2>
					<jdoc:include type="message" />
				</div>
	  <?php endif; ?> 
      <div id="content">
      	<jdoc:include type="modules" name="position-12" style="xhtml" />  
      	<jdoc:include type="component" /> 
      </div>   
  </div>
  <?php if($showRightColumn) : ?>
  <div id="sidebar-right" style="width:<?php echo $rightColumnWidth; ?>px;">     
      <jdoc:include type="modules" name="position-6" style="xhtml" />     
      <jdoc:include type="modules" name="position-8" style="xhtml" />
      <jdoc:include type="modules" name="position-3" style="xhtml" />      
  </div>
  <?php endif; ?>
  <div class="clr"></div>
  </div>  
<!--end of wrap-->
</div>    
<!--end of pageouter-->
</div>
<div id="footerwrap"> 
  <div id="footer" style="width:<?php echo $pageWidth; ?>px;">  	
        <jdoc:include type="modules" name="position-9" style="xhtml" />
        <jdoc:include type="modules" name="position-10" style="xhtml" />
        <jdoc:include type="modules" name="position-11" style="xhtml" />    
  </div>  
  <div id="bottom">
  	<div id="copyleft">
			<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/copyleft.png" title="Copyleft" alt="Copyleft" /> ##year## ##author##. All Wrongs Reserved.		
    </div>
  </div>
</div>
</body>
</html>