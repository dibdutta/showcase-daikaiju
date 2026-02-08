<link href="{$adminActualPath}/template_test.css" rel="stylesheet">
{literal}

<script type="text/javascript" charset="utf-8">
	
	function validate_poster(){
		var auction_id = $("#auction_id").val();
		var week_id = $("#auction_week").val();
		if(week_id==''){
			alert("Please select a auction week.");
		}else{
			$.get('admin_auction_manager.php',{ mode: "relist_weekly_to_weekly", auction_id: auction_id,auction_week:week_id,asked_price:10 },
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
   
    <div style="clear:both;"></div>
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
  
  						<!-- Weekly Auction Area -->
						
  <div class="formarea" id="formarea" >
  <form name="form1" id="form1">
  <input type="hidden" name="auction_id" id="auction_id" value="{$auction_id}" />
    <div class="per-field">
      {if $aucetionWeeks!=''}
          <label for="AuctionWeeklyOptions"><strong>Auction Week:</strong><span class="red-star">*</span></label>
          <select name="auction_week" id="auction_week" style="width:320px;" class="formlisting-txtfield required">
            <option value="" selected="selected">Select</option>
            {section name=counter loop=$aucetionWeeks}
            <option value="{$aucetionWeeks[counter].auction_week_id}" {if $auction_week == $aucetionWeeks[counter].auction_week_id} selected {/if}>{$aucetionWeeks[counter].auction_week_title}&nbsp;({$aucetionWeeks[counter].auction_week_start_date|date_format:"%D"}&nbsp; - {$aucetionWeeks[counter].auction_week_end_date|date_format:"%D"})
            </option>
            {/section}
          </select>
       {else}
          <span for="AuctionWeeklyOptions"><strong>No auctions are currently scheduled. Please check back.</strong><span class="red-star">*</span></span>
       {/if}
    </div>
    
  {if $aucetionWeeks!=''}
    <div class="per-field">
      <label></label>
      <input type="button" class="submit-btn" value="Save" onclick="validate_poster()">
    </div>
   {/if}
	</form>
  </div>
</div>
