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
  $arr1 = Array("title"=>"CAS",    "status"=>1, "requestUrl"=>"cas.byu.edu");
  $arr2 = Array("title"=>"Person", "status"=>0, "requestUrl"=>"person.byu.edu");
  $arr3 = Array("title"=>"AIM",    "status"=>1, "requestUrl"=>"aim.byu.edu");
  $arr4 = Array("title"=>"GRO",    "status"=>1, "requestUrl"=>"gro.byu.edu");
  $arr5 = Array("title"=>"Scout",  "status"=>1, "requestUrl"=>"scout.byu.edu");
  $arr6 = Array("title"=>"Server", "status"=>1, "requestUrl"=>"learningsuite.byu.edu");

  $all = Array($arr1, $arr2, $arr3, $arr4, $arr5, $arr6);

    
  // Get the requested data
  switch($q) {
    
    case 'titles':
      $arr = getTitles();
      break;
      
    case 'cas':
      $arr = checkCAS();
      break;

    case 'person':
      $arr = checkPersonService();
      break;

    case 'aim':
      $arr = checkAIM();
      break;

    case 'gro':
      $arr = checkGRO();
      break;

    case 'scout':
      $arr = checkScout();
      break;
    
    case 'all':
    default:
      $arr = checkAllServices();
      break;
  }  
  
 
 
/**
* Gives a list of services
*
* @return A json encoded array
*/
 
function getTitles() {
  // Just the titles  
  $title1 = Array("title"=>"CAS");
  $title2 = Array("title"=>"Person");
  $title3 = Array("title"=>"AIM");
  $title4 = Array("title"=>"GRO");
  $title5 = Array("title"=>"Scout");
  $title6 = Array("title"=>"Server");
  
  $titles = Array($title1, $title2, $title3, $title4, $title5, $title6);

  return $titles;
}


/**
* Will check all services and 
*
* @return A json encoded array
*/
function checkAllServices(){
  $retArr = Array();

  //TODO: Remove 'magic' strings
  $retArr[] = checkServer();
  $retArr[] = checkCAS();
  $retArr[] = checkPersonService();
  $retArr[] = checkGRO();

  return $retArr;
}

/**
* Will check too see if the service that hosts the website works
*
* @return A json encoded array
*/
function checkServer(){

  $retArr = Array();
  $retArr["title"] = "Server";
  $retArr["status"] = 1;
  $retArr["requestUrl"] = "my.byu.edu";

  return $retArr;
}

/**
* Will check to see if the CAS system is up an running
*
* @return A json encoded array
*/
function checkCAS(){
  //TODO: Make into a defined
  $CASurl = "https://cas.byu.edu/cas/login?service=https://my.byu.edu/uPortal/Login";
  if($CASurl == NULL) return false;

  //Connect to website with curl
  $curly = curl_init($CASurl);

  //Some settings for curl
  curl_setopt($curly, CURLOPT_TIMEOUT, 5);
  curl_setopt($curly, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($curly, CURLOPT_RETURNTRANSFER, true);// What does this exactly do

  $data = curl_exec($curly);
  $httpcode = curl_getinfo($curly,CURLINFO_HTTP_CODE);

  //Close curl
  curl_close($curly);

  //Return object
  $retArr = Array();
  $retArr["title"] = "CAS";
  $retArr["requestUrl"] = "cas.byu.edu";

  if($httpcode >= 200 && $httpcode < 300){
    $retArr["status"] = 1;
  }else{
    $retArr["status"] = 0;
  }

  return $retArr;
}

/**
* Will check the person service and see if it is working or not
*
* @return A json encoded array
*/
function checkPersonService(){
  $retArr = Array();
  $retArr["title"] = "Person";
  $retArr["status"] = 0;
  $retArr["requestUrl"] = "person.byu.edu";

  return $retArr;

}

/**
* Will check the gro service and giveback a status
* 
* @return A json encoded array
*/
function checkGRO(){
  $retArr = Array();
  $retArr["title"] = "GRO";
  $retArr["status"] = 0;
  $retArr["requestUrl"] = "gro.byu.edu";

  return $retArr;
}

/**
* Will check the AIM service
*
* @return A json encoded array
*/
function checkAIM(){
  $retArr = Array();
  $retArr["title"] = "AIM";
  $retArr["status"] = 0;
  $retArr["requestUrl"] = "aim.byu.edu";

  return $retArr;
}

/**
* Will check the Scout service
*
* @return A json encoded array
*/
function checkScout(){
  $retArr = Array();
  $retArr["title"] = "Scout";
  $retArr["status"] = 0;
  $retArr["requestUrl"] = "scout.byu.edu";

  return $retArr;
}





  // Send back the JSON
  echo json_encode($arr);

  
?>