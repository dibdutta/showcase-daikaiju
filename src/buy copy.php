<?php
ob_start();

define ("INCLUDE_PATH", "./");
require_once INCLUDE_PATH."lib/inc.php";
//chkLoginNow();
if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] =='listing') {
	displayList();
}else if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] =='gallery'){
	displayGallery();
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='select_watchlist'){
	select_watchlist();
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='poster_details'){
	poster_details();
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='search'){
	displaySearch();
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='key_search_global'){
	if($_REQUEST['keyword'] == '' ||  $_REQUEST['keyword'] == 'Search For Items..' ){
		$_SESSION['Err'] = "Please enter a keyword!";
		header("location: buy.php");
		exit;
	}else{
		displayKeySearchGlobal();
	}
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='key_search'){
	if($_REQUEST['keyword'] == '' ||  $_REQUEST['keyword'] == 'Search For Items..' ){
		$_SESSION['Err'] = "Please enter a keyword!";
		header("location: buy.php");
		exit;
	}else{
		displayKeySearch();
	}
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='key_search_upcoming'){
	if($_REQUEST['keyword'] == ''){
		$_SESSION['Err'] = "Please enter a keyword!";
		header("location: buy.php?list=upcoming");
		exit;
	}else{
		displayKeySearch_upcoming();
	}
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='refinesrc'){
	displayRefineSearch();
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='refinesrcStills'){
	displayRefineSearchStills();
}else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='dorefinesrc'){
    if($_REQUEST['keyword'] == '' && $_REQUEST['poster_size_id'] == '' && $_REQUEST['genre_id'] == '' && $_REQUEST['decade_id'] == '' && $_REQUEST['country_id'] == '' ){
		$_SESSION['Err'] = "Please enter atleast one search criteria!!";
		header("location: buy.php?mode=refinesrc");
		exit;
	}else{
		displayDoRefineSearch();
	}
 }else if(isset($_REQUEST['mode']) && $_REQUEST['mode'] =='dorefinesrcStills'){
    if($_REQUEST['keyword'] == '' && $_REQUEST['poster_size_id'] == '' && $_REQUEST['genre_id'] == '' && $_REQUEST['decade_id'] == '' && $_REQUEST['country_id'] == '' ){
		$_SESSION['Err'] = "Please enter atleast one search criteria!!";
		header("location: buy.php?mode=refinesrcStills");
		exit;
	}else{
		displayDoRefineSearchStills();
	}
 }else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='key_search_stills'){
 		key_search_stills();
 }else if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='react'){
 		return_react_json();
 } else{
	displayList();
}

ob_end_flush();

