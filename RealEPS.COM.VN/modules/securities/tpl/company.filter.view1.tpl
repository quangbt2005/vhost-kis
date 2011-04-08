<div class="other_news">
    <div class="left" style="font-size: 13px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px;">
    Giao dịch thỏa thuận
    {if $data.from_date != $data.to_date}
    ({$data.from_date|date_format:"%d/%m/%Y"} - {$data.to_date|date_format:"%d/%m/%Y"})
    {else}
    ({$data.to_date|date_format:"%d/%m/%Y"})
    {/if}
    </div>
    <div class="clear"></div>
</div>
{if $data.put_through}
<div class="margin_bottom_10px">
	<div class="left box">
		Tổng Khối Lượng GD : {$data.put_through_info.TotalVol|num_format:0}
	</div>
	<div class="left box margin_left_20px">
		Tổng Giá Trị GD : {$data.put_through_info.TotalValue|num_format:0}
	</div>
	<div class="clear"></div>
</div>
<div>
	<div class="margin_bottom_10px">
	<img class="icon_panel1" style="margin-right: 5px;" src="/images/transparent.png"/>
	<b>Thống kê giao dịch thỏa thuận</b></div>
	<table border="1" class="table" bordercolor="#8f8f8f" width="600">
	<thead>
		<tr>
			<th width="40">STT</th>
			<th width="60">Mã CK</th>
			<th width="100">Giá</th>
			<th width="100">Khối lượng</th>
			<th width="100">Giá trị giao dịch</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$data.put_through item="item" name="loop"}
	{if $smarty.foreach.loop.index % 2 == 0}
	<tr>
	{else}
	<tr style="background-color: #EBEBEB">
	{/if}
		<th>{$smarty.foreach.loop.index+1}</th>
		<th>{$item.Symbol}</th>
		<th align="right">{$item.Price|num_format:0}</th>
		<th align="right">{$item.Vol|num_format:0}</th>
		<th align="right">{$item.Value|num_format:0}</th>
	</tr>
	{/foreach}
	</tbody>
	</table>
</div>
{else}
<h3 style="text-align: center; font-weight: bold;">Không tìm thấy thông tin giao dịch</h3>	
{/if}