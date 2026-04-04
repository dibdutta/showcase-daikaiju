{include file="admin_header.tpl"}

{literal}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
function initBlogEditor() {
    if (typeof CKEDITOR === 'undefined') return;
    CKEDITOR.replace('content', {
        height: 450,
        filebrowserImageUploadUrl: '/admin/blog_image_upload.php',
        uploadUrl: '/admin/blog_image_upload.php',
        extraPlugins: 'uploadimage',
        imageUploadUrl: '/admin/blog_image_upload.php',
        toolbar: [
            { name: 'document',   items: ['Source'] },
            { name: 'clipboard',  items: ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'] },
            { name: 'editing',    items: ['Find','Replace','-','SelectAll'] },
            '/',
            { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'] },
            { name: 'paragraph',  items: ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
            { name: 'links',      items: ['Link','Unlink','Anchor'] },
            { name: 'insert',     items: ['Image','Table','HorizontalRule','SpecialChar'] },
            '/',
            { name: 'styles',     items: ['Styles','Format','Font','FontSize'] },
            { name: 'colors',     items: ['TextColor','BGColor'] }
        ]
    });
}
window.addEventListener('load', initBlogEditor);
</script>
{/literal}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="100%">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                {if $errorMessage != ""}
                    <tr>
                        <td width="100%" align="center"><div class="messageBox">{$errorMessage}</div></td>
                    </tr>
                {/if}
                <tr>
                    <td align="center">
                        <table align="center" width="96%" border="0" cellspacing="0" cellpadding="2">
                            <tr height="22">
                                <td align="center" class="bold_text">
                                    {if $blog_id}Edit Blog Post{else}Create New Blog Post{/if}
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <form method="post" action="" enctype="multipart/form-data" id="blogForm">
                                        <input type="hidden" name="mode" value="{$mode}">
                                        <input type="hidden" name="blog_id" value="{$blog_id}">
                                        <input type="hidden" name="encoded_string" value="{$encoded_string}">

                                        <table border="0" cellpadding="4" cellspacing="1" class="header_bordercolor" width="100%">
                                            <tr class="header_bgcolor" height="26">
                                                <td colspan="2" class="headertext"><b>{if $blog_id}Edit{else}New{/if} Blog / Article</b></td>
                                            </tr>

                                            <tr class="tr_bgcolor">
                                                <td width="18%" class="bold_text" valign="top"><span class="err">*</span> Title :</td>
                                                <td>
                                                    <input type="text" name="title" value="{$blog.title|escape}" class="look" style="width:98%;" />
                                                    {if $title_err != ""}<br /><span class="err">{$title_err}</span>{/if}
                                                </td>
                                            </tr>

                                            <tr class="tr_bgcolor">
                                                <td class="bold_text" valign="top">Status :</td>
                                                <td>
                                                    <select name="status" class="look">
                                                        <option value="1" {if $blog.status == 1}selected="selected"{/if}>Active</option>
                                                        <option value="0" {if $blog.status == 0}selected="selected"{/if}>Inactive</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr class="tr_bgcolor">
                                                <td class="bold_text" valign="top">Featured Image :</td>
                                                <td>
                                                    {if $blog.featured_image != ""}
                                                        <img src="http://{$smarty.server.HTTP_HOST}/blog_images/{$blog.featured_image}" style="max-height:80px; display:block; margin-bottom:6px; border:1px solid #ddd;" /><br />
                                                    {/if}
                                                    <input type="file" name="featured_image" class="look" accept="image/*" />
                                                    <br /><small>JPG, PNG, GIF or WebP. Leave blank to keep existing.</small>
                                                </td>
                                            </tr>

                                            <tr class="tr_bgcolor">
                                                <td class="bold_text" valign="top"><span class="err">*</span> Content :</td>
                                                <td>
                                                    <textarea name="content" id="content" style="width:100%; height:450px;">{$editor_content|escape}</textarea>
                                                </td>
                                            </tr>

                                            <tr class="tr_bgcolor">
                                                <td colspan="2" align="center">
                                                    <input type="submit" value="{if $blog_id}Update Post{else}Publish Post{/if}" class="button" />
                                                    &nbsp;&nbsp;
                                                    <input type="button" value="Cancel" class="button" onclick="location.href='{$smarty.const.ADMIN_PAGE_LINK}/admin_blog_manager.php';" />
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
{include file="admin_footer.tpl"}
