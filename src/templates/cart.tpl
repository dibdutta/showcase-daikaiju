{include file="header.tpl"}
{literal}
<script  type="text/javascript">
function updateCart(){
 var quantityArr = new Array();
 var amountArr = new Array();
 var auctionArr = new Array();
 var i=0;
	$(".quantity").each(function(index,element) { 
		quantityArr[i] = element.value;
		i++;
	});
 var j=0;
 		
	$.each($('.amount'), function() { 
    amountArr[j]=$(this).html();
		j++;
	});
 var m = 0;	
	$.each($('.auction_id'), function() { 
    auctionArr[m]=$(this).html();
		m++;
	});
	
var sum = 0;	
	for(var k=0;k<amountArr.length;k++){
		sum +=parseFloat(amountArr[k])* parseInt(quantityArr[k]);
	}
	var url = "ajax.php?mode=updateSession&auctionArr=" + auctionArr+"&amountArr="+amountArr+"&quantityArr="+quantityArr;
	jQuery.ajax({
  	type : 'GET',
  	url : url,
  	data: {
 	 },
 	 beforeSend : function(){
   		//loading
  		},
  	 success : function(data){
	 
	  if(data=='1'){
	 	$("#auto_load").show();
   		$("#auto_load").html(data);
		}else if(data=='0'){
			alert("You have exceeded max available Quantity!");
			$("#"+inputId).val('1');
		}
  	},
  	error : function(XMLHttpRequest, textStatus, errorThrown) {
  	}
	});
	
	amnt_in_dollar = '$'+sum+'.00'
	$("#total_amount").text(amnt_in_dollar);
 }
