<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
session_start();
header('content-type: application/x-javascript;');
$random = (empty($_POST['random']))? rand(999, 999999) : $_POST['random'];
?>

function popupWindow(path, where, hite, wide){
    if (window.event){ 
        window.event.returnValue = false;   
    }
    var width;
    var height;
    var imgWidth;
    var imgHeight;
    
    if (screen.width<wide){
        width=screen.width-20;
        imgWidth=width-10;
        var windowX = (screen.width-width)/2;
    }
    else{
        var windowX = (screen.width-wide)/2;
        width=wide;
    }

    if (screen.height<hite){
        height=screen.height-70;
        imgHeight=height-20;
        var windowY = (screen.height-height)/2-30;
    }
    else{
        var windowY = (screen.height-hite)/2-10;
        height=hite;
    }

    var rand_no = Math.random();
    var i = Math.round(100*Math.random());
    if(screen.height<hite || screen.width<wide){
        var props=window.open(path, i, 'scrollbars=1,toolabars=0,resizable=0,status=0,menubar=0,directories=0,location=0,height='+(hite+30)+', width='+(wide+30));
    }
    else{
        var props=window.open(path, i, 'scrollbars=1,toolabars=0,resizable=1,status=0,menubar=0,directories=0,location=0,height='+(hite+30)+', width='+(wide+30));
    }
    props.moveTo(windowX,windowY);
}

var marked_row = new Array;

function markAllSelectedRows(container_id) {
    
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            if ( checkbox.disabled == false ) {
                checkbox.checked = true;
                if ( typeof(marked_row[unique_id]) == 'undefined' || !marked_row[unique_id] ) {
                    rows[i].className += ' selected_bg';
                    marked_row[unique_id] = true;
                }
            }
        }
    }
    return true;
}

function markAllSelectedRowsDiv(container_id) {
    
    var rows = document.getElementById(container_id).getElementsByTagName('div');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            if ( checkbox.disabled == false ) {
                checkbox.checked = true;
                if ( typeof(marked_row[unique_id]) == 'undefined' || !marked_row[unique_id] ) {
                    rows[i].className += ' selected_bg';
                    marked_row[unique_id] = true;
                }
            }
        }
    }
    return true;
}

function unmarkAllSelectedRowsDiv(container_id) {

    var rows = document.getElementById(container_id).getElementsByTagName('div');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            if ( checkbox.disabled == false ) {
                checkbox.checked = false;
                if ( typeof(marked_row[unique_id]) == 'undefined' || !marked_row[unique_id] ) {
                    rows[i].className += ' selected_bg';
                    marked_row[unique_id] = false;
                }
            }
        }
    }
    return true;
}

function deleteConfirmRecord(path, toDelete){
    if(confirm('Are you sure to delete this '+toDelete+'?')){
        location.href=''+path+'';
    }
    else{
        return false;   
    }
}

function unMarkSelectedRows( container_id ) {
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            checkbox.checked = false;
            rows[i].className = rows[i].className.replace(' selected_bg', '');
            marked_row[unique_id] = false;
        }
    }

    return true;
}

/******************************************************************************************************************************/

function countImage()
{
    var existingArr = $("#existing_images").val().split(',');
    var existingCount = existingArr.length - 1;
    var newArr = $("#poster_images").val().split(',');
    var newCount = newArr.length - 1;   
    return (existingCount + newCount);
}

function deletePhoto(divID, photo, type,key){
    var url = "ajax.php";
    //var request = url+"?mode=delete_poster&poster_image="+photo+"&type="+type+"&poster_id="+$('#poster_id').val();
    //alert(request);
    $.post(url, {mode: 'delete_poster', poster_image: photo, type: type,key:key, folder: $("#random").val(), poster_id: $('#poster_id').val()}, function(retunedData, textStatus){
        if(textStatus == 'success' && retunedData == 'invalid_request'){
            $("#err"+divID).html('<div class="disp-err">Last image cannot be deleted.</div>');
        }else{
            if(type == 'existing'){
            	$("#fileUploadQueue").hide();
                $("#"+divID).remove();
                $("#existing_images").val($("#existing_images").val().replace(photo+',', ""));      
            }else if(type == 'new'){
               // $("#"+divID).remove();
				//var poster_images= $("#poster_images").val();
				
				//var posterImg = poster_images.replace(photo,"");
				
				//document.getElementById("poster_images").value=posterImg;
				$("#fileUploadQueue").hide();
                $("#"+divID).remove();
                $("#poster_images").val($("#poster_images").val().replace(photo+',', ""));	
                
            }
            
			if($('input[name=is_default]')[0]!= undefined)
            {
				$('input[name=is_default]')[0].checked="checked";
			}
			var cnt=document.getElementById("cnt").value;
	 		cnt=Number(cnt)-1;
     		document.getElementById("cnt").value=cnt;
			$("#browse").show();
			$("#path").show();
        }
    });

}

/* Poster title autocomplete starts */

function findValue(li) {
if( li == null ) return alert("No match!");
    // if coming from an AJAX call, let's use the CityId as the value
    if( !!li.extra ) var sValue = li.extra[0];
    
    // otherwise, let's just display the value in the text box
    else var sValue = li.selectValue;
    
    //alert("The value you selected was: " + sValue);
}

function selectItem(li) {
    findValue(li);
}

function formatItem(row) {
    return row[0];
}

function lookupAjax(){
    var oSuggest = $('#poster_title')[0].autocompleter;
    oSuggest.findValue();
    return false;
}

function autoComplete(id)
{
    $('#'+id).autocomplete(
        'ajax.php?mode=autocomplete',
        {
            delay:10,
            minChars:2,
            matchSubset:1,
            matchContains:1,
            cacheLength:10,
            onItemSelect:selectItem,
            onFindValue:findValue,
            formatItem:formatItem,
            autoFill:true
        }
    );  
}

/* Poster title autocomplete ends */

/* Auction Timer functions starts */


/*function validatePostBid(auction_id)
{
	errCounter = 0;
	if(isNaN($('#bid_price_'+auction_id).val())){
    	alert("Please enter numeric value only");
        errCounter++;
    }
    
    if
    if(confirm("Please confirm your bid of $"+$('#bid_price_'+auction_id).val()+".00")){
    
    }
}
*/

