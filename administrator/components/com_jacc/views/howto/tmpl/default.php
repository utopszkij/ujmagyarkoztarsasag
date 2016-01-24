<?php

// no direct access
defined('_JEXEC') or die('Restricted access');



$style = "
div.yacc table { 
	border-collapse: collapse;
	}
div.yacc table, div.yacc  td, div.yacc  th {
    border: 1px solid #BBBBBB;
    padding: 4px;
}
.yacc dl.tabs {
	float: left;
	margin: 10px 0 -1px 0;
	
	z-index: 50;
}

.yacc dl.tabs dt {
	float: left;
	padding: 4px 10px;
	border: 1px solid #ccc;
	margin-left: 3px;
	background: #e9e9e9;
	color: #666;
}

.yacc dl.tabs dt.open {
	background: #F9F9F9;
	border-bottom: 1px solid #f9f9f9;
	z-index: 100;
	color: #000;
}

.yacc div.current {
	clear: both;
	border: 1px solid #ccc;
	padding: 10px 10px;
}

.yacc div.current dd {
	padding: 0;
	margin: 0;
}
.yacc dl.tabs h3{
	font-size:1.0em;
}
.yacc  dl#content-pane.tabs {
	margin: 1px 0 0 0;
}
";
$document = JFactory::getDocument();
$document->addStyleDeclaration($style);

?>
<div  style="font-size:1.1em" class="nav-tabs yacc col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-50  <?php endif;?>span8  fltlft">

<?php echo JHtml::_('tabs.start','howto-1');?> 
<?php echo JHtml::_('tabs.panel', 'Intro','howto-1-intro'); ?>

<h2>Jacc is...</h2>
<p><strong>J</strong>ust <strong>a</strong>nother <strong>c</strong>omponent <strong>c</strong>reator</p>
<h2>Approach</h2>
<p>Before the first line of code is written, a data model must be developed. Normally this model will later be represented in the database.</p> 
<p>For instance I use MySQL Workbench for developing the data model. The tool is able to export tables directly into a database.</p>
<p><strong>Jacc</strong> uses these tables, and expects that each table (as far as there exists a primary key) represents a triple of a Model View Control.</p>
<p>
	So before you use <strong>Jacc</strong>, be sure that there are tables in the Joomla database, which corresponds to your data model.
	For a little test you can try the <a class='modal' href="<?php echo JRoute::_('index.php?option=com_jacc&view=sql&tmpl=component') ?>"  rel="{handler: 'iframe', size: {x: 650, y: 475}}">sql script for an example bookshop</a>.
</p>
<h2>Quick Start</h2>
	<ol>
		<li>Import your tables into the Joomla database</li>
		<li>Go to <strong>Jacc-&gt;Components</strong> and edit the <strong>Preferences</strong>.</li>
		<li>Click <strong>New</strong>. The Jacc Component Editor will be displayed.</li>
		<li>Enter title and version, select your tables and click <strong>Save</strong>. Your Component appears now in the components list</li>
		<li>Copy the link in the column <strong>Download</strong>, paste it in the URL-Installation Field of the <strong>Joomla Installation Manager</strong> and install the component.</li>
	</ol>
<p>
	If you have respected the suggested naming rules for the table columns,  you will have a working but rudimental backend administration and frontend for your component. You can start now developement. 	
</p>		
<p>
	<i><strong>Warning: </strong> If you want to repeat the procedure, use <strong>Jacc</strong> to recreate the component before reinstalling or backup tables structure before deinstallation of the component.</i>
</p>
<?php echo JHtml::_('tabs.panel', 'Guidelines','howto-1-guidlines'); ?>		

<h2>Guidelines and Recommendations </h2>

<h3>Table Naming</h3>
<p>Use the underscore to indicate the relation between your tables. M.e. if you are developing a component for a bookshop:</p>
<p><strong>jos_book</strong> (for the mainview/the books), <strong>jos_book_author</strong>,  <strong>jos_book_publisher</strong> etc..</p>
<h3>Table Fields</h3>
<strong>Jacc</strong> recognizes some fields which are standard for Joomla tables:
<ul>
	<li><strong>title</strong> (varchar) <br /> or<br /><strong>name</strong> (varchar)</li>
	<li><strong>alias</strong> (varchar)</li>
	<li><strong>description</strong> (text)</li>
	<li><strong>catid</strong> Category (int)<br /> or<br /><strong>category_id</strong> (int)</li>	
