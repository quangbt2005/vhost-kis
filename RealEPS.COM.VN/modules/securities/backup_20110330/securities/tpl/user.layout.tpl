<form action="" name="frm_search" method="GET"/>
<input type="hidden" name="mod" value="securities" />
<div class="small_panel margin_bottom_10px" style="font-weight:bold;" border="1">
	<table cellpadding="0" cellspacing="0"><tr><td>
	<label for="txt_search_machungkhoan">Mã Chứng Khóan:</label> <input type="text" class="input" id="suggestSymbol" size="10" name="symbol" value="{$data.symbol}"/>
			
	<label for="txt_search_tungay">Từ ngày:</label><input type="text" onKeyPress="return submitenter(this,event)" class="input" name="fromdate" id="fromdate" size="10" value="{$data.from_date|date_format:"%d/%m/%Y"}"/>
	<a href="javascript:cal.openCal();"><img src="/images/transparent.png" class="icon_cal" /></a>
			
	<label for="txt_search_denngay">Đến ngày:</label> <input type="text" onKeyPress="return submitenter(this,event)" class="input" name="todate" id="txt_search_denngay" value="{$data.to_date|date_format:"%d/%m/%Y"}" size="10"/>
	<a href="javascript:cal1.openCal();"><img src="/images/transparent.png" class="icon_cal" /></a>
    
	<input type="radio" name="seid" id="rad_search_hose" {if $data.seid !== '1'}checked="checked"{/if} value="1" onchange="changeExchangeId(this);"/> 
    <label for="rad_search_hose">Sàn HOSE</label>

    <input type="radio" name="seid" id="rad_search_hase" {if $data.seid == '2'}checked="checked"{/if} value="2" onchange="changeExchangeId(this);"/>
    <label for="rad_search_hase">Sàn HASE</label>
    	
	</td><td>			
	<a class="button" href="#" style="width: 100px; margin:auto;" onclick="document.frm_search.submit(); this.blur();"><span>Truy cập</span></a>			
	</td></tr></table>
</div>

</form>
{if $get.view != 3 && $get.view != 4}
<a name="info"></a>
<div class="table_panel margin_bottom_10px_float"> 
    <div class="header_left">
        <table cellpadding="0" cellspacing="0" class="header_right">
        <tr><td>
            <a href="index.php?mod=securities&seid=1#info" class="panel_button{if $data.seid != 2}_active{/if} left" ><span>
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>Sàn HOSE
            </span></a>
            <a href="index.php?mod=securities&seid=2#info" class="panel_button{if $data.seid == 2}_active{/if} left margin_left_20px" ><span>
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>Sàn HASE
            </span></a>
            
            <span class="clear"></span>    
        </td></tr>
        </table>          
    </div>              
    <div class="panel_content">
    {include file="`$_MODULE_ABSPATH`/tpl/`$data.se`.info.tpl"}    
    </div>    
    <div class="panel_bottom_left"></div>
    <div class="panel_bottom"></div>
    <div class="panel_bottom_right"></div>
    <div class="clear"></div>                
</div>
{/if}
<a name="detail"></a>
<!-- CAC GIAO DICH -->
<div class="table_panel">
    <div class="header_left">
        <table cellpadding="0" cellspacing="0" class="header_right">
        <tr><td>
            <a href="index.php?mod=securities&seid={$data.seid}&view=0{$data.url_param}#detail" class="panel_button{if $data.view==0}_active{/if} left" ><span>
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Khớp lệnh
            </span></a>
            <a href="index.php?mod=securities&seid={$data.seid}&view=1{$data.url_param}#detail" class="panel_button{if $data.view==1}_active{/if} left margin_left_20px" ><span>
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Thỏa thuận
            </span></a>
            <a href="index.php?mod=securities&seid={$data.seid}&view=2{$data.url_param}#detail" class="panel_button{if $data.view==2}_active{/if} left margin_left_20px" ><span>
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD NĐT NN
            </span></a>            
            <a href="index.php?mod=securities&seid={$data.seid}&view=3{$data.url_param}#info" class="panel_button{if $data.view==3}_active{/if} left margin_left_20px" ><span>
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>GD Trái phiếu
            </span></a>
            {if $get.symbol != ''}
            <a href="index.php?mod=securities&seid={$data.seid}&view=4{$data.url_param}#info" class="panel_button{if $data.view==4}_active{/if} left margin_left_20px" ><span>
            <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>Biểu đồ kỹ thuật
            </span></a>
            {/if}
            <span class="right" style="color: #666666;padding: 3px 10px 5px 2px;"><b>
            Ngày giao dịch:
            {if $data.from_date != $data.to_date}
            {$data.from_date|date_format:"%d/%m/%Y"} - {$data.to_date|date_format:"%d/%m/%Y"}
            {else}
            {$data.to_date|date_format:"%d/%m/%Y"}
            {/if}
            </b></span>
            <span class="clear"></span>  
        </td></tr></table>
    </div>
    
    <div class="panel_content">           
        {include file="`$_MODULE_ABSPATH`/tpl/`$data.se``$data.type`view`$data.view`.tpl"}                      
    </div>    
    <div class="panel_bottom_left"></div>
    <div class="panel_bottom"></div>
    <div class="panel_bottom_right"></div>
    <div class="clear"></div>          
</div>   
<!-- /CAC GIAO DICH -->