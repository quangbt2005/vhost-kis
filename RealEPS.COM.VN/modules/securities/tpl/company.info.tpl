{if $data.info}
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td>
		<div style="line-height: 150%; font-family: arial;font-size: 12px;">
			<div style="font-size: 14px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px; text-transform: uppercase;">
			<b>{$data.info.CompanyName} ({$data.info.Symbol} . {if $data.seid == 1}HOSE{else}HASE{/if})</b> 
			</div>
			<div><b>Ngành :</b> <a href="/doanh-nghiep/nganh/{$data.info.IndustryId}/index.html">{$data.info.IndustryName}</a></div>
		</div>
	</td>
</tr>
</table>
{else}
<h3 style="text-align: center; font-weight: bold;">Không tìm thấy thông mã chứng khoán "{$get.symbol}"</h3>
{/if}    