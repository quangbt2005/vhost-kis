<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th></th>
        <th class="border_right">Mã<br/>CK</th>        
        <th class="border_right num">Giá<br/>gần nhất</th>
        <th class="border_right num">Khối<br/>lượng</th>
        <th class="border_right num">% Thay đổi<br/>trong ngày</th>
        <th class="border_right num">% Thay đổi<br/>7 ngày</th>
        <th class="border_right num">% Thay đổi<br/>30 ngày</th>
        <th class="border_right num">% Thay đổi<br/>3 tháng</th>
        <th class="border_right num">% Thay đổi<br/>6 tháng</th>
        <th class="border_right num">% Thay đổi<br/>1 năm</th>
        <th class="border_right num">% Thay đổi<br/>2 năm</th>
        <th class="border_right num">% Thay đổi<br/>3 năm</th>
        <th class="num">% Thay đổi<br/>5 năm</th>    
    </tr>
</thead>
<tbody>
    {foreach from=$data.symbols item=item name=loop}   
    {if $smarty.foreach.loop.index % 2 == 0}
    <tr bgcolor="#f0f0f0">
    {else}
    <tr>
    {/if}
        <th><a href="#" onclick="alert('Du lieu dang duoc cap nhap');" rel="nofollow"><img src="/images/filetype/pdf.gif" title="{option name="image_title"}"/></a></th>
        <td class="border_right"><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink" title="Chung khoan {$item.Symbol} - {$item.CompanyName}">{$item.Symbol}</a></td>            
		<td class="border_right num">---</td>
		<td class="border_right num">---</td>	
		<td class="border_right num">---</td>
		<td class="border_right num">---</td>
		<td class="border_right num">---</td>
		<td class="border_right num">---</td>
        <td class="border_right num">---</td>        
        <td class="border_right num">---</td>
        <td class="border_right num">---</td>
        <td class="border_right num">---</td>
		<td class="num">---</td>     
    </tr>   
    {/foreach}
</tbody>
</table>
<!-- /DINH GIA -->