<?php 
  header('Content-Type: application/json');
  
  $arr1 = Array("title"=>"CAS", "status"=>"success", "url"=>"http://cas.byu.edu");
  $arr2 = Array("title"=>"Person", "status"=>"fail", "url"=>"http://person.byu.edu");
  $arr3 = Array("title"=>"AIM", "status"=>"success", "url"=>"http://aim.byu.edu");
  
  $arr = Array($arr1, $arr2, $arr3);
  echo json_encode($arr);
  
?>