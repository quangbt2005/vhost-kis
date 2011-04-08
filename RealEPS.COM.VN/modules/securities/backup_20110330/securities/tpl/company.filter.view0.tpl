<div class="other_news">
    <div class="left" style="font-size: 13px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px;">
    Giao dịch khớp lệnh
    {if $data.from_date != $data.to_date}
    ({$data.from_date|date_format:"%d/%m/%Y"} - {$data.to_date|date_format:"%d/%m/%Y"})
    {else}
    ({$data.to_date|date_format:"%d/%m/%Y"})
    {/if}
    </div>
    <div class="clear"></div>
</div>
{if $data.current_security}
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
    {if $data.current_security}
    {foreach from=$data.current_security item="item" name="loop"}
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
{else}
<h3 style="text-align: center; font-weight: bold;">Không tìm thấy thông tin giao dịch</h3>
{/if}                  