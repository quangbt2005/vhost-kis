<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th></th>
        <th class="border_right">Mã<br/>CK</th>        
        <th class="border_right num">Giá<br/>gần nhất</th>
        <th class="border_right num">Thị giá vốn</th>
        <th class="border_right num">Vốn CSH (MRQ)</th>
        <th class="border_right num">Doanh thu (TTM)</th>
        <th class="border_right num">Lợi nhuận sau thuế (TTM)</th>
        <th class="border_right num">P/E pha loãng (TTM)</th>
        <th class="border_right num">ROE (TTM)</th>               
        <th class="num">ROA (TTM)</th>    
    </tr>
</thead>
<tbody>
    {foreach from=$data.symbols item=item name=loop}   
    {if $smarty.foreach.loop.index % 2 == 0}
    <tr bgcolor="#f0f0f0">
    {else}
    <tr>
    {/if}
        <th><a href="#" onclick="alert('Du lieu dang duoc cap nhap');" rel="nofollow"><img src="/images/filetype/pdf.gif" title="{option name="image_title"}"/></a></th>
        <td class="border_right"><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink" title="Chung khoan {$item.Symbol} - {$item.CompanyName}">{$item.Symbol}</a></td>            
		<td class="border_right num"></td>
		<td class="border_right num">{$item.MarketCapitalization|num_format:2:'tỷ'}</td>	
		<td class="border_right num">{$item.Equity_MRQ|num_format:2:'tỷ'}</td>
		<td class="border_right num">{$item.TotalAssets_MRQ|num_format:2:'tỷ'}</td>
		<td class="border_right num">{$item.ProfitAfterTax_TTM|num_format:2:'tỷ'}</td>
		<td class="border_right num">{$item.DilutedPE_TTM|num_format:2:'x'}</td>
        <td class="border_right num">{$item.ROE_TTM|num_format:2:'%'}</td>        
        <td class="num">{$item.ROA_TTM|num_format:2:'%'}</td>        		    
    </tr>   
    {/foreach}
</tbody>
</table>
<!-- /DINH GIA -->