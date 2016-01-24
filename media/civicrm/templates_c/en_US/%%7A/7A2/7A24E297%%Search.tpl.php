<?php /* Smarty version 2.6.27, created on 2016-01-03 18:16:39
         compiled from CRM/Group/Form/Search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'crmScope', 'CRM/Group/Form/Search.tpl', 1, false),array('block', 'ts', 'CRM/Group/Form/Search.tpl', 28, false),array('function', 'crmURL', 'CRM/Group/Form/Search.tpl', 122, false),)), $this); ?>
<?php $this->_tag_stack[] = array('crmScope', array('extensionKey' => "")); $_block_repeat=true;smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><div class="crm-block crm-form-block crm-group-search-form-block">

<h3><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Find Groups<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h3>
<table class="form-layout">
  <tr>
    <td>
      <?php echo $this->_tpl_vars['form']['title']['label']; ?>
<br />
      <?php echo $this->_tpl_vars['form']['title']['html']; ?>
<br />
      <span class="description font-italic">
          <?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Complete OR partial group name.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </span>
    </td>
    <td>
      <?php echo $this->_tpl_vars['form']['created_by']['label']; ?>
<br />
      <?php echo $this->_tpl_vars['form']['created_by']['html']; ?>
<br />
      <span class="description font-italic">
          <?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Complete OR partial creator name.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </span>
    </td>
    <td id="group_type-block">
      <?php echo $this->_tpl_vars['form']['group_type']['label']; ?>
<br />
      <?php echo $this->_tpl_vars['form']['group_type']['html']; ?>
<br />
      <span class="description font-italic">
          <?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Filter search by group type(s).<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </span>
    </td>
    <td>
      <?php echo $this->_tpl_vars['form']['visibility']['label']; ?>
<br />
      <?php echo $this->_tpl_vars['form']['visibility']['html']; ?>
<br />
      <span class="description font-italic">
          <?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Filter search by visibility.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </span>
    </td>
    <td>
      <?php echo $this->_tpl_vars['form']['group_status']['label']; ?>
<br />
      <?php echo $this->_tpl_vars['form']['group_status']['html']; ?>

    </td>
  </tr>
  <tr>
     <td><?php echo $this->_tpl_vars['form']['buttons']['html']; ?>
</td><td colspan="2">
  </tr>
</table>
</div>
<br/>
<table id="crm-group-selector">
  <thead>
    <tr>
      <th class='crm-group-name'><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Name<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
      <th class='crm-group-group_id'><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>ID<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
      <th class='crm-group-created_by'><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Created By<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
      <th class='crm-group-description'><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Description<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
      <th class='crm-group-group_type'><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Group Type<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
      <th class='crm-group-visibility'><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Visibility<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
      <?php if ($this->_tpl_vars['showOrgInfo']): ?>
      <th class='crm-group-org_info'><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Organization<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></th>
      <?php endif; ?>
      <th class='crm-group-group_links nosort'>&nbsp;</th>
      <th class='hiddenElement'>&nbsp;</th>
    </tr>
  </thead>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/enableDisable.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript">
cj( function() {
  // for CRM-11310 and CRM-10635 : processing just parent groups on initial display
  // passing \'1\' for parentsOnlyArg to show parent child heirarchy structure display
  // on initial load of manage group page and
  // also to handle search filtering for initial load of same page.
  buildGroupSelector(true, 1);
  cj(\'#_qf_Search_refresh\').click( function() {
    buildGroupSelector( true );
  });
});

function buildGroupSelector( filterSearch, parentsOnlyArg ) {
    if ( filterSearch ) {
        if (typeof crmGroupSelector !== \'undefined\') {
          crmGroupSelector.fnDestroy();
        }
        var parentsOnly = 0;
        var ZeroRecordText = \'<div class="status messages">'; ?>
<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>No matching Groups found for your search criteria. Suggestions:<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?><?php echo '<div class="spacer"></div><ul><li>'; ?>
<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Check your spelling.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?><?php echo '</li><li>'; ?>
<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Try a different spelling or use fewer letters.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?><?php echo '</li><li>'; ?>
<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Make sure you have enough privileges in the access control system.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?><?php echo '</li></ul></div>\';
    } else {
        var parentsOnly = 1;
        var ZeroRecordText = '; ?>
'<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><div class="status messages">No Groups have been created for this site.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></div>'<?php echo ';
    }

    // this argument should only be used on initial display i.e onPageLoad
    if (typeof parentsOnlyArg !== \'undefined\') {
      parentsOnly = parentsOnlyArg;
    }

    var columns = \'\';
    var sourceUrl = '; ?>
'<?php echo CRM_Utils_System::crmURL(array('p' => "civicrm/ajax/grouplist",'h' => 0,'q' => "snippet=4"), $this);?>
'<?php echo ';
    var showOrgInfo = '; ?>
"<?php echo $this->_tpl_vars['showOrgInfo']; ?>
"<?php echo ';

    crmGroupSelector = cj(\'#crm-group-selector\').dataTable({
        "bFilter"    : false,
        "bAutoWidth" : false,
        "aaSorting"  : [],
        "aoColumns"  : [
                        {sClass:\'crm-group-name\'},
                        {sClass:\'crm-group-group_id\'},
                        {sClass:\'crm-group-created_by\'},
                        {sClass:\'crm-group-description\', bSortable:false},
                        {sClass:\'crm-group-group_type\'},
                        {sClass:\'crm-group-visibility\'},
                        {sClass:\'crm-group-group_links\', bSortable:false},
                        '; ?>
<?php if ($this->_tpl_vars['showOrgInfo']): ?><?php echo '
                        {sClass:\'crm-group-org_info\', bSortable:false},
                        '; ?>
<?php endif; ?><?php echo '
                        {sClass:\'hiddenElement\', bSortable:false}
                       ],
        "bProcessing": true,
        "asStripClasses" : [ "odd-row", "even-row" ],
        "sPaginationType": "full_numbers",
        "sDom"       : \'<"crm-datatable-pager-top"lfp>rt<"crm-datatable-pager-bottom"ip>\',
        "bServerSide": true,
        "bJQueryUI": true,
        "sAjaxSource": sourceUrl,
        "iDisplayLength": 25,
        "oLanguage": { "sZeroRecords":  ZeroRecordText,
                       "sProcessing":    '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Processing...<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                       "sLengthMenu":    '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Show _MENU_ entries<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                       "sInfo":          '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Showing _START_ to _END_ of _TOTAL_ entries<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                       "sInfoEmpty":     '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Showing 0 to 0 of 0 entries<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                       "sInfoFiltered":  '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>(filtered from _MAX_ total entries)<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                       "sSearch":        '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Search:<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                       "oPaginate": {
                            "sFirst":    '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>First<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                            "sPrevious": '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Previous<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                            "sNext":     '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Next<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ',
                            "sLast":     '; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Last<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo '
                        }
                    },
        "fnDrawCallback": function() { setSelectorClass( parentsOnly, showOrgInfo ); },
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            aoData.push( {name:\'showOrgInfo\', value: showOrgInfo },
                         {name:\'parentsOnly\', value: parentsOnly }
                       );
            if ( filterSearch ) {
                var groupTypes = \'\';
                cj(\'#group_type-block input\').each(function(index) {
                if (cj(this).prop(\'checked\')) {
                  if (groupTypes) {
                    groupTypes = groupTypes + \',\' + cj(this).attr(\'id\').substr(11);
                  }
                  else {
                    groupTypes = cj(this).attr(\'id\').substr(11);
                  }
                }
                });

                var groupStatus = \'\';
                if ( cj(\'.crm-group-search-form-block #group_status_1\').prop(\'checked\') ) {
                    groupStatus = \'1\';
                }

                if ( cj(\'.crm-group-search-form-block #group_status_2\').prop(\'checked\') ) {
                    if ( groupStatus ) {
                        groupStatus = \'3\';
                    } else {
                        groupStatus = \'2\';
                    }
                }

                aoData.push(
                    {name:\'title\', value: cj(\'.crm-group-search-form-block #title\').val()},
                    {name:\'created_by\', value: cj(\'.crm-group-search-form-block #created_by\').val()},
                    {name:\'group_type\', value: groupTypes },
                    {name:\'visibility\', value: cj(\'.crm-group-search-form-block #visibility\').val()},
                    {name:\'status\', value: groupStatus }
                );
            }
            cj.ajax( {
                "dataType": \'json\',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            } );
        }
    });
}

function setSelectorClass( parentsOnly, showOrgInfo ) {
  cj(\'#crm-group-selector tr\').each( function( ) {
    var className = cj(this).find(\'td:last-child\').text();
    cj(this).addClass( className );
    var rowID = cj(this).find(\'td:nth-child(2)\').text();
    cj(this).prop( \'id\', \'row_\' + rowID );
    if (parentsOnly) {
      if ( cj(this).hasClass(\'crm-group-parent\') ) {
        cj(this).find(\'td:first\').prepend(\''; ?>
<span class="collapsed show-children" title="<?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>show child groups<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"/></span><?php echo '\');
      }
    }
  });
}

// show hide children
cj(\'#crm-group-selector\').on( \'click\', \'span.show-children\', function(){
  var showOrgInfo = '; ?>
"<?php echo $this->_tpl_vars['showOrgInfo']; ?>
"<?php echo ';
  var rowID = cj(this).parents(\'tr\').prop(\'id\');
  var parentRow = rowID.split(\'_\');
  var parent_id = parentRow[1];
  var group_id = \'\';
  if ( parentRow[2]) {
    group_id = parentRow[2];
  }
  var levelClass = \'level_2\';
  // check enclosing td if already at level 2
  if ( cj(this).parent().hasClass(\'level_2\') ) {
    levelClass = \'level_3\';
  }
  if ( cj(this).hasClass(\'collapsed\') ) {
    cj(this).removeClass("collapsed").addClass("expanded").attr("title",'; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>hide child groups<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ');
    showChildren( parent_id, showOrgInfo, group_id, levelClass );
  }
  else {
    cj(this).removeClass("expanded").addClass("collapsed").attr("title",'; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>show child groups<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ');
    cj(\'.parent_is_\' + parent_id).find(\'.show-children\').removeClass("expanded").addClass("collapsed").attr("title",'; ?>
"<?php $this->_tag_stack[] = array('ts', array('escape' => 'js')); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>show child groups<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"<?php echo ');
    cj(\'.parent_is_\' + parent_id).hide();
    cj(\'.parent_is_\' + parent_id).each(function(i, obj) {
      // also hide children of children
      var gID = cj(this).find(\'td:nth-child(2)\').text();
      cj(\'.parent_is_\' + gID).hide();
    });
  }
});

function showChildren( parent_id, showOrgInfo, group_id, levelClass) {
  var rowID = \'#row_\' + parent_id;
  if ( group_id ) {
    rowID = \'#row_\' + parent_id + \'_\' + group_id;
  }
  if ( cj(rowID).next().hasClass(\'parent_is_\' + parent_id ) ) {
    // child rows for this parent have already been retrieved so just show them
    cj(\'.parent_is_\' + parent_id ).show();
  } else {
    var sourceUrl = '; ?>
'<?php echo CRM_Utils_System::crmURL(array('p' => "civicrm/ajax/grouplist",'h' => 0,'q' => "snippet=4"), $this);?>
'<?php echo ';
    cj.ajax( {
        "dataType": \'json\',
        "url": sourceUrl,
        "data": {\'parent_id\': parent_id, \'showOrgInfo\': showOrgInfo},
        "success": function(response){
          var appendHTML = \'\';
          cj.each( response, function( i, val ) {
            appendHTML += \'<tr id="row_\'+ val.group_id +\'_\'+parent_id+\'" class="parent_is_\' + parent_id + \' crm-row-child \' + val.class + \'">\';
            if ( val.is_parent ) {
              appendHTML += \'<td class="crm-group-name \' + levelClass + \'">\' + \''; ?>
<span class="collapsed show-children" title="<?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>show child groups<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>"/></span><?php echo '\' + val.group_name + \'</td>\';
            }
            else {
              appendHTML += \'<td class="crm-group-name \' + levelClass + \'"><span class="crm-no-children"></span>\' + val.group_name + \'</td>\';
            }
            appendHTML += "<td>" + val.group_id + "</td>";
            appendHTML += "<td>" + val.created_by + "</td>";
            if (val.group_description) {
              appendHTML += "<td>" + val.group_description + "</td>";
            } else {
              appendHTML += "<td>&nbsp;</td>";
            }
            appendHTML += "<td>" + val.group_type + "</td>";
            appendHTML += "<td>" + val.visibility + "</td>";
						if (showOrgInfo) {
							appendHTML += "<td>" + val.org_info + "</td>";
						}
            appendHTML += "<td>" + val.links + "</td>";
            appendHTML += "</tr>";
          });
          cj( rowID ).after( appendHTML );
        }
    } );
  }
}

</script>
'; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>