<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th class="border_right">Tên</th>
        <th class="border_right num">Doanh<br/>thu<br/>(MRQ)</th>
        <th class="border_right num">Doanh<br/>thu<br/>(TTM)</th>
        <th class="border_right num">Doanh<br/>thu<br/>(LFY)</th>
        <th class="border_right num">Lợi<br/>nhuận<br/>(MRQ)</th>    
        <th class="border_right num">Lợi<br/>nhuận<br/>(TTM)</th>    
        <th class="border_right num">Lợi<br/>nhuận<br/>(LFY)</th> 
        <th class="border_right num">Tài<br/>sản<br/>(MRQ)</th>
        <th class="border_right num">Tài<br/>sản<br/>(TTM)</th>
        <th class="border_right num">Tài<br/>sản<br/>(LFY)</th>       
        <th class="border_right num">EPS<br/>pha loãng<br/>(MRQ)</th>
        <th class="border_right num">EPS<br/>pha loãng<br/>(TTM)</th>
        <th class="num">EPS<br/>pha loãng<br/>(LFY)</th>
    </tr>
</thead>
<tbody>
    {foreach from=$data.sector item=item name=loop}
    {assign var='index' value=`$index+1`}
    {if $index % 2 == 0}
    <tr bgcolor="#f0f0f0">
    {else}
    <tr>
    {/if}
        <td class="border_right">
            <a name="sector{$item.SectorId}"></a>
            {if isset($item.industry)}
            <img src="/images/minus.gif" alt="Chung khoan Gia Quyen" align="absmiddle"/>
            {else}
            <img src="/images/plus.gif" alt="Chung khoan Gia Quyen" align="absmiddle"/>
            {/if}
            <a href="/doanh-nghiep/linh-vuc/{$item.SectorId}/sosanh.html?view={$data.view}#sector{$item.SectorId}">{$item.Name}</a>
        </td>
        <td class="border_right num">{$item.SalesGrowth_MRQ|num_format:2:'%'}</td>
        <td class="border_right num">{$item.SalesGrowth_TTM|num_format:2:'%'}</td>
        <td class="border_right num">{$item.SalesGrowth_LFY|num_format:2:'%'}</td>
        <td class="border_right num">{$item.ProfitGrowth_MRQ|num_format:2:'%'}</td>
        <td class="border_right num">{$item.ProfitGrowth_TTM|num_format:2:'%'}</td>
        <td class="border_right num">{$item.ProfitGrowth_LFY|num_format:2:'%'}</td>        
        <td class="border_right num">{$item.TotalAssetsGrowth_MRQ|num_format:2:'%'}</td>
        <td class="border_right num">{$item.TotalAssetsGrowth_TTM|num_format:2:'%'}</td>
        <td class="border_right num">{$item.TotalAssetsGrowth_LFY|num_format:2:'%'}</td>
        <td class="border_right num">{$item.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>
        <td class="border_right num">{$item.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>   
        <td class="num">{$item.DilutedEPSGrowth_LFY|num_format:2:'%'}</td>                
    </tr>
    {if isset($item.industry)}
        {foreach from=$item.industry item=subitem}
        {assign var='index' value=`$index+1`}
        {if $index % 2 == 0}
        <tr bgcolor="#f0f0f0">
        {else}
        <tr>
        {/if}
            <td class="border_right" style="padding-left: 20px;">
                <a name="industry{$subitem.IndustryId}"></a>
                {if isset($subitem.company)}
                <img src="/images/minus.gif" alt="Chung khoan Gia Quyen" align="absmiddle"/>
                {else}
                <img src="/images/plus.gif" alt="Chung khoan Gia Quyen" align="absmiddle"/>
                {/if}
                <a href="/doanh-nghiep/nganh/{$subitem.IndustryId}/sosanh.html?view={$data.view}#industry{$subitem.IndustryId}">{$subitem.Name}</a>
            </td>
            <td class="border_right num">{$subitem.SalesGrowth_MRQ|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.SalesGrowth_TTM|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.SalesGrowth_LFY|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.ProfitGrowth_MRQ|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.ProfitGrowth_TTM|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.ProfitGrowth_LFY|num_format:2:'%'}</td>        
            <td class="border_right num">{$subitem.TotalAssetsGrowth_MRQ|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.TotalAssetsGrowth_TTM|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.TotalAssetsGrowth_LFY|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>   
            <td class="num">{$subitem.DilutedEPSGrowth_LFY|num_format:2:'%'}</td>  
        </tr>
        {if isset($subitem.company)}
        {foreach from=$subitem.company item=subitem1}
            {assign var='index' value=`$index+1`}
            {if $index % 2 == 0}
            <tr bgcolor="#f0f0f0">
            {else}
            <tr>
            {/if}
                <td class="border_right" style="padding-left: 55px;">
                    - <a href="/doanh-nghiep/cong-ty/{$subitem1.Symbol}/overview.html#content">{$subitem1.CompanyName}</a>
                </td>
                <td class="border_right num">{$subitem1.SalesGrowth_MRQ|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.SalesGrowth_TTM|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.SalesGrowth_LFY|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.ProfitGrowth_MRQ|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.ProfitGrowth_TTM|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.ProfitGrowth_LFY|num_format:2:'%'}</td>        
                <td class="border_right num">{$subitem1.TotalAssetsGrowth_MRQ|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.TotalAssetsGrowth_TTM|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.TotalAssetsGrowth_LFY|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>   
                <td class="num">{$subitem1.DilutedEPSGrowth_LFY|num_format:2:'%'}</td> 
            </tr>
        {/foreach}
        {/if}
        {/foreach}
    {/if}
    {/foreach}
</tbody>
</table>
<!-- /DINH GIA -->