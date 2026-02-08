<?php
/* Smarty version 3.1.47, created on 2026-02-07 12:30:10
  from '/var/www/html/admin_templates/admin_user_edit.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_698776a2241b74_63942839',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e6f1d65d9935f8f40f38d8c8f64c0dcf693d8646' => 
    array (
      0 => '/var/www/html/admin_templates/admin_user_edit.tpl',
      1 => 1487960230,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.tpl' => 1,
    'file:admin_footer.tpl' => 1,
  ),
),false)) {
function content_698776a2241b74_63942839 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/var/www/html/libs/plugins/function.html_options.php','function'=>'smarty_function_html_options',),));
$_smarty_tpl->_subTemplateRender("file:admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 language="javascript">
$(document).ready(function() {
	stateOptions($('#country_id').val(), 'state_textbox', 'state_select');
	stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
});
/*function shipsame(form){

	if(form.sameasbilling.checked){
	
		form.shipping_firstname.value = form.firstname.value;
		form.shipping_lastname.value = form.lastname.value;
		form.shipping_address1.value = form.address1.value;
		form.shipping_address2.value = form.address2.value;
		form.shipping_city.value = form.city.value;
		form.shipping_state.value = form.state.value;
		form.shipping_zipcode.value = form.zipcode.value;
		
		if(form.country_id.type == "Select"){
			 var bCountryIdx = form.country_id.selectedIndex;
			 form.shipping_country_id.options[bCountryIdx].selected = true;
		}else{
			form.shipping_country_id.value = form.country_id.value;
		}
	}else{
		form.shipping_firstname.value = "";
		form.shipping_lastname.value = "";
		form.shipping_address1.value = "";
		form.shipping_address2.value  = "";
		form.shipping_city.value="";
		form.shipping_state.value = "";
		form.shipping_zipcode.value = "";
		if(form.shipping_country_id.type == "Select"){
			 form.shipping_country_id.options[0].selected = true;
		}else{
			 form.shipping_country_id.value = "";
		}
	}
}*/

function shipsame(form){

	if(form.sameasbilling.checked){

		form.shipping_firstname.value = form.firstname.value;
		form.shipping_lastname.value = form.lastname.value;
		form.shipping_address1.value = form.address1.value;
		form.shipping_address2.value = form.address2.value;
		form.shipping_city.value = form.city.value;
		form.shipping_zipcode.value = form.zipcode.value;

		if(form.country_id.type == "Select"){
			var bCountryIdx = form.country_id.selectedIndex;
			form.shipping_country_id.options[bCountryIdx].selected = true;
		}else{
			form.shipping_country_id.value = form.country_id.value;
			
			if(form.country_id.value == 230){
				form.shipping_state_select.value = form.state_select.value;
			}else{
				form.shipping_state_textbox.value = form.state_textbox.value;
			}
			
			stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
		}

	}else{
		form.shipping_firstname.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_firstname']->value;?>
" ;
		form.shipping_lastname.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_lastname']->value;?>
" ;
		form.shipping_address1.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_address1']->value;?>
" ;
		form.shipping_address2.value  =  "<?php echo $_smarty_tpl->tpl_vars['shipping_address2']->value;?>
" ;
		form.shipping_city.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_city']->value;?>
" ;
		form.shipping_zipcode.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_zipcode']->value;?>
" ;
		if(form.shipping_country_id.type == "Select"){
			form.shipping_country_id.options[0].selected = true;
		}else{
			form.shipping_country_id.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_country_id']->value;?>
" ;
			 
			if(form.shipping_country_id.value == 230){
				form.shipping_state_select.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_state']->value;?>
" ;
			}else{
				form.shipping_state_textbox.value =  "<?php echo $_smarty_tpl->tpl_vars['shipping_state']->value;?>
" ;
			}
			
			stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');
		}
	}
}
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['actualPath']->value;?>
/javascript/formvalidation.js"><?php echo '</script'; ?>
>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%" align="center">
			<form name="frm_edit_profile" id="frm_edit_profile" method="post" action="">
				<input type="hidden" name="mode" value="update_user" />
				<input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
" />
				<input type="hidden" name="encoded_string" value="<?php echo $_smarty_tpl->tpl_vars['encoded_string']->value;?>
" />
				<table width="60%" border="0" cellspacing="1" cellpadding="5" align="center" class="header_bordercolor">
					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Update User Details</b></td>
					</tr>
                    <tr class="tr_bgcolor">
                        <td valign="top" width="30%"> Username : </td>
                        <td width="70%"><?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</td>
                    </tr>
                    <tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Billing Address</b></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Firstname : </td>
						<td><input type="text" name="firstname" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['firstname']->value;?>
