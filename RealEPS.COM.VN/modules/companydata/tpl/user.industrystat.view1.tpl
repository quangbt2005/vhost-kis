<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
	<tr>
		<th class="border_right">Tên</th>
		<th class="border_right num">Khả năng<br/>thanh toán<br/>nhanh (MRQ)</th>
		<th class="border_right num">Khả năng<br/>thanh toán<br/>tức thời (MRQ)</th>
		<th class="border_right num">Khả năng<br/>thanh toán<br/>lãi vay (TTM)</th>
		<th class="border_right num">Nợ dài hạn/<br/>Vốn CSH<br/>(MRQ)</th>
		<th class="border_right num">Tổng nợ/<br/>Vốn CSH<br/>(MRQ)</th>
		<th class="border_right num">Tổng nợ/<br/>Tổng tài sản<br/>(MRQ)</th>
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
		<td class="border_right num">{$item.QuickRatio_MRQ|num_format:2:'x'}</td>
		<td class="border_right num">{$item.CurrentRatio_MRQ|num_format:2:'x'}</td>
		<td class="border_right num">{$item.InterestCoverageRatio_TTM|num_format:2:'x'}</td>
		<td class="border_right num">{$item.LTDebtOverEquity_MRQ|num_format:2:'x'}</td>
		<td class="border_right num">{$item.TotalDebtOverEquity_MRQ|num_format:2:'x'}</td>
		<td class="border_right num">{$item.TotalDebtOverAssets_MRQ|num_format:2:'x'}</td>
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
			<td class="border_right num">{$subitem.QuickRatio_MRQ|num_format:2:'x'}</td>
    		<td class="border_right num">{$subitem.CurrentRatio_MRQ|num_format:2:'x'}</td>
    		<td class="border_right num">{$subitem.InterestCoverageRatio_TTM|num_format:2:'x'}</td>
    		<td class="border_right num">{$subitem.LTDebtOverEquity_MRQ|num_format:2:'x'}</td>
    		<td class="border_right num">{$subitem.TotalDebtOverEquity_MRQ|num_format:2:'x'}</td>
    		<td class="border_right num">{$subitem.TotalDebtOverAssets_MRQ|num_format:2:'x'}</td>
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
				<td class="border_right num">{$subitem1.QuickRatio_MRQ|num_format:2:'x'}</td>
        		<td class="border_right num">{$subitem1.CurrentRatio_MRQ|num_format:2:'x'}</td>
        		<td class="border_right num">{$subitem1.InterestCoverageRatio_TTM|num_format:2:'x'}</td>
        		<td class="border_right num">{$subitem1.LTDebtOverEquity_MRQ|num_format:2:'x'}</td>
        		<td class="border_right num">{$subitem1.TotalDebtOverEquity_MRQ|num_format:2:'x'}</td>
        		<td class="border_right num">{$subitem1.TotalDebtOverAssets_MRQ|num_format:2:'x'}</td>
			</tr>
		{/foreach}
		{/if}
		{/foreach}
	{/if}
	{/foreach}
</tbody>
</table>
<!-- /DINH GIA -->