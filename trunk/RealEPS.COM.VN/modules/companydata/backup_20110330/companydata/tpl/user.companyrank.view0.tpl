<!-- TONG QUAN -->
<table class="small finalcial" width="100%" style="color: #333333" id="finalcial_quymo">
	<thead style="text-align: right;">
	<tr>
		<th align="center">Mã<br/>CK</th>
		<th align="center">Tên</th>
		<th nowrap="nowrap">Năm TC<br/>gần nhất</th>
		<th nowrap="nowrap">Quý gần<br/>nhất</th>
		<th nowrap="nowrap">Giá gần<br/>nhất</th>
		<th nowrap="nowrap">Thay đổi<br/>trong ngày</th>
		<th nowrap="nowrap">Thị giá vốn</th>
		<th nowrap="nowrap">PE Pha loãng<br/>(TTM)</th>
		<th nowrap="nowrap">PE Pha loãng<br/>(LFY)</th>
	</tr>
	</thead>
	<tbody id="tbody_quymo">
	{foreach from=$data.company item=item name=loop}
	{if $smarty.foreach.loop.index % 2==0}
	<tr bgcolor="#F4F4F4">
	{else}
	<tr>
	{/if}
		<td align="center"><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink">{$item.Symbol}</a></td>
		<td align="left">{$item.CompanyName}</td>
		{if $item.LFY == 0}
		<td align="right">---</td>
		<td align="right">---</td>
		{else}
		<td align="right">{$item.LFY}</td>
		<td align="right">Q{$item.Quarter}/{$item.Year}</td>
		{/if}
	
		<td align="right"></td>
		<td align="right"></td>
		<td align="right">{$item.MarketCapitalization|num_format:2:' tỷ'}</td>
		<td align="right">{$item.DilutedPE_TTM|num_format:2:'x'}</td>
		<td align="right">{$item.DilutedPE_LFY|num_format:2:'x'}</td>
	</tr>
	{/foreach}
	</tbody>
	<tfoot>
	<tr>
		<td colspan="9" align="right">
			<b>MRQ</b>: Quý gần nhất   
			<b>MRQ2</b>: Quý gần nhì   
			<b>TTM</b>: 4 quý gần nhất   
			<b>LFY</b>: Năm tài chính gần nhất 
		</td>
	</tr>
	</tfoot>
</table>
<!-- /TONG QUAN -->