"> 
								<br /><span class="err" id="firstname_err"><?php echo $_smarty_tpl->tpl_vars['firstname_err']->value;?>
</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Lastname : </td>
						<td><input type="text" name="lastname" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['lastname']->value;?>
"> 
								<br /><span class="err" id="lastname_err"><?php echo $_smarty_tpl->tpl_vars['lastname_err']->value;?>
</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Email : </td>
						<td><input type="text" name="email" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
"> 
								<br /><span class="err" id="email_err"><?php echo $_smarty_tpl->tpl_vars['email_err']->value;?>
</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Address1 : </td>
						<td><input type="text" name="address1" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['address1']->value;?>
"> 
								<br /><span class="err" id="address1_err"><?php echo $_smarty_tpl->tpl_vars['address1_err']->value;?>
</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"> Address2 : </td>
						<td><input type="text" name="address2" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['address2']->value;?>
"> 
								<br /><span class="err" id="address2_err"><?php echo $_smarty_tpl->tpl_vars['address2_err']->value;?>
</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Country : </td>
						<td>
                            <select name="country_id" id="country_id" onchange="stateOptions($('#country_id').val(), 'state_textbox', 'state_select');" class="look">
                                <option value="" selected="selected">Select</option>
                                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['countryID']->value,'output'=>$_smarty_tpl->tpl_vars['countryName']->value,'selected'=>$_smarty_tpl->tpl_vars['country_id']->value),$_smarty_tpl);?>

                            </select>
                            <br /><span id="country_id_err" class="err"><?php echo $_smarty_tpl->tpl_vars['country_id_err']->value;?>
</span>
                        </td>
					</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> State or Province : </td>
						<td>
                                                        <input type="text" name="state_textbox" id="state_textbox" <?php if ($_smarty_tpl->tpl_vars['country_id']->value != 230) {?> value="<?php echo $_smarty_tpl->tpl_vars['state']->value;?>
" <?php }?> class="look required" <?php if ($_smarty_tpl->tpl_vars['country_id']->value == 230) {?> style="display:none;" <?php }?> />
                            <select name="state_select" id="state_select" <?php if ($_smarty_tpl->tpl_vars['country_id']->value != 230) {?> style="display:none;" <?php }?> class="look">
                                                                <?php
$__section_counter_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['us_states']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_0_total = $__section_counter_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_0_total !== 0) {
for ($__section_counter_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_0_iteration <= $__section_counter_0_total; $__section_counter_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['us_states']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['us_states']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['abbreviation'] == $_smarty_tpl->tpl_vars['state']->value) {?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['us_states']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'];?>
</option>
                                <?php
}
}
?>
                            </select>
                            <div class="disp-err"><?php echo $_smarty_tpl->tpl_vars['state_textbox_err']->value;
echo $_smarty_tpl->tpl_vars['state_select_err']->value;?>
</div>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> City : </td>
						<td><input type="text" name="city" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['city']->value;?>
" />
						<br /><span class="err" id="city_err"><?php echo $_smarty_tpl->tpl_vars['city_err']->value;?>
</span>
						</td>
					</tr>					
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Zip/Postal Code : </td>
						<td><input type="text" name="zipcode" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['zipcode']->value;?>
">
						<br /><span class="err" id="zipcode_err"><?php echo $_smarty_tpl->tpl_vars['zipcode_err']->value;?>
</span>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Day Phone : </td>
						<td><input type="text" name="contact_no" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['contact_no']->value;?>
"> 
						<br /><span class="err" id="contact_no_err"><?php echo $_smarty_tpl->tpl_vars['contact_no_err']->value;?>
</span></td>
					</tr>
					<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Shipping Address</b></td>
					</tr>
					<tr class="tr_bgcolor">
                        <td><input type="checkbox" name="sameasbilling" value="checkbox" onClick="shipsame(this.form);">&nbsp;Same as billing</td>
                        <td>&nbsp;</td>
                    </tr>                    	
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Firstname : </td>
						<td><input type="text" name="shipping_firstname" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['shipping_firstname']->value;?>
"> 
						<br /><span class="err" id="shipping_firstname_err"><?php echo $_smarty_tpl->tpl_vars['shipping_firstname_err']->value;?>
</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Lastname : </td>
						<td><input type="text" name="shipping_lastname" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['shipping_lastname']->value;?>
" />
						<br /><span class="err" id="shipping_lastname_err"><?php echo $_smarty_tpl->tpl_vars['shipping_lastname_err']->value;?>
</span>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Address1: </td>
						<td><input type="text" name="shipping_address1" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['shipping_address1']->value;?>
