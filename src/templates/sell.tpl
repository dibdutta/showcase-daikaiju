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
                <div class="innerpage-container-main">                        
                  <div class="dashboard-main">
                                <h1>{$pageHeaderName}</h1>
                               
                                </div>
                        
                        <!--<div class="black-midrept">
                            <span class="white-txt"><strong>{$pageHeaderName}</strong></span>
                        </div>-->
                      
                   <div class="left-midbg"> 
               		<div class="right-midbg">
                    <div class="mid-rept-bg">
                        <div class="inner-area-general" style="margin-left: 16px; background-color:#FFF;">
                        <div class="mandatoryTxt"  style="margin-left: 18px;">
                        <p>{$pageContent}</p>
                        </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    <!--<div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>-->
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