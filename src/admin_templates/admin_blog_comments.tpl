{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="100%">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td align="center">
                        <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php" class="view_link">&larr; Back to Blog List</a>
                        {if $blog_id}
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <strong>Comments for: {$post.title}</strong>
                        {else}
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <strong>All Comments</strong>
                        {/if}
                    </td>
                </tr>
                {if $smarty.session.adminErr != ""}
                    <tr>
                        <td width="100%" align="center"><div class="messageBox">{$smarty.session.adminErr}</div></td>
                    </tr>
                    {php} unset($_SESSION['adminErr']); {/php}
                {/if}
                <tr>
                    <td align="center">
                        <table align="center" width="96%" border="0" cellspacing="1" cellpadding="2" class="header_bordercolor">
                            <tbody>
                                <tr class="header_bgcolor" height="26">
                                    {if !$blog_id}<td class="headertext">Blog Post</td>{/if}
                                    <td class="headertext">Name</td>
                                    <td class="headertext">Email</td>
                                    <td class="headertext">Comment</td>
                                    <td class="headertext">Date</td>
                                    <td class="headertext">Status</td>
                                    <td class="headertext" width="15%">Action</td>
                                </tr>
                                {if $comments}
                                    {foreach from=$comments item=c}
                                    <tr class="{cycle values="odd_tr,even_tr"}">
                                        {if !$blog_id}<td class="smalltext">{$c.blog_title}</td>{/if}
                                        <td class="smalltext">{$c.commenter_name|escape}</td>
                                        <td class="smalltext">{$c.commenter_email|escape}</td>
                                        <td class="smalltext">{$c.comment_text|escape|nl2br}</td>
                                        <td class="smalltext">{$c.post_date|date_format:"%d %b %Y"}</td>
                                        <td class="smalltext">
                                            {if $c.status == 1}<span style="color:green;">Approved</span>{else}<span class="err">Pending</span>{/if}
                                        </td>
                                        <td align="center" class="bold_text">
                                            {if $c.status == 0}
                                                <a href="{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=approve_comment&comment_id={$c.comment_id}&blog_id={$blog_id}" class="view_link">Approve</a>
                                                &nbsp;|&nbsp;
                                            {/if}
                                            <a href="#" class="view_link" onclick="javascript: deleteConfirmRecord('{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php?mode=delete_comment&comment_id={$c.comment_id}&blog_id={$blog_id}', 'comment'); return false;">
                                                <img src="{$smarty.const.CLOUD_STATIC_ADMIN}delete_image.png" align="absmiddle" alt="Delete" title="Delete" border="0" />
                                            </a>
                                        </td>
                                    </tr>
                                    {/foreach}
                                {else}
                                    <tr>
                                        <td colspan="7" align="center" class="err">No comments found.</td>
                                    </tr>
                                {/if}
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
{include file="admin_footer.tpl"}
