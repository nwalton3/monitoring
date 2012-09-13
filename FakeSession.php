<?php

class FakeSession implements LearningSuite_Application{
	
	/**
	 * Will return the fake CTL person as the authenticated person
	 * @return A NetID
	 */
	public static function getUser(){
		$p = LearningSuite_BYU_Person::findByNetID("ctlbizsv");
		return $p;
		
	}
	
	/**
	 * Will return the fake CTL person as the authenticated person
	 * @return A NetID
	 */
	public static function getAuthenticatedUser(){
		$p = LearningSuite_BYU_Person::findByNetID("ctlbizsv");
		return $p;
		
	}
	
	/**
	 * Will return a ip address
	 *  @return An IP Address
	 */
	public static function getClientIPAddress(){
		return "127.0.0.1";
	}
	
	/**
	 *  Not sure what it's meant to do but 
	 * @return An empty Array
	 */
	public static function getAdditionalRequestHeaders(){
		return Array();
	}
	
	/**
	 *
	 */
	public static function getAPISessionCookies(){
		
		return Array();
	}
    
	/**
	 * 
	 */
	public static function setAPISessionCookies(array $cookies){
		
	}
}
?>