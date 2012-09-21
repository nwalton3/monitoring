<?php 
header('Content-Type: application/json');

//Needs to be changed to point at the urlDefs in the ls repository
require_once('c:/wamp/www/ls/site/inc/urlDefs.php');

require_once("FakeSession.php");
require_once(SESSION_WRAPPER_URL);

$fk = new FakeSession();

LearningSuite_Environment::setApplication($fk);
	// Get the query string  
$q = '';
if(isset( $_GET['s'] )) {
	$q = $_GET['s'];
}
$q = strtolower($q);


	// The array to pass back
$arr = Array();


	// The full info... Not really used
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

	case 'gradebook':
	$arr = checkGradebook();
	break;

	case 'agilix':
	$arr = checkAgilix();
	break;

	case 'alfresco':
	$arr = checkAlfresco();
	break;

	case 'bookstore':
	$arr = checkBookstore();
	break;

	case 'ls server':
	$arr = checkServer();
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
	$titles = Array();

	//TODO: Remove 'magic' strings
	$titles[] = checkServer(true);
	$titles[] = checkCAS(true);
	//$titles[] = checkPersonService(true);
	$titles[] = checkAIM(true);
	$titles[] = checkGRO(true);
	$titles[] = checkBookstore(true);
	$titles[] = checkGradebook(true);
	$titles[] = checkScout(true);
	//$titles[] = checkAgilix(true);
	$titles[] = checkAlfresco(true);
	

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
	//$retArr[] = checkPersonService();
	$retArr[] = checkAIM();
	$retArr[] = checkGRO();
	$retArr[] = checkScout();
	$titles[] = checkAgilix();
	$titles[] = checkAlfresco();
	$titles[] = checkGradebook();
	$titles[] = checkBookstore();

	return $retArr;
}

/**
* Will check too see if the service that hosts the website works
*
* @return A json encoded array
*/
function checkServer($title = false){

	$retArr = Array();
	$retArr["title"] = "LS Server";
	$retArr["desc"] = "The web server running Learning Suite. If down, LS is completely inaccessible.";  
	$retArr["requestUrl"] = "learningsuite.byu.edu";
	
	if($title) {
		return $retArr;
	}
	
	$retArr["status"] = 1;

	return $retArr;
}

