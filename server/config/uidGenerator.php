<?php

class UIDGenerator
{

  private $now;

  function __construct()
  {
    $this->now = time();
  }

  function getUID($num, $filter){
    if(!isset($filter)){
      $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    } else {
      if($filter == "numbers"){
        $permitted_chars = '0123456789';
      }
      elseif($filter == "alphabets"){
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      }
      else {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      }
    }
    if(strlen($num) > 10){
      $num = $num - strlen($this->now);
      $firstTwoChars = substr($this->now, 0, 2);
      $leftChars = substr($this->now, 2);
      $createdcode = substr(str_shuffle($permitted_chars), 0, $num);
      $divided = round($num/2);
      $halfDividedChars = substr($createdcode, 0, $divided);
      $leftDividedChars = substr($createdcode, $divided);
      $uid = $firstTwoChars . $halfDividedChars . $leftChars . $leftDividedChars;
    }
    else {
      $uid = substr(str_shuffle($permitted_chars), 0, $num);
    }
    return $uid;
  }

  function splitUID($uid, $groupNum){
    $splitUID = implode("-", str_split($uid, $groupNum));
    return $splitUID;
  }
}

?>
