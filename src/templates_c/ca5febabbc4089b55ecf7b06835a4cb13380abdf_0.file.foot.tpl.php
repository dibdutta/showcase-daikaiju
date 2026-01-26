<?php
/* Smarty version 3.1.47, created on 2026-01-26 13:45:50
  from '/var/www/html/templates/foot.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6977b65e43b876_43918832',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ca5febabbc4089b55ecf7b06835a4cb13380abdf' => 
    array (
      0 => '/var/www/html/templates/foot.tpl',
      1 => 1769443627,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6977b65e43b876_43918832 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="push"></div>
</div>
<!--Footer Starts-->
<div class="footer">
  <div id="footer" <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/index.php' || (defined('PHP_SELF') ? constant('PHP_SELF') : null) == '') {?> <?php } else { ?> style="border-top:1px solid #333333; margin-top:20px;" <?php }?>>
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
    	<div id="footernavigator" <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/index.php' || (defined('PHP_SELF') ? constant('PHP_SELF') : null) == '') {?> <?php } else { ?>style="border:none;"<?php }?>>
        	<div class="left">
            	<ul class="menu">
                	<li <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '' || (defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/index.php') {?>class="active"<?php }?>><a <?php if ($_SESSION['sessUserID'] != '') {?>href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/index.php"<?php } else { ?>href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/index.php"<?php }?> title="Home">Home</a>&nbsp;|&nbsp;</li>                    
                    <?php if ($_SESSION['sessUserID'] != '') {?><li <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/myaccount.php') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/myaccount.php" title="My Account">My Dashboard</a>&nbsp;|&nbsp;</li><?php }?>
                    <li <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/buy.php' && $_REQUEST['mode'] == 'refinesrc') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/buy.php?mode=refinesrc" title="Advanced Search">Advanced Search</a>&nbsp;|&nbsp;</li>
                    <li <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/siteurl.php') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/siteurl.php" title="Sitemap">Sitemap</a>&nbsp;|&nbsp;</li>
                    <li <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/contactus.php') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/contactus.php" title="Contact Us">Contact Us</a>&nbsp;|&nbsp;</li>
                                        <li <?php if ((defined('PHP_SELF') ? constant('PHP_SELF') : null) == '/privacypolicy.php') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/user_agreement.php" title="User Agreement and policies">User Agreement and Policies</a></li>
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
<?php }
}
