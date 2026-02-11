{include file="header.tpl"}
<link href="{$smarty.const.DOMAIN_PATH}/javascript/jquery-countdown-1.5.9/jquery.countdown.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{$smarty.const.DOMAIN_PATH}/javascript/jquery-countdown-1.5.9/jquery.countdown.js"></script>
{literal}
<script type="text/javascript">
function insert_proxy(auction_id,user_id,seller_id,asked_price){
	var curr_bid=$('#current_bid_'+auction_id).val();
	var proxy_bid=$('#proxy_bid_'+auction_id).val();
	var next_increment=$('#auction_increment_'+auction_id).val();
    var curr_bid= Math.floor(curr_bid);
    var asked_price=Math.floor(asked_price);
    var chk_ind=/^ *[0-9]+ *$/.test(proxy_bid);
    var is_sold_track=$('#is_sold_track_'+auction_id).val();
	if($('#proxy_bid_'+auction_id).val() == ''){
    	alert("Please enter proxy amount");
        return;
    }else if(isNaN($('#proxy_bid_'+auction_id).val())){
    	alert("Please enter numeric value only");
        $('#proxy_bid_'+auction_id).val("");
        return;
    }else if( proxy_bid == parseFloat(proxy_bid) && chk_ind==false){
    	 alert("Please enter integer value");
    	 $('#proxy_bid_'+auction_id).val("");
    	 return;
    }else if(is_sold_track==1){
      	 alert("This poster has been sold");
      	 $('#proxy_bid_'+auction_id).val("");
      	 return;
    }else if(curr_bid > proxy_bid){
    		alert("Please enter proxy amount more than next bid");
          	 $('#proxy_bid_'+auction_id).val("");
          	 return;
    }else if(asked_price > proxy_bid){
    	 alert("Please enter proxy amount more than start price of "+asked_price+".00");
    	 $('#proxy_bid_'+auction_id).val("");
    	 return;
    }else if(user_id == seller_id){
    	 alert("Seller cannot set proxy bid on his own poster.");
    	 $('#proxy_bid_'+auction_id).val("");
    	 return;
    	}
 
	if(confirm("Please confirm your proxy bid of $"+$('#proxy_bid_'+auction_id).val()+".00")){
	
	$.post("proxy_bid", { mode:'insert_proxy' , auction_id: auction_id, user_id: user_id , proxy_bid:proxy_bid,curr_bid:curr_bid,next_increment:next_increment},
			   function(data) {
			  $("#edit_proxy_amnt_"+auction_id).val(data);
			  $('#proxy_btn_'+auction_id).hide();
			  $('#proxy_bid_'+auction_id).hide();
			  $('#edit_del_'+auction_id).show();
			  $('#view_proxy_'+auction_id).html('<span class="CurrencyDecimal bold" id="show_proxy_'+auction_id+'">'+data+'</span>');
			   });
	}
	$('#proxy_bid_'+auction_id).val("");

}
//function insert_proxy_offer(auction_id,user_id,asked_price){
//	var curr_bid=$('#current_bid_'+auction_id).val();
//	var proxy_bid=$('#proxy_bid_'+auction_id).val();
//	var next_increment=$('#auction_increment_'+auction_id).val();
//    var curr_bid= Math.floor(curr_bid);
//    var asked_price=Math.floor(asked_price);
//    var chk_ind=/^ *[0-9]+ *$/.test(proxy_bid);
//	
//	if($('#proxy_bid_'+auction_id).val() == ''){
//    	alert("Please enter proxy amount");
//        return;
//    }else if(isNaN($('#proxy_bid_'+auction_id).val())){
//    	alert("Please enter numeric value only");
//        $('#proxy_bid_'+auction_id).val("");
//        return;
//    }else if( proxy_bid == parseFloat(proxy_bid) && chk_ind==false){
//    	 alert("Please enter integer value");
//    	 $('#proxy_bid_'+auction_id).val("");
//    	 return;
//    }else if(curr_bid > proxy_bid){
//    		alert("Please enter proxy amount more than next bid");
//          	 $('#proxy_bid_'+auction_id).val("");
//          	 return;
//    }else if(asked_price > proxy_bid){
//    	 alert("Please enter proxy amount more than start price of "+asked_price+".00");
//    	 $('#proxy_bid_'+auction_id).val("");
//    	 return;
//    	}
// 
//	if(confirm("Please confirm your proxy bid of $"+$('#proxy_bid_'+auction_id).val()+".00")){
//	
//	$.post("proxy_bid", { mode:'insert_proxy' , auction_id: auction_id, user_id: user_id , proxy_bid:proxy_bid,curr_bid:curr_bid,next_increment:next_increment},
//			   function(data) {
//			  $("#edit_proxy_amnt_"+auction_id).val(data);
//			  $('#proxy_btn_'+auction_id).hide();
//			  $('#proxy_bid_'+auction_id).hide();
//			  $('#edit_del_'+auction_id).show();
//			  $('#show_proxy_'+auction_id).html('<span class="CurrencyDecimal bold" id="show_proxy_'+auction_id+'">'+data+'</span>');
//			   });
//	}
//	$('#proxy_bid_'+auction_id).val("");
//
//}

 function edit_proxy(auction_id){
	 $('#div_show_proxy_'+auction_id).hide();
	 var proxy_amnt=parseInt($('#edit_proxy_amnt_'+auction_id).val());
	 $('#edit_proxy_'+auction_id).show();
	 $('#edit_proxy_'+auction_id).html('<div class="text-proxy proxyEdit">$<input id='+auction_id+'  type="text" name="bid_price_'+auction_id+'"  maxlength="8" class="inner-txtfld" value='+proxy_amnt+'  /><span class="CurrencyDecimal bold" id="new_proxy_'+auction_id+'" ></span><span class="CurrencyDecimal bold">.00</span></div>');
	 //$('#proxy_edit_btn_'+auction_id).html("<input type='button' class='proxybid-edit-btn' id='proxy_edit_btn_'+auction_id  >");
	 $('#proxy_edit_btn_'+auction_id).hide();
	 $('#proxy_edit_new_btn_'+auction_id).show();
		 }
 function edit_new_proxy(auction_id){
	 var curr_bid=$('#current_bid_'+auction_id).val();
	 var proxy_bid=$('#'+auction_id).val();
	 var next_increment=$('#auction_increment_'+auction_id).val();
	 var curr_bid= Math.floor(curr_bid);
	 var last_proxy= parseInt($('#edit_proxy_amnt_'+auction_id).val());
	 var chk_ind=/^ *[0-9]+ *$/.test(proxy_bid);
	 var is_sold_track=$('#is_sold_track_'+auction_id).val();
	 if($('#'+auction_id).val() == ''){
	    	alert("Please enter proxy amount");
	    	$('#'+auction_id).val(last_proxy) ;
	        return;
	    }else if(isNaN($('#'+auction_id).val())){
	    	alert("Please enter numeric value only");
	        $('#'+auction_id).val(last_proxy) ;
	        return;
	    }else if( proxy_bid == parseFloat(proxy_bid) && chk_ind==false){
	    	 alert("Please enter integer value");
	    	 $('#'+auction_id).val(last_proxy);
	    	 return;
	    }else if(is_sold_track==1){
	      	 alert("This poster has been sold");
	      	 $('#proxy_bid_'+auction_id).val("");
	      	 return;
	    }else if(curr_bid > proxy_bid){
	    		alert("Please enter proxy amount more than next bid");
	          	 $('#'+auction_id).val(last_proxy);
	          	 return;
	    	}
	 if(confirm("Please confirm your proxy bid of $"+$('#'+auction_id).val()+".00")){
	 $.post("proxy_bid", { mode:'edit_proxy' , auction_id: auction_id,proxy_bid:proxy_bid,curr_bid:curr_bid,next_increment:next_increment},
			   function(data) {
			  $("#edit_proxy_amnt_"+auction_id).val(data);
			  $('#'+auction_id).hide();
			  $('#proxy_edit_btn_'+auction_id).show();
			  $('#proxy_edit_new_btn_'+auction_id).hide();
			  $('#show_proxy_'+auction_id).show();
			  $('#new_proxy_'+auction_id).html('<span class="CurrencyDecimal bold" id="show_proxy_'+auction_id+'" >'+data+'</span>');
			   });
	 }
 }
