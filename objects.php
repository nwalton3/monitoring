<?php 
  header('Content-Type: application/json');


  // Get the query string  
  $q = '';
  if(isset( $_GET['s'] )) {
    $q = $_GET['s'];
  }
  $q = strtolower($q);

  
  // The array to pass back
  $arr = Array();


  // The full info  
  $arr1 = Array("title"=>"CAS", "status"=>"success", "url"=>"http://cas.byu.edu");
  $arr2 = Array("title"=>"Person", "status"=>"fail", "url"=>"http://person.byu.edu");
  $arr3 = Array("title"=>"AIM", "status"=>"success", "url"=>"http://aim.byu.edu");
  $arr4 = Array("title"=>"GRO", "status"=>"success", "url"=>"http://gro.byu.edu");
  $arr5 = Array("title"=>"Scout", "status"=>"success", "url"=>"http://scout.byu.edu");

  $all = Array($arr1, $arr2, $arr3, $arr4, $arr5);


  // Just the titles  
  $title1 = Array("title"=>"CAS");
  $title2 = Array("title"=>"Person");
  $title3 = Array("title"=>"AIM");
  $title4 = Array("title"=>"GRO");
  $title5 = Array("title"=>"Scout");
  
  $titles = Array($title1, $title2, $title3, $title4, $title5);

    
  // Get the requested data
  switch($q) {
    
    case 'titles':
      $arr = $titles;
      break;
      
    case 'cas':
      $arr = $arr1;
      break;

    case 'person':
      $arr = $arr2;
      break;

    case 'aim':
      $arr = $arr3;
      break;

    case 'gro':
      $arr = $arr4;
      break;

    case 'scout':
      $arr = $arr5;
      break;
    
    case 'all':
    default:
      $arr = $all;
      break;
  }  
  
  
  // Send back the JSON
  echo json_encode($arr);
  
?>