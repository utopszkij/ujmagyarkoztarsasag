<?php
/**
* @version		$Id: default_viewfrontend.php 118 2012-10-02 08:52:27Z michel $
* @package		Joomla site
* @subpackage amcomponent components	View
* @copyright	Copyright (C) 2013, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class ComponentsViewComponents  extends JViewLegacy {
  protected $viewName = '';
  public $Item = false;
  public $Items = false;
  public $model = false;
  public $Total = false;
  public $Pagination = false;
  public $filerStr = '';
  public $helper = false;

  public function setViewName($value) {
    $this->viewName = $value;
  }
  /**
   * echo one tab
   * @param string name
   * @param string $caption
   * @param boolean $active
   * @return void            
   */     
  protected function showtab($name,$caption,$active) {
    if ($active) {
      echo '<b>'.$caption.'</b>';
    } else {
      echo '<a onclick="tabClick('."'".$name."'".')">'.$caption.'</a>';
    }
  }
  /** echo tabs
   * @param string $actpage exampla: model|view.....
   * @param integer $type 0: first line: tmpl,  1 - second line tmpl
   */        
  protected function showTabs($actPage,$type) {
      if ($type==0) {
        echo '<p class="tabs">Tmpls&nbsp;
        ';
        $this->showtab('buttons','default-buttons',($actPage == 'buttons'));
        $this->showtab('filterform','default-filterform',($actPage == 'filterform'));
        $this->showtab('list','default-list',($actPage == 'list'));
        $this->showtab('form','form',($actPage == 'form'));
        $this->showtab('show','show',($actPage == 'show'));
        echo '&nbsp;&nbsp;&nbsp;('.JText::_('COMPONENTS_TAB_HELP').')</p>
        <p class="tabs">
        ';
        $this->showtab('','Head data',($actPage == ''));
        $this->showtab('model','Model',($actPage == 'model'));
        $this->showtab('view','View',($actPage == 'view'));
        $this->showtab('controller','controller',($actPage == 'controller'));
        $this->showtab('helper','Helper',($actPage == 'helper'));
        $this->showtab('table','Table',($actPage == 'table'));
        $this->showtab('formxml','Form XML',($actPage == 'formxml'));
        $this->showtab('css','CSS',($actPage == 'css'));
        $this->showtab('en','Lng EN',($actPage == 'en'));
        $this->showtab('hu','Lng HU',($actPage == 'hu'));
        echo '</p>
        ';
      } else {
        echo '<p class="tabs">
        ';
        $this->showtab('','Head data',($actPage == ''));
        $this->showtab('model','Model',($actPage == 'model'));
        $this->showtab('view','View',($actPage == 'view'));
        $this->showtab('controller','controller',($actPage == 'controller'));
        $this->showtab('helper','Helper',($actPage == 'helper'));
        $this->showtab('table','Table',($actPage == 'table'));
        $this->showtab('formxml','Form XML',($actPage == 'formxml'));
        $this->showtab('css','CSS',($actPage == 'css'));
        $this->showtab('en','Lng EN',($actPage == 'en'));
        $this->showtab('hu','Lng HU',($actPage == 'hu'));
        echo '</p>
        <p class="tabs">Tmpls&nbsp;
        ';
        $this->showtab('buttons','default-buttons',($actPage == 'buttons'));
        $this->showtab('filterform','default-filterform',($actPage == 'filterform'));
        $this->showtab('list','default-list',($actPage == 'list'));
        $this->showtab('form','form',($actPage == 'form'));
        $this->showtab('show','show',($actPage == 'show'));
        echo '&nbsp;&nbsp;&nbsp;('.JText::_('COMPONENTS_TAB_HELP').')</p>
        ';
      }
  }
  protected function showFooter() {
    echo '<p>'.$this->Item->fileName.'&nbsp;&nbsp;
    <b>Help</b>&nbsp;
    <a href="http://hu1.php.net/manual/en/" target="new">PHP</a>&nbsp
    <a href="http://dev.mysql.com/doc/refman/5.1/en/index.html" target="new">MYSQL</a>&nbsp
    <a href="http://doc.joomladev.eu/api25/" target="new">Joomla</a>&nbsp
    <a href="http://www.w3schools.com/tags/" target="new">HTML</a>&nbsp
    <a href="http://www.w3schools.com/jsref/" target="new">Javascript</a>&nbsp
    <a href="http://www.w3schools.com/cssref/" target="new">CSS</a>&nbsp
    </p>
    ';
  }
  public function display($tpl = null){
	  parent::display($tpl);
	}
}
?>