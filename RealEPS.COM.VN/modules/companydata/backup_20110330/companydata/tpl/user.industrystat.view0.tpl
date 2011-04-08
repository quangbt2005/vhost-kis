<!-- DINH GIA -->
<table width="100%" class="small" cellpadding="0" cellspacing="0">
<thead style="background: #e5e5e5; font-size: 9px;">
	<tr>
		<th class="border_right">Tên</th>
		<th class="border_right num">P/E cơ bản<br/>(TTM)</th>
		<th class="border_right num">P/E cơ bản<br/>(LFY)</th>
		<th class="border_right num">P/E pha loãng<br/>(TTM)</th>
		<th class="border_right num">P/E pha loãng<br/>(LFY)</th>
		<th class="border_right num">P/S (TTM)</th>
		<th class="border_right num">P/S (LFY)</th>
		<th classs="num">P/B (MRQ)</th>
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
		<td class="border_right num">{$item.BasicPE_TTM|num_format:2:'x'}</td>
		<td class="border_right num">{$item.BasicPE_LFY|num_format:2:'x'}</td>
		<td class="border_right num">{$item.DilutedPE_TTM|num_format:2:'x'}</td>
		<td class="border_right num">{$item.DilutedPE_LFY|num_format:2:'x'}</td>
		<td class="border_right num">{$item.PS_TTM|num_format:2:'x'}</td>
		<td class="border_right num">{$item.PS_LFY|num_format:2:'x'}</td>
		<td class="num">{$item.PB_MRQ|num_format:2:'x'}</td>
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
			<td class="border_right num">{$subitem.BasicPE_TTM|num_format:2:'x'}</td>
			<td class="border_right num">{$subitem.BasicPE_LFY|num_format:2:'x'}</td>
			<td class="border_right num">{$subitem.DilutedPE_TTM|num_format:2:'x'}</td>
			<td class="border_right num">{$subitem.DilutedPE_LFY|num_format:2:'x'}</td>
			<td class="border_right num">{$subitem.PS_TTM|num_format:2:'x'}</td>
			<td class="border_right num">{$subitem.PS_LFY|num_format:2:'x'}</td>
			<td class="num">{$subitem.PB_MRQ|num_format:2:'x'}</td>
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
				<td class="border_right num">{$subitem1.BasicPE_TTM|num_format:2:'x'}</td>
				<td class="border_right num">{$subitem1.BasicPE_LFY|num_format:2:'x'}</td>
				<td class="border_right num">{$subitem1.DilutedPE_TTM|num_format:2:'x'}</td>
				<td class="border_right num">{$subitem1.DilutedPE_LFY|num_format:2:'x'}</td>
				<td class="border_right num">{$subitem1.PS_TTM|num_format:2:'x'}</td>
				<td class="border_right num">{$subitem1.PS_LFY|num_format:2:'x'}</td>
				<td class="num">{$subitem1.PB_MRQ|num_format:2:'x'}</td>
			</tr>
		{/foreach}
		{/if}
		{/foreach}
	{/if}
	{/foreach}
</tbody>
</table>
<!-- /DINH GIA -->