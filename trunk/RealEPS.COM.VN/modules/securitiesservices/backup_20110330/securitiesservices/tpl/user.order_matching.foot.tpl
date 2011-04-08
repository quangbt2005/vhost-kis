<link rel="stylesheet" type="text/css" href="/js/jquery.autocomplete.css" />
<script type="text/javascript" src="/js/jquery.autocomplete.pack.js"></script>
<script type="text/javascript" src="/js/calendar1.js"></script>
<script type="text/javascript">
var StockSymbols={$data.StockSymbols};
</script>
{literal}
<script type="text/javascript">
var cal = new calendar1(document.forms[ "frm_search" ].elements["fromdate"]);	
cal.year_scroll = true;
var cal1 = new calendar1(document.forms[ "frm_search" ].elements["todate"]);	
cal1.year_scroll = true;

$(document).ready(function(){  
	$("#suggest1").focus().autocomplete(StockSymbols, {width: 100});  
});
</script>
{/literal}