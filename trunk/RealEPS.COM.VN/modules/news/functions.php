<?php
function BuildCategoryTree(){
	$result = array();
	$db = _db();
	$db->query( 'SELECT news_id, news_title, parent_id FROM _prefix_news WHERE is_category=1' );
	if ( $objs = $db->fetchAll() ){
		$Tree = array();
		$List = $objs;
		$ID_List = array();

		for($i=0;$i<count($List);$i++){
			$Tree[$List[$i]['news_id']] = &$List[$i];
			$ID_List[] = $List[$i]['news_id'];
		}

		for($i=0;$i<count($ID_List);$i++){
			$id = $ID_List[$i];
			$parent_of_id = $Tree[$id]['parent_id'];
			if(!empty($parent_of_id)){
				$Tree[$parent_of_id]['childs'][] = &$Tree[$id];
			}
		}

		for($i=0;$i<count($ID_List);$i++){
			$id = $ID_List[$i];
			$parent_of_id = $Tree[$id]['parent_id'];
			if(!empty($parent_of_id)){
			  unset($Tree[$id]);
			}
		}

		reset($Tree);
		$pointer = $Tree;
		$stack   = array();
		$dau_tru = '';

		while(!empty($pointer)){
			if(is_array($pointer)){
				$break = false;
				do{
					$cat = current($pointer);

					if(!empty($cat)){
						$result[$cat['news_id']] = sprintf("%s %s", $dau_tru, $cat['news_title']);
						if(isset($cat['childs'])){
							if(next($pointer)) $stack[] = $pointer; else $stack[] = 'nothing';
							$stack[] = $cat['childs'];
							$dau_tru .= '- ';
							$break = true;
							break;
						}
					}
				} while (next($pointer));
				if(!(current($pointer)) && !$break){
					$dau_tru = substr ( $dau_tru , 0, -2 );
				};
				$pointer = array_pop($stack);
			} else {
				$dau_tru = substr ( $dau_tru , 0, -2 );
				$pointer = array_pop($stack);
			}
		}
	}
	return $result;
}
function BuildCategoryTree(){
	$db = _db();
	$db->query( 'SELECT news_id, news_title, parent_id FROM _prefix_news WHERE is_category=1' );
	if ( $objs = $db->fetchAll() ){
		$Tree = array();
	  $List = $objs;
	  $ID_List = array();

	  for($i=0;$i<count($List);$i++){
		$Tree[$List[$i]['news_id']] = &$List[$i];
		$ID_List[] = $List[$i]['news_id'];
	  }

	  for($i=0;$i<count($ID_List);$i++){
		$id = $ID_List[$i];
		$parent_of_id = $Tree[$id]['parent_id'];
		if(!empty($parent_of_id)){
		  $Tree[$parent_of_id]['childs'][] = &$Tree[$id];
		}
	  }

	  for($i=0;$i<count($ID_List);$i++){
		$id = $ID_List[$i];
		$parent_of_id = $Tree[$id]['parent_id'];
		if(!empty($parent_of_id)){
		  unset($Tree[$id]);
		}
	  }

	  reset($Tree);
	  $pointer = $Tree;
	  $stack   = array();
	  $dau_tru = '';
	  $html = "<ul>\n";
	  $texe = array();

	  while(!empty($pointer)){
		if(is_array($pointer)){
		  $break = false;
		  do{
			$cat = current($pointer);

			if(!empty($cat)){
			  $html .= sprintf("<li data=\"key: '%s'\" class=\"folder\">%s\n", $cat['news_id'], $cat['news_title']);
			  $texe[$cat['news_id']] = sprintf("%s %s", $dau_tru, $cat['news_title']);
			  if(isset($cat['childs'])){
				if(next($pointer)) $stack[] = $pointer; else $stack[] = '</ul>';
				$stack[] = $cat['childs'];
				$html .= "<ul>\n";
				$dau_tru .= '-';
				$break = true;
				break;
			  }
			}
		  } while (next($pointer));
		  if(!(current($pointer)) && !$break){
			$html .= "</ul>\n";
			$dau_tru = substr ( $dau_tru , 0, -1 );
			};
		  $pointer = array_pop($stack);
		} else {
		  $html .= "</ul>\n";
		  $dau_tru = substr ( $dau_tru , 0, -1 );
		  $pointer = array_pop($stack);
		}
	  }
echo '<pre>';
print_r($texe);
echo '</pre>';
	  return $html;
	}
}

function getCategoryList2Level( &$cats, &$subcats, $pid ){
	$db = _db();
	$db->query( 'SELECT news_id, news_title FROM _prefix_news WHERE is_enabled=1 AND is_category=1 AND parent_id=' . $pid . ' ORDER BY ordering DESC, news_id DESC' );	
	if ( $objs = $db->fetchAll() ){
		foreach( $objs as $obj ){
			$cats[ $obj[ 'news_id' ] ] = $obj[ 'news_title' ];			
			$db->query( 'SELECT news_id, news_title FROM _prefix_news WHERE is_enabled=1 AND is_category=1 AND parent_id=' . $obj['news_id'] . ' ORDER BY ordering DESC, news_id DESC' );		
			if ($subobjs = $db->fetchAll()){
				foreach ($subobjs as $subobj)
					$subcats[$obj['news_id']][$subobj['news_id']] = 	$subobj[ 'news_title' ];
			}
				
		}
	}
}
function getNewsCat( &$data ){
	$db = _db();
	$db->query("SELECT news_id, news_title FROM _prefix_news WHERE news_alias='THONGTIN_TT'");		
	if ($obj = $db->fetch()){
		getCategoryList2Level($cats, $subcats, $obj['news_id']);
		$data['cat'] = $obj['news_title'];
		$data['cats'] = $cats;		
		$data['subcats'] = $subcats;
		//Lay cac tin cua cat 1				
	}
}
function updateView($id){
	$db = _db();
	$db->prepare('UPDATE _prefix_news SET view=view+1 WHERE news_id=:ID');
	$db->bindValue( ':ID' , $id, PARAM_INT );
	$db->execute();
}
function belongToEPS($parent_id){
    $db = _db();    
	$db->query( 'SELECT parent_id, news_alias FROM _prefix_news WHERE is_category=1 AND news_id=' . $parent_id );
	if ( $obj = $db->fetch() ){
		if ($obj['news_alias'] == 'TINEPS') return true;
		return belongToEPS($obj['parent_id']);
	}
	return false;
}
?>