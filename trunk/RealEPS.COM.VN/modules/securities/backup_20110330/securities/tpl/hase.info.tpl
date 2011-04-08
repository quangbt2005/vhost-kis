<table cellpadding="0" cellspacing="0">
<tr>
    <td>
        <div class="other_news">
            <div class="left" style="font-size: 13px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px;">
            Thống kê sàn HASE ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}
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
        <param name='src' value='/images/FinalIndexChart.swf?tradingSym=HASE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl'/>                                                
        <param name='flashVars' value=''/>   
        <param name='wmode' value='transparent'/>                                                   
        <embed name='mySwf' wmode="transparent" src='/images/FinalIndexChart.swf?tradingSym=HASE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl'  pluginspage='http://www.adobe.com/go/getflashplayer' height='200px' width='360px' flashVars=''/>                                    
        </object>
    </div>  
    {if $data.total_market.VNIndexChanges > 0}
        {assign var='market_class' value='up'}
    {elseif $data.total_market.VNIndexChanges < 0}
        {assign var='market_class' value='down'}
    {else}
        {assign var='market_class' value='stand'}
    {/if}
    <div class="chart_info">
        <div>
            <div class="left">HASE-Index</div>
            <div class="right"><span id="MarketIndex1">{$data.total_market.MarketIndex|num_format}</span></div>
            <div class="clear"></div>
        </div>
        <div class="odd">
            <div class="left">Thay đổi</div>
            <div class="right {$market_class}" id="change_container1"><span id="CHGIndex1">{$data.total_market.CHGIndex|num_format}</span> (<span id="PCTIndex1">{$data.total_market.PCTIndex|num_format}</span>%)</div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="left">Số mã chứng khoán tăng giá</div>
            <div class="right up"><span id="Gainers1">{$data.total_market.Gainers}</span></div>
            <div class="clear"></div>
        </div>
        <div class="odd">
            <div class="left">Số mã chứng khoán đứng giá</div>
            <div class="right stand"><span id="Unchanged1">{$data.total_market.Unchanged}</span></div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="left">Số mã chứng khoán giảm giá</div>
            <div class="right down"><span id="Losers1">{$data.total_market.Losers}</span></div>
            <div class="clear"></div>
        </div>
        <div class="odd">
            <div class="left">Giá trị giao dịch</div>
            <div class="right"><span id="TotalValue1">{$data.total_market.TotalValue|num_format:0}</span></div>
            <div class="clear"></div>
        </div>
        <div>
            <div class="left">Khối lượng giao dịch</div>
            <div class="right"><span id="TotalQuantity1">{$data.total_market.TotalQuantity|num_format:0}</span></div>
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
            Sàn HASE</b>
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
        {foreach from=$data.top_gainers item="item" name="loop"}
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
            Sàn HASE</b>
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
        {foreach from=$data.top_losers item="item" name="loop"}
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
            Sàn HASE</b>
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
        {foreach from=$data.top_last_vol item="item" name="loop"}
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