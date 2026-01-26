<?php
$totalPoster=3;
$PosterAttr = array();
$property= array('Weight' => array('Value' => 1,
                                'Units' => 'LB'),
                                'Dimensions' => array('Length' => 36,
                                					  'Width' => 24,
                                                      'Height' => 3,
                                                      'Units' => 'IN')
                                                  ); 

for($tp=1;$tp<=$totalPoster;$tp++){
	array_push($PosterAttr,$property);
}
echo "<pre>";
print_r($PosterAttr);
echo "</pre>";
 ?>