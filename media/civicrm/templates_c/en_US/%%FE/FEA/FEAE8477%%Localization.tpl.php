<?php /* Smarty version 2.6.27, created on 2016-01-03 18:08:13
         compiled from CRM%5CAdmin%5CForm%5CSetting%5CLocalization.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'crmScope', 'CRM\\Admin\\Form\\Setting\\Localization.tpl', 1, false),array('block', 'ts', 'CRM\\Admin\\Form\\Setting\\Localization.tpl', 28, false),)), $this); ?>
<?php $this->_tag_stack[] = array('crmScope', array('extensionKey' => "")); $_block_repeat=true;smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><div class="crm-block crm-form-block crm-localization-form-block">
<div class="crm-submit-buttons"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/formButtons.tpl", 'smarty_include_vars' => array('location' => 'top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
    <h3><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Language and Currency<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h3>
        <table class="form-layout-compressed">
            <tr class="crm-localization-form-block-lcMessages">
                <td class="label"><?php echo $this->_tpl_vars['form']['lcMessages']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['lcMessages']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Default language used for this installation.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
           <?php if ($this->_tpl_vars['form']['languageLimit']): ?>
             <tr class="crm-localization-form-block-languageLimit">
                 <td class="label"><?php echo $this->_tpl_vars['form']['languageLimit']['label']; ?>
</td>
                 <td><?php echo $this->_tpl_vars['form']['languageLimit']['html']; ?>
<br />
                 <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Languages available to users of this installation.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
             </tr>
             <tr class="crm-localization-form-block-addLanguage">
                 <td class="label"><?php echo $this->_tpl_vars['form']['addLanguage']['label']; ?>
</td>
                 <td><?php echo $this->_tpl_vars['form']['addLanguage']['html']; ?>
<br />
                 <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Add a new language to this installation.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
             </tr>
          <?php endif; ?>
            <tr class="crm-localization-form-block-inheritLocale">
                <td class="label"><?php echo $this->_tpl_vars['form']['inheritLocale']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['inheritLocale']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>If checked, CiviCRM will follow CMS language changes.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-defaultCurrency">
                <td class="label"><?php echo $this->_tpl_vars['form']['defaultCurrency']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['defaultCurrency']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Default currency assigned to contributions and other monetary transactions.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-monetaryThousandSeparator">
                <td class="label"><?php echo $this->_tpl_vars['form']['monetaryThousandSeparator']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['monetaryThousandSeparator']['html']; ?>
</td>
            </tr>
            <tr class="crm-localization-form-block-monetaryDecimalPoint">
                <td class="label"><?php echo $this->_tpl_vars['form']['monetaryDecimalPoint']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['monetaryDecimalPoint']['html']; ?>
</td>
            </tr>
            <tr class="crm-localization-form-block-currencyLimit">
                <td class="label"><?php echo $this->_tpl_vars['form']['currencyLimit']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['currencyLimit']['html']; ?>
</td>
            </tr>
            <tr class="crm-localization-form-block-moneyformat">
                <td class="label"><?php echo $this->_tpl_vars['form']['moneyformat']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['moneyformat']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Format for displaying monetary amounts.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-moneyvalueformat">
                <td class="label"><?php echo $this->_tpl_vars['form']['moneyvalueformat']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['moneyvalueformat']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Format for displaying monetary values.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-customTranslateFunction">
                <td class="label"><?php echo $this->_tpl_vars['form']['customTranslateFunction']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['customTranslateFunction']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Function name to use for translation inplace of the default CiviCRM translate function. <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-legacyEncoding">
                <td class="label"><?php echo $this->_tpl_vars['form']['legacyEncoding']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['legacyEncoding']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>If import files are NOT encoded as UTF-8, specify an alternate character encoding for these files. The default of <strong>Windows-1252</strong> will work for Excel-created .CSV files on many computers.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-fieldSeparator">
                <td class="label"><?php echo $this->_tpl_vars['form']['fieldSeparator']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['fieldSeparator']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Global CSV separator character. Modify this setting to enable import and export of different kinds of CSV files (for example: ',' ';' ':' '|' ).<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
        </table>
    <h3><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Contact Address Fields - Selection Values<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h3>
        <table class="form-layout-compressed">
            <tr class="crm-localization-form-block-defaultContactCountry">
                <td class="label"><?php echo $this->_tpl_vars['form']['defaultContactCountry']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['defaultContactCountry']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>This value is selected by default when adding a new contact address.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
           <tr class="crm-localization-form-block-defaultContactStateProvince">
                <td class="label"><?php echo $this->_tpl_vars['form']['defaultContactStateProvince']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['defaultContactStateProvince']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>This value is selected by default when adding a new contact address.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-countryLimit">
                <td class="label"><?php echo $this->_tpl_vars['form']['countryLimit']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['countryLimit']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Which countries are available in the Country selection field when adding or editing contact addresses. Profile and Custom 'Country' fields also use this setting. To include ALL countries, leave the right-hand box empty.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
            <tr class="crm-localization-form-block-provinceLimit">
                <td class="label"><?php echo $this->_tpl_vars['form']['provinceLimit']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['provinceLimit']['html']; ?>
<br />
                <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>State/province listings are populated dynamically based on the selected Country for all standard contact address editing forms, as well as for <strong>Profile forms which include both a Country and a State/Province field</strong>.  This setting controls which countries' states and/or provinces are available in the State / Province selection field <strong>for Custom Fields</strong> or for Profile forms which do NOT include a Country field.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
            </tr>
        </table>
    <h3><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Multiple Languages Support<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></h3>
      <table class="form-layout-compressed">
        <?php if ($this->_tpl_vars['form']['languageLimit']): ?>
          <tr class="crm-localization-form-block-makeSinglelingual_description">
              <td></td>
              <td><span class="description"><?php $this->_tag_stack[] = array('ts', array('1' => "http://documentation.civicrm.org")); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>This is a multilingual installation. It contains certain schema differences compared to regular installations of CiviCRM. Please <a href="%1">refer to the documentation</a> for details.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span></td>
          </tr>
          <tr class="crm-localization-form-block-makeSinglelingual">
              <td class="label"><?php echo $this->_tpl_vars['form']['makeSinglelingual']['label']; ?>
</td>
              <td><?php echo $this->_tpl_vars['form']['makeSinglelingual']['html']; ?>
<br />
              <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Check this box and click 'Save' to switch this installation from multi- to single-language.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span><br /><br />
              <span class="description" style="color:red"><?php echo $this->_tpl_vars['warning']; ?>
</span></td>
          </tr>
        <?php elseif ($this->_tpl_vars['form']['makeMultilingual']): ?>
          <tr class="crm-localization-form-block-makeMultilingual">
              <td class="label"><?php echo $this->_tpl_vars['form']['makeMultilingual']['label']; ?>
</td>
              <td><?php echo $this->_tpl_vars['form']['makeMultilingual']['html']; ?>
<br />
              <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>Check this box and click 'Save' to switch this installation from single- to multi-language, then add further languages.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span><br /><br />
              <span class="description" style="color:red"><?php echo $this->_tpl_vars['warning']; ?>
</span></td>
        <?php else: ?>
          <tr class="crm-localization-form-block-description">
              <td>
              <span class="description"><?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>In order to use this functionality, the installation's database user must have privileges to create triggers (in MySQL 5.0 – and in MySQL 5.1 if binary logging is enabled – this means the SUPER privilege). This install either does not seem to have the required privilege enabled.<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?> <?php $this->_tag_stack[] = array('ts', array()); $_block_repeat=true;smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>(Multilingual support currenly cannot be enabled on installations with enabled logging.)<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_ts($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?></span><br /><br />
              <span class="description" style="color:red"><?php echo $this->_tpl_vars['warning']; ?>
</span></td>
          </tr>
        <?php endif; ?>
      </table>
    <div class="crm-submit-buttons">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "CRM/common/formButtons.tpl", 'smarty_include_vars' => array('location' => 'bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
<div class="spacer"></div>
</div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_crmScope($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>