<?php

//error_reporting(E_STRICT); 
header('Content-Type: application/json');

//What it should be able to do
// 1. Return all titles for all possiable objects(shared code)
// 2. Check each individual service
// 3. Connect to the ls includes
// 4. Check all services at the same time

//Needs to be changed to point at the urlDefs in the ls repository
require_once('../learningsuite-trunk/site/inc/urlDefs.php');

//S special fake session
require_once("FakeSession.php");

//
require_once(SESSION_WRAPPER_URL);

//A tests to compare switch vs if-elseif
$fk = new FakeSession();

LearningSuite_Environment::setApplication($fk);

//The array that needs to be modified 
$dremel = array(
	'dremel1.byu.edu',
	'dremel2.byu.edu',
	'dremel3.byu.edu',
	'dremel4.byu.edu',
	'dremel5.byu.edu',
	'dremel6.byu.edu'
	);

$servicesObjectsData = array(
	'cas' => array(
		'title'=>'CAS',
		'requestUrl' => "cas.byu.edu",
		'desc' => "BYU's campus-wide authentication solution. If down, nothing on campus requiring CAS authentication works at all."
		),
	'person'=> array(
		'title'=>'Person',
		'requestUrl' => "person.byu.edu",
		'desc' => "Data stored by BYU about all individuals here. If down, Learning Suite will not function."
		),
	'aim'=> array(
		'title'=>'AIM',
		'requestUrl' => "ws.byu.edu",
		'desc' => "Course enrollments. If down, nothing in Learning Suite works."
		),
	'gro'=> array(
		'title'=>'GRO',
		'requestUrl' => "ws.byu.edu/rest/v1/identity/customGroup",
		'desc' => "Manages all groups. If down, instructors and students will likely not be affected, but others (admin, staff) may be blocked or limited in Learning Suite."
		),
	'scout'=> array(
		'title'=>'Scout',
		'requestUrl' => "learningsuite.byu.edu",
		'desc' => "Manages exams. If down, all exam functions will be unavailable."
		),
	'gradebook'=> array(
		'title'=>'Gradebook',
		'requestUrl' => "gradebook.byu.edu",
		'desc' => "Manages grades."
		),
	'agilix'=> array(
		'title'=>'Agilix',
		'requestUrl' => "gradebook.byu.edu",
		'desc' => "Helps manages gradebook."
		),
	'alfresco'=> array(
		'title'=>'Alfresco',
		'requestUrl' => "dev1.ctl.byu.edu:8080/alfresco/api",
		'desc' => "Manages grades."
		),
	'bookstore'=> array(
		'title'=>'Bookstore',
		'requestUrl' => "booklist.byu.edu",
		'desc' => "Gives BYU Bookstore Book infomation."
		),
	'server'=> array(
		'title'=>'Server',
		'requestUrl' => "learningsuite.byu.edu",
		'desc' => "The web server running Learning Suite. If down, LS is completely inaccessible."
		)
);

$servicesObjectsFn = array(
	'cas'=> function(){
		$status = 0;

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
			$status = 1;
		}else{
			$status = 0;
		}

		return $status;
	},
	'person'=> function(){
		$status = 0;
		$test = LearningSuite_LearningSuite_Monitor::find(1);

		try{
			$test->forceLoad();
			$status = 1;
		}catch(Exception $e){
			$status = 0;
		}

		return $status;
	},
	'aim'=> function(){
		$status = 0;
		$test = LearningSuite_LearningSuite_Monitor::find(1);

		try{
			$test->forceLoad();
			$status = 1;
		}catch(Exception $e){
	 		$status = 0;
 		}
		return $status;
	},
	'gro'=> function(){
		$status = 0;

		$test = LearningSuite_LearningSuite_Monitor::find(3);

		try{
			$test->forceLoad();
			$status = 1;
		}catch(Exception $e){
	 		$status = 0;
 		}

 		return $status;
	},
	'scout'=> function(){
		$status = 0;
		$test = LearningSuite_LearningSuite_Monitor::find(4);

		try{
			$test->forceLoad();
			$status = 1;
		}catch(Exception $e){
			$status = 0;
 		}
 		return $status;
	},
	'gradebook'=> function(){
		$status = 0;

		$test = LearningSuite_LearningSuite_Monitor::find(6);

		try{
			$test->forceLoad();
			if($test->getGradebook() == 0) {
				$status = 0;
			}else{
				$status = 1;
			}
		}catch(Exception $e){
	 		$status = 0;
 		}

 		return $status;
	},
	'agilix'=> function(){
		$status = 0;
		$test = LearningSuite_LearningSuite_Monitor::find(7);
		try{
			if($test->forceLoad() == 0) {
				$status = 0;
			}else{
				$status = 1;
			}
		}catch(Exception $e){
	 		$status = 0;
	 	}

	 	return $status;
	},
	'alfresco'=> function(){
		$status = 0;
		$test = LearningSuite_LearningSuite_Monitor::find(3);

		try{
			if($test->forceLoad() == 0) {
				$status = 0;
			}else{
				$status = 1;
			}
		}catch(Exception $e){
	 		$status = 0;
 		}
		return $status;
	},
	'bookstore'=> function(){
		$status = 0;

		$url = "http://booklist.byu.edu/item/9780716779391";

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
		
		if($httpcode >= 200 && $httpcode < 304){
			$status = 1;
		}else{
			$status = 0;
		}

		return $status;

	},
	'server'=> function(){
		$status = 1;

		return $status;
	}
);