function postBid(auction_id, user_id,buy_now)
{
	$("#dialog-confirm").html("");
	var bid_price= Math.floor($('#bid_price_'+auction_id).val());
    var buy_now= Math.floor(buy_now);
    var secs_left = $('#seconds_left_'+auction_id).val();
    var chk_ind=/^ *[0-9]+ *$/.test(bid_price);
    var curr_bid=$('#current_bid_'+auction_id).val();
    var curr_bid= Math.floor(curr_bid);
    var next_increment=$('#auction_increment_'+auction_id).val();
	if('<?php echo $_SESSION['sessUserID'];?>' == ''){
    	showLogIn();
        $("#bid_price_"+auction_id).val("");
        return;
	}else if('<?php echo $_SESSION['sessUserID'];?>' == user_id){
    	var txt="Seller cannot offer on his own poster";
		var clr="red";
		showalert(txt,clr,'');
        $("#bid_price_"+auction_id).val("");
        return;
    }
	if($('#bid_price_'+auction_id).val() == ''){
    	var txt="Please enter bid amount";
		var clr="red";
		showalert(txt,clr,'');
        return;
    }else if(isNaN($('#bid_price_'+auction_id).val())){
    	var txt="Please enter numeric value only";
		var clr="red";
		showalert(txt,clr,'');
        $('#bid_price_'+auction_id).val("");
        return;
    }else if( bid_price == parseFloat(bid_price) && chk_ind==false){
    	 var txt="Please enter integer value";
		 var clr="red";
		 showalert(txt,clr,'');
    	 $('#bid_price_'+auction_id).val("");
    	 return;
    }else if( bid_price < curr_bid){
    	var txt="Please enter bid amount more than next bid amount $"+curr_bid+".00";
		var clr="red";
		showalert(txt,clr,'');
        $('#bid_price_'+auction_id).val("");
        return;
    }
 
	$( "#dialog-confirm" ).dialog({
      resizable: false,
      height:140,
	  width:700,
      modal: true,
	  title:'Please confirm your bid of $'+bid_price+'.00 (Bid may not contain decimals)',
      buttons: {
        "Confirm": function() {
		  
		  if(buy_now > 1){		  	
			if(bid_price < buy_now){
				var url = "mybuying.php";   
				$.post(url, {mode : 'post_bid', auction_id : auction_id,curr_bid:curr_bid,next_increment:next_increment, bid_amount : bid_price,secs_left:secs_left}, function(data, textStatus){
		    			var txt=data;
		    			var clr="green";
					showalert(txt,clr,'');
				}); 
			}else{
       			window.location="cart.php?id="+auction_id;
       		}		  	 
		  }else{		  	
			var url = "mybuying.php";   
			$.post(url, {mode : 'post_bid', auction_id : auction_id,curr_bid:curr_bid,next_increment:next_increment, bid_amount : bid_price,secs_left:secs_left}, function(data, textStatus){
				var txt=data;
				var clr="green";
				showalert(txt,clr,'');
			});       
		  }
		  $( this ).dialog( "close" );
		  },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
    $('#bid_price_'+auction_id).val("");
}

function postOffer(auction_id, user_id,buy_now)
{

    var offer_price=Math.floor($('#offer_price_'+auction_id).val());
    var buy_now= Math.floor(buy_now);
    var chk_ind=/^ *[0-9]+ *$/.test(offer_price);
    
    if('<?php echo $_SESSION['sessUserID'];?>' == ''){
    	showLogIn();
        $('#offer_price_'+auction_id).val("");
        return;
	}else if('<?php echo $_SESSION['sessUserID'];?>' == user_id){
    	alert("Seller cannot offer on his own poster");
        $("#offer_price_"+auction_id).val("");
        return;
    }
    if($('#offer_price_'+auction_id).val() < 1){
    	alert("Please enter valid offer amount");
        return;
    }else if(isNaN($('#offer_price_'+auction_id).val())){
    	alert("Please enter integer value");
        $('#offer_price_'+auction_id).val("");
        return;
    }else if( offer_price == parseFloat(offer_price) && chk_ind==false){
    	alert("Please enter integer value");
    	$('#offer_price_'+auction_id).val("");
    	return;
    }
	if(confirm("Please confirm your offer of $"+offer_price+".00 \n (Offer may not contain decimals)")){
 
    var offer_price=Math.floor($('#offer_price_'+auction_id).val());
    if(offer_price < buy_now){
        var url = "mybuying.php";
        $.post(url, {mode : 'post_offer', auction_id : auction_id, offer_amount : offer_price}, function(data, textStatus){
            alert(data);
        });
        }else{
        	window.location="cart.php?id="+auction_id;
        }
       
    }
    $('#offer_price_'+auction_id).val("");
}

function postBuynow(auction_id)
{
    var url = "mybuying.php";
    $.post(url, {mode : 'post_buynow', auction_id : auction_id, bid_amount : $('#buynow_price_'+auction_id).val()}, function(data, textStatus){
        alert(data);
        $('#buynow_price_'+auction_id).val("");
    }); 
}

function placeAllBids(dataArr)
{

	$("#dialog-confirm").html("");
	$( "#dialog-confirm" ).dialog({
      resizable: false,
	  width:500,
	  height:140,
      modal: true,
	  title:'Please confirm your offer(s) or bid(s)',
      buttons: {
        "Confirm": function() {
			var formData = $('form').serialize();
			
			var ids = '';
			for(i=0; i<dataArr.length; i++){
				ids += dataArr[i]['auction_id'];
				if(i < (dataArr.length -1)){
					ids += ','; 
				}
			}
			
			var url = "mybuying.php?action=place_all_bids&"+formData+"&ids="+ids;
			
			$.post(url, function(data, textStatus){
				for(i=0; i<dataArr.length; i++){
					if($('#bid_price_'+dataArr[i]['auction_id']).length > 0){
						$('#bid_price_'+dataArr[i]['auction_id']).val('');
					}else if($('#offer_price_'+dataArr[i]['auction_id']).length > 0){
						$('#offer_price_'+dataArr[i]['auction_id']).val('');
					}   
				}
				var txt="Alert Confirmation";
				$("#dialog-confirm").html(data);
				var clr="green";
				showalert(txt,clr,300);
				//window.location.reload();
			})
	
		  $( this ).dialog( "close" );
		  },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
	
	
}

/* Auction Timer functions ends */

function timeLeft(dataArr,list)
{
    if(dataArr != null){
        var bidDataArr = new Array();
        var dispData = '';
        var datetime;
        var url = "ajax.php";
        var ids = ''; 
        for(var k=0; k < dataArr.length; k++){
            ids += dataArr[k]['auction_id'];
            if(k < (dataArr.length -1)){
                ids += ','; 
            }
        }
        var curr_user = '<?php echo $_SESSION['sessUserID'];?>';
        $.post(url, {mode : 'time_left', ids : ids,list:list}, function(data, textStatus){
            bidDataArr = eval(data);
            if(bidDataArr!=null){
            for(var i=0; i < bidDataArr.length; i++){
                if(parseInt(bidDataArr[i]['fk_auction_type_id']) != 1 && parseInt(bidDataArr[i]['fk_auction_type_id']) != 4){
                    try {
                    var auction_week_end_time=JSON.parse(document.getElementById('auction_week_end_time').value)
                    var auction_week_end_time_for_item= auction_week_end_time[parseInt(bidDataArr[i]['fk_auction_week_id'])]
                    var curr_time= bidDataArr[i]['current_time']
                    var date1 = new Date(auction_week_end_time_for_item);
                    var date2 = new Date(curr_time);
                    var delta = Math.floor(date1 - date2) / 1000;
                    console.log(delta)
                    if(parseInt(delta) < -3){
                        go_to_sold(parseInt(bidDataArr[i]['fk_auction_type_id']),parseInt(bidDataArr[i]['fk_auction_week_id']));
                        break;
                        }
                    }
                    catch(err) {
                        //console.log(err)
                    }    
                }
                if(parseInt(bidDataArr[i]['auction_is_sold']) != 0 && parseInt(bidDataArr[i]['auction_is_sold']) != 3 ){
                    if(parseInt(bidDataArr[i]['fk_auction_type_id']) != 1 && parseInt(bidDataArr[i]['fk_auction_type_id']) != 4){
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown('destroy');
                        $('#timer_'+bidDataArr[i]['auction_id']).hide();
                    }
                    dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold">This poster has been sold.</div>';
                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
					dispData='';
					//if(parseInt(bidDataArr[i]['auction_is_closed']) ==1 && parseInt(bidDataArr[i]['seconds_left']) > -3){
					//	go_to_sold(parseInt(bidDataArr[i]['fk_auction_type_id']),parseInt(bidDataArr[i]['fk_auction_week_id']));
					//}
                }else if(parseInt(bidDataArr[i]['auction_is_sold']) ==3){
                     dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold BigFont"><span class="message" style="color:red;margin-left:70px;">Sale is Pending.</span></div>';

                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                }else if(parseInt(bidDataArr[i]['in_cart']) ==1){
                     dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold BigFont"><span class="message" style="color:red;margin-left:70px;">Opted for Buy Now.</span></div>';

                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                }else{              
                    if(parseInt(bidDataArr[i]['offer_count']) > 0){
                        /* Offer data starts */
                        //alert(bidDataArr[i]['next_increment']);
                        var nextoffer = parseFloat(bidDataArr[i]['last_offer_amount'])+ parseFloat(bidDataArr[i]['next_increment']);
						//alert(bidDataArr[i]['auction_id']);
                        dispData = '<div class="auction-row" style="padding:0px;"><div class="buy-text bold"><span class="CurrentBidOffer"  style="font-size:12px; color:#000;">Current Offer: </span></div><div class="buy-text offer_buyprice"><input type="hidden" id="current_bid_'+bidDataArr[i]['auction_id']+'" value='+bidDataArr[i]['last_offer_amount']+'>$'+bidDataArr[i]['last_offer_amount']+'</div><div class="buy-text-detpstr" style="cursor:pointer;" onMouseOver="toggleDiv('+bidDataArr[i]['auction_id']+',1,1,1)" onMouseOut="toggleDiv('+bidDataArr[i]['auction_id']+',0,1,0)"><b class="OfferBidNumber">&nbsp;'+bidDataArr[i]['offer_count']+' Offer(s)</b></div></div>';
                        $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                        $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        /* Offer data onds */
                    }else if(parseInt(bidDataArr[i]['offer_count']) < 1){
                    	dispData = '<div class="text bold"></div>';
                        $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                        $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                    }
                    else{
                        /* Auction data starts */
                        if(parseInt(bidDataArr[i]['bid_count']) > 0){
                            var highest_user= bidDataArr[i]['highest_user'];
                        	var nextbid = parseFloat(bidDataArr[i]['last_bid_amount'])+parseFloat(bidDataArr[i]['next_increment']);
                            var winner='';
                            if(curr_user!=''){
                               if(curr_user==highest_user){
                                 var winner= "<img src='https://d2m46dmzqzklm5.cloudfront.net/images/winning-bid-img.png' alt='Winner' title='Winner'>";
                               }else{
                                 //var winner= "<img src='https://d2m46dmzqzklm5.cloudfront.net/images/winning-bid-img.png' alt='Loosing' title='Loosing'>";
                               }
                            }
                            dispData = '<div class="auction-row" style="padding:0px;"><div class="buy-text bold"><span class="CurrentBidOffer"  style="font-size:12px; color:#000;">Current Bid:</span> </div><div class="buy-text offer_buyprice"><input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="0"><input type="hidden" id="current_bid_'+bidDataArr[i]['auction_id']+'" value='+nextbid+' >$'+bidDataArr[i]['last_bid_amount']+'</div><div style="cursor:pointer;" class="buy-text-detpstr" onMouseOver="toggleDiv('+bidDataArr[i]['auction_id']+',1,0,1)" onMouseOut="toggleDiv('+bidDataArr[i]['auction_id']+',0,0,0)" >&nbsp;<b class="OfferBidNumber">'+bidDataArr[i]['bid_count']+'Bid(s)&nbsp;&nbsp;'+winner+'</b> </div><div class="buy-text-detpstr bold"><input type="hidden" id="auction_increment_'+bidDataArr[i]['auction_id']+'" value='+bidDataArr[i]['next_increment']+'><span class="nextbid">Next minimum bid needs to be $'+nextbid+'.00</span></div></div>';
                            $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                            $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        }else{
						   if(parseInt(bidDataArr[i]['fk_auction_type_id']) != 1 && parseInt(bidDataArr[i]['fk_auction_type_id']) != 4){
                           dispData = '<div class="text bold"><input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="0">Opening Bid : <span class="offer_buyprice">$'+bidDataArr[i]['auction_asked_price']+'.00 </span>&nbsp;&nbsp;<b class="OpeningBidNumber">0 Bid</b></div>';                  }else{
						   dispData = '<div class="text bold"><input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="0"></div>';
						   }
                            $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                            $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        }
                        /* Auction data ends */
                        
                        /* Auction timer starts */
                        
                        var end_datetime = dateAdd('s', bidDataArr[i]['seconds_left'], new Date());
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown('destroy');
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown({until: end_datetime});
                        
                        /* Auction timer ends */
                        
                        /* Auction endtime starts */
                        dispData = '<div class="buy-text boldItalics EDTSpace" >End Time: </div><div class="buy-text" style="float:none;">'+bidDataArr[i]['actual_end_time']+' EDT</div><div class="buy-text bold EDTSpace">'+bidDataArr[i]['actual_end_day']+'</div><div class="buy-text">'+bidDataArr[i]['actual_end_date']+'</div>';
                        $('#auction_end_time_'+bidDataArr[i]['auction_id']).html(dispData);
                        /* Auction endtime ends */
                        
                        if(parseInt(bidDataArr[i]['fk_auction_type_id']) == 3){
                            if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 && parseInt(bidDataArr[i]['auction_reserve_offer_price']) <= parseInt(bidDataArr[i]['last_bid_amount'])){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text PriceIncluded" style="font-size:11px; color:#00ff00;">(Reserve Met)</div>');
                            }else if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 && parseInt(bidDataArr[i]['auction_reserve_offer_price']) > parseInt(bidDataArr[i]['last_bid_amount'])){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice"  style="font-size:11px;">(Reserve Not Met)</div>');
                            }else if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 &&  bidDataArr[i]['last_bid_amount']==null){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice"  style="font-size:11px;">(Reserve Not Met)</div>');
                            }else{
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice" style="font-size:11px;">(No Reserve)</div>');
                            }
                        }
                    }
                }
			}
           }
		   setTimeout(function() { timeLeft(dataArr,list); }, 1500);
        });
    }
}

function timeLeftGallery(dataArr,list)
{
    if(dataArr != null){
        var bidDataArr = new Array();
        var dispData = '';
        var datetime;
        var url = "ajax.php";
        var ids = ''; 
        for(var k=0; k<dataArr.length; k++){
            ids += dataArr[k]['auction_id'];
            if(k < (dataArr.length -1)){
                ids += ','; 
            }
        }
        var curr_user = '<?php echo $_SESSION['sessUserID'];?>';
        $.get(url, {mode : 'time_left', ids : ids,list:list}, function(data, textStatus){
            bidDataArr = eval(data);
            if(bidDataArr!=null){
            
            for(var i=0; i<bidDataArr.length; i++){
                if(parseInt(bidDataArr[i]['fk_auction_type_id']) != 1 && parseInt(bidDataArr[i]['fk_auction_type_id']) != 4){
                    try {
                    var auction_week_end_time=JSON.parse(document.getElementById('auction_week_end_time').value)
                    var auction_week_end_time_for_item= auction_week_end_time[parseInt(bidDataArr[i]['fk_auction_week_id'])]
                    var curr_time= bidDataArr[i]['current_time']
                    var date1 = new Date(auction_week_end_time_for_item);
                    var date2 = new Date(curr_time);
                    var delta = (Math.floor(date1 - date2) / 1000)-37800;
                    console.log(delta)
                    if(parseInt(delta) < -3){
                        go_to_sold(parseInt(bidDataArr[i]['fk_auction_type_id']),parseInt(bidDataArr[i]['fk_auction_week_id']));
                        break;
                        }
                    }
                    catch(err) {
                        //console.log(err)
                    }    
                }
                if(parseInt(bidDataArr[i]['auction_is_sold']) != 0 && parseInt(bidDataArr[i]['auction_is_sold']) != 3 ){
                    if(parseInt(bidDataArr[i]['fk_auction_type_id']) != 1 && parseInt(bidDataArr[i]['fk_auction_type_id']) != 4){
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown('destroy');
                        $('#timer_'+bidDataArr[i]['auction_id']).hide();
                    }
                    dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold">This poster has been sold.</div>';
                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
					
                }else if(parseInt(bidDataArr[i]['auction_is_sold']) == 3){
                     dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold BigFont"><span class="message" style="color:red;margin-left:70px;"></span></div>';

                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                }else if(parseInt(bidDataArr[i]['in_cart']) ==1){
                     dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold BigFont"><span class="message" style="color:red;margin-left:70px;">Opted for Buy Now.</span></div>';

                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                }else{ 
                    if(parseInt(bidDataArr[i]['offer_count']) > 0){
                        /* Offer data starts */
                        //alert(bidDataArr[i]['next_increment']);
                        var nextoffer = parseFloat(bidDataArr[i]['last_offer_amount'])+ parseFloat(bidDataArr[i]['next_increment']);
                        dispData = '<div class="buygrid_cbid pb10"  onMouseOver="toggleDiv('+bidDataArr[i]['auction_id']+',1,1,1)" onMouseOut="toggleDiv('+bidDataArr[i]['auction_id']+',0,1,0)" style="cursor:pointer;" >Current Offer:<input type="hidden" id="current_bid_'+bidDataArr[i]['auction_id']+'" value='+bidDataArr[i]['last_offer_amount']+'><strong>$'+bidDataArr[i]['last_offer_amount']+'&nbsp;&nbsp;'+bidDataArr[i]['offer_count']+' Offer(s)</strong></div>';
                        $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                        $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        /* Offer data onds */
                    }else if(parseInt(bidDataArr[i]['offer_count']) < 1){
                    	dispData = '<div class="text bold"></div>';
                        $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                        $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                    }
                    else{
                        /* Auction data starts */
                        if(parseInt(bidDataArr[i]['bid_count']) > 0){
                            var highest_user= bidDataArr[i]['highest_user'];
                        	var nextbid = parseFloat(bidDataArr[i]['last_bid_amount'])+parseFloat(bidDataArr[i]['next_increment']);
                            var winner='';
                            if(curr_user!=''){
                               if(curr_user==highest_user){
                                 var winner= "<img src='https://d2m46dmzqzklm5.cloudfront.net/images/winning-bid-img.png' alt='Winner' title='Winner'>";
                               }else{
                                 //var winner= "<img src='https://d2m46dmzqzklm5.cloudfront.net/images/winning-bid-img.png' alt='Loosing' title='Loosing'>";
                               }
                            }
                            dispData = '<div class="buygrid_cbid pb05 mt10">Current: <input type="hidden" id="seconds_left_'+bidDataArr[i]['auction_id']+'" value="'+bidDataArr[i]['seconds_left']+'" ><input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="0"><input type="hidden" id="current_bid_'+bidDataArr[i]['auction_id']+'" value='+nextbid+' >$'+bidDataArr[i]['last_bid_amount']+'</div><div style="cursor:pointer;" class="buygrid_cbid2 pb05 mt10" onMouseOver="toggleDiv('+bidDataArr[i]['auction_id']+',1,0,1)" onMouseOut="toggleDiv('+bidDataArr[i]['auction_id']+',0,0,0)"  ><strong>&nbsp;'+bidDataArr[i]['bid_count']+'Bid(s)&nbsp;&nbsp;</strong></div><div class="buygrid_cbid2 pb05 mt08 ">'+winner+'</div><input type="hidden" id="auction_increment_'+bidDataArr[i]['auction_id']+'" value='+bidDataArr[i]['next_increment']+'><div class="buygrid_cbid3 pb10">Next minimum needs to be <strong>$'+nextbid+'.00</strong></div>';
                            $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                            $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        }else{
                           dispData = '<div class="text bold"><input type="hidden" id="seconds_left_'+bidDataArr[i]['auction_id']+'" value="'+bidDataArr[i]['seconds_left']+'" ><input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="0"></div>';
                            $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                            $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        }
                        /* Auction data ends */
                        
                        /* Auction timer starts */
                        
                        var end_datetime = dateAdd('s', bidDataArr[i]['seconds_left'], new Date());
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown('destroy');
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown({until: end_datetime});
                        
                        /* Auction timer ends */
                        
                        /* Auction endtime starts */
                        dispData = '<div class="buy-text boldItalics EDTSpace">End Time:</div><div class="buy-text" style="float:none;">'+bidDataArr[i]['actual_end_time']+' EDT</div><div class="buy-text bold EDTSpace">'+bidDataArr[i]['actual_end_day']+'</div><div class="buy-text">'+bidDataArr[i]['actual_end_date']+'</div>';
                        $('#auction_end_time_'+bidDataArr[i]['auction_id']).html(dispData);
                        /* Auction endtime ends */
                        
                        if(parseInt(bidDataArr[i]['fk_auction_type_id']) == 3){
                            if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 && parseInt(bidDataArr[i]['auction_reserve_offer_price']) <= parseInt(bidDataArr[i]['last_bid_amount'])){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text PriceIncluded"  style="font-size:11px; color:#00ff00;">(Reserve Met)</div>');
                            }else if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 && parseInt(bidDataArr[i]['auction_reserve_offer_price']) > parseInt(bidDataArr[i]['last_bid_amount'])){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice"  style="font-size:11px;">(Reserve Not Met)</div>');
                            }else{
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice"  style="font-size:11px;">(No Reserve)</div>');
                            }
                        }
                    }
                }
            }
           }
		   setTimeout(function() { timeLeftGallery(dataArr,list); }, 1500);
        });
    }
}

function timeLeftPosterDetails(dataArr)
{
    if(dataArr != null){
        var bidDataArr = new Array();
        var dispData = '';
        var datetime;
        var url = "ajax.php";
        var ids = ''; 
		var list = "details";
        for(var k=0; k<dataArr.length; k++){
            ids += dataArr[k]['auction_id'];
            if(k < (dataArr.length -1)){
                ids += ','; 
            }
        }
        var curr_user = '<?php echo $_SESSION['sessUserID'];?>';
        $.get(url, {mode : 'time_left', ids : ids,list:list}, function(data, textStatus){
            bidDataArr = eval(data);
            for(var i=0; i<bidDataArr.length; i++){
                if(parseInt(bidDataArr[i]['auction_is_sold']) != 0 && parseInt(bidDataArr[i]['auction_is_sold']) != 3){
                    if(parseInt(bidDataArr[i]['fk_auction_type_id']) != 1 && parseInt(bidDataArr[i]['fk_auction_type_id']) != 4){
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown('destroy');
                        $('#timer_'+bidDataArr[i]['auction_id']).hide();
                    }

                    dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold BigFont"><span class="message">This poster has been sold.</span></div>';

                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
					if(parseInt(bidDataArr[i]['auction_is_closed']) ==1 && parseInt(bidDataArr[i]['seconds_left']) > -3){
						go_to_sold(parseInt(bidDataArr[i]['fk_auction_type_id']),parseInt(bidDataArr[i]['fk_auction_week_id']));
					}
                }else if(parseInt(bidDataArr[i]['auction_is_sold']) == 3){
                     dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold BigFont"><span class="message" style="color:red;margin-left:70px;">Sale is Pending.</span></div>';

                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                }else if(parseInt(bidDataArr[i]['in_cart']) ==1){
                     dispData = '<input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="1"><div class="text bold BigFont"><span class="message" style="color:red;margin-left:70px;">Opted for Buy Now.</span></div>';

                    $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                }else{ 
                    if(parseInt(bidDataArr[i]['offer_count']) > 0){
                        /* Offer data starts */
                        //alert(bidDataArr[i]['next_increment']);
                        var nextoffer = parseFloat(bidDataArr[i]['last_offer_amount'])+ parseFloat(bidDataArr[i]['next_increment']);
                        dispData = '<div class="auction-row" style="position:relative; cursor:pointer;"><div class="buy-text bold"><span class="CurrentBidOffer" style="font-size:12px; color:#000;">Current Offer:</span></div><div class="buy-text offer_buyprice"><input type="hidden" id="current_bid_'+bidDataArr[i]['auction_id']+'" value='+bidDataArr[i]['last_offer_amount']+'>$'+bidDataArr[i]['last_offer_amount']+'</div><div class="buy-text-detpstr" onMouseOver="toggleDiv('+bidDataArr[i]['auction_id']+',1,1,1)" onMouseOut="toggleDiv('+bidDataArr[i]['auction_id']+',0,1,0)" ><b class="OfferBidNumber" >'+bidDataArr[i]['offer_count']+' Offer(s)</b></div></div>';
                        $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                        $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        /* Offer data onds */
                    }else if(parseInt(bidDataArr[i]['offer_count']) < 1){
                    	dispData = '<div class="text bold"></div>';
                        $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                        $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                    }
                    else{
                        /* Auction data starts */
                        if(parseInt(bidDataArr[i]['bid_count']) > 0){
                            var highest_user= bidDataArr[i]['highest_user'];
                        	var nextbid = parseFloat(bidDataArr[i]['last_bid_amount'])+parseFloat(bidDataArr[i]['next_increment']);
                            var winner='';
                            if(curr_user!=''){
                               if(curr_user==highest_user){
                                 var winner= "<img src='https://d2m46dmzqzklm5.cloudfront.net/images/winning-bid-img.png' alt='Winner' title='Winner'>";
                               }else{
                                 //var winner= "<img src='https://d2m46dmzqzklm5.cloudfront.net/images/winning-bid-img.png' alt='Loosing' title='Loosing'>";
                               }
                            }
                            dispData = '<div class="auction-row" style="position:relative; cursor:pointer;"><div class="buy-text bold"><span class="CurrentBidOffer" style="font-size:12px; color:#000;">Current Bid:</span></div><div class="buy-text offer_buyprice"><input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="0"><input type="hidden" id="current_bid_'+bidDataArr[i]['auction_id']+'" value='+nextbid+' >$'+bidDataArr[i]['last_bid_amount']+'</div><div class="buy-text-detpstr" onMouseOver="toggleDiv('+bidDataArr[i]['auction_id']+',1,0,1)" onMouseOut="toggleDiv('+bidDataArr[i]['auction_id']+',0,0,0)" ><b class="OfferBidNumber" >'+bidDataArr[i]['bid_count']+' Bid(s)&nbsp;&nbsp;'+winner+'</b></div><div class="buy-text-detpstr bold italics"><input type="hidden" id="auction_increment_'+bidDataArr[i]['auction_id']+'" value='+bidDataArr[i]['next_increment']+'><div class="nextbid">Next minimum bid needs to be $'+nextbid+'.00</div></div></div>';
                            $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                            $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        }else{
						   if(parseInt(bidDataArr[i]['fk_auction_type_id']) != 1 && parseInt(bidDataArr[i]['fk_auction_type_id']) != 4){
                           dispData = '<div class="text bold"><input type="hidden" id="is_sold_track_'+bidDataArr[i]['auction_id']+'" value="0">Opening Bid : <span class="offer_buyprice">$'+bidDataArr[i]['auction_asked_price']+'.00 </span> &nbsp;&nbsp;<b class="OpeningBidNumber">0 Bid</b></div>';                  }
                            $('#auction_data_'+bidDataArr[i]['auction_id']).html(dispData);
                            $('#auction_data_'+bidDataArr[i]['auction_id']).show();
                        }
                        /* Auction data ends */
                        
                        /* Auction timer starts */
                        
                        var end_datetime = dateAdd('s', bidDataArr[i]['seconds_left'], new Date());
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown('destroy');
                        $('#cd_'+bidDataArr[i]['auction_id']).countdown({until: end_datetime});
                        
                        /* Auction timer ends */
                        
                        /* Auction endtime starts */
                        dispData = '<div class="buy-text boldItalics EDTSpace">End Time:</div><div class="buy-text" style="float:none;">'+bidDataArr[i]['actual_end_time']+' EDT</div><div class="buy-text bold EDTSpace">'+bidDataArr[i]['actual_end_day']+'</div><div class="buy-text">'+bidDataArr[i]['actual_end_date']+'</div>';
                        $('#auction_end_time_'+bidDataArr[i]['auction_id']).html(dispData);
                        /* Auction endtime ends */
                        
                        if(parseInt(bidDataArr[i]['fk_auction_type_id']) == 3){
                            if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 && parseInt(bidDataArr[i]['auction_reserve_offer_price']) <= parseInt(bidDataArr[i]['last_bid_amount'])){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text PriceIncluded"  style="font-size:11px; color:#00ff00;">(Reserve Met)</div>');
                            }else if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 && parseInt(bidDataArr[i]['auction_reserve_offer_price']) > parseInt(bidDataArr[i]['last_bid_amount'])){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice"  style="font-size:11px;"> (Reserve Not Met)</div>');
                            }else if(parseInt(bidDataArr[i]['auction_reserve_offer_price']) > 0 &&  bidDataArr[i]['last_bid_amount']==null){
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice"  style="font-size:11px;">(Reserve Not Met)</div>');
                            }else{
                                $('#rp_'+bidDataArr[i]['auction_id']).html('<div class="text NoPrice" style="font-size:11px;">(No Reserve)</div>');
                            }
                        }
                    }
                }
            }
			setTimeout(function() { timeLeftPosterDetails(dataArr); }, 1500);
        });
    }
}

