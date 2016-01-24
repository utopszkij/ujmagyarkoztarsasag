<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	4.9.3
 * @author	acyba.com
 * @copyright	(C) 2009-2015 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><div id="acy_content" >
<?php $app = JFactory::getApplication(); $adminPath = $app->isAdmin() ? '../' : JURI::base(true)."/";
if(empty($this->mailingstats->mailid)) die('No statistics recorded yet'); ?>
<script language="JavaScript" type="text/javascript">
	function drawChartSendProcess() {
		document.getElementById('sendprocess').style.display = 'block';
		document.getElementById('open').style.display = 'block';
		var dataTable = new google.visualization.DataTable();
		dataTable.addColumn('string');
		dataTable.addColumn('number');
		dataTable.addRows(3);

		dataTable.setValue(0, 0, '<?php echo intval($this->mailingstats->senthtml).' '.JText::_('SENT_HTML',true); ?>');
		dataTable.setValue(1, 0, '<?php echo intval($this->mailingstats->senttext).' '.JText::_('SENT_TEXT',true); ?>');
		dataTable.setValue(2, 0, '<?php echo intval($this->mailingstats->fail).' '.JText::_('FAILED',true); ?>');

		dataTable.setValue(0, 1, <?php echo intval($this->mailingstats->senthtml); ?>);
		dataTable.setValue(1, 1, <?php echo intval($this->mailingstats->senttext); ?>);
		dataTable.setValue(2, 1, <?php echo intval($this->mailingstats->fail); ?>);

		var vis = new google.visualization.PieChart(document.getElementById('sendprocess'));
		var options = {
			width: 370,
			height: 300,
			colors: ['#40A640','#5F78B5','#A42B37'],
			title: '<?php echo JText::_('SEND_PROCESS',true);?>',
			is3D:true,
			legendTextStyle: {color:'#333333'}
		};
		vis.draw(dataTable, options);
	}

	function drawChartOpen(){
		var vis = new google.visualization.PieChart(document.getElementById('open'));
		var options = {
			width: 370,
			height: 300,
			colors: ['#40A640','#5F78B5'],
			title: '<?php echo JText::_('OPEN',true);?>',
			is3D:true,
			legendTextStyle: {color:'#333333'}
		};
		vis.draw(getDatadrawChartOpen(), options);
	}
	function getDatadrawChartOpen(){
		var dataTable = new google.visualization.DataTable();
		dataTable.addRows(2);

		dataTable.addColumn('string');
		dataTable.addColumn('number');
		dataTable.setValue(0, 0, '<?php echo intval($this->mailingstats->openunique).' '.JText::_('OPEN',true); ?>');
		dataTable.setValue(0, 1, <?php echo intval($this->mailingstats->openunique); ?>);
		<?php if(acymailing_level(3)) $bounceval = $this->mailingstats->bounceunique;
		else $bounceval = 0;
		?>
		dataTable.setValue(1, 0, '<?php $notOpen = intval($this->mailingstats->senthtml - $this->mailingstats->openunique - $bounceval); echo $notOpen.' '.JText::_('NOT_OPEN',true); ?>');
		dataTable.setValue(1, 1, <?php echo $notOpen; ?>);

		return dataTable;
	}

	function getDatadrawChartOpenclick(){
		var dataTable = new google.visualization.DataTable();
		dataTable.addRows(<?php echo count($this->openclick->open); ?>);

		dataTable.addColumn('string');

		dataTable.addColumn('number','<?php echo JText::_('OPEN',true); ?>');
		dataTable.addColumn('number','<?php echo JText::_('CLICKED_LINK',true);?>');

		<?php foreach($this->openclick->open as $i => $oneResult){
			if(!empty($this->openclick->legend[$i])) echo "dataTable.setValue($i, 0, '".addslashes($this->openclick->legend[$i])."');";
			echo "dataTable.setValue($i, 1, $oneResult);";
			echo "dataTable.setValue($i,2,".$this->openclick->click[$i].");";
		}
				?>
		return dataTable;
	}
	function drawChartOpenclick(){


		var vis = new google.visualization.LineChart(document.getElementById('openclick'));
		var options = {
			width: 750,
			height: 300,
			colors: ['#40A640','#5F78B5'],
			legend:'bottom',
			title: '<?php echo JText::_('ACY_STAT_OPEN_CLICK',true); ?>',
			legendTextStyle: {color:'#333333'}
		};
		vis.draw(getDatadrawChartOpenclick(), options);
	}

	function displayChart(chartname){
		document.getElementById('openclick').style.display = 'none';
		document.getElementById('chartopenratetable').style.display = 'none';
		document.getElementById(chartname).style.display = 'block';
	}

	function getDatadrawChartOpenclickperday(){
		var dataTable = new google.visualization.DataTable();
		dataTable.addRows(<?php echo min(10,count($this->openclickday)); ?>);

		dataTable.addColumn('string');

		dataTable.addColumn('number','<?php echo JText::_('OPEN',true); ?>');
		dataTable.addColumn('number','<?php echo JText::_('CLICKED_LINK',true);?>');

		<?php $i=min(10,count($this->openclickday))-1;
		$nextDate = '';
		foreach($this->openclickday as $oneResult){
			if(!empty($nextDate) AND $nextDate != $oneResult['date']){
				echo "dataTable.setValue($i, 0, '...'); ";
				if($i-- == 0) break;
			}
			echo "dataTable.setValue($i, 0, '".addslashes($oneResult['date'])."'); ";
			echo "dataTable.setValue($i, 1, ".intval(@$oneResult['open']->totalopen)."); ";
			echo "dataTable.setValue($i,2,".intval(@$oneResult['click']->totalclick)."); ";
			$nextDate = $oneResult['nextdate'];
			if($i-- == 0) break;
		}
				?>

		return dataTable;
	}

	function drawChartOpenclickperday(){
		var vis = new google.visualization.ColumnChart(document.getElementById('openclick'));
		var options = {
			width: 750,
			height: 300,
			colors: ['#40A640','#5F78B5'],
			legend:'bottom',
			title: '<?php echo JText::_('ACY_STAT_OPEN_CLICK_DAY',true); ?>',
			legendTextStyle: {color:'#333333'}
		};
		vis.draw(getDatadrawChartOpenclickperday(), options);

	}
