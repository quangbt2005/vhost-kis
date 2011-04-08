<?php
function push_user_hose(){
	$db = _db('eps');
	$db->query('call sp_GetTotalMarket("'.maxTradingDate().'")');
	if ($data=$db->fetch()){
		$obj['VNIndex']=_num_format($data['VNIndex']);
		$obj['VNIndexChanges']=_num_format($data['VNIndexChanges']);
		$obj['PercentChanges']=_num_format($data['PercentChanges'],2);
		$obj['Gainers']=$data['Gainers'];
		$obj['Unchanged']=$data['Unchanged'];
		$obj['Losers']=$data['Losers'];
		$obj['TotalValues'] = _num_format($data['TotalValues'],0);
		$obj['TotalShares'] = _num_format($data['TotalShares'],0);
		echo json_encode($obj);
	}
	exit(0);
}
function push_user_hase(){
	$db = _db('eps');
	$db->query('call sp_HN_getCurrentMarketInfo("'.maxTradingDate().'")');
	if ($data=$db->fetch()){
		$obj['MarketIndex']=$data['MarketIndex'];
		$obj['CHGIndex']= _num_format($data['CHGIndex']);
		$obj['PCTIndex']=_num_format($data['PCTIndex']);
		$obj['TotalValue'] = _num_format($data['TotalValue'],0);
		$obj['TotalQuantity'] = _num_format($data['TotalQuantity'],0);
		$obj['Gainers']=$data['Gainers'];
		$obj['Unchanged']=$data['Unchanged'];
		$obj['Losers']=$data['Losers'];
		echo json_encode($obj);
	}
	exit(0);
}
function push_user_upcom(){
	$db = _db('eps');
	$db->query('call sp_upcom_getCurrentMarketInfo("'.maxTradingDate().'")');
	if ($data=$db->fetch()){
		$obj['MarketIndex']=_num_format($data['MarketIndex']);
		$obj['CHGIndex']=_num_format($data['CHGIndex']);
		$obj['PCTIndex']=_num_format($data['PCTIndex']);
		echo json_encode($obj);
	}
	exit(0);
}
function welcome_user_layout(){
	return 'empty.tpl';
}
?>