function dateAdd(timeU,byMany,dateObj) {
    var millisecond=1;
    var second=millisecond*1000;
    var minute=second*60;
    var hour=minute*60;
    var day=hour*24;
    var year=day*365;
    var newDate;
    var dVal=dateObj.valueOf();
    switch(timeU) {
        case "ms": newDate=new Date(dVal+millisecond*byMany); break;
        case "s": newDate=new Date(dVal+second*byMany); break;
        case "mi": newDate=new Date(dVal+minute*byMany); break;
        case "h": newDate=new Date(dVal+hour*byMany); break;
        case "d": newDate=new Date(dVal+day*byMany); break;
        case "y": newDate=new Date(dVal+year*byMany); break;
    }
    return newDate;
}

/* Offer functins start */
function acceptOfferOnly(auction_id, offer_id, cntr_offer_id, flag,offset,toshow)
{
   $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
   if(data=='1'){
    var url = "offers.php";
    //$("input.track-btn").attr("disabled", true);
    if(flag == 'buyer'){
        $.post(url, {mode : 'accept_offer', type : 'buyer', auction_id : auction_id, offer_id : cntr_offer_id}, function(data, textStatus){
            if(data == 'true'){
            alert('You have accepted the counter offer.\rYou have received an invoice under Invoice/Reconciliation menu for payment.');
                $("#cntr_ofr_status_"+offer_id).text('Accepted');
            }else if(data != 'false'){              
                refreshOutgoingOffersOnly(offset,toshow);
                alert(data);
            }
        })
    }else{
        $.post(url, {mode : 'accept_offer', type : 'seller', auction_id : auction_id, offer_id : offer_id}, function(data, textStatus){
            if(data == 'true'){
            alert('You have accepted the offer.\rBuyer will now be invoiced.');
                $("#ofr_status_"+offer_id).text('Accepted');
                $("#cntr_ofr_"+offer_id).text('--');
                refreshIncomingCounters(offset,toshow);
            }else if(data != 'false'){
                refreshIncomingCounters(offset,toshow);
                alert(data);
            }
        })
    }
   }else{
   	alert('This offer does not exists.');
   	refreshOutgoingOffersOnly(offset,toshow);
   }
   })
}