</ul> 
<p>
	If you use this standards, <strong>Jacc</strong> roughly will create the right elements for the backend forms and lists.	   
</p>
<p>A full list of special field names and the results is found on the tab <strong>Optimize your tables</strong></p>
<p>
	Recommandation: Call your primary keys <strong>id</strong>
</p>
<h3>Foreign Keys</h3>
<p><strong>Jacc</strong> will recognize foreign keys in your tables, if you respect the naming </p>
<h5>Example:</h5>
<p>
	Tables: <i>jos_example, jos_example_some, jos_example_foo</i>
</p>
<p>	
	Foreign Keys: <i>some_id, foo_id, example_id</i>
</p> 
<p>So, if you use some_id in jos_example, this will create a select in the backend for the "Example" Detail View</p>
<h3>Forms</h3>
<p>One of the improvements of Joomla 1.6 is the <strong>forms</strong> library.  <strong>Jacc</strong> provides the forms for Joomla 1.5 too. </p>
<p>
	The forms are defined by an xml-file in models/forms. Have a look to joomla/form/fields in your component directory to get an 
	idea of available field types. For more information visit <a href="http://docs.joomla.org/Developers">docs.joomla.org/Developers</a>
</p>
<h2>Categories</h2>
<p>If you set the option <strong><?php echo JText::_('PARAMS_CATEGORIES_LABEL')?></strong> you will add Joomla 1.6 style, nested categories to your component.</p>
<h2>Restrictions</h2>
<ul>
<li>A frontend view will just print out the contents of the table fields. You can imagine, that there is no way for <strong>Jacc</strong> to guess right the purpose of your component.</li>
<li>There will be no SQL-joins in the frontend models for categories or foreign keys. Do it by yourself.</li>
<li><strong>Jacc</strong> won't work, if you use a table prefix ends not with underscore</li>
</ul>
<?php echo JHtml::_('tabs.panel', 'Developing','howto-1-developing'); ?>

<p>For developing with Jacc the following approach is suggested:</p>


	<ol>
	<li>Install <strong>Jacc</strong> on a Joomla that you use for development of components.</li>
		<li>Create a data model and implement as MySQL tables.</li>

		<li>Then import the tables into the Joomla on which you installed <strong>Jacc</strong>.</li>
		<li>Create the component and install it on the same Joomla.</li>
		<li>Define <strong>Maximum</strong> for Joomlas error reporting  and then test, whether storing of items works in the backend.</li>
		<li>If this is not the case, check the naming of your table fields (common errors are a forgotten autoincrement or a lack of a primary id).</li>

		<li>Once your table structure is satisfying, you can generate and install the component again (a previous uninstallation is not necessary)</li>
		<li>In the Jacc Component Editor activate "live component" to create installation packages from the installed component. (Note that files already existing in the component are not overwritten, changes to the tables themselves will therefore have no effect.).</li>
	</ol>


	<p>Now you can develope the component "on site" and use <strong>Jacc</strong> to create installation archives.</p>
<?php echo JHtml::_('tabs.panel', 'Optimize your Tables','howto-1-tables'); ?>
	