function displayList()
{
	require_once INCLUDE_PATH."lib/common.php";
    if(isset($_SESSION['sessUserID'])){
        $smarty->assign('user_id', $_SESSION['sessUserID']);
    }else{
        $smarty->assign('user_id', 0);
        
    }
    if(isset($_SESSION['sessAuctionView'])){

    }else{
        $_SESSION['sessAuctionView']='';
    }
    if(isset($_REQUEST['list'])){
        $list = $_REQUEST['list'];
    }else{
        $list ='';
    }
	if(isset($_REQUEST['auction_week_id'])){
        $auction_week_id = $_REQUEST['auction_week_id'];
    }else{
        $auction_week_id ='';
    }
	
    if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }
	
	##########################    Overlapping New Add  ##########################
		$auctionWeekObj = new AuctionWeek();
		$objAuction = new Auction();
	    $auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
		if($auctionWeeks >= 1){
			$smarty->assign('live_count', $auctionWeeks);
			$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
			$smarty->assign('auctionWeeksData', $auctionWeeksData);
		}
		if($auctionWeeks == 1 || $auctionWeeks == 0){
			$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
			$smarty->assign('upcomingTotal', $upcomingTotal);
			$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
			$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
		}
		$extended = $objAuction->getExtendedAuction();
		$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
	
	
	if($list == 'upcoming'){
		$total = $objAuction->countAuctionsByStatus('', 'upcoming',$_REQUEST['auction_week']);
		$auctionItems = $objAuction->fetchAuctionsByStatus('', 'upcoming','',$_REQUEST['auction_week']);
		//$posterObj = new Poster();
		//$posterObj->fetchPosterCategories($auctionItems);
		$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
		$auctionWeekObj = new AuctionWeek();
	    $aucetionWeeks = $auctionWeekObj->fetchUpcomingWeeksWithItem();
        $smarty->assign('UpcomingAuctionWeeks', $aucetionWeeks);
	}else{
	  if(!isset($_REQUEST['track_is_expired'])){
		$total = $objAuction->countLiveAuctions($list,$auction_week_id);
		
		if($list=='weekly' || $list=='extended'){
			$totalLiveWeekly = $total;
		}else{
			$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
		}
		######  Should have these chnaged due to auction deleted ########
		if($list=='weekly' && $total==0 && $auctionWeeks==0){
			$total = $objAuction->countExpiredAuctions($list);
			$auctionItems = $objAuction->fetchExperiedAuctions($list,'',$_SESSION['sessAuctionView']);
			$smarty->assign('is_expired', '1');
		}elseif($list=='stills' && $total==0){
		
			$totalUpcoming = $objAuction->countUpcomingStillsAuctionsByStatus();
			if($totalUpcoming>=1){
				$total = $totalUpcoming;
				$auctionItems = $objAuction->fetchStillsLiveAuctions($_SESSION['sessAuctionView']);
			}else{
				$total = $objAuction->countExpiredAuctions($list);
				$auctionItems = $objAuction->fetchExperiedAuctions($list,'',$_SESSION['sessAuctionView']);			
				$smarty->assign('is_expired_stills', '1');
			}
		}else{
			$auctionItems = $objAuction->fetchLiveAuctions($list,'',$_SESSION['sessAuctionView'],$auction_week_id);
			$smarty->assign('is_expired', '0');
		}
		
	 }elseif(isset($_REQUEST['track_is_expired']) && $_REQUEST['track_is_expired']=='1'){
	 	$totalLiveNow = $objAuction->countLiveAuctions($list,$auction_week_id);
		if($list=='weekly'){
			$totalLiveWeekly = $totalLiveNow;
		}else{
			$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
		}
		
	 	$total = $objAuction->countExpiredAuctions('weekly',$_REQUEST['track_is_expired']);
		$auctionItems = $objAuction->fetchExperiedAuctions('weekly','',$_SESSION['sessAuctionView'],$_REQUEST['track_is_expired']);
		$smarty->assign('is_expired', '1');
	 }
	}
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
	$smarty->assign('total', $total);
	$smarty->assign('list',$list);
	for($i=0;$i<count($auctionItems);$i++){
        /*if($list!='weekly'){*/
            if ($auctionItems[$i]['is_cloud']!='1'){
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy/".$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }
            }else{
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }
            }
        /*}else{
            if($_SESSION['sessAuctionView']=='list'){
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }else{
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }
        }*/
		if($auctionItems[$i]['fk_auction_type_id'] != 1){
			/*$endDateTime = splitDateTime($auctionItems[$i]['auction_actual_end_datetime']);
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
		if(isset($auctionItems[$i]['seconds_left']) && $auctionItems[$i]['seconds_left']!=''){
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
			}
		}
	}
	if(!isset($_REQUEST['offset'])){
		$offset=0;
	}else{
		$offset=$_REQUEST['offset'];
	}
	if(!isset($_REQUEST['toshow'])){
		$toshow=0;
	}else{
		$toshow=$_REQUEST['toshow'];
	}
	$smarty->assign('offset', $offset);
	$smarty->assign('toshow', $toshow);
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));
	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$Newlink = DOMAIN_PATH.$_SERVER['PHP_SELF'].generateLink($GLOBALS["offset"], $GLOBALS["toshow"], 'shuffle', 'ASC');
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
	$smarty->assign('Newlink', $Newlink);
	

    if($_SESSION['sessAuctionView'] == 'list'){
        if($list == 'upcoming'  || (isset($totalUpcoming) && $totalUpcoming>=1)){
            $smarty->display("upcoming_buy_list.tpl");
        }else{
            $smarty->display("buy_list.tpl");
        }

    }else{
        if($list == 'upcoming' || (isset($totalUpcoming) && $totalUpcoming>=1)){
            $smarty->display("upcoming_buy_grid.tpl");
        }else{
            $smarty->display("buy_grid.tpl");
        }

    }
}

function displaySearch()
{
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
	if(isset($_REQUEST['auction_week_id'])){
        $auction_week_id = $_REQUEST['auction_week_id'];
    }else{
        $auction_week_id ='';
    }
	$list = $_REQUEST['list'];
    if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }
	##########################    Overlapping New Add  ##########################
		$auctionWeekObj = new AuctionWeek();
		$objAuction = new Auction();
	    $auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
		if($auctionWeeks >= 1){
			$smarty->assign('live_count', $auctionWeeks);
			$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
			//echo "<pre>".print_r($auctionWeeksData)."</pre>";
			$smarty->assign('auctionWeeksData', $auctionWeeksData);
		}
		if($auctionWeeks == 1 || $auctionWeeks == 0){
			$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
			$smarty->assign('upcomingTotal', $upcomingTotal);
			$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
			$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
		}
		$extended = $objAuction->getExtendedAuction();
		$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
	 
	if($_REQUEST['is_expired']==''){
	  $_REQUEST['is_expired']=0;
	}
	if ($_REQUEST['is_expired']=='1'){
	    $poster_ids = $objAuction->searchExpiredPosterIds($list);		
	}else{
		$poster_ids = $objAuction->searchPosterIds($list,$auction_week_id);
		
	}
	
	$total = $objAuction->countSearchLiveAuctions($poster_ids);
	
	$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	
    if($list!='upcoming'){
	 if ($_REQUEST['is_expired']=='1'){
		$auctionItems = $objAuction->fetchSearchExpiredAuctions($poster_ids,$_SESSION['sessAuctionView']);      
	  }else{
		$auctionItems = $objAuction->fetchSearchLiveAuctions($poster_ids,$_SESSION['sessAuctionView'],$_REQUEST['list']);
	  }
    }else{
        $auctionItems = $objAuction->fetchSearchLiveAuctions_upcoming($poster_ids);
		$auctionWeekObj = new AuctionWeek();
	    $aucetionWeeks = $auctionWeekObj->fetchUpcomingWeeksWithItem();
        $smarty->assign('UpcomingAuctionWeeks', $aucetionWeeks);
    }
	if($_REQUEST['genre_id']!=''){
			$objCategory = new Category();
			$cat_value = $objCategory->selectCategoryName($_REQUEST['genre_id']);
			$smarty->assign('cat_value', $cat_value);
	  }elseif($_REQUEST['poster_size_id']!=''){
			$objCategory = new Category();
			$cat_value = $objCategory->selectCategoryName($_REQUEST['poster_size_id']);
			$smarty->assign('cat_value', $cat_value);
			
	  }elseif($_REQUEST['country_id']!=''){
			$objCategory = new Category();
			$cat_value = $objCategory->selectCategoryName($_REQUEST['country_id']);
			$smarty->assign('cat_value', $cat_value);
	  }elseif($_REQUEST['decade_id']!=''){
			$objCategory = new Category();
			$cat_value = $objCategory->selectCategoryName($_REQUEST['decade_id']);
			$smarty->assign('cat_value', $cat_value);
	  }
	//$posterObj = new Poster();
	//$posterObj->fetchPosterCategories($auctionItems);
	//$posterObj->fetchPosterImages($auctionItems);
	
	//$watchObj = new Watch();
	//$watchObj->checkWatchlist($auctionItems);
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
	$smarty->assign('total', $total);
	$smarty->assign('is_expired', $_REQUEST['is_expired']);
	
	for($i=0;$i<count($auctionItems);$i++){           
		if(isset($_SESSION['sessAuctionView']) && $_SESSION['sessAuctionView']=='list'){
			$auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
			$auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];                    
		}else{
			$auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
		}           
        
		if($auctionItems[$i]['fk_auction_type_id'] != 1){		
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
		}
	}
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));

	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
	

    if($_SESSION['sessAuctionView'] == 'list'){
        if($list == 'upcoming'){
            $smarty->display("upcoming_buy_list.tpl");
        }else{
            $smarty->display("buy_list.tpl");
        }

    }else{
        if($list == 'upcoming'){
            $smarty->display("upcoming_buy_grid.tpl");
        }else{
            $smarty->display("buy_grid.tpl");
        }

    }
}



function displayKeySearch()
{

	require_once INCLUDE_PATH."lib/common.php";
    $valueNew='';
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
    if(isset($_REQUEST['search_type'])){

    }else{
        $_REQUEST['search_type']='';
    }
	if(isset($_REQUEST['auction_week_id'])){
        $auction_week_id = $_REQUEST['auction_week_id'];
    }else{
        $auction_week_id ='';
    }
	$list = $_REQUEST['list'];
	$smarty->assign('cat_value', $_REQUEST['keyword']);
    if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }
	$objAuction = new Auction();
	##########################    Overlapping New Add  ##########################
		$auctionWeekObj = new AuctionWeek();
		$objAuction = new Auction();
	    $auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
		if($auctionWeeks >= 1){
			$smarty->assign('live_count', $auctionWeeks);
			$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
			//echo "<pre>".print_r($auctionWeeksData)."</pre>";
			$smarty->assign('auctionWeeksData', $auctionWeeksData);
		}
		if($auctionWeeks == 1 || $auctionWeeks == 0){
			$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
			$smarty->assign('upcomingTotal', $upcomingTotal);
			$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
			$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
		}
		$extended = $objAuction->getExtendedAuction();
		$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
	
	 
    if($_REQUEST['is_expired']=='1'){
	    $total_row[] = $objAuction->countKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type']);		
	}elseif($_REQUEST['is_expired_stills']=='1'){
		if($_REQUEST['search_type']=='stills'){
				$search_type='title';
			}
			if($_REQUEST['search_type']=='stills_desc'){
				$search_type='title_desc';
			}
	    $total_row[] = $objAuction->countKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$search_type);		
	}else{
	   if($list=='stills' || $_REQUEST['search_type']=='stills' || $_REQUEST['search_type']=='stills_desc'){
			$totalUpcoming = $objAuction->countUpcomingStillsAuctionsByStatus();
			$totalLiveStiils = $objAuction->countLiveStillsAuctionsByStatus();
				if($totalUpcoming>=1 && $totalLiveStiils<1){
				header("location: ".PHP_SELF."?list=stills&mode=key_search_upcoming&keyword=".$_REQUEST['keyword']."&search_type=".$_REQUEST['search_type']);
				exit;
			}else{
				//header("location: ".PHP_SELF."?list=stills&mode=key_search_stills&keyword=".$_REQUEST['keyword']."&search_type=".$_REQUEST['search_type']);
				//exit;
				$total_row[] = $objAuction->countKeySearchLiveAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$auction_week_id);
			}
		}else{
			$total_row[] = $objAuction->countKeySearchLiveAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$auction_week_id);
		 }
	}
	
	$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	
    if(!empty($total_row[0])){
    $total = count($total_row[0]);
    if(!empty($total_row[0])){
        foreach($total_row as $key=>$val){
            foreach($val as $key=>$value){
                $valueNew .= $value.',';
            }
        }
    }

    $arrayList=substr($valueNew,0,(strLen($valueNew)-1));
    if($_REQUEST['is_expired']=='1'){
		$auctionItems = $objAuction->fetchKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$arrayList,$_SESSION['sessAuctionView']);
		$smarty->assign('is_expired', 1);
		
	}elseif($_REQUEST['is_expired_stills']=='1'){
		$auctionItems = $objAuction->fetchKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$arrayList,$_SESSION['sessAuctionView']);
		$smarty->assign('is_expired', $_REQUEST['is_expired']);
		$smarty->assign('is_expired_stills', $_REQUEST['is_expired_stills']);
	}else{
		$auctionItems = $objAuction->fetchKeySearchLiveAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$arrayList,$_SESSION['sessAuctionView'],$auction_week_id);
		$smarty->assign('is_expired', 0);
	}
	

    //$posterObj = new Poster();
	//$posterObj->fetchPosterCategories($auctionItems);
	//$posterObj->fetchPosterImages($auctionItems);
	
	//$watchObj = new Watch();
	//$watchObj->checkWatchlist($auctionItems);
	$smarty->assign('total', $total);
	
	for($i=0;$i<count($auctionItems);$i++){
        /*if($list!='weekly'){*/
            if ($auctionItems[$i]['is_cloud']=='1'){
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }else{
					$auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }
            }else{
                if($_SESSION['sessAuctionView']=='list'){
					$auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy/".$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }
            }
       /* }else{
            if($_SESSION['sessAuctionView']=='list'){
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }else{
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }
        }*/
		if($auctionItems[$i]['fk_auction_type_id'] != 1){	
			/*$endDateTime = splitDateTime($auctionItems[$i]['auction_actual_end_datetime']);
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
			
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
		}
	}
	
	
		
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));

	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }else{
        $smarty->assign('total', 0);
    }
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
	if($_SESSION['sessAuctionView'] == 'list'){
        $smarty->display("buy_list.tpl");
	}else{
        $smarty->display("buy_grid.tpl");
	}
}

function displayKeySearchGlobal()
{

	require_once INCLUDE_PATH."lib/common.php";
    $valueNew='';
	$valueAuction='';
	$total='';
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
    if(isset($_REQUEST['search_type'])){

    }else{
        $_REQUEST['search_type']='';
    }
	if(isset($_REQUEST['auction_week_id'])){
        $auction_week_id = $_REQUEST['auction_week_id'];
    }else{
        $auction_week_id ='';
    }
	$list = $_REQUEST['list'];
	$smarty->assign('cat_value', $_REQUEST['keyword']);
    if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }
	$objAuction = new Auction();
	##########################    Overlapping New Add  ##########################
		$auctionWeekObj = new AuctionWeek();
		$objAuction = new Auction();
	    $auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
		if($auctionWeeks >= 1){
			$smarty->assign('live_count', $auctionWeeks);
			$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
			//echo "<pre>".print_r($auctionWeeksData)."</pre>";
			$smarty->assign('auctionWeeksData', $auctionWeeksData);
		}
		if($auctionWeeks == 1 || $auctionWeeks == 0){
			$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
			$smarty->assign('upcomingTotal', $upcomingTotal);
			$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
			$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
		}
		$extended = $objAuction->getExtendedAuction();
		$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
	
	 
    
	$total_row[] = $objAuction->countKeySearchLiveAuctionsGlobal(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$auction_week_id);
			
	
	$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	
    if(!empty($total_row[0]['others']) || !empty($total_row[0]['auction'])){
		if(!empty($total_row[0]['others'])){
			$total = $total + count($total_row[0]['others']);
			foreach($total_row[0]['others'] as $key=>$val){            
					$valueNew .= $val.',';            
			}
		}
		
		if(!empty($total_row[0]['auction'])){
			$total = $total + count($total_row[0]['auction']);
			foreach($total_row[0]['auction'] as $key=>$val){            
					$valueAuction .= $val.',';            
			}
		}
	
    $arrayList=substr($valueNew,0,(strLen($valueNew)-1));
	
	$arrayListAuction=substr($valueAuction,0,(strLen($valueAuction)-1));
    
	$auctionItemsOthers = $objAuction->fetchKeySearchLiveAuctionsGlobals('fixed',$arrayList,$_SESSION['sessAuctionView']);
	$auctionItemsAuction = $objAuction->fetchKeySearchLiveAuctionsGlobals('weekly',$arrayListAuction,$_SESSION['sessAuctionView']);
	if(!empty($auctionItemsOthers) && !empty($auctionItemsAuction)){
		$auctionItems = array_merge($auctionItemsOthers,$auctionItemsAuction);
	}else if(empty($auctionItemsOthers)){
		$auctionItems = $auctionItemsAuction;
	}else if(empty($auctionItemsAuction)){
		$auctionItems = $auctionItemsOthers;
	}
	$smarty->assign('is_expired', 0);
	

	$smarty->assign('total', $total);
	
	for($i=0;$i<count($auctionItems);$i++){
        /*if($list!='weekly'){*/
            if ($auctionItems[$i]['is_cloud']=='1'){
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }else{
					$auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }
            }else{
                if($_SESSION['sessAuctionView']=='list'){
					$auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy/".$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }
            }
       
		if($auctionItems[$i]['fk_auction_type_id'] != 1){	
			/*$endDateTime = splitDateTime($auctionItems[$i]['auction_actual_end_datetime']);
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
			
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
		}
	}
	
	
		
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));

	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }else{
        $smarty->assign('total', 0);
    }
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
	if($_SESSION['sessAuctionView'] == 'list'){
        $smarty->display("buy_list.tpl");
	}else{
        $smarty->display("buy_grid.tpl");
	}
}

function displayKeySearch_upcoming(){
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
	$list = $_REQUEST['list'];
	if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }
	if($_REQUEST['list']=='stills'){
		if($_REQUEST['search_type']=='stills'){
			 $search_type='title';
		}
		if($_REQUEST['search_type']=='stills_desc'){
			$search_type='title_desc';
		}
	}else{
			$search_type=$_REQUEST['search_type'];
	}
	##########################    Overlapping New Add  ##########################
	$auctionWeekObj = new AuctionWeek();
	$objAuction = new Auction();
	$auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
	if($auctionWeeks >= 1){
		$smarty->assign('live_count', $auctionWeeks);
		$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
		//echo "<pre>".print_r($auctionWeeksData)."</pre>";
		$smarty->assign('auctionWeeksData', $auctionWeeksData);
	}
	if($auctionWeeks == 1 || $auctionWeeks == 0){
		$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
		$smarty->assign('upcomingTotal', $upcomingTotal);
		$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
		$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
	}
	$extended = $objAuction->getExtendedAuction();
	$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
	
	 
	$total_row[] = $objAuction->countAuctionsByStatus_upcoming(trim($_REQUEST['keyword']),$search_type,$_REQUEST['auction_week'],$_REQUEST['list']);
	if(!empty($total_row[0])){
	$total = count($total_row[0]);
    if(!empty($total_row[0])){
        foreach($total_row as $key=>$val){
            foreach($val as $key=>$value){
                $valueNew .= $value.',';
            }
        }
    }

    $arrayList=substr($valueNew,0,(strLen($valueNew)-1));
	
	$auctionItems = $objAuction->fetchAuctionsByStatus_upcoming(trim($_REQUEST['keyword']),'',$arrayList,$search_type);
	}else{
	  $smarty->assign('total', 0);
	}
	//$posterObj = new Poster();
	//$posterObj->fetchPosterCategories($auctionItems);
	//$posterObj->fetchPosterImages($auctionItems);
	
	//$watchObj = new Watch();
	//$watchObj->checkWatchlist($auctionItems);
	$smarty->assign('total', $total);
	
	$auctionWeekObj = new AuctionWeek();
	$aucetionWeeks = $auctionWeekObj->fetchUpcomingWeeksWithItem();
    $smarty->assign('UpcomingAuctionWeeks', $aucetionWeeks);
	
	for($i=0;$i<count($auctionItems);$i++){
        /*if($list!='weekly'){*/
            if (file_exists("poster_photo/".$auctionItems[$i]['poster_thumb'])){
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy/".$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }
            }else{
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }
            }
        /*}else{
            if($_SESSION['sessAuctionView']=='list'){
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }else{
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }
        }*/
		if($auctionItems[$i]['fk_auction_type_id'] != 1){	
			/*$endDateTime = splitDateTime($auctionItems[$i]['auction_actual_end_datetime']);
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
			
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
		}
	}
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));

	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
	
	
    $totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
    if($_SESSION['sessAuctionView'] == 'list'){
        $smarty->display("upcoming_buy_list.tpl");
    }else{
        $smarty->display("upcoming_buy_grid.tpl");
    }

}

function displayRefineSearch()
{
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
	$obj = new Category();
	$catRows = $obj->selectDataCategory(TBL_CATEGORY, array('*'));
	$smarty->assign('catRows', $catRows);
	
	$smarty->display("refinesrc_criteria.tpl");
}

function displayDoRefineSearch()
{
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
    if(isset($_REQUEST['list'])){
		$_REQUEST['list'] =$_REQUEST['poster_type'];
    }else{
        $_REQUEST['list']='';
    }
	if(isset($_REQUEST['auction_week_id'])){
        $auction_week_id = $_REQUEST['auction_week_id'];
    }else{
        $auction_week_id ='';
    }
	
    if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }	
	##########################    Overlapping New Add  ##########################
	$auctionWeekObj = new AuctionWeek();
	$objAuction = new Auction();
	$auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
	if($auctionWeeks >= 1){
		$smarty->assign('live_count', $auctionWeeks);
		$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
		//echo "<pre>".print_r($auctionWeeksData)."</pre>";
		$smarty->assign('auctionWeeksData', $auctionWeeksData);
	}
	if($auctionWeeks == 1 || $auctionWeeks == 0){
		$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
		$smarty->assign('upcomingTotal', $upcomingTotal);
		$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
		$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
	}
	$extended = $objAuction->getExtendedAuction();
	$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
    $poster_ids = $objAuction->searchPosterIds($_REQUEST['poster_type'],$auction_week_id);
	
    $total = $objAuction->countSearchLiveAuctions($poster_ids);
    $auctionItems = $objAuction->fetchSearchLiveAuctions($poster_ids,$_SESSION['sessAuctionView'],$_REQUEST['poster_type']);
	
	$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
	
	$smarty->assign('total', $total);
	
	for($i=0;$i<count($auctionItems);$i++){
        /*if($_REQUEST['list']!='weekly'){*/
            if (file_exists("poster_photo/".$auctionItems[$i]['poster_thumb'])){
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy/".$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }
            }else{
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }
            }
        /*}else{
            if($_SESSION['sessAuctionView']=='list'){
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }else{
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }
        }*/
		if($auctionItems[$i]['fk_auction_type_id'] != 1){	
			/*$endDateTime = splitDateTime($auctionItems[$i]['auction_actual_end_datetime']);
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
			
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
		}
	}
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));

	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
	$smarty->assign('is_expired', 0);

    if($_SESSION['sessAuctionView'] == 'list'){
        $smarty->display("buy_list.tpl");
    }else{
        $smarty->display("buy_grid.tpl");
    }
}

function select_watchlist()
{
	$flag = 1;
	if(!isset($_REQUEST['offset'])){
		$offset=0;
	}else{
		$offset=$_REQUEST['offset'];
	}
	if(isset($_REQUEST['toshow']) && $_REQUEST['toshow']<1){
		//$toshow=0;
	}else{
		$toshow=$_REQUEST['toshow'];
	}
	if(isset($_REQUEST['order_by']) && $_REQUEST['order_by']!=''){
		$order_by = $_REQUEST['order_by'];
	}else{
		$order_by = '';
	}
	if(isset($_REQUEST['order_type']) && $_REQUEST['order_type']!=''){
		$order_type = $_REQUEST['order_type'];
	}else{
		$order_type='';
	}
	if(isset($_REQUEST['auction_week_id']) && $_REQUEST['auction_week_id']!=''){
		$auction_week_id = $_REQUEST['auction_week_id'];
	}else{
		$auction_week_id='';
	}
	if($_SESSION['sessUserID']!=''){
		if(count($_REQUEST['auction_ids']) >0 && $_REQUEST['is_track']==''){
			foreach($_REQUEST['auction_ids'] as $val){
				$obj = new DBCommon();
				$obj->primaryKey = 'watching_id';
				$where = array('user_id' => $_SESSION['sessUserID'], "auction_id" => $val);
				$count=$obj->countData(TBL_WATCHING,$where);
				if($count < 1){
					$Data = array("auction_id" => $val, "user_id" => $_SESSION['sessUserID'],"add_date"=>date('Y-m-d'));
					$chk=$obj->updateData(TBL_WATCHING,$Data,false);
					if($chk==true){
						$_SESSION['Err']="All items are added to your watchlist.";
					}else{
						$_SESSION['Err'] .="All items are not added to your watchlist.";
					}
				}else{
					$_SESSION['Err']="Items are already added to your watchlist.";
				}
			}
		}elseif($_REQUEST['is_track']!=''){
			$obj = new DBCommon();
			$obj->primaryKey = 'watching_id';
			$where = array('user_id' => $_SESSION['sessUserID'], "auction_id" => $_REQUEST['is_track']);
			$count=$obj->countData(TBL_WATCHING,$where);
			if($count < 1){
				$Data = array("auction_id" => $_REQUEST['is_track'], "user_id" => $_SESSION['sessUserID'],"add_date"=>date('Y-m-d'));
				$chk=$obj->updateData(TBL_WATCHING,$Data,false);
				if($chk==true){
					$_SESSION['Err']="Item is added to your watchlist.";
				}else{
					$_SESSION['Err'] .="Item is not added to your watchlist.";
				}
			}else{
				$_SESSION['Err']="Item is already added to your watchlist.";
			}
		}else{
			$_SESSION['Err']="Please select atleast one item to add to your watchlist.";
			header("location: ".PHP_SELF."?list=".$_REQUEST['list']."&offset=".$offset."&toshow=".$toshow);
			exit;	
		}
	}else{
		$_SESSION['Err']="Please login to add to your watch list";
		header("location: ".PHP_SELF."?list=".$_REQUEST['list']."&offset=".$offset."&toshow=".$toshow);
		exit;
	}
	header("location: ".PHP_SELF."?list=".$_REQUEST['list']."&offset=".$offset."&toshow=".$toshow."&order_by=".$order_by."&order_type=".$order_type."&auction_week_id=".$auction_week_id);
	exit;
}
function poster_details()
{
	require_once INCLUDE_PATH."lib/common.php";
if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
	extract($_REQUEST);
	##########################    Overlapping New Add  ##########################
		$auctionWeekObj = new AuctionWeek();
		$objAuction = new Auction();
	    $auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
		if($auctionWeeks >= 1){
			$smarty->assign('live_count', $auctionWeeks);
			$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
			//echo "<pre>".print_r($auctionWeeksData)."</pre>";
			$smarty->assign('auctionWeeksData', $auctionWeeksData);
		}
		if($auctionWeeks == 1 || $auctionWeeks == 0){
			$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
			$smarty->assign('upcomingTotal', $upcomingTotal);
			$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
			$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
		}
		$extended = $objAuction->getExtendedAuction();
		$smarty->assign('extendedAuction', $extended);
	    ##########################    Overlapping New Add  ##########################
		
	if(isset($_REQUEST['fixed']) && $_REQUEST['fixed']==1){
		$auctionDetails=$objAuction->select_details_auction($auction_id,1);
	}elseif(isset($_REQUEST['extended']) && $_REQUEST['extended']=="true") {
		$auctionDetails=$objAuction->select_details_auction($auction_id,'',1);
	}else{
		$auctionDetails=$objAuction->select_details_auction($auction_id);
	}
	
	 
	$auctionDetails[0]['poster_desc']=strip_slashes($auctionDetails[0]['poster_desc']);
	if($auctionDetails[0]['auction_is_sold']=='1' || $auctionDetails[0]['auction_is_sold']=='2'){
		$auctionDetails[0]['is_selling']=0;
	}
    if ($auctionDetails[0]['is_cloud']==0){
        list($width, $height, $type, $attr) = @getimagesize("poster_photo/".$auctionDetails[0]['poster_thumb']);
        $smarty->assign('width', $width);
        $smarty->assign('height', $height);
        $auctionDetails[0]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionDetails[0]['poster_thumb'];
        $auctionDetails[0]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/".$auctionDetails[0]['poster_thumb'];
    }else{
        list($width, $height, $type, $attr) = @getimagesize(CLOUD_POSTER.$auctionDetails[0]['poster_thumb']);
        $smarty->assign('width', $width);
        $smarty->assign('height', $height);
        $auctionDetails[0]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionDetails[0]['poster_thumb'];
        $auctionDetails[0]['large_image']=CLOUD_POSTER.$auctionDetails[0]['poster_thumb'];
    }
	if($auctionDetails[0]['auction_is_approved']=='1'){
		if($auctionDetails[0]['fk_auction_type_id'] == 1){
			$smarty->assign('itemType', 'Fixed');
		}elseif($auctionDetails[0]['fk_auction_type_id'] == 2){
			$smarty->assign('itemType', 'Weekly');
		}elseif($auctionDetails[0]['fk_auction_type_id'] == 5){
			$smarty->assign('itemType', 'Stills');
		}
		
	
	if($auctionDetails[0]['fk_auction_type_id'] == 1){
		$offerObj = new Offer();		
		$offerObj->fetch_OfferCount_MaxOffer($auctionDetails);
	}else{
		//echo "hiii";
		//$bidObj = new Bid();
		//$bidObj->fetch_BidCount_MaxBid($auctionDetails);
	}
	if($auctionDetails[0]['auction_is_sold'] == '2'){
		$objAuction->fetchWinnerAndSoldPrice($auctionDetails);
	}elseif($auctionDetails[0]['auction_is_sold'] == '1' && $auctionDetails[0]['fk_auction_type_id'] == 1){
		$objAuction->fetchWinnerAndSoldPrice($auctionDetails);
	}
	
	if($auctionDetails[0]['fk_auction_type_id'] != 1 && $auctionDetails[0]['is_upcoming'] != 1){	
		/*$endDateTime = splitDateTime($auctionDetails[0]['auction_actual_end_datetime']);
		$auctionDetails[0]['auction_countdown'] = '<span id="cd_'.$auctionDetails[0]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionDetails[0]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
		
		$auctionDetails[0]['auction_countdown'] = '<span id="cd_'.$auctionDetails[0]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionDetails[0]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionDetails[0]['seconds_left'].', new Date())});</script></span>';
	}elseif($auctionDetails[0]['fk_auction_type_id'] != 1 && $auctionDetails[0]['is_upcoming'] != 0){
		$auctionDetails[0]['auction_countdown'] = '<span id="cd_'.$auctionDetails[0]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionDetails[0]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionDetails[0]['seconds_left_to_start'].', new Date())});</script></span>';	
	}
	
	//echo "<pre>";print_r($auctionDetails);
	}else{
		
		$smarty->assign('auction_key_approved', '0');
	}
	$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
	$smarty->assign('auctionDetails', $auctionDetails);
	$smarty->assign('json_arr', json_encode($auctionDetails));
	if($auctionDetails[0]['total_poster']>1){
		if($auctionDetails[0]['auction_is_sold']=='0' && $auctionDetails[0]['fk_auction_type_id']==2){
			$itemImageArry=$objAuction->fetchTotalPostersForItem($auctionDetails[0]['poster_id'],'weekly');
		}else{
			$itemImageArry=$objAuction->fetchTotalPostersForItem($auctionDetails[0]['poster_id'],'');
		}
		for($i=0;$i<count($itemImageArry);$i++){        
            if ($itemImageArry[$i]['is_cloud']!='1'){                
               $itemImageArry[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumbnail/".$itemImageArry[$i]['poster_image'];  
			   $itemImageArry[$i]['big_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/".$itemImageArry[$i]['poster_image'];                 
            }else{
               $itemImageArry[$i]['image_path']=CLOUD_POSTER_THUMB.$itemImageArry[$i]['poster_image'];
			   $itemImageArry[$i]['big_image']=CLOUD_POSTER.$itemImageArry[$i]['poster_image'];
            }
		  }
		$smarty->assign('itemImageArry', $itemImageArry);
		
	}
	if($auctionDetails[0]['is_upcoming'] == 1){
		$smarty->display("upcoming_poster_details.tpl");
	}else{
		$smarty->display("poster_details.tpl");
	}
}
function displayRefineSearchStills()
{
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
	$obj = new Category();	
	$catRows = $obj->selectDataCategoryStills(TBL_CATEGORY, array('*'));
	$smarty->assign('catRows', $catRows);
	
	$smarty->display("refinesrc_criteria_stills.tpl");
}
function displayDoRefineSearchStills()
{
	require_once INCLUDE_PATH."lib/common.php";
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
    if(isset($_REQUEST['list'])){

    }else{
        $_REQUEST['list']='';
    }

    if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }
	##########################    Overlapping New Add  ##########################
		$auctionWeekObj = new AuctionWeek();
		$objAuction = new Auction();
	    $auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
		if($auctionWeeks >= 1){
			$smarty->assign('live_count', $auctionWeeks);
			$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
			//echo "<pre>".print_r($auctionWeeksData)."</pre>";
			$smarty->assign('auctionWeeksData', $auctionWeeksData);
		}
		if($auctionWeeks == 1 || $auctionWeeks == 0){
			$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
			$smarty->assign('upcomingTotal', $upcomingTotal);
			$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
			$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
		}
		$extended = $objAuction->getExtendedAuction();
		$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
	 
	$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);	
	//$objAuction->orderType = "ASC";
    $poster_ids = $objAuction->searchPosterIds('stills');
    $total = $objAuction->countSearchLiveAuctions($poster_ids);
    $auctionItems = $objAuction->fetchSearchLiveAuctions($poster_ids,$_SESSION['sessAuctionView']);
	

	$smarty->assign('total', $total);
	
	for($i=0;$i<count($auctionItems);$i++){
        if($_REQUEST['list']!='weekly'){
            if (file_exists("poster_photo/".$auctionItems[$i]['poster_thumb'])){
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy/".$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }
            }else{
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }
            }
        }else{
            if($_SESSION['sessAuctionView']=='list'){
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }else{
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }
        }
		if($auctionItems[$i]['fk_auction_type_id'] != 1){	
			/*$endDateTime = splitDateTime($auctionItems[$i]['auction_actual_end_datetime']);
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
			
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
		}
	}
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));

	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
	$totalStillsLive = $objAuction->countLiveWeeklyAuctionsForStills();
	if($totalStillsLive >=1){
		$smarty->assign('is_expired_stills', 0);
		$smarty->assign('is_expired', 0);
	}else{
		$smarty->assign('is_expired_stills', 1);
		$smarty->assign('is_expired', 1);
	}
	
	$objCategory = new Category();
	$cat_value = $objCategory->selectCategoryName($_REQUEST['genre_id']);
	$smarty->assign('cat_value', $cat_value);
	
    if($_SESSION['sessAuctionView'] == 'list'){
        $smarty->display("buy_list.tpl");
    }else{
        $smarty->display("buy_grid.tpl");
    }
}
function key_search_stills(){
 		

	require_once INCLUDE_PATH."lib/common.php";
    $valueNew='';
	if(isset($_SESSION['sessUserID'])){
		$smarty->assign('user_id', $_SESSION['sessUserID']);
	}else{
		$smarty->assign('user_id', 0);	
	}
    if(isset($_REQUEST['search_type'])){

    }else{
        $_REQUEST['search_type']='';
    }
	if(isset($_REQUEST['auction_week_id'])){
        $auction_week_id = $_REQUEST['auction_week_id'];
    }else{
        $auction_week_id ='';
    }
	$list = $_REQUEST['list'];
	$smarty->assign('cat_value', $_REQUEST['keyword']);
    if(isset($_REQUEST['view_mode']) && $_REQUEST['view_mode'] != "" && $_REQUEST['view_mode'] != $_SESSION['sessAuctionView']){
        $_SESSION['sessAuctionView'] = $_REQUEST['view_mode'];
    }
	##########################    Overlapping New Add  ##########################
		$auctionWeekObj = new AuctionWeek();
		$objAuction = new Auction();
	    $auctionWeeks = $auctionWeekObj->countLiveAuctionWeekRunning();
		if($auctionWeeks >= 1){
			$smarty->assign('live_count', $auctionWeeks);
			$auctionWeeksData = $auctionWeekObj->fetchLiveAuctionNames();
			//echo "<pre>".print_r($auctionWeeksData)."</pre>";
			$smarty->assign('auctionWeeksData', $auctionWeeksData);
		}
		if($auctionWeeks == 1 || $auctionWeeks == 0){
			$upcomingTotal = $objAuction->countAuctionsForUpcomingNow();
			$smarty->assign('upcomingTotal', $upcomingTotal);
			$latestEndedAuction = $auctionWeekObj->latestEndedAuctions();
			$smarty->assign('latestEndedAuction', $latestEndedAuction[0]["auction_week_title"]);
		}
		$extended = $objAuction->getExtendedAuction();
		$smarty->assign('extendedAuction', $extended);
	##########################    Overlapping New Add  ##########################
	
	
	 
    if($_REQUEST['is_expired']=='1'){
	    $total_row[] = $objAuction->countKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type']);		
	}elseif($_REQUEST['is_expired_stills']=='1'){
	    $total_row[] = $objAuction->countKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type']);		
	}else{
	   if($list=='stills' || ($_REQUEST['search_type']=='stills' || $_REQUEST['search_type']=='stills_desc')){
	   		if($_REQUEST['search_type']=='stills'){
				$search_type='title';
			}
			if($_REQUEST['search_type']=='stills_desc'){
				$search_type='title_desc';
			}
			$totalUpcoming = $objAuction->countUpcomingStillsAuctionsByStatus();
			$totalLiveStiils = $objAuction->countLiveStillsAuctionsByStatus();
				if($totalUpcoming>=1 && $totalLiveStiils<1){
				header("location: ".PHP_SELF."?list=stills&mode=key_search_upcoming&keyword=".$_REQUEST['keyword']."&search_type=".$_REQUEST['search_type']);
				exit;
			}elseif($totalUpcoming<1 && $totalLiveStiils<1){
				$total_row[] = $objAuction->countKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$search_type);	
				$_REQUEST['is_expired_stills']=1;
			}
			else{
				$total_row[] = $objAuction->countKeySearchLiveAuctions(trim($_REQUEST['keyword']),$list,$search_type,$auction_week_id);
			}
		}else{
			$total_row[] = $objAuction->countKeySearchLiveAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$auction_week_id);
		 }
	}
	
	$totalLiveWeekly = $objAuction->countLiveWeeklyAuctions();
	
    if(!empty($total_row[0])){
    $total = count($total_row[0]);
    if(!empty($total_row[0])){
        foreach($total_row as $key=>$val){
            foreach($val as $key=>$value){
                $valueNew .= $value.',';
            }
        }
    }

    $arrayList=substr($valueNew,0,(strLen($valueNew)-1));
    if($_REQUEST['is_expired']=='1'){
		$auctionItems = $objAuction->fetchKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$_REQUEST['search_type'],$arrayList,$_SESSION['sessAuctionView']);
		$smarty->assign('is_expired', 1);
		
	}elseif($_REQUEST['is_expired_stills']=='1'){
		$auctionItems = $objAuction->fetchKeySearchExpiredAuctions(trim($_REQUEST['keyword']),$list,$search_type,$arrayList,$_SESSION['sessAuctionView']);
		$smarty->assign('is_expired', $_REQUEST['is_expired']);
		$smarty->assign('is_expired_stills', $_REQUEST['is_expired_stills']);
	}else{
		$auctionItems = $objAuction->fetchKeySearchLiveAuctions(trim($_REQUEST['keyword']),$list,$search_type,$arrayList,$_SESSION['sessAuctionView'],$auction_week_id);
		$smarty->assign('is_expired', 0);
	}
	

    //$posterObj = new Poster();
	//$posterObj->fetchPosterCategories($auctionItems);
	//$posterObj->fetchPosterImages($auctionItems);
	
	//$watchObj = new Watch();
	//$watchObj->checkWatchlist($auctionItems);
	$smarty->assign('total', $total);
	
	for($i=0;$i<count($auctionItems);$i++){
        /*if($list!='weekly'){*/
            if (file_exists("poster_photo/".$auctionItems[$i]['poster_thumb'])){
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy/".$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']="http://".$_SERVER['HTTP_HOST']."/poster_photo/thumb_buy_gallery/".$auctionItems[$i]['poster_thumb'];
                }
            }else{
                if($_SESSION['sessAuctionView']=='list'){
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                    $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }else{
                    $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
                }
            }
       /* }else{
            if($_SESSION['sessAuctionView']=='list'){
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY.$auctionItems[$i]['poster_thumb'];
                $auctionItems[$i]['large_image']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }else{
                $auctionItems[$i]['image_path']=CLOUD_POSTER_THUMB_BUY_GALLERY.$auctionItems[$i]['poster_thumb'];
            }
        }*/
		if($auctionItems[$i]['fk_auction_type_id'] != 1){	
			/*$endDateTime = splitDateTime($auctionItems[$i]['auction_actual_end_datetime']);
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: new Date('.$endDateTime['year'].', '.($endDateTime['month'] - 1).', '.$endDateTime['date'].', '.$endDateTime['hour'].', '.$endDateTime['minute'].', '.$endDateTime['second'].'), serverSync: function(){return new Date(\''.date("M j, Y H:i:s O").'\')}});</script></span>';*/
			
			$auctionItems[$i]['auction_countdown'] = '<span id="cd_'.$auctionItems[$i]['auction_id'].'"><script language="javascript">$("#cd_'.$auctionItems[$i]['auction_id'].'").countdown({until: dateAdd(\'s\', '.$auctionItems[$i]['seconds_left'].', new Date())});</script></span>';
		}
	}
	
	
		
	
	$smarty->assign('auctionItems', $auctionItems);
	$smarty->assign('json_arr', json_encode($auctionItems));

	$smarty->assign('displayCounterTXT', displayCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $message="", $start=33, $end=99, $step=33, $use=1));
	$smarty->assign('pageCounterTXT', pageCounter($total, $GLOBALS['offset'], $GLOBALS['toshow'], "headertext", $groupby=10, $showcounter=1, $linkStyle='view_link', $redText='headertext'));
	$smarty->assign('displaySortByTXT', displaySortBy("headertext"));
    }else{
        $smarty->assign('total', 0);
    }
	$smarty->assign('totalLiveWeekly', $totalLiveWeekly);
	if($_SESSION['sessAuctionView'] == 'list'){
        $smarty->display("buy_list.tpl");
	}else{
        $smarty->display("buy_grid.tpl");
	}

 }
 
 function return_react_json(){
 	require_once INCLUDE_PATH."lib/common.php";
	$objAuction = new Auction();
	$data = $objAuction->reactUpdateJson($_REQUEST['offset'],$_REQUEST['toshow']);
	$json_arr = json_encode($data);
	echo $json_arr;
 }
 mysqli_close($GLOBALS['db_connect']);
?>