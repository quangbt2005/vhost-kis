<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Push Data</title>
</head>
<body>
<script type="text/javascript" src="/js/config.js"></script>
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
{literal}
<script type="text/javascript">
$.ajaxSetup({ cache: false }); 	
var dowIndex=[];
function loadDowIndex(){
	var parent = this.parent.document;		
				
	$.getJSON("services/data/data.dow.json", function(data){
		if (dowIndex.length==0 || dowIndex[0] != data.index || dowIndex[1] != data.change){
			$('#dow_index', parent).html(data.index);			
			$('#dow_change', parent).html(data.change);
			$('#dow_percent_change', parent).html(data.percent_change);
			if (data.change > 0){				
				$('#dow_change_container', parent).attr('class','right up');	
				$('#dow_img', parent).html('<img src="/images/transparent.png" class="icon_up" />');			
			}else if(data.change == 0){
				$('#dow_change_container', parent).attr('class','right stand');
				$('#dow_img', parent).html('<img src="/images/transparent.png" class="icon_stand" />');
			}else{
				$('#dow_change_container', parent).attr('class','right down');
				$('#dow_img', parent).html('<img src="/images/transparent.png" class="icon_down" />');				
			}
			dowIndex[0]=data.index;
			dowIndex[1]=data.change;
		}
		setTimeout(loadDowIndex, REFRESH_TIME);
	});
}
var nikkeiIndex=[];
function loadNikkeiIndex(){
	var parent = this.parent.document;		 				
	$.getJSON("services/data/data.nikkei.json", function(data){
		if (nikkeiIndex.length==0 || nikkeiIndex[0] != data.index || nikkeiIndex[1] != data.change){
			$('#nikkei_index', parent).html(data.index);			
			$('#nikkei_change', parent).html(data.change);
			$('#nikkei_percent_change', parent).html(data.percent_change);
			if (data.change > 0){				
				$('#nikkei_change_container', parent).attr('class','right up');	
				$('#nikkei_img', parent).html('<img src="/images/transparent.png" class="icon_up" />');			
			}else if(data.change == 0){
				$('#nikkei_change_container', parent).attr('class','right stand');
				$('#nikkei_img', parent).html('<img src="/images/transparent.png" class="icon_stand" />');
			}else{
				$('#nikkei_change_container', parent).attr('class','right down');
				$('#nikkei_img', parent).html('<img src="/images/transparent.png" class="icon_down" />');				
			}
			nikkeiIndex[0]=data.index;
			nikkeiIndex[1]=data.change;
		}
		setTimeout(loadNikkeiIndex, REFRESH_TIME);
	});
}
var stoxxIndex=[];
function loadStoxxIndex(){
	var parent = this.parent.document;		 				
	$.getJSON("services/data/data.stoxx.json", function(data){
		if (stoxxIndex.length==0 || stoxxIndex[0] != data.index || stoxxIndex[1] != data.change){
			$('#stoxx_index', parent).html(data.index);			
			$('#stoxx_change', parent).html(data.change);
			$('#stoxx_percent_change', parent).html(data.percent_change);
			if (data.change > 0){				
				$('#stoxx_change_container', parent).attr('class','right up');	
				$('#stoxx_img', parent).html('<img src="/images/transparent.png" class="icon_up" />');			
			}else if(data.change == 0){
				$('#stoxx_change_container', parent).attr('class','right stand');
				$('#stoxx_img', parent).html('<img src="/images/transparent.png" class="icon_stand" />');
			}else{
				$('#stoxx_change_container', parent).attr('class','right down');
				$('#stoxx_img', parent).html('<img src="/images/transparent.png" class="icon_down" />');				
			}
			stoxxIndex[0]=data.index;
			stoxxIndex[1]=data.change;
		}
		setTimeout(loadStoxxIndex, REFRESH_TIME);
	});
}

function hose_assign(id,value,parent){
	var oldVal = $('#'+id, parent).html();
	if (oldVal != value){
		$('#'+id, parent).html(value);
		if (id == 'hose_VNIndexChanges'){
            value = value.replace(',', '.');                                                   
			if (value > 0){				
				$('#hose_change_container', parent).attr('class','right up');	
				$('#hose_change_container1', parent).attr('class','right up');
				$('#hose_img', parent).html('<img src="/images/transparent.png" class="icon_up" />');			
			}else if(value == 0){
				$('#hose_change_container', parent).attr('class','right stand');
				$('#hose_change_container1', parent).attr('class','right stand');
				$('#hose_img', parent).html('<img src="/images/transparent.png" class="icon_stand" />');
			}else{
				$('#hose_change_container', parent).attr('class','right down');
				$('#hose_change_container1', parent).attr('class','right down');
				$('#hose_img', parent).html('<img src="/images/transparent.png" class="icon_down" />');				
			}
		}
	}
}

