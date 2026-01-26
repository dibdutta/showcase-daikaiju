<?php /* Smarty version 2.6.14, created on 2018-06-10 05:00:04
         compiled from admin_blacklist_template_hist.tpl */ ?>
<?php echo '
<style>
.printer{
font-family:Calibri;	
}

.forPrint-mainBorder{
border:1px solid #CCCCCC; font-size:12px; font-family:Arial, Helvetica, sans-serif;
padding:5px;
margin:0px;
} 

</style>
'; ?>

<table align="center" width="80%" class="forPrint-main" border="1"  bordercolor="#000000" cellpadding="0" cellspacing="0" style="border-collapse:collapse;<?php if ($this->_tpl_vars['invoiceData'][0]['is_paid'] == '1'): ?>background:url(<?php echo @CLOUD_STATIC; ?>
paid-img.png)<?php elseif ($this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '1'): ?>background:url(<?php echo @CLOUD_STATIC; ?>
cancelled-img.png)<?php elseif ($this->_tpl_vars['invoiceData'][0]['is_cancelled'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_paid'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_approved'] == '1' && $this->_tpl_vars['invoiceData'][0]['is_ordered'] == '0'): ?>background:url(<?php echo @CLOUD_STATIC; ?>
approved-img.png)<?php elseif ($this->_tpl_vars['invoiceData'][0]['is_paid'] == '0' && $this->_tpl_vars['invoiceData'][0]['is_ordered'] == '1'): ?> background:url(<?php echo @CLOUD_STATIC; ?>
payment-pending-img.png)<?php endif; ?> no-repeat center 75%; ">
                            	                               
                                <tr >
                                	<td align="left" colspan="2" >
                                    	<table border="1" width="100%" align="left" bordercolor="#000000" bordercolordark="#000000" bordercolorlight="#FFFFFF" cellpadding="2" style="border-collapse:collapse;" cellspacing="0" class="invoice-main">
                                        	<tr class="printer" bgcolor="silver">
                                            	<th align="left" width="20%" >Sl No</th>
                                                <th align="left" width="20$" >Domain Name</th>
                                                <th align="left" width="20%" >First Name</th>
                                                <th align="left" width="20%" >Last Name</th>
                                                <th align="left" width="20%" >Email Id</th>
                                            </tr>
                                            
                                            <?php unset($this->_sections['counter']);
$this->_sections['counter']['name'] = 'counter';
$this->_sections['counter']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                        	<tr class="printer" >
                                                <td align="left" ><?php echo $this->_tpl_vars['data'][$this->_sections['counter']['index']]['idtbl_blacklist']; ?>
</td>
                                                <td align="left" ><?php echo $this->_tpl_vars['data'][$this->_sections['counter']['index']]['domain']; ?>
</td>
                                                <td align="left" ><?php echo $this->_tpl_vars['data'][$this->_sections['counter']['index']]['firstname']; ?>
</td>
                                                <td align="left" ><?php echo $this->_tpl_vars['data'][$this->_sections['counter']['index']]['lastname']; ?>
</td>
                                                <td align="left" ><?php echo $this->_tpl_vars['data'][$this->_sections['counter']['index']]['email']; ?>
</td>
                                               
                                            </tr>
											<?php endfor; endif; ?>
                                            
                                        </table>
                                    </td>
                                </tr>
                                
                        </form>
                    </td>
                </tr>
               
			</table>