<p>You can take full advantage of the capabilities of YACC, if you follow some rules in the respect of the naming of your tables fields:</p>


	<table class="yacctable">
		<tr>

			<td><strong>Field name</strong></td>
			<td>     <strong>Alternatives</strong>     </td>
			<td><strong>Field Type</strong>     </td>
			<td><strong>Comment</strong></td>
		</tr>

		<tr>
			<td><strong><em>id</em></strong> </td>
			<td>every primary key    </td>
			<td>    hidden field     </td>
			<td>This field must be primary and autoincrement. Every other name for primary key will be accepted too, but "id" is recommanded for better compliance.</td>
		</tr>

		<tr>
			<td><strong><em>title</em></strong> </td>
			<td>    name, sku </td>
			<td>    text field </td>
			<td>In 99% there is something like a name or a title for an item, as a human identifier. If you don't use this naming for it, it's recommanded to put a varchar field after the primary field (id)</td>

		</tr>
		<tr>
			<td><strong><em>alias</em></strong> </td>
			<td>    None </td>
			<td>    text field </td>
			<td>    This field is needed to produce SEF-Urls for items</td>

		</tr>
		<tr>
			<td><strong><em>params</em></strong> </td>
			<td>    None </td>
			<td>    None </td>
			<td>    Will enable you to use params. Its easyly implemented by adding fields in the form xml to the params field group.</td>

		</tr>
		<tr>
			<td><strong><em>ordering</em></strong> </td>
			<td>    None </td>
			<td>    System </td>
			<td>    If you use this, there will be shown an ordering column in the backend list view and it will be used for default sorting in frontend.</td>

		</tr>
		<tr>
			<td><strong><em>published</em></strong> </td>
			<td>    state </td>
			<td>    State select </td>
			<td>    The use of this name is highly recommanded.</td>

		</tr>
		<tr>
			<td><strong><em>access</em></strong> </td>
			<td>    None </td>
			<td>    Access level select </td>
		</tr>

		<tr>
			<td><strong><em>category_id</em></strong> </td>
			<td>    catid     </td>
			<td>Category select </td>
			<td>    You have to activate "Use Categories" to make this working</td>

		</tr>
		<tr>
			<td><strong><em>parent_id</em></strong> </td>
			<td>    parentid </td>
			<td>    Select </td>
			<td>    Build a tree. You can connect an item to a parent from backend, but you have to implement it in the frontend by yourself.</td>

		</tr>
		<tr>
			<td><strong><em>description</em></strong> </td>
			<td>    text </td>
			<td>    editor </td>
			<td> Every field of the type text will result in an editor field too. The recommanded naming will make the editor appear at the usual place in the backend form.</td>

		</tr>
		<tr>
			<td><strong><em>language</em></strong> </td>
			<td>    None </td>
			<td>    Language select </td>
			<td> </td>

		</tr>
		<tr>
			<td><strong><em>created</em></strong> </td>
			<td>    created_time </td>
			<td>    Calendar </td>
			<td>     If this field is not filled, now time will be autosaved.</td>

		</tr>
		<tr>
			<td><strong><em>created_by</em></strong> </td>
			<td>    None </td>
			<td>    Printed text </td>
			<td>     The name of the author</td>

		</tr>
		<tr>
			<td><strong><em>created_by_alias</em></strong> </td>
			<td>     None </td>
			<td>    Printed text </td>
			<td>    TODO: Make it a text field</td>

		</tr>
		<tr>
			<td><strong><em>modified</em></strong> </td>
			<td>    None </td>
			<td>    Printed text. </td>
			<td>    Will be autosaved.</td>

		</tr>
		<tr>
			<td><strong><em>modified_by</em></strong> </td>
			<td>    None </td>
			<td>    Printed text. </td>
			<td>    Will be autosaved.</td>

		</tr>
		<tr>
			<td><strong><em>checked_out</em></strong> </td>
			<td>    checked_out_time </td>
			<td>    System </td>
			<td> Will be autosaved.</td>

		</tr>
		<tr>
			<td><strong><em>checked_out_by</em></strong> </td>
			<td>    None </td>
			<td>    System </td>
			<td>    Will be autosaved.</td>

		</tr>
		<tr>
			<td><strong><em>publish_up</em></strong> </td>
			<td>    None </td>
			<td>    Calendar </td>
			<td>    Not implemented yet in frontend</td>

		</tr>
		<tr>
			<td><strong><em>publish_down</em></strong> </td>
			<td>    None </td>
			<td>    Calendar </td>
			<td>    Not implemented yet in frontend</td>

		</tr>
		<tr>
			<td><strong><em>image</em></strong> </td>
			<td>    None </td>
			<td>    Imageup </td>
			<td>    Provides image upload and autocreation of thumbnails</td>

		</tr>		
	</table>
<?php echo JHtml::_('tabs.panel', 'Compatibility','howto-1-compat'); ?>

