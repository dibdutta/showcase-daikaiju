{include file="header.tpl"}
    <script type="text/javascript" src="{$actualPath}/javascript/fancybox/jquery-min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="{$actualPath}/javascript/fancybox/jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="{$actualPath}/javascript/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<!-- 	<link rel="stylesheet" href="{$actualPath}/javascript/fancybox/style.css" />-->
 	{literal}
 	<script type="text/javascript">
		//$(document).ready(function() {
			/*
			*   Examples - images
			*/
		function fancy_images(i){
			$("#various_"+i).fancybox({
				'width'				: '75%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		}
			
		//});
		</script>
 	{/literal}
<div id="forinnerpage-container">
	<div id="wrapper">
    	 <!--Header themepanel Starts-->
    <div id="headerthemepanel">
      <!--Header Theme Starts-->
       		<div id="searchbar">
            	<div class="search-left-bg"></div>
                <div class="search-midrept-bg">
                	<label><img src="images/search-img.png" width="20" height="32"  /></label>
                	<input type="text" name="txt1" class="srchbox-txt" />
                    <input type="button" value="Search" class="srchbtn-main"  />
                    <input type="button" value="Refine Search" class="refine-srchbtn-main"  />
                </div>
                <div class="search-right-bg"></div>
              </div> 
      <!--Header Theme Ends-->
    </div>
    <!--Header themepanel Ends-->
    
    <div id="inner-container">
    	<div id="inner-left-container">
			 <div id="tabbed-inner-nav">
             <div class="tabbed-inner-nav-left">
             	<ul class="menu">
                	<li class="active"><a href="{$actualPath}/my_invoice"><span>My Invoice(Seller)</span></a></li>
                	<li class="active"><a href="{$actualPath}/my_invoice?mode=buyer_view"><span>My Invoice(Buyer)</span></a></li>
                </ul>
				<div class="tabbed-inner-nav-right"></div>
				</div>	
            </div>
             
            <div class="innerpage-container-main">
            	<div class="top-main-bg"></div>
                <div class="mid-rept-bg">
                {if $total>0}	
                <!--    inner listing starts-->
                    
                  <div class="display-listing-main">
						<div class="gnrl-listing">
                        {if $errorMessage<>""}<div class="messageBox">{$errorMessage}</div>{/if}
                        <form name="listFrom" id="listForm" action="" method="post">
                            	<input type="hidden" name="encoded_string" value="{$encoded_string}" />
                        	<table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                	
                                	<td width="25%"><strong>Poster Title</strong>
                                    </td>
                                    
                                    <td width="40%"><strong>Billing Date</strong>
                                    </td>
                                    
                                    <td width="25%"><strong>Price</strong>
                                    </td>
                                    <td> <strong>Action</strong></td>
                                </tr>
								{section name=counter loop=$invoiceData}
                                <tr>
                                <td align="left">{$invoiceData[counter].poster_details}</td>
                                <td>{$invoiceData[counter].post_date|date_format:"%m/%d/%Y"}</td>
                                <td>${$invoiceData[counter].total_amount}</td>
                                <td><a id="various_{$smarty.section.counter.index}" href="{$actualPath}/my_invoice?mode=buyer_print&invoice_id={$invoiceData[counter].invoice_id}"><img alt="Print" title="Print" src="{$actualPath}/images/print.jpg" onclick="fancy_images({$smarty.section.counter.index})"></a></td>
                                </tr>
                                {/section}
                            </table>
                           
                        </div>					
                       
                  </div>
                 
                  <!--    inner listing ends-->
                  
<!--                     <div class="top-display-panel">-->
<!--                        <div class="right-area">-->
<!--                        	{$pageCounterTXT}-->
<!--                        </div>-->
<!--                        -->
<!--                         <div class="left-area">-->
<!--                         	<div class="results-area">-->
<!--                        	<span>{$displayCounterTXT}</span>-->
<!--                           </div>-->
<!--                            </div>-->
<!--                            <div class="left-area">-->
<!--                         	<div class="results-area">-->
<!--                        	<span><a href="#" onclick="javascript: markAllSelectedRows('listForm'); return false;" class="new_link">Check All</a> / <a href="#" onclick="javascript: unMarkSelectedRows('listForm'); return false;" class="new_link">Uncheck All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--											</span>-->
<!--                           </div>-->
<!--                            </div>-->
<!--                            <div class="right-area">-->
<!--                        	<span><select name="mode" class="look" onchange="javascript: this.form.submit();" >-->
<!--												<option value="" selected="selected">With Selected</option>-->
<!--												<option value="delete_all_messages">Delete Message</option>-->
<!--											</select></span>-->
<!--                        	</div>-->
<!--                            </div>   -->
                    
                       </form>
                       {else}
                       <table width="100%" cellpadding="3" cellspacing="1" align="left" border="0">
                            	<tr>
                                <td colspan="4" align="center" style="font-size:11px; font-weight:bold;">Sorry No Invoice to Display.</td>
                                </tr></table>
                       {/if}
                    
                </div>
                <div class="btom-main-bg"></div>
            </div>
        </div>
        
        {include file="right-panel.tpl"}
    </div>
    
    </div>
    <div class="clear"></div>
</div>
{include file="foot.tpl"}