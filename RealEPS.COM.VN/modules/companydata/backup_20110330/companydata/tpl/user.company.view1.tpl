<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th></th>
        <th class="border_right">Mã<br/>CK</th>        
        <th class="border_right num">Giá<br/>gần nhất</th>
        <th class="border_right num">Giá đóng cửa<br/>trước</th>
        <th class="border_right num">Thay đổi<br/>trong ngày</th>
        <th class="border_right num">Giá cao nhất<br/>trong ngày</th>
        <th class="border_right num">Giá thấp nhất<br/>trong ngày</th>
        <th class="border_right num">Khối lượng</th>
        <th class="border_right num" nowrap="nowrap">Khối lượng<br/>TB(10 ngày)</th>
        <th class="border_right num">Cao nhất<br/>52 tuần</th>
        <th class="num">Thấp nhất<br/>52 tuần</th>    
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
        <td class="border_right num">{$item.AvgVolume10d|num_format}</td>
        <td class="border_right num">{$item.High52WkPrice|num_format}</td>
		<td class="num">{$item.Low52WkPrice|num_format}</td>     
    </tr>   
    {/foreach}
</tbody>
</table>
<!-- /DINH GIA -->