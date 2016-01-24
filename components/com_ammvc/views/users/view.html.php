<?php
/**
* @version        $Id: default_viewfrontend.php 118 2012-10-02 08:52:27Z michel $
* @package        Joomla site
* @subpackage amcomponent users    View
* @copyright    Copyright (C) 2013, Fogler Tibor. All rights reserved.
* @license #GNU/GPL
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class UsersViewUsers  extends JViewLegacy {
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
  public function display($tpl = null){
          parent::display($tpl);
    }
}
?>