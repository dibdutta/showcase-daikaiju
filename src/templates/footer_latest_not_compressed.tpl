<!--Footer Starts-->
  <div id="footer" {if $smarty.const.PHP_SELF=='/index.php' || $smarty.const.PHP_SELF==''} {else} style="border-top:1px solid #333333;" {/if}>
  	<div id="footerwrapper">
    	<div id="footernavigator" {if $smarty.const.PHP_SELF=='/index.php' || $smarty.const.PHP_SELF==''} {else}style="border:none;"{/if}>
        	<div class="left">
            	<ul class="menu">
                	<li {if $smarty.const.PHP_SELF == '' || $smarty.const.PHP_SELF == '/index.php'}class="active"{/if}><a {if $smarty.session.sessUserID != ''}href="{$actualPath}/index.php"{else}href="{$actualPath}/index.php"{/if} title="Home">Home</a>&nbsp;|&nbsp;</li>                    
                    {if $smarty.session.sessUserID != ''}<li {if $smarty.const.PHP_SELF == '/myaccount.php'}class="active"{/if}><a href="{$actualPath}/myaccount.php" title="My Account">My Dashboard</a>&nbsp;|&nbsp;</li>{/if}
                    <li {if $smarty.const.PHP_SELF == '/buy.php' && $smarty.request.mode == 'refinesrc'}class="active"{/if}><a href="{$actualPath}/buy.php?mode=refinesrc" title="Advanced Search">Advanced Search</a>&nbsp;|&nbsp;</li>
                    <li {if $smarty.const.PHP_SELF == '/siteurl.php'}class="active"{/if}><a href="{$actualPath}/siteurl.php" title="Sitemap">Sitemap</a>&nbsp;|&nbsp;</li>
                    <li {if $smarty.const.PHP_SELF == '/contactus.php'}class="active"{/if}><a href="{$actualPath}/contactus.php" title="Contact Us">Contact Us</a>&nbsp;|&nbsp;</li>
                    {*<li><a href="#" title="Receive Email Updates">Receive Email Updates</a>&nbsp;|&nbsp;</li>*}
                    <li {if $smarty.const.PHP_SELF == '/privacypolicy.php'}class="active"{/if}><a href="{$actualPath}/user_agreement.php" title="User Agreement and policies">User Agreement and Policies</a></li>
                    {*<li><a href="#" title="Archives">Archives</a></li>*}
                </ul>
            </div>            
            <div class="right">
            	<p><span>&copy; 2011 - 2012. Movie Poster Exchange.</span></p>                
            </div>            
        </div> 
        
        
        <div class="paypal"><img src="{$smarty.const.CLOUD_STATIC}paypal_logos.jpg" alt="Movie Poster Exchange" title="Movie Poster Exchange" width="224" height="79"/></div>
  </div>
        
        
    </div>
  
  <!-- Div used for sign up popup -->
  <div id="sb-container" style="height: 100%; width: 100%;">
  <div id="sb-overlay" style="background-color:#D6D6D6 ; opacity: 0.8"></div>
  <div id="sb-wrapper" style="visibility: visible; left: 374px; width: 514px; top: 129px">
    <div id="sb-title">
      <div id="sb-title-inner" style="margin-top: 100px"></div>
    </div>
    <div id="sb-wrapper-inner" style="height: 300px">
      <div id="sb-body">
        <div id="sb-body-inner">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Div used for sign up popup -->  
<!--Footer Ends-->
</body>
</html>
