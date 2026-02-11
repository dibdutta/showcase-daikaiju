{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#mywantList").validate();
});
function view_want_list()
{
	window.location.href='{/literal}{$actualPath}/my_want_list{literal}';
}
function autocom(q){
	var url = "ajax?mode=autocomplete_want&q="+q;
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
function set_result(title){
	document.getElementById('poster_title').value=title;
	$("#auto_load").hide();
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
        {include file="right-panel.tpl"}
        <div id="center">
        <div id="squeeze">
        <div class="right-corner">
            <div id="inner-left-container">
                <!--Page Body Starts-->
                
                <div class="innerpage-container-main">            	
                	<div class="dashboard-main">
                        <h1>Add My Want List</h1>
                        <p>Fields marked <span class="mandatory">*</span> are mandatory</p>
                   </div>
                 <div class="mid-rept-bg">
                    <div class="inner-area-general"  style="width: 685px;">
                         <div class="mid-rept-bg">             
                        <div class="formarea-listing"> 
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}                       
                            <form name="mywantList" id="mywantList" action="" method="post" autocomplete="off">
                            <input type="hidden" name="mode" value="save_mywant_list" />
                            <input type="hidden" name="encoded_string" value="{$encoded_string}" />
                                         
                                 <div class="formarea" style="margin-left:0; text-align:center; width:100%;">                  
                                <table border="0" cellpadding="0" cellspacing="0" class="" style="border:0; margin:0 auto;" >
                                    <tr>                                        
                                        <td width="200" style="text-align:right; margin:0;"><label  style="margin-right:10px; float:right; padding:0; ">Poster Title or Keyword(s)<span class="mandatory">*</span>:</label></td>
                                        <td width="300" >
                                        <div class="UserNameSearch" style="position:relative;">
											<div><input type="text" name="title"  id="poster_title" onkeyup="autocom(this.value);" class = "required" /></div>						
                       						    <div id="auto_load" style="width:163px; position:absolute; z-index:100px; top:20px; left:0px; background-color:#CCCCCC; display:none; max-height:280px; overflow-y:scroll;font-size:12px;"></div>
                                                </div>
                                        </td>
<!--                                        <td width="210px"><label>Size:</label></td>-->
                                    
                                    </tr>
                                    <tr>
                                        <td></td>
<!--                                        <td>-->
<!--                                        <select name="poster_size"  id="poster_size">-->
<!--                                                <option value="" selected="selected">Select</option>-->
<!--                                                {section name=counter loop=$catRows}-->
<!--                                                    {if $catRows[counter].fk_cat_type_id == 1}-->
<!--                                                    <option value="{$catRows[counter].cat_id}">{$catRows[counter].cat_value}</option>-->
<!--                                                    {/if}-->
<!--                                                {/section}-->
<!--                                            </select>-->
<!--                                        </td>-->
                                    </tr>
<!--                                    <tr>-->
<!--                                       -->
<!--                                        <td><div class="disp-err">&nbsp;</div></td>-->
<!--                                        <td><div class="list-err">&nbsp;</div></td>-->
<!--                                    </tr>                                        -->
<!--                                    <tr>-->
<!--                                        <td width="210px"><label>Genre:</label></td>-->
<!--                                        <td width="210px"><label>Decade:</label></td>-->
<!--                                       -->
<!--                                    </tr>                                        -->
<!--                                    <tr>-->
<!--                                    <td><select name="genre" >-->
<!--                                                <option value="" selected="selected">Select</option>-->
<!--                                                {section name=counter loop=$catRows}-->
<!--                                                    {if $catRows[counter].fk_cat_type_id == 2}-->
<!--                                                    <option value="{$catRows[counter].cat_id}">{$catRows[counter].cat_value}</option>-->
<!--                                                    {assign var="selected" value=""}-->
<!--                                                    {/if}-->
<!--                                                {/section}-->
<!--                                            </select>-->
<!--                                        -->
<!--                                    </td>-->
<!--                                        <td>-->
<!--                                        <select name="decade" >-->
<!--                                            <option value="" selected="selected">Select</option>-->
<!--                                            {section name=counter loop=$catRows}-->
<!--                                                {if $catRows[counter].fk_cat_type_id == 3}-->
<!--                                                <option value="{$catRows[counter].cat_id}" >{$catRows[counter].cat_value}</option>-->
<!--                                                {/if}-->
<!--                                            {/section}-->
<!--                                        </select>-->
<!--                                        </td>-->
<!--                                        -->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                        <td><div class="disp-err">&nbsp;</div></td>-->
<!--                                        <td><div class="disp-err">&nbsp;</div></td>-->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                    <td ><label>Country:</label></td>-->
<!--                                    <td ><label>Notification:</label></td>-->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                    <td ><select name="country" >-->
<!--                                                <option value="" selected="selected">Select</option>-->
<!--                                                {section name=counter loop=$catRows}-->
<!--                                                    {if $catRows[counter].fk_cat_type_id == 4}-->
<!--                                                    <option value="{$catRows[counter].cat_id}" {if $country == $catRows[counter].cat_id} selected {/if}>{$catRows[counter].cat_value}</option>-->
<!--                                                    {assign var="selected" value=""}-->
<!--                                                    {/if}-->
<!--                                                {/section}-->
<!--                                            </select></td> -->
<!--                                    <td ><label>YES</label><input type="radio" name="notify_id" value="1"  checked="checked"/>&nbsp;<label>NO</label><input type="radio" name="notify_id" value="0"  /></td>-->
<!--                                               -->
<!--                                    </tr>-->
                                    
                                    
                                </table>
                                </div>
                                
                                <div class="clear"></div>
                                <div class="btn-box">     
                                    <input type="submit" id="submit" value="Submit" class="submit-btn" />
<!--                                    <input type="reset" value="reset" class="submit-btn" />-->
                                    <input type="button"  value="View want list" class="submit-btn" onclick="javascript: location.href='{$decoded_string}';" />
                                </div>
                                <div class="clear"></div>                            
                        </form>
                        </div>
                    </div>
					</div>
                    </div>
                 <div class="clear"></div>
                        </div>
                     </div>
                     </div>
                        
                       
                    </div>
            
                <!--Page Body Ends-->
            </div>        
               </div>
               </div>
               </div>   
        	
        <!--</div> -->   
		{include file="gavelsnipe.tpl"} 
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}