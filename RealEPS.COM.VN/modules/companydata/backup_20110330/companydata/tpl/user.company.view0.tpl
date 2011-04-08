<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th></th>
        <th class="border_right">Mã<br/>CK</th>
        <th class="border_right">Tên</th>
        <th class="border_right num">Năm TC<br/>gầnnhất</th>
        <th class="border_right num">Quý gần<br/>nhất</th>
        <th class="border_right num">Giá gần<br/>nhất</th>
        <th class="border_right num">Thay đổi<br/>trong ngày</th>
        <th class="border_right num">Thị giá vốn</th>
        <th class="border_right num">P/E pha loãn<br/>(TTM)</th>
        <th class="num">P/E pha loãn<br/>(LFY)</th>    
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
        <td class="border_right"><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink" title="{option name="image_title"}">{$item.Symbol}</a></td>
        <td class="border_right" align="left">{$item.CompanyName}</td>
        {if $item.LFY == 0}
		<td class="border_right num">---</td>
		<td class="border_right num">---</td>
		{else}
		<td class="border_right num">{$item.LFY}</td>
		<td class="border_right num">Q{$item.Quarter}/{$item.Year}</td>
		{/if}
	
		<td class="border_right num"></td>
		<td class="border_right num"></td>
		<td class="border_right num">{$item.MarketCapitalization|num_format:2:' tỷ'}</td>
		<td class="border_right num">{$item.DilutedPE_TTM|num_format:2:'x'}</td>
		<td class="num">{$item.DilutedPE_LFY|num_format:2:'x'}</td>     
    </tr>   
    {/foreach}    
</tbody>
</table>
<!-- /DINH GIA -->