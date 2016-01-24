<?php defined('_JEXEC') or die;
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$sitename = $app->getCfg('sitename');
// Detecting Active Variables
$itemid   = $app->input->getCmd('Itemid', '');
$db = JFactory::getDBO();
$user = JFactory::getUser();
$session = JFactory::getSession();
$option = JRequest::getVar('option'); 

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<jdoc:include type="head" />
<?php
// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/template.js');
// Add Stylesheets
JHtmlBootstrap::loadCss();
// Load optional rtl Bootstrap css and Bootstrap bugfixes
JHtmlBootstrap::loadCss($includeMaincss = false, $this->direction);
// Adjusting content width
if ($this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span6";
}
elseif ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = "span9";
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span9";
}
else
{
	$span = "span12";
}
?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css' />
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>
<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
<![endif]-->
<!--[if lte IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template_IEold.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 8]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template_IE8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 9]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template_IE9.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body id="<?php echo ($itemid ? 'itemid-' . $itemid : ''); ?>">
	<?php JHTML::_('behavior.modal'); ?>
	<center>
	<div class="container">
		<!-- Begin Header-->
		<div class="header">
			<div class="header-inner">
				<?php if ($this->countModules('position-0')): ?>
				<div class="pos0">
					<jdoc:include type="modules" name="position-0" style="none" />
					<div class="clearfix"></div>
				</div><!--End Pos0-->
				<?php endif; ?>
				<?php if ($this->countModules('position-4')): ?>
				<div class="pos4">
					<jdoc:include type="modules" name="position-4" style="none" />
					<div class="clearfix"></div>
				</div><!--End Pos4-->
				<?php endif; ?>
				<?php if ($this->countModules('position-5')): ?>
				<div class="bigimage">
					<jdoc:include type="modules" name="position-5" style="none" />
					<div class="clearfix"></div>
				</div><!--End Bigimage-->
				<?php endif; ?>
				<?php if ($this->countModules('position-6')): ?>
				<div class="pos6">
					<jdoc:include type="modules" name="position-6" style="none" />
					<div class="clearfix"></div>
				</div><!--End Pos6-->
				<?php endif; ?>
				<div class="clearfix"></div>
			</div><!--End Header-Inner-->
		</div><!--End Header-->
		
		<!-- user doboz -->	
		<?php $kepviselosegemMenu = $session->get('kepviselosegemMenu'); ?>
		<?php $loginLink = base64_encode(JURI::base().'index.php?option=com_temakorok&view=temakoroklist&task=browse&Itemid=888'); ?>
		<div id="userDoboz">
					   <?php if ($user->id == 0) {
						  ?>
						  <ul>
						  <li class="registIcon">&nbsp;
						    <a href="<?php echo JURI::base(); ?>index.php?option=com_users&view=registration"><span>Regist</span></a>
						  </li>
						  <li class="loginIcon">&nbsp;
						    <a class="modal" href="<?php echo JURI::base(); ?>index.php?option=com_users&view=login&return=<?php echo $loginLink; ?>&tmpl=component"><span>Login</span></a>
						  </li>
						  <li class="esemenyekIcon">&nbsp;
						    <a href="<?php echo JURI::base(); ?>index.php?option=com_uddeim&task=inbox"><span>Üzenetek</span></a>
						  </li>
						  </ul>	  
						  <?php	
					   } else {
						  ?>
						  <ul>
						  <li class="userIcon">&nbsp;
						    <var onclick="jQuery('#userMenu').show(1000);" style="cursor:pointer">
							  <div class="userAvatar"><?php echo getAvatar($user->id, 50); ?></div>
							</var>
							<br><?php echo $user->username; ?>
							<ul id="userMenu" style="display:none">
							  <li>
								<div style="text-align:right">
							    <button class="btnPopupClose" type="button" onclick="jQuery('#userMenu').hide()">&nbsp;</button>
								</div>
							  </li>
							  <li class="profilomIcon">&nbsp;
							    <a href="<?php echo JURI::base(); ?>index.php?option=com_users&view=profile&layout=edit"><span>Profilom</span></a>
							  </li>
							  <!-- li class="statisztikaIcon">&nbsp;
							    <a href=""><span>Statisztikám</span></a>
							  </li -->
							  <?php
							  if ($kepviselosegemMenu != '') 
								  echo '<li class="kepviselosegemMenu">&nbsp;<span>'.$kepviselosegemMenu.'</span></li>
								  ';
 							  ?>							  
							  <li class="accountDeleteIcon">&nbsp;
								<a href="index.php?option=com_tagok&view=tagok&task=deletemyaccount"><span>Fiokom törlése</span></a>
							  </li>	
							</ul>
						  </li>
						  <li class="esemenyekIcon">&nbsp;
								<a href="<?php echo JURI::base(); ?>index.php?option=com_uddeim&task=inbox&"><span>Üzenetek</span></a>
						  </li>
						  <li class="logoutIcon">&nbsp;
						    <var onclick="jQuery('#login-form').submit()" style="cursor:pointer">
							  <span>Kijelentkezés</span>
							<var>
						  </li>
						  </ul>	 
						  <?php	
					   }
					   ?>
		</div><!-- user doboz -->
		<div class="clearfix"></div>
		
		<!-- Begin Container content-->
		<div class="container-content">
			<?php if ($this->countModules('position-1')): ?>
			<div class="menuIcon" id="menuIcon">&nbsp;<span>Menu</span></div>
			<div class="navigation" id="navigation">
				<jdoc:include type="modules" name="position-1" style="none" />
				<div class="clearfix"></div>
			</div><!--End Navigation-->
			<?php endif; ?>
			<div class="row">

				<!-- csak címlapon -->
				<?php if  (($this->countModules('position-3') > 0) & ($option == 'com_temakorok')) : ?>
				<div class="pos3">
					<jdoc:include type="modules" name="position-3" style="none" />
					<div class="clearfix"></div>
				</div><!--End Pos3-->
				<?php endif; ?>

				<?php if ($this->countModules('position-2')): ?>
				<div class="pos2">
					<jdoc:include type="modules" name="position-2" style="" />
					<div class="clearfix"></div>
				</div><!--End Pos2-->
				<?php endif; ?>
			</div>
			<div class="row">
				<?php if ($this->countModules('position-8')): ?>
				<div id="sidebarleft" class="span3">
					<jdoc:include type="modules" name="position-8" style="well" /><!--End Position-8-->
				</div><!--End Sidebar Left-->
				<?php endif; ?>
				<div id="content" class="<?php echo $span;?>"<?php if ($option==com_temakorok) echo ' style="width:100%"';?>>
					
					<jdoc:include type="message" />

					<!-- magán üzenet értesítő -->
					<?php if ($user->id > 0) : ?>
						<?php
						  $db->setQuery('select count(*) cc 
						  from #__uddeim 
						  where toread = 0 and totrash = 0 and toid='.$db->quote($user->id));
						  $res = $db->loadObject();
						?>  
						<?php if (($res->cc >= 1) & ($user->id > 0)) : ?>
							<div class="pms_ertesito">
							<p>Önnek <var><?php echo $res->cc; ?></var> darab olvasattlan új üzenete érkezett&nbsp;
							   <a href="<?php echo JURI::base(); ?>index.php?option=com_uddeim&task=inbox&tmpl=component"
								 class="modal" rel="{handler: 'iframe', size: {x: 800, y: 600}}">Elolvasom</a>
							</p>
							</div>
						<?php endif; ?>
					<?php endif; ?>

					<div class="clearfix"></div>
					<div class="component">
						<jdoc:include type="component" />
					</div>
					<div class="clearfix"></div>
					
					<?php if ($this->countModules('position-9')) : ?>
					<jdoc:include type="modules" name="position-9" style="well" />
					<?php endif; ?><!--End Position-9-->
				</div><!--Content -->

				<?php if (($option != 'com_temakorok') & ($this->countModules('position-7') > 0)) :?>
				<div id="sidebarright" class="span3">
					<?php if ($this->countModules('position-7')) : ?>
					<jdoc:include type="modules" name="position-7" style="well" />
					<?php endif; ?><!--End Position-7-->
				</div><!--End Sidebar Right-->
				<?php endif; ?>
			</div><!--End Row-->
		</div><!--End Container Content-->
		<!-- Begin Footer -->
		<div class="footer">
			<jdoc:include type="modules" name="footer" style="none" />
			<p class="pull-right"><a href="#" id="back-top">&uarr; Top</a></p>
			<p>&copy; <?php echo $sitename; ?> <?php echo date('Y');?></p>
		</div>
		<!--End Footer-->
	</div><!--Container-->
	</center>
	
	<div class="modal fade" id="modal">
	  <div class="modal-dialog">
	    <button type="button" class="btnClose" onclick="jQuery('#modal').modal('hide');" style="float:right" ><span>close</span></button>
		<div class="modal-content" id="modal-content">
		  <iframe name="modal-iframe" width="600" height="600" frameborder="no" src="origo.hu"></iframe>
		</div>
	  </div>
	</div>	
	
	<?php if ($this->countModules('messageIE')): ?>
	<!--[if lte IE 7]>
	<div class="message-ie"><jdoc:include type="modules" name="messageIE" style="none" /></div>
	<![endif]-->
	<?php endif; ?>
	<jdoc:include type="modules" name="debug" style="none" />
	
	<script type="text/javascript">
	  jQuery(window).load(function(){
		  jQuery('.acymailing_lists').css('display','none');
		  jQuery('#menuIcon').click(function() {
			  jQuery('#navigation').show();
		  });
		  //SqueezeBox.setContent('iframe','http://origo.hu'); 
	  
	  });	
    </script>

</body>
</html>
