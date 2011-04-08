<div class="other_news">
    <div class="left" style="font-size: 13px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px;">
    Giao dịch nhà đầu tư nước ngoài
    {if $data.from_date != $data.to_date}
    ({$data.from_date|date_format:"%d/%m/%Y"} - {$data.to_date|date_format:"%d/%m/%Y"})
    {else}
    ({$data.to_date|date_format:"%d/%m/%Y"})
    {/if}
    </div>
    <div class="clear"></div>
</div>
{if $data.fi}
<table><tr>
<td valign="top" class="border_right" style="padding-right: 5px;">
<div class="margin_bottom_10px">
    <div class="left">
        <table border="1" class="table" bordercolor="#8f8f8f" width="300">
        <thead>
            <tr>
                <th colspan="3">Khối lượng khớp lệnh</th>
            </tr>
            <tr>
                <th>Tổng mua</th>
                <th>Tổng bán</th>
                <th>Tổng mua-bán</th>
            </tr>
        </thead>
        <tbody>
        
        <tr>
            <th>{$data.fi_sum.TotalBDeal|num_format:0}</th>
            <th>{$data.fi_sum.TotalSDeal|num_format:0}</th>
            <th>{$data.fi_sum.TotalDiffDealVol|num_format:0}</th>
        </tr>
        
        </tbody>
        </table>
    </div>
    <div class="left margin_left_10px">
        <table border="1" class="table" bordercolor="#8f8f8f" width="300">
        <thead>
            <tr>
                <th colspan="3">Khối lượng khớp lệnh</th>
            </tr>
            <tr>
                <th>Tổng mua</th>
                <th>Tổng bán</th>
                <th>Tổng mua-bán</th>
            </tr>
        </thead>
        <tbody>
        
        <tr>
            <th>{$data.fi_sum.TotalBDealValue|num_format:0}</th>
            <th>{$data.fi_sum.TotalSDealValue|num_format:0}</th>
            <th>{$data.fi_sum.TotalDiffDealValue|num_format:0}</th>
        </tr>
        
        </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>
<div>
    <div class="margin_bottom_10px">
    <img class="icon_panel1" style="margin-right: 5px;" src="/images/transparent.png"/>
    <b>Thống kê giao dịch nhà đầu tư nước ngoài</b></div>
    <table border="1" class="table" bordercolor="#8f8f8f" width="610">
    <thead>
        <tr>
            <th rowspan="2">STT</th>
            <th rowspan="2">Mã CK</th>
            <th colspan="3">KL khớp lệnh</th>
            <th colspan="3">GT khớp lệnh</th>
        </tr>
        <tr>
            <!-- KL khop lenh -->
            <th>Mua</th>
            <th>Bán</th>
            <th>Mua-Bán</th>
            <!-- /KL khop lenh -->
            
            <!-- GT khop lenh -->
            <th>Mua</th>
            <th>Bán</th>
            <th>Mua-Bán</th>
            <!-- /GT khop lenh -->
        </tr>
    </thead>
    <tbody>
    {section name=loop start=$data.fi_offset loop=$data.fi_total step=1}
    {assign var='item' value=`$data.fi[$smarty.section.loop.index]`}
    {if $smarty.section.loop.index % 2 == 0}
    <tr>
    {else}
    <tr style="background-color: #EBEBEB">
    {/if}
        <th>{$smarty.section.loop.index+1}</th>
        <th>{$item.StockSymbol}</th>
        <th align="right">{$item.BDealVol|num_format:0}</th>
        <th align="right">{$item.SDealVol|num_format:0}</th>
        <th align="right">{$item.DiffDealVol|num_format:0}</th>
        <th align="right">{$item.BDealVal|num_format:0}</th>
        <th align="right">{$item.SDealVal|num_format:0}</th>
        <th align="right">{$item.DiffDealVal|num_format:0}</th>
    </tr>
    {/section}
    </tbody>
    </table>
    <div>
    <div class="left"></div><div class="paging right" style="margin-top: 10px;">{$data.fi_paging}</div>
    </div>