">
						<br /><span class="err" id="shipping_address1_err"><?php echo $_smarty_tpl->tpl_vars['shipping_address1_err']->value;?>
</span>
						</td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"> Shipping Address2: </td>
						<td><input type="text" name="shipping_address2" value="<?php echo $_smarty_tpl->tpl_vars['shipping_address2']->value;?>
" size="30" class="look">
						<br /><span class="err" id="shipping_address2_err"><?php echo $_smarty_tpl->tpl_vars['shipping_address2_err']->value;?>
</span>
						</td>
					</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping Country: </td>
						<td>
                            <select name="shipping_country_id" id="shipping_country_id" onchange="stateOptions($('#shipping_country_id').val(), 'shipping_state_textbox', 'shipping_state_select');" class="look">
                                <option value="" selected="selected">Select</option>
                                <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['countryID']->value,'output'=>$_smarty_tpl->tpl_vars['countryName']->value,'selected'=>$_smarty_tpl->tpl_vars['shipping_country_id']->value),$_smarty_tpl);?>

                            </select>
                            <br /><span id="shipping_country_id_err" class="err"><?php echo $_smarty_tpl->tpl_vars['shipping_country_id_err']->value;?>
</span>
                        </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping State: </td>
						<td>
                                                        <input type="text" name="shipping_state_textbox" id="shipping_state_textbox" <?php if ($_smarty_tpl->tpl_vars['shipping_country_id']->value != 230) {?> value="<?php echo $_smarty_tpl->tpl_vars['shipping_state']->value;?>
" <?php }?> <?php if ($_smarty_tpl->tpl_vars['shipping_country_id']->value == 230) {?> style="display:none;" <?php }?> class="look" />
                            <select name="shipping_state_select" id="shipping_state_select" <?php if ($_smarty_tpl->tpl_vars['shipping_country_id']->value != 230) {?> style="display:none;" <?php }?> class="look">
                                                                <?php
$__section_counter_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['us_states']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_counter_1_total = $__section_counter_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_counter'] = new Smarty_Variable(array());
if ($__section_counter_1_total !== 0) {
for ($__section_counter_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] = 0; $__section_counter_1_iteration <= $__section_counter_1_total; $__section_counter_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']++){
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['us_states']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['us_states']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['abbreviation'] == $_smarty_tpl->tpl_vars['shipping_state']->value) {?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['us_states']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_counter']->value['index'] : null)]['name'];?>
</option>
                                <?php
}
}
?>
                            </select>
                            <div class="disp-err"><?php echo $_smarty_tpl->tpl_vars['shipping_state_textbox_err']->value;
echo $_smarty_tpl->tpl_vars['shipping_state_select_err']->value;?>
</div>
						</td>
					</tr>
                    <tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Shipping City: </td>
						<td><input type="text" name="shipping_city" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['shipping_city']->value;?>
">
						<br /><span class="err" id="shipping_city_err"><?php echo $_smarty_tpl->tpl_vars['shipping_city_err']->value;?>
</span>
						</td>
					</tr>				
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span>Shipping Zipcode: </td>
						<td><input type="text" name="shipping_zipcode" size="30" class="look" value="<?php echo $_smarty_tpl->tpl_vars['shipping_zipcode']->value;?>
">
						<br /><span class="err" id="shipping_zipcode_err"><?php echo $_smarty_tpl->tpl_vars['shipping_zipcode_err']->value;?>
</span>
						</td>
					</tr>
                    <tr class="tr_bgcolor">
						<td valign="top">Newsletter Subscription </td>
						<td><input type="checkbox" name="nl_subscr" class="" value="1" <?php if ($_smarty_tpl->tpl_vars['nl_subscr']->value == 1) {?> checked='checked' <?php }?> ><br /><span class="err" id="nl_subscr_err"><?php echo $_smarty_tpl->tpl_vars['nl_subscr_err']->value;?>