function rejectOfferOnly(offer_id, cntr_offer_id, flag,offset,toshow)
{
  $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
   if(data=='1'){
    var url = "offers.php";
    //$("input.track-btn").attr("disabled", true);
    if(flag == 'buyer'){
        $.post(url, {mode : 'reject_offer', type : 'buyer', offer_id : cntr_offer_id}, function(data, textStatus){
            if(data == 'true'){
                $("#cntr_ofr_status_"+offer_id).text('Rejected');
            }else if(data != 'false'){
                refreshOutgoingOffersOnly(offset,toshow);
                alert(data);
            }
        })
    }else{
        $.post(url, {mode : 'reject_offer', type : 'seller', offer_id : offer_id}, function(data, textStatus){
            if(data == 'true'){
                $("#ofr_status_"+offer_id).text('Rejected');
                refreshIncomingCounters(offset,toshow);
            }else if(data != 'false'){
                refreshIncomingCounters(offset,toshow);
                alert(data);
            }
        })
    }
   }else{
   		alert('This offer does not exists.');
   		refreshOutgoingOffersOnly(offset,toshow);
   }
   })
}
function acceptOffer(auction_id, offer_id, cntr_offer_id, flag,offset,toshow)
{
   $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
   if(data=='1'){
    var url = "offers.php";
    //$("input.track-btn").attr("disabled", true);
    if(flag == 'buyer'){
        $.post(url, {mode : 'accept_offer', type : 'buyer', auction_id : auction_id, offer_id : cntr_offer_id}, function(data, textStatus){
            if(data == 'true'){
            alert('You have accepted the counter offer.\rYou have received an invoice under Invoice/Reconciliation menu for payment.');
                $("#cntr_ofr_status_"+offer_id).text('Accepted');
            }else if(data != 'false'){              
                refreshOutgoingOffers(offset,toshow);
                alert(data);
            }
        })
    }else{
        $.post(url, {mode : 'accept_offer', type : 'seller', auction_id : auction_id, offer_id : offer_id}, function(data, textStatus){
            if(data == 'true'){
            alert('You have accepted the offer.\rBuyer will now be invoiced.');
                $("#ofr_status_"+offer_id).text('Accepted');
                $("#cntr_ofr_"+offer_id).text('--');
                refreshIncomingCounters(offset,toshow);
            }else if(data != 'false'){
                refreshIncomingCounters(offset,toshow);
                alert(data);
            }
        })
     }
    }else{
    	alert('This offer does not exists.');
   		refreshOutgoingOffers(offset,toshow);
    }
    })
}

