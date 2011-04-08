{include file="$_MODULE_ABSPATH/tpl/user.hose.marketinfo.tpl"}
<a name="table_listing"></a>
<!-- CAC GIAO DICH -->
<div class="table_panel">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>
        	<a href="/thong-ke/hose/index.html#table_listing" class="panel_button_active left" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Khớp lệnh HOSE
        	</span></a>
        	<a href="/thong-ke/thoa-thuan/hose/index.html#table_listing" class="panel_button left margin_left_20px" ><span>
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
        	<span class="right" style="color: #666666;padding: 3px 10px 5px 2px;"><b>Ngày giao dịch {$data.maxtradingdate|date_format:"%d/%m/%Y"}</b></span>
        	<span class="clear"></span>  
      	</td></tr></table>
    </div>
    <div class="panel_content">
    	<div class="margin_bottom_10px" style="text-align: right;">(Đơn vị giá: 1000 Đồng - Đơn vị khối lượng: 10 cổ phiếu)</div>
		<table width="100%" border="1" class="table" bordercolor="#8f8f8f">
			<thead>
			<tr>
				<th rowspan="2" width="30">STT</th>
				<th rowspan="2" width="40">Mã CK</th>
				<th rowspan="2" width="40">Giá<br/>Tham<br/>Chiếu</th>
				<th colspan="2">Đợt 1</th>
				<th colspan="2">Đợt 2</th>
				<th colspan="2">Đợt 3</th>
				<th rowspan="2" width="60">Thay đổi</th>
				<th rowspan="2" width="40">%</th>
				<th colspan="2">Khớp</th>
				<th rowspan="2" width="60">Tỷ lệ (%)</th>
				<th colspan="2">Dư khớp</th>
			</tr>
			<tr>
				<!-- PHIEN 1 -->
				<th width="40">Giá</th>
				<th width="60">KL</th>
				<!-- /PHIEN 1 -->
				
				<!-- PHIEN 2 -->
				<th width="40">Giá</th>
				<th width="60">KL</th>
				<!-- /PHIEN 2 -->
				<!-- PHIEN 3 -->
				<th width="40">Giá</th>
				<th width="60">KL</th>
				<!-- /PHIEN 3 -->
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
				<th class="{$class}">
					{$item.StockSymbol} {$icon}						
				</th>
				<th>{$item.PriorClosePrice|num_format}</th>
				<th>{$item.session_one_price|num_format}</th>
				<th>{$item.session_one_vol|num_format:0}</th>
				<th>{$item.session_two_price|num_format}</th>
				<th>{$item.session_two_vol|num_format:0}</th>
				<th>{$item.session_two_price|num_format}</th>
				<th>{$item.session_three_vol|num_format:0}</th>
				<th>
					{if $item.change != 0} 
					<table>
						<tr>
							<td width="10" class="{$class}">{$icon}</td>
							<td width="50" class="{$class}">{$item.change|num_format}</td>
						</tr>
					</table>
					{/if}
				</th>
				<th class="{$class}">{$item.percentage_change|num_format}</th>
				<th>{$item.LastVol|num_format:0}</th>
				<th>{$item.LastVal|num_format:0}</th>
				<th>{$item.ratio|num_format}</th>
				<th>{$item.unmatch_bid|num_format:0}</th>
				<th>{$item.unmatch_offer|num_format:0}</th>		
					
			</tr>	
			{/foreach}	
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