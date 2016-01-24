<?php
/**
 * @version 1.00
 * @package    joomla
 * @subpackage admin
 * @component  ammvc  
 * @author	   Fogler Tibor
 * @copyright  Copyright (C) 2013, Fogler Tibor. All rights reserved.
 * @license    GNU/GPL
 * 
 * Jform extension: addExtraOptimn for list fieldType  
 */
class amForm extends JForm {
  protected $extraOptions = array(); // [fieldname][label] = value:
  protected $extraValues = array(); //[fieldName] = value
  /**
   *  add extra Option into list field
   *  @result void
   *  @param string $fieldName
   *  @param string $value value of option
   *  @param string $label label of option            
   */     
  public function addExtraOption($fieldName,$value,$label) {
    if (!isset($this->extraOptions[$fieldName])) {
      $this->extraOptions[$fieldName] = array();
    }
    $this->extraOptions[$fieldName][$label]=$value;
  }
  /**
   * set value into forfield and $this->extraValues
   * note: JForm::setValue($fieldname, $value) check the forfield options list,
   *       and not save value if it is not valid. This function save value into
   *       $this->extraValues ohne check.      
   * @result void
   * @param string $fieldname
   * @param string $value            
   */     
  public function setValue($fieldName, $group=null, $value) {
    $this->extraValues[$fieldName] = $value;
    parent::setValue($fieldName, $group, $value);
  }
  /**
   *  result html input code (in "LIst" type use extraValues and extraOptions)
   *  @result string html code
   *  @param string $fieldName     
   */     
  public function getInput($fieldName) {
    $actValue = $this->extraValues[$fieldName];
    $result = parent::getInput($fieldName);
    //$result = str_replace(' value="'.$actValue.'">',' value="'.$actValue.'" selected="selected">',$result);
    if (substr($result,0,7) == '<select') {
      $options = '';
      foreach ($this->extraOptions[$fieldName] as $fn => $fv) {
        if ($fv == $actValue)
          $options .= '<option value="'.$fv.'" selected="selected">'.$fn.'</option>';
        else
          $options .= '<option value="'.$fv.'">'.$fn.'</option>';
      }
      $result = str_replace('</select>',$options.'</select>',$result);
    }
    return $result;
  }
}
?>