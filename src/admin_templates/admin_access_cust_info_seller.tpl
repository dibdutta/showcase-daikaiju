{include file="admin_header.tpl"}
<link rel="stylesheet" href="{$actualPath}/javascript/datepicker/jquery.datepick.css" type="text/css" />
<script type="text/javascript" src="{$actualPath}/javascript/datepicker/jquery.datepick.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
{literal}
<script type="text/javascript">
	$(document).ready(function() {				   
		$(function() {
			$("#start_date").datepick();
			$("#end_date").datepick();
		});
	});
	function viewInvoiceDetails(invoice_id,inv_no){
	    //var inv_no = parseInt(inv_no);
		var invoiceid = " (Invoice - "+inv_no+")";
		//alert(inv_no);
		$("#invoice").text(invoiceid);
		$('#righttable').html("<table cellpadding='0' cellspacing='0' width='100%' class='Container'  align='center'><tr><td align='center' ><img id='img' alt='' src='https://c4808190.ssl.cf2.rackcdn.com/ajax-loading.gif'  /></tr></td></table>");		
		
		$.get("admin_access_cust_info.php?mode=fetch_invoice", { invoice_id :invoice_id },
			function(data) {				
                $("#righttable").html(data);				
			});
		
	}
	function autocom(q){
	var url = "../ajax.php?mode=autocomplete_admin&q=" + q;
	jQuery.ajax({
  	type : 'GET',
  	url : url,
  	data: {
 	 },
 	 beforeSend : function(){
   		//loading
  		},
  	 success : function(data){
	  if(data!=''){
	 	$("#auto_load").show();
   		$("#auto_load").html(data);
		}else{
		$("#auto_load").hide();
		}
  	},
  	error : function(XMLHttpRequest, textStatus, errorThrown) {
  	}
	});
	} 
	function set_result(name,id){
		document.getElementById('user').value=name;
		document.getElementById('user_id').value=id;
		$("#auto_load").hide();
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
  function reset_date(ele) {
		    $(ele).find(':input').each(function() {
		        switch(this.type) {
	            	case 'text':	            	
		                $(this).val('');
		                break;    
		            
		        }
		    });
		    
		}
	function view_all(){
  	window.location.href="admin_access_cust_info.php?mode=seller";
  }	
  function fancy_images(){
    $("#various").fancybox({
        'width'				: '75%',
        'height'			: '80%',
        'autoScale'			: false,
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'type'				: 'iframe'
    });
}
  function view_seller(id){
    window.location.href="admin_report_manager.php?mode=auction_report&search=reconciliation&user_id="+id;
  }
  function notify_buyer(){
        var is_notify=confirm("Are you sure to reissue the invoice?");
        if(is_notify){
            var invoice_id=$("#invoice_id").val();
            $.get("admin_auction_manager.php?mode=notify_buyer", {invoice_id :invoice_id },
                    function(data) {
                            alert("Successfully issued.");

                    });
        }
  }
  function markPaid(){
  	var is_notify=confirm("Are you sure to mark the invoice as paid?");
        if(is_notify){
            var invoice_id=$("#invoice_id").val();
            $.get("admin_manage_auction_week.php?mode=mark_paid_seller_invoice", {invoice_id :invoice_id },
                    function(data) {
					      if(data==1){
						        $("#paid").hide();
								alert("Successfully marked as Paid.");
							}else{
								alert("Falied to mark as Paid.");
							}

                    });
        }
  }
  function markShipped(){
  	var is_notify=confirm("Are you sure to mark the invoice as shipped?");
        if(is_notify){
            var invoice_id=$("#invoice_id").val();
            $.get("admin_manage_auction_week.php?mode=mark_shipped_buyer_invoice", {invoice_id :invoice_id },
                    function(data) {
					    if(data==1){
						$("#shipped").hide();
                            alert("Successfully marked as Shipped.");
						 }else{
							alert("Falied to mark as Shipped.");
						 }

                    });
        }
  }
  function editNote(){
  	var note=$("#note").text();
	$("#note").html('<textarea id="niteText">'+note+'</textarea>');
  }
  
  function updateNote(){
  	var note=$("#niteText").val();
	if(note!=''  || note!='undefined'){
			var invoice_id=$("#invoice_id").val();
            var auction_id=$("#auction_id").val();
            $.get("admin_auction_manager.php?mode=add_note", {invoice_id :invoice_id ,auction_id:auction_id,note:note},
                    function(data) {
							$("#note").text(note);
                            alert("Successfully note updated.");
                    });
		}else{
			alert("Please update note");
		}
  }
  
  function print_all(){
  	var selected = [];
	$('.altbg input:checked').each(function() {
		selected.push($(this).attr('value'));
	});
	if(selected.length >0){
		window.open("/admin/admin_auction_manager.php?mode=invoice_bulk&invoice_Arr="+selected);
	}
  }
  
  function reset(){
   if(confirm("Confirm Reset to $0")){
		$.get("admin_access_cust_info.php?mode=mark_shipping_claimed",
			function(data) {								
					alert("Successfully reset to $0.");				 
			});
		$("#total_shipping").val('$0')
	}
  }
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
        {if $errorMessage<>""}
        <tr id="errorMessage">
          <td width="90%" align="center"><div class="messageBox">{$errorMessage}</div></td>
        </tr>
        {/if}
        <tr>
          <td width="100%"><form action="" method="get" onsubmit="return test();">
		     <input type="hidden" name="mode" value="seller" >
              <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor cutomersection" >
                <tr class="">
                  <td  align="left" style="width:130px;"><label>Customer Name</label>
                    <div class="UserNameSearch" style="position:relative;">
                      <div>
                        <input type="text" name="user" id="user"  class="look inputBox_long" value="{$smarty.request.user}"  onkeyup="autocom(this.value);" />
                      </div>
                      <div id="auto_load" style="width:150px; position:absolute; z-index:100px; top:20px; left:0px; background-color:#CCCCCC; display:none;"></div>
                      <input type="hidden" name="user_id" id="user_id" value="{$smarty.request.user_id}"  class="look inputBox_long"/>
                      <span class="err">{$user_id_err}</span> </div>
                    <!--<label class="rightaligned">Type</label>
                    <select>
                      <option>Buyer</option>
                    </select>-->
                  </td>
                </tr>
                <tr>
                  <td><label>Filter by Date</label>
                    <label class="small">From</label>
                    <input type="text" id="start_date" name="start_date" value="{$start_date_show}"  class="look inputBox_small"/>
                    <label class="small">to</label>
                    <input type="text" id="end_date" name="end_date" value="{$end_date_show}"  class="look inputBox_small"/>
					<label class="small">Type</label>
					<select name="invoice_type">
						<option value="">Select</option>
						<option value="paid" {if $smarty.request.invoice_type=='paid'}selected='selected'{/if}>Paid</option>
						<option value="unpaid" {if $smarty.request.invoice_type=='unpaid'}selected='selected'{/if}>Unpaid</option>
						<option value="shipped" {if $smarty.request.invoice_type=='shipped'}selected='selected'{/if}>Shipped</option>
						<option value="notshipped" {if $smarty.request.invoice_type=='notshipped'}selected='selected'{/if}>Not Shipped</option>
					</select>
					<input type="submit" class="submitbtn" value="Submit" />
					<input type="button" class="submitbtn" value="Reset" onclick="reset_date(this.form)"/>
					<input type="button" class="submitbtn" value="View All" onclick="view_all()"/>
                  </td>
                </tr>
              </table>
			  </form>
              <table align="center" width="90%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor" >
                <tr>
                  <td><div class="lefttable">
                      <h2>MPE Invoice History</h2>
					  <input type="button" class=" cutomersection submitbtn" value="Seller Info" onclick="view_seller({$user_new_id})"/>
					   <input type="button" class=" cutomersection submitbtn" value="Print All" onclick="print_all()"/>
					   <input onClick="setAllCheckboxes(this.id);" type="checkbox" id="them" />All of them
					   &nbsp&nbsp <input  value="${$shipping}" readonly style="width:100px;" id="total_shipping" /> <input type="button" class="submitbtn" value="Reset" onclick="reset()"/>
                      <table width="100%" border="0" cellspacing="1" cellpadding="0" class="smallTable">
                        <tr>
						  <th width="45%">Invoice Number</th>
                          <th style="width:25%;">Date</th>                          
                          <th>Customer</th>
                          <th>Amount</th>
                        </tr>
                        <tr>
                          <td colspan="4" style="padding:5px 0;"><div class="scroll"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  {section name=counter loop=$invoiceData} 
                              <tr class="altbg">
                                <td style="width:45%;"><input type="checkbox" name="inv" class="inv" value="{$invoiceData[counter].invoice_id}"  />&nbsp;<a href="javascript:void(0)" onclick="viewInvoiceDetails({$invoiceData[counter].invoice_id},'{$invoiceData[counter].auction_actual_end_datetime|date_format:"%m%d%Y"}-{$invoiceData[counter].inv_no}')">{$invoiceData[counter].auction_actual_end_datetime|date_format:"%m%d%Y"}-{$invoiceData[counter].inv_no} </a>
								{if $invoiceData[counter].is_combined=='1'}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}combined.png" alt="Combined" title="Combined">
									{else}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_combined.png" alt="Combined" title="Not Combined">
								{/if}
								{if $invoiceData[counter].is_approved=='1' || $invoiceData[counter].is_paid=='1'}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}approved.png" alt="Combined" title="Approved">
									{else}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_approved.png" alt="Combined" title="Not Approved">
								{/if}
								&nbsp;
								{if $invoiceData[counter].is_paid=='1'}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}paid.png" alt="Combined" title="Paid on {$invoiceData[counter].paid_on|date_format:"%m/%d/%Y"}">
								{else}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}unpaid.png" alt="Combined" title="Not Paid">
								{/if}
								&nbsp;
								{if $invoiceData[counter].is_shipped=='1'}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}shipped.png" alt="Combined" title="Shipped on {$invoiceData[counter].shipped_date|date_format:"%m/%d/%Y"}">
									{else}
									<img src="{$smarty.const.CLOUD_STATIC_ADMIN}not_shipped.png" alt="Combined" title="Not Shipped">
								{/if}
								</td>
								
                                <td style="width:25%;">&nbsp;{if $smarty.request.invoice_type=='paid'} {$invoiceData[counter].paid_on|date_format:"%m/%d/%Y"}{else}{$invoiceData[counter].invoice_generated_on|date_format:"%m/%d/%Y"} {/if}</td>
                                <td style="width:20%;">{$invoiceData[counter].firstname}&nbsp;{$invoiceData[counter].lastname}</td>
                                <td style="width:10%;">${$invoiceData[counter].total_amount}</td>
                              </tr>
							  {assign var="total" value=$total+$invoiceData[counter].total_amount}
                           {/section}   
                            </table></div></td>
                        </tr>
                      </table>
					  <table width="100%" border="0" cellspacing="1" cellpadding="0" class="smallTable">
					  <tr class="bgcolr">
                        	<td align="right" colspan="4" >Overall Purchase Total</td>
                            <td align="right">${$total|number_format:2}&nbsp;&nbsp;</td>
                        </tr>
					  <tr class="header_bgcolor" height="26">
							<!--<td align="left" class="smalltext">&nbsp;</td>-->
							<td align="left" colspan="4" class="headertext">{$pageCounterTXT}</td>
							<td align="right" {if $smarty.request.search == 'fixed_price'}colspan="2"{else}colspan="5"{/if} class="headertext">{$displayCounterTXT}</td>
						</tr>
					  </table>
                    </div>
                    <div class="righttable" >
                    	<h2>Invoice Details <span id="invoice"> </span></h2>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="smallTable" id="righttable">
                       
                        </table>
                    </div></td>
                </tr>
                <tr>
                  <td id='start_date_td' style="padding:5px 0 0 0;" align="right" valign="top"></td>
                </tr>
              </table>
            </td>
        </tr>
        
      </table></td>
  </tr>
</table>
{literal}
<script>
function setAllCheckboxes(id){

var val = $("#"+id).val();
if( $("#"+id).is(":checked") ) {
	$('.inv').each(function(){ //iterate all listed checkbox items
        this.checked = true; //change ".checkbox" checked status
    });	
}
else {
	$('.inv').each(function(){ //iterate all listed checkbox items
        this.checked = false; //change ".checkbox" checked status
    });
}

}
</script>
{/literal}
{include file="admin_footer.tpl"}