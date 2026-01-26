<?php /* Smarty version 2.6.14, created on 2018-06-17 08:08:26
         compiled from admin_create_fixed_auction.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'sizeof', 'admin_create_fixed_auction.tpl', 285, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['actualPath']; ?>
/javascript/uploadify/jquery.uploadify.js"></script>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
	$("#fileUpload").fileUpload({
		\'uploader\': \'../javascript/uploadify/uploader.swf\',
		\'cancelImg\': \'../javascript/uploadify/cancel.png\',
		\'script\': \'../javascript/uploadify/upload.php\',
		\'folder\': \'../poster_photo/temp/';  echo $this->_tpl_vars['random'];  echo '\',
		\'fileDesc\': \'Image Files\',
		\'sizeLimit\':\'2000000\',
		\'fileExt\': \'*.jpg;*.jpeg;*.gif;*.png\',
		\'auto\': true,
		\'buttonText\': \'Add Photo(s)\',
		\'onComplete\': function(event, ID, fileObj, response, data) {
			$("#fileUploadQueue").show();
			var fileLimit = parseInt(';  echo @MAX_UPLOAD_POSTER;  echo ');
			var photosArr = $("#poster_images").val().split(\',\');
			var flag = false;
			var image = \'';  echo $this->_tpl_vars['actualPath']; ?>
/poster_photo/temp/<?php echo $this->_tpl_vars['random']; ?>
/'+fileObj.name+'<?php echo '\';
			for(i=0;i<photosArr.length;i++){
				if(photosArr[i] == fileObj.name){
					flag = true;
				}
			}
			
			
			if(!flag){
				var cnt=document.getElementById("cnt").value;
				cnt=Number(cnt)+1;
				document.getElementById("cnt").value=cnt;
				if(cnt == 1){
				var radList = document.getElementsByName(\'is_default\');
for (var i = 0; i < radList.length; i++) {
if(radList[i].checked) radList[i].checked = false;
}
					checked = \'checked\';
				}else{
					checked = \'\';
				}
				var newDate = new Date;
			    var randCount=newDate.getTime();
			    
				var html = \'<div id="photo_\'+randCount+\'" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img style="border:3px solid #474644;" src="\'+image+\'" height="78" width="100" /><input type="radio" name="is_default" value="\'+fileObj.name+\'" \'+checked+\' /><br /><img src="';  echo @CLOUD_STATIC; ?>
delete-icon.png<?php echo '" onclick="deletePhoto(\\\'photo_\'+randCount+\'\\\', \\\'\'+fileObj.name+\'\\\', \\\'new\\\')" /></div>\';
				$("#photos").append(html);
				$("#poster_images").val($("#poster_images").val()+fileObj.name+",");
			}

			if(cnt==12){
                $("#browse").hide();
				$("#path").hide();
            }else{
                $("#browse").show();
				$("#path").show();
            }
    	}
	});
  });
	function chkPosterSize(id){
	    if(id!=""){
    	var url = "../bid_popup.php";
    	$.get(url, {mode : \'chkPosterSizeCount\', id : id}, function(data){
    	var newData = data.split("-");
		document.getElementById(\'no_sizes\').value=newData[0];
    			if( newData[0] ==1){
    				$("#flat_rolled").show();
    				if(newData[1]==\'f\'){
    					$("#rolled").hide();
    					$("#folded").show();
    					$("#folded_selected")[0].checked = true;
    				}else if(newData[1]==\'r\'){
    					$("#folded").hide();
    					$("#rolled").show();
    					$("#rolled_selected")[0].checked = true;
    				}
    				
    			}else if(newData[0]==2){
    				$("#flat_rolled").show();
    				$("#rolled").show();
    				$("#folded").show();
    			}
    	 	});	
		}else{
			$("#flat_rolled").hide();
		}	
    }
	function autocom(q){
	var url = "../ajax.php?mode=autocomplete_admin&q=" + q;
	jQuery.ajax({
  	type : \'GET\',
  	url : url,
  	data: {
 	 },
 	 beforeSend : function(){
   		//loading
  		},
  	 success : function(data){
	  if(data!=\'\'){
	 	$("#auto_load").show();
   		$("#auto_load").html(data);
		}else{
		$("#auto_load").hide();
		}
  	},
  	error : function(XMLHttpRequest, textStatus, errorThrown) {
  	}
	});
	}
	
	function set_result(name,id){
		document.getElementById(\'user\').value=name;
		document.getElementById(\'user_id\').value=id;
		$("#auto_load").hide();
	}
	
	function checkMinOffer(){
		if ($(\'#is_consider\').is(\':checked\')) {
			//alert(\'checked\');
			$("#minOfferDiv").show();
		} else {
			// alert(\'unchecked\');
			$("#minOfferDiv").hide();
		}
    }
</script>
'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td align="center" valign="top" class="bold_text">Manage Poster / Auction</td>
				</tr>
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
                <?php if ($this->_tpl_vars['event_id_err'] != ''): ?>
                <tr>
					<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['event_id_err']; ?>
</div></td>
				</tr>
                <?php endif; ?>
				<tr>
					<td align="center">
						<form method="post" action="" name="configManager" id="configManager">
							<input type="hidden" name="mode" value="save_fixed_auction">
							   <input type="hidden" name="cnt" id="cnt" value="<?php echo $this->_tpl_vars['cnt']; ?>
" />
                            <input type="hidden" name="random" value="<?php echo $this->_tpl_vars['random']; ?>
" />
							<input type="hidden" id="no_sizes" name="no_sizes" value="<?php echo $this->_tpl_vars['no_sizes']; ?>
" />
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td align="center">
										<table align="center" width='70%' border="0" cellpadding="2" cellspacing="1" class="header_bordercolor">
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Poster Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>User :</td>
												<td class="smalltext">
                                                <div class="UserNameSearch" style="position:relative;">
												<div><input type="text" name="user" id="user"  class="look" value="<?php echo $this->_tpl_vars['user']; ?>
"  onkeyup="autocom(this.value);"/></div>						
                       						    <div id="auto_load" style="width:150px; position:absolute; z-index:100px; top:20px; left:0px; background-color:#CCCCCC; display:none;"></div>
												<input type="hidden" name="user_id" id="user_id" value="<?php echo $this->_tpl_vars['user_id']; ?>
"  class="look"/>
												<br /><span class="err"><?php echo $this->_tpl_vars['user_id_err']; ?>
</span>
                                                </div>
                                                </td>
                                                
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top" width="36%"><span class="err">*</span>Poster Title :</td>
												<td class="smalltext"><input type="text" name="poster_title" value="<?php echo $this->_tpl_vars['poster_title']; ?>
" size="40" class="look" /><br /><span class="err"><?php echo $this->_tpl_vars['poster_title_err']; ?>
</span></td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Size :</td>
												<td class="smalltext">
                                                <select name="poster_size" class="look" onchange="chkPosterSize(this.value)">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 1): ?>
                                                        <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['poster_size']): ?>
                                                            <?php $this->assign('selected', 'selected'); ?>
                                                        <?php endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['poster_size_err']; ?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Genre :</td>
												<td class="smalltext">
                                                <select name="genre" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 2): ?>
                                                        <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['genre']): ?>
                                                            <?php $this->assign('selected', 'selected'); ?>
                                                        <?php endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['genre_err']; ?>
</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Decade :</td>
												<td class="smalltext">
                                                <select name="dacade" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 3): ?>
                                                        <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['dacade']): ?>
                                                            <?php $this->assign('selected', 'selected'); ?>
                                                        <?php endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['dacade_err']; ?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Country :</td>
												<td class="smalltext">
                                                <select name="country" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 4): ?>
                                                        <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['country']): ?>
                                                            <?php $this->assign('selected', 'selected'); ?>
                                                        <?php endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['country_err']; ?>
</span>
                                                </td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Condition :</td>
												<td class="smalltext">
                                                <select name="condition" class="look">
                                                    <option value="" selected="selected">Select</option>
                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['catRows']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                    <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['fk_cat_type_id'] == 5): ?>
                                                        <?php if ($this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id'] == $this->_tpl_vars['condition']): ?>
                                                            <?php $this->assign('selected', 'selected'); ?>
                                                        <?php endif; ?>
                                                        <option value="<?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_id']; ?>
" <?php echo $this->_tpl_vars['selected']; ?>
><?php echo $this->_tpl_vars['catRows'][$this->_sections['counter']['index']]['cat_value']; ?>
</option>
                                                        <?php $this->assign('selected', ""); ?>
                                                    <?php endif; ?>
                                                    <?php endfor; endif; ?>
                                            	</select><br /><span class="err"><?php echo $this->_tpl_vars['condition_err']; ?>
</span>
                                                </td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Description :</td>
												<td class="smalltext">
												<?php echo $this->_tpl_vars['poster_desc']; ?>
<br /><span class="err"><?php echo $this->_tpl_vars['poster_desc_err']; ?>
</span>
												</td>
											</tr>
                                            <tr class="tr_bgcolor">
                                                <td>&nbsp;</td>
                                                <td class="smalltext">
												<div id="flat_rolled" <?php if ($this->_tpl_vars['flat_rolled'] == ''): ?> style="display:none;" <?php endif; ?>>
                                                <div id="folded" <?php if ($this->_tpl_vars['flat_rolled'] == 'rolled' && $this->_tpl_vars['no_sizes'] != '2'): ?> style="display:none;"<?php endif; ?>>
												<input id="folded_selected" type="radio" name="flat_rolled" value="flat" checked="checked" /><label>&nbsp;Folded&nbsp;</label>
												</div>
                                                <div id="rolled" <?php if ($this->_tpl_vars['flat_rolled'] == 'flat' && $this->_tpl_vars['no_sizes'] != '2'): ?> style="display:none;"<?php endif; ?>>
												<input id="rolled_selected"  type="radio" name="flat_rolled" value="rolled" <?php if ($this->_tpl_vars['flat_rolled'] == 'rolled'): ?> checked="checked" <?php endif; ?> /><label>&nbsp;Rolled</label>
												</div>
												</div>
                                                </td>
                                            </tr>
                                            <tr class="tr_bgcolor">
												<td align="center" colspan="2">
                                                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    	<tr>
                                                        	<td align="center">
                                                                <div id="browse" style="padding:5px 0px;<?php if (sizeof($this->_tpl_vars['poster_images_arr']) >= @MAX_UPLOAD_POSTER): ?>display:none;<?php endif; ?>">
                                                                	<div id="fileUpload">You have a problem with your javascript</div>
                                                                	<input type="hidden" name="poster_images" id="poster_images" value="<?php echo $this->_tpl_vars['poster_images']; ?>
" class="validate required" />
                                                                	<div class="err"><?php echo $this->_tpl_vars['poster_images_err']; ?>
</div>
                                                                    <div class="err"><?php echo $this->_tpl_vars['is_default_err']; ?>
</div>
                                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:11px; width:300px;">Recommended photo size is minimum of 100KB<br/>(800 pixels longest side) to 1.26MB(2000 pixels longest side)</div>
                                                                </div>
                                                 <div id="path" <?php if (sizeof($this->_tpl_vars['poster_images_arr']) >= @MAX_UPLOAD_POSTER): ?> style="display:none;"<?php endif; ?>>               
																											</div>
											<div id="photos" style="width:700px; padding:10px; margin:0px; float:left;">
                                                                    <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['poster_images_arr']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['counter']['show'] = true;
$this->_sections['counter']['max'] = $this->_sections['counter']['loop'];
$this->_sections['counter']['step'] = 1;
$this->_sections['counter']['start'] = $this->_sections['counter']['step'] > 0 ? 0 : $this->_sections['counter']['loop']-1;
if ($this->_sections['counter']['show']) {
    $this->_sections['counter']['total'] = $this->_sections['counter']['loop'];
    if ($this->_sections['counter']['total'] == 0)
        $this->_sections['counter']['show'] = false;
} else
    $this->_sections['counter']['total'] = 0;
if ($this->_sections['counter']['show']):

            for ($this->_sections['counter']['index'] = $this->_sections['counter']['start'], $this->_sections['counter']['iteration'] = 1;
                 $this->_sections['counter']['iteration'] <= $this->_sections['counter']['total'];
                 $this->_sections['counter']['index'] += $this->_sections['counter']['step'], $this->_sections['counter']['iteration']++):
$this->_sections['counter']['rownum'] = $this->_sections['counter']['iteration'];
$this->_sections['counter']['index_prev'] = $this->_sections['counter']['index'] - $this->_sections['counter']['step'];
$this->_sections['counter']['index_next'] = $this->_sections['counter']['index'] + $this->_sections['counter']['step'];
$this->_sections['counter']['first']      = ($this->_sections['counter']['iteration'] == 1);
$this->_sections['counter']['last']       = ($this->_sections['counter']['iteration'] == $this->_sections['counter']['total']);
?>
                                                                        <?php $this->assign('countID', $this->_sections['counter']['index']+1); ?>
                                                                        <div id="photo_<?php echo $this->_tpl_vars['countID']; ?>
" style="float:left; width:110px; padding:0px 2px 0 1px; margin:0px;"><img src="<?php echo $this->_tpl_vars['actualPath']; ?>
/poster_photo/temp/<?php echo $this->_tpl_vars['random']; ?>
/<?php echo $this->_tpl_vars['poster_images_arr'][$this->_sections['counter']['index']]; ?>
" height="78" width="100" /><br /><input type="radio" name="is_default" style=" margin-left:40px;" value="<?php echo $this->_tpl_vars['poster_images_arr'][$this->_sections['counter']['index']]; ?>
" <?php if ($this->_tpl_vars['is_default'] == $this->_tpl_vars['poster_images_arr'][$this->_sections['counter']['index']]): ?> checked="checked" <?php endif; ?> /><br /><img src="<?php echo @CLOUD_STATIC; ?>
delete-icon.png" onclick="deletePhoto('photo_<?php echo $this->_tpl_vars['countID']; ?>
', '<?php echo $this->_tpl_vars['poster_images_arr'][$this->_sections['counter']['index']]; ?>
', 'new')" style=" margin-left:30px;" /></div>
                                                                    <?php endfor; endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
											</tr>
											<tr class="header_bgcolor" height="24">
												<td colspan="2" align="left" class="headertext">Auction Section</td>
											</tr>
                                            <tr class="tr_bgcolor">
												<td class="bold_text" valign="top"><span class="err">*</span>Ask Price :</td>
												<td class="smalltext"><input type="text" name="asked_price" value="<?php echo $this->_tpl_vars['asked_price']; ?>
" maxlength="8" class="look-price" />.00<br /><span class="err"><?php echo $this->_tpl_vars['asked_price_err']; ?>
</span></td>
											</tr>
                                           
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">&nbsp;</td>
												<td class="smalltext">
                                                <input type="checkbox" name="is_consider" <?php if ($this->_tpl_vars['is_consider'] == 1): ?> checked="checked" <?php endif; ?> id="is_consider"  value="1" onclick="checkMinOffer()"  ><label>I will consider offers</label>
                                                </td>
											</tr>
											<tr class="tr_bgcolor" id="minOfferDiv"  <?php if ($this->_tpl_vars['is_consider'] != 1): ?> style="display:none;" <?php endif; ?>>
												<td class="bold_text" valign="top">Min Offer Price :</td>
												<td class="smalltext"><input type="text" name="offer_price" value="<?php echo $this->_tpl_vars['offer_price']; ?>
" maxlength="8" class="look-price" />.00<br /><span class="err"><?php echo $this->_tpl_vars['offer_price_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor">
												<td class="bold_text" valign="top">Notes :</td>
												<td class="smalltext"><textarea name="auction_note" class="look" cols="70" rows="6"><?php echo $this->_tpl_vars['auction_note']; ?>
</textarea><br /><span class="err"><?php echo $this->_tpl_vars['auction_note_err']; ?>
</span></td>
											</tr>
											<tr class="tr_bgcolor" >
												<td class="bold_text" valign="top">ImDB link :</td>
												<td class="smalltext"><input type="text" name="imdb_link" value=""  class="look" /><br /><span class="err"><?php echo $this->_tpl_vars['asked_price_err']; ?>
</span></td>
											</tr>
											<tr height="28" class="tr_bgcolor">
												<td align="center" colspan="2"><input type="submit" name="" value="Add" class="button" />&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $this->_tpl_vars['actualPath'];  echo $this->_tpl_vars['decoded_string']; ?>
'; " /></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>		
</table>
<?php echo '
<script type="text/javascript">
var xmlHttp;
function  fetchimage(image)
{

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var url="fetchimg.php";
url=url+"?imgurl="+image;
//url=url+"&sid="+Math.random();
//alert(url);
xmlHttp.onreadystatechange=stateChanged2;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged2()
{
if (xmlHttp.readyState==4 && xmlHttp.status==200)
{
var subcat_arr=xmlHttp.responseText;
//document.getElementById("onlinephotos").innerHTML=subcat_arr;
var ind=subcat_arr.indexOf("text/javascript");
if(ind==-1){
var cnt=document.getElementById("cnt").value;
if(Number(cnt) >=1)
{
var radList = document.getElementsByName(\'is_default\');
for (var i = 0; i < radList.length; i++) {
if(radList[i].checked) radList[i].checked = false;
}	 
}
cnt=Number(cnt)+1;
document.getElementById("cnt").value=cnt;

if(cnt==12)
{
$("#browse").hide();
$("#path").hide();
}
}
$("#photos").append(subcat_arr);
document.getElementById("imgurl").value="";
}
}
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}
</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>