<?php
/**
 *
 * This class handles all the functions that are related to Category module.
 *
 */
class Category extends DBCommon{
	/**
	*
	* This is a constructer of Auction Class.
	*/
	public function __construct(){
		$this->primaryKey = 'cat_id';
		$this->orderBy = 'cat_id';
		parent::__construct();
	}
	function fetchCategoryDetails($cat_type_id,$isOrdered = false, $isLimit = false){
		$select="Select c.*,cw.name,cw.size_type
					from tbl_category c LEFT JOIN tbl_size_weight_cost_master cw ON
							c.fk_size_weight_cost_id = cw.size_weight_cost_id
							where c.fk_cat_type_id = '".$cat_type_id."'
							";
		if($isOrdered){
			   $select = $select." ORDER BY ".$this->orderBy." ".$this->orderType;
		   }
		   if($isLimit){
			   $select = $select." LIMIT ".$this->offset.",".$this->toShow;
		   }
		 if($rs = mysqli_query($GLOBALS['db_connect'], $select)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }
			   return $dataArr;
		   }
		   return false;
	}
	function selectDataCategory(){

		$select="Select c.*
					from tbl_category c WHERE c.is_stills = '0'
							AND c.fk_cat_type_id !='2'
							AND c.cat_id IN (SELECT MIN(cat_id) FROM tbl_category WHERE is_stills = '0' AND fk_cat_type_id !='2' GROUP BY cat_value)
							ORDER BY
							c.cat_id
					 ";


		 if($rs = mysqli_query($GLOBALS['db_connect'], $select)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }
			  }
		$selectGenre ="Select c.*
					from tbl_category c WHERE c.is_stills = '0'
							AND c.fk_cat_type_id ='2'
							ORDER BY
							c.cat_value
					 ";
		if($rsGenre = mysqli_query($GLOBALS['db_connect'], $selectGenre)){
			   while($rowGenre = mysqli_fetch_assoc($rsGenre)){
				   $dataArr[] = $rowGenre;
			   }
			   return $dataArr;
		   }
		   return false;
	}
	function selectCategoryName($catId){
		$select="Select c.cat_value
					from tbl_category c
						WHERE c.cat_id = '".$catId."' ";

		if($rs = mysqli_query($GLOBALS['db_connect'], $select)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr = $row['cat_value'];
			   }
			   return $dataArr;
		   }
		   return false;

	}
	function selectDataCategoryStills(){
		$select="Select c.*
					from tbl_category c WHERE c.fk_cat_type_id !='2'
							AND c.cat_id IN (SELECT MIN(cat_id) FROM tbl_category WHERE fk_cat_type_id !='2' GROUP BY cat_value)
							ORDER BY
							c.cat_id
					 ";


		 if($rs = mysqli_query($GLOBALS['db_connect'], $select)){
			   while($row = mysqli_fetch_assoc($rs)){
				   $dataArr[] = $row;
			   }
			  }
		$selectGenre ="Select c.*
					from tbl_category c WHERE  c.fk_cat_type_id ='2'
							ORDER BY
							c.cat_value
					 ";
		if($rsGenre = mysqli_query($GLOBALS['db_connect'], $selectGenre)){
			   while($rowGenre = mysqli_fetch_assoc($rsGenre)){
				   $dataArr[] = $rowGenre;
			   }
			   return $dataArr;
		   }
		   return false;
	}
}
?>
