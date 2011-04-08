<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
    <tr>
        <th class="border_right">Tên</th>
        <th class="border_right num">ROE (TTM)</th>
        <th class="border_right num">ROE (LFY)</th>
        <th class="border_right num">ROA (TTM)</th>
        <th class="num">ROA (LFY)</th>      
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
        <td class="border_right num">{$item.ROE_TTM|num_format:2:'%'}</td>
        <td class="border_right num">{$item.ROE_LFY|num_format:2:'%'}</td>
        <td class="border_right num">{$item.ROA_TTM|num_format:2:'%'}</td>
        <td class="num">{$item.ROA_LFY|num_format:2:'%'}</td>        
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
                <a name="indsutry{$subitem.IndustryId}"></a>
                {if isset($subitem.company)}
                <img src="/images/minus.gif" alt="Chung khoan Gia Quyen" align="absmiddle"/>
                {else}
                <img src="/images/plus.gif" alt="Chung khoan Gia Quyen" align="absmiddle"/>
                {/if}
                <a href="/doanh-nghiep/nganh/{$subitem.IndustryId}/sosanh.html?view={$data.view}#indsutry{$subitem.IndustryId}#indsutry{$subitem.IndustryId}">{$subitem.Name}</a>
            </td>
            <td class="border_right num">{$subitem.ROE_TTM|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.ROE_LFY|num_format:2:'%'}</td>
            <td class="border_right num">{$subitem.ROA_TTM|num_format:2:'%'}</td>
            <td class="num">{$subitem.ROA_LFY|num_format:2:'%'}</td> 
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
                <td class="border_right num">{$subitem1.ROE_TTM|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.ROE_LFY|num_format:2:'%'}</td>
                <td class="border_right num">{$subitem1.ROA_TTM|num_format:2:'%'}</td>
                <td class="num">{$subitem1.ROA_LFY|num_format:2:'%'}</td> 
            </tr>
        {/foreach}
        {/if}
        {/foreach}
    {/if}
    {/foreach}
</tbody>
</table>
<!-- /DINH GIA -->