<?php
// a cron php command line -al futtat és annak a beállításai nem jók joomla keretrendszerhez.
function process_queue() {
  //variables
  $url = "http://li-de.tk/cron.php";
  //open connection
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  $result = curl_exec($ch);
  //clean up
  curl_close($ch);
  return $result;
}
$result = process_queue();
?>

