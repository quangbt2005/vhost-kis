<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th></th>
        <th class="border_right">Mã<br/>CK</th>        
        <th class="border_right num">Năm TC gần nhất</th>
        <th class="border_right num">Quý gần nhất</th>
        <th class="border_right num">Giá gần nhất</th>
        <th class="border_right num">P/E cơ bản (TTM)</th>
        <th class="border_right num">P/E cơ bản (LFY)</th>
        <th class="border_right num">P/E pha loãng (TTM)</th>
        <th class="border_right num">P/E pha loãng (LFY)</th>               
        <th class="border_right num">P/S (TTM)</th>
        <th class="border_right num">P/S (LFY)</th>                       
        <th class="num">P/B (MRQ)</th>    
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
		<td class="border_right num">---</td>	
		<td class="border_right num">{$item.BasicPE_TTM|num_format:2:'x'}</td>
		<td class="border_right num">{$item.BasicPE_LFY|num_format:2:'x'}</td>
		<td class="border_right num">{$item.DilutedPE_TTM|num_format:2:'x'}</td>
		<td class="border_right num">{$item.DilutedPE_LFY|num_format:2:'x'}</td>
        <td class="border_right num">{$item.PS_TTM|num_format:2:'x'}</td>        
        <td class="border_right num">{$item.PS_LFY|num_format:2:'x'}</td>
        <td class="num">{$item.PB_MRQ|num_format:2:'x'}</td>        		    
    </tr>   
    {/foreach}
</tbody>
</table>
<!-- /DINH GIA -->