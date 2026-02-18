<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
</head>

<body style="margin:0; padding:0; background-color:#dad7d3;font-family:Arial, Helvetica, sans-serif;">
<table width="752" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:12px auto;">
  <tr>
    <td><table width="752" border="0" cellspacing="0" cellpadding="0" style="background-color:#ffffff;">
      <tr>
        <td colspan="5"><img src="{$smarty.const.SITE_URL}/newsletter/img_001.jpg" width="752" height="22" /></td>
        </tr>
      <tr>
        <td width="136"><a href="http://r20.rs6.net/tn.jsp?e=001QBvP9hNbylp9o_fYNyxtnhc9T7fR9ZviRVrO0Y2x1wRfWQhE7ndHFnyAlKNs7fn1isUEoniEB7MSXN_0-hqBboT5GF-1xQocG-dOYTY9sGB8qxp5ukm9zAF0FdFGG4eR" target="_blank"><img src="{$smarty.const.SITE_URL}/newsletter/img_002.jpg" width="136" height="60" /></a></td>
        <td width="115">&nbsp;</td>
        <td width="309" style="background-image:url({$smarty.const.SITE_URL}/newsletter/img_003.jpg); background-repeat:repeat-x; padding-left:10px;"><a href="{$smarty.const.SITE_URL}/buy.php?list=weekly" target="_blank" style="color:#881318; font-family:Arial, Helvetica, sans-serif; text-decoration:none; font-size:15px;">{$banner_text}</a></td>
        <td width="167"><a href="http://r20.rs6.net/tn.jsp?e=001QBvP9hNbylqxJZtUf7lynetm0mPwSO2Z_5Lh0f7vA06FLN_fpZISbwCy2SIRejD_FmqoYVov5fb5qIly4gCkqJE7pwWAI4foOcOmCKzfmfVp-5R4vjRw0g==" target="_blank"><img src="{$smarty.const.SITE_URL}/newsletter/img_004.jpg" width="167" height="60" /></a></td>
        <td width="25">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="752" border="0" cellspacing="0" cellpadding="0" style="background-color:#881318;">
      <tr>
        <td style="padding-left:15px;"><a href="{$smarty.const.SITE_URL}/buy.php?list=fixed" target="_blank" style="color:#ebebea; font-family:Arial, Helvetica, sans-serif; text-decoration:none; border-bottom:1px dashed #ff646b; font-size:15px;">{$fixed_text}</a></td>
        <td width="65"><img src="{$smarty.const.SITE_URL}/newsletter/img_005.jpg" width="65" height="49" /></td>
        <td width="26"><a href="http://r20.rs6.net/tn.jsp?e=001QBvP9hNbylpezT6kk3aAovLb6bJ5esclSbwPk1tJuYOpWpjXWS9L-eaxUXmTKCvgP4MGdWCNrCiq0GVCdR9ywtC-31CbjgFHEHQwPPOcceKIKiKgsA-00oQXYQiU1tdsOXkO-iPVLIQ=" target="_blank"><img src="{$smarty.const.SITE_URL}/newsletter/img_006.jpg" width="26" height="49" /></a></td>
        <td width="25"><a href="http://r20.rs6.net/tn.jsp?e=001QBvP9hNbylrH70OEn1ZDTQuEGutKaB81RsOX5viT2K0jsB4CDYq7xMx0fN8NJhzFUIZO2ptO2epNZY-JWrIc9YmamD-Gm5zIH8JKbsjlX5gb-PqWdr8GFiae39sh352T2zEAqaI_Q2XLhwC_xPsnC6YmvhSb16bNwqdQy_AD3e8=" target="_blank"><img src="{$smarty.const.SITE_URL}/newsletter/img_007.jpg" width="25" height="49" /></a></td>
        <td width="118"><img src="{$smarty.const.SITE_URL}/newsletter/img_008.jpg" width="118" height="49" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="background-color:#efeeec;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	{if $dataArr[0].is_auction=='1'}
      <tr>
        <td style="padding:25px 0 1px 8px; color:#131313; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:20px;">Bid Now</td>
        </tr>
	{/if}
      <tr>
        <td><img src="{$smarty.const.SITE_URL}/newsletter/img_009.jpg" width="752" height="2" /></td>
      </tr>
      <tr>
        <td valign="top" style="background-color:#efeeec; padding:16px 8px 8px 8px;">
       
        
		  {section name=counter loop=$dataArr}
		  <table width="134" border="0" cellspacing="1" cellpadding="0" style="margin:10px 10px 40px 0;float:left;height:320px;border: 1px solid #EFEEEC;">
          <tr>           
			<td style="padding-right:0px; vertical-align:bottom; width:134px; height:230px; display:inline-block; ">
            <div style="padding-right:0px; vertical-align:bottom; width:134px; height:230px; display:table-cell; ">
            <a href="{$smarty.const.SITE_URL}/buy.php?mode=poster_details&auction_id={$dataArr[counter].auction_id}" style="color:#2c2c2b;" target="_blank"><img src="{$dataArr[counter].image}" width="134"  style="border:2px solid #bd1a21;" /></a>
            </div>
            </td>
             </tr>
          <tr>
            <td style="padding:6px 4px 6px 0; font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:11px; vertical-align:top; height:45px;"><a href="{$smarty.const.SITE_URL}/buy.php?mode=poster_details&auction_id={$dataArr[counter].auction_id}" target="_blank" style="color:#2c2c2b;">{$dataArr[counter].poster_title}</a></td>
            </tr>
          <tr>
            <td style="text-align:left; vertical-align:top;"><a href="{$smarty.const.SITE_URL}/buy.php?mode=poster_details&auction_id={$dataArr[counter].auction_id}" style="color:#2c2c2b;" target="_blank"><img src="{$smarty.const.SITE_URL}/newsletter/img_011.jpg" width="61" height="24"  /></a></td>
            </tr>
			</table>           
		   {/section}	             
         
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="background-color:#989693; background-image:url({$smarty.const.SITE_URL}/newsletter/img_010.jpg); background-repeat:no-repeat; background-position:left bottom; text-align:center; color:#989693; padding:6px 0;"><a href="http://r20.rs6.net/tn.jsp?e=001QBvP9hNbylrQQAqBjtSRs2eyHUPLDKu62ACpDPvT_ojZy72Ki0gxG-hnMe_xGKQoSoGoDDEbjcOsgL_wPMknfcSIJCf7bnTy_YjrTD1fBlf2XQaU5dy_AjyUGdFWj5c4hhU3JkAeTiE=" target="_blank" style="color:#989693; font-family:Arial, Helvetica, sans-serif; text-decoration:none; border-bottom:1px dashed #989693; font-size:12px;">Contact Customer Service</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://r20.rs6.net/tn.jsp?e=001QBvP9hNbylpmZVl2hXgdR-SlqOKmroUU_CmvlMefUtXIk5KP22-ewcvsCLl261zebDSLx0kPzNZvA4-l27-ImeuRCYLYTbhtrV3QdAbDLsLDVbZdICz8qhFqTBs58N5j6K9znKRJwvyqIjdgT9y2YQ==" target="_blank" style="color:#989693; font-family:Arial, Helvetica, sans-serif; text-decoration:none; border-bottom:1px dashed #989693; font-size:12px;">View our User Agreement</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://r20.rs6.net/tn.jsp?e=001QBvP9hNbylqcyKgdCfbwSYEEPvSsfONd_fJxqynxiu_L7uwV1X-f6H7PT1pe3bimhPnNzo0mdEQr6RdWtUctgT3LqoeSLj5H5o5rMziQECIRiSU-iWaYcebgHkkhtZNIX7pD-_T3zzs=" target="_blank" style="color:#989693; font-family:Arial, Helvetica, sans-serif; text-decoration:none; border-bottom:1px dashed #989693; font-size:12px;">FAQ</a></td>
  </tr>
</table>

</body>
</html>
