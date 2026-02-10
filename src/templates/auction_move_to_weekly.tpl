{literal}

<script type="text/javascript" charset="utf-8">
	
	function validate_poster(){
		var auction_id = $("#auction_id").val();
		var week_id = $("#auction_week").val();
		var asked_price = $("#asked_price").val();
		var chk_ind_asked=/^ *[0-9]+ *$/.test(asked_price);
		if(week_id==''){
			alert("Please select a auction week.");
		}else if(asked_price==''){
			alert("Please enter value for Starting Price");
    	 	$('#asked_price').val("");
    	 	return;
		}else if(chk_ind_asked==false){
			alert("Please enter integer value for Starting Price");
    	 	$('#asked_price').val("");
    	 	return;
		}else{
			$.get('{/literal}{$actualPath}{literal}/admin_myselling.php',{ mode: "move_fixed", auction_id: auction_id,auction_week:week_id,asked_price:asked_price},
			 function(data) {
			$(".list-auction-fixed-ask").hide(); 
			$("#formarea").hide(); 
			$("#success").show();
			});
		}
		/*if(week_id!=''){
		 if(isNaN(buynow_price)){
		 	alert("Please select a start price.");
		 }else{
			$.get('myselling.php',{ mode: "move_fixed", auction_id: auction_id,auction_week:week_id,asked_price:asked_price,buynow_price:buynow_price },
			 function(data) {
			$(".list-auction-fixed-ask").hide(); 
			$("#formarea").hide(); 
			$("#success").show();
			});
		  }
		  	
		 }
		else{
			
		}*/
	}
</script>

<style>
#fancybox-wrap {
  /*margin: -70px 0 0 290px;*/
}
</style>
{/literal}
<div class="MoveToWeeklyPopUp">
  <h4>{$auctionDetails[0].poster_title}</h4>
  <div class="display-listing-main">
    <div class="PosterThumb" style="cursor:default;">  
  <img  class="image-brdr" src="{$auctionDetails[0].image_path}"  border="0"  style="cursor:default;" />
   </div>
    <div class="descrp-area-two movetoweeklypopup_desc">
      <div class="desp-txt"><b>Size : </b>{$auctionDetails[0].categories[0].cat_value}</div>
      <div class="desp-txt"><b>Genre : </b> {$auctionDetails[0].categories[1].cat_value}</div>
      <div class="desp-txt"><b>Decade : </b> {$auctionDetails[0].categories[2].cat_value}</div>
      <div class="desp-txt"><b>Country : </b> {$auctionDetails[0].categories[3].cat_value}</div>
      <div class="desp-txt"><b>Condition : </b>{$auctionDetails[0].categories[4].cat_value}</div>
    </div>
    <div class="list-auction-fixed-ask">
      <div class="auction-row">
        <div class="buy-text bold"><strong>Ask Price:</strong></div>
        <div class="buy-text">${$auctionDetails[0].auction_asked_price}</div>
      </div>
      <div class="auction-row">
        <div class="buy-text bold"><strong>{if $auctionDetails[0].auction_reserve_offer_price > 0}You will consider offers{/if}</strong></div>
        
      </div>
      
    </div>
    <div style="clear:both;"></div>
  </div>
  <div class="Note">
        <div class="note-txt-heading">
          <div class="note-txt"> <strong>Note:</strong> {$auctionDetails[0].auction_note}</div>
		  <div style="clear:both;"></div>
        </div>
    
   </div>
  <div class="formarea" id="formarea">
  <form name="form1" id="form1">
  <input type="hidden" name="auction_id" id="auction_id" value="{$auction_id}" />
    <div class="per-field">
    {if $aucetionWeeks!=''}
        <label for="AuctionWeeklyOptions"><strong>Auction Week:</strong><span class="red-star">*</span></label>
        <select name="auction_week" id="auction_week" style="width:320px;" class="formlisting-txtfield required">
            <option value="" selected="selected">Select</option>
            {section name=counter loop=$aucetionWeeks}
                <option value="{$aucetionWeeks[counter].auction_week_id}" {if $auction_week == $aucetionWeeks[counter].auction_week_id} selected {/if}>{$aucetionWeeks[counter].auction_week_title}&nbsp;({$aucetionWeeks[counter].auction_week_start_date|date_format:'%D'}&nbsp; - {$aucetionWeeks[counter].auction_week_end_date|date_format:'%D'})
                </option>
            {/section}
        </select>
        {else}
        <span class="AuctionWeeklyOptions"><strong>No auctions are currently scheduled. Please check back.</strong></span>
    {/if}
    </div>
    <div class="per-field" style="display:none;">
      <label for="StartPrice"><strong>Starting Price:</strong><span class="red-star">*</span></label>
      $
      <input type="text" class="register-txtfield required" size="32" maxlength="8" value="10" name="asked_price" id="asked_price">
      .00 </div>
  {if $aucetionWeeks!=''}
    <div class="per-field">
      <label></label>
      <input type="button" class="submit-btn" value="Save" onclick="validate_poster()">
    </div>
  {/if}
	</form>
  </div>
  <div class="formarea" id="success" style="display:none;">
    <div class="for-options">
      <div class="activity bold">Poster is successfully moved to weekly auction</div>
      </div>
  </div>
</div>
