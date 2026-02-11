<div class="push"></div>
</div>
<!--Footer Starts-->
<div class="footer">
  <div id="footer" {if $smarty.const.PHP_SELF=='/index.php' || $smarty.const.PHP_SELF==''} {else} style="border-top:1px solid #333333; margin-top:20px;" {/if}>
  	<div id="footerwrapper">
    <div class="paypal">
    <div class="fll"><table width="138" border="0" cellspacing="0" cellpadding="0" style="border:0;">
  <tr>
    <td><img src="https://d2m46dmzqzklm5.cloudfront.net/images/followus.png" width="78" height="45" /></td>
    <td><a href="https://twitter.com/intent/follow?original_referer=http%3A%2F%2Fwww.movieposterexchange.com%2Findex.php&amp;region=follow_link&amp;screen_name=MoviePosterExch&amp;source=followbutton&amp;variant=2.0" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/followus_tweter.png" alt="Follow us on Tweeter" width="30" height="45" /></a></td>
    <td><a href="https://www.facebook.com/pages/MoviePosterExchangecom/105014962910848" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/followus_fb.png" alt="Follow us on Facebook" width="30" height="45" /></a></td>
  </tr>
</table>
</div>
    <img src="https://d2m46dmzqzklm5.cloudfront.net/images/paypal_logos.jpg" alt="Movie Poster Exchange" title="Movie Poster Exchange" width="333" height="45"/></div>
    	<div id="footernavigator" {if $smarty.const.PHP_SELF=='/index.php' || $smarty.const.PHP_SELF==''} {else}style="border:none;"{/if}>
        	<div class="left">
            	<ul class="menu">
                	<li {if $smarty.const.PHP_SELF == '' || $smarty.const.PHP_SELF == '/index.php'}class="active"{/if}><a {if $smarty.session.sessUserID != ''}href="{$actualPath}/index"{else}href="{$actualPath}/index"{/if} title="Home">Home</a>&nbsp;|&nbsp;</li>                    
                    {if $smarty.session.sessUserID != ''}<li {if $smarty.const.PHP_SELF == '/myaccount.php'}class="active"{/if}><a href="{$actualPath}/myaccount" title="My Account">My Dashboard</a>&nbsp;|&nbsp;</li>{/if}
                    <li {if $smarty.const.PHP_SELF == '/buy.php' && $smarty.request.mode == 'refinesrc'}class="active"{/if}><a href="{$actualPath}/buy?mode=refinesrc" title="Advanced Search">Advanced Search</a>&nbsp;|&nbsp;</li>
                    <li {if $smarty.const.PHP_SELF == '/siteurl.php'}class="active"{/if}><a href="{$actualPath}/siteurl" title="Sitemap">Sitemap</a>&nbsp;|&nbsp;</li>
                    <li {if $smarty.const.PHP_SELF == '/contactus.php'}class="active"{/if}><a href="{$actualPath}/contactus" title="Contact Us">Contact Us</a>&nbsp;|&nbsp;</li>
                    {*<li><a href="#" title="Receive Email Updates">Receive Email Updates</a>&nbsp;|&nbsp;</li>*}
                    <li {if $smarty.const.PHP_SELF == '/privacypolicy.php'}class="active"{/if}><a href="{$actualPath}/user_agreement" title="User Agreement and policies">User Agreement and Policies</a></li>
                    {*<li><a href="#" title="Archives">Archives</a></li>*}
                </ul>
            </div>            
            <div class="right">
            	<p><span>&copy; 2011 - 2013. Movie Poster Exchange.</span></p>                
            </div>            
        </div> 
        
        
        
  </div>
        
        
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
