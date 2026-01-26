<?php
/**
 * 
 * This class handles all the functions that executes sql queries as select data,insert data,delete
 * data,count data;
 *
 */
class DBCommon{
	/**
	 * 
	 * @var  This is global variable defines the 'primary key' that will be used for all the sql that will be
	 * used in all the functions in this class.
	 */
	public $primaryKey;
	/**
	 * 
	 * @var This is global variable defines the IP address from which the site is been accessed.
	 */
	public $postIP;
	
	public $status;
	/**
	 * 
	 * @var This is global variable defines the 'starting limit' that will be used for all the sql that will be
	 * used in all the functions in this class.
	 */
	public $offset;
	/**
	 * 
	 *@var This is global variable defines the 'ending limit' that will be used for all the sql that will be
	 * used in all the functions in this class.
	 */
	public $toShow;
	public $orderType;
	/**
	 * 
	 *@var This is global variable defines the 'Order By' for all the sql that will be
	 * used in all the functions in this class.
	 */
	public $orderBy;
	
	/**
	* 
	* This is a constructer of DBCommon Class.
	*/
	
	public function __construct(){
		
		$this->postIP = $_SERVER['REMOTE_ADDR'];
		$this->status = 1;		
		
		$this->offset = $GLOBALS['offset'];
		$this->toShow = $GLOBALS['toshow'];
		$this->orderType = $GLOBALS["order_type"];
		if(isset($_REQUEST["order_by"]) && $_REQUEST["order_by"] != ""){
			$this->orderBy = $_REQUEST["order_by"];
		}
		
		/*if($_REQUEST["order_type"]!="") {
			$this->orderType = $_REQUEST["order_type"];
		}else{
			$this->orderType = 'ASC';
		}*/
	}
	/**
	 * 
	 * This function counts the no. of datas avilable in the database in the provided condition.
	 * @param $table=>The name of the table.
	 * @param $where=>Condition that are eual to any particular data to count particular records.
	 * @param $exception=>Condition that are not eual to any particular data to count particular records. 
	 */
	public function countData($table, $where = '1', $exception = '')
	{
		
		   $counter = 0;
           $whereClause='';
           $exceptionClause='';
		   if(is_array($where)){
				   $counter = 1;
				   foreach($where as $key => $value){                        
						   $whereClause .= "$key = '".$value."'";
						   $counter++;
						   if(count($where) >= $counter){
								   $whereClause .= ' AND ';
						   }
				   }
				   $whereClause = '('.$whereClause.')';
		   }elseif($where != ''){
				   $whereClause = $where;
		   }
		   
		   if(is_array($exception)){
				   $counter = 1;
				   foreach($exception as $key => $value){                        
						   $exceptionClause .= "$key <> '".$value."'";
						   $counter++;
						   if(count($exception) >= $counter){
								   $exceptionClause .= ' AND ';
						   }						   
				   }
				   $exceptionClause = ' AND ('.$exceptionClause.')';
		   }else{
			   $exceptionClause = $exception;
		   }
		   
		   $select = "SELECT COUNT(".$this->primaryKey.") AS counter FROM $table WHERE $whereClause $exceptionClause";

		   $rs = mysqli_query($GLOBALS['db_connect'], $select) or die(mysqli_error($GLOBALS['db_connect']));
		   $row = mysqli_fetch_array($rs);
		   return $row['counter'];
		 
   }
   
   	/**
   	 * This function fetchs the particular records fulfill the provided condition.
   	 * @param $table=>The name of the table.
   	 * @param $fields=>The fields needed to be fetched from database.
   	 * @param $where=>Condition that are eual to any particular data to count particular records.
   	 * @param $isOrdered=> Defines the sql order by.
   	 * @param $isLimit=> Limit of the sql.
   	 */
   public function selectData($table, $fields = array('*'), $where = '1', $isOrdered = false, $isLimit = false)
   {
		   $counter = 1;
		   $tableData='';
           $whereClause='';
		   foreach($fields as $key => $value){                        
				   $tableData .= $value;
				   $counter++;
				   if(count($fields) >= $counter){
						   $tableData .= ', ';
				   }
		   }
		   
		   if(is_array($where)){
				   $counter = 1;
				   foreach($where as $key => $value){                        
						   $whereClause .= "$key = '".$value."'";
						   $counter++;
						   if(count($where) >= $counter){
								   $whereClause .= ' AND ';
						   }
				   }
		   }else{
				   $whereClause = $where;
		   }
		   $select = "SELECT $tableData FROM $table WHERE $whereClause";
		   if($isOrdered){
			   $select = $select." ORDER BY ".$this->orderBy." ".$this->orderType;
		   }
		   if($isLimit){
			   $select = $select." LIMIT ".$this->offset.",".$this->toShow;
		   }

		   /*$rs = mysqli_query($GLOBALS['db_connect'], $select);
		   for($i=0;$i<mysqli_num_rows($rs);$i++){
			   $row = mysqli_fetch_assoc($rs);
			   $dataArr[$i] = $row;
		   }*/

		   if($rs = mysqli_query($GLOBALS['db_connect'], $select)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }
			   return $dataArr;
		   }
		   return false;
   }
   	/**
   	 * This function updates a particular record in database table in a particular condition.
   	 * @param $table=>The name of the table.
   	 * @param $data=>This fields defines the update data with the field in table.
   	 * @param $where=>Condition that are eual to any particular data to count particular records.
   	 * @param $isUpdate=> Defines whether to insert or to update.If $isUpdate is false the function
   	 * will update and if true than insert. 
   	 */
   public function updateData($table, $data, $where = '1', $isUpdate = false)
   {
		   $counter = 1;
           $tableData='';
           $whereClause='';
		   foreach($data as $key => $value){                        
				   $tableData .= "$key = '$value'";
				   $counter++;
				   if(count($data) >= $counter){
						   $tableData .= ',';
				   }
		   }
		   
		   if(!$isUpdate){
				$sql = "INSERT INTO $table SET $tableData";
				echo $sql;
				if(mysqli_query($GLOBALS['db_connect'], $sql)){
					return mysqli_insert_id($GLOBALS['db_connect']);
				}else{
					return false;
				}
		   }else{
				if(is_array($where)){
					$counter = 1;
					foreach($where as $key => $value){
						$whereClause .= "$key = '".$value."'";
						$counter++;
						if(count($where) >= $counter){
							$whereClause .= ' AND ';
						}
					}
				}else{
					$whereClause = $where;
				}

				$sql = "UPDATE $table SET $tableData WHERE $whereClause";
				return mysqli_query($GLOBALS['db_connect'], $sql);
		   }
   }
   /**
   	 * This function deletes a particular record in database table in a particular condition.
   	 * @param $table=>The name of the table.
   	 * @param $where=>Condition that are eual to any particular data to count particular records.
   	 */
   public function deleteData($table, $where = '1')
   {
       $whereClause='';
		   if(is_array($where)){
				   $counter = 1;
				   foreach($where as $key => $value){                        
						   $whereClause .= "$key = '".$value."'";
						   $counter++;
						   if(count($where) >= $counter){
								   $whereClause .= ', ';
						   }
				   }
		   }else{
				   $whereClause = $where;
		   }
		   
		   $sql = "DELETE FROM $table WHERE $whereClause";

		   return mysqli_query($GLOBALS['db_connect'], $sql);
   }	
}
?>