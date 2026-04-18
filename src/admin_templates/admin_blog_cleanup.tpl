{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="100%">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td align="center">
                        <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php" class="action_link">&laquo; Back to Blog Manager</a>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <table align="center" width="70%" border="0" cellspacing="1" cellpadding="6" class="header_bordercolor">
                            <tr class="header_bgcolor" height="26">
                                <td colspan="3" class="headertext"><b>S3 Blog Image Cleanup</b></td>
                            </tr>
                            <tr class="tr_bgcolor">
                                <td class="smalltext">Total objects in S3 <code>blog-images/</code></td>
                                <td class="smalltext">{$s3_total}</td>
                            </tr>
                            <tr class="tr_bgcolor">
                                <td class="smalltext">Referenced in blog posts</td>
                                <td class="smalltext">{$db_referenced}</td>
                            </tr>
                            <tr class="tr_bgcolor">
                                <td class="smalltext"><b>Orphaned (not used anywhere)</b></td>
                                <td class="smalltext"><b>{$orphans|count}</b> &nbsp; ({$total_kb} KB)</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {if $confirm && $deleted}
                <tr>
                    <td align="center" style="padding-top:14px;">
                        <div style="background:#d4edda; border:1px solid #28a745; padding:10px 16px; display:inline-block; font-size:12px; color:#155724;">
                            Deleted {$deleted|count} file(s) from S3 successfully.
                        </div>
                    </td>
                </tr>
                {/if}

                {if $errors}
                <tr>
                    <td align="center" style="padding-top:8px;">
                        <div style="background:#f8d7da; border:1px solid #f5c6cb; padding:10px 16px; display:inline-block; font-size:12px; color:#721c24;">
                            {foreach from=$errors item=e}{$e}<br />{/foreach}
                        </div>
                    </td>
                </tr>
                {/if}

                {if $orphans && !$confirm}
                <tr>
                    <td align="center" style="padding-top:14px;">
                        <table align="center" width="70%" border="0" cellspacing="1" cellpadding="4" class="header_bordercolor">
                            <tr class="header_bgcolor">
                                <td class="headertext">Filename</td>
                                <td class="headertext">Size</td>
                                <td class="headertext">Uploaded</td>
                            </tr>
                            {foreach from=$orphans key=filename item=info}
                            <tr class="{cycle values="odd_tr,even_tr"}">
                                <td class="smalltext">{$filename}</td>
                                <td class="smalltext">{math equation="round(size/1024,1)" size=$info.size} KB</td>
                                <td class="smalltext">{$info.modified}</td>
                            </tr>
                            {/foreach}
                        </table>
                        <div style="margin-top:14px;">
                            <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=cleanup_images&confirm=1"
                               class="button"
                               style="background:#bd1a21; color:#fff; padding:8px 20px; text-decoration:none; font-weight:bold;"
                               onclick="return confirm('Delete {$orphans|count} orphaned image(s) from S3? This cannot be undone.');">
                                Delete {$orphans|count} Orphaned Image(s) from S3
                            </a>
                        </div>
                    </td>
                </tr>
                {elseif !$orphans}
                <tr>
                    <td align="center" style="padding-top:14px; color:green; font-weight:bold;">
                        S3 is clean &mdash; no orphaned images found.
                    </td>
                </tr>
                {/if}

            </table>
        </td>
    </tr>
</table>
{include file="admin_footer.tpl"}