</span></td>
					</tr>	 
					<!--<tr class="header_bgcolor" height="26">
						<td colspan="2" class="headertext"><b>&nbsp;Credit Card Details</b></td>
					</tr>
					<tr class="tr_bgcolor">
                        <td><input type="checkbox" name="update_cc" value="1" onClick="if(this.checked) $('#credit_card_no').val(''); else $('#credit_card_no').val('XXXXXXXXXX'+<?php echo $_smarty_tpl->tpl_vars['card']->value[0]['last_digit'];?>
);" <?php if ($_smarty_tpl->tpl_vars['update_cc']->value == 1) {?> checked="checked" <?php }?>>&nbsp;Update Credit Card Info</td>
                        <td>&nbsp;</td>
                    </tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Card Type: </td>
						<td>
                        	<select name="card_type" id="card_type" class="look required">
                                <option value="" selected="selected">Select</option>
                                <option value="American Express" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "American Express") {?> selected="selected" <?php }?>>American Express</option>
                                <option value="Diners Club Carte Blanche" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Diners Club Carte Blanche") {?> selected="selected" <?php }?>>Diners Club Carte Blanche</option>
                                <option value="Diners Club" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Diners Club") {?> selected="selected" <?php }?>>Diners Club</option>
                                <option value="Discover" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Discover") {?> selected="selected" <?php }?>>Discover</option>
                                <option value="Diners Club Enroute" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Diners Club Enroute") {?> selected="selected" <?php }?>>Diners Club Enroute</option>
                                <option value="JCB" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "JCB") {?> selected="selected" <?php }?>>JCB</option>
                                <option value="Maestro" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Maestro") {?> selected="selected" <?php }?>>Maestro</option>
                                <option value="MasterCard" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "MasterCard") {?> selected="selected" <?php }?>>MasterCard</option>
                                <option value="Solo" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Solo") {?> selected="selected" <?php }?>>Solo</option>
                                <option value="Switch" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Switch") {?> selected="selected" <?php }?>>Switch</option>
                                <option value="Visa" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Visa") {?> selected="selected" <?php }?>>Visa</option>
                                <option value="Visa Electron" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "Visa Electron") {?> selected="selected" <?php }?>>Visa Electron</option>
                                <option value="LaserCard" <?php if ($_smarty_tpl->tpl_vars['card']->value[0]['card_type'] == "LaserCard") {?> selected="selected" <?php }?>>LaserCard</option>
                            </select>
                            <br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['card_type_err']->value;?>
</span>
                        </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Card Number: </td>
						<td>
                            
                           <input type="text" name="credit_card_no" id="credit_card_no" value="<?php if ($_smarty_tpl->tpl_vars['update_cc']->value == 1) {
echo $_smarty_tpl->tpl_vars['credit_card_no']->value;
} else { ?>XXXXXXXXXX<?php echo $_smarty_tpl->tpl_vars['card']->value[0]['last_digit'];
}?>" class="look" /><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['credit_card_no_err']->value;?>
</span>
                                                   </td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Security Code: </td>
						<td><input type="password" name="security_code" id="security_code" value="" class="look" /><br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['security_code_err']->value;?>
</span></td>
					</tr>
					<tr class="tr_bgcolor">
						<td valign="top"><span class="err">*</span> Expiry Date: </td>
						<td>
                            <select name="expired_mnth" id="expired_mnth" class="look" style="width:50px;">
                                <?php
$_smarty_tpl->tpl_vars['__smarty_section_mnth'] = new Smarty_Variable(array());
if (true) {
for ($__section_mnth_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index'] = 1; $__section_mnth_2_iteration <= 12; $__section_mnth_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index']++){
?>
                                <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index'] : null);?>
" <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index'] : null) == $_smarty_tpl->tpl_vars['expiry_month']->value) {?> selected="selected" <?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_mnth']->value['index'] : null);?>
</option>
                                <?php
}
}
?>
                            </select>                         
                            <select name="expired_yr" id="expired_yr" class="look" style="width:60px;">
                                <?php
$_smarty_tpl->tpl_vars['__smarty_section_year'] = new Smarty_Variable(array());
if (true) {
for ($__section_year_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_year']->value['index'] = 2005; $__section_year_3_iteration <= 16; $__section_year_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_year']->value['index']++){
?>
                                <option value="<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_year']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_year']->value['index'] : null);?>
" <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_year']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_year']->value['index'] : null) == $_smarty_tpl->tpl_vars['expiry_year']->value) {?> selected="selected" <?php }?>><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_year']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_year']->value['index'] : null);?>
</option>
                                <?php
}
}
?>
                            </select>
                            <br /><span class="err"><?php echo $_smarty_tpl->tpl_vars['expired_mnth_err']->value;
echo $_smarty_tpl->tpl_vars['expired_mnth_err']->value;?>
</span>
                         </td>
					</tr>	-->		  				  
					<tr class="tr_bgcolor">
						<td align="center" colspan="2" class="bold_text" valign="top">
						<input type="submit" value="Save" class="button">
						&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" value="Cancel" class="button" onclick="javascript: location.href='<?php echo $_smarty_tpl->tpl_vars['decoded_string']->value;?>
'; " />
						</td>
					</tr>
  			  </table>
			</form>
		</td>
	</tr>		
</table>
<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
