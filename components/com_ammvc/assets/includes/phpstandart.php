<?php
      // include a phpchecker.php -ba
      // gyakran használt standart php funkciók és globális változók, konstansok
      $w = $this->nameSpace->addClass('stdClass','');
      $w = $this->nameSpace->addFunHelp('void function define("name",$scalarValue)');
      $w = $this->nameSpace->addFunHelp('void function undefine("name")');
      $w = $this->nameSpace->addFunHelp('bool function defined("name")');
      $w = $this->nameSpace->addFunHelp('bool function isset($varName)');
      $w = $this->nameSpace->addFunHelp('bool function is_array($varName)');
      $w = $this->nameSpace->addFunHelp('bool function is_object($varName)');
      $w = $this->nameSpace->addFunHelp('void function session_start()');
      $w = $this->nameSpace->addFunHelp('void function exit()');
      $w = $this->nameSpace->addFunHelp('void function ini_set($name,$value)');
      $w = $this->nameSpace->addFunHelp('void function header($value)');
      $w = $this->nameSpace->addFunHelp('void function error_reporting($errorLevel)');
      $w = $this->nameSpace->addFunHelp('void function set_magic_quotes_runtime($value)');
      $w = $this->nameSpace->addFunHelp('str function date($mask,$numDate)');
      // str functions
      $w = $this->nameSpace->addFunHelp('str function str_replace($pattern,$changem$source)');
      $w = $this->nameSpace->addFunHelp('str function substr($source,$from,$length)');
      $w = $this->nameSpace->addFunHelp('int|false function strpos($source,$pattern)',2);
      $w = $this->nameSpace->addFunHelp('int|false function stripos($source,$pattern)',2);
      $w = $this->nameSpace->addFunHelp('str function strtoupper($str)');
      $w = $this->nameSpace->addFunHelp('str function strtolower($str)');
      $w = $this->nameSpace->addFunHelp('str functiob addslashes($str)');
      $w = $this->nameSpace->addFunHelp('str function stripslashes($str)');
      $w = $this->nameSpace->addFunHelp('str function md5($str)');
      $w = $this->nameSpace->addFunHelp('str function number_format($number,$decimals,$dec_point,$thousands_sep)');
      $w = $this->nameSpace->addFunHelp('str function rtrim($str)');
      $w = $this->nameSpace->addFunHelp('str function ltrim($str)');
      $w = $this->nameSpace->addFunHelp('str function trim($str)');
      $w = $this->nameSpace->addFunHelp('str function ucfirst($str)');
      $w = $this->nameSpace->addFunHelp('str function implode($terminator,$array)');
      $w = $this->nameSpace->addFunHelp('str function strip_tags($str)');
      $w = $this->nameSpace->addFunHelp('str function urlencode($str)');
      $w = $this->nameSpace->addFunHelp('str function urldecode($str)');
      $w = $this->nameSpace->addFunHelp('int function strlen($str)');
      // array functions
      $w = $this->nameSpace->addFunHelp('array function explode($terminator,$source)');
      $w = $this->nameSpace->addFunHelp('array function array_merge($array1,$array2)');
      $w = $this->nameSpace->addFunHelp('array function array_splice($inputArray,$offset,$length,$replacement)');
      $w = $this->nameSpace->addFunHelp('array function array_push($inputArray,$array2)');
      $w = $this->nameSpace->addFunHelp('int function count($array)');
      // file és directory functions
      $w = $this->nameSpace->addFunHelp('fileHandler function fopen($fileName,$rw)');
      $w = $this->nameSpace->addFunHelp('void function fclose($fileHandler)');
      $w = $this->nameSpace->addFunHelp('void function fwrite($fileHandler,$str)');
      $w = $this->nameSpace->addFunHelp('array function file($fileName|url)');
      $w = $this->nameSpace->addFunHelp('bool function file_exists($fileName)');
      $w = $this->nameSpace->addFunHelp('bool function unlink($fileName)');
      $w = $this->nameSpace->addFunHelp('bool function is_dir($dirName)');
      $w = $this->nameSpace->addFunHelp('bool function is_file($filename)');
      $w = $this->nameSpace->addFunHelp('bool function mkdir($dirName,$mode)');
      $w = $this->nameSpace->addFunHelp('bool function rmdir($dirName)');
      $w = $this->nameSpace->addFunHelp('dirHandler function opendir($dirName)');
      $w = $this->nameSpace->addFunHelp('str function readdir($dirHandler)');
      $w = $this->nameSpace->addFunHelp('void function closedir($dirHanler)');
      $w = $this->nameSpace->addFunHelp('str function filetype($fullFileName)');
      $w = $this->nameSpace->addFunHelp('str function dirname($fullFileName)');
      $w = $this->nameSpace->addFunHelp('int function filemtime($fullFileName)');
      $w = $this->nameSpace->addFunHelp('int function filesize($fullFileName)');
      // json
      $w = $this->nameSpace->addFunHelp('str function JSON_encode($object)');
      $w = $this->nameSpace->addFunHelp('object function JSON_decode($jsonStr)');      
      
      // globális változók
      $w = $this->nameSpace->addArray('_SERVER');
      $w = $this->nameSpace->addArray('_GET');
      $w = $this->nameSpace->addArray('_POST');
      $w = $this->nameSpace->addArray('_SESSION');
      
      // globális konstansok
      $w = $this->nameSpace->addConstant('__FILE__');
      $w = $this->nameSpace->addConstant('__IS__');
      $w = $this->nameSpace->addConstant('true');
      $w = $this->nameSpace->addConstant('false');
      $w = $this->nameSpace->addConstant('null');
      
?>