{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>

	
{literal}
<script type="text/javascript">
	

$(document).ready(function() {
	//$("#search_criteria").validate();					   
	$(function() {
		$("#start_date").datepick();
		$("#end_date").datepick();
	});
});

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
 	window.location.href="admin_auction_manager.php?mode=create_stills_auction&encoded_string={/literal}{$encoded_string}{literal}";
 }
 function view_all(){
 	window.location.href="admin_auction_manager.php?mode=stills_auction";
 }	
 function combine_buyer_invoice(){
	 //var checkBoxs = $(":checkbox").filter(":checked").size();

		 
     var allVals = [];
     $(":checkbox").filter(":checked").each(function() {
       allVals.push($(this).val());
     });
     //$('#t').val(allVals)
     var totalInv=allVals.length;
     if(totalInv >1){
	     if(confirm("Are you sure to combine invoices for buyer!")){
		     //alert(allVals);
	    	 $.get("admin_auction_manager.php", { mode:"combine_buyer_invoice","auction_id[]": allVals},
	    			   function(data) {
	    			     if(data=='1'){
		    			    alert("Successfully invoices are combined"); 
	    			     }else{
	    			    	 alert("invoices are not combined"); 
	    			     }
	    			   }); 
	    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
	     }else{
	    	 $(":checkbox").filter(":checked").each(function() {
		     		$(this).removeAttr("checked");
		          });
	     }
     }else{
    	 alert("Please select atleast two invoices to combine.");
    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
     }
     
 }
 function combine_seller_invoice(){
	 //var checkBoxs = $(":checkbox").filter(":checked").size();

		 
     var allVals = [];
     $(":checkbox").filter(":checked").each(function() {
       allVals.push($(this).val());
     });
     //$('#t').val(allVals)
     var totalInv=allVals.length;
     if(totalInv >1){
	     if(confirm("Are you sure to combine invoices for seller!")){
		     //alert(allVals);
	    	 $.get("admin_auction_manager.php", { mode:"combine_seller_invoice","auction_id[]": allVals},
	    			   function(data) {
	    			     if(data=='1'){
		    			    alert("Successfully invoices are combined"); 
	    			     }else{
	    			    	 alert("invoices are not combined"); 
	    			     }
	    			   }); 
	    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
	     }else{
	    	 $(":checkbox").filter(":checked").each(function() {
		     		$(this).removeAttr("checked");
		          });
	     }
     }else{
    	 alert("Please select atleast two invoices to combine.");
    	 $(":checkbox").filter(":checked").each(function() {
	     		$(this).removeAttr("checked");
	          });
     }
     
 }
 function fancy_images(i){
			$("#various_"+i).fancybox({
    		'width': 500,
    		'height': 400,
			'onClosed': function() {
    		parent.location.reload(true);
  				}
  			});
		}
  function set_for_homepage(id){
		if ($('#home_slider_'+id).is(':checked')) {
    		$.get("admin_auction_manager.php", { mode:"set_as_big_slider","auction_id": id},
				function(data) {
					
				
			});	
		} else {
    		$.get("admin_auction_manager.php", { mode:"remove_as_big_slider","auction_id": id},
				function(data) {
					
				
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
					<table align="center" width="80%" border="0" cellspacing="1" cellpadding="2" >
							
							<tr>
								<td class="bold_text" align="center" colspan="2" >
									
                                    	<input type="hidden" name="mode" value="stills_auction" />
										Select : 
										<select name="search" class="look" onchange="javascript: this.form.submit();">
                                        	<option value="" selected="selected">All</option>
											<option value="selling" {if $search == "selling"}selected="selected"{/if}>Selling</option>                                            
                                            <option value="sold" {if $search == "sold"}selected="selected"{/if}>Sold</option>
                                            <option value="unpaid" {if $search == "unpaid"}selected="selected"{/if}>Unpaid</option>                                            
										</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									
								</td>
								{*<td>&nbsp; &nbsp;<input type="button"  value="Add Consignment Item" class="button" onclick="redirect_to_consignment()"></td>*}
							</tr>
						</table>
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
											<option value="buyer" {if $sort_type == "buyer"} selected="selected"{/if} >Buyer(A-Z)</option>										
											<option value="buyer_desc" {if $sort_type == "buyer_desc"} selected="selected"{/if}>Buyer(Z-A)</option>
											
										</select>
								    </td>
									<td align="right">Search:&nbsp;</td>
									<td>
										<input type="text" name="search_fixed_poster" value="{$search_fixed_poster}" class="look" />&nbsp;
									</td>
							</tr>
							<tr>
									<td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top">Start Date:&nbsp;
									</td>
									<td>
										<input type="text" name="start_date" id="start_date" value="{$start_date_show}"  class="look required" /></td>
									<td id='end_date_td' style="padding:5px 0 0 0;" align="right" valign="top">End date:&nbsp;
									</td>
									<td>
										<input type="text" name="end_date" id="end_date" value="{$end_date_show}"  class="look required" />                        </td>
									<td>
										<input type="submit" value="Search" class="button"  >&nbsp;<input type="button" name="reset" value="Reset" class="button" onclick="reset_date(this.form)" >
									&nbsp;<input type="button"  value="View All" class="button" onclick="view_all()">
									
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
											<td align="center" class="headertext" width="8%">Poster</td>
											{*if $smarty.request.search == 'sold'}											
											<td align="center" class="headertext" width="12%">Buyer</td>
											<td align="center" class="headertext" width="8%">Sold Date</td>
											{/if*}
											<td align="center" class="headertext" width="12%">Seller</td>
                                            <td align="center" class="headertext" width="6%">Start Price</td>
                                            
                                            {if $smarty.request.search == '' || $smarty.request.search == 'pending'}<td align="center" class="headertext" width="8%">Status</td>{/if}
											<td align="center" class="headertext" width="15%">Action</td>
										</tr>
										{section name=counter loop=$auctionRows}
											<tr id="tr_{$auctionRows[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
												
                                                <td align="center" class="smalltext" >
                                                
                                                <img src="{$auctionRows[counter].image_path}" style="cursor:pointer;" onclick="javascript:window.open('{$actualPath}/auction_images_large.php?mode=auction_images_large&id={$auctionRows[counter].poster_id}','mywindow','menubar=1,resizable=1,width={$auctionRows[counter].img_width+100},height={$auctionRows[counter].img_height+100},scrollbars=yes')" /><br />{$auctionRows[counter].poster_title}<br /><b>SKU: </b>{$auctionRows[counter].poster_sku}</td>
												{*if $smarty.request.search == 'sold'}
													<td align="center" class="smalltext" >{$auctionRows[counter].winnerName}</td>
													<td align="center" class="smalltext" >{$auctionRows[counter].invoice_generated_on|date_format:"%m/%d/%Y"}</td>
												{/if*}
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
                                                {*if $auctionRows[counter].auction_is_approved == 0*}
                                                	<a href="{$adminActualPath}/admin_auction_manager.php?mode=edit_stills_auction&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Update" title="Update" border="0" class="changeStatus" /></a>
                                                    <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$adminActualPath}/admin_auction_manager.php?mode=delete_auction&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}', 'auction','{$auctionRows[counter].auction_id}'); return false;"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete Auction" title="Delete Auction" border="0" class="changeStatus" /></a> 
                                                {*/if*}
                                                 <a href="{$adminActualPath}/admin_auction_manager.php?mode=view_stills&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_open.gif" align="absmiddle" alt="Details" title="Details" border="0" class="changeStatus" /></a> 
                                                    <!--&nbsp;|&nbsp;<a href="#" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete" title="Delete" border="0" class="changeStatus" /></a>&nbsp;&nbsp;-->
                                             		{if $search == 'selling' || $search == 'sold' || $auctionRows[counter].auction_is_approved == '1'}<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_details&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_view.gif" align="absmiddle" alt="View Bid Details" title="View Bid Details" border="0" class="changeStatus" /></a>{/if}
													{if $search == 'sold'}
													<a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}invoice.jpg" align="absmiddle" alt="Manage Invoice" title="Manage Invoice Buyer" border="0" class="changeStatus" width="20px" /></a>
													&nbsp;<a href="{$adminActualPath}/admin_auction_manager.php?mode=manage_invoice_seller&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}invoice_seller.jpg" align="absmiddle" alt="Reopen Auction" title="Manage Invoice Seller" border="0" class="changeStatus" width="20px" /></a>
													{/if}
													{if $search == 'unpaid' && $auctionRows[counter].reopen_auction_id=='0'}
													 <a href="{$adminActualPath}/admin_auction_manager.php?mode=reopen_fixed&auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}reopen_auction.jpg" align="absmiddle" alt="Reopen Auction" title="Reopen Auction" border="0" class="changeStatus" width="20px" /></a>
													{elseif $search == 'unpaid' && $auctionRows[counter].reopen_auction_id!='0'}
													<a href="{$adminActualPath}/admin_auction_manager.php?mode=view_fixed&auction_id={$auctionRows[counter].reopen_auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}auction_reopened.jpg" align="absmiddle" alt="Auction Reopened" title="Auction Reopened" border="0" class="changeStatus" width="20px" /></a>
													{/if}
													{if $search == 'selling' || $search == 'sold'}
													 <a href="{$adminActualPath}/admin_proxy_manager.php?auction_id={$auctionRows[counter].auction_id}&encoded_string={$encoded_string}" class="view_link"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}proxy-bid-icon.png" align="absmiddle" title="Proxy Bids" width="20" height="16" border="0" /></a>												
													{/if}
													{if $search == 'selling' && $auctionRows[counter].is_big=='1'}
													<input type="checkbox" name="home_slider" id="home_slider_{$auctionRows[counter].auction_id}" value="{$auctionRows[counter].auction_id}" onclick="set_for_homepage(this.value)" {if $auctionRows[counter].is_set_for_home_big_slider=='1'} checked="checked" {/if} />
													{/if}
												</td>
											</tr>
										{/section}
										<tr class="header_bgcolor" height="26">
											<!--<td align="left" class="smalltext">&nbsp;</td>-->
											<td align="left" colspan="2" class="headertext">{$pageCounterTXT}</td>
											<td align="right" {if $smarty.request.search == ''}colspan="3"{else}colspan="2"{/if} class="headertext">{$displayCounterTXT}</td>
										</tr>
									</tbody>
								</table>
								<!--<table width="70%" border="0" cellspacing="1" cellpadding="2" class="">
									<tr>
										<td width="8%" align="center"><img src="{$smarty.const.CLOUD_STATIC_ADMIN}arrow_ltr.png" alt="" align="absmiddle" border="0" /></td>
										<td class="smalltext">
											<a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<select name="mode" class="look" onchange="javascript: this.form.submit();" >
												<option value="" selected="selected">With Selected</option>
													<option value="set_active_all">Set Active</option>
													<option value="set_inactive_all">Set Inactive</option>
													<option value="delete_all">Delete</option>
											</select>
										</td>
									</tr>
								</table>-->
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