<?php if(!empty($this->browserstats)){ ?>
	function drawChartBrowser(){
		var vis = new google.visualization.PieChart(document.getElementById('openclick'));
		var options = {
			width: 750,
			height: 300,
			title: '<?php echo JText::_('ACY_STAT_BROWSER',true);?>',
			is3D:true,
			legendTextStyle: {color:'#333333'}
		};
		vis.draw(getDatadrawChartBrowser(), options);
	}
	function getDatadrawChartBrowser(){
		var dataTable = new google.visualization.DataTable();
		dataTable.addRows(<?php echo count($this->browserstats);?>);

		dataTable.addColumn('string');
		dataTable.addColumn('number');
		var i = 0;
		<?php foreach($this->browserstats as $oneBrowser => $detailBrowser){ ?>
			dataTable.setValue(i, 0, '<?php echo intval($detailBrowser->nbBrowser).' '.$oneBrowser; ?>');
			dataTable.setValue(i, 1, <?php echo intval($detailBrowser->nbBrowser); ?>);
			i+=1;
		<?php } ?>

		return dataTable;
	}
<?php } ?>
<?php if(!empty($this->ismobilestats)){ ?>
	function drawChartIsMobile(){
		var vis = new google.visualization.PieChart(document.getElementById('sendprocess'));
		var options = {
			width: 370,
			height: 300,
			colors: ['#40A640','#5F78B5'],
			title: '<?php echo JText::_('ACY_STAT_MOBILE_USAGE',true);?>',
			is3D:true,
			legendTextStyle: {color:'#333333'}
		};
		vis.draw(getDatadrawChartIsMobile(), options);
	}
	function getDatadrawChartIsMobile(){
		var dataTable = new google.visualization.DataTable();
		dataTable.addRows(2);

		dataTable.addColumn('string');
		dataTable.addColumn('number');
		<?php $valNoMob = (empty($this->ismobilestats[0])?0:$this->ismobilestats[0]->nbMobile);
		$valMob = (empty($this->ismobilestats[1])?0:$this->ismobilestats[1]->nbMobile); ?>
		dataTable.setValue(0, 0, '<?php echo intval($valNoMob).' '.JText::_('ACY_STAT_NOMOBILE'); ?>');
		dataTable.setValue(0, 1, <?php echo intval($valNoMob); ?>);
		dataTable.setValue(1, 0, '<?php echo intval($valMob).' '.JText::_('ACY_STAT_MOBILE'); ?>');
		dataTable.setValue(1, 1, <?php echo intval($valMob); ?>);

		return dataTable;
	}
<?php } else{ ?>
	function drawChartIsMobile(){
		document.getElementById('sendprocess').style.display = 'none';
	}
<?php } ?>
<?php if(!empty($this->mobileosstats)){ ?>
	function drawChartMobileOS(){

		var vis = new google.visualization.PieChart(document.getElementById('open'));
		var options = {
			width: 375,
			height: 300,
			title: '<?php echo JText::_('ACY_STAT_MOBILEOS',true);?>',
			is3D:true,
			legendTextStyle: {color:'#333333'},
			chartAreaLeft: 10
		};
		vis.draw(getDatadrawChartMobileOS(), options);
	}
	function getDatadrawChartMobileOS(){
		var dataTable = new google.visualization.DataTable();
		dataTable.addRows(<?php echo count($this->mobileosstats);?>);

		dataTable.addColumn('string');
		dataTable.addColumn('number');

		var i = 0;
		<?php foreach($this->mobileosstats as $oneOS => $detailOS){ ?>
			dataTable.setValue(i, 0, '<?php echo intval($detailOS->nbOS).' '.$oneOS; ?>');
			dataTable.setValue(i, 1, <?php echo intval($detailOS->nbOS); ?>);
			i+=1;
		<?php } ?>

		return dataTable;
	}
<?php } else{ ?>
	function drawChartMobileOS(){
		document.getElementById('open').style.display = 'none';

	}
<?php } ?>

	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChartSendProcess);
	google.setOnLoadCallback(drawChartOpen);
