<?php
// emailes szavazás levél szöveg kialakitása
// ismert $temakor
//        $szavazas
//        $alternativak
//        $felado
//        $eredmenyLink
//        $meghivoLink
//        $szoveg
//        $cimek[$i]
$mailBody = '<div>
<p><img src="http://li-de.tk/images/banners/social-media_680x100l.png" /></p>
<h1><a href="http://li-de.tk">li-de.tk E-mailes szavazás</a></h1>
<h2>'.$szavazas->megnevezes.'</h2>
<div>'.$szavazas->leiras.'</div>
<hr />
<p>Ezen a szavazáson bárki részt vehet aki számára meghívó levél lett küldve.</p>
<p>Kattints arra az alternatívára amit a legmegfelelőbbnek tartasz!</p>
<p>Ez a levél csak egy szavazat leadására alkalmas, az igy leadott szavazás titkos; e-mail 
címed a web oldalon nem lesz látható.</p>

<p>cimed: '.$cimek[$i].'</p>
<ul>
';
foreach ($alternativak as $alt) {
  $link = JURI::base().'index.php?option=com_szavazasok&view=szavazasok&task=emailszavazat'.
  '&data='.encrypt($temakor.','.$szavazas->id.','.$alt->id.','.$cimek[$i], ENCRYPTION_KEY); 
  $mailBody .= '<li><a href="'.$link.'">'.$alt->megnevezes.'</a></li>';
}
$mailBody .= '
</ul>
<div>'.$szoveg.'</div>
<p><strong>Ezt a levelet levelező programoddal ne továbbitsd másoknak, mivel ezzel 
 csak egy szavazat adható le,<br /> 
 <a href="'.$meghivoLink.'">ha másokat meg akarsz hívni a szavazásra használd ezt a linket!</a></strong></p>
<p><a href="'.$eredmenyLink.'">A szavazás eredményéről ezen a linken tájékozódhatsz</a></p>
<p>&nbsp;</p> 
<p><strong>Ha érdekel az e-demokrácia, véleményt akarsz mondani más kérdésekben is, 
 szavazásokat akarsz indítani, segíteni akarsz a program fejlesztésében az e-demokrácia 
 elterjesztésében; akkor látogass el és regisztrálj a 
 <a href="http://li-de.tk">li-de.tk</a> oldalra!</strong></p>
 <p>&nbsp;</p>
 <p>Ennek a levélnek az elküldését a '.$felado.' címről kezdeményezték.</p>
</div>
';
?>