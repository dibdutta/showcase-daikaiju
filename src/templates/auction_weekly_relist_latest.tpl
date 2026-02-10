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
			$.get('myselling.php',{ mode: "relist_weekly_to_weekly", auction_id: auction_id,auction_week:week_id,asked_price:asked_price },
			 function(data) {
			$(".list-auction-fixed-ask").hide(); 
			$(".Note").hide(); 
			$("#formarea").hide(); 
			$("#formarea_fixed").hide();
			$("#choose_option").hide();
			$("#success").show();
			});
		}
	}
	function validate_poster_fixed(){
		var auction_id = $("#auction_id").val();
		var buynow_price = $("#asked_price_fixed").val();
    	var chk_ind=/^ *[0-9]+ *$/.test(buynow_price);
    	
    	if(buynow_price!='' && chk_ind==false){
			alert("Please enter integer value for Asked Price");
    	 	$('#asked_price_fixed').val("");
    	 	return;
		}else if(buynow_price==''){
			alert("Please enter integer value for Asked Price");
    	 	
    	 	return;
		}else if(chk_ind==true){
			if($('#is_consider').attr('checked')){
				var asked_price=1;
				$.get('myselling.php',{ mode: "relist_weekly_to_fixed", auction_id: auction_id,asked_price:asked_price,buynow_price:buynow_price},
						 function(data) {
						$(".list-auction-fixed-ask").hide();
						$(".Note").hide(); 
						$("#formarea").hide();
						$("#formarea_fixed").hide();
						$("#choose_option").hide(); 
						$("#success_fixed").show();
						});
			}else{
				var asked_price=0;
				$.get('myselling.php',{ mode: "relist_weekly_to_fixed", auction_id: auction_id,asked_price:asked_price,buynow_price:buynow_price},
						 function(data) {
						$(".list-auction-fixed-ask").hide();
						$(".Note").hide(); 
						$("#formarea").hide();
						$("#formarea_fixed").hide();
						$("#choose_option").hide(); 
						$("#success_fixed").show();
						});
			}
		}
		
		
	}
	function choose_option(val){
		//$("#choose_option").hide();
		if(val=='fixed'){
			$("#formarea").hide();
			$("#formarea_fixed").show();
		}else if(val=='weekly'){
			$("#formarea_fixed").hide();
			$("#formarea").show();
		}
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
    <div class="PosterThumb" style="cursor:default;"> <img  class="image-brdr" src="{$auctionDetails[0].image_path}"  border="0" style="cursor:default;"  /> </div>
    <div class="descrp-area-two movetoweeklypopup_desc">
      <div class="desp-txt"><b>Size : </b>{$auctionDetails[0].categories[0].cat_value}</div>
      <div class="desp-txt"><b>Genre : </b> {$auctionDetails[0].categories[1].cat_value}</div>
      <div class="desp-txt"><b>Decade : </b> {$auctionDetails[0].categories[2].cat_value}</div>
      <div class="desp-txt"><b>Country : </b> {$auctionDetails[0].categories[3].cat_value}</div>
      <div class="desp-txt"><b>Condition : </b>{$auctionDetails[0].categories[4].cat_value}</div>
    </div>
    <div class="list-auction-fixed-ask">
      <div class="auction-row">
        <div class="buy-text bold"><strong>Start Bid:</strong></div>
        <div class="buy-text">${$auctionDetails[0].auction_asked_price}</div>
      </div>
      
      
    </div>
    <div style="clear:both;"></div>
  </div>
  <div class="Note">
        <div class="note-txt-heading">
          <div class="note-txt"> <strong>Auction Week:</strong> {$auctionDetails[0].auction_week_title}&nbsp;({$auctionDetails[0].auction_actual_start_datetime|date_format:'%D'} - {$auctionDetails[0].auction_actual_end_datetime|date_format:'%D'})</div>
		  <div style="clear:both;"></div>
        </div>
    
   </div>
  
  <div class="formarea" id="success" style="display:none;">
    <div class="for-options">
      <div class="activity bold">Poster is successfully moved to weekly auction</div>
      </div>
  </div>
  <div class="formarea" id="success_fixed" style="display:none;">
    <div class="for-options">
      <div class="activity bold">Poster is successfully moved to fixed auction</div>
      </div>
  </div>
  							<!-- Choose Option Area -->
  
  <div class="formarea" id="choose_option">
    <div class="for-options">
      <div class="activity bold">Select You Option</div>
      <input type="radio"  value="fixed" name="choose_fixed_weekly" id="choose_fixed" onclick="choose_option(this.value)">
      <span>Fixed Price</span>
      <input type="radio"  value="weekly" name="choose_fixed_weekly" id="choose_weekly" onclick="choose_option(this .value)">
      <span>Weekly Auction</span> 
      </div>
  </div>
  							<!-- Fixed Auction Area -->
  
  <div class="formarea" id="formarea_fixed" style="display:none;">
  <input type="hidden" name="auction_id" id="auction_id" value="{$auction_id}" />
    <div class="per-field">
      <label for="StartPrice"><strong>Ask Price :</strong><span class="red-star">*</span></label>
      $
      <input type="text" class="register-txtfield required" size="32" maxlength="8" value="" name="asked_price" id="asked_price_fixed">
      .00 </div>
    
	  <div class="activity bold">
	  <input type="checkbox"  value="1" name="is_consider" id="is_consider" >
	  I will consider offers
	  </div>
    <div class="per-field">
      <label></label>
      <input type="button" class="submit-btn" value="Save" onclick="validate_poster_fixed()">
    </div>
  </div>
  						<!-- Weekly Auction Area -->
						
  <div class="formarea" id="formarea" style="display:none;">
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
        <span for="AuctionWeeklyOptions"><strong>No auctions are currently scheduled. Please check back.</strong></span>
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
</div>