</script>
<style type="text/css">
	div.miniacycharts{
		width:80px;
		float:left;
		text-align:center;
	}
	span.statnumber{ font-size:14px}
	body{height:auto}
</style>
<h1 class="onlyprint"><?php echo $this->mailing->subject; ?></h1>
<form action="index.php?option=<?php echo ACYMAILING_COMPONENT ?>" method="post" name="adminForm" autocomplete="off" id="adminForm" >
	<fieldset class="acyheaderarea">
		<div class="acyheader icon-48-stats" style="float: left;"><?php echo $this->mailing->subject; ?></div>
		<div class="toolbar" id="toolbar" style="float: right;">
			<table><tr>
			<td><a onclick="window.print(); return false;" href="#" ><span class="icon-32-acyprint" title="<?php echo JText::_('ACY_PRINT',true); ?>"></span><?php echo JText::_('ACY_PRINT'); ?></a></td>
			</tr></table>
		</div>
	</fieldset>
</form>

<table width="100%">
<tr><td width="45%">
	<fieldset class="adminform">
		<legend><?php echo JText::_('ACY_SUMMARY'); ?></legend>
		<ul>
			<li>
			<?php
			$text = '<span class="statnumber">'.((int) $this->mailingstats->senthtml + (int)$this->mailingstats->senttext).'</span>';
			if(acymailing_isAllowed($this->config->get('acl_subscriber_view','all'))){
				$link = 'stats&task=detaillisting';
				if(!$app->isAdmin()) $link = 'frontnewsletter&task=detailstats&listid='.JRequest::getInt('listid').'&mailid='.$this->mailing->mailid;
				$text = '<a href="'.acymailing_completeLink($link.'&filter_status=0&filter_mail='.$this->mailing->mailid,true).'">'.$text.'</a>';
			}
			echo JText::sprintf('TOTAL_EMAIL_SENT',$text) ?></li>
			<?php if(!empty($this->mailingstats->queue)){ ?>
				<li><?php echo JText::sprintf('NB_PENDING_EMAIL',$this->mailingstats->queue,'<b><i>'.$this->mailing->subject.'</i></b>'); ?></li>
			<?php } ?>
			<?php if(!empty($this->mailingstats->senddate)){ ?>
				<li><?php echo JText::_('SEND_DATE').' : <span class="statnumber">'.acymailing_getDate($this->mailingstats->senddate); ?></span></li>
			<?php } ?>
				<?php if(!empty($this->mailingstats->senthtml)){?>
			<li>
			<?php
				if(acymailing_level(3)) $cleanSent = $this->mailingstats->senthtml+$this->mailingstats->senttext-$this->mailingstats->bounceunique;
				else $cleanSent = $this->mailingstats->senthtml+$this->mailingstats->senttext;
				$pourcent = ($cleanSent == 0?'0%':(substr( $this->mailingstats->openunique/$cleanSent*100,0,5)).'%');
				$text = '<span class="statnumber">'.$pourcent.'</span>';
				if(acymailing_isAllowed($this->config->get('acl_subscriber_view','all'))){
					$link = 'stats&task=detaillisting';
					if(!$app->isAdmin()) $link = 'frontnewsletter&task=detailstats&listid='.JRequest::getInt('listid').'&mailid='.$this->mailing->mailid;
					$text = '<a href="'.acymailing_completeLink($link.'&filter_status=open&filter_mail='.$this->mailing->mailid,true).'">'.$text.'</a>';
				}

				echo JText::sprintf('NB_OPEN_USERS',$text).' ( '.$this->mailingstats->openunique.' / '.$cleanSent.' )';
			?>
			</li>
			<li>
			<?php
				$pourcent = ($cleanSent == 0?'0%':(substr( $this->mailingstats->clickunique/$cleanSent*100,0,5)).'%');
				$text = '<span class="statnumber">'.$pourcent.'</span>';
				if(acymailing_isAllowed($this->config->get('acl_subscriber_view','all'))){
					$link = 'statsurl&task=detaillisting';
					if(!$app->isAdmin()) $link = 'frontnewsletter&task=statsclick&listid='.JRequest::getInt('listid').'&mailid='.$this->mailing->mailid;
					$text = '<a href="'.acymailing_completeLink($link.'&filter_url=0&filter_mail='.$this->mailing->mailid,true).'">'.$text.'</a>';
				}

				echo JText::sprintf('NB_CLICK_USERS',$text).' ( '.$this->mailingstats->clickunique.' / '.$cleanSent.' )';
			?>
			</li>
			<li>
			<?php
				$pourcent = ($this->mailingstats->openunique == 0?'0%':(substr($this->mailingstats->clickunique/$this->mailingstats->openunique*100,0,5)).'%');
				$text = '<span class="statnumber">'.$pourcent.'</span>';
				if(acymailing_isAllowed($this->config->get('acl_subscriber_view','all'))){
					$link = 'statsurl&task=detaillisting';
					if(!$app->isAdmin()) $link = 'frontnewsletter&task=statsclick&listid='.JRequest::getInt('listid').'&mailid='.$this->mailing->mailid;
					$text = '<a href="'.acymailing_completeLink($link.'&filter_url=0&filter_mail='.$this->mailing->mailid,true).'">'.$text.'</a>';
				}
				echo JText::sprintf('ACY_CLICK_EFFICIENCY_DESC',$text).' ( '.$this->mailingstats->clickunique.' / '.$this->mailingstats->openunique.' )';
			?>
			</li>
			<?php } ?>

			<li><?php $pourcent = ($cleanSent == 0) ? '0%' : (substr($this->mailingstats->unsub/$cleanSent*100,0,5)).'%';
			echo JText::sprintf('NB_UNSUB_USERS','<span class="statnumber">'.$pourcent.'</span>').' ( '.$this->mailingstats->unsub.' )'; ?></li>

			<?php if(acymailing_level(3)){?>
			<li>
			<?php
				$pourcent = (empty($this->mailingstats->senthtml) AND empty($this->mailingstats->senttext)) ? '0%' : (substr($this->mailingstats->bounceunique/($this->mailingstats->senthtml+$this->mailingstats->senttext)*100,0,5)).'%';
				$text = '<span class="statnumber">'.$pourcent.'</span>';
				if(acymailing_isAllowed($this->config->get('acl_subscriber_view','all'))){
					$link = 'stats&task=detaillisting';
					if(!$app->isAdmin()) $link = 'frontnewsletter&task=detailstats&listid='.JRequest::getInt('listid').'&mailid='.$this->mailing->mailid;
					$text = '<a href="'.acymailing_completeLink($link.'&filter_status=bounce&filter_mail='.$this->mailing->mailid,true).'">'.$text.'</a>';
				}
				echo JText::sprintf('NB_BOUNCED_USERS',$text).' ( '.$this->mailingstats->bounceunique.' )';
			?>
			</li>
			<?php } ?>
		</ul>
	</fieldset>
