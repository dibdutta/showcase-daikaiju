{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>
{literal}
<script type="text/javascript">
	function reset_date(ele) {
		    $(ele).find(':input').each(function() {
		        switch(this.type) {
	            	case 'text':
	            	case 'select-one':	
		                $(this).val('');
		                break;    
		        }
		    });
		    
	}
	function test(){
		if(document.getElementById('start_date').value!=''){
			if(document.getElementById('end_date').value!=''){
				return true;
			}else{
				alert("Please select a end date");
				document.getElementById('end_date').focus();
				return false;
			}
		}	
 	}
	function redirect_to_consignment(){
		window.location.href="admin_auction_manager.php?mode=create_fixed&encoded_string={/literal}{$encoded_string}{literal}";
	}
 	function track_item_for_home(id){
		$.post("admin_auction_manager.php", { mode: "track_first_sold_for_home", auction_id: id },
	 	function(data) {
	   		alert(data);
		});
 	}
 	function changeSeliderPositionStatus(actionId,type){

	  if(type == 1){
	   $.post("admin_auction_manager.php", { mode: "track_first_sold_for_home", actionId: actionId },
	   function(data) { 
	   alert(data);
	  });
	  }else if(type == 2){
	   $.post("admin_auction_manager.php", { mode: "update_slider", actionId: actionId },
	   function(data) {
	   alert(data);
	  });
	 }else if(type == 3){
          $.post("admin_set_first_image_for_home.php", { mode: "update_auction_for_home", actionId: actionId },
                  function(data) {
                      alert(data);
                  });
      }else if(type == 4){
          $.post("admin_set_first_image_for_home.php", { mode: "update_upcoming_for_home", actionId: actionId },
                  function(data) {
                      alert(data);
                  });
      }

	    
	 }
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
                {if $errorMessage<>""}
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
                    </tr>
                {/if}
                <tr>
					<td width="100%">
					<form action="" method="get" onsubmit="return test();">

					<input type="hidden" name="search" value="{$smarty.request.search}" />
						<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
							<tr>
						       <td  align="right">Sort By:&nbsp;</td>
							   <td>
									<select name="sort_type" class="look" id='search_id' onChange="javascript: this.form.submit();">
										<option value="" selected="selected" >Select</option>
										<option value="poster_title" {if $sort_type == "poster_title"} selected="selected"{/if}>Poster Title(A-Z)</option>						
										<option value="poster_title_desc" {if $sort_type == "poster_title_desc"} selected="selected"{/if}>Poster Title(Z-A)</option>
										<option value="seller" {if $sort_type == "seller"} selected="selected"{/if} >Seller(A-Z)</option>										
										<option value="seller_desc" {if $sort_type == "seller_desc"} selected="selected"{/if}>Seller(Z-A)</option>
									</select>
							    </td>
								<td align="right">Search:&nbsp;</td>
								<td>
									<input type="text" name="search_fixed_poster" value="{$search_fixed_poster}" class="look" />&nbsp;
								</td>
								<td>
									<input type="submit" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" >
								&nbsp;<input type="button"  value="View All" class="button" onclick="window.location.href='admin_set_first_image_for_home.php?search={$smarty.request.search}'">
								</td>
							</tr>
							</table>
						</form>	
					</td>
				</tr>
						
				{if $total>0}
					<tr>
					
						<td align="center">
                        	<div id="messageBox" class="messageBox" style="display:none;"></div>
							<form name="listFrom" id="listForm" action="" method="post">
								<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
									<tbody>
										<tr class="header_bgcolor" height="26">
											<!--<td align="center" class="headertext" width="6%"></td>-->
											<td align="center" class="headertext" width="15%">Poster</td>
											<td align="center" class="headertext" width="14%">Seller</td>
                                            <td align="center" class="headertext" width="12%">Start Price</td>
                                            {if $smarty.request.search == '' || $smarty.request.search == 'pending'}<td align="center" class="headertext" width="8%">Status</td>{/if}
											<td align="center" class="headertext" width="13%">Set as First poster in Home Page</td>
										</tr>
										{section name=counter loop=$auctionRows}
											<tr id="tr_{$auctionRows[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
												<!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                                <td align="center" class="smalltext"><img src="{$auctionRows[counter].image_path}" style="cursor:pointer;" onclick="javascript:window.open('{$actualPath}/auction_images_large.php?mode=auction_images_large&id={$auctionRows[counter].poster_id}','mywindow','menubar=1,resizable=1,width={$auctionRows[counter].img_width+100},height={$auctionRows[counter].img_height+100},scrollbars=yes')" /><br />{$auctionRows[counter].poster_title}<br /><b>SKU: </b>{$auctionRows[counter].poster_sku}</td>
												<td align="center" class="smalltext">{$auctionRows[counter].firstname}&nbsp;{$auctionRows[counter].lastname}</td>
												<td align="center" class="smalltext">${$auctionRows[counter].auction_asked_price|number_format:2}</td>
                                                {if $smarty.request.search == '' || $smarty.request.search == 'pending'}
                                                <td id="td_{$auctionRows[counter].auction_id}" align="center" class="smalltext">
													{if $auctionRows[counter].auction_is_approved == 0}
														<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_active.gif" align="absmiddle" alt="Approve" border="0" onclick="javascript: approveAuction({$auctionRows[counter].auction_id}, 1, '{$smarty.request.search}', 'fixed');" title="Approve" class="changeStatus" />&nbsp;|&nbsp;<img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_inactive.gif" align="absmiddle" alt="Disapprove" border="0" onclick="javascript: approveAuction({$auctionRows[counter].auction_id}, 2, '{$smarty.request.search}', 'fixed');" title="Disapprove" class="changeStatus" />
													{elseif $auctionRows[counter].auction_is_approved == 1}
														Approved
                                                    {else}
                                                    	Disapproved
													{/if}
												</td>
                                                {/if}
												<td align="center" class="bold_text">
                                               
													{if  $search == 'upcoming'}
                       									<input type="radio" name="admin_track_slider" value="{$auctionRows[counter].auction_id}" title="Select First Item for Home Page" {if $auctionRows[counter].slider_first_position_status==1} checked="checked";{/if} onclick="changeSeliderPositionStatus({$auctionRows[counter].auction_id},'4');" >
                      								{/if}

												</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
											<td align="right" {if $smarty.request.search == 'fixed_price'}colspan="2"{else}colspan="5"{/if} class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
							</form>
						</td>
					</tr>
				{else}
					<tr>
						<td align="center" class="err">There is no auctions in database.</td>
					</tr>
				{/if}
			</table>
		</td>
	</tr>		
</table>
{include file="admin_footer.tpl"}