function acceptOfferNew(auction_id, offer_id, cntr_offer_id, flag,offset,toshow)
{
   $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
   if(data=='1'){
    var url = "offers.php";
    //$("input.track-btn").attr("disabled", true);
    if(flag == 'buyer'){
        $.post(url, {mode : 'accept_offer', type : 'buyer', auction_id : auction_id, offer_id : cntr_offer_id}, function(data, textStatus){
            if(data == 'true'){
            alert('You have accepted the counter offer.\rYou have received an invoice under Invoice/Reconciliation menu for payment.');
                $("#cntr_ofr_status_"+offer_id).text('Accepted');
            }else if(data != 'false'){              
                refreshOutgoingOffers(offset,toshow);
                alert(data);
            }
        })
    }else{
        $.post(url, {mode : 'accept_offer', type : 'seller', auction_id : auction_id, offer_id : offer_id}, function(data, textStatus){
            if(data == 'true'){
            alert('You have accepted the offer.\rBuyer will now be invoiced.');
                $("#ofr_status_"+offer_id).text('Accepted');
                $("#cntr_ofr_"+offer_id).text('--');
                refreshIncomingOffersOnly(offset,toshow);
            }else if(data != 'false'){
                refreshIncomingOffersOnly(offset,toshow);
                alert(data);
            }
        })
     }
    }else{
    	alert('This offer does not exists.');
   		refreshIncomingOffersOnly(offset,toshow);
    }
    })
}
	function acceptOfferModified(auction_id, offer_id, cntr_offer_id, flag,offset,toshow)
	{
	   $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
	   if(data=='1'){
	    var url = "offers.php";
	    //$("input.track-btn").attr("disabled", true);
	    if(flag == 'buyer'){
	        $.post(url, {mode : 'accept_offer', type : 'buyer', auction_id : auction_id, offer_id : cntr_offer_id}, function(data, textStatus){
	            if(data == 'true'){
	            alert('You have accepted the counter offer.\rYou have received an invoice under Invoice/Reconciliation menu for payment.');
	                $("#cntr_ofr_status_"+offer_id).text('Accepted');
	            }else if(data != 'false'){              
	                refreshOutgoingOffersOnly(offset,toshow);
	                alert(data);
	            }
	        })
	    }else{
	        $.post(url, {mode : 'accept_offer', type : 'seller', auction_id : auction_id, offer_id : offer_id}, function(data, textStatus){
	            if(data == 'true'){
	            alert('You have accepted the offer.\rBuyer will now be invoiced.');
	                $("#ofr_status_"+offer_id).text('Accepted');
	                $("#cntr_ofr_"+offer_id).text('--');
	                refreshIncomingCounters(offset,toshow);
	            }else if(data != 'false'){
	                refreshIncomingCounters(offset,toshow);
	                alert(data);
	            }
	        })
	     }
	    }else{
	    	alert('This offer does not exists.');
	   		refreshIncomingOffersOnly(offset,toshow);
	    }
	    })
	}

