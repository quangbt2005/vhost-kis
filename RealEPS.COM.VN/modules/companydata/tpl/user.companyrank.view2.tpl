<!-- TONG QUAN -->
<table class="small finalcial" width="100%" style="color: #333333" id="finalcial_quymo">
	<thead style="text-align: right;">
	<tr>
		<th align="center">Mã<br/>CK</th>
		<th nowrap="nowrap">Năm TC<br/>gần nhất</th>
		<th nowrap="nowrap">Giá gần<br/>nhất</th>
		<th nowrap="nowrap">Khối<br/>lượng</th>
		<th nowrap="nowrap">% Thay đổi<br/>trong ngày</th>
		<th nowrap="nowrap">% Thay đổi<br/>7 ngày</th>
		<th nowrap="nowrap">% Thay đổi<br/>30 ngày</th>
		<th nowrap="nowrap">% Thay đổi<br/>3 tháng</th>
		<th nowrap="nowrap">% Thay đổi<br/>6 tháng</th>
		<th nowrap="nowrap">% Thay đổi<br/>1 năm</th>
		<th nowrap="nowrap">% Thay đổi<br/>2 tháng</th>
		<th nowrap="nowrap">% Thay đổi<br/>3 tháng</th>
		<th nowrap="nowrap">% Thay đổi<br/>5 tháng</th>
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
	</tr>
	{/foreach}
	</tbody>
	<tfoot>
	<tr>
		<td colspan="13" align="right">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="13" align="right">
			<b>MRQ</b>: Quý gần nhất   
			<b>MRQ2</b>: Quý gần nhì   
			<b>TTM</b>: 4 quý gần nhất   
			<b>LFY</b>: Năm tài chính gần nhất 
		</td>
	</tr>
	</tfoot>
</table>
<!-- /TONG QUAN -->