/**
* Will check to see if the CAS system is up an running
*
* @return A json encoded array
*/
function checkCAS($title = false){

	$retArr = Array();
	$retArr["title"] = "CAS";
	$retArr["desc"] = "BYU's campus-wide authentication solution. If down, nothing on campus requiring CAS authentication works at all.";  
	$retArr["requestUrl"] = "cas.byu.edu";

	// Only return the title if that's all that's requested
	if($title) {
		return $retArr;
	}

	//TODO: Make into a defined
	$CASurl = "http://cas.byu.edu/cas/login";
	//$CASurl = "http://www.google.com/";
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
	
	if($httpcode >= 200 && $httpcode < 304){
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
function checkPersonService($title = false){
	$retArr = Array();
	$retArr["title"] = "Person";
	$retArr["desc"] = "Data stored by BYU about all individuals here. If down, Learning Suite will not function.";  
	$retArr["requestUrl"] = "person.byu.edu";
	
	if($title) {
		return $retArr;
	}
	
	$test = LearningSuite_LearningSuite_Monitor::find(1);

	try{
		$test->forceLoad();
		$retArr["status"] = 1;
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }

 return $retArr;

}

/**
* Will check the gro service and giveback a status
* 
* @return A json encoded array
*/
function checkGRO($title = false){
	$retArr = Array();
	$retArr["title"] = "GRO";
	$retArr["desc"] = "Manages all groups. If down, instructors and students will likely not be affected, but others (admin, staff) may be blocked or limited in Learning Suite.";
	$retArr["requestUrl"] = "ws.byu.edu/rest/v1/identity/customGroup";
	
	if($title) {
		return $retArr;
	}
	
	$retArr["status"] = 0;
	
	$test = LearningSuite_LearningSuite_Monitor::find(3);

	try{
		$test->forceLoad();
		$retArr["status"] = 1;
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }
 return $retArr;
}

/**
* Will check the AIM service
*
* @return A json encoded array
*/
function checkAIM($title = false){
	$retArr = Array();
	$retArr["title"] = "AIM";
	$retArr["desc"] = "Course enrollments. If down, nothing in Learning Suite works.";  
	$retArr["requestUrl"] = "ws.byu.edu";
	
	if($title) {
		return $retArr;
	}
	
	$test = LearningSuite_LearningSuite_Monitor::find(1);

	try{
		$test->forceLoad();
		$retArr["status"] = 1;
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }

 return $retArr;
}

/**
* Will check the alfreco service and giveback a status
* 
* @return A json encoded array
*/
function checkAlfresco($title = false){
	$retArr = Array();
	$retArr["title"] = "Alfresco";
	$retArr["desc"] = "Manages file uploading.";
	$retArr["requestUrl"] = "dev1.ctl.byu.edu:8080/alfresco/api";
	
	if($title) {
		return $retArr;
	}
	
	$retArr["status"] = 0;
	
	$test = LearningSuite_LearningSuite_Monitor::find(3);

	try{
		if($test->forceLoad() == 0) {
			$retArr["status"] = 0;
		}else{
			$retArr["status"] = 1;
		}
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }
 return $retArr;
}

/**
* Will check the Gradebook service and giveback a status
* 
* @return A json encoded array
*/
function checkGradebook($title = false){
	$retArr = Array();
	$retArr["title"] = "Gradebook";
	$retArr["desc"] = "Manages grades.";
	$retArr["requestUrl"] = "dot-ctl.byu.edu/alfresco/service";
	
	if($title) {
		return $retArr;
	}
	
	$retArr["status"] = 0;
	
	$test = LearningSuite_LearningSuite_Monitor::find(6);

	try{
		$test->forceLoad();
		if($test->getGradebook() == 0) {
			$retArr["status"] = 0;
		}else{
			$retArr["status"] = 1;
		}
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }
 return $retArr;
}

/**
* Will check the Bookstore service and giveback a status
* 
* @return A json encoded array
*/
function checkBookstore($title = false){
	$retArr = Array();
	$retArr["title"] = "Bookstore";
	$retArr["desc"] = "Gives BYU Bookstore Book infomation.";
	$retArr["requestUrl"] = "dot-ctl.byu.edu/alfresco/service";
	
	if($title) {
		return $retArr;
	}
	
		
	$retArr["status"] = 0;
	$url = "http://booklist.byu.edu/item/9780716779391";
	//$url = "http://www.google.com/";
		if($url == NULL) return false;

		//Connect to website with curl
		$curly = curl_init($url);

		//Some settings for curl
		curl_setopt($curly, CURLOPT_TIMEOUT, 0);
		curl_setopt($curly, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($curly, CURLOPT_RETURNTRANSFER, true);// What does this exactly do
		
		$data = curl_exec($curly);
		$httpcode = curl_getinfo($curly,CURLINFO_HTTP_CODE);
		
		//Close curl
		curl_close($curly);
		
		//Return object
		//var_dump($httpcode);
		//die;
		if($httpcode >= 200 && $httpcode < 304){
			$retArr["status"] = 1;
		}else{
			$retArr["status"] = 0;
		}
	/*
	$test = LearningSuite_LearningSuite_Monitor::find(8);

	try{
		if($test->forceLoad() == 0) {
			$retArr["status"] = 0;
		}else{
			$retArr["status"] = 1;
		}
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }*/
 return $retArr;
}

/**
* Will check the Agilix service
*
* @return A json encoded array
*/
function checkAgilix($title = false){
	$retArr = Array();
	$retArr["title"] = "Agilix";
	$retArr["desc"] = "Manages gradebook also.";  
	$retArr["requestUrl"] = "byu.ct.agilix.com/Dlap/dlap.ashx";
	
	$test = LearningSuite_LearningSuite_Monitor::find(7);
	
	if($title) {
		return $retArr;
	}
	
	$retArr["status"] = 0;
	try{
		if($test->forceLoad() == 0) {
			$retArr["status"] = 0;
		}else{
			$retArr["status"] = 1;
		}
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }

 return $retArr;
}

/**
* Will check the Scout service
*
* @return A json encoded array
*/
function checkScout($title = false){
	$retArr = Array();
	$retArr["title"] = "Scout";
	$retArr["desc"] = "Manages exams. If down, all exam functions will be unavailable.";  
	$retArr["requestUrl"] = "scout.byu.edu";
	
	$test = LearningSuite_LearningSuite_Monitor::find(4);
	
	if($title) {
		return $retArr;
	}
	
	$retArr["status"] = 0;
	try{
		$test->forceLoad();
		$retArr["status"] = 1;
	}catch(Exception $e){
	 $retArr["status"] = 0;
 }

 return $retArr;
}

	// Send back the JSON
echo json_encode($arr);


?>