</td>
<td width="55%" valign="top">
<?php if(!empty($this->mailinglinks)){ ?>
	<fieldset class="adminform">
	<legend><?php echo JText::_('MOST_POPULAR_LINKS'); ?></legend>
	<ul>
	<?php foreach($this->mailinglinks as $oneLink){
		$urlName = $oneLink->name;
		if(strlen($urlName)>45) $urlName = substr($oneLink->name,0,20).'...'.substr($oneLink->name,-20);
		$text = '<span class="statnumber">'.$oneLink->uniqueclick.'</span>';
		if(acymailing_isAllowed($this->config->get('acl_subscriber_view','all'))){
			$link = 'statsurl&task=detaillisting';
			if(!$app->isAdmin()) $link = 'frontnewsletter&task=statsclick&listid='.JRequest::getInt('listid').'&mailid='.$this->mailing->mailid;
			$text = '<a href="'.acymailing_completeLink($link.'&filter_url='.$oneLink->urlid.'&filter_mail='.$this->mailing->mailid,true).'">'.$text.'</a>';
		}
		echo '<li>'.JText::sprintf('NB_USERS_CLICKED_ON',$text,'<a target="_blank" href="'.$oneLink->url.'">'.$urlName.'</a>').'</li>';
	}?>
	</ul>
	</fieldset>
<?php } ?>
</td>
</tr>
</table>

