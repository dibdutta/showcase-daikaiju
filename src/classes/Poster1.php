<?php

class Poster extends DBCommon{
	
	public function __construct(){		
		$this->primaryKey = 'poster_id';
		$this->orderBy = 'poster_id';
		parent::__construct();
	}
	
	function fetchPosterCategories(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			 $poster_ids .= $dataArr[$i]['poster_id'].",";
		}
		echo $poster_ids = trim($poster_ids, ',');
		
		/*$sql = "SELECT ptc.fk_poster_id, c.cat_value FROM ".TBL_POSTER_TO_CATEGORY." ptc
				LEFT JOIN ".TBL_CATEGORY." c ON ptc.fk_cat_id = c.cat_id
				WHERE ptc.fk_poster_id IN (".$poster_ids.")";*/
				
		 $sql = "SELECT ptc.fk_poster_id, c.cat_value, c.fk_cat_type_id
		 		FROM ".TBL_POSTER_TO_CATEGORY." ptc, ".TBL_CATEGORY." c
				WHERE ptc.fk_cat_id = c.cat_id AND ptc.fk_poster_id IN (".$poster_ids.")
				ORDER BY c.fk_cat_type_id";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $catArr[] = $row;
		   }
	    }
		
		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($catArr);$j++){
				if($dataArr[$i]['poster_id'] == $catArr[$j]['fk_poster_id']){
					$arr[$flag]['fk_cat_type_id'] = $catArr[$j]['fk_cat_type_id'];
					$arr[$flag]['cat_value'] = $catArr[$j]['cat_value'];
					$flag++;
					//$dataArr[$i]['categories'] .= $catArr[$j]['cat_value'].",";
				}				
			}
			//$dataArr[$i]['categories'] = trim($dataArr[$i]['categories'], ',');
			$dataArr[$i]['categories'] = $arr;
			unset($arr);
		}		
	   return true;
	}
	
	function fetchPosterImages(&$dataArr)
	{
		for($i=0;$i<count($dataArr);$i++){
			$poster_ids .= $dataArr[$i]['poster_id'].",";
		}
		$poster_ids = trim($poster_ids, ',');
		
		$sql = "SELECT pi.fk_poster_id, pi.poster_image, pi.is_default FROM ".TBL_POSTER_IMAGES." pi
				WHERE pi.fk_poster_id IN (".$poster_ids.")";
				
	    if($rs = mysqli_query($GLOBALS['db_connect'],$sql)){
		   while($row = mysqli_fetch_assoc($rs)){
			   $imagesArr[] = $row;
		   }
	    }

		for($i=0;$i<count($dataArr);$i++){
			$flag = 0;
			for($j=0;$j<count($imagesArr);$j++){
				if($dataArr[$i]['poster_id'] == $imagesArr[$j]['fk_poster_id']){					
					 $arr[$flag]['poster_image'] = $imagesArr[$j]['poster_image'];
					 if($imagesArr[$j]['is_default'] == 1){
						 $arr[$flag]['is_default'] = 1;
					 }else{
						 $arr[$flag]['is_default'] = 0;
					 }
					 $flag++;
				}				
			}
			$dataArr[$i]['images'] = $arr;			
			unset($arr);
		}
	   return true;
	}
}
?>