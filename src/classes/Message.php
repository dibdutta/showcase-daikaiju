<?php
/**
 * 
 * This class handles all the functions that are related to Internal Message module.
 *
 */
class Message extends DBCommon{
	/**
	* 
	* This is a constructer of Message Class.
	*/
	public function __construct(){		
		parent::__construct();
		$this->primaryKey = 'message_id';
		$this->orderBy = 'message_sent_dt';
		$this->orderType = 'DESC';
		
	}
	/**
		 * 
		 * This function fetches all the details of your inbox messages.
		 * @param $where=>This paramter defines the condition on which messages to be fetched. 
		 * @param $fields=>This parameter defines database table columns to be fetched.
		 */
	public function listInbox($where, $fields = array('*'),$search_field='')
	{
		if($search_field=='message_subject'){
		 $this->orderType = 'ASC';
		}else{
		 $this->orderType = 'DESC';	
		}
		if($search_field!=''){
		 $this->orderBy=$search_field;	
		}else{
			$this->orderBy='message_sent_dt';	
		}
		$messageRow = $this->selectData(TBL_MESSAGE, $fields, $where, true, true);

			for($i=0;$i<count($messageRow);$i++){
				if($messageRow[$i]['message_is_fromadmin'] == '0'){
					$from = $this->selectData(USER_TABLE, array("username"), array('user_id' => $messageRow[$i]['message_from']));
					$messageRow[$i]['message_from_username'] = $from[0]['username'];
				}else{
					$messageRow[$i]['message_from_username'] = "Admin";
				}
			}
			
			return $messageRow;
	}
	/**
		 * 
		 * This function fetches all the details of your sent messages.
		 * @param $where=>This paramter defines the condition on which messages to be fetched. 
		 * @param $fields=>This parameter defines database table columns to be fetched.
		 */
	public function listSentMessages($where, $fields = array('*'),$search_field='')
	{
		if($search_field=='message_subject'){
			$this->orderType = 'ASC';
		}else{
		$this->orderType = 'DESC';	
		}
		if($search_field!=''){
		 $this->orderBy=$search_field;	
		}else{
			$this->orderBy='message_sent_dt';	
		}
		$messageRow = $this->selectData(TBL_MESSAGE, $fields, $where, true, true);
		
			for($i=0;$i<count($messageRow);$i++){
				if($messageRow[$i]['message_is_toadmin'] == '0'){
					$from = $this->selectData(USER_TABLE, array("username"), array('user_id' => $messageRow[$i]['message_to']));
					$messageRow[$i]['message_to_username'] = $from[0]['username'];
				}else{
					$messageRow[$i]['message_to_username'] = "Admin";
				}
			}
			
			return $messageRow;
	}
	/**
		 * 
		 * This function fetches all the details of your read messages.
		 * @param $where=>This paramter defines the condition on which messages to be fetched. 
		 * @param $fields=>This parameter defines database table columns to be fetched.
		 */
	public function readMessage($where, $fields = array('*'))
	{
		$message = $this->selectData(TBL_MESSAGE, $fields, $where);
		$from = $this->selectData(USER_TABLE, array("username"), array('user_id' => $message[$i]['message_from']));
		if($message[0]['message_is_fromadmin'] == '0'){
			$from = $this->selectData(USER_TABLE, array("username"), array('user_id' => $message[0]['message_from']));
			$message[0]['message_from_username'] = $from[0]['username'];
		}else{
			$message[0]['message_from_username'] = "Admin";
		}
		
		return $message;
	}
}
?>