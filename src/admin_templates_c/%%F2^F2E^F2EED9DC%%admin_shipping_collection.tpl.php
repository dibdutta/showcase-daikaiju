<?php /* Smarty version 2.6.14, created on 2018-07-21 15:36:14
         compiled from admin_shipping_collection.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<td width="100%" align="center" class="err"><a href="javascript:void(0);" class="action_link"><strong>MPE Year wise Shipping Collection</strong></a></td>
				</tr>
				<?php if ($this->_tpl_vars['errorMessage'] <> ""): ?>
					<tr>
						<td width="100%" align="center"><div class="messageBox"><?php echo $this->_tpl_vars['errorMessage']; ?>
</div></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td width="100%" align="center">
						<table width="60%" border="0" cellspacing="0" cellpadding="2">
							<tr>
								<td align="center">
									
									<form action="" method="post" name="changeProfile" id="changeProfile">
										<input type="hidden" name="mode" value="shipping">
										<table border="0" cellpadding="2" cellspacing="1" class="header_bordercolor" width="100%">
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Select Year :</td>
												<td valign="top">
													<select name="year">
														<option value="2018">2018</option>
														<option value="2017">2017</option>
														<option value="2016">2016</option>
														
													</select>
												</td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Total Shipping :</td>
												<td valign="top">$<?php echo $this->_tpl_vars['totalShipping']; ?>
 Against Total Invoice: <?php echo $this->_tpl_vars['totalInvoice']; ?>
</td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> </td>
												<td valign="top"></td>
											</tr>
											
											<tr class="tr_bgcolor">
												<td align="left" class="bold_text" width="36%" valign="top"> Total Discounts :</td>
												<td valign="top"><?php echo $this->_tpl_vars['totalDiscounts']; ?>
</td>
											</tr>
																				
											
											<tr class="tr_bgcolor">
												<td align="center" class="bold_text" colspan=2><input type="submit" name="submit" class="button" value="Get Shipping" >&nbsp;&nbsp;&nbsp;&nbsp;												
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
		</td>
	</tr>		
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>