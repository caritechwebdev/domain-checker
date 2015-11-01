<?php


function get1Data($tableName,$fieldName,$criteria,$keyword){
  $sql = "SELECT ".$fieldName." FROM ".$tableName." WHERE ".$criteria."='".$keyword."'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  return $row[0];
};

function getOptions($tableName, $fieldID, $fieldName, $criteria, $keyword){
  $sql = "SELECT ".$fieldID.",".$fieldName." FROM ".$tableName." WHERE ".$criteria."=".$keyword;
  $result = mysql_query($sql);

  $arr = array();

  while($row = mysql_fetch_array($result)){
    $arr[$row[$fieldID]] = $row[$fieldName];
  }

  return $arr;
}


function setMessage($msg, $url, $duration=1, $type=''){

  if($type==''){
    $color='green';
  }else{
    $color='red';
  }

  return '<html><head><meta http-equiv="refresh" content="'.$duration.';url='.$url.'"><body ><center><div style="margin-top:100px;width:200px;padding:10px;border: 1 dashed #c0c0c0"><img src="../images/loader.gif" border="0"><br><br><span style="font-face:verdana;font-size:14px;color:'.$color.'">'.$msg.'</span></div></center></body></head></html>';

}


function displayStatus($status){
  if($status == 1){
    return '<span style="color:blue">Active</span>';
  }else{
    return '<span style="color:red">Disabled</span>';
  }
}

function displayUsage($use){
  if($use == 1){
    return '<span style="color:#04B404;">Internal</span>';
  }else{
    return '<span>External</span>';
  }
}


function getNextAutoNumber($table){
  $query = 'SELECT AUTO_INCREMENT AS nextId FROM information_schema.TABLES WHERE TABLE_SCHEMA = "caritech_tk2" AND TABLE_NAME = "'.$table.'"';
  $result = mysql_query($query);
  $d = mysql_fetch_array($result);

  if($d){
    return $d['nextId'];
  }
}


function getRelationship($uid){
  $query = 'SELECT relationship FROM tblUser WHERE uid='.$uid;
  $result = mysql_query($query);
  $d = mysql_fetch_array($result);

  if($d){
    return $d['relationship'];
  }
}


function getUserUplineByUserId($uid){
  $relationship = getRelationship($uid);

  if(strpos($relationship, "_") !== FALSE){
    //$uplineRelationship = implode("_", array_pop(explode("_", $relationship)));
    $arr = explode("_", $relationship);
    $key = abs(count($arr) - 2);
    $uplineId = $arr[$key];
  }else{
    $uplineId = $uid;
  }

  $query = "SELECT uid,fullName FROM tblUser WHERE uid='$uplineId'";
  $result = mysql_query($query);
  $d = mysql_fetch_array($result);

  return $d;
  
}


?>