/**
* Will check a service and give back selected information about it
*
* @param $serviceToCheck -  A string of what to check
* @param $servicesObjectsData
* @param $servicesObjectsFn
* @return An Array that will always contain static data about the services and usually(dependant of settings) status
*/
function checkService($serviceToCheck,$servicesObjectsData,$servicesObjectsFn,$dremel,$server){
	
	$data = array();
	if($serviceToCheck === "titles"){
		foreach($dremel as $key){
			$data[] = getStaticDataWithServer($key,'server',$servicesObjectsData);
			$data[] = getStaticDataWithServer($key,'cas',$servicesObjectsData);
			$data[] = getStaticDataWithServer($key,'person',$servicesObjectsData);
			$data[] = getStaticDataWithServer($key,'aim',$servicesObjectsData);
			$data[] = getStaticDataWithServer($key,'gro',$servicesObjectsData);
			$data[] = getStaticDataWithServer($key,'gradebook',$servicesObjectsData);
			$data[] = getStaticDataWithServer($key,'bookstore',$servicesObjectsData);
			$data[] = getStaticDataWithServer($key,'scout',$servicesObjectsData);
			//$data[] = $servicesObjectsData['agilix'];
			//$data[] = $servicesObjectsData['alfresco'];
		}
	}else if($serviceToCheck === "all"){
		$data[] = checkService('server',$servicesObjectsData,$servicesObjectsFn,$server);
		$data[] = checkService('cas',$servicesObjectsData,$servicesObjectsFn,$server);
		$data[] = checkService('person',$servicesObjectsData,$servicesObjectsFn);
		$data[] = checkService('aim',$servicesObjectsData,$servicesObjectsFn,$server);
		$data[] = checkService('gro',$servicesObjectsData,$servicesObjectsFn,$server);
		$data[] = checkService('gradebook',$servicesObjectsData,$servicesObjectsFn,$server);
		$data[] = checkService('bookstore',$servicesObjectsData,$servicesObjectsFn,$server);
		$data[] = checkService('scout',$servicesObjectsData,$servicesObjectsFn,$server);
		//$data[] = checkService('agilix',$servicesObjectsData,$servicesObjectsFn);
		//$data[] = checkService('alfresco',$servicesObjectsData,$servicesObjectsFn);
		
	}else{
		//
		if($server != null){
			setServer($server);
		}
		$fn = $servicesObjectsFn[$serviceToCheck];
		
		$data = array();//$servicesObjectsData[$serviceToCheck];
		$data['title'] = ucfirst($serviceToCheck);
		$data['status'] = $fn();
	}
	return $data;
}

/**
* Will get the information about a service and then just get a simple version of it.
*
* @param $serviceToCheck - A string with 
* @param $servicesObjectsData - An Assoc. Array of static data about each service
* @param $servicesObjectsFn - An Assoc. Array of functions to check status
* @return A simple array with just the name and the status of a service
*/
function simpleCheckService($serviceToCheck,$servicesObjectsData,$servicesObjectsFn){

	$return = checkService($serviceToCheck,$servicesObjectsData,$servicesObjectsFn);
	unset($return['requestUrl']);
	unset($return['desc']);
	unset($return['active']);
	return $return;

}

/**
 * Willg et the static data array with a 'server' field added
 * @param type $server
 * @param type $service
 * @param type $servicesObjectsData
 */
function getStaticDataWithServer($server,$service,$servicesObjectsData){
	$return = $servicesObjectsData[$service];
	$return['server'] = $server;
	return $return;
}

/**
 * Set the server that LSObject will connect to for the LSAPI
 * @param type $server
 */
function setServer($server){
	//TODO: GREG SET STUFF HERE
}
/**
* Will check each dremel server with each service and return a simple array
*
* @param $dremel - An array of the $dremel servers
* @param $servicesObjectsData -An Assoc. Array of static data about each service
* @param $servicesObjectsFn - An Assoc. Array of functions to check status
* @return An array of all the dremel servers with data on each
*/
function checkAllServersAndServices($dremel,$servicesObjectsData,$servicesObjectsFn){
	//
	$titles = checkService("titles",$servicesObjectsData,$servicesObjectsFn);

	$retArr = array();
	
	foreach($dremel as $val){

		$data = array();
		//TODO: Set the learningSuite Object environment
		
		foreach ($titles as $key => $vals) {
			$temp = simpleCheckService(strtolower($vals['title']),$servicesObjectsData,$servicesObjectsFn);
			$data[] =  simpleCheckService(strtolower($vals['title']),$servicesObjectsData,$servicesObjectsFn);
			//$data[] =  simpleCheckService(strtolower($vals['title']),$servicesObjectsData,$servicesObjectsFn);
			
		}
		$retArr[$val] = $data;

	}

	return $retArr;
}

//Service
// Get the query string  
$q = '';
if(isset( $_GET['s'] )) {
	$q = $_GET['s'];
}
$q = strtolower($q);

//This is for each each server
$q2 = '';
if(isset( $_GET['q'])){
	$q2 = $_GET['q'];
}
$q2 = strtolower($q2);

$arr = array();

if(strlen($q) > 0){
	$arr = checkService($q,$servicesObjectsData,$servicesObjectsFn,$dremel,$q2);
}else if(strlen($q2) > 0){
	$arr = checkAllServersAndServices($dremel,$servicesObjectsData,$servicesObjectsFn);
}

echo json_encode($arr);

?>