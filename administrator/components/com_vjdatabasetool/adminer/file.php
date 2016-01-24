<?php
/** Adminer - Compact database management
* @link http://www.adminer.org/
* @author Jakub Vrana, http://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');
error_reporting(6135); // errors and warnings
if (!defined('MyAdminerConst')) {
   die('Direct access not permitted');
}

define('_JEXEC', 1);

define('DS', DIRECTORY_SEPARATOR);

define('JPATH_BASE', dirname(__FILE__) . '/../../../../');

require_once JPATH_BASE . '/includes/defines.php';

require_once JPATH_BASE . '/includes/framework.php';

JFactory::getApplication('administrator');

if (!JFactory::getUser()->authorise('core.admin'))
{
    exit;
}

// disable filter.default
$filter = !ereg('^(unsafe_raw)?$', ini_get("filter.default"));
if ($filter || ini_get("filter.default_flags")) {
	foreach (array('_GET', '_POST', '_COOKIE', '_SERVER') as $val) {
		$unsafe = filter_input_array(constant("INPUT$val"), FILTER_UNSAFE_RAW);
		if ($unsafe) {
			$$val = $unsafe;
		}
	}
}

if (function_exists("mb_internal_encoding")) {
	mb_internal_encoding("8bit");
}

// used only in compiled file
if (isset($_GET["file"])) {
	
if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
	header("HTTP/1.1 304 Not Modified");
	exit;
}

header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365*24*60*60) . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

if ($_GET["file"] == "favicon.ico") {
	header("Content-Type: image/x-icon");
	echo lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃşÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ıÀ/(%Œ\0");
} elseif ($_GET["file"] == "default.css") {
	header("Content-Type: text/css; charset=utf-8");
	echo lzw_decompress("\n1Ì‡“ÙŒŞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Şn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1Ìs˜´ç-4™‡fÓ	ÈÎi7†³é†„ŒFÃ©–¨a'3IĞÊd«Â!S±æ¾:4ç§+Mdåg¯‹¬Çƒ¡îöt™°c‘†£õãé b{H(Æ“Ñ”t1É)tÚ}F¦p0™•8è\\82›DL>‚9`'C¡¼Û—889¤È xQØş\0îe4™ÍQÊ˜lÁ­P±¿V‰Åbñ‘—½T4²\\W/™æéÕ\n€` 7\"hÄq¹è4ZM6£TÖ\r­r\\–¶C{hÛ7\rÓx67Î©ºJÊ‡2.3å9ˆKë¢H¢,Œ!m”Æ†o\$ã¹.[\r&î#\$²<ÁˆfÍ)Z£\0=Ïr¨9ÃÜjÎªJ è0«c,|Î=‘Ãâù½êš¡Rs_6£„İ·­û‚áÉí€Z6£2B¾p\\-‡1s2ÉÒ>ƒ X:\rÜº–È3»bšÃ¼Í-8SLõÀí¼ÉK.ü´-ÜÒ¥\rH@mlá:¢ëµ;®úş¦îJ£0LRĞ2´!è¿«åAêˆÆ2¤	mıÑí0eIÁ­-:U\rüã9ÔõMWL»0û¹GcJv2(ëëF9`Â<‡J„7+Ëš~ •}DJµ½HWÍSNÖÇïe×u]1Ì¥(OÔLĞª<lşÒR[u&ªƒHÚ3vò€›ÜUˆt6·Ã\$Á6àßàX\"˜<£»}:O‹ä<3xÅO¤8óğ> ÌììCÎÚï1ƒ¢ÕHRâ¹ÕS–d9ªà¹%µU1–Snæa|.÷Ô`ê 8£ ¶:#€ÊàCÎ2‹¸*[oá†4X~œ7j \\ÁÃê6/¨09\rŞ;Êô;Vù„n¨nªÊØŞ‰v«k«HB%À.k\">º¡[ë­\n¼¬°lÍápÔ9ÒcFZsÍÒ|Ú>6 œ5­l1VçÒÎê6ÃØà7¬Œ:£\"AzŠ½de´å˜ı\\í5*ÿÕ´Ÿ]£p[*‡Am)Kt[»\n8g=;úúæ2z¾àÃ|üòÌ£4˜t8.üÅìN#ßÊ²Œ¿B\"Ë9°Øú%¨ªè„HQwˆqd²àFûû¤\$&V¦–Q#Q'×ò‹_Øm¡Ì¡µ· ˆ¡Ş\rĞà´hà Xrt0j5¤Œñâ½W‡øõ4µúÇ×“€mÕÿ•‡\"CA¸F!Ïì—–h>ßb0ˆ0 7;84Kaˆ¨Ò	\0Ôp	a‡€ÑHXF±Š1:÷8ìU9H‰IÃ³Ë;ÙsQ7F¤‹cLpXM@e˜şÉüƒå+g(›Ğ73Oì3pÆî•b®lEE>·Chb%²DÀI8²ÉE'Ì	#)ù=%C£€jYù1°ĞyÕh;cA‘6ãjKû\ráÁİ9Â˜\$|­–’¼øËg-Zˆo—\0ˆ“òz‰³\$+D¿°æV±w*ÓWƒpæJ›†\\û²FŸO³'É²a1Àm,_Ú§\r‹ä1‡Päo±;\0Ğ5°æíÁe\r& 3ğ^\r™µ6åMR2T\0¹à5?~‚5˜—ªP>‚85h¹ nì1;ÒÍ\rRL8`Á\\¤Ğ@ŒÒ`;z\ní\0ĞÔƒ8Áˆ9RÔyZP@¾ib?Æ­v\$ƒ<Ä%	A\ré?œ\0ÇSÊ¥¤¡í  ÌBÃ4JÒ¨ƒ:Á`#Hi¿7Îµº+}àîªÕvî¥°o¦J´ÀVÚ°‰Ú9ÕĞßWÁ2¬Q®\rØTáD`¯fâÑ ‹­wéLµ˜³£œI]MKd7*rk*j\nASæÂjFÙ-[ezzÏr²íÊfUø3Øæ~\\àüZ£¤Z’”{)¢ò>>Ğƒp¿…*«¤Á‚;zDbáwÔÊ]¤mC\nƒõœè¨“ÃKBôŞB£¡Šm@Æœ¬ÏÖ´>§¶õÏÍwUÂ’İ*Nô(ba¡Æ¶Š@fvÙ)­µ`·\0ußD)mD@/4öÒãë9j‰ˆíú¹ªëHBm1ˆ²I¨£5DÀ¶RuEÆÒ9 åAÓ—=1bİ0çŠe¿yÔØ1ûãsä¡;´Äô‚ĞÚÃĞ-¥ØËó†]s¡ˆ5–\\…‘\n1;Èè­×QÜ^©Êb“¬i;YJ2ƒd!sÁ”÷ƒ#ñkgÃhŞ]êW)>VÆ…I—x]Ãr³Ÿ÷;6ÒJLcpr°d{pyó¹Mıè-UVHè5'\nt®„Ğ²¤lÓÊşpHÛÂÍo°eÁZ€Ï¨Óùq’eÉÑXÛFé`Gy\rç½!î›Ww*íÁ‡¿D¯ôu­t%Œ¹šdàQğë¯/Õp™:şihÀt&ú˜ğPÅÌe,JÍŒÊàtÃ!ìOØ7´Ò6µGgRúƒšC[òËskëvqU¡}y©hëAGV²Ş×Ï|ÚlF Ş…L^Ê.ñŞ]u&w!ßÚ[jnŒnÀàÚ[kƒCÅàvÀßÁ÷k–rmOÉ­¾ÙJ>°ïWTâ0Şÿ·¼\n£pMãCø®¹½b›tÂ÷VG|oy8ô§Èù¯cé°èĞú");
} elseif ($_GET["file"] == "functions.js") {
	header("Content-Type: text/javascript; charset=utf-8");
	echo lzw_decompress("f:›ŒgCI¼Ü\n:Ìæsa”Pi2\nOgc	Èe6L†óÔÚe7Æs)Ğ‹\rÈHG’I’ÆÆ3a„æs'cãÑDÊi6œNŒ£ÑèœÑ2Hãñ8œuF¤R…#³””êr7‡#©”v}€@ `QŒŞo5šaÔIœÜ,2O'8”R-q:PÍÆS¸(ˆa¼Š*wƒ(¸ç%¿àp’<F)Ünx8äzA\"³Z-CÛe¸V'ˆ§ƒ¦ªs¢äqÕû;NF“1ä­²9ëğG¼Í¦'0™\r¦›ÙÈ¿±9n`ÃÑ€œX1©İG3Ìàtee9Š®:NeíŠıN±ĞOSòzøc‘Œzl`5âãÈß	³3âñyßü8.Š\rãÎ¹PÜú\rƒ@£®Ø\\1\rã ó\0‚@2j8Ø—=.º¦° -rÈÃ¡¨¬0ŠèQ¨êŠºhÄb¼Œì`À»^9‹qÚE!£ ’7)#Àºª*ÊÀQÆÈ‹\0ŠØÒ1«Èæ\"‘hÊ>ƒØú°ĞĞÆÚ-C \"’äX®‡S`\\¼¤FÖ¬h8àŠ²â Â3§£`X:Oñš,ª‡«Úú)£8ŠÒ<BğNĞƒ;>9Á8Òó‡c¼<‡#0Lª³˜Ê9”ç?§(øR‰#êe=ª©\n«Ãêª:*êÊ0ÖD³Ê9C±ˆ×@ĞÖ{ZO³ıêİ8­¦iªoV¨v¢k¨Arª8&£…ğø..ƒÑcH¡EĞ>H_h“ÎÕWUÙ5áô1r*œ¦Îö^Ğ(ÛbàxÜ¡Y1°ÚÔ&XHä6…Ø“.9‡x°Pé\r.`v4‡˜”¶†Ã8è4daXV‰6FÔÕEğHHºfc-^=äÂŞt™İx‹Y\rš%ö«xe çQû,X=1!ºsvéjèkQ2É“%ÚW?öÃÅ®Œ´æ=dY&Ù“¤VX4åÙ€Ì\\—5ĞßãXÃ¬!×}âæµNç¡gvÚƒWY*ÛQÅèi&ÈğlÃÎÑµZ#–İãñ Õ‘\rAç\$e°v5o#Ş›¢Øü¶5gc3MTC£L>vÎHéÜÃú–§<`ø°Ú* ]‚_ˆ£;%Ë;îÚV–ùi“Àèã4XÃé–'”Œ`ºªÉãi×j0g¶O±†Û¥“iæŒì©9·Æ™Û’dİFêÊÙk/lÅ¸–nÄÜc<b\n‰¨8×`‘H“ëeÅ}]\$Ò²úÖâ í°!†ÀÒÃC)±\$ °šAğ×`ó\0'•€&\0BÎ!íŒ)¥ò˜´5E)äÁàÒÂo\r„Ô8r`ûÈÌ!2ê­TÁ›s=¯DË©Õ>\n/ÅlğÓ‰’•[ı˜Å PÛàa‡8%ø!İ1v/¥¥SUcoJ¨:”4J+Bàó‡µv¯Jü‚\ráâÂb{ƒ ,|\0î°zöƒcÜªÅY§Ål®\nüœi.õÜ!äÛ)ü¦dmîJ«¯ÑÈ!'ÒÁë B\nC\\i\$J˜\"¾ëÖ2È+çIkJ––ñ\$Š‘’âG™y\$#Ü²i/¦CAb¾Ìb‚C(á˜:°ÊUX˜¯”2&	Ç, Q;~/¥õKy9×Ø?\r6¾°tVÊéÑ!º6‡CP³	hYëEÁÓÎØâ£ölñä(Ø–TáÒp'3ƒĞC<Ødc®¸?°yCçóşe0¼@&A?È=¤å%³A:JD&SQ˜Ñ6RÌ)A˜Ğb`0Ú@ˆéu9(!0R\n‡F „•ÂŠ ÄwC\\‰©Œ¤Ï…rÔäÜ™¡î¤#•~ğØ2'\$¡ :ĞØKÁ`h¬³@‰£Ebó¢[Ğ~¡Ñé’â TæÅlf5ª³BR]±{\"-¤Ğ\0è­ÊL>\rÇ\$@š\n(&\rÁˆ9‡\0vh*É‡°–*ÆXë!_djˆ˜ƒ†åpy¹‡‚¶‘`ájYwJ‚\$ØRªˆ(uaM+Áêníxs‚pU^€Ap`Í¤Iì’HÖ\n¨f—02É)!4aù9	À¢ê•EwCİĞ¡˜“Ë© ‰L×PÔİÄşAiĞ)êpø3äAuâÀöıAIAÉHu	ç!gÍ•’U”‰ZU·À¼c¤*­´À°M„ÃxfÆ:ËÆ^ÃXp+‘V°†±á²K‰C#+¾ ÖWhúCP!ÈÇÀ;”[pn\\%˜´k\0„ô²²,Ú¨8à7ã¬xQC\nY\röbÿ£XvC d\nA¼;‚‡lF,_wrğ4RPïù»HAµ!ô;™‰&^Í²…\"6;œå²êÎ=÷#CíI¡¸¯9fé'¬:¸ŸDY!ŒÿB+˜s¡xV†8lçÃ“¡\"Ïé‘ƒÍHU%\"Z6³Ôu\r©e0[Á•pÄßØa¡è.…À¶ +^`œ`b§5#CM‰\$² ûIçîËšAÌP§5C\rı S•dêWN6H[ïSR½µ·êß\\+Xë=k­õÎ»×ºş¼S”¶Ór^(¦ƒoo¶7™¬Ï©\\huk¢lHaC(màìşønRB†¤Uup³Ú2C1š[Æ|Ù½ùbeG0ĞÙ\"ìCG±²?\$x7Ğßn­¤\$ZÎ=ŸZÓ¦Ãsi5ËfÏí&ç,®fÓhiÆIÎyÖnî¶2ò0ÚœDvEüÃTïxôúMå{àô`Ü¤ÁGN#é‚Z,«Âƒ/âR\$”#\\I-	®„°—|Ä0à-0ı‰Nî¦P·ÉÒ¤;s-˜vô–ÏÒ†ÿ½‡nwGtï…n”¡ÒdiáH×|¥˜4¤(½¼+¼vò¥İ&ØÅ…’+KÀ£Ìñ™L\nJ\$Ô©ı†¨µ:\\Q<WB\"^—Íñ¤ºWTIB~Ñßq¬Éåğ}ó3ŸÎ¿\":şU‡á­Ö|\r5n(n™­ˆ‡ Ù7ƒÌOÁD}B}‹¼¨æÊ\0\r“voÜ•„…·Ø†_Jl‚Ä°•H3‘\"®[Ä¸âå¾ÔKŠAµ`ß–ù¯¦NÉÂü&(‚)\"ˆ fÿ&Å\0°¦ b¾ò¨lãF.Âjròî”şâJÂˆÆ\"P<\$F°*é|f/Ş! İOççŒpR Ç™„F#5gäbã Ä8eRDi¸É0“P‚+*¬üÆı™kZ;ÃpHh¦®l!è\0\r\nc›oÈ/¿úCBˆ<pyÀNTH½hêTç	ğ@éğpxÌ\$¢Šæ°ÌÀÖ48\n€Ò#îNU,Óˆš\$Pémò YKü¬\"H Ò †RıL¸ı‹®©DŸ\0‰¿âˆ€aWˆ`pûïşúĞgğ¯êlP¤Âÿoú:L€·Ê+\0 ]0±<)‚öN«xk\n(`cê„+r·k{m\"â3.0±H1’e*ZoeBÌ‹9\rÈøÚ\0RLi¥Q¨UğÔ‹`äÂ.”ûñÂ–o:Åd€´Â’µT7QœÑV »ÉDh‘âWæ´ëS1ñ	ñøgæ*2¯‘,†W)°Á@çÏ°T@C	Q(ñ,™Å4æ#d<Ò’\0¦! á\$˜ú2 {es¢´+…rÊ«şÍìÎJvY*ŒHPr\r¤‚†ÍTÜM\\\\`¼¿ívíàæ<ñ«&ÄnôD\\HHÈoj^@¢Ú	 Â<ñŠ†¯ëÆ8Š“*#fò©*Çş\r\nT§ \\\r²«*çTª^* ÚÉ Ê\$ª6oŞ7òĞRee8³ Êç²¡,Ò¥,Ó,`|9°K2Ï0r±+Ò§1RÖä\"È Õ* P*å¾È†M\\\rbà0\0ÂY\"ª\"ºUx†Ù`°±êÈ€àQ“E\rÀ~Q@5 ™5sZ³^fÀR@Q4ÈdÀ‚5Ãb\0@ÔFób/€8\"	8s‹8â<@šƒãìl2\$Sh± ¨\nÎR\"Uì43FNÉ«7\"D\rä4úOI3Â˜\n\0\n`¨``³â Y2Êğobñ3óË<n6“]<`ì\"’Ó Nˆ\"B2àZ\nˆüm¥ àEÀƒëîé\0ğ£üàZxÀ[2Â@,Â’’÷<Pİ?ô\rÔ8#d<@°´JUŠ¬K/E¡;\$«6óÌS”DU	l;¤,UÏLÎ’ñ7fcG\"EG€ó\$£¨\"E€Ù3FHÆ¤I“Ìãd‘=e	!ÒUHĞ‘23&jŠÈ¬Ó*úÂ%%Ó%2“,ŒÓJQ1HÌl0tY3öÁ\$X<CÄtà4ë_\$\0©ã>/F\nç¢?mF¬jÖ3¥p«Dá„HKœv ÈºÉœ\0Xâ*\rÊšåÑ\n0Ÿ‘e\nÎ%ïœºäÁ\riûÄêO€Ãfl‰Nö©M%]U¬Q¹Q½Lé­-†÷SÂ±T4Ğ! äU5T\nn˜di0#ˆEŠªM£ˆ³«i.ª°/U ¸é\rZFšúÓj„®¨;¢òíHÏâ˜d`m¤İ©ú–Ğ\nıt„ƒQS	eé²³|Ùi²šñ¬ÁQt¦ dò12,›öÁDYò1UQSU¬±cd±«µÄEˆ)\\«–¶ÂLö	ìF\$¶@öå³Vï{W6\"LlTÄëAò\$6abã‹OäêdrÌÉLp†c,’¨esÎ¨<2ì`Æ@b€XP\$3ààŒ@ËƒP,úKÍVÕ­^õ¾àÏM”‡Lö°¸ué1şÙ@îc•ˆt-ä( ¸ `\0‚9¶nïç2sb„¡Ê/ ĞFmä)¶ôƒ´ÿHl5ó@ÏnÌl\$‡q+ğ:®Â/ ¤ø§dŒÏ,òà\n€Şµˆì„£.4ú–’\$ ³w0\$€d·V0 È´\"¾ÃrìöW4678íVtqBau÷pÃ€ŠI<\$#Åx`Éwd9×^*kƒu×ofBEp	g2³Íóf4 à‰L!êr=¬\0§ñ\"	Ú\r<êÕhöÓÒæöˆU…%TÓhËëBkòº#>Å'C¥p\n ¤	(‚\r´ú2ö‡Â\"3â‹l•õMÔ‹7ıGÅx.ˆ,ÖUuØ%Dtø Ãw¶y^­Mf\" ‚ŠƒŞ(vU„3„u¬£J^HC_IU–YkS…—‡c_ylc†c]rF÷å×_q¤%†W#]@Ër²kv×3-ãcyÄÏVHJG<€Z¥öTè@V¸8œ\$6‡oƒ2H@˜\rã‚äÂª\0Âˆ=Øİö·æ¹\"3‹9zõ²:KõúÂu¯K >‚¢Œ¿B\$Ârİ.äJÒê<KõG~àP¿X´€QMÆ¹	XŒ‰w\$;Êæmp”Zp• åcK!OeOO¸?ïwpæÄæ‡¤í†Ö ¦ÚL—¶I\nŒğ•?9xB¤.]O:V®„˜ß9ßÃ.ÅmWŠ\0Ë—s>”*´l'«õk­Æoph»’èx¼‹‹«Şv´L`w1”÷° €è!¸M¨4\"òI\$Õ÷\"oõ\$À >Ë™Bea\"™ñŸDÿBoƒÊ¶ü+ì B0PxpŠ«&àá7Ã|p{|·Ï}7Ö°Â\$-P£‰‚éú@b„…¤õe¤ÆåÊVYmoMoŠ\0¢§£Nzn*>İÎ„€)¢ò·Èˆ×-H‡l!®“¼hpÆgÙË Š’¼Û&tZøãœ¤\0!‚¦8 É©¸¨àºZKŠê@DZG…Œ•Ÿº®øæ¶F€ç§©.† ˆ¼l¢üz%ÈÎ(ä¶xÙ}­ú'<šıÅª(°¼¥ú°ê<ÚXZÇ¬ºÚÑšà° É®g´ºí§ºò‡òw¯ºzÔz{°e¸'{;@å™±(&ø²ÅRà^Eèİ›xºå®›Y®ñ\"ËÌë¥MÜ’çç–VöÚ\n§5Ózl¥zrÔ[xŸ²Ëª’¥ú“»G\$O W @¤½À«Z¹xÇÎÕÄò­,Ì•”be»‰ 	ˆf£dÆ»Ğ2ûÕEÃ‹‹I¼D‘YTÙ%kš{ÎJ­\\\rºU N Å'¼_¾ÛÉ½»f|wŞµûàË,½l«7ªktø1RD>öĞ‹X‰ZîÍĞŠ­|y|Z{|×Õ¢Èî\r—é%;¬#\0eZ,\rKt\r¶>ãŞ>\$ò>ƒì?„?cú?ä+€ä@„ò¥ €Æã@Ê°•Œã‚cãqˆfcÆÒ+Ç3È˜ƒˆ’Ø€&x•]€N·Ğö*|ÈÕb2<lnTåÖ\$£AÌû¢Z0.àÆ&üßË·ö¼`{Ëp,ì@üø&|í•îÏ–.ÒÒ.oo¢@ƒÎÛä1=\$9{¼ÉdB;¿“õ×”#Æ:£Õ\$@wÒ£Ø=ÜùËC?Ğ Õ(ı?ÓƒÖ ÙG1†|ø\"]Ó\0ÊüÈ5û\0Ej\rÀÖ@@*¢2KLº#d* äCAĞ3,K`æ Øı¢«C±ÙÏ­Ú¤Ûü÷Æà]Ùã\rÚL9Û°“=Â“<–·]¸(ÔjCø) í,âçÚBf\ràÚä ë£-Rd5ãö\$\0^\n4¤\0ÏÚ¢Š­SYİÜ††k‚€Î4ıè@¤B\0çÉÀWßâ?x(ƒüœu}½ÜÚ ¿ä½ÅİÊK~P\r¹å¥/à¾E\"½¿Û#éá>R_çôâ¸\$< ¢Ì\rÇlà[à‰¾¿*Ö`\n ‡èí~Á½bÜù½]‚İj·B\r½qË£Qê¾¼+ı(üW|àèå+Šep9Ñj}R<´w@‚çÉdbÌ´ƒÕèÊÀQÕ¤Š‚Í€Â/(ç¨¦mÔ‘I_Ô}U<àİÕ¸ÇĞ—ByÑ÷¸ó¤_ñf¥&FÍŒÁ·F.} zhçÀy—©¹Fcæ†ÔÏrUÛ«Fq›³:’\n€ä\n%ÇÎï`ç–ĞD@ò³{¢ôˆ–Õßñ‰öÿs/wh]Bz\"JÁ#àãˆƒfÀ€ÉúûÛTC“¥ş _²ïƒdZØ öÖ£m2n´nC’èKã§G\\9(ëB†o« Ëğ…Sü#â†|À£™d)Eó‘Ş€Ä|Ãë,€€bgÊ1N1u»P91Ê\0ˆ‰T\0“<öp>iJ²Šƒ6p\r-ÄÀ¶S0¡t¯ÂHJÙ` 7DcÀœšp)‹\nß¢\\¨¤ĞÎ%¬aüÌáQù¢ î¾CÑfƒ¦é’úã‚½õà6\nŠe·Œ\n>Ò@%h°%I	“`§\0çuAX¢K‚ü	`Ã8+€öI\\(Ô\rÅ„¯\0î¤lúH#]*y\$°ÀÚ,Hü?EÅF±C7™`È›E@rG´p‡LB3H,•0Ö+s\r\0è²\0ò!¢9„Hua4¹ÂË áƒ0¢aJË(°\0Á¤Dq°gÀ¸aJ!Á‹m~A¦a&Ã ƒ/ *p“¤\"ËIà‡BDÄ\r!†9!v‡L‘:„ñÄŠã!\$±šA‡KñĞàëeŞÃ\0öl°b	iÀ¹6%®YzKrlRK’\"AF{ 6ˆ»XHó&‡:h~Ïè9àÈ_Ö2Ws>œèˆÖ\$ÈĞ‹ã¢ª¤ °†©p²C@vz°0´¸Ö‡8ÔÒ\\„v´¬Îp:s_\\€:¼ÙY\rB€Òöá\$|Ÿ­Åi©G›‘¢R#„	YR9Â\0D28?é©ñ+}YÓâĞá©‡J#¦CûiV‹CT6ùQ9±àpite¼Läàp\$¼4Š\$D#’@@°ô<AÏÍPÜ‘ÖÅ\0‡f§!Ùäâ“Ğ°¥)B2YZ\0è. ‘˜SÁ²(ËÃòÀ. 4b1‹H‡Ò`Ø³¨Y)èŠâRâÄ‚ø¼ `1ègÓĞĞªH:B]ŠO#8Â€œK±ˆÛ\nÊjD%C*I\$AiÑÀæN,0	 K(\0¤Tù`\n2OB7Àøˆ¾4Q¤CH	„º4@Š¥Ê )\$\0	ÀJqŸÄÜ+°ÓKìeÀØ&.„J'pÒ=pŞÀQ´½èêÂ[xXbá <EÑ'Dì#Ù€Â`3½øäë60@@èÚ¦õ‡ `|ŠRì€¾ô5Úñ.ñò Ş×Á?#?lS\"!µjE„ôq€\0º£ ğüÆQ—ÑÉ\räT#<°üŠˆ?1½(HB–ĞFL¬å[|„@LE§Ü†Ê&QÛ:yÄ³€âFh4qœŠˆÏã–U ¯Ä\"!C1ëFJ8#@üÆf:dÑ‘8#2CÈ8æ2.\$´Cbğ´|\$¾0â˜ÊÎrÓI\0€,€Â˜00ÇK¬e!°N÷×i@d|á5‡Äh`‚Ã	Tˆ…U2Nj óiì0€UdkÀÂ*&j—F8*ÃE£´‡âzcÎ¬€¨Î—s¦•æÃ‚˜5ïÀ7£\n\räíUé,Ğ2â`”ƒ @äÂ¹¬Ë@X*²p:-,\rRZ L¥,Êƒ|·œàlº^éOá0×	BCÌR‡n˜œÔVé¡ñ³ì“ ¯åTé]·Mréü™à#€¹y†\\\"y \$Ï¤³/ r*h”î%Ğ1´KõêÜˆÏ|R`bBµ8¹rò1’çn\0å¤		Ì\ràU8±lùtBš (ƒ†‚È\0003:‡†·Œ%´ -|»\0öeTH\"Hğq4(ğN\\jc·šª¨…TÆH\n¸\0€İmÑ3ç?1S:>|g¡ŸÛRcŒ´ôøªª\rèF8Q&ñ„@5r\0ÌÆXVú5\\ñf¡h@v,˜èÃ/\0\n&–/!ŒÇdq°šKRËàÆm;ØaD2 ”†d\0002ºæb\$	®Lè/1•…,ÂEÇ4¹…‹@<â¢}aÛŒæ\$Â²1*ƒË`Æ>0‹ :´àd 	-	Ã„\rDËYl(6[6kàsfèÁ' 8IÉŒTó•JDUD:AÓ2Úhd\0a\0†ÙÆÍ)2ë:´¹B3:€†‰‚Z1=–œµ@ë-qN\\!¤\$’k§fƒàÙNÚw	—’îš”‰‰´†`Àn\$LÎCR¨ƒÍô«5pcE3CaÀ°\0=HjÚ’g—»Åó-Ú˜‰E°e£.\0¡!oˆ,Ò'‘wæI`\\s6ÀRøìEÒ}e0F\\öãm±|F>q ?jĞ”æ6išíp	» +ÀNõéıûÂÍúßÈ9åÕqu¦pè®2eÉ‘‰ım.Š+L~\$\"ˆˆĞR s]iŸ×qCÀĞ˜<T(iœÛŒQêÅbtÔ\"‘©NñBºÒmÆ°€@rèÂ‹ÌÇxMM„qÁ#Oj /	 LöD’Kú.¸Ùt0tI¥eBºĞj„”1‰¡â6Š0~sÔ74íbQŠQ¦!À2ãÔ–àËÇ¼ˆD…£HĞØ2¦PñşdîˆmMÀº DÖˆF¬fÈ¹\rµDj\$¾‰L¾[\0ã`•ö¡Î<@mØV~9¨ v4Š=!Ÿüˆ’2šÙ’¡6ı'Äí*DÒ”´‚úâ›#©Ñ\0Ş¿{»…'Ê2‘lLR—J’Š™£ÑX Ã«,Eã(C¨\\ÃG¢ş¨Ó;/§ÚÑäÄRğ\$ŠùdÀ¬\$¾QJ`Ï„!Ò®Š™Kâ\n|¶9¡T–dxÌ@¸h!'¦øÊEÌã-™v}bÉ;|cfLéııÂYAROéÚ‡|3êEgšzQfî@líó/i™¾ÑôoÖE†Å—go^q¢\nAaÎ”gË°!ù«@òRÓì4ÂÉ1lE!‘p”ôH0ÊjbÌúqA¢ÉaÍ@xTŠ§Âİ™\0\r¦F­¹¹©45HşZm=øxšF‡CÌ™˜†’v?CšL¯2‰}hfX¸Ä\$`Iâäb \0Ä­7àGäéDÅ©ºÎ²fP9Uš­`\"é–­á¾ô\rÁ°IjÔÊ¶Tí\rUz«á‡*ş«TŠ½!CI`ÊáßX2 Qó£k#Ô…\ne†e+[l~:°È~²hn	Ğhˆ'Í™Î§UV¨ÊÀNºWL½ÿÕ‹Q=)nIª­¾²µÒ„Ò„æ^Y·úò¬•pUƒO‚AXZ¿UÕµ‰’¸Sà“«••\\­Ø@Crá\"ÖüîÍ„;Å^EÊÀ-x\rèı\\ûP™Óà òv!I:Z	¡\\¥_×2CP€tWYŠ®Ì° À_]a+´=s»„í]¢uC-hë* êæ×Òº	{­ÉŞ+óZúıËD\$°c\$-vÛBÿPÌ.®ÕòsÂ¤û2åRüéj[ZÜ/QÅQ:º¢Æÿ1Yå+Ú¾‰Ú¾…!²S³bÁ™ä9æ–ZyÚÅºb,t0åÙf=@×\r -˜\nB-ÉŸ0¤&2_¥9ƒ¥’ñhM,×‘2HãoTÆŞlbd¢“… ¶ \0‰[à\"³%AÖ¾Û4;2Í’d.ÄÚË—H¾Zb545HÀ\\ûÊ“T ĞA ˜‰Œ—RBÊ„Ö¤é-ğÛl¦ÚJsÏ6\"± È‚k=œºŸ¶…¦< >²•jZgæx`Ë6•Àt«.ÙÉãb,œÍ©™¸k·óY¸\\`'³ˆSlÙjÕ°!lnÌ…›\0Wg+:+’c6~´¢‚ŠKFÚÊ–Ä©-±¤¡h9-…–H@SDúG×;ÈÎ ­ûƒ_†å	\nê)ˆ¨fnå¢äQ-*¦CÖ©ïí£{üMSnZED\0)­å¶Pg]Ë®Á6¯´†b%ó%²‰Hj&%-* 9}ˆj43@Ù*(mº\$QD¶ùÛ†èĞÒ¹(äİmÂ¼ukjO¥\" ,1£‚ÄôVv¼%s“1k®P`ƒ	ù¡€/@œŸ0>F‰>#±¬X‡À8%lâ´¹K£ÚS|¹Yw0uÌ§bÃ‰ÑX4p\0\n‰Õàùçºæ·º%Ó\0ZşQ2WéWEºkñ«çoÉ‡·jë¢y§	ğ.Z\0ª	PpĞt“H³‡ÏRğ>ÓË,%)ñkºŠî÷`|¤«,prZÓhÍŠ›Z,P¶º|ôù™CFLñxªnñú »‹‡.æ›¥PRe’ÔV„oB;xD††”k‰)§M?nÓ`ÒÊ/¡5IlËqh\0Ä×¦À5Eh qéí´·½A‚Ë‰UÙæd÷ˆkD”…Oy;‘ÎòÆ†¼Ã«â§A.OróÆ„¾!ÛïHÓ^Ò‹D3½Iàèg‹Ö>’õéc…ìe~ëÛZÈo—Î™­™¶n£_^ò+·¾!ÙÇh¥|*3Ş¢ëG€¢é´[‰n˜ª´ÜÚ¶íjô¢p¯ş—ö7H½/ò¾ÓTİü+÷İ3›ùlP{<2îù‡ÊĞ©â)\"Ã£Ş£¶¢YË£§A2€‹:ûÖò·&\0Ûƒ~cKîÉÀ\nìãD—4GNªg.`ÍRB1ÆH.jà{Áè}n·|—øÏ/˜ñ¸oä¶€¨×`]ØÏf_6Ãy`¬\r x^@ÔğâŠ\\Rş=ı'Ï‚ƒé_{X-˜Íõ\\)LÉEÑÃ¯Â‰ŒáPÏ¤l\\\0]…¡hareÓ8’N®¥‚ÜG^şŠI:™ˆßÜµ¬J%rÓ~œ-Ü	1”g¯‚+gV£oÏƒ«zmÓé>54‰)mşøm–\$oûEb¶ŒóÜ’)mÍEìÑ¨¥æİK6!*\në†Ó”qî	Ã0?’Şw…¾PK­gÃ1âi‰³~X`\0X€æYç	ÒZ *Dhœùã1EÁl…Ôóğã¸\r\0:?\r>Ğ‚#2¡@´3Ûh2éÀè¢°™´Ã†&àêOĞµ.¢É„»•(.L<r‡áàK#á’@Aª[,L…54›<!µrğÑ,áàYI²HïÑd)+l\$U\\|âúŞ'…Áİ£TÂØá\0ñ'’ÂÏ\$ÿ;\0ÑÍÙµQÔèwÅÖ¹~âŒ´0qt^2yŒ£®áL.ŠˆŸ•a{(!—Ô*\0i~?9êÃ„Gµl2²3¶v4 ?f[rÄÔ†;AŒYn²î) ’Âƒ&ˆ‹ŒP2D@€õıã Î]Æw–K2xº .špËÀ[4³u6Ë(Ç} J3É\0x\\¿T\\)!Ì>bV†„³á¦EÑŒ€s—÷æ:ĞÆ8Ì8{Ì>Ï‡€AùoÉÔHryŠ‘ÙúS‰dÍvmór×ƒfÃë­Í>jO¥\n¬Ã€·5‘„Í‚Ö³A›0Âæ×0à2Î>nòû›ÜfıÑÙÂ16q3·ÕÂ”]+ŠaúrëFÙâx6	S-3e™+xÙûÌ¤Óó/jñhD\r•½-\n“Ñ˜”“G7™€©‚z2i’Ôô.·A9×Ğf`²Y™³Tæxò9ßÅë´\"^\\Önëéèİ£sÀ9ÌñÂÏÂë{0sš83ä\$˜:#‚ı3ĞİYû6¯{0ø\nóJ\$ç#D©\\ÎÄ¼¢™œÑŸ@âƒĞ3u¤0½ç°\"*ˆ….rs££æØ›™èÆèå5’íéÈG_ÈD×dHğ¸Km]ÈÌà\\4\0;d}¤[S2ÜœİîÇ×}Ş“÷ªKd—& tÈrf	*jÊ+ÉPx—¥Ü\r˜7ËM8A¶[#ØÔm†—\nĞ\nğ§€¯9¡ö+şZÂ–ÕH›|H[ª€_ªÅº†|š¢j5H¥|ºéßU1„Õ^«u]«áP L`X¼gh ò_rıÉ—såmæZ:l]ihÍs—Kèç†>¹šöe¯c9ÀÈp7¡j‘CŠíLˆ€´Rp``¤ÀæÀ½´ ");
} else {
	header("Content-Type: image/gif");
	switch ($_GET["file"]) {
		case "plus.gif": echo "GIF87a\0\0¡\0\0îîî\0\0\0™™™\0\0\0,\0\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;"; break;
		case "cross.gif": echo "GIF87a\0\0¡\0\0îîî\0\0\0™™™\0\0\0,\0\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;"; break;
		case "up.gif": echo "GIF87a\0\0¡\0\0îîî\0\0\0™™™\0\0\0,\0\0\0\0\0\0\0 „©ËíMQN\nï}ôa8ŠyšaÅ¶®\0Çò\0;"; break;
		case "down.gif": echo "GIF87a\0\0¡\0\0îîî\0\0\0™™™\0\0\0,\0\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wş\\¢ÇL&ÙœÆ¶•\0Çò\0;"; break;
		case "arrow.gif": echo "GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹”ªÓ²Ş»\0\0;"; break;
	}
}
exit;

}


/** Get database connection
* @return Min_DB
*/
function connection() {
	// can be used in customization, $connection is minified
	global $connection;
	return $connection;
}

/** Get Adminer object
* @return Adminer
*/
function adminer() {
	global $adminer;
	return $adminer;
}

/** Unescape database identifier
* @param string text inside ``
* @return string
*/
function idf_unescape($idf) {
	$last = substr($idf, -1);
	return str_replace($last . $last, $last, substr($idf, 1, -1));
}

/** Escape string to use inside ''
* @param string
* @return string
*/
function escape_string($val) {
	return substr(q($val), 1, -1);
}

/** Disable magic_quotes_gpc
* @param array e.g. (&$_GET, &$_POST, &$_COOKIE)
* @param bool whether to leave values as is
* @return null modified in place
*/
function remove_slashes($process, $filter = false) {
	if (get_magic_quotes_gpc()) {
		while (list($key, $val) = each($process)) {
			foreach ($val as $k => $v) {
				unset($process[$key][$k]);
				if (is_array($v)) {
					$process[$key][stripslashes($k)] = $v;
					$process[] = &$process[$key][stripslashes($k)];
				} else {
					$process[$key][stripslashes($k)] = ($filter ? $v : stripslashes($v));
				}
			}
		}
	}
}

/** Escape or unescape string to use inside form []
* @param string
* @param bool
* @return string
*/
function bracket_escape($idf, $back = false) {
	// escape brackets inside name="x[]"
	static $trans = array(':' => ':1', ']' => ':2', '[' => ':3');
	return strtr($idf, ($back ? array_flip($trans) : $trans));
}

/** Escape for HTML
* @param string
* @return string
*/
function h($string) {
	return htmlspecialchars(str_replace("\0", "", $string), ENT_QUOTES);
}

/** Escape for TD
* @param string
* @return string
*/
function nbsp($string) {
	return (trim($string) != "" ? h($string) : "&nbsp;");
}

/** Convert \n to <br>
* @param string
* @return string
*/
function nl_br($string) {
	return str_replace("\n", "<br>", $string); // nl2br() uses XHTML before PHP 5.3
}

/** Generate HTML checkbox
* @param string
* @param string
* @param bool
* @param string
* @param string
* @param string
* @return string
*/
function checkbox($name, $value, $checked, $label = "", $onclick = "", $class = "") {
	$return = "<input type='checkbox' name='$name' value='" . h($value) . "'"
		. ($checked ? " checked" : "")
		. ($onclick ? ' onclick="' . h($onclick) . '"' : '')
		. ">"
	;
	return ($label != "" || $class ? "<label" . ($class ? " class='$class'" : "") . ">$return" . h($label) . "</label>" : $return);
}

/** Generate list of HTML options
* @param array array of strings or arrays (creates optgroup)
* @param mixed
* @param bool always use array keys for value="", otherwise only string keys are used
* @return string
*/
function optionlist($options, $selected = null, $use_keys = false) {
	$return = "";
	foreach ($options as $k => $v) {
		$opts = array($k => $v);
		if (is_array($v)) {
			$return .= '<optgroup label="' . h($k) . '">';
			$opts = $v;
		}
		foreach ($opts as $key => $val) {
			$return .= '<option' . ($use_keys || is_string($key) ? ' value="' . h($key) . '"' : '') . (($use_keys || is_string($key) ? (string) $key : $val) === $selected ? ' selected' : '') . '>' . h($val);
		}
		if (is_array($v)) {
			$return .= '</optgroup>';
		}
	}
	return $return;
}

/** Generate HTML radio list
* @param string
* @param array
* @param string
* @param string true for no onchange, false for radio
* @return string
*/
function html_select($name, $options, $value = "", $onchange = true) {
	if ($onchange) {
		return "<select name='" . h($name) . "'" . (is_string($onchange) ? ' onchange="' . h($onchange) . '"' : "") . ">" . optionlist($options, $value) . "</select>";
	}
	$return = "";
	foreach ($options as $key => $val) {
		$return .= "<label><input type='radio' name='" . h($name) . "' value='" . h($key) . "'" . ($key == $value ? " checked" : "") . ">" . h($val) . "</label>";
	}
	return $return;
}

/** Get onclick confirmation
* @param string JavaScript expression
* @return string
*/
function confirm($count = "") {
	return " onclick=\"return confirm('" . lang(0) . ($count ? " (' + $count + ')" : "") . "');\"";
}

/** Print header for hidden fieldset (close by </div></fieldset>)
* @param string
* @param string
* @param bool
* @param string
* @return null
*/
function print_fieldset($id, $legend, $visible = false, $onclick = "") {
	echo "<fieldset><legend><a href='#fieldset-$id' onclick=\"" . h($onclick) . "return !toggle('fieldset-$id');\">$legend</a></legend><div id='fieldset-$id'" . ($visible ? "" : " class='hidden'") . ">\n";
}

/** Return class='active' if $bold is true
* @param bool
* @return string
*/
function bold($bold) {
	return ($bold ? " class='active'" : "");
}

/** Generate class for odd rows
* @param string return this for odd rows, empty to reset counter
* @return string
*/
function odd($return = ' class="odd"') {
	static $i = 0;
	if (!$return) { // reset counter
		$i = -1;
	}
	return ($i++ % 2 ? $return : '');
}

/** Escape string for JavaScript apostrophes
* @param string
* @return string
*/
function js_escape($string) {
	return addcslashes($string, "\r\n'\\/"); // slash for <script>
}

/** Print one row in JSON object
* @param string or "" to close the object
* @param string
* @return null
*/
function json_row($key, $val = null) {
	static $first = true;
	if ($first) {
		echo "{";
	}
	if ($key != "") {
		echo ($first ? "" : ",") . "\n\t\"" . addcslashes($key, "\r\n\"\\") . '": ' . ($val !== null ? '"' . addcslashes($val, "\r\n\"\\") . '"' : 'undefined');
		$first = false;
	} else {
		echo "\n}\n";
		$first = true;
	}
}

/** Get INI boolean value
* @param string
* @return bool
*/
function ini_bool($ini) {
	$val = ini_get($ini);
	return (eregi('^(on|true|yes)$', $val) || (int) $val); // boolean values set by php_value are strings
}

/** Check if SID is neccessary
* @return bool
*/
function sid() {
	static $return;
	if ($return === null) { // restart_session() defines SID
		$return = (SID && !($_COOKIE && ini_bool("session.use_cookies"))); // $_COOKIE - don't pass SID with permanent login
	}
	return $return;
}

/** Shortcut for $connection->quote($string)
* @param string
* @return string
*/
function q($string) {
	global $connection;
	return $connection->quote($string);
}

/** Get list of values from database
* @param string
* @param mixed
* @return array
*/
function get_vals($query, $column = 0) {
	global $connection;
	$return = array();
	$result = $connection->query($query);
	if (is_object($result)) {
		while ($row = $result->fetch_row()) {
			$return[] = $row[$column];
		}
	}
	return $return;
}

/** Get keys from first column and values from second
* @param string
* @param Min_DB
* @return array
*/
function get_key_vals($query, $connection2 = null) {
	global $connection;
	if (!is_object($connection2)) {
		$connection2 = $connection;
	}
	$return = array();
	$result = $connection2->query($query);
	if (is_object($result)) {
		while ($row = $result->fetch_row()) {
			$return[$row[0]] = $row[1];
		}
	}
	return $return;
}

/** Get all rows of result
* @param string
* @param Min_DB
* @param string
* @return array associative
*/
function get_rows($query, $connection2 = null, $error = "<p class='error'>") {
	global $connection;
	$conn = (is_object($connection2) ? $connection2 : $connection);
	$return = array();
	$result = $conn->query($query);
	if (is_object($result)) { // can return true
		while ($row = $result->fetch_assoc()) {
			$return[] = $row;
		}
	} elseif (!$result && !is_object($connection2) && $error && defined("PAGE_HEADER")) {
		echo $error . error() . "\n";
	}
	return $return;
}

/** Find unique identifier of a row
* @param array
* @param array result of indexes()
* @return array or null if there is no unique identifier
*/
function unique_array($row, $indexes) {
	foreach ($indexes as $index) {
		if (ereg("PRIMARY|UNIQUE", $index["type"])) {
			$return = array();
			foreach ($index["columns"] as $key) {
				if (!isset($row[$key])) { // NULL is ambiguous
					continue 2;
				}
				$return[$key] = $row[$key];
			}
			return $return;
		}
	}
}

/** Create SQL condition from parsed query string
* @param array parsed query string
* @param array
* @return string
*/
function where($where, $fields = array()) {
	global $jush;
	$return = array();
	$function_pattern = '(^[\w\(]+' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . '\)+$)'; //! columns looking like functions
	foreach ((array) $where["where"] as $key => $val) {
		$key = bracket_escape($key, 1); // 1 - back
		$column = (preg_match($function_pattern, $key) ? $key : idf_escape($key)); //! SQL injection
		$return[] = $column
			. (($jush == "sql" && ereg('^[0-9]*\\.[0-9]*$', $val)) || $jush == "mssql"
				? " LIKE " . q(addcslashes($val, "%_\\"))
				: " = " . unconvert_field($fields[$key], q($val))
			) // LIKE because of floats but slow with ints, in MS SQL because of text
		; //! enum and set
		if ($jush == "sql" && ereg("[^ -@]", $val)) { // not just [a-z] to catch non-ASCII characters
			$return[] = "$column = " . q($val) . " COLLATE utf8_bin";
		}
	}
	foreach ((array) $where["null"] as $key) {
		$return[] = (preg_match($function_pattern, $key) ? $key : idf_escape($key)) . " IS NULL";
	}
	return implode(" AND ", $return);
}

/** Create SQL condition from query string
* @param string
* @param array
* @return string
*/
function where_check($val, $fields = array()) {
	parse_str($val, $check);
	remove_slashes(array(&$check));
	return where($check, $fields);
}

/** Create query string where condition from value
* @param int condition order
* @param string column identifier
* @param string
* @param string
* @return string
*/
function where_link($i, $column, $value, $operator = "=") {
	return "&where%5B$i%5D%5Bcol%5D=" . urlencode($column) . "&where%5B$i%5D%5Bop%5D=" . urlencode(($value !== null ? $operator : "IS NULL")) . "&where%5B$i%5D%5Bval%5D=" . urlencode($value);
}

/** Get select clause for convertible fields
* @param array
* @param array
* @param array
* @return string
*/
function convert_fields($columns, $fields, $select = array()) {
	$return = "";
	foreach ($columns as $key => $val) {
		if ($select && !in_array(idf_escape($key), $select)) {
			continue;
		}
		$as = convert_field($fields[$key]);
		if ($as) {
			$return .= ", $as AS " . idf_escape($key);
		}
	}
	return $return;
}

/** Set cookie valid for 1 month
* @param string
* @param string
* @return bool
*/
function cookie($name, $value) {
	global $HTTPS;
	$params = array(
		$name,
		(ereg("\n", $value) ? "" : $value), // HTTP Response Splitting protection in PHP < 5.1.2
		time() + 2592000, // 2592000 - 30 days
		preg_replace('~\\?.*~', '', $_SERVER["REQUEST_URI"]),
		"",
		$HTTPS
	);
	if (version_compare(PHP_VERSION, '5.2.0') >= 0) {
		$params[] = true; // HttpOnly
	}
	return call_user_func_array('setcookie', $params);
}

/** Restart stopped session
* @return null
*/
function restart_session() {
	if (!ini_bool("session.use_cookies")) {
		session_start();
	}
}

/** Stop session if it would be possible to restart it later
* @return null
*/
function stop_session() {
	if (!ini_bool("session.use_cookies")) {
		session_write_close();
	}
}

/** Get session variable for current server
* @param string
* @return mixed
*/
function &get_session($key) {
	return $_SESSION[$key][DRIVER][SERVER][$_GET["username"]];
}

/** Set session variable for current server
* @param string
* @param mixed
* @return mixed
*/
function set_session($key, $val) {
	$_SESSION[$key][DRIVER][SERVER][$_GET["username"]] = $val; // used also in auth.inc.php
}

/** Get authenticated URL
* @param string
* @param string
* @param string
* @param string
* @return string
*/
function auth_url($driver, $server, $username, $db = null) {
	global $drivers;
	preg_match('~([^?]*)\\??(.*)~', remove_from_uri(implode("|", array_keys($drivers)) . "|username|" . ($db !== null ? "db|" : "") . session_name()), $match);
	return "$match[1]?"
		. (sid() ? SID . "&" : "")
		. ($driver != "server" || $server != "" ? urlencode($driver) . "=" . urlencode($server) . "&" : "")
		. "username=" . urlencode($username)
		. ($db != "" ? "&db=" . urlencode($db) : "")
		. ($match[2] ? "&$match[2]" : "")
	;
}

/** Find whether it is an AJAX request
* @return bool
*/
function is_ajax() {
	return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}

/** Send Location header and exit
* @param string null to only set a message
* @param string
* @return null
*/
function redirect($location, $message = null) {
	if ($message !== null) {
		restart_session();
		$_SESSION["messages"][preg_replace('~^[^?]*~', '', ($location !== null ? $location : $_SERVER["REQUEST_URI"]))][] = $message;
	}
	if ($location !== null) {
		if ($location == "") {
			$location = ".";
		}
		header("Location: $location");
		exit;
	}
}

/** Execute query and redirect if successful
* @param string
* @param string
* @param string
* @param bool
* @param bool
* @param bool
* @return bool
*/
function query_redirect($query, $location, $message, $redirect = true, $execute = true, $failed = false) {
	global $connection, $error, $adminer;
	$time = "";
	if ($execute) {
		$start = microtime();
		$failed = !$connection->query($query);
		$time = "; -- " . format_time($start, microtime());
	}
	$sql = "";
	if ($query) {
		$sql = $adminer->messageQuery($query . $time);
	}
	if ($failed) {
		$error = error() . $sql;
		return false;
	}
	if ($redirect) {
		redirect($location, $message . $sql);
	}
	return true;
}

/** Execute and remember query
* @param string null to return remembered queries, end with ';' to use DELIMITER
* @return Min_Result
*/
function queries($query = null) {
	global $connection;
	static $queries = array();
	if ($query === null) {
		// return executed queries without parameter
		return implode("\n", $queries);
	}
	$start = microtime();
	$return = $connection->query($query);
	$queries[] = (ereg(';$', $query) ? "DELIMITER ;;\n$query;\nDELIMITER " : $query)
		. "; -- " . format_time($start, microtime());
	return $return;
}

/** Apply command to all array items
* @param string
* @param array
* @param callback
* @return bool
*/
function apply_queries($query, $tables, $escape = 'table') {
	foreach ($tables as $table) {
		if (!queries("$query " . $escape($table))) {
			return false;
		}
	}
	return true;
}

/** Redirect by remembered queries
* @param string
* @param string
* @param bool
* @return bool
*/
function queries_redirect($location, $message, $redirect) {
	return query_redirect(queries(), $location, $message, $redirect, false, !$redirect);
}

/** Format time difference
* @param string output of microtime()
* @param string output of microtime()
* @return string HTML code
*/
function format_time($start, $end) {
	return lang(1, max(0, array_sum(explode(" ", $end)) - array_sum(explode(" ", $start))));
}

/** Remove parameter from query string
* @param string
* @return string
*/
function remove_from_uri($param = "") {
	return substr(preg_replace("~(?<=[?&])($param" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', "$_SERVER[REQUEST_URI]&"), 0, -1);
}

/** Generate page number for pagination
* @param int
* @param int
* @return string
*/
function pagination($page, $current) {
	return " " . ($page == $current ? $page + 1 : '<a href="' . h(remove_from_uri("page") . ($page ? "&page=$page" : "")) . '">' . ($page + 1) . "</a>");
}

/** Get file contents from $_FILES
* @param string
* @param bool
* @return mixed int for error, string otherwise
*/
function get_file($key, $decompress = false) {
	$file = $_FILES[$key];
	if (!$file) {
		return null;
	}
	foreach ($file as $key => $val) {
		$file[$key] = (array) $val;
	}
	$return = '';
	foreach ($file["error"] as $key => $error) {
		if ($error) {
			return $error;
		}
		$name = $file["name"][$key];
		$tmp_name = $file["tmp_name"][$key];
		$content = file_get_contents($decompress && ereg('\\.gz$', $name)
			? "compress.zlib://$tmp_name"
			: $tmp_name
		); //! may not be reachable because of open_basedir
		if ($decompress) {
			$start = substr($content, 0, 3);
			if (function_exists("iconv") && ereg("^\xFE\xFF|^\xFF\xFE", $start, $regs)) { // not ternary operator to save memory
				$content = iconv("utf-16", "utf-8", $content);
			} elseif ($start == "\xEF\xBB\xBF") { // UTF-8 BOM
				$content = substr($content, 3);
			}
		}
		$return .= $content . "\n\n";
	}
	//! support SQL files not ending with semicolon
	return $return;
}

/** Determine upload error
* @param int
* @return string
*/
function upload_error($error) {
	$max_size = ($error == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0); // post_max_size is checked in index.php
	return ($error ? lang(2) . ($max_size ? " " . lang(3, $max_size) : "") : lang(4));
}

/** Create repeat pattern for preg
* @param string
* @param int
* @return string
*/
function repeat_pattern($pattern, $length) {
	// fix for Compilation failed: number too big in {} quantifier
	return str_repeat("$pattern{0,65535}", $length / 65535) . "$pattern{0," . ($length % 65535) . "}"; // can create {0,0} which is OK
}

/** Check whether the string is in UTF-8
* @param string
* @return bool
*/
function is_utf8($val) {
	// don't print control chars except \t\r\n
	return (preg_match('~~u', $val) && !preg_match('~[\\0-\\x8\\xB\\xC\\xE-\\x1F]~', $val));
}

/** Shorten UTF-8 string
* @param string
* @param int
* @param string
* @return string escaped string with appended ...
*/
function shorten_utf8($string, $length = 80, $suffix = "") {
	if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{FFFF}]", $length) . ")($)?)u", $string, $match)) { // ~s causes trash in $match[2] under some PHP versions, (.|\n) is slow
		preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $length) . ")($)?)", $string, $match);
	}
	return h($match[1]) . $suffix . (isset($match[2]) ? "" : "<i>...</i>");
}

/** Generate friendly URL
* @param string
* @return string
*/
function friendly_url($val) {
	// used for blobs and export
	return preg_replace('~[^a-z0-9_]~i', '-', $val);
}

/** Print hidden fields
* @param array
* @param array
* @return null
*/
function hidden_fields($process, $ignore = array()) {
	while (list($key, $val) = each($process)) {
		if (is_array($val)) {
			foreach ($val as $k => $v) {
				$process[$key . "[$k]"] = $v;
			}
		} elseif (!in_array($key, $ignore)) {
			echo '<input type="hidden" name="' . h($key) . '" value="' . h($val) . '">';
		}
	}
}

/** Print hidden fields for GET forms
* @return null
*/
function hidden_fields_get() {
	echo (sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : '');
	echo (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : "");
	echo '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}

/** Get status of a single table and fall back to name on error
* @param string
* @param bool
* @return array
*/
function table_status1($table, $fast = false) {
	$return = table_status($table, $fast);
	return ($return ? $return : array("Name" => $table));
}

/** Find out foreign keys for each column
* @param string
* @return array array($col => array())
*/
function column_foreign_keys($table) {
	global $adminer;
	$return = array();
	foreach ($adminer->foreignKeys($table) as $foreign_key) {
		foreach ($foreign_key["source"] as $val) {
			$return[$val][] = $foreign_key;
		}
	}
	return $return;
}

/** Print enum input field
* @param string "radio"|"checkbox"
* @param string
* @param array
* @param mixed int|string|array
* @param string
* @return null
*/
function enum_input($type, $attrs, $field, $value, $empty = null) {
	global $adminer;
	preg_match_all("~'((?:[^']|'')*)'~", $field["length"], $matches);
	$return = ($empty !== null ? "<label><input type='$type'$attrs value='$empty'" . ((is_array($value) ? in_array($empty, $value) : $value === 0) ? " checked" : "") . "><i>" . lang(5) . "</i></label>" : "");
	foreach ($matches[1] as $i => $val) {
		$val = stripcslashes(str_replace("''", "'", $val));
		$checked = (is_int($value) ? $value == $i+1 : (is_array($value) ? in_array($i+1, $value) : $value === $val));
		$return .= " <label><input type='$type'$attrs value='" . ($i+1) . "'" . ($checked ? ' checked' : '') . '>' . h($adminer->editVal($val, $field)) . '</label>';
	}
	return $return;
}

/** Print edit input field
* @param array one field from fields()
* @param mixed
* @param string
* @return null
*/
function input($field, $value, $function) {
	global $connection, $types, $adminer, $jush;
	$name = h(bracket_escape($field["field"]));
	echo "<td class='function'>";
	$reset = ($jush == "mssql" && $field["auto_increment"]);
	if ($reset && !$_POST["save"]) {
		$function = null;
	}
	$functions = (isset($_GET["select"]) || $reset ? array("orig" => lang(6)) : array()) + $adminer->editFunctions($field);
	$attrs = " name='fields[$name]'";
	if ($field["type"] == "enum") {
		echo nbsp($functions[""]) . "<td>" . $adminer->editInput($_GET["edit"], $field, $attrs, $value);
	} else {
		$first = 0;
		foreach ($functions as $key => $val) {
			if ($key === "" || !$val) {
				break;
			}
			$first++;
		}
		$onchange = ($first ? " onchange=\"var f = this.form['function[" . h(js_escape(bracket_escape($field["field"]))) . "]']; if ($first > f.selectedIndex) f.selectedIndex = $first;\"" : "");
		$attrs .= $onchange;
		echo (count($functions) > 1 ? html_select("function[$name]", $functions, $function === null || in_array($function, $functions) || isset($functions[$function]) ? $function : "", "functionChange(this);") : nbsp(reset($functions))) . '<td>';
		$input = $adminer->editInput($_GET["edit"], $field, $attrs, $value); // usage in call is without a table
		if ($input != "") {
			echo $input;
		} elseif ($field["type"] == "set") { //! 64 bits
			preg_match_all("~'((?:[^']|'')*)'~", $field["length"], $matches);
			foreach ($matches[1] as $i => $val) {
				$val = stripcslashes(str_replace("''", "'", $val));
				$checked = (is_int($value) ? ($value >> $i) & 1 : in_array($val, explode(",", $value), true));
				echo " <label><input type='checkbox' name='fields[$name][$i]' value='" . (1 << $i) . "'" . ($checked ? ' checked' : '') . "$onchange>" . h($adminer->editVal($val, $field)) . '</label>';
			}
		} elseif (ereg('blob|bytea|raw|file', $field["type"]) && ini_bool("file_uploads")) {
			echo "<input type='file' name='fields-$name'$onchange>";
		} elseif (($text = ereg('text|lob', $field["type"])) || ereg("\n", $value)) {
			if ($text && $jush != "sqlite") {
				$attrs .= " cols='50' rows='12'";
			} else {
				$rows = min(12, substr_count($value, "\n") + 1);
				$attrs .= " cols='30' rows='$rows'" . ($rows == 1 ? " style='height: 1.2em;'" : ""); // 1.2em - line-height
			}
			echo "<textarea$attrs>" . h($value) . '</textarea>';
		} else {
			// int(3) is only a display hint
			$maxlength = (!ereg('int', $field["type"]) && preg_match('~^(\\d+)(,(\\d+))?$~', $field["length"], $match) ? ((ereg("binary", $field["type"]) ? 2 : 1) * $match[1] + ($match[3] ? 1 : 0) + ($match[2] && !$field["unsigned"] ? 1 : 0)) : ($types[$field["type"]] ? $types[$field["type"]] + ($field["unsigned"] ? 0 : 1) : 0));
			if ($jush == 'sql' && $connection->server_info >= 5.6 && ereg('time', $field["type"])) {
				$maxlength += 7; // microtime
			}
			// type='date' and type='time' display localized value which may be confusing, type='datetime' uses 'T' as date and time separator
			echo "<input" . (ereg('int', $field["type"]) ? " type='number'" : "") . " value='" . h($value) . "'" . ($maxlength ? " maxlength='$maxlength'" : "") . (ereg('char|binary', $field["type"]) && $maxlength > 20 ? " size='40'" : "") . "$attrs>";
		}
	}
}

/** Process edit input field
* @param one field from fields()
* @return string
*/
function process_input($field) {
	global $adminer;
	$idf = bracket_escape($field["field"]);
	$function = $_POST["function"][$idf];
	$value = $_POST["fields"][$idf];
	if ($field["type"] == "enum") {
		if ($value == -1) {
			return false;
		}
		if ($value == "") {
			return "NULL";
		}
		return +$value;
	}
	if ($field["auto_increment"] && $value == "") {
		return null;
	}
	if ($function == "orig") {
		return ($field["on_update"] == "CURRENT_TIMESTAMP" ? idf_escape($field["field"]) : false);
	}
	if ($function == "NULL") {
		return "NULL";
	}
	if ($field["type"] == "set") {
		return array_sum((array) $value);
	}
	if (ereg('blob|bytea|raw|file', $field["type"]) && ini_bool("file_uploads")) {
		$file = get_file("fields-$idf");
		if (!is_string($file)) {
			return false; //! report errors
		}
		return q($file);
	}
	return $adminer->processInput($field, $value, $function);
}

/** Print results of search in all tables
* @uses $_GET["where"][0]
* @uses $_POST["tables"]
* @return null
*/
function search_tables() {
	global $adminer, $connection;
	$_GET["where"][0]["op"] = "LIKE %%";
	$_GET["where"][0]["val"] = $_POST["query"];
	$found = false;
	foreach (table_status('', true) as $table => $table_status) {
		$name = $adminer->tableName($table_status);
		if (isset($table_status["Engine"]) && $name != "" && (!$_POST["tables"] || in_array($table, $_POST["tables"]))) {
			$result = $connection->query("SELECT" . limit("1 FROM " . table($table), " WHERE " . implode(" AND ", $adminer->selectSearchProcess(fields($table), array())), 1));
			if (!$result || $result->fetch_row()) {
				if (!$found) {
					echo "<ul>\n";
					$found = true;
				}
				echo "<li>" . ($result
					? "<a href='" . h(ME . "select=" . urlencode($table) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$name</a>\n"
					: "$name: <span class='error'>" . error() . "</span>\n");
			}
		}
	}
	echo ($found ? "</ul>" : "<p class='message'>" . lang(7)) . "\n";
}

/** Send headers for export
* @param string
* @param bool
* @return string extension
*/
function dump_headers($identifier, $multi_table = false) {
	global $adminer;
	$return = $adminer->dumpHeaders($identifier, $multi_table);
	$output = $_POST["output"];
	if ($output != "text") {
		header("Content-Disposition: attachment; filename=" . $adminer->dumpFilename($identifier) . ".$return" . ($output != "file" && !ereg('[^0-9a-z]', $output) ? ".$output" : ""));
	}
	session_write_close();
	ob_flush();
	flush();
	return $return;
}

/** Print CSV row
* @param array
* @return null
*/
function dump_csv($row) {
	foreach ($row as $key => $val) {
		if (preg_match("~[\"\n,;\t]~", $val) || $val === "") {
			$row[$key] = '"' . str_replace('"', '""', $val) . '"';
		}
	}
	echo implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $row) . "\r\n";
}

/** Apply SQL function
* @param string
* @param string escaped column identifier
* @return string
*/
function apply_sql_function($function, $column) {
	return ($function ? ($function == "unixepoch" ? "DATETIME($column, '$function')" : ($function == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$function(")) . "$column)") : $column);
}

/** Read password from file adminer.key in temporary directory or create one
* @param bool
* @return string or false if the file can not be created
*/
function password_file($create) {
	$dir = ini_get("upload_tmp_dir"); // session_save_path() may contain other storage path
	if (!$dir) {
		if (function_exists('sys_get_temp_dir')) {
			$dir = sys_get_temp_dir();
		} else {
			$filename = @tempnam("", ""); // @ - temp directory can be disabled by open_basedir
			if (!$filename) {
				return false;
			}
			$dir = dirname($filename);
			unlink($filename);
		}
	}
	$filename = "$dir/adminer.key";
	$return = @file_get_contents($filename); // @ - can not exist
	if ($return || !$create) {
		return $return;
	}
	$fp = @fopen($filename, "w"); // @ - can have insufficient rights //! is not atomic
	if ($fp) {
		$return = md5(uniqid(mt_rand(), true));
		fwrite($fp, $return);
		fclose($fp);
	}
	return $return;
}

/** Check whether the string is e-mail address
* @param string
* @return bool
*/
function is_mail($email) {
	$atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]'; // characters of local-name
	$domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])'; // one domain component
	$pattern = "$atom+(\\.$atom+)*@($domain?\\.)+$domain";
	return preg_match("(^$pattern(,\\s*$pattern)*\$)i", $email);
}

/** Check whether the string is URL address
* @param string
* @return string "http", "https" or ""
*/
function is_url($string) {
	$domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])'; // one domain component //! IDN
	return (preg_match("~^(https?)://($domain?\\.)+$domain(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $string, $match) ? strtolower($match[1]) : ""); //! restrict path, query and fragment characters
}

/** Check if field should be shortened
* @param array
* @return bool
*/
function is_shortable($field) {
	return ereg('char|text|lob|geometry|point|linestring|polygon', $field["type"]);
}

/** Run query which can be killed by AJAX call after timing out
* @param string
* @return Min_Result
*/
function slow_query($query) {
	global $adminer, $token;
	$db = $adminer->database();
	if (support("kill") && is_object($connection2 = connect()) && ($db == "" || $connection2->select_db($db))) {
		$kill = $connection2->result("SELECT CONNECTION_ID()"); // MySQL and MySQLi can use thread_id but it's not in PDO_MySQL
		?>
<script type="text/javascript">
var timeout = setTimeout(function () {
	ajax('<?php echo js_escape(ME); ?>script=kill', function () {
	}, 'token=<?php echo $token; ?>&kill=<?php echo $kill; ?>');
}, <?php echo 1000 * $adminer->queryTimeout(); ?>);
</script>
<?php
	} else {
		$connection2 = null;
	}
	ob_flush();
	flush();
	$return = @get_key_vals($query, $connection2); // @ - may be killed
	if ($connection2) {
		echo "<script type='text/javascript'>clearTimeout(timeout);</script>\n";
		ob_flush();
		flush();
	}
	return array_keys($return);
}

// used in compiled version
function lzw_decompress($binary) {
	// convert binary string to codes
	$dictionary_count = 256;
	$bits = 8; // ceil(log($dictionary_count, 2))
	$codes = array();
	$rest = 0;
	$rest_length = 0;
	for ($i=0; $i < strlen($binary); $i++) {
		$rest = ($rest << 8) + ord($binary[$i]);
		$rest_length += 8;
		if ($rest_length >= $bits) {
			$rest_length -= $bits;
			$codes[] = $rest >> $rest_length;
			$rest &= (1 << $rest_length) - 1;
			$dictionary_count++;
			if ($dictionary_count >> $bits) {
				$bits++;
			}
		}
	}
	// decompression
	$dictionary = range("\0", "\xFF");
	$return = "";
	foreach ($codes as $i => $code) {
		$element = $dictionary[$code];
		if (!isset($element)) {
			$element = $word . $word[0];
		}
		$return .= $element;
		if ($i) {
			$dictionary[] = $word . $element[0];
		}
		$word = $element;
	}
	return $return;
}


global $adminer, $connection, $drivers, $edit_functions, $enum_length, $error, $functions, $grouping, $HTTPS, $inout, $jush, $LANG, $langs, $on_actions, $permanent, $structured_types, $token, $translations, $types, $unsigned, $VERSION; // allows including Adminer inside a function

if (!$_SERVER["REQUEST_URI"]) { // IIS 5 compatibility
	$_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
}
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") { // IIS 7 compatibility
	$_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
}
$HTTPS = $_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off");

@ini_set("session.use_trans_sid", false); // protect links in export, @ - may be disabled
if (!defined("SID")) {
	session_name("adminer_sid"); // use specific session name to get own namespace
	$params = array(0, preg_replace('~\\?.*~', '', $_SERVER["REQUEST_URI"]), "", $HTTPS);
	if (version_compare(PHP_VERSION, '5.2.0') >= 0) {
		$params[] = true; // HttpOnly
	}
	call_user_func_array('session_set_cookie_params', $params); // ini_set() may be disabled
	session_start();
}

// disable magic quotes to be able to use database escaping function
remove_slashes(array(&$_GET, &$_POST, &$_COOKIE), $filter);
if (function_exists("set_magic_quotes_runtime")) { // removed in PHP 6
	set_magic_quotes_runtime(false);
}
@set_time_limit(0); // @ - can be disabled
@ini_set("zend.ze1_compatibility_mode", false); // @ - deprecated
@ini_set("precision", 20); // @ - can be disabled


// not used in a single language version

$langs = array(
	'en' => 'English', // Jakub VrÃ¡na - http://www.vrana.cz
	'ar' => 'Ø§Ù„Ø¹Ø±Ø¨ÙŠØ©', // Y.M Amine - Algeria - nbr7@live.fr
	'bn' => 'à¦¬à¦¾à¦‚à¦²à¦¾', // Dipak Kumar - dipak.ndc@gmail.com
	'ca' => 'CatalÃ ', // Joan Llosas
	'cs' => 'ÄŒeÅ¡tina', // Jakub VrÃ¡na - http://www.vrana.cz
	'de' => 'Deutsch', // Klemens HÃ¤ckel - http://clickdimension.wordpress.com
	'es' => 'EspaÃ±ol', // Klemens HÃ¤ckel - http://clickdimension.wordpress.com
	'et' => 'Eesti', // Priit Kallas
	'fa' => 'ÙØ§Ø±Ø³ÛŒ', // mojtaba barghbani - Iran - mbarghbani@gmail.com
	'fr' => 'FranÃ§ais', // Francis GagnÃ©, AurÃ©lien Royer
	'hu' => 'Magyar', // Borsos SzilÃ¡rd (Borsosfi) - http://www.borsosfi.hu, info@borsosfi.hu
	'id' => 'Bahasa Indonesia', // Ivan Lanin - http://ivan.lanin.org
	'it' => 'Italiano', // Alessandro Fiorotto, Paolo Asperti
	'ja' => 'æ—¥æœ¬èª', // Hitoshi Ozawa - http://sourceforge.jp/projects/oss-ja-jpn/releases/
	'ko' => 'í•œêµ­ì–´', // dalli - skcha67@gmail.com
	'lt' => 'LietuviÅ³', // Paulius LeÅ¡Äinskas - http://www.lescinskas.lt
	'nl' => 'Nederlands', // Maarten Balliauw - http://blog.maartenballiauw.be
	'pl' => 'Polski', // RadosÅ‚aw Kowalewski - http://srsbiz.pl/
	'pt' => 'PortuguÃªs', // Gian Live - gian@live.com, Davi Alexandre davi@davialexandre.com.br
	'ro' => 'Limba RomÃ¢nÄƒ', // .nick .messing - dot.nick.dot.messing@gmail.com
	'ru' => 'Ğ ÑƒÑÑĞºĞ¸Ğ¹ ÑĞ·Ñ‹Ğº', // Maksim Izmaylov
	'sk' => 'SlovenÄina', // Ivan Suchy - http://www.ivansuchy.com, Juraj Krivda - http://www.jstudio.cz
	'sl' => 'Slovenski', // Matej Ferlan - www.itdinamik.com, matej.ferlan@itdinamik.com
	'sr' => 'Ğ¡Ñ€Ğ¿ÑĞºĞ¸', // Nikola RadovanoviÄ‡ - cobisimo@gmail.com
	'ta' => 'à®¤â€Œà®®à®¿à®´à¯', // G. Sampath Kumar, Chennai, India, sampathkumar11@gmail.com
	'tr' => 'TÃ¼rkÃ§e', // Bilgehan Korkmaz - turktron.com
	'uk' => 'Ğ£ĞºÑ€Ğ°Ñ—Ğ½ÑÑŒĞºĞ°', // Valerii Kryzhov
	'zh' => 'ç®€ä½“ä¸­æ–‡', // Mr. Lodar
	'zh-tw' => 'ç¹é«”ä¸­æ–‡', // http://tzangms.com
);

/** Get current language
* @return string
*/
function get_lang() {
	global $LANG;
	return $LANG;
}

/** Translate string
* @param string
* @param int
* @return string
*/
function lang($idf, $number = null) {
	if (is_string($idf)) { // compiled version uses numbers, string comes from a plugin
		// English translation is closest to the original identifiers //! pluralized translations are not found
		$pos = array_search($idf, get_translations("en")); //! this should be cached
		if ($pos !== false) {
			$idf = $pos;
		}
	}
	global $LANG, $translations;
	$translation = ($translations[$idf] ? $translations[$idf] : $idf);
	if (is_array($translation)) {
		$pos = ($number == 1 ? 0
			: ($LANG == 'cs' || $LANG == 'sk' ? ($number && $number < 5 ? 1 : 2) // different forms for 1, 2-4, other
			: ($LANG == 'fr' ? (!$number ? 0 : 1) // different forms for 0-1, other
			: ($LANG == 'pl' ? ($number % 10 > 1 && $number % 10 < 5 && $number / 10 % 10 != 1 ? 1 : 2) // different forms for 1, 2-4, other
			: ($LANG == 'sl' ? ($number % 100 == 1 ? 0 : ($number % 100 == 2 ? 1 : ($number % 100 == 3 || $number % 100 == 4 ? 2 : 3))) // different forms for 1, 2, 3-4, other
			: ($LANG == 'lt' ? ($number % 10 == 1 && $number % 100 != 11 ? 0 : ($number % 10 > 1 && $number / 10 % 10 != 1 ? 1 : 2)) // different forms for 1, 12-19, other
			: ($LANG == 'ru' || $LANG == 'sr' || $LANG == 'uk' ? ($number % 10 == 1 && $number % 100 != 11 ? 0 : ($number % 10 > 1 && $number % 10 < 5 && $number / 10 % 10 != 1 ? 1 : 2)) // different forms for 1, 2-4, other
			: 1
		))))))); // http://www.gnu.org/software/gettext/manual/html_node/Plural-forms.html
		$translation = $translation[$pos];
	}
	$args = func_get_args();
	array_shift($args);
	$format = str_replace("%d", "%s", $translation);
	if ($format != $translation) {
		$args[0] = number_format($number, 0, ".", lang(8));
	}
	return vsprintf($format, $args);
}

function switch_lang() {
	global $LANG, $langs;
	echo "<form action='' method='post'>\n<div id='lang'>";
	echo lang(9) . ": " . html_select("lang", $langs, $LANG, "this.form.submit();");
	echo " <input type='submit' value='" . lang(10) . "' class='hidden'>\n";
	echo "<input type='hidden' name='token' value='$_SESSION[token]'>\n"; // $token may be empty in auth.inc.php
	echo "</div>\n</form>\n";
}

if (isset($_POST["lang"]) && $_SESSION["token"] == $_POST["token"]) { // $token and $error not yet available
	cookie("adminer_lang", $_POST["lang"]);
	$_SESSION["lang"] = $_POST["lang"]; // cookies may be disabled
	$_SESSION["translations"] = array(); // used in compiled version
	redirect(remove_from_uri());
}

$LANG = "en";
if (isset($langs[$_COOKIE["adminer_lang"]])) {
	cookie("adminer_lang", $_COOKIE["adminer_lang"]);
	$LANG = $_COOKIE["adminer_lang"];
} elseif (isset($langs[$_SESSION["lang"]])) {
	$LANG = $_SESSION["lang"];
} else {
	$accept_language = array();
	preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace("_", "-", strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])), $matches, PREG_SET_ORDER);
	foreach ($matches as $match) {
		$accept_language[$match[1]] = (isset($match[3]) ? $match[3] : 1);
	}
	arsort($accept_language);
	foreach ($accept_language as $key => $q) {
		if (isset($langs[$key])) {
			$LANG = $key;
			break;
		}
		$key = preg_replace('~-.*~', '', $key);
		if (!isset($accept_language[$key]) && isset($langs[$key])) {
			$LANG = $key;
			break;
		}
	}
}

$translations = &$_SESSION["translations"];
if ($_SESSION["translations_version"] != 2121441971) {
	$translations = array();
	$_SESSION["translations_version"] = 2121441971;
}

function get_translations($lang) {
	switch ($lang) {
		case "en": $compressed = "A9D“yÔ@s:ÀGà¡(¸ffƒ‚Š¦ã	ˆÙ:ÄS°Şa2\"1¦..L'ƒI´êm‘#Çs,†KƒšOP#IÌ@%9¥i4Èo2ÏÆó €Ë,9%SiÀèyÎF“9¦(l£GH¬\\ç(‰†qœêa3™bG;‘B.aºFï&ótß: Tó¡”Üs4ß'Ô\nP:YîfS‚®p¤Øeæ,¡ÌD0ádFé	Ò[r)+vÜñ\n¼a9V	ÆS¡Ş´kÌ¦ónÓcjäAE3ÍF©ÃÊ²™3”Sz\n(^{c‘“?¡ŠŞ.DÃ}tİĞÊm˜jl{½È‹˜é¦NÇĞo;ÁõG_T&äA6ar§cI”î?Ó,²®M›â4°£h\"(Æ:°°XÉ!‰Ä<° HKCÈ¦2½# #£sÔÄ°ğ\0Î3 #;C9\r€Æ4K`ò;°H†­DC\"’1°ĞšÚà\r° ¨ÂºÚÀÀ:ù©”‹ C˜Æ¶8bˆ˜mãÄÒ+,Ã¾9Œ.T\0ü²Ø²NÔÏJÌÄhC*Æj ÂëÍÒ<Îb‚¶ş\"ë‹<\$ª±ã>—Sº‚ÄS¨Ë;„ëã6\"àTÖì®€Tã=SÑ?#\$Ã°Â6\r)†)ŠB3,7l0\\Cí#,Á\$ŠÒ`¸*òPîô‚úH˜æ3J)D?eE8à8G\\¨„âœŠJƒ%œ¤±ã8\r(Èí&¼¼ÊòEXU=SUÕ²åÌò\r5[\$•8Ì¨àé:‰\nŸr\\Õ¸x‘Ì„C@è:Ğ^ø¨\\H«èä+C8^ÃcãÃ\nÃÅxEKˆé†è²Ø5„Aõu7£pèã|Ÿ§Íë7´¨ÓÅZ„EÒğ¼y²P±1ùÂï¬Kè@¿×rª9jL*B(	†šÃiéğP )‘UI4”%Ib\\˜\rÌÜÓªUišj’?£`ÈŸ)òjšÖëµÖDÓ²òÆB ŞJà@(	â˜©5;¸¤š¾ˆÅyMêlª¼1ğÜÒ K‹âJ·Q}Å	 1;””(,¸¶#hê>¤|hÏ\\K[Âpş\$b0©¯-‰\n[¬)º0Ì97ˆ;’Ê%EUV\$4ÜÚº%\rúº'ÃDÊ3Œ4ÕæZ|ÑQòÚåIR”·ÓN.¾e’ŸUŠˆ+6Ì¨Ï5-êg!ÊM<3Åvó¨g\r=®µöH¸ŠEmÜ¼@X\"åŞYIF7“'TwÂ¢3Áò5\0Ş’ô\$*|ñ4²4ó¹’Åh2•ÀÜ©ÅIvdÂp \n¡@\"¨@T@\"„À‹Ó¤%ğÜçS`YòiŠ®\$<™‚Ôaƒ:L	åYà‚„Ò¨tPòğÊƒ\nQ)¯L:™˜8Yª\"!—ÖDJCyÊv²ApîwÜ¸m%È+ÓÿR¤Q\r‘My#ä“C4…=PäI°eI¼åÇ²m\r!´8¥`*¸'\0Ğ|2Ò¸¸ª` Òë6I%xÜ Ç‘P€pB_”^3!å3hF{_a¢ç,\"‡'™&\0q¦ı\r‚`†‰03ÁFm‡“ƒƒw	á-tMØ`Hƒ0fTn\0ÎC)9¤âk@‚uÎÙÂ|	ğa3Ío4—cÃÅ'ÄfsÏ ÊJ&ìÚô6t’Ö§Ù›gõ¾ ÚE‚Y'pFc©#· -	¦Eº³ˆÈpjpÜÊMsÜ|)˜lŸX­àŒó	tPpÊªwÎŒÏ\$KRÀPH8%h¬2î©‚*)­ÕS @÷‰óá†èø‹µ§£W«Ù¯ˆ&·ÌPK¤­5‰¢˜s)Y—•BDNÄƒ=éR×Jƒ(ªY»ZÜ®ÉêS\$ç\rïØÉñ]+6+ÑÔ§U«@¬^¯JTÂFêÊ\\¤8®u®±¾C1Am	´o‰UŸ§Íjjùx­OŠ5§z4HÂ”)QJÅ‚å&QĞ6šCt/pšÊŒ·\"â-¶ş\$™™UX¤Û]-i”­òl<\0©_\\R\r°Ü\$¨ÂIa·Éñø[Ãio|´í^ÛW\rÈU¾‡aëÚ«e]-­x¾·ö÷[8ovX*tNÆ‰ë&à§	ğ-t–™ó`ôäÂ/ığÀ8W_rck­½\\™Bea4İI¬ş›ÔâO#Õ=1¦jXy+“,ROçü1º¼C2*aÎ&|XNùZr‡*<7È8{>l}\rrLªœØÓáY<\r¥”FÑÒÉ;ÆÏ_ùM¯ÎˆƒÛçŞe¯è07ikfÔhë¬–¦mU”2¬»è\nºaWi7w8µÊiO89ås(YN\\S­ïÓï,¡ä”‘§û!`y2ù´™ñÃÙù’3¥W²“¯àÃü‚ænbÃ9\nPY˜y5MÕÚ§Paº\n€SHeÕ8+Q=vÿZÊL¼ß„øoBUÅ°%%çÌy“Œõ]¥È¯›â\\™¥è.ÕÚ¾Úe]o&I\"%IÇ\\/çäæÖ¤YˆšâëÅ(78d>ÓÚ˜neÍ@e¢Y÷PiÌŒr7ŞXÊšö‚¡ş¶æ–Ä£r¼î»tá÷|ÌoİZJ8§ÀÚ†ÛpÍÁ¾8¼&Z&7Åù!\\–ºÇlqJex”†TÕr£—©9¬¯q&ŸTFĞ«P¸¶Ó ¼ÿ“m?vº@æ5à\$ƒu¶Ñrî¥›o@ì­”İŞ½ùê\0ÖIˆºŞ£=mùİ\\ÇÆúş6¶äx¾¡Zê¬Ë!`	}ƒ· ‚©¬h/ìSw»×º÷øŞ- „ !š Ø\nÃ¬a¯9’8èF@\r!šs ŠD@´o]ÁT*`ZÚ]HAˆc@ñÑäôÔë>áêËæ\"hÂ—DC4X\n&¨QË†È>gº%•hÊ°7xÊ\"Ÿ”±ûÇ’ƒ¢\\@W¾~ÇpàÎ£‰Ö†¼#ˆ:@ˆ	?6ì³zŞ6|Ñ72µ=şëß	r­D\"üØùßâşÿğßÖ¿ùvzè¾CLH¢vşïÊ²\rL†\$b“ès…ÜÑc<¢Ú¸+ê\0˜Œ˜ºbŸ,F&§êÖÙĞ\"¾\"v‰(É\0MAÃpråş\\®HÜDî jlÖ2¬S š‘h¢°àÈêÏ§øO-äS ‚)¢º™£,ç‰º Z<BLÔèiJ3	œ\rØõÇÅ\n\"¤"; break;
		case "ar": $compressed = "ÙC¶P‚Â²†l*„\r”,&\nÙA¶í„ø(J.™„0T2]6QM…ŒO!bù#eØ\\É¥¤\$¸\\\nl+[\nÈdÊk4—O¡è&ÂÕ²‰…ÀQ)Ì…7lIçò„‚E\$…Ê‘¶Ím_7—Td…Ôâ¥¢ÊQÔ%Fª®ÎâPEdJ£]MÅ–iEµtØTß'í…œ9sBGeHh\\½m(AÁ¸L6#%9‰QèJXd:&§»hCªaÎ¡RÄPcÕ¹åzÀ†¸Ìnø<*©°®Ì¡g\n9††%‚‡h5ut.—³¼QS…œ\nÅÍÄ¶p{š¯l-\nˆ†;„Dğ¸Ê\nã ën¹…ÅßÕgÜhğÌwk0ÄGPs<û:á«eŠ:¢4ÊìT âF“¡\rpÛ0©á(H™\\¼:0‚¹	 k´.DBóÒœ@Å‰°[(PRï¡1\"Ç6hs†ı¤eC¼Ã30â	Äğ{zùÇQŠêùÄ‹„ªÂå 7èJ—*å„}H,2A+ºFå››p¸Ai#\"6qòx•\$eÊq'EZ:@¤I‘¬»°d}LÜê4’Ôœ'Ezp[Ãô‘@%¨‹#£`ØƒÄ6¨ØÆ0ÉÃ&û°ëjNB„˜¢&Mèq[@,%Ä§Â*Å*?±ŒU,Rãm*\$QP†·¹°[ÓN£´Ğ*Ëo_×ìU_ìm_Å*½iF,â<Ïµ­4ÊO13åI2d‡B5Ì:ø%­cwa2èÌÈ·|™AUĞ- íÚSäZäW–ESG-øä:\r€P†)ŠB0@*\rãXÊ7 SÓ£°±é«\"´JŒ¼LÂªLİ¸Î¸LÀ†¶K; ÷dÑ\"Ôˆ-ë:m>¡'‹n@„ªâ¸èNpç<fÁ‹YØÎa.w\$7]9Ğ´0°%å¥[8Nzt%¨-º”Š›‰£æ:£@8lC˜î7RÀÊ<Hä2Œ˜¨x0„Fæ3¡Ğ:ƒ€t…ã¿# Ú4Û(]¶á~É Ü9#xÜ„T€Â9ã(é¾‹ô05„Ağ’6 Û‡à^0‡Í(A×ƒ@ß,ƒn0áÁ\0Ò:lû(ÛLvë:Û3újB‘¤­Z¸¯X6»}æ¡C€Ğ8?Èj&ÃÄl²*şŠµéÀëj¢ëzä“«e–…Ölbƒ(Š2¾§/.¦BŞ\\)Äá’òbGŒaMdçàš¾j€O\naP…‘T‰ŸC*,Uÿ*¶“15\$bÔ‚¤Î÷`ax!¦ˆ‚b—RÊ~L\$M?ä&ø²Pk(]0­çæÈB€H\nÜ,†ğê»®´7¸@Şiê…Q‚\0ÌT  Á¥¼`¨\"xnK¥Ö6Çˆğâ°r\rá´¶PìãÏ†ˆ%|¢Â±Í¾Ìµ'Aât,\rQæ+kÙûuf¾…S=XæÙè D~¬d4u[D<„¥ÜXd\"±ñÚ8ƒ:øË9“.°øP­§–ù \nÔ'Eœì‚aMÂ) €ÒK3ğcAÃBbÉJw›!P¤AŒ5=Áä4Ö×;Q6ê©²{1LMÈÉ'#RqŸ‚V3\0@ŸUú³R½WìD±G§Ô[’q¬.gPÛ‚vÉäÄÕ'0´®„U+NtŒB ğœ¨P*Yû?Â E	‚­³›‹9‡|ê	.˜Bz¿sÏLG¬Øœ‘IÄ<,Pù[\r‡äIÉö.¬ê’#êy¡¼9Æp—Ï£@cÉØVì¼A-±l]É| Ÿ' µ¤øBBÉ©m7Št£‘ÓaQßá¼9©ÀÄŸbr‹‘0¶šëÂmQ\"ãEØØ‡d±­En«&Iƒ¬gj’MâŠ]—¨h'În£„ªtL?\$õ:SRÄ+g¡<Ô¹§äXö)õ@V6±/B¶Q‹kãy§¥›eÂùVÙ¸‡Â°àbF_çÁm@VDx Kn3µ2-F}Y\"Æ>æàù›¢\0Ÿ\\âf58­U¹rW†_.2á1’y/0¢Á‘)Ãœ§ÁaLK>`T£)qaB¸²3œS³Ôı¡s,z5%'°6P¸ìÆó%šeTôÏºgp„S@+Ap	·²^‹ßNïŒ+h@–ùKìNJ„&	Ğš×[Ö—Nq¶\$¶=Ò¨­J„.ÅVBTbøÔ	qs‘_\n5¶g7“ŠØ¥ˆ° ABbVÔÅHrbç!ò¢æ¡Mk“—áTGÇâ,£\n©ë²æ?ÇíÑxşP_¡ÔI\"ÆõQzÏ]ÊG­ùRb™r'fòÎR\$*J–!B¢,G\r†7‚\0Üïƒ€r\r1mJ:æ¤ôK…²)\0Ğsº‘Ra”¨\nÕR¶ô1/ã+ P²ºæšê§FaË„Ë<íOõ[\$`üUR\\™Vc#ü•¨R!yËºZØ\r…‹ªšÁÒú¹y!ŠÎrCÖÔ`#<jQ(|tw]é•\\si®¢ÔB|ìur{ÉE0>—ï\$¤ÃZóN60£lWWŠğ Æ Rp&qêÓ×¢@Ç*d[dŞ˜¯ÌÉ cä¬P§+:LÔ-á\$¤—ºÍb¯Y¿—Â‘jªÙ¬8Fñà:ËVğ^½ø’ûİsrN!oÃ-zÃÖ”cpÍ#µç%¡ÆxŞ¬MV¦ùföäeÑ¦tn¡BªRæì™›#t93,3¶y¿yëÂYŠ Ó„ •:ı}ù×GA]%÷+„9Ó&÷C¯ıFÁt©ÈK¤ëpÎÇ:0¸JÁ]?ÕÌÕ2ê*!i,.íK‹èXEš†67D«öşâÅĞŸt#öİ³;·mãY©}—w3‡<‘áQÚ\"bêÌÏï};dÊ\\w2ğÅß9­}8×§ôSy×PQÀ×KÆŒ_]]w7hŸ(n›ƒù;\\7µgiÌ²‹ùìÓàqNE«ñF]÷ÈÆÔ\n¾M©¹Amù¿‚/§ìu?ÍøÙ›9¦dÑ±ÄÚ[ÇrâVttHØÑrİ¦ÊÙùuv«Óåš«‘\róú·ºş¨Oûòÿ„æcœÿb½O ÷C>9Êu\0ªÒ¢©FÌÏ¶Âp²0äiD¬¯âIâ¶e-¾«ë*ÉÍØÔThú*(FVeaRÿ\nÑĞD»o°H0O&ÕğcM¨şj90HøîõP^U£a0f!p‚&åâ„±ƒåL°°¥ô+ïüú°œ°ğÿ\$;	Dšì'\nÀ%@9C€ûPo	Z!Ëh!˜ÔêÂ¶cso¹£má\nÊ­ş¥\"q\0AÆ©ÅÅ‚/Ğç+}¥ˆäbL¨Â	v¨Êè\nœ2\\¸L:£Î£±^¢\\EÂ&º¯Ø4¦ç£æçën)l&à†€ä\r€V`Ø\r Æ\r`@sH‹@Â\r€êR§zvçv\r Ì'„‚nÈ°R Ú¦Æ\0ÄR§ \0¨ÀZ\0@aàÇ Üâ ~®¢¸„•\riÒ,hç1Æ)Q.„%Cö—¼C„g\rEäŒ¹îK`§bhş‚ÄFÅšN‡:¨p¬)-ØãüÚGÄ*Œ%ât´\"Ğ¤H0@˜‰ Èq€Ï!’æöR1O\"ê†¢\"Sğd¿e\\WĞ4-©°Ö2@©ïu\$¦¾ùI^6ñÕ\0òWn8Õï%`¨RE(ÎìÖÍ±añ^\0èŒ€ÒFèé¤—&¥Zò/ˆ´j´ƒäÚñ2_)¢¬-z\"™ŠÂ@ÅL)*ïXÚêÈËÊ¾íŞ3èÑ°¸Çú„I´6ÂtÙT¢t¥¶²\nş2DÛJÂjn.ìÎ2ìV%¡/D¬:‰`8V4¡E^*åèkŒUÂ3«PP@	\0t	 š@¦\n`"; break;
		case "bn": $compressed = "àS)\nt]\0_ˆ 	XD)L¨„@Ğ4l5€ÁBQpÌÌ 9‚ \n¸ú\0‡€,¡ÈhªSEÀ0èb™a%‡. ÑH¶\0¬‡.bÓÅ2n‡‡DÒe*’D¦M¨ŠÉ,OJÃ°„v§˜©”Ñ…\$:IK“Êg5U4¡Lœ	Nd!u>Ï&¶ËÔöå„Òa\\­@'Jx¬ÉS¤Ñí4ÚzZØ²„SåØHİMS àè]şOâ”ÕE2şÕ\\¶J1‚Ê|úĞ¦[ÉiõL¢™_?€Pµë\n~bÂ¨‡#óªm\r/ƒÚÔt7½Bš'Ÿ¹C¶˜]¾sl¾ğæö2G©ÓÔ¶ĞæŠÌï^TÈ˜s±¢ìñ<\neU>¢‚€c¶½Uõ>İ£³ëÄÖS ïL^>Ê#–Â²Í4\nÙ¾jRñ©êêÜâ’hªòÀ\r©*§½ÏÚÙÂOù~ÿ1êÃdÁ#\nå­Åt°­t.§­ÏbŞ÷¹‰³×ÆÉjØ¨Ã¥;‹¨…\nP­’[q “Š{ SëJ¶¥*«% d+Ë/QQÒó÷!ÂNÛ\nÒ/»>í&\n|ÊP0Ç ±Íy&Ö£Lƒ¶©s^±¡éÄè°)ñ£pÒ¼*ÂĞËÅC,Ú‚Îp\$\$ØÌ\$eM ‘½'#PóË.ÊÎ±„¢R³Óšş„£#¤ù“àMk[µğİ]B?1sLÒ\n“k8(rÛ¾×Ø.{_ v\r†¯­ËÁ>‡PĞŠv×”lk=NJ°ò¿;”íG4­Ôn¼=ÍzºE·ª#-¨M«,¼ám¿¨U¹7ò=‘cjL(…}ã{#ûd#£`ØƒÄ6©\0Æ0ÀP¦(‰k˜Ì4B@[×,¯~ª‚Ë3+bS[©”¢¶6‹ráhP«e/å±1—ÖÅYb´“u5N¦®İáhV.ˆ‡ E>cLT^SJ\r|¤ëJ‹^£	hŒ•äŒ5Ğ“!*4WÌµ²k”â)î\0Âª;\rÊÈÊ–=wõ‰ªÓ–{å ´›V¨êîŞ³UØÚŞ»kg\rÃ °©®É )Sj¦¶NS8Ø:Jz·°jå8@!ŠbŒĞ3ÌÂÜˆ)«6öƒ%t|/£5óÄüî³…4È€põ¯RCkÃ^·ûÎÕx,İgP}½Ñs9†ò/Ï‹âQèL†=>’%t¾u·aÔ:ñ-ÅºƒqAo2w0'v—Ë×ÓTÙ¨=\$ø¯<'x¾IkíÍ(ÀšC˜t¡È Ã¸oJØ2‡€àCe€¸ÀÂD!Àô€è€:à¼;ÃP\\C m\r!º	‚è4Áxe\rÑ<A ÜÃHoˆ`‰ŠäÃ(t…}‹±ÀÖğI\r¡ÁŒØ„à/ ø¸‡0Aƒ h\rêØ:øÎC[\r!Ò\nÁ0ÚÇ\"ùudj©»3\\¿ÊQÏ/voÁ\0P	Aê¬c\n—–)e ô¢£E L\0(.@¦À’’Èqü“é¼=Lò”â„,*!»eŠÚÌ)3’fU·5)ŠºÅ+*¹`Ÿ£¨¢…3§EOe£ŠçºvÊC~~Ç¢ILQ2˜bÂHÂ—¹ó/U¹™VFÖ\\•á^)S…GµÑy\"BxS\n„9É¯âªíY³^˜Şb0dÌ,Í€€À½tá6J,èI2¤Ä‚õk6©íéÍ“4XŠ\$İ˜éÔ,†ğêØnÖ.øp!8b\r!œ1ğ˜0ic\0€;˜N‚¤ŒcŠØ4Å¸5#(A¼6’&¡ê€€¤ªx¹C^ÎOlá¨³º£¹fx´ŸT(«Œï¤VüĞQåH/>¥5ÆoS[\r	zÒİĞÑ5s\\\"ª§Ê°3§Õ˜3Ÿmn|4wÌTY¯JèHš²Ää•Éª’Z&å.#6W×Â€G\n¸à u_ÁÑ‘R2Y·xÿ%ß:‰H'Å•tÖ¬”ƒ%än3uŠTKÃ9Ls)®õ´)‰# ëÅá;D³”i¢q/òÁMKWÔãÏvÕYV¹ƒ†æÊ\\§uY±9–‡;Ş	¾UV¡£Íå¯jég™\n¨Ì2ƒ†ÚË²³)œ€:wà2PH\"~å8fºÚˆÅì»èô«2Ù™2LH—Å ÉI}êd¥%¥=‚=f~îR†·\rA7¿D@°cñâBH~‡M³7Ry,òÁ/Â¸SĞI]Ÿ)Lê#u‚m×*í¼ú0i“q¼ƒ}Ôÿ›Ç”¾Å1/w4€Id»Š&5Á*ºı3QLÚH\0‰·. Œ+hÊğAX8ë[Õ¤—2ša©æåê³ÕSuÙaìâ8Á7Û-=°CÈU\nYY—l]w\nÄæ{Vf¶ƒî­¬GsºhĞC±œ—)ÎFÂãÒØÃ…;¯l¸…·YêŞLós¾B™âÔÃ&§4»³Rü×¶å¦ÁJÊÖüõ@Gfƒ²ÚÂÃ3Êä¥¤|»_Ù†®\rc;Hy?aÙ:¤ÅğNTM(@*áŒWyê«¥m±0–]Êñí’éÊãíëÉËï3[Õ·î\\v;-@•£Mt£åi×´[\0ÅĞ³3Â\nÙùwifÅ:ófX‡²;fêl™¦ö²;•’/ÏqÕ9˜©•ƒ>ĞkŞZ-¹ôg¤!nt0‰_òòc)3\"`“tÊ-h«°Ù=r¸ï5bİ6ª·†Ö/{’²%t¶kôÙú¤\\ ~3¾knìU‹mRÜóóuØ€Ïƒ^eÎp;×üôÏK+®§Ê&µøQ:ny°^U{Pâİc&[›^/MHÖªn¨Sßœ³Ò¤¶u.¬º Û“l·'ÒğŸöCsÛéC\$dSàUºî%¹Ÿî–‰Qrè\0‡'\"ñ”7p=SiiÕÖHõª®&ºûhæ»@…¼Š \n€âšEÎá*Œ¸UW¬LCÍ÷+ÁÓ^qGùõ6şoI¢xîA{ïÇêP¢ÅõŠ‹ Õ-F°´ãĞM1£½ù¥¿z†&Ğ%‡\0ª+EÃ@a¨\0€7FààƒM-cB3FÚ6 a‚LP4ŸºÅ˜ÄzÛSW3³<=ıÙÙšD\rÇUÌ¬]Åî,ñOàfˆfggx2Æ’÷­ø,PùŒ>¸\rÈã‹`4KÀÉbÜÓM|P‹‚ë«bô®œøïnßìù,šæN<İÏ0é¯Œôğ&”ĞJÜÂj§Î0XöÍâ«¥ÿJß°kP1Kj³nH¤Ì(…ÚBLVÿ-\$#\nëÎèUã^³Í8}fÌ±jØBL'¬ê«Æ¾¬ÀÊ&ˆ9¯~Zl¤(måPÿ&(0\\ßĞaìrL.\$—#,ÈÏ&Dà@	·Ã\nÀã¨%ˆ/Œ­f¾©Şô0;>ZæĞ^«±ãfu”­%:°¥\ráF¢páPå‹JjÜT|®O‹Eq*­£Û\rnÿpnÜPGÑJlNÖQRĞ§ ¹^¸pA*³'Êé+Ÿ0hº±AÏÿq’leùM¦˜ßÉ¢%+\\ªP¼ø…1XõöŞg`ím´¿BÍ´Xr“îhîæÓI›. Üí>©”{­}‘lŞ1Ñ„úå‘äÅ­¼ßMÃQ¸ç+¶ø~UïEĞ,ôÑDù%—\"'ÿÑŞà1¯\rÑW 1Z»,ß\"G®.ö’0ùpjä’¯êeÑÒ Ã\nK+×Ëé‰(-©Ø±jKAT!Ì|8fªÅãtg'ğÀ'­'7'K÷#ë|øì_'®ªlL³\"fìşÂ\".şXÍN`&¹'ëÖÏì’UÎ’R!­5êú#H|M8|‡‚»I.\\„Ä·0±)Ì:pğL•ğ®µğÆ\"r˜Éxùj’YN`BEÿgrY2]“É1oIËG‚É×ªãó;hP3E%jæG4H.h8“3Q‰3’IĞæ-ÍLyDgĞUG!ÒJ=3p³jörTqÓI6³=5ó5Ä7/7ÍKSrãóaGÎ€£¶.\0005êê0ÃJ¿\rğìÏ„-ÄFZÀÈ*°C±7pø06°ó3»…USe3kk2‘n«³ï+¦+íÛ:2D{ÓK#Q÷@E;8ò= 6ÒLY‹Ç:õ2SWcÄ*\$\$½é=\n/+”/:FœğdB³±5F®†ÎÛT:#Ü>4\"t2ÂR˜‘ÅTkâÜ>«Ê™ìÎ^sbôp*¸‘Có‚x+ÌªN”wRB3’ñ±£4Ô‘GÔ–A-\r¯BuJ4I(J³*TDtD´z³E9LSIÓ´­ƒ(p%?t‡ª±K’_MÒ…MrÙ2q´~´/Tß\"10lGTÍOÕNy;2X¬çßı>ãHQ?±#2°æİ+^ ®ÏD0ØVtŸïSB1S£FqUA•JL—RõS´òÔÉK4WU¬òµ%QtU:r¤Òs‡9Ó‹9_,Ò)¬_Rª¯UtG³Ö5=24I%³ÿ8RÎGõsUC#4î^­œUÄœ`ÎÕ	Dìlëó7GVè¼\"6Û2¯CC,®áq ò¤ZRÓB”Tw´#3ÎI •Üjİ^1İµêÔ/79õõTS,Â.}1‚¢–Â¾,#Šm±\$WUïa^\r‡%xéBóĞ-ºßê,”(àgH\r€V`Ø\r Æ\r`@‰J@¥€Â\r€êc/¼\r¨Ö\r Ì @bêÊTc Ú¨\"\0ÄJ4\n ¨ÀZ\0@ˆ@ÇgàÜâëcµÛq`b¿^‚ë’&3‹[50xûcÎöÛ–Á\"–Ämé§lÕóO–S2ĞwêÅGôY2:<RŸ¯äÊ5Ÿ\$&Yp¦ç=!LnÌ_e:[5zÃşCNÎÅFJõ@„\$.’›-84ƒtÖ*æ«£&¡õğ }pêÇ;gâ@˜£ÀÈ‡`Ïu×`Œè4c/Âb®\0g²¦nq>YoÃp‚óN„(Ã^íIKmoxpxÁ’ÚÇìe0£KL!ğcx‘şU­z”BCÓo)_\rU'\"Ô‰Rõ¦)À¨ı\0ÊŒÏ¢úvšˆVj\0è¦ ÒHDıWÀqK++4X³^mI\"ôÅãô,%Àó\"ÜĞÔ-V¨ÍbÀ¶ùD=9‚”½SÑ&K*>8 nx\$6ÄĞMC©6,\"z#ß<p….X`æhÈtqÆu0,´ı¦€}oŠàÂŸxÂñy	\rLó^ò~Õ‹R©Ğ)-'ĞÈ¤>4kˆŒˆÕ‰j8e\rbéM	ê^s¾}£Ë8M!MğQÌ™«{ 	\0@š	 t\n`¦"; break;
		case "ca": $compressed = "E9j˜€æe3NCğP”\\33AD“iÀŞs9šLFÃ(€Âd5MÇC	È@e6Æ“¡àÊr‰†´Òdš`gƒI¶hp—›L§9¡’Q*–K¤Ì5LŒ œÈS,¦W-—ˆ\rÆù<òe4&&#¬°o9Læ“q„Ø\n'W\r‘¢hc0œC©°Ã1DÌ†“|øU:M’ÃÑ„Sº`§ñÔX :âqgLnbÚ §Ç ¦SÁĞÊnŒ›õR­I¬š¦šCM~Ã1*N-tØ'Éd¦›†Är¡‚ˆ† ‚èh´cˆqı?\$…lá‚‹SÆ8eÂ™N–œq3_9ãöºl1N^v›Ú8¦İ\0çÂ´‚ˆz¯†7,p„ÿ#ªzp£=\"HÜ4ŒcJh¿ Ê2a–l|\$4Â€9'ÃsN:BÈàÇµJ+¨ô‰¨»ú7êÆ:Œc¢ÇE,V¼E‰£à€Æƒ|mAé¢ø¿8£ªN(I\"¥Ã2Ç¬H†Œ\0Ä<´ÀHK*Êí3Ò÷DQ\"ÚÉÄôˆ#;3Œ0l(ı%ëÀš.ØƒÃzR6\rƒxÆ	ã’1ÁOAÄa†V¦ÔKTµÆRªŒ”´Í( ÄpÄ+2Ï‹ØÂ££šğ7P\nbˆ˜³¸ã(G±üqP#zĞDàTj4ÆğxN¡Î£+!¹	¢D“v€YJ+|šV¨=o¹\"‚Òø#‹\\Š­œ˜‹R˜ˆ¡ŒmT=ºV+<š+c´„0¯¬u£ÀµÍ€:ØLtÖõ¹HØñB Ş5´á\0†)ŠB3œ7È2Á93í\$Ê8Ì´\r·ŠÒ˜ÜuÌÚC7(ää]	‹¦”Ø6C„®ÚtT ­ûx§ èÃÔ&)œ#C+²º8\r#“˜Ë‹F+…Á˜À[]yS‘AÁ«r\n¶a¥Ö×OóL“ğæ;­«I¢jxˆxš\r@Ì„C@è:Ğ^ûÈ\\¦Ğò`´á{OÁ4­;R7á<9ïà/£cÜ5„Aò(ÊXPøxŒ!óXš¼N„«¤¦£çÒƒÉCùRò®´ÍE4â®®zï×´*aÃgh( \$\n0ßp9‘8@*!K@Ú¢Ğ]@˜Ša>…±OId­8Õ:tP'¢¼\"­hAnD’æª9ïujwÂx¦* Ğ İÒ£	¤ÕÉ|BÊ2_XúŞ1\\-•Ì’4‚òÙA‰]Êİr†âVBZ2nf°˜…Ş‘•˜2¼‘ä¬Z•Bª)ph‚£ÁrIT®Rõƒ0r0¨D9b^LPÒ@Ï¬0ân_Ì{ÒrD:‡Ò£_ù^e9z ‡ J*™D©Y[C´~—Q\"]¾¯5¦®O1ëYÈj(b0EÀPV8j|Ñ\$´xˆ±/BpL¨ƒ§>ChbEŠıÂ»\$2SİûÁ*'é‘®‡R¹Clvoê®C¤a[	k-°I€¯Úâ,G,â7,Ù:¾	ók,<˜—j]]¹z_dä2£*AXÛFCÇ¦DI±%xNT(@‚*€—A\"„À‹0š·B”6PÚ˜Ë‹Ş(í„92„xÕq¹7g¤óTØN\0pLäL7@GÎGŒÉ… f%?Æ¤úŒ™Y(Áš(šiùÎÈA5ÿrÆ¼CêêÁâp¿è\"FZ„°˜ù2OdÜiŒRUxÈI›3ÌpÃ¡¸£„P•â@HäEÑÃHzB1ü9H¹EĞEdc§Ñ“k¬3*JŠcS(–„Ñ>éšÇM´ğ2 Š“àabÕ!ÇX’–úİ1ÁMnÃôÈÇ`\n\nFd¶‹\r‰é9q]bUŒüÎ	Ù¬œ´wç2ÍQ÷_æ9-‚	W6ÒU®ëöB‚úsM\$QIäâš–ˆù—®µì†Ú@¯C .'î¿W2»`‰%„dÖóØªôBãº±Ô¼:5Ã¦^¤D+'åfÀ¤âHL¥…²¶&Ø2ïa§­ˆ\$vJºÀÚä—¬½®xÖnÜ¾rbI\"9««”¢d	Ã%Éœªi[ÜØäËˆ½(ˆÄ4®âqqÑ“F­Åî+RL±É|2TVE²tSi'­“Á%¿9ü{ÏëÆÀ“zJH<5¿ €;†PÄ’í­€5åbõ„ƒÖ0Å‘ä¡ÑˆPÔ¢K-:ì7¢¢Ğ¼F‰µ\$:Ø‚ôÑŠv1‡2=Å‰É¡lÀ\$‘ÔâH\nLäÀ4F\$bí\rÄd»¦*™WIIÁ¦/eÏ#FÀÊÈ\nd8ÅšfşğÂJÊg9…ã¹û€E rc\n*‡É¦!ˆïY\$8š	­HÕw¯¡©ªÅÎŠ{;EŠÍM3tÉ49Õ\"Xæ“~ÔÔ÷*×	.‹ÑÓFeı\"ÓS|î§ØÁùÚ:B^I(¤‚¶“Qãpn™¸'¤´v‹Lã>\nènRÔ2“çŒ\"&eÍ”.DÒ‡Ú£„Ú„”•¹¤b¦½W;\\@LX­\"®¾k™ÃOY\r‘¢¶¿ÏÕŸ^/M–rs†j'¹±_¬™A›óÆÎÆ»•fìsœµ-ÜËå©Ulàùaş{Up¶Ùêíh%eŞ2ÉorÓ’vFû1;ô¨Yõµ6.ÕÎ{O<n,F]é¼±r[¡¡q-ã2øÍ9ã…ß=lŠl¼)Ä²ˆ1İLÍ\\î‹Aj`¥Ñ![*›8EŸgübfÙ—®\\ÏóU*ª.\$¬.‘ü¨h¶ùmÄ¼ÓµTÎ:I^16À!òUE‚¥‚´ı9#à¥êş‹V¢U<ñÇ¶z:Œ[»\\æ¼öÉ'tİ[#¼D\nË·!-Ü4?«úÁduÇpİa—Ã÷®J‹|m.ÓêûÆP>şg‰?‡æ¥Óğ­{,à²˜w1—ç-Hå¯×[]×mùÈó¤á>¿ÇVmõí<’½Ù™3;5wî¦œeËŸmÓOytÓ—Xñ?|:6áÈĞå·q_	ëH8q #T]?aŞĞ‡Ùûuª÷O²?¼ûŸx˜ûúEøC/Úı_‘|^×ú[Uõ_b½Pâ‚ä¢è\$ı®zğ=/”~pÿmtİj†»ªz¶\r¨àp »‹¼-jÙàO02¶ÜVp;&şÇçĞJ\n…„Ò«ìÆúĞjÒcïĞd>ã‡m×`Ò& ?ÀĞj´õàédDôO&×˜FgR®¯˜b˜5 ÍN¼,Y\n„ŒëLÖ*èlĞÃ¢ÜRğ±¯d®¬\\u°ªˆM;ĞĞÄªÂ& ŒwEcÆ\r€V¦ÄƒÅ]ÉŞ©¯bò`ä¤ûLˆ&£\$u Ä#¢Ø—`¨ÀZ\nÜ\\£ÖNè…ª¥	î´.\rƒœ[…Ã16à&¸râ.#%@B\$Âgn–Í©,1Ì°Jgô/ÉÆ1ÅlZ©ü©n’0h%à\$ÀÂX\"„¢İM/Å\$£hÂdƒ‘*ñƒ«Tì’1Æ’´«â_ªş9„¿É:Æ§tHmµ\nË´2Š”íŸ©-ñ<\\¦‰¬š/±à.Çæõ‘É£D7œ ¬~#±`§†1\"lG÷Ñìjï=àDp}‹ÆêÌ£ííd%h™H\0Šà˜Qò4RC|ÕMHÕ‚\0l\"èO€Ò!E\\¿hÚ\"Ú3cœ2ÅhÒ%ï&«@Êš„ TBòóªVqÔó°øb¥ş¼M°ÚRƒ(qØ?L!d,şOò\r#’	¢? ‚óœêŠú€	\0@š	 t\n`¦"; break;
		case "cs": $compressed = "O8Œ'c!Ô~\n‹†faÌN2œ\ræC2i6á¦Q¸Âh90Ô'Hi¼êb7œ…À¢i„ği6È†æ´A;Í†Y¢„@v2›\r&³yÎHs“JGQª8%9¥e:L¦:e2ËèÇZt®\"=&ŠQÁŠ¯œØ¦ ¦*öEjTˆ†ÔØk<ÊÄ\0¢Q„ôy5‚ŠÇ“è\n(¨³SlŞLÅ_MGHå:ÅL=(†ã¾€kT*uS‚²i­×AE\\¤ìaÊf¶Äèy8ALDdÔæl0‚ˆ›®4Â b#L0æ*`Êtb&ÏF3((„iœ¦ŠĞQNjÅR‚ˆæSy·r4õJfSÔxÛº)hÛSotÊr µzİ~Ä\$­øŞá6¢ÀêŠ°Ò4\r‰æ4¨î¨¨ü0jâ³\"ğbDb”)âÖÁ›`\"‹˜-\rì*ı!£¢–5ƒª–Ä\rãĞÚèÑb%£\$iGbæº®ãªÏ\$Lr2È\rn\$*3V€ p‚2ÂÉ!,±-2cÌ»/Ëc¢ÎÁ7#£pÖêBÎ9£8Ã80qäJ\rc Ê¢(C³ì‹#\$¬9À1ˆà7: P˜˜JÂ#j»¸ì ñ3óŒßK8Æ4\"a©.K¢ì¼;¢ˆ˜›¢É¬š=C{(;U¥k»\rík(F±¹7¤‘,PCL_Xm>ú8,èœÁJ=–T®§iÚ±\$\n1@àR\0”#µ_­bHÚ‰L8Š<]82CEÃÙÖ‚.’\rÌòMRÈƒ\\a[–#ª9Ûí4¶\0PÙ!è‹€:&…êä7ià@!ŠbŒxË'l @3%#jí\r“!ÚÏ©]ßxÃòl€Å.ŒÌuZPŒ—ò§\0ÁãxÜ›±VBÆdÃšk,˜eêHœ'PñSŸz‡ƒ 9‹€UËdTFˆÅ•¬nV;e¸há‡èğÄ¯”,ôï¥˜eÒ(Õ\nbŠ’Aˆ·PDà'íÅ;¸àxã¤(Ì„C@è:Ğ^üÈ]B®Ãî%#8^1az²Ê\rÚ°^T£ÎçòøÄàMÁ}smc+Ì7F,˜Êã}¤9èš˜¨k‹ ò›áèÂ4ù”)ÚV¶­ú;=Cù3™a®ÜI½´[j2¯ÆÌ¢C%Ñ¹b4ø@(	€Aëû%j-™B ¥bòê1G%‹-R^L^‹Şjíˆ˜èÓÉÑ5ciƒ¶8ÍSe4!Ì• ‘2MJ'åÚà Â˜T[EÎ	»¶bÈ–W%ª\n’28¨²)†l3ÎŒƒ	É{Ê:#\\òÍ‚„45TII9V\r¥œÈò8G‰\"‚´7†6–‚£ò8äÁv·&øFƒÑQàû¶’ Êúá'°­aÆ’VpÒK/ıå‘2Œ@—n/)¡,¶X2õW+Ü¯¢˜À\$Aö=¡„Æ³C¨Ó:OhÆÔî—5¼iƒ`ê\rÀæûß‹óF¯Õû½â bS0C­5‰)%xOKä;%exb—\"Äˆí€ ¨©‹¹º]ñü0¬ºÁXlp\\¸°@Ğ³™ng³ÙÃHzia­ŠØYII'³PÌX<YRÈQ³¼†­YÅ;KXN@ìå>á>˜9„d\\‘‚¡¸8JM&˜\"tĞA¡Ğ“8Úôiª}´¸p¾M¸\n	g”FQ,º%[A±úÒ„›I2ø#ä¥#Aê^¾h›ß¥ŠeHTh¦4È¡¡LŒ¾ÊÀUOÁàİ+Ä€¯ÑaØ©fè-C€PC„dKäJƒáœs”äÌcĞİxr©µ}¢è}Zk1¯A¬H‰ªğº×i‚i¥l8\0 ŒÉbÑˆ1GP‚Ö @qÃ2mSf¬2&ö±£ÂÍ+>E¢Àê\rA:¡4CÎC\"²/É/>H>Ïúc´Å¼¼Z©ºäÊµUíŒ13h@¤]¬­rˆ@\nŸ M\nXòL6‚à•q~¶–ØŸ³«NÏmÜ{\r.ß£ˆ‘p‹î/7Ù\\¦imDÚ¹¤J×İ{'’¿#V–áâÏ6_2»¥üÍ8S71 ’Wk·%ô«Áx­Åå¸Ö•_Ç—wí³ËÀ7=ŸZ¬\n+Uyg¹w„ŒŞ;rÏñ#ëïˆ¢ŒÂv˜Wà›aâ•„ƒsødğ7’°´räò:AJŠÎŞNŠHÅ‚ÖQ)ó	U#Q÷?)ªaùJG\0w¤¢a­B7˜SÔ£\"ÌLJOù¨¢‡ ê˜3“–’°UJ’ô’+D:X¾I·Hã‡9í1'Jç5{zqå²1B³…\$NÜãš3¢M*°Ÿæ’yŸÂ¶iJÄB2 ßW8ihõFbåDÈÒCTí¤*è£§s¢,8äH5#“¥™Î”.u„Õéë¡u†¥‚„µ…9ìÂf:ıÎÏüãÇä]3QÆ×*Ÿ]¸Kª¯öBØ¶~É¯mJäRÑ_šl‡Ï½§2@SuÑMF…\$j‰B‚­àÉcEmÓÚ´=Ğ0H\"t€İT¢²òííÔ½2•Ğà*‘YÈ•8TwócEJ”;®4¨+\"Àewİ¡’fHÿÃã×C”5;¼úG£¼‡`ZƒÙI[Åù×“Ål¡³l¬†+c-y®µ6)×ÒbÙŸÍÖÍçp¼™í¯’¦Án•èå·«2tÂR}„ˆ=täŸ­ãÿåŠı\\Uvd¥Æê(÷©ñ.ªNz¹ë7O­È¯×Ö%ÚìV².©Õ³‡ké]rõuëÛ%/}Y¬DÚrS“t¸ŸG®pN/	YoˆØá»Æx35ä<G%ÙŞQÕ`Ş’†¯‹Û§ĞÏĞàuFTidÅ[\"Ş9Q*HbFÜ85Â<–=˜bõÎŞ	X}Li98ã±Çø\0n©z¾º—çØ’a‹IÒejŠß+ã¼¿†µfgİ¯CBÕ]Wu°£ğJOÉÚ_ë^O9'¯Îö¿ı¿§Ìó	[Ëú\":\rõ\0*Ø×¢omş,%oú±ÂŒêöÏğ\nÿğâO4‘mXä‚\$€êÿÂ2JM¢‘+\0ÃÅã’‹Dş¤F„üà–\"¡|±¡zSäh{ã6€‡¼êª8?«‹®êÙo×ğn¤îÎÍ(:î‹Ğäì\\üFF±MXü0&lpvHĞ2E‹MÍY	æŸdHÊ\0ÃöBä¡CÖ\rb€3‚8âPåÃíxõşÎŠÏğ¿0Ôåo&ÏêÅ\r8‘0ØÊÄÿŒßÏŞâpñiŒ7êè‚xÎK~HJ\nº¯¤&­ãï/şJÍCJ·®Û‘\"­'P†è°‹	jİÃõÑJ®x9kƒö2#ú(1)q,5‘`³(OÙã]ónš\r*n#^,pu¤hí¬ÅèJê£È\0°Z¦,Àèƒ€—F…ÎŞ’Ä»q #Q¸Q‘¨_.½	0âV	b2—†´¥Fb£ê\n±¦JÑ İ ìP+€½À¸±²‘õ‹¬ïÑÿGşçQö5É½k°î/Š²EÀØiÈ(eÆdL\"O (†¸Fî|e>:†E`è4lŒúBl[ˆg#hkB‡¼\n ¨ÀZúëHÈ%/ª˜’\r\"N\0\\òxãîŞïãŞ¸ÑÇ(hË&Rîˆğ\" }\"*\"ì*lF°MO¾HÇÂ LÈ0@ô.k:¤B8Øâä6ª(p-æVL1ã\"wÎ&¶rºJ²N“¬8¡¢\$7äz˜¬B‹%ÂI%ÃRüÖGê€Th˜÷rôOÃØi’ºLpÂÀ,K¬ßª„ßã`æMª&s/ eBˆj˜	‰3Ó/40ÊWóP_³0í‚`Ï`õ(Ó-5Í^GoÒ7Dòı\$F†&rÓBî\$PTa4ÛbFQ©@(B‰\0ä÷9b‡\0Î\nÂthïX(Ä9«XLà‚#Ë§6°d dZ¢…<FC6EÌç<lÆJÄ@\\Â™Êm3jpX\"4\rC°|i `J]>ÊbDóG4¨ÍğàAÒ0E´£“ŒR"; break;
		case "de": $compressed = "S4›Œ‚”@s4˜ÍS€~\n‹†fh8(o…&C)¸@v7Çˆ†¡”Ò 3MÃ9”ç0ËMÂàQ4Âx4›L&Á24u1ID9)¤Îra­g81¤æt	Nd)¥M=œSÍ0Êºh:M\r†X`(r£@g`¢\\˜İ*LFSef\nŠg‘†e£§S¡èên3àM'Jº: CjØ³ÉÃR\\ÍØCÔv«\$«™k'JÙÊ¡/4Hf˜,Ş- :ZS+Œ2½Åêmò\"Ô˜é¹“_ÍÆ³.3pB€°Ô‡ Q;šz;Ã\r`¢9”ŞmæÚ0Êt”Ü\n«ŒF\\óO2›oPÃµ—Yœ²”4³¹¿Lô4SØí‰ƒxÎ€OÓøÿ4ì²¾†<ïH@0£˜îé78¦:C¨Ö:¨kØÎ¨ÍÀ¬­á¤B\0Râ¹®¨4VÈ¼î°ê†(pæ’@Pƒ\nŒÆx4MÁ†BEƒ“Î bò’2`A'\$£œ\0ó\"d¤ PŒÃÃãJBÜ*8Ê3¤“ß\r®P+cŒ³C\$Ö.O„J03<Š70ÌD\\ÑƒdV–ÇÓ»/®¡\0è¹,h8Æö/Bˆ˜Š1¸ä<ÏL™Jé5C=±œZ)¯éÔTRI1¨Ëh%R0Ôo[–Ô>5 ¤2¡I(\$£„Ò·(ña?âÄğ\rˆå]„zè±Ö°õYRÓp6C€P†)ŠB5¢7¹ˆó3ÈVâŒJlZ„2+a\0Œÿ\r£ª5:À)ì•WªÊ„Ü©¥•f—=ô3\rédŠ¯¦ˆs±ãl„¥±ãÂ;6ˆ:İ†±tÎ9Œ¤p¹%©úR7ŒÍÜƒBä&7`Œğ*±KH–„`º#h’7a’tÒLkºlø!£ƒ÷?ÈD8\r2(ÉvƒA\"£0z, àáxï±…ÈØÚ€¡sü3…èîÚ<<ÈBB„TpÂ9%£¦¶/ŒHÓ–Ö\0à±¼pèã|¨Ö/\0èÔ c Ş'N`@Å„¶„ö#«\nØÇ(äì±hf  *zv66œşĞÈG:J9)ò,\n@ ô]'gÓ„B¤òê|¸9\reœªŞ)Òp'‰ô(  ÙĞôİ§G,T^.}¢´9ÉÚçq—ĞĞ¤¡k¸ 'Šb£ ’jÌ0@£ê]Ù]à£ÕˆGˆ)^!¤¢˜pNõoŠ\$¢¼Vp \nåqô`CBY!6A¦“T‚Èo I®gÈÚeAœ‚)bPT‹jÁ*^@ÉÊÈ*`3#¾Æƒ”\n3ç™[°@¹Ù²ëZ§,Ç¹ÒR’œñéˆ¨M\n¡qH†Nª¯ ÑIk|gJ[¬>\0(+7pÒ¤\rÂ\$ˆV2ÆäGŠ:qŒ¥³•rîİéÆtÆ!Æ#ã|^âı\rÎ9%ˆ	ÙNëy„‘¦ˆyÖ’1<áÃDôîªY:Zòe«åzıâHg&…µ×’h’(m†¡CÆ(dƒÇœ'„à@B€D!P\"–il(L²ğ½4¥¸GCpa<Veb8¬OÑ}qÑ¹P9€	áÂG¦CÙñË•.v26²äNÉ¦ Ä¤§–5ACk…QçP\$Eâ 	Åø453TGpËJ²ÓÎ‰çB.œèÆb“µ|Ï×„`Wä4ÆV«Y›´/‹œÜ•¹`‘èÄ¨>2¬Œ±2˜ODö³áPBĞÉiÔ¥Å˜µzUK\rë\"y„3;0@yX\nXĞêEº\"ZŠòV^nlãÅàŞgX*¨L,3Ô’˜¨âÊšJf×G¶ol8aMKÕ•I‰€JG¥˜T¢@ëaÒ5Èø1V†p…™-Ÿ	:2šÖ‘á™<!¼32p\\k9}®èV½\$*ù_«‚:®FvÁ!Ë	aqè92ANÑaw¬Š]LÀòÁØJf+ñR¼µ›i¬:R´jaMµbCC\n93ö¼XÔ‡l	'‡+†‡qú\\\$F€­‘æHKˆU9¦¬«ÕòÆˆƒsÉ˜èÕ¯\"UuÙzÚ<ë\0‚BËÃLˆ(àÉÇÛÛ^+İR¥<ÿ)É(¡K%R(Æ‹£EG[CÓ÷.…\$ÔE\0ap¦¸±ŠR ­¾îzzá\npyá#y'Ôç&_KÄ¹G90ê	Bqå9»7ĞÊÃPqISİ¡\n@İò8.mÜ¹ºT5ŒH\\0ä7\"|öé	P_y,n\$Š‘‰ÈAÏeKpVU¡yIÚRêç‘±pËl³.­3q>ÏZ9Œš†÷\$u&‰¤‘ïş#Ÿ,âbÓVg™¹«;ÈğçU¢8“,*Ã\"ç¨¢¦Ø8PÙğfÂ¬% ¦fL¸¸{rœPˆdv)›ó4{6›T‘7eå¹¨¢…I9‚-#˜ˆµ¤Â¹İ‘Ì¡ŠR½&™…XëU©V›×Í[UhvJĞë'–3Åå9;Gk-õ*6E¸Øçe¬)6ofÂĞ™´-u¿¯»OWĞçdÈ6×‡Ûd»Ò)U+)1t'´M%éSI	^ñ'›®J}ï¼%u'_GÃ/ã¤G¦|·£HtÄ+†ìˆZ£Ø‘‰pH\0g,h>å`èeXÑe<Q\nğêC`.Îc%‚Ü4Hx+—:põàA’,O#¯ø®ô%ÅX¡4\\ÒâîİÿIx´°åKs6Rü^î•6ÂÙ1\"Œ¡·ìdêÚgPõ©ÑÀõ6¬Z!ì	%TÔıIŞaÒK9çEÚqfü¸¼£v®Í©ûGuÅ˜*IÕNí™{<j?òP\0 ”|,û '\r‡;âÁˆeÚ<È&/ø‹»×õNªw¹yŸ+T{Á”é‚GßÔ[æ¼±\rï•dƒ%ó—Ÿ³ õFj‡ ’Ba­49Ò•O˜qFê[àMuë//Âç~‡‚ü‡€|ë\r¿+âz¿bşŸÏö¿\\–i£>gxü¯ğw|¡Ké¯˜ûÿ¡}]ûowÊ¿ÃÓc:gLÆJ¥}PóœSHï*ª)Äú5£:ş-èë£î«®®Õk©\0ÄpşBh	ö!`È@¤0†Ğªb~Ÿà¬!„ä9£pJOP)l¾€à›‹b pJ€â[T-€Øh¢ ‡\0Üµ¤v\r£gO%b#L\r#˜'Ô²ædd8\r€V\rgX÷d²7ê¶ÇˆôáHĞª”è` ÅêxÂærâ<\n ¨ÀZ\ræc„ )E­Ëë¸p‚ßªß\rmÎƒ\\Ömj1ğÜ4²ñ î{ÔÊÂP»ğ^&@õev‘Ìò<ğ3¨\0‚¨Œ0Ã€ñğè¨%Ğªç æúGJBÆvãÆ…àPD\n… Ú?Éœ~ƒ¸%É”vj©*Fì âiÇ,h(?¤ê1àPCƒRbJ/¾Ìb<CP\rã5qd1íib<\r`Şj²ÊÂ=¨\"ó‚ˆ|…\"ÆV,6İ\"È#Ñ¢4†Îª”ÌÅÌ @@ì„¬\ndÚ!p¼Íq–<àšÍÃüTbÀŠ®æ1ö€Ã\0¤CJ«f!Kşİü'cŞ‘i·É‹Ä„ÙEviCÄªKï“®\0ÊÒ†~†ë‹\rh§Åş°<ÒJŸè3J¤û¨G¯ükÆü7+º=‚Z¨â:1òb\"À@š	 t\n`¦"; break;
		case "es": $compressed = "E9jÌÊg:œãğP”\\33AADãx€Ês\rç3IˆØeM±£‘ĞÂrIÌfƒIØŞ.&Ó\rc6ÀÏ(©’A*–K¢Ñ)Ì…0 œ¥rØ©º*eÀL³q¤Üga®©À£yÈÒg«M‘:}Dèe7\$Ñã	Î` L†“|ĞU9ÉÁE\nè€Ìa—J°aÔÜaO„ËlXñg7G\ræè¸‚‹H¥Pb§œE@ÓR˜\r1¨ÄøÍV4™\"²H±³\ns:Éî‘:É´Ë\n9‚ˆÆY^ ò 4WL ¢†}‡¬5ãx(¤e2ˆæ[©”èra«xdÌü›rM7/¸£¶AŠ2|[’Üí©®İö.i'×óM¸d/6'Îõ#`P˜7¬s¤ØOJP1¾ã“òX¸b³>ØƒHô“„`ÜÈ>\0SÀ€ÁÉB.ë£è„¸oæÓŒpÃŞ€Å#|V4#ªAQ,O\"q²„ç¬š\"Màê“Pôd4Å‹ĞJ2ò³2|£)¢òT@½Ì0Æº2È‚3H8Ã/²rËì7.rù†YÀÍTØ ÎŸ­Ò|9ŒkBæ´,ğD4&°Dòƒ³±îh‚1ÍÓƒt:rÖ ±lû&“b*)Š\"`6£oÄ’ )’Tg¥ãô@ü—&ÄCœj2®ÂË\"õºì€WÌCÈşÖZö¯=èúÁ\0‰)»\$B(ğ’P°Î7ÈñèÊ;1»†òÕïı^ÆË´Ë ºğØë¦#xÖ´¦)ÉÜ; p«T´l6[‰J-{0ÀØ±5‹ü×ÊèÛJ>‰€¦±5,êvõŒ)€ˆ2ŒW„G\rÄ4Â©3ÒŒ1ˆÂÉL8’.4ÍëJ 8\r0sÒ#+êşÀŞÓ\"/:°Ë;<é\0İ%ë‹:IƒL[4-*µğPßXÌ<¶¬é@à¶cº»(fy«¡~Œ@Ñ2ŒÁèD4ƒ àáxï¹…Î0Ú«6árº3…ëFúÇ­`^-I8ÎëmBúØ7\ra}fûm\r‡xÂ2ÈÃl:82ƒÄ&—zB:#-½;@&£€0·êƒ!–\"j²Ã¿Ì[×p3*(	‚\n7Ú3(¡J† ‹˜æ*¨ò¦â0Ş+Ğ'I„E¶r08tÔ#àŒ*êæÕ-Áø”gkèÂ:òk?2˜\nx¦*a)3üš#2+2z)õøsÃ uH´Ö¸RhMˆ©}o´ÃØ‘1-zèdÉšrƒ”‰i2à(,­„2ôL+‘\rç20Î\0L/Ìó‚£¾¤…gWF_ˆPm §¹¼œ•ˆ¸˜CR_,T˜*ã*±X@eB­ÜÃ²v\\GÔ‚`CÚ•ŒJºe0m˜…ÀÑ_ª;ˆÁÚ‡ŸCš\nÆÉ‘ór@1Í\nÆÜ32œË?àTšTnà‹0N™Ş¹•áßÔT‘à¢œàÊ¢Ò¬8¼ÆA’cKjÑ‰g-h«eÊpÖŸ^ÍM}4—TgŠ‘i\\çtÜ\0†ĞÌ«\r;„ÊI”%d	á8P T *]‚\0ˆB`E˜E6†\$Êíe»ì9RfÌó	9sd(˜š3š€Êº„§D'‡ –bÀcL¯¶\$rê@ÚbQ­ƒÅ¢2™IóY‰èÜ©Å\0}\0Rc\\åèğ4BPIÊñåIT”PÔäÙ‡I(I’d[\$˜lšG,&Ô²Ššj¬^ÔxÜ§r¾Z\0S %XæÒi@YğgCXâº@å©1+ÁÃ‡\$ÅLPÁ×+ôõh†é*Hàrtèl2­¦³ËÓj¦é‡ ßƒP\"´D6€B\"±8Šì”„lÂ(r!Hˆ´¡£`ºÎV•i	*¥\næºgé“­ïØ2¤PÆ‘Ş8®DV@ Ìo#ˆ.)®½™Úı`¹–®Ö!€ÃaÑ4üu\$U›ô§MQ\$ö9#\$‚`•ˆ5L\rÉ|Ä+c]_m+Â‚•ªÄ5\0Të¬;µV±•_cÙ1A–ÒÌÀÂ`ä*…3*¦äTÏ.]ª¨%Ñø9²<É#ú~¶AøÒíM½kKJ™ß˜ÈE«Q]K4¨Å`ä{ÍRI)%,¡^ÓÜ|	@wc’\"[Q|ÌĞ\n	t®‡™çsËĞE.i µ#\$,)­Pq5¤á„è›N»R9t¢Š½¯u‰¦\r\$ÁÖ‚ÈZ  )ÓÜ–ÂÇFøuX9Ã>á^q0è! rN‚>åYlÿNn;Çêó|xfàE¢%ê‹Àè•„Ş¡“aUå™.[Ê»=2º²cƒ3&t`ËyQã6	+NŠMk7’yâîÌÔÍ.×8gvcç¬èM8ÊªLºù\rŞv§gA§Ú3FÁ\0(`ó…D‚œĞ™aòáŒ/ƒ)æ=3\"³L¥:jåè©Äêºšé¼¹HròºÕj·Vêß'•ÁÓ­&PëœÃª×ÜX:½&ì™y‹ÕŒR•òàX\$+¹\n%6bÄØºõ²í%¸6\nÉáÖeí®ˆ8”ÕÜ'i•çŞ•æ?µ—i¡µ†êÜsU—‚eÂ’”n?»IËI¿Om3“æ:Zost}R©¼Î84;¬ÔÂ–G˜×»êÓw¥™í*Ú\r¹hµ–‡ˆ˜î&¥vóİÇ*Á>DVév¾Uï¾<„NéˆŞ«QJù§z/A×úÇ2¢òL´jóŸİ‡`ÕÚ·±0×Uê\$W{ìsHºµ_¬zÌvÄ\\Jªh7EYèšk¬û‘:Èb33ûŞ^‚„g:j¯á-ÒÒ{ÍXïmß«ô>³à;Ñsğ÷®´¾†í«—*«X5¯ß;>²C™/y?5å¼Š\r5nn‘§j·'«µ\\ñhæÚÿÊ˜/~ê[×#o%½³´HŞÃ¡a”[§¼y( Ş¿Ûö41ğıµ¼ô¥?]èŸMãI‡ÁáÄkã†™õ¥;§¾Ë\n´múÇ¿i?f¡ş¡å  ü”ğÛâ4ÌJ?]D4Jãêvc›Y§ÜÃàæ~ö>oúüà- Ğ9Ä,)&µc ı§ ïd’JÈÌğK¾Ÿ\"Ğ>ô(üCÄ•ã&IÆÀ-#Ä\$ÂÆcc ı¤¬;\"Î‡MÀ³%ö·%W+¨â-Ãˆ:àØjhiÇ~Ïh”P/¦¶AÌŒ» ä`â`ÈXtt†:^Éz\n€Œ p`d.b®´íºÂ\"Dx0^°m¼#ºª\rÄ”ç¶#b:SŠ `Åº“ÚË¤’9épM#r\n¦˜B¤ú€¢Ğ¨çjğÊEcWd*BâP`íR&fF#gà d\n8b²]bxPÃŒvQ(JHšÃÔ8h´ÛBî\">ìîj#¸åg†D‹V=@Ê&\\ÃŞ6ã&vÌ`“mh(f‡…±hÿHœËèÜulRc¥àx˜nàôlq|1£~éÉ2C¤Ml`lÌ“#À<D’œœhª¬Q°œE\$.Ğ‰:kdĞ1b:Ó,¯\n0ñ\n/IË¤,Ù\"ë#Ë`ËJ&Á’ ¯À1 ‹Íj¬QøI#í’ö¯x§äü8`‚8„?Éôöl	\0t	 š@¦\n`"; break;
		case "et": $compressed = "K0œÄóa”È 5šMÆC)°~\n‹†faÌF0šM†‘\ry9›&!¤Û\n2ˆIIÙ†µ“cf±p(ša5œæ3#t¤ÍœÎ§S‘Ö%9¦±ˆÔpË‚šN‡S\$Ôé4AFó‘¤Ï\n‘›EC	ŠOƒÓÄT,Ì°ÛŒêt0‚Š#©ºv¼GW†ƒ¥®2e…Ñ†S‘K \rGS„@eœšq·:éŠk\0¡^\rFºò<b4™Dã©´Å] Á®43ƒ\rHe;d²Æ¸lˆÂe3ØóİH(…`0œEiyÈÖ ON‡zá¬R\n#™MæÛ™Ò»y&fœR/¹•€Éæó¥pS2œß®„Ã£7I«W³—®ÄòŒ:F‹	ƒz¾Š³C˜Ê	M³“¡a¸†¡ZFÀŒ/2ĞÕ¶Ê“,Æ¨£Z¦¢+Bj†22Ã²F†0¡@¬\$ˆ¢»¯*Œ²ğ³#h«¼:ÄJº<#›v4CT%Ã£´<›DëÈJƒ²ª'„‹ÆÙÅHºû'O[òÕ<*”!‰ã¢tEC@ÊÂ¥h+Ş®1oŠ´5Œ#D2Ü&C¢ô4È‹È¨á¼iPÒ5j3„3·0Œ:ƒ`A ¨¨Ç½âˆ˜Š\r²º78#t:Àµã\n9\"ÒØù±¬²~¦ËÌiÌ2½=_ÇqìI =qÔC¹Pô¢­àÊ6F*¯TmP’6¥c’J©Í£iÀ°:\\R\rx7„\n®••‡R×6\0BË#c½7µkH:„¦)ÁbT¾/É[ˆ¼Q\0ì®\r·êÆ<i«™n4cdı'¨éj7'¬jŒš¾œº7ËéPÊ0ÅH:Yy-l¥æ·c8ÚıV.úª_C…øµáø\n‡„#‰Ö42¦¢+*5«ƒ“13 ÕŒ4·&ìØå}ãN¥¤Ë„ˆƒÁ\0xË\rÌ„L è8Ax^;ìrI1Ar¸3…ìFÚ<1ctº7áäÑ¦¸/ŒIÜ5„Aõ8 ®àÜ:xÂ\nD%5zöÂIÂR©cÃ•äğùê §­¬0ÒÄŒSŞø¾jê6¥*Ã½³^N\n@¡ÑtŒVè)Jj›³7’x–¶ÖêH”¹-Ê<‚¯nª½‹ê+tƒÇ¯Bx¦*·4Ö”ŞL\"¿#cLóé¨~gmÍH_­äCMN—ç>§İëõc@àÁ^8èMBÈo^ŠL¿WÉ\"±J¥x5,1%¯˜`¨íÕ \$ËDÂ¹€ÌX*\n>GÄš…Bú€W›FVjÔš¬%h€ß“, Èñó¨V,óJ£\n&Dqï+U¾Áˆ=@eèş´F4jIIù;„%£B¦hÍPS/Ì‹8çRÊÓké:gBí]¸m=n”6E’{ĞI)aÅ|¶Æb,X;î,fÙ5.BÄYÁÅ	f(»—˜¤¯Ñòğ&%Mb—5äÆ#Jt!m8\"pêÈXQ/9¤¸Z‡C¸AÁ@f+…<3—ãxN¹W‘Ô²—@\0U\n …@Š¥8 &Y\\rÌâô‰Gìä†&wˆä»f˜^ö¡0V‡jÕîvĞº\n]Ï¡¡Ğì…”ú'OÌR)¢¦‚PK;n)œ¤‚eƒRšé 'ÀÏL %d²v¬Ä0£CóMÁc“\$P…\"~”¥ˆ+Ã‚dY™5JŞ\rP”yjƒ 1 Â4“¬íHOÌZÉ2^•ÔÌİ‡f	€Ô@r:óœ•cmI€T\nA\$#„pŠº™„è·õ¨µŠâÓakv‘v…â!ìœøâ…2<y–iĞ¡X\"„à¨Î¼.L\nõqóì·©\n›äÆ‚’ƒ:N åvÖØ“a}Ò^dŞk³­Ö3ä‘HÎ|*†Pš¥Cj)+—t©Òi†´’‡rS ö±{\r,m‡¸¦#—–c\rñ%–v\$O@ŠØ)e‹‘<âôÇËj)cæ\\ÒO4’Â)#\$ùšK`†Ï„#uIêÎ‘WP©#qq³J¨ \0 ‚ÃC¬ï/AÕ;*š0¬,q0!&ÎËâQ\\X¬ß&±Áê¦;Á\\Ã™ŸH‰ÇC+ùÊ'‘*ë@è˜ \rË€8Ô”ATBã\\µVWe ¬`™*‚ğ{ğk¡'D\$Pä±âÂ\nŸ	¢Öf°¥ˆd¢î<kã²ö0ÂÃlM|‹‡C<Y…Ê¢k‡8Åc[ß4Øs’Çh”fî1á\r˜'èD#Óaî?‡3”½/–TeG)•,·~²c›Ë4P‚fp3ŞdEû>vnû­vf8dpÒ‘éAOp\rJd3®²d.V¸úÌbØùfájĞw»B˜#\\|sÜÑ;E =	ò¥-Ú\n+äx°æoE˜—×&-zaı]ÉÄZ?éô}¥á®‡Æµ]4½¦#;Ö‹XM0Ú‰ñÕ~¹u%¢:Rˆ£Ğê,)Øü:WZï]\r{¯²F‹SåGÈæ·Ö7v×Í«µä©Ü…R_^˜]vì’ÚÒP®îVi‹pL†,áâta™ñ*Œy@œæfÓ“\$4d\ry2D„Éöu˜¡¥}opé¾C”ï!Š881ğÄ@Ü)–®Ôˆ9;2™ÈùSŒ	>`]÷š·ã!2æg€Ùr÷VàJáL4˜@[®¹àÄ\nƒPtz1;»s¢Ìw2?@FËwbí¡ÑÑY)Eİ/¡í¬®w\\ÈÈ«¤õ>„{êzÈİ[CmÍuØuú\nÜm²0g«kªp¼ª¶éœwCŸhT}¬âäH€E{ÑNª…J²ôn¶ò¼W„šÒ	Œ»ÓHÉ ä?àUŠ1›¥ì~ÛÓ´˜Pˆ¾wvòÛÑv	5ôU*ùìÙ³7~šwé6%¼«•ùÉ*ô~µ÷êº½³*Õ9şúÍŒr‹%iÔü*c¢He¼ş²µß9Xw^°M~§Ğõú7ÔZê½ü;tß¥Â¡ü¿[x{4k²&#R‡ÿ0½RêFxÎÑìÅºÒÿğ^LûlnÔL`VşÊ`ıd÷+ÿÅ\0â«l‹\0êD¦\0P¦Jh¦Êp¹Ã€ìäìB,4úàoôÅë]CD2ĞÅgÎû¬wîûPXÈ@µÀ¥â²t P	M@È§/vøí(U¥¨Ÿ Ø­¯vcMÜâªDwÀ™B6t/ŠˆÂt“Ÿ	k`Æ\0–È Ü. Ş™\núµê&Í³b½bĞÚn`ã‰¾|0¶ã†^£¼\r€V\rbfg#z!¢–‚L.1¤ªrâü\n ¨ÀZ.\rÀÆrJŞ&§¨\"¤#„¨­€Â„¬d`Hv¼È^Ô«ÂPÎŠÃ´œÚÌnÔÜì2ABr«ÉáËn§¢& ˜¤Ô±Â>8\$”&\"zW‚H­ñt èÄh@@À¤üC¬”¤¢¦p¬É\nCRßhì†0|ãJ\rŒÎ¡\nq˜ÆL×c\n|©ŞÒlP#q²Í«\rî*NMº‡gC±Âö@Æğ\$\0@¿R,Ã `à<bNF¨É1ÀÃÎ¸1cTL©¶h	ŞíejÃGp£y¯„…ÌÏˆlÌª#’ ™\"Ê2ÂŠ5¢´\nQ–Ò‚dıJv+@ŸâL3‚´œG?ª\"/IzOÒ0q¦ŸäÃ¤l)îÔÕbµ&hûÊGï²“(âc«#FN„²<§C(ê7‚Ä	\0@š	 t\n`¦"; break;
		case "fa": $compressed = "ÙB¶ğÂ™²†6Pí…›aTÛF6í„ø(J.™„0SeØSÄ›aQ\n’ª\$6ÔMa+X¶QP”‚dÙBBPÓ(d:x¯§2•[\"S¶Pm…\\KICR)CfkIEN#µy¼å²ˆl++ñ)ÕIc6Ód\$BÓ!ZÎ-Ö•~äŒ„Ø,V}–'!³Ğ•”šl†·ÏUUiZ¾B@±ŠqA´©ˆSêp•ô2íQÇBÔùšœB#SàğëT­Q:‚HTÚkí“ˆN!([îÉ+†ª­ğ{…r ËÌ0ËJæ¥@Ö`4ÊëÌ–©¨ZlëIò¢´ã¯•ø…Ï¸¨ËãáZ¸šÏÕmˆğaRO¹Š€}dv>f®’B¡*[\0å¦Héœ 	A°ç\$ëúÎ«	jlï9ïT±¨¢U5©_\nèêvì4Å¢J†¤+\\8À-*9`«6\"\"Z#¤CL³´qšJV.¤B´lM3\0.…{hÄÇ‘Äk¤*,2%2j\"U!, ÃG(t4Ö-pòÒÅ¬ô/¬(!r´ÇÊD#¨YbäÇ…::€¬ğã^ä°(<D©®Ï„æl(ï%!-(|¯ ,[Á/‚VáÃ¨Ø6 Â1\rƒ*61Œ#sÂüAÌÑg\0¦äCTB-)RBª)sÍ—•Éâc®Ï¼pDÆÌ ™BJL(¿®µ¤lˆÇ,N•ÅI‚ŞÓN-üPÖÅiõº*ut›Uì`4.Ut|jå/³ÂëEË°Bf¥5uĞı¯VZ#f¯²,ûĞhŠkÂ+ı¶Æ±éí©h¹Œ<¸×Cè6OoüÖ%I#€‡É-U?p¢\\³/IÚ Ş5Œ£p@!ŠbTµ0L|@£ÉáT’Ë­AX’»Œsï}³®ãûÕN\"f•–K+¸àÊ*Ãñu¦®r’œÂL\nĞÕèès9l0èKî¤¦¬Z¼'’¯‹,xÅf¼Ü™Åj´%ntì˜DíZÅuª8vÜåBhÂ9ƒ(äØæ;ã” 2€Ò9£&*!\0ÑÆÁèD4ƒ àáxïÏ…ÃÈ6#vüp£8_’õcÆú7cHŞ7á*0C8Ê:rÂı1Na|\$£…26ä£ xŒ!ò„9„@è4\rò€è7ú#H\r#§¿\r´ï’#¬ëİ4.íˆZZ¿Îö3!Nm!ÓH‰âOkX³Ôh;LÒAC\$•å¸‹JAÉ)¤‚,ÖŠUÉ‘4)Hİ—EVf;mgIŠ¶ØÍ±¨2‡%_\r„L°R:€L©n ¤ŠRQ,âÈ–ª&(Q¡[`yvBXNhIùÕ\\ìgIQÄ:‚ø›ªÒL{	‘ª&¦¥CóÖÎß Y\ráÔ)ÆL^0ot@È† ÒÁ\0S\n!0`Ò¦A\0v\r.D#@¡rP\r/Â½ç»Co\r¤m¿gNùVÂÚWğíõ&gØƒäJş‘d†	™HT‹Ä]Í°¨0t<Õ×ê‡RQ€¥•é(ä’”k|3¦¦!	ãH1…œQs@ŸĞàºVGÍ91l£¹Â5d5Xãl¢9>,lª‹çäı‰x(kŒ˜—ÂR‚…ÉÄL\$dM4°ŸÜOI[’cr “B=A‚K•e¦´SFîÄOÔå&dŞ¡‚ü¹\0QéQÒTÒ3RÎ+šœ¢¢s€ \0U\n …@‹C¨€D¡0\"Ñf@:`OGú/ÈDAáı'e3™%bQQ¦@d„áh¦”¡34C‘i ’?%¼Ñ§2Ìld¿/0­8dÖj®t£‹œ1tüİDô(ĞLŠr`ÕL¶Mxx„(ŒOS´@¢#b“—µ/TÃ’{äX”âÖÓA[åâs5d©3Ÿ3Yk”\"­\rq>2@™fÔ\$‘™gñ^iµ…©ÏîÇ-#”ÛÉ·•dB˜”ÔZÑÁa-6‚~Î:Èv,ë>‹ÀÚC»WQ\r8”ğôÔOƒ[9d³øT…€S¹Æ•–<úJ©\\†Ï¤Xíé1hd…\$š˜M\nÄ F\\“ul€Wkä\$GÉ´6\"¶ÕÍ2“ökÊp\nUÈ·×†I¦X`‘/0DÉ•ÛŞK	q0Š#b]]sÓª©!85\$`H˜‘k·n\"Ù£ˆvÃ4ºp–­Ar{SNa¶¾¥d¯>CpÅfÂİ\\•Ì8™/™÷Ò ¤ˆ;°«‘ª²k\näC ›bR ¬—¹ \$,tÄKE5Á—‹P!8'Ğ±›cÇñh¢Ô\\\r†C\0Üö€r\r1ÉL»§ õÁ`…¾©PĞrú—S7iX#v›V!UTÆ4›Èx°ì3-9ÁŒ\\Xjzùbt*ª‹°;9Ğ«ŞÀ¬Tu‘ôZ‡)ë0ÆãÉM¥kIZ¤‰hePË¦U–%E¬óÃH˜	è·eš’'šs\\[®?5¨ÒŸÔn¼«p©3Æˆ¼¤Ä³	ôTÚAzN±W}t,ÏÕ\"!\0¢—€SGìêü•2‰C‰1{´Ü¨[2«jšËú¬±{SW{oj[T}å>Ú[‘_J³B^q”UÒÚRJm©»˜\nÏY3Óé	å¾Í>—Ş»û}-X4u9ßÂÔ¤eÏj&Ù^©‹\"ÔäY5tn\nÖQ\$®É ¼*íDE<TÒ31ªxÒÕãºBÄ/¬\$€èFFÑg–\n’îoè1aŸœ\"º^î[ÎW1ØXßè­ªA	QˆFğğÅëw&¼Kü‡rYÍX¡æ5HŒ`ZÊÍ¨/±b3H›ªı;¶õa²ÖªXjBgñ=Ñ¼÷u\">éÌöÇv×ıtônY0}tâ·÷ı5|'€çïÃØ¹ß4ÆÁñkÖ/£¼º\"õñZJ‘E&,¦T­0TzD,(ÆLl†­êë¦µ5§ímÛ=§fòz?£{’sl¼‹S÷|)h×Ä—\\ü`²I™Xço1º~*cøåW?™Xj%\"(?ZWô‹4ğİğùù‡sñK_yOÃóôÇïØG~ì¿ı;úõıŸ!c?àŞ¯ü²j/læŒ¥+*àïÚ÷†Ù·O¦è¯…oˆ±°ímè7ğj#6*Æóc@Ã”b0\nÛ¶¥¬GÅlÆcÉé\\_pN,ğHkúm‚Në,t¹E `*šgêØaìl)tTÅØÆĞâij+'Ò¥ìÀĞ\r¨Öê¼\$¥)Êã\rı0–ÂĞ¸zÇ\$\0¥84ær¸bJÉD†‚¥¢åm`è@Ø`Æ\r€Ò`ÖfŒˆâ Ø¥4Ì\0Úz ÒÀò{€è|€Œå4\r êo€@E4tª\"\n€Œ pJq\rÀÎ|¼¸°Rm,ÎPàñDØ*~Á¦«kCí:ÑŒŠ1DıJĞ´\"T n²µh..â2ízÿ»äsìòáJìˆ‚>X\$ÀB|*éXcÈRü%\0`/>´Ü	ˆÄ‡JàÇ'ÆRÄÚÆÂÊEe˜ì©`êF\"6„g.¼Ó1Ö¹Ê¤ˆ¯jÛ±à–ñä—ƒæÉœÈÑòm‘^Pñøş¥Î-\0¨Í@Êz¦Ê± d°ğ\0è`ÒG»RµKÇôÕã¾µdÒ5‚ö~éQä¯BÀÕ\nPÊª¶\n^ä¤×\"SéHB†¦P,Ÿ&2µd8±xU\n¬7\"vcFˆ.k¾‹›/RX¾,dV%Ì]Ä¶«‘ïã+\0aR”*İ­ºHĞ.`±êª…P=1ÿ¥Ú¬oÊ²®`ÂNÕÎÈOŒ ~©í(BŞcÃ>"; break;
		case "fr": $compressed = "ÃE§1iØŞu9ˆfS‘ĞÂi7à¡(¸ffÁD“iÀŞs9šLFÃ(€È'4ÇMğØ`‚H 3LfƒL0\\\n&DãI²^m0%&y’0™M!˜ÒM%œÈSrd–c3šœ„Ñ@èrƒŒ23,Üìi£¥f“<Bˆ\n LgSt–d›‹'qœêeN“ÓIÎ\n+N³Ù!è@uÁ›0²Ó`é%£S#t„ßTj•jMf·B9À¦åCÉÂÂÌ0#©ÈN7›LG((‰³’™iÆŒVğC4Xjë¬h…n4ï#E&§a:‚ˆı]ÏV¿5œa`Q¢™çRÃTp8aÛ‹ÈáxPQ4ßN£\0„ş3Ã>7:­êâ:8ƒs«¶cK>¸2L™A¬ûô†(¬À#2®â+I\"2@p*5Ãì¢tÔKèÚ°°È4¦)k.Ëûê7Æq¬B.é#n°Œ£`@ê«ÕB(ğê®hmFŠÊ(2xÆ€HK,KRãÉ\"Œ²Ø#3òÜÎ®8äêŒğ¨Ü\nS,@™°ãrP•%’É†\\B å+’‚ÀÂ¶R`˜”(pÏ¯Î*L:§c+7MPxŒ:§ÉÚÆ—cù:£ˆêa•H@)Š\"bÔ:Ôl2ÍâÛ0ò¤|—'C\0§¤Ñ)RŞ×M5@™ÉC7ØjÒèŒÙJ€\nvŠ`\r•í~üÄƒt	a£B…³É%@ÎŞ£ˆòXÛI×T¤ßJ-5Ùp-œº„tˆŸ.Ôû_0Ö»o·µÑdL2I3\rŠı7u @!ŠbŒ®Ë\$£ÁÅßŒu™Z ÃË(«%cm8‡·‰ºâ7ˆ3¢,CÆ¬pÃ5=Ñ\nÃ\$Xæ›½š-KŒ\nG¾C èK±VšZa”ÌˆìeĞ«*ÔL-(\r<\n›‰¯ä¤ı?ƒ˜î•ËC¢2Œ˜èx\r\ràÌ„C@è:Ğ^ü(\\0Œƒj ›%c8_Zqô»;5…á<9\\ã¦ø/¤kàÖ×JI%à^0‡Í\nõAâv7„\n\"®©Ípåê©¼œÎ3ÈŠ¼°Vô ¹ßËOŞhA\0 \$\nÈê8]Ñ0@*!Mò«‘˜æ\rÉHÑëMÓyØ¨)Hê6Ø	˜Â©JLê¿i«ãùÆt:Œı\"ZÑ7ÖxS\n„ì°\0@›‹á™c§PT†CaŒrÙSÌà§¢7üBH8 ;åª³•x\n\"’?%D“ÂƒŸ&%ø9'%€òÂ70eQ{ˆƒ@€1ÅV«JA/,äè#G›Jê|)Ê4˜Ğaƒ“=&çı€­È.ÆÑh,¤à£°–óÒ3å8ïWœômDÍ\$&VÄ·‘T<[h\n0®ê³Lzø‹Ì\nR€HHp,,ƒTş<„9‡FlêÀ„€éÕ#€ÒNŒª–yZ:¤ ÕRUŒÌH‡  @©‰,”*)Ğ0†hZrÊÁ¶	(l95²]\"‘KQçÈ\"RaÖ«ZK*`¬˜°Q\"Ó]xŒÀê‡59#	¸CI'Y#Š’¾_9è:@(¯ÉlÛC,¹	á8P T *q‚\0ˆB`EI\rô˜PáÄpŠM¶BØÔ*\nù€5†¹G—Òş}xpèœÈ; Íä¹\nĞ„ÚÈûÅHfjgÜºFX‡Qmd¾A%£’D€©d…•¦{	É)É2¦•³²[KÉq%`	5Scl‘ĞTxA|/\"6Š0xGhõcr!RV¡–¦\0!½äb©‡4„È#eñ-£1Ş…¥ömP%×<.qµ¬ó¿Z:‹bNÙÜ\$ÅÚJ×xS¯4;sf)‹#CD‡cĞ]]!‘ô!²5îcÏ‰²6‹°9Ãk	M7Š™T(ä¾K‹auKÉ`Ésš©,â©8)<T¥pcyÁŒ1€æÓ,ı¥_¶¬ÎS­©UJY(^m³¶¢¢ÛšIhJ=¼©‘­á£xRPÉùkâ¥\"ogìÚ§µWrÖÜe‡l-Ê¶ÀºÑ³KxäµË‚ô[)m/Y‰Ux¤Šâ×t.?(|Ó=™šÎÌ†XlºÊÙÒZÄ•#{T÷Ÿdo\nÑ†S“…ªÓ’™…(©¾¡ÂÓ’2{OxF4¯í©H {¬¸W¡‰&ÚÄ¢ÉïéJ6Á ñ¹QO(Õ-aæAØÛÔ¬:HIXtFQSåôj%S\$Š™¦é!ŞNÈ·O)“Œ«•Ú¬\$É³Z3\0æuVa7–yœTá€Ô¡É=Íhı.2zW9	Áç†C€NÉ¦z_ÎéZçƒÅ›‚*µc§…F2 _ÊÑÕFq½&è¢·Ìîh%´•õR€‹Or9SÅ“,æLug/zŒ—æ0é®”¢Áz­ ’]]¨ÕÕV5{G•úY'ÜöH\nŞY0\$AƒåÔ­³m²jh[’Á-²—¥\$˜†YÔœ·¬š5¦`”T…-G'ÊøåH›PS=5\\{Œ©M]_“æth%:«Qo(é½5.÷½ËêìoÅµwûÒÖù?\\Š\r¸BÁ¥…íû}¬õäxFûû‰oH¸´&×â»ç(¿>>Á¦7á¼˜ªòS½µ†FäÁè&Cm¨ƒ_Vâ^]îmÅÏ´Ä—XñrÊyÅç|ÃSãkÍĞ.u èn¯™.¨N«O¬Sb²ğGªu¢ë;Ú±Í‘Pøø¯E\r<?±õºÉÙõ·L!K3~xSºbù%uH…évSKtoX!¤÷Jk:øàs±U¨î6˜O|N6À7³5ŸSÔ³ÎgÄ'»¯\$G 9Ô.Ñˆ‹½%˜´Ğn¶·ÑxL:¼ãørš3O²uÎá.µ!gÍ•^¦UªÙW‰/ŸZ‰÷µÚ¸ÅëÚŸ°E¿ˆ_ş_s×\\bÇkäp²AÕ°Â¢ÄdÎåÉ#O,Ê¿oîÊnÓÕr§Ú°øsów.W—V-üı_söHî3ü…Oäş´¤ aCl\n„0qcl9\0ÂÇêˆ3¬P+EL‰®¥lœÕnrqo¢ü\röì\"u.–øîªùĞ.éOŒÔÏ¤áÍfş\$~&ÒÒHƒí8ÒD`ïÏTÒî^âKhª@+ÜÏcèÔLØ•UîŒ¥‚2:°€ï®Tî-áS	0„æ,¸‹pR‚P~/ğƒĞi	Ğ ãàèÜp&—¯ÂË®[ã\\ú/ŞmŒÇÌªª­ÍÇÊÎ­0ÂßL¤|\nßÎËñb[	o§\rOz±ğò÷ÊD¿‘\nÿéÂ°¯Ö—,6\$²E\$çÀÊ‘\$>K&ú/‘ƒ,²#æ+QBn	v˜K\0006ê;JÆ‘Äê Æ\"JìêKB™ÍêËIMåR~kÚÓ‘j!²ğĞA+:™¯f3ã³ã°uâ\r‚àÁ«T6Ë>ÉE¤ûĞ5‹Û‹(É:Ü †+àØil\r)P1Éf4RB<²è\$íBlLìîv\")ÀÄ\$¢ œ ¨ÀZ¶õJ°/«¾èP3Rz,½«t(èÆîR¯¨]\">\$-H?,Øam–-jQà6Äê[*>bƒÂ^2F\$R:rÑÚ+R:!C„UQÖ6¢nÙÎBŒGº¬¥q òvKxñfYE˜™Æ6qş0jâ(íjƒ„àB¾3ë8êÈ¸ĞBÉ)ÑºàE\n¥JXº‚«*ÏI!¬´…&“+Ò˜‘Q¸îMPÈ+¨¨R®ä§@Êb@Ş¡EFè5rĞÑŠ:dì›Ä@³\na,ˆ>ãŞ	…  â´xÆDÊ\nİ³Ú­Êª\0Š{jlc2ÍƒÂêbà\rÂˆ<Ã¡#qH 1Ğ«2<~	0å*M ¦ŠX¦â–úÆ¦|n91¨ì‡á60.¤¬\np‘	@%j>A†òÈ¬°D 0³ˆ	\0t	 š@¦\n`"; break;
		case "hu": $compressed = "B4†ó˜€Äe7Œ£ğP”\\33\r¬5	ÌŞd8NF0Q8Êm¦C|€Ìe6kiL Ò 0ˆÑCT¤\\\n ÄŒ'ƒLMBl4Áfj¬MRr2X)\no9¡ÍD©±†©:OF“\\İ†¼¤ÁQ£)’’išMÆ8,©Bb6fâéæPv'3Ñº(l¼Şï·óTÄÂ(=\nipSY¦²r5o’¥IÌéO™M\r‚\nµbµ\\›‘¥Œú~ÃYËåJÓÖÄS=E\r ¢\$RE «ÁM&F*D°•Œ¦pTLr ŞoúƒÑ„è\n#™d´A„L :Ä'8Å­ëÏQ®È¢6i/šj²ÌJ”_5éÓ¾¡ğñes†ä\"¬èÖ­A\0äÙB Â9;CbJßƒê5¥EĞäë	Ê»Æ¥\"ešH9˜ejÜ9ºÂ¢(¸&0ì?Än±†M\rI\n®¬°²®3©\r Ôç¶ÔÉ¡£\"š€HK!>ñÜ\$H€P–4Ëû¼ã¨Ü5ŒcKP5§<pá¹h¬œ²D¨ûC@ŞÀ\ncxä1&*@Ü³632Ø•pÜŞC\\Ü«1ãb[8C8A5kà&˜¥‹„6)2¨ØÍ»K€ÊcÂ77âˆ˜]6¶Ck†7,uJ„9îã¼ğ((“QÄH¤HßªãlSY ‘elë\nuÊbÎÂ#,ÔØ¢®Ûêû¼4Å„\n@ì4³£8Ò:£|¸\$£„Ü·PŠ<[ĞdÂ±Iìëû3EñŠİC\r—X,S-u>Ê“'[IKÌa‘#”¢TÕ¢b˜¤#&ĞŞ7Wµ©fZ¾6’†]\rP¾Q£’ão2íú¹2mÔÜ³l¬5Œ52¬hPÖ›\$98{„ë*®6.ÃÓ…”¥İ „#*n&åùŠ¤³ƒ(ÔŠA`@Èéc¤=@¨8Aã«€`J¾\n”`÷“miëÛP/c˜ï7HC-È4©&(&#B3¡Ğ:ƒ€t…ã¿^CjÔÓpÎ¡Àğ¬Ùæ„I œ(¿Já}n†d:xÂ1h’“5HHu„u@WHPİ’‰ËRÙ”±ÈÓ#}ÌŞ*Ö‚¸cÈ@ı¨ãB’ŞÆE\r²3íü@@(	‡Çùhsœ)ŒVt6å©Úz¿Ö50ôŞ¾^ĞŞ¥zbËŠC4\"P•2†+A•‡@tbÉº&Fl‹3rbxS\n„Àú‚ˆ²yUÍ!\nÛáW)P:5 ìC;Ò/ÏùŒjAËùVV¤U’…ŞAš\rÀ€:ºĞŞ¼¡pb\r*)©âdµºÓ&!*>%6‰êå)Nø3\"J¦#”lì¶¶—yø(%=yÆ' Æxb„ñ’0¬Ó”IúSWíFì½:k,Å·¥ÄlOÈ±ipaˆ&Y!\r §”­šˆSÓà\n<±'¨”<ç!D«äÌaI8FP±\"bŞ àE‰\\\n•îÚ\"èy`Ğí{6gœñà\\!±ëG°Y!FUÜ\$–fƒÃXu\rŠ‘èÊ\"’¢©AD\nÔÊ§ãÌJ…³\"73XòøƒƒS§	h*\"ŒÜÈTäDÆ°×’¢‚xpK)lœR®ƒ¡\\5ÅLà½BÄY\"FÈ¤”ªUĞ\\	§ÈÂ”êº'ë^+Oac¬…åÏA'3§\\2Ñ¢®ÉIÉ­_&\$2*PÚ	DåÆnÍğŞ\0PINmêSf’b(¶<‡\$˜‚CQjòi¥IŠpØ<É™dŠÑu’‚NB^#UB!´ä¡Ã{`\"•9[„„ s“òÈ\\K‘o¤âzÔÎxFMÄøÛ€ ¥=‹RÚ?ï­µ“ès9£4§,YÕŠ´(jáÖ«ÉÂ)\0×“¡¹ êq#©„Ü’ìpr²XóÈ	b\nÓçgˆ°°v—ÑĞt„íjÆÙFÆQËQYq\0¸ÙkQìI•SÎÃ»>C\n;´e-!ZhEjh-¬µÖb‡Û;8d¬ò7·è0ÚKz›­9Èxw´¼ğAmÖ5¹†•WÕB…Şy7´¶ĞÉ5[^­ˆs4&h™‰±HL¨e'd¢º5{å#Uºêl­KDÙ¬1¹RÀb‚\$Ê4ŸvnËÕ<G¬#z`¸eEò,Õr¢fÊaç½š{aæ‰¦ÎR8¢m.Á,¢OÃÉ¾kã|á!(FSd•†Ã„f1Íö“•È¤dgŒÙ>HZ5Ÿ¬–y¡´84ˆ*¥	m\rğğ8U/vÕŠ•R\r=Vêğß=š<xĞÉcb…±5OÌ÷ç4±ÃœA³k<Ø°ÎÏ÷²Šœ«É¤åw—r‡æS%Ğ”­a£2ÕÅµ«¥RŸF•„sVq>ŒŸ‚¤¼-’y‚‚Ÿ)e‡®w¦Ø	DåA¦yÈ=U¨ÒÕ}7É´JN)j,Áâ;`Ï	MY;Ev›k´e;¼ŞaÓ„hF\nHéW/ÆUšÿãNƒÚ«Ê;ÆfÆ u›FiÚâ;,Åb±4y+Ò[Sr¯MA4LlÛ«7t,m1SÖ®ÀZ	³o•tg4sVİL—+ºt÷Š‹8a¡—Šß>p/á¶îÒİtíX	áå«_pÁZ¸¥Ïªü^Õ~5\\8ˆgãÜ‚æÛË#tn’¨ó”Ì§¶#Sfæu'›TU¼	µ1˜Üò¥ğ\r-À´Š&IºŸWÎÚ  êp- Ü`sbµšÔ@.ºÃU…-L5µ¢cÔI›ê}U›ëªhKYºìlÙ­>wWÚõY~å*u~âŒÊĞni­!IÌN‡29îê:ëGı‚@«ÆÊœú‹HæNKõ(jœÿ„t0†š§8Ğzm\rôe‹¤4•'ô»Õcùtr&ÒôM›v{\në»üîŠõõÑ‚=-ëê(E÷Š£ÜRUoğˆÿ·õ›İ[„²´\0R6-Eöå9%‰9‘¡ó[_ĞäVïšâ’s“1ø¸çœá\$çôC¿ÀÍ/Õ¿üpØÕÅMş”ğ#-bôÍ.¬C¬•OğÿO—\0O¢šCš2„2¢^ áRK„ÚŠĞü²ß¤Ü«,îıî’&ğ'HBàîğ*óŒX3°Ó-‘ÏÌ¥P[\0ìšn¼ÿpY°V©íª*­ÏFB*ª#OpıbC…\$\nŒªğLş¤K	p\0ŞĞ˜¤øùb¾j4=C4êúöc1*÷†óËÚ=0Â=°¢øn/@æzÏ ãe8 Üh/,í&Š?À­@Â¤cL,KÈô‚”RbEˆÖ²\0h‘j±\nDQñŸ'èd¿ân	cÚb\0ôlálÆ‡d£‘9ëÈ.`ãM¯\0003nH¸+!ÑZÒ@†B Ø`Æ(\0Æfæ…ÈN\r€êËì¶[ È\r ÌzC4(\"C\\)FÄã€ª\n€Œ pzbÖ\"âÔëÄäGz[¥¾/ñH£¢î_%Íil#âB\$h®åôò…Í\n6ÀÆlj9à¤?aBÕ£=bşƒ¥0Íqî|àĞï\nÂVÇğ<hw¨Œ\"…&äÖ;£\0ÄÖDÜ	ˆpæ:ò6\"DÜRãêEÑ:Ã‡ o¯bC‰ì9Ï.Ïí£Bø\$àòÑlÉL.(fãlzÆˆ+L‹&éPÛàè'Â,ÇÒl¥rsÒm&E ©öRâ`ê^Ÿ'\$<füÒrp2t¶O2CjjùÂÂîÒ]'\$àS€š~äÜ¨bR*dØÅQE\\)Rc&jZêŠ^¤>¡éº¨\"€Y\0•F–ûÒô	PöEŠò\r’æ¢äDlá»bQëe(‚¸İ¨ÌN2{`šVÊHLPH¦Î‚²\r²ô¡g¸\$‡¼7cz±fÎi\r Ú"; break;
		case "id": $compressed = "A7\"É„Öi7„¢á™˜@s\r0#X‚p0Ó)¸ÎuÌ&ˆÊr5˜NbàQÊs0œ¤²yIÎaE&“Ô\"Rn`FÉ€K61N†dºQ*\"piÑĞÊm:Ïå†³yÌßÎF“œ ÂlˆšhP:\\˜Ù,¦ÈåFQAœ‰	ÀA7^(\n\$’`t:ˆ¦³Xİe£Jå³JÌë’Zå„¨í@p™ğHSœh¬ñiÀ€ïÄŠgK€…“‚‰SDŠG2›ã›CH(ˆa3RÎ[+%XÛ²“·%\re82qHR¬ô\n–\n&Ê«>W@r6Î# ¢¤Øi’w®„Ï„f´¬â9eS–6ròş?Ã\nÜ£sˆ’¦#«t³§	üìˆPÈ’©K£Ú÷\0PŒë( ŒãÊ‘DBx;(Úp	\0*Cª–„£ƒpë¡/ Ú¥=‰ÀÔÔª,Z ‰ ,Ø„ CJ££`@64)Hàö\$èB–’\nbˆ˜JÊè²Àú’?«*lùFs:5ªë „:¾Ãœàô¶Sº4»¨Ì4±Ïr^2BL\0±A`áD	rŒèåÎo²Û(Á‘¬ÀîMsğ;N TCchˆó‚€!ŠbŒ!²Î‰…Á\0–4¬ch@:¨‰ÈÌ±+xä¦¤ãC¹)Ne–ŠÌ@Öi|aF©³`4ŒÉ`§g’9…ˆ|ŸÅÌ²*¢ãJX ±‰}X7UÏxÈ–<,jNÏ¥C˜î±Bã(ñ\0Ä×x@ cDL3¡Ğ:ƒ€t…ã¾(QøÜ“…ËÎ£¸ÀğÇ,ªø^IãÎ2˜(¾1W#XDPÃ„©à^0‡ÌŠ7’\r|.:\rñtáV#O;Ó‰ÁI`ŠÆc’r¤ŠH£•šì®š=äÇÉÂ€(&éË²2YIÈP£…*Š¦ŠªÚpË¨3c¨ÚÂ„ª ô±ƒJ±[ ºÒv×³*5ê•b½Kè@À#]À£Ùğ@(	â˜©¦¨–2f˜Wõ”vÔÉÏ’‚¥±/:MÊ3í\nø’+ƒpÌ4£ü!ÄBÈŞÄŒmhë—\rêƒáº&<¨P(Œ*kÅYCHÒ•ŞNèâ‰m0Ö)w]ÛXzSW©=Ø6uaF,”6øAÔÙH£Så3ê¿´³ä¦,ÿ›f¢³y(-\rš2:ş©?VÁÓ6ˆ \$f’âÚ¹‘<‹‰çŸÒD`	G:ˆ§–Ê\"\"\nà½×øTèSOOYW®òÒZÔ©d%,4œw\\ƒ''„à@B€D!P\"€¨j E	\0 œOH †G\n#D„`_Ke7Ftˆ„jağpDJ5Â.\0Ï\"‰dˆÈ	'Ó^^`»0&& 6¦åšUŒ(n ±5Â‘vŒ‹ÛáŠ|¼Á´ÃdL	\$#&ÒŠ“\$(SmD˜å…2æàHJC°n6”P×aye,´1 é(›5ØÖ´#ÔBZ’‹9eì²–€Œ¯È\n\nHØ„%‚ÆcCI¯8Êiô:B]ÀR0…È 8‘ƒªYBĞ¤ˆBÄ²LÃ’Â•«t¡wÚg›) #È44Â%\n:Z(¤€ÄS²ÙI8%“VdLù4q:Fu#2BQda5Ky%„P'ÉP;1„­¢:T— Q(—¡	ÿc‘l‰\n}p'	‡CÎ9cyáÈé)(M–m^aÜ2†(nçM\0£òÊ\\†\n…Jqe\rH\"¡GVŠ\n£S½ï—Àÿ5:Œ¯vV“§<ƒW2¨EhO¤vSPi)–J¤„q‰XGIÁ³Ğà #&Ìñ[‡¼Jˆh›*-fäFMUL³Ö¶WøÍÈógHÊ¸ÃUª™­n®ä¢KXóãò”§•ŸAã%bR•‹'d:¦y¼ş*m=\r)„Œ”ÔèF”™hˆñ&Ğ€¢9&’ÉªÕâ;¡X­j‘£‰öÀâ„èÈ¡d!Œ³604ÙRFfâ  pÆL0óEpHdxÄÔğvß3Š²U<ú¾ãt_eD²n œ'®º}»3FÍYÀéx_[Ü¼–òßMÒ[gß-â.‰8Û»·OÌ•ô‰7L^e­ïå”²É \",Ê‘@ì×D{¦¤Ö7•Œ“Í¨(fè	Á!\"¶ÌjW(lÂ31¦ái¹0dÁA“Nç\0İZŠt.ÅFöû]KÛ\nñL0Å—jê_ë U±–«Ì9kV…w#ˆü÷p@®š°d>ğ++r9@É\$Û%ç\n“¤EºÈ¯m¶‡PÔ˜²Ò\rZDc2oMAnÊQ38Ø›¢YÏ’‘ò•^»·ãŞÆ¯~ÇYt ±n>—§ÿ>Kc›KtºÚ:\\ı#opÔ–åKKh›>K\$“¡Ót¶÷ŸiÃ¥K MW„â­t¨L5k\$-I_M%¹é‘“ªQ¡§\rçÚ¡4½Òúaië;!‰ fD‹PÕòºÙÑŞ¥#[(\"){³š~Ñ3¸ÏÜš^B!'dš^ü,ÄúqåıÓçsì<¨`&¦Ãx²H§·\nFéÒX¿míİõf÷^¡Êãidø¨’äîäĞ¼ Äâİ'8nÿÇÛ44Ê-¯ÅPpW6;Mhùtu%ùáZO\"ï»­üûäÜ‹c^x:ÃCgRÊZ’œq`Ùc\rs/l.¬[ÌPS…¡ì\$©ØÏ\nYh	¡™ÙAèÔÙtHÖ÷3hXc=áŒŠ•÷n»fIQg¡µ-@òĞ	`FPDmşn…×\rÂ F àÅcÊG§^–ú^·–\"YÑ	RË¨q' zô…B’Q;…Ô»®8ÌU6œ…f¼ôİ·,*ë©%ì¢40ÙH5j9a1Ú’Áé·dDÏlè,n¨¶Vq±[ü®â=Al†—@)&™Ï_s‹L!²ùËŸğ¿¿Ãxp*G¤6{‹1˜ôfHª9©Œ­­(MYÄ&+ë–îN9ßû¿~á[’!øH.M/J[¢3{ÓTYùe	qÓ†‰9ıË÷Ûbò=¯x¢ªĞ}LÈ°¯¸I‚FBI=âÜ-äAàÈ5âĞŠÊ5àÖ1š1Ãb\rÀŞ"; break;
		case "it": $compressed = "S4˜Î§#xü%ÌÂ˜(†a9@L&Ó)¸èo¦Á˜Òl2ˆ\rÆóp‚\"u9˜Í1qp(˜aŒšb†ã™¦I!6˜NsYÌf7ÈXj\0”æB–’c‘éŠH 2ÍNgC,´ìu7ÅÁFø‰œÒn0ÈDèÁĞÂbÈ%²Òe|Îu0‚Š§;Î`u°O”ÚRi67h§:M.ƒP©Uæ‚ZT4œ0Q¨öé“°›ç[õRÆuŠDADC\rš  ®\\JgH‰¸Îh2‚ˆUø¤R2çˆæS|SXi¸Ûj{r\n)™NGnUË;±(Ngzá“G¥³Î¶\$äW.c0°a¾½%8r§&îöÄ¬i9Ü\r†“Ñê`dÒí½ÿÓì†5Œàè®\"hŞ2\r(óÀÏ‚Ì@ĞD˜,ËBö¸‰ÊÀìŒ#c*f­£˜Ê·¶ĞŒ‰ ã @1* ÅQb¨†¹)Ä’.\"2ñ° P‚3Œã”Fğ¼hs”ğ+j¸Ü8­ˆ9A\0%(ª4‹<‰’Vò/\rxÊúÂ‹èßGŒt½„ªš”Œ#rŞÍ£\"0)Š\"`0\rè6Ğ,ÁoÄ*íBü&†mƒ!ÈI‚SE5TL<û»(\"0j@¯BHÚ8+xˆĞ\0TB•!ÔjE\rB‹:Ò¸ĞNÌDQôiÇ‹ˆØÖB Ş5¢¡\0†)ŠB2œ’Ï¯œä\rÂ¿¦b`ˆÑ#Jú0¥«šTÓ£0ÌÜÀnÀ@1©ïˆÆ1ª#˜Ş¶\$1vÀ2c,6‘±„,èúVÒª®EÒñÑÈÎ!eğî¢Èäš¦5Xß\r¥´`Ë+¼Oí?¨ÒZ&§J ä“©(*Ã%!–`x˜\rÌ„C@è:Ğ^ùÈ]\rªû”+ƒ8^ŠècÂüš¤xE4¢;s˜ã¤7\ra}O	>ã|Á„\rğÑÍ(Âs`	^@õM®ò[è÷†/<ª.ól']+Ãî´¤+ê+¤0!\0 \$\n`ê8T’ÌÅ\n0R˜u1(,z	Ä0O>4Ù‚ƒ”Œ0İî0´ò ¨Ü°ßÌ#/ÌàpBx¦*Y‚ÓW»0Ëµ<?Ó„’c!fcLû†Üƒr<·R\"nÁ¥¢ÈŞ:ÜshAÃƒ~|EcHÎN‚b€¦Ú\0Œ*p³ÓOÔ;Hè ƒjå9ƒ’ZÒPq/dö÷[®ş[éóg¥€Ë’Ôj—Ì”€\n¤2“\0Ü†ˆÂ±RÊÌ\"’\0Ü¹]¼cj¾O™ÈqiŒ+§\0ê˜:l•¿÷àÜ)FGÌ ïšR0¹¤*†Hü¯Ä¤ÃzLªõW³cRÒR\njHãÄµ şØËşoí½g¼¶ph84Ä1ãØ—\$BH¡<'\0ª A\nF@@(L±¬±›ÒCI\"R,„Q&nH\"½2)Œ&%Ó`˜#hpG†ØîvÓÒ„…„®&èe\nù+6Ñ\0006É\$|J]0E„Ö&0¦¨\nš§\"Tb½*İ°mCGé‰›`©V’o{!¹)Ü‚B&På~``¦ĞOlmr‹ã&9„Š!ä¡5Æ3ÀÊ÷‰*À*ô®´àå'å|ÓM3tæ–Ö¨ÚÃ‘ë™(…Ä ÷l|UÜ6A®’´™—‹áæ0—ÿ&ÕT4ˆîæk%^aÊ›hÂ+pÂ‹ÑQ]6\n™\$Ê^	Aäğ–Á¨a]&}.“°€J!´Y€¤/Bm£´|¢Ñ¼l\$}%'kğ–Å3âIaÁëNN´Ä\"0êR-¡”j7THiK†\\ë¥uÑ\naBª-Oë”:Õ2vÿˆzÔäXŒÃcXH”’|d…*BöK!«pÅB‚\$%\nTŞiˆ\$`3Ÿ:èA\r¤#‹Ùú€ ®C„sõ˜ÁÑJ5\n\rqZ‰Œ(SæJQ*†\"I¥&8*‡ò€FÒ¸YúÔe>†Í½­Z#×±+ÒúØÙ€ô ht\$…z'—ŒPZpsl¯\\8(\"B\"ÕÂMKô)–úr.q0«l&š«¢iÊıµ%O\\’ÊI q–èYá¸“Iâ%ä&¶ÍÌcåÁ0j6÷ÀÅ[z£¬|Bª¼^Â/]‹Š>&t\0¬eä]ù\$,‡D8<öM¾˜­†öŸ“ ä|À¬õî^\0P\$2_>À§?õe\0o=p+;ÃŠ”©Ú\\wÑÿb¸&N0­pbP+œˆ™t­Ñ9Iã8\\2!=½ˆH‰c¨´DËŒø3ŒùqäùìÁi­\r¤ia!S»Şr”úùXìR\nl—©ÉÊ¤ÅP–ÏD…6Ú*ôfé®æÈe£™-@gY­œ3•óÈñ`&U¹v{+ĞriÉ`Ó‘¢¦m(¹^hpæª0F_M8b;¯˜½t±xÃ\$vÙg…0ë\rÑÓéçhJîÌ.ÍA¹ŠÀYçŸóÆqÏW¦ƒ†ù–ñPÙ\"nP¸ÍD¸ğâR?f›>!;ë²ò)‹C#^ŒvëåJ¦Ÿ²:ób÷ı?-É—»oí¸oŞ*šûn»B§L\n7lú6ç‰GôÁyuú:so>r¦İ´‘c0åM›“x'\0Ñ\nôLô‘ÚEáÄÁ<†õĞî×âÑ\"í~+ÅĞ!·7\$’‡@òzWõ	Ö›GÅƒ“Êÿ¾¼½&ò½ÅŸo¯~|ÃŒª¤EÏ\$ 'ÆVÙ:ÒöfÎ~sÅ/øÈt)0e ‰™é·j×teúrİ“28ütz»zÄë]C£®¾'#àY	Ë=é½ÍöwLí=Uÿu~ÓØ;ºO6¶{v^“ÚíYÎêœr-“ÌŸğH'FÀëpX¾ç§LÌäHm\$PÎ?U3MfuWËA¥ÿæH#Åb2ì¸ĞÂ¾ÙK1b—Ìyø™%:GŒğ„{ ¿œ9–Pì’¥*+{(míI!ôô3Ü·lÚLC5°†3æÃ]sÔK&‚–?áƒÙÍ¦Y4Wğ‰(U\nƒ‚¡Óù®©Y‘¾ÇIêµø_¹ÅÜÅqKh=û¥äŒ’’{0Aï°äE¤Á\"ìm\"8>iÎû	Ğî\$**b0úŠ’ÀËP6€²Ã.8ãÊ`BÜ%Ç´EKØ^åbJH9B0ö00M\ni‹È]¢HÓê!‚®+*x%Ë—\\^‰R1G\"\rğv_°VÿD×ä\0_2Pk0p¯Pu/\0Í‹Ò\$„·M>-‚up2>†&¾Z4ä8dŒD=ˆ†øP«şKƒ\\ãşPIÄ\$ÀÔeĞŸç‚\r\"Ğ4GlKÄ|,æ‘\0x¦z‘€\"ÂBãn2(ü9fAéOÃLôë¼ê(­²ˆå.j>Ì8Bd|M\$<èFè•'(>b´	\0@š	 t\n`¦"; break;
		case "ja": $compressed = "åW'İ\nc—ƒ/ É˜2-Ş¼O‚„¢á™˜@çS¤N4UÆ‚PÇÔ‘Å\\}%QGqÈB\r[^G0e<	ƒ&ãé0S™8€r©&±Øü…#AÉPKY}t œÈQº\$‚›Iƒ+ÜªÔÃ•8¨ƒB0¤é<sªW@§*TCL#‰i\$\nAGÑS‹,íÆ€A…€§B¡\0èU'NEêıÎ”TFĞ(H2j?wEÁ•ÎdZ…Ê¼Z¹•0\$öMŒ_Á”pe4PA£Ù:Î©«Qî¨c™/)@ªëuÚı†ø™ªkPsÚa\0M9×Ê—*y=J¬+iyê]JæLà\\Éd?mÊˆîG{Ú\rUT› åh4Dq_rAVºÑ´â>U#‰èN«¯#åÊ8D*„;ğÔhc—œåA\\t”,R>¦Bd ä¿±ÊHª¡#¾Ë‘DÁ°z9	9…Ê¨—E‚®Y§¥ps–Î‰4Ê8(äi7DpAĞ™_§¥9t¨I£…+ğI(\$IÌM–‹„Tº+	],ËréÒP§96W3La8sú\0 €QÎ[•I6C\"C @õ*ğaÒ@—1Å\$±Ds; TôCDpaÌR‡9hQ1eÙvs„{øÓC´2FÌóãÎ[RÄ\"zò<ÏC4t’¥»d¶d¬ÜÃ¨Ø6 Â1\rƒ(@9ŒcÜ\nbˆ˜–há<Y±]K3\$\r<räë‡ÉP„aRÁI-KäA%ğé=2\\·Ò˜dñĞ_—§))Òt¡|IÒLÃñº8NÅPb8@Z	dfÈ‰Iå`ÄãÌ\nQ%7N	\$¹–óñ]ÑUBPÌPØ:LYpFœÅkV@•B¦)Ğ[ğûÈËùrÕ!\0@Û	\nÖ5ÍƒdƒUR”#øƒø]¥HıdA¨vmÂŸ7´ èd[khÄg¤Zƒå©#š«4Ÿ÷ù óÁÄ\nÀiQ®ƒÍE£¯h¤c±iVY— Ğ]¥È±Àš0c Ê9‡9ãxå?£Àà4C(ÈàÂ\rèÌ„C@è:Ğ^ıˆ\\0ŒƒhÒ7qáw,3…ã(İŞpÜ9#~W£ä3Œ£§P/Ø0ÖÂHÚ8X#o|:xÂ6¡´:\r|ü:\rÿÂ5ØCHéÈñãmí…Éë:Ï´-ĞÒ®È2ò ‹Ùc'\$ì\0[÷4ˆÒÒ\"\n‰&fğ¶cæ}D)lâ±‚î×Òd,Äğè#¨#Å{û4ÌÀŸ„G\rÁ«C¤•¨Äˆ\$‡@¶€'Ö5Ñ>ÎŠŠ\\#”Q_5íù£™6uBxS\n‰!Â‚MD	7\$0@ˆãÎ¢¢İCe4A¢L9E„K6q,†%ª\"ß	…§B3Âø²ßbK}oíŒŞAÅ\rÀ€:½€Şí£A¤3‚’\0f\r+`ÒèÂ0T\n\$7'àÒõÜ³ï}ÒD9ğÚ°Üxvw.	–²÷ÇûIL¢ä\"Çã8‰Kü‘µÒÈXˆŒac¨¾\\.¡T;{‰M†>1`:4K†’Á%ÌIfiÅêoN%P–£F  …ÈäS\nrØ¸á²vBØsS®TTJ?ÍQhñ5<ø €Á@Îèş)µahÖ{¨áˆğƒDA51J„(§R*”r‹¥<Gšğb¥²]KÅÌG×zÎNÂÏ¦¶€' dF‚?Òğ^‹ä#œâXtˆ2Àº	…¢B@DQJ,‚xNT(@‚-@¨A\"„À‹RaèDh”rˆñ\rª™l?jÁY6#*#˜®J8@\n1Î%O|Ğç@rˆHŠZ(1y¯UîÊ„S*:òğ ‰d¦•iÍKä’¨Å,(Œø•NÊ^Ä™¥Ø—Hú F'ñÁdÔO¤ç\\‰v¾ÓZoHW\ru^ÉI›â?BÎYT>¶˜AZ‚b˜­w#ˆuÃã\\ĞC9?'ò›ŸzR Ø\"¡-‚]/a6[íˆ”\\¬!Ñ´áHBUÍn1Ô@’ráclÛâÁišb#÷|TÓJŸˆŒ?—zÜœÄ°@oK{—ä˜Î/ŒC	rù7²\"œïŒ[#ædA-ÎQ].ğ@KïwoíŒ÷Â–ËëümÊ)WbÍ2\rÍÔT‹!†H¤–ñA›1‡ìƒ’5¢hBíá¼·…1Šh¤JÈå)¼V©Œ\" ñ¯M‚_1P9Å!kŒhtõŞÖp¥ê\ná”1dµá“MÁF)®bs–ğšt½C”XñZ—G0¶”G³%Ø¦Néå=¨äĞš“dC£¢f^–+æ HŠgM)¬“&Yañz<hQ/ËjVÂÚ\$shı#cû¤2¨çÒi’Ëæ5zúd(d.9^†€Ó©•òÀ¯Õl-¢¸bÖÉÃ™HğL£ÊÇ­NöÅ)\\÷[ì.¹ê]çÍ0öÊ+êÍìûé´hÖËbóeŒím¶Ú»ljŒî“VqûViAÛEà\\D«¡­¦è[4U¼7“Sj¨›{‘ıó½5Y­µ¾ÃØİ¨™vñà¢ğÙ¦3öyÄ¼«†Ê	ÄHF…Õ–3YË›ŸKæĞ˜\\n[ÍtÅTö17Ú„gùƒ-c%ã·kn'Æ¦¯2\\‹jé>EÌ&:¥<Òm0‡HW—œİÛ[B½-LèìŠ:óÜı…Ç(‘ƒ–â©\r…Ï·Ic­e›f@½·ƒßÎ}µìí6¥I),l~oÜlúW±ıÜRSNåN;¦ãêVIoeHı—ƒpñ1ªáV„w% l^Ì2'nDyˆLKótç6ZÌf¿*øY³.ø,¿ö)¨jb±\\+Å® æ‹¿¥2–xŸ_{˜¼ÜØû\nI¶%i[ºw¾ß·ÈâTù}ë»|ş_ô¾eîğ_[å}™±Ñhçï[í·ÕôOÆÜkLETœ…¨‚‚é>a^#‡(›1D\0Ş§ÊÂîm€Öâê¹Æè†2ëäTìF¬ç„ËPìoÖQ%;+¿k ƒ†êjc˜f^Lp0Zp*ó¡\\ıbYcñÄÚæ¤>N	¾N±Ãöm”0\\îêüO¹ƒ™Ëu\rˆêP8#ğ|jĞpùÏĞäMç°nøĞyoÁ9C˜9Ã–„£¦òÍ˜épw\ndB9êÄ„Ğ´‡ ^î™Ë±£#­	ĞÑ\n°ÕC­\nKV¥\\éM°ê´îõÏkZJğƒD,i\rÑäÄıcÀE'‚®ºdºğálù‚>»0]°ß/¿ q€ĞsĞ ì+ ÅúmÄÚa0œA'±R`á,Í(x;ŒGl®v3ánTáÎş/æ.0v?&”C¤pR#\n ‚Ø‘~QOèO¨„MÏ;	-®fP\r€V`Ø\r Æ\r`@xÉ’ Â\r€êXGĞ|GÌ\r Ì @}ÇêÉ&X@Ú§\0Ä}©\n ¨ÀZ\0@wÀÇ Üçê¾ëò\$ç`fíÊø´˜æJòè´Á¢ÎNÄğQğD[·&¬·Á\$Îe!l*ƒ,Bz'ñ‚0 ˜àÈvàÎRf‘\0ÚrÅ„ÕE|-\nÈájÌÁ8øf*\$ÆP ÜX§\"‹ÚrNáv¥k*\r¤Ãl\n#(.P»\"²“Î@í\r®\n…~X-L\r\r6XQşwÑÎ\0è“àÒG<~­’Û\$Â»ï°°.€ãf®R‹%HÜÆ+tİnpê¸±k”³-(Ì‹*X7¥<á\r(°Z'å:¯Â8¹á(bV·e°Lc¦@¨R™)ÀÊª-\$M’úç%¾¥%#ªV¤í*’¬±E™+‹	p{ê>Pl?«\0†bzƒÊ¬Q<ìİ u2€t#\$"; break;
		case "ko": $compressed = "ìE©©dHÚ•L@¥’ØŠZºÑh‡Rå?	EÃ30Ø´D¨Äc±:¼“!#Ét+­Bœu¤Ódª‚<ˆLJĞĞøŒN\$¤H¤’iBvrìZÌˆ2Xê\\,S™\n…%“É–‘å\nÑØVAá*zc±*ŠD‘ú\r‰ÖŠL‰´ƒ­=qv¡kGZá)ZZgĞ²ä–\\;ËK’	XìM*dP‡Z\nFƒ&Rµõ(‚ °·©e1ìvASb€+aNÄÂ’¦s«Ñ0§Z½qO\"0V¼&7‘¯¤#ÊŞaÚ˜JÜ‘\n¾\rÉX!Nµf%<v%ñ•§bŸ¤ëB@‘X”Ú1ÛNƒrYû§’ëU*eÉŞš5aZv¡4Şâ+\\ã³d[èv‰dé+€ë¶…3¾\\‡Y`@e‘ã—«îN–Ëö‡CˆyHé¥çQnÄ“°ËX@E«P'a8^%ÉœkEÉÖû?Ó×…	`é–e£>e™\0†©ôÚ/ÒD•&2ekàTÉ9˜”Œûœ ‰Ä”äŠ22I‚ÿ¯äBiú åAØœ.S*É!„ØA‘.™TT&%äâeX¹íQNPäâÍ&º³°í\$ÉÊ¡;h\n@ˆÃ¨Ø6 Â1\rƒ(@9ŒcÜ\nbˆ™\$Ii@\\ÑÙA?Å,5Ãïë]\$Ée”›¤Hu”äD¥bØïõ“eÙ¨ñlJPœ~ÇÈOYló´…³?\r»Y.ª/ªJ;ñ,N³‹™'/ké),ËdÑ!ÇpÜ:ıB±¼ÿ.V••f\$0\$ã9C`è9.K»à]d‚f!ŠbŒƒÓ‰XÒB…JKá¯iAÕ9÷:ƒİä­âMŞp#B²éTß´èCRÕµªlvgÁÖQ‘™\n’fËQ•è\n\"Lbx¬mwG Pš0c Ê9†¸9ãxå4£Àà4C(É‡ƒ@4m£0z\r è8Ax^;ğpÂ2\r£Hİ¯…Û0ÎŒ£w<kÃpæ4üpERŒ#Î2›¸¿TUÃXD	#háT¼hèã|×„Hè4\ró@è7ö#×U\r#¦Ã¯µwT¶³Lã<¨´-™.¢RØ\n@ Ì³uè@*MÆ<'asªKÜ7K\"<³·~yØâS,ô&Ğ éš¥)ˆ<\"™&ú¡J^#ÉÔ,Åá7O4Á”^:ßÚH.¬Sö ËZĞ	áL*\$„x›ÓÛ<¬V³Î/^q„‚ËùÒò Hì‹Å¡bh³°@‚‘õœRT[Ú¤\rgğA©ŞA­\rÀ€:ºpŞàÁrA¤3‚b¬Ã0iU €;–ä‚£ÓUÉ 4ºfÌïè ÁÈ7†ÕV×Ã³ˆjmU‹B5€ÀV_%°—Áuş°Q	şñš¡@' é7«ö7ŸÈò²áJpNBu§²Å%SúÎb<05†–’â^«±´3ü­¡>‹;—ş S’*‰!¾²TU` z/Lv¼W¬U!Dà€òä ËY/3ÂÌ‡‘P¡Äª‰Qeåz—ã”‚È`ë65Š¦)f’Ô\$*}å<Âzoì\"àu‹gê²¦DÊA<'\0ª A\nuÎĞˆB`Ejä!È‚‰HD¬V\nHR›+I¾F\"]Dx™‚˜N®3Öò˜¸[\"H¹Ñ(:ÅH˜M¨©kÑiN\\™‘v”Ñşq#¤‹&’|ş™Çdí¨LŠ‘J;(‰g¥AØ!‰+NKO¤E \\§åœò\">RUµHàaO…äˆñÕ\\T‡eNÈL\"Ä\\–eAN:l\$²dŒºjÉ0\nù\0	F(Å@ígn#Ä£²7Æ˜à´eô—‡`¿FèÌ.x\\A*hSåÊÁUöG”ñ0p2Aˆ!£X‰2ÉÍ÷ÕdDI&Ò•òõïA”H¹›²	©Y{`è,)´vµ\"FV#à˜ °6M2NJÉi/&'@²±)¬ÅHH—€vxŞØaJeÔÒÆ2`R	»Vîq9Y‚0ƒ	\$sÓz^\"\\ì [ ˜W¡‰î^\"\roŸä¸¶æÈN³«@£\rQ™ï­H\$É°íLgu3t¬|M}¿–Ò:%T®hÖÍ;iÄK\\»jPe^Á÷ÔÒØåƒ,©ÃÂzƒÃè€i¹Ü\0äbª©saÍR»ˆŠ^T¡ 4ãELª+BWfqC«ÁJXŸù6ëÄCÜŠg2DÄdPĞN’[Èµ–ÂÚÁQız%ÖÎ„ĞÄ>feë4”Ö6c7¹–™eúı\r.U¬-´Ä¾%·&WNlÎ«İ ._ÎñW®Gİœh!¡Á\$Ğm£ÏäzÅ…¦ôéXû7šp®r.TäFÓ¹>€'à(¡Hpé²ù£äœwÇå¹¦l£ÏÕ({UÉgÛŸlÒjBøÄçc ëË\0Ò[KI…ôvp¶\rÖ{	iX¥Åîjj[.JÓÌï_ëC›Z·0à½as'Úa¶­m&…¸–n–ÍGoázbf1Ó®È¯aÄ1Zw1S±Vgm\rÍ»êQ`ğ¦?Õ}ÿKx\nÓİKCƒÔ™ÍÀªfoÙh¹—Z2šDzH)rœ•ïR˜:è‰D~1ºJêÜwYf€\"TùGI@;nñtO’Œ¯¤ôê\"œ\\`‹¶Jñ` åxJò¾[ˆxGZyw6Ôj|v²Å¬¦…ÙÍÛ²©|(›v?ïş§Ö¸–¾Ü¼[•-®¾ïß]êø‡v½e±³†Éí›¬é÷\0ËDòf‚ˆ–´ê²ĞµH^\"Xa6Î²½ŞUÆ¹æô¼Ñüa[Ú/zxìò%S±8}¾LÕ«ºz±ŒŸ™»]Ú´2ß=Ùüx°¤BdœÖÔs¤\0€OÑë‚¸_ÁÎxíö[:¦å‘ÁÔz&?uü%y¼ç¹÷rÔV„*kì5}¾¸Nà¹«û“êùÿEöc‘ÉğåY÷Üís†q}oß@^}cşS…ô¾ò¾Y!Õyõoöı»5Õ_î4ˆáø¶ÏüªP\0÷¥Æßïí\0ÏØª‰Èÿïèö²A\nê®êöAoŞúğ.úÌóİ k€ĞmÏ(®e¼\\lœÃ²QaÔ[îFnNÊ€Lâ“‚^“Î\"[#6â<ï†KgÂâm~Úaf«ø.AhşkÒv~P|ïË±ì\" (û#zf\r€V`Ø\r Æ\r`@r¨’Š€Â\r€êUGnv'j\r Ì @w¢‚È¤U@Ú¦º\0Äwˆ†\n ¨ÀZ\0@q Ç\r`Üì0ßaÂ&}eÌ\"ÿlæ™¬ÜaI´Gò01 LDÈLÁÔ„–c¾êÂ‚ÀdÊLC.+ÂÈî§ÊBNP ˜ˆàÈpÀÎQb‰\0ÚlÅTÇLPKşÉAdçÈ\0éŒö4f ÜU¦½Lè^Ì\\!‚Q,õÍû¦vÚQ‰ÌÀÌP( ¨TåRÆŒPÅPòq°Â\0è‹ ÒFİ,¼çønÊWîJO¤şP#²Ğ¾ç§S6œr“íF;a.1á8PËœ¯@b’}iQÂDx¤RHjE¥\n€å”£¦ (6í¨Ö­*˜Ch¢-Lä3\"ÆvötödF6Jºèj² ARB>\0"; break;
		case "lt": $compressed = "T4šÎFHü%ÌÂ˜(œe8NÇ“Y¼@ÄWšÌ¦Ã¡¤@f‚\râàQ4Âk9šM¦aÔçÅŒ‡“!¦^-	Nd)!Ba—›Œ¦S9êlt:›ÍF%!Š¡b#M&Q¼äi3šMÒÊ9ˆ—ˆ\r†SqÒ6ib¬ä‚\0Q.XbªŒ'S!¾;¹İMf›0€ìi²1¢B„@p6Wã¦ëBÎrsÏåôJ1Î‘J¦ŠÆ‘ÒíJ´ˆ#±H(¦k‚TjzR!„èaÂ¬PMD4¨e”ká¤C±”Ôe×Ö¦À¨¸Öl®‘Ì¦óo¯KÓ` tø&še•éŒ§-í^›ÎçépÒŸ á¯b¯ó]İ'šnĞÜUğQC¼i5MÆ{¹B€ÏÉsû¿/ÚT®ˆ#¢®ã#¡\0È÷,¤õ0k,9£Xèb•c“\nC(È0ŒêL; ƒĞÉÄ1J»#ËÊ˜„Êğ:¼h¹^é”*è¬Š&k¼[DÍ(J2‚ø 2<’‚è\$›\$IPÙfA0\\4ÒˆÏĞÖ1¿z Œã’ˆ0Ì€’2©èªî¿c¨å #LŠ%oJ¾5%H°éM@&%R[lÜ2È°Ò6+.øÊ€iZ.ƒcD0ŒK1Œ#sL(‰\0êô¸ë˜æª5ÃLF9B­+S£<aDR\$aBƒùF«mË#Ã˜Æ4;ø§ÎPµ‡b P‰\\¾#æK¥öˆì¾ÃJş±«#TÄ	#hà«7@PŠ”\\lìï¥0+øÒØã]’+qÃ±,‹3AîbÉhÚ`U¬ìURµ-Häæ‡¬É²µ(¥â¦)ÍŞ+l€@!S©šö¾¥+M€ªÃlÅ\\_Ìb_U„\rC:Á\$‚T8—µ×kô3±C(@7)(c¯“2ÕÚĞ¢.B<ÒMäPäŒ]ÍÒH)Œ·nO(ƒJ•¥òVqj\r!pAlæÎ2ù0¹Úço\$˜e‡£Ã„	›Ï¹CŞ<è)3,í°ê\0æ;ªÒ@Ê<LÌ2lAã`4LÃ0z\r è8Ax^;ópÂ2\rªÓ¶*Ã8^²tcÂÌ7%#xÜ„T¸ä3¸x¿LÓ£XD\\,C±|‡xÂ1áš:\r^-á\$û@èÃ»iZ„²íªúÂÄ1CN´¯,\r‚„/ë%§ïº2*6´\"€(0ìI.Å±¡\0P) ­Ã)ğªä%:Z—¬uSÒTß!2ÁÔ6ÎhKÙ¸&ÍˆÿRjÙ‹é:\$A¾\"5bØÂxS\nÙ– @±ÓÈ¾`í+¦Z`Yp¸7ØËé\rÁ˜¬!ÂšY;<2Æ¹¤/x\$‚Èo NåDb{›…i\$¬Aõ@GÔ[:/æÀ#GĞÇL\"â\\†å†`äsaÛ;­´à6óöléï`|’,öSÖ£}+iÔ²¦(&P3A±¦¤óæ—ŠómKØÁÇÈL¯±ö\ráªšætƒ	Ô!¡,­÷:o(Bfeª¢üv×haO'Ìú£ë+P¨Væ~Ñ©/5¥Êô°ª|,¦”&’²c’ƒ_(ÑjY\"ZÌ»4Ë,ì¶æÔÚ×3!9é0I\$	%<«\":­_)‚‚eÉZS¡ÑpöVË)¦)³‘b\"Š {\\˜Ä\ráÅöû>'1] D†„•pÂq.5áÑ¤P‚Lğ 	!¸1¦cß;	)á´¯’ò\"Öİ/©>QÅšÙI¯ d5l¢¹U	Ã¢‚Š´ñ^_Ÿ ¡-'Ôí‘¢8GIØ*xÿI’]ÌØiEEt&L7Õ< \$k47EuR/A¥j«‚\\†( %°Û)CjÊw¥¯TÂMÄ\n§\r1Y¡P«»®uk]/`ÕØŒLe_é	V=eQs‡5Ò¹fØ¡7«I²S\\WdTŒÙoŒA\\DËÙÕÍÜò,ƒ:÷á3Á©„¶ŒˆÕ¤9¸¥R’&¼ÇI‰:Ø@Ò”ÑÔØJáVÕ*i¬+ìÂA)ä”wïmİ²2\0&ŞåJK­ıÁ~Ğ2â²; .¹–öè#«¤kî¡¸ÄæØ\\’Ÿ6^Áa¸'0Ğª;jÃèI×ºçª{¼.¸¾—Á“‘‹¿¯ÕÜ¾&:ÿ_‹À‰ò‹\"Äb‰v³0pHl480¯à÷îaZ‰@jt)L\$<Õg[-´õa\n Ò:ñDtğ8ÄvŞ¾¸ä½´âã¹ŒyšÀÄx(´>TIÏ*–%ÅZ­rE§	Ä†Ùk±'rj@+'\\¦ûx¡ÛAÊ²JO'ägpÖTÈó#Ä†“:\rÓØ«­²ˆÕ^8uŒ¾¼Bl¥ÔÈe›E=X+\"ïbsê·pÆŠX ×‰‘*Çùğ¹çâ= í¨¡U´Á×I+/*q_oµJ™ššŒßVWWøO¯­5—–I™6}|j{©f%\"Nn€Õ\0@j™¦/aÈËi:>K5Ó†f0êš}„c'¶³Ÿ3Œ†º7GWUªíÆê‘Ùµ´‰B~–…t)Ï:¥ÁB‹Q ¦cP	€WlÜ}W‚^9M;V‚»ZZjRîlºd>óİš£0oß¼–¢¸Øo/Ç½ã•èS™†ÀˆéÂËª¸Y³Ø…M.ß–;•Ò-Ck£®×ÊÄG,5 dxêãá®á6.Em¸¾Öäñ~ÉqëïË.ä·3¢mS3bfë*œœİi¹‘§Z@AyŞ¸¿~I¨óJ8D¿¦­^'˜k\rc8J(Ùbpç2s¼•M¥t’Óˆõ\"\$w80Ş\rf›Ç4†mâ6Mÿei¢A—R–ÒjåWÆ†ÊC7ô¡GH¹ìPô™Ñ(r\rÚija/1¹)¥¯([»‘^f‘N+æ9†¤Ô½eÃ²Ÿ¥ô[ó)ê´OèPı–³ß†ô~–¬¹öœûÜ{>­Ás\riVøùÿ\\G¾%}>Îmÿ•Cü×Š¡nÉ¾ç–?ô«ôj³åO•tbY»øß5û½?şRX}a™	z%äÓiUú[@|sî!å›ñÈÿî?‰·hüä>ïìé€ÛJ;CPûÊÕCp6ÒjpôbHıbX#pÿÈR®m¶ôïlÊj~ïÒh0(dcG	êæ®¬aÏ¾öâHÒÊì÷nJÌ0e®\$øHıƒE„<øÏû¢°;jú	ƒh+¯d÷C¾´#ÄÂì¢éå	‹F&ErğÏÈX¢<+GN®h*Â\r(¼DË ÿïê*…a¦A#¨C\"îIÆäã…N(*  pØÃKq\réTåébæKkµ\rÏşÀjBAPúÀëLuDîIÆÒNr¡1	\r4÷tÒ0ì?Ï3kÌG¦Âäñ\$åêt-@d\r€Vf²lPuH–È êgJ\"dÂjÀò‹‚zŠ'„¡D’mŒ\n ¨ÀZ¢ƒÖaâIÇîÁŠj)‹q#*kq<Âqœ#‰¦¢0yÃ˜6\\KDò­bM«CJ\n@ò)ãV!Â¬+äFs©ÀV±Åª4*8.úbèI-dË‹äV¨&%ÃÌ8j^JÈPh’àÏ È”dÄÌAËDà~äÌH¡j˜Ó(â@êÇ¾\"#É*É„ÕÈâ”ª|3Æ‚ÖÕB*p£ò3òS#\\¨òD\n…0,b^Í{\"È\0Ş<å\nDD\$’T££b/ÏB:¤ÖM¥nÃCÒVµÃÀ×†ßBÜC†¢jºe âÂm#‚^{²PÌK°4 ‚+f³\"…f	ò€s²Ø?¥R M.˜Ã‚l\n…G\$	”¦rO­(®‘\nx¦Š~-²~?îj‚*!°(h6¢NLJˆgÄ Dbà@"; break;
		case "nl": $compressed = "W2™N‚¨€ÑŒ¦³)È~\n‹†faÌO7Mæs)°Òj5ˆFS™ĞÂn2†X!ÀØo0™¦áp(ša<M§Sl¨Şe2³tŠI&”Ìç#y¼é+Nb)Ì…5!Qäò“q¦;å9©²gÎF“9¤İ6ˆğ,šFl³MSR¡„Ãq¹˜GSI®äeÁa\$#ÚO7›#–1”ñD9×cª¡Î±Z”Q¤·èÊdÏañ8Xm(Ë23[,5\\6e*<œ\$˜y5âf\n\"Pç™[¬|È\n*Bä ¢¸ÂiÓ#–	œX;Ãp×3y¶k2‚‰‘ù.ÿƒv0œä‡Ÿ)”Ú\n)ÃNĞİVXr9›¯Şò¹„Æ4ƒºš98ï8Â1=/’7%ã;&æ#ÃR(¿\rÈã¼68ë›¨7*oRÌ1¥m0Üä)ª*JÁÄ¨ê9B²¼;„ àô½Qú»Æ)<f9Æ Pœ¯±€Ò•½â¬†°¡­ú²ìL0J”ŒCÊVÉé¤İ‰lĞ#£tA-\nŠrşß‹Iúï˜ä¿¾TBßˆ#2^İ%`ÊİI®C”¯#:V2ûw./	T³\"£Nø\n\"`@7\$Öÿ‹LèßÒš…EÀĞCÕÑÜz)¿ïpÂèøô¶7õ\"6Ôõ„Îà(p<DÕã)´£~\$£„İ\$Äb(ñaI[é#lŒ²\nX»# PÉZÓÏçRÖ\0P×-\rƒ¤XŒ(#\"Øb˜¤#'Ó8\\\nÍhéH23-IÚ<†Ñã‚»hé­™g&n’IMŒã\"jøÇŒĞ@ X*8ÿƒKæÛ!(úô*ÆV–*Lj9¬ç}¾wíÿ ª+ªY‚/W\";s#·:c+ç&©»ËzÔPÊØîƒ_w‡•8ĞÓÁèE\0ƒ€t…ã¾¬&#jÜ†…ËPÎ¦{.ê+^PÃ’8:iÂøÄ¡\rÃXDX	sÜ™à^0‡Ìî\rzR:\røxÂ†*(ñX-ãpèš®x+,Ì+Ì>%™Õ\0 \$\n'(’4Oû7¨Pª…9êp8p£{‘C*FÓ0¼}à†ğ(Û:šŠx¦*¶ºL¨ªj‚–¦ö×Œš³-ÁoÀçK‚4¥>N7¢“Wr3ùÉbªkb3Åj¼š‹#zE(£ª\\˜%58ÅsŠth@ØÑ°ÓSˆÂ§:VÊŠÁMÎ%û”Âzzƒ’j&¬É9—¬¶IªA%M5*ÔL\$[\nİ+ÔŞˆÖ‚ÒyĞlõ\0  S<ŠT+:Wö]Õi&^dYï¦£2Lãß;Ä\rÍ¹×&Ùñ\$34bÙE¤5•”FÌ‰Bb§…‘ÒóÃ”ƒ\nµn+¨ÍÂ¦rĞ°ÔYÙj¥°¢ÃØŸ	x|Åˆ‹„à@B€D!P\"ÇP@(L±ğ³\"wOĞa=áAÒÈ¦\"¤Iï\n†äğ„ÂfŸON!Wq<;Å­\nŸµİ))åùø Nó•ˆ´È™3náÑ?Aá<6½².XDX‹K¢óÖ¬†%ç½“ ğ¯ËÏ(¨É\$¢˜ˆÂ!?.1\rPÍTF£Tl¹P+#~Z5§\"t‘Åê…'2#\n5Æ7†^[Œ2ÆY|,Ä‹'\0rVBƒ^ŠÍØEgaĞ‹ cêb—äğpæşpIæZˆu!¡äˆ˜Ì•(ñ7áF òA`'èJB˜2kpî<ÒJ7J¥*6Ôµ*Æg/Lƒ[rÅH)#ü€)„ eBÆ„«Fi¸s¡‡2Â)Å:ƒ4‚ŒRSØEjUªõf\\›dìhÍî%äÅ%dû_}l(¬†¥Å¶(šan8'BDGß»êR¡¸‘Û'˜+„q¨´ÇÀ„Ôˆ\0b±Ëğ‘Ö‚RUk<§§5—:îW«yR²I„|TÉLVa%\"2(²q±5µ‡¹PÄwP­˜m{òâ0’øOÒB}\$¼2ÜáCkEš»âZğ–˜hd%Ø³@°à¦¡ºêl¢°TÕ\n5ª7òjìz[*\$‚§—ß¼©†ˆ¦:8‚¶Âß…-±é¨QV¬_…MLËäÈ¿¤xß`Ù\$@T—kp™Ò±V*X–\"ıÁ‹%!¥©…\"œ ?vBVVğ3LµµN÷êÙMpn¤,‡' ¡>’°R°ÜS÷ÎÛhzù’ü6°¬n­”ış u\rc‚Y­¾EÈQ4F«•5®½øû(+EêUTär*»}?R=+7ğœ7ÂÉB+\$ÿ”ò—Óı‘\0NdÌÙ¢ºÖZYK£-\"(³»7Ô*Ã<m´ŸAŒ}ŸçäÉ’4»M8ôWÏ¥bk‚Óˆó¦ĞkÅRÅ‡“òˆcLy„(6cnõ±9,Ua¨7RÕøÄd-Ó8Ñc¤ëÓD*6é·%wW®°¦\$t¡[Ş•ÖÅëDhøÜp&ÒÔ./(­ÌI”wIõeAè¸2£\rII®ÜFn-%€&.İœ¹8P¦ğªÆä¾»¹Ço‡·êô i1øÄKÿ‘7mT\nˆßï­Ö¬Â™&Y2™Haó^’S´«DXhÈ.šYÅÌ´èï,}œ¸æLB¸pq¬ætr“KiuAp9½É¹.G”S–aš\$¬ùgå5Y«Åç\$5IğµA/Î<Âúè»Ÿ€‰\nX6]-™S¤“>¡ÔNé]CÉ3u”¯¦>ëÜ‰r®ÆªR¬FÒQÃ+9Ğ['w`Æ·×·Î©ß¿²LìîGe‚ù;{äİæhÛÀwr3»¡:<;ê‡Ÿ~å¡£«!üòS}¼ŸL¨EÎ¼2qÂ•‚Ái„…“;‚×ViVäñ²§]«å4õ”Á°bJ¤*D­A¦ŸDªó\\&¶.<%H'J:âm¦øÕq!â§ò€PC\\A°†²<HuÄd•r¤–m‚dB‰Q,µ'j4`Ò¢	Ù%(Ô\\*…@ŒAÁÄ|+™\n“Z{`7ãb¾,ŒaJ¸§ÂŠß‡.ÿoúYKê#4(\">\$-¤ü\"*#¨<˜ÆO%xŠD´òã×\"<n @P*nE'¯¾%¶Øâ ëĞ‘‚Ú?@SjOà˜~3bbÓ£¢zÀªâÌŒLªEÂ4Œ/-ì­æ,Â€ìL(¤Ô%ÃHä ˆZp–`­VÏbR¼ÆËù	ƒl»ÂÊlmç@¸¯ÄŒp'@Ò!P”.ğˆ»Ä^\"ÄÊôªæ(¨A-ÚB¬@Æl’äşÄ\0ñ¤*Oğø\nÈÌWlôPô\rƒØØË´b¥`#ÃÔ>ˆ qÂ™	X	äZ©,Ûb\n†*iâÇ(H<'•\nÅ à+ËàëN¬7l ÌâÌ»LDCbT8À	\0@š	 t\n`¦"; break;
		case "pl": $compressed = "C=D£)Ìèeb¦Ä)ÜÒe7ÁBQpÌÌ 9‚Šæs‘„İ…›\r&³¨€Äyb âù”Úob¯\$Gs(¸M0šÎg“i„Øn0ˆ!ÆSa®`›b!ä29)ÒV%9¦Å	®Y 4Á¥°I±Àë2‚ŒFSĞ€ôm4ÇD(íXèa±›&Â\0Q)ˆ™€šãG“<äzFó™êî :ÌO4˜”Èn2™åv\\ë\ne¿Âƒ¡B§UâW‚\nÉÒ·5'ˆòt£ãæ³(œu6æ&3Ö@D0Ûô‚\rá†2T2Î©ÓKY¦€rßáôQÊoÜVQ3JyæCÑ„Õ&0ÀAE<ÄĞä\n*â¶ı”ŒHãJMö¿MÈ7c@-'ÃxÎ:¼ã˜Ò»Àcà0­ºß £T(\rí¢b?î‹´:c ê„zâ4ÀkC4…³š#¼-EF)	®\n\$'>ˆääãÈ½¨Ê\0Ô£#_\"c#Ğ5€HK'O0è<ÊR¤¬a–c¸8C#\nbÃ¨Ü5Œh  £ŒˆÃ4¬\"˜õ<ÀPÎò!ê0Ø¡¯BœƒHéèØ2ÂÄ(Æı»Ë@èß¥#«\$„±ˆ;”:H\0ò7\rÊ;¨+§ƒÎ ¡‰K É!lÈæÚS#º<´Ç<Ö-éh@)Š\"`7ƒ¼¸¿O(à¬°¢=13@aEc”—8/…s]¬¶pÑhQb–*À/€à¾¨…X×>o¨×.KÂHÛ0TXŠ^]86@Ò`«i–kúXú„-[+ûd\r×\r­lKìÈÎ6`/ü6;M²qŒ(pÈıèœ5¢\0†)ŠB0]YÜràÅ(CÈæ”Œ,`Í £¨Ø0ßÓR–¦×¼ú#É\\À6¥Ú~‡ç´í> 1¨0@7ŒYyG(#œ*4¨A\0 \$\n	³Ø9J;OêCX³@°<ØùÓébÃ.1cƒ.»_•TŒ)²p°H[Œ9òœ2ü~2dáâ‚4Gã0z\r è8Ax^;ópÂ2-€äH#8^ˆtãÂ7ACxÜ„QÀä3Œ£§&/ŒY¼Î×páA·#pèã|Îa²4<q*Vä\r%º†Ië!á&Ëbr2¬»3¾F)wÏ²7¸7²ÃÓ1õXšØ Ä%éŠf´Ğ£…¦Ş\\Û´aË*U0Ì	p, @\n\n€)*íØ‚4àÈa¡w@©™Ö`Íã®yää¨ ÜÀA\"7ˆÃ‡¸\\\0Z!ÅÜS<`U30S%˜“­ĞÈh‰\\\r³\nÓÃ%9H¨uC¨b,Ğ¬LÂÒÌŠ”Ä H¡˜4 r:ıƒT`P¼,†òJÈñˆwá½Ï‚‚_C:³V ‚*(0@•`F\n¼\$àÒ»ÓûÒ†6‘ƒ0ŒÁ6	Ä€Ş“âÈ`ÒŞaì•¾²CAf‚	ˆAĞæ™›ai%õõ¬S–’º_¥•TÂ'äİ4ª‚UØŠHz˜N%½®‹[È3…A´?‚^áPA­å 0’NC|»#!=‰²†˜ĞÀr]Œ%½ÈB€ºÒé©G*øItlzÖÚÑmÉr–6J˜éœ!Ñì–×¸ì&Á,6Wùa^Mª¶í!fÂ^\nê”€ ğÈI\"yia\$j‚·?B\nü˜.áŒîãÒªz7.‹ª0ƒÈéÙJPÕÔÔyHà('‡àšÃ©N\$74~ğW³8ˆ‚nŠ!Ã°ÑIùa	g`ˆõxæ%‡‰˜&xê›ÈÜ;‚\0Î®Ğº¦15Q%ÂS7jÙE¨½+ª©´\\M­C¡´ \0ªhI;–¬çWtx(¹šBÎsŸ°†Q+œß©JŒÏSy>œ£Äù7¾£RO;±lÜŞäª‰I\$I\$/DşxK#6–‰‘š-çÌ7D	¬dÌšRœ?ï|î}`êRè6&ÌÚ„\"RÄZÊ¾5ê­J%9ŞQ’Y¸î,\\dr\$¯@ŠÂ2ÔŠG›³C¨µ³–yc\"!Î0İ;†¬˜í×|·h„´pËwb…à)é:çÜÀ]yPuç\$¥×]‰}vÈ}ğ»ò&ñ]	äÅƒ>º×õ¾:{o@y½WÍ´]FxPÃDÂï	`Ì)p•‰i¾øg\0007køP/\nNÄ	ˆB3Ò9u]ùL#Dr~«,c@Zjİc¶ıC§\\j!Ú \$öÈĞÚ\rB¿0ÜÀ¦6•Ê)+É/ë%\0µ¬¹˜6¥P‘¼Š—–u\n´e‡ÍÔ H4©î)ÃxÑN¢IIvDÂ²ã`CíĞ’DJ‰.GĞy&ÁJñç²ŞJ[B!¤ø4ãæ÷ ³Ë†—˜û>hˆ¸	µ¸Hïh«VæKV\$8İ†¦°AÏ:&(ˆ¢é¬\n€~®k	+†àêË5\"iFh;YSëP4¡aV©ÖrˆPt¦‡Eˆè†ßv37ĞÒSd_úM‚¤ÛÙM˜…rqñ@&ËîQ/íTÄ-£*vaæ©a\nëRÁ­â`w¥/İJƒ|êb5NŠ=­Áº»½§fhJæÇû`ÕšN	\\T¥j£eNu¦„8)6Ô^Ş°x²v¦~¢[>AqÉÇöæËá\$kŸÃË\"à7 Û´ÅÂ—şZ¸ôàüªïp­Å(V¤Xòm-u¹ÎùÎJízuôi¸vè«c¤sŞXÂwdy¶ZƒˆöŞ•åH{u»ÀÙ¹]ò3·Òñâ9[j»ÊÙhìv|Ï°¥õHZvşÁÎûŸeî·÷»õ~óxğ<ôÅ•¨?nŸäÎñVÆ.d »OQvÆ/åö÷5Ü:B¼×ºûFÄŸ+âŒQªØPY©…”Æ,¥uHĞ‘%i\\¯6tÀC‰hn4…hé”ªë\\rÿª(‡ÑBQßZÕ’A=/(¯À?†i¾+wá˜Ì±\0W“ó¯ÛhŸî½ë\rªÌ°VCç}/XÎMeî<‡«vr§ü…òû3È!- \nğşO\0ô. çíÈè'¨EÏâF\$¶Fp}EdòâVÙ©25¶‰şå#&ÚÏÁğ 5\0lüÔª€ò¶p>,0”f[úÉ£x`%\$ü'\\!àÆH‡\\e…n*28ÆXc°\\o‡ğ ‡j3B˜ ÒR‹Nµ.şÿn’“/şïÄI	Ïêå°–ëğ¦å-˜ÛğFÚJ‹^×FåÆëËTAV_Ë\\LğÄèY°˜Dfè®@J5cÖ9\"h¦©s	Ğ(ÿÆ½O½°µMÂÚØ\rpöM/æÛ°ªçğ¾jÑpĞ_…ıQˆCRá¯Aè†Ò\nJéĞ¸ôbmïy\rÍÍUK(,±:ÿ±>i+&±®«!k°ñ;o4°0Mk+\r\"Ê²QX±¥*<©mğãâƒ^·l»îFécà>Q *ÏAí!±mñ¢å-|@J Ğ8Ç˜omå\nCj\n­>»ñÖªhÄ\\‚;Š¢=¦‚íb…C’íÇÔ²ñî¸Äd¬ï‘ìÅ1ó JÓ-<*¤™ 07ñ«.\r+\"Ã©¨ŸÊæğÑğïKÈY’4À«ì¼°8ğìK¢lc´\r€V\rbª#ë\"àŠlâà E\nÔd”9fbâlÀÒÏb[¢ÆáÀ@\n ¨ÀZ\rF¦£Æ9ÀÎ&Ò@HNª(î^©Šï’INvòÒ¤â˜¢j¹R8]v2r·*YI\$\0ê?ãô#Ø\0Ä#£ãæ\$@Ô…\0´(MQ¸<ë6¡\rrÔÈÌ\$îÒR#URºˆ¦¼;KúVìøû4Íïä%³\" \$&(FØŸ#Î”:“…üìê ÀÖÏ\r².02ìB\ræRbbêãQ4¢‰4í” EÇ'Zü`Ï. EO5I\r°›sd’‰-s_8R²’@àJåÑ²½83L8p¬„b±&\\Nch²,M4,î€ÍÎMä\n`Öİğ,#Ä»Æpæ<âÑ=/'I^\nï|¤T\rEœ,#¼„bƒ,)²\"€\$DæHê[9@#Önf6N6njY5s[\"ˆa\"ÁCœ2Î€Ia%•B'ú!0hWä™12,#ğz¨4Åî¸	é£ŠABÂ% "; break;
		case "pt": $compressed = "E9jÌÊg:œãğP”\\33AADæŒŞ aªDyÌæÃVŒ¦Á”Üv4˜NB¼¨âu4âàQPÂm0›slği6ÅÌ’Ó”¾cŒˆ§2ĞƒE˜L„è¬\\Ë?€™f‡c	èÒoÎF“9¤Üa6Dê²ZÁĞÊm&)„ç4‰&JüàU9ÊE€Ìa™JÎ°aÖp 2]­–ãt}je9Ò®àª}¤jÛ\r5™¡PÓÌ™¦k1¦‡‘ÅñgXÁ]L°£˜(ˆa¹ID³‘„C0ê¬à¢›k_Œº QÊoİ,|bfå½&›Î˜]P€…v2ä=9ô§»”PÎWóÑC¶{ç\\o>3Êö# PŠ7;L¦´+‰[ô48ÏxØ2ŒjúÎ•À;¥lÃ´:ˆKŒğ¯`Æ•	BñÓÃ(åCÈ˜Ş©:K,\\°£Ä!0Q\0Ó0A(ÈCÊÜÈR\$ŒÌ?)!	0B0êªæ.Şˆ+á‡*Êì1ÃÏš^´%íØ@6\rñÒ'NSÕc“01¤Ëpî£Lì›'	Ò„ô­ÃÃÆÎKj¨)\r‰\"ä1Aè,F78îÂr×Šbˆ˜(1sÀŠä-E3Ğõ2LHlÊ¿nİT:­î2UŒ5#úõ½u3z(,i@ØŒ¬°’6£ƒ’äùÇ6-üŒ#Kæ'Fu­ºCFÿ×@S1ZS”lí@#c´šãZLb˜¤#0ìrf@iDH‹ŒËÚ:‰R¾©Ú-Ô­Yujº.¬è¾2) ˆ2¤K„5AƒÓx®L‹2É Èô¬Ì&~<‹-ƒ…œäŒ!b6Â°ìJKNH(ëZˆpbER\rÑšf½9C¤Œ4.Iw^2h&®ËrV8.Ã˜î±Hj¾M9p@V£Dä3¡Ğ:ƒ€t…ã¾Ì93ÈÜİ…ËÎ¤Û…“p^.)PÎ2šè¿F'#XDXc„à^0‡ÌĞ@ì§rÇÇŒ75Ú:6”û:¦ˆ¦H44*»)ºô€œ“\ruk2{¦>ÌŠ@¡™YYC2)aJJ€´+àæ\rÉŠFš\n9œ	ƒ<©éBŸ±ï,Gb#¼ÌóŸ=«fy.á•å¬(ÂÇN¯J–š\nx¦*T®Tœnµ0@3¸£sU«:C ê=V¨ºå>§i`êûˆ=.­g7ÂbêÏHct¦°„V„Eß\n!½ÿ¨óáƒyÉ€	²*3=+Ø`¨ìÔšízË˜bÂOƒl9‹]\\½Vˆ(W‹\r†luR!RJ¼[S¶d)9ºTH­áêÙU¤¤•³’¸‘!¢¥=©Üï@‚6—ÌÀs@!Y2DhĞ'(`(+²>É\nX:qÇ\0â®ñRjU«¢uÌ‘Ø»2–Ãxg}Ğ( Æ¨îPéh\r/àù„0Ş¿`y5.eÔŞ\"‚H–@s[ŠÍXøoYÛ*Å´·‚¼wá4f¦ ÌbÄ@ÛYvP)Dœ\$‚xNT(@‚,°–A\"„À‹.‘ºT ‚V%3Œ´&å\n¨aŠ#²B‰©§,	ğœ“¹`*]	!¹8–ôêEÂ\n;\rŸ@¨ÈZ¥\rQ¾¸ƒä3ˆ9å,¢´ ÒÈSÌ,†H@\"_§âf.k4<	ŒÍÜd4lÍxÈI]ê‘\r“1ü‘ZLU\r\0•’\n0\rêl,…¼ß!¢Í>ÑK?E†p¾DT&º±é_!ÊTSŒgoaÉ,RÙî\\iÍ;0s¸œ§TÎYƒZÔù r@dT:ú8^&“¦P&ù½¤‰ <t³>³Í\"TÕ¬\n2«ğ¹Ô‡'ÑºH­äP \rZ×qGIŒ²’•\\Öıg!™¾*`\\k¹õ¯%±×ÖT’k‚àcvŒ‘×:êtÄROÈ‹´Ã‹c+á*&‰&µX£ƒ\$‰!W±¬¢ÍVk\0¬=¤t¶™S^Ñã¬V¹ı¾háKÇ€@£—¨V\\ z¤%ÅEèš££ºze•\"I:ˆâÒ¤7s@ğ©¢W %¬ÕxÌR‰b3—©ûÏzIXw¡ˆÍT«VJÌíÌA ï1fXç2x³È¾9‚ĞZQ­u‡å\0³Xc£]»¥)\0¡“LÊZí2¦íy[ü6XÏœôÅ€Erc›Ù™raÔ8Ü\\CA£o*1‚ u:EÖ³O7343T™`ÆÈ\$ákÎ³Ÿòà32=2mD#Œ@Á°ë'—\\\$¨.ÊÉÄ”Ã¨–‰™\nç­B‚xÏœËXÓÚ#4»Õš™ôÙI™aç\0Ó\"bâhNFö‹QùJPrÁí4³IRQêZe\\‡˜À€?¹ªÁLÁÑ!l=RGƒ<:ÒÕè§&rn²Î›ŠOG.j£´*Ë9|•ê\$+U¦ìîJ+ˆvğ®°’ª×TáFw(ÉÄ…¶u²½Z³#cì\n°v\nØ‡bíU¡ØõşOa%\0,¢º”X’9\"Ï¬²˜aÛr‘Öííy„Ú^ÛÏsk|»¸Œá™˜¥œÔ’ÅHÃqÂ¹Ìùœ¦\"AS1¯7AÌ —¤ÊS7*ç{\$Y\rFYyÚ€{ËEoH{I·îöÚ¶‹µ³vI‹îá'§…¸øVì9yU~ñ~LÎ@U¥sÖ—\"Mæq‚´UÊúªs”O¸4ÎğçÇRåêÂ‰«m[›ıtª»Îõñ4éÎO¢³¾d‰:™`Õ‹Ò®(9¶H\"*‡(”Â/5…Ÿ`ø*ªõÜAVÊZeöú¯Üz†éî±`¾wªÑ÷B¡JIQCuyñU»ìß8õ„3%9Öç_ˆ«vh‘ÅHW3Ò¤[Ùï!R^0ÅTÜ%=2ÿ?èyîË>˜ÚzG¯wNğğÜÓú#ÖÈ7µä&ôÓym/¬ô–ïüÇÀæ	¥ââg#„Ö ¦o”Ùİ8,”ï¼¢=sô©Òfø~ÏìT.iOşí	\n…¿åõ“è}·¤gfô/ÿaõ¿]c>ëÿá„‚ì‰âÁªFn:pª®>d’ò*@»&”ø\näŠê¬#Ç£\0ï 3`†M&­ÌJ<bä-,ÔH\$†OI:Ùk*¶06tm°Ù‹,8ã´\r€VeâL¤J ô”¨´Fb\"ï00«<,€¤Ğ&€Œ„G1g0.Œ4–`¨ÀZ^Bø\rÀÎ´m’Â\"€v­š²\r¬7ˆU\nPJ“B0#CPn¢D\$‚Aîj%ejåƒŒıã:IK„˜\n¦|¡®4^ Ü\roªDn€Ä7kD0b,£–at\\B€,\0˜ƒ0–èğƒB‚f,\\8ÌöØƒ^íPpÌÅD^›‡lÑ„7Ü\"œ31*”ÃŠ.	`Ã6Éä3,H.…ÎFL:cJ‘eú3/è1N.qR8mÉò\rààgÄóæªËQf8N•@„1eB‡Î-¯ˆÍ	„şÔox&íĞ¡ZÏÈÂi„¶\"ãºÄäÁî8KÎ¡£	ñ€cŒ¢ÆU,ìêV \"V‚„\nTCüÓ„,’\"\0òI¯t%\$°ogä8À‚8bÄè  Ï! "; break;
		case "ro": $compressed = "Ed&N†‘Àäe1šNcğP”\\33`¢qÔ@a6ÁN§HØ†®7Øˆ3‘ŒÂ 3`&“)Èêl‚™bRÓ´´\\\n#J“2ÉtÀÚa<c&!¶ ˆ§2|Üƒ“ÊerÑº,e œÎ’9¹œŞlÎF“9¤Üa°0ÑÆáˆÂz“™&FC	ÒeV‰MÇAĞÂb2›³q`(™B·ˆ8#9–q_7œåI¸%êãfNFÙĞŞaƒà„‹±»%¥Íç59è‚äj“Ö!U´Ü¨i8f —,ÌØi¸g¬qC®rH\n\"]dò»ís`d&\r0}tÊLr0˜îĞpVÜám³hE#+!6e0‚ˆæSy´Êt±ã°õ¬qOfeŸ‚ŠsIoÜê·£K~à¬@P Ğ+ïH„·®+šêÇ	+Øä‘°ÃxÎĞ&C‚ZŸÃ*÷\n?l´ôP ‚ì6ˆ“à:»LÓÒ&ã Ò”¤D@ƒ Ã(õ/ÎäaF‰ú¿°)xµ4Ãâê\rÃxë\n£ÂÊ’ì·Â(È\rñèËRäFó\r/Ó„Jñ)œ/CÉ2ˆ#:»‚FÃ\nÆ½.OÒÅ±Ëç%´;°ê0èÃ/K+Ü“®ÃÂ86³„ÜÊ/LpŒ—¦ğÄÑPcÜı\n\"`@8©hòPCĞ4Ï£šĞšË\\1ªÛ@¢ìVòmAÃÒ! õ¬¸‰UÏÄAf§õÜvİÁÕø ±¦¬`Ó2‰#há?Â‚#Š8Hw:Ù3T†À&hê-Ë…{V%zÌñj\r€!ŠbŒ¾ã\\<9ÌˆÒ1@Ap@ò>\nÒ»%~§LV¾h°çt*nı²KÔ™>(ÅJ¦Cœ„”Ã+İ‰°nëœ—¦y.f‚6#Ààé®¡do\"R(6BÖ(ôİ³rnŠ½ÍxÀNê±\"C\n,8Acbú“Ê¶‰¸š0¾ƒ’´cºÅ-«ú2aÁâN4 ã0z\r è8Ax^;ğrˆ£C£\\±á|=ÇRPó\$7ÁxE!Lhé½‹ôıD5„Aõº80Oröã|¥aÜ:\r	×86¾CLİEiê¾ÀÒrIcˆÑìì4¯ğ…™¡6_€Ó%‹Í¾9/ÑHP¥…=ëŒÖ§ê\n2Ş#òL—¦vşg†4J‹\"¾.«0ç‡lãRÄ0ã-MBŒ#Vp(	â˜¨ñ¢9\$äüƒ°à¨XÔQå2Ğ‚”È‡Mrk\$Yí™8hÁï5¡ÊÎ‹“ ei„í’jjx\n)8bØ]!ŸKd†p@Õ)(dàã’pŒ\rÉm„½GnJ‘í&aÈš¸ ‚×Q¼.PH³bĞ¬\näO-åÍj“&´ÅJĞ  'l9³SLjÒA°E_¬„HƒzÒHQJ	.ä(|Ëñ‰,†2´€ä‚± y ú¨	\0KYÑèu€éÖBÒ®ä^'\n\" ”³ÆK1ğ.°´0ÈÉ,Z–ôI|¦v7¦°†‚S#”O!Q\" tNÙ?K@ô…5 ‹4„•á±òöG‰ƒ|dÜ!¬PÒn‘HtAÆ½*K:É0Ğ\r«ƒ®|Y%¦4îD<qNœŠ™Æ}¦V ™ÛYØuäõJ³eÈiB1ÁKÌy™£-‘MhÏói AŸY,!™¦BĞ…%;¦G³Å@êÒáF«\0+§Â^H˜M¢´DäDå„Û1Ç‘£²÷*åjÿ2\n‰\n!ä”–ÕXT—ŸS4Ë“\\¶\rë‘`«”MC¨‚6Y¤àL³ºXÃ<Üu£T‰¹CH=8&.é¡ôÖ”^š‹9,PŞ69ÂcİÒ‹Zét2†Is2mMíd6Ee~I«3¡F:­˜èÜ²š¢jñü\"Ä”10b¨UD5-¾„O*`°³%ÄÊUHr3%)½V„˜l5ŸNº™+’êW\0MUVQÙb•bß³‰Ïgz^eütÍ-\0‹*]Iºa°VJÒ'€è¬R§²!äÌ‹mi`“/!>tuÕÑR'dµ#\\òFIPÁQ'V\"?@e&IkK§Ü'£™òÑÍ~;ˆÏ£`É@›	 &2Íâcâi8»wP˜»ïbaıJ6U—ß¸şJÑbyüÍ3Ì¹*V”¬E¤„ælÎÁÔ}Q†|šÆ‘Ë^+Xf/FøøRk‹8Z4a‹³°Ù|}Ä¶ö“t#€%,*…¡ãxâA¡3'1®´Ïà¯™B¯È…üÁ25gBOYG2²Ì“Ñµebwdıe%Ôs	ùÆk¥\nR2c¥bìgÆ1M å\nsJE&°6ÙÒMoÎì­Íxš¬œñ]×R0'\"o”j ”¢”L¤\rrJ¸õ©LŒ›Bm\r\"£,õdÉ•Î¨4»éu¶}\$X3>»W5y¶7à³Rò_;e;H¥ˆØ)@Ü£@)fÁÑJE¥å¦lÃ¹¾,Å×’¾|nz]}±à–lP˜×g¯=ƒŸ3­¬Îñg@\$%ã´ü¶X«GaM¬=wÆÙ:–0í9yºw&ØÎÛP ¡£¾Â|¸öù!jÉY˜ƒ²ö¢ÃÙ¼é¼Û(	ß;°¾o·«¿cİeÁ¼\nÓØ\nXÈ¾¤ÔÛgTZåÿ1¦IÛ-›–2LNAQyòÛVãÂ.BKyOÏ§£?Ò´:ú[S)ed©Êg#OM26\0eh\\é–4\\²Vjä7ä––aŠ(ÒÌ/TĞ¬_yÆîÚğ-êògnry”¨ó‹^Y”î˜íª~Öª-æÈR’zL 	?åróº£¤yvw^¦Øx¾÷´³öÜÌˆÙwnşw+‚Eï=ó)ó›É¿‘®HóÊñ¾æk“R~0”Dî…óÅ=WA—ĞĞ¥şAğŸ¬òN¿ÊnTXSÃQ&7~ˆByÊ5·	Ö`áYš²;•ğóŸ<YùœHìzBùÇ¦Ôú;ës=©ê™}j2ˆ¿;q\rş‹½~­\$†ş••¿¾oÌàƒ‘É—uÖØ\nB¯L×Ì!„oºú-œÿoúCÏÿ\0/ºİÈ³\0ÂÿÁ7\0ïN:‹/ÀFĞp \$pıÅÕ06p:6íVÎo ÍÈRÛ¤lÑ‚ªIÆÌü°V7<hÃq¤Ê€âÈ›:ÃP6Êœ¿ºû[Ğsæ^íĞWèÿBû	†l[ÅÊõ¤x@ª7Æ¬8Pv/.…0®j¤5°(û,ñêõPLæMÜ&àmŠ„â.\0B€ CfhD\";f–d#Ï‚Rù)6L/àdNãHÃâ‚Qâ(Ê˜†C¥öI(-N;°ì\rÄLåP*FË0±„–0qPÈ&Q:µ.ª˜ƒà\r€Vc~`Ö¾èâŠÍd:„4BB,\$èãBL5Hv\r êŒ#\0 €@\n ¨ÀZF\$)ªÖërK`ä|(ˆ[Äş·ƒâ@àÅG¨Õ'†#4#‚ø¤Ğ..¤3\rL´ÃÈ™ã(L©fb‚BRÔğÈHK”\"6,Fpec<*Í÷P8bn@âÊ,à%â? ˜†BÌä*(‹8:…|=#</í!BêHÎÒ¿\rN&ÿî=#­FÛ|f²H‹ÑcŠvy%.3èÉ%˜P @Ç‚j- Ê`êw!c€¬£l•¢d9ïÊ¬8`†ŸŠ8-Íe),¬z©é%şTB*HÖÕ«l?F¸Ò`@7ã\0äâäà,äÇ+Ë'Äv_iNBB¾Ç*H4\n\$!6B€šJ„l¢âĞE%âhºXğ¥F~_oö?p5ÏªÆNB0ö£š[Æpc¢/`	\0@š	 t\n`¦"; break;
		case "ru": $compressed = "ĞI4QbŠ\r ²h-Z(KA{‚„¢á™˜@s4°˜\$hĞX4móEÑFyAg‚ÊÚ†Š\nQBKW2)RöA@Âapz\0]NKWRi›Ay-]Ê!Ğ&‚æ	­èp¤D6}EÕjòÙe>€œN¤Sñh€Js!QÚ\n*T’]\$´Ègr5„ö9&‚´Q4):\n1… ®KüIšIĞ·hı‚«IJ–6HãB?!¯Àš([ö&	†æäsD5AWÊê‹¬ÅQcCXMe”Å1v¨£6PeÌ×:¾ÏC¯Õ¼Æši7\nìÒµå.,Vû’’Ô»´×ù:„ã,±[•ÓµŒ´7üË‘Üá»>Âæ2S¦jbF_#\$¢@ã/©šTõ:êq¢G£%t†9Òg¨BhCªk\n¬è>PŠ„›ˆÉ&†¹4'\0ÂBù@*,\\CC´ñÂ±Î¢,íäG¥OšD©%¼ıHqi?Â’Jh,äÏ¹KFÌ.Î+\ró\0Ô(ÊPÀH:¸ÎÂÌÚ¬-º°İIò\\+)N\n&˜©i³Ì@ ±òÊ¯@1\$‚­³ÒúZ„?Ê?)ÔiAAƒU\0Óê4»?zT–\$-û\"İ \n¤„‘§Ô}@P!²¤ó\0É´ÌH‰ŒÒtš!-cIVmEk[³kÓŒûÍ”“§Wš\"bŸ)d2›.	uYÀöRi%.Ì‰ ÚLÒ\\E)TTÇ±K>Kj1Iï›ÂÛ¬/Ã²h‘ÈÉ6¦©ô|0Õ¹KìÓkĞÅ„0şĞÑµ#£`ØƒÄ6¨¸Æ0ÀP¦(‰”ÚZÆB‰22’°Ê\\øEÎ\0R˜’­Åßb	’Í“¦õÂ²‚¥R£C´fWRÎ¬'5RÈİÏMgHjŸEÍ„ŸåÍ“ã™C²¹¡9-iôR’0å§)ïš`AC	³`ËP¼\\»%Œüêå>ì	Ó¥´›YKW©”¦–ær¾ƒ5\$ËÕ6ØmØØ:HÊ6ì#ø_o«,«b˜¤#m“›°^…ÉT¼Ãc=¿§7A¥HQh’+²¹ (+›D‚»FjšÕÌôü^ «”^…\$ê´\\f.Å³M¢BÊ‰ª«ÈusZşôÅ“?x¦xD]‰êbñêS>¥0ÁrË¡ö´6xA®\\å“`\\RìZ¥N×q2Ôr%1#¡ªŒÊv¢07)4à”pšC˜t¡ÈÃ¸oJÄ2‡€àCeT@ Èf ˆ4@èĞ/áŞàÂhi\rĞ,A ÎÃ(n‡âàæC|:L 0‡ ÎC¤#ì-ˆ°D‚Hm06ÃèxaÅ¸9‚ª@oV!Ğ7ÅàÂØhi6†Ö!Ÿj#tÇQV(ã.¥ß¡É\$¦˜›÷ÂvIQÈ2¥ÙhèæIÎª„gü•ºùrQÙã;K¹3@@\nx).H=¢ CÏ1†Ê4”·})sh3¤°Ÿ”8äÊlyBÇÑ\0ÊöÒüOHÁ+Da-ë•´6˜ÏÔ\\wSh•ÙfS•‘ôLetäbìmÄSB@'…0¨NI i¢a')›3&JrsL¦Íc‘6&ÔáJ¦Š_@LHAû–³ Î›øKQQ6-\\»òrv‰z{Z%4äô²ğN±\rUrLL Cxu<7\0ëÃ|/x1Î›Á¥†\0ì`ğF\nB‘†åbb”q¨`äÃiaÚ”–€Ú1¹L­ÅN<Å/K’Qeí-ºN3Â•I`uÙ¾’–’Vòn¬Õ±œ†Ê‘Ùkã=G™µÕöaX§\"SÌè¾ö2²¹AX\r<¢´y`e—\rePÄ”G¨«\$Š+ØSE¼EÂ6Â@P§NDGY`v“T\\M”’•Ø…¥--ädO+ŠÔ U9\r’SBº5£HTBAädº™˜¥DY˜•bÔ\$ô\$Îå#‚!®fØ×åR“µÀhqÄÓ7\$`µ¦\nX'ÎµR™×’¼b4P–¬^&s‘k”±²öÍ§”7³;åUâQIpOŞdì¹JÅë¸Ee0Øi’o™2]×V<ÏæM@MÅ´)¢ı{”ÙZ¿Ê¬·³ef©E)ƒÌw”ä_ÛÌtÌ—Qc@K¯œ\$»ßÁx&%>i!ÉÄMˆĞEØ§³ty£¼œi.!ãº,6’ÑÛxzë•ã‰òL+&8P‹ãÕ-íÔò5l†ò Ñh¿J%Y–8\nÛdµ”Ñ1\\´¡´¢2’|áWá'·#A”§ûÆñÎÖ_¢F1›ÓIPåÕ[™şªË:™bOÆMÇ2Òtç=Õš×]åˆ{iŒ‚Ğ,ä	^‹Š©‰J+¡İ×ÉtÕ,-¹1»@FEna—ím64i`*tó,6ï9æ†MHÈ¥d×UÜjµ]ÕIcïÔœ,uø´›/ï5İU†ö2lÏüœ\$Š˜\\MäKÇU\\ZÑsœÌ{ªÂ÷½@®öêMF{/íâ3‡Têæ\$ÌZâè²ºäŞéÌÏM|–ån§.y€€¸áÆ/º„ìG„Ãwíâv³1Êd\r[p*æï·æşİ,g€Üì~Ÿ8(½àì©@K	\rÃvÂ1!¢ææRU3ÚÊÿ µDğ·¤‹(üƒ|mÖaË\n£áD8›â„WZ–üæ›ÿŠ4†÷/ÚŠ€Î¬ßİBIĞ·¿Dj•élô~uÌqæ(=7@ôıÎKIz| Ä³H’ªO7©LG|_¯’ÂLIfÖ\$ä½³î_—ÑAíe‡³Ï,rKÖ¾ôÛİn‚š¦Ô3hZÀ—I¤p¥œœçkÅì¬Pø»yX§~ÇoYŠmû×˜¯¶t>şµ‘I¿s;æòÁátZ—š²†ÒeT8B•„Umh«Ç¨“‰Û¾I>‘#ÅA@xÃÙmè´ùKãq/€J{Å,%ó—xKÕ+jßÖ·´^ŒÁğÃQ\0nŒ¡À9š^Ã\"<]Œ”x8@Ã˜@h\r?©…0É–É5ŸÛ°L–ø³ŒĞğé–‰\$g,œöëàlNÙ¨ÿŠªì¯÷‹ÂğÂ„Ã\$\"M.üX‹jW¬iØ-eôøbBùƒÚm«o‚¨úäfï‹lªRLúb~®ŠÎœOšÙ0fg\$ÀmÁ¢R¡¿\"X¿ibmZmërDP¾ŒÀÉm˜1ğ3–Ñ….¾€³LÙGúóD–Ÿæ¼Db`Í®TÍlÄ~®8–cßŒÔ;	LóL²îÃ”ÚÀP9%ğ• SËê¿‚2ªFäÕ*ÆúP<ªïˆğ\n¢JPüªÅ…ë„~Î•\"A«ènj‘\0úd®›Šš®	{æá\rçeÅĞVF^¬&˜—°*¹Pc×‘Ko<´í62F¦ŒoPUEB,0~÷P÷îŒ*‘‡mr¡A`{®†S¤Ğ«Ğ;|ã¥òâ!#Äèñ’óÎl¯Ñ ê1¤ZÇ³£—ğÌmµ]Q!mÕLŸìáÎD?±@”qØçn‚ºN~QM[F«ñ\"¼uë£µ §• ñíşæ2Ğ€®O Á!2fBå\rä/—\"Ö|\n*^¼«ÉÍ\"êm-mÒSièŞ!d,c°¬œ÷ÔïâÄÂàY;\$ÂF<g&úFÏ%ÌÀ”Íã&m…5%F´\\‰pxRPuCÊïéngäI\"òĞR7\"-\r	òr&#ƒ'ŠØ<í70JË°ÊÏ-Æp\$™òFY,½¬œÊ¯2&@pÈá.°Âå/\rrûL¥\nÒúë,”éSPŒŸ0Èì1Ôén©’¬±Llç2p’õ+\r¥ØD%Î—¥0S@Ø“2rÿn<şñ4Qú»ÑMÆl¶E ê“BKp¬ÉÂg3u5L6#i\\ø„ÅJ\n(A#,V\$#ÆÉíV¨Î§.âéÎ¼d€dcFÿ/fÉ¦©Íuñ&+y\$³ÁÑA²Şë›<ñ™3“Õ1.òl‘4.LïNÊîm|Y\$Å3ó7[1š&{3nR	?±˜Åg7í™´\nìD±7Ä@ã\$)*,PŒA„m,@ES\r¢8F¤Ü¡CÁ<‘4i„Å5CíF(%\$Å\\Î´LêdáEBF‰ÍFÔG+”tmQES[ô\\Ì“ÚğÔhµÓ=Gø?b¥DèùE!wEïtŸ:toD„~It%TÀPÓE’rsa2Âı&97?›?táKQOC¢æÑ\r(!r=4ÒĞâÒmO’ûI1°r•\0)­ï•#æéNS\0ğÍ\$.õíõR£jA§ï5&A7‹jêÙôsJ‘©ò3ÕÒÉST”¦IÒ50c€T‰TÒ=2ªÄ.AK j\"\\æĞ¨Ô%>LU‘†–“ºô³6õŸo§:«ã1ò®Ó¾=ğ`”mñ:Î2/A@Šó-ûYÎíZ\rÜt‡][õ†Ó…1\$2‚²¸TïBîãàÈ÷õ¸ÿUÉÔšğ¦æ±§[	PÑÚ,şbîD/Õe`µ½Ï€äbg\0\r€V …ğBÅJ‘Æ,•¬>g{¦ªWñt5ë`Œò(àŒ¥†\r ê @HÒ£ ª\n€Œ prhÄ†@ÏNF²j’©Wñç-ÊÜUÅI–‚\\oqÒV6vfâ&Sif·^!^ÍÂv™U*ø+î*#Ìö')Ã:á…E(Ñ“\0Ö°UËSJA¦Å@,Îõ#”V:@é^¾Å9ÀÄN*HLH0DÆmm9ÄgK”A\"«{GĞ* P†‰J¾!öæB\0˜¤ ÉgÀsjD\r¨\$a¯Üa&ô=\r\"A²u,ãPÖçŒ­%1Ô¼ë³'Ê´Ê–Õ‘@{1¯×ly×qKpLé®or4uğ‡weÇMUx\0¨ş Ê‹ ĞûæfHr\0Ş\0è§\0ÒH5—syƒãw“3³¼† ZÁt}#xD¬ƒÜD\$ºXA]»Éè´—ñPÔ’\rD¯d^!ĞÔçæ[ÃĞ”W\"ÜÁ Y©Z˜Âeh–àIëJ1“x^¸&z+XOrGsºÍÕ¨Ñì˜ö´ÿL…S˜RnP®Å^¥á‡ñX¯ŒrOdÉßxÔÀ7tKÔ†ÚÃJ´xKtË	ãrënE+†˜0õ8¼„\0àt’˜ªEáB"; break;
		case "sk": $compressed = "N0›ÏFPü%ÌÂ˜(¦Ã]ç(a„@n2œ\ræC	ÈÒl7ÅÌ&ƒ‘…Š¥‰¦Á¤ÚÃP›\rÑhÑØŞl2›¦±•ˆ¾5›ÎrxdB\$r:ˆ\rFQ\0”æB”Ãâ18¹”Ë-9´¹IÀå0=#\0¨™¤ÎiLALUé¤Ãb¦&#¬üÖy”ˆD£	èòk&),œP9P˜jÓlóe9)”»\$ô  ›Œfó±¤Êk¦œê4j¥\\ÓY­™e%V*ûv0ä§ç3[\rR :NS‹9› ¢\$Âµ‹1¦iHË'¾˜Ì ¢¢`r±”óØb9”Şm2#Ü2Ô\nfmŞÏ5±¶œ°æó®·_±Ÿ/Dƒ/Şâ6+šÀá±HĞ6&˜Ò¢n¨96Cn¯@ĞAB9§,óİ8	1J3È7°‹ì˜¥Ä:c¢ ¤BÓÀ7Dá44'ë|cÆ«’è» PœÎ'hÒ@ÖnÌÃÀPª¯,ëŒ\0Ä‚€L©+KÌµ*ÊãPèÎCc„:ÃÃ¨Ü5ŒpĞ‚3C(Î˜M²PóË|š5ŒŒøŞŸ§¬Êñ3Ã\$NJ´8,bb\\4!ˆ]I³\$<Lc° Í‹p4ƒcp¹§`Æ0Èp¢&FÊù[\$K è›#Ì0ë#—Ô<e¨ˆä|°H\"‚AƒĞöÈ,f²Ø¶9R6È\"Œö¢ÕôP¯ÀP¯&²18bHÚ2 PŠ<\\”ˆ2@ğMeV‘¨İ\"U~ H6°ÅC§g¸c´8VÁ¬0ØñHHË„:'Eëp7iÈ@!ŠbŒXß”‚˜3\"v„,ŠW›`”İwl/©ŠğÊ1°:B;FË*Ş5ª‹û\rãuZ2ÆiÓohAH°Ä<¨‰ªnœ¶ÙĞçgØ½Œ.YVÂ°K\$ŠÕ¬Sd¬àÂ”‰ØSc¡k;™±Mªb +‰S˜É\"ƒƒ˜9èœª«Lâ2câ,’£0z\r è8Ax^;òrŞ6­€\\‰ŒázsÍS	Î „Uä3¼<8¾18SXD\\C‚qà^0‡Í@ğƒB7‡öã\"R³ 6Õ	Èè”­‹rà1#ÔRÅÎ1£¦'3ÊR˜2QC­Û\ro”Œl¨ÉrlXmæ ^y[è±a\0P§)H„›çã[åi˜wˆ–¥éˆÜY«øŒÔ›‡Ìª¬`-a†/QK[+ÍxÆ”âRb[E\$ğü›SnxS\nˆ@ÄfŠXô\$EDYª²òB tEE1İ ŞVŒÃ=Å˜:’Wğ‘~3è¸V°#BJBÉô\nŸ=¢@[ÁF,À€)ª°AÕ)\"Á*¢’©.]/†ccPÂrÌ\$9­ÁB·–ª_ka± ~¶ c €•’¾(VûMCh•^Ç%€†ÖZµCì˜ˆ\"	¶	åd¡„ÆÁ3¤Ó!ˆhå¡âä¦‚±E¸Ğƒ§ltŒ¸P	yæ¾§¢õJq‡#Ì©0Ø¢Pe4±	á‰“(u„bVòİUh*2êP\râëÄÁe¤³#	uÍî/é¡^Io|Œ2rRÃ¨d”e05“ò ş\0Sä˜1¾a0\0U\n …@Š¶§€D¡0\"Ïd„XáŠL8*yş¶(v\$®à’€ ¨n”’”(	)?‹æ¦Ãªc\$Í'```zÆ#sŒCUæn@PK;ïëË ÒG\n ÄíUõK#úšˆDwIÆ›:p¥ûØ\r‰HAJ|ÓÂ:˜«İ\$ÉêC\n£‰ô<Åw3Pùhª•X2Ô‚'èí^TtLøcœ!éöÎS\\.U#ÁÒ#yYĞñ¸®uÔÃ¼7Š˜d“t¾®eĞDÔˆVæ 8)öBq¥o:H„]WdœG	Y\r'H…âÒO¡öˆ§áÖ\0Ğ`È³4{È=4·7‚_y(»Û)¸PTÔUåõŸ³t¨™¢ä¶Õ«Ç¦ÀŒßÉMJµ±lp\\mÒ°·¬Åú\\m7JLz\r7œ´Ãn–îd“=>èÛÆ]o®«5¶÷d›Âû‘îS`,œÎ<‚Û6™j®V\0™˜ä˜ôŸ•Õ/ìõTX\$·jËíÏ~qí_÷¹á¹}/\0'³<Lï†µ—Õ!2JôŠ)SF\0’-Ù˜õC™¤˜]ê”¸ÒÚ)MÍ(£T)í;0F(’Ê2ˆR¾80uXÆ“â´qS¶¿¡ŞhĞ|…›\naÀ:Ù¤ŠÙ§EÂÌñ¡³•–”:O\$©I‡dRxJ	óW	%+{R^!-0^ö©\\Úp¥¹Zj¡¥D›çš˜İ)ÙŞÔ«†˜(IHVW\n\$”Ğ”Jbóktœ:@æïÒ¾.! Ó¯bpjôY†\nº…“F!„kb(ŒĞˆ%(V2NÔ‘Dk:eM	‹Geõ&Ô¹›#Ñ§ŠfhrS¯‹³FÍ×r@èŠ1¶N„1Ò'cYå˜‡Ñö¿H!:€3M²]áÑfĞÿ…\"Ÿ`Ò#A’Ò®µCa¼Û”!š½ßPÏÙ¤æò©•xòMîØz½ò\n‡‡\nºÑ bè8Uİ»(’I4>Çe®@ö–Ãû4”„IÆ6?Fo”˜qŞ?²³ÃÚ™ÿG~A²øİÏëÃkÈî\\´WûÄã!’eÈ\r«3Ö¦ÒåJÓŸóPE¹F)G7cdƒ-”\$»HÀ\\\n(n+ôé7&ğ_9)yM“Eı°tÇRL:Ì{ëm£®ÜÙ)„úb²½“ªæâÓÚow2¤0#¶Ş,98'mœÕÀFç{Ïd½›õ¯ÁVó•á»\\ñ~V™ãî7C\"oçUĞŞ’!·\"Í´ŸúA“·Ê²‘âI€LÍ«WÉ‡àÕÉšUô‚ûÚ9OOÃ?¾hµ£«×\nZ9#«E_ZµaÉ\rº!…~©¢‚LVuQ(¬3ÊÖéÎ#kb÷š½{kóÈ±+1­ÿ†Õ…RSZà~*¤#Ÿâ¨¸ÖÅa¹Óøxo4}èæ‰f¯à²æª(Bˆä/òçÌş\n«1>ä/\"ÙĞ\0â‡-–ÿíªÌLj(‰ÃÃ\r\0Dkë20ÌfËãbb\nRg£<ª –\$Á|D!zÖ%„D g§ğ'O* jD6\"î.¢ìnvñ\r«¤îÙĞNCLşªäjÄÔS©\"ıºîDaB‰\nDÖM¥’)ÆÎÃ+*Ûeº\$¥2°Ol=àÖ'£4”ç‰K\rÜN®…ˆÏà¦3ğïa	,èé\$jCÚ'0¼ÚĞĞşH.\nğĞñ-7OıO6ÿcç‚‰\rp´Û\n AâÌ®±!N6óŠå# òæØê÷/3Ğ\0ÆP¬PŠè2G±Z>C|9\rªÌ´#\\´cdÑG‘0XCë0|?1TïOéEb®VòN–ÑäRú#3Ç|@cÁ`@Ep®¸J©,?¬àÊ30rÁñÕ`æÂl+ñÎ'ÎKqÖ“\0ì% –\$LI¤¶:@Ø(#Ü\n±à¥ŒêW#>ÎâB3‡\\%½@Ğ›ãÄ\r€V\rf:\rdhkkúHÃ9B‚jäZ\"g¸XÃ¤kq4û@Œ#â˜hˆf ¨ÀZ¬3B6-\0ÎÀ%DŒKù+â¼+œÂ‘İ(ƒ\"úëËÇ)B@xÇ(¬üïríÀÚÃ_¸#\rÖ#¢>ÂÄÌ`„š{LÆ]çœ¢F®äâÙ‚’2DÄ\$*L†è\0#Q’…/œ·’Ñ¯´\npæMc†#C‚ê&@˜\râß(1D«+rŞZÀ Ë†3\n{+­#tâÂéS4ì†\\§ÀÜ£0ë3MşmÉ,©€À¡RØí ¢p‡0-ª©bpÒí'¤¬*Æ|\ràà…µ§\0Ùê˜€\rLşx0Oà¯/¤.Bxü¢ìN€Ğ¡Ê ”\"íT±(;;–’¢¦ĞrƒúL`\nKh7€‚&mâÏ¤š[s€x†;=‰œ3#Ä½£`0Å·-0C3¢À,I|N3H§*‚\$'*ˆô,Ü¦ât¨W5³ÑSÀ BÅR\nÊU8¹#•€	\0t	 š@¦\n`"; break;
		case "sl": $compressed = "S:D‘–ib#L&ãHü%ÌÂ˜(6›à¦Ñ¸Âl7±WÆ“¡¤@d0\rğY”]0šÆXI¨Â ™›\r&³yÌé'”ÊÌ²Ñª%9¥äJ²nnÌSé‰†_0ÆğThÒg4Ç‘i1ĞÂb2›%â\0Q(Êz‚Š§ÕœÒ\n(§¦“h°@uº®Ğ– g››Ì’|T¦xvR)tÚ&§f›KîwS1Š¡5ÙM'»A;M†U0èuXD“Tœi¸ˆV	Ê\n&Ád[ò9”Şm2PùNß6İÊf™ñ”Ú\n€p—ĞÃ]ËgÏh\râá”Å9È7UeäÓ6ÔÅ<ÅLª=9{Ì'ma\$ô´?(:%«ÀŞ5Œ)L=ìÈ1+‚šë0É2è3ƒ(ÈìBnB,ËCÔ'\rì„&29 ÿ&c\"î* ±rÅŒIˆè„±¤l0ÇĞÔ’Ç¡kÄ±[ş2¿ PŒ:ÃXÆ÷¼ÂĞÈ9°SQ³èJî5¨Ã’x;ÒJúC€Â”\rCzó	‹âHÖƒxÙ>éb¨ÖŒ©°Ü£IC¨Ø6D<2ŠhZåA\0¦(‰ŠèÈƒC˜ĞÁ9°ì+!+0-ÒN²¸*§ÏäN£.ÀĞë&ñ¨ôó//ØÒ1¼Â¨ì7·1eh»‰ã#à“uBŞ¤Êİg@ÄJåTÖTcq\0.ãc”‹©ËàÃD=¨!ŠbŒ‚BPƒRHÈĞÛ?7¡>0Ã[:%ïsà›£˜à2³èõâÅ;á\0ô›×ª0@Œ°RH“8ãxÏ5¬2¬ìO)¾º%]¸¼¯hÊüºXJÛäü?MJ—¢ö“ö¨?u`—‰­ª9 m¨æ;£LXÊ<4‘¸&ô˜Ê3¡Ğ:ƒ€t…ã¾”LîŠ 9ÈĞÎ°Ú ğ€Ã˜Ò7ÁxE@C;“ ‹ãW&„Ağ’6Ì<:xÂ2#äU«Œ*\"HÉjÃ^\rÒDŒ‹*V¦ôºQã’J41‰D	ßÉ¸ \$\n\0P¤(í‚›Öwß’&)šj3íCTññ=*Œ†r‹¥Âbh-z‘0İ=º½kXÔÕ!Qú9Ş(*r¼|ƒÌ_öè)Š–àµÁOlümÖ=rArÌx@ÂÑ*iâ°ˆò©‘Z<Îê—‹#xêP£rÿ¶ó?ÇƒôU1ª F¤›„`¨çHY‹/†Ÿ·ğÌ^ˆâ½DÍ¨-LºÇ%á¬ æx×øvNğ¨óü³ÀzSêı\0¬#Æª‰Ï\$p‚õaÃ²#fp†ìHOY\$lİAÓu?\rØ8¢nô\\Û)àüŸnı‰àt‰1L'‡2f‚€PZA¥J'À¨YËJQ?aÈÜ…5Nà ±i>İd²BM‰ò¯%áP:® @×uK@(ÿÆH„yˆ:ƒä¡³' ÔS*Gä9Ä) Úàñ*\rÁB¢³ÌL)0@(*3Zœ“¡¬	¤„í“ÒJv!™ŠO,xº<E£!â¤>Uf!¢·@PK8îŞÊtĞGMª‰ì2˜ˆ¨ªZaaÊg¸)¢IœIcW\$ùJu¼†ÑwŒèˆÖä½Ã+\rÁ¡µ¨t…ùa­^¤eg5ª\rS½tã1Íxjò„Ã©Xjäş1´	{¤áxp.7òt“g²·HÍäÅ¸tüY‹2J\\Ä¥àŞ\r§aa’”­çÂ‹áa&0pîÀœS2'Ü\"ØÆŒÉÀr* Ç‚J“ê-B¨á–¤Ô4\rOPÒ5cì	z¯uòxê€d5eú†ÏfÄŠ9‹¨Ê¼«\0•½Vj’½(¤\nª¯BÇªÍ[\"ŠmÙ«ÂÌdkJUá¤V`ßZ¸­‹Ú·W\0ô‹k•]CÎÎ4sPj.¯Ö©Ø:­[êÅ‡CV&º!W(À¬}cqØ¿¨‡ MëC§.V«ÙXş×\r¡«¯òÍ úÊ¨,»*Œ|ëbI¬yt­ğÛ‹\nxàı¼¶)AÜÿmKE}¸Ö¶µ0+{llq‹¸WAÔP	Q,+”ÜÕ˜‰™x\nk­`®)æšÊÙš}l 1LŠs7:	\$dRXßfúy”LÜ_l§)N££m9%Bœ¬wœSWéK¹kÒWÕ+D¦ñ%©€Qq?#åŒ¼¡¤SzÖ\\”!o'›Ö]\$YRŠø±’‘zÃ³ëÆ`(+_0ü_˜h?d\nZ“R†[v%OİË è¢ÄC\$¾7MÕM7O#ö#Ä¢@Ğ%H,:Ù\\…’ceK1ñNÈªŸ“?8£E²`P†‹æó`®pîf/©IoZõŠŠ¯ß-°!i+’cD¡”ÊÂšâ0Aêv¤¤ŠÎ•\$„ÎO#¿¥N›<ÁYËù^g\\íW—\"ÎÈöhòÌó’§bMN‡=6eH)&ÂÁÇ£œã\\\$aúû=!3Ê°ˆ^Ã=šhS×¯àö­aêƒCÉ%2©•EëÎ›*Füõ ´&wÛ\nõØ£\r³–ô€!4»„²tıo\\cPÀ•/p×W6•ë´5éB×İİY³ŞR+z”=ñŸ+©®ûî¡ÜMÿ¼8ªà”Ÿƒgº¼a¬m³´VK‡½ãÄ·§ŞüZÅÙíõ^j{´Gµ°s°nåT\n@rÑ¹uo3å’›ÕMša¡5‡#SÅû\$õÂ§5¨elºDS™£Ëàyğ`Ñ¸Ì¹U\$½1‚Ï)Û2¤úvœ*s¤÷(lŠ‘T&İm‚ÆAC2H0Ç1òÒşuÍyà\nŸ=›¢Ó9Tİ\n˜ôšMô¤\r8[ÜÙõ}ø_¡'™[3j»=¨Ÿ/ˆ¥RÊõl!ÌJ^|ã„t7èù÷•ôÈK>MDPí^ÕõÔ¯Øa4ÖK&\rí8æÿ g3ŞHk~a½IæZKÁ|éÛ~ƒãò/IÅù—ÍŞŞSpıY<	0fI‰8÷©¯[Ä÷·±óí¤ôÓø´G!ü:0Û>ICƒ\rdÌ7(_wÎşfX}CzÙÏôşúñM¤Ê„:S‚‡\0HVöCäÿoê+‰Jîò)HÖRú°ûïàıoX ê 'kÖ1I¸ï¬†ª;ä°N¡ÂG/’/î¯°Ïp@¢-¨üjââ6¯Nö60C;Fƒ•Ã4;ğ‹/òÃ¼¦Œ°oTú,&'„\\R‚¸[ÊLü\$ât¥p€ìUc¢÷+|!N¬#ğ†ÀÊy\0˜PÎÙ.&ë‚/Hn¬°à6…8»0Ö†î¹lÊ³ğÔ†¨nD¢^İÆ¸Éö\no„LÊG0Ì6‘Õ®N‰lj^\0úğX`»DbE*ËMÎRë“¬Z\$ªûLú\r1¶dNE1ïC”\r€VİKÔ>éz™i\\}ÌÀb)˜%àŒ€FĞD„ Cd\n ¨ÀZä\\\rÀÎ3EfØQ*´Konb®Ğèå\n¸…d•0\"øãk¥L´¸E ëƒ¬<ƒş]âÊÎ#Í¤d\nNşüÀæ¥0†0jØÌ)xbŞÈgÜ±BÂÌD@€mJ•ÊøÖ…(Œ\$ÎOcX	‡óàÎR\$F G,5…`P\r&£êHœhÓB(]Âb{HJÏäDã\$:o¬ú%ÒU\$k’'†rplñ%rHùn1&ä2nÌ„&qŠqÀà\$£¢U`É&òF6D.™Bî	\$²a®¤@<<nü5`Ğğí\"ˆ‚t'‚}*'+G™+®¼ƒÚqG0†ªL-H©À‚,Cq@	ò†MÂàLŒJ‚‹ğ+R;L\rG´ŸlJšÄ>2¦¦…0¶#r\\İªO.ÿ…b7Âã0‡#ƒhi Ò‚b"; break;
		case "sr": $compressed = "ĞJ4‚í ¸4P-Ak	@ÁÚ6Š\r¢€h/`ãğP”\\33`¦‚†h¦¡ĞE¤¢¾†Cš©\\fÑLJâ°¦‚şe_¤‰ÙDåeh¦àRÆ‚ù ·hQæ	™”jQŸÍĞñ*µ1a1˜CV³9Ôæ%9¨P	u6ccšUãPùíº/œAíkø¼\nŸ6_I&…ÄN¹~]É3%¼&°h,k+\n²HˆÆD—RIVowƒÉ”Ù>yšg—©®Å	³4%¹ìœ´‚Uµ˜úÆBâ ´Zà5ûÅŠÉW£­i0IôÃA0œ®-yÛî®#ÕÖæmÖG\\b¯½	'hiàğE•öÆ¼‡IS%Öï‡¯Æ#X‚sÜhÈHI¦JsàåNªòX\$ŠS¬·¤‰4ãŠŒ9(»8·0‰ã°h»JjÓ>&‚”§**4¸¾ì‚ «¹­’Úß@F?',‚ú¯§*ê{/ÑÚHœÅìŒ.õ»Ñ“ˆ²©\$nÂ8ğÖİ¢ïCë¢Ä*’oúZ„I¥šN±–“Å+·Œ’Æ]Ëæ‚ˆï©mÜŠãÈëûÛ/3	¡\$=*«BŒˆ#% !€M	C(©‰aEP²U—·³Ì“7:©!HôEf‰›¬Ğ³|ô/Š¢¾•J1³Üó£„Í2L*€‚LÉmROÃŠA\$¢°K« Ù§	Ú•T’qúlÕÓñá(ô@1Têã>­xH&tõA¤Ïª0±ÃõjRšµ4\n|ƒA	²GIS{â)Š\"cPÒ>\r¤œÁ&*•2+ä;Ñ§U·L”:Š¹%€ŞE†„ÃÌhK0÷Î%%rø5vñ1‡&EäâTc*]\$¿®‘¿a(P¬)×\$Á”)ò<í:?)!<ÙAtªlÈ/•j±2?j	tMÈ,ãEø+oÏ@ÇŒ-/%¼#`è9(i”w+9Pp@!Šbw¶ár	)®Ó>\0·èÌP„˜š*µÌ(Š|å3ošÇk[FÏIë¤Ò\"ˆ´Öí%¤²Ì>¤	¢§R\"Õ¬Ë]v¯³rªÍÎË‚NXd‰&í´çª’Ö¢,z¼¬¦©nN©Lêš0c Ê9‡p9ãxåBŒ£Àà4C(É±ƒ@4y#0z\r è8Ax^;ûpÂ2\r£Hİİ…ŞÎŒ£wĞ<wCpæ4ÿPDƒä3Œ£§¦/ŒC`ÂƒX\"Á\$6‡\0ØCké€ğ†|p˜ !Ğ4õ\n|!¬2‚\0Òë»\r¯ş³XÌj2hé=#ÂˆæSA~6¬Â—Ô¼X…@\$™\n×A¿Xåäº;\$° Õñ-m÷’†–mb!^+UÇ´ÂNv1ã'ı=â¨·	¼:;ÃES6#úi1¦!1!”¥&JÎ\nR?ç\$Ò–BxS\n¤¨ÌŞÑûhIÄA¦-ó\\MY}Df•´ÆÕkÙó0í°‘¢ÛL+*|Â”âæS©ô;§& ²Ã¨ oüXŞø yÁˆ4†p@»pf\r0`Òó‚0T‡ÏıB†˜\nğ¡˜9ğÚHØv|T±d†ÎŠ:BhŒzDÂÃ	‹ğ·%1òoóXâˆ‘P((ˆ¯!jZÔSvH4DâQÂÆ<äÒÙÑ=§Dİˆ+`ºÍc|èˆÁ0Sî9¶Fş·#!9(EGr, Hì+(Œ\"” ƒi>ÀM°Hy¡RN&3™Í–ˆä‡QË;…Ğ¸”ÚAK†€'‘ÑfÑI±!êßU'Îy•R 'ZO¤‘DÔySZdü†q¹O¦o8!A	’LÀµŠY’aõ\$ì­ºÓBIgÕ@_Š ğœ¨P*P@\n&¹%‘jvL¡½A%BÀÖÚŞ(LµÖ»×•df—„YC³µoØFª‹¨”•(šË—ó\n,˜)ù/È¯£ÃæaEùåY‡á™\$99	 'd¼Øé\"(¨˜JLcN(Íêæ=‰¬ı§dügT\r1èh¶D.O\"2v	ù\\Pó«?\nºf3Êİx5±S\n,–lì[²œ™®ŠiG¥ù dyr/\"5H7J*VvL˜i‡V×Ö£ÅÓI17+úüVvMJ®ywXÑajÖ2,!íiÛ¥Em?`u€ÅÍ&XAÈærÊ<PĞ[²æägÔÓ%ÄP[3ªp:¯.L¼İFK–²~ŸåÒ&CS;:xm´£ã]¢ÄuB¦%!V°*Qi­˜2²|k:¢åÕº	TŞF[‡)°Ì²È\\nWkp\0›Å•Èfgdñ¹äc÷—äb#9“&É',Bèi&®«æáG’„r'xŸ.çyÓb~|ÊÅ˜g\$Ëš”A>õf¾Eb5~Z.Ì.VÁâ…”âFpÑ1GEåÌìˆµ‡*¹·Th„ë 3ŒÕâû<j5e2z¤t®k-gBİuƒNÒf®¹ú„W‹oÈLÌ¹¨Î°´ÎŠ\"7»gÒ£Š}kä¢‹®‰÷c£ªá=DS\"¸„JÙ-5·Ñm|mehª÷r©\$Ùı%¡•ZyKiaÜ´HL@XÅ3/»ú†á“ÿƒ.	ÄL2÷FC’ 3æµK\\•!(h7…–]•RLı`2”S‘äx££í\"¨ªü±;—Ëİ–ŞÜ,®ÒÛË)åHh3Hè2i—ĞüA1+C€d.éú€ÓÓƒı»5|¯µxIIBú…İ„ísEÍu	Q\"¼;)èç¼~è`WagR\n©w®¢®§,æô( ÜÏ¾.—?¥¶W1×å®¢xkİ¥–Ñ2”+Ë•§\"üÎS¹ÜM¤ş{Î2Ğ*1\$´‚°l£ …Q¶7]IæŞkéxIÊ‹©T‰+ˆ]¸â&×íh¥}qÌ\nG2;0‰ù§åíCl¤ÒÚğá¢BÍföİ tZ_Ñ†7œ»ºr|å'˜û1„}Êä¸ó©å_‡ìNJß×ÿò~Åş/İù‡İ/ş*0yV\$3Æ(ÃÅEÆI¦F…ª˜c¯òÏŞ¢¬-j ^/ şLça¡/Ìø”øP,º¢şNŒlvnTÑD¼\"ÂYÇ@8ú¿\r,F+´ÆmfÍĞ<ÌFÕJ;¢¬ÒDÖÏğÍ0ÿ¬Úõ0DòHÅĞQJ¶7°ZĞP`Œ\r4äP*ÇÈÈ¬/ğ¨”å¢5¦Áğª*ù0 gL¬P¨åï\"š¬ü/©>Jë^*Ş\\+â.ŠFÃĞ\nV'ãe(cø¢t,r¢\$…šcĞîU¥äÈYÏxs**ñ\r£ôYëØ2h¤W-øWèl-¯XûJVäÂ!0â\\Êº´®>ÁªÈÀfğşï§>ã«€¼«šÁ4ù¤ãËÑ^ñ/‚Öo]dÑã\"ûğÅFÌ7ÑÈuo.ªÑ>¼ñ’à¤+ìh¹ï\0ûË&†C„Í1¬ì‘zÿq~Í‘¨0Ñ¾î–_ïæ¦àMdÈç,eë:óĞ¥1âëëªãEÊ7Ã8ÃÄ,jã¶\$Ç‚0Y¦ŒqdŠÖEÊq,YÑ].óoÁ!°L?‰0\"q0Ò&ğÉËî†#¸…8Z«^â¡À’Düê¿w¬S\0=H‰;\$æ\"ÅO&‹jó%¤Ñ%ñrŸ©çÄØø¦ªiÑ‰\nñ¹(ñFÕ†Û&Q×Ò‘\"’¨PÅ\$&\0ªFZòÉò›˜;¶´â{)1€;¯/%\rrU+2Ğà”“†O°şµ\"\"L7,’%FfÃNÃ\"ñÇ/ˆìÂp'RØaQÜ6ÓÃrb/°bÓ/Åò\$l_ï­±îH–ÈÀRôå#h:eršÓ;07\nù3ƒ50²×¢H­&eä?Œ[\"°Q°hù„üfdb*@É’XZÇÑH‘CcŒŸ'³„_ góŠZğ9/1'Ó˜Õ“†\08M„1üKM„Îåes8Î+JÍ¤ĞoØ%¥<Ât÷ğ}=HÀóØÜÈí	sÓ	³²@†j`ØkÇ5q\\’,\n¸¢ï!%J b„Évƒ Ú§r\0Äƒ§Ä®\0¨ÀZ\0@} Æ‚ÇÄíOq‡:Ê6k”Ø,ı9§ëÂÆuí\nÌ¬\nÒ´L§˜š‘2ÚéĞ6lğï£ş4ï@MäãÈÁ7de@ÊÎ:‹'hè·ÔÏg\0¤è.„÷@¯qñNA2>Gƒšî²~°dÔÂ“ìôôÂØgHôì²&şæH@S„DCş·Æ„¹a>Q.ö”XªŒx@¬.o‰ÉO*ò‰¦è)%ôíPß9Åg´aOÕñÕµ4MR+ÛRs/NP-”f.ğµ2û¦ÓF\0¥â‘KBı Ğ-¢h\\ôZónüiƒD)H‡°=+Tú2-U¯¶YKW¾zG‚L³c\$hí OğÅ”ffÅ¨*Èê£Æ,µµ8\"F(`b,·ET¡*6S0…OcÀÄÔö*h‰’ª4¹Gd²‰\0uµM[¦:qÏrĞãáQÊÎ…ğ>guœ+ìN»cdLçMy@•\$‚æ"; break;
		case "ta": $compressed = "àW* øiÀ¯FÁ\\Hd_†«•Ğô+ÁBQpÌÌ 9‚¢Ğt\\U„«¤êô@‚W¡à(<É\\±”@1	| @(:œ\r†ó	S.WA•èhtå]†R&Êùœñ\\µÌéÓI`ºD®JÉ\$Ôé:º®TÏ X’³`«*ªÉúrj1k€,êÕ…z@%9«Ò5|–Udƒß jä¦¸ˆÁÕàôÉ¾&{,Ÿ™M§¡äS_¶RjØİéÓ^êÊ8<·ZÔ+±õáe~`Š€- uôLš­TÂÈìÕõ&ş÷‰¤R²œ	MºûHI@ˆbÍÒ·õ¬öœÆ2x:MÇ3I¼İG€oe[û‚ßaØÅá\\´JQ‘øa¥r™^)\\õjrôù•ÎqÈ®P\" ˆ­%r*W@h‹¦„)ª¬ø²­\0¡\nù€5Œ6”8‰ªÚ©r¬œ61aË‘ªB˜ºJ²`F«ë´XFÉğP)ƒÒ7ìúÆ– J¬é¸hfÊ4éJøÜĞšRøGªæì¸îºÑÇÂ8Ê7£,‚Ï+ğJ#(´Ë|ØK*JŞ\\)Äü{\nGãÈæğ²2®«Š±2§,+2~)Œ£íDÏÓR«A°|\"ìO¨çF+ï”Öã¯¨*êƒÊ\"ÛµP#QÀ”›íÉÏ«t–+è½@‘››%Ç°t4¨Õ´é]WÃ2ü¾Eõ\\ââÀ”ÔµS5ªCœ›JÏ£ŸO)jmX¸@“a];@‰…‚ıÈísİ]Ñø÷Ğ”å‹Ä®+ªÎs›f§·\$X”ÅÍ-·:Ô¨ŒC`¸'{)×Ìb­Òô¤=P‹p=vËwj9scG_uõå¯·l¨ø(ØÈ¤%v¢„¹Ã6¶-=‹eB&9h)Ö#’ÉÚÑÀŒ:Ãèò¼q-g¶9°P Œã8ä2Œã~óOÖ~Y ù]A¾(¢›/;—^e×êÔÃÖx™\\›'p&±+¾©†_\\ÁòR¯ÂÑÜïsã¯M)qFdó»Ç9Å„ˆ´™ØØ6 Â1\rƒ*@1Œ#p)Š\"b‘˜[Vâ#Ï´‘œhûI»“~ÎG7x©Îv­]÷Ã}[Ò>ñ¯WÑfzt}îvkÅWo±öİàI\ny†¾®´,0š§Lˆæ¯	ÖÃk¹\\Ğö¬>.êUv/u]ózüuë×ĞÇÈ¼§Á~o/t¶ìKŞîaN;D/Bm½e\nI›\ráÈ:ğˆLÛtpH…\"eŞôê'aOhĞ¹—P¹MjÖ\\O1_<ãÛËÓ}iıfêÛ×{eï;s.øjífğ¦rƒbAA)… ŒR\r9†za68llŠÛ°@À¹’%´¼õ˜âó3]¿A†ZÛ[¡k¯Éˆ‘ˆŒ‰|2üÊ¥æ`­‹Aç1\nÀ´İ‰Ä\r\\…Qø0Sdb8·R\rŒÊBtj°ßSh‰10æ£k£\\ÍN0:#)!ÜF'	“EÉ,o\\Š_ÆÔ½\$KE\$*È¶2î\$™UĞ±7™'Œ}ÑÊK“MÅí£|İ›RéU-ŒÆD’º‚haOj\$	„Ã¼da”<\0ÒÒÃ\$L„†–è\"\rĞ:\0tÁxwœ@¸¢†Ô†¢Atà¼ñNÃÀx!æà‰Ä†äÓ4Ùî1È†°D 	B3Gˆ:À^Añ`2‡@ĞÙt\rô00†·C¤ÅQ!µÈĞHÂ[ÒaghÓ0ğ3^+‰h%¡³º˜f\0PP	@¤GÖÃŸ¶J§dú¿t|`)d½6&Í}E²\$ÿ‹<Cf-²Ø)ªIq©¤¥ó¹sÛ!©ê#k«JcYŸäSUqUøÂÙnš×ä¡ë8ãH¦œ–«Ê„Ç ïôW¥z®µÉqTQÚè”â¼ˆÓ\"Àì\0Œ)ø÷·’F€O\naR¶:u†Å¬5•z\\ÇÕgs*RêF.—'XsëÜ˜.‘=;¼G¾f@c<Á˜4†pêšs@’g†V|T],O!|Z%ŒW‚Èo Èà@PJEP1[P@åµ´q €;™¨‚¥4r,Œ4À((À ÁÉ2¢Ã‘‘Ñe¾…nª[¹É–QÉ¸Á%Nlˆ…òT–^Ê›æª›\\#ÊRAøGS”W-â`8½fS­UÎ±5*w\r+|G9‰¤ú×õ¯!ô„—Û¡O Ú”X°x÷5˜B_*Á§Õm\nVvXJmX¿6ÎÂ8–y-b_bx\nÓÚï8ÀÊÓò²É\nü§e#`KQûŠ×(º¤Ê^«ôP§5®Pg\r\0‚™SJI<-Ñ€M5¶\"®H•³.r~re_U‡şƒ-ëÉá¡?CŸ:IkğV´át¿Õ\rÆ°éB·“˜İÄ0V	îéˆ^ò‰§wòÇÊ1€\nŒ\0\rÁØ0†ÀÒÈÂ˜c\rh0‚˜Ã~Ë9J\\UÇÚ>èã\".“ÚæĞ4Dã¡6ÔRHğœ¨P*]›³Â E	jéâË¯«ôØ&:¶ÆJØ­…XhˆÁ>_@PÁ††¨ÆHà¥jVn’\rÎ«Ø«bÒ&Ò› â}Dv\nÍ+â=ä5åÈÜ£K_@\nSÚÃ*	øDĞ!„:Ã›…R\"æî§ÈQLŸ\\‹È^Û‘™òû‘\\ÍİÑÒp/¬l†èÊà‡FXYJE(¤ô„UUüéVâ®dÆóãÒo¸;½#œa¸O6xRƒƒ¢b¯RƒÍ×S~ò¬U&)\\ÁHø\$†àÉ3\n:úz½n¸;»aÙ{8x¸Y¼=\"` Š¬)=åêq|†Áo)Ç†ì>¹Ì!œ J÷€çÎñ²%ÔücÁ)Éo×PkÄsİ\"ÙeUsJ¥K«iwŠô¸c±áµÚµ:XÄû h¯Š¬¸¯ˆ2Æ¹9’*Â(ÄhG )_BiQÌé)\$<şSUõQOÆm…l·U¥éÅŒJÕ#»ÛÆGÒM÷ï¸vìáo1¶kpÀü’JURdHW¶k¦PÊ±^âìX©ü@¦¹øqípİ8².ò¾¾l ­\nœÃa‚şşÀóGx¸oT&ââ,Š¦50ÀûíJúOÆb¥ÉÄ§°° ÷p\$åÃ\0ÆRı‹KÏ6ş†Ç£\0,p.\rğ³šÂ&ëj¥zå§/%¶hŒth0¤ëş¨OÌ&À‹ìæ÷Š›(Mæ/4c„ıï\r	p0—GÊÿ,DÔğ:cPtä0¬R(0ƒôx§^çàî¢~ºˆ(Ï‘\rNP}-Œ”pÜØìXĞâ(Pæ-?%“ĞÍINüï±„-å€)RŒ:Ç‰RÊĞSLHKÅ€ìjÄ÷Pò+\nªÅÈ”ÂÊ©1•ÉP‘Îzü®ÂúoHİğ{®#ö¿MÔJIdÿ#óâüÏLk\rg¾Çwnfëè°ZîÀL\0éÃê4ì°gÄü‹HXÿéYìT¢7¶¬ÆÈÈ,öN˜©pCğdé#\"ƒ†¤ÚPÌö@ÎP¬ñÍH/±Ó°`_gş	\$ø¥‚”ñ1Ç\nƒùğ&Ä‡ÓÌ8d+’¹`Ğ%\0Ü¢`àHKºq©ğ¡j\$¹àà†œqÊ\r24qg‡F±D&ËŠ'TŞçàcü9Æ>>±öåæ8øŠnZQRZ’T-ïÿ ’\\ÜÏòÑÉ\nl6\\NE!N~ÛÈª©NS(Œ€‚åÿ2›ñöê°22¡ã­*eêwÆ ŒÁ+Ğ_RÈ“¼?ñºÆ‹C«¯,®¦Ñ¯Ê_ï8oQ`2OºÆÍ+1í.¨Y¤	ì>N&¬Ï›(O¨â¤½'ğ	\"Ï®jò“ şRõ1Mî®-òkñ<ªy„â4.×-ÇivOà™Œîo\0¸²Ü\\æ3*2xSFBP¬I0C5 ğ\0¨ à¬¢pMÀş-G4¢~ßÑFå±nú7	Š\\Àëó9Q‹’ß²â‰s æO:õ33JÉG5¢u,Oû61Ï;Œ[6³¦{3Ã/û‡Ÿ*ÑÙ=Rÿ.LS=Ï¦Å¥TFóË,á5òÇ.“ô¾sø¿óÁì`ûRó-¼ëÍ:ôñwR© t	=2É=”%04(|-AAÓç/Sëq½seäv”<µí3D2¾ğC4Q=hî_E€øQµ?NŠ©%4HÊ‡“-­Ú1x>§ñn!Ğı°î”â2†e…‚VÌZ‰p*ÃïˆN¯ìxQ7:óÑF±f#bUT—\0ğQ6ĞTØ³N•0]´.g“JÎ“L\\’0Ò•ÆÑ”×T/LTi ÔT×ôúğ*Ş§UF0¬²¯@Ô8ğuó4Ú¬QÕ>”1H³³/Ó·FğŒm).²ƒ´œÜÄ‹3½4ÕNâãäá1Bz'OPrà{TK¯Æ\r\0Å<@Æ¦FÚ`¨*Xf0ÌTŒyç´†p¤å¤à‘.K‹\n‰ƒ.ñëLÅåpR¦®õªZ‰®|·Lµ»4¦·3Úÿ	RµD¹< QX€ƒ7À²\n\0Š¥ŠSGèËYŒQYÕ3ZOK	QPÔdØTşêî½,ãVwƒT·Q•`éSˆ§5JíÍBÎeH’tFÚêå´ vTOP’³cö:¯C*´MQğP¶QQ¶URôIS1éS‹OEf9då†8Æ4vœ„1,f–Z˜àŠQ`Ü€µc–KVóf•Oœ@–®’“ Qij	5”d–]E6Nè¯”Sãb Ö•i–>G›hP½LvM?VŠPÍk/9kvÕkÖå6çjÖêSÏbË¹iªYf”!/†=ìé®nX±ÀtOÊR/„¥Gfq±Ú,ôì¾lL¥Oó­sè”âÒ÷V«	'tµS”ºÿ.—PU5 ¶¥f)Kh¯W=NG<õm;VÇu4vÏmˆ;mÖ[>ô7Fævg¦¹Ö\$î±Tpj\\xåßcof;y+~<ÔEm·Kb/ôg4+õ--wˆÒ‡=¤n`ôÖ0»]/çzT-:Ö¡l4m\r÷UNÛ|7Çh7ºÅWé?5#b÷ôuóÍFw_@¶_w·İ4Azrîw·¬zXwá|VDw|ÏË7@P3³‚¥—[~wR=8Ø9ƒÓ…{w‡³±vµg-oµMB…õRlnß˜p×Ë{Ãœòõ¨?Õw˜C>Õ7G˜`]¸v¸…6ø	k÷u€ô5„—ìc˜—`·QrÕ”KtÖo‰§‡öjx³‚×«‡˜ø¯Œ–T×÷ƒ{q…zZlˆGjâ•k,æAWBöt¸ÎÑs­%„Xø¯p–Àƒ¹Ì\$RYŒğ_„yç¤Î˜ûuYøTÆxã…¸lRÊ		„Ö`ÉGA_v‘AGÍt%Öä f'KŒ6çö‘JäG“OŒ¯}j_“„½6¨sò”Å´ÉS±ñNÊô€ü¢¹—ÌŒlq,EÒXÅ9‹\r2!Pç•ÉkQ <Ó„æä©Ğı÷î}Z8ìüÖ|é/×xQ×¤Qy´¢õJ§[+9‘‹tGQö«÷q€ªË3¦3ÒŒAŒ(d‚\r€Vm\\`Ö´šX\r€ë\$\n&\rª \r Ì+Ğ‚¼ÀÒ»`ÚËŠ2J.¹Àª\n€Œ p£\$ˆ+Ùs‚vŠ1Æ¯[kJ€v×{ùo—ÿ˜Ğ³¦xòXdÒ™èªv¼ÚzÄBœ•ºƒrÍ@ÒÑŒÆgqQ	×ÀppõqÄÜK¹¨v&W¼=JË2póW€Ê\r‹r<Ìº¤÷6{Zs¬ı(XŸe\"\0ÒoVTN/JµÓa¯ú£Ú“–m	Ì ñ§0…–ĞÈ@™d†à²k¥£–·fœ71HGpwn®‘š§ˆC+sóªêÄd\rA±:ƒg8jFxrÂ(Òµg¤ŠÆù›N¶£…ö§µW+«@üì\\b¹Tf^ˆ[%Ù\rC›…*X‰x…Ûqf\0©\$Œš² qÚL<Z 3‹Ê\r õX[oŒ¥.Ú\\BÊAîd/“M÷QW;r³´é”U´ZÇ'FöxÓlâŞøö¶H‰Îj9´“u³şD“yP<C ‰³ @Æ–¹Ë2ĞW2…zX¤C¹qÜÃ(IˆÖñ\$Áõ—¦ã\0Ÿ¼IÍ¼¥T£¯øö\"%_\nCı½¯=¯Ô,\0©¶F{#äı MƒWÈ\$ı9î¬mT\$·™ï!ecÊ9)nŠP¥E8Ñ[‚MaE\n’ªŸ½\0Ón›VbÏ1Ğvô9eA“<ú`	\0@š	 t\n`¦"; break;
		case "tr": $compressed = "E6šMÂ	Îi=ÁBQpÌÌ 9‚ˆ†ó™äÂ 3°ÖÆã!”äi6`'“yÈ\\\nb,P!Ú= 2ÀÌ‘H°€Äo<N‡XƒbnŸ§Â)Ì…'‰ÅbæÓ)ØÇ:GX‰ùnÅO‚¤¦“TÂl&#a¼A\$5ÉÄ)\0(–u6&èYÌ@u=\\Î“ë•\n~d¹Í1óq¤@k¸\\¨úDÒ/y:L`”ÚyÒOo¸ÜçÆ:Ñ†¼9Hcà¢™„ó|0œ¬:“I¢Ze^M·;aèÎe”,\rrH(ƒSÌ¦úaÓFL4œò:-''\"mÒMÇZ}»šXç ¢†¤ßr¥â‹±ÁÁšk\0¢Çh0ŞÖ:‡Æs2°Ôà¢É„àŸ4åŠ09Hó‚LøÜÏ¬ú¢2ªoQ>:0mZÈœ'Š’¨¬BP²÷0í2|:F¯§Ğâ‚‰3ãÒb¡c\"lÓ€HK<ÃÌH)¿/ØŒ7ÃZ’\rËêİ©\n˜ßO¨Ğ4¿C³£ÈëH «ï¨Â¼±@PæŸ1pô¶¡¯Ø:ªc¨\"2SV6„¢Æ²Î-HÂÙ´‚ˆ˜Ã¸‰ÔÔ0¿@PÖÓ#±#ÄÎ¯3ÅÁğŒ9\n˜¤òE@PÔ%T&;ã¬8:µT;\r9QJ±IËîÚR•È°2Rı<b×95B\"45Á‘)Ÿ\rqJ³°´LéNÓíR]DT=O<?Øã81ê<ƒA\0P!ŠbŒ„PÊ:H¨\\GãÚ2#\\š9,îúä“ˆC\n°ÔÀ@ıW•òÎÿ/ƒ\"|“‰éØä:Îì„ûv»í˜ØŸ_Ï`ˆƒ>9¨2¢ïŒƒ¨X\rŒøè32WMÖŒ=*Åöÿ±–`9ZŒ8Ò6ƒJÒ	£vĞæ;¤±Ê<Ê2\\aâ.4c0z\r è8Ax^;ëpÂ2 #r<\$£8^˜ìcÃ\"7 Ò\0^N£“n:iâúÈ¹a|\$£„”˜à^0‡Ê\"ìâ|ep ƒÖØ\r# @8#Í¼72ÀPª¼òŠĞ‰c7JCÉ„€(a#_?\n4H:…\n-¹'Ê/K&§*°Ø“Õie˜ lÍ-ŞÒÊ9Ò•HAy÷íş	™H¨´i>u6Rù/ÃrO\rãZlÏ,ÿ¼(	â˜¨×£è6?İ,4¶¯¾HjÀp^:-v|(Ú<Û ÖêC9ÒS…õÅ2³PG\n\n`\$ád7“ÀÆ`C«z\rímã˜ Îšz˜˜ĞÒEÂ0Tt…Í30àI\\sƒaÈâ<±É9ÂeìÅİ¨“°IÕÉH«ÑfjGL8<pè¡¬Óö°45ˆˆ	b!5@nJÂJd9Œ›Ğˆ„ØŸqjµZª]X± A€éÁ1÷¢è etÍğä˜baúv{Á”‰ø,Cc\$å‰#\0–jJÁ¨EGÍ<RÊ‘‚™mSIâ\nu¦BË&]J8âĞRÑs-DÔ¤e¤xya<ğœ¨P*U¬8eË¤ÃGôã¢ºBg¥š³\0Ê\n@T¦\"„À‹+e|±–qªZÉX0o,¾˜,ï¤ÄNâv8¬bk“âÂÅÜ°zLÁÔ5šE¤×£Yª`'ø³`@C“Ø<&¥â ô¢Œè#¤`@I®•™É¬¡7ËÌ©™×‘7¤I`è!+™ËtÕ.„#™Gc©zJ]\nË`Üâ€T°#¡™ÎK¥0\$Í'“‹²5#\0¨·Ù±Ì¦èQïSSqØyÙ(g˜©˜£äD•õVJÑ]+Ê’€§fgñ §tŒË’m5'ØÑ™ƒfÊM`F‘°‡Wè|’1D2İ#&¶·ëZ#¬¸eæ_ªÒ÷è XÈ2ıIôf­Ê¸‹Âàdˆ \$)ÖTg]×©?Uò¿<¡c`¦½pPrİ„‡CvçìSÛDõÊÊ(÷ƒZ}’Ït“£r!c«°Ÿ‡•æÉÚD'cÄz­¶eÇ;`ò-šö¶ªùìYcR#ªÔÇ\\’8KÈ\ratÛÒ“âEâj x…F'šR:Í…hK%úä³²NÎ‘Ô¬ÆÑè‡pÊˆ…é)áÍ˜åRDŒr¯VRÛŸ6\\)È	ë¦ä=SdEEáQE¨¾ŸÌè|ê¢	n™Äd^ëÀ\\I¡ÂRİèÓè€IÂ,kª„ğøà@‹0p#áØ˜?ÄâY ‰€2)Å'—eHHd yP¸nÂb`É‚ÕiL&À‡dïgqåpÄÖø7\$Öa©ñÍ,\\ˆM5•²#ñçåJÅ£ÊâBË\r3¬\\ÆYšÜŞ\r¡½p©ütáÛßÌ„^3CpˆÖtÎÙ»< ÉºvåËÓ4(Qâ=HòÑ ÃZ…F.gèÉeu‰•\"¦>f\0A•qQ–3±•aşTPÙE¦\0@rnY—yoQD=<£2ûÌ1	djò‡ªîŠÂ:%À5=T‹\"ø?©•\$lõòÅ.t“ì-ªõÕ¢46ÿO³\0œ,™S¯ìFÌV÷fÑÒ±6/kd}²'öİ(ˆËpXmÅh00¯±ÚMS=A„\$ÆóxôÉZlıs—7Ë*Ş»÷Xì¼ÅI .&\r)>i\"úı”dJÑøTÀ6º¸]+á©\0¾¿K«	±p:\\]bkb³†¥1Ú8æ_8ôß•n•K%…F4\r\$5SSIPCqDÅ²	Â¹û\\KÌ5Ğ:Î»ßbôŒœ8.³@ı§ì0jÏLÃU`Óoî„zàyêÌS©vo9×XëºÄö<ƒÁcK¤°]†ÈÚ#fÍ¹µ3ñMíÊœ6&ïı{VaÔv`\nGéŠ†•Ãáár„ˆÃtSUâÒiH'…Ÿ\$süáª8J#‘³>ÊŒôb†ÔÃxãG})ÃËmXû|†…ô3|Ğu¬ºÅıRÑŞ«È|5ÙÛ)ÜîõÑîœ=ïkÀÍø>'ä°-ó)ç»]äºv¬fLYÚ÷Æ\\ëşÏKºÿäü‚&f]ì®²æ.f*lwóùb‡şözfØüµÄ\$ŠL˜ş‹pÿÀ\\·m¼Ôè¢\$K^‡h>kŒ£ à\"ÃÀ\\ôÈän¬b#TµÍÚ°ïøŞµĞíŞÃ,\"ªØCCÆòÂ˜{Ê¢%Œ0ƒ`cŒ\r€V>GLR‡´ñH:\\ã”&Ç `ª\n€Œ pa,,pÂëZİ‰œª#ÆqEh¸Ğ°M\nE\nˆy\0ÌÎ…Ãô&˜±@ÇáxEÅZ7&j+>Ğˆ±®ĞËP^ÔğÂ&L€odf¨¢ô'ÅRQƒıfZ4 òwä¼H\"ˆÖ0¢HV©6\"ç~À¢.†§Ã`õ/\0\\%¢î*ëdYğ#CR¡'’/åşÌîµ0&xHõÑBùqX¦‚è cà\$\"0§\ndæ%ØÄÂ2ê†Îªun;0¦I¦pÍ‚JÓ‰PœM*M/Y‘œLñ @ŞeEDÃdFHÄL#@ôA„`±b€£`mä*Šæ¼ŠlNä¦¤IÅæYîÛ\r‘ŒÖ¥J'â.NJ,Jš‘R<\r`ÖÅ†h7¥Dsãbûƒ\0Cà@ ä"; break;
		case "uk": $compressed = "ĞI4‚É ¿h-`­ì&ÑKÁBQpÌÌ 9‚š	Ørñ ¾h-š¸-}[´¹Zõ¢‚•H`Rø¢„˜®dbèÒrbºh d±éZí¢Œ†Gà‹Hü¢ƒ Í\rõMs6@Se+ÈƒE6œJçTd€Jsh\$g\$æG†­fÉj> ”µÂÕêlŠ]H_F¯M<ªhº¦ÁªÑ¨ä*‰6˜JÖ29š<Oq2¨Òy ±¾,*Q¤= ´£Á\$š*!`,‚bš‹İeqQ˜HZeÌÒåM¦\\eŠÓE3¬Â¯öc®Ûb·×hRë½­E%„@öqûæİ/ÓA´Hx„4§™Ğµq¤¦#s›au‘¥Æ™ˆ\\{ ¾YÖÓöK3Eªø…\$E‚4I¡É=JòºG£E\nô»oÉ¡	;Íò¨• „Šb”»OjZ™°Š¾ Ğ\0NãlÜ<,1ì2²(ÄcIÃ:b†¶ñ) Q¿æƒz˜BÑªV^æ‰š4RBl¡@NúèG#H\n¦Ğ+2Šk%¨„h¦µÆ‚S/ q\0Ó(j¡5hÑ.ª<²¤Ø¤¥šG'4ó”èK)-¼¥(3ì£nËKÛ6«%	‹² Ë)+ü†Í¢¦%eœcJ„£\"É¬IxNÓéÌ¡QÓÔ-CĞ•#-´-ØÓ!ª,ºèÑ hSNMxÃVòtÆ½‘b4Ğm:ÇÅ¬LÚ¼KÅY/Rœ&•Ó\nJ]D³Ìœ™9H| h=­Òd©ÒŒ‚ ;ósÙB0ê6\r\0è0ŒC`ÊŒcÜ\nbˆ™F¥ty7tîîÖIK'!ÔÔ‘?+”í)US2¥Çñ&):¦t¾B£ª|\"š Í®Bšª9#“Bæ]\r–*Wc‘ƒ;²*IW&\r\r°s\\Ü–VQ‰WÈÕ‘C”EÙ[´†·XİÉ¤”9£DÔ4{lÎÑ.Z³ˆ]a.´c`è91”»øºÈ0@!Šbu\$C” ˆå°®¸ê2é‘‹¢®,¦‰„¸™º×-OÊH“ìÚo/–ö´2˜1È×	Jªé.‚/\\ª—ÔúŸ;ÇÉS”²R!ÏÄò´‚6s«’µj‰Ø3í3QÂ²c¶×¦Ö“ùepmJÍ7*Ë¯jÙµ±ªt»ÊÇ(S0{Ídà)éàš0c Ê9‡Ğ9ãxåO£Àà4C(É¾ƒ@Èf ˆ4@èĞ/áŞàÂhi\rÏ¬? ÎÃ(nƒáõàæC|KØ0‡ ÎC¤ëå°D‚Hmè6ÁèxaÇ0CPèz¾†Ö¾ÃHt}¯¬6¯èlö#5/¸ã‚_ÈÒ€\$Æ&`@@P±Msn¯X(,à¤Ø8¢”S˜Qà6ÉĞ¨ãÀ#\nˆx	Ö£’B‰k\\±å_D A\n#¹(END½ÕÒîTİ(Ñv¼â˜^ä¬P,ÉÒ×A[áixO9ŞšÒTğqåG'®¸C˜ZÓš#oæå<¦²…[‘M)4ö‹È¾Â˜TYJæ·ÉrÅy¯K±£/H!’ò¦H”yY2äé¢{h.91ÈÎºÊ“f‡‡lâpTÔÒoXˆŞAı\rÀ€:Ã0ßÁşA¤3‚ÀÃ0i_@€;—ü‚ PŸ!¹O˜dü¢TI˜9ğÚFXv‚‹\r_Ë&l×™«àl%­3t¿1ªY-e<7%İ™x-¡Œ5ÑnÆéf\$Á”°Æ0õMÛÓ¦Ôâ”3\$ÆÄ%±åN’)†èUkbÏy“™¢¤'MnØGœÀu8ÜÌ`ŒQ’›Æd¶“ä¾,ê½ä¤SzåÓH6u~µ=P’&ç”İ®ÒbA™ıh\\g^i5šœ˜ªÍ.&6‰³fQi\na%ñt¶7:,\"…—+	ñ…ªÙ`fİDUuÄhìyu¯jµè’»×c>¢`‚'2|ĞÈà†¶CBÚU‘0¹‚»c@J¨«rÛi1âJdÑsW³,¸Ûó^¹K\\Ğ¡´hHÑ×*büı.bDº)¹Î‰]³rÍ\n“»“Q=Çƒ¸IrãNjQİßoHÁj§‘i1ÛâUaM™	A Ïs,qk8h#ZTVL†c=-ãƒjÓµV¯	¨ÌÓ)z‚ M1=jä-.É1kUa\rZ\njµl­†”Â»1Ğ˜ìƒ&š§¤R›°Gè‘Tƒ(`F€¦•E©I»¹S¬%+šĞœwQ.m+[0—e§¦ …²‚˜NñÉ<Õ¥†Œ:†E¼\\‡q\$RZÄ³#ÊpHƒ9ª…±ÃäüÃë>E|/hîTõ•:’KäWé0àfŸO=´šF?4ƒåG\n©”5ÆÅÜ0dÄ©v'LŠ¢Íê#ñ©5\n>’g›(æCKg!IDdÕ”+Whˆü¨Oå%p’}@šõyÀ'V°]^åT›Ö…C[8’/µÓ×›<³)íR}ÜöÄ–(MAk\r“¬ŞMªÙÍSh²\r{µu.ª¯–ešiÖC_ã”6[~ÁÅIH6á/ÛØÇenš]2±Ø{İ3ïœ:T÷£TßÑÃ\\îªx.U»îrïİkÃ8OÖ¹¨K¿˜Ë\nF\$|l–ó\"¸,†:|Y;ƒ&Ê¸ªá²ÀÓœœz^u{6Òu;Ë‘«yCêo1ªËÚ…yâ*dü'%¬ÄMØÏœ®qÈôRğR¢(«V#m×½™zT!,dhËWå ]wnn¼êB–ÌéiLºàÎºziVGÖ¿^ÙıŒw»Ë“Q»H¸ìşı¾D	gğ1¾¾¨K_ßRÍ­lÆwO\0ĞhĞ \rÑ8 ÓAWÔ'kÚ\"OPÈ_Rö\r§Ñ¯uòlş€WÌK§?dÄsßçG\0Íñõ¯»Btø·Ûa’í1óâ¯ÜsI=CÌÓà±˜æÂ([¢<^ò\$½óÃb›\neQêÈx¾sk#­Š”5‡«¯•¡Ç£OcA*síA•i&¯úTEÈº_»“â¶´µ\$àšäŒRÇ\\yÒcõ\0†¼5	\"Ç+¢uïÜFğÉl.¾dd¶âì‚’ÈØøEÄû/Èªo ´ âçiÀ;ì.Ñã6!2Ç\nZ!k¾Ö@RÿP @ÂÒèg¦¨¡*û†¨¤xÏFÃ\\@cÊ™6ÖpˆfêˆcªRıôıæ£jJcP{\nI9\nkÏ¶4§bL§Ä¾¨p¶gJŒ±Ç¥eNdë§ÄğP¬ePFiğæ¨CMâ¶ü°†i‹JRLBÃJıªBŞexíd©„n©ÆÜGà\\ğ¼šmvğ°†Ø‘üm‘dÊ‘ïv/m5\$6(ïâê;PëÂï±9¤{Io\${q îVK±Pâ**.'ç)ğDû­ZÊÆ?&´Ã	\rÏ¶±pÄ³ñà¼Ëö´ğ§1!l«¢®;q˜ğAêÏX¹®~é#døg¾(Š)¢®.¤–\$±æIL§\$‚¥nèæªu'£Eo‚KÊTu‘pÇğS	§ÂÏ*D\"öıÊä’nygŠËG2¼F:Bìîg<OÑ¦´Q•L´Fl’Éc\0%…Ôûæ´¾Q2í¬Ã«–¼â\r	0`Ä„öÄñ³&0Fú,J³‘œ±B‹2tÄÃOªüş’˜ù£e(,N£kr†úRšè'™*Ñ…1·,0‹bºÒ”ş‘Ï,vªošt²ªQ0Y)òÑF¶Ìãä¹ƒfEÌ°ätÅÂúÙå~É?#ÌLw¢MkŞå&¼öïVSñKpéOµ(‡cÓĞ±\"AĞøı±‡'Ó,©³Mó#3’k¯ãrÒæäÒ…hw%‚Q3Rbä¿C3J«4Æ¤,ZVÒÇ6òáA3\$àÅ+¶§r‡K0­xèòÌãÔÎë@:Hï*ğán‚.©>’ñ½:I]+±Í4â×:óaS¢’“§+°ÁÑ&2Ö;“Çb´)+/rŞÒ=Ä÷<’G>s‰1[2r±pJòÊÒñÓc7)Â»’>ÆYLº«S©BdU'±_Ô\$l¼+Ô7GA/ìA´<ÌÔş®‹C¼<ã2¨^ùEI2ÒÏÃ2N÷BÑŒÅæF¥¦>T5=PÇG„_GĞ.¤3ÿ4²™aJDã\\Ífg“8FÊÊ Æzä^Œ“eÔpß\nŠ­ÎŞóhv­†”SIL·0îL“‚J­³MõMDT•„=M¥SLª ”rr>Zf&Şï%l*ä”Â¬ÓJdª4”¿Q4)QRñÏ°ı3ÔğİÃ½N5)Ô„İ\rğQä­O€†m`ØrLP´3º‘âR¾ƒ\n¾Ò8ã?+Ôº ‚t\$*'€Œ Eö\r ê} @H`ª\n€Œ p2h‚‚@ÎŞÍ¬Øf©s¼P<h²ì<OÕ¤ÛYG–ÎD&Í”áíÒ³§ŸZ¦ˆEÕ³\\«\"Cb@\$Ine-`K’hşï¯.jÎø+úR­ZDš®BRé«œ”{[#x7Ò*Í£Vå(Ü™µiAJQµ]œşcrÀ¢’5Â4“ød 	‰î•œVDŸ\0Ú~Eöôåîa4pªÎ¦êVšÊ¬ÎªÿÑ×=ö0£nÁt8ıò{ô’BlŒ..ëgò]g6‡`bšµnEJúÌYhQd;PßGGPüö“ q.;B@¯qğÚL¦ä¶²ûÖ¤ÿãàr²¤GÄ,Ù&’{î[_XIä„V™P®Ã>—‚©Êt[¶ü—ÆA‘€Õ%%Mx‘¤©ãè³‰ Õ…vR“óR@BËÄœ6Äè‹ÁÊÎ²d^±¯¢÷o˜VNÕg‡£K,1h¬4c	/é’;‡Fc&qP×sÏât+?Ín×/9×+;Sã=ÃÀÀÃë\0±[³pwcæ{À"; break;
		case "zh": $compressed = "ä^¨ês•\\šr¤îõâ|%ÌÂ:\$\nr.®„ö2Šr/d²È»[8Ğ S™8€r©!T¡\\¸s¦’I4¢b§r¬ñ•Ğ€Js!Kd²u´eåV¦©ÅDªXçT®NTr}Ê§EËVJr%Ğ¡ªÊÁBÀS¡^­t*…êıÎ”T[UëxÚğè_¦\\‹¤Û™©r¬R±•lå	@FUPÄÕ­J­œ«u•B¥TËİÕdBİÎ±]¹SÖ2UaPKËRêYr}Ì—[:RëJÚµ.çV)£+(Âé€M¹Q`Sz‘s®Ó•´:‚\0•r¦×ÎUêŠ¶ˆKÙï.ušï£—SÑJ*gÇxÒ-á(ÚÚ½çP eºç26\n]ni2Ô—¤ª0_“§1@œğ¹\$seKZX?¥rZLÇ9H]:\$™ÌO‰i6ZÄ¡rtä3²_DÑDTñ)Myv]%	r–‘%:ÎF9¥á,tÄŠ2\rĞE%Œ'\nº…ì.\$Ü\\H	i Nå£¼“—g1¡—¤k\rÄq\$r—D|¨L©ólŞH ÄÓ0—‡I*_Í…2¶E¦#£`ØƒÄ6¡\0æ1Œ#p)Š\"aÊH£ÅÙIg)x¹œC=Å%Ì/Í	ÍÔ§1Pö“s”äÆõua7TïõRsÄĞS?G1:A\$É ú—‡)\nRÙ)­Å™Pt’‹frÖ¤±aW/ıUWÓÓt\n PØ:M’FJ‘\0†)ŠB0@“”‡9F*ÇIF¤yHÂ)ªĞr‘¤«/hÚv«I:Dû.“Kq:r—ä,r]V„•í^b%~&Î0;j†8ëİõ~[Pl	ƒ-M½ÖDYÅl2Ë‰£æ:£@8gC˜î7R@Ê<Hä2Œp@!\0Ñ¥ŒÁèD4ƒ àáxï¯…ÃÈ6#vzhƒ8^2ÛXñ\rÃ˜Ò7í¡0C8Ê:jÂıHa|\$£…6íƒ xŒ!òŒ9„@è4\rò@è7ò#×F#¦´,K!9	°ìLs,k,RWÁPbt\n@ 0ÌCr‘øêğ†\n:D²çAlBä©r`™YIªnÇ61\\ZÂ÷Ñ«-Ï‘DO¤QAÇ²é‰TŸ±İ )ŠÃøÿ*Öq ’6ëI!)Ëíû¾ú\$,Ì/H*˜^†\\,†ğê€nÕÃöÄˆb\r!œ)@˜0iQ€€;–¢‚£·R) 4¸VˆçœìA¼6¨æz›:ê5¢!nª—ÂgÈ¢SÂ .¸Ğ¬=@+]l¡‡Ö·‹h¿cœT³”xKA[âaëÑ-‡0€?Oí{CA8+£ûB,D_ˆwhíÃ©1N=2ò‰C™ßëô–ŠØ+ÑÚ4‡0ì–®b•èZ\"U[.ë]:?|\"K-DÑ‡,xA<'\0ª A\nIÉPˆB`E“g|KŸ8¤ ¼¦4æ¤Õ¥DöŸR¢G1äC¾5\0ıÄôU\"ìLaH9D\0¼%«I}¢Z-ÍKŞ#\",È\"0.Qs<EÍ#š)ÅÚÅSh±¢ÛbyÍKÊyÕªÄT—aĞ¼ubécq6+‡0 ê‘Ly’(	Œˆi\ngx\$Oiyˆ‚ê~ÏúVÄØºN£¤I‹äÒ³\$ŠÉYå´_)Ú'<VL*B&Dää`æa(?h`ÿõhˆ¥%¢|R–èt³Ö ™Hà£Ä|(D`æ¥”¸'„¶P	RB?w’”^‹Ê\$Äl‡tÂ%K©‘Ha©ºø-UÜ	ÒÉNÅ|:3Œ-î›d{\"™‰K%|Š0S+!\"c\"¬s¬<Z–r8‚dÛ™¡'0­KâìBd8‡«™-Â¼–‰Ú[-OKİ=‡¸pÊ¬Ië \$ğ¦FÃ\0\$ı”¤Eqóˆ9…Ã*ls¤\$‰@*ÓtÎ¡A6¥œîĞÜY*´P¶­Œï¶ƒ˜G¦µ—nEq–f6õe,ÈÃ@a†\0€79€àƒLQéÈ9x agŠ 4›ª¢”c¤T,L¨ {ÈT…È¶:\"œè˜ÛL‘o1·¦Ş[áK2æh¸G~×Ú2·ÄégŠİÎdVZ-¥À•ÀDRthx¥4äÂLGô\\#¨5E„åarµ‡G.Â3ÿÛ\\\r:'!¡œsªUá¹HğÒ|B™á•± ™…8°Ä±ì^CÈ\r«œeu4ùÄ,ƒVÀºÈÙ#%Máö¤ñàw!UGÊqùëäËl«rãÅÑÚ9S`­c£1š*PiÅk;•¤d{û/ädÀ¹:|ç¬™@óìû`ó²'Q\$#-”ñúŠ±u•İ<î'D¥»‹M[(*b£DÏ(GØ£)…Óß‘UŠ'Uó)¢àJNCDc¡®ÔwÈĞWó>ÎlïÑKs·ğ÷§	›Éª–n\"ûi0-ØÙÿ\$#}ŠvŸÍ ›*ol-‘H\nf{T»`”e¬“·	K1ÀÛ‚“mñuHNb&€æ‹´D'O@¯VBºœˆ„è\$uãT{[+cÚ7GsNÚE[ÿ4&İ¼ø%Ë¤³/ğ1”tôEq–î^ÃÒ\nâ‘6\$êÑ6'´ÆÀ4ÄşB“o&ËØ’Ë9IàâÜ¡÷ó-ù€¹'ç;‹'rgÏ¹¼; «ş€ğ\$V)ç÷D=ÜŸ¡Ğ—Ï6'H Ö3u.”^k©º7›“ ãÓD|z7_4¼ê”‹s.Ğhi™›€'\$Ó\r[B~mS3\$r(ík:0Ò½±\n\"ÇHšİøX“aBQƒ&íï‡zª+PÎQ¯¨µ¤– †º`+a°4†0Ö¤ƒ„6Uuƒk•\r!˜<‚:é4Q¡´:³°@œä\n\n¡P#Ğp`cõA¸3ºJ©P­h¯Y+-‡‘¢8/b\0©-Ô¶(ÚT‡|P³J*È l!}Õ÷½€PÚ°¯¸¿ÌWŠY€/!ø¡£¤Nç”Bp¨LÁ‘²†pÿHõ&–²Q\$xÊD\$F:m„´\n+\nÁ˜z‰¤ÁbXÂZ‚9mß¬BX\n‹À§ ¹+–÷Øô\0àˆJ\r ôi‡HÂ\rÙä`ÓcÄ1ÌKiĞ[¢¶L&Â¥ºÆ)`Õ+Œf¤d3t8‹2â,:De\$\"¤,%¡G\nX@â‚Z´0 -°*šO\"YC4Ì|¤ˆ‘,›·ƒ”İ.b6,Øi`ÓdÑbë#v@	\0t	 š@¦\n`"; break;
		case "zh-tw": $compressed = "ä^¨ê%Ó•\\šr¥ÑÎõâ|%ÌÎu:HçB(\\Ë4«‘pŠr –neRQÌ¡D8Ğ S•\nt*.tÒI&”G‘N”ÊAÊ¤S¹V÷:	t%9Sy:\"<r«STâ¢.©‚ ’Ôr}Ê§EÒÖI'2qèY¡ÜÉdË¡B¨•K€§B©=1@ ÷:R¬èU¢ïwÕDyåD%åËhò¶<€r b)àèe7Í&óp‚‘q¥Éi®UºÊ£Sªè0wçB\néP§œ©ë™*¸¨¥éiu-•>æL )dœµZ—s«Ñå•étŒt 4È…´]l²t-ÕòÕÊú\0•–âm×ûM­2å]*Üë5Ûj±½/VZ‚f¬å\\,İ	˜s•^C jÚĞµ-AV‹“%Ú\\R©epr\$)ÏÁ`QÒ@—1&CÀo2.S²9t÷2À¥“e¡ÌJ)!DtÄ³ÇEQd:¶FkY`r—eÑÒP©i>[­Äb.[•Axí„£ @1,¸P9…0´1\réi^¶ÅÄ,MÇ) D)d8¡,'!v]œÄ!€§9zW)dq\$ôğ±2¨ÅTôŸ àP¨ÊÒJ–ïAL–‘hézNB0ê6\r\0è0ŒC`ÊcÂ7B˜¢&¤‰{5ŠYI¸k	ÊB4Ê”i—1»ÎôÖq³Ë-ñ\$MWG§;[<uôO[@Ç1<[WêYX§©iWÂª…ö±ËAU¹Dlub-ë¥w[À÷!Qc,0¼3\rC`è9\"èËlD&„ @!ŠbK\rã[0¸°YÒC‘±Ô&^:)‚Şr’ÅsA	ÛÏ™ŸDû@)Œ£›4Î)~×”AĞQg)*O°˜Ş;³­!e‘ÍòF`¸>K¤‰ŞÄ­ğšœÄ1\"t¤K@&Œ#›.9†š9ãxå'2£€Ò9£ \\ƒ@4kƒ0z\r è8Ax^;îpÂ2\r£HÜ2Av¬3…ìÆúË3€^RÃä3Œ£¦Î/Ó4øÖÂHÚ8SCk0:xÂ3Ã˜AËƒ@ß'ƒ>0àA\0ÓBÀÛOòárÄ²,Á4Z%Ä)ÌT/q	Ù¬¤LÔ]»ñY^så¥ò(	‡oÜ÷}éjB!„B†iIZè[5äjN2\"—¦)šjÜœÅqk.àä~Àœ¥dEÿ´(	â˜¨Y!TOÅ9qÂàM”&¹Ç0ˆFF¹ø¿1@çAù&\"´ƒ‚´hÈo OĞêå{s\rˆ1ÎL˜4© @ƒKbÁP(B0Ü“ƒK“jÊÕÂ°äÃjœoÙ¼;\"0Fš\\èĞ,ƒÒÌŒ@ª'‚Ğ.ä±:àXB-qÄµptEçñ.QĞ+„R]\"â,@a\nXJ@ç\" ²ŠÂ&ŠB†=š<Çœ\$İÀ…wNñß9Õº:D`„(¢ê;”„,Â¼(Ts\nBP„jæ@…µr‘ã~(İúê]‹Ö\$41	(…ª%,€s7‚‘M?Ã¤F‹R—%¤À\n	á8P T²ê^@Š,Â<&(HI‘Ê#Ä]LIÄ™!cbl×jˆQIX\\#ô‚:;ÿQ°4r¿D,(„2(T±Ğ)ÅKg4Ãó\"šHùeè\\¹ô‡ÅÜS4(½£5Õ2È¸´C”^ÌŠU ç¡T0ğA|!‡0º\\MŠçv&UÈ¹HíùK)i-§x¸ac”ûÕ‚°Å=*\"ò–aÌƒ¯ñĞG ÁÊ´ÖØº.‚ğÜ-É+MâyŒF]'‘È.Œ»:ªÚ—./Ká¬5Å,OŠQĞ*hZ\"‘	02\$T„‘ŒÕv¯Š ÙºMH³<ÅÑb:Dø¿x™Rªqv)&zÔHrÁí3\$~˜D@©¶´™ä=ë]^¬°Ñ’>HE™¡':Ë’&Nz…0e¶±-3€ ‡(ƒ˜VŠ\"Z Íx¡ãœR#å¦]E!1\"íQ|'‡!ò>”Ôë31@ n	ó‡ÔTÂQ!¬]h­VU2ZÅ#Îl5âeTt’– …¤A—ñSq•fV~(Ğ&eCÑS<›ÃËJò¸…·Î¿bY~¬ƒa 0Ä@@0pA¦)§ç( ƒá0™u,NS\niÙ*õb&Ğ¿¦œ\naÎ.Eàç9÷y\$¤²Z¬1 ¸ØıOQpd‘áŠWp–šQÎ-„í»‹ª&®sÇ{è‚,È²o#ß|’.e/kªƒdf3cğ¢ˆhGÂ#D°6FÓ/\\Á™sÓ%¥k‹+áDh\rbyÄJæ)±2Şª‡Q\"èS=‚[–&¬XŠ#ÅK\niYÒ:¯³N,_cM”´n‡ÍÙ?H’È´°âôY4¹\nÜåe×*UşÒùOO.Í›ÕÖLWº‚UØQ#Mz©iâõ²‹¢‘ke­7²»WŠõ ô-&–ºŸ'ì!k¨²–Æ•”hÄ¡\$#/¥œÄ²&H\"	p·x7ĞÜ	\r Ñ\rºYØÚ3r¨ºèíÙ¤ëk#øèY§±’¢T.†âR<%(¡„_)wqnÖJi÷<±’ÎZÑÍ¤[tõ!¤p5dœÛªhª ˆÈ·èé<9¥.FP¸i-GÆ¨/°¹KqÌÛÅåOª\"Ûb#QsÊ“W,ãÙK˜U)Y“ù©ÕÔ|å	c‰Õğ!Ã˜W§ÎA«S·Â0rb#OÉÅÄŸ‘Q<rÕhTD†³©»\"«u´û×[ipÛÒiRê¬[ìq«Q£ò|TºùtûàM‰íÈ«´Ş„Šq8‡S0Ã/\\‹}ó¿ïÕ‘g„ïş°äÿáƒ/i0>?Àfİ9İüó7—w\$Á¦¾df\\¢SÓV}¼BµôÔÎšùœ§êé§¨óŠÒ”úsï¤=…Ä´çâóÏGÔxÀ„5i\$×zŸ†kD/®øÿí†šéê•5:ÇEŸK…I¬„É\0¡üt¿ÆP{„¬µÃ R!ÁF/H¸¸¤¸XØï¸XGê!á’{ßÁ\\®ƒGmz¯#@eæ\r€V`Ø\r Æ\r`@dÄÀÂ\rü`>t`ÒÀòu@èv@Œ…¥6\r êiÄSfì— ¨ÀZ(ğĞ0\rÀÎvJä­( ®¿F€#B8ŠÄ6«ã°á,X¼,á8x/J°ßK¾Ic¢dH¢Áéª<ÉG´Gá)gÀéc\nÀ	ˆB†ìğ»ğ.k€@Â….UHÚ,Å|Å ½ápBB°È\$z)õ‚X<jfL~oØıÏà÷î¤<c@\nŒ6c¦ÆÀ¥6@Ê3\0è‡ ÒFºvEÔ­ä¤fÜè°ÄÌMZ¡¬¸“CÌÏI¶Şj)ùÂØâ°8b,H®Ø\n0Ê6Uçş, k\"Ä/şÁR)pã\n…Ğğäv¡l Á‹ééÿ!ĞıåB®úñ`æ.Té¶ÜáÌ‚¯v8€	\0@š	 t\n`¦"; break;
	}
	$translations = array();
	foreach (explode("\n", lzw_decompress($compressed)) as $val) {
		$translations[] = (strpos($val, "\t") ? explode("\t", $val) : $val);
	}
	return $translations;
}

if (!$translations) {
	$translations = get_translations($LANG);
}


// PDO can be used in several database drivers
if (extension_loaded('pdo')) {
	/*abstract*/ class Min_PDO extends PDO {
		var $_result, $server_info, $affected_rows, $errno, $error;
		
		function __construct() {
			global $adminer;
			$pos = array_search("SQL", $adminer->operators);
			if ($pos !== false) {
				unset($adminer->operators[$pos]);
			}
		}
		
		function dsn($dsn, $username, $password, $exception_handler = 'auth_error') {
			set_exception_handler($exception_handler); // try/catch is not compatible with PHP 4
			parent::__construct($dsn, $username, $password);
			restore_exception_handler();
			$this->setAttribute(13, array('Min_PDOStatement')); // 13 - PDO::ATTR_STATEMENT_CLASS
			$this->server_info = $this->getAttribute(4); // 4 - PDO::ATTR_SERVER_VERSION
		}
		
		/*abstract function select_db($database);*/
		
		function query($query, $unbuffered = false) {
			$result = parent::query($query);
			$this->error = "";
			if (!$result) {
				list(, $this->errno, $this->error) = $this->errorInfo();
				return false;
			}
			$this->store_result($result);
			return $result;
		}
		
		function multi_query($query) {
			return $this->_result = $this->query($query);
		}
		
		function store_result($result = null) {
			if (!$result) {
				$result = $this->_result;
				if (!$result) {
					return false;
				}
			}
			if ($result->columnCount()) {
				$result->num_rows = $result->rowCount(); // is not guaranteed to work with all drivers
				return $result;
			}
			$this->affected_rows = $result->rowCount();
			return true;
		}
		
		function next_result() {
			if (!$this->_result) {
				return false;
			}
			$this->_result->_offset = 0;
			return @$this->_result->nextRowset(); // @ - PDO_PgSQL doesn't support it
		}
		
		function result($query, $field = 0) {
			$result = $this->query($query);
			if (!$result) {
				return false;
			}
			$row = $result->fetch();
			return $row[$field];
		}
	}
	
	class Min_PDOStatement extends PDOStatement {
		var $_offset = 0, $num_rows;
		
		function fetch_assoc() {
			return $this->fetch(2); // PDO::FETCH_ASSOC
		}
		
		function fetch_row() {
			return $this->fetch(3); // PDO::FETCH_NUM
		}
		
		function fetch_field() {
			$row = (object) $this->getColumnMeta($this->_offset++);
			$row->orgtable = $row->table;
			$row->orgname = $row->name;
			$row->charsetnr = (in_array("blob", (array) $row->flags) ? 63 : 0);
			return $row;
		}
	}
}

$drivers = array();


$drivers["sqlite"] = "SQLite 3";
$drivers["sqlite2"] = "SQLite 2";

if (isset($_GET["sqlite"]) || isset($_GET["sqlite2"])) {
	$possible_drivers = array((isset($_GET["sqlite"]) ? "SQLite3" : "SQLite"), "PDO_SQLite");
	define("DRIVER", (isset($_GET["sqlite"]) ? "sqlite" : "sqlite2"));
	if (class_exists(isset($_GET["sqlite"]) ? "SQLite3" : "SQLiteDatabase")) {
		if (isset($_GET["sqlite"])) {
			
			class Min_SQLite {
				var $extension = "SQLite3", $server_info, $affected_rows, $errno, $error, $_link;
				
				function Min_SQLite($filename) {
					$this->_link = new SQLite3($filename);
					$version = $this->_link->version();
					$this->server_info = $version["versionString"];
				}
				
				function query($query) {
					$result = @$this->_link->query($query);
					$this->error = "";
					if (!$result) {
						$this->errno = $this->_link->lastErrorCode();
						$this->error = $this->_link->lastErrorMsg();
						return false;
					} elseif ($result->numColumns()) {
						return new Min_Result($result);
					}
					$this->affected_rows = $this->_link->changes();
					return true;
				}
				
				function quote($string) {
					return (is_utf8($string)
						? "'" . $this->_link->escapeString($string) . "'"
						: "x'" . reset(unpack('H*', $string)) . "'"
					);
				}
				
				function store_result() {
					return $this->_result;
				}
				
				function result($query, $field = 0) {
					$result = $this->query($query);
					if (!is_object($result)) {
						return false;
					}
					$row = $result->_result->fetchArray();
					return $row[$field];
				}
			}
			
			class Min_Result {
				var $_result, $_offset = 0, $num_rows;
				
				function Min_Result($result) {
					$this->_result = $result;
				}
				
				function fetch_assoc() {
					return $this->_result->fetchArray(SQLITE3_ASSOC);
				}
				
				function fetch_row() {
					return $this->_result->fetchArray(SQLITE3_NUM);
				}
				
				function fetch_field() {
					$column = $this->_offset++;
					$type = $this->_result->columnType($column);
					return (object) array(
						"name" => $this->_result->columnName($column),
						"type" => $type,
						"charsetnr" => ($type == SQLITE3_BLOB ? 63 : 0), // 63 - binary
					);
				}
				
				function __desctruct() {
					return $this->_result->finalize();
				}
			}
			
		} else {
			
			class Min_SQLite {
				var $extension = "SQLite", $server_info, $affected_rows, $error, $_link;
				
				function Min_SQLite($filename) {
					$this->server_info = sqlite_libversion();
					$this->_link = new SQLiteDatabase($filename);
				}
				
				function query($query, $unbuffered = false) {
					$method = ($unbuffered ? "unbufferedQuery" : "query");
					$result = @$this->_link->$method($query, SQLITE_BOTH, $error);
					$this->error = "";
					if (!$result) {
						$this->error = $error;
						return false;
					} elseif ($result === true) {
						$this->affected_rows = $this->changes();
						return true;
					}
					return new Min_Result($result);
				}
				
				function quote($string) {
					return "'" . sqlite_escape_string($string) . "'";
				}
				
				function store_result() {
					return $this->_result;
				}
				
				function result($query, $field = 0) {
					$result = $this->query($query);
					if (!is_object($result)) {
						return false;
					}
					$row = $result->_result->fetch();
					return $row[$field];
				}
			}
			
			class Min_Result {
				var $_result, $_offset = 0, $num_rows;
				
				function Min_Result($result) {
					$this->_result = $result;
					if (method_exists($result, 'numRows')) { // not available in unbuffered query
						$this->num_rows = $result->numRows();
					}
				}
				
				function fetch_assoc() {
					$row = $this->_result->fetch(SQLITE_ASSOC);
					if (!$row) {
						return false;
					}
					$return = array();
					foreach ($row as $key => $val) {
						$return[($key[0] == '"' ? idf_unescape($key) : $key)] = $val;
					}
					return $return;
				}
				
				function fetch_row() {
					return $this->_result->fetch(SQLITE_NUM);
				}
				
				function fetch_field() {
					$name = $this->_result->fieldName($this->_offset++);
					$pattern = '(\\[.*]|"(?:[^"]|"")*"|(.+))';
					if (preg_match("~^($pattern\\.)?$pattern\$~", $name, $match)) {
						$table = ($match[3] != "" ? $match[3] : idf_unescape($match[2]));
						$name = ($match[5] != "" ? $match[5] : idf_unescape($match[4]));
					}
					return (object) array(
						"name" => $name,
						"orgname" => $name,
						"orgtable" => $table,
					);
				}
				
			}
			
		}
		
	} elseif (extension_loaded("pdo_sqlite")) {
		class Min_SQLite extends Min_PDO {
			var $extension = "PDO_SQLite";
			
			function Min_SQLite($filename) {
				$this->dsn(DRIVER . ":$filename", "", "");
			}
		}
		
	}

	if (class_exists("Min_SQLite")) {
		class Min_DB extends Min_SQLite {
			
			function Min_DB() {
				$this->Min_SQLite(":memory:");
			}
			
			function select_db($filename) {
				if (is_readable($filename) && $this->query("ATTACH " . $this->quote(ereg("(^[/\\\\]|:)", $filename) ? $filename : dirname($_SERVER["SCRIPT_FILENAME"]) . "/$filename") . " AS a")) { // is_readable - SQLite 3
					$this->Min_SQLite($filename);
					return true;
				}
				return false;
			}
			
			function multi_query($query) {
				return $this->_result = $this->query($query);
			}
			
			function next_result() {
				return false;
			}
		}
	}
	
	function idf_escape($idf) {
		return '"' . str_replace('"', '""', $idf) . '"';
	}

	function table($idf) {
		return idf_escape($idf);
	}

	function connect() {
		return new Min_DB;
	}

	function get_databases() {
		return array();
	}

	function limit($query, $where, $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	function limit1($query, $where) {
		global $connection;
		return ($connection->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')") ? limit($query, $where, 1) : " $query$where");
	}

	function db_collation($db, $collations) {
		global $connection;
		return $connection->result("PRAGMA encoding"); // there is no database list so $db == DB
	}

	function engines() {
		return array();
	}

	function logged_user() {
		return get_current_user(); // should return effective user
	}

	function tables_list() {
		return get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name", 1);
	}

	function count_tables($databases) {
		return array();
	}

	function table_status($name = "") {
		global $connection;
		$return = array();
		foreach (get_rows("SELECT name AS Name, type AS Engine FROM sqlite_master WHERE type IN ('table', 'view') " . ($name != "" ? "AND name = " . q($name) : "ORDER BY name")) as $row) {
			$row["Oid"] = 1;
			$row["Auto_increment"] = "";
			$row["Rows"] = $connection->result("SELECT COUNT(*) FROM " . idf_escape($row["Name"]));
			$return[$row["Name"]] = $row;
		}
		foreach (get_rows("SELECT * FROM sqlite_sequence", null, "") as $row) {
			$return[$row["name"]]["Auto_increment"] = $row["seq"];
		}
		return ($name != "" ? $return[$name] : $return);
	}

	function is_view($table_status) {
		return $table_status["Engine"] == "view";
	}
	
	function fk_support($table_status) {
		global $connection;
		return !$connection->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");
	}

	function fields($table) {
		$return = array();
		foreach (get_rows("PRAGMA table_info(" . table($table) . ")") as $row) {
			$type = strtolower($row["type"]);
			$default = $row["dflt_value"];
			$return[$row["name"]] = array(
				"field" => $row["name"],
				"type" => (eregi("int", $type) ? "integer" : (eregi("char|clob|text", $type) ? "text" : (eregi("blob", $type) ? "blob" : (eregi("real|floa|doub", $type) ? "real" : "numeric")))),
				"full_type" => $type,
				"default" => (ereg("'(.*)'", $default, $match) ? str_replace("''", "'", $match[1]) : ($default == "NULL" ? null : $default)),
				"null" => !$row["notnull"],
				"auto_increment" => eregi('^integer$', $type) && $row["pk"], //! possible false positive
				"privileges" => array("select" => 1, "insert" => 1, "update" => 1),
				"primary" => $row["pk"],
			);
		}
		return $return;
	}

	function indexes($table, $connection2 = null) {
		$return = array();
		$primary = array();
		foreach (fields($table) as $field) {
			if ($field["primary"]) {
				$primary[] = $field["field"];
			}
		}
		if ($primary) {
			$return[""] = array("type" => "PRIMARY", "columns" => $primary, "lengths" => array());
		}
		$sqls = get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = " . q($table));
		foreach (get_rows("PRAGMA index_list(" . table($table) . ")") as $row) {
			$name = $row["name"];
			if (!ereg("^sqlite_", $name)) {
				$return[$name]["type"] = ($row["unique"] ? "UNIQUE" : "INDEX");
				$return[$name]["lengths"] = array();
				foreach (get_rows("PRAGMA index_info(" . idf_escape($name) . ")") as $row1) {
					$return[$name]["columns"][] = $row1["name"];
				}
				$return[$name]["descs"] = array();
				if (eregi('^CREATE( UNIQUE)? INDEX ' . quotemeta(idf_escape($name) . ' ON ' . idf_escape($table)) . ' \((.*)\)$', $sqls[$name], $regs)) {
					preg_match_all('/("[^"]*+")+( DESC)?/', $regs[2], $matches);
					foreach ($matches[2] as $val) {
						$return[$name]["descs"][] = ($val ? '1' : null);
					}
				}
			}
		}
		return $return;
	}

	function foreign_keys($table) {
		$return = array();
		foreach (get_rows("PRAGMA foreign_key_list(" . table($table) . ")") as $row) {
			$foreign_key = &$return[$row["id"]];
			//! idf_unescape in SQLite2
			if (!$foreign_key) {
				$foreign_key = $row;
			}
			$foreign_key["source"][] = $row["from"];
			$foreign_key["target"][] = $row["to"];
		}
		return $return;
	}

	function view($name) {
		global $connection;
		return array("select" => preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\\s+~iU', '', $connection->result("SELECT sql FROM sqlite_master WHERE name = " . q($name)))); //! identifiers may be inside []
	}

	function collations() {
		return (isset($_GET["create"]) ? get_vals("PRAGMA collation_list", 1) : array());
	}

	function information_schema($db) {
		return false;
	}

	function error() {
		global $connection;
		return h($connection->error);
	}
	
	function check_sqlite_name($name) {
		// avoid creating PHP files on unsecured servers
		global $connection;
		$extensions = "db|sdb|sqlite";
		if (!preg_match("~^[^\\0]*\\.($extensions)\$~", $name)) {
			$connection->error = lang(11, str_replace("|", ", ", $extensions));
			return false;
		}
		return true;
	}
	
	function create_database($db, $collation) {
		global $connection;
		if (file_exists($db)) {
			$connection->error = lang(12);
			return false;
		}
		if (!check_sqlite_name($db)) {
			return false;
		}
		$link = new Min_SQLite($db); //! exception handler
		$link->query('PRAGMA encoding = "UTF-8"');
		$link->query('CREATE TABLE adminer (i)'); // otherwise creates empty file
		$link->query('DROP TABLE adminer');
		return true;
	}
	
	function drop_databases($databases) {
		global $connection;
		$connection->Min_SQLite(":memory:"); // to unlock file, doesn't work in PDO on Windows
		foreach ($databases as $db) {
			if (!@unlink($db)) {
				$connection->error = lang(12);
				return false;
			}
		}
		return true;
	}
	
	function rename_database($name, $collation) {
		global $connection;
		if (!check_sqlite_name($name)) {
			return false;
		}
		$connection->Min_SQLite(":memory:");
		$connection->error = lang(12);
		return @rename(DB, $name);
	}
	
	function auto_increment() {
		return " PRIMARY KEY" . (DRIVER == "sqlite" ? " AUTOINCREMENT" : "");
	}
	
	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$use_all_fields = ($table == "" || $foreign);
		foreach ($fields as $field) {
			if ($field[0] != "" || !$field[1] || $field[2]) {
				$use_all_fields = true;
				break;
			}
		}
		$alter = array();
		$originals = array();
		$primary_key = false;
		foreach ($fields as $field) {
			if ($field[1]) {
				if ($field[1][6]) {
					$primary_key = true;
				}
				$alter[] = ($use_all_fields ? "  " : "ADD ") . implode($field[1]);
				if ($field[0] != "") {
					$originals[$field[0]] = $field[1][0];
				}
			}
		}
		if ($use_all_fields) {
			if ($table != "") {
				queries("BEGIN");
				foreach (foreign_keys($table) as $foreign_key) {
					$columns = array();
					foreach ($foreign_key["source"] as $column) {
						if (!$originals[$column]) {
							continue 2;
						}
						$columns[] = $originals[$column];
					}
					$foreign[] = "  FOREIGN KEY (" . implode(", ", $columns) . ") REFERENCES "
						. table($foreign_key["table"])
						. " (" . implode(", ", array_map('idf_escape', $foreign_key["target"]))
						. ") ON DELETE $foreign_key[on_delete] ON UPDATE $foreign_key[on_update]"
					;
				}
				$indexes = array();
				foreach (indexes($table) as $key_name => $index) {
					$columns = array();
					foreach ($index["columns"] as $column) {
						if (!$originals[$column]) {
							continue 2;
						}
						$columns[] = $originals[$column];
					}
					$columns = "(" . implode(", ", $columns) . ")";
					if ($index["type"] != "PRIMARY") {
						$indexes[] = array($index["type"], $key_name, $columns);
					} elseif (!$primary_key) {
						$foreign[] = "  PRIMARY KEY $columns";
					}
				}
			}
			$alter = array_merge($alter, $foreign);
			if (!queries("CREATE TABLE " . table($table != "" ? "adminer_$name" : $name) . " (\n" . implode(",\n", $alter) . "\n)")) {
				// implicit ROLLBACK to not overwrite $connection->error
				return false;
			}
			if ($table != "") {
				if ($originals && !queries("INSERT INTO " . table("adminer_$name") . " (" . implode(", ", $originals) . ") SELECT " . implode(", ", array_map('idf_escape', array_keys($originals))) . " FROM " . table($table))) {
					return false;
				}
				$triggers = array();
				foreach (triggers($table) as $trigger_name => $timing_event) {
					$trigger = trigger($trigger_name);
					$triggers[] = "CREATE TRIGGER " . idf_escape($trigger_name) . " " . implode(" ", $timing_event) . " ON " . table($name) . "\n$trigger[Statement]";
				}
				if (!queries("DROP TABLE " . table($table))) { // drop before creating indexes and triggers to allow using old names
					return false;
				}
				queries("ALTER TABLE " . table("adminer_$name") . " RENAME TO " . table($name));
				if (!alter_indexes($name, $indexes)) {
					return false;
				}
				foreach ($triggers as $trigger) {
					if (!queries($trigger)) {
						return false;
					}
				}
				queries("COMMIT");
			}
		} else {
			foreach ($alter as $val) {
				if (!queries("ALTER TABLE " . table($table) . " $val")) {
					return false;
				}
			}
			if ($table != $name && !queries("ALTER TABLE " . table($table) . " RENAME TO " . table($name))) {
				return false;
			}
		}
		if ($auto_increment) {
			queries("UPDATE sqlite_sequence SET seq = $auto_increment WHERE name = " . q($name)); // ignores error
		}
		return true;
	}
	
	function index_sql($table, $type, $name, $columns) {
		return "CREATE $type " . ($type != "INDEX" ? "INDEX " : "")
			. idf_escape($name != "" ? $name : uniqid($table . "_"))
			. " ON " . table($table)
			. " $columns"
		;
	}
	
	function alter_indexes($table, $alter) {
		foreach (array_reverse($alter) as $val) {
			if (!queries($val[2] == "DROP"
				? "DROP INDEX " . idf_escape($val[1])
				: index_sql($table, $val[0], $val[1], $val[2])
			)) {
				return false;
			}
		}
		return true;
	}
	
	function truncate_tables($tables) {
		return apply_queries("DELETE FROM", $tables);
	}
	
	function drop_views($views) {
		return apply_queries("DROP VIEW", $views);
	}
	
	function drop_tables($tables) {
		return apply_queries("DROP TABLE", $tables);
	}
	
	function move_tables($tables, $views, $target) {
		return false;
	}
	
	function trigger($name) {
		global $connection;
		if ($name == "") {
			return array("Statement" => "BEGIN\n\t;\nEND");
		}
		preg_match('~^CREATE\\s+TRIGGER\\s*(?:[^`"\\s]+|`[^`]*`|"[^"]*")+\\s*([a-z]+)\\s+([a-z]+)\\s+ON\\s*(?:[^`"\\s]+|`[^`]*`|"[^"]*")+\\s*(?:FOR\\s*EACH\\s*ROW\\s)?(.*)~is', $connection->result("SELECT sql FROM sqlite_master WHERE name = " . q($name)), $match);
		return array("Timing" => strtoupper($match[1]), "Event" => strtoupper($match[2]), "Trigger" => $name, "Statement" => $match[3]);
	}
	
	function triggers($table) {
		$return = array();
		foreach (get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($table)) as $row) {
			preg_match('~^CREATE\\s+TRIGGER\\s*(?:[^`"\\s]+|`[^`]*`|"[^"]*")+\\s*([a-z]+)\\s*([a-z]+)~i', $row["sql"], $match);
			$return[$row["name"]] = array($match[1], $match[2]);
		}
		return $return;
	}
	
	function trigger_options() {
		return array(
			"Timing" => array("BEFORE", "AFTER", "INSTEAD OF"),
			"Type" => array("FOR EACH ROW"),
		);
	}
	
	function routine($name, $type) {
		// not supported by SQLite
	}
	
	function routines() {
		// not supported by SQLite
	}
	
	function routine_languages() {
		// not supported by SQLite
	}
	
	function begin() {
		return queries("BEGIN");
	}
	
	function insert_into($table, $set) {
		return queries("INSERT INTO " . table($table) . ($set ? " (" . implode(", ", array_keys($set)) . ")\nVALUES (" . implode(", ", $set) . ")" : "DEFAULT VALUES"));
	}
	
	function insert_update($table, $set, $primary) {
		return queries("REPLACE INTO " . table($table) . " (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")");
	}
	
	function last_id() {
		global $connection;
		return $connection->result("SELECT LAST_INSERT_ROWID()");
	}
	
	function explain($connection, $query) {
		return $connection->query("EXPLAIN $query");
	}
	
	function found_rows($table_status, $where) {
	}
	
	function types() {
		return array();
	}
	
	function schemas() {
		return array();
	}
	
	function get_schema() {
		return "";
	}
	
	function set_schema($scheme) {
		return true;
	}
	
	function create_sql($table, $auto_increment) {
		global $connection;
		$return = $connection->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = " . q($table));
		foreach (indexes($table) as $name => $index) {
			if ($name == '') {
				continue;
			}
			$return .= ";\n\n" . index_sql($table, $index['type'], $name, "(" . implode(", ", array_map('idf_escape', $index['columns'])) . ")");
		}
		return $return;
	}
	
	function truncate_sql($table) {
		return "DELETE FROM " . table($table);
	}
	
	function use_sql($database) {
	}
	
	function trigger_sql($table, $style) {
		return implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($table)));
	}
	
	function show_variables() {
		global $connection;
		$return = array();
		foreach (array("auto_vacuum", "cache_size", "count_changes", "default_cache_size", "empty_result_callbacks", "encoding", "foreign_keys", "full_column_names", "fullfsync", "journal_mode", "journal_size_limit", "legacy_file_format", "locking_mode", "page_size", "max_page_count", "read_uncommitted", "recursive_triggers", "reverse_unordered_selects", "secure_delete", "short_column_names", "synchronous", "temp_store", "temp_store_directory", "schema_version", "integrity_check", "quick_check") as $key) {
			$return[$key] = $connection->result("PRAGMA $key");
		}
		return $return;
	}
	
	function show_status() {
		$return = array();
		foreach (get_vals("PRAGMA compile_options") as $option) {
			list($key, $val) = explode("=", $option, 2);
			$return[$key] = $val;
		}
		return $return;
	}
	
	function convert_field($field) {
	}
	
	function unconvert_field($field, $return) {
		return $return;
	}
	
	function support($feature) {
		return ereg('^(view|trigger|variables|status|dump|move_col|drop_col)$', $feature);
	}
	
	$jush = "sqlite";
	$types = array("integer" => 0, "real" => 0, "numeric" => 0, "text" => 0, "blob" => 0);
	$structured_types = array_keys($types);
	$unsigned = array();
	$operators = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL", "SQL"); // REGEXP can be user defined function
	$functions = array("hex", "length", "lower", "round", "unixepoch", "upper");
	$grouping = array("avg", "count", "count distinct", "group_concat", "max", "min", "sum");
	$edit_functions = array(
		array(
			// "text" => "date('now')/time('now')/datetime('now')",
		), array(
			"integer|real|numeric" => "+/-",
			// "text" => "date/time/datetime",
			"text" => "||",
		)
	);
}


$drivers["pgsql"] = "PostgreSQL";

if (isset($_GET["pgsql"])) {
	$possible_drivers = array("PgSQL", "PDO_PgSQL");
	define("DRIVER", "pgsql");
	if (extension_loaded("pgsql")) {
		class Min_DB {
			var $extension = "PgSQL", $_link, $_result, $_string, $_database = true, $server_info, $affected_rows, $error;
			
			function _error($errno, $error) {
				if (ini_bool("html_errors")) {
					$error = html_entity_decode(strip_tags($error));
				}
				$error = ereg_replace('^[^:]*: ', '', $error);
				$this->error = $error;
			}
			
			function connect($server, $username, $password) {
				global $adminer;
				$db = $adminer->database();
				set_error_handler(array($this, '_error'));
				$this->_string = "host='" . str_replace(":", "' port='", addcslashes($server, "'\\")) . "' user='" . addcslashes($username, "'\\") . "' password='" . addcslashes($password, "'\\") . "'";
				$this->_link = @pg_connect("$this->_string dbname='" . ($db != "" ? addcslashes($db, "'\\") : "postgres") . "'", PGSQL_CONNECT_FORCE_NEW);
				if (!$this->_link && $db != "") {
					// try to connect directly with database for performance
					$this->_database = false;
					$this->_link = @pg_connect("$this->_string dbname='postgres'", PGSQL_CONNECT_FORCE_NEW);
				}
				restore_error_handler();
				if ($this->_link) {
					$version = pg_version($this->_link);
					$this->server_info = $version["server"];
					pg_set_client_encoding($this->_link, "UTF8");
				}
				return (bool) $this->_link;
			}
			
			function quote($string) {
				return "'" . pg_escape_string($this->_link, $string) . "'"; //! bytea
			}
			
			function select_db($database) {
				global $adminer;
				if ($database == $adminer->database()) {
					return $this->_database;
				}
				$return = @pg_connect("$this->_string dbname='" . addcslashes($database, "'\\") . "'", PGSQL_CONNECT_FORCE_NEW);
				if ($return) {
					$this->_link = $return;
				}
				return $return;
			}
			
			function close() {
				$this->_link = @pg_connect("$this->_string dbname='postgres'");
			}
			
			function query($query, $unbuffered = false) {
				$result = @pg_query($this->_link, $query);
				$this->error = "";
				if (!$result) {
					$this->error = pg_last_error($this->_link);
					return false;
				} elseif (!pg_num_fields($result)) {
					$this->affected_rows = pg_affected_rows($result);
					return true;
				}
				return new Min_Result($result);
			}
			
			function multi_query($query) {
				return $this->_result = $this->query($query);
			}
			
			function store_result() {
				return $this->_result;
			}
			
			function next_result() {
				// PgSQL extension doesn't support multiple results
				return false;
			}
			
			function result($query, $field = 0) {
				$result = $this->query($query);
				if (!$result || !$result->num_rows) {
					return false;
				}
				return pg_fetch_result($result->_result, 0, $field);
			}
		}
		
		class Min_Result {
			var $_result, $_offset = 0, $num_rows;
			
			function Min_Result($result) {
				$this->_result = $result;
				$this->num_rows = pg_num_rows($result);
			}
			
			function fetch_assoc() {
				return pg_fetch_assoc($this->_result);
			}
			
			function fetch_row() {
				return pg_fetch_row($this->_result);
			}
			
			function fetch_field() {
				$column = $this->_offset++;
				$return = new stdClass;
				if (function_exists('pg_field_table')) {
					$return->orgtable = pg_field_table($this->_result, $column);
				}
				$return->name = pg_field_name($this->_result, $column);
				$return->orgname = $return->name;
				$return->type = pg_field_type($this->_result, $column);
				$return->charsetnr = ($return->type == "bytea" ? 63 : 0); // 63 - binary
				return $return;
			}
			
			function __destruct() {
				pg_free_result($this->_result);
			}
		}
		
	} elseif (extension_loaded("pdo_pgsql")) {
		class Min_DB extends Min_PDO {
			var $extension = "PDO_PgSQL";
			
			function connect($server, $username, $password) {
				global $adminer;
				$db = $adminer->database();
				$string = "pgsql:host='" . str_replace(":", "' port='", addcslashes($server, "'\\")) . "' options='-c client_encoding=utf8'";
				$this->dsn("$string dbname='" . ($db != "" ? addcslashes($db, "'\\") : "postgres") . "'", $username, $password);
				//! connect without DB in case of an error
				return true;
			}
			
			function select_db($database) {
				global $adminer;
				return ($adminer->database() == $database);
			}
			
			function close() {
			}
		}
		
	}
	
	function idf_escape($idf) {
		return '"' . str_replace('"', '""', $idf) . '"';
	}

	function table($idf) {
		return idf_escape($idf);
	}

	function connect() {
		global $adminer;
		$connection = new Min_DB;
		$credentials = $adminer->credentials();
		if ($connection->connect($credentials[0], $credentials[1], $credentials[2])) {
			if ($connection->server_info >= 9) {
				$connection->query("SET application_name = 'Adminer'");
			}
			return $connection;
		}
		return $connection->error;
	}
	
	function get_databases() {
		return get_vals("SELECT datname FROM pg_database ORDER BY datname");
	}
	
	function limit($query, $where, $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	function limit1($query, $where) {
		return " $query$where";
	}
	
	function db_collation($db, $collations) {
		global $connection;
		return $connection->result("SHOW LC_COLLATE"); //! respect $db
	}

	function engines() {
		return array();
	}
	
	function logged_user() {
		global $connection;
		return $connection->result("SELECT user");
	}
	
	function tables_list() {
		return get_key_vals("SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema() ORDER BY table_name");
	}
	
	function count_tables($databases) {
		return array(); // would require reconnect
	}

	function table_status($name = "") {
		$return = array();
		foreach (get_rows("SELECT relname AS \"Name\", CASE relkind WHEN 'r' THEN 'table' ELSE 'view' END AS \"Engine\", pg_relation_size(oid) AS \"Data_length\", pg_total_relation_size(oid) - pg_relation_size(oid) AS \"Index_length\", obj_description(oid, 'pg_class') AS \"Comment\", relhasoids::int AS \"Oid\", reltuples as \"Rows\"
FROM pg_class
WHERE relkind IN ('r','v')
AND relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
" . ($name != "" ? "AND relname = " . q($name) : "ORDER BY relname")
		) as $row) { //! Index_length, Auto_increment
			$return[$row["Name"]] = $row;
		}
		return ($name != "" ? $return[$name] : $return);
	}
	
	function is_view($table_status) {
		return $table_status["Engine"] == "view";
	}
	
	function fk_support($table_status) {
		return true;
	}
	
	function fields($table) {
		$return = array();
		$aliases = array(
			'timestamp without time zone' => 'timestamp',
			'timestamp with time zone' => 'timestamptz',
		);
		foreach (get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, d.adsrc AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = " . q($table) . "
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum"
		) as $row) {
			//! collation, primary
			$type = $row["full_type"];
			if (ereg('(.+)\\((.*)\\)$', $row["full_type"], $match)) {
				list(, $type, $row["length"]) = $match;
			}
			$row["type"] = ($aliases[$type] ? $aliases[$type] : $type);
			$row["full_type"] = $row["type"] . ($row["length"] ? "($row[length])" : "");
			$row["null"] = !$row["attnotnull"];
			$row["auto_increment"] = eregi("^nextval\\(", $row["default"]);
			$row["privileges"] = array("insert" => 1, "select" => 1, "update" => 1);
			if (preg_match('~^(.*)::.+$~', $row["default"], $match)) {
				$row["default"] = ($match[1][0] == "'" ? idf_unescape($match[1]) : $match[1]);
			}
			$return[$row["field"]] = $row;
		}
		return $return;
	}
	
	function indexes($table, $connection2 = null) {
		global $connection;
		if (!is_object($connection2)) {
			$connection2 = $connection;
		}
		$return = array();
		$table_oid = $connection2->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($table));
		$columns = get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $table_oid AND attnum > 0", $connection2);
		foreach (get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption FROM pg_index i, pg_class ci WHERE i.indrelid = $table_oid AND ci.oid = i.indexrelid", $connection2) as $row) {
			$relname = $row["relname"];
			$return[$relname]["type"] = ($row["indisprimary"] ? "PRIMARY" : ($row["indisunique"] ? "UNIQUE" : "INDEX"));
			$return[$relname]["columns"] = array();
			foreach (explode(" ", $row["indkey"]) as $indkey) {
				$return[$relname]["columns"][] = $columns[$indkey];
			}
			$return[$relname]["descs"] = array();
			foreach (explode(" ", $row["indoption"]) as $indoption) {
				$return[$relname]["descs"][] = ($indoption & 1 ? '1' : null); // 1 - INDOPTION_DESC
			}
			$return[$relname]["lengths"] = array();
		}
		return $return;
	}
	
	function foreign_keys($table) {
		global $on_actions;
		$return = array();
		foreach (get_rows("SELECT conname, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = " . q($table) . " AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname") as $row) {
			if (preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA', $row['definition'], $match)) {
				$row['source'] = array_map('trim', explode(',', $match[1]));
				$row['table'] = $match[2];
				if (preg_match('~(.+)\.(.+)~', $match[2], $match2)) {
					$row['ns'] = $match2[1];
					$row['table'] = $match2[2];
				}
				$row['target'] = array_map('trim', explode(',', $match[3]));
				$row['on_delete'] = (preg_match("~ON DELETE ($on_actions)~", $match[4], $match2) ? $match2[1] : 'NO ACTION');
				$row['on_update'] = (preg_match("~ON UPDATE ($on_actions)~", $match[4], $match2) ? $match2[1] : 'NO ACTION');
				$return[$row['conname']] = $row;
			}
		}
		return $return;
	}
	
	function view($name) {
		global $connection;
		return array("select" => $connection->result("SELECT pg_get_viewdef(" . q($name) . ")"));
	}
	
	function collations() {
		//! supported in CREATE DATABASE
		return array();
	}
	
	function information_schema($db) {
		return ($db == "information_schema");
	}
	
	function error() {
		global $connection;
		$return = h($connection->error);
		if (preg_match('~^(.*\\n)?([^\\n]*)\\n( *)\\^(\\n.*)?$~s', $return, $match)) {
			$return = $match[1] . preg_replace('~((?:[^&]|&[^;]*;){' . strlen($match[3]) . '})(.*)~', '\\1<b>\\2</b>', $match[2]) . $match[4];
		}
		return nl_br($return);
	}
	
	function create_database($db, $collation) {
		return queries("CREATE DATABASE " . idf_escape($db) . ($collation ? " ENCODING " . idf_escape($collation) : ""));
	}
	
	function drop_databases($databases) {
		global $connection;
		$connection->close();
		return apply_queries("DROP DATABASE", $databases, 'idf_escape');
	}
	
	function rename_database($name, $collation) {
		//! current database cannot be renamed
		return queries("ALTER DATABASE " . idf_escape(DB) . " RENAME TO " . idf_escape($name));
	}
	
	function auto_increment() {
		return "";
	}
	
	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = array();
		$queries = array();
		foreach ($fields as $field) {
			$column = idf_escape($field[0]);
			$val = $field[1];
			if (!$val) {
				$alter[] = "DROP $column";
			} else {
				$val5 = $val[5];
				unset($val[5]);
				if (isset($val[6]) && $field[0] == "") { // auto_increment
					$val[1] = ($val[1] == "bigint" ? " big" : " ") . "serial";
				}
				if ($field[0] == "") {
					$alter[] = ($table != "" ? "ADD " : "  ") . implode($val);
				} else {
					if ($column != $val[0]) {
						$queries[] = "ALTER TABLE " . table($table) . " RENAME $column TO $val[0]";
					}
					$alter[] = "ALTER $column TYPE$val[1]";
					if (!$val[6]) {
						$alter[] = "ALTER $column " . ($val[3] ? "SET$val[3]" : "DROP DEFAULT"); //! quoting
						$alter[] = "ALTER $column " . ($val[2] == " NULL" ? "DROP NOT" : "SET") . $val[2];
					}
				}
				if ($field[0] != "" || $val5 != "") {
					$queries[] = "COMMENT ON COLUMN " . table($table) . ".$val[0] IS " . ($val5 != "" ? substr($val5, 9) : "''");
				}
			}
		}
		$alter = array_merge($alter, $foreign);
		if ($table == "") {
			array_unshift($queries, "CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)");
		} elseif ($alter) {
			array_unshift($queries, "ALTER TABLE " . table($table) . "\n" . implode(",\n", $alter));
		}
		if ($table != "" && $table != $name) {
			$queries[] = "ALTER TABLE " . table($table) . " RENAME TO " . table($name);
		}
		if ($table != "" || $comment != "") {
			$queries[] = "COMMENT ON TABLE " . table($name) . " IS " . q($comment);
		}
		if ($auto_increment != "") {
			//! $queries[] = "SELECT setval(pg_get_serial_sequence(" . q($name) . ", ), $auto_increment)";
		}
		foreach ($queries as $query) {
			if (!queries($query)) {
				return false;
			}
		}
		return true;
	}
	
	function alter_indexes($table, $alter) {
		$create = array();
		$drop = array();
		$queries = array();
		foreach ($alter as $val) {
			if ($val[0] != "INDEX") {
				//! descending UNIQUE indexes results in syntax error
				$create[] = ($val[2] == "DROP"
					? "\nDROP CONSTRAINT " . idf_escape($val[1])
					: "\nADD" . ($val[1] != "" ? " CONSTRAINT " . idf_escape($val[1]) : "") . " $val[0] " . ($val[0] == "PRIMARY" ? "KEY " : "") . $val[2]
				);
			} elseif ($val[2] == "DROP") {
				$drop[] = idf_escape($val[1]);
			} else {
				$queries[] = "CREATE INDEX " . idf_escape($val[1] != "" ? $val[1] : uniqid($table . "_")) . " ON " . table($table) . " $val[2]";
			}
		}
		if ($create) {
			array_unshift($queries, "ALTER TABLE " . table($table) . implode(",", $create));
		}
		if ($drop) {
			array_unshift($queries, "DROP INDEX " . implode(", ", $drop));
		}
		foreach ($queries as $query) {
			if (!queries($query)) {
				return false;
			}
		}
		return true;
	}
	
	function truncate_tables($tables) {
		return queries("TRUNCATE " . implode(", ", array_map('table', $tables)));
		return true;
	}
	
	function drop_views($views) {
		return queries("DROP VIEW " . implode(", ", array_map('table', $views)));
	}
	
	function drop_tables($tables) {
		return queries("DROP TABLE " . implode(", ", array_map('table', $tables)));
	}
	
	function move_tables($tables, $views, $target) {
		foreach ($tables as $table) {
			if (!queries("ALTER TABLE " . table($table) . " SET SCHEMA " . idf_escape($target))) {
				return false;
			}
		}
		foreach ($views as $table) {
			if (!queries("ALTER VIEW " . table($table) . " SET SCHEMA " . idf_escape($target))) {
				return false;
			}
		}
		return true;
	}
	
	function trigger($name) {
		if ($name == "") {
			return array("Statement" => "EXECUTE PROCEDURE ()");
		}
		$rows = get_rows('SELECT trigger_name AS "Trigger", condition_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers WHERE event_object_table = ' . q($_GET["trigger"]) . ' AND trigger_name = ' . q($name));
		return reset($rows);
	}
	
	function triggers($table) {
		$return = array();
		foreach (get_rows("SELECT * FROM information_schema.triggers WHERE event_object_table = " . q($table)) as $row) {
			$return[$row["trigger_name"]] = array($row["condition_timing"], $row["event_manipulation"]);
		}
		return $return;
	}
	
	function trigger_options() {
		return array(
			"Timing" => array("BEFORE", "AFTER"),
			"Type" => array("FOR EACH ROW", "FOR EACH STATEMENT"),
		);
	}
	
	/*
	function routine($name, $type) {
		//! there can be more functions with the same name differing only in parameters, it must be also passed to DROP FUNCTION
		//! no procedures, only functions
		//! different syntax of CREATE FUNCTION
		$rows = get_rows('SELECT pg_catalog.format_type(p.prorettype, NULL) AS "returns", p.prosrc AS "definition"
FROM pg_catalog.pg_namespace n
JOIN pg_catalog.pg_proc p ON p.pronamespace = n.oid
WHERE n.nspname = current_schema() AND p.proname = ' . q($name));
		$rows[0]["fields"] = array(); //!
		return $rows[0];
	}
	*/
	
	function routines() {
		return get_rows('SELECT p.proname AS "ROUTINE_NAME", p.proargtypes AS "ROUTINE_TYPE", pg_catalog.format_type(p.prorettype, NULL) AS "DTD_IDENTIFIER"
FROM pg_catalog.pg_namespace n
JOIN pg_catalog.pg_proc p ON p.pronamespace = n.oid
WHERE n.nspname = current_schema()
ORDER BY p.proname');
	}
	
	function routine_languages() {
		return get_vals("SELECT langname FROM pg_catalog.pg_language");
	}
	
	function begin() {
		return queries("BEGIN");
	}
	
	function insert_into($table, $set) {
		return queries("INSERT INTO " . table($table) . ($set ? " (" . implode(", ", array_keys($set)) . ")\nVALUES (" . implode(", ", $set) . ")" : "DEFAULT VALUES"));
	}
	
	function insert_update($table, $set, $primary) {
		global $connection;
		$update = array();
		$where = array();
		foreach ($set as $key => $val) {
			$update[] = "$key = $val";
			if (isset($primary[idf_unescape($key)])) {
				$where[] = "$key = $val";
			}
		}
		return ($where && queries("UPDATE " . table($table) . " SET " . implode(", ", $update) . " WHERE " . implode(" AND ", $where)) && $connection->affected_rows)
			|| queries("INSERT INTO " . table($table) . " (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ")")
		;
	}
	
	function last_id() {
		return 0; // there can be several sequences
	}
	
	function explain($connection, $query) {
		return $connection->query("EXPLAIN $query");
	}
	
	function found_rows($table_status, $where) {
		global $connection;
		if (ereg(
			" rows=([0-9]+)",
			$connection->result("EXPLAIN SELECT * FROM " . idf_escape($table_status["Name"]) . ($where ? " WHERE " . implode(" AND ", $where) : "")),
			$regs
		)) {
			return $regs[1];
		}
		return false;
	}
	
	function types() {
		return get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0"
		);
	}
	
	function schemas() {
		return get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");
	}
	
	function get_schema() {
		global $connection;
		return $connection->result("SELECT current_schema()");
	}
	
	function set_schema($schema) {
		global $connection, $types, $structured_types;
		$return = $connection->query("SET search_path TO " . idf_escape($schema));
		foreach (types() as $type) { //! get types from current_schemas('t')
			if (!isset($types[$type])) {
				$types[$type] = 0;
				$structured_types[lang(13)][] = $type;
			}
		}
		return $return;
	}
	
	function use_sql($database) {
		return "\connect " . idf_escape($database);
	}
	
	function show_variables() {
		return get_key_vals("SHOW ALL");
	}

	function process_list() {
		global $connection;
		return get_rows("SELECT * FROM pg_stat_activity ORDER BY " . ($connection->server_info < 9.2 ? "procpid" : "pid"));
	}
	
	function show_status() {
	}
	
	function convert_field($field) {
	}
	
	function unconvert_field($field, $return) {
		return $return;
	}
	
	function support($feature) {
		return ereg('^(comment|view|scheme|processlist|sequence|trigger|type|variables|drop_col)$', $feature); //! routine|
	}
	
	$jush = "pgsql";
	$types = array();
	$structured_types = array();
	foreach (array( //! arrays
		lang(14) => array("smallint" => 5, "integer" => 10, "bigint" => 19, "boolean" => 1, "numeric" => 0, "real" => 7, "double precision" => 16, "money" => 20),
		lang(15) => array("date" => 13, "time" => 17, "timestamp" => 20, "timestamptz" => 21, "interval" => 0),
		lang(16) => array("character" => 0, "character varying" => 0, "text" => 0, "tsquery" => 0, "tsvector" => 0, "uuid" => 0, "xml" => 0),
		lang(17) => array("bit" => 0, "bit varying" => 0, "bytea" => 0),
		lang(18) => array("cidr" => 43, "inet" => 43, "macaddr" => 17, "txid_snapshot" => 0),
		lang(19) => array("box" => 0, "circle" => 0, "line" => 0, "lseg" => 0, "path" => 0, "point" => 0, "polygon" => 0),
	) as $key => $val) { //! can be retrieved from pg_type
		$types += $val;
		$structured_types[$key] = array_keys($val);
	}
	$unsigned = array();
	$operators = array("=", "<", ">", "<=", ">=", "!=", "~", "!~", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL"); // no "SQL" to avoid SQL injection
	$functions = array("char_length", "lower", "round", "to_hex", "to_timestamp", "upper");
	$grouping = array("avg", "count", "count distinct", "max", "min", "sum");
	$edit_functions = array(
		array(
			"char" => "md5",
			"date|time" => "now",
		), array(
			"int|numeric|real|money" => "+/-",
			"date|time" => "+ interval/- interval", //! escape
			"char|text" => "||",
		)
	);
}


$drivers["oracle"] = "Oracle";

if (isset($_GET["oracle"])) {
	$possible_drivers = array("OCI8", "PDO_OCI");
	define("DRIVER", "oracle");
	if (extension_loaded("oci8")) {
		class Min_DB {
			var $extension = "oci8", $_link, $_result, $server_info, $affected_rows, $errno, $error;

			function _error($errno, $error) {
				if (ini_bool("html_errors")) {
					$error = html_entity_decode(strip_tags($error));
				}
				$error = ereg_replace('^[^:]*: ', '', $error);
				$this->error = $error;
			}
			
			function connect($server, $username, $password) {
				$this->_link = @oci_new_connect($username, $password, $server, "AL32UTF8");
				if ($this->_link) {
					$this->server_info = oci_server_version($this->_link);
					return true;
				}
				$error = oci_error();
				$this->error = $error["message"];
				return false;
			}

			function quote($string) {
				return "'" . str_replace("'", "''", $string) . "'";
			}

			function select_db($database) {
				return true;
			}

			function query($query, $unbuffered = false) {
				$result = oci_parse($this->_link, $query);
				$this->error = "";
				if (!$result) {
					$error = oci_error($this->_link);
					$this->errno = $error["code"];
					$this->error = $error["message"];
					return false;
				}
				set_error_handler(array($this, '_error'));
				$return = @oci_execute($result);
				restore_error_handler();
				if ($return) {
					if (oci_num_fields($result)) {
						return new Min_Result($result);
					}
					$this->affected_rows = oci_num_rows($result);
				}
				return $return;
			}

			function multi_query($query) {
				return $this->_result = $this->query($query);
			}
			
			function store_result() {
				return $this->_result;
			}
			
			function next_result() {
				return false;
			}
			
			function result($query, $field = 1) {
				$result = $this->query($query);
				if (!is_object($result) || !oci_fetch($result->_result)) {
					return false;
				}
				return oci_result($result->_result, $field);
			}
		}

		class Min_Result {
			var $_result, $_offset = 1, $num_rows;

			function Min_Result($result) {
				$this->_result = $result;
			}

			function _convert($row) {
				foreach ((array) $row as $key => $val) {
					if (is_a($val, 'OCI-Lob')) {
						$row[$key] = $val->load();
					}
				}
				return $row;
			}
			
			function fetch_assoc() {
				return $this->_convert(oci_fetch_assoc($this->_result));
			}

			function fetch_row() {
				return $this->_convert(oci_fetch_row($this->_result));
			}

			function fetch_field() {
				$column = $this->_offset++;
				$return = new stdClass;
				$return->name = oci_field_name($this->_result, $column);
				$return->orgname = $return->name;
				$return->type = oci_field_type($this->_result, $column);
				$return->charsetnr = (ereg("raw|blob|bfile", $return->type) ? 63 : 0); // 63 - binary
				return $return;
			}
			
			function __destruct() {
				oci_free_statement($this->_result);
			}
		}
		
	} elseif (extension_loaded("pdo_oci")) {
		class Min_DB extends Min_PDO {
			var $extension = "PDO_OCI";
			
			function connect($server, $username, $password) {
				$this->dsn("oci:dbname=//$server;charset=AL32UTF8", $username, $password);
				return true;
			}
			
			function select_db($database) {
				return true;
			}
		}
		
	}
	
	function idf_escape($idf) {
		return '"' . str_replace('"', '""', $idf) . '"';
	}

	function table($idf) {
		return idf_escape($idf);
	}

	function connect() {
		global $adminer;
		$connection = new Min_DB;
		$credentials = $adminer->credentials();
		if ($connection->connect($credentials[0], $credentials[1], $credentials[2])) {
			return $connection;
		}
		return $connection->error;
	}

	function get_databases() {
		return get_vals("SELECT tablespace_name FROM user_tablespaces");
	}

	function limit($query, $where, $limit, $offset = 0, $separator = " ") {
		return ($offset ? " * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $query$where) t WHERE rownum <= " . ($limit + $offset) . ") WHERE rnum > $offset"
			: ($limit !== null ? " * FROM (SELECT $query$where) WHERE rownum <= " . ($limit + $offset)
			: " $query$where"
		));
	}

	function limit1($query, $where) {
		return " $query$where";
	}

	function db_collation($db, $collations) {
		global $connection;
		return $connection->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'"); //! respect $db
	}

	function engines() {
		return array();
	}

	function logged_user() {
		global $connection;
		return $connection->result("SELECT USER FROM DUAL");
	}

	function tables_list() {
		return get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = " . q(DB) . "
UNION SELECT view_name, 'view' FROM user_views
ORDER BY 1"
		); //! views don't have schema
	}

	function count_tables($databases) {
		return array();
	}
	
	function table_status($name = "") {
		$return = array();
		$search = q($name);
		foreach (get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = ' . q(DB) . ($name != "" ? " AND table_name = $search" : "") . "
UNION SELECT view_name, 'view', 0, 0 FROM user_views" . ($name != "" ? " WHERE view_name = $search" : "") . "
ORDER BY 1"
		) as $row) {
			if ($name != "") {
				return $row;
			}
			$return[$row["Name"]] = $row;
		}
		return $return;
	}

	function is_view($table_status) {
		return $table_status["Engine"] == "view";
	}
	
	function fk_support($table_status) {
		return true;
	}

	function fields($table) {
		$return = array();
		foreach (get_rows("SELECT * FROM all_tab_columns WHERE table_name = " . q($table) . " ORDER BY column_id") as $row) {
			$type = $row["DATA_TYPE"];
			$length = "$row[DATA_PRECISION],$row[DATA_SCALE]";
			if ($length == ",") {
				$length = $row["DATA_LENGTH"];
			} //! int
			$return[$row["COLUMN_NAME"]] = array(
				"field" => $row["COLUMN_NAME"],
				"full_type" => $type . ($length ? "($length)" : ""),
				"type" => strtolower($type),
				"length" => $length,
				"default" => $row["DATA_DEFAULT"],
				"null" => ($row["NULLABLE"] == "Y"),
				//! "auto_increment" => false,
				//! "collation" => $row["CHARACTER_SET_NAME"],
				"privileges" => array("insert" => 1, "select" => 1, "update" => 1),
				//! "comment" => $row["Comment"],
				//! "primary" => ($row["Key"] == "PRI"),
			);
		}
		return $return;
	}

	function indexes($table, $connection2 = null) {
		$return = array();
		foreach (get_rows("SELECT uic.*, uc.constraint_type
FROM user_ind_columns uic
LEFT JOIN user_constraints uc ON uic.index_name = uc.constraint_name AND uic.table_name = uc.table_name
WHERE uic.table_name = " . q($table) . "
ORDER BY uc.constraint_type, uic.column_position", $connection2) as $row) {
			$index_name = $row["INDEX_NAME"];
			$return[$index_name]["type"] = ($row["CONSTRAINT_TYPE"] == "P" ? "PRIMARY" : ($row["CONSTRAINT_TYPE"] == "U" ? "UNIQUE" : "INDEX"));
			$return[$index_name]["columns"][] = $row["COLUMN_NAME"];
			$return[$index_name]["lengths"][] = ($row["CHAR_LENGTH"] && $row["CHAR_LENGTH"] != $row["COLUMN_LENGTH"] ? $row["CHAR_LENGTH"] : null);
			$return[$index_name]["descs"][] = ($row["DESCEND"] ? '1' : null);
		}
		return $return;
	}

	function view($name) {
		$rows = get_rows('SELECT text "select" FROM user_views WHERE view_name = ' . q($name));
		return reset($rows);
	}
	
	function collations() {
		return array(); //!
	}

	function information_schema($db) {
		return false;
	}

	function error() {
		global $connection;
		return h($connection->error); //! highlight sqltext from offset
	}
	
	function explain($connection, $query) {
		$connection->query("EXPLAIN PLAN FOR $query");
		return $connection->query("SELECT * FROM plan_table");
	}
	
	function found_rows($table_status, $where) {
	}
	
	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = $drop = array();
		foreach ($fields as $field) {
			$val = $field[1];
			if ($val && $field[0] != "" && idf_escape($field[0]) != $val[0]) {
				queries("ALTER TABLE " . table($table) . " RENAME COLUMN " . idf_escape($field[0]) . " TO $val[0]");
			}
			if ($val) {
				$alter[] = ($table != "" ? ($field[0] != "" ? "MODIFY (" : "ADD (") : "  ") . implode($val) . ($table != "" ? ")" : ""); //! error with name change only
			} else {
				$drop[] = idf_escape($field[0]);
			}
		}
		if ($table == "") {
			return queries("CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)");
		}
		return (!$alter || queries("ALTER TABLE " . table($table) . "\n" . implode("\n", $alter)))
			&& (!$drop || queries("ALTER TABLE " . table($table) . " DROP (" . implode(", ", $drop) . ")"))
			&& ($table == $name || queries("ALTER TABLE " . table($table) . " RENAME TO " . table($name)))
		;
	}
	
	function foreign_keys($table) {
		return array(); //!
	}
	
	function truncate_tables($tables) {
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	function drop_views($views) {
		return apply_queries("DROP VIEW", $views);
	}

	function drop_tables($tables) {
		return apply_queries("DROP TABLE", $tables);
	}

	function begin() {
		return true; // automatic start
	}
	
	function insert_into($table, $set) {
		return queries("INSERT INTO " . table($table) . " (" . implode(", ", array_keys($set)) . ")\nVALUES (" . implode(", ", $set) . ")"); //! no columns
	}
	
	function last_id() {
		return 0; //!
	}
	
	function schemas() {
		return get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX'))");
	}
	
	function get_schema() {
		global $connection;
		return $connection->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");
	}
	
	function set_schema($scheme) {
		global $connection;
		return $connection->query("ALTER SESSION SET CURRENT_SCHEMA = " . idf_escape($scheme));
	}
	
	function show_variables() {
		return get_key_vals('SELECT name, display_value FROM v$parameter');
	}
	
	function process_list() {
		return get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');
	}
	
	function show_status() {
		$rows = get_rows('SELECT * FROM v$instance');
		return reset($rows);
	}
	
	function convert_field($field) {
	}
	
	function unconvert_field($field, $return) {
		return $return;
	}
	
	function support($feature) {
		return ereg("view|scheme|processlist|drop_col|variables|status", $feature); //!
	}
	
	$jush = "oracle";
	$types = array();
	$structured_types = array();
	foreach (array(
		lang(14) => array("number" => 38, "binary_float" => 12, "binary_double" => 21),
		lang(15) => array("date" => 10, "timestamp" => 29, "interval year" => 12, "interval day" => 28), //! year(), day() to second()
		lang(16) => array("char" => 2000, "varchar2" => 4000, "nchar" => 2000, "nvarchar2" => 4000, "clob" => 4294967295, "nclob" => 4294967295),
		lang(17) => array("raw" => 2000, "long raw" => 2147483648, "blob" => 4294967295, "bfile" => 4294967296),
	) as $key => $val) {
		$types += $val;
		$structured_types[$key] = array_keys($val);
	}
	$unsigned = array();
	$operators = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL");
	$functions = array("length", "lower", "round", "upper");
	$grouping = array("avg", "count", "count distinct", "max", "min", "sum");
	$edit_functions = array(
		array( //! no parentheses
			"date" => "current_date",
			"timestamp" => "current_timestamp",
		), array(
			"number|float|double" => "+/-",
			"date|timestamp" => "+ interval/- interval",
			"char|clob" => "||",
		)
	);
}


/**
* @author Jakub Cernohuby
* @author Vladimir Stastka
* @author Jakub Vrana
*/

$drivers["mssql"] = "MS SQL";

if (isset($_GET["mssql"])) {
	$possible_drivers = array("SQLSRV", "MSSQL");
	define("DRIVER", "mssql");
	if (extension_loaded("sqlsrv")) {
		class Min_DB {
			var $extension = "sqlsrv", $_link, $_result, $server_info, $affected_rows, $errno, $error;

			function _get_error() {
				$this->error = "";
				foreach (sqlsrv_errors() as $error) {
					$this->errno = $error["code"];
					$this->error .= "$error[message]\n";
				}
				$this->error = rtrim($this->error);
			}

			function connect($server, $username, $password) {
				$this->_link = @sqlsrv_connect($server, array("UID" => $username, "PWD" => $password, "CharacterSet" => "UTF-8"));
				if ($this->_link) {
					$info = sqlsrv_server_info($this->_link);
					$this->server_info = $info['SQLServerVersion'];
				} else {
					$this->_get_error();
				}
				return (bool) $this->_link;
			}

			function quote($string) {
				return "'" . str_replace("'", "''", $string) . "'";
			}

			function select_db($database) {
				return $this->query("USE " . idf_escape($database));
			}

			function query($query, $unbuffered = false) {
				$result = sqlsrv_query($this->_link, $query); //! , array(), ($unbuffered ? array() : array("Scrollable" => "keyset"))
				$this->error = "";
				if (!$result) {
					$this->_get_error();
					return false;
				}
				return $this->store_result($result);
			}

			function multi_query($query) {
				$this->_result = sqlsrv_query($this->_link, $query);
				$this->error = "";
				if (!$this->_result) {
					$this->_get_error();
					return false;
				}
				return true;
			}

			function store_result($result = null) {
				if (!$result) {
					$result = $this->_result;
				}
				if (sqlsrv_field_metadata($result)) {
					return new Min_Result($result);
				}
				$this->affected_rows = sqlsrv_rows_affected($result);
				return true;
			}

			function next_result() {
				return sqlsrv_next_result($this->_result);
			}

			function result($query, $field = 0) {
				$result = $this->query($query);
				if (!is_object($result)) {
					return false;
				}
				$row = $result->fetch_row();
				return $row[$field];
			}
		}

		class Min_Result {
			var $_result, $_offset = 0, $_fields, $num_rows;

			function Min_Result($result) {
				$this->_result = $result;
				// $this->num_rows = sqlsrv_num_rows($result); // available only in scrollable results
			}

			function _convert($row) {
				foreach ((array) $row as $key => $val) {
					if (is_a($val, 'DateTime')) {
						$row[$key] = $val->format("Y-m-d H:i:s");
					}
					//! stream
				}
				return $row;
			}
			
			function fetch_assoc() {
				return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_ASSOC, SQLSRV_SCROLL_NEXT));
			}

			function fetch_row() {
				return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_NUMERIC, SQLSRV_SCROLL_NEXT));
			}

			function fetch_field() {
				if (!$this->_fields) {
					$this->_fields = sqlsrv_field_metadata($this->_result);
				}
				$field = $this->_fields[$this->_offset++];
				$return = new stdClass;
				$return->name = $field["Name"];
				$return->orgname = $field["Name"];
				$return->type = ($field["Type"] == 1 ? 254 : 0);
				return $return;
			}
			
			function seek($offset) {
				for ($i=0; $i < $offset; $i++) {
					sqlsrv_fetch($this->_result); // SQLSRV_SCROLL_ABSOLUTE added in sqlsrv 1.1
				}
			}

			function __destruct() {
				sqlsrv_free_stmt($this->_result);
			}
		}
		
	} elseif (extension_loaded("mssql")) {
		class Min_DB {
			var $extension = "MSSQL", $_link, $_result, $server_info, $affected_rows, $error;

			function connect($server, $username, $password) {
				$this->_link = @mssql_connect($server, $username, $password);
				if ($this->_link) {
					$result = $this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");
					$row = $result->fetch_row();
					$this->server_info = $this->result("sp_server_info 2", 2) . " [$row[0]] $row[1]";
				} else {
					$this->error = mssql_get_last_message();
				}
				return (bool) $this->_link;
			}

			function quote($string) {
				return "'" . str_replace("'", "''", $string) . "'";
			}

			function select_db($database) {
				return mssql_select_db($database);
			}

			function query($query, $unbuffered = false) {
				$result = mssql_query($query, $this->_link); //! $unbuffered
				$this->error = "";
				if (!$result) {
					$this->error = mssql_get_last_message();
					return false;
				}
				if ($result === true) {
					$this->affected_rows = mssql_rows_affected($this->_link);
					return true;
				}
				return new Min_Result($result);
			}

			function multi_query($query) {
				return $this->_result = $this->query($query);
			}

			function store_result() {
				return $this->_result;
			}

			function next_result() {
				return mssql_next_result($this->_result);
			}

			function result($query, $field = 0) {
				$result = $this->query($query);
				if (!is_object($result)) {
					return false;
				}
				return mssql_result($result->_result, 0, $field);
			}
		}

		class Min_Result {
			var $_result, $_offset = 0, $_fields, $num_rows;

			function Min_Result($result) {
				$this->_result = $result;
				$this->num_rows = mssql_num_rows($result);
			}

			function fetch_assoc() {
				return mssql_fetch_assoc($this->_result);
			}

			function fetch_row() {
				return mssql_fetch_row($this->_result);
			}

			function num_rows() {
				return mssql_num_rows($this->_result);
			}

			function fetch_field() {
				$return = mssql_fetch_field($this->_result);
				$return->orgtable = $return->table;
				$return->orgname = $return->name;
				return $return;
			}

			function seek($offset) {
				mssql_data_seek($this->_result, $offset);
			}
			
			function __destruct() {
				mssql_free_result($this->_result);
			}
		}
		
	}

	function idf_escape($idf) {
		return "[" . str_replace("]", "]]", $idf) . "]";
	}

	function table($idf) {
		return ($_GET["ns"] != "" ? idf_escape($_GET["ns"]) . "." : "") . idf_escape($idf);
	}

	function connect() {
		global $adminer;
		$connection = new Min_DB;
		$credentials = $adminer->credentials();
		if ($connection->connect($credentials[0], $credentials[1], $credentials[2])) {
			return $connection;
		}
		return $connection->error;
	}

	function get_databases() {
		return get_vals("EXEC sp_databases");
	}

	function limit($query, $where, $limit, $offset = 0, $separator = " ") {
		return ($limit !== null ? " TOP (" . ($limit + $offset) . ")" : "") . " $query$where"; // seek later
	}

	function limit1($query, $where) {
		return limit($query, $where, 1);
	}

	function db_collation($db, $collations) {
		global $connection;
		return $connection->result("SELECT collation_name FROM sys.databases WHERE name =  " . q($db));
	}

	function engines() {
		return array();
	}

	function logged_user() {
		global $connection;
		return $connection->result("SELECT SUSER_NAME()");
	}

	function tables_list() {
		return get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') ORDER BY name");
	}

	function count_tables($databases) {
		global $connection;
		$return = array();
		foreach ($databases as $db) {
			$connection->select_db($db);
			$return[$db] = $connection->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");
		}
		return $return;
	}
	
	function table_status($name = "") {
		$return = array();
		foreach (get_rows("SELECT name AS Name, type_desc AS Engine FROM sys.all_objects WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') " . ($name != "" ? "AND name = " . q($name) : "ORDER BY name")) as $row) {
			if ($name != "") {
				return $row;
			}
			$return[$row["Name"]] = $row;
		}
		return $return;
	}

	function is_view($table_status) {
		return $table_status["Engine"] == "VIEW";
	}
	
	function fk_support($table_status) {
		return true;
	}

	function fields($table) {
		$return = array();
		foreach (get_rows("SELECT c.*, t.name type, d.definition [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND o.type IN ('S', 'U', 'V') AND o.name = " . q($table)
		) as $row) {
			$type = $row["type"];
			$length = (ereg("char|binary", $type) ? $row["max_length"] : ($type == "decimal" ? "$row[precision],$row[scale]" : ""));
			$return[$row["name"]] = array(
				"field" => $row["name"],
				"full_type" => $type . ($length ? "($length)" : ""),
				"type" => $type,
				"length" => $length,
				"default" => $row["default"],
				"null" => $row["is_nullable"],
				"auto_increment" => $row["is_identity"],
				"collation" => $row["collation_name"],
				"privileges" => array("insert" => 1, "select" => 1, "update" => 1),
				"primary" => $row["is_identity"], //! or indexes.is_primary_key
			);
		}
		return $return;
	}

	function indexes($table, $connection2 = null) {
		$return = array();
		// sp_statistics doesn't return information about primary key
		foreach (get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = " . q($table)
		, $connection2) as $row) {
			$name = $row["name"];
			$return[$name]["type"] = ($row["is_primary_key"] ? "PRIMARY" : ($row["is_unique"] ? "UNIQUE" : "INDEX"));
			$return[$name]["lengths"] = array();
			$return[$name]["columns"][$row["key_ordinal"]] = $row["column_name"];
			$return[$name]["descs"][$row["key_ordinal"]] = ($row["is_descending_key"] ? '1' : null);
		}
		return $return;
	}

	function view($name) {
		global $connection;
		return array("select" => preg_replace('~^(?:[^[]|\\[[^]]*])*\\s+AS\\s+~isU', '', $connection->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = " . q($name))));
	}
	
	function collations() {
		$return = array();
		foreach (get_vals("SELECT name FROM fn_helpcollations()") as $collation) {
			$return[ereg_replace("_.*", "", $collation)][] = $collation;
		}
		return $return;
	}

	function information_schema($db) {
		return false;
	}

	function error() {
		global $connection;
		return nl_br(h(preg_replace('~^(\\[[^]]*])+~m', '', $connection->error)));
	}
	
	function create_database($db, $collation) {
		return queries("CREATE DATABASE " . idf_escape($db) . (eregi('^[a-z0-9_]+$', $collation) ? " COLLATE $collation" : ""));
	}
	
	function drop_databases($databases) {
		return queries("DROP DATABASE " . implode(", ", array_map('idf_escape', $databases)));
	}
	
	function rename_database($name, $collation) {
		if (eregi('^[a-z0-9_]+$', $collation)) {
			queries("ALTER DATABASE " . idf_escape(DB) . " COLLATE $collation");
		}
		queries("ALTER DATABASE " . idf_escape(DB) . " MODIFY NAME = " . idf_escape($name));
		return true; //! false negative "The database name 'test2' has been set."
	}

	function auto_increment() {
		return " IDENTITY" . ($_POST["Auto_increment"] != "" ? "(" . (+$_POST["Auto_increment"]) . ",1)" : "") . " PRIMARY KEY";
	}
	
	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = array();
		foreach ($fields as $field) {
			$column = idf_escape($field[0]);
			$val = $field[1];
			if (!$val) {
				$alter["DROP"][] = " COLUMN $column";
			} else {
				$val[1] = preg_replace("~( COLLATE )'(\\w+)'~", "\\1\\2", $val[1]);
				if ($field[0] == "") {
					$alter["ADD"][] = "\n  " . implode("", $val) . ($table == "" ? substr($foreign[$val[0]], 16 + strlen($val[0])) : ""); // 16 - strlen("  FOREIGN KEY ()")
				} else {
					unset($val[6]); //! identity can't be removed
					if ($column != $val[0]) {
						queries("EXEC sp_rename " . q(table($table) . ".$column") . ", " . q(idf_unescape($val[0])) . ", 'COLUMN'");
					}
					$alter["ALTER COLUMN " . implode("", $val)][] = "";
				}
			}
		}
		if ($table == "") {
			return queries("CREATE TABLE " . table($name) . " (" . implode(",", (array) $alter["ADD"]) . "\n)");
		}
		if ($table != $name) {
			queries("EXEC sp_rename " . q(table($table)) . ", " . q($name));
		}
		if ($foreign) {
			$alter[""] = $foreign;
		}
		foreach ($alter as $key => $val) {
			if (!queries("ALTER TABLE " . idf_escape($name) . " $key" . implode(",", $val))) {
				return false;
			}
		}
		return true;
	}
	
	function alter_indexes($table, $alter) {
		$index = array();
		$drop = array();
		foreach ($alter as $val) {
			if ($val[2] == "DROP") {
				if ($val[0] == "PRIMARY") { //! sometimes used also for UNIQUE
					$drop[] = idf_escape($val[1]);
				} else {
					$index[] = idf_escape($val[1]) . " ON " . table($table);
				}
			} elseif (!queries(($val[0] != "PRIMARY"
				? "CREATE $val[0] " . ($val[0] != "INDEX" ? "INDEX " : "") . idf_escape($val[1] != "" ? $val[1] : uniqid($table . "_")) . " ON " . table($table)
				: "ALTER TABLE " . table($table) . " ADD PRIMARY KEY"
			) . " $val[2]")) {
				return false;
			}
		}
		return (!$index || queries("DROP INDEX " . implode(", ", $index)))
			&& (!$drop || queries("ALTER TABLE " . table($table) . " DROP " . implode(", ", $drop)))
		;
	}
	
	function begin() {
		return queries("BEGIN TRANSACTION");
	}
	
	function insert_into($table, $set) {
		return queries("INSERT INTO " . table($table) . ($set ? " (" . implode(", ", array_keys($set)) . ")\nVALUES (" . implode(", ", $set) . ")" : "DEFAULT VALUES"));
	}
	
	function insert_update($table, $set, $primary) {
		$update = array();
		$where = array();
		foreach ($set as $key => $val) {
			$update[] = "$key = $val";
			if (isset($primary[idf_unescape($key)])) {
				$where[] = "$key = $val";
			}
		}
		// can use only one query for all rows with different API
		return queries("MERGE " . table($table) . " USING (VALUES(" . implode(", ", $set) . ")) AS source (c" . implode(", c", range(1, count($set))) . ") ON " . implode(" AND ", $where) //! source, c1 - possible conflict
			. " WHEN MATCHED THEN UPDATE SET " . implode(", ", $update)
			. " WHEN NOT MATCHED THEN INSERT (" . implode(", ", array_keys($set)) . ") VALUES (" . implode(", ", $set) . ");" // ; is mandatory
		);
	}
	
	function last_id() {
		global $connection;
		return $connection->result("SELECT SCOPE_IDENTITY()"); // @@IDENTITY can return trigger INSERT
	}
	
	function explain($connection, $query) {
		$connection->query("SET SHOWPLAN_ALL ON");
		$return = $connection->query($query);
		$connection->query("SET SHOWPLAN_ALL OFF"); // connection is used also for indexes
		return $return;
	}
	
	function found_rows($table_status, $where) {
	}
	
	function foreign_keys($table) {
		$return = array();
		foreach (get_rows("EXEC sp_fkeys @fktable_name = " . q($table)) as $row) {
			$foreign_key = &$return[$row["FK_NAME"]];
			$foreign_key["table"] = $row["PKTABLE_NAME"];
			$foreign_key["source"][] = $row["FKCOLUMN_NAME"];
			$foreign_key["target"][] = $row["PKCOLUMN_NAME"];
		}
		return $return;
	}

	function truncate_tables($tables) {
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	function drop_views($views) {
		return queries("DROP VIEW " . implode(", ", array_map('table', $views)));
	}

	function drop_tables($tables) {
		return queries("DROP TABLE " . implode(", ", array_map('table', $tables)));
	}

	function move_tables($tables, $views, $target) {
		return apply_queries("ALTER SCHEMA " . idf_escape($target) . " TRANSFER", array_merge($tables, $views));
	}
	
	function trigger($name) {
		if ($name == "") {
			return array();
		}
		$rows = get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = " . q($name)
		); // triggers are not schema-scoped
		$return = reset($rows);
		if ($return) {
			$return["Statement"] = preg_replace('~^.+\\s+AS\\s+~isU', '', $return["text"]); //! identifiers, comments
		}
		return $return;
	}
	
	function triggers($table) {
		$return = array();
		foreach (get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = " . q($table)
		) as $row) { // triggers are not schema-scoped
			$return[$row["name"]] = array($row["Timing"], $row["Event"]);
		}
		return $return;
	}
	
	function trigger_options() {
		return array(
			"Timing" => array("AFTER", "INSTEAD OF"),
			"Type" => array("AS"),
		);
	}
	
	function schemas() {
		return get_vals("SELECT name FROM sys.schemas");
	}
	
	function get_schema() {
		global $connection;
		if ($_GET["ns"] != "") {
			return $_GET["ns"];
		}
		return $connection->result("SELECT SCHEMA_NAME()");
	}
	
	function set_schema($schema) {
		return true; // ALTER USER is permanent
	}
	
	function use_sql($database) {
		return "USE " . idf_escape($database);
	}
	
	function show_variables() {
		return array();
	}
	
	function show_status() {
		return array();
	}

	function convert_field($field) {
	}
	
	function unconvert_field($field, $return) {
		return $return;
	}
	
	function support($feature) {
		return ereg('^(scheme|trigger|view|drop_col)$', $feature); //! routine|
	}
	
	$jush = "mssql";
	$types = array();
	$structured_types = array();
	foreach (array( //! use sys.types
		lang(14) => array("tinyint" => 3, "smallint" => 5, "int" => 10, "bigint" => 20, "bit" => 1, "decimal" => 0, "real" => 12, "float" => 53, "smallmoney" => 10, "money" => 20),
		lang(15) => array("date" => 10, "smalldatetime" => 19, "datetime" => 19, "datetime2" => 19, "time" => 8, "datetimeoffset" => 10),
		lang(16) => array("char" => 8000, "varchar" => 8000, "text" => 2147483647, "nchar" => 4000, "nvarchar" => 4000, "ntext" => 1073741823),
		lang(17) => array("binary" => 8000, "varbinary" => 8000, "image" => 2147483647),
	) as $key => $val) {
		$types += $val;
		$structured_types[$key] = array_keys($val);
	}
	$unsigned = array();
	$operators = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL");
	$functions = array("len", "lower", "round", "upper");
	$grouping = array("avg", "count", "count distinct", "max", "min", "sum");
	$edit_functions = array(
		array(
			"date|time" => "getdate",
		), array(
			"int|decimal|real|float|money|datetime" => "+/-",
			"char|text" => "+",
		)
	);
}


$drivers = array("server" => "MySQL") + $drivers;

if (!defined("DRIVER")) {
	$possible_drivers = array("MySQLi", "MySQL", "PDO_MySQL");
	define("DRIVER", "server"); // server - backwards compatibility
	// MySQLi supports everything, MySQL doesn't support multiple result sets, PDO_MySQL doesn't support orgtable
	if (extension_loaded("mysqli")) {
		class Min_DB extends MySQLi {
			var $extension = "MySQLi";
			
			function Min_DB() {
				parent::init();
			}
			
			function connect($server, $username, $password) {
				mysqli_report(MYSQLI_REPORT_OFF); // stays between requests, not required since PHP 5.3.4
				list($host, $port) = explode(":", $server, 2); // part after : is used for port or socket
				$return = @$this->real_connect(
					($server != "" ? $host : ini_get("mysqli.default_host")),
					($server . $username != "" ? $username : ini_get("mysqli.default_user")),
					($server . $username . $password != "" ? $password : ini_get("mysqli.default_pw")),
					null,
					(is_numeric($port) ? $port : ini_get("mysqli.default_port")),
					(!is_numeric($port) ? $port : null)
				);
				if ($return) {
					if (method_exists($this, 'set_charset')) {
						$this->set_charset("utf8");
					} else {
						$this->query("SET NAMES utf8");
					}
				}
				return $return;
			}
			
			function result($query, $field = 0) {
				$result = $this->query($query);
				if (!$result) {
					return false;
				}
				$row = $result->fetch_array();
				return $row[$field];
			}
			
			function quote($string) {
				return "'" . $this->escape_string($string) . "'";
			}
		}
		
	} elseif (extension_loaded("mysql") && !(ini_get("sql.safe_mode") && extension_loaded("pdo_mysql"))) {
		class Min_DB {
			var
				$extension = "MySQL", ///< @var string extension name
				$server_info, ///< @var string server version
				$affected_rows, ///< @var int number of affected rows
				$errno, ///< @var int last error code
				$error, ///< @var string last error message
				$_link, $_result ///< @access private
			;
			
			/** Connect to server
			* @param string
			* @param string
			* @param string
			* @return bool
			*/
			function connect($server, $username, $password) {
				$this->_link = @mysql_connect(
					($server != "" ? $server : ini_get("mysql.default_host")),
					("$server$username" != "" ? $username : ini_get("mysql.default_user")),
					("$server$username$password" != "" ? $password : ini_get("mysql.default_password")),
					true,
					131072 // CLIENT_MULTI_RESULTS for CALL
				);
				if ($this->_link) {
					$this->server_info = mysql_get_server_info($this->_link);
					if (function_exists('mysql_set_charset')) {
						mysql_set_charset("utf8", $this->_link);
					} else {
						$this->query("SET NAMES utf8");
					}
				} else {
					$this->error = mysql_error();
				}
				return (bool) $this->_link;
			}
			
			/** Quote string to use in SQL
			* @param string
			* @return string escaped string enclosed in '
			*/
			function quote($string) {
				return "'" . mysql_real_escape_string($string, $this->_link) . "'";
			}
			
			/** Select database
			* @param string
			* @return bool
			*/
			function select_db($database) {
				return mysql_select_db($database, $this->_link);
			}
			
			/** Send query
			* @param string
			* @param bool
			* @return mixed bool or Min_Result
			*/
			function query($query, $unbuffered = false) {
				$result = @($unbuffered ? mysql_unbuffered_query($query, $this->_link) : mysql_query($query, $this->_link)); // @ - mute mysql.trace_mode
				$this->error = "";
				if (!$result) {
					$this->errno = mysql_errno($this->_link);
					$this->error = mysql_error($this->_link);
					return false;
				}
				if ($result === true) {
					$this->affected_rows = mysql_affected_rows($this->_link);
					$this->info = mysql_info($this->_link);
					return true;
				}
				return new Min_Result($result);
			}
			
			/** Send query with more resultsets
			* @param string
			* @return bool
			*/
			function multi_query($query) {
				return $this->_result = $this->query($query);
			}
			
			/** Get current resultset
			* @return Min_Result
			*/
			function store_result() {
				return $this->_result;
			}
			
			/** Fetch next resultset
			* @return bool
			*/
			function next_result() {
				// MySQL extension doesn't support multiple results
				return false;
			}
			
			/** Get single field from result
			* @param string
			* @param int
			* @return string
			*/
			function result($query, $field = 0) {
				$result = $this->query($query);
				if (!$result || !$result->num_rows) {
					return false;
				}
				return mysql_result($result->_result, 0, $field);
			}
		}
		
		class Min_Result {
			var
				$num_rows, ///< @var int number of rows in the result
				$_result, $_offset = 0 ///< @access private
			;
			
			/** Constructor
			* @param resource
			*/
			function Min_Result($result) {
				$this->_result = $result;
				$this->num_rows = mysql_num_rows($result);
			}
			
			/** Fetch next row as associative array
			* @return array
			*/
			function fetch_assoc() {
				return mysql_fetch_assoc($this->_result);
			}
			
			/** Fetch next row as numbered array
			* @return array
			*/
			function fetch_row() {
				return mysql_fetch_row($this->_result);
			}
			
			/** Fetch next field
			* @return object properties: name, type, orgtable, orgname, charsetnr
			*/
			function fetch_field() {
				$return = mysql_fetch_field($this->_result, $this->_offset++); // offset required under certain conditions
				$return->orgtable = $return->table;
				$return->orgname = $return->name;
				$return->charsetnr = ($return->blob ? 63 : 0);
				return $return;
			}
			
			/** Free result set
			*/
			function __destruct() {
				mysql_free_result($this->_result); //! not called in PHP 4 which is a problem with mysql.trace_mode
			}
		}
		
	} elseif (extension_loaded("pdo_mysql")) {
		class Min_DB extends Min_PDO {
			var $extension = "PDO_MySQL";
			
			function connect($server, $username, $password) {
				$this->dsn("mysql:host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\\d)~', ';port=\\1', $server)), $username, $password);
				$this->query("SET NAMES utf8"); // charset in DSN is ignored
				return true;
			}
			
			function select_db($database) {
				// database selection is separated from the connection so dbname in DSN can't be used
				return $this->query("USE " . idf_escape($database));
			}
			
			function query($query, $unbuffered = false) {
				$this->setAttribute(1000, !$unbuffered); // 1000 - PDO::MYSQL_ATTR_USE_BUFFERED_QUERY
				return parent::query($query, $unbuffered);
			}
		}
		
	}

	/** Escape database identifier
	* @param string
	* @return string
	*/
	function idf_escape($idf) {
		return "`" . str_replace("`", "``", $idf) . "`";
	}

	/** Get escaped table name
	* @param string
	* @return string
	*/
	function table($idf) {
		return idf_escape($idf);
	}

	/** Connect to the database
	* @return mixed Min_DB or string for error
	*/
	function connect() {
		global $adminer;
		$connection = new Min_DB;
		$credentials = $adminer->credentials();
		if ($connection->connect($credentials[0], $credentials[1], $credentials[2])) {
			$connection->query("SET sql_quote_show_create = 1, autocommit = 1");
			return $connection;
		}
		$return = $connection->error;
		if (function_exists('iconv') && !is_utf8($return) && strlen($s = iconv("windows-1250", "utf-8", $return)) > strlen($return)) { // windows-1250 - most common Windows encoding
			$return = $s;
		}
		return $return;
	}

	/** Get cached list of databases
	* @param bool
	* @return array
	*/
	function get_databases($flush) {
		global $connection;
		// SHOW DATABASES can take a very long time so it is cached
		$return = get_session("dbs");
		if ($return === null) {
			$query = ($connection->server_info >= 5
				? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA"
				: "SHOW DATABASES"
			); // SHOW DATABASES can be disabled by skip_show_database
			$return = ($flush ? slow_query($query) : get_vals($query));
			restart_session();
			set_session("dbs", $return);
			stop_session();
		}
		return $return;
	}

	/** Formulate SQL query with limit
	* @param string everything after SELECT
	* @param string including WHERE
	* @param int
	* @param int
	* @param string
	* @return string
	*/
	function limit($query, $where, $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	/** Formulate SQL modification query with limit 1
	* @param string everything after UPDATE or DELETE
	* @param string
	* @return string
	*/
	function limit1($query, $where) {
		return limit($query, $where, 1);
	}

	/** Get database collation
	* @param string
	* @param array result of collations()
	* @return string
	*/
	function db_collation($db, $collations) {
		global $connection;
		$return = null;
		$create = $connection->result("SHOW CREATE DATABASE " . idf_escape($db), 1);
		if (preg_match('~ COLLATE ([^ ]+)~', $create, $match)) {
			$return = $match[1];
		} elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $create, $match)) {
			// default collation
			$return = $collations[$match[1]][-1];
		}
		return $return;
	}

	/** Get supported engines
	* @return array
	*/
	function engines() {
		$return = array();
		foreach (get_rows("SHOW ENGINES") as $row) {
			if (ereg("YES|DEFAULT", $row["Support"])) {
				$return[] = $row["Engine"];
			}
		}
		return $return;
	}

	/** Get logged user
	* @return string
	*/
	function logged_user() {
		global $connection;
		return $connection->result("SELECT USER()");
	}

	/** Get tables list
	* @return array array($name => $type)
	*/
	function tables_list() {
		global $connection;
		return get_key_vals("SHOW" . ($connection->server_info >= 5 ? " FULL" : "") . " TABLES");
	}

	/** Count tables in all databases
	* @param array
	* @return array array($db => $tables)
	*/
	function count_tables($databases) {
		$return = array();
		foreach ($databases as $db) {
			$return[$db] = count(get_vals("SHOW TABLES IN " . idf_escape($db)));
		}
		return $return;
	}

	/** Get table status
	* @param string
	* @param bool return only "Name", "Engine" and "Comment" fields
	* @return array array($name => array("Name" => , "Engine" => , "Comment" => , "Oid" => , "Rows" => , "Collation" => , "Auto_increment" => , "Data_length" => , "Index_length" => , "Data_free" => )) or only inner array with $name
	*/
	function table_status($name = "", $fast = false) {
		global $connection;
		$return = array();
		foreach (get_rows($fast && $connection->server_info >= 5
			? "SELECT TABLE_NAME AS Name, Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($name != "" ? "AND TABLE_NAME = " . q($name) : "ORDER BY Name")
			: "SHOW TABLE STATUS" . ($name != "" ? " LIKE " . q(addcslashes($name, "%_\\")) : "")
		) as $row) {
			if ($row["Engine"] == "InnoDB") {
				// ignore internal comment, unnecessary since MySQL 5.1.21
				$row["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\\1', $row["Comment"]);
			}
			if (!isset($row["Engine"])) {
				$row["Comment"] = "";
			}
			if ($name != "") {
				return $row;
			}
			$return[$row["Name"]] = $row;
		}
		return $return;
	}

	/** Find out whether the identifier is view
	* @param array
	* @return bool
	*/
	function is_view($table_status) {
		return $table_status["Engine"] === null;
	}

	/** Check if table supports foreign keys
	* @param array result of table_status
	* @return bool
	*/
	function fk_support($table_status) {
		return eregi("InnoDB|IBMDB2I", $table_status["Engine"]);
	}

	/** Get information about fields
	* @param string
	* @return array array($name => array("field" => , "full_type" => , "type" => , "length" => , "unsigned" => , "default" => , "null" => , "auto_increment" => , "on_update" => , "collation" => , "privileges" => , "comment" => , "primary" => ))
	*/
	function fields($table) {
		$return = array();
		foreach (get_rows("SHOW FULL COLUMNS FROM " . table($table)) as $row) {
			preg_match('~^([^( ]+)(?:\\((.+)\\))?( unsigned)?( zerofill)?$~', $row["Type"], $match);
			$return[$row["Field"]] = array(
				"field" => $row["Field"],
				"full_type" => $row["Type"],
				"type" => $match[1],
				"length" => $match[2],
				"unsigned" => ltrim($match[3] . $match[4]),
				"default" => ($row["Default"] != "" || ereg("char|set", $match[1]) ? $row["Default"] : null),
				"null" => ($row["Null"] == "YES"),
				"auto_increment" => ($row["Extra"] == "auto_increment"),
				"on_update" => (eregi('^on update (.+)', $row["Extra"], $match) ? $match[1] : ""), //! available since MySQL 5.1.23
				"collation" => $row["Collation"],
				"privileges" => array_flip(explode(",", $row["Privileges"])),
				"comment" => $row["Comment"],
				"primary" => ($row["Key"] == "PRI"),
			);
		}
		return $return;
	}

	/** Get table indexes
	* @param string
	* @param string Min_DB to use
	* @return array array($key_name => array("type" => , "columns" => array(), "lengths" => array()))
	*/
	function indexes($table, $connection2 = null) {
		$return = array();
		foreach (get_rows("SHOW INDEX FROM " . table($table), $connection2) as $row) {
			$return[$row["Key_name"]]["type"] = ($row["Key_name"] == "PRIMARY" ? "PRIMARY" : ($row["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($row["Non_unique"] ? "INDEX" : "UNIQUE")));
			$return[$row["Key_name"]]["columns"][] = $row["Column_name"];
			$return[$row["Key_name"]]["lengths"][] = $row["Sub_part"];
			$return[$row["Key_name"]]["descs"][] = null;
		}
		return $return;
	}

	/** Get foreign keys in table
	* @param string
	* @return array array($name => array("db" => , "ns" => , "table" => , "source" => array(), "target" => array(), "on_delete" => , "on_update" => ))
	*/
	function foreign_keys($table) {
		global $connection, $on_actions;
		static $pattern = '`(?:[^`]|``)+`';
		$return = array();
		$create_table = $connection->result("SHOW CREATE TABLE " . table($table), 1);
		if ($create_table) {
			preg_match_all("~CONSTRAINT ($pattern) FOREIGN KEY \\(((?:$pattern,? ?)+)\\) REFERENCES ($pattern)(?:\\.($pattern))? \\(((?:$pattern,? ?)+)\\)(?: ON DELETE ($on_actions))?(?: ON UPDATE ($on_actions))?~", $create_table, $matches, PREG_SET_ORDER);
			foreach ($matches as $match) {
				preg_match_all("~$pattern~", $match[2], $source);
				preg_match_all("~$pattern~", $match[5], $target);
				$return[idf_unescape($match[1])] = array(
					"db" => idf_unescape($match[4] != "" ? $match[3] : $match[4]),
					"table" => idf_unescape($match[4] != "" ? $match[4] : $match[3]),
					"source" => array_map('idf_unescape', $source[0]),
					"target" => array_map('idf_unescape', $target[0]),
					"on_delete" => ($match[6] ? $match[6] : "RESTRICT"),
					"on_update" => ($match[7] ? $match[7] : "RESTRICT"),
				);
			}
		}
		return $return;
	}

	/** Get view SELECT
	* @param string
	* @return array array("select" => )
	*/
	function view($name) {
		global $connection;
		return array("select" => preg_replace('~^(?:[^`]|`[^`]*`)*\\s+AS\\s+~isU', '', $connection->result("SHOW CREATE VIEW " . table($name), 1)));
	}

	/** Get sorted grouped list of collations
	* @return array
	*/
	function collations() {
		$return = array();
		foreach (get_rows("SHOW COLLATION") as $row) {
			if ($row["Default"]) {
				$return[$row["Charset"]][-1] = $row["Collation"];
			} else {
				$return[$row["Charset"]][] = $row["Collation"];
			}
		}
		ksort($return);
		foreach ($return as $key => $val) {
			asort($return[$key]);
		}
		return $return;
	}

	/** Find out if database is information_schema
	* @param string
	* @return bool
	*/
	function information_schema($db) {
		global $connection;
		return ($connection->server_info >= 5 && $db == "information_schema")
			|| ($connection->server_info >= 5.5 && $db == "performance_schema");
	}

	/** Get escaped error message
	* @return string
	*/
	function error() {
		global $connection;
		return h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $connection->error));
	}

	/** Get line of error
	* @return int 0 for first line
	*/
	function error_line() {
		global $connection;
		if (ereg(' at line ([0-9]+)$', $connection->error, $regs)) {
			return $regs[1] - 1;
		}
	}

	/** Create database
	* @param string
	* @param string
	* @return string
	*/
	function create_database($db, $collation) {
		set_session("dbs", null);
		return queries("CREATE DATABASE " . idf_escape($db) . ($collation ? " COLLATE " . q($collation) : ""));
	}
	
	/** Drop databases
	* @param array
	* @return bool
	*/
	function drop_databases($databases) {
		restart_session();
		set_session("dbs", null);
		return apply_queries("DROP DATABASE", $databases, 'idf_escape');
	}
	
	/** Rename database from DB
	* @param string new name
	* @param string
	* @return bool
	*/
	function rename_database($name, $collation) {
		if (create_database($name, $collation)) {
			//! move triggers
			$rename = array();
			foreach (tables_list() as $table => $type) {
				$rename[] = table($table) . " TO " . idf_escape($name) . "." . table($table);
			}
			if (!$rename || queries("RENAME TABLE " . implode(", ", $rename))) {
				queries("DROP DATABASE " . idf_escape(DB));
				return true;
			}
		}
		return false;
	}
	
	/** Generate modifier for auto increment column
	* @return string
	*/
	function auto_increment() {
		$auto_increment_index = " PRIMARY KEY";
		// don't overwrite primary key by auto_increment
		if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
			foreach (indexes($_GET["create"]) as $index) {
				if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $index["columns"], true)) {
					$auto_increment_index = "";
					break;
				}
				if ($index["type"] == "PRIMARY") {
					$auto_increment_index = " UNIQUE";
				}
			}
		}
		return " AUTO_INCREMENT$auto_increment_index";
	}
	
	/** Run commands to create or alter table
	* @param string "" to create
	* @param string new name
	* @param array of array($orig, $process_field, $after)
	* @param array of strings
	* @param string
	* @param string
	* @param string
	* @param int
	* @param string
	* @return bool
	*/
	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = array();
		foreach ($fields as $field) {
			$alter[] = ($field[1]
				? ($table != "" ? ($field[0] != "" ? "CHANGE " . idf_escape($field[0]) : "ADD") : " ") . " " . implode($field[1]) . ($table != "" ? $field[2] : "")
				: "DROP " . idf_escape($field[0])
			);
		}
		$alter = array_merge($alter, $foreign);
		$status = "COMMENT=" . q($comment)
			. ($engine ? " ENGINE=" . q($engine) : "")
			. ($collation ? " COLLATE " . q($collation) : "")
			. ($auto_increment != "" ? " AUTO_INCREMENT=$auto_increment" : "")
			. $partitioning
		;
		if ($table == "") {
			return queries("CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n) $status");
		}
		if ($table != $name) {
			$alter[] = "RENAME TO " . table($name);
		}
		$alter[] = $status;
		return queries("ALTER TABLE " . table($table) . "\n" . implode(",\n", $alter));
	}
	
	/** Run commands to alter indexes
	* @param string escaped table name
	* @param array of array("index type", "name", "(columns definition)") or array("index type", "name", "DROP")
	* @return bool
	*/
	function alter_indexes($table, $alter) {
		foreach ($alter as $key => $val) {
			$alter[$key] = ($val[2] == "DROP"
				? "\nDROP INDEX " . idf_escape($val[1])
				: "\nADD $val[0] " . ($val[0] == "PRIMARY" ? "KEY " : "") . ($val[1] != "" ? idf_escape($val[1]) . " " : "") . $val[2]
			);
		}
		return queries("ALTER TABLE " . table($table) . implode(",", $alter));
	}
	
	/** Run commands to truncate tables
	* @param array
	* @return bool
	*/
	function truncate_tables($tables) {
		return apply_queries("TRUNCATE TABLE", $tables);
	}
	
	/** Drop views
	* @param array
	* @return bool
	*/
	function drop_views($views) {
		return queries("DROP VIEW " . implode(", ", array_map('table', $views)));
	}
	
	/** Drop tables
	* @param array
	* @return bool
	*/
	function drop_tables($tables) {
		return queries("DROP TABLE " . implode(", ", array_map('table', $tables)));
	}
	
	/** Move tables to other schema
	* @param array
	* @param array
	* @param string
	* @return bool
	*/
	function move_tables($tables, $views, $target) {
		$rename = array();
		foreach (array_merge($tables, $views) as $table) { // views will report SQL error
			$rename[] = table($table) . " TO " . idf_escape($target) . "." . table($table);
		}
		return queries("RENAME TABLE " . implode(", ", $rename));
		//! move triggers
	}
	
	/** Copy tables to other schema
	* @param array
	* @param array
	* @param string
	* @return bool
	*/
	function copy_tables($tables, $views, $target) {
		queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
		foreach ($tables as $table) {
			$name = ($target == DB ? table("copy_$table") : idf_escape($target) . "." . table($table));
			if (!queries("DROP TABLE IF EXISTS $name")
				|| !queries("CREATE TABLE $name LIKE " . table($table))
				|| !queries("INSERT INTO $name SELECT * FROM " . table($table))
			) {
				return false;
			}
		}
		foreach ($views as $table) {
			$name = ($target == DB ? table("copy_$table") : idf_escape($target) . "." . table($table));
			$view = view($table);
			if (!queries("DROP VIEW IF EXISTS $name")
				|| !queries("CREATE VIEW $name AS $view[select]") //! USE to avoid db.table
			) {
				return false;
			}
		}
		return true;
	}
	
	/** Get information about trigger
	* @param string trigger name
	* @return array array("Trigger" => , "Timing" => , "Event" => , "Type" => , "Statement" => )
	*/
	function trigger($name) {
		if ($name == "") {
			return array();
		}
		$rows = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($name));
		return reset($rows);
	}
	
	/** Get defined triggers
	* @param string
	* @return array array($name => array($timing, $event))
	*/
	function triggers($table) {
		$return = array();
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($table, "%_\\"))) as $row) {
			$return[$row["Trigger"]] = array($row["Timing"], $row["Event"]);
		}
		return $return;
	}
	
	/** Get trigger options
	* @return array ("Timing" => array(), "Type" => array())
	*/
	function trigger_options() {
		return array(
			"Timing" => array("BEFORE", "AFTER"),
			// Event is always INSERT, UPDATE, DELETE
			"Type" => array("FOR EACH ROW"),
		);
	}
	
	/** Get information about stored routine
	* @param string
	* @param string "FUNCTION" or "PROCEDURE"
	* @return array ("fields" => array("field" => , "type" => , "length" => , "unsigned" => , "inout" => , "collation" => ), "returns" => , "definition" => , "language" => )
	*/
	function routine($name, $type) {
		global $connection, $enum_length, $inout, $types;
		$aliases = array("bool", "boolean", "integer", "double precision", "real", "dec", "numeric", "fixed", "national char", "national varchar");
		$type_pattern = "((" . implode("|", array_merge(array_keys($types), $aliases)) . ")\\b(?:\\s*\\(((?:[^'\")]*|$enum_length)+)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s]+)['\"]?)?";
		$pattern = "\\s*(" . ($type == "FUNCTION" ? "" : $inout) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$type_pattern";
		$create = $connection->result("SHOW CREATE $type " . idf_escape($name), 2);
		preg_match("~\\(((?:$pattern\\s*,?)*)\\)\\s*" . ($type == "FUNCTION" ? "RETURNS\\s+$type_pattern\\s+" : "") . "(.*)~is", $create, $match);
		$fields = array();
		preg_match_all("~$pattern\\s*,?~is", $match[1], $matches, PREG_SET_ORDER);
		foreach ($matches as $param) {
			$name = str_replace("``", "`", $param[2]) . $param[3];
			$fields[] = array(
				"field" => $name,
				"type" => strtolower($param[5]),
				"length" => preg_replace_callback("~$enum_length~s", 'normalize_enum', $param[6]),
				"unsigned" => strtolower(preg_replace('~\\s+~', ' ', trim("$param[8] $param[7]"))),
				"null" => 1,
				"full_type" => $param[4],
				"inout" => strtoupper($param[1]),
				"collation" => strtolower($param[9]),
			);
		}
		if ($type != "FUNCTION") {
			return array("fields" => $fields, "definition" => $match[11]);
		}
		return array(
			"fields" => $fields,
			"returns" => array("type" => $match[12], "length" => $match[13], "unsigned" => $match[15], "collation" => $match[16]),
			"definition" => $match[17],
			"language" => "SQL", // available in information_schema.ROUTINES.PARAMETER_STYLE
		);
	}
	
	/** Get list of routines
	* @return array ("ROUTINE_TYPE" => , "ROUTINE_NAME" => , "DTD_IDENTIFIER" => )
	*/
	function routines() {
		return get_rows("SELECT ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
	}
	
	/** Get list of available routine languages
	* @return array
	*/
	function routine_languages() {
		return array(); // "SQL" not required
	}
	
	/** Begin transaction
	* @return bool
	*/
	function begin() {
		return queries("BEGIN");
	}
	
	/** Insert data into table
	* @param string
	* @param array
	* @return bool
	*/
	function insert_into($table, $set) {
		return queries("INSERT INTO " . table($table) . " (" . implode(", ", array_keys($set)) . ")\nVALUES (" . implode(", ", $set) . ")");
	}
	
	/** Insert or update data in the table
	* @param string
	* @param array
	* @param array columns in keys
	* @return bool
	*/
	function insert_update($table, $set, $primary) {
		foreach ($set as $key => $val) {
			$set[$key] = "$key = $val";
		}
		$update = implode(", ", $set);
		return queries("INSERT INTO " . table($table) . " SET $update ON DUPLICATE KEY UPDATE $update");
	}
	
	/** Get last auto increment ID
	* @return string
	*/
	function last_id() {
		global $connection;
		return $connection->result("SELECT LAST_INSERT_ID()"); // mysql_insert_id() truncates bigint
	}
	
	/** Explain select
	* @param Min_DB
	* @param string
	* @return Min_Result
	*/
	function explain($connection, $query) {
		return $connection->query("EXPLAIN " . ($connection->server_info >= 5.1 ? "PARTITIONS " : "") . $query);
	}
	
	/** Get approximate number of rows
	* @param array
	* @param array
	* @return int or null if approximate number can't be retrieved
	*/
	function found_rows($table_status, $where) {
		return ($where || $table_status["Engine"] != "InnoDB" ? null : $table_status["Rows"]);
	}
	
	/** Get user defined types
	* @return array
	*/
	function types() {
		return array();
	}
	
	/** Get existing schemas
	* @return array
	*/
	function schemas() {
		return array();
	}
	
	/** Get current schema
	* @return string
	*/
	function get_schema() {
		return "";
	}
	
	/** Set current schema
	* @param string
	* @return bool
	*/
	function set_schema($schema) {
		return true;
	}
	
	/** Get SQL command to create table
	* @param string
	* @param bool
	* @return string
	*/
	function create_sql($table, $auto_increment) {
		global $connection;
		$return = $connection->result("SHOW CREATE TABLE " . table($table), 1);
		if (!$auto_increment) {
			$return = preg_replace('~ AUTO_INCREMENT=\\d+~', '', $return); //! skip comments
		}
		return $return;
	}
	
	/** Get SQL command to truncate table
	* @param string
	* @return string
	*/
	function truncate_sql($table) {
		return "TRUNCATE " . table($table);
	}
	
	/** Get SQL command to change database
	* @param string
	* @return string
	*/
	function use_sql($database) {
		return "USE " . idf_escape($database);
	}
	
	/** Get SQL commands to create triggers
	* @param string
	* @param string
	* @return string
	*/
	function trigger_sql($table, $style) {
		$return = "";
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($table, "%_\\")), null, "-- ") as $row) {
			$return .= "\n" . ($style == 'CREATE+ALTER' ? "DROP TRIGGER IF EXISTS " . idf_escape($row["Trigger"]) . ";;\n" : "")
			. "CREATE TRIGGER " . idf_escape($row["Trigger"]) . " $row[Timing] $row[Event] ON " . table($row["Table"]) . " FOR EACH ROW\n$row[Statement];;\n";
		}
		return $return;
	}
	
	/** Get server variables
	* @return array ($name => $value)
	*/
	function show_variables() {
		return get_key_vals("SHOW VARIABLES");
	}
	
	/** Get process list
	* @return array ($row)
	*/
	function process_list() {
		return get_rows("SHOW FULL PROCESSLIST");
	}
	
	/** Get status variables
	* @return array ($name => $value)
	*/
	function show_status() {
		return get_key_vals("SHOW STATUS");
	}
	
	/** Convert field in select and edit
	* @param array one element from fields()
	* @return string
	*/
	function convert_field($field) {
		if (ereg("binary", $field["type"])) {
			return "HEX(" . idf_escape($field["field"]) . ")";
		}
		if ($field["type"] == "bit") {
			return "BIN(" . idf_escape($field["field"]) . " + 0)"; // + 0 is required outside MySQLnd
		}
		if (ereg("geometry|point|linestring|polygon", $field["type"])) {
			return "AsWKT(" . idf_escape($field["field"]) . ")";
		}
	}
	
	/** Convert value in edit after applying functions back
	* @param array one element from fields()
	* @param string
	* @return string
	*/
	function unconvert_field($field, $return) {
		if (ereg("binary", $field["type"])) {
			$return = "UNHEX($return)";
		}
		if ($field["type"] == "bit") {
			$return = "CONV($return, 2, 10) + 0";
		}
		if (ereg("geometry|point|linestring|polygon", $field["type"])) {
			$return = "GeomFromText($return)";
		}
		return $return;
	}
	
	/** Check whether a feature is supported
	* @param string "comment", "copy", "drop_col", "dump", "event", "kill", "partitioning", "privileges", "procedure", "processlist", "routine", "scheme", "sequence", "status", "trigger", "type", "variables", "view"
	* @return bool
	*/
	function support($feature) {
		global $connection;
		return !ereg("scheme|sequence|type" . ($connection->server_info < 5.1 ? "|event|partitioning" . ($connection->server_info < 5 ? "|view|routine|trigger" : "") : ""), $feature);
	}

	$jush = "sql"; ///< @var string JUSH identifier
	$types = array(); ///< @var array ($type => $maximum_unsigned_length, ...)
	$structured_types = array(); ///< @var array ($description => array($type, ...), ...)
	foreach (array(
		lang(14) => array("tinyint" => 3, "smallint" => 5, "mediumint" => 8, "int" => 10, "bigint" => 20, "decimal" => 66, "float" => 12, "double" => 21),
		lang(15) => array("date" => 10, "datetime" => 19, "timestamp" => 19, "time" => 10, "year" => 4),
		lang(16) => array("char" => 255, "varchar" => 65535, "tinytext" => 255, "text" => 65535, "mediumtext" => 16777215, "longtext" => 4294967295),
		lang(20) => array("enum" => 65535, "set" => 64),
		lang(17) => array("bit" => 20, "binary" => 255, "varbinary" => 65535, "tinyblob" => 255, "blob" => 65535, "mediumblob" => 16777215, "longblob" => 4294967295),
		lang(19) => array("geometry" => 0, "point" => 0, "linestring" => 0, "polygon" => 0, "multipoint" => 0, "multilinestring" => 0, "multipolygon" => 0, "geometrycollection" => 0),
	) as $key => $val) {
		$types += $val;
		$structured_types[$key] = array_keys($val);
	}
	$unsigned = array("unsigned", "zerofill", "unsigned zerofill"); ///< @var array number variants
	$operators = array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "REGEXP", "IN", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL"); ///< @var array operators used in select
	$functions = array("char_length", "date", "from_unixtime", "lower", "round", "sec_to_time", "time_to_sec", "upper"); ///< @var array functions used in select
	$grouping = array("avg", "count", "count distinct", "group_concat", "max", "min", "sum"); ///< @var array grouping functions used in select
	$edit_functions = array( ///< @var array of array("$type|$type2" => "$function/$function2") functions used in editing, [0] - edit and insert, [1] - edit only
		array(
			"char" => "md5/sha1/password/encrypt/uuid", //! JavaScript for disabling maxlength
			"binary" => "md5/sha1",
			"date|time" => "now",
		), array(
			"(^|[^o])int|float|double|decimal" => "+/-", // not point
			"date" => "+ interval/- interval",
			"time" => "addtime/subtime",
			"char|text" => "concat",
		)
	);
}
 // must be included as last driver

define("SERVER", $_GET[DRIVER]); // read from pgsql=localhost
define("DB", $_GET["db"]); // for the sake of speed and size
define("ME", preg_replace('~^[^?]*/([^?]*).*~', '\\1', $_SERVER["REQUEST_URI"]) . '?'
	. (sid() ? SID . '&' : '')
	. (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '')
	. (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '')
	. (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : '')
);


$VERSION = "3.7.1";


// any method change in this file should be transferred to editor/include/adminer.inc.php and plugins/plugin.php

class Adminer {
	/** @var array operators used in select, null for all operators */
	var $operators;
	
	/** Name in title and navigation
	* @return string HTML code
	*/
	function name() {
		return "<a href='http://www.adminer.org/' id='h1'>Adminer</a>";
	}
	
	/** Connection parameters
	* @return array ($server, $username, $password)
	*/
	function credentials() {
		return array(SERVER, $_GET["username"], get_session("pwds"));
	}
	
	/** Get key used for permanent login
	* @param bool
	* @return string cryptic string which gets combined with password or false in case of an error
	*/
	function permanentLogin($create = false) {
		return password_file($create);
	}
	
	/** Identifier of selected database
	* @return string
	*/
	function database() {
		// should be used everywhere instead of DB
		return DB;
	}
	
	/** Get cached list of databases
	* @param bool
	* @return array
	*/
	function databases($flush = true) {
		return get_databases($flush);
	}
	
	/** Specify limit for waiting on some slow queries like DB list
	* @return float number of seconds
	*/
	function queryTimeout() {
		return 5;
	}
	
	/** Headers to send before HTML output
	* @return bool true to send security headers
	*/
	function headers() {
		return true;
	}
	
	/** Print HTML code inside <head>
	* @return bool true to link adminer.css if exists
	*/
	function head() {
		return true;
	}
	
	/** Print login form
	* @return null
	*/
	function loginForm() {
		global $drivers;
		?>
<table cellspacing="0">
<tr><th><?php echo lang(21); ?><td><?php echo html_select("auth[driver]", $drivers, DRIVER, "loginDriver(this);"); ?>
<tr><th><?php echo lang(22); ?><td><input name="auth[server]" value="<?php echo h(SERVER); ?>" title="hostname[:port]" placeholder="localhost" autocapitalize="off">
<tr><th><?php echo lang(23); ?><td><input name="auth[username]" id="username" value="<?php echo h($_GET["username"]); ?>" autocapitalize="off">
<tr><th><?php echo lang(24); ?><td><input type="password" name="auth[password]">
<tr><th><?php echo lang(25); ?><td><input name="auth[db]" value="<?php echo h($_GET["db"]); ?>" autocapitalize="off">
</table>
<script type="text/javascript">
var username = document.getElementById('username');
focus(username);
username.form['auth[driver]'].onchange();
</script>
<?php
		echo "<p><input type='submit' value='" . lang(26) . "'>\n";
		echo checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], lang(27)) . "\n";
	}
	
	/** Authorize the user
	* @param string
	* @param string
	* @return bool
	*/
	function login($login, $password) {
		return true;
	}
	
	/** Table caption used in navigation and headings
	* @param array result of SHOW TABLE STATUS
	* @return string HTML code, "" to ignore table
	*/
	function tableName($tableStatus) {
		return h($tableStatus["Name"]);
	}
	
	/** Field caption used in select and edit
	* @param array single field returned from fields()
	* @param int order of column in select
	* @return string HTML code, "" to ignore field
	*/
	function fieldName($field, $order = 0) {
		return '<span title="' . h($field["full_type"]) . '">' . h($field["field"]) . '</span>';
	}
	
	/** Print links after select heading
	* @param array result of SHOW TABLE STATUS
	* @param string new item options, NULL for no new item
	* @return null
	*/
	function selectLinks($tableStatus, $set = "") {
		echo '<p class="tabs">';
		$links = array("select" => lang(28), "table" => lang(29));
		if (is_view($tableStatus)) {
			$links["view"] = lang(30);
		} else {
			$links["create"] = lang(31);
		}
		if ($set !== null) {
			$links["edit"] = lang(32);
		}
		foreach ($links as $key => $val) {
			echo " <a href='" . h(ME) . "$key=" . urlencode($tableStatus["Name"]) . ($key == "edit" ? $set : "") . "'" . bold(isset($_GET[$key])) . ">$val</a>";
		}
		echo "\n";
	}
	
	/** Get foreign keys for table
	* @param string
	* @return array same format as foreign_keys()
	*/
	function foreignKeys($table) {
		return foreign_keys($table);
	}
	
	/** Find backward keys for table
	* @param string
	* @param string
	* @return array $return[$target_table]["keys"][$key_name][$target_column] = $source_column; $return[$target_table]["name"] = $this->tableName($target_table);
	*/
	function backwardKeys($table, $tableName) {
		return array();
	}
	
	/** Print backward keys for row
	* @param array result of $this->backwardKeys()
	* @param array
	* @return null
	*/
	function backwardKeysPrint($backwardKeys, $row) {
	}
	
	/** Query printed in select before execution
	* @param string query to be executed
	* @return string
	*/
	function selectQuery($query) {
		global $jush, $token;
		return "<form action='" . h(ME) . "sql=' method='post'><p><span onclick=\"return !selectEditSql(event, this, '" . lang(33) . "');\">"
			. "<code class='jush-$jush'>" . h(str_replace("\n", " ", $query)) . "</code>"
			. " <a href='" . h(ME) . "sql=" . urlencode($query) . "'>" . lang(34) . "</a>"
			. "</span><input type='hidden' name='token' value='$token'></p></form>\n"; // </p> - required for IE9 inline edit
	}
	
	/** Description of a row in a table
	* @param string
	* @return string SQL expression, empty string for no description
	*/
	function rowDescription($table) {
		return "";
	}
	
	/** Get descriptions of selected data
	* @param array all data to print
	* @param array
	* @return array
	*/
	function rowDescriptions($rows, $foreignKeys) {
		return $rows;
	}
	
	/** Get a link to use in select table
	* @param string raw value of the field
	* @param array single field returned from fields()
	* @return string or null to create the default link
	*/
	function selectLink($val, $field) {
	}
	
	/** Value printed in select table
	* @param string HTML-escaped value to print
	* @param string link to foreign key
	* @param array single field returned from fields()
	* @return string
	*/
	function selectVal($val, $link, $field) {
		$return = ($val === null ? "<i>NULL</i>" : (ereg("char|binary", $field["type"]) && !ereg("var", $field["type"]) ? "<code>$val</code>" : $val));
		if (ereg('blob|bytea|raw|file', $field["type"]) && !is_utf8($val)) {
			$return = lang(35, strlen(html_entity_decode($val, ENT_QUOTES)));
		}
		return ($link ? "<a href='" . h($link) . "'>$return</a>" : $return);
	}
	
	/** Value conversion used in select and edit
	* @param string
	* @param array single field returned from fields()
	* @return string
	*/
	function editVal($val, $field) {
		return $val;
	}
	
	/** Print columns box in select
	* @param array result of selectColumnsProcess()[0]
	* @param array selectable columns
	* @return null
	*/
	function selectColumnsPrint($select, $columns) {
		global $functions, $grouping;
		print_fieldset("select", lang(36), $select);
		$i = 0;
		$fun_group = array(lang(37) => $functions, lang(38) => $grouping);
		foreach ($select as $key => $val) {
			$val = $_GET["columns"][$key];
			echo "<div>" . html_select("columns[$i][fun]", array(-1 => "") + $fun_group, $val["fun"]);
			echo "(<select name='columns[$i][col]' onchange='selectFieldChange(this.form);'><option>" . optionlist($columns, $val["col"], true) . "</select>)</div>\n";
			$i++;
		}
		echo "<div>" . html_select("columns[$i][fun]", array(-1 => "") + $fun_group, "", "this.nextSibling.nextSibling.onchange();");
		echo "(<select name='columns[$i][col]' onchange='selectAddRow(this);'><option>" . optionlist($columns, null, true) . "</select>)</div>\n";
		echo "</div></fieldset>\n";
	}
	
	/** Print search box in select
	* @param array result of selectSearchProcess()
	* @param array selectable columns
	* @param array
	* @return null
	*/
	function selectSearchPrint($where, $columns, $indexes) {
		print_fieldset("search", lang(39), $where);
		foreach ($indexes as $i => $index) {
			if ($index["type"] == "FULLTEXT") {
				echo "(<i>" . implode("</i>, <i>", array_map('h', $index["columns"])) . "</i>) AGAINST";
				echo " <input type='search' name='fulltext[$i]' value='" . h($_GET["fulltext"][$i]) . "' onchange='selectFieldChange(this.form);'>";
				echo checkbox("boolean[$i]", 1, isset($_GET["boolean"][$i]), "BOOL");
				echo "<br>\n";
			}
		}
		$_GET["where"] = (array) $_GET["where"];
		reset($_GET["where"]);
		$change_next = "this.nextSibling.onchange();";
		for ($i = 0; $i <= count($_GET["where"]); $i++) {
			list(, $val) = each($_GET["where"]);
			if (!$val || ("$val[col]$val[val]" != "" && in_array($val["op"], $this->operators))) {
				echo "<div><select name='where[$i][col]' onchange='$change_next'><option value=''>(" . lang(40) . ")" . optionlist($columns, $val["col"], true) . "</select>";
				echo html_select("where[$i][op]", $this->operators, $val["op"], $change_next);
				echo "<input type='search' name='where[$i][val]' value='" . h($val["val"]) . "' onchange='" . ($val ? "selectFieldChange(this.form)" : "selectAddRow(this)") . ";' onsearch='selectSearchSearch(this);'></div>\n";
			}
		}
		echo "</div></fieldset>\n";
	}
	
	/** Print order box in select
	* @param array result of selectOrderProcess()
	* @param array selectable columns
	* @param array
	* @return null
	*/
	function selectOrderPrint($order, $columns, $indexes) {
		print_fieldset("sort", lang(41), $order);
		$i = 0;
		foreach ((array) $_GET["order"] as $key => $val) {
			if (isset($columns[$val])) {
				echo "<div><select name='order[$i]' onchange='selectFieldChange(this.form);'><option>" . optionlist($columns, $val, true) . "</select>";
				echo checkbox("desc[$i]", 1, isset($_GET["desc"][$key]), lang(42)) . "</div>\n";
				$i++;
			}
		}
		echo "<div><select name='order[$i]' onchange='selectAddRow(this);'><option>" . optionlist($columns, null, true) . "</select>";
		echo checkbox("desc[$i]", 1, false, lang(42)) . "</div>\n";
		echo "</div></fieldset>\n";
	}
	
	/** Print limit box in select
	* @param string result of selectLimitProcess()
	* @return null
	*/
	function selectLimitPrint($limit) {
		echo "<fieldset><legend>" . lang(43) . "</legend><div>"; // <div> for easy styling
		echo "<input type='number' name='limit' class='size' value='" . h($limit) . "' onchange='selectFieldChange(this.form);'>";
		echo "</div></fieldset>\n";
	}
	
	/** Print text length box in select
	* @param string result of selectLengthProcess()
	* @return null
	*/
	function selectLengthPrint($text_length) {
		if ($text_length !== null) {
			echo "<fieldset><legend>" . lang(44) . "</legend><div>";
			echo "<input type='number' name='text_length' class='size' value='" . h($text_length) . "'>";
			echo "</div></fieldset>\n";
		}
	}
	
	/** Print action box in select
	* @param array
	* @return null
	*/
	function selectActionPrint($indexes) {
		echo "<fieldset><legend>" . lang(45) . "</legend><div>";
		echo "<input type='submit' value='" . lang(36) . "'>";
		echo " <span id='noindex' title='" . lang(46) . "'></span>";
		echo "<script type='text/javascript'>\n";
		echo "var indexColumns = ";
		$columns = array();
		foreach ($indexes as $index) {
			if ($index["type"] != "FULLTEXT") {
				$columns[reset($index["columns"])] = 1;
			}
		}
		$columns[""] = 1;
		foreach ($columns as $key => $val) {
			json_row($key);
		}
		echo ";\n";
		echo "selectFieldChange(document.getElementById('form'));\n";
		echo "</script>\n";
		echo "</div></fieldset>\n";
	}
	
	/** Print command box in select
	* @return bool whether to print default commands
	*/
	function selectCommandPrint() {
		return !information_schema(DB);
	}
	
	/** Print import box in select
	* @return bool whether to print default import
	*/
	function selectImportPrint() {
		return !information_schema(DB);
	}
	
	/** Print extra text in the end of a select form
	* @param array fields holding e-mails
	* @param array selectable columns
	* @return null
	*/
	function selectEmailPrint($emailFields, $columns) {
	}
	
	/** Process columns box in select
	* @param array selectable columns
	* @param array
	* @return array (array(select_expressions), array(group_expressions))
	*/
	function selectColumnsProcess($columns, $indexes) {
		global $functions, $grouping;
		$select = array(); // select expressions, empty for *
		$group = array(); // expressions without aggregation - will be used for GROUP BY if an aggregation function is used
		foreach ((array) $_GET["columns"] as $key => $val) {
			if ($val["fun"] == "count" || (isset($columns[$val["col"]]) && (!$val["fun"] || in_array($val["fun"], $functions) || in_array($val["fun"], $grouping)))) {
				$select[$key] = apply_sql_function($val["fun"], (isset($columns[$val["col"]]) ? idf_escape($val["col"]) : "*"));
				if (!in_array($val["fun"], $grouping)) {
					$group[] = $select[$key];
				}
			}
		}
		return array($select, $group);
	}
	
	/** Process search box in select
	* @param array
	* @param array
	* @return array expressions to join by AND
	*/
	function selectSearchProcess($fields, $indexes) {
		global $jush;
		$return = array();
		foreach ($indexes as $i => $index) {
			if ($index["type"] == "FULLTEXT" && $_GET["fulltext"][$i] != "") {
				$return[] = "MATCH (" . implode(", ", array_map('idf_escape', $index["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$i]) . (isset($_GET["boolean"][$i]) ? " IN BOOLEAN MODE" : "") . ")";
			}
		}
		foreach ((array) $_GET["where"] as $val) {
			if ("$val[col]$val[val]" != "" && in_array($val["op"], $this->operators)) {
				$cond = " $val[op]";
				if (ereg('IN$', $val["op"])) {
					$in = process_length($val["val"]);
					$cond .= " (" . ($in != "" ? $in : "NULL") . ")";
				} elseif ($val["op"] == "SQL") {
					$cond = " $val[val]"; // SQL injection
				} elseif ($val["op"] == "LIKE %%") {
					$cond = " LIKE " . $this->processInput($fields[$val["col"]], "%$val[val]%");
				} elseif (!ereg('NULL$', $val["op"])) {
					$cond .= " " . $this->processInput($fields[$val["col"]], $val["val"]);
				}
				if ($val["col"] != "") {
					$return[] = idf_escape($val["col"]) . $cond;
				} else {
					// find anywhere
					$cols = array();
					foreach ($fields as $name => $field) {
						$is_text = ereg('char|text|enum|set', $field["type"]);
						if ((is_numeric($val["val"]) || !ereg('(^|[^o])int|float|double|decimal|bit', $field["type"]))
							&& (!ereg("[\x80-\xFF]", $val["val"]) || $is_text)
						) {
							$name = idf_escape($name);
							$cols[] = ($jush == "sql" && $is_text && !ereg('^utf8', $field["collation"]) ? "CONVERT($name USING utf8)" : $name);
						}
					}
					$return[] = ($cols ? "(" . implode("$cond OR ", $cols) . "$cond)" : "0");
				}
			}
		}
		return $return;
	}
	
	/** Process order box in select
	* @param array
	* @param array
	* @return array expressions to join by comma
	*/
	function selectOrderProcess($fields, $indexes) {
		$return = array();
		foreach ((array) $_GET["order"] as $key => $val) {
			if (isset($fields[$val]) || preg_match('~^((COUNT\\(DISTINCT |[A-Z0-9_]+\\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\\)|COUNT\\(\\*\\))$~', $val)) { //! MS SQL uses []
				$return[] = (isset($fields[$val]) ? idf_escape($val) : $val) . (isset($_GET["desc"][$key]) ? " DESC" : "");
			}
		}
		return $return;
	}
	
	/** Process limit box in select
	* @return string expression to use in LIMIT, will be escaped
	*/
	function selectLimitProcess() {
		return (isset($_GET["limit"]) ? $_GET["limit"] : "50");
	}
	
	/** Process length box in select
	* @return string number of characters to shorten texts, will be escaped
	*/
	function selectLengthProcess() {
		return (isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
	}
	
	/** Process extras in select form
	* @param array AND conditions
	* @param array
	* @return bool true if processed, false to process other parts of form
	*/
	function selectEmailProcess($where, $foreignKeys) {
		return false;
	}
	
	/** Build SQL query used in select
	* @param array result of selectColumnsProcess()[0]
	* @param array result of selectSearchProcess()
	* @param array result of selectColumnsProcess()[1]
	* @param array result of selectOrderProcess()
	* @param int result of selectLimitProcess()
	* @param int index of page starting at zero
	* @return string empty string to use default query
	*/
	function selectQueryBuild($select, $where, $group, $order, $limit, $page) {
		return "";
	}
	
	/** Query printed after execution in the message
	* @param string executed query
	* @return string
	*/
	function messageQuery($query) {
		global $jush;
		restart_session();
		$history = &get_session("queries");
		$id = "sql-" . count($history[$_GET["db"]]);
		if (strlen($query) > 1e6) {
			$query = ereg_replace('[\x80-\xFF]+$', '', substr($query, 0, 1e6)) . "\n..."; // [\x80-\xFF] - valid UTF-8, \n - can end by one-line comment
		}
		$history[$_GET["db"]][] = array($query, time()); // not DB - $_GET["db"] is changed in database.inc.php //! respect $_GET["ns"]
		return " <span class='time'>" . @date("H:i:s") . "</span> <a href='#$id' onclick=\"return !toggle('$id');\">" . lang(47) . "</a><div id='$id' class='hidden'><pre><code class='jush-$jush'>" . shorten_utf8($query, 1000) . '</code></pre><p><a href="' . h(str_replace("db=" . urlencode(DB), "db=" . urlencode($_GET["db"]), ME) . 'sql=&history=' . (count($history[$_GET["db"]]) - 1)) . '">' . lang(34) . '</a></div>'; // @ - time zone may be not set
	}
	
	/** Functions displayed in edit form
	* @param array single field from fields()
	* @return array
	*/
	function editFunctions($field) {
		global $edit_functions;
		$return = ($field["null"] ? "NULL/" : "");
		foreach ($edit_functions as $key => $functions) {
			if (!$key || (!isset($_GET["call"]) && (isset($_GET["select"]) || where($_GET)))) { // relative functions
				foreach ($functions as $pattern => $val) {
					if (!$pattern || ereg($pattern, $field["type"])) {
						$return .= "/$val";
					}
				}
				if ($key && !ereg('set|blob|bytea|raw|file', $field["type"])) {
					$return .= "/SQL";
				}
			}
		}
		return explode("/", $return);
	}
	
	/** Get options to display edit field
	* @param string table name
	* @param array single field from fields()
	* @param string attributes to use inside the tag
	* @param string
	* @return string custom input field or empty string for default
	*/
	function editInput($table, $field, $attrs, $value) {
		if ($field["type"] == "enum") {
			return (isset($_GET["select"]) ? "<label><input type='radio'$attrs value='-1' checked><i>" . lang(6) . "</i></label> " : "")
				. ($field["null"] ? "<label><input type='radio'$attrs value=''" . ($value !== null || isset($_GET["select"]) ? "" : " checked") . "><i>NULL</i></label> " : "")
				. enum_input("radio", $attrs, $field, $value, 0) // 0 - empty
			;
		}
		return "";
	}
	
	/** Process sent input
	* @param array single field from fields()
	* @param string
	* @param string
	* @return string expression to use in a query
	*/
	function processInput($field, $value, $function = "") {
		if ($function == "SQL") {
			return $value; // SQL injection
		}
		$name = $field["field"];
		$return = q($value);
		if (ereg('^(now|getdate|uuid)$', $function)) {
			$return = "$function()";
		} elseif (ereg('^current_(date|timestamp)$', $function)) {
			$return = $function;
		} elseif (ereg('^([+-]|\\|\\|)$', $function)) {
			$return = idf_escape($name) . " $function $return";
		} elseif (ereg('^[+-] interval$', $function)) {
			$return = idf_escape($name) . " $function " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+$~i", $value) ? $value : $return);
		} elseif (ereg('^(addtime|subtime|concat)$', $function)) {
			$return = "$function(" . idf_escape($name) . ", $return)";
		} elseif (ereg('^(md5|sha1|password|encrypt)$', $function)) {
			$return = "$function($return)";
		}
		return unconvert_field($field, $return);
	}
	
	/** Returns export output options
	* @return array
	*/
	function dumpOutput() {
		$return = array('text' => lang(48), 'file' => lang(49));
		if (function_exists('gzencode')) {
			$return['gz'] = 'gzip';
		}
		return $return;
	}
	
	/** Returns export format options
	* @return array empty to disable export
	*/
	function dumpFormat() {
		return array('sql' => 'SQL', 'csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV');
	}
	
	/** Export database structure
	* @param string
	* @return null prints data
	*/
	function dumpDatabase($db) {
	}
	
	/** Export table structure
	* @param string
	* @param string
	* @param int 0 table, 1 view, 2 temporary view table
	* @return null prints data
	*/
	function dumpTable($table, $style, $is_view = 0) {
		if ($_POST["format"] != "sql") {
			echo "\xef\xbb\xbf"; // UTF-8 byte order mark
			if ($style) {
				dump_csv(array_keys(fields($table)));
			}
		} elseif ($style) {
			if ($is_view == 2) {
				$fields = array();
				foreach (fields($table) as $name => $field) {
					$fields[] = idf_escape($name) . " $field[full_type]";
				}
				$create = "CREATE TABLE " . table($table) . " (" . implode(", ", $fields) . ")";
			} else {
				$create = create_sql($table, $_POST["auto_increment"]);
			}
			if ($create) {
				if ($style == "DROP+CREATE" || $is_view == 1) {
					echo "DROP " . ($is_view == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($table) . ";\n";
				}
				if ($is_view == 1) {
					$create = remove_definer($create);
				}
				echo "$create;\n\n";
			}
		}
	}
	
	/** Export table data
	* @param string
	* @param string
	* @param string
	* @return null prints data
	*/
	function dumpData($table, $style, $query) {
		global $connection, $jush;
		$max_packet = ($jush == "sqlite" ? 0 : 1048576); // default, minimum is 1024
		if ($style) {
			if ($_POST["format"] == "sql") {
				if ($style == "TRUNCATE+INSERT") {
					echo truncate_sql($table) . ";\n";
				}
				$fields = fields($table);
			}
			$result = $connection->query($query, 1); // 1 - MYSQLI_USE_RESULT //! enum and set as numbers
			if ($result) {
				$insert = "";
				$buffer = "";
				$keys = array();
				$suffix = "";
				$fetch_function = ($table != '' ? 'fetch_assoc' : 'fetch_row');
				while ($row = $result->$fetch_function()) {
					if (!$keys) {
						$values = array();
						foreach ($row as $val) {
							$field = $result->fetch_field();
							$keys[] = $field->name;
							$key = idf_escape($field->name);
							$values[] = "$key = VALUES($key)";
						}
						$suffix = ($style == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $values) : "") . ";\n";
					}
					if ($_POST["format"] != "sql") {
						if ($style == "table") {
							dump_csv($keys);
							$style = "INSERT";
						}
						dump_csv($row);
					} else {
						if (!$insert) {
							$insert = "INSERT INTO " . table($table) . " (" . implode(", ", array_map('idf_escape', $keys)) . ") VALUES";
						}
						foreach ($row as $key => $val) {
							$field = $fields[$key];
							$row[$key] = ($val !== null
								? unconvert_field($field, ereg('(^|[^o])int|float|double|decimal', $field["type"]) && $val != '' ? $val : q($val))
								: "NULL"
							);
						}
						$s = ($max_packet ? "\n" : " ") . "(" . implode(",\t", $row) . ")";
						if (!$buffer) {
							$buffer = $insert . $s;
						} elseif (strlen($buffer) + 4 + strlen($s) + strlen($suffix) < $max_packet) { // 4 - length specification
							$buffer .= ",$s";
						} else {
							echo $buffer . $suffix;
							$buffer = $insert . $s;
						}
					}
				}
				if ($buffer) {
					echo $buffer . $suffix;
				}
			} elseif ($_POST["format"] == "sql") {
				echo "-- " . str_replace("\n", " ", $connection->error) . "\n";
			}
		}
	}
	
	/** Set export filename
	* @param string
	* @return string filename without extension
	*/
	function dumpFilename($identifier) {
		return friendly_url($identifier != "" ? $identifier : (SERVER != "" ? SERVER : "localhost"));
	}
	
	/** Send headers for export
	* @param string
	* @param bool
	* @return string extension
	*/
	function dumpHeaders($identifier, $multi_table = false) {
		$output = $_POST["output"];
		$ext = (ereg('sql', $_POST["format"]) ? "sql" : ($multi_table ? "tar" : "csv")); // multiple CSV packed to TAR
		header("Content-Type: " .
			($output == "gz" ? "application/x-gzip" :
			($ext == "tar" ? "application/x-tar" :
			($ext == "sql" || $output != "file" ? "text/plain" : "text/csv") . "; charset=utf-8"
		)));
		if ($output == "gz") {
			ob_start('gzencode', 1e6);
		}
		return $ext;
	}
	
	/** Print homepage
	* @return bool whether to print default homepage
	*/
	function homepage() {
		echo '<p>' . ($_GET["ns"] == "" ? '<a href="' . h(ME) . 'database=">' . lang(50) . "</a>\n" : "");
		echo (support("scheme") ? "<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? lang(51) : lang(52)) . "</a>\n" : "");
		echo ($_GET["ns"] !== "" ? '<a href="' . h(ME) . 'schema=">' . lang(53) . "</a>\n" : "");
		echo (support("privileges") ? "<a href='" . h(ME) . "privileges='>" . lang(54) . "</a>\n" : "");
		return true;
	}
	
	/** Prints navigation after Adminer title
	* @param string can be "auth" if there is no database connection, "db" if there is no database selected, "ns" with invalid schema
	* @return null
	*/
	function navigation($missing) {
		global $VERSION, $token, $jush, $drivers;
		?>
<h1>
<?php echo $this->name(); ?> <span class="version"><?php echo $VERSION; ?></span>
<a href="http://www.adminer.org/#download" id="version"><?php echo (version_compare($VERSION, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : ""); ?></a>
</h1>
<?php
		if ($missing == "auth") {
			$first = true;
			foreach ((array) $_SESSION["pwds"] as $driver => $servers) {
				foreach ($servers as $server => $usernames) {
					foreach ($usernames as $username => $password) {
						if ($password !== null) {
							if ($first) {
								echo "<p id='logins' onmouseover='menuOver(this, event);' onmouseout='menuOut(this);'>\n";
								$first = false;
							}
							$dbs = $_SESSION["db"][$driver][$server][$username];
							foreach (($dbs ? array_keys($dbs) : array("")) as $db) {
								echo "<a href='" . h(auth_url($driver, $server, $username, $db)) . "'>($drivers[$driver]) " . h($username . ($server != "" ? "@$server" : "") . ($db != "" ? " - $db" : "")) . "</a><br>\n";
							}
						}
					}
				}
			}
		} else {
			?>
<form action="" method="post">
<p class="logout">
<?php
			if (DB == "" || !$missing) {
				echo "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"])) . " title='" . lang(55) . "'>" . lang(47) . "</a>\n";
				if (support("dump")) {
					echo "<a href='" . h(ME) . "dump=" . urlencode(isset($_GET["table"]) ? $_GET["table"] : $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . ">" . lang(56) . "</a>\n";
				}
			}
			?>
<input type="submit" name="logout" value="<?php echo lang(57); ?>" id="logout">
<input type="hidden" name="token" value="<?php echo $token; ?>">
</p>
</form>
<?php
			$this->databasesPrint($missing);
			if ($_GET["ns"] !== "" && !$missing && DB != "") {
				echo '<p><a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . ">" . lang(58) . "</a>\n";
				$tables = table_status('', true);
				if (!$tables) {
					echo "<p class='message'>" . lang(7) . "\n";
				} else {
					$this->tablesPrint($tables);
					$links = array();
					foreach ($tables as $table => $type) {
						$links[] = preg_quote($table, '/');
					}
					echo "<script type='text/javascript'>\n";
					echo "var jushLinks = { $jush: [ '" . js_escape(ME) . "table=\$&', /\\b(" . implode("|", $links) . ")\\b/g ] };\n";
					foreach (array("bac", "bra", "sqlite_quo", "mssql_bra") as $val) {
						echo "jushLinks.$val = jushLinks.$jush;\n";
					}
					echo "</script>\n";
				}
			}
		}
	}
	
	/** Prints databases list in menu
	* @param string
	* @return null
	*/
	function databasesPrint($missing) {
		global $connection;
		$databases = $this->databases();
		?>
<form action="">
<p id="dbs">
<?php
		hidden_fields_get();
		$db_events = " onmousedown='dbMouseDown(event, this);' onchange='dbChange(this);'";
		echo ($databases
			? "<select name='db'$db_events>" . optionlist(array("" => "(" . lang(59) . ")") + $databases, DB) . "</select>"
			: '<input name="db" value="' . h(DB) . '" autocapitalize="off">'
		);
		echo "<input type='submit' value='" . lang(10) . "'" . ($databases ? " class='hidden'" : "") . ">\n";
		if ($missing != "db" && DB != "" && $connection->select_db(DB)) {
			if (support("scheme")) {
				echo "<br><select name='ns'$db_events>" . optionlist(array("" => "(" . lang(60) . ")") + schemas(), $_GET["ns"]) . "</select>";
				if ($_GET["ns"] != "") {
					set_schema($_GET["ns"]);
				}
			}
		}
		echo (isset($_GET["sql"]) ? '<input type="hidden" name="sql" value="">'
			: (isset($_GET["schema"]) ? '<input type="hidden" name="schema" value="">'
			: (isset($_GET["dump"]) ? '<input type="hidden" name="dump" value="">'
		: "")));
		echo "</p></form>\n";
	}
	
	/** Prints table list in menu
	* @param array result of table_status('', true)
	* @return null
	*/
	function tablesPrint($tables) {
		echo "<p id='tables' onmouseover='menuOver(this, event);' onmouseout='menuOut(this);'>\n";
		foreach ($tables as $table => $status) {
			echo '<a href="' . h(ME) . 'select=' . urlencode($table) . '"' . bold($_GET["select"] == $table || $_GET["edit"] == $table) . ">" . lang(61) . "</a> ";
			echo '<a href="' . h(ME) . 'table=' . urlencode($table) . '"' . bold(in_array($table, array($_GET["table"], $_GET["create"], $_GET["indexes"], $_GET["foreign"], $_GET["trigger"]))) . " title='" . lang(29) . "'>" . $this->tableName($status) . "</a><br>\n";
		}
	}
	
}

$adminer = (function_exists('adminer_object') ? adminer_object() : new Adminer);
if ($adminer->operators === null) {
	$adminer->operators = $operators;
}


/** Print HTML header
* @param string used in title, breadcrumb and heading, should be HTML escaped
* @param string
* @param mixed array("key" => "link=desc", "key2" => array("link", "desc")), null for nothing, false for driver only, true for driver and server
* @param string used after colon in title and heading, will be HTML escaped
* @return null
*/
function page_header($title, $error = "", $breadcrumb = array(), $title2 = "") {
	global $LANG, $adminer, $connection, $drivers;
	header("Content-Type: text/html; charset=utf-8");
	if ($adminer->headers()) {
		header("X-Frame-Options: deny"); // ClickJacking protection in IE8, Safari 4, Chrome 2, Firefox 3.6.9
		header("X-XSS-Protection: 0"); // prevents introducing XSS in IE8 by removing safe parts of the page
	}
	$title_all = $title . ($title2 != "" ? ": " . h($title2) : "");
	$title_page = strip_tags($title_all . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $adminer->name());
	?>
<!DOCTYPE html>
<html lang="<?php echo $LANG; ?>" dir="<?php echo lang(62); ?>">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta name="robots" content="noindex">
<title><?php echo $title_page; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo h(preg_replace("~\\?.*~", "", ME)) . "?file=default.css&amp;version=3.7.1"; ?>">
<style>
/** 
 * Alternative style for Adminer by paranoiq. 2009.
 */

#menu h1 {
  display: none !important;
}
/* defaults & fonts */
body {
    margin: 0; 
    line-height: 1.25em;
    font-size: 11pt; }
body, select, option, optgroup, button {
    font-family: Calibri, Arial, Helvetica, sans-serif; } /* IE6 */
input[type='submit'], input[type='reset'], input[type='button'], input[type='file'] {
    font-family: Calibri, Arial, Helvetica, sans-serif; }
input, textarea, pre, code, samp, kbd, var {
    font-family: Consolas, "Courier New", monospace;
    font-size: 10pt; } /* FF3 */

/* links */
a { 
    color: #007; }
a:visited { 
    color: #707; }
a:hover { 
    text-decoration: none; }
h1 a:visited { 
    color: #007; }

/* tables */
table { 
    margin: 0 12px 12px 0; 
    border: 1px #BBB solid;
    font-size: 90%; }
th {
    text-align: left; }
td, th {
	background-color: #FFF;
    padding: 1px 2px;
    border: 1px #DDD solid;
    border-width: 1px 0px 0px 1px; }
tr:first-child td, tr:first-child th {
    border-top-width: 0; }
td:first-child, th:first-child {
    border-left-width: 0; }
thead td, thead th { 
    background-color: #DDD;
    border: none; 
    border-bottom: 1px #BBB solid; }
thead tr:hover td, thead tr:hover th {
	background-color: #DDD !important; }
tr:nth-child(2n) td, tr:nth-child(2n) th,
.odd td, .odd th {
    background-color: #DEF; }
tr:hover td, tr:hover th {
    background-color: #BCD; }

/* forms */
fieldset { 
    display: inline; 
    vertical-align: top; 
    padding: 8px 12px; 
    margin: 0 8px 12px 0; 
    border: none;
    background-color: #DEF;
    position: relative;     /* IEx */
    padding-top: 14px; }    /* IEx */
fieldset, x:-moz-any-link {
    padding-top: 4px; }     /* .FF3 */
fieldset {
    %padding-top: 14px;}    /* ..IE6+7 */
legend {
    font-weight: bold; 
    color: #000;
    background-color: #FFF;
    position: absolute;     /* IEx */
    top: -0.666em;          /* IEx */
    left: 0.666em;          /* IEx */
    padding: 0px 4px; }
input[name='limit'], input[name*='length'] {
    width: 3em; 
    xtext-align: right; }
input[name='text_length'] {
    width: 5em; }           /* ~FF3 */
select + input, select + select {
    margin-left: 2px; }
input + label input, select + label input {
    margin-left: 4px; }
td input[type='checkbox']:first-child, td input[type='radio']:first-child {
    margin-left: 2px; }
label:hover {
    text-decoration: underline; }
fieldset div {
    margin-bottom: 2px; }
input[name='Comment'] { /* !!! */
	width: 24em; }
input[name='Auto_increment'] { /* !!! */
	width: 6em; }

/* other */
img { 
    vertical-align: middle; 
    margin: 0; 
    padding: 0; }
.error { 
    padding: 8px; 
    color: #F00; 
    background-color: #FEE; }
.message { 
    padding: 8px;  
    background-color: #DDD; }
.char { 
    color: #070; }
.date { 
    color: #707; }
.enum { 
    color: #077; }
.binary { 
    color: red; }
.jush-sql {
    padding: 2px 4px;
    margin-right: 4px;
    outline: 1px #BBB dashed;
    font-size: 9pt; }

/* structure */
#content { 
    margin: 28px 0 0 212px; 
    padding: 10px 20px 20px 0; }
h3 { 
    margin: 20px 0;
    font-weight: normal; 
    font-size: 130%; }

#lang { 
    height: 23px;
    width: 200px;
    display: block; 
    padding: 1px 0px; 
    position: absolute; 
    top: 0;
    left: 0;
    text-align: center; 
    background-color: #EEE;
	line-height: 1.25em; }
#lang select {
    font-size: 8pt; }

#breadcrumb { 
    margin: 0; 
    height: 21px;
    display: block; 
    position: absolute; 
    top: 0; 
    left: 212px;
    background-color: #DDD;
    padding: 2px 12px;
	line-height: 1.25em }

#menu {  
    position: absolute; 
    margin: 0;
    top: 38px; 
    left: 0; 
    width: 200px; 
    background-color: #DEF; }
#menu form { 
    margin: 0; }
#menu p { 
    padding-left: 8px;
    font-size: 10pt;
	border-bottom: none; }
#menu form p {
    padding-left: 0;
    text-align: center; }
h1 { 
    margin: 0; 
    color: #000;
    padding: 5px; 
    text-align: center;
    font-size: 14pt; 
	border-bottom: none; 
	background: transparent;
	font-style: italic; }
h1 .h1 {
	color: #000; }
h1 .h1:hover {
	text-decoration: underline; } 

h2 { 
    margin: 0;
    margin-bottom: 12px; 
    padding: 6px 12px;  
    font-weight: normal; 
    background-color: #BCD;
	border-bottom: none; }

#schema { 
    margin: 1.5em 0 0 220px;
    position: relative; }
#schema .table { 
    border: 1px solid #DDD;
    background-color: #DEF;
    padding: 0 2px; 
    cursor: move; 
    position: absolute; }
#schema .references { 
    position: absolute; }

/* controversial */
.js .hidden {
	display: inline; }
.js td.hidden, .js input.hidden {
	display: none; }
legend a {
	color: #000;
	text-decoration: none;
	cursor: default; }
legend a:hover {
	color: black; }
code {
	background: transparent; }

/* eye candy */
fieldset, legend, h2, table, .error, .message {
    -moz-border-radius: 5px;
	-khtml-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px; }
#breadcrumb, #lang, #menu {
    -moz-border-radius-bottomright: 5px;
	-khtml-border-bottom-right-radius: 5px;
	-webkit-border-bottom-right-radius: 5px;
	border-bottom-right-radius: 5px; }
#breadcrumb {
    -moz-border-radius-bottomleft: 5px;
	-khtml-border-bottom-left-radius: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-bottom-left-radius: 5px; }
#menu {
    -moz-border-radius-topright: 5px;
	-khtml-border-top-right-radius: 5px;
	-webkit-border-top-right-radius: 5px;
	border-bottom-top-radius: 5px; }
</style>
<script type="text/javascript" src="<?php echo h(preg_replace("~\\?.*~", "", ME)) . "?file=functions.js&amp;version=3.7.1"; ?>"></script>
<?php if ($adminer->head()) { ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo h(preg_replace("~\\?.*~", "", ME)) . "?file=favicon.ico&amp;version=3.7.1"; ?>">
<link rel="apple-touch-icon" href="<?php echo h(preg_replace("~\\?.*~", "", ME)) . "?file=favicon.ico&amp;version=3.7.1"; ?>">
<?php if (file_exists("adminer.css")) { ?>
<link rel="stylesheet" type="text/css" href="adminer.css">
<?php }  } ?>

<body class="<?php echo lang(62); ?> nojs" onkeydown="bodyKeydown(event);" onclick="bodyClick(event);" onload="bodyLoad('<?php echo (is_object($connection) ? substr($connection->server_info, 0, 3) : ""); ?>');<?php echo (isset($_COOKIE["adminer_version"]) ? "" : " verifyVersion();"); ?>">
<script type="text/javascript">
document.body.className = document.body.className.replace(/ nojs/, ' js');
</script>

<div id="content">
<?php
	if ($breadcrumb !== null) {
		$link = substr(preg_replace('~(username|db|ns)=[^&]*&~', '', ME), 0, -1);
		echo '<p id="breadcrumb"><a href="' . h($link ? $link : ".") . '">' . $drivers[DRIVER] . '</a> &raquo; ';
		$link = substr(preg_replace('~(db|ns)=[^&]*&~', '', ME), 0, -1);
		$server = (SERVER != "" ? h(SERVER) : lang(22));
		if ($breadcrumb === false) {
			echo "$server\n";
		} else {
			echo "<a href='" . ($link ? h($link) : ".") . "' accesskey='1' title='Alt+Shift+1'>$server</a> &raquo; ";
			if ($_GET["ns"] != "" || (DB != "" && is_array($breadcrumb))) {
				echo '<a href="' . h($link . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> &raquo; ';
			}
			if (is_array($breadcrumb)) {
				if ($_GET["ns"] != "") {
					echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> &raquo; ';
				}
				foreach ($breadcrumb as $key => $val) {
					$desc = (is_array($val) ? $val[1] : $val);
					if ($desc != "") {
						echo '<a href="' . h(ME . "$key=") . urlencode(is_array($val) ? $val[0] : $val) . '">' . h($desc) . '</a> &raquo; ';
					}
				}
			}
			echo "$title\n";
		}
	}
	echo "<h2>$title_all</h2>\n";
	restart_session();
	$uri = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
	$messages = $_SESSION["messages"][$uri];
	if ($messages) {
		echo "<div class='message'>" . implode("</div>\n<div class='message'>", $messages) . "</div>\n";
		unset($_SESSION["messages"][$uri]);
	}
	$databases = &get_session("dbs");
	if (DB != "" && $databases && !in_array(DB, $databases, true)) {
		$databases = null;
	}
	stop_session();
	if ($error) {
		echo "<div class='error'>$error</div>\n";
	}
	define("PAGE_HEADER", 1);
}

/** Print HTML footer
* @param string "auth", "db", "ns"
* @return null
*/
function page_footer($missing = "") {
	global $adminer;
	?>
</div>

<?php switch_lang(); ?>
<div id="menu">
<?php $adminer->navigation($missing); ?>
</div>
<script type="text/javascript">setupSubmitHighlight(document);</script>
<?php
}


/** PHP implementation of XXTEA encryption algorithm
* @author Ma Bingyao <andot@ujn.edu.cn>
* @link http://www.coolcode.cn/?action=show&id=128
*/

function int32($n) {
	while ($n >= 2147483648) {
		$n -= 4294967296;
	}
	while ($n <= -2147483649) {
		$n += 4294967296;
	}
	return (int) $n;
}

function long2str($v, $w) {
	$s = '';
	foreach ($v as $val) {
		$s .= pack('V', $val);
	}
	if ($w) {
		return substr($s, 0, end($v));
	}
	return $s;
}

function str2long($s, $w) {
	$v = array_values(unpack('V*', str_pad($s, 4 * ceil(strlen($s) / 4), "\0")));
	if ($w) {
		$v[] = strlen($s);
	}
	return $v;
}

function xxtea_mx($z, $y, $sum, $k) {
	return int32((($z >> 5 & 0x7FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k ^ $z));
}

/** Cipher
* @param string plain-text password
* @param string
* @return string binary cipher
*/
function encrypt_string($str, $key) {
	if ($str == "") {
		return "";
	}
	$key = array_values(unpack("V*", pack("H*", md5($key))));
	$v = str2long($str, true);
	$n = count($v) - 1;
	$z = $v[$n];
	$y = $v[0];
	$q = floor(6 + 52 / ($n + 1));
	$sum = 0;
	while ($q-- > 0) {
		$sum = int32($sum + 0x9E3779B9);
		$e = $sum >> 2 & 3;
		for ($p=0; $p < $n; $p++) {
			$y = $v[$p + 1];
			$mx = xxtea_mx($z, $y, $sum, $key[$p & 3 ^ $e]);
			$z = int32($v[$p] + $mx);
			$v[$p] = $z;
		}
		$y = $v[0];
		$mx = xxtea_mx($z, $y, $sum, $key[$p & 3 ^ $e]);
		$z = int32($v[$n] + $mx);
		$v[$n] = $z;
	}
	return long2str($v, false);
}

/** Decipher
* @param string binary cipher
* @param string
* @return string plain-text password
*/
function decrypt_string($str, $key) {
	if ($str == "") {
		return "";
	}
	if (!$key) {
		return false;
	}
	$key = array_values(unpack("V*", pack("H*", md5($key))));
	$v = str2long($str, false);
	$n = count($v) - 1;
	$z = $v[$n];
	$y = $v[0];
	$q = floor(6 + 52 / ($n + 1));
	$sum = int32($q * 0x9E3779B9);
	while ($sum) {
		$e = $sum >> 2 & 3;
		for ($p=$n; $p > 0; $p--) {
			$z = $v[$p - 1];
			$mx = xxtea_mx($z, $y, $sum, $key[$p & 3 ^ $e]);
			$y = int32($v[$p] - $mx);
			$v[$p] = $y;
		}
		$z = $v[$n];
		$mx = xxtea_mx($z, $y, $sum, $key[$p & 3 ^ $e]);
		$y = int32($v[0] - $mx);
		$v[0] = $y;
		$sum = int32($sum - 0x9E3779B9);
	}
	return long2str($v, true);
}


$connection = '';

$token = $_SESSION["token"];
if (!$_SESSION["token"]) {
	$_SESSION["token"] = rand(1, 1e6); // defense against cross-site request forgery
}

$permanent = array();
if ($_COOKIE["adminer_permanent"]) {
	foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $val) {
		list($key) = explode(":", $val);
		$permanent[$key] = $val;
	}
}

$auth = $_POST["auth"];
if ($auth) {
	session_regenerate_id(); // defense against session fixation
	$_SESSION["pwds"][$auth["driver"]][$auth["server"]][$auth["username"]] = $auth["password"];
	$_SESSION["db"][$auth["driver"]][$auth["server"]][$auth["username"]][$auth["db"]] = true;
	if ($auth["permanent"]) {
		$key = base64_encode($auth["driver"]) . "-" . base64_encode($auth["server"]) . "-" . base64_encode($auth["username"]) . "-" . base64_encode($auth["db"]);
		$private = $adminer->permanentLogin(true);
		$permanent[$key] = "$key:" . base64_encode($private ? encrypt_string($auth["password"], $private) : "");
		cookie("adminer_permanent", implode(" ", $permanent));
	}
	if (count($_POST) == 1 // 1 - auth
		|| DRIVER != $auth["driver"]
		|| SERVER != $auth["server"]
		|| $_GET["username"] !== $auth["username"] // "0" == "00"
		|| DB != $auth["db"]
	) {
		redirect(auth_url($auth["driver"], $auth["server"], $auth["username"], $auth["db"]));
	}
	
} elseif ($_POST["logout"]) {
	if ($token && $_POST["token"] != $token) {
		page_header(lang(57), lang(63));
		page_footer("db");
		exit;
	} else {
		foreach (array("pwds", "db", "dbs", "queries") as $key) {
			set_session($key, null);
		}
		unset_permanent();
		redirect(substr(preg_replace('~(username|db|ns)=[^&]*&~', '', ME), 0, -1), lang(64));
	}
	
} elseif ($permanent && !$_SESSION["pwds"]) {
	session_regenerate_id();
	$private = $adminer->permanentLogin();
	foreach ($permanent as $key => $val) {
		list(, $cipher) = explode(":", $val);
		list($driver, $server, $username, $db) = array_map('base64_decode', explode("-", $key));
		$_SESSION["pwds"][$driver][$server][$username] = decrypt_string(base64_decode($cipher), $private);
		$_SESSION["db"][$driver][$server][$username][$db] = true;
	}
}

function unset_permanent() {
	global $permanent;
	foreach ($permanent as $key => $val) {
		list($driver, $server, $username, $db) = array_map('base64_decode', explode("-", $key));
		if ($driver == DRIVER && $server == SERVER && $username == $_GET["username"] && $db == DB) {
			unset($permanent[$key]);
		}
	}
	cookie("adminer_permanent", implode(" ", $permanent));
}

function auth_error($exception = null) {
	global $connection, $adminer, $token;
	$session_name = session_name();
	$error = "";
	if (!$_COOKIE[$session_name] && $_GET[$session_name] && ini_bool("session.use_only_cookies")) {
		$error = lang(65);
	} elseif (isset($_GET["username"])) {
		if (($_COOKIE[$session_name] || $_GET[$session_name]) && !$token) {
			$error = lang(66);
		} else {
			$password = &get_session("pwds");
			if ($password !== null) {
				$error = h($exception ? $exception->getMessage() : (is_string($connection) ? $connection : lang(67)));
				if ($password === false) {
					$error .= '<br>' . lang(68, '<code>permanentLogin()</code>');
				}
				$password = null;
			}
			unset_permanent();
		}
	}
	page_header(lang(26), $error, null);
	echo "<form action='' method='post'>\n";
	$adminer->loginForm();
	echo "<div>";
	hidden_fields($_POST, array("auth")); // expired session
	echo "</div>\n";
	echo "</form>\n";
	page_footer("auth");
}

if (isset($_GET["username"])) {
	if (!class_exists("Min_DB")) {
		unset($_SESSION["pwds"][DRIVER]);
		unset_permanent();
		page_header(lang(69), lang(70, implode(", ", $possible_drivers)), false);
		page_footer("auth");
		exit;
	}
	$connection = connect();
}

if (is_string($connection) || !$adminer->login($_GET["username"], get_session("pwds"))) {
	auth_error();
	exit;
}

$token = $_SESSION["token"]; ///< @var string CSRF protection
if ($auth && $_POST["token"]) {
	$_POST["token"] = $token; // reset token after explicit login
}

$error = ''; ///< @var string
if ($_POST) {
	if ($_POST["token"] != $token) {
		$ini = "max_input_vars";
		$max_vars = ini_get($ini);
		if (extension_loaded("suhosin")) {
			foreach (array("suhosin.request.max_vars", "suhosin.post.max_vars") as $key) {
				$val = ini_get($key);
				if ($val && (!$max_vars || $val < $max_vars)) {
					$ini = $key;
					$max_vars = $val;
				}
			}
		}
		$error = (!$_POST["token"] && $max_vars
			? lang(71, "'$ini'")
			: lang(63)
		);
	}
	
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
	// posted form with no data means that post_max_size exceeded because Adminer always sends token at least
	$error = lang(72, "'post_max_size'");
	if (isset($_GET["sql"])) {
		$error .= ' ' . lang(73);
	}
}


if (!ini_bool("session.use_cookies") || @ini_set("session.use_cookies", false) !== false) { // @ - may be disabled
	session_cache_limiter(""); // to allow restarting session
	session_write_close(); // improves concurrency if a user opens several pages at once, may be restarted later
}


function connect_error() {
	global $adminer, $connection, $token, $error, $drivers;
	$databases = array();
	if (DB != "") {
		header("HTTP/1.1 404 Not Found");
		page_header(lang(25) . ": " . h(DB), lang(74), true);
	} else {
		if ($_POST["db"] && !$error) {
			queries_redirect(substr(ME, 0, -1), lang(75), drop_databases($_POST["db"]));
		}
		
		page_header(lang(76), $error, false);
		echo "<p><a href='" . h(ME) . "database='>" . lang(77) . "</a>\n";
		foreach (array(
			'privileges' => lang(54),
			'processlist' => lang(78),
			'variables' => lang(79),
			'status' => lang(80),
		) as $key => $val) {
			if (support($key)) {
				echo "<a href='" . h(ME) . "$key='>$val</a>\n";
			}
		}
		echo "<p>" . lang(81, $drivers[DRIVER], "<b>$connection->server_info</b>", "<b>$connection->extension</b>") . "\n";
		echo "<p>" . lang(82, "<b>" . h(logged_user()) . "</b>") . "\n";
		$refresh = "<a href='" . h(ME) . "refresh=1'>" . lang(83) . "</a>\n";
		$databases = $adminer->databases();
		if ($databases) {
			$scheme = support("scheme");
			$collations = collations();
			echo "<form action='' method='post'>\n";
			echo "<table cellspacing='0' class='checkable' onclick='tableClick(event);' ondblclick='tableClick(event, true);'>\n";
			echo "<thead><tr><td>&nbsp;<th>" . lang(25) . "<td>" . lang(84) . "<td>" . lang(85) . "</thead>\n";
			
			foreach ($databases as $db) {
				$root = h(ME) . "db=" . urlencode($db);
				echo "<tr" . odd() . "><td>" . checkbox("db[]", $db, in_array($db, (array) $_POST["db"]));
				echo "<th><a href='$root'>" . h($db) . "</a>";
				echo "<td><a href='$root" . ($scheme ? "&amp;ns=" : "") . "&amp;database=' title='" . lang(50) . "'>" . nbsp(db_collation($db, $collations)) . "</a>";
				echo "<td align='right'><a href='$root&amp;schema=' id='tables-" . h($db) . "' title='" . lang(53) . "'>?</a>";
				echo "\n";
			}
			
			echo "</table>\n";
			echo "<script type='text/javascript'>tableCheck();</script>\n";
			echo "<p><input type='submit' name='drop' value='" . lang(86) . "'" . confirm("formChecked(this, /db/)") . ">\n";
			echo "<input type='hidden' name='token' value='$token'>\n";
			echo $refresh;
			echo "</form>\n";
		} else {
			echo "<p>$refresh";
		}
	}
	
	page_footer("db");
	if ($databases) {
		echo "<script type='text/javascript'>ajaxSetHtml('" . js_escape(ME) . "script=connect');</script>\n";
	}
}

if (isset($_GET["status"])) {
	$_GET["variables"] = $_GET["status"];
}
if (!(DB != "" ? $connection->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
	if (DB != "" || $_GET["refresh"]) {
		restart_session();
		set_session("dbs", null);
	}
	connect_error(); // separate function to catch SQLite error
	exit;
}

if (support("scheme") && DB != "" && $_GET["ns"] !== "") {
	if (!isset($_GET["ns"])) {
		redirect(preg_replace('~ns=[^&]*&~', '', ME) . "ns=" . get_schema());
	}
	if (!set_schema($_GET["ns"])) {
		header("HTTP/1.1 404 Not Found");
		page_header(lang(87) . ": " . h($_GET["ns"]), lang(88), true);
		page_footer("ns");
		exit;
	}
}


/** Print select result
* @param Min_Result
* @param Min_DB connection to examine indexes
* @param string base link for <th> fields
* @param array
* @return null
*/
function select($result, $connection2 = null, $href = "", $orgtables = array()) {
	$links = array(); // colno => orgtable - create links from these columns
	$indexes = array(); // orgtable => array(column => colno) - primary keys
	$columns = array(); // orgtable => array(column => ) - not selected columns in primary key
	$blobs = array(); // colno => bool - display bytes for blobs
	$types = array(); // colno => type - display char in <code>
	$return = array(); // table => orgtable - mapping to use in EXPLAIN
	odd(''); // reset odd for each result
	for ($i=0; $row = $result->fetch_row(); $i++) {
		if (!$i) {
			echo "<table cellspacing='0' class='nowrap'>\n";
			echo "<thead><tr>";
			for ($j=0; $j < count($row); $j++) {
				$field = $result->fetch_field();
				$name = $field->name;
				$orgtable = $field->orgtable;
				$orgname = $field->orgname;
				$return[$field->table] = $orgtable;
				if ($href) { // MySQL EXPLAIN
					$links[$j] = ($name == "table" ? "table=" : ($name == "possible_keys" ? "indexes=" : null));
				} elseif ($orgtable != "") {
					if (!isset($indexes[$orgtable])) {
						// find primary key in each table
						$indexes[$orgtable] = array();
						foreach (indexes($orgtable, $connection2) as $index) {
							if ($index["type"] == "PRIMARY") {
								$indexes[$orgtable] = array_flip($index["columns"]);
								break;
							}
						}
						$columns[$orgtable] = $indexes[$orgtable];
					}
					if (isset($columns[$orgtable][$orgname])) {
						unset($columns[$orgtable][$orgname]);
						$indexes[$orgtable][$orgname] = $j;
						$links[$j] = $orgtable;
					}
				}
				if ($field->charsetnr == 63) { // 63 - binary
					$blobs[$j] = true;
				}
				$types[$j] = $field->type;
				$name = h($name);
				echo "<th" . ($orgtable != "" || $field->name != $orgname ? " title='" . h(($orgtable != "" ? "$orgtable." : "") . $orgname) . "'" : "") . ">"
					. ($href ? "<a href='$href" . strtolower($name) . "' target='_blank' rel='noreferrer' class='help'>$name</a>" : $name)
				;
			}
			echo "</thead>\n";
		}
		echo "<tr" . odd() . ">";
		foreach ($row as $key => $val) {
			if ($val === null) {
				$val = "<i>NULL</i>";
			} elseif ($blobs[$key] && !is_utf8($val)) {
				$val = "<i>" . lang(35, strlen($val)) . "</i>"; //! link to download
			} elseif (!strlen($val)) { // strlen - SQLite can return int
				$val = "&nbsp;"; // some content to print a border
			} else {
				$val = h($val);
				if ($types[$key] == 254) { // 254 - char
					$val = "<code>$val</code>";
				}
			}
			if (isset($links[$key]) && !$columns[$links[$key]]) {
				if ($href) { // MySQL EXPLAIN
					$table = $row[array_search("table=", $links)];
					$link = $links[$key] . urlencode($orgtables[$table] != "" ? $orgtables[$table] : $table);
				} else {
					$link = "edit=" . urlencode($links[$key]);
					foreach ($indexes[$links[$key]] as $col => $j) {
						$link .= "&where" . urlencode("[" . bracket_escape($col) . "]") . "=" . urlencode($row[$j]);
					}
				}
				$val = "<a href='" . h(ME . $link) . "'>$val</a>";
			}
			echo "<td>$val";
		}
	}
	echo ($i ? "</table>" : "<p class='message'>" . lang(89)) . "\n";
	return $return;
}

/** Get referencable tables with single column primary key except self
* @param string
* @return array ($table_name => $field)
*/
function referencable_primary($self) {
	$return = array(); // table_name => field
	foreach (table_status('', true) as $table_name => $table) {
		if ($table_name != $self && fk_support($table)) {
			foreach (fields($table_name) as $field) {
				if ($field["primary"]) {
					if ($return[$table_name]) { // multi column primary key
						unset($return[$table_name]);
						break;
					}
					$return[$table_name] = $field;
				}
			}
		}
	}
	return $return;
}

/** Print SQL <textarea> tag
* @param string
* @param int
* @param int
* @param string
* @return null
*/
function textarea($name, $value, $rows = 10, $cols = 80) {
	echo "<textarea name='$name' rows='$rows' cols='$cols' class='sqlarea' spellcheck='false' wrap='off' onkeydown='return textareaKeydown(this, event);'>"; // spellcheck, wrap - not valid before HTML5
	if (is_array($value)) {
		foreach ($value as $val) { // not implode() to save memory
			echo h($val[0]) . "\n\n\n"; // $val == array($query, $time)
		}
	} else {
		echo h($value);
	}
	echo "</textarea>";
}

/** Print table columns for type edit
* @param string
* @param array
* @param array
* @param array returned by referencable_primary()
* @return null
*/
function edit_type($key, $field, $collations, $foreign_keys = array()) {
	global $structured_types, $types, $unsigned, $on_actions;
	?>
<td><select name="<?php echo $key; ?>[type]" class="type" onfocus="lastType = selectValue(this);" onchange="editingTypeChange(this);"><?php echo optionlist((!$field["type"] || isset($types[$field["type"]]) ? array() : array($field["type"])) + $structured_types + ($foreign_keys ? array(lang(90) => $foreign_keys) : array()), $field["type"]); ?></select>
<td><input name="<?php echo $key; ?>[length]" value="<?php echo h($field["length"]); ?>" size="3" onfocus="editingLengthFocus(this);"><td class="options"><?php //! type="number" with enabled JavaScript
	echo "<select name='$key" . "[collation]'" . (ereg('(char|text|enum|set)$', $field["type"]) ? "" : " class='hidden'") . '><option value="">(' . lang(91) . ')' . optionlist($collations, $field["collation"]) . '</select>';
	echo ($unsigned ? "<select name='$key" . "[unsigned]'" . (!$field["type"] || ereg('((^|[^o])int|float|double|decimal)$', $field["type"]) ? "" : " class='hidden'") . '><option>' . optionlist($unsigned, $field["unsigned"]) . '</select>' : '');
	echo (isset($field['on_update']) ? "<select name='$key" . "[on_update]'" . ($field["type"] == "timestamp" ? "" : " class='hidden'") . '>' . optionlist(array("" => "(" . lang(92) . ")", "CURRENT_TIMESTAMP"), $field["on_update"]) . '</select>' : '');
	echo ($foreign_keys ? "<select name='$key" . "[on_delete]'" . (ereg("`", $field["type"]) ? "" : " class='hidden'") . "><option value=''>(" . lang(93) . ")" . optionlist(explode("|", $on_actions), $field["on_delete"]) . "</select> " : " "); // space for IE
}

/** Filter length value including enums
* @param string
* @return string
*/
function process_length($length) {
	global $enum_length;
	return (preg_match("~^\\s*(?:$enum_length)(?:\\s*,\\s*(?:$enum_length))*\\s*\$~", $length) && preg_match_all("~$enum_length~", $length, $matches) ? implode(",", $matches[0]) : preg_replace('~[^0-9,+-]~', '', $length));
}

/** Create SQL string from field type
* @param array
* @param string
* @return string
*/
function process_type($field, $collate = "COLLATE") {
	global $unsigned;
	return " $field[type]"
		. ($field["length"] != "" ? "(" . process_length($field["length"]) . ")" : "")
		. (ereg('(^|[^o])int|float|double|decimal', $field["type"]) && in_array($field["unsigned"], $unsigned) ? " $field[unsigned]" : "")
		. (ereg('char|text|enum|set', $field["type"]) && $field["collation"] ? " $collate " . q($field["collation"]) : "")
	;
}

/** Create SQL string from field
* @param array basic field information
* @param array information about field type
* @return array array("field", "type", "NULL", "DEFAULT", "ON UPDATE", "COMMENT", "AUTO_INCREMENT")
*/
function process_field($field, $type_field) {
	return array(
		idf_escape(trim($field["field"])),
		process_type($type_field),
		($field["null"] ? " NULL" : " NOT NULL"), // NULL for timestamp
		(isset($field["default"]) ? " DEFAULT " . ((ereg("time", $field["type"]) && eregi('^CURRENT_TIMESTAMP$', $field["default"])) || ($field["type"] == "bit" && ereg("^([0-9]+|b'[0-1]+')\$", $field["default"])) ? $field["default"] : q($field["default"])) : ""),
		($field["type"] == "timestamp" && $field["on_update"] ? " ON UPDATE $field[on_update]" : ""),
		(support("comment") && $field["comment"] != "" ? " COMMENT " . q($field["comment"]) : ""),
		($field["auto_increment"] ? auto_increment() : null),
	);
}

/** Get type class to use in CSS
* @param string
* @return string class=''
*/
function type_class($type) {
	foreach (array(
		'char' => 'text',
		'date' => 'time|year',
		'binary' => 'blob',
		'enum' => 'set',
	) as $key => $val) {
		if (ereg("$key|$val", $type)) {
			return " class='$key'";
		}
	}
}

/** Print table interior for fields editing
* @param array
* @param array
* @param string TABLE or PROCEDURE
* @param array returned by referencable_primary()
* @param bool display comments column
* @return null
*/
function edit_fields($fields, $collations, $type = "TABLE", $foreign_keys = array(), $comments = false) {
	global $connection, $inout;
	?>
<thead><tr class="wrap">
<?php if ($type == "PROCEDURE") { ?><td>&nbsp;<?php } ?>
<th><?php echo ($type == "TABLE" ? lang(94) : lang(95)); ?>
<td><?php echo lang(96); ?><textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;" onblur="editingLengthBlur(this);"></textarea>
<td><?php echo lang(97); ?>
<td><?php echo lang(98);  if ($type == "TABLE") { ?>
<td>NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym title="<?php echo lang(99); ?>">AI</acronym>
<td><?php echo lang(100);  echo (support("comment") ? "<td" . ($comments ? "" : " class='hidden'") . ">" . lang(101) : "");  } ?>
<td><?php echo "<input type='image' class='icon' name='add[" . (support("move_col") ? 0 : count($fields)) . "]' src='" . h(preg_replace("~\\?.*~", "", ME)) . "?file=plus.gif&amp;version=3.7.1' alt='+' title='" . lang(102) . "'>"; ?><script type="text/javascript">row_count = <?php echo count($fields); ?>;</script>
</thead>
<tbody onkeydown="return editingKeydown(event);">
<?php
	foreach ($fields as $i => $field) {
		$i++;
		$orig = $field[($_POST ? "orig" : "field")];
		$display = (isset($_POST["add"][$i-1]) || (isset($field["field"]) && !$_POST["drop_col"][$i])) && (support("drop_col") || $orig == "");
		?>
<tr<?php echo ($display ? "" : " style='display: none;'"); ?>>
<?php echo ($type == "PROCEDURE" ? "<td>" . html_select("fields[$i][inout]", explode("|", $inout), $field["inout"]) : ""); ?>
<th><?php if ($display) { ?><input name="fields[<?php echo $i; ?>][field]" value="<?php echo h($field["field"]); ?>" onchange="<?php echo ($field["field"] != "" || count($fields) > 1 ? "" : "editingAddRow(this); "); ?>editingNameChange(this);" maxlength="64" autocapitalize="off"><?php } ?><input type="hidden" name="fields[<?php echo $i; ?>][orig]" value="<?php echo h($orig); ?>">
<?php edit_type("fields[$i]", $field, $collations, $foreign_keys);  if ($type == "TABLE") { ?>
<td><?php echo checkbox("fields[$i][null]", 1, $field["null"], "", "", "block"); ?>
<td><label class="block"><input type="radio" name="auto_increment_col" value="<?php echo $i; ?>"<?php if ($field["auto_increment"]) { ?> checked<?php } ?> onclick="var field = this.form['fields[' + this.value + '][field]']; if (!field.value) { field.value = 'id'; field.onchange(); }"></label><td><?php
echo checkbox("fields[$i][has_default]", 1, $field["has_default"]); ?><input name="fields[<?php echo $i; ?>][default]" value="<?php echo h($field["default"]); ?>" onchange="this.previousSibling.checked = true;">
<?php echo (support("comment") ? "<td" . ($comments ? "" : " class='hidden'") . "><input name='fields[$i][comment]' value='" . h($field["comment"]) . "' maxlength='" . ($connection->server_info >= 5.5 ? 1024 : 255) . "'>" : "");  } 
		echo "<td>";
		echo (support("move_col") ?
			"<input type='image' class='icon' name='add[$i]' src='" . h(preg_replace("~\\?.*~", "", ME)) . "?file=plus.gif&amp;version=3.7.1' alt='+' title='" . lang(102) . "' onclick='return !editingAddRow(this, 1);'>&nbsp;"
			. "<input type='image' class='icon' name='up[$i]' src='" . h(preg_replace("~\\?.*~", "", ME)) . "?file=up.gif&amp;version=3.7.1' alt='^' title='" . lang(103) . "'>&nbsp;"
			. "<input type='image' class='icon' name='down[$i]' src='" . h(preg_replace("~\\?.*~", "", ME)) . "?file=down.gif&amp;version=3.7.1' alt='v' title='" . lang(104) . "'>&nbsp;"
		: "");
		echo ($orig == "" || support("drop_col") ? "<input type='image' class='icon' name='drop_col[$i]' src='" . h(preg_replace("~\\?.*~", "", ME)) . "?file=cross.gif&amp;version=3.7.1' alt='x' title='" . lang(105) . "' onclick='return !editingRemoveRow(this);'>" : "");
		echo "\n";
	}
}

/** Move fields up and down or add field
* @param array
* @return bool
*/
function process_fields(&$fields) {
	ksort($fields);
	$offset = 0;
	if ($_POST["up"]) {
		$last = 0;
		foreach ($fields as $key => $field) {
			if (key($_POST["up"]) == $key) {
				unset($fields[$key]);
				array_splice($fields, $last, 0, array($field));
				break;
			}
			if (isset($field["field"])) {
				$last = $offset;
			}
			$offset++;
		}
	} elseif ($_POST["down"]) {
		$found = false;
		foreach ($fields as $key => $field) {
			if (isset($field["field"]) && $found) {
				unset($fields[key($_POST["down"])]);
				array_splice($fields, $offset, 0, array($found));
				break;
			}
			if (key($_POST["down"]) == $key) {
				$found = $field;
			}
			$offset++;
		}
	} elseif ($_POST["add"]) {
		$fields = array_values($fields);
		array_splice($fields, key($_POST["add"]), 0, array(array()));
	} elseif (!$_POST["drop_col"]) {
		return false;
	}
	return true;
}

/** Callback used in routine()
* @param array
* @return string
*/
function normalize_enum($match) {
	return "'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($match[0][0] . $match[0][0], $match[0][0], substr($match[0], 1, -1))), '\\')) . "'";
}

/** Issue grant or revoke commands
* @param string GRANT or REVOKE
* @param array
* @param string
* @param string
* @return bool
*/
function grant($grant, $privileges, $columns, $on) {
	if (!$privileges) {
		return true;
	}
	if ($privileges == array("ALL PRIVILEGES", "GRANT OPTION")) {
		// can't be granted or revoked together
		return ($grant == "GRANT"
			? queries("$grant ALL PRIVILEGES$on WITH GRANT OPTION")
			: queries("$grant ALL PRIVILEGES$on") && queries("$grant GRANT OPTION$on")
		);
	}
	return queries("$grant " . preg_replace('~(GRANT OPTION)\\([^)]*\\)~', '\\1', implode("$columns, ", $privileges) . $columns) . $on);
}

/** Drop old object and create a new one
* @param string drop old object query
* @param string create new object query
* @param string drop new object query
* @param string create test object query
* @param string drop test object query
* @param string
* @param string
* @param string
* @param string
* @param string
* @param string
* @return null redirect in success
*/
function drop_create($drop, $create, $drop_created, $test, $drop_test, $location, $message_drop, $message_alter, $message_create, $old_name, $new_name) {
	if ($_POST["drop"]) {
		query_redirect($drop, $location, $message_drop);
	} elseif ($old_name == "") {
		query_redirect($create, $location, $message_create);
	} elseif ($old_name != $new_name) {
		$created = queries($create);
		queries_redirect($location, $message_alter, $created && queries($drop));
		if ($created) {
			queries($drop_created);
		}
	} else {
		queries_redirect(
			$location,
			$message_alter,
			queries($test) && queries($drop_test) && queries($drop) && queries($create)
		);
	}
}

/** Generate SQL query for creating trigger
* @param string
* @param array result of trigger()
* @return string
*/
function create_trigger($on, $row) {
	global $jush;
	$timing_event = " $row[Timing] $row[Event]";
	return "CREATE TRIGGER "
		. idf_escape($row["Trigger"])
		. ($jush == "mssql" ? $on . $timing_event : $timing_event . $on)
		. rtrim(" $row[Type]\n$row[Statement]", ";")
		. ";"
	;
}

/** Generate SQL query for creating routine
* @param string "PROCEDURE" or "FUNCTION"
* @param array result of routine()
* @return string
*/
function create_routine($routine, $row) {
	global $inout;
	$set = array();
	$fields = (array) $row["fields"];
	ksort($fields); // enforce fields order
	foreach ($fields as $field) {
		if ($field["field"] != "") {
			$set[] = (ereg("^($inout)\$", $field["inout"]) ? "$field[inout] " : "") . idf_escape($field["field"]) . process_type($field, "CHARACTER SET");
		}
	}
	return "CREATE $routine "
		. idf_escape(trim($row["name"]))
		. " (" . implode(", ", $set) . ")"
		. (isset($_GET["function"]) ? " RETURNS" . process_type($row["returns"], "CHARACTER SET") : "")
		. ($row["language"] ? " LANGUAGE $row[language]" : "")
		. rtrim("\n$row[definition]", ";")
		. ";"
	;
}

/** Remove current user definer from SQL command
 * @param string
 * @return string
 */
function remove_definer($query) {
	return preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\\1)', logged_user()) . '`~', '\\1', $query); //! proper escaping of user
}

/** Add a file to TAR
* @param string
* @param TmpFile
* @return null prints the output
*/
function tar_file($filename, $tmp_file) {
	$return = pack("a100a8a8a8a12a12", $filename, 644, 0, 0, decoct($tmp_file->size), decoct(time()));
	$checksum = 8*32; // space for checksum itself
	for ($i=0; $i < strlen($return); $i++) {
		$checksum += ord($return[$i]);
	}
	$return .= sprintf("%06o", $checksum) . "\0 ";
	echo $return;
	echo str_repeat("\0", 512 - strlen($return));
	$tmp_file->send();
	echo str_repeat("\0", 511 - ($tmp_file->size + 511) % 512);
}

/** Get INI bytes value
* @param string
* @return int
*/
function ini_bytes($ini) {
	$val = ini_get($ini);
	switch (strtolower(substr($val, -1))) {
		case 'g': $val *= 1024; // no break
		case 'm': $val *= 1024; // no break
		case 'k': $val *= 1024;
	}
	return $val;
}


$on_actions = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT"; ///< @var string used in foreign_keys()



class TmpFile {
	var $handler;
	var $size;
	
	function TmpFile() {
		$this->handler = tmpfile();
	}
	
	function write($contents) {
		$this->size += strlen($contents);
		fwrite($this->handler, $contents);
	}
	
	function send() {
		fseek($this->handler, 0);
		fpassthru($this->handler);
		fclose($this->handler);
	}
	
}


$enum_length = "'(?:''|[^'\\\\]|\\\\.)*+'";
$inout = "IN|OUT|INOUT";

if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) {
	$_GET["edit"] = $_GET["select"];
}
if (isset($_GET["callf"])) {
	$_GET["call"] = $_GET["callf"];
}
if (isset($_GET["function"])) {
	$_GET["procedure"] = $_GET["function"];
}

if (isset($_GET["download"])) {
	
$TABLE = $_GET["download"];
$fields = fields($TABLE);
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . friendly_url("$TABLE-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
echo $connection->result("SELECT" . limit(idf_escape($_GET["field"]) . " FROM " . table($TABLE), " WHERE " . where($_GET, $fields), 1));
exit; // don't output footer

} elseif (isset($_GET["table"])) {
	
$TABLE = $_GET["table"];
$fields = fields($TABLE);
if (!$fields) {
	$error = error();
}
$table_status = table_status1($TABLE, true);

page_header(($fields && is_view($table_status) ? lang(106) : lang(107)) . ": " . h($TABLE), $error);

$adminer->selectLinks($table_status);
$comment = $table_status["Comment"];
if ($comment != "") {
	echo "<p>" . lang(101) . ": " . h($comment) . "\n";
}

if ($fields) {
	echo "<table cellspacing='0'>\n";
	echo "<thead><tr><th>" . lang(108) . "<td>" . lang(96) . (support("comment") ? "<td>" . lang(101) : "") . "</thead>\n";
	foreach ($fields as $field) {
		echo "<tr" . odd() . "><th>" . h($field["field"]);
		echo "<td title='" . h($field["collation"]) . "'>" . h($field["full_type"]) . ($field["null"] ? " <i>NULL</i>" : "") . ($field["auto_increment"] ? " <i>" . lang(99) . "</i>" : "");
		echo (isset($field["default"]) ? " [<b>" . h($field["default"]) . "</b>]" : "");
		echo (support("comment") ? "<td>" . nbsp($field["comment"]) : "");
		echo "\n";
	}
	echo "</table>\n";
	
	if (!is_view($table_status)) {
		echo "<h3 id='indexes'>" . lang(109) . "</h3>\n";
		$indexes = indexes($TABLE);
		if ($indexes) {
			echo "<table cellspacing='0'>\n";
			foreach ($indexes as $name => $index) {
				ksort($index["columns"]); // enforce correct columns order
				$print = array();
				foreach ($index["columns"] as $key => $val) {
					$print[] = "<i>" . h($val) . "</i>"
						. ($index["lengths"][$key] ? "(" . $index["lengths"][$key] . ")" : "")
						. ($index["descs"][$key] ? " DESC" : "")
					;
				}
				echo "<tr title='" . h($name) . "'><th>$index[type]<td>" . implode(", ", $print) . "\n";
			}
			echo "</table>\n";
		}
		echo '<p><a href="' . h(ME) . 'indexes=' . urlencode($TABLE) . '">' . lang(110) . "</a>\n";
		
		if (fk_support($table_status)) {
			echo "<h3 id='foreign-keys'>" . lang(90) . "</h3>\n";
			$foreign_keys = foreign_keys($TABLE);
			if ($foreign_keys) {
				echo "<table cellspacing='0'>\n";
				echo "<thead><tr><th>" . lang(111) . "<td>" . lang(112) . "<td>" . lang(93) . "<td>" . lang(92) . ($jush != "sqlite" ? "<td>&nbsp;" : "") . "</thead>\n";
				foreach ($foreign_keys as $name => $foreign_key) {
					echo "<tr title='" . h($name) . "'>";
					echo "<th><i>" . implode("</i>, <i>", array_map('h', $foreign_key["source"])) . "</i>";
					echo "<td><a href='" . h($foreign_key["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($foreign_key["db"]), ME) : ($foreign_key["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($foreign_key["ns"]), ME) : ME)) . "table=" . urlencode($foreign_key["table"]) . "'>"
						. ($foreign_key["db"] != "" ? "<b>" . h($foreign_key["db"]) . "</b>." : "") . ($foreign_key["ns"] != "" ? "<b>" . h($foreign_key["ns"]) . "</b>." : "") . h($foreign_key["table"])
						. "</a>"
					;
					echo "(<i>" . implode("</i>, <i>", array_map('h', $foreign_key["target"])) . "</i>)";
					echo "<td>" . nbsp($foreign_key["on_delete"]) . "\n";
					echo "<td>" . nbsp($foreign_key["on_update"]) . "\n";
					echo ($jush == "sqlite" ? "" : '<td><a href="' . h(ME . 'foreign=' . urlencode($TABLE) . '&name=' . urlencode($name)) . '">' . lang(113) . '</a>');
				}
				echo "</table>\n";
			}
			if ($jush != "sqlite") {
				echo '<p><a href="' . h(ME) . 'foreign=' . urlencode($TABLE) . '">' . lang(114) . "</a>\n";
			}
		}
		
		if (support("trigger")) {
			echo "<h3 id='triggers'>" . lang(115) . "</h3>\n";
			$triggers = triggers($TABLE);
			if ($triggers) {
				echo "<table cellspacing='0'>\n";
				foreach ($triggers as $key => $val) {
					echo "<tr valign='top'><td>$val[0]<td>$val[1]<th>" . h($key) . "<td><a href='" . h(ME . 'trigger=' . urlencode($TABLE) . '&name=' . urlencode($key)) . "'>" . lang(113) . "</a>\n";
				}
				echo "</table>\n";
			}
			echo '<p><a href="' . h(ME) . 'trigger=' . urlencode($TABLE) . '">' . lang(116) . "</a>\n";
		}
		
	}
}

} elseif (isset($_GET["schema"])) {
	
page_header(lang(53), "", array(), DB . ($_GET["ns"] ? ".$_GET[ns]" : ""));

$table_pos = array();
$table_pos_js = array();
$name = "adminer_schema";
$SCHEMA = ($_GET["schema"] ? $_GET["schema"] : $_COOKIE[($_COOKIE["$name-" . DB] ? "$name-" . DB : $name)]); // $_COOKIE["adminer_schema"] was used before 3.2.0 //! ':' in table name
preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $SCHEMA, $matches, PREG_SET_ORDER);
foreach ($matches as $i => $match) {
	$table_pos[$match[1]] = array($match[2], $match[3]);
	$table_pos_js[] = "\n\t'" . js_escape($match[1]) . "': [ $match[2], $match[3] ]";
}

$top = 0;
$base_left = -1;
$schema = array(); // table => array("fields" => array(name => field), "pos" => array(top, left), "references" => array(table => array(left => array(source, target))))
$referenced = array(); // target_table => array(table => array(left => target_column))
$lefts = array(); // float => bool
foreach (table_status('', true) as $table => $table_status) {
	if (is_view($table_status)) {
		continue;
	}
	$pos = 0;
	$schema[$table]["fields"] = array();
	foreach (fields($table) as $name => $field) {
		$pos += 1.25;
		$field["pos"] = $pos;
		$schema[$table]["fields"][$name] = $field;
	}
	$schema[$table]["pos"] = ($table_pos[$table] ? $table_pos[$table] : array($top, 0));
	foreach ($adminer->foreignKeys($table) as $val) {
		if (!$val["db"]) {
			$left = $base_left;
			if ($table_pos[$table][1] || $table_pos[$val["table"]][1]) {
				$left = min(floatval($table_pos[$table][1]), floatval($table_pos[$val["table"]][1])) - 1;
			} else {
				$base_left -= .1;
			}
			while ($lefts[(string) $left]) {
				// find free $left
				$left -= .0001;
			}
			$schema[$table]["references"][$val["table"]][(string) $left] = array($val["source"], $val["target"]);
			$referenced[$val["table"]][$table][(string) $left] = $val["target"];
			$lefts[(string) $left] = true;
		}
	}
	$top = max($top, $schema[$table]["pos"][0] + 2.5 + $pos);
}

?>
<div id="schema" style="height: <?php echo $top; ?>em;" onselectstart="return false;">
<script type="text/javascript">
var tablePos = {<?php echo implode(",", $table_pos_js) . "\n"; ?>};
var em = document.getElementById('schema').offsetHeight / <?php echo $top; ?>;
document.onmousemove = schemaMousemove;
document.onmouseup = function (ev) {
	schemaMouseup(ev, '<?php echo js_escape(DB); ?>');
};
</script>
<?php
foreach ($schema as $name => $table) {
	echo "<div class='table' style='top: " . $table["pos"][0] . "em; left: " . $table["pos"][1] . "em;' onmousedown='schemaMousedown(this, event);'>";
	echo '<a href="' . h(ME) . 'table=' . urlencode($name) . '"><b>' . h($name) . "</b></a>";
	
	foreach ($table["fields"] as $field) {
		$val = '<span' . type_class($field["type"]) . ' title="' . h($field["full_type"] . ($field["null"] ? " NULL" : '')) . '">' . h($field["field"]) . '</span>';
		echo "<br>" . ($field["primary"] ? "<i>$val</i>" : $val);
	}
	
	foreach ((array) $table["references"] as $target_name => $refs) {
		foreach ($refs as $left => $ref) {
			$left1 = $left - $table_pos[$name][1];
			$i = 0;
			foreach ($ref[0] as $source) {
				echo "\n<div class='references' title='" . h($target_name) . "' id='refs$left-" . ($i++) . "' style='left: $left1" . "em; top: " . $table["fields"][$source]["pos"] . "em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: " . (-$left1) . "em;'></div></div>";
			}
		}
	}
	
	foreach ((array) $referenced[$name] as $target_name => $refs) {
		foreach ($refs as $left => $columns) {
			$left1 = $left - $table_pos[$name][1];
			$i = 0;
			foreach ($columns as $target) {
				echo "\n<div class='references' title='" . h($target_name) . "' id='refd$left-" . ($i++) . "' style='left: $left1" . "em; top: " . $table["fields"][$target]["pos"] . "em; height: 1.25em; background: url(" . h(preg_replace("~\\?.*~", "", ME)) . "?file=arrow.gif) no-repeat right center;&amp;version=3.7.1'><div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$left1) . "em;'></div></div>";
			}
		}
	}
	
	echo "\n</div>\n";
}

foreach ($schema as $name => $table) {
	foreach ((array) $table["references"] as $target_name => $refs) {
		foreach ($refs as $left => $ref) {
			$min_pos = $top;
			$max_pos = -10;
			foreach ($ref[0] as $key => $source) {
				$pos1 = $table["pos"][0] + $table["fields"][$source]["pos"];
				$pos2 = $schema[$target_name]["pos"][0] + $schema[$target_name]["fields"][$ref[1][$key]]["pos"];
				$min_pos = min($min_pos, $pos1, $pos2);
				$max_pos = max($max_pos, $pos1, $pos2);
			}
			echo "<div class='references' id='refl$left' style='left: $left" . "em; top: $min_pos" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($max_pos - $min_pos) . "em;'></div></div>\n";
		}
	}
}
?>
</div>
<p><a href="<?php echo h(ME . "schema=" . urlencode($SCHEMA)); ?>" id="schema-link"><?php echo lang(117); ?></a>
<?php
} elseif (isset($_GET["dump"])) {
	
$TABLE = $_GET["dump"];

if ($_POST && !$error) {
	$cookie = "";
	foreach (array("output", "format", "db_style", "routines", "events", "table_style", "auto_increment", "triggers", "data_style") as $key) {
		$cookie .= "&$key=" . urlencode($_POST[$key]);
	}
	cookie("adminer_export", substr($cookie, 1));
	$tables = array_flip((array) $_POST["tables"]) + array_flip((array) $_POST["data"]);
	$ext = dump_headers(
		(count($tables) == 1 ? key($tables) : DB),
		(DB == "" || count($tables) > 1));
	$is_sql = ereg('sql', $_POST["format"]);
	
	if ($is_sql) {
		echo "-- Adminer $VERSION " . $drivers[DRIVER] . " dump

" . ($jush != "sql" ? "" : "SET NAMES utf8;
" . ($_POST["data_style"] ? "SET foreign_key_checks = 0;
SET time_zone = " . q(substr(preg_replace('~^[^-]~', '+\0', $connection->result("SELECT TIMEDIFF(NOW(), UTC_TIMESTAMP)")), 0, 6)) . ";
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
");
	}
	
	$style = $_POST["db_style"];
	$databases = array(DB);
	if (DB == "") {
		$databases = $_POST["databases"];
		if (is_string($databases)) {
			$databases = explode("\n", rtrim(str_replace("\r", "", $databases), "\n"));
		}
	}
	
	foreach ((array) $databases as $db) {
		$adminer->dumpDatabase($db);
		if ($connection->select_db($db)) {
			if ($is_sql && ereg('CREATE', $style) && ($create = $connection->result("SHOW CREATE DATABASE " . idf_escape($db), 1))) {
				if ($style == "DROP+CREATE") {
					echo "DROP DATABASE IF EXISTS " . idf_escape($db) . ";\n";
				}
				echo "$create;\n";
			}
			if ($is_sql) {
				if ($style) {
					echo use_sql($db) . ";\n\n";
				}
				$out = "";
				
				if ($_POST["routines"]) {
					foreach (array("FUNCTION", "PROCEDURE") as $routine) {
						foreach (get_rows("SHOW $routine STATUS WHERE Db = " . q($db), null, "-- ") as $row) {
							$out .= ($style != 'DROP+CREATE' ? "DROP $routine IF EXISTS " . idf_escape($row["Name"]) . ";;\n" : "")
							. remove_definer($connection->result("SHOW CREATE $routine " . idf_escape($row["Name"]), 2)) . ";;\n\n";
						}
					}
				}
				
				if ($_POST["events"]) {
					foreach (get_rows("SHOW EVENTS", null, "-- ") as $row) {
						$out .= ($style != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($row["Name"]) . ";;\n" : "")
						. remove_definer($connection->result("SHOW CREATE EVENT " . idf_escape($row["Name"]), 3)) . ";;\n\n";
					}
				}
				
				if ($out) {
					echo "DELIMITER ;;\n\n$out" . "DELIMITER ;\n\n";
				}
			}
			
			if ($_POST["table_style"] || $_POST["data_style"]) {
				$views = array();
				foreach (table_status('', true) as $name => $table_status) {
					$table = (DB == "" || in_array($name, (array) $_POST["tables"]));
					$data = (DB == "" || in_array($name, (array) $_POST["data"]));
					if ($table || $data) {
						if ($ext == "tar") {
							$tmp_file = new TmpFile;
							ob_start(array($tmp_file, 'write'), 1e5);
						}
						
						$adminer->dumpTable($name, ($table ? $_POST["table_style"] : ""), (is_view($table_status) ? 2 : 0));
						if (is_view($table_status)) {
							$views[] = $name;
						} elseif ($data) {
							$fields = fields($name);
							$adminer->dumpData($name, $_POST["data_style"], "SELECT *" . convert_fields($fields, $fields) . " FROM " . table($name));
						}
						if ($is_sql && $_POST["triggers"] && $table && ($triggers = trigger_sql($name, $_POST["table_style"]))) {
							echo "\nDELIMITER ;;\n$triggers\nDELIMITER ;\n";
						}
						
						if ($ext == "tar") {
							ob_end_flush();
							tar_file((DB != "" ? "" : "$db/") . "$name.csv", $tmp_file);
						} elseif ($is_sql) {
							echo "\n";
						}
					}
				}
				
				foreach ($views as $view) {
					$adminer->dumpTable($view, $_POST["table_style"], 1);
				}
				
				if ($ext == "tar") {
					echo pack("x512");
				}
			}
		}
	}
	
	if ($is_sql) {
		echo "-- " . $connection->result("SELECT NOW()") . "\n";
	}
	exit;
}

page_header(lang(118), $error, ($_GET["export"] != "" ? array("table" => $_GET["export"]) : array()), DB);
?>

<form action="" method="post">
<table cellspacing="0">
<?php
$db_style = array('', 'USE', 'DROP+CREATE', 'CREATE');
$table_style = array('', 'DROP+CREATE', 'CREATE');
$data_style = array('', 'TRUNCATE+INSERT', 'INSERT');
if ($jush == "sql") { //! use insert_update() in all drivers
	$data_style[] = 'INSERT+UPDATE';
}
parse_str($_COOKIE["adminer_export"], $row);
if (!$row) {
	$row = array("output" => "text", "format" => "sql", "db_style" => (DB != "" ? "" : "CREATE"), "table_style" => "DROP+CREATE", "data_style" => "INSERT");
}
if (!isset($row["events"])) { // backwards compatibility
	$row["routines"] = $row["events"] = ($_GET["dump"] == "");
	$row["triggers"] = $row["table_style"];
}

echo "<tr><th>" . lang(119) . "<td>" . html_select("output", $adminer->dumpOutput(), $row["output"], 0) . "\n"; // 0 - radio

echo "<tr><th>" . lang(120) . "<td>" . html_select("format", $adminer->dumpFormat(), $row["format"], 0) . "\n"; // 0 - radio

echo ($jush == "sqlite" ? "" : "<tr><th>" . lang(25) . "<td>" . html_select('db_style', $db_style, $row["db_style"])
	. (support("routine") ? checkbox("routines", 1, $row["routines"], lang(121)) : "")
	. (support("event") ? checkbox("events", 1, $row["events"], lang(122)) : "")
);

echo "<tr><th>" . lang(85) . "<td>" . html_select('table_style', $table_style, $row["table_style"])
	. checkbox("auto_increment", 1, $row["auto_increment"], lang(99))
	. (support("trigger") ? checkbox("triggers", 1, $row["triggers"], lang(115)) : "")
;

echo "<tr><th>" . lang(123) . "<td>" . html_select('data_style', $data_style, $row["data_style"]);
?>
</table>
<p><input type="submit" value="<?php echo lang(118); ?>">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<table cellspacing="0">
<?php
$prefixes = array();
if (DB != "") {
	$checked = ($TABLE != "" ? "" : " checked");
	echo "<thead><tr>";
	echo "<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$checked onclick='formCheck(this, /^tables\\[/);'>" . lang(85) . "</label>";
	echo "<th style='text-align: right;'><label class='block'>" . lang(123) . "<input type='checkbox' id='check-data'$checked onclick='formCheck(this, /^data\\[/);'></label>";
	echo "</thead>\n";
	
	$views = "";
	$tables_list = tables_list();
	foreach ($tables_list as $name => $type) {
		$prefix = ereg_replace("_.*", "", $name);
		$checked = ($TABLE == "" || $TABLE == (substr($TABLE, -1) == "%" ? "$prefix%" : $name)); //! % may be part of table name
		$print = "<tr><td>" . checkbox("tables[]", $name, $checked, $name, "checkboxClick(event, this); formUncheck('check-tables');", "block");
		if ($type !== null && !eregi("table", $type)) {
			$views .= "$print\n";
		} else {
			echo "$print<td align='right'><label class='block'><span id='Rows-" . h($name) . "'></span>" . checkbox("data[]", $name, $checked, "", "checkboxClick(event, this); formUncheck('check-data');") . "</label>\n";
		}
		$prefixes[$prefix]++;
	}
	echo $views;
	
	if ($tables_list) {
		echo "<script type='text/javascript'>ajaxSetHtml('" . js_escape(ME) . "script=db');</script>\n";
	}
	
} else {
	echo "<thead><tr><th style='text-align: left;'><label class='block'><input type='checkbox' id='check-databases'" . ($TABLE == "" ? " checked" : "") . " onclick='formCheck(this, /^databases\\[/);'>" . lang(25) . "</label></thead>\n";
	$databases = $adminer->databases();
	if ($databases) {
		foreach ($databases as $db) {
			if (!information_schema($db)) {
				$prefix = ereg_replace("_.*", "", $db);
				echo "<tr><td>" . checkbox("databases[]", $db, $TABLE == "" || $TABLE == "$prefix%", $db, "formUncheck('check-databases');", "block") . "\n";
				$prefixes[$prefix]++;
			}
		}
	} else {
		echo "<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
	}
}
?>
</table>
</form>
<?php
$first = true;
foreach ($prefixes as $key => $val) {
	if ($key != "" && $val > 1) {
		echo ($first ? "<p>" : " ") . "<a href='" . h(ME) . "dump=" . urlencode("$key%") . "'>" . h($key) . "</a>";
		$first = false;
	}
}

} elseif (isset($_GET["privileges"])) {
	
page_header(lang(54));

$result = $connection->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
$grant = $result;
if (!$result) {
	// list logged user, information_schema.USER_PRIVILEGES lists just the current user too
	$result = $connection->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
}

echo "<form action=''><p>\n";
hidden_fields_get();
echo "<input type='hidden' name='db' value='" . h(DB) . "'>\n";
echo ($grant ? "" : "<input type='hidden' name='grant' value=''>\n");
echo "<table cellspacing='0'>\n";
echo "<thead><tr><th>" . lang(23) . "<th>" . lang(22) . "<th>&nbsp;</thead>\n";

while ($row = $result->fetch_assoc()) {
	echo '<tr' . odd() . '><td>' . h($row["User"]) . "<td>" . h($row["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($row["User"]) . '&host=' . urlencode($row["Host"])) . '">' . lang(34) . "</a>\n";
}

if (!$grant || DB != "") {
	echo "<tr" . odd() . "><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='" . lang(34) . "'>\n";
}

echo "</table>\n";
echo "</form>\n";

echo '<p><a href="' . h(ME) . 'user=">' . lang(124) . "</a>";

} elseif (isset($_GET["sql"])) {
	
if (!$error && $_POST["export"]) {
	dump_headers("sql");
	$adminer->dumpTable("", "");
	$adminer->dumpData("", "table", $_POST["query"]);
	exit;
}

restart_session();
$history_all = &get_session("queries");
$history = &$history_all[DB];
if (!$error && $_POST["clear"]) {
	$history = array();
	redirect(remove_from_uri("history"));
}

page_header(lang(47), $error);

if (!$error && $_POST) {
	$fp = false;
	$query = $_POST["query"];
	if ($_POST["webfile"]) {
		$fp = @fopen((file_exists("adminer.sql")
			? "adminer.sql"
			: "compress.zlib://adminer.sql.gz"
		), "rb");
		$query = ($fp ? fread($fp, 1e6) : false);
	} elseif ($_FILES && $_FILES["sql_file"]["error"][0] != 4) { // 4 - UPLOAD_ERR_NO_FILE
		$query = get_file("sql_file", true);
	}
	
	if (is_string($query)) { // get_file() returns error as number, fread() as false
		if (function_exists('memory_get_usage')) {
			@ini_set("memory_limit", max(ini_bytes("memory_limit"), 2 * strlen($query) + memory_get_usage() + 8e6)); // @ - may be disabled, 2 - substr and trim, 8e6 - other variables
		}
		
		if ($query != "" && strlen($query) < 1e6) { // don't add big queries
			$q = $query . (ereg(";[ \t\r\n]*\$", $query) ? "" : ";"); //! doesn't work with DELIMITER |
			if (!$history || reset(end($history)) != $q) { // no repeated queries
				restart_session();
				$history[] = array($q, time());
				set_session("queries", $history_all); // required because reference is unlinked by stop_session()
				stop_session();
			}
		}
		
		$space = "(?:\\s|/\\*.*\\*/|(?:#|-- )[^\n]*\n|--\n)";
		$delimiter = ";";
		$offset = 0;
		$empty = true;
		$connection2 = connect(); // connection for exploring indexes and EXPLAIN (to not replace FOUND_ROWS()) //! PDO - silent error
		if (is_object($connection2) && DB != "") {
			$connection2->select_db(DB);
		}
		$commands = 0;
		$errors = array();
		$line = 0;
		$parse = '[\'"' . ($jush == "sql" ? '`#' : ($jush == "sqlite" ? '`[' : ($jush == "mssql" ? '[' : ''))) . ']|/\\*|-- |$' . ($jush == "pgsql" ? '|\\$[^$]*\\$' : '');
		$total_start = microtime();
		parse_str($_COOKIE["adminer_export"], $adminer_export);
		$dump_format = $adminer->dumpFormat();
		unset($dump_format["sql"]);
		
		while ($query != "") {
			if (!$offset && preg_match("~^$space*DELIMITER\\s+(\\S+)~i", $query, $match)) {
				$delimiter = $match[1];
				$query = substr($query, strlen($match[0]));
			} else {
				preg_match('(' . preg_quote($delimiter) . "\\s*|$parse)", $query, $match, PREG_OFFSET_CAPTURE, $offset); // should always match
				list($found, $pos) = $match[0];
				if (!$found && $fp && !feof($fp)) {
					$query .= fread($fp, 1e5);
				} else {
					if (!$found && rtrim($query) == "") {
						break;
					}
					$offset = $pos + strlen($found);
					
					if ($found && rtrim($found) != $delimiter) { // find matching quote or comment end
						while (preg_match('(' . ($found == '/*' ? '\\*/' : ($found == '[' ? ']' : (ereg('^-- |^#', $found) ? "\n" : preg_quote($found) . "|\\\\."))) . '|$)s', $query, $match, PREG_OFFSET_CAPTURE, $offset)) { //! respect sql_mode NO_BACKSLASH_ESCAPES
							$s = $match[0][0];
							if (!$s && $fp && !feof($fp)) {
								$query .= fread($fp, 1e5);
							} else {
								$offset = $match[0][1] + strlen($s);
								if ($s[0] != "\\") {
									break;
								}
							}
						}
						
					} else { // end of a query
						$empty = false;
						$q = substr($query, 0, $pos);
						$commands++;
						$print = "<pre id='sql-$commands'><code class='jush-$jush'>" . shorten_utf8(trim($q), 1000) . "</code></pre>\n";
						if (!$_POST["only_errors"]) {
							echo $print;
							ob_flush();
							flush(); // can take a long time - show the running query
						}
						$start = microtime(); // microtime(true) is available since PHP 5
						//! don't allow changing of character_set_results, convert encoding of displayed query
						if ($connection->multi_query($q) && is_object($connection2) && preg_match("~^$space*USE\\b~isU", $q)) {
							$connection2->query($q);
						}
						
						do {
							$result = $connection->store_result();
							$end = microtime();
							$time = " <span class='time'>(" . format_time($start, $end) . ")</span>"
								. (strlen($q) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($q)) . "'>" . lang(34) . "</a>" : "") // 1000 - maximum length of encoded URL in IE is 2083 characters
							;
							
							if ($connection->error) {
								echo ($_POST["only_errors"] ? $print : "");
								echo "<p class='error'>" . lang(125) . ($connection->errno ? " ($connection->errno)" : "") . ": " . error() . "\n";
								$errors[] = " <a href='#sql-$commands'>$commands</a>";
								if ($_POST["error_stops"]) {
									break 2;
								}
								
							} elseif (is_object($result)) {
								$orgtables = select($result, $connection2);
								if (!$_POST["only_errors"]) {
									echo "<form action='' method='post'>\n";
									echo "<p>" . ($result->num_rows ? lang(126, $result->num_rows) : "") . $time;
									$id = "export-$commands";
									$export = ", <a href='#$id' onclick=\"return !toggle('$id');\">" . lang(118) . "</a><span id='$id' class='hidden'>: "
										. html_select("output", $adminer->dumpOutput(), $adminer_export["output"]) . " "
										. html_select("format", $dump_format, $adminer_export["format"])
										. "<input type='hidden' name='query' value='" . h($q) . "'>"
										. " <input type='submit' name='export' value='" . lang(118) . "'><input type='hidden' name='token' value='$token'></span>\n"
									;
									if ($connection2 && preg_match("~^($space|\\()*SELECT\\b~isU", $q) && ($explain = explain($connection2, $q))) {
										$id = "explain-$commands";
										echo ", <a href='#$id' onclick=\"return !toggle('$id');\">EXPLAIN</a>$export";
										echo "<div id='$id' class='hidden'>\n";
										select($explain, $connection2, ($jush == "sql" ? "http://dev.mysql.com/doc/refman/" . substr($connection->server_info, 0, 3) . "/en/explain-output.html#explain_" : ""), $orgtables);
										echo "</div>\n";
									} else {
										echo $export;
									}
									echo "</form>\n";
								}
								
							} else {
								if (preg_match("~^$space*(CREATE|DROP|ALTER)$space+(DATABASE|SCHEMA)\\b~isU", $q)) {
									restart_session();
									set_session("dbs", null); // clear cache
									stop_session();
								}
								if (!$_POST["only_errors"]) {
									echo "<p class='message' title='" . h($connection->info) . "'>" . lang(127, $connection->affected_rows) . "$time\n";
								}
							}
							
							$start = $end;
						} while ($connection->next_result());
						
						$line += substr_count($q.$found, "\n");
						$query = substr($query, $offset);
						$offset = 0;
					}
					
				}
			}
		}
		
		if ($empty) {
			echo "<p class='message'>" . lang(128) . "\n";
		} elseif ($_POST["only_errors"]) {
			echo "<p class='message'>" . lang(129, $commands - count($errors));
			echo " <span class='time'>(" . format_time($total_start, microtime()) . ")</span>\n";
		} elseif ($errors && $commands > 1) {
			echo "<p class='error'>" . lang(125) . ": " . implode("", $errors) . "\n";
		}
		//! MS SQL - SET SHOWPLAN_ALL OFF
		
	} else {
		echo "<p class='error'>" . upload_error($query) . "\n";
	}
}
?>

<form action="" method="post" enctype="multipart/form-data" id="form">
<p><?php
$q = $_GET["sql"]; // overwrite $q from if ($_POST) to save memory
if ($_POST) {
	$q = $_POST["query"];
} elseif ($_GET["history"] == "all") {
	$q = $history;
} elseif ($_GET["history"] != "") {
	$q = $history[$_GET["history"]][0];
}
textarea("query", $q, 20);

echo ($_POST ? "" : "<script type='text/javascript'>focus(document.getElementsByTagName('textarea')[0]);</script>\n");
echo "<p>" . (ini_bool("file_uploads")
	? lang(130) . ': <input type="file" name="sql_file[]" multiple'
		. ($_FILES && $_FILES["sql_file"]["error"][0] != 4 ? '' : ' onchange="this.form[\'only_errors\'].checked = true;"') // 4 - UPLOAD_ERR_NO_FILE
		. '> (&lt; ' . ini_get("upload_max_filesize") . 'B)' // ignore post_max_size because it is for all form fields together and bytes computing would be necessary
	: lang(131)
);

?>
<p>
<input type="submit" value="<?php echo lang(33); ?>" title="Ctrl+Enter">
<?php
echo checkbox("error_stops", 1, $_POST["error_stops"], lang(132)) . "\n";
echo checkbox("only_errors", 1, $_POST["only_errors"], lang(133)) . "\n";

print_fieldset("webfile", lang(134), $_POST["webfile"], "document.getElementById('form')['only_errors'].checked = true; ");
echo lang(135, "<code>adminer.sql" . (extension_loaded("zlib") ? "[.gz]" : "") . "</code>");
echo ' <input type="submit" name="webfile" value="' . lang(136) . '">';
echo "</div></fieldset>\n";

if ($history) {
	print_fieldset("history", lang(137), $_GET["history"] != "");
	for ($val = end($history); $val; $val = prev($history)) { // not array_reverse() to save memory
		$key = key($history);
		list($q, $time) = $val;
		echo '<a href="' . h(ME . "sql=&history=$key") . '">' . lang(34) . "</a> <span class='time' title='" . @date('Y-m-d', $time) . "'>" . @date("H:i:s", $time) . "</span> <code class='jush-$jush'>" . shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $q)))), 80, "</code>") . "<br>\n"; // @ - time zone may be not set
	}
	echo "<input type='submit' name='clear' value='" . lang(138) . "'>\n";
	echo "<a href='" . h(ME . "sql=&history=all") . "'>" . lang(139) . "</a>\n";
	echo "</div></fieldset>\n";
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["edit"])) {
	
$TABLE = $_GET["edit"];
$fields = fields($TABLE);
$where = (isset($_GET["select"]) ? (count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $fields) : "") : where($_GET, $fields));
$update = (isset($_GET["select"]) ? $_POST["edit"] : $where);
foreach ($fields as $name => $field) {
	if (!isset($field["privileges"][$update ? "update" : "insert"]) || $adminer->fieldName($field) == "") {
		unset($fields[$name]);
	}
}

if ($_POST && !$error && !isset($_GET["select"])) {
	$location = $_POST["referer"];
	if ($_POST["insert"]) { // continue edit or insert
		$location = ($update ? null : $_SERVER["REQUEST_URI"]);
	} elseif (!ereg('^.+&select=.+$', $location)) {
		$location = ME . "select=" . urlencode($TABLE);
	}
	
	$indexes = indexes($TABLE);
	$unique_array = unique_array($_GET["where"], $indexes);
	$query_where = "\nWHERE $where";
	
	if (isset($_POST["delete"])) {
		$query = "FROM " . table($TABLE);
		query_redirect(
			"DELETE" . ($unique_array ? " $query$query_where" : limit1($query, $query_where)),
			$location,
			lang(140)
		);
	} else {
		$set = array();
		foreach ($fields as $name => $field) {
			$val = process_input($field);
			if ($val !== false && $val !== null) {
				$set[idf_escape($name)] = ($update ? "\n" . idf_escape($name) . " = $val" : $val);
			}
		}
		
		if ($update) {
			if (!$set) {
				redirect($location);
			}
			$query = table($TABLE) . " SET" . implode(",", $set);
			query_redirect(
				"UPDATE" . ($unique_array ? " $query$query_where" : limit1($query, $query_where)),
				$location,
				lang(141)
			);
		} else {
			$result = insert_into($TABLE, $set);
			$last_id = ($result ? last_id() : 0);
			queries_redirect($location, lang(142, ($last_id ? " $last_id" : "")), $result); //! link
		}
	}
}

$table_name = $adminer->tableName(table_status1($TABLE, true));
page_header(
	($update ? lang(34) : lang(143)),
	$error,
	array("select" => array($TABLE, $table_name)),
	$table_name //! two calls of h()
);

$row = null;
if ($_POST["save"]) {
	$row = (array) $_POST["fields"];
} elseif ($where) {
	$select = array();
	foreach ($fields as $name => $field) {
		if (isset($field["privileges"]["select"])) {
			$as = convert_field($field);
			if ($_POST["clone"] && $field["auto_increment"]) {
				$as = "''";
			}
			if ($jush == "sql" && ereg("enum|set", $field["type"])) {
				$as = "1*" . idf_escape($name);
			}
			$select[] = ($as ? "$as AS " : "") . idf_escape($name);
		}
	}
	$row = array();
	if ($select) {
		$rows = get_rows("SELECT" . limit(implode(", ", $select) . " FROM " . table($TABLE), " WHERE $where", (isset($_GET["select"]) ? 2 : 1)));
		$row = (isset($_GET["select"]) && count($rows) != 1 ? null : reset($rows));
	}
}

if ($row === false) {
	echo "<p class='error'>" . lang(89) . "\n";
}
?>

<form action="" method="post" enctype="multipart/form-data" id="form">
<?php
if (!$fields) {
	echo "<p class='error'>" . lang(144) . "\n";
} else {
	echo "<table cellspacing='0' onkeydown='return editingKeydown(event);'>\n";
	
	foreach ($fields as $name => $field) {
		echo "<tr><th>" . $adminer->fieldName($field);
		$default = $_GET["set"][bracket_escape($name)];
		if ($default === null) {
			$default = $field["default"];
			if ($field["type"] == "bit" && ereg("^b'([01]*)'\$", $default, $regs)) {
				$default = $regs[1];
			}
		}
		$value = ($row !== null
			? ($row[$name] != "" && $jush == "sql" && ereg("enum|set", $field["type"]) ? (is_array($row[$name]) ? array_sum($row[$name]) : +$row[$name]) : $row[$name])
			: (!$update && $field["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $default))
		);
		if (!$_POST["save"] && is_string($value)) {
			$value = $adminer->editVal($value, $field);
		}
		$function = ($_POST["save"] ? (string) $_POST["function"][$name] : ($update && $field["on_update"] == "CURRENT_TIMESTAMP" ? "now" : ($value === false ? null : ($value !== null ? '' : 'NULL'))));
		if (ereg("time", $field["type"]) && $value == "CURRENT_TIMESTAMP") {
			$value = "";
			$function = "now";
		}
		input($field, $value, $function);
		echo "\n";
	}
	
	echo "</table>\n";
}
?>
<p>
<?php
if ($fields) {
	echo "<input type='submit' value='" . lang(145) . "'>\n";
	if (!isset($_GET["select"])) {
		echo "<input type='submit' name='insert' value='" . ($update ? lang(146) : lang(147)) . "' title='Ctrl+Shift+Enter'>\n";
	}
}
echo ($update ? "<input type='submit' name='delete' value='" . lang(148) . "' onclick=\"return confirm('" . lang(0) . "');\">\n"
	: ($_POST || !$fields ? "" : "<script type='text/javascript'>focus(document.getElementById('form').getElementsByTagName('td')[1].firstChild);</script>\n")
);
if (isset($_GET["select"])) {
	hidden_fields(array("check" => (array) $_POST["check"], "clone" => $_POST["clone"], "all" => $_POST["all"]));
}
?>
<input type="hidden" name="referer" value="<?php echo h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]); ?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["create"])) {
	
$TABLE = $_GET["create"];
$partition_by = array('HASH', 'LINEAR HASH', 'KEY', 'LINEAR KEY', 'RANGE', 'LIST');

$referencable_primary = referencable_primary($TABLE);
$foreign_keys = array();
foreach ($referencable_primary as $table_name => $field) {
	$foreign_keys[str_replace("`", "``", $table_name) . "`" . str_replace("`", "``", $field["field"])] = $table_name; // not idf_escape() - used in JS
}

$orig_fields = array();
$table_status = array();
if ($TABLE != "") {
	$orig_fields = fields($TABLE);
	$table_status = table_status($TABLE);
	if (!$table_status) {
		$error = lang(7);
	}
}

$row = $_POST;
$row["fields"] = (array) $row["fields"];
if ($row["auto_increment_col"]) {
	$row["fields"][$row["auto_increment_col"]]["auto_increment"] = true;
}

if ($_POST && !process_fields($row["fields"]) && !$error) {
	if ($_POST["drop"]) {
		query_redirect("DROP TABLE " . table($TABLE), substr(ME, 0, -1), lang(149));
	} else {
		$fields = array();
		$all_fields = array();
		$use_all_fields = false;
		$foreign = array();
		ksort($row["fields"]);
		$orig_field = reset($orig_fields);
		$after = " FIRST";
		
		foreach ($row["fields"] as $key => $field) {
			$foreign_key = $foreign_keys[$field["type"]];
			$type_field = ($foreign_key !== null ? $referencable_primary[$foreign_key] : $field); //! can collide with user defined type
			if ($field["field"] != "") {
				if (!$field["has_default"]) {
					$field["default"] = null;
				}
				if ($key == $row["auto_increment_col"]) {
					$field["auto_increment"] = true;
				}
				$process_field = process_field($field, $type_field);
				$all_fields[] = array($field["orig"], $process_field, $after);
				if ($process_field != process_field($orig_field, $orig_field)) {
					$fields[] = array($field["orig"], $process_field, $after);
					if ($field["orig"] != "" || $after) {
						$use_all_fields = true;
					}
				}
				if ($foreign_key !== null) {
					$foreign[idf_escape($field["field"])] = ($TABLE != "" && $jush != "sqlite" ? "ADD" : " ") . " FOREIGN KEY (" . idf_escape($field["field"]) . ") REFERENCES " . table($foreign_keys[$field["type"]]) . " (" . idf_escape($type_field["field"]) . ")" . (ereg("^($on_actions)\$", $field["on_delete"]) ? " ON DELETE $field[on_delete]" : "");
				}
				$after = " AFTER " . idf_escape($field["field"]);
			} elseif ($field["orig"] != "") {
				$use_all_fields = true;
				$fields[] = array($field["orig"]);
			}
			if ($field["orig"] != "") {
				$orig_field = next($orig_fields);
				if (!$orig_field) {
					$after = "";
				}
			}
		}
		
		$partitioning = "";
		if (in_array($row["partition_by"], $partition_by)) {
			$partitions = array();
			if ($row["partition_by"] == 'RANGE' || $row["partition_by"] == 'LIST') {
				foreach (array_filter($row["partition_names"]) as $key => $val) {
					$value = $row["partition_values"][$key];
					$partitions[] = "\n  PARTITION " . idf_escape($val) . " VALUES " . ($row["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($value != "" ? " ($value)" : " MAXVALUE"); //! SQL injection
				}
			}
			$partitioning .= "\nPARTITION BY $row[partition_by]($row[partition])" . ($partitions // $row["partition"] can be expression, not only column
				? " (" . implode(",", $partitions) . "\n)"
				: ($row["partitions"] ? " PARTITIONS " . (+$row["partitions"]) : "")
			);
		} elseif (support("partitioning") && ereg("partitioned", $table_status["Create_options"])) {
			$partitioning .= "\nREMOVE PARTITIONING";
		}
		
		$message = lang(150);
		if ($TABLE == "") {
			cookie("adminer_engine", $row["Engine"]);
			$message = lang(151);
		}
		$name = trim($row["name"]);
		
		queries_redirect(ME . "table=" . urlencode($name), $message, alter_table(
			$TABLE,
			$name,
			($jush == "sqlite" && ($use_all_fields || $foreign) ? $all_fields : $fields),
			$foreign,
			$row["Comment"],
			($row["Engine"] && $row["Engine"] != $table_status["Engine"] ? $row["Engine"] : ""),
			($row["Collation"] && $row["Collation"] != $table_status["Collation"] ? $row["Collation"] : ""),
			($row["Auto_increment"] != "" ? +$row["Auto_increment"] : ""),
			$partitioning
		));
	}
}

page_header(($TABLE != "" ? lang(31) : lang(152)), $error, array("table" => $TABLE), $TABLE);

if (!$_POST) {
	$row = array(
		"Engine" => $_COOKIE["adminer_engine"],
		"fields" => array(array("field" => "", "type" => (isset($types["int"]) ? "int" : (isset($types["integer"]) ? "integer" : "")))),
		"partition_names" => array(""),
	);
	
	if ($TABLE != "") {
		$row = $table_status;
		$row["name"] = $TABLE;
		$row["fields"] = array();
		if (!$_GET["auto_increment"]) { // don't prefill by original Auto_increment for the sake of performance and not reusing deleted ids
			$row["Auto_increment"] = "";
		}
		foreach ($orig_fields as $field) {
			$field["has_default"] = isset($field["default"]);
			$row["fields"][] = $field;
		}
		
		if (support("partitioning")) {
			$from = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($TABLE);
			$result = $connection->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $from ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
			list($row["partition_by"], $row["partitions"], $row["partition"]) = $result->fetch_row();
			$partitions = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $from AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
			$partitions[""] = "";
			$row["partition_names"] = array_keys($partitions);
			$row["partition_values"] = array_values($partitions);
		}
	}
}

$collations = collations();
$engines = engines();
// case of engine may differ
foreach ($engines as $engine) {
	if (!strcasecmp($engine, $row["Engine"])) {
		$row["Engine"] = $engine;
		break;
	}
}
?>

<form action="" method="post" id="form">
<p>
<?php echo lang(153); ?>: <input name="name" maxlength="64" value="<?php echo h($row["name"]); ?>" autocapitalize="off">
<?php if ($TABLE == "" && !$_POST) { ?><script type='text/javascript'>focus(document.getElementById('form')['name']);</script><?php }  echo ($engines ? html_select("Engine", array("" => "(" . lang(154) . ")") + $engines, $row["Engine"]) : ""); ?>
 <?php echo ($collations && !ereg("sqlite|mssql", $jush) ? html_select("Collation", array("" => "(" . lang(91) . ")") + $collations, $row["Collation"]) : ""); ?>
 <input type="submit" value="<?php echo lang(145); ?>">
<table cellspacing="0" id="edit-fields" class="nowrap">
<?php
$comments = ($_POST ? $_POST["comments"] : $row["Comment"] != "");
if (!$_POST && !$comments) {
	foreach ($row["fields"] as $field) {
		if ($field["comment"] != "") {
			$comments = true;
			break;
		}
	}
}
edit_fields($row["fields"], $collations, "TABLE", $foreign_keys, $comments);
?>
</table>
<p>
<?php echo lang(99); ?>: <input type="number" name="Auto_increment" size="6" value="<?php echo h($row["Auto_increment"]); ?>">
<?php echo checkbox("defaults", 1, true, lang(100), "columnShow(this.checked, 5)", "jsonly");  if (!$_POST["defaults"]) { ?><script type="text/javascript">editingHideDefaults()</script><?php }  echo (support("comment")
	? "<label><input type='checkbox' name='comments' value='1' class='jsonly' onclick=\"columnShow(this.checked, 6); toggle('Comment'); if (this.checked) this.form['Comment'].focus();\"" . ($comments ? " checked" : "") . ">" . lang(101) . "</label>"
		. ' <input name="Comment" id="Comment" value="' . h($row["Comment"]) . '" maxlength="' . ($connection->server_info >= 5.5 ? 2048 : 60) . '"' . ($comments ? '' : ' class="hidden"') . '>'
	: '')
; ?>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<?php if ($_GET["create"] != "") { ?><input type="submit" name="drop" value="<?php echo lang(86); ?>"<?php echo confirm(); ?>><?php } 
if (support("partitioning")) {
	$partition_table = ereg('RANGE|LIST', $row["partition_by"]);
	print_fieldset("partition", lang(155), $row["partition_by"]);
	?>
<p>
<?php echo html_select("partition_by", array(-1 => "") + $partition_by, $row["partition_by"], "partitionByChange(this);"); ?>
(<input name="partition" value="<?php echo h($row["partition"]); ?>">)
<?php echo lang(156); ?>: <input type="number" name="partitions" class="size" value="<?php echo h($row["partitions"]); ?>"<?php echo ($partition_table || !$row["partition_by"] ? " class='hidden'" : ""); ?>>
<table cellspacing="0" id="partition-table"<?php echo ($partition_table ? "" : " class='hidden'"); ?>>
<thead><tr><th><?php echo lang(157); ?><th><?php echo lang(158); ?></thead>
<?php
foreach ($row["partition_names"] as $key => $val) {
	echo '<tr>';
	echo '<td><input name="partition_names[]" value="' . h($val) . '"' . ($key == count($row["partition_names"]) - 1 ? ' onchange="partitionNameChange(this);"' : '') . ' autocapitalize="off">';
	echo '<td><input name="partition_values[]" value="' . h($row["partition_values"][$key]) . '">';
}
?>
</table>
</div></fieldset>
<?php
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["indexes"])) {
	
$TABLE = $_GET["indexes"];
$index_types = array("PRIMARY", "UNIQUE", "INDEX");
$table_status = table_status($TABLE, true);
if (eregi("MyISAM|M?aria" . ($connection->server_info >= 5.6 ? "|InnoDB" : ""), $table_status["Engine"])) {
	$index_types[] = "FULLTEXT";
}
$indexes = indexes($TABLE);
if ($jush == "sqlite") { // doesn't support primary key
	unset($index_types[0]);
	unset($indexes[""]);
}
$row = $_POST;

if ($_POST && !$error && !$_POST["add"]) {
	$alter = array();
	foreach ($row["indexes"] as $index) {
		$name = $index["name"];
		if (in_array($index["type"], $index_types)) {
			$columns = array();
			$lengths = array();
			$descs = array();
			$set = array();
			ksort($index["columns"]);
			foreach ($index["columns"] as $key => $column) {
				if ($column != "") {
					$length = $index["lengths"][$key];
					$desc = $index["descs"][$key];
					$set[] = idf_escape($column) . ($length ? "(" . (+$length) . ")" : "") . ($desc ? " DESC" : "");
					$columns[] = $column;
					$lengths[] = ($length ? $length : null);
					$descs[] = $desc;
				}
			}
			
			if ($columns) {
				$existing = $indexes[$name];
				if ($existing) {
					ksort($existing["columns"]);
					ksort($existing["lengths"]);
					ksort($existing["descs"]);
					if ($index["type"] == $existing["type"]
						&& array_values($existing["columns"]) === $columns
						&& (!$existing["lengths"] || array_values($existing["lengths"]) === $lengths)
						&& array_values($existing["descs"]) === $descs
					) {
						// skip existing index
						unset($indexes[$name]);
						continue;
					}
				}
				$alter[] = array($index["type"], $name, "(" . implode(", ", $set) . ")");
			}
		}
	}
	
	// drop removed indexes
	foreach ($indexes as $name => $existing) {
		$alter[] = array($existing["type"], $name, "DROP");
	}
	if (!$alter) {
		redirect(ME . "table=" . urlencode($TABLE));
	}
	queries_redirect(ME . "table=" . urlencode($TABLE), lang(159), alter_indexes($TABLE, $alter));
}

page_header(lang(109), $error, array("table" => $TABLE), $TABLE);

$fields = array_keys(fields($TABLE));
if ($_POST["add"]) {
	foreach ($row["indexes"] as $key => $index) {
		if ($index["columns"][count($index["columns"])] != "") {
			$row["indexes"][$key]["columns"][] = "";
		}
	}
	$index = end($row["indexes"]);
	if ($index["type"]
		|| array_filter($index["columns"], 'strlen')
		|| array_filter($index["lengths"], 'strlen')
		|| array_filter($index["descs"])
	) {
		$row["indexes"][] = array("columns" => array(1 => ""));
	}
}
if (!$row) {
	foreach ($indexes as $key => $index) {
		$indexes[$key]["name"] = $key;
		$indexes[$key]["columns"][] = "";
	}
	$indexes[] = array("columns" => array(1 => ""));
	$row["indexes"] = $indexes;
}
?>

<form action="" method="post">
<table cellspacing="0" class="nowrap">
<thead><tr><th><?php echo lang(160); ?><th><?php echo lang(161); ?><th><?php echo lang(162); ?></thead>
<?php
$j = 1;
foreach ($row["indexes"] as $index) {
	echo "<tr><td>" . html_select("indexes[$j][type]", array(-1 => "") + $index_types, $index["type"], ($j == count($row["indexes"]) ? "indexesAddRow(this);" : 1)) . "<td>";
	ksort($index["columns"]);
	
	$i = 1;
	foreach ($index["columns"] as $key => $column) {
		echo "<span>" . html_select("indexes[$j][columns][$i]", array(-1 => "") + $fields, $column, ($i == count($index["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . "(this, '" . js_escape($jush == "sql" ? "" : $_GET["indexes"] . "_") . "');");
		echo ($jush == "sql" || $jush == "mssql" ? "<input type='number' name='indexes[$j][lengths][$i]' class='size' value='" . h($index["lengths"][$key]) . "'>" : "");
		echo ($jush != "sql" ? checkbox("indexes[$j][descs][$i]", 1, $index["descs"][$key], lang(42)) : "");
		echo " </span>";
		$i++;
	}
	
	echo "<td><input name='indexes[$j][name]' value='" . h($index["name"]) . "' autocapitalize='off'>\n";
	$j++;
}
?>
</table>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<noscript><p><input type="submit" name="add" value="<?php echo lang(102); ?>"></noscript>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["database"])) {
	
$row = $_POST;

if ($_POST && !$error && !isset($_POST["add_x"])) { // add is an image and PHP changes add.x to add_x
	restart_session();
	$name = trim($row["name"]);
	if ($_POST["drop"]) {
		$_GET["db"] = ""; // to save in global history
		queries_redirect(remove_from_uri("db|database"), lang(163), drop_databases(array(DB)));
	} elseif (DB !== $name) {
		// create or rename database
		if (DB != "") {
			$_GET["db"] = $name;
			queries_redirect(preg_replace('~db=[^&]*&~', '', ME) . "db=" . urlencode($name), lang(164), rename_database($name, $row["collation"]));
		} else {
			$databases = explode("\n", str_replace("\r", "", $name));
			$success = true;
			$last = "";
			foreach ($databases as $db) {
				if (count($databases) == 1 || $db != "") { // ignore empty lines but always try to create single database
					if (!create_database($db, $row["collation"])) {
						$success = false;
					}
					$last = $db;
				}
			}
			queries_redirect(ME . "db=" . urlencode($last), lang(165), $success);
		}
	} else {
		// alter database
		if (!$row["collation"]) {
			redirect(substr(ME, 0, -1));
		}
		query_redirect("ALTER DATABASE " . idf_escape($name) . (eregi('^[a-z0-9_]+$', $row["collation"]) ? " COLLATE $row[collation]" : ""), substr(ME, 0, -1), lang(166));
	}
}

page_header(DB != "" ? lang(50) : lang(167), $error, array(), DB);

$collations = collations();
$name = DB;
if ($_POST) {
	$name = $row["name"];
} elseif (DB != "") {
	$row["collation"] = db_collation(DB, $collations);
} elseif ($jush == "sql") {
	// propose database name with limited privileges
	foreach (get_vals("SHOW GRANTS") as $grant) {
		if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\\.\\*)?~', $grant, $match) && $match[1]) {
			$name = stripcslashes(idf_unescape("`$match[2]`"));
			break;
		}
	}
}
?>

<form action="" method="post">
<p>
<?php
echo ($_POST["add_x"] || strpos($name, "\n")
	? '<textarea id="name" name="name" rows="10" cols="40">' . h($name) . '</textarea><br>'
	: '<input name="name" id="name" value="' . h($name) . '" maxlength="64" autocapitalize="off">'
) . "\n" . ($collations ? html_select("collation", array("" => "(" . lang(91) . ")") + $collations, $row["collation"]) : "");
?>
<script type='text/javascript'>focus(document.getElementById('name'));</script>
<input type="submit" value="<?php echo lang(145); ?>">
<?php
if (DB != "") {
	echo "<input type='submit' name='drop' value='" . lang(86) . "'" . confirm() . ">\n";
} elseif (!$_POST["add_x"] && $_GET["db"] == "") {
	echo "<input type='image' name='add' src='" . h(preg_replace("~\\?.*~", "", ME)) . "?file=plus.gif&amp;version=3.7.1' alt='+' title='" . lang(102) . "'>\n";
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["scheme"])) {
	
$row = $_POST;

if ($_POST && !$error) {
	$link = preg_replace('~ns=[^&]*&~', '', ME) . "ns=";
	if ($_POST["drop"]) {
		query_redirect("DROP SCHEMA " . idf_escape($_GET["ns"]), $link, lang(168));
	} else {
		$name = trim($row["name"]);
		$link .= urlencode($name);
		if ($_GET["ns"] == "") {
			query_redirect("CREATE SCHEMA " . idf_escape($name), $link, lang(169));
		} elseif ($_GET["ns"] != $name) {
			query_redirect("ALTER SCHEMA " . idf_escape($_GET["ns"]) . " RENAME TO " . idf_escape($name), $link, lang(170)); //! sp_rename in MS SQL
		} else {
			redirect($link);
		}
	}
}

page_header($_GET["ns"] != "" ? lang(51) : lang(52), $error);

if (!$row) {
	$row["name"] = $_GET["ns"];
}
?>

<form action="" method="post">
<p><input name="name" id="name" value="<?php echo h($row["name"]); ?>" autocapitalize="off">
<script type='text/javascript'>focus(document.getElementById('name'));</script>
<input type="submit" value="<?php echo lang(145); ?>">
<?php
if ($_GET["ns"] != "") {
	echo "<input type='submit' name='drop' value='" . lang(86) . "'" . confirm() . ">\n";
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["call"])) {
	
$PROCEDURE = $_GET["call"];
page_header(lang(171) . ": " . h($PROCEDURE), $error);

$routine = routine($PROCEDURE, (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
$in = array();
$out = array();
foreach ($routine["fields"] as $i => $field) {
	if (substr($field["inout"], -3) == "OUT") {
		$out[$i] = "@" . idf_escape($field["field"]) . " AS " . idf_escape($field["field"]);
	}
	if (!$field["inout"] || substr($field["inout"], 0, 2) == "IN") {
		$in[] = $i;
	}
}

if (!$error && $_POST) {
	$call = array();
	foreach ($routine["fields"] as $key => $field) {
		if (in_array($key, $in)) {
			$val = process_input($field);
			if ($val === false) {
				$val = "''";
			}
			if (isset($out[$key])) {
				$connection->query("SET @" . idf_escape($field["field"]) . " = $val");
			}
		}
		$call[] = (isset($out[$key]) ? "@" . idf_escape($field["field"]) : $val);
	}
	
	$query = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . idf_escape($PROCEDURE) . "(" . implode(", ", $call) . ")";
	echo "<p><code class='jush-$jush'>" . h($query) . "</code> <a href='" . h(ME) . "sql=" . urlencode($query) . "'>" . lang(34) . "</a>\n";
	
	if (!$connection->multi_query($query)) {
		echo "<p class='error'>" . error() . "\n";
	} else {
		$connection2 = connect();
		if (is_object($connection2)) {
			$connection2->select_db(DB);
		}
		
		do {
			$result = $connection->store_result();
			if (is_object($result)) {
				select($result, $connection2);
			} else {
				echo "<p class='message'>" . lang(172, $connection->affected_rows) . "\n";
			}
		} while ($connection->next_result());
		
		if ($out) {
			select($connection->query("SELECT " . implode(", ", $out)));
		}
	}
}
?>

<form action="" method="post">
<?php
if ($in) {
	echo "<table cellspacing='0'>\n";
	foreach ($in as $key) {
		$field = $routine["fields"][$key];
		$name = $field["field"];
		echo "<tr><th>" . $adminer->fieldName($field);
		$value = $_POST["fields"][$name];
		if ($value != "") {
			if ($field["type"] == "enum") {
				$value = +$value;
			}
			if ($field["type"] == "set") {
				$value = array_sum($value);
			}
		}
		input($field, $value, (string) $_POST["function"][$name]); // param name can be empty
		echo "\n";
	}
	echo "</table>\n";
}
?>
<p>
<input type="submit" value="<?php echo lang(171); ?>">
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["foreign"])) {
	
$TABLE = $_GET["foreign"];
$name = $_GET["name"];
$row = $_POST;

if ($_POST && !$error && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
	if ($_POST["drop"]) {
		query_redirect("ALTER TABLE " . table($TABLE) . "\nDROP " . ($jush == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($name), ME . "table=" . urlencode($TABLE), lang(173));
	} else {
		$source = array_filter($row["source"], 'strlen');
		ksort($source); // enforce input order
		$target = array();
		foreach ($source as $key => $val) {
			$target[$key] = $row["target"][$key];
		}
		
		query_redirect("ALTER TABLE " . table($TABLE)
			. ($name != "" ? "\nDROP " . ($jush == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($name) . "," : "")
			. "\nADD FOREIGN KEY (" . implode(", ", array_map('idf_escape', $source)) . ") REFERENCES " . table($row["table"]) . " (" . implode(", ", array_map('idf_escape', $target)) . ")" //! reuse $name - check in older MySQL versions
			. (ereg("^($on_actions)\$", $row["on_delete"]) ? " ON DELETE $row[on_delete]" : "")
			. (ereg("^($on_actions)\$", $row["on_update"]) ? " ON UPDATE $row[on_update]" : "")
		, ME . "table=" . urlencode($TABLE), ($name != "" ? lang(174) : lang(175)));
		$error = lang(176) . "<br>$error"; //! no partitioning
	}
}

page_header(lang(177), $error, array("table" => $TABLE), $TABLE);

if ($_POST) {
	ksort($row["source"]);
	if ($_POST["add"]) {
		$row["source"][] = "";
	} elseif ($_POST["change"] || $_POST["change-js"]) {
		$row["target"] = array();
	}
} elseif ($name != "") {
	$foreign_keys = foreign_keys($TABLE);
	$row = $foreign_keys[$name];
	$row["source"][] = "";
} else {
	$row["table"] = $TABLE;
	$row["source"] = array("");
}

$source = array_keys(fields($TABLE)); //! no text and blob
$target = ($TABLE === $row["table"] ? $source : array_keys(fields($row["table"])));
$referencable = array_keys(array_filter(table_status('', true), 'fk_support'));
?>

<form action="" method="post">
<p>
<?php if ($row["db"] == "" && $row["ns"] == "") {  echo lang(178); ?>:
<?php echo html_select("table", $referencable, $row["table"], "this.form['change-js'].value = '1'; this.form.submit();"); ?>
<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="<?php echo lang(179); ?>"></noscript>
<table cellspacing="0">
<thead><tr><th><?php echo lang(111); ?><th><?php echo lang(112); ?></thead>
<?php
$j = 0;
foreach ($row["source"] as $key => $val) {
	echo "<tr>";
	echo "<td>" . html_select("source[" . (+$key) . "]", array(-1 => "") + $source, $val, ($j == count($row["source"]) - 1 ? "foreignAddRow(this);" : 1));
	echo "<td>" . html_select("target[" . (+$key) . "]", $target, $row["target"][$key]);
	$j++;
}
?>
</table>
<p>
<?php echo lang(93); ?>: <?php echo html_select("on_delete", array(-1 => "") + explode("|", $on_actions), $row["on_delete"]); ?>
 <?php echo lang(92); ?>: <?php echo html_select("on_update", array(-1 => "") + explode("|", $on_actions), $row["on_update"]); ?>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<noscript><p><input type="submit" name="add" value="<?php echo lang(180); ?>"></noscript>
<?php }  if ($name != "") { ?><input type="submit" name="drop" value="<?php echo lang(86); ?>"<?php echo confirm(); ?>><?php } ?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["view"])) {
	
$TABLE = $_GET["view"];
$row = $_POST;

if ($_POST && !$error) {
	$name = trim($row["name"]);
	$as = " AS\n$row[select]";
	$location = ME . "table=" . urlencode($name);
	$message = lang(181);
	
	if (!$_POST["drop"] && $TABLE == $name && $jush != "sqlite") {
		query_redirect(($jush == "mssql" ? "ALTER" : "CREATE OR REPLACE") . " VIEW " . table($name) . $as, $location, $message);
	} else {
		$temp_name = $name . "_adminer_" . uniqid();
		drop_create(
			"DROP VIEW " . table($TABLE),
			"CREATE VIEW " . table($name) . $as,
			"DROP VIEW " . table($name),
			"CREATE VIEW " . table($temp_name) . $as,
			"DROP VIEW " . table($temp_name),
			($_POST["drop"] ? substr(ME, 0, -1) : $location),
			lang(182),
			$message,
			lang(183),
			$TABLE,
			$name
		);
	}
}

if (!$_POST && $TABLE != "") {
	$row = view($TABLE);
	$row["name"] = $TABLE;
	if (!$error) {
		$error = $connection->error;
	}
}

page_header(($TABLE != "" ? lang(30) : lang(184)), $error, array("table" => $TABLE), $TABLE);
?>

<form action="" method="post">
<p><?php echo lang(162); ?>: <input name="name" value="<?php echo h($row["name"]); ?>" maxlength="64" autocapitalize="off">
<p><?php textarea("select", $row["select"]); ?>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<?php if ($_GET["view"] != "") { ?><input type="submit" name="drop" value="<?php echo lang(86); ?>"<?php echo confirm(); ?>><?php } ?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["event"])) {
	
$EVENT = $_GET["event"];
$intervals = array("YEAR", "QUARTER", "MONTH", "DAY", "HOUR", "MINUTE", "WEEK", "SECOND", "YEAR_MONTH", "DAY_HOUR", "DAY_MINUTE", "DAY_SECOND", "HOUR_MINUTE", "HOUR_SECOND", "MINUTE_SECOND");
$statuses = array("ENABLED" => "ENABLE", "DISABLED" => "DISABLE", "SLAVESIDE_DISABLED" => "DISABLE ON SLAVE");
$row = $_POST;

if ($_POST && !$error) {
	if ($_POST["drop"]) {
		query_redirect("DROP EVENT " . idf_escape($EVENT), substr(ME, 0, -1), lang(185));
	} elseif (in_array($row["INTERVAL_FIELD"], $intervals) && isset($statuses[$row["STATUS"]])) {
		$schedule = "\nON SCHEDULE " . ($row["INTERVAL_VALUE"]
			? "EVERY " . q($row["INTERVAL_VALUE"]) . " $row[INTERVAL_FIELD]"
			. ($row["STARTS"] ? " STARTS " . q($row["STARTS"]) : "")
			. ($row["ENDS"] ? " ENDS " . q($row["ENDS"]) : "") //! ALTER EVENT doesn't drop ENDS - MySQL bug #39173
			: "AT " . q($row["STARTS"])
			) . " ON COMPLETION" . ($row["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE"
		;
		
		queries_redirect(substr(ME, 0, -1), ($EVENT != "" ? lang(186) : lang(187)), queries(($EVENT != ""
			? "ALTER EVENT " . idf_escape($EVENT) . $schedule
			. ($EVENT != $row["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($row["EVENT_NAME"]) : "")
			: "CREATE EVENT " . idf_escape($row["EVENT_NAME"]) . $schedule
			) . "\n" . $statuses[$row["STATUS"]] . " COMMENT " . q($row["EVENT_COMMENT"])
			. rtrim(" DO\n$row[EVENT_DEFINITION]", ";") . ";"
		));
	}
}

page_header(($EVENT != "" ? lang(188) . ": " . h($EVENT) : lang(189)), $error);

if (!$row && $EVENT != "") {
	$rows = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($EVENT));
	$row = reset($rows);
}
?>

<form action="" method="post">
<table cellspacing="0">
<tr><th><?php echo lang(162); ?><td><input name="EVENT_NAME" value="<?php echo h($row["EVENT_NAME"]); ?>" maxlength="64" autocapitalize="off">
<tr><th title="datetime"><?php echo lang(190); ?><td><input name="STARTS" value="<?php echo h("$row[EXECUTE_AT]$row[STARTS]"); ?>">
<tr><th title="datetime"><?php echo lang(191); ?><td><input name="ENDS" value="<?php echo h($row["ENDS"]); ?>">
<tr><th><?php echo lang(192); ?><td><input type="number" name="INTERVAL_VALUE" value="<?php echo h($row["INTERVAL_VALUE"]); ?>" class="size"> <?php echo html_select("INTERVAL_FIELD", $intervals, $row["INTERVAL_FIELD"]); ?>
<tr><th><?php echo lang(80); ?><td><?php echo html_select("STATUS", $statuses, $row["STATUS"]); ?>
<tr><th><?php echo lang(101); ?><td><input name="EVENT_COMMENT" value="<?php echo h($row["EVENT_COMMENT"]); ?>" maxlength="64">
<tr><th>&nbsp;<td><?php echo checkbox("ON_COMPLETION", "PRESERVE", $row["ON_COMPLETION"] == "PRESERVE", lang(193)); ?>
</table>
<p><?php textarea("EVENT_DEFINITION", $row["EVENT_DEFINITION"]); ?>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<?php if ($EVENT != "") { ?><input type="submit" name="drop" value="<?php echo lang(86); ?>"<?php echo confirm(); ?>><?php } ?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["procedure"])) {
	
$PROCEDURE = $_GET["procedure"];
$routine = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
$row = $_POST;
$row["fields"] = (array) $row["fields"];

if ($_POST && !process_fields($row["fields"]) && !$error) {
	$temp_name = "$row[name]_adminer_" . uniqid();
	drop_create(
		"DROP $routine " . idf_escape($PROCEDURE),
		create_routine($routine, $row),
		"DROP $routine " . idf_escape($row["name"]),
		create_routine($routine, array("name" => $temp_name) + $row),
		"DROP $routine " . idf_escape($temp_name),
		substr(ME, 0, -1),
		lang(194),
		lang(195),
		lang(196),
		$PROCEDURE,
		$row["name"]
	);
}

page_header(($PROCEDURE != "" ? (isset($_GET["function"]) ? lang(197) : lang(198)) . ": " . h($PROCEDURE) : (isset($_GET["function"]) ? lang(199) : lang(200))), $error);

if (!$_POST && $PROCEDURE != "") {
	$row = routine($PROCEDURE, $routine);
	$row["name"] = $PROCEDURE;
}

$collations = get_vals("SHOW CHARACTER SET");
sort($collations);
$routine_languages = routine_languages();
?>

<form action="" method="post" id="form">
<p><?php echo lang(162); ?>: <input name="name" value="<?php echo h($row["name"]); ?>" maxlength="64" autocapitalize="off">
<?php echo ($routine_languages ? lang(9) . ": " . html_select("language", $routine_languages, $row["language"]) : ""); ?>
<table cellspacing="0" class="nowrap">
<?php
edit_fields($row["fields"], $collations, $routine);
if (isset($_GET["function"])) {
	echo "<tr><td>" . lang(201);
	edit_type("returns", $row["returns"], $collations);
}
?>
</table>
<p><?php textarea("definition", $row["definition"]); ?>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<?php if ($PROCEDURE != "") { ?><input type="submit" name="drop" value="<?php echo lang(86); ?>"<?php echo confirm(); ?>><?php } ?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["sequence"])) {
	
$SEQUENCE = $_GET["sequence"];
$row = $_POST;

if ($_POST && !$error) {
	$link = substr(ME, 0, -1);
	$name = trim($row["name"]);
	if ($_POST["drop"]) {
		query_redirect("DROP SEQUENCE " . idf_escape($SEQUENCE), $link, lang(202));
	} elseif ($SEQUENCE == "") {
		query_redirect("CREATE SEQUENCE " . idf_escape($name), $link, lang(203));
	} elseif ($SEQUENCE != $name) {
		query_redirect("ALTER SEQUENCE " . idf_escape($SEQUENCE) . " RENAME TO " . idf_escape($name), $link, lang(204));
	} else {
		redirect($link);
	}
}

page_header($SEQUENCE != "" ? lang(205) . ": " . h($SEQUENCE) : lang(206), $error);

if (!$row) {
	$row["name"] = $SEQUENCE;
}
?>

<form action="" method="post">
<p><input name="name" value="<?php echo h($row["name"]); ?>" autocapitalize="off">
<input type="submit" value="<?php echo lang(145); ?>">
<?php
if ($SEQUENCE != "") {
	echo "<input type='submit' name='drop' value='" . lang(86) . "'" . confirm() . ">\n";
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["type"])) {
	
$TYPE = $_GET["type"];
$row = $_POST;

if ($_POST && !$error) {
	$link = substr(ME, 0, -1);
	if ($_POST["drop"]) {
		query_redirect("DROP TYPE " . idf_escape($TYPE), $link, lang(207));
	} else {
		query_redirect("CREATE TYPE " . idf_escape(trim($row["name"])) . " $row[as]", $link, lang(208));
	}
}

page_header($TYPE != "" ? lang(209) . ": " . h($TYPE) : lang(210), $error);

if (!$row) {
	$row["as"] = "AS ";
}
?>

<form action="" method="post">
<p>
<?php
if ($TYPE != "") {
	echo "<input type='submit' name='drop' value='" . lang(86) . "'" . confirm() . ">\n";
} else {
	echo "<input name='name' value='" . h($row['name']) . "' autocapitalize='off'>\n";
	textarea("as", $row["as"]);
	echo "<p><input type='submit' value='" . lang(145) . "'>\n";
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["trigger"])) {
	
$TABLE = $_GET["trigger"];
$name = $_GET["name"];
$trigger_options = trigger_options();
$trigger_event = array("INSERT", "UPDATE", "DELETE");
$row = (array) trigger($name) + array("Trigger" => $TABLE . "_bi");

if ($_POST) {
	if (!$error && in_array($_POST["Timing"], $trigger_options["Timing"]) && in_array($_POST["Event"], $trigger_event) && in_array($_POST["Type"], $trigger_options["Type"])) {
		// don't use drop_create() because there may not be more triggers for the same action
		$on = " ON " . table($TABLE);
		$drop = "DROP TRIGGER " . idf_escape($name) . ($jush == "pgsql" ? $on : "");
		$location = ME . "table=" . urlencode($TABLE);
		if ($_POST["drop"]) {
			query_redirect($drop, $location, lang(211));
		} else {
			if ($name != "") {
				queries($drop);
			}
			queries_redirect(
				$location,
				($name != "" ? lang(212) : lang(213)),
				queries(create_trigger($on, $_POST))
			);
			if ($name != "") {
				queries(create_trigger($on, $row + array("Type" => reset($trigger_options["Type"]))));
			}
		}
	}
	$row = $_POST;
}

page_header(($name != "" ? lang(214) . ": " . h($name) : lang(215)), $error, array("table" => $TABLE));
?>

<form action="" method="post" id="form">
<table cellspacing="0">
<tr><th><?php echo lang(216); ?><td><?php echo html_select("Timing", $trigger_options["Timing"], $row["Timing"], "if (/^" . preg_quote($TABLE, "/") . "_[ba][iud]$/.test(this.form['Trigger'].value)) this.form['Trigger'].value = '" . js_escape($TABLE) . "_' + selectValue(this).charAt(0).toLowerCase() + selectValue(this.form['Event']).charAt(0).toLowerCase();"); ?>
<tr><th><?php echo lang(217); ?><td><?php echo html_select("Event", $trigger_event, $row["Event"], "this.form['Timing'].onchange();"); ?>
<tr><th><?php echo lang(96); ?><td><?php echo html_select("Type", $trigger_options["Type"], $row["Type"]); ?>
</table>
<p><?php echo lang(162); ?>: <input name="Trigger" value="<?php echo h($row["Trigger"]); ?>" maxlength="64" autocapitalize="off">
<p><?php textarea("Statement", $row["Statement"]); ?>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<?php if ($name != "") { ?><input type="submit" name="drop" value="<?php echo lang(86); ?>"<?php echo confirm(); ?>><?php } ?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["user"])) {
	
$USER = $_GET["user"];
$privileges = array("" => array("All privileges" => ""));
foreach (get_rows("SHOW PRIVILEGES") as $row) {
	foreach (explode(",", ($row["Privilege"] == "Grant option" ? "" : $row["Context"])) as $context) {
		$privileges[$context][$row["Privilege"]] = $row["Comment"];
	}
}
$privileges["Server Admin"] += $privileges["File access on server"];
$privileges["Databases"]["Create routine"] = $privileges["Procedures"]["Create routine"]; // MySQL bug #30305
unset($privileges["Procedures"]["Create routine"]);
$privileges["Columns"] = array();
foreach (array("Select", "Insert", "Update", "References") as $val) {
	$privileges["Columns"][$val] = $privileges["Tables"][$val];
}
unset($privileges["Server Admin"]["Usage"]);
foreach ($privileges["Tables"] as $key => $val) {
	unset($privileges["Databases"][$key]);
}

$new_grants = array();
if ($_POST) {
	foreach ($_POST["objects"] as $key => $val) {
		$new_grants[$val] = (array) $new_grants[$val] + (array) $_POST["grants"][$key];
	}
}
$grants = array();
$old_pass = "";

if (isset($_GET["host"]) && ($result = $connection->query("SHOW GRANTS FOR " . q($USER) . "@" . q($_GET["host"])))) { //! use information_schema for MySQL 5 - column names in column privileges are not escaped
	while ($row = $result->fetch_row()) {
		if (preg_match('~GRANT (.*) ON (.*) TO ~', $row[0], $match) && preg_match_all('~ *([^(,]*[^ ,(])( *\\([^)]+\\))?~', $match[1], $matches, PREG_SET_ORDER)) { //! escape the part between ON and TO
			foreach ($matches as $val) {
				if ($val[1] != "USAGE") {
					$grants["$match[2]$val[2]"][$val[1]] = true;
				}
				if (ereg(' WITH GRANT OPTION', $row[0])) { //! don't check inside strings and identifiers
					$grants["$match[2]$val[2]"]["GRANT OPTION"] = true;
				}
			}
		}
		if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $row[0], $match)) {
			$old_pass = $match[1];
		}
	}
}

if ($_POST && !$error) {
	$old_user = (isset($_GET["host"]) ? q($USER) . "@" . q($_GET["host"]) : "''");
	if ($_POST["drop"]) {
		query_redirect("DROP USER $old_user", ME . "privileges=", lang(218));
	} else {
		$new_user = q($_POST["user"]) . "@" . q($_POST["host"]); // if $_GET["host"] is not set then $new_user is always different
		$pass = $_POST["pass"];
		if ($pass != '' && !$_POST["hashed"]) {
			// compute hash in a separate query so that plain text password is not saved to history
			$pass = $connection->result("SELECT PASSWORD(" . q($pass) . ")");
			$error = !$pass;
		}
		
		$created = false;
		if (!$error) {
			if ($old_user != $new_user) {
				$created = queries(($connection->server_info < 5 ? "GRANT USAGE ON *.* TO" : "CREATE USER") . " $new_user IDENTIFIED BY PASSWORD " . q($pass));
				$error = !$created;
			} elseif ($pass != $old_pass) {
				queries("SET PASSWORD FOR $new_user = " . q($pass));
			}
		}
		
		if (!$error) {
			$revoke = array();
			foreach ($new_grants as $object => $grant) {
				if (isset($_GET["grant"])) {
					$grant = array_filter($grant);
				}
				$grant = array_keys($grant);
				if (isset($_GET["grant"])) {
					// no rights to mysql.user table
					$revoke = array_diff(array_keys(array_filter($new_grants[$object], 'strlen')), $grant);
				} elseif ($old_user == $new_user) {
					$old_grant = array_keys((array) $grants[$object]);
					$revoke = array_diff($old_grant, $grant);
					$grant = array_diff($grant, $old_grant);
					unset($grants[$object]);
				}
				if (preg_match('~^(.+)\\s*(\\(.*\\))?$~U', $object, $match) && (
					!grant("REVOKE", $revoke, $match[2], " ON $match[1] FROM $new_user") //! SQL injection
					|| !grant("GRANT", $grant, $match[2], " ON $match[1] TO $new_user")
				)) {
					$error = true;
					break;
				}
			}
		}
		
		if (!$error && isset($_GET["host"])) {
			if ($old_user != $new_user) {
				queries("DROP USER $old_user");
			} elseif (!isset($_GET["grant"])) {
				foreach ($grants as $object => $revoke) {
					if (preg_match('~^(.+)(\\(.*\\))?$~U', $object, $match)) {
						grant("REVOKE", array_keys($revoke), $match[2], " ON $match[1] FROM $new_user");
					}
				}
			}
		}
		
		queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? lang(219) : lang(220)), !$error);
		
		if ($created) {
			// delete new user in case of an error
			$connection->query("DROP USER $new_user");
		}
	}
}

page_header((isset($_GET["host"]) ? lang(23) . ": " . h("$USER@$_GET[host]") : lang(124)), $error, array("privileges" => array('', lang(54))));

if ($_POST) {
	$row = $_POST;
	$grants = $new_grants;
} else {
	$row = $_GET + array("host" => $connection->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)")); // create user on the same domain by default
	$row["pass"] = $old_pass;
	if ($old_pass != "") {
		$row["hashed"] = true;
	}
	$grants[(DB == "" || $grants ? "" : idf_escape(addcslashes(DB, "%_\\"))) . ".*"] = array();
}

?>
<form action="" method="post">
<table cellspacing="0">
<tr><th><?php echo lang(22); ?><td><input name="host" maxlength="60" value="<?php echo h($row["host"]); ?>" autocapitalize="off">
<tr><th><?php echo lang(23); ?><td><input name="user" maxlength="16" value="<?php echo h($row["user"]); ?>" autocapitalize="off">
<tr><th><?php echo lang(24); ?><td><input name="pass" id="pass" value="<?php echo h($row["pass"]); ?>">
<?php if (!$row["hashed"]) { ?><script type="text/javascript">typePassword(document.getElementById('pass'));</script><?php }  echo checkbox("hashed", 1, $row["hashed"], lang(221), "typePassword(this.form['pass'], this.checked);"); ?>
</table>

<?php
//! MAX_* limits, REQUIRE
echo "<table cellspacing='0'>\n";
echo "<thead><tr><th colspan='2'><a href='http://dev.mysql.com/doc/refman/" . substr($connection->server_info, 0, 3) . "/en/grant.html#priv_level' target='_blank' rel='noreferrer' class='help'>" . lang(54) . "</a>";
$i = 0;
foreach ($grants as $object => $grant) {
	echo '<th>' . ($object != "*.*" ? "<input name='objects[$i]' value='" . h($object) . "' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$i]' value='*.*' size='10'>*.*"); //! separate db, table, columns, PROCEDURE|FUNCTION, routine
	$i++;
}
echo "</thead>\n";

foreach (array(
	"" => "",
	"Server Admin" => lang(22),
	"Databases" => lang(25),
	"Tables" => lang(107),
	"Columns" => lang(108),
	"Procedures" => lang(222),
) as $context => $desc) {
	foreach ((array) $privileges[$context] as $privilege => $comment) {
		echo "<tr" . odd() . "><td" . ($desc ? ">$desc<td" : " colspan='2'") . ' lang="en" title="' . h($comment) . '">' . h($privilege);
		$i = 0;
		foreach ($grants as $object => $grant) {
			$name = "'grants[$i][" . h(strtoupper($privilege)) . "]'";
			$value = $grant[strtoupper($privilege)];
			if ($context == "Server Admin" && $object != (isset($grants["*.*"]) ? "*.*" : ".*")) {
				echo "<td>&nbsp;";
			} elseif (isset($_GET["grant"])) {
				echo "<td><select name=$name><option><option value='1'" . ($value ? " selected" : "") . ">" . lang(223) . "<option value='0'" . ($value == "0" ? " selected" : "") . ">" . lang(224) . "</select>";
			} else {
				echo "<td align='center'><label class='block'><input type='checkbox' name=$name value='1'" . ($value ? " checked" : "") . ($privilege == "All privileges" ? " id='grants-$i-all'" : ($privilege == "Grant option" ? "" : " onclick=\"if (this.checked) formUncheck('grants-$i-all');\"")) . "></label>"; //! uncheck all except grant if all is checked
			}
			$i++;
		}
	}
}

echo "</table>\n";
?>
<p>
<input type="submit" value="<?php echo lang(145); ?>">
<?php if (isset($_GET["host"])) { ?><input type="submit" name="drop" value="<?php echo lang(86); ?>"<?php echo confirm(); ?>><?php } ?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["processlist"])) {
	
if (support("kill") && $_POST && !$error) {
	$killed = 0;
	foreach ((array) $_POST["kill"] as $val) {
		if (queries("KILL " . (+$val))) {
			$killed++;
		}
	}
	queries_redirect(ME . "processlist=", lang(225, $killed), $killed || !$_POST["kill"]);
}

page_header(lang(78), $error);
?>

<form action="" method="post">
<table cellspacing="0" onclick="tableClick(event);" ondblclick="tableClick(event, true);" class="nowrap checkable">
<?php
// HTML valid because there is always at least one process
$i = -1;
foreach (process_list() as $i => $row) {
	
	if (!$i) {
		echo "<thead><tr lang='en'>" . (support("kill") ? "<th>&nbsp;" : "");
		foreach ($row as $key => $val) {
			echo "<th>" . ($jush == "sql"
				? "<a href='http://dev.mysql.com/doc/refman/" . substr($connection->server_info, 0, 3) . "/en/show-processlist.html#processlist_" . strtolower($key) . "' target='_blank' rel='noreferrer' class='help'>$key</a>"
				: $key
			);
		}
		echo "</thead>\n";
	}
	
	echo "<tr" . odd() . ">" . (support("kill") ? "<td>" . checkbox("kill[]", $row["Id"], 0) : "");
	foreach ($row as $key => $val) {
		echo "<td>" . (
			($jush == "sql" && $key == "Info" && ereg("Query|Killed", $row["Command"]) && $val != "") ||
			($jush == "pgsql" && $key == "current_query" && $val != "<IDLE>") ||
			($jush == "oracle" && $key == "sql_text" && $val != "")
			? "<code class='jush-$jush'>" . shorten_utf8($val, 100, "</code>") . ' <a href="' . h(ME . ($row["db"] != "" ? "db=" . urlencode($row["db"]) . "&" : "") . "sql=" . urlencode($val)) . '">' . lang(226) . '</a>'
			: nbsp($val)
		);
	}
	echo "\n";
}
?>
</table>
<script type='text/javascript'>tableCheck();</script>
<p>
<?php
if (support("kill")) {
	echo ($i + 1) . "/" . lang(227, $connection->result("SELECT @@max_connections"));
	echo "<p><input type='submit' value='" . lang(228) . "'>\n";
}
?>
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
} elseif (isset($_GET["select"])) {
	
$TABLE = $_GET["select"];
$table_status = table_status1($TABLE);
$indexes = indexes($TABLE);
$fields = fields($TABLE);
$foreign_keys = column_foreign_keys($TABLE);
$oid = "";
if ($table_status["Oid"]) {
	$oid = ($jush == "sqlite" ? "rowid" : "oid");
	$indexes[] = array("type" => "PRIMARY", "columns" => array($oid));
}
parse_str($_COOKIE["adminer_import"], $adminer_import);

$rights = array(); // privilege => 0
$columns = array(); // selectable columns
$text_length = null;
foreach ($fields as $key => $field) {
	$name = $adminer->fieldName($field);
	if (isset($field["privileges"]["select"]) && $name != "") {
		$columns[$key] = html_entity_decode(strip_tags($name), ENT_QUOTES);
		if (is_shortable($field)) {
			$text_length = $adminer->selectLengthProcess();
		}
	}
	$rights += $field["privileges"];
}

list($select, $group) = $adminer->selectColumnsProcess($columns, $indexes);
$is_group = count($group) < count($select);
$where = $adminer->selectSearchProcess($fields, $indexes);
$order = $adminer->selectOrderProcess($fields, $indexes);
$limit = $adminer->selectLimitProcess();
$from = ($select ? implode(", ", $select) : "*" . ($oid ? ", $oid" : ""))
	. convert_fields($columns, $fields, $select)
	. "\nFROM " . table($TABLE);
$group_by = ($group && $is_group ? "\nGROUP BY " . implode(", ", $group) : "") . ($order ? "\nORDER BY " . implode(", ", $order) : "");

if ($_GET["val"] && is_ajax()) {
	header("Content-Type: text/plain; charset=utf-8");
	foreach ($_GET["val"] as $unique_idf => $row) {
		$as = convert_field($fields[key($row)]);
		echo $connection->result("SELECT" . limit($as ? $as : idf_escape(key($row)) . " FROM " . table($TABLE), " WHERE " . where_check($unique_idf, $fields) . ($where ? " AND " . implode(" AND ", $where) : "") . ($order ? " ORDER BY " . implode(", ", $order) : ""), 1));
	}
	exit;
}

if ($_POST && !$error) {
	$where_check = $where;
	if (is_array($_POST["check"])) {
		$where_check[] = "((" . implode(") OR (", array_map('where_check', $_POST["check"])) . "))";
	}
	$where_check = ($where_check ? "\nWHERE " . implode(" AND ", $where_check) : "");
	$primary = $unselected = null;
	foreach ($indexes as $index) {
		if ($index["type"] == "PRIMARY") {
			$primary = array_flip($index["columns"]);
			$unselected = ($select ? $primary : array());
			break;
		}
	}
	foreach ((array) $unselected as $key => $val) {
		if (in_array(idf_escape($key), $select)) {
			unset($unselected[$key]);
		}
	}
	
	if ($_POST["export"]) {
		cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
		dump_headers($TABLE);
		$adminer->dumpTable($TABLE, "");
		if (!is_array($_POST["check"]) || $unselected === array()) {
			$query = "SELECT $from$where_check$group_by";
		} else {
			$union = array();
			foreach ($_POST["check"] as $val) {
				// where is not unique so OR can't be used
				$union[] = "(SELECT" . limit($from, "\nWHERE " . ($where ? implode(" AND ", $where) . " AND " : "") . where_check($val, $fields) . $group_by, 1) . ")";
			}
			$query = implode(" UNION ALL ", $union);
		}
		$adminer->dumpData($TABLE, "table", $query);
		exit;
	}
	
	if (!$adminer->selectEmailProcess($where, $foreign_keys)) {
		if ($_POST["save"] || $_POST["delete"]) { // edit
			$result = true;
			$affected = 0;
			$query = table($TABLE);
			$set = array();
			if (!$_POST["delete"]) {
				foreach ($columns as $name => $val) { //! should check also for edit or insert privileges
					$val = process_input($fields[$name]);
					if ($val !== null) {
						if ($_POST["clone"]) {
							$set[idf_escape($name)] = ($val !== false ? $val : idf_escape($name));
						} elseif ($val !== false) {
							$set[] = idf_escape($name) . " = $val";
						}
					}
				}
				$query .= ($_POST["clone"] ? " (" . implode(", ", array_keys($set)) . ")\nSELECT " . implode(", ", $set) . "\nFROM " . table($TABLE) : " SET\n" . implode(",\n", $set));
			}
			if ($_POST["delete"] || $set) {
				$command = "UPDATE";
				if ($_POST["delete"]) {
					$command = "DELETE";
					$query = "FROM $query";
				}
				if ($_POST["clone"]) {
					$command = "INSERT";
					$query = "INTO $query";
				}
				if ($_POST["all"] || ($unselected === array() && is_array($_POST["check"])) || $is_group) {
					$result = queries("$command $query$where_check");
					$affected = $connection->affected_rows;
				} else {
					foreach ((array) $_POST["check"] as $val) {
						// where is not unique so OR can't be used
						$result = queries($command . limit1($query, "\nWHERE " . ($where ? implode(" AND ", $where) . " AND " : "") . where_check($val, $fields)));
						if (!$result) {
							break;
						}
						$affected += $connection->affected_rows;
					}
				}
			}
			$message = lang(229, $affected);
			if ($_POST["clone"] && $result && $affected == 1) {
				$last_id = last_id();
				if ($last_id) {
					$message = lang(142, " $last_id");
				}
			}
			queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $message, $result);
			//! display edit page in case of an error
			
		} elseif (!$_POST["import"]) { // modify
			if (!$_POST["val"]) {
				$error = lang(230);
			} else {
				$result = true;
				$affected = 0;
				foreach ($_POST["val"] as $unique_idf => $row) {
					$set = array();
					foreach ($row as $key => $val) {
						$key = bracket_escape($key, 1); // 1 - back
						$set[] = idf_escape($key) . " = " . (ereg('char|text', $fields[$key]["type"]) || $val != "" ? $adminer->processInput($fields[$key], $val) : "NULL");
					}
					$query = table($TABLE) . " SET " . implode(", ", $set);
					$where2 = " WHERE " . where_check($unique_idf, $fields) . ($where ? " AND " . implode(" AND ", $where) : "");
					$result = queries("UPDATE" . ($is_group || $unselected === array() ? " $query$where2" : limit1($query, $where2))); // can change row on a different page without unique key
					if (!$result) {
						break;
					}
					$affected += $connection->affected_rows;
				}
				queries_redirect(remove_from_uri(), lang(229, $affected), $result);
			}
			
		} elseif (!is_string($file = get_file("csv_file", true))) {
			$error = upload_error($file);
		} elseif (!preg_match('~~u', $file)) {
			$error = lang(231);
		} else {
			cookie("adminer_import", "output=" . urlencode($adminer_import["output"]) . "&format=" . urlencode($_POST["separator"]));
			$result = true;
			$cols = array_keys($fields);
			preg_match_all('~(?>"[^"]*"|[^"\\r\\n]+)+~', $file, $matches);
			$affected = count($matches[0]);
			begin();
			$separator = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
			foreach ($matches[0] as $key => $val) {
				preg_match_all("~((?>\"[^\"]*\")+|[^$separator]*)$separator~", $val . $separator, $matches2);
				if (!$key && !array_diff($matches2[1], $cols)) { //! doesn't work with column names containing ",\n
					// first row corresponds to column names - use it for table structure
					$cols = $matches2[1];
					$affected--;
				} else {
					$set = array();
					foreach ($matches2[1] as $i => $col) {
						$set[idf_escape($cols[$i])] = ($col == "" && $fields[$cols[$i]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $col))));
					}
					$result = insert_update($TABLE, $set, $primary);
					if (!$result) {
						break;
					}
				}
			}
			if ($result) {
				queries("COMMIT");
			}
			queries_redirect(remove_from_uri("page"), lang(232, $affected), $result);
			queries("ROLLBACK"); // after queries_redirect() to not overwrite error
			
		}
	}
}

$table_name = $adminer->tableName($table_status);
if (is_ajax()) {
	// needs to send headers
	ob_start();
}
page_header(lang(36) . ": $table_name", $error);

$set = null;
if (isset($rights["insert"])) {
	$set = "";
	foreach ((array) $_GET["where"] as $val) {
		if (count($foreign_keys[$val["col"]]) == 1 && ($val["op"] == "="
			|| (!$val["op"] && !ereg('[_%]', $val["val"])) // LIKE in Editor
		)) {
			$set .= "&set" . urlencode("[" . bracket_escape($val["col"]) . "]") . "=" . urlencode($val["val"]);
		}
	}
}
$adminer->selectLinks($table_status, $set);

if (!$columns) {
	echo "<p class='error'>" . lang(233) . ($fields ? "." : ": " . error()) . "\n";
} else {
	echo "<form action='' id='form'>\n";
	echo "<div style='display: none;'>";
	hidden_fields_get();
	echo (DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : ""); // not used in Editor
	echo '<input type="hidden" name="select" value="' . h($TABLE) . '">';
	echo "</div>\n";
	$adminer->selectColumnsPrint($select, $columns);
	$adminer->selectSearchPrint($where, $columns, $indexes);
	$adminer->selectOrderPrint($order, $columns, $indexes);
	$adminer->selectLimitPrint($limit);
	$adminer->selectLengthPrint($text_length);
	$adminer->selectActionPrint($indexes);
	echo "</form>\n";
	
	$page = $_GET["page"];
	if ($page == "last") {
		$found_rows = $connection->result("SELECT COUNT(*) FROM " . table($TABLE) . ($where ? " WHERE " . implode(" AND ", $where) : ""));
		$page = floor(max(0, $found_rows - 1) / $limit);
	}

	$query = $adminer->selectQueryBuild($select, $where, $group, $order, $limit, $page);
	if (!$query) {
		$query = "SELECT" . limit(
			(+$limit && $group && $is_group && $jush == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . $from,
			($where ? "\nWHERE " . implode(" AND ", $where) : "") . $group_by,
			($limit != "" ? +$limit : null),
			($page ? $limit * $page : 0),
			"\n"
		);
	}
	echo $adminer->selectQuery($query);
	
	$result = $connection->query($query);
	if (!$result) {
		echo "<p class='error'>" . error() . "\n";
	} else {
		if ($jush == "mssql" && $page) {
			$result->seek($limit * $page);
		}
		$email_fields = array();
		echo "<form action='' method='post' enctype='multipart/form-data'>\n";
		$rows = array();
		while ($row = $result->fetch_assoc()) {
			if ($page && $jush == "oracle") {
				unset($row["RNUM"]);
			}
			$rows[] = $row;
		}
		// use count($rows) without LIMIT, COUNT(*) without grouping, FOUND_ROWS otherwise (slowest)
		if ($_GET["page"] != "last") {
			$found_rows = (+$limit && $group && $is_group
				? ($jush == "sql" ? $connection->result(" SELECT FOUND_ROWS()") : $connection->result("SELECT COUNT(*) FROM ($query) x")) // space to allow mysql.trace_mode
				: count($rows)
			);
		}
		
		if (!$rows) {
			echo "<p class='message'>" . lang(89) . "\n";
		} else {
			$backward_keys = $adminer->backwardKeys($TABLE, $table_name);
			
			echo "<table id='table' cellspacing='0' class='nowrap checkable' onclick='tableClick(event);' ondblclick='tableClick(event, true);' onkeydown='return editingKeydown(event);'>\n";
			echo "<thead><tr>" . (!$group && $select ? "" : "<td><input type='checkbox' id='all-page' onclick='formCheck(this, /check/);'> <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . lang(234) . "</a>");
			$names = array();
			$functions = array();
			reset($select);
			$rank = 1;
			foreach ($rows[0] as $key => $val) {
				if ($key != $oid) {
					$val = $_GET["columns"][key($select)];
					$field = $fields[$select ? ($val ? $val["col"] : current($select)) : $key];
					$name = ($field ? $adminer->fieldName($field, $rank) : "*");
					if ($name != "") {
						$rank++;
						$names[$key] = $name;
						$column = idf_escape($key);
						$href = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($key);
						$desc = "&desc%5B0%5D=1";
						echo '<th onmouseover="columnMouse(this);" onmouseout="columnMouse(this, \' hidden\');">';
						echo '<a href="' . h($href . ($order[0] == $column || $order[0] == $key || (!$order && $is_group && $group[0] == $column) ? $desc : '')) . '">'; // $order[0] == $key - COUNT(*)
						echo (!$select || $val ? apply_sql_function($val["fun"], $name) : h(current($select))) . "</a>"; //! columns looking like functions
						echo "<span class='column hidden'>";
						echo "<a href='" . h($href . $desc) . "' title='" . lang(42) . "' class='text'> â†“</a>";
						if (!$val["fun"]) {
							echo '<a href="#fieldset-search" onclick="selectSearch(\'' . h(js_escape($key)) . '\'); return false;" title="' . lang(39) . '" class="text jsonly"> =</a>';
						}
						echo "</span>";
					}
					$functions[$key] = $val["fun"];
					next($select);
				}
			}
			
			$lengths = array();
			if ($_GET["modify"]) {
				foreach ($rows as $row) {
					foreach ($row as $key => $val) {
						$lengths[$key] = max($lengths[$key], min(40, strlen(utf8_decode($val))));
					}
				}
			}
			
			echo ($backward_keys ? "<th>" . lang(235) : "") . "</thead>\n";
			
			if (is_ajax()) {
				if ($limit % 2 == 1 && $page % 2 == 1) {
					odd();
				}
				ob_end_clean();
			}
			
			foreach ($adminer->rowDescriptions($rows, $foreign_keys) as $n => $row) {
				$unique_array = unique_array($rows[$n], $indexes);
				if (!$unique_array) {
					$unique_array = array();
					foreach ($rows[$n] as $key => $val) {
						if (!preg_match('~^(COUNT\\((\\*|(DISTINCT )?`(?:[^`]|``)+`)\\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\\(`(?:[^`]|``)+`\\))$~', $key)) { //! columns looking like functions
							$unique_array[$key] = $val;
						}
					}
				}
				$unique_idf = "";
				foreach ($unique_array as $key => $val) {
					if (strlen($val) > 64) {
						$key = "MD5(" . (strpos($key, '(') ? $key : idf_escape($key)) . ")"; //! columns looking like functions
						$val = md5($val);
					}
					$unique_idf .= "&" . ($val !== null ? urlencode("where[" . bracket_escape($key) . "]") . "=" . urlencode($val) : "null%5B%5D=" . urlencode($key));
				}
				echo "<tr" . odd() . ">" . (!$group && $select ? "" : "<td>" . checkbox("check[]", substr($unique_idf, 1), in_array(substr($unique_idf, 1), (array) $_POST["check"]), "", "this.form['all'].checked = false; formUncheck('all-page');") . ($is_group || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($TABLE) . $unique_idf) . "'>" . lang(234) . "</a>"));
				
				foreach ($row as $key => $val) {
					if (isset($names[$key])) {
						$field = $fields[$key];
						if ($val != "" && (!isset($email_fields[$key]) || $email_fields[$key] != "")) {
							$email_fields[$key] = (is_mail($val) ? $names[$key] : ""); //! filled e-mails can be contained on other pages
						}
						
						$link = "";
						$val = $adminer->editVal($val, $field);
						if ($val !== null) {
							if (ereg('blob|bytea|raw|file', $field["type"]) && $val != "") {
								$link = ME . 'download=' . urlencode($TABLE) . '&field=' . urlencode($key) . $unique_idf;
							}
							if ($val === "") { // === - may be int
								$val = "&nbsp;";
							} elseif ($text_length != "" && is_shortable($field)) {
								$val = shorten_utf8($val, max(0, +$text_length)); // usage of LEFT() would reduce traffic but complicate query - expected average speedup: .001 s VS .01 s on local network
							} else {
								$val = h($val);
							}
							
							if (!$link) { // link related items
								foreach ((array) $foreign_keys[$key] as $foreign_key) {
									if (count($foreign_keys[$key]) == 1 || end($foreign_key["source"]) == $key) {
										$link = "";
										foreach ($foreign_key["source"] as $i => $source) {
											$link .= where_link($i, $foreign_key["target"][$i], $rows[$n][$source]);
										}
										$link = ($foreign_key["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\\1' . urlencode($foreign_key["db"]), ME) : ME) . 'select=' . urlencode($foreign_key["table"]) . $link; // InnoDB supports non-UNIQUE keys
										if (count($foreign_key["source"]) == 1) {
											break;
										}
									}
								}
							}
							
							if ($key == "COUNT(*)") { //! columns looking like functions
								$link = ME . "select=" . urlencode($TABLE);
								$i = 0;
								foreach ((array) $_GET["where"] as $v) {
									if (!array_key_exists($v["col"], $unique_array)) {
										$link .= where_link($i++, $v["col"], $v["val"], $v["op"]);
									}
								}
								foreach ($unique_array as $k => $v) {
									$link .= where_link($i++, $k, $v);
								}
							}
							
						}
						
						if (!$link && ($link = $adminer->selectLink($row[$key], $field)) === null) {
							if (is_mail($row[$key])) {
								$link = "mailto:$row[$key]";
							}
							if ($protocol = is_url($row[$key])) {
								$link = ($protocol == "http" && $HTTPS
									? $row[$key] // HTTP links from HTTPS pages don't receive Referer automatically
									: "$protocol://www.adminer.org/redirect/?url=" . urlencode($row[$key]) // intermediate page to hide Referer, may be changed to rel="noreferrer" in HTML5
								);
							}
						}
						
						$id = h("val[$unique_idf][" . bracket_escape($key) . "]");
						$value = $_POST["val"][$unique_idf][bracket_escape($key)];
						$h_value = h($value !== null ? $value : $row[$key]);
						$long = strpos($val, "<i>...</i>");
						$editable = is_utf8($val) && $rows[$n][$key] == $row[$key] && !$functions[$key];
						$text = ereg('text|lob', $field["type"]);
						echo (($_GET["modify"] && $editable) || $value !== null
							? "<td>" . ($text ? "<textarea name='$id' cols='30' rows='" . (substr_count($row[$key], "\n") + 1) . "'>$h_value</textarea>" : "<input name='$id' value='$h_value' size='$lengths[$key]'>")
							: "<td id='$id' onclick=\"selectClick(this, event, " . ($long ? 2 : ($text ? 1 : 0)) . ($editable ? "" : ", '" . h(lang(236)) . "'") . ");\">" . $adminer->selectVal($val, $link, $field)
						);
					}
				}
				
				if ($backward_keys) {
					echo "<td>";
				}
				$adminer->backwardKeysPrint($backward_keys, $rows[$n]);
				echo "</tr>\n"; // close to allow white-space: pre
			}
			
			if (is_ajax()) {
				exit;
			}
			echo "</table>\n";
			echo (!$group && $select ? "" : "<script type='text/javascript'>tableCheck();</script>\n");
		}
		
		if (($rows || $page) && !is_ajax()) {
			$exact_count = true;
			if ($_GET["page"] != "last" && +$limit && !$is_group && ($found_rows >= $limit || $page)) {
				$found_rows = found_rows($table_status, $where);
				if ($found_rows < max(1e4, 2 * ($page + 1) * $limit)) {
					// slow with big tables
					$found_rows = reset(slow_query("SELECT COUNT(*) FROM " . table($TABLE) . ($where ? " WHERE " . implode(" AND ", $where) : "")));
				} else {
					$exact_count = false;
				}
			}
			
			if (+$limit && ($found_rows === false || $found_rows > $limit || $page)) {
				echo "<p class='pages'>";
				// display first, previous 4, next 4 and last page
				$max_page = ($found_rows === false
					? $page + (count($rows) >= $limit ? 2 : 1)
					: floor(($found_rows - 1) / $limit)
				);
				echo '<a href="' . h(remove_from_uri("page")) . "\" onclick=\"pageClick(this.href, +prompt('" . lang(237) . "', '" . ($page + 1) . "'), event); return false;\">" . lang(237) . "</a>:";
				echo pagination(0, $page) . ($page > 5 ? " ..." : "");
				for ($i = max(1, $page - 4); $i < min($max_page, $page + 5); $i++) {
					echo pagination($i, $page);
				}
				if ($max_page > 0) {
					echo ($page + 5 < $max_page ? " ..." : "");
					echo ($exact_count && $found_rows !== false
						? pagination($max_page, $page)
						: " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$max_page'>" . lang(238) . "</a>"
					);
				}
				echo (($found_rows === false ? count($rows) + 1 : $found_rows - $page * $limit) > $limit ? ' <a href="' . h(remove_from_uri("page") . "&page=" . ($page + 1)) . '" onclick="return !selectLoadMore(this, ' . (+$limit) . ', \'' . lang(239) . '\');">' . lang(240) . '</a>' : '');
			}
			
			echo "<p>\n";
			echo ($found_rows !== false ? "(" . ($exact_count ? "" : "~ ") . lang(126, $found_rows) . ") " : "");
			echo checkbox("all", 1, 0, lang(241)) . "\n";
			
			if ($adminer->selectCommandPrint()) {
				?>
<fieldset><legend><?php echo lang(34); ?></legend><div>
<input type="submit" value="<?php echo lang(145); ?>"<?php echo ($_GET["modify"] ? '' : ' title="' . lang(230) . '" class="jsonly"'); ?>>
<input type="submit" name="edit" value="<?php echo lang(34); ?>">
<input type="submit" name="clone" value="<?php echo lang(226); ?>">
<input type="submit" name="delete" value="<?php echo lang(148); ?>" onclick="return confirm('<?php echo lang(0); ?> (' + (this.form['all'].checked ? <?php echo $found_rows; ?> : formChecked(this, /check/)) + ')');">
</div></fieldset>
<?php
			}
			
			$format = $adminer->dumpFormat();
			foreach ((array) $_GET["columns"] as $column) {
				if ($column["fun"]) {
					unset($format['sql']);
					break;
				}
			}
			if ($format) {
				print_fieldset("export", lang(118));
				$output = $adminer->dumpOutput();
				echo ($output ? html_select("output", $output, $adminer_import["output"]) . " " : "");
				echo html_select("format", $format, $adminer_import["format"]);
				echo " <input type='submit' name='export' value='" . lang(118) . "'>\n";
				echo "</div></fieldset>\n";
			}
		}
		
		if ($adminer->selectImportPrint()) {
			print_fieldset("import", lang(55), !$rows);
			echo "<input type='file' name='csv_file'> ";
			echo html_select("separator", array("csv" => "CSV,", "csv;" => "CSV;", "tsv" => "TSV"), $adminer_import["format"], 1); // 1 - select
			echo " <input type='submit' name='import' value='" . lang(55) . "'>";
			echo "</div></fieldset>\n";
		}
		
		$adminer->selectEmailPrint(array_filter($email_fields, 'strlen'), $columns);
		
		echo "<p><input type='hidden' name='token' value='$token'></p>\n";
		echo "</form>\n";
	}
}

if (is_ajax()) {
	ob_end_clean();
	exit;
}

} elseif (isset($_GET["variables"])) {
	
$status = isset($_GET["status"]);
page_header($status ? lang(80) : lang(79));

$variables = ($status ? show_status() : show_variables());
if (!$variables) {
	echo "<p class='message'>" . lang(89) . "\n";
} else {
	echo "<table cellspacing='0'>\n";
	foreach ($variables as $key => $val) {
		echo "<tr>";
		echo "<th><code class='jush-" . $jush . ($status ? "status" : "set") . "'>" . h($key) . "</code>";
		echo "<td>" . nbsp($val);
	}
	echo "</table>\n";
}

} elseif (isset($_GET["script"])) {
	
header("Content-Type: text/javascript; charset=utf-8");

if ($_GET["script"] == "db") {
	$sums = array("Data_length" => 0, "Index_length" => 0, "Data_free" => 0);
	foreach (table_status() as $name => $table_status) {
		$id = js_escape($name);
		json_row("Comment-$id", nbsp($table_status["Comment"]));
		if (!is_view($table_status)) {
			foreach (array("Engine", "Collation") as $key) {
				json_row("$key-$id", nbsp($table_status[$key]));
			}
			foreach ($sums + array("Auto_increment" => 0, "Rows" => 0) as $key => $val) {
				if ($table_status[$key] != "") {
					$val = number_format($table_status[$key], 0, '.', lang(8));
					json_row("$key-$id", ($key == "Rows" && $val && $table_status["Engine"] == ($sql == "pgsql" ? "table" : "InnoDB")
						? "~ $val"
						: $val
					));
					if (isset($sums[$key])) {
						// ignore innodb_file_per_table because it is not active for tables created before it was enabled
						$sums[$key] += ($table_status["Engine"] != "InnoDB" || $key != "Data_free" ? $table_status[$key] : 0);
					}
				} elseif (array_key_exists($key, $table_status)) {
					json_row("$key-$id");
				}
			}
		}
	}
	foreach ($sums as $key => $val) {
		json_row("sum-$key", number_format($val, 0, '.', lang(8)));
	}
	json_row("");

} elseif ($_GET["script"] == "kill") {
	$connection->query("KILL " . (+$_POST["kill"]));

} else { // connect
	foreach (count_tables($adminer->databases()) as $db => $val) {
		json_row("tables-" . js_escape($db), $val);
	}
	json_row("");
}

exit; // don't print footer

} else {
	
$tables_views = array_merge((array) $_POST["tables"], (array) $_POST["views"]);

if ($tables_views && !$error && !$_POST["search"]) {
	$result = true;
	$message = "";
	if ($jush == "sql" && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) {
		queries("SET foreign_key_checks = 0"); // allows to truncate or drop several tables at once
	}
	
	if ($_POST["truncate"]) {
		if ($_POST["tables"]) {
			$result = truncate_tables($_POST["tables"]);
		}
		$message = lang(242);
	} elseif ($_POST["move"]) {
		$result = move_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
		$message = lang(243);
	} elseif ($_POST["copy"]) {
		$result = copy_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
		$message = lang(244);
	} elseif ($_POST["drop"]) {
		if ($_POST["views"]) {
			$result = drop_views($_POST["views"]);
		}
		if ($result && $_POST["tables"]) {
			$result = drop_tables($_POST["tables"]);
		}
		$message = lang(245);
	} elseif ($jush != "sql") {
		$result = ($jush == "sqlite"
			? queries("VACUUM")
			: apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE"), $_POST["tables"])
		);
		$message = lang(246);
	} elseif (!$_POST["tables"]) {
		$message = lang(7);
	} elseif ($result = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('idf_escape', $_POST["tables"])))) {
		while ($row = $result->fetch_assoc()) {
			$message .= "<b>" . h($row["Table"]) . "</b>: " . h($row["Msg_text"]) . "<br>";
		}
	}
	
	queries_redirect(substr(ME, 0, -1), $message, $result);
}

page_header(($_GET["ns"] == "" ? lang(25) . ": " . h(DB) : lang(87) . ": " . h($_GET["ns"])), $error, true);

if ($adminer->homepage()) {
	if ($_GET["ns"] !== "") {
		echo "<h3 id='tables-views'>" . lang(247) . "</h3>\n";
		$tables_list = tables_list();
		if (!$tables_list) {
			echo "<p class='message'>" . lang(7) . "\n";
		} else {
			echo "<form action='' method='post'>\n";
			echo "<p>" . lang(248) . ": <input type='search' name='query' value='" . h($_POST["query"]) . "'> <input type='submit' name='search' value='" . lang(39) . "'>\n";
			if ($_POST["search"] && $_POST["query"] != "") {
				search_tables();
			}
			echo "<table cellspacing='0' class='nowrap checkable' onclick='tableClick(event);' ondblclick='tableClick(event, true);'>\n";
			
			echo '<thead><tr class="wrap"><td><input id="check-all" type="checkbox" onclick="formCheck(this, /^(tables|views)\[/);">';
			echo '<th>' . lang(107);
			echo '<td>' . lang(249);
			echo '<td>' . lang(84);
			echo '<td>' . lang(250);
			echo '<td>' . lang(251);
			echo '<td>' . lang(252);
			echo '<td>' . lang(99);
			echo '<td>' . lang(253);
			echo (support("comment") ? '<td>' . lang(101) : '');
			echo "</thead>\n";
			
			foreach ($tables_list as $name => $type) {
				$view = ($type !== null && !eregi("table", $type));
				echo '<tr' . odd() . '><td>' . checkbox(($view ? "views[]" : "tables[]"), $name, in_array($name, $tables_views, true), "", "formUncheck('check-all');");
				echo '<th><a href="' . h(ME) . 'table=' . urlencode($name) . '" title="' . lang(29) . '">' . h($name) . '</a>';
				if ($view) {
					echo '<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($name) . '" title="' . lang(30) . '">' . lang(106) . '</a>';
					echo '<td align="right"><a href="' . h(ME) . "select=" . urlencode($name) . '" title="' . lang(28) . '">?</a>';
				} else {
					foreach (array(
						"Engine" => array(),
						"Collation" => array(),
						"Data_length" => array("create", lang(31)),
						"Index_length" => array("indexes", lang(110)),
						"Data_free" => array("edit", lang(32)),
						"Auto_increment" => array("auto_increment=1&create", lang(31)),
						"Rows" => array("select", lang(28)),
					) as $key => $link) {
						echo ($link ? "<td align='right'><a href='" . h(ME . "$link[0]=") . urlencode($name) . "' id='$key-" . h($name) . "' title='$link[1]'>?</a>" : "<td id='$key-" . h($name) . "'>&nbsp;");
					}
				}
				echo (support("comment") ? "<td id='Comment-" . h($name) . "'>&nbsp;" : "");
			}
			
			echo "<tr><td>&nbsp;<th>" . lang(227, count($tables_list));
			echo "<td>" . nbsp($jush == "sql" ? $connection->result("SELECT @@storage_engine") : "");
			echo "<td>" . nbsp(db_collation(DB, collations()));
			foreach (array("Data_length", "Index_length", "Data_free") as $key) {
				echo "<td align='right' id='sum-$key'>&nbsp;";
			}
			
			echo "</table>\n";
			echo "<script type='text/javascript'>tableCheck();</script>\n";
			if (!information_schema(DB)) {
				echo "<p>" . (ereg('^(sql|sqlite|pgsql)$', $jush)
					? ($jush != "sqlite" ? "<input type='submit' value='" . lang(254) . "'> " : "")
					. "<input type='submit' name='optimize' value='" . lang(255) . "'> " : ""
				) . ($jush == "sql" ? "<input type='submit' name='check' value='" . lang(256) . "'> <input type='submit' name='repair' value='" . lang(257) . "'> " : "") . "<input type='submit' name='truncate' value='" . lang(258) . "'" . confirm("formChecked(this, /tables/)") . "> <input type='submit' name='drop' value='" . lang(86) . "'" . confirm("formChecked(this, /tables|views/)") . ">\n";
				$databases = (support("scheme") ? schemas() : $adminer->databases());
				if (count($databases) != 1 && $jush != "sqlite") {
					$db = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
					echo "<p>" . lang(259) . ": ";
					echo ($databases ? html_select("target", $databases, $db) : '<input name="target" value="' . h($db) . '" autocapitalize="off">');
					echo " <input type='submit' name='move' value='" . lang(260) . "'>";
					echo (support("copy") ? " <input type='submit' name='copy' value='" . lang(261) . "'>" : "");
					echo "\n";
				}
				echo "<input type='hidden' name='token' value='$token'>\n";
			}
			echo "</form>\n";
		}
		
		echo '<p><a href="' . h(ME) . 'create=">' . lang(152) . "</a>\n";
		if (support("view")) {
			echo '<a href="' . h(ME) . 'view=">' . lang(184) . "</a>\n";
		}
	
		if (support("routine")) {
			echo "<h3 id='routines'>" . lang(121) . "</h3>\n";
			$routines = routines();
			if ($routines) {
				echo "<table cellspacing='0'>\n";
				echo '<thead><tr><th>' . lang(162) . '<td>' . lang(96) . '<td>' . lang(201) . "<td>&nbsp;</thead>\n";
				odd('');
				foreach ($routines as $row) {
					echo '<tr' . odd() . '>';
					echo '<th><a href="' . h(ME) . ($row["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($row["ROUTINE_NAME"]) . '">' . h($row["ROUTINE_NAME"]) . '</a>';
					echo '<td>' . h($row["ROUTINE_TYPE"]);
					echo '<td>' . h($row["DTD_IDENTIFIER"]);
					echo '<td><a href="' . h(ME) . ($row["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($row["ROUTINE_NAME"]) . '">' . lang(113) . "</a>";
				}
				echo "</table>\n";
			}
			echo '<p>' . (support("procedure") ? '<a href="' . h(ME) . 'procedure=">' . lang(200) . '</a> ' : '') . '<a href="' . h(ME) . 'function=">' . lang(199) . "</a>\n";
		}
		
		if (support("sequence")) {
			echo "<h3 id='sequences'>" . lang(262) . "</h3>\n";
			$sequences = get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema()");
			if ($sequences) {
				echo "<table cellspacing='0'>\n";
				echo "<thead><tr><th>" . lang(162) . "</thead>\n";
				odd('');
				foreach ($sequences as $val) {
					echo "<tr" . odd() . "><th><a href='" . h(ME) . "sequence=" . urlencode($val) . "'>" . h($val) . "</a>\n";
				}
				echo "</table>\n";
			}
			echo "<p><a href='" . h(ME) . "sequence='>" . lang(206) . "</a>\n";
		}
		
		if (support("type")) {
			echo "<h3 id='user-types'>" . lang(13) . "</h3>\n";
			$user_types = types();
			if ($user_types) {
				echo "<table cellspacing='0'>\n";
				echo "<thead><tr><th>" . lang(162) . "</thead>\n";
				odd('');
				foreach ($user_types as $val) {
					echo "<tr" . odd() . "><th><a href='" . h(ME) . "type=" . urlencode($val) . "'>" . h($val) . "</a>\n";
				}
				echo "</table>\n";
			}
			echo "<p><a href='" . h(ME) . "type='>" . lang(210) . "</a>\n";
		}
		
		if (support("event")) {
			echo "<h3 id='events'>" . lang(122) . "</h3>\n";
			$rows = get_rows("SHOW EVENTS");
			if ($rows) {
				echo "<table cellspacing='0'>\n";
				echo "<thead><tr><th>" . lang(162) . "<td>" . lang(263) . "<td>" . lang(190) . "<td>" . lang(191) . "<td></thead>\n";
				foreach ($rows as $row) {
					echo "<tr>";
					echo "<th>" . h($row["Name"]);
					echo "<td>" . ($row["Execute at"] ? lang(264) . "<td>" . $row["Execute at"] : lang(192) . " " . $row["Interval value"] . " " . $row["Interval field"] . "<td>$row[Starts]");
					echo "<td>$row[Ends]";
					echo '<td><a href="' . h(ME) . 'event=' . urlencode($row["Name"]) . '">' . lang(113) . '</a>';
				}
				echo "</table>\n";
				$event_scheduler = $connection->result("SELECT @@event_scheduler");
				if ($event_scheduler && $event_scheduler != "ON") {
					echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($event_scheduler) . "\n";
				}
			}
			echo '<p><a href="' . h(ME) . 'event=">' . lang(189) . "</a>\n";
		}
		
		if ($tables_list) {
			echo "<script type='text/javascript'>ajaxSetHtml('" . js_escape(ME) . "script=db');</script>\n";
		}
	}
}

}

// each page calls its own page_header(), if the footer should not be called then the page exits
page_footer();
