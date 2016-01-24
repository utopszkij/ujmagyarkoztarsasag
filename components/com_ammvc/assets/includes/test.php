<?php
/**
 * PHP kod ellenörzés
 * @author  Fogler Tibor
 * @author-email tibor.fogler@gmail.com
 * @licence  GNU/GPL
 * @copyright none
 * @use e:/www/proba.nms
 */      
include 'proba2.php';
require 'proba3.php';

/**
  * ismert változók , konstans, class, function nevek az ellenörzéshez
  * class esetében items a public proertyket és methodusokat tartalmazza
  * van egy LOCAL nevü elem ennek items-e az aktuálisan elemzett
  * funkciók, methodusok lokálisan deklarált elemeit, paramétereit tartalmazza  
*/                                                                   

function stmtDumper($fn,$stmt,$level) {
    $fv = '';
    $level1 = $level + 1;
    if (is_object($stmt)) {
      echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px">'.$fn.':{getType():'.$stmt->getType().'</p>';
      foreach ($stmt as $fn => $fv) {
        stmtDumper($fn,$fv,$level1);
        echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px">,</p>';
      }
      $attrs = $stmt->getAttributes();
      foreach ($attrs as $fn => $fv) {
        echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px"> -attr '.$fn.':'.$fv.'</p>';
      }
      echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px">}</p>';
    } else if (is_array($stmt)) {
      echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px">'.$fn.':[</p>';
      foreach ($stmt as $fn => $fv) {
        stmtDumper($fn,$fv,$level1);
        echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px">,</p>';
      }
      echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px">]</p>';
    } else {
      echo '<p style="margin:0px; padding:0px 0px 0px '.($level*20).'px">'.$fn.':'.$stmt.'</p>';
    }  
}


class nameSpaceClass {
     public $name; 
     public $dataType;        // scalar, array, class, function, constant, mixed, className
     public $items = array(); // key:name , item: nameSpaceClass
     public $extend;          // dtatType=="class" esetben ennek a clssnak a kiterjesztése
                              // dataType="function" esetben a paraméterek száma
                              // máskor üres
     public $help = '';       // functionoknál hivási szintaxis: 'type function name(pae1,par2,...)'                           
     function __construct($name,$dataType='scalar',$extend='') {
       $this->name = $name;
       $this->dataType = $dataType;
       $this->items = array();
       $this->extend = $extend;
       $this->help = '';
     }
     /**
      * nameSpace elem keresése név alapján
      * ha dataType=="className" akkor a class elemet adja vissza
      * ha dataType=='class' és extend adott akkor appendeli az extend tartalmával      
      * @return nameSpace
      * @param string $name
      */                              
     public function get($name) {
       $result = $this->items[$name];
       if ($result) {
         if (($result->dataType != 'scalar') &
             ($result->dataType != 'array') &
             ($result->dataType != 'class') &
             ($result->dataType != 'function') &
             ($result->dataType != 'constant') &
             ($result->dataType != 'mixed'))
             $result = $this->get($result->dataType);
       }
       if (($result->dataType == 'class') & ($result->extend != '')) {
         // merge $extend
         $e = $this->get($result->extend);
         $result->items = array_merge($e->items, $result->items);
       }
       return $result;
     }
     /** 
      *   new item into this nameSpace item
      * @return nameSpace
      * @param string $name
      * @param string $dataType
      * @param string $extend
      */                               
     public function add($name,$dataType='scalar',$extend='') {
        $this->items[$name] = new nameSpaceClass($name,$dataType,$extend);
        return $this->items[$name];
     }
     public function addScalar($name) {
        $this->items[$name] = new nameSpaceClass($name,'scalar','');
        return $this->items[$name];
     }
     public function addArray($name) {
        $this->items[$name] = new nameSpaceClass($name,'array','');
        return $this->items[$name];
     }
     public function addMixed($name) {
        $this->items[$name] = new nameSpaceClass($name,'mixed','');
        return $this->items[$name];
     }
     public function addClass($name,$extend='') {
        $this->items[$name] = new nameSpaceClass($name,'class',$extend);
        return $this->items[$name];
     }
     public function addFunction($name,$paramNumber=0) {
        $this->items[$name] = new nameSpaceClass($name,'function',$paramNumber);
        return $this->items[$name];
     }
     public function addConstant($name) {
        $this->items[$name] = new nameSpaceClass($name,'constant','');
        return $this->items[$name];
     }
     public function addObject($name,$className) {
        $this->items[$name] = new nameSpaceClass($name,$className,'');
        return $this->items[$name];
     }
     /**
      * funció deklarálás helstr -ből     
      * @param type function name($par1,$par2....) formájú help szöveg
      * @return nameSpace           
      */       
     public function addFunHelp($funHelp) {
        $w = explode('(',$funHelp);
        $w0 = explode(' ',$w[0]);
        $w1 = explode(',',$w[1]);
        $name = $w0[2];
        $this->items[$name] = new nameSpaceClass($name,'function',count($w1));
        $this->items[$name]->help = $funHelp;
        return $this->items[$name];
     }
     /**
      * adott elem és gyermek elemeinek kiirása fájlba
      * @return void
      * @param fileHanler $fp
      * @param string $owner
      */
      public function save($fp,$owner) {
        /*
        fwrite($fp,'$w = '.$owner.'->add("'.$this->name.'","'.$this->dataType.
                    '","'.$this->extend.'"');
        foreach ($this->stmts as $stmt)
          $this->save($fp,"$w");
        */  
      }
      /**
       * névtér bővitése .nms  fájlból
       * @return void
       * @param string $fileName
       */
       public function load($fileName) {
         /*
         if (file_exists($fileName) {
           inlude($fileName);
         }
         */
       }                            
} // nameSpaceClass                                        

