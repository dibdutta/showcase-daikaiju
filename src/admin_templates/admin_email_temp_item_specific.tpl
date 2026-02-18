<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
</head>

<body style="margin:0; padding:0; background-color:#dad7d3;font-family:Arial, Helvetica, sans-serif;">
<table cellspacing="0" cellpadding="0" border="0" align="center" width="752" style="margin:12px auto;">
    <tbody>
        <tr>
            <td>
            <table cellspacing="0" cellpadding="0" border="0" width="752" style="background-color:#ffffff;">
                <tbody>
                    <tr>
                        <td colspan="5"><img height="22" width="752" src="https://d2m46dmzqzklm5.cloudfront.net/images/img_001.jpg" alt="" /></td>
                    </tr>
                    <tr>
                        <td width="136"><a href="{$smarty.const.SITE_URL}" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/img_002.jpg" width="136" height="60" /></a></td>
                        <td width="115">&nbsp;</td>
                        <td width="309" style="background-image:url(https://d2m46dmzqzklm5.cloudfront.net/images/img_003.jpg); background-repeat:repeat-x; padding-left:10px;"><a style="color:#881318; font-family:Arial, Helvetica, sans-serif; text-decoration:none; font-size:15px;" target="_blank" href="{$banner_link}">{$banner_text}
                        </a></td>
                        <td width="167"><a href="http://www.gavelsnipe.com/" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/img_004.jpg" width="167" height="60" /></a></td>
                        <td width="25">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td>
            <table cellspacing="0" cellpadding="0" border="0" width="752" style="background-color:#881318;">
                <tbody>
                    <tr>
                        <td style="padding-left:15px;">
                        <h4>&nbsp;<span style="color: rgb(255, 255, 255);"><strong>{$sub_banner_text}</strong></span></h4>
                        </td>
                        <td width="65"><img height="49" width="65" src="https://d2m46dmzqzklm5.cloudfront.net/images/img_005.jpg" alt="" /></td>
                        <td width="26"><a href="https://twitter.com/movieposterexch" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/img_006.jpg" width="26" height="49" /></a></td>
                        <td width="25"><a href="https://www.facebook.com/MoviePosterExchange" target="_blank"><img src="https://d2m46dmzqzklm5.cloudfront.net/images/img_007.jpg" width="25" height="49" /></a></td>
                        <td width="118"><img height="49" width="118" src="https://d2m46dmzqzklm5.cloudfront.net/images/img_008.jpg" alt="" /></td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td style="background-color:#efeeec;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td valign="top" style="background-color:#efeeec; padding:25px 25px 0 25px;">
                        <table cellspacing="1" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding:5px 0 5px 20px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:14px; color:#ebebea; vertical-align:top; background-color:#881318;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                    <table cellspacing="1" cellpadding="0" border="0" width="100%" style="margin-bottom:40px; background-color:#FFF;">
                                        <tbody>
                                            <tr>
                                                <td width="318" style="padding:20px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:13px; line-height:17px; vertical-align:top; text-align:justify;"><a href="{$smarty.const.SITE_URL}/buy.php?mode=poster_details&auction_id={$auction_id}" target="_blank"><img  width="318" alt="" src="{$image_path}" /></a></td>
                                                <td style="padding:20px 20px 0 0; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:13px; line-height:17px; vertical-align:top; text-align:justify;">
                                                <h2><span style="color: rgb(128, 0, 0);">{$poster_title}<br />
                                                </span></h2>
                                                <p>{$poster_desc}</p>
                                                <p>&nbsp;</p>
                                                <p>&nbsp;</p>
												
												{if $is_auction==1}
													<a href="{$smarty.const.SITE_URL}/buy.php?mode=poster_details&auction_id={$auction_id}" target="_blank"><img height="24" width="61" src="{$smarty.const.SITE_URL}/newsletter/img_011.jpg" alt="" /></a>
												{else}
													<a href="{$smarty.const.SITE_URL}/buy.php?mode=poster_details&auction_id={$auction_id}&fixed=1" target="_blank"><img height="24" width="61" src="{$smarty.const.SITE_URL}/newsletter/img_011.jpg" alt="" /></a>
												{/if}
												
                                               </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td style="background-color:#989693; background-image:url(https://d2m46dmzqzklm5.cloudfront.net/images/img_010.jpg); background-repeat:no-repeat; background-position:left bottom; text-align:center; color:#989693; padding:6px 0;"><a href="{$smarty.const.SITE_URL}/contactus.php" target="_blank" style="color:#989693; font-family:Arial, Helvetica, sans-serif; text-decoration:none; border-bottom:1px dashed #989693; font-size:12px;">Contact Customer Service</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{$smarty.const.SITE_URL}/user_agreement.php" target="_blank" style="color:#989693; font-family:Arial, Helvetica, sans-serif; text-decoration:none; border-bottom:1px dashed #989693; font-size:12px;">View our User Agreement</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{$smarty.const.SITE_URL}/faq.php" target="_blank" style="color:#989693; font-family:Arial, Helvetica, sans-serif; text-decoration:none; border-bottom:1px dashed #989693; font-size:12px;">FAQ</a></td>
        </tr>
    </tbody>
</table>

</body>
</html>