<div id="acy_selectChart">
	<table>
		<tr>
			<td><input type="radio" name="selectchart" checked="checked" onclick="displayChart('chartopenratetable');drawChartSendProcess();drawChartOpen();" id="selectChartOpenRate"/></td>
			<td onclick="document.getElementById('selectChartOpenRate').click();" class="selectChart"><?php echo JText::_('ACY_STAT_OPEN_RATE'); ?></td>

			<td><input type="radio" name="selectchart" onclick="displayChart('openclick');drawChartOpenclick();" id="selectChartOpenClick"/></td>
			<td onclick="document.getElementById('selectChartOpenClick').click();" class="selectChart"><?php echo JText::_('ACY_STAT_OPEN_CLICK'); ?></td>
		<?php if(!empty($this->openclickday)){ ?>
			<td><input type="radio" name="selectchart" onclick="displayChart('openclick');drawChartOpenclickperday();" id="selectChartOpenClickPerDay"/></td>
			<td onclick="document.getElementById('selectChartOpenClickPerDay').click();" class="selectChart"><?php echo JText::_('ACY_STAT_OPEN_CLICK_DAY'); ?></td>
		<?php } ?>
		<?php if(!empty($this->browserstats)){ ?>
			<td><input type="radio" name="selectchart" onclick="displayChart('openclick');drawChartBrowser();" id="selectChartBrowser"/></td>
			<td onclick="document.getElementById('selectChartBrowser').click();" class="selectChart"><?php echo JText::_('ACY_STAT_BROWSER'); ?></td>
		<?php } ?>
		<?php if(!empty($this->ismobilestats) || !empty($this->mobileosstats)){ ?>
			<td><input type="radio" name="selectchart" onclick="displayChart('chartopenratetable');drawChartIsMobile();drawChartMobileOS();" id="selectChartMobile"/></td>
			<td onclick="document.getElementById('selectChartMobile').click();" class="selectChart"><?php echo JText::_('ACY_STAT_MOBILE_USAGE'); ?></td>
		<?php } ?>
		</tr>
	</table>
</div>

<table width="100%" border="0" id="chartopenratetable">
	<tr>
		<td width="50%">
			<div id="sendprocess" class="acychart"></div>
		</td>
		<td width="50%">
			<div id="open" class="acychart"></div>
		</td>
	</tr>
</table>
<div style="display:none" id="openclick" class="acychart"></div>
</div>
