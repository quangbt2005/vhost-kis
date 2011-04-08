{include file="$_MODULE_ABSPATH/tpl/user.hose.companyinfo.tpl"}
<a name="table_listing"></a>
<!-- CAC GIAO DICH -->
<div class="table_panel">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>
        	<a href="/thong-ke/hose/index.html?symbol={$data.symbol}&fromdate={$data.from_date|date_format:"%d/%m/%Y"}&todate={$data.to_date|date_format:"%d/%m/%Y"}#table_listing" class="panel_button left" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Khớp lệnh HOSE
        	</span></a>
        	<a href="/thong-ke/thoa-thuan/hose/index.html?symbol={$data.symbol}&fromdate={$data.from_date|date_format:"%d/%m/%Y"}&todate={$data.todate|date_format:"%d/%m/%Y"}#table_listing" class="panel_button_active left margin_left_20px" ><span>
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
        	<span class="right" style="color: #666666;padding: 3px 10px 5px 2px;"><b>Ngày giao dịch: {$data.from_date|date_format:"%d/%m/%Y"} - {$data.to_date|date_format:"%d/%m/%Y"}</b></span>
        	<span class="clear"></span>  
      	</td></tr></table>
    </div>
    <div class="panel_content">
			<div class="margin_bottom_10px">
				<div class="left box">
					Tổng Khối Lượng GD : {$data.put_through_qty|num_format:0}
				</div>
				<div class="left box margin_left_20px">
					Tổng Giá Trị GD : {$data.put_through_val|num_format:0}
				</div>
				<div class="clear"></div>
			</div>
			<div>
				<div class="margin_bottom_10px">
				<img class="icon_panel1" style="margin-right: 5px;" src="/images/transparent.png"/>
				<b>Thống kê giao dịch thỏa thuận</b></div>
				<table border="1" class="table" bordercolor="#8f8f8f">
				<thead>
					<tr>
						<th width="40">STT</th>
						<th width="100">Ngày</th>
						<th width="100">Giá</th>
						<th width="100">Khối lượng</th>
						<th width="100">Giá trị giao dịch</th>
					</tr>
				</thead>
				<tbody>
				{if $data.put_through}
				{foreach from=$data.put_through item="item" name="loop"}
				{if $smarty.foreach.loop.index % 2 == 0}
				<tr>
				{else}
				<tr style="background-color: #EBEBEB">
				{/if}
					<th>{$smarty.foreach.loop.index+1}</th>
					<th>{$item.TradingDate|date_format:"%d/%m/%Y"}</th>
					<th>{$item.Price|num_format:0}</th>
					<th>{$item.Vol|num_format:0}</th>
					<th>{$item.Value|num_format:0}</th>
				</tr>
				{/foreach}
				{else}
				<th colspan="5">Không có dữ liệu</th>
				{/if}
				</tbody>
				</table>
			</div>		      
    </div>    
    <div class="panel_bottom_left"></div>
    <div class="panel_bottom"></div>
    <div class="panel_bottom_right"></div>
    <div class="clear"></div>          
</div>   
<!-- /CAC GIAO DICH -->