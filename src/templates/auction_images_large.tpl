		<link rel="stylesheet" href="{$actualPath}/javascript/pagination/pagination.css" />
        <link rel="stylesheet" href="{$actualPath}/javascript/pagination/demo.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="{$actualPath}/javascript/pagination/jquery.pagination.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="{$actualPath}/javascript/jquery.mousewheel.min.js"></script>
		<script src="{$actualPath}/javascript/jquery.mapz.js" type="text/javascript"></script>
		{literal}
		<script type="text/javascript">
		$(document).ready(function() {
			$("#map").mapz({
				zoom : true,
				createmaps : true,
				mousewheel : true
			});
			initPagination();
		});
		</script>
        <!-- 800 * 600 ,  -->
        <style>
			.map-viewport{ position:relative; width:{/literal}{$widthNew}{literal}px; height:670px; border:1px solid black; overflow:hidden; margin:0 0 20px 0;}
			.level{ position:absolute; left:0; top:0; z-index:10;}
			.current-level{ z-index:20; }
			
			#map{ width:{/literal}{$width}px;{literal} height:{/literal}{$height}px;{literal} position:absolute; left:0; top:0; cursor:pointer;}
			img{ border:0; }
			
			.block{ float:left; margin-right:0%; margin-top:00px; }
			*{ margin:0; padding:0; }
			a{color:#09F;text-decoration:none}
			a:hover{color:#000}
			a img{border:0;}
			body{ font-family:TrebuchetMS,Arial,Verdana,Sans-serif; color:#222; font-size:14px; position:relative;}
			nav,aside,header,article,section,footer{display:block}
			input,textarea{padding:0px}
			#page-wrap{background:white; padding:00px; margin:0px auto; border:0px solid #ccc;}
			#header{  text-align:center; }
			
			p{ margin:0 0 0px 0; }
</style>
        <script type="text/javascript">
        
            // This is a very simple demo that shows how a range of elements can
            // be paginated.
            // The elements that will be displayed are in a hidden DIV and are
            // cloned for display. The elements are static, there are no Ajax 
            // calls involved.
        
            /**
             * Callback function that displays the content.
             *
             * Gets called every time the user clicks on a pagination link.
             *
             * @param {int} page_index New Page index
             * @param {jQuery} jq the container with the pagination links as a jQuery object
             */
            function pageselectCallback(page_index){			    
            	window.location = "/auction_images_large.php?mode=auction_images_large&id={/literal}{$smarty.request.id}{literal}&auction_id={/literal}{$smarty.request.auction_id}{literal}&page_index="+page_index;
				
                return false;
            }
           
            /** 
             * Initialisation function for pagination
             */
            function initPagination() {
                // count entries inside the hidden content
                var num_entries ={/literal}{$total_images};{literal}  <!--no of total records-->
                // Create content inside pagination element
                $("#PaginationNew").pagination(num_entries, {
                    callback: pageselectCallback,
                    items_per_page:1 // Show only 10 item per page
                });
             }
            
            // When document is ready, initialize pagination
            
            
            
            
        </script>
		{/literal}
		 <div style="font-family:Arial, Helvetica, sans-serif; color:#CC0000; font-size:16px;"><b>USE MOUSE TO DRAG AND PAN IMAGE</b></div>
			{if $total_images >1}	
			<div class="pagination">		
			{section name=foo start=0 loop=$total_images step=1}
				{if $smarty.request.page_index==$smarty.section.foo.index}
					<span class="current">{$smarty.section.foo.index+1}</span>
				{else }	
					<a href="javascript:void(0)" onclick="pageselectCallback({$smarty.section.foo.index})">{$smarty.section.foo.index+1}</a>
				{/if}
			{/section}	
			</div>
			{/if}
			
			<div id="page-wrap">
		
				<div class="block" style="width:{$widthNew}px;" id="Searchresult" >
					<div class="map-viewport">
						<div id="map">
							<img id="img" src="{$imgArr[0].image_path}"  width="{$width}" height="{$height}" alt="" usemap="#html-map" class="current-level level" style="cursor: hand;" />
							
						</div>
						<map name="html-map">
							<area title="Ruins of Flaegra" shape="rect" coords="75,180,100,200" href="#" />
							<area title="Valley of Mista" shape="rect" coords="145,140,180,160" href="#" />
						</map>
					</div>
				</div>
		
				<br style="clear:both;" />
			</div>
			
			