<link rel="stylesheet" type="text/css" href="/js/jquery.autocomplete.css" />
<script type="text/javascript" src="/js/jquery.autocomplete.pack.js"></script>
<script type="text/javascript" src="/js/calendar1.js"></script>
{literal}
<script type="text/javascript">
//{ Cac ham tien ich cua trang
function changeExchangeId(obj){
    //San HOSE
    if (obj.value == 1) obj.form.action='';
    //San HASE
    else obj.form.action='';
    bindSymbolAutocomplete(obj.value);
}
function bindSymbolAutocomplete(stockExchangeId){
	//{ Autocomplete
    $("#suggestSymbol").unautocomplete()
    $("#suggestSymbol").autocomplete('ajax.php?mod=securities&func=getsymbol&se=' + stockExchangeId, 
    {
		minChars: 0,
		width: 400,
		highlight: false,
		autoFill: true,
		formatItem: function(row) {
		  return row[0] + ' - ' + row[1];
		},
		formatMatch: function(row) {
			return row[0];
		},
		formatResult: function(row) {
		  return row[0] ;
		}
	});  
    //}
}
//}

//{ Chon ngay thang
var cal = new calendar1(document.forms[ "frm_search" ].elements["fromdate"]);   
cal.year_scroll = true;
var cal1 = new calendar1(document.forms[ "frm_search" ].elements["todate"]);    
cal1.year_scroll = true;
//}
bindSymbolAutocomplete(1);

</script>
{/literal}