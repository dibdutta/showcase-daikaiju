{include file="header.tpl"}
{literal}
<script language="javascript">
$(document).ready(function() {
	var me = $(this);
	$.getJSON('http://fk-solutions.com/Codeme/codedme_api.php?mode=login_api&request_user_id=dibyendudutta1985@gmail.com&request_password=123456&callback=?',function(rtndata) {
		alert(rtndata.message);
        //alert(data); //uncomment this for debug
        //$('#showdata').html("<p>Response= "+data.message+"</p>");
    });
	
});
</script>
{/literal}
<div id="showdata"></div>
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
                  
                        
                        <div class="black-midrept">
                            <span class="white-txt"><strong>{$pageHeaderName}</strong></span>
                        </div><div class="black-right-crnr"></div>
                        <div class="black-left-crnr"></div>
                      
                   <div class="left-midbg"> 
               		<div class="right-midbg">
                    <div class="mid-rept-bg">
                        <div class="inner-area-general">
                        <div class="mandatoryTxt">
                        <p>{$pageContent}</p>
                        </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    </div>
                    </div>
                    <div class="btm-mid"><div class="btom-left"></div></div><div class="btom-right"></div>
                </div>
                <!--Page body Ends-->
               
            </div>
        </div> 
        
         </div></div></div>        
        {include file="user-panel.tpl"}
    </div>
    
    </div>
    <div class="clear"></div>
</div>
{include file="footer.tpl"}