function rejectOffer(offer_id, cntr_offer_id, flag,offset,toshow)
{
  $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
   if(data=='1'){
    var url = "offers.php";
    //$("input.track-btn").attr("disabled", true);
    if(flag == 'buyer'){
        $.post(url, {mode : 'reject_offer', type : 'buyer', offer_id : cntr_offer_id}, function(data, textStatus){
            if(data == 'true'){
                $("#cntr_ofr_status_"+offer_id).text('Rejected');
            }else if(data != 'false'){
                refreshOutgoingOffers(offset,toshow);
                alert(data);
            }
        })
    }else{
        $.post(url, {mode : 'reject_offer', type : 'seller', offer_id : offer_id}, function(data, textStatus){
            if(data == 'true'){
                $("#ofr_status_"+offer_id).text('Rejected');
                refreshIncomingOffersOnly(offset,toshow);
            }else if(data != 'false'){
                refreshIncomingOffersOnly(offset,toshow);
                alert(data);
            }
        })
    }
   }else{
   		alert('This offer does not exists.');
   		refreshOutgoingOffers(offset,toshow);
   }
   })
}
function rejectOfferNew(offer_id, cntr_offer_id, flag,offset,toshow)
{
  $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
   if(data=='1'){
    var url = "offers.php";
    //$("input.track-btn").attr("disabled", true);
    if(flag == 'buyer'){
        $.post(url, {mode : 'reject_offer', type : 'buyer', offer_id : cntr_offer_id}, function(data, textStatus){
            if(data == 'true'){
                $("#cntr_ofr_status_"+offer_id).text('Rejected');
            }else if(data != 'false'){
                refreshOutgoingOffers(offset,toshow);
                alert(data);
            }
        })
    }else{
        $.post(url, {mode : 'reject_offer', type : 'seller', offer_id : offer_id}, function(data, textStatus){
            if(data == 'true'){
                $("#ofr_status_"+offer_id).text('Rejected');
                refreshIncomingOffersOnly(offset,toshow);
            }else if(data != 'false'){
                refreshIncomingOffersOnly(offset,toshow);
                alert(data);
            }
        })
    }
    }else{
    	alert('This offer does not exists.');
   		refreshIncomingOffersOnly(offset,toshow);
   }
   })
}
	function rejectOfferModified(offer_id, cntr_offer_id, flag,offset,toshow)
	{
	  $.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
	   if(data=='1'){
	    var url = "offers.php";
	    //$("input.track-btn").attr("disabled", true);
	    if(flag == 'buyer'){
	        $.post(url, {mode : 'reject_offer', type : 'buyer', offer_id : cntr_offer_id}, function(data, textStatus){
	            if(data == 'true'){
	                $("#cntr_ofr_status_"+offer_id).text('Rejected');
	            }else if(data != 'false'){
	                refreshOutgoingOffersOnly(offset,toshow);
	                alert(data);
	            }
	        })
	    }else{
	        $.post(url, {mode : 'reject_offer', type : 'seller', offer_id : offer_id}, function(data, textStatus){
	            if(data == 'true'){
	                $("#ofr_status_"+offer_id).text('Rejected');
	                refreshIncomingOffersOnly(offset,toshow);
	            }else if(data != 'false'){
	                refreshIncomingOffersOnly(offset,toshow);
	                alert(data);
	            }
	        })
	    }
	   }else{
	   		alert('This offer does not exists.');
	   		refreshIncomingOffersOnly(offset,toshow);
	   }
	   })
	}