</div>  
</td>
<td style="padding-left: 5px;" valign="top">
<!-- MUA -->
<div class="margin_bottom_10px">
<!-- 5 mua nhiều nhất theo KL -->
<div class="left">
    <div class="margin_bottom_10px">
        <div class="left" style="padding-top: 5px">
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        </div>
        <div class="left">
            <b>5 mua nhiều nhất theo KL</b>
            <div style="color: #0033ff; font-weight: bold;">Ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}</div>
        </div>
        <div class="clear"></div>
    </div>
    <div>
    <table border="1" class="table" bordercolor="#8f8f8f">
        <col width="50"/>
        <col width="100"//>
        <thead>
        <tr>
            <th>Mã CK</th>
            <th>Khối lượng</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$data.fi_top5bvol item=item name=loop}
        {if $smarty.foreach.loop.index % 2 == 0}
        <tr>
        {else}
        <tr style="background-color: #EBEBEB">
        {/if}
            <th>{$item.StockSymbol}</th>
            <td align="right">{$item.BDealVol}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    </div>
</div>  
<!-- /5 mua nhiều nhất theo KL -->
<!-- 5 mua nhiều nhất theo GT  -->
<div class="left margin_left_20px">
    <div class="margin_bottom_10px">
        <div class="left" style="padding-top: 5px">
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        </div>
        <div class="left">
            <b>5 mua nhiều nhất theo GT</b>
            <div style="color: #0033ff; font-weight: bold;">Ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}</div>
        </div>
        <div class="clear"></div>
    </div>
    <div>
    <table border="1" class="table" bordercolor="#8f8f8f">
        <col width="50"/>
        <col width="100"//>
        <thead>
        <tr>
            <th>Mã CK</th>
            <th>Khối lượng</th>
        </tr>
        </thead>
        
        <tbody>
        {foreach from=$data.fi_top5bval item=item name=loop}
        {if $smarty.foreach.loop.index % 2 == 0}
        <tr>
        {else}
        <tr style="background-color: #EBEBEB">
        {/if}
            <th>{$item.StockSymbol}</th>
            <td align="right">{$item.BDealVal}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    </div>
</div>  
<!-- /5 mua nhiều nhất theo GT  -->
<div class="clear"></div>
</div>
<!-- /MUA -->
<!-- BAN -->
<div>
<!-- 5 mua nhiều nhất theo KL -->
<div class="left">
    <div class="margin_bottom_10px">
        <div class="left" style="padding-top: 5px">
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        </div>
        <div class="left">
            <b>5 bán nhiều nhất theo KL</b>
            <div style="color: #0033ff; font-weight: bold;">Ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}</div>
        </div>
        <div class="clear"></div>
    </div>
    <div>
    <table border="1" class="table" bordercolor="#8f8f8f">
        <col width="50"/>
        <col width="100"//>
        <thead>
        <tr>
            <th>Mã CK</th>
            <th>Khối lượng</th>
        </tr>
        </thead>
        
        <tbody>
        {foreach from=$data.fi_top5svol item=item name=loop}
        {if $smarty.foreach.loop.index % 2 == 0}
        <tr>
        {else}
        <tr style="background-color: #EBEBEB">
        {/if}
            <th>{$item.StockSymbol}</th>
            <td align="right">{$item.SDealVol}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    </div>
</div>  
<!-- /5 mua nhiều nhất theo KL -->
<!-- 5 mua nhiều nhất theo GT  -->
<div class="left margin_left_20px">
    <div class="margin_bottom_10px">
        <div class="left" style="padding-top: 5px">
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        </div>
        <div class="left">
            <b>5 bán nhiều nhất theo GT</b>
            <div style="color: #0033ff; font-weight: bold;">Ngày {$data.maxtradingdate|date_format:"%d/%m/%Y"}</div>
        </div>
        <div class="clear"></div>
    </div>
    <div>
    <table border="1" class="table" bordercolor="#8f8f8f">
        <col width="50"/>
        <col width="100"//>
        <thead>
        <tr>
            <th>Mã CK</th>
            <th>Khối lượng</th>
        </tr>
        </thead>
        
        <tbody>
        {foreach from=$data.fi_top5sval item=item name=loop}
        {if $smarty.foreach.loop.index % 2 == 0}
        <tr>
        {else}
        <tr style="background-color: #EBEBEB">
        {/if}
            <th>{$item.StockSymbol}</th>
            <td align="right">{$item.SDealVal}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    </div>
</div>  
<!-- /5 mua nhiều nhất theo GT  -->
<div class="clear"></div>
</div>
<!-- /BAN -->
</td>
</tr>
</table>
{else}
<h3 style="text-align: center; font-weight: bold;">Không tìm thấy thông tin giao dịch</h3>
{/if}