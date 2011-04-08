<?php
function loai_bo_dau($cs){    
    $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
    "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
    ,"ế","ệ","ể","ễ",
    "ì","í","ị","ỉ","ĩ",
    "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
    ,"ờ","ớ","ợ","ở","ỡ",
    "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
    "ỳ","ý","ỵ","ỷ","ỹ",
    "đ",
    "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
    ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
    "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
    "Ì","Í","Ị","Ỉ","Ĩ",
    "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
    ,"Ờ","Ớ","Ợ","Ở","Ỡ",
    "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
    "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
    "Đ");
    
    $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
    ,"a","a","a","a","a","a",
    "e","e","e","e","e","e","e","e","e","e","e",
    "i","i","i","i","i",
    "o","o","o","o","o","o","o","o","o","o","o","o"
    ,"o","o","o","o","o",
    "u","u","u","u","u","u","u","u","u","u","u",
    "y","y","y","y","y",
    "d",
    "A","A","A","A","A","A","A","A","A","A","A","A"
    ,"A","A","A","A","A",
    "E","E","E","E","E","E","E","E","E","E","E",
    "I","I","I","I","I",
    "O","O","O","O","O","O","O","O","O","O","O","O"
    ,"O","O","O","O","O",
    "U","U","U","U","U","U","U","U","U","U","U",
    "Y","Y","Y","Y","Y",
    "D");
    return str_replace($marTViet,$marKoDau,$cs);
}
function smarty_function_random_title($params, &$smarty) {
    $data = $smarty->_tpl_vars['data']; 
    $mod = $params['mod'];    
    $page = $params['page'];
    switch ($mod){
        case 'news':
	     $str_page = '';
            if (!empty($_GET['p']))  $str_page = '- Trang ' . $_GET['p'];
            switch($page){
                case 'detail':
			return $data['item']['news_title'] . ' - ' . loai_bo_dau($data['item']['news_title']) . $str_page;
                case 'list':		      
                    return $data['category'] . ' - ' . loai_bo_dau($data['category']) . $str_page;
                case 'search':
                    return $_GET['key'] . ' - ' . loai_bo_dau($_GET['key']) . $str_page;
                default:
                    return 'Tin tuc tai chinh chung khoan hang dau Viet Nam';
            }
        break;
        case 'content':
        	if (!empty($data['meta_title'])) return $data['meta_title'];
            return $data['content_name'] . ' - ' . loai_bo_dau($data['content_name']);          
        break;
        case 'companydata':
        	return 'Dữ liệu doanh nghiệp - Du lieu doah nghiep - Tai chinh chung khoan';  
        break;
        case 'securities':
            return 'Thống kê thị trường chứng khoán - Thong ke thi truong chung khoan';
        break;
        case 'contact':
            return 'Liên hệ - Lien he';
        break;
        default:
            return 'KIS Vietnam Securities Corporation'; 
    }
    
}
?>