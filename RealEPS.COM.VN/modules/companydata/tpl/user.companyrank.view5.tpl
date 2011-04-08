<!-- TONG QUAN -->
<table class="small finalcial" width="100%" style="color: #333333" id="finalcial_quymo">
	<thead style="text-align: right;">
	<tr>
		<th align="center">Mã<br/>CK</th>
		<th>Năm TC<br/>gần nhất</th>
		<th>Quý<br/>gần nhất</th>
		<th>Tăng trưởng<br/>EPS pha loãng<br/>(MRQ)</th>
		<th>Tăng trưởng<br/>EPS pha loãng<br/>(TTM)</th>
		<th>Tăng trưởng<br/>EPS pha loãng<br/>(LFY)</th>
		<th>Tăng trưởng<br/>doanh thu<br/>(MRQ)</th>
		<th>Tăng trưởng<br/>doanh thu<br/>(TTM)</th>
		<th>Tăng trưởng<br/>doanh thu<br/>(LFY)</th>
		<th>Tăng trưởng<br/>lợi nhuận<br/>(MRQ)</th>
		<th>Tăng trưởng<br/>lợi nhuận<br/>(TTM)</th>
		<th>Tăng trưởng<br/>lợi nhuận<br/>(LFY)</th>
	</tr>
	</thead>
	<tbody id="tbody_quymo">
	{foreach from=$data.company item=item name=loop}
	{if $smarty.foreach.loop.index % 2==0}
	<tr bgcolor="#F4F4F4">
	{else}
	<tr>
	{/if}
		<td align="center"><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink" >{$item.Symbol}</a></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
	</tr>
	{/foreach}
	</tbody>
	<tfoot>
	

	<tr>
		<td colspan="12" align="right">
			<b>MRQ</b>: Quý gần nhất   
			<b>MRQ2</b>: Quý gần nhì   
			<b>TTM</b>: 4 quý gần nhất   
			<b>LFY</b>: Năm tài chính gần nhất 
		</td>
	</tr>
	</tfoot>
</table>
<!-- /TONG QUAN -->