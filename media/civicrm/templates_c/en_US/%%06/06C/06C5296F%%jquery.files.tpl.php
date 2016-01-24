<?php /* Smarty version 2.6.27, created on 2016-01-03 18:05:41
         compiled from CRM/common/jquery.files.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'crmScope', 'CRM/common/jquery.files.tpl', 1, false),)), $this); ?>
<?php $this->_tag_stack[] = array('crmScope', array('extensionKey' => "")); $_block_repeat=true;smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>packages/jquery/jquery-1.8.3.min.js
packages/jquery/jquery-ui-1.9.0/js/jquery-ui-1.9.0.custom.min.js
packages/jquery/jquery-ui-1.9.0/css/smoothness/jquery-ui-1.9.0.custom.min.css

packages/jquery/plugins/jquery.autocomplete.js
packages/jquery/css/jquery.autocomplete.css

packages/jquery/plugins/jquery.menu.pack.js
packages/jquery/css/menu.css

packages/jquery/plugins/jquery.chainedSelects.js

packages/jquery/plugins/jquery.tableHeader.js

packages/jquery/plugins/jquery.textarearesizer.js

packages/jquery/plugins/jquery.form.js

packages/jquery/plugins/jquery.tokeninput.js
packages/jquery/css/token-input-facebook.css

packages/jquery/plugins/jquery.timeentry.pack.js
packages/jquery/plugins/jquery.mousewheel.pack.js

packages/jquery/plugins/DataTables/media/css/demo_table_jui.css
packages/jquery/plugins/DataTables/media/js/jquery.dataTables.min.js

packages/jquery/plugins/jquery.FormNavigate.js

packages/jquery/plugins/jquery.validate.min.js
packages/jquery/plugins/jquery.ui.datepicker.validation.pack.js

packages/jquery/plugins/jquery.jeditable.mini.js

packages/jquery/plugins/jquery.blockUI.js

packages/jquery/plugins/jquery.notify.min.js

packages/jquery/plugins/jquery.redirect.min.js

js/rest.js
js/Common.js

js/jquery/jquery.crmeditable.js
js/jquery/jquery.crmasmselect.js

<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>