function loadHoseIndex(){
	var parent = this.parent.document;					
	$.getJSON("index.php?mod=welcome&page=push&func=hose", function(data){	
		hose_assign('hose_VNIndex', data.VNIndex, parent);
		hose_assign('hose_VNIndexChanges', data.VNIndexChanges, parent);	
		hose_assign('hose_PercentChanges', data.PercentChanges, parent);		

		hose_assign('hose_VNIndex1', data.VNIndex, parent);
		hose_assign('hose_VNIndexChanges1', data.VNIndexChanges, parent);	
		hose_assign('hose_PercentChanges1', data.PercentChanges, parent);
		hose_assign('hose_Gainers1', data.Gainers, parent);
		hose_assign('hose_Unchanged1', data.Unchanged, parent);
		hose_assign('hose_Losers1', data.Losers, parent);
		hose_assign('hose_TotalValues1', data.TotalValues, parent);
		hose_assign('hose_TotalShares1', data.TotalShares, parent);
		setTimeout(loadHoseIndex, REFRESH_TIME);
	});
}

function hase_assign(id,value,parent){
	var oldVal = $('#'+id, parent).html();
	if (oldVal != value){
		$('#'+id, parent).html(value);
		if (id == 'hase_CHGIndex'){
			value = value.replace(',', '.');
			if (value > 0){				
				$('#hase_change_container', parent).attr('class','right up');	
				$('#hase_change_container1', parent).attr('class','right up');
				$('#hase_img', parent).html('<img src="/images/transparent.png" class="icon_up" />');			
			}else if(value == 0){
				$('#hase_change_container', parent).attr('class','right stand');
				$('#hase_change_container1', parent).attr('class','right stand');
				$('#hase_img', parent).html('<img src="/images/transparent.png" class="icon_stand" />');
			}else{
				$('#hase_change_container', parent).attr('class','right down');
				$('#hase_change_container1', parent).attr('class','right down');
				$('#hase_img', parent).html('<img src="/images/transparent.png" class="icon_down" />');				
			}
		}
	}
}

function loadHaseIndex(){
	var parent = this.parent.document;					
	$.getJSON("index.php?mod=welcome&page=push&func=hase", function(data){	
		hase_assign('hase_MarketIndex', data.MarketIndex, parent);
		hase_assign('hase_CHGIndex', data.CHGIndex, parent);	
		hase_assign('hase_PCTIndex', data.PCTIndex, parent);		
        
		hase_assign('hase_MarketIndex1', data.MarketIndex, parent);
		hase_assign('hase_CHGIndex1', data.CHGIndex, parent);	
		hase_assign('hase_PCTIndex1', data.PCTIndex, parent);
		hase_assign('hase_Gainers1', data.Gainers, parent);
		hase_assign('hase_Unchanged1', data.Unchanged, parent);
		hase_assign('hase_Losers1', data.Losers, parent);
		hase_assign('hase_TotalValue1', data.TotalValue, parent);
		hase_assign('hase_TotalQuantity1', data.TotalQuantity, parent);
		setTimeout(loadHaseIndex, REFRESH_TIME);
	});
}

function upcom_assign(id,value,parent){
	var oldVal = $('#'+id, parent).html();
	if (oldVal != value){
		$('#'+id, parent).html(value);
		if (id == 'upcom_CHGIndex'){
			value = value.replace(',', '.');
			if (value > 0){				
				$('#upcom_change_container', parent).attr('class','right up');	
				$('#upcom_img', parent).html('<img src="/images/transparent.png" class="icon_up" />');			
			}else if(value == 0){
				$('#upcom_change_container', parent).attr('class','right stand');
				$('#upcom_img', parent).html('<img src="/images/transparent.png" class="icon_stand" />');
			}else{
				$('#upcom_change_container', parent).attr('class','right down');
				$('#upcom_img', parent).html('<img src="/images/transparent.png" class="icon_down" />');				
			}
		}
	}
}

function loadUpcomIndex(){
	var parent = this.parent.document;					
	$.getJSON("index.php?mod=welcome&page=push&func=upcom", function(data){	
		upcom_assign('upcom_MarketIndex', data.MarketIndex, parent);
		upcom_assign('upcom_CHGIndex', data.CHGIndex, parent);	
		upcom_assign('upcom_PCTIndex', data.PCTIndex, parent);		
		setTimeout(loadUpcomIndex, REFRESH_TIME);
	});
}
loadStoxxIndex();
loadNikkeiIndex();
loadDowIndex();
loadHoseIndex();
loadHaseIndex();
loadUpcomIndex();

</script>
{/literal}
</body>
</html>
