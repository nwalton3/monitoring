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
<<<<<<< HEAD
  $arr1 = Array("title"=>"CAS", "status"=>1, "url"=>"http://cas.byu.edu");
  $arr2 = Array("title"=>"Person", "status"=>0, "url"=>"http://person.byu.edu");
  $arr3 = Array("title"=>"AIM", "status"=>1, "url"=>"http://aim.byu.edu");
  $arr4 = Array("title"=>"GRO", "status"=>1, "url"=>"http://gro.byu.edu");
  $arr5 = Array("title"=>"Scout", "status"=>1, "url"=>"http://scout.byu.edu");
  $arr6 = Array("title"=>"Server", "status"=>1, "url"=>"http://learningsuite.byu.edu");
=======
  $arr1 = Array("title"=>"CAS",    "status"=>"success", "requestUrl"=>"cas.byu.edu");
  $arr2 = Array("title"=>"Person", "status"=>"error",   "requestUrl"=>"person.byu.edu");
  $arr3 = Array("title"=>"AIM",    "status"=>"success", "requestUrl"=>"aim.byu.edu");
  $arr4 = Array("title"=>"GRO",    "status"=>"success", "requestUrl"=>"gro.byu.edu");
  $arr5 = Array("title"=>"Scout",  "status"=>"success", "requestUrl"=>"scout.byu.edu");
>>>>>>> It's alive! Hahahahaha!

  $all = Array($arr1, $arr2, $arr3, $arr4, $arr5, $arr6);


  // Just the titles  
  $title1 = Array("title"=>"CAS");
  $title2 = Array("title"=>"Person");
  $title3 = Array("title"=>"AIM");
  $title4 = Array("title"=>"GRO");
  $title5 = Array("title"=>"Scout");
  $title6 = Array("title"=>"Server");
  
  $titles = Array($title1, $title2, $title3, $title4, $title5, $title6);

    
  // Get the requested data
  switch($q) {
    
    case 'titles':
      $arr = $titles;
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
<<<<<<< HEAD
      $arr = checkScout();
=======
      $arr = $arr5;
      $arr["status"] = "processing"; 
>>>>>>> It's alive! Hahahahaha!
      break;
    
    case 'all':
    default:
      $arr = checkAllServices();
      break;
  }  

/**
* Will check all services and 
*
* @return A json encoded array
*/
function checkAllServices(){
  $retArr = [];

  //TODO: Remove 'magic' strings
  $retArr[] = json_decode(checkServer());
  $retArr[] = json_decode(checkCAS());
  $retArr[] = json_decode(checkPersonService());
  $retArr[] = json_decode(checkGRO());

  return json_encode($retArr);
}

/**
* Will check too see if the service that hosts the website works
*
* @return A json encoded array
*/
function checkServer(){

  $retArr = [];
  $retArr["title"] = "Server";
  $retArr["status"] = 1;
  $retArr["url"] = "my.byu.edu";

  return json_encode($retArr);
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
  $retArr = [];
  $retArr["title"] = "CAS";
  $retArr["url"] = "cas.byu.edu";

  if($httpcode >= 200 && $httpcode < 300){
    $retArr["status"] = 1;
  }else{
    $retArr["status"] = 0;
  }

  return json_encode($retArr);
}

/**
* Will check the person service and see if it is working or not
*
* @return A json encoded array
*/
function checkPersonService(){
  $retArr = [];
  $retArr["title"] = "Person";
  $retArr["status"] = 0;
  $retArr["url"] = "person.byu.edu";

  return json_encode($retArr);

}

/**
* Will check the gro service and giveback a status
* 
* @return A json encoded array
*/
function checkGRO(){
  $retArr = [];
  $retArr["title"] = "GRO";
  $retArr["status"] = 0;
  $retArr["url"] = "gro.byu.edu";

  return json_encode($retArr);
}

/**
* Will check the AIM service
*
* @return A json encoded array
*/
function checkAIM(){
  $retArr = [];
  $retArr["title"] = "AIM";
  $retArr["status"] = 0;
  $retArr["url"] = "aim.byu.edu";

  return json_encode($retArr);
}

/**
* Will check the Scout service
*
* @return A json encoded array
*/
function checkScout(){
  $retArr = [];
  $retArr["title"] = "Scout";
  $retArr["status"] = 0;
  $retArr["url"] = "scout.byu.edu";

  return json_encode($retArr);
}
  // Send back the JSON
  echo json_encode($arr);
  
?>