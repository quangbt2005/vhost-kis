<div class="other_news">
    <div class="left" style="font-size: 13px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px;">
    Giao dịch khớp lệnh ({$data.maxtradingdate|date_format:"%d/%m/%Y"})
    </div>
    <div class="clear"></div>
</div>
{if $data.hase_current_security}
<table width="100%" border="1" class="table" bordercolor="#8f8f8f">
	<thead>
	<tr>
		<th rowspan="2" width="30">STT</th>
		<th rowspan="2" width="40">Mã CK</th>
		<th rowspan="2" width="40">Giá<br/>Tham<br/>Chiếu</th>
		<!--<th colspan="2">Đợt 1</th>
		<th colspan="2">Đợt 2</th>
		<th colspan="2">Đợt 3</th>-->
		<th rowspan="2" width="60">Thay đổi</th>
		<th rowspan="2" width="40">%</th>
		<th colspan="2">Khớp</th>
		<!--<th rowspan="2" width="60">Tỷ lệ (%)</th>
		--><th colspan="2">Dư khớp</th>
	</tr>
	<tr>
		<!-- PHIEN 1 -->
		<!--<th width="40">Giá</th>
		<th width="60">KL</th>
		--><!-- /PHIEN 1 -->
		
		<!-- PHIEN 2 -->
		<!--<th width="40">Giá</th>
		<th width="60">KL</th>
		--><!-- /PHIEN 2 -->
		<!-- PHIEN 3 -->
		<!--<th width="40">Giá</th>
		<th width="60">KL</th>
		--><!-- /PHIEN 3 -->
		<!-- KHOP -->
		<th width="60">Giá</th>
		<th width="70">KL</th>
		<!-- /KHOP -->
		<!-- DU KHOP -->
		<th width="60">Mua</th>
		<th width="60">Bán</th>
		<!-- /DU KHOP -->
	</tr>
	</thead>
	<tbody>
	{foreach from=$data.hase_current_security item="item" name="loop"}
	{if $item.change > 0}
		{assign var='class' value='up'}
		{assign var='icon' value='▲'}
	{elseif $item.change < 0}
		{assign var='class' value='down'}
		{assign var='icon' value='▼'}
	{else}
		{assign var='class' value='stand'}
		{assign var='icon' value='■'}
	{/if}
	{if $smarty.foreach.loop.index % 2 == 0}
	<tr>
	{else}
	<tr style="background-color: #EBEBEB">
	{/if}
		<th>{$smarty.foreach.loop.index+1}</th>
		<th>
			<table>
				<tr>
					<td width="50" class="{$class}">{$item.StockSymbol}</td>
					<td width="10" class="{$class}">{$icon}</td>
				</tr>
			</table>
		</th>
		<th>{$item.PriorClosePrice|num_format}</th>
		<!-- DOT 1 -->
		<!-- <th></th>
		<th></th> -->
		<!-- /DOT 1 -->
		<!-- DOT 2 -->
		<!-- <th></th>
		<th></th>  -->
		<!-- /DOT 2 -->
		<!--<th></th>
		<th></th>
		--><th>
			{if $item.change != 0}
			<table width="100%">
				<tr>
					<td width="10" class="{$class}">{$icon}</td>
					<td width="50" class="{$class}">{$item.change|num_format}</td>
				</tr>
			</table>
			{/if}
		</th>
		<th class="{$class}">{$item.percentage_change|num_format}</th>
		<th>{$item.last_price|num_format}</th>
		<th>{$item.last_volume|num_format:0}</th>
		<!--<th></th>
		--><th>{$item.unmatch_bid|num_format:0}</th>
		<th>{$item.unmatch_offer|num_format:0}</th>		
			
	</tr>	
	{/foreach}	
	</tbody>
</table>
<div style="text-align: right; margin-top: 10px;">(Đơn vị giá: 1000 Đồng - Đơn vị khối lượng: 10 cổ phiếu)</div>
{else}
<h3 style="text-align: center; font-weight: bold;">Không tìm thấy thông tin giao dịch</h3>
{/if}  