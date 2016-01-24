<?php /* Smarty version 2.6.27, created on 2016-01-03 18:05:56
         compiled from CRM/common/Navigation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'crmScope', 'CRM/common/Navigation.tpl', 1, false),array('block', 'ts', 'CRM/common/Navigation.tpl', 32, false),array('function', 'crmURL', 'CRM/common/Navigation.tpl', 30, false),array('function', 'crmKey', 'CRM/common/Navigation.tpl', 35, false),array('function', 'crmSetting', 'CRM/common/Navigation.tpl', 73, false),)), $this); ?>
<?php $this->_tag_stack[] = array('crmScope', array('extensionKey' => "")); $_block_repeat=true;smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><div id="menu-container" style="display:none;">
    <ul id="civicrm-menu">
      <?php if (call_user_func ( array ( 'CRM_Core_Permission' , 'giveMeAllACLs' ) )): ?>
        <li id="crm-qsearch" class="menumain crm-link-home">
            <form action="<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/search/advanced','h' => 0), $this);?>
" name="search_block" id="id_search_block" method="post">
              <div id="quickSearch">
                <input type="text" class="form-text" id="sort_name_navigation" placeholder="<?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Find Contacts<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>" name="sort_name" style="width: 12em;" />
                <input type="text" id="sort_contact_id" style="display: none" />
                <input type="hidden" name="hidden_location" value="1" />
                <input type="hidden" name="qfKey" value="<?php echo smarty_function_crmKey(array('name' => 'CRM_Contact_Controller_Search','addSequence' => 1), $this);?>
" />
                <div style="height:1px; overflow:hidden;"><input type="submit" value="<?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Go<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>" name="_qf_Advanced_refresh" class="form-submit default" /></div>
              </div>
            </form>
          <ul>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" checked="checked" value="" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Name/Email<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="contact_id" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>CiviCRM ID<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="external_identifier" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>External ID<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="first_name" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>First Name<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="last_name" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Last Name<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="eml" value="email" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Email<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="phe" value="phone_numeric" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Phone<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="sts" value="street_address" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Street Address<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="sts" value="city" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>City<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="sts" value="postal_code" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Postal Code<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
            <li><label class="crm-quickSearchField"><input type="radio" data-tablename="cc" value="job_title" name="quickSearchField"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Job Title<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></label></li>
          </ul>
        </li>
      <?php endif; ?>
      <?php echo $this->_tpl_vars['navigation']; ?>

    </ul>
</div>

<?php echo '
<script type="text/javascript">
cj(function( ) {
  cj("#civicrm-menu >li").each(function(i){
    cj(this).attr("tabIndex",i+2);
  });

  var contactUrl = '; ?>
"<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/ajax/rest','q' => 'className=CRM_Contact_Page_AJAX&fnName=getContactList&json=1&context=navigation','h' => 0), $this);?>
"<?php echo ';

  cj( \'#sort_name_navigation\' ).autocomplete( contactUrl, {
      width: 200,
      selectFirst: false,
      minChars: 1,
      matchContains: true,
      delay: 400,
      max: '; ?>
<?php echo smarty_function_crmSetting(array('name' => 'search_autocomplete_count','group' => 'Search Preferences'), $this);?>
<?php echo ',
      extraParams:{
        fieldName:function () {
          return  cj(\'input[name=quickSearchField]:checked\').val();
        },
        tableName:function () {
           return  cj(\'input[name=quickSearchField]:checked\').attr("data-tablename");
        }
      }
  }).result(function(event, data, formatted) {
     document.location = CRM.url(\'civicrm/contact/view\', {reset: 1, cid: data[1]});
     return false;
  });
  cj(\'#sort_name_navigation\').keydown(function() {
    cj.Menu.closeAll();
  });
  cj(\'.crm-quickSearchField\').click(function() {
    var label = cj(this).text();
    var value = cj(\'input\', this).val();
    // These fields are not supported by advanced search
    if (value === \'first_name\' || value === \'last_name\') {
      value = \'sort_name\';
    }
    cj(\'#sort_name_navigation\').attr({name: value, placeholder: label}).flushCache().focus();
  });
  // check if there is only one contact and redirect to view page
  cj(\'#id_search_block\').on(\'submit\', function() {
    var contactId, sortValue = cj(\'#sort_name_navigation\').val();
    if (sortValue && cj(\'#sort_name_navigation\').attr(\'name\') == \'sort_name\') {
      '; ?>
<?php echo '
      var dataUrl = '; ?>
"<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/ajax/contact','h' => 0,'q' => 'name='), $this);?>
"<?php echo ' + sortValue;
      contactId = cj.ajax({
        url: dataUrl,
        async: false
      }).responseText;
    }
    if (contactId && !isNaN(parseInt(contactId))) {
      var url = '; ?>
"<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/contact/view','h' => 0,'q' => 'reset=1&cid='), $this);?>
"<?php echo ' + contactId;
      this.action = url;
    }
  });
});

'; ?>
<?php if ($this->_tpl_vars['config']->userFramework != 'Joomla' && $this->_tpl_vars['config']->userFrameworkFrontend != 1): ?><?php echo '
  cj(\'body\').prepend( cj("#menu-container").html() );

  //Track Scrolling
  cj(window).scroll( function () {
     var scroll = document.documentElement.scrollTop || document.body.scrollTop;
     cj(\'#civicrm-menu\').css({top: "scroll", position: "fixed", top: "0px"});
     cj(\'div.sticky-header\').css({ \'top\' : "23px", position: "fixed" });
  });

  if ( cj(\'#edit-shortcuts\').length > 0 ) {
     cj(\'#civicrm-menu\').css({ \'width\': \'97%\' });
  }
'; ?>
<?php elseif ($this->_tpl_vars['config']->userFrameworkFrontend != 1): ?><?php echo '
  // below div is present in older version of joomla 2.5.x
  var elementExists = cj(\'div#toolbar-box div.m\').length;
  if ( elementExists > 0 ) {
    cj(\'div#toolbar-box div.m\').html(cj("#menu-container").html());
  }
  else {
    cj("#menu-container").show().css({\'padding-bottom\': \'10px\'});
  }

  cj(\'#civicrm-menu\').ready(function() {
    cj(\'#root-menu-div .outerbox\').css({ \'margin-top\': \'6px\'});
    cj(\'#root-menu-div .outerbox\').first().css({ \'margin-top\': \'20px\'});
    cj(\'#root-menu-div .menu-ul li\').css({ \'padding-bottom\' : \'2px\', \'margin-top\' : \'2px\' });
    cj(\'img.menu-item-arrow\').css({ \'top\' : \'4px\' });
  });
  '; ?>
<?php endif; ?><?php echo '
  cj(\'#civicrm-menu\').menu( {arrowSrc: CRM.config.resourceBase + \'packages/jquery/css/images/arrow.png\'} );
</script>
'; ?>

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>