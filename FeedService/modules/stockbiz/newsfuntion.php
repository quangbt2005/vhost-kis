<?php
function getNewsParentId($newsGroup){
	$parentId = 3;
	if ($newsGroup == 5) $parentId = 5;
	else if ($newsGroup == 3) $parentId=4;
	else if ($newsGroup == 1) $parentId=6;
	return $parentId;
}
function setRangeDate(&$startDate, &$endDate){
	$startDate = strtotime('now');
	$endDate = strtotime('now');
	if (isset($_GET['start']) && strtotime($_GET['start']))
		$startDate = strtotime($_GET['start']);
	if (isset($_GET['end']) && strtotime($_GET['end']))
		$endDate = strtotime($_GET['end']);
	//Neu ngay bat dau > ngay ket thu
	//--> hoan vi 2 thoi gian
	if ($startDate > $endDate){
		$tmp = $startDate;
		$startDate = $endDate;
		$endDate = $startDate;
	}
	$startDate = mktime(0,0,0,date('m', $startDate), date('d', $startDate), date('Y', $startDate));
	$endDate = mktime(23,59,59,date('m', $endDate), date('d', $endDate), date('Y', $endDate));
	
	$startDate=date('c', $startDate);
	$endDate=date('c', $endDate);
}
function insertIntoNews($obj, $values=null){
	if (!empty($obj)){
		
		$db = _db();
		/**
		 * Kiem tra su ton tai cua ID
		 * Neu co : 
		 * + Neu noi dung co thay doi o mot trong cac field --> cap nhap
		 * + Khong co thay doi --> bo qua
		 * Khong co:
		 * + Insert moi vao
		 */
		$db->query('SELECT * FROM _prefix_news WHERE stockbiz_id=' . $obj[ 'NewsID' ]);
		//Neu news da ton tai
		if ($currentObj = $db->fetch()){
			$sql = 'UPDATE `_prefix_news` SET sectorid=:SECTORID, industryid=:INDUSTRYID, symbol=:SYMBOL WHERE stockbiz_id=:ID';
			
			$db->prepare($sql);
			$db->bindValue(':ID', $obj[ 'NewsID' ], PARAM_INT);
			if (isset($values['SectorId'])) $db->bindValue(':SECTORID', $values['SectorId'], PARAM_INT);
			else $db->bindValue(':SECTORID', $currentObj['sectorid'], PARAM_INT);
			
			if (isset($values['IndustryId'])) $db->bindValue(':INDUSTRYID', $values['IndustryId'], PARAM_INT);
			else $db->bindValue(':INDUSTRYID', $currentObj['industryid'], PARAM_INT);
			
			if (isset($values['Symbol'])) $db->bindValue(':SYMBOL', $values['Symbol'], PARAM_STR);
			else $db->bindValue(':SYMBOL', '', PARAM_STR);
			
			$db->execute($sql);
			
		}else{		
			global $_configs;
			//{Lay contnet
			//Van de : Khi bai viet khong co content, service tra ve noi dung gioi thieu
			$url = 'http://datafeed.stockbiz.vn/NewsService.asmx?WSDL';
			$params=array(
			'userName' => $_configs['stockbiz_user'],
			'password' => $_configs['stockbiz_pass'],
			'newsID' => $obj['NewsID']);
			$result=_feed_stockbiz('GetNewsContent',$url,$params);
			$content='';
			if (!empty($result)) $content=$result['GetNewsContentResult'];
			//}
			$sql = 'INSERT INTO `_prefix_news` (stockbiz_id,news_created,news_title,news_tagline,news_alias,introimage,intro,content,is_category,
					is_enabled,is_showintroimage,is_tieudiem,is_quantam,view,ordering,parent_id,hasattachedfile,attachedfileName,
					attachedfileextension,source,feedfrom,sectorid,industryid,symbol)
					VALUES(:STOCKBIZ_ID,:CREATED,:TITLE,:TAGLINE,:ALIAS,:INTROIMAGE,:INTRO,:CONTENT,:IS_CATEGORY,:IS_ENABLED,:IS_SHOWINTROIMAGE,:IS_TIEUDIEM,
					:IS_QUANTAM,:VIEW,:ORDERING,:PARENT_ID,:HASATTACH,:ATTACHFILE,:FILEEXT,:SOURCE,:FEEDFROM,:SECTORID,:INDUSTRYID,:SYMBOL)';
			$db->query('DELETE FROM _prefix_news WHERE news_id=' . $obj[ 'NewsID' ]);
			$db->prepare($sql);
			$db->bindValue( ':STOCKBIZ_ID', $obj[ 'NewsID' ], PARAM_INT );
			$date=date('Y-m-d H:m:s',strtotime($obj[ 'Date' ]));
			$db->bindValue( ':CREATED', $date, PARAM_STR );
			$db->bindValue( ':TITLE', $obj[ 'Title' ], PARAM_STR );
			$db->bindValue( ':TAGLINE', '', PARAM_STR );
			$db->bindValue( ':ALIAS', '', PARAM_STR );
			if ($obj['ImageUrl'] != ''){
				if (file_exists(_UPLOAD_IMG_ABSPATH_ . '/tin-tuc1/' . $obj['ImageUrl'] . '.jpg') || copy('http://stockbiz.vn/Handlers/GetThumbnail.axd?i='. $obj['ImageUrl'], _UPLOAD_IMG_ABSPATH_ . '/tin-tuc1/' . $obj['ImageUrl'] . '.jpg')){
					$db->bindValue( ':INTROIMAGE', '/upload/image/tin-tuc1/'. $obj['ImageUrl'] . '.jpg', PARAM_STR );
					$db->bindValue( ':IS_SHOWINTROIMAGE', 1, PARAM_INT );
				}else{
					$db->bindValue( ':INTROIMAGE', '', PARAM_STR );
					$db->bindValue( ':IS_SHOWINTROIMAGE', 0, PARAM_INT );
				}
			}else{
				$db->bindValue( ':INTROIMAGE', '', PARAM_STR );
				$db->bindValue( ':IS_SHOWINTROIMAGE', 0, PARAM_INT );
			}
			$db->bindValue( ':INTRO', $obj[ 'Description' ], PARAM_STR );
			$db->bindValue( ':CONTENT', $content, PARAM_STR );			
			$db->bindValue( ':IS_ENABLED', 1, PARAM_INT );
			
			$db->bindValue( ':IS_TIEUDIEM', 1, PARAM_INT );
			$db->bindValue( ':IS_QUANTAM', 0, PARAM_INT );
			$db->bindValue( ':VIEW', 0, PARAM_INT );
			$db->bindValue( ':ORDERING', 0, PARAM_INT );
			$db->bindValue( ':IS_CATEGORY', 0, PARAM_INT );
			$db->bindValue( ':SOURCE', $obj['Source'], PARAM_STR);
			//1 = StockBiz
			$db->bindValue( ':FEEDFROM', 1, PARAM_INT );
			
			if (isset($values['SectorId']))
				$db->bindValue( ':SECTORID', $values['SectorId'], PARAM_INT );
			else $db->bindValue( ':SECTORID', '', PARAM_INT );
			
			if (isset($values['IndustryId']))
				$db->bindValue( ':INDUSTRYID', $values['IndustryId'], PARAM_INT );
			else $db->bindValue( ':INDUSTRYID', '', PARAM_INT );
			
			if (isset($values['Symbol'])) $db->bindValue(':SYMBOL', $values['Symbol'], PARAM_STR);
			else $db->bindValue(':SYMBOL', '', PARAM_STR);
			
			$db->bindValue( ':PARENT_ID',getNewsParentId($obj['GroupID']), PARAM_INT );
			$obj['HasAttachedFile'] = (bool)$obj['HasAttachedFile'];
			$hasAttachedFile=0;
			if ($obj['HasAttachedFile'] && !empty($obj['AttachedFileName'])){
				if ( file_exists(_UPLOAD_FILE_ABSPATH_ . '/tin-tuc1/' . $obj[ 'AttachedFileName' ])
					|| copy('http://stockbiz.vn/Handlers/DownloadAttachedFile.ashx?NewsID='. $obj['NewsID'], _UPLOAD_FILE_ABSPATH_ . '/tin-tuc1/' . $obj[ 'AttachedFileName' ]))
					$hasAttachedFile=1;
			}
			$db->bindValue( ':HASATTACH', $hasAttachedFile, PARAM_INT );
			$db->bindValue( ':ATTACHFILE', $obj[ 'AttachedFileName' ], PARAM_STR );
			$db->bindValue( ':FILEEXT', $obj[ 'AttachedFileExtension' ], PARAM_STR );
			
			$db->execute();
		}
	}
}
?>
