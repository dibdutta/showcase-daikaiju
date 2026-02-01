<?php
/* Smarty version 3.1.47, created on 2026-01-28 09:22:41
  from '/var/www/html/templates/buy_grid.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_697a1bb1470607_87724984',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f5bccdc0cffd41a870f1a51514a14a74c786042e' => 
    array (
      0 => '/var/www/html/templates/buy_grid.tpl',
      1 => 1769443627,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:search-login.tpl' => 1,
    'file:right-panel.tpl' => 1,
    'file:foot.tpl' => 1,
  ),
),false)) {
function content_697a1bb1470607_87724984 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<link href="https://d2m46dmzqzklm5.cloudfront.net/css/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<?php echo '<script'; ?>
 type="text/javascript" src="https://d2m46dmzqzklm5.cloudfront.net/js/jquery.countdown.js"><?php echo '</script'; ?>
>


<style type="text/css">.popDiv { position:absolute; min-width:120px; list-style-type:none; background-color:#881318; color:#fff; z-index:1000;font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; margin-left:150px; margin-top:45px;visibility:hidden;}
.popDiv_Auction { position:absolute; min-width:120px; list-style-type:none; background-color:#881318 ;color:white; z-index:1000;font-size:12px; padding:6px; outline:4px solid #881318; border: 1px solid #a3595c; margin-left:150px; margin-top:45px;visibility:hidden;}

#track-btn-id:hover {
	background-image: url(https://c4808190.ssl.cf2.rackcdn.com/watchthisitem_btn.png);
}

</style>



<div id="forinnerpage-container">

	<div id="wrapper">
    <!--Header themepanel Starts-->
    <div id="headerthemepanel">
	<!--Header Theme Starts-->
      <?php $_smarty_tpl->_subTemplateRender("file:search-login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?> 
	<!--Header Theme Ends-->
    </div>
    <!--Header themepanel Ends-->
    
    <!-- page listing starts -->

		<div id="inner-container">
        	<?php $_smarty_tpl->_subTemplateRender("file:right-panel.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
            <div id="center"><div id="squeeze"><div class="right-corner">
            
			<div id="inner-left-container">
            
            <div id="tabbed-inner-nav">
				<div class="tabbed-inner-nav-left">
					<ul class="menu">
												<li <?php if ($_REQUEST['list'] == 'fixed') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=fixed"><span>Poster Shop</span></a></li>
						<?php if ($_smarty_tpl->tpl_vars['live_count']->value <= 1) {?>
                    	<li <?php if ($_REQUEST['list'] == 'weekly' && $_REQUEST['track_is_expired'] != '1') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=weekly"><span><?php if ($_smarty_tpl->tpl_vars['totalLiveWeekly']->value > 0) {
echo $_smarty_tpl->tpl_vars['auctionWeeksData']->value[0]['auction_week_title'];
} else {
echo $_smarty_tpl->tpl_vars['latestEndedAuction']->value;?>
 Results<?php }?></span></a></li>
                    	                    	<?php if ($_smarty_tpl->tpl_vars['upcomingTotal']->value > 0) {?>
                    		<li <?php if ($_REQUEST['list'] == 'upcoming') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=upcoming"><span>Upcoming Auction(s)</span></a></li>
						<?php } else { ?>
							<li <?php if ($_REQUEST['track_is_expired'] == '1') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=weekly&track_is_expired=1"><span> <?php echo $_smarty_tpl->tpl_vars['latestEndedAuction']->value;?>
 Results</span></a></li>
						<?php }?>
						<?php } elseif ($_smarty_tpl->tpl_vars['live_count']->value > 1) {?>
							<li <?php if ($_REQUEST['auction_week_id'] == $_smarty_tpl->tpl_vars['auctionWeeksData']->value[0]['auction_week_id']) {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=weekly&auction_week_id=<?php echo $_smarty_tpl->tpl_vars['auctionWeeksData']->value[0]['auction_week_id'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['auctionWeeksData']->value[0]['auction_week_title'];?>
</span></a></li>
							<li <?php if ($_REQUEST['auction_week_id'] == $_smarty_tpl->tpl_vars['auctionWeeksData']->value[1]['auction_week_id']) {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=weekly&auction_week_id=<?php echo $_smarty_tpl->tpl_vars['auctionWeeksData']->value[1]['auction_week_id'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['auctionWeeksData']->value[1]['auction_week_title'];?>
</span></a></li>	
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['extendedAuction']->value != '') {?>					    
							<li <?php if ($_REQUEST['list'] == 'extended') {?> class="active" <?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=extended&view_mode=grid"><span>Extended Auction <?php echo $_smarty_tpl->tpl_vars['extendedAuction']->value;?>
</span></a></li>
						<?php }?>
					    <li <?php if ($_REQUEST['list'] == 'alternative') {?> class="active" <?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?list=alternative&view_mode=grid"><span><i>Alternative</i></span></a></li>
					</ul>
                     
				</div>	
            </div>
                
                  <form name="listFrom" id="listForm" action="" method="post" onsubmit="return false;">
                 <input type="hidden" id="mode" name="mode" value="select_watchlist" />
                 <input type="hidden" name="is_track" id="is_track" value="" />
				 <input type="hidden" name="offset" value="<?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
" />
				 <input type="hidden" name="toshow" value="<?php echo $_smarty_tpl->tpl_vars['toshow']->value;?>
" />
				 <input type="hidden" name="is_expired" id="is_expired" value="<?php echo $_smarty_tpl->tpl_vars['is_expired']->value;?>
" />
				 <input type="hidden" name="is_expired_stills" id="is_expired_stills" value="<?php echo $_smarty_tpl->tpl_vars['is_expired_stills']->value;?>
" />
				 <input type="hidden" name="auction_week_id" id="auction_week_id" value="<?php echo $_REQUEST['auction_week_id'];?>
" />
				 <input type="hidden" id="auction_week_end_time" name="auction_week_end_time" value='<?php echo $_smarty_tpl->tpl_vars['auction_week_end_time']->value;?>
' />
				
				<div class="innerpage-container-main">
                
					<div class="top-mid"><div class="top-left"></div></div>
               
                    
                    
                    
                    <div class="left-midbg"> 
                    <div class="right-midbg">   
					<div class="mid-rept-bg">
					 <?php if ($_REQUEST['mode'] == 'search') {?>
					  	<div class="messageBox"> You have searched for <?php echo $_smarty_tpl->tpl_vars['cat_value']->value;?>
</div>
					  <?php }?>
					<?php if ($_smarty_tpl->tpl_vars['errorMessage']->value <> '') {?><div class="messageBox"><?php echo $_smarty_tpl->tpl_vars['errorMessage']->value;?>
</div><?php }?>
                    	<?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
                            <div class="top-display-panel">
							<?php if ($_REQUEST['list'] != ('alternative' || 'extended')) {?>
                                <div class="left-area">
                                    <div class="dis">View as <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 :</div>
                                    <ul class="menu">
									<?php if ($_REQUEST['keyword'] != '' && $_REQUEST['mode'] == 'key_search') {?>
										<li class="list"><a href="buy.php?view_mode=list&list=<?php echo $_REQUEST['list'];?>
&mode=key_search&keyword=<?php echo urlencode($_REQUEST['keyword']);?>
&search_type=<?php echo $_REQUEST['search_type'];?>
&is_expired=<?php echo $_smarty_tpl->tpl_vars['is_expired']->value;?>
&is_expired_stills=<?php echo $_smarty_tpl->tpl_vars['is_expired_stills']->value;?>
&auction_week_id=<?php echo $_REQUEST['auction_week_id'];?>
"></a> </li>
									<?php } elseif ($_REQUEST['mode'] == 'search' || $_REQUEST['mode'] == 'dorefinesrc') {?>
										<li class="list"><a href="buy.php?view_mode=list&list=<?php echo $_REQUEST['list'];?>
&mode=<?php echo $_REQUEST['mode'];?>
&poster_size_id=<?php echo $_REQUEST['poster_size_id'];?>
&genre_id=<?php echo $_REQUEST['genre_id'];?>
&decade_id=<?php echo $_REQUEST['decade_id'];?>
&country_id=<?php echo $_REQUEST['country_id'];?>
&is_expired=<?php echo $_smarty_tpl->tpl_vars['is_expired']->value;?>
&auction_week_id=<?php echo $_REQUEST['auction_week_id'];?>
"></a></li>	
									<?php } elseif ($_REQUEST['mode'] == 'key_search_global') {?>
										<li class="list"><a href="buy.php?view_mode=list&list=<?php echo $_REQUEST['list'];?>
&mode=<?php echo $_REQUEST['mode'];?>
&is_expired=0&auction_week_id=&is_expired_stills=&keyword=<?php echo urlencode($_REQUEST['keyword']);?>
"></a></li>	
									<?php } else { ?>
                                        <li class="list"><a href="buy.php?view_mode=list&list=<?php echo $_REQUEST['list'];?>
&auction_week_id=<?php echo $_REQUEST['auction_week_id'];?>
"></a> </li>
									<?php }?>	
                                        |
                                        <li class="grida"><span class="active"></span></li>
                                    </ul>
                                </div>
								<?php }?>
								<div class="soldSearchblock">
                            	
								<div style="width:270px; height:26px;border:1px solid #cecfd0; float:left;">
                                    <input style="width:232px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 0;" type="text" class="midSearchbg_edit fll" id="search_buy_items" name="search_sold" <?php if ($_REQUEST['mode'] == 'key_search') {?> value="<?php echo $_REQUEST['keyword'];?>
" <?php } elseif ($_REQUEST['list'] == 'stills') {?> value="Search Stills.." <?php } else { ?> value="Search Auctions.."<?php }?> onclick="clear_text();" onfocus="$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var list= <?php if ($_REQUEST['list'] == '') {?>''<?php } else { ?>'<?php echo $_REQUEST['list'];?>
'<?php }?>;
			key_search_buy(list);
			}	
		}); " onblur="key_search_buy_clear()"   />
                                <input type="button" class="rightSearchbg" value=""  onclick="search_buy_items_func('<?php echo $_REQUEST['list'];?>
')" />
                            </div>
                            </div>
                                <div class="sortblock"><?php echo $_smarty_tpl->tpl_vars['displaySortByTXT']->value;?>
</div>
                                
								
                            </div>
							<div class="top-display-panel2"> 
							<div class="left-area">
								<div class="results-area" style="width:200px;;"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</div>
								<?php if (($_REQUEST['list'] == "fixed")) {?>
								<div  style="width:500px;"><input type="button" value="Press to Shuffle Inventory" class="track-btn" id="track-btn-id" onclick="shufflePage()" style="width:200px;background-repeat:repeat" /></div>
								<?php }?>
								<div class="pagination" <?php if (($_REQUEST['list'] == "fixed")) {?>style="margin-top:-20px;" <?php }?> ><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</div>
							  </div>
						  </div>
                        <?php }?>
                        <?php if ($_SESSION['sessUserID'] <> '') {?>					
						<div class="light-grey-bg-inner">
                        	<div class="inner-grey">
							
                            </div>
						</div>
                        
                        <?php }?>
                        <div class="clear"></div>
                        <?php if ($_smarty_tpl->tpl_vars['total']->value > 0) {?>
                        				
                            <div class="light-grey-bg-inner">
                               <?php if (($_REQUEST['list'] == ("weekly" || "extended")) && ($_smarty_tpl->tpl_vars['is_expired']->value == '0' && $_smarty_tpl->tpl_vars['is_expired_stills']->value != '1')) {?>
                                    <div class="inner-grey SelectionBtnPanel" >
										
                                        <div style="float:left; padding:0px; margin:0px;">
										<?php if ($_SESSION['sessUserID'] <> '') {?>
                                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);" value="" />
										<?php } else { ?>	
										  &nbsp;
										<?php }?>	
                                        </div>
									

                                        <div class="time_auction" id="auction_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[0]['auction_id'];?>
">
                                                                                        
                                            <!--<div class="text-timer" id="timer_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[0]['auction_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[0]['auction_countdown'];?>
</div>-->
                                            
                                        </div>

                                    </div>
                                <?php }?>
                            </div>
                            
                            				
                            <div class="display-listing-main buygrid"> 
 

                            <div>  
                            <div class="btomgrey-bg"></div>                 
                                <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['auctionItems']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>	
                               
                                    <div>							
                                    <div <?php if ($_SESSION['sessUserID'] == '') {?> class="grid-view-main gridMrgn" <?php } else { ?> class="grid-view-main " <?php }?>>
                                    
                                        <div class="poster-area">
                                             <div class="inner-cntnt-each-poster">
                                                <div id="gallery_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null);?>
" class="image-hldr">
                                                     <div class="buygridtb">
                                       					<div>
														<?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == '1') {?>
															<a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&fixed=1"><img  class="image-brdr"  src="<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
"   /></a>
														<?php } elseif ($_REQUEST['list'] == 'extended') {?>
															<a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&extended=true"><img  class="image-brdr"  src="<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
"   /></a>
														<?php } else { ?>
															<a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><img  class="image-brdr"  src="<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['image_path'];?>
"   /></a>
														<?php }?>
                                                        
                                                        </div>
                                                      </div>
                                                        <?php if (($_REQUEST['list'] == 'alternative' || $_REQUEST['list'] == '') && $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == 6) {?>
                                                        <div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
</a></h3></div>
														 <div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['artist'];?>
</a></h3></div>	
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_size'];?>
</a></h3></div>
														<?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['field_1'] <> '') {?>
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['field_1'];?>
</a></h3></div>
														<?php }?>
														<?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['field_2'] <> '') {?>
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['field_2'];?>
</a></h3></div>
														<?php }?>
														<?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['field_3'] <> '') {?>
														<div class="pb05 pl10 pr10 tac" ><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['field_3'];?>
</a></h3></div>
														<?php }?>
														<?php } elseif ($_REQUEST['list'] == 'fixed') {?>
															<div class="pb05 pl10 pr10 tac" style="height:40px;"><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&fixed=1" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
</a></h3></div>
														<?php } elseif ($_REQUEST['list'] == 'extended') {?>
															<div class="pb05 pl10 pr10 tac" style="height:40px;"><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
&extended=true" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
</a></h3></div>
														<?php } else { ?>
															<div class="pb05 pl10 pr10 tac" style="height:40px;"><h3><a class="gridView" href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=poster_details&auction_id=<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" style="cursor:pointer;" ><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['poster_title'];?>
</a></h3></div>
														<?php }?>	
                                                         <?php if ($_smarty_tpl->tpl_vars['is_expired']->value == '0' && $_smarty_tpl->tpl_vars['is_expired_stills']->value != '1' && $_REQUEST['list'] != 'alternative' && $_REQUEST['list'] != '') {?>
														   <?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] <> '1') {?>
                                            				<div class="inner-cntnt-each-poster pt10  pb05 pl10 pr10">                                        
                                                			  <div class="tac">
																<?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['watch_indicator'] == 0) {?>	
																  <?php if ($_REQUEST['list'] != 'extendded') {?>
																	<div class="timerwrapper" style="float:right">
																 	<!-- <div class="timer-left"></div>-->
																  	<div class="text-timer" id="timer_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_countdown'];?>
</div>
																  	<!--<div class="timer-right"></div>-->
																  	</div>
																	<input type="button" value="Watch" class="track-btn" style="width:60px;" onclick="add_watchlist_for_details(<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
);" id="watch_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" />
																  <?php }?>
																<?php } else { ?>
																	<div class="timerwrapper" style="float:right">
																 	<!-- <div class="timer-left"></div>-->
																  		<div class="text-timer" id="timer_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_countdown'];?>
</div>
																  		<!--<div class="timer-right"></div>-->
																  	</div>
																	<input type="button" value="Watching" style="width:60px;" onclick="redirect_watchlist(<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
);" class="track-btn"  />
													
																<?php }?>
                                                               </div>
                                                            </div>
															<?php } else { ?>
															<div class="pb05 pl10 pr10 tac" ><h3>Buy Now Price:&nbsp;$<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_asked_price'];?>
</h3></div>
															<?php }?>
														<?php }?>
                                            
                                            	<div class="inner-cntnt-each-poster pb05 pl10 pr10">
                                            <?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == 1) {?>	
                                                <div id="auction_data_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
">
                                                    <?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['offer_count'] > 0) {?>
                                                        <div class="auction-row">
                                                            
                                                        </div>
                                                    <?php }?>
                                                </div>
												<!--   popup starts -->
												<div id="<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="popDiv_Auction">
												
                                    			</div>
												<!--   popup ends -->
                                            <?php } elseif ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == 2 || $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == 5) {?>
                                                
													
												
                                                <?php if (($_REQUEST['list'] == "weekly" || $_REQUEST['list'] == "extended") && ($_smarty_tpl->tpl_vars['is_expired']->value == '0' && $_smarty_tpl->tpl_vars['is_expired_stills']->value != '1')) {?>
												<div class="bid-time" >
                                                        <div class="left-side1"  style="margin-right: 12px;">
                                                            <div class="text-grid CurrencyDecimal fll"  style="font-size:15px;">&#36;</div>
                                                            <div class="txtdivd fll"><input type="text" name="bid_price_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" id="bid_price_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" maxlength="8"  onfocus="$(this).keypress(function(event){
                                                                    var keycode = (event.keyCode ? event.keyCode : event.which);
                                                                    if(keycode == '13'){
                                                                    var auc_id=this.id;
                                                                    test_enter_for_bid(auc_id);
                                                                    }
                                                                    }); " onblur="test_blur_for_bid(this.id)" style="width:40px;" /></div>
                                                            <div class="CurrencyDecimal" style="font-size:15px;">.00</div>
                                                        </div>
                                                        <div class="left-side fll">
														<input type="button" id="bid_bttn_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" value="" onclick="postBid(<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_user_id'];?>
');" class="bidnow-hammer-btn2" /></div>
                                                    </div>
												<div id="auction_data_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" >
                                                    <?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_count'] > 0) {?>
                                                        
                                                    <?php }?>
                                                </div>
												
												<?php if (($_smarty_tpl->tpl_vars['is_expired']->value == '0' && $_smarty_tpl->tpl_vars['is_expired_stills']->value != '1')) {?>
												<!--   popup starts -->
												<div id="<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="popDiv">
												
                                    			</div>
												
												<?php }?>	
                                                    
                                                <?php } elseif (($_REQUEST['list'] == "weekly" || $_REQUEST['list'] == "stills") && ($_smarty_tpl->tpl_vars['is_expired']->value == '1' || $_smarty_tpl->tpl_vars['is_expired_stills']->value == '1')) {?>
													<div class="auction-row" style="padding:0px;">
													
													 <div class="buy-text bold"><span class="CurrentBidOffer"  style="font-size:13px; color:#000;">Sold Price:</span> </div>
													 <div class="buy-text offer_buyprice" style="font-size:13px;">$<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['last_bid_amount'];?>
</div><div  class="buy-text-detpstr" >&nbsp;<b class="OfferBidNumber" style="font-size:13px;"><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['bid_count'];?>
 Bid(s)&nbsp;&nbsp;</b> </div>
													 
													</div>
                                                <?php }?>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == 3) {?>
                                                <div id="auction_data_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
">
                                                    <?php if ($_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['last_bid_amount'] > 0) {?>
                                                        <div class="auction-row">
                                                            
                                                        </div>
                                                    <?php }?>
                                                </div>
												<!--   popup starts -->
												<div id="<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" class="popDiv">
												
                                    			</div>
												
                                            <?php }?>
											<?php if (($_REQUEST['list'] == 'alternative' || $_REQUEST['list'] == '') && $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == 6 && $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['quantity'] > 0) {?>
													<div class="bid-time" >
                                                        <div class="left-side1"  style="margin-right: 12px;">
                                                            <div class="text-grid CurrencyDecimal fll"  style="font-size:15px;">&#36;<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_asked_price'];?>
</div>
                                                            
                                                        </div>
                                                        <div class="left-side fll">
														<input type="button" id="buynow_bttn_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
" value="" onclick="redirect_to_cart(<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['auction_id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_user_id'];?>
')" class="bidnow-btn BuyNow" style="margin:1px 0 0 0;" /></div>
                                                    </div>
												<?php } elseif (($_REQUEST['list'] == 'alternative' || $_REQUEST['list'] == '') && $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['fk_auction_type_id'] == 6 && $_smarty_tpl->tpl_vars['auctionItems']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['quantity'] == 0) {?>
													<div class="auction-row" style="padding:0px;">
													
													 <div class="buy-text bold"><span class="CurrentBidOffer"  style="font-size:13px; color:#000;">
													 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													 <input type="button" value="Sold" class="track-btn" onclick="javascript:void(0);"></span> </div>
													 													 
													</div>	
												<?php }?>
                                            </div>
                                            
                                            
                                            
                                                        
                                              </div>                                            
                                           </div>
                                        </div>
                                       
                                    </div>
                                    </div>
                                    <?php if (((isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)) != 0) {?>
                                        <?php if ((((isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)+1)%4) == 0) {?> 
                                         <!--<img class="grid-divider" src="images/grid-divider.png" width="756" height="4" border="0" />-->
                                         <div class="btomgrey-bg"></div> <?php }?>
                                    <?php }?> 
                                <?php
}
}
?> 
                                  <div class="btomgrey-bg"></div>  
                                </div>
                            </div>
                            
                            <div class="top-display-panel2">
                              <div class="left-area">
                                <div class="results-area"><?php echo $_smarty_tpl->tpl_vars['displayCounterTXT']->value;?>
</div>
                                <div class="pagination" style="width:270px;"><?php echo $_smarty_tpl->tpl_vars['pageCounterTXT']->value;?>
</div>
                              </div>
							</div>
						<?php } else { ?>
						    <div class="top-display-panel">
								<?php if ($_REQUEST['list'] != 'extended') {?>
                                <div class="left-area">
                                    <div class="dis">View as :</div>
                                    <ul class="menu">
									<?php if ($_REQUEST['keyword'] != '') {?>
										<li class="list"><a href="buy.php?view_mode=list&list=<?php echo $_REQUEST['list'];?>
&mode=key_search&keyword=<?php echo urlencode($_REQUEST['keyword']);?>
&search_type=<?php echo $_REQUEST['search_type'];?>
&is_expired=<?php echo $_smarty_tpl->tpl_vars['is_expired']->value;?>
&auction_week_id=<?php echo $_REQUEST['auction_week_id'];?>
"></a> </li>
									<?php } elseif ($_REQUEST['mode'] == 'search' || $_REQUEST['mode'] == 'dorefinesrc') {?>
										<li class="list"><a href="buy.php?view_mode=list&list=<?php echo $_REQUEST['list'];?>
&mode=<?php echo $_REQUEST['mode'];?>
&poster_size_id=<?php echo $_REQUEST['poster_size_id'];?>
&genre_id=<?php echo $_REQUEST['genre_id'];?>
&decade_id=<?php echo $_REQUEST['decade_id'];?>
&country_id=<?php echo $_REQUEST['country_id'];?>
&is_expired=<?php echo $_smarty_tpl->tpl_vars['is_expired']->value;?>
&auction_week_id=<?php echo $_REQUEST['auction_week_id'];?>
"></a></li>	
									<?php } else { ?>
                                        <li class="list"><a href="buy.php?view_mode=list&list=<?php echo $_REQUEST['list'];?>
&auction_week_id=<?php echo $_REQUEST['auction_week_id'];?>
"></a> </li>
									<?php }?>	
                                        |
                                        <li class="grida"><span class="active"></span></li>
                                    </ul>
                                </div>
								<?php }?>
								<div class="soldSearchblock">
                            	 <div style="width:270px; height:26px;border:1px solid #cecfd0; float:left;"> 	

                                    <input type="text" style="width:232px; height:23px;border:0px solid #cecfd0; padding:3px 0 0 0;" class="midSearchbg_edit fll" id="search_buy_items" name="search_sold" <?php if ($_REQUEST['mode'] == 'key_search') {?> value="<?php echo $_REQUEST['keyword'];?>
" <?php } elseif ($_REQUEST['list'] == 'stills') {?> value="Search Stills.." <?php } else { ?> value="Search Auctions.."<?php }?> onclick="clear_text();" onfocus="$(this).keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13' && keycode != ''){
			var list= <?php if ($_REQUEST['list'] == '') {?>''<?php } else { ?>'<?php echo $_REQUEST['list'];?>
'<?php }?>;
			key_search_buy(list);
			}	
		}); " onblur="key_search_buy_clear()"   />
                                <input type="button" class="rightSearchbg" value=""  onclick="search_buy_items_func('<?php echo $_REQUEST['list'];?>
')" />
                            </div>
                            </div>
                                <div class="sortblock"><?php echo $_smarty_tpl->tpl_vars['displaySortByTXT']->value;?>
</div>
                                
								<?php if ($_REQUEST['list'] == 'weekly') {?> 
									<div class="msgsearchnorecords"> Sorry no records found. </div>
								<?php } elseif ($_REQUEST['list'] == 'monthly') {?>
									<div class="msgsearchnorecords"> There are currently no Event auctions scheduled at this time.</div>
								<?php } elseif ($_REQUEST['list'] == 'stills') {?>
									<div class="msgsearchnorecords"> Sorry no records found.</div>	
								<?php } else { ?>
									<div class="msgsearchnorecords"> Sorry no records found.</div>	
								<?php }?>
                            </div>
						
							
                        <div class="top-display-panel2">&nbsp;</div>
						<?php }?>
                        <?php if ($_SESSION['sessUserID'] <> '') {?>
						<div class="light-grey-bg-inner">
                        	<div class="inner-grey">
							
                            </div>
						</div>
                        
                        <?php }?>
						<?php if ($_smarty_tpl->tpl_vars['total']->value > 1) {?>
                            <?php if ($_SESSION['sessUserID'] <> '') {?>
                            <div class="light-grey-bg-inner">
                               <?php if (($_REQUEST['list'] == "weekly" || $_REQUEST['list'] == "extended") && ($_smarty_tpl->tpl_vars['is_expired']->value == '0' && $_smarty_tpl->tpl_vars['is_expired_stills']->value != '1')) {?>
                                    <div class="inner-grey SelectionBtnPanel">
                                        <div style="float:left; padding:0px; margin:0px;">
                                            <input type="button" class="place-all-bids-btn" onclick="placeAllBids(dataArr);"  />
                                        </div>

                                        <div class="time_auction" id="auction_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[1]['auction_id'];?>
">
										                                            
                                            <!--<div class="text-timer" id="timer_<?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[0]['auction_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['auctionItems']->value[0]['auction_countdown'];?>
</div>-->
                                            
                                        </div>

                                    </div>
                                <?php }?>
                            </div>
                            
                            <?php }?>
						<?php }?>	
                        <div class="clear"></div>			
					</div>
                    </div>
                    </div>
                    
                    
					<!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
				</div>
				</form>	
			</div>	
			
             </div></div></div>	
			
		</div>
         
	<!-- page listing ends -->
    
    </div>
    <div class="clear"></div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>



<?php echo '<script'; ?>
 type="text/javascript">

$(document).ready(function(){
    
	    <?php if ($_REQUEST['list'] == 'alternative') {?>
		 <?php if ($_smarty_tpl->tpl_vars['liveStilltrack']->value == 1) {?>
	
			dataArr = <?php if ($_smarty_tpl->tpl_vars['json_arr']->value != '') {
echo $_smarty_tpl->tpl_vars['json_arr']->value;
} else { ?> ''<?php }?>;
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= <?php if ($_REQUEST['list'] == '') {?>''<?php } else { ?>'<?php echo $_REQUEST['list'];?>
'<?php }?>;		
			//setInterval(function() { timeLeftGallery(dataArr,list); }, 1500);
			setTimeout(function() { timeLeftGallery(dataArr,list); }, 3000);

	
		 <?php }?>
		 <?php } elseif ($_REQUEST['list'] == 'stills') {?>
		 
	
			dataArr = <?php if ($_smarty_tpl->tpl_vars['json_arr']->value != '') {
echo $_smarty_tpl->tpl_vars['json_arr']->value;
} else { ?> ''<?php }?>;
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= <?php if ($_REQUEST['list'] == '') {?>''<?php } else { ?>'<?php echo $_REQUEST['list'];?>
'<?php }?>;		
			//setInterval(function() { timeLeftGallery(dataArr,list); }, 2500);
			setTimeout(function() { timeLeftGallery(dataArr,list); }, 3000);
	
		<?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['is_expired']->value != '1') {?>	
		
			dataArr = <?php if ($_smarty_tpl->tpl_vars['json_arr']->value != '') {
echo $_smarty_tpl->tpl_vars['json_arr']->value;
} else { ?> ''<?php }?>;
			//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
			var list= <?php if ($_REQUEST['list'] == '') {?>''<?php } else { ?>'<?php echo $_REQUEST['list'];?>
'<?php }?>;		
			//setInterval(function() { timeLeftGallery(dataArr,list); }, 1500);
			setTimeout(function() { timeLeftGallery(dataArr,list); }, 3000);
		
	       <?php }?>	
		<?php }?>
	
})


<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
function toggleDiv(id,flagit,type,track) {
 	 var url = "bid_popup.php";
	 if(type==1 && track==1){
	 	$.post(url, {mode : 'offer_popup', id : id}, function(data){
			$('#'+id).html(data);
	 	});
	 }else if(type==0 && track==1){
	 	$.post(url, {mode : 'bid_popup', id : id}, function(data, textStatus){
	 		$('#'+id).html(data);
	 	});
	 }
	if (flagit=="1"){
	document.getElementById(''+id+'').style.visibility = "visible";
	/*if (document.layers) document.layers[''+id+''].visibility = "show"
	else if (document.all) document.all[''+id+''].style.visibility = "visible"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "visible"*/
	}
	else
	if (flagit=="0"){
	document.getElementById(''+id+'').style.visibility = "hidden";
	/*if (document.layers) document.layers[''+id+''].visibility = "hide"
	else if (document.all) document.all[''+id+''].style.visibility = "hidden"
	else if (document.getElementById) document.getElementById(''+id+'').style.visibility = "hidden"*/
	}
}
    function clear_text(){
        if($("#search_buy_items").val()=='Search Auctions..'){
            document.getElementById('search_buy_items').value='';
        }if($("#search_buy_items").val()=='Search Stills..'){
            document.getElementById('search_buy_items').value='';
        }
    }
	
	function search_buy_items_func(list){
		var search_text= $('#search_buy_items').val();
		var is_expired = $('#is_expired').val();
		var is_expired_stills = $('#is_expired_stills').val();
		var auction_week_id = $('#auction_week_id').val();
		window.location.href="buy.php?list="+list+"&mode=key_search&is_expired="+is_expired+"&is_expired_stills="+is_expired_stills+"&auction_week_id="+auction_week_id+"&keyword="+encodeURIComponent(search_text);
	}
	function key_search_buy(list){
		var search_text= $('#search_buy_items').val();
		var is_expired = $('#is_expired').val();
		var is_expired_stills = $('#is_expired_stills').val();
		var auction_week_id = $('#auction_week_id').val();
		window.location.href="buy.php?list="+list+"&mode=key_search&is_expired="+is_expired+"&is_expired_stills="+is_expired_stills+"&auction_week_id="+auction_week_id+"&keyword="+encodeURIComponent(search_text);
		return false;
	}
	function key_search_buy_clear(){
		$('#search_buy_items').unbind('keypress');
		//$('#search_buy_items_func').unbind('click');
	}
    function test_enter_for_bid(auction_id){
        var newData = auction_id.split("_");
        $('#'+newData[2]).html("");
        $("#bid_bttn_"+newData[2]).click();
    }
    function test_blur_for_bid(auction_id){
        var newData = auction_id.split("_");
        $('#'+auction_id).unbind('keypress');
        $('#bid_bttn_'+newData[2]).unbind('click');
    }
	function shufflePage(){
			var newUrl =  '<?php echo $_smarty_tpl->tpl_vars['Newlink']->value;?>
'.replace(/\&amp;/g,'&')
			window.location.href=newUrl;
		}
<?php echo '</script'; ?>
>
<?php }
}
