<?php
if ( !defined( 'TYPE' ) || TYPE != 'admin' ) die();
require( 'functions.php' );
function news_admin_main() {
	$paging = new Paging( 'p', _result_per_page(), 1, 9 );
	$paging->sCurrentPageClass = 'current';
	$paging->sPageNextClass = 'next';

	$sqlOrder ='news_id desc';
	if ( !empty( $_GET[ 'sortby' ] ) ){
		$sortby = $_GET[ 'sortby' ];
		$sort = $_GET[ 'sort' ];
		if ( $sort == 'asc' ) {
			$sqlOrder = $sortby . ' asc';
		}else if ( $sort == 'desc' ){
			$sqlOrder = $sortby . ' desc';
		}
	}
	$sqlOrder = 'ordering DESC,is_category desc,' . $sqlOrder;	
	$data = array();
	$db = _db();
	$pid = 0;
	$parent = null;
	if ( !empty( $_GET[ 'pid' ])){
		$pid = $_GET[ 'pid' ];
		if ( $pid != 0 ){
			$db->prepare('SELECT news_id, parent_id FROM `_prefix_news` WHERE news_id=:ID' );
			$db->bindValue( ':ID', $pid, PARAM_INT );
			$db->execute();
			if ( $parent = $db->fetch() ){
				$data[ 'parent' ] = $parent;
			}else{
				$pid = 0;
			}
		}
	}
	$cats[ 0 ] = '-- Không thuộc nhóm --';
	getCategoryList( $cats );
	$data[ 'category' ] = $cats;
	$db->prepare( 'SELECT SQL_CALC_FOUND_ROWS ordering ,is_quantam, is_tieudiem,news_id, news_created, news_title, is_category, is_enabled, is_showintroimage,introimage FROM `_prefix_news` WHERE parent_id=:PARENT_ID ORDER BY :ORDER LIMIT :OFFSET, :TOTAL' );
	$db->bindValue( ':PARENT_ID', $pid, PARAM_INT );
	$db->bindValue( ':ORDER', $sqlOrder, PARAM_NONE );
	$db->bindValue( ':OFFSET', $paging->getResultRowStart(), PARAM_INT );
	$db->bindValue( ':TOTAL', _result_per_page(), PARAM_INT );	
	$db->execute();

	if ( $items = $db->fetchAll() ){
		$data[ 'items' ] = $items;
	}
	//Lay tong cong so record
	$paging->nTotalRow = $db->total_last_limit_query();

	$data[ 'paging' ] = $paging;

	return $data;
}
?>