<?php /* Smarty version 2.6.27, created on 2016-01-03 18:06:55
         compiled from CRM/common/stateCountry.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'crmScope', 'CRM/common/stateCountry.tpl', 1, false),array('function', 'crmURL', 'CRM/common/stateCountry.tpl', 44, false),)), $this); ?>
<?php $this->_tag_stack[] = array('crmScope', array('extensionKey' => "")); $_block_repeat=true;smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php if ($this->_tpl_vars['config']->stateCountryMap): ?>
<script language="javaScript" type="text/javascript">
<?php $_from = $this->_tpl_vars['config']->stateCountryMap; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['stateCountryMap']):
?>
  <?php if ($this->_tpl_vars['stateCountryMap']['country'] && $this->_tpl_vars['stateCountryMap']['state_province']): ?>
    <?php echo '
    cj(function() {
        countryID       = '; ?>
"<?php echo $this->_tpl_vars['stateCountryMap']['country']; ?>
"<?php echo '
        // sometimes we name != id, hence if element does not exists
        // fetch the id
        if ( cj( \'#\' + countryID ).length == 0 ) {
          countryID = cj( \'select[name="\' + countryID + \'"]\' ).prop(\'id\');
        }

        stateProvinceID = '; ?>
"<?php echo $this->_tpl_vars['stateCountryMap']['state_province']; ?>
"<?php echo '
        if ( cj( \'#\' + stateProvinceID ).length == 0 ) {
          stateProvinceID = cj( \'select[name="\' + stateProvinceID + \'"]\' ).prop(\'id\');
        }

        callbackURL     = '; ?>
"<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/ajax/jqState','h' => 0), $this);?>
"<?php echo '

        cj( \'#\' + countryID ).chainSelect(
          \'#\' + stateProvinceID,
          callbackURL,
          {
            before : function (target) {
              if (typeof(setdefault) === "undefined") { setdefault = new Array(); }
              targetid = cj(target).attr("id");
              eval(\'setdefault[targetid] = cj(target).val()\');
            },
            after : function(target) {
              targetid = cj(target).attr("id");
              cj(target).val(setdefault[targetid]);
            }
          }
        );
    });
    '; ?>

  <?php endif; ?>

  <?php if ($this->_tpl_vars['stateCountryMap']['state_province'] && $this->_tpl_vars['stateCountryMap']['county']): ?>
    <?php echo '
    cj(function() {
        stateProvinceID = '; ?>
"<?php echo $this->_tpl_vars['stateCountryMap']['state_province']; ?>
"<?php echo '
        if ( cj( \'#\' + stateProvinceID ).length == 0 ) {
          stateProvinceID = cj( \'select[name="\' + stateProvinceID + \'"]\' ).prop(\'id\');
        }

        countyID       = '; ?>
"<?php echo $this->_tpl_vars['stateCountryMap']['county']; ?>
"<?php echo '
        if ( cj( \'#\' + countyID ).length == 0 ) {
          countyID = cj( \'select[name="\' + countyID + \'"]\' ).prop(\'id\');
        }

        callbackURL     = '; ?>
"<?php echo CRM_Utils_System::crmURL(array('p' => 'civicrm/ajax/jqCounty','h' => 0), $this);?>
"<?php echo '

        cj( \'#\' + stateProvinceID ).chainSelect( \'#\' + countyID, callbackURL,
          {
            before : function (target) {
              if (typeof(setdefault) === "undefined") { setdefault = new Array(); }
              targetid = cj(target).attr("id");
              eval(\'setdefault[targetid] = cj(target).val()\');
            },
            after : function(target) {
              targetid = cj(target).attr("id");
              cj(target).val(setdefault[targetid]);
            }
          }
        );
    });
    '; ?>

  <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</script>
<?php endif; ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>