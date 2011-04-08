<form action="" name="frm_search" method="GET"/>
<div class="small_panel margin_bottom_10px" style="font-weight:bold;" border="1">
	<table cellpadding="0" cellspacing="0"><tr><td>
	<label for="txt_search_machungkhoan">Mã Chứng Khóan:</label> <input type="text" class="input" id="suggest1" size="10" name="symbol" value="{$data.symbol}"/>
			
	<label for="txt_search_tungay">Từ ngày:</label><input type="text" onKeyPress="return submitenter(this,event)" class="input" name="fromdate" id="fromdate" size="10" value="{$data.from_date|date_format:"%d/%m/%Y"}"/>
	<a href="javascript:cal.openCal();"><img src="/images/transparent.png" class="icon_cal" /></a>
			
	<label for="txt_search_denngay">Đến ngày:</label> <input type="text" onKeyPress="return submitenter(this,event)" class="input" name="todate" id="txt_search_denngay" value="{$data.to_date|date_format:"%d/%m/%Y"}" size="10"/>
	<a href="javascript:cal1.openCal();"><img src="/images/transparent.png" class="icon_cal" /></a>
	
	{if $_func != 'hase' && $_func != 'hase.filter'}
	<input type="radio" name="stockexchange" id="rad_search_hose" checked="checked" value="1" onchange="changesearch(this,'/thong-ke/hose/index.html');"/> 
	<label for="rad_search_hose">Sàn HOSE</label>
	<input type="radio" name="stockexchange" id="rad_search_hase" value="2" onchange="changesearch(this,'/thong-ke/hase/index.html');"/>
	<label for="rad_search_hase">Sàn HASE</label>
	{else}
	<input type="radio" name="stockexchange" id="rad_search_hose" value="1" onchange="changesearch(this,'/thong-ke/hose/index.html');"/> 
	<label for="rad_search_hose">Sàn HOSE</label>
	<input type="radio" name="stockexchange" id="rad_search_hase" checked="checked" value="2" onchange="changesearch(this,'/thong-ke/hase/index.html');"/>
	<label for="rad_search_hase">Sàn HASE</label>
	{/if}
	
	</td><td>			
	<a class="button" href="#" style="width: 100px; margin:auto;" onclick="document.frm_search.submit(); this.blur();"><span>Truy cập</span></a>			
	</td></tr></table>
</div>
</form>
{include file="$_MODULE_ABSPATH/tpl/$_type.$_page.$_func.tpl"}
