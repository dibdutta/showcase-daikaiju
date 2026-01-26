{include file="header.tpl"}
{literal}
<script language="javascript">

function setAuction(id, postfix)
{
	if(id == 'fixed_'+postfix){
		//$(".red-star").css("display", "block");
		$("#price_caption_"+postfix).html('Asked Price<span class="red-star">*</span>');
		$("#start_buynow_"+postfix).hide();
		$("#month_div_"+postfix).hide();
		$("#poster_price_div_"+postfix).show();
	}else if(id == 'weekly_'+postfix){
		//$(".red-star").css("display", "block");
		$("#price_caption_"+postfix).html('Reserved Price<span class="red-star">*</span>');
		$("#start_buynow_"+postfix).show();
		$("#poster_price_div_"+postfix).show();
		$("#month_div_"+postfix).hide();
	}else if(id == 'monthly_'+postfix){
		//$(".red-star").css("display", "none");
		$("#price_caption_"+postfix).html('Reserved Price<span class="red-star">*</span>');
		$("#poster_price_div_"+postfix).hide();
		$("#start_buynow_"+postfix).hide();
		$("#month_div_"+postfix).show();
	}
}
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
    
    <div id="inner-container">
        <div id="inner-left-container">
            <!--Page body Starts-->
			<form name="posterUpload" id="posterUpload" action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="save_upload" />
				{if $errorMessage<>""}<div style="margin-left:300px;" class="messageBox">{$errorMessage}</div>{/if}
				{section name=uploader start=1 loop=$smarty.const.NO_OF_FORMS}
				<div class="innerpage-container-main">                
					<div class="innerpage-container-main">            	
						<div class="black-topbg-main">
							<div class="black-left-crnr"></div>
							<div class="black-midrept">
								<span class="white-txt"><strong>Manual Upload</strong></span>
							</div>
							<div class="black-right-crnr"></div>
						</div>
						<div class="mid-rept-bg">                
							<div class="inner-area-general">
								<span>Fields marked <span class="mandatory">*</span> are mandatory</span>  
								<div class="formarea">
									<div class="bulkupload">
										<div class="bulkinner">
											<div class="per-field">
												<label>Title<span class="mandatory">*</span></label>
												<input type="text" name="poster_title_{$smarty.section.uploader.index}" value="{$poster_val[uploader].poster_title}" class="input_textbox required" /><div class="disp-err">{$poster_err[uploader].poster_title_err}</div>
											</div>
											<div class="per-field">
												<label>Size<span class="red-star">*</span></label>
												<select name="poster_size_{$smarty.section.uploader.index}" class="input_textbox required">
													<option value="" selected="selected">Select</option>
													{section name=counter loop=$catRows}
													{if $catRows[counter].fk_cat_type_id == 1}
													<option value="{$catRows[counter].cat_id}" {if $poster_val[uploader].poster_size == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
													{/if}
													{/section}
												</select>
												<div class="disp-err">{$poster_err[uploader].poster_size_err}</div>
											</div>
											<div class="per-field" style="float:left;">
												<label>Genre<span class="red-star">*</span></label>
												<select name="genre_{$smarty.section.uploader.index}" class="input_textbox">
													<option value="" selected="selected">Select</option>
													{section name=counter loop=$catRows}
													{if $catRows[counter].fk_cat_type_id == 2}
														<option value="{$catRows[counter].cat_id}" {if $poster_val[uploader].genre == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
														{assign var="selected" value=""}
													{/if}
													{/section}
												</select>
												<div class="disp-err">{$poster_err[uploader].genre_err}</div>
											</div>
											<div class="per-field">
												<label>Released Year<span class="red-star">*</span></label>
												<select name="released_yr_{$smarty.section.uploader.index}" class="input_textbox required">
													<option value="" selected="selected">Select</option>
													{section name=counter loop=$catRows}
													{if $catRows[counter].fk_cat_type_id == 3}
														<option value="{$catRows[counter].cat_id}" {if $poster_val[uploader].released_yr == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
													{/if}
													{/section}
												</select>
												<div class="disp-err">{$poster_err[uploader].released_yr_err}</div>
											</div>
											<div class="per-field">
												<label>Country<span class="red-star">*</span></label>
												<select name="poster_country_{$smarty.section.uploader.index}" class="input_textbox required">
													<option value="" selected="selected">Select</option>
													{section name=counter loop=$catRows}
													{if $catRows[counter].fk_cat_type_id == 4}
													<option value="{$catRows[counter].cat_id}" {if $poster_val[uploader].poster_country == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>
													{/if}
													{/section}
												</select>
												<div class="disp-err">{$poster_err[uploader].poster_country_err}</div>
											</div>
											<div class="per-field">
												<label>Description</label>
												<input type="text" name="poster_desc_{$smarty.section.uploader.index}" value="{$poster_val[uploader].poster_desc}" class="input_textbox required" /><div class="disp-err">{$poster_err[uploader].poster_desc_err}</div>
											</div>
											{*<div class="parent">
												<div class="innner">
													<div class="per-field">
														<label>Thumb Image<span class="red-star">*</span></label>
														<input style="margin:5px 0px" type="file" name="poster_thumb[]" class="required" /><div class="disp-err">{$poster_thumb_err}</div>
													</div>
													<div class="per-field">
														<label>Large Image</label>
														<input style="margin:5px 0px" type="file" name="poster_large[]" /><div class="disp-err">{$poster_large_err}</div>
													</div>
												</div>
											</div>*}
											<div class="for-options">
												<div class="activity">Activities<span class="mandatory">*</span></div>
												<input type="radio" name="auction_type_{$smarty.section.uploader.index}" value="1" {if $poster_val[uploader].auction_type == 1} checked {/if} onclick="setAuction('fixed_{$smarty.section.uploader.index}', {$smarty.section.uploader.index});" /><span>Fixed Price</span>
												<input type="radio" name="auction_type_{$smarty.section.uploader.index}" value="2" {if $poster_val[uploader].auction_type == 2} checked {/if} onclick="setAuction('weekly_{$smarty.section.uploader.index}', {$smarty.section.uploader.index});" /><span>Weekly Auction</span>
												<input type="radio" name="auction_type_{$smarty.section.uploader.index}" value="3" {if $poster_val[uploader].auction_type == 3} checked {/if} onclick="setAuction('monthly_{$smarty.section.uploader.index}', {$smarty.section.uploader.index});" /><span>Monthly / Event Auction</span>   
												<div class="disp-err">{$poster_err[uploader].auction_type_err}</div>                                 
											</div>
											<div class="per-field" id="month_div_{$smarty.section.uploader.index}" {if $poster_val[uploader].auction_type != 3} style="display:none;" {else} {/if}>
												<label>Select Month<span class="red-star">*</span></label>
												<select name="month_{$smarty.section.uploader.index}" class="input_textbox" onchange="$('#start_buynow_{$smarty.section.uploader.index}').show();$('#poster_price_div_{$smarty.section.uploader.index}').show();">
													<option value="" selected="selected">Select</option>
													<option value="1" {if $poster_val[uploader].month == 1} selected="selected" {/if}>January</option>
													<option value="2" {if $poster_val[uploader].month == 2} selected="selected" {/if}>February</option>
													<option value="3" {if $poster_val[uploader].month == 3} selected="selected" {/if}>March</option>
													<option value="4" {if $poster_val[uploader].month == 4} selected="selected" {/if}>April</option>
													<option value="5" {if $poster_val[uploader].month == 5} selected="selected" {/if}>May</option>
													<option value="6" {if $poster_val[uploader].month == 6} selected="selected" {/if}>June</option>
													<option value="7" {if $poster_val[uploader].month == 7} selected="selected" {/if}>July</option>
													<option value="8" {if $poster_val[uploader].month == 8} selected="selected" {/if}>August</option>
													<option value="9" {if $poster_val[uploader].month == 9} selected="selected" {/if}>September</option>
													<option value="10" {if $poster_val[uploader].month == 10} selected="selected" {/if}>October</option>
													<option value="11" {if $poster_val[uploader].month == 11} selected="selected" {/if}>November</option>
													<option value="12" {if $poster_val[uploader].month == 12} selected="selected" {/if}>December</option>
												</select>
												<div class="disp-err">{$poster_err[uploader].month_err}</div>
											</div>
											<div id="poster_price_div_{$smarty.section.uploader.index}" class="per-field" {if $poster_val[uploader].auction_type == ''} style="display:none;" {/if}>
												<label id="price_caption_{$smarty.section.uploader.index}">{if $poster_val[uploader].auction_type == '' || $poster_val[uploader].auction_type == 1}Asked{else}Reserve{/if} Price<span class="red-star">*</span></label>
												<input type="text" name="poster_price_{$smarty.section.uploader.index}" value="{$poster_val[uploader].poster_price}" class="input_textbox required number" /><div class="disp-err">{$poster_err[uploader].poster_price_err}</div>
											</div>
											<div id="start_buynow_{$smarty.section.uploader.index}" {if ($poster_val[uploader].auction_type == 2) || ($poster_val[uploader].auction_type == 3 && $poster_val[uploader].month != '')} style="display:block;" {else} style="display:none;" {/if}>
												<div class="per-field">
													<label>Start Price<span class="red-star">*</span></label>
													<input type="text" name="start_price_{$smarty.section.uploader.index}" value="{$poster_val[uploader].start_price}" class="input_textbox number" /><div class="disp-err">{$poster_err[uploader].start_price_err}</div>
												</div>
												<div class="per-field">
													<label>Bye Now Price<span class="red-star">*</span></label>
													<input type="text" name="buynow_price_{$smarty.section.uploader.index}" value="{$poster_val[uploader].buynow_price}" class="input_textbox number" /><div class="disp-err">{$poster_err[uploader].buynow_price_err}</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="btom-main-bg"></div>
				</div>
				{/section}								
				<div style="margin-left:300px;">
				<input type="submit" value="Submit" class="submit-btn" />
				<input type="reset" value="Reset" class="submit-btn" onclick="check_reset()" />
				</div>
			</form>
            <!--Page body Ends-->
        </div>        
        {include file="right-panel.tpl"}
    </div>
    <div class="clear"></div>
    </div>
</div>
{include file="foot.tpl"}