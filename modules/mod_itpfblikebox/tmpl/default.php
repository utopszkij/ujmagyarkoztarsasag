<?php
/**
 * @package      ITPrism Modules
 * @subpackage   ITPFacebookLikeBox
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPFacebookLikeBox is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined( "_JEXEC" ) or die;?>

<?php switch ($params->get("fbRendering",0)){ 
    
    case 1: // XFBML ?>

<?php if($params->get("facebookRootDiv", 1)) {?>
<div id="fb-root"></div>
<?php }?>

<?php if($params->get("fbLoadJsLib", 1)) {?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $locale;?>/all.js#xfbml=1<?php echo $facebookLikeAppId;?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php }?>
    
    <fb:like-box 
    href="<?php echo $params->get("fbPageLink");?>" 
    width="<?php echo $params->get("fbWidth");?>"
    height="<?php echo $params->get("fbHeight");?>"
    colorscheme="<?php echo $params->get("fbColour");?>" 
    show_faces="<?php echo (!$params->get("fbFaces")) ? "false" : "true";?>" 
    show_border="<?php echo (!$params->get("fbBorder")) ? "false": "true";?>" 
    stream="<?php echo (!$params->get("fbStream")) ? "false" : "true";?>" 
    header="<?php echo (!$params->get("fbHeader")) ? "false" : "true";?>"
    force_wall="<?php echo (!$params->get("facebookForceWall")) ? "false" : "true";?>"></fb:like-box>

<?php break; ?>


<?php case 2: // HTML5 ?>

<?php if($params->get("facebookRootDiv", 1)) {?>
<div id="fb-root"></div>
<?php }?>

<?php if($params->get("fbLoadJsLib", 1)) {?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $locale;?>/all.js#xfbml=1<?php echo $facebookLikeAppId;?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php }?>

	<div class="fb-like-box" 
	data-href="<?php echo $params->get("fbPageLink");?>" 
	data-width="<?php echo $params->get("fbWidth");?>" 
	data-height="<?php echo $params->get("fbHeight");?>" 
	data-colorscheme="<?php echo $params->get("fbColour");?>" 
	data-show-faces="<?php echo $params->get("fbFaces", 1); ?>" 
	data-show-border="<?php echo $params->get("fbBorder", 1);?>" 
	data-stream="<?php echo $params->get("fbStream", 1); ?>" 
	data-header="<?php echo $params->get("fbHeader", 1); ?>"
	data-force-wall="<?php echo (!$params->get("facebookForceWall")) ? "false" : "true";?>"></div>
<?php break; ?>


<?php default: // iframe ?>

<?php 
	$forceWall ="";
	if($params->get("facebookForceWall"))  {
		$forceWall = '&amp;force_wall=true';
	}
 ?>

<iframe 
src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $params->get("fbPageLink");?>&amp;locale=<?php echo $locale;?>&amp;width=<?php echo $params->get("fbWidth");?>&amp;colorscheme=<?php echo $params->get("fbColour");?>&amp;show_faces=<?php echo $params->get("fbFaces", 1);?>&amp;show_border=<?php echo (!$params->get("fbBorder")) ? "false" : "true";?>&amp;stream=<?php echo $params->get("fbStream", 1);?>&amp;header=<?php echo $params->get("fbHeader", 1);?>&amp;height=<?php echo $params->get("fbHeight");?><?php echo $facebookLikeAppId;?><?php echo $forceWall;?>"
scrolling="no" 
frameborder="0" 
style="border:none; overflow:hidden; width:<?php echo $params->get("fbWidth");?>px; height:<?php echo $params->get("fbHeight");?>px;" 
allowTransparency="true"></iframe>

<?php break; ?>

<?php }// END switch?>
