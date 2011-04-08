{include file="$_MODULE_ABSPATH/tpl/user.hose.companyinfo.tpl"}
<!-- CAC GIAO DICH -->
<div class="table_panel">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>
        	<a href="/thong-ke/hose/index.html?symbol={$data.symbol}&fromdate={$data.from_date|date_format:"%d/%m/%Y"}&todate={$data.to_date|date_format:"%d/%m/%Y"}#table_listing" class="panel_button_active left" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Khớp lệnh HOSE
        	</span></a>
        	<a href="/thong-ke/thoa-thuan/hose/index.html?symbol={$data.symbol}&fromdate={$data.from_date|date_format:"%d/%m/%Y"}&todate={$data.todate|date_format:"%d/%m/%Y"}#table_listing" class="panel_button left margin_left_20px" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Thỏa thuận
        	</span></a>
        	<!--<a href="#" class="panel_button left margin_left_20px" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD NĐT NN
        	</span></a>
        	<a href="#" class="panel_button left margin_left_20px" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>Giao dịch OTC
        	</span></a>
        	<a href="#" class="panel_button left margin_left_20px" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Trái phiếu
        	</span></a>-->
        	<span class="right" style="color: #666666;padding: 3px 10px 5px 2px;"><b>Ngày giao dịch : {$data.from_date|date_format:"%d/%m/%Y"} - {$data.to_date|date_format:"%d/%m/%Y"}</b></span>
        	<span class="clear"></span>  
      	</td></tr></table>
    </div>
    <div class="panel_content">
    	<div style="text-align: right;" class="margin_bottom_10px">(Đơn vị giá: 1000 Đồng - Đơn vị khối lượng: 10 cổ phiếu)</div>
		<table width="100%" border="1" class="table" bordercolor="#8f8f8f">
			<thead>
			<tr>
				<th rowspan="2" width="30">STT</th>
				<th rowspan="2" width="70">Ngày</th>
				<th rowspan="2" width="60">Giá<br/>đóng cửa</th>
				<th colspan="2">Thay đổi</th>
				<th rowspan="2" width="60">Giá<br/>mở cửa</th>
				<th rowspan="2" width="60">Giá<br/>cao nhất</th>
				<th rowspan="2" width="60">Giá<br/>thấp nhất</th>
				<th rowspan="2" width="70">Khối<br/>lượng</th>
				<th colspan="4">Nước ngoài</th>
			</tr>
			<tr>
				<th width="60">+/-</th>
				<th width="60">%</th>
				
				<th width="60">Mua</th>
				<th width="60">Bán</th>
				<th width="70">Mua - Bán</th>
				<th width="80">Room</th>
			</tr>
			</thead>
			<tbody>
			{if $data.hose_current_security}
			{foreach from=$data.hose_current_security item="item" name="loop"}
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
				<th>{$item.TradingDate|date_format:'%d/%m/%y'}</th>
				<th>{$item.PriorClosePrice|num_format}</th>
				<th class={$class}>
					{if $item.change != 0}
					{$item.change|num_format} {$icon}
					{/if}
				</th>
				<th>{$item.percentage_change|num_format}</th>
				<th>{$item.OpenPriceOS|num_format}</th>
				<th>{$item.Highest|num_format}</th>
				<th>{$item.Lowest|num_format}</th>
				<th>{$item.LastVol|num_format:0}</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>			
			</tr>	
			{/foreach}	
			{else}
			<th colspan="13">Không có dữ liệu</th>
			{/if}
			</tbody>
		</table>	
		<div style="text-align: right; margin-top: 10px;">(Đơn vị giá: 1000 Đồng - Đơn vị khối lượng: 10 cổ phiếu)</div>			      
    </div>    
    <div class="panel_bottom_left"></div>
    <div class="panel_bottom"></div>
    <div class="panel_bottom_right"></div>
    <div class="clear"></div>          
</div>   
<!-- /CAC GIAO DICH -->