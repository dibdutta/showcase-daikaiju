<?php
/**
 * 
 * This class handles all the functions that are related to Event module.
 *
 */
class Event extends DBCommon{
	/**
	* 
	* This is a constructer of Event Class.
	*/
	public function __construct(){		
		$this->primaryKey = 'event_id';
		$this->orderBy = 'event_id';
		parent::__construct();
	}
}
?>