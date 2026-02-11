{literal}
<script type="text/javascript">
function expand(id,image_id1,image_id2){
    $("#"+id).show(500);
    $("#"+image_id1).show(500);
    $("#"+image_id2).hide(500);
}
function collapse(id,image_id1,image_id2){
    $("#"+id).hide(500);
    $("#"+image_id1).show(500);
    $("#"+image_id2).hide(500);
}
function expand_full(id,image_id1,image_id2){
    $("#"+id).show();
    $("#"+image_id1).show(500);
    $("#"+image_id2).hide(500);
}
function collapse_full(id,image_id1,image_id2){
    $("#"+id).hide();
    $("#"+image_id1).show(500);
    $("#"+image_id2).hide(500);
}
</script>
{/literal}
<div id="inner-right-container" >
    {if $smarty.session.sessUserID != ''}
    <div class="member-name">
        <strong>Welcome {$smarty.session.sessUsername}!</strong>
    </div>
    <div id="member-area">
        <div class="black-left-bg"></div>
        <div class="black-midrept-bg">
            <div class="icon-menu">
                <div style="width:50px; float:left;"><a href="{$actualPath}/myaccount.php?mode=profile"><img src="images/user-profile.png" width="41" height="39" border="0" title="My Profile" alt="My Profile" /></a></div>
                <div style="width:1px; float:left;"><img src="images/profile-img-divider.png" width="1" height="41" border="0" /></div>
                <div style="position:relative; width:50px; float:left;"><a href="{$actualPath}/cart.php"><img src="images/cart-icon.png" width="45" height="43" border="0" title="My Cart" alt="My Cart" />
                    <div style="width:20px; padding:0px; margin:0px; font-size:10px; position:absolute; top:25px; left:3px; text-align:center;">{$smarty.session.cart|@count}</div>
                </a>
                </div>
                <div style="width:1px; float:left;"><img src="images/profile-img-divider.png" width="1" height="41" border="0" /></div>
                <div style="width:50px; float:left;"><a href="{$actualPath}/myaccount.php?mode=logout"><img src="images/logout-icon.png" width="41" height="39" border="0" title="Logout" alt="Logout" /></a></div>
            </div>
            <div class="member-box">
            <div class="left-round-crnr"></div>
            <div class="mid-rept-profile">
            <ul class="menu-txt">
                <li class="profile"><a href="{$actualPath}/myaccount.php?mode=profile">Profile</a></li>
                <li><img src="images/profile-dividr.png" width="1" height="14" border="0" /></li>
                <li class="cart"><a href="{$actualPath}/cart.php">Cart</a></li>
                <li><img src="images/profile-dividr.png" width="1" height="14" border="0" /></li>
                <li class="logout"><a href="{$actualPath}/myaccount.php?mode=logout">Logout</a></li>
            </ul>
            </div>
            <div class="right-round-crnr"></div>
           
            </div>
        </div>
        <div class="black-right-bg"></div>
    </div>
    
    <div class="grey-collapsable-container">
        <div class="dark-grey-topbg">
            <div class="left-bg-main"></div>
            <div class="midrept-bg-main">
                <div class="txt">USER SECTION</div>
              <div class="grey-image">
                 <a href="javascript:void(0)"><img id="user_section_expand" src="images/expand.png" width="13" height="13" border="0" style="display:none;" onclick="expand_full('user_section','user_section_collapse','user_section_expand')" /></a>
                                     <a href="javascript:void(0)"><img id="user_section_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse_full('user_section','user_section_expand','user_section_collapse')" /></a></div>
            </div>
            <div class="right-bg-main"></div>
        </div>
        <div id="user_section">
        <div class="grey-collapse-tab">
            <div class="tab-txt">
            <strong>MY BUYING</strong></div>
            <div class="tab-image">
            <a href="javascript:void(0)"><img id="buying_expand" src="images/expand.png" width="13" height="13" border="0" style="display:none;" onclick="expand('my_buying','buying_collapse','buying_expand')" /></a>
                                            <a href="javascript:void(0)"><img id="buying_collapse" src="images/collapse.png" width="13" height="13" border="0"  onclick="collapse('my_buying','buying_expand','buying_collapse')" /></a></div>
        </div>
        
        <div class="grey-collapse-listing" id="my_buying">
            <ul class="menu">
                <li><a href="#">Bids &amp; Offers</a></li>
                <li><a href="{$actualPath}/user_watching.php">Watch List&nbsp;({$count_watching})</a></li>                
            </ul>
        </div>
        <div class="grey-collapse-tab non-collapse-img">
        <div class="tab-txt">
            <strong>MY SELLING</strong></div>
            <div class="tab-image">
            <a href="javascript:void(0)"><img id="selling_expand" src="images/expand.png" width="13" height="13" border="0" style="display:none;"  onclick="expand('my_selling','selling_collapse','selling_expand')"/></a>
                                             <a href="javascript:void(0)"><img id="selling_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse('my_selling','selling_expand','selling_collapse')" /></a></div>
        </div>
        
        <div class="grey-collapse-listing" id="my_selling">
            <ul class="menu">
                <li><a href="{$actualPath}/myselling.php?mode=manualupload">Manual Upload</a></li>
                <li><a href="{$actualPath}/myselling.php?mode=bulkupload">Bulk Upload</a></li>
                <li><a href="{$actualPath}/myselling.php?mode=selling">Selling</a></li>
                <li><a href="{$actualPath}/myselling.php?mode=pending">Pending</a></li>
                <li><a href="{$actualPath}/myselling.php?mode=sold">Sold</a></li>
                <li><a href="{$actualPath}/myselling.php?mode=unsold">Unsold/Closed</a></li>
                {*<li><a href="#">Send Tracking Info</a></li>*}
            </ul>
        </div>
        
         <div class="grey-collapse-tab">
            <div class="tab-txt">
            <strong>MY ACCOUNT</strong></div>
            <div class="tab-image">
            <a href="javascript:void(0)"><img id="acount_expand" src="images/expand.png" width="13" height="13" border="0" style="display:none;" onclick="expand('my_account','acount_collapse','acount_expand')" /></a>
                                             <a href="javascript:void(0)"><img id="acount_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse('my_account','acount_expand','acount_collapse')" /></a></div>
        </div>
        <div class="grey-collapse-listing" id="my_account">
            <ul class="menu">
                <li><a href="{$actualPath}/myaccount.php">My Account / Dashboard</a></li>
                <li><a href="{$actualPath}/myaccount.php?mode=profile">Profile</a></li>
                <li><a href="{$actualPath}/send_message.php">Messages&nbsp;({$countMsg}) </a></li>
                <li><a href="{$actualPath}/my_want_list.php">My Want List ({$total_want_count})</a></li>
                <li><a href="{$actualPath}/my_invoice">Invoices</a></li>
                <li><a href="{$actualPath}/my_report">Reports</a></li>
                <li><a href="{$actualPath}/myaccount?mode=change_password">Change Password</a></li>
            </ul>
        </div>
        
       <div class="rounded-bg"></div>
    </div>
    </div>
    {/if}
    
    <div class="grey-collapsable-container" {if $smarty.session.sessUserID == ''} style="margin-top:0px;" {/if}>
    
        <div class="dark-grey-topbg">
            <form name="frm_refine" id="frm_refine" method="get" action="{$actualPath}/buy.php">
                <input type="hidden" name="mode" value="search" />
                <input type="hidden" name="poster_size_id" id="poster_size_id" value="{$smarty.request.poster_size_id}" />
                <input type="hidden" name="genre_id" id="genre_id" value="{$smarty.request.genre_id}" />
                <input type="hidden" name="decade_id" id="decade_id" value="{$smarty.request.decade_id}" />
                <input type="hidden" name="country_id" id="country_id" value="{$smarty.request.country_id}" />
            </form>
            <div class="left-bg-main"></div>
            <div class="midrept-bg-main">
                <div class="txt">REFINE SEARCH</div>
                <div class="grey-image">
                    <a href="javascript:void(0)"><img id="refine_expand" src="images/expand.png" width="13" height="13" border="0" style="display:none;" onclick="expand_full('all_right','refine_collapse','refine_expand')" /></a>
                    <a href="javascript:void(0)"><img id="refine_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse_full('all_right','refine_expand','refine_collapse')" /></a>
                </div>
            </div>
            <div class="right-bg-main"></div>
        </div>
        <div id="all_right">
        <div class="grey-collapse-tab">
            <div class="tab-txt"><strong>CATEGORY/GENRE</strong></div>
            <div class="tab-image">
                <a href="javascript:void(0)"><img id="category_expand" src="images/expand.png" width="13" height="13" border="0" onclick="expand('category','category_collapse','category_expand')" style="display:none;" /></a>
                <a href="javascript:void(0)"><img id="category_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse('category','category_expand','category_collapse')" /></a>
            </div>
        </div>
        
        <div class="grey-collapse-listing" id="category">
            <ul class="menu">
            {section name=counter loop=$rightPanelCatRows}
                {if $rightPanelCatRows[counter].fk_cat_type_id==2}
                <li><a href="javascript:void(0);" onclick="$('#genre_id').val({$rightPanelCatRows[counter].cat_id});$('#frm_refine').submit();">{$rightPanelCatRows[counter].cat_value}</a>
                {if $smarty.request.genre_id == $rightPanelCatRows[counter].cat_id}
                <img class="srch-cnclbtn" src="images/cancel-btn.png" width="8" height="9" border="0" onclick="$('#genre_id').val('');$('#frm_refine').submit();" />
                {/if}
                </li>
                {/if}
            {/section} 
            </ul>
        </div>
        
        <div class="grey-collapse-tab non-collapse-img">
            <div class="tab-txt"><strong>Search All Sizes</strong></div>
            <div class="tab-image">
                <a href="javascript:void(0)"><img id="size_expand" src="images/expand.png" width="13" height="13" border="0" onclick="expand('size','size_collapse','size_expand')" style="display:none;"/></a>
                <a href="javascript:void(0)"><img id="size_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse('size','size_expand','size_collapse')"/></a>
            </div>
        </div>
        
        <div class="grey-collapse-listing" id="size">
            <ul class="menu">
            {section name=counter loop=$rightPanelCatRows}
                {if $rightPanelCatRows[counter].fk_cat_type_id==1}
                <li><a href="javascript:void(0);" onclick="$('#poster_size_id').val({$rightPanelCatRows[counter].cat_id});$('#frm_refine').submit();">{$rightPanelCatRows[counter].cat_value|escape:'html'}</a>
                {if $smarty.request.poster_size_id == $rightPanelCatRows[counter].cat_id}
                <img class="srch-cnclbtn" src="images/cancel-btn.png" width="8" height="9" border="0" onclick="$('#poster_size_id').val('');$('#frm_refine').submit();" />
                {/if}
                </li>
                {/if} 
            {/section} 
            </ul>
        </div>
        
        <div class="grey-collapse-tab" >
            <div class="tab-txt"><strong>Search all Decades</strong></div>
            <div class="tab-image">
                <a href="javascript:void(0)"><img id="decade_expand" src="images/expand.png" width="13" height="13" border="0" onclick="expand('decade','decade_collapse','decade_expand')" style="display:none;" /></a>
                <a href="javascript:void(0)"><img id="decade_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse('decade','decade_expand','decade_collapse')"/></a>
            </div>
        </div>
        <div class="grey-collapse-listing" id="decade">
            <ul class="menu">
            {*{section name=foo start=1900 loop=2011 step=10}
            <li><a href="javascript:void(0)">{$smarty.section.foo.index}&nbsp;&nbsp;-&nbsp;&nbsp;{if $smarty.section.foo.index+9 >2011}Till Date {else}{$smarty.section.foo.index+9}{/if}</a>
            <img class="srch-cnclbtn" src="images/cancel-btn.png" width="8" height="9" border="0" />
            </li>
            {/section} *}
            {section name=counter loop=$rightPanelCatRows}
                {if $rightPanelCatRows[counter].fk_cat_type_id==3}
                <li><a href="javascript:void(0);" onclick="$('#decade_id').val({$rightPanelCatRows[counter].cat_id});$('#frm_refine').submit();">{$rightPanelCatRows[counter].cat_value|escape:'html'}</a>
                {if $smarty.request.decade_id == $rightPanelCatRows[counter].cat_id}
                <img class="srch-cnclbtn" src="images/cancel-btn.png" width="8" height="9" border="0" onclick="$('#decade_id').val('');$('#frm_refine').submit();" />
                {/if}
                </li>
                {/if} 
            {/section} 
            </ul>
        </div>        
        <div class="grey-collapse-tab">
            <div class="tab-txt"><strong>Search all Countries</strong></div>
            <div class="tab-image">
                <a href="javascript:void(0)"><img id="country_expand" src="images/expand.png" width="13" height="13" border="0" onclick="expand('country','country_collapse','country_expand')" style="display:none;" /></a>
                <a href="javascript:void(0)"><img id="country_collapse" src="images/collapse.png" width="13" height="13" border="0" onclick="collapse('country','country_expand','country_collapse')"/></a>
            </div>
        </div>
        
        <div class="grey-collapse-listing" id="country">
            <ul class="menu">
            {section name=counter loop=$rightPanelCatRows}
                {if $rightPanelCatRows[counter].fk_cat_type_id==4}
                <li><a href="javascript:void(0);" onclick="$('#country_id').val({$rightPanelCatRows[counter].cat_id});$('#frm_refine').submit();">{$rightPanelCatRows[counter].cat_value}</a>
                {if $smarty.request.country_id == $rightPanelCatRows[counter].cat_id}
                <img class="srch-cnclbtn" src="images/cancel-btn.png" width="8" height="9" border="0" onclick="$('#country_id').val('');$('#frm_refine').submit();" />
                {/if}
                </li>
                {/if}
            {/section}                
            </ul>
        </div>
        
         <div class="grey-collapse-tab">
          <div class="tab-txt">
            <strong>Closed/Sold <br />
