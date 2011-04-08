<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th></th>
        <th class="border_right">Mã<br/>CK</th>        
        <th class="border_right num">Năm<br/>TC gần<br/>nhất</th>
        <th class="border_right num">Quý gần<br/>nhất</th>        
        <th class="border_right num">EPS pha loãng<br/>(MRQ)</th>
        <th class="border_right num">EPS pha loãng<br/>(TTM)</th>
        <th class="border_right num">EPS pha loãng<br/>(LFY)</th>
        <th class="border_right num">Doanh thu<br/>(MRQ)</th>               
        <th class="border_right num">Doanh thu<br/>(TTM)</th>
        <th class="border_right num">Doanh thu<br/>(LFY)</th>                       
        <th class="border_right num">Lợi nhuận<br/>(MRQ)</th>
        <th class="border_right num">Lợi nhuận<br/>(TTM)</th>
        <th class="num">Lợi nhuận<br/>(LFY)</th>    
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
	    {if $item.LFY == 0}
		<td class="border_right num">---</td>
		<td class="border_right num">---</td>
		{else}
		<td class="border_right num">{$item.LFY}</td>
		<td class="border_right num">Q{$item.Quarter}/{$item.Year}</td>
		{/if}
		<td class="border_right num">{$item.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>	
		<td class="border_right num">{$item.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>
		<td class="border_right num">{$item.DilutedEPSGrowth_LFY|num_format:2:'%'}</td>
		<td class="border_right num">{$item.SalesGrowth_MRQ|num_format:2:'%'}</td>
		<td class="border_right num">{$item.SalesGrowth_TTM|num_format:2:'%'}</td>        
        <td class="border_right num">{$item.SalesGrowth_LFY|num_format:2:'%'}</td>                
        <td class="border_right num">{$item.ProfitGrowth_MRQ|num_format:2:'%'}</td>
        <td class="border_right num">{$item.ProfitGrowth_TTM|num_format:2:'%'}</td>
        <td class="num">{$item.ProfitGrowth_LFY|num_format:2:'%'}</td>        		    
    </tr>   
    {/foreach}
</tbody>
</table>
<!-- /DINH GIA -->