// function delete_proxy(auction_id){
//	 if(confirm("Are you sure want to delete the proxy bid")){
//	  $.post("proxy_bid", { mode:'delete_proxy' , auction_id: auction_id},
//	  function(data) {
//	  $('#del_div_'+auction_id).remove();
//	  });
//	 }
// }
// function delete_proxy_offer(auction_id){
//	 if(confirm("Are you sure want to delete the proxy bid")){
//	  $.post("proxy_bid", { mode:'delete_proxy_offer' , auction_id: auction_id},
//	  function(data) {
//	  $('#del_div_'+auction_id).remove();
//	  });
//	 }
// }

$(document).ready(function(){
	dataArr = {/literal}{$json_arr}{literal};
	//setTimeout(function() {setInterval(function() { timeLeft(dataArr); }, 300)}, 10000);	
	setInterval(function() { timeLeft(dataArr); }, 300);	
})


 
</script>
{/literal}
<div id="forinnerpage-container">
  <div id="wrapper">
    <!--Header themepanel Starts-->
    <div id="headerthemepanel">
      <!--Header Theme Starts-->
      {include file="search-login.tpl"}
      <!--Header Theme Ends-->
    </div>
    <!--Header themepanel Ends-->
    <!-- page listing starts -->
    <div id="inner-container">
      <div id="inner-left-container">
        <div id="tabbed-inner-nav">
          <div class="tabbed-inner-nav-left">
            <ul class="menu">
              <li {if $smarty.request.list == ''}class="active"{/if}><a href="{$actualPath}/proxy_bid"><span>Proxy Bids</span></a></li>
            </ul>
            <div class="tabbed-inner-nav-right"></div>
          </div>
        </div>
        <form name="listFrom" id="listForm" action="" method="post">
          <input type="hidden" name="mode" value="select_watchlist" />
          <input type="hidden" name="is_track" id="is_track" value="" />
          <div class="innerpage-container-main">
            <div class="top-main-bg"></div>
            <div class="mid-rept-bg"> {if $errorMessage<>""}
              <div class="messageBox">{$errorMessage}</div>
              {/if}
              {if $total > 0}
              <div class="top-display-panel">
                <div class="sortblock">{$displaySortByTXT}</div>
                <div class="left-area">
                  <div class="results-area">{$displayCounterTXT}</div>
                  <div class="pagination" style="width:270px;">{$pageCounterTXT}</div>
                </div>
              </div>
              {/if}
              
              {if $total > 0}
              <!-- start of movie posters --->
              {section name=counter loop=$auctionItems}
              <div class="display-listing-main">
                <table class="list-view-main" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td class="list-poster-box" valign="top"><div class="poster-area-list">
                        <input type="checkbox" name="auction_ids[]" value="{$auctionItems[counter].auction_id}"/>
                        <span style="cursor:pointer;" onclick="redirect_poster_details({$auctionItems[counter].auction_id});"><strong>{$auctionItems[counter].poster_title}&nbsp;{*if $smarty.session.sessUserID <> ""}(#{$auctionItems[counter].poster_sku}){/if*}</strong></span> {if $auctionItems[counter].fk_auction_type_id=='3'}
                        <div  style="font-family:Calibri;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Event :{$auctionItems[counter].event_title}</div>
                        {/if} </div>
                      <div class="poster-area-list">
                        <div id="gallery_{$smarty.section.counter.index}" class="image-hldr"><div class="shadowbottom">
                                       <div class="shadow-bringer shadow"> <img  class="image-brdr" src="{$actualPath}/poster_photo/thumbnail/{$auctionItems[counter].poster_thumb}"  onclick="redirect_poster_details({$auctionItems[counter].auction_id});" style="cursor:pointer;" /></div></div> </div>

                        <div class="descrp-area"> {section name=catCounter loop=$auctionItems[counter].categories}
                          {if $auctionItems[counter].categories[catCounter].fk_cat_type_id == 1}
                          <div class="desp-txt"><b>Size : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                          {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 2}
                          <div class="desp-txt"><b>Genre : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                          {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 3}
                          <div class="desp-txt"><b>Decade : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                          {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 4}
                          <div class="desp-txt"><b>Country : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                          {elseif $auctionItems[counter].categories[catCounter].fk_cat_type_id == 5}
                          <div class="desp-txt"><b>Condition : </b> {$auctionItems[counter].categories[catCounter].cat_value}</div>
                          {/if}
                          {/section} </div>                      </div>

                      <div class="poster-area-list">
                        <!--<input type="button" class="bidnow-btn" value="Details" onclick="redirect_poster_details({$auctionItems[counter].auction_id});"/>-->
                      </div></td>
                    <td class="list-soldItems" valign="top"> {if $auctionItems[counter].fk_auction_type_id == 1}
                      <div class="auction-row">
                        <div id="auction_data_{$auctionItems[counter].auction_id}" {if $auctionItems[counter].offer_count == 0} style="display:none" {/if}>
                          
                        </div>
                      </div>
                      {elseif $auctionItems[counter].fk_auction_type_id == 2}
                      <div id="auction_data_{$auctionItems[counter].auction_id}"> {if $auctionItems[counter].last_bid_amount > 0}
                        <div class="auction-row">
                         
                        </div>
                        {/if} </div>
                      <div class="auction-row">
                        <div class="buy-text bold">Start Price</div>
                        <div class="buy-text">${$auctionItems[counter].auction_asked_price}</div>
                      </div>
                      {if $auctionItems[counter].auction_buynow_price > 0}
                      <div class="auction-row">
                        <div class="buy-text bold">Buy Now</div>
                        <div class="buy-text">${$auctionItems[counter].auction_buynow_price}</div>
                      </div>
                      {/if}
                      <div id="auction_{$auctionItems[counter].auction_id}">
                        <div class="auction-row">
                          <div class="boldItalics time-left">Time Left</div>
                          <div class="timerwrapper" style="float:right">
                          <div class="timer-left"></div>
                          <div class="text-timer" id="timer_($auctionItems[counter].auction_id}">{$auctionItems[counter].auction_countdown}</div>
                          <div class="timer-right"></div>
                          </div>
                        </div>
                        <div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
                          <div class="buy-text boldItalics">End Time: </div>
                          <div class="buy-text" style="float:none;">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                          <div class="buy-text bold">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                          <div class="buy-text">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                        </div>
                      </div>
                      {elseif $auctionItems[counter].fk_auction_type_id == 3}
                      <div id="auction_data_{$auctionItems[counter].auction_id}"> {if $auctionItems[counter].last_bid_amount > 0}
                        <div class="auction-row">
                          
                        </div>
                        {/if} </div>
                      <div class="auction-row">
                        <div class="buy-text bold">Start Price</div>
                        <div class="buy-text"><b class="BigFont">${$auctionItems[counter].auction_asked_price}</b></div>
                      </div>
                      <div id="auction_{$auctionItems[counter].auction_id}">
                        <div class="auction-row">
                          <div class="boldItalics time-left">Time Left</div>
                          <div class="timerwrapper" style="float:right">
                          <div class="timer-left"></div>
                          <div class="text-timer" id="timer_($auctionItems[counter].auction_id}">{$auctionItems[counter].auction_countdown}</div>
                          <div class="timer-right"></div>
                          </div>
                        </div>
                        <div class="auction-row" id="auction_end_time_{$auctionItems[counter].auction_id}">
                          <div class="buy-text boldItalics">End Time: </div>
                          <div class="buy-text">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%I:%M:00 %p"} EDT</div>
                          <div class="buy-text bold">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%A"}</div>
                          <div class="buy-text">{$auctionItems[counter].auction_actual_end_datetime|date_format:"%m/%d/%Y"}</div>
                        </div>
                      </div>
                      {/if} </td>
                    <td class="list-bid-proxy" valign="top"><div class="price-box"> {if $auctionItems[counter].fk_auction_type_id == 1}
                        <!--                                                  {if $auctionItems[counter].proxy_amnt < 1}-->
                        <!--                                                  <div id="del_div_{$auctionItems[counter].auction_id}">-->
                        <!--                                                	<div class="text-proxy bold" id="div_show_proxy_{$auctionItems[counter].auction_id}">-->
                        <!--                                                        $&nbsp;<input type="text" name="bid_price_{$auctionItems[counter].auction_id}" id="proxy_bid_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld" />-->
                        <!--                                                         <span class="CurrencyDecimal bold" id="view_proxy_{$auctionItems[counter].auction_id}"></span>-->
                        <!--                                                        <span class="CurrencyDecimal bold">.00</span>-->
                        <!--                                                    </div>-->
                        <!--                                                    <div class="text-proxy">-->
                        <!--                                                    <input type="button" class="proxybid-add-btn" value="Add" id="proxy_btn_{$auctionItems[counter].auction_id}" onclick="insert_proxy_offer({$auctionItems[counter].auction_id},{$smarty.session.sessUserID},{$auctionItems[counter].fk_user_id},{$auctionItems[counter].auction_asked_price})"; />-->
                        <!--                                                    </div>-->
                        <!--                                                    <div class="text-proxy bold" id="edit_proxy_{$auctionItems[counter].auction_id}" style="display:none">-->
                        <!--                                                        $&nbsp;<span class="CurrencyDecimal bold" id="show_proxy_{$auctionItems[counter].auction_id}">{$auctionItems[counter].proxy_amnt}</span>-->
                        <!--                                                    </div>-->
                        <!--                                                    <div class="text-proxy proxyEdit" id="edit_del_{$auctionItems[counter].auction_id}" style="display:none;">-->
                        <!--                                                    <input type="hidden" id="edit_proxy_amnt_{$auctionItems[counter].auction_id}" value="{$auctionItems[counter].proxy_amnt}">-->
                        <!--                                                    <input type="button" class="proxybid-edit-btn" id="proxy_edit_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_proxy_offer({$auctionItems[counter].auction_id})" />-->
                        <!--                                                    <input type="button" class="proxybid-edit-btn" id="proxy_edit_new_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_new_proxy_offer({$auctionItems[counter].auction_id})"  style="display:none"/>-->
                        <!--                                                    <input type="button" class="proxybid-del-btn" value="Delete" onclick="delete_proxy_offer({$auctionItems[counter].auction_id})" />-->
                        <!--                                                    </div>-->
                        <!--                                                    </div>-->
                        <!--                                                  {else} -->
                        <!--                                                  	<div id="del_div_{$auctionItems[counter].auction_id}">-->
                        <!--                                                  	<div class="text-proxy bold" id="edit_proxy_{$auctionItems[counter].auction_id}">-->
                        <!--                                                        $&nbsp;<span class="CurrencyDecimal bold" id="show_proxy_{$auctionItems[counter].auction_id}">{$auctionItems[counter].proxy_amnt}</span>-->
                        <!--                                                    </div>-->
                        <!--                                                  	<div class="text-proxy proxyEdit" id="edit_del_{$auctionItems[counter].auction_id}" >-->
                        <!--                                                  	<input type="hidden" id="edit_proxy_amnt_{$auctionItems[counter].auction_id}" value="{$auctionItems[counter].proxy_amnt}">-->
                        <!--                                                    <input type="button" class="proxybid-edit-btn" id="proxy_edit_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_proxy_offer({$auctionItems[counter].auction_id})" />-->
                        <!--                                                    <input type="button" class="proxybid-edit-btn" id="proxy_edit_new_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_new_proxy_offer({$auctionItems[counter].auction_id})"  style="display:none"/>-->
                        <!--                                                    <input type="button" class="proxybid-del-btn" value="Delete" onclick="delete_proxy_offer({$auctionItems[counter].auction_id})" />-->
                        <!--                                                    </div>-->
                        <!--                                                    </div>-->
                        <!--                                                  {/if}-->
                        {elseif $auctionItems[counter].fk_auction_type_id == 2}
                        <!-- Bid Now section for weekly auction items -->
                        {if $auctionItems[counter].proxy_amnt < 1}
                        <div id="del_div_{$auctionItems[counter].auction_id}">
                          <div class="text-proxy bold" id="div_show_proxy_{$auctionItems[counter].auction_id}"> $&nbsp;
                            <input type="text" name="bid_price_{$auctionItems[counter].auction_id}" id="proxy_bid_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld" />
                            <span class="CurrencyDecimal bold" id="view_proxy_{$auctionItems[counter].auction_id}"></span> <span class="CurrencyDecimal bold">.00</span> </div>
                          <div class="text-proxy">
                            <input type="button" class="proxybid-add-btn" value="Add" id="proxy_btn_{$auctionItems[counter].auction_id}" onclick="insert_proxy({$auctionItems[counter].auction_id},{$smarty.session.sessUserID},{$auctionItems[counter].fk_user_id},{$auctionItems[counter].auction_asked_price})"; />
                          </div>
                          <div class="text-proxy bold" id="edit_proxy_{$auctionItems[counter].auction_id}" style="display:none"> $&nbsp;<span class="CurrencyDecimal bold" id="show_proxy_{$auctionItems[counter].auction_id}">{$auctionItems[counter].proxy_amnt}</span> </div>
                          <div class="text-proxy proxyEdit" id="edit_del_{$auctionItems[counter].auction_id}" style="display:none;">
                            <input type="hidden" id="edit_proxy_amnt_{$auctionItems[counter].auction_id}" value="{$auctionItems[counter].proxy_amnt}">
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_proxy({$auctionItems[counter].auction_id})" />
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_new_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_new_proxy({$auctionItems[counter].auction_id})"  style="display:none"/>
                            <!--                                                    <input type="button" class="proxybid-del-btn" value="Delete" onclick="delete_proxy({$auctionItems[counter].auction_id})" />-->
                          </div>
                        </div>
                        {else}
                        <div id="del_div_{$auctionItems[counter].auction_id}">
                          <div class="text-proxy bold" id="edit_proxy_{$auctionItems[counter].auction_id}"> $&nbsp;<span class="CurrencyDecimal bold" id="show_proxy_{$auctionItems[counter].auction_id}">{$auctionItems[counter].proxy_amnt}</span> </div>
                          <div class="text-proxy proxyEdit" id="edit_del_{$auctionItems[counter].auction_id}" >
                            <input type="hidden" id="edit_proxy_amnt_{$auctionItems[counter].auction_id}" value="{$auctionItems[counter].proxy_amnt}">
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_btn_{$auctionItems[counter].auction_id}"  value="Edit" onclick="edit_proxy({$auctionItems[counter].auction_id})"/>
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_new_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_new_proxy({$auctionItems[counter].auction_id})"  style="display:none"/>
                            <!--                                                    <input type="button" class="proxybid-del-btn" value="Delete" onclick="delete_proxy({$auctionItems[counter].auction_id})" />-->
                          </div>
                        </div>
                        {/if}
                        
                        {elseif $auctionItems[counter].fk_auction_type_id == 3}
                        
                        {if $auctionItems[counter].proxy_amnt < 1}
                        <div id="del_div_{$auctionItems[counter].auction_id}">
                          <div class="text-proxy bold" id="div_show_proxy_{$auctionItems[counter].auction_id}"> $&nbsp;
                            <input type="text" name="bid_price_{$auctionItems[counter].auction_id}" id="proxy_bid_{$auctionItems[counter].auction_id}" maxlength="8" class="inner-txtfld" />
                            <span class="CurrencyDecimal bold" id="view_proxy_{$auctionItems[counter].auction_id}"></span> <span class="CurrencyDecimal bold">.00</span> </div>
                          <div class="text-proxy">
                            <input type="button" class="proxybid-add-btn" value="Add" id="proxy_btn_{$auctionItems[counter].auction_id}" onclick="insert_proxy({$auctionItems[counter].auction_id},{$smarty.session.sessUserID},{$auctionItems[counter].fk_user_id},{$auctionItems[counter].auction_asked_price})"; />
                          </div>
                          <div class="text-proxy bold" id="edit_proxy_{$auctionItems[counter].auction_id}" style="display:none"> $&nbsp;<span class="CurrencyDecimal bold" id="show_proxy_{$auctionItems[counter].auction_id}">{$auctionItems[counter].proxy_amnt}</span> </div>
                          <div class="text-proxy proxyEdit" id="edit_del_{$auctionItems[counter].auction_id}" style="display:none;">
                            <input type="hidden" id="edit_proxy_amnt_{$auctionItems[counter].auction_id}" value="{$auctionItems[counter].proxy_amnt}">
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_proxy({$auctionItems[counter].auction_id})" />
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_new_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_new_proxy({$auctionItems[counter].auction_id})"  style="display:none"/>
                            <!--                                                    <input type="button" class="proxybid-del-btn" value="Delete" onclick="delete_proxy({$auctionItems[counter].auction_id})" />-->
                          </div>
                        </div>
                        {else}
                        <div id="del_div_{$auctionItems[counter].auction_id}">
                          <div class="text-proxy bold" id="edit_proxy_{$auctionItems[counter].auction_id}"> $&nbsp;<span class="CurrencyDecimal bold" id="show_proxy_{$auctionItems[counter].auction_id}">{$auctionItems[counter].proxy_amnt}</span> </div>
                          <div class="text-proxy proxyEdit" id="edit_del_{$auctionItems[counter].auction_id}" >
                            <input type="hidden" id="edit_proxy_amnt_{$auctionItems[counter].auction_id}" value="{$auctionItems[counter].proxy_amnt}">
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_proxy({$auctionItems[counter].auction_id})" />
                            <input type="button" class="proxybid-edit-btn" id="proxy_edit_new_btn_{$auctionItems[counter].auction_id}" value="Edit" onclick="edit_new_proxy({$auctionItems[counter].auction_id})"  style="display:none"/>
                            <!--                                                    <input type="button" class="proxybid-del-btn" value="Delete" onclick="delete_proxy({$auctionItems[counter].auction_id})" />-->
                          </div>
                        </div>
                        {/if}
                        {/if} </div></td>
                  </tr>
                </table>
              </div>
              {/section}
              <!-- end of movie posters --->
              <div class="btomgrey-bg"></div>
              {else}
              <div class="top-display-panel" style="height:80px; padding-top:40px;">No records found!</div>
              {/if} </div>
            <div class="btom-main-bg"></div>
          </div>
        </form>
      </div>
      {include file="right-panel.tpl"} </div>
    <!-- page listing ends -->
  </div>
  <div class="clear"></div>
</div>
{include file="foot.tpl"}