{* Smarty *}

<table border="0" width="300">
    <tr>
        <th colspan="20" bgcolor="#d1d1d1">List of Users</th>
    </tr>
    {foreach from=$users item="user"}
        <tr bgcolor="{cycle values="#dedede,#eeeeee" advance=false}">
            <td>{$user.first_name|escape}</td>
            <td>{$user.last_name|escape}</td>        
            <td align="right">{$user.create_date|date_format:"%e %b, %Y %H:%M:%S"}</td>        
            <td colspan="2" bgcolor="{cycle values="#dedede,#eeeeee"}">{$user.modified_date|date_format:"%e %b, %Y %H:%M:%S"}</td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="2">No records</td>
        </tr>
    {/foreach}
</table>