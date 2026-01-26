{include file="admin_header.tpl"}
{literal}
 <script type="text/javascript">
  function delete_offer_details(id){
   var status = confirm("Are you sure that you want to clear all offers ?");
   if(status == true){
       $.post("admin_auction_manager.php", { mode: "clearOffer", auction_id: id },
       function(data) {
      if(data == "1"){
       $("#list_offer").html("");
       $("#clear_button").html("");
       $("#offer_details").html("");       
       alert("All offers has been deleted successfully");
      }
      });
   }
  }
 </script>

{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td width="100%">
   <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                 <td width="100%" align="center"><a href="#" onclick="javascript: location.href='{$actualPath}{$decoded_string}';" class="action_link"><strong>&lt;&lt; Back</strong></a></td>
                </tr>
                {if $errorMessage<>""}
                    <tr id="errorMessage">
                        <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
                    </tr>
                {/if}
                <tr>
                    <td align="center">
                        <div id="messageBox" class="messageBox" style="display:none;"></div>
                        <form name="listFrom" id="listForm" action="" method="post">
                            <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>
                                    <tr class="header_bgcolor" height="26">
                                        <!--<td align="center" class="headertext" width="6%"></td>-->
                                        <td align="center" class="headertext" width="15%">Poster</td>
                                        <td align="center" class="headertext" width="12%">Pricing</td>
                                        
                                        
                                    </tr>
         <tr id="tr_{$auctionArr[counter].auction_id}" class="{cycle values="odd_tr,even_tr"}">
                                        <!--<td align="center" class="smalltext"><input type="checkbox" name="poster_ids[]" value="{$posterRows[counter].poster_id}" class="checkBox" /></td>-->
                                        <td align="center" class="smalltext"><img src="{$auctionArr[0].image_path}"  /><br />{$auctionArr[0].poster_title}<br /><b>SKU: </b>{$auctionArr[0].poster_sku}</td>
                                        <td align="center" class="smalltext">Ask Price : ${$auctionArr[0].auction_asked_price|number_format:2}<br/>{if $auctionArr[0].auction_reserve_offer_price > 0}&nbsp;Will consider offers{/if}</td>
                                         
                                        
         </tr>          
                                </tbody>
                            </table>
                        </form>
                    </td>
                </tr>
              
     <tr>
                     <td align="left" id="list_offer">
                            <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                                <tbody>
                                    <tr class="header_bgcolor" height="26">
                                            <td align="center" class="headertext" width="10%">Buyer</td>
                                            <td align="center" class="headertext" width="17%">Date</td>
                                            <td align="center" class="headertext" width="17%">Amount</td>
                                            <td align="center" class="headertext" width="12%">Action</td>
                                        </tr>
                                    {section name=counter loop=$dataArr}
                                        
                                        <tr class="{cycle values="odd_tr,even_tr"}">
                                            <td align="center" class="smalltext">&nbsp;{$dataArr[counter].firstname} {$dataArr[counter].lastname}</td>
                                            <td align="center" class="smalltext">{$dataArr[counter].invoice_generated_on|date_format:"%m/%d/%Y"} </td>
                                            <td align="center" class="smalltext">${$dataArr[counter].total_amount} </td>
                                            <td align="center" class="smalltext"><a href="{$actualPath}/admin/admin_alternate_poster.php?mode=manage_invoice_alternative&invoice_id={$dataArr[counter].invoice_id}"><img alt="" src="{$smarty.const.CLOUD_STATIC_ADMIN}invoiceButton.PNG" width="20" title="View Invoice Buyer"  border='0'></a>
                                             &nbsp;
                                            </td>
                                            
                                        </tr>
                                    {/section}
                                    <tr class="header_bgcolor" height="26">
                                        <td align="left" class="smalltext">&nbsp;</td>
                                        <td align="left" class="headertext" colspan="2"></td>
                                        <td align="right" class="headertext"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
    
    <tr>
     <td>&nbsp;</td>
    </tr>
                {*<tr>
                 <td align="center" ><input type="button" name="cancel" value="Back" class="button" onclick="javascript: location.href='{$actualPath}{$decoded_string}'; " /></td>
                </tr>*}
   </table>
  </td>
 </tr>  
</table>
{include file="admin_footer.tpl"}