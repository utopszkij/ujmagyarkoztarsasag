<?php /* Smarty version 2.6.27, created on 2016-01-03 18:05:42
         compiled from CRM/Block/blocks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'crmScope', 'CRM/Block/blocks.tpl', 1, false),)), $this); ?>
<?php $this->_tag_stack[] = array('crmScope', array('extensionKey' => "")); $_block_repeat=true;smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_from = $this->_tpl_vars['blocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
<div class="block <?php echo $this->_tpl_vars['block']['name']; ?>
" id="<?php echo $this->_tpl_vars['block']['id']; ?>
">
   <h2 class="title"><?php echo $this->_tpl_vars['block']['subject']; ?>
</h2>
   <div class="content">
      <?php echo $this->_tpl_vars['block']['content']; ?>

   </div>
</div>
<?php endforeach; endif; unset($_from); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>