<div class="other_news">
    <div class="left" style="font-size: 13px; font-weight: bold; color:#254F92; background-color: #FFFFFF; padding-right: 5px;">
    Biểu đồ kỹ thuật
    {if $data.from_date != $data.to_date}
     ({$data.from_date|date_format:"%d/%m/%Y"} đến ngày {$data.to_date|date_format:"%d/%m/%Y"})
    {else}
    ({$data.to_date|date_format:"%d/%m/%Y"})
    {/if}
    </div>
    <div class="clear"></div>
</div>

<div style="border:1px solid #000000;width:955px;height:700px;">
	<object  id='mySwf' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab' height="700px" width="955px" > 	
    <param name='src' value="charts/TechnicalChart.swf?stockSymbol=ABT&stockExchangeID=1&dateFrom=2009-06-04&dateTo=2009-12-04&wsdl=http://www.kisvn.vn/ws/chart.php?wsdl"/>     
    <embed src="images/TechnicalChart.swf?stockSymbol={$get.symbol}&stockExchangeID={$data.seid}&dateFrom={$data.from_date}&dateTo={$data.to_date}&wsdl=http://www.kisvn.vn/ws/chart.php?wsdl" width="955px" height="700px" pluginspage='http://www.adobe.com/go/getflashplayer'  />     
    </object>
</div>
