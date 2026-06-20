{include file="admin_header.tpl"}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="100%">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td align="center" valign="top" class="bold_text">Generate Sitemap</td>
                </tr>
                {if $message == 'success'}
                <tr>
                    <td align="center">
                        <div class="messageBox" style="color:green;">
                            sitemap.xml generated successfully — {$count} URLs written.
                        </div>
                    </td>
                </tr>
                {elseif $message == 'error'}
                <tr>
                    <td align="center">
                        <div class="messageBox" style="color:red;">
                            Failed to write sitemap.xml — check file permissions.
                        </div>
                    </td>
                </tr>
                {/if}
                <tr>
                    <td align="center" style="padding:20px;">
                        <p>Writes a fresh <strong>sitemap.xml</strong> to the web root from live database data.</p>
                        <p>Run this after every auction event, bulk listing import, or new blog post.</p>
                        <form method="post" action="">
                            <input type="submit" name="generate" value="Generate sitemap.xml" class="button" style="padding:8px 20px;font-size:14px;" />
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
{include file="admin_footer.tpl"}