function makeCounterOffer(auction_id, offer_id, cntr_amt,offset,toshow)
{   
	$.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
      if(data=='1'){
	    var chk_ind=/^ *[0-9]+ *$/.test(cntr_amt);
	    if(cntr_amt == parseFloat(cntr_amt) && chk_ind==false){
	    	 alert("Please enter integer value");
	    	 $('#cntr_amt_'+offer_id).val("");
	    	 return;
	    }else{
		    var url = "offers.php";
		    $.post(url, {mode : 'make_counter_offer', auction_id : auction_id, offer_id : offer_id, offer_amount : cntr_amt}, function(data, textStatus){
		        if(data == 'true'){
		            $("#cntr_ofr_"+offer_id).text('$'+cntr_amt+'.00');
		            $("#cntr_ofr_status_"+offer_id).text("Pending");
		        }else if(data != 'false'){
		            alert(data);
		            refreshIncomingCounters(offset,toshow);
		        }
		    })
	    }
      }else if(data=='2'){
    	alert('This offer does not exists.');
   		refreshIncomingCounters(offset,toshow);
      }
    })
   
}
function makeCounterOfferModified(auction_id, offer_id, cntr_amt,offset,toshow)
{   
	$.post('offers.php', {mode : 'trackOfferIfExists',offer_id:offer_id}, function(data) {
      if(data=='1'){
	    var chk_ind=/^ *[0-9]+ *$/.test(cntr_amt);
	    if(cntr_amt == parseFloat(cntr_amt) && chk_ind==false){
	    	 alert("Please enter integer value");
	    	 $('#cntr_amt_'+offer_id).val("");
	    	 return;
	    }else{
		    var url = "offers.php";
		    $.post(url, {mode : 'make_counter_offer', auction_id : auction_id, offer_id : offer_id, offer_amount : cntr_amt}, function(data, textStatus){
		        if(data == 'true'){
		            $("#cntr_ofr_"+offer_id).text('$'+cntr_amt+'.00');
		            $("#cntr_ofr_status_"+offer_id).text("Pending");
		        }else if(data != 'false'){
		            alert(data);
		            refreshIncomingOffersOnly(offset,toshow);
		        }
		    })
	    }
      }else if(data=='2'){
    	alert('This offer does not exists.');
   		refreshIncomingOffersOnly(offset,toshow);
      }
    })
   
}

function refreshOutgoingOffersOnly(offset,toshow,orderBy,orderType){
	
    $.get('offers.php', {mode : 'refresh_outgoing_offers_only',offset:offset,toshow:toshow,order_by:orderBy,order_type:orderType}, function(data, textStatus){
        $('#offers').html(data);
    })                   
}
function refreshOutgoingOffers(offset,toshow,orderBy,orderType){
	
    $.get('offers.php', {mode : 'refresh_outgoing_offers',offset:offset,toshow:toshow,order_by:orderBy,order_type:orderType}, function(data, textStatus){
        $('#offers').html(data);
    })                   
}

function refreshIncomingCounters(offset,toshow,orderBy,orderType){
    
	
    $.get('offers.php', {mode : 'refresh_incoming_counters',offset:offset,toshow:toshow,order_by:orderBy,order_type:orderType}, function(data, textStatus){
        $('#offers').html(data);
    })                   
}
function refreshIncomingOffersOnly(offset,toshow,orderBy,orderType){
    
	
    $.get('offers.php', {mode : 'refresh_incoming_offers_only',offset:offset,toshow:toshow,order_by:orderBy,order_type:orderType}, function(data, textStatus){
        $('#offers').html(data);
    })                   
}

/* Offer functins end */


function add_watchlist(id)
{
   if('<?php echo $_SESSION['sessUserID'];?>' == ''){
    	showLogIn();
    }else{
	    if(document.getElementById('watch_'+id).value=='Watch this item'){
			$.post('buy.php', {mode : 'select_watchlist',is_track : id}, function(data, textStatus){
			//window.location.reload();
			document.getElementById('watch_'+id).value="You are watching";
			}) 
		}else{
			window.location="user_watching.php#"+id;
		}
		
    //document.getElementById('is_track').value=id;
    //document.listFrom.submit();
    }  
}
function add_watchlist_for_details(id)
{
	$.post('buy.php', {mode : 'select_watchlist',is_track : id}, function(data, textStatus){
        window.location.reload();
    })  
	
}

function lightbox_images(i){
    $(function() {
        $('#gallery_'+i+' a').lightBox();
    });
}
function lightbox_images_monthly(i){
    $(function() {
        $('#gallery_monthly'+i+' a').lightBox();
    });
}
function lightbox_images_weekly(i){
    $(function() {
        $('#gallery_weekly'+i+' a').lightBox();
    });
}
function lightbox_images_sold(i){
    $(function() {
        $('#gallery_sold'+i+' a').lightBox();
    });
}

