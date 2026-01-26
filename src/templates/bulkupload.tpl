{include file="header.tpl"}
{literal}
<script language="javascript">

function chk_chkd(){
	if(document.getElementById('upload_to_admin').checked==true){
		$("#upload_user").hide();
		$("#upload_admin").show();
		document.getElementById('mode').value="save_bulk_to_admin";
	}else{
		$("#upload_user").show();
		$("#upload_admin").hide();
		document.getElementById('mode').value="save_bulkupload";
	}
}
function validateForm(){
	var form = document.frm_bulkupload; 
	var mode = $("#mode").val();
	if(mode=="save_bulk_to_admin"){
		if(form.bulkupload_for_admin.value.length == 0){
			alert("Please select a zip.");
			return false;
		}
	}else if(mode=="save_bulkupload"){
		if(form.bulkupload.value.length == 0){
			alert("Please select a zip.");
			return false;
		}
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
     {include file="right-panel.tpl"}
     <div id="center"><div id="squeeze"><div class="right-corner">
    
    	<div id="inner-left-container">
            <div class="innerpage-container-main">            	
                <!--Page body Starts-->
                  <div class="innerpage-container-main">            	
                   <div class="dashboard-main">
                     <h1>Bulk Upload</h1>
                     <p>Fields marked <span class="mandatory">*</span> are mandatory</p>
                   </div>
                    
                 <div class="left-midbg"> 
                    <div class="right-midbg"> 
                <div class="mid-rept-bg">                
                    <div class="inner-area-general" style="padding-top:0;">
                        <div class="formarea" style="margin-left:0; padding-left: 50px;">
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                        {if $successCounter <> ""}<div class="messageBox">{$successCounter} Posters uploaded.</div>{/if}
                        <form name="frm_bulkupload" id="frm_bulkupload" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
							<input type="hidden" name="mode" id="mode" value="save_bulkupload">
							<input type="hidden" name="cnt_err" value="{$err}">
							<div class="per-field" id="upload_user">
								<label>Browse File (max 20 mb)<span class="red-star">*</span></label>
								<input type="file" name="bulkupload" id="bulkupload_user"  style="margin:5px 0px;" />
                                <div class="disp-err">{$bulkupload_err}</div>
                                <div class="clear"></div>
							</div>
							<div class="per-field" id="upload_admin" style="display:none;">
								<label>Browse File to Admin (max 20 mb)<span class="red-star">*</span></label>
								<input type="file" name="bulkupload_admin" id="bulkupload_for_admin"  style="margin:5px 0px;" />
                                <div class="disp-err">{$bulkupload_admin_err}</div>
                                <div class="clear"></div>
							</div>
							<div class="per-field">
                                <div style="font-size:11px; font-family:Verdana, Geneva, sans-serif; padding:10px 0px; text-align:justify;">
                                Upload zip file in a specific format. <a href="{$actualPath}/myselling.php?mode=download&file=sample.zip"><font color="#0000FF">Download</font></a> the sample zip file and <a href="{$actualPath}/myselling.php?mode=download&file=instructions.txt"><font color="#0000FF">download</font></a> the instruction file.</div>
							</div>
							{if $err >=3}
							 <div class="per-field">
                                <div style="font-size:11px; font-family:Verdana, Geneva, sans-serif; padding:10px 0px; text-align:justify;">
                                <input type="checkbox" id="upload_to_admin" name="upload_to_admin" onClick="chk_chkd();">&nbsp; <font style="color: red;">Would you like to upload the zip directly to admin.</font>
                                </div>
							</div>
							{/if}
                            							
							<div class="per-field"> 
                            	<label></label>
								<input type="submit" value="Submit" class="submit-btn" />
								<input type="reset" value="Reset" class="submit-btn" />  
							</div>                      
                        </form>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                </div>
                </div>
                
                
            </div>
                <!--Page body Ends-->
            </div>
        </div> 
        
        </div></div></div>        
        
    </div>
    {include file="gavelsnipe.tpl"} 
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}