{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	$("#frm_profile").validate();
});
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
      <div id="center"><div id="squeeze"><div class="right-corner">
     
     
    	<div id="inner-left-container">
            <div class="innerpage-container-main">            	
                <!--Page body Starts-->
                 
						<div class="dashboard-main">
                                <h1>Contact Us </h1>
                               
                                </div>
                        
                        <div class="left-midbg"> 
               <div class="right-midbg" style="background-image:url(../images/contactbg.png); background-position:right top; background-repeat:no-repeat;">
               
                <div class="mid-rept-bg">
                        <div class="inner-area-general" style="padding-top:0;">
                        <div class="mandatoryTxt" style="margin-left:0; padding-top:0;">
                        <p>{$pageContent}</p>
                        </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                   <!-- 
                    <div class="mid-rept-bg">
                    	<div class="inner-area-general" style="padding-top:0;">
                            {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}                       
                            <form name="frm_profile" action="" method="post" id="frm_profile">
                            <input type="hidden" name="mode" value="insert_contact">
                            <div class="mandatoryTxt"  style="margin-left:0; padding-top:0;">
                            <span>Fields marked <span class="mandatory">*</span> are mandatory</span></div>
                            <div class="formarea" style="margin-left:0;">
                            
                                <div class="per-field"> 
                                    <label>Name<span class="red-star">*</span></label>
                                    <input type="text" name="firstname" id="firstname" value="{$profile[0].firstname}" size="32" class="register-txtfield required"  style="width:200px;"/><div class="disp-err">{$firstname_err}</div>
                                </div>
                                <div class="per-field"> 
                                    <label>Email Address<span class="red-star">*</span></label>
                                    <input type="text" name="email" value="{$profile[0].email}" size="32" class="register-txtfield required email"  style="width:200px;" /><div class="disp-err">{$email_err}</div>
                                </div>
                                {*<div class="per-field"> 
                                    <label>Enquiry On<span class="red-star">*</span></label>
                                    <select name="category_id" id="category_id" class="selectbox required"  style="width:200px;">
                                        <option value="" selected="selected">Select</option>
                                       {html_options values=$countryID output=$countryName selected=$profile[0].country_id}
                                        <option value="1">Comedy</option>
                                        <option value="2">Documentary</option>
                                        <option value="3">Horror</option>
                                        <option value="4">Rock & Roll</option>
                                    </select>
                                    <div class="disp-err">{$category_err}</div>
                                </div>*}
                                <div class="per-field"> 
                                    <label>Comments<span class="red-star">*</span></label>
                                    <textarea class="register-txtarea required" name="comments"  style="width:200px;"></textarea>
                                </div>
                                <div class="per-field"> 
                                	<label></label>
                                    <input type="submit" value="Submit" class="submit-btn" />
                                    <input type="reset" value="Reset" class="submit-btn" />
                                </div>
                            </div>                            
                            </form>                      
                        </div>
                    	<div class="clear"></div>
                    </div>
               -->
               </div>
               </div>
                
                
                <!--Page body Ends-->
                <div class="btom-right"></div>
            </div>
        </div>     
        
        </div></div></div>     
       
    </div>
    {include file="gavelsnipe.tpl"}
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}