{include file="$_MODULE_ABSPATH/tpl/user.hose.marketinfo.tpl"}
<a name="table_listing"></a>
<!-- CAC GIAO DICH -->
<div class="table_panel">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>
        	<a href="/thong-ke/hose/index.html#table_listing" class="panel_button left" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Khớp lệnh HOSE
        	</span></a>
        	<a href="/thong-ke/thoa-thuan/hose/index.html#table_listing" class="panel_button_active left margin_left_20px" ><span>
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
					<th>{$item.Price|num_format:0}</th>
					<th>{$item.Vol|num_format:0}</th>
					<th>{$item.TotalVal|num_format:0}</th>
				</tr>
				{/foreach}
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