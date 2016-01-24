<?php
// átirányitás a vita_alt oldalra
?>
<center>
  <a href="index.php?option=com_szavazasok&view=vita_alt&task=vita_alt&temakor=<?php echo JRequest::getVar('temakor'); ?>">Rendben</a>
</center>
<script type="text/javascript">
  if (jQuery('#system-message').length == 0) {
     location = "index.php?option=com_szavazasok&view=vita_alt&task=vita_alt&temakor=<?php echo JRequest::getVar('temakor'); ?>"
 }
</script>