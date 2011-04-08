<!-- THONG KE CAC SAN -->
<div class="table_panel margin_bottom_10px_float"> 
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>
    		<a href="/thong-ke/hose/index.html" class="panel_button_active left" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>Sàn HOSE
        	</span></a>
        	<a href="/thong-ke/hase/index.html" class="panel_button left margin_left_20px" ><span>
        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>Sàn HASE
        	</span></a>
        	
        	<span class="clear"></span>    
    	</td></tr>
    	</table>          
    </div>              
    <div class="panel_content">
    	<table cellpadding="0" cellspacing="0">
    	<tr>
    		<td>
    			<div class="other_news">
					<div class="left" style="font-size: 13px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px;">
					Thống kê sàn HOSE ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}
					</div>
					<div class="clear"></div>
				</div>
    		</td>
    	</tr>
    	<tr><td>
		<!-- BIEU DO THONG KE -->
		<!-- BIEU DO -->
    	<div class="left" style="width:311px;">
	    	<div style="overflow: auto; height: 220px;">
	        	<object id='mySwf' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab' height='200px' width='360px'>
		        <param name='src' value='/images/FinalIndexChart.swf?tradingSym=HOSE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl'/>                								
		        <param name='flashVars' value=''/>   
		        <param name='wmode' value='transparent'/>                  									
		        <embed name='mySwf' wmode="transparent" src='/images/FinalIndexChart.swf?tradingSym=HOSE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl'  pluginspage='http://www.adobe.com/go/getflashplayer' height='200px' width='360px' flashVars=''/>									
				</object>
	        </div>  
	        {if $data.hose_total_market.VNIndexChanges > 0}
				{assign var='hose_market_class' value='up'}
			{elseif $data.hose_total_market.VNIndexChanges < 0}
				{assign var='hose_market_class' value='down'}
			{else}
				{assign var='hose_market_class' value='stand'}
			{/if}
			<div class="chart_info">
	        	<div>
                	<div class="left">HOSE-Index</div>
                    <div class="right"><span id="hose_VNIndex1">{$data.hose_total_market.VNIndex|num_format}</span></div>
                    <div class="clear"></div>
                </div>
                <div class="odd">
                	<div class="left">Thay đổi</div>
                	
                    <div class="right {$hose_market_class}" id="hose_change_container1"><span id="hose_VNIndexChanges1">{$data.hose_total_market.VNIndexChanges}</span> (<span id="hose_PercentChanges">{$data.hose_total_market.PercentChanges|num_format}</span>%)</div>
                    <div class="clear"></div>
                </div>
                <div>
                	<div class="left">Số mã chứng khoán tăng giá</div>
                    <div class="right up"><span id="hose_Gainers1">{$data.hose_total_market.Gainers|num_format:0}</span></div>
                    <div class="clear"></div>
                </div>
                <div class="odd">
                	<div class="left">Số mã chứng khoán đứng giá</div>
                    <div class="right stand"><span id="hose_Unchanged1">{$data.hose_total_market.Unchanged|num_format:0}</span></div>
                    <div class="clear"></div>
                </div>
                <div>
                	<div class="left">Số mã chứng khoán giảm giá</div>
                    <div class="right down"><span id="hose_Losers1">{$data.hose_total_market.Losers|num_format:0}</span></div>
                    <div class="clear"></div>
                </div>
                <div class="odd">
                	<div class="left">Giá trị giao dịch</div>
                    <div class="right"><span id="hose_TotalValues1">{$data.hose_total_market.TotalValues|num_format:0}</span></div>
                    <div class="clear"></div>
                </div>
                <div>
                	<div class="left">Khối lượng giao dịch</div>
                    <div class="right"><span id="hose_TotalShares1">{$data.hose_total_market.TotalShares|num_format:0}</span></div>
                    <div class="clear"></div>
                </div>
	        </div>	    
	    </div>  
	    <!-- /BIEU DO -->
	    <div class="left margin_left_10px">	   			   		
   			<div class="margin_bottom_10px">
   				<div class="left" style="padding-top: 5px">
	   				<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	   			</div>
	   			<div class="left">
		   			<b>CP tăng giá nhiều nhất<br/>
		   			Sàn HOSE</b>
		   			<div style="color: #0033ff; font-weight: bold;">Ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}</div>
	   			</div>
	   			<div class="clear"></div>
	   		</div>
   			<div>
   			<table border="1" class="table" bordercolor="#8f8f8f">
   				<col width="50"/>
   				<col width="45"/>
   				<col width="45"/>
   				<col width="45"/>
   				<thead>
   				<tr>
   					<th>Mã<br/>CK</th>
   					<th>Giá</th>
   					<th>Thay<br/>đổi</th>
   					<th>%<br/>Tăng</th>
   				</tr>
   				</thead>
   				<tbody>
   				{foreach from=$data.hose_top_gainers item="item" name="loop"}
   				{if $item.TopChange > 0}
   					{assign var='class' value='up'}
   				{elseif $item.TopChange < 0}
   					{assign var='class' value='down'}
   				{else}
   					{assign var='class' value='stand'}
   				{/if}
   				{if $smarty.foreach.loop.index % 2 == 0}
   				<tr>
   				{else}
   				<tr class="odd">
   				{/if}
   					<th>{$item.Symbol}</th>
   					<th class="{$class}">{$item.ClosePrice|num_format}</th>
   					<th class="{$class}">{$item.TopChange|num_format}</th>
   					<th class="{$class}">{$item.Ratio|num_format}</th>
   				</tr>
   				{/foreach}
   				</tbody>
   			</table>
   			</div>	   			   	
	    </div>
     	<div class="left margin_left_10px">
	   		<div class="margin_bottom_10px">
   				<div class="left" style="padding-top: 5px">
	   				<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	   			</div>
	   			<div class="left">
		   			<b>CP giảm giá nhiều nhất<br/>
		   			Sàn HOSE</b>
		   			<div style="color: #0033ff; font-weight: bold;">Ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}</div>
	   			</div>
	   			<div class="clear"></div>
	   		</div>
   			<div>
   			<table border="1" class="table" bordercolor="#8f8f8f">
   				<col width="50"/>
   				<col width="45"/>
   				<col width="45"/>
   				<col width="45"/>
   				<thead>
   				<tr>
   					<th>Mã<br/>CK</th>
   					<th>Giá</th>
   					<th>Thay<br/>đổi</th>
   					<th>%<br/>Giảm</th>
   				</tr>
   				</thead>
   				<tbody>
   				{foreach from=$data.hose_top_losers item="item" name="loop"}
   				{if $item.TopChange > 0}
   					{assign var='class' value='up'}
   				{elseif $item.TopChange < 0}
   					{assign var='class' value='down'}
   				{else}
   					{assign var='class' value='stand'}
   				{/if}
   				{if $smarty.foreach.loop.index % 2 == 0}
   				<tr>
   				{else}
   				<tr class="odd">
   				{/if}
   					<th>{$item.Symbol}</th>
   					<th class="{$class}">{$item.ClosePrice|num_format}</th>
   					<th class="{$class}">{$item.TopChange|num_format}</th>
   					<th class="{$class}">{$item.Ratio|num_format}</th>
   				</tr>
   				{/foreach}
   				</tbody>
   			</table>
   			</div>
	    </div>	
	    <div class="left margin_left_10px">
			<div class="margin_bottom_10px">
   				<div class="left" style="padding-top: 5px">
	   				<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	   			</div>
	   			<div class="left">
		   			<b>CP có KLGD nhiều nhất<br/>
		   			Sàn HOSE</b>
		   			<div style="color: #0033ff; font-weight: bold;">Ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}</div>
	   			</div>
	   			<div class="clear"></div>
	   		</div>
   			<div>
   			<table border="1" class="table" bordercolor="#8f8f8f">
   				<col width="50"/>
   				<col width="70"/>
   				<col width="45"/>
   				<col width="45"/>
   				<col width="45"/>
   				<thead>
   				<tr>
   					<th>Mã<br/>CK</th>
   					<th>LKGD</th>
   					<th>Giá</th>
   					<th>Thay<br/>đổi</th>
   					<th>%<br/>Tăng</th>
   				</tr>
   				</thead>
   				<tbody>
   				{foreach from=$data.hose_top_last_vol item="item" name="loop"}
   				{if $item.PriceChange > 0}
   					{assign var='class' value='up'}
   				{elseif $item.PriceChange < 0}
   					{assign var='class' value='down'}
   				{else}
   					{assign var='class' value='stand'}
   				{/if}
   				{if $smarty.foreach.loop.index % 2 == 0}
   				<tr>
   				{else}
   				<tr class="odd">
   				{/if}
   					<th>{$item.Symbol}</th>
   					<th class="{$class}">{$item.TotalBuyTradingQtty|num_format:0}</th>
   					<th class="{$class}">{$item.ClosePrice|num_format}</th>
   					<th class="{$class}">{$item.PriceChange|num_format}</th>
   					<th class="{$class}">{$item.Ratio|num_format}</th>
   				</tr>
   				{/foreach}
   				</tbody>
   			</table>
   			</div>	    	
	    </div>		    
	    <!-- /BIEU DO THONG KE -->
	    <div class="clear"></div> 
	    </td></tr></table>   		  
    </div>    
    <div class="panel_bottom_left"></div>
    <div class="panel_bottom"></div>
    <div class="panel_bottom_right"></div>
    <div class="clear"></div>    	         
</div>
<!-- /THONG KE CAC SAN -->  