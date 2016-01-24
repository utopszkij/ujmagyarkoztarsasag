<?php /* Smarty version 2.6.27, created on 2016-01-03 18:06:55
         compiled from CRM/common/formButtons.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'crmScope', 'CRM/common/formButtons.tpl', 1, false),array('modifier', 'substring', 'CRM/common/formButtons.tpl', 32, false),array('modifier', 'crmReplace', 'CRM/common/formButtons.tpl', 34, false),array('modifier', 'crmBtnValidate', 'CRM/common/formButtons.tpl', 38, false),array('modifier', 'crmBtnType', 'CRM/common/formButtons.tpl', 39, false),array('modifier', 'crmAddClass', 'CRM/common/formButtons.tpl', 39, false),)), $this); ?>
<?php $this->_tag_stack[] = array('crmScope', array('extensionKey' => "")); $_block_repeat=true;smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>

<?php $_from = $this->_tpl_vars['form']['buttons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['btns'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['btns']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['button']):
        $this->_foreach['btns']['iteration']++;
?>
    <?php if (((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('substring', true, $_tmp, 0, 4) : smarty_modifier_substring($_tmp, 0, 4)) == '_qf_'): ?>
        <?php if ($this->_tpl_vars['location']): ?>
          <?php $this->assign('html', ((is_array($_tmp=$this->_tpl_vars['form']['buttons'][$this->_tpl_vars['key']]['html'])) ? $this->_run_mod_handler('crmReplace', true, $_tmp, 'id', ($this->_tpl_vars['key'])."-".($this->_tpl_vars['location'])) : smarty_modifier_crmReplace($_tmp, 'id', ($this->_tpl_vars['key'])."-".($this->_tpl_vars['location'])))); ?>
        <?php else: ?>
          <?php $this->assign('html', $this->_tpl_vars['form']['buttons'][$this->_tpl_vars['key']]['html']); ?>
        <?php endif; ?>
        <?php ob_start(); ?><?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('crmBtnValidate', true, $_tmp) : smarty_modifier_crmBtnValidate($_tmp)); ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('validate', ob_get_contents());ob_end_clean(); ?>
        <span class="crm-button crm-button-type-<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('crmBtnType', true, $_tmp) : smarty_modifier_crmBtnType($_tmp)); ?>
 crm-button<?php echo $this->_tpl_vars['key']; ?>
"<?php if ($this->_tpl_vars['buttonStyle']): ?> style="<?php echo $this->_tpl_vars['buttonStyle']; ?>
"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['html'])) ? $this->_run_mod_handler('crmAddClass', true, $_tmp, $this->_tpl_vars['validate']) : smarty_modifier_crmAddClass($_tmp, $this->_tpl_vars['validate'])); ?>
</span>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>