function shippingMethod(param)
{   
    var weights=$("#weights").val();
    var country_id = $("#shipping_country_id").val();
    var zip_code = $("#shipping_zipcode").val();
    var city = $("#shipping_city").val();
    var state = $("#shipping_state").val();
    var address1 = $("#shipping_address1").val();
    var totalPoster = $("#total_item").val();
    
    var errCounter = 0;
    if(country_id == ''){
    	errCounter++;
    }else if(zip_code == ''){
    	errCounter++;
    }else if(city == ''){
    	errCounter++;
    }else if(state == ''){
    	errCounter++;
    }else if(address1 == ''){
    	errCounter++;
    }
    
    if(errCounter > 0){
    	$('#ship_price_err').html('Please enter all mandatory shipping info.');
    }else{ 
    	$('#ship_price_err').html('');   
        $('#options').html('<img src="https://c4808190.ssl.cf2.rackcdn.com/loader.gif">');
        if(param == 'usps'){
            if(country_id == '230'){
                $.get('usps/usps.php', {country_id:country_id, zip_code:zip_code, city:city, address1:address1,totalPoster:totalPoster, weights:weights}, function(data){
				var newData = data.split("/");
				if(newData[0] == 'Y'){
					uspsOpts ='<span>Technical problem plese try again with your proper shipping details.</span>';
				}else{
					var shippingRate = newData[0];
					shippingRate = parseFloat(shippingRate);
					shippingRate = shippingRate.toFixed(2);
					var deliveryDate = '';
					if(newData[1] !== ""){
						deliveryDate= '(<span>'+newData[1]+'</span>)';
					}
					uspsOpts = '<input type="hidden" name="shipping_methods" value="usps"><input type="hidden" name="shipping_desc" value="'+newData[1]+'"><input type="radio" name="shipping_charge" value="'+newData[0]+'" class="required" checked="checked"/>&nbsp;<b>$'+shippingRate+'</b>&nbsp;'+deliveryDate+'<br >';
				}
                        $('#options').html('<div id="shipping_options">'+uspsOpts+'<div>');
                });
            }else if(country_id!=''){
                $.get('usps/usps_intl.php', {country_id:country_id, zip_code:zip_code, city:city, address1:address1,totalPoster:totalPoster,weights:weights}, function(data){
				var newData = data.split("/");
				if(newData[0] == 'Y'){
					uspsOpts ='<span>Technical problem plese try again with your proper shipping details.</span>';
				}else{
					var shippingRate = newData[0];
					shippingRate = parseFloat(shippingRate);
					shippingRate = shippingRate.toFixed(2);
					var deliveryDate = '';
					if(newData[1] !== ""){
						deliveryDate= '(<span>'+newData[1]+'</span>)';
					}
					uspsOpts = '<input type="hidden" name="shipping_methods" value="usps"><input type="hidden" name="shipping_desc" value="'+newData[1]+'"><input type="radio" name="shipping_charge" value="'+newData[0]+'" class="required" checked="checked"/>&nbsp;<b>$'+shippingRate+'</b>&nbsp;'+deliveryDate+'<br >';
				}
                        $('#options').html('<div id="shipping_options">'+uspsOpts+'<div>');
                });
            }
        }else if(param == 'fedex'){
            if(country_id == '230'){
                $.get('fedex/RateWebServiceClientLocal.php', {country_id:country_id, zip_code:zip_code, city:city, address1:address1,totalPoster:totalPoster,weights:weights}, function(data){
                    optionsArr = eval(data);
                    uspsOpts = '';
                    if(optionsArr[0]['option'] == 'error'){
                        uspsOpts = optionsArr[0]['charge'];
                    }else{
                        for(i=0;i<optionsArr.length;i++){
                            if(i == 0){
                                checked = 'checked';
                                $('#shipping_desc').val(optionsArr[i]['option']);
                            }else{
                                checked = '';
                            }
                            uspsOpts += '<input type="hidden" name="shipping_methods" value="fedex"><input type="radio" name="shipping_charge" value="'+optionsArr[i]['charge']+'" onclick="setShippingDesc('+i+')" class="required" '+checked+' />&nbsp;<b>$'+optionsArr[i]['charge']+'</b>&nbsp;(<span id="div_'+i+'">'+optionsArr[i]['option']+'</span>)<br >';
                        }
                    }
                    $('#shipping_options').remove();
                    $('#options').html('<div id="shipping_options">'+uspsOpts+'<div>');             
                });
            }else if(country_id != ''){
                $.get('fedex/RateWebServiceClient.php', {country_id:country_id,zip_code:zip_code,city:city,address1:address1,totalPoster:totalPoster,weights:weights},function(data){
                    optionsArr = eval(data);
                    uspsOpts = '';
                    if(optionsArr[0]['option'] == 'error'){
                        uspsOpts = optionsArr[0]['charge'];
                    }else{
                        for(i=0;i<optionsArr.length;i++){
                            if(i == 0){
                                checked = 'checked';
                                $('#shipping_desc').val(optionsArr[i]['option']);
                            }else{
                                checked = '';
                            }
    
                            uspsOpts += '<input type="hidden" name="shipping_methods" value="fedex"><input type="radio" name="shipping_charge" value="'+optionsArr[i]['charge']+'" onclick="setShippingDesc('+i+')" class="required" '+checked+' />&nbsp;<b>$'+optionsArr[i]['charge']+'</b>(&nbsp;<span id="div_'+i+'">'+optionsArr[i]['option']+'</span>)<br >';
    
                        }
                    }
                    $('#shipping_options').remove();
                    $('#options').html('<div id="shipping_options">'+uspsOpts+'<div>'); 
                }); 
            }
        }else{
            $('#options').html('<div class="err-msg">Please select a shipping method<div>'); 
        }
	}
}

function setShippingDesc(id)
{
    $('#shipping_desc').val($('#div_'+id).html());
}

function frmSubmit()
{
    var url = "auth.php";
    var data = $('#frmlogin').serialize();
    var retunedData;
    $.post(url, data, function(retunedData, textStatus){
        if(retunedData == 'true'){
            var url= '<?php echo $_SERVER['HTTP_REFERER'];?>';
            $(location).attr('href',url);
        }else{  
            $("#loginmsg").text(retunedData);
            $("#loginmsg").show(300);
        }
    });
    return false;
}

function remove_dummy_username(){
    $('#username').val('');
}

function remove_dummy_password(){
    $('#password').val('');
}

function redirect_poster_details(auction_id,type)
{
	if(type==1){
		window.location="buy.php?mode=poster_details&auction_id="+auction_id+"&fixed=1";
	}else{
		window.location="buy.php?mode=poster_details&auction_id="+auction_id;
	}
}

function redirect_to_cart(auction_id, user_id)
{ 
     
	if('<?php echo $_SESSION['sessUserID'];?>' == ''){
    	showLogIn();
	}else if(user_id == '<?php echo $_SESSION['sessUserID'];?>'){
		alert("Seller cannot buy his own poster.");
	}else{
		var in_cart;
	    $.post("ajax.php", { auction_id:auction_id,mode:"chkcart" }, function(data){		 
  	 	 in_cart = data;
		 if(in_cart=='1'){
			alert("This Item is already added in cart by other user.");
		}else{
			window.location="cart.php?id="+auction_id;
		}
  	  });
	 
	}
}


function stateOptions(country_id, state_textbox, state_select)
{
	if(country_id == 230){
		$('#'+state_textbox).hide();
		$('#'+state_select).show();
	}else{
		$('#'+state_textbox).show();
		$('#'+state_select).hide();
	}
}
function showLogIn(){
 $('#login-modal-overlay').show();
 $('#login-modal-box').show();
 $('#username').focus();
}
function hideLogIn(){
 $('#login-modal-box').hide();
 $('#login-modal-overlay').hide();
}
function redirect_watchlist(id){
    window.location="user_watching.php#"+id;
}


function showalert(txt,clr,height){
	if(height==''){
		height=140;
	}
	$( "#dialog-confirm" ).dialog({
      resizable: false,
      height:height,
	  width:500,
      modal: true,
	  title:txt,
      buttons: {
        OK: function() {
          $( this ).dialog( "close" );
        }
      }
    });
}