<h2>Backward Compatibility</h2>
<p>The goal is, to create components, that will run native with joomla 1.5 too. So you can find some libraries in the administration tree, which are picked from Joomla 1.6. </p>
<p>You can delete this part, if your component is developed for Joomla 1.6 only. You can also remove the compatibility switches starting with: <pre>$jv = new JVersion();</pre></p>

<p>Example component is tested with Joomla 1.5, 1.6, 1.7, 2.5.</p>
<h2>Jacc Developement</h2>
<p>If you want to make <strong>Jacc</strong> matching more your style of programming, you can customize carefully the files in <strong>com_jacc/templates</strong>. </p>
<p>Templates in the folder <strong>mvcbase</strong> are common classes, which doesn't need a lot of changes, those in the folder <strong>mvctriple</strong> will be specialized for your component and your data model. 
	   There are a lot of placeholders, but you will understand  what they do.

<?php echo JHtml::_('tabs.panel', 'Subversion','howto-1-subversion'); ?>

<p>The following procedure is applied by the author successfully:</p>


	<h3 id="Prerequisite">Prerequisite:</h3>


	<p>The development system (Joomla) is under version control.</p>


	<h3 id="Procedure">Procedure:</h3>


	<ol>
	<li>Create and install the component.</li>
		<li>Unzip the installation package into a folder and put it via svn import into the trunk tree of the repository.</li>
		<li>From the Joomla delete frontend and backend of the component .</li>

		<li>In the directory administrator/components register trunk/admin as external: <br>  <pre>svn propset svn:externals com_mycomponent http://svn.mydomain.tld/repository/trunk/admin components</pre></li>
		<li>In the directory components register trunk/site as external</li>
	</ol>


	<p>Each commit will now update the components repository</p>

<?php echo JHtml::_('tabs.end');?>
</div>
<div class="col <?php if(version_compare(JVERSION,'3.0','lt')): ?>width-40  <?php endif;?>span2 fltrt">
<fieldset class="adminform">
	<legend>About</legend>
	<strong>Author:</strong> Michael Liebler<br />
	<strong>Home:</strong> <a href="http://www.janguo.de">www.janguo.de</a><br />
	<strong>License:</strong> <a href="http://www.gnu.org/licenses/gpl-2.0.html">http://www.gnu.org/licenses/gpl-2.0.html</a>  GNU/GPL<br />		
	<strong>Forum/Feature Request</strong>: <a href="http://redmine.janguo.de/projects/jacc/">redmine.janguo.de/projects/jacc/</a> (registration required)	
</fieldset>
<fieldset class="adminform">
	<legend>Support other users</legend>
	<p>Support other users by sharing your experiences with <strong>Jacc</strong> on <a href="http://extensions.joomla.org/extensions/miscellaneous/development/13644">extensions.joomla.org</a>.
</fieldset>
<fieldset class="adminform">
	<legend>Make a Donation</legend>
					<table>
	<tr>	
		<td align="center">
			If <strong>Jacc</strong> was usefull for you, please make a little donation, to bring the developement forward. Thank you.</td>
	</tr>
	<tr>
		<td align="center">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			<input type="hidden" name="cmd" value="_donations">

			<input type="hidden" name="business" value="michael-liebler@janguo.de">
			<input type="hidden" name="item_name" value="">
			<input type="hidden" name="amount" value="">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="currency_code" value="EUR">
			<input type="hidden" name="tax" value="0">
			<input type="hidden" name="lc" value="DE">
			<input type="hidden" name="bn" value="PP-DonationsBF">
			<input type="image" src="http://wzcreativetechnology.com/paypal/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">

			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>	
		</td>
	</tr>
</table>
</fieldset>

</div>
<form method="post" action="index.php?option=com_jacc" id="adminForm" name="adminForm">
		<input type="hidden" name="option" value="com_jacc" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="jacc" />	
		<?php echo JHTML::_( 'form.token' ); ?>
</form>
<div class="clr"></div>
<div style="text-align:center;font-weight:bold;padding:10px;clear:both">Jacc Version <?php print JaccHelper::getVersion() ?></div> 