items only option</strong></div> <div class="tab-image">
<a href="#"><img src="images/expand.png" width="13" height="13" border="0" /></a></div>
        </div>
        
       <div class="rounded-bg"></div>
        
    </div>          
        </div>  
    <div class="lower-side-container">
        <div class="top-bg-main">
        <div class="left-bg-main"></div>
        <div class="midrept-bg-main">
            How to Order?
        </div>
        <div class="right-bg-main"></div>
        </div>
        <div class="mid-lower-panel">
            <img class="imgprpty" src="images/visa-img.png" width="61" height="64" border="0" />
            <p>Dolor sit amet, consetetur sadipscing elitr, seddiam nonumy eirmod tempor. 
            </p>
        </div>
        <div class="rounded-bg"></div>
    </div>    
    <div class="lower-side-container">
        <div class="top-bg-main">
            <div class="left-bg-main"></div>
            <div class="midrept-bg-main">Other Details</div>
            <div class="right-bg-main"></div>
        </div>
        <div class="mid-lower-panel">
            <div class="sub-panels-lower">
                <span>Consetetur<br /> sadipscing elitr,<br />seddiam</span>
                <img class="imgprpty" src="images/mail-main.png" width="61" height="55" border="0" />
            </div>
            <div class="sub-panels-lower">
            <span>Consetetur<br /> sadipscing elitr,<br />seddiam</span>
            <img class="imgprpty" src="images/order-van.png" width="61" height="55" border="0" />
            </div>
             <div class="sub-panels-lower">
            <span>Consetetur<br /> sadipscing elitr,<br />seddiam</span>
            <img class="imgprpty" src="images/archive-icon.png" width="61" height="55" border="0" />
            </div>
        </div>        
        <div class="rounded-bg"></div>        
    </div>          
</div>