function chkQuantity(id,quantity,inputId){
 	
	var url = "ajax.php?mode=chkQuantity&id=" + id+"&quantity="+quantity;
	jQuery.ajax({
  	type : 'GET',
  	url : url,
  	data: {
 	 },
 	 beforeSend : function(){
   		//loading
  		},
  	 success : function(data){
	 
	  if(data=='1'){
	 	
		}else if(data=='0'){
			alert("You have exceeded max available Quantity!");
			$("#"+inputId).val('1');
		}
  	},
  	error : function(XMLHttpRequest, textStatus, errorThrown) {
  	}
	});
	
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
      <!--Header Theme Starts-->
       		 
      <!--Header Theme Ends-->
    </div>
    <!--Header themepanel Ends-->
    
    <div id="inner-container">
    {include file="right-panel.tpl"}
    <div id="center"><div id="squeeze"><div class="right-corner">
    
    	<div id="inner-left-container">
			 {*<div id="tabbed-inner-nav">
             	<div class="tabbed-inner-nav-left">
             	<ul class="menu">
                	<li><a href="{$actualPath}/send_message.php"><span>Inbox</span></a></li>
                    <li class="active"><a href="{$actualPath}/send_message.php?mode=sent_messages"><span>Sent Items</span></a></li>
                    <li><a href="{$actualPath}/send_message.php?mode=compose&encoded_string={$encoded_string}"><span>Compose</span></a></li>
                </ul>
                
 				
                </div>	
             </div>*}
            <div id="tabbed-inner-nav">
            <div class="tabbed-inner-nav-left">
                    <ul class="menu">
                        <li class="active"><a href="{$actualPath}/cart.php"><span>My Shopping Cart</span></a></li>
                        
                    </ul>
                    
                </div>
                 </div>
            <div class="innerpage-container-main">
            <div class="top-mid"><div class="top-left"></div></div>
                
            	
                 <div class="left-midbg"> 
                    <div class="right-midbg">  
                <div class="mid-rept-bg">
                <!--    inner listing starts--> 
				<input type="hidden" name="checkcart" value="{$total}"  />
                  {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}                   
				  {if $total>0}
                  	<div class="display-listing-main">
                    <div>
                        <div class="gnrl-listing">
                        <div style="margin: 20px 0 0 0;">
                            <form name="listFrom" id="listForm" action="" method="post">
                            <input type="hidden" name="mode" value="update_cart" />
                            <table width="100%" cellpadding="3" cellspacing="1" align="center" border="0">
                                <!--<tr>
                                    <td colspan="3" width="100%"><strong>Your Shopping Cart</strong><br /><br /></td>
                                </tr>-->
                                <tr>
                                    <th width="15%" align="left"><strong>Remove</strong></th>
                                    <th width="55%" align="left"><strong>Poster</strong></th>
                                    <th width="30%" align="left"><strong>Amount</strong></th>
									
                                </tr>
                                {section name=counter loop=$cart}
                                <tr>								    
                                    <td align="left"><input type="checkbox" name="auction_ids[]" value="{$cart[counter].auction_id}" class="checkBox" /></td>
                                    <td align="left" class="text"><span style="cursor:pointer;" onclick="redirect_poster_details({$cart[counter].auction_id});">{$cart[counter].poster_title}&nbsp;</span></td>
                                    <td align="" class="text">
									{if $cart[counter].fk_auction_type_id =='6'}
									 $<span class="amount">{$cart[counter].auction_asked_price|number_format:2} </span>
									  {assign var="alternative" value='1'}
									    <span style="display:none;" class="auction_id">{$cart[counter].auction_id}</span>
										<div> QTY:&nbsp;<input type="text" id="quantity_{$cart[counter].auction_id}" name="quantity" value="{$cart[counter].quantity}" style="width:50px;" class="alternative quantity" onkeyup="chkQuantity({$cart[counter].auction_id},this.value,this.id);" /> </div>
									{else}
									    $<span class="amount">{$cart[counter].auction_asked_price|number_format:2} </span>									  
									    <span style="display:none;" class="auction_id">{$cart[counter].auction_id}</span>
										<div> <input type="hidden" id="quantity_{$cart[counter].auction_id}" name="quantity" value="{$cart[counter].quantity}" style="width:50px;" class="alternative quantity"  /> </div>
										
									{/if}	
									</td>
                                </tr>
                                {assign var="totalAmt" value=$totalAmt+$cart[counter].amount}
                                {/section}
                                <tr>
                                	<td colspan="2" align="right" class="text bold" style="border-top:2px solid #333333;">Total</td>
                                    <td align="left" style="border-top:2px solid #333333;"><span id="total_amount">${$totalAmt|number_format:2}</span>
									{if $alternative =='1'}
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span><a href="#" onclick="javascript: updateCart(); return false;" class="new_link">Update Cart</a></span>
									{/if}
									</td>
                                </tr>
								<tr>
								<td colspan="3">
								<div class="left-area">
                         	<div class="results-area">
                        	<span><a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											</span>
                           </div>
                            </div>
								</td>
								</tr>
                                <tr>                                	
                                   <td colspan="3" align="center" style="padding:10px;"><input type="submit" value="Clear from Cart" class="track-btn"  />&nbsp;<input type="button" value="Continue Shopping" class="track-btn"  onclick="$(location).attr('href', '{$actualPath}/buy.php');" />&nbsp;<input type="button" value="CONTINUE TO CHECKOUT" class="track-btn"   onclick="$(location).attr('href', '{$actualPath}/my_invoice.php?mode=generate_buy_now_invoice');" /></td>
                                </tr>
                            </table>
                            </form>   
                            </div>                        
                        </div>     
                       </div> 
                       
						<div style="clear:both;height: 0"></div>
						<div style="margin:0 auto; overflow:hidden;">
							<div style="float:left; margin-top:10px;">
							                       
								<div >
									<img src="../images/comodo_secure.png" >
								</div>
								
		                     				
							</div>
							<div style="float:left; margin:10px 0 0 5px;">
								<a href="https://www.paypal.com/us/verified/pal=info%40movieposterexchange%2ecom" target="_blank"><img src="../images/verification_seal.png" border="0" alt="Official PayPal Seal"></A>
							</div>
						</div>
						<div style="clear:both;height: 0"></div>
                                        
                  	</div>                       
                  {else}
                    <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                    	<tr>
                    		<td align="center" style="font-size:32px; text-align:center; padding:30px; border-bottom:1px dashed #C8C8C8;">Cart is empty.</td>
                    	</tr>
                        
                    	<tr>
                    		<td align="center" style="text-align:center;">
                           
							<div style="margin-top:10px;">
								<div>
								
								<a href="https://www.paypal.com/us/verified/pal=info%40movieposterexchange%2ecom" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/verification_seal.png" border="0" alt="Official PayPal Seal"></a>
								</div>
							</div>
                        </td>
                    	</tr>
                        
					</table>
                  {/if}
                  {if $count_sold_item >0}
                  <div class="display-listing-main">
                  <div>
                  <div class="gnrl-listing"> 
                    <div style="margin:0 0 0 12px;">
                  	<table width="550px" cellpadding="3" cellspacing="1" align="center" border="0">
                    	<tr>
                    		<td colspan="3" align="center" style="font-size:11px; font-weight:bold;color:red;">This cart items are already opted for Buy Now.</td>
                    	</tr>
                    	<tr>
                             <td width="55%" align="left"><strong>Poster</strong></td>
                             <td width="30%" align="left" colspan="2"><strong>Amount</strong></td>
                        </tr>
                   {section name=counter loop=$sold_item}
                        <tr>
<!--                             <td align="left"><input type="checkbox" name="auction_ids[]" value="{$cart[counter].auction_id}" class="checkBox" /></td>-->
                             <td align="left" class="text">{$sold_item[counter].poster_title}&nbsp;</td>
                             <td align="" class="text" colspan="2">${$sold_item[counter].amount|number_format:2}</td>
                        </tr>
                    {assign var="totalSoldAmt" value=$totalSoldAmt+$sold_item[counter].amount}
                    {/section}
                        <tr>
                             <td  align="right" class="text bold">Total</td>
                             <td align="left" colspan="2">${$totalSoldAmt|number_format:2}</td>
                             </tr>     
					</table>
                    </div>
				  </div>   
                  </div>                    
                  </div>            
                  {/if}  
                  <div class="clear"></div>                
                </div>
                </div>
                </div>
                
                <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
            </div>
        </div>  
        
          </div></div></div>   
          
          
       
    </div>   
    {include file="gavelsnipe.tpl"} 
    </div>
    <!--<div class="clear"></div>-->
    
</div>


{include file="foot.tpl"}