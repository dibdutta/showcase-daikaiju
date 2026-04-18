{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="100%">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td align="center">
                        <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=create" class="action_link"><strong>+ Create New Blog Post</strong></a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=comments" class="action_link">
                            Manage All Comments {if $pendingComments > 0}<span class="err">({$pendingComments} pending)</span>{/if}
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=cleanup_images" class="action_link" style="color:#856404;">&#128465; Cleanup S3 Images</a>
                    </td>
                </tr>
                {if $errorMessage != ""}
                    <tr>
                        <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
                    </tr>
                {/if}
                {if $total > 0}
                <tr>
                    <td align="center">
                        <table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
                            <tbody>
                                <tr class="header_bgcolor" height="26">
                                    <td align="center" class="headertext">Title</td>
                                    <td align="center" class="headertext">Slug</td>
                                    <td align="center" class="headertext">Status</td>
                                    <td align="center" class="headertext">Date</td>
                                    <td align="center" class="headertext" width="20%">Action</td>
                                </tr>
                                {foreach from=$blogs item=b}
                                <tr class="{cycle values="odd_tr,even_tr"}">
                                    <td align="left" class="smalltext">&nbsp;{$b.title}</td>
                                    <td align="left" class="smalltext">&nbsp;{$b.slug}</td>
                                    <td align="center" class="smalltext">
                                        {if $b.status == 1}<span style="color:green;">Active</span>{else}<span class="err">Inactive</span>{/if}
                                    </td>
                                    <td align="center" class="smalltext">{$b.post_date|date_format:"%d %b %Y"}</td>
                                    <td align="center" class="bold_text">
                                        <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=edit&blog_id={$b.blog_id}&encoded_string={$encoded_string}" class="view_link">
                                            <img src="{$smarty.const.CLOUD_STATIC_ADMIN}icon_edit.gif" align="absmiddle" alt="Edit" title="Edit" border="0" />
                                        </a>
                                        &nbsp;
                                        <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=comments&blog_id={$b.blog_id}" class="view_link" title="View Comments">Comments</a>
                                        &nbsp;
                                        <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=delete&blog_id={$b.blog_id}', 'blog post'); return false;">
                                            <img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete" title="Delete" border="0" />
                                        </a>
                                    </td>
                                </tr>
                                {/foreach}
                                <tr class="header_bgcolor" height="26">
                                    <td class="headertext" colspan="4">{$pageCounterTXT}</td>
                                    <td align="right" class="headertext">{$displayCounterTXT}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                {else}
                <tr>
                    <td align="center" class="err">No blog posts found. <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=create" class="view_link">Create the first one.</a></td>
                </tr>
                {/if}
            </table>
        </td>
    </tr>
</table>
{include file="admin_footer.tpl"}