class phpCheckerClass {   
  public $nameSpace;
  public $errorMsg = '';
  protected $actClass = '';
  protected $actMethod = '';
  function __construct() {
      $this->nameSpace = new nameSpaceClass('root','scalar','');
      $this->nameSpace->addScalar('LOCAL');
      // standart php definitions
      include 'phpstandart.php';
      include 'joomlastandart.php';
  }
  /**
    * stmt checker
    * olyan stmt -et tud ellenörizni amiben lehet name, var, dim:
    * ez az ellenörizendő elemek nagy része kivéve: 
    *   Expr_New, Expr_StaticCall, Expr_ConstFetch        
    * @return nevterItem}
    */         
  public function varChecker($stmt) {
       $result = false;
       if (isset($stmt->var)) {
         $result =  $this->varChecker($stmt->var);
         if ($result) {
           if (isset($stmt->name)) {
             if (is_object($stmt->name))
               $name = $stmt->name->parts[0];
             else 
               $name = $stmt->name;   
             // a $result szerint object?
             //if (($result->dataType != 'class') & ($result->dataType != 'mixed'))
             //     $result = false;
             if ($result) {
               if ($result->dataType == 'class') {
                 // a névtér szerint '$stmt->name' property létezik? 
                 $result = $result->get($name);
                 if ($result->dataType == 'method') $result = false;
                 if (!$result) {
                     $this->errorMsg .= $stmt->getType().' <b>'.$name.'</b> not valid in this object prefix (Line:'.$stmt->getAttribute('startLine').')<br />';
                 }
               }
             }
           }
         } else {
           $this->errorMsg .= $stmt->getType().' '.' not valid object prefix (Line:'.$stmt->getAttribute('startLine').')<br />';
         }
       } else if (isset($stmt->name)) {
          if (is_object($stmt->name))
            $name = $stmt->name->parts[0];
          else 
            $name = $stmt->name;
         // nézzük a LOCAL névtérben   
         $result = $this->nameSpace->items['LOCAL']->items[$name];
         // ha ott nincs meg nézzük a global névtérben
         if ($result == false) 
            $result = $this->nameSpace->get($name);
         if ($result == false) {
           $this->errorMsg .= $stmt->getType().' <b>'.$name.'</b> not found in nameSpace (Line:'.$stmt->getAttribute('startLine').')<br />';
         }
       }
       /*  A tömbök különböző elemei különböző tipusuak lehetnek
       if (isset($stmt->dim)) {
         if (($result->dataType != 'array') & ($result->dataType != 'mixed')) 
            $result = false;
         if (!$result) {
            $this->errorMsg .= $stmt->getType().' '.' this is not array (Line:'.$stmt->getAttribute('startLine').')<br />';
         }
       }
       */
       //DBG if (!$result)    
       //    stmtDumper('',$stmt,1);
       return $result;
  }
  /**
   * névtér bővítése function deklarációval
   * @return void
   * @param object stmt
   */            
  private function nameSpaceAddFun($nameSpace,$stmt) {
     $nameSpace->addFunction($stmt->name, count($stmt->params));
     $comment = null;
     // * @local tipus name commentsorok alapján a LOCAL  névtér büvitése 
     // * @param tipus name commentsorok alapján a LOCAL névtér büvitése
     $ns = $this->nameSpace->get('LOCAL');
     $comments = $stmt->getAttribute('comments');
     foreach ($comments as $comment) {
       $w = explode('@local',$comment);
       if (count($w) != 2)
          $w = explode('@param',$comment);
       if (count($w) == 2) {
         $w1 = explode(' ',$w[1]);
         $w1[1] = trim($w1[0]);
         $w1[2] = str_replace('$','',trim($w1[2]));
         if ($w1[1] == 'array')
           $ns->addArray($w1[2]);
         else if ($w1[1] == 'integer')
           $ns->addScalar($w1[2]);
         else if ($w1[1] == 'int')
           $ns->addScalar($w1[2]);
         else if ($w1[1] == 'float')
           $ns->addScalar($w1[2]);
         else if ($w1[1] == 'number')
           $ns->addScalar($w1[2]);
         else if ($w1[1] == 'date')
           $ns->addScalar($w1[2]);
         else if ($w1[1] == 'string')
           $ns->addScalar($w1[2]);
         else
           $ns->add($w1[2],$w1[1],'');
       }
     }
  }
  /**
   * nameSpace bővitése változó deklarációval
   * @return void
   * @param object stmt
   * @local string $comment
   */            
  private function nameSpaceAddVar($nameSpace,$stmt) {
     $name = $stmt->props[0]->name;
     $type = $stmt->props[0]->default;
     if ($type) $type = $type->getType();
     if ($type != 'Expr_Array') $type = '';
     if ($type == 'Expr_Array')
        $nameSpace->addArray($name);
     else
        $nameSpace->addScalar($name);
     // @objct Name comment alapján esetleg mosositom a tipus
     $comments = $stmt->getAttribute('comments');
     foreach ($comments as $comment) {
       if (strpos($comment,'@object') > 0) {
         $w = explode('@object',$comment);
         $nameSpace->items[$name]->dataType = trim($w[1]);
       }
     }
     //DBG echo '<p>nameSpace var '.$name.' '.$nameSpace->items[$name]->dataType.'</p>';
  }
  /**
   * stmt ellenörző
   * @return nameSpace vagy false és a $this->errorMsg
   * @param object $stmt   
   */                                      
  public function stmtChecker($stmt) {
    $result = true;
    $param = null;
    $var = null;
    if (is_object($stmt)) {
      $t = $stmt->getType();
      if ($t == 'Stmt_Global') {
        foreach ($stmt->vars as $var)
          $this->nameSpace->addMixed($var->name);
      }
      if ($t == 'Stmt_Function') {
        // LOCAL névtér üritése
        $this->nameSpace->items['LOCAL']->items = array();
        // root névtér bövitése
        $w = $this->nameSpace;
        $this->nameSpaceAddFun($w,$stmt);
        // LOCAL névtér bővitése a paraméterekkel
        foreach ($stmt->params as $param)
          $this->nameSpace->items['LOCAL']->addMixed($param->name);
      }
      if ($t == 'Stmt_Class') {
        // névtér bövitése
        $this->actClass = $stmt->name;
        $this->nameSpace->addClass($this->actClass);
        $this->nameSpace->addClass('this');
        // $tmt->stmts végig olvasása és a method definiciokkal
        // a this és a $this->actClass névtér bövitése
        foreach ($stmt->stmts as $stmt1) {
          if ($stmt1->getType() == 'Stmt_ClassMethod') {
            $this->nameSpace->items[$this->actClass]->addFunction($stmt1->name,0);
            $this->nameSpace->items['this']->addFunction($stmt1->name,0);
          }
        }
      }
      if ($t == 'Stmt_ClassMethod') {
        // LOCAL névtér üritése
        $this->nameSpace->items['LOCAL']->items = array();
        // actClass névtér bövitése
        $w = $this->nameSpace->get($this->actClass);
        if (($w) & ($stmt->type == 1)) {
          $this->nameSpaceAddFun($w,$stmt);
        }
        // $this névtér bövités
        $w = $this->nameSpace->get('this');
        if ($w) {
          $this->nameSpaceAddFun($w,$stmt);
        }
        // LOCAL névtér bővitése a paraméterekkel
        foreach ($stmt->params as $param)
          $this->nameSpace->items['LOCAL']->addMixed($param->name);
      }
      if ($t == 'Stmt_Property') {
        // $actClass névtér bövitése
        $w = $this->nameSpace->get($this->actClass);
        if (($w) & ($stmt->type == 1)) {
          $this->nameSpaceAddVar($w,$stmt);
        }
        // $this névtér bövitése
        $w = $this->nameSpace->get('this');
        if ($w)  {
          $this->nameSpaceAddVar($w,$stmt);
        }
      }
      if ($t == 'Expr_Assign') {
        // névtér bövitése
        $name = $stmt->var->name;
        $this->nameSpace->items['LOCAL']->addMixed($name);
        if ($this->varChecker($stmt) == false) $result = false; 
      } else if ($t == 'Expr_AssignRef') {
        // névtér bövitése
        $name = $stmt->var->name;
        $this->nameSpace->items['LOCAL']->addMixed($name);
        if ($this->varChecker($stmt) == false) $result = false; 
      } else if ($t == 'Expr_Variable') { 
        if ($this->varChecker($stmt) == false) $result = false;  
      } else if ($t == 'Expr_ArrayDimFetch') { 
        if ($this->varChecker($stmt) == false) $result = false;  
      } else if ($t == 'Expr_PropertyFetch') { 
        if ($this->varChecker($stmt) == false) $result = false;  
      } else if ($t == 'Expr_FuncCall') {
        $r = $this->varChecker($stmt); 
        if ($r) {
          if ($r->dataType == 'function') {
            /* nem jó
            if ($r->extend != count($stmt->args)) {
               $result = false;
               if ($r->help != '')
                  $this->errorMsg .= $stmt->getType().' not valid parameters number '.
                  ' (Line:'.$stmt->getAttribute('startLine').')'.
                  '<br />  /'.$r->help.'/<br />';
               else
                  $this->errorMsg .= $stmt->getType().' not valid parameters number '.
                  ' (Line:'.$stmt->getAttribute('startLine').')<br />';
            }
            */
          } else {
               $result = false;
               $this->errorMsg .= $stmt->getType().' <b>'.$r->name.'</b> not valid function name (Line:'.$stmt->getAttribute('startLine').')<br />';
          }  
        }
      } else if ($t == 'Expr_MethodCall') {
        $r = $this->varChecker($stmt); 
        if ($r == false) $result = false;
        if ($r) {
          /* valamiért nem jó (pld a default értékek miatt)
          if ($r->dataType == 'function') {
            if ($r->extend != count($stmt->args)) {
               $result = false;
               if ($r->help != '')
                  $this->errorMsg .= $stmt->getType().' not valid parameters number '.
                  ' (Line:'.$stmt->getAttribute('startLine').')'.
                  '<br />  /'.$r->help.'/<br />';
               else
                  $this->errorMsg .= $stmt->getType().' not valid parameters number '.
                  ' (Line:'.$stmt->getAttribute('startLine').')<br />';
            }
          }
          */  
        }
      } else if ($t == 'Expr_StaticCall') {
        $class = $stmt->class->parts[0];
        $name = $stmt->name;
        $result = $this->nameSpace->get($class);
        if ($result) {
           if ($result->dataType == 'class') {
              $result = $result->get($name);
              if ($result) {
                  if ($result->dataType == 'function') {
                    /* nem jó (default értékek miatt)
                    if ($result->extend != count($stmt->args)) {
                       if ($result->help != '')
                          $this->errorMsg .= $stmt->getType().' not valid parameters number '.
                          ' (Line:'.$stmt->getAttribute('startLine').')'.
                          '<br />  /'.$result->help.'/<br />';
                       else
                          $this->errorMsg .= $stmt->getType().' not valid parameters number by <b>'.$result->name.'</b>'.
                          ' (Line:'.$stmt->getAttribute('startLine').')<br />';
                       $result = false;
                    }
                    */
                  } else {
                    $result = false;
                    $this->errorMsg .= $stmt->getType().' <b>'.$name.'</b> not a method in this class (Line:'.$stmt->getAttribute('startLine').')<br />';
                  } 
              } else {
                  $result = false;
                  $this->errorMsg .= $stmt->getType().' <b>'.$name.'</b> not found in this class (Line:'.$stmt->getAttribute('startLine').')<br />';
              }
           } else {
             $result = false;
             $this->errorMsg .= $stmt->getType().' <b>'.$class.'</b> not a class in nameSpace (Line:'.$stmt->getAttribute('startLine').')<br />';
           } 
        } else {
           $result = false;
           $this->errorMsg .= $stmt->getType().' <b>'.$class.'</b> not found in nameSpace (Line:'.$stmt->getAttribute('startLine').')<br />';
        }
      } else if ($t == 'Expr_ConstFetch') {
        $name = $stmt->name->parts[0];
        $result = $this->nameSpace->get($name);
        if ($result) {
          if ($result->dataType != 'constant') {
            $result = false;
            $this->errorMsg .= $stmt->getType().' <b>'.$name.'</b> not a constant (Line:'.$stmt->getAttribute('startLine').')<br />';
          }
        } else {
           $result = false;
           $this->errorMsg .= $stmt->getType().' <b>'.$name.'</b> not valid constant name (Line:'.$stmt->getAttribute('startLine').')<br />';
        }
      } else if ($t == 'Expr_New') {
        $class = $stmt->class->parts[0];
        $result = $this->nameSpace->get($class);
        if ($result) {
           if ($result->dataType != 'class') {
             $result = false;
             $this->errorMsg .= $stmt->getType().' <b>'.$class.'</b> not a class in nameSpace (Line:'.$stmt->getAttribute('startLine').')<br />';
           } 
        } else {
           $result = false;
           $this->errorMsg .= $stmt->getType().' <b>'.$class.'</b> not found in nameSpace (Line:'.$stmt->getAttribute('startLine').')<br />';
        }
      }
      foreach ($stmt as $stmt1) {
         if ($this->stmtChecker($stmt1)==false) $result = false; 
      }
    } else if (is_array($stmt)) {
      foreach ($stmt as $stmt1) {
         if ($this->stmtChecker($stmt1)==false) $result = false; 
      }
    }
    return $result;
  }
  /** utasitás sorozat ellenörző
   * @return true vagy false és $this->errorMsg
   * @param array of stmt object   
   */      
  public function stmtsChecker($stmts) {
    $result = true;
    foreach ($stmts as $stmt) {
      //DBG stmtDumper('',$stmt,0);
      if ($this->stmtChecker($stmt) == false) $result = false;
    }
    return $result;
  }
} // phpChecker class  

?>