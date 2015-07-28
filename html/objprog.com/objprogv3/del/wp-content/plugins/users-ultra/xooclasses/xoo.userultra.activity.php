<?php
class XooActivity 
{
	
	var $mDateToday ;


	function __construct() 
	{
		$this->ini_module();
		$this->mDateToday =  date("Y-m-d"); 
		
		
	}
	
	public function ini_module()
	{
	
	
		
	}
	
	
	
	

}
$key = "activity";
$this->{$key} = new XooActivity();