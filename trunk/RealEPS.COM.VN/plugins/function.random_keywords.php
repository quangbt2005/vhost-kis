<?php
function sinh_tu_khoa($string, $keyword = 'chung khoan,kis,eps,gia quyen,earnings per share'){
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
    $s = str_replace($marTViet,$marKoDau,$string);
    $arr = explode(" ", $s);
    $result = $keyword;
    for ($i=0; $i <count($arr); $i++){
        for ($j=$i+1; $j < count($arr) - 1; $j++)
        $result .= ',' . trim($arr[$i]) . ' ' . trim($arr[$j]);
        $result .= ',' . $keyword;
    }
    return $result;
}
function smarty_function_random_keywords($params, &$smarty) {    
    $data = $smarty->_tpl_vars['data']; 
    $mod = $params['mod'];    
    $page = $params['page'];
  
    switch ($mod){
        case 'news':
            switch($page){
                case 'detail':
                    return sinh_tu_khoa($data['item']['news_title']);
                case 'list':
                    return sinh_tu_khoa($data['category']);
                case 'search':
                    return sinh_tu_khoa($_GET['key']);
                default:
                    return 'chung khoan,kis,eps,gia quyền,gia quyen,chứng khoán,tin tuc,chung khoan,kis,eps,gia quyền,gia quyen,tin tức,chung khoan,kis,eps,gia quyền, chứng khoán, tin tuc chung khoan,chung khoan,tin tức chứng khoán,chung khoan,kis,eps,gia quyền';
            }
        break;
        case 'content':        	
        	if (!empty($data['meta_keywords'])) return $data['meta_keywords'];
            return $data['content_name'] . ' - ' . sinh_tu_khoa($data['content_name']);          
        break;
        case 'companydata':
        	return 'chung khoan,kis,eps,gia quyền,chứng khoán,dieu doanh nghiep, chung khoan,kis,eps,gia quyền, thong tin doanh nghiep, chung khoan,kis,eps,gia quyền,dữ liệu doanh nghiệp, chứng khoán,kis,eps,gia quyền, thong tin doanh nghiệp, chứng khoán, bao cao tai chinh, báo cáo tài chính, tai chinh, chung khoan,kis,eps,gia quyền, tài chính';  
        break;
        case 'securities':
            return 'chung khoan,kis,eps,gia quyền,chứng khoán,san chung khoan,kis,eps,gia quyền,san giao dich,chung khoan,kis,eps,gia quyền,co phieu tang,chứnng khoán,chung khoan,sàn giao dịc,co phieu giam,chung khoan,ma tang,earnings per share,mã tăng,ma giam,ma dung gia,mã đứng giá,chung khoan,chung khoan';
        break;       
        default:
            return 'chung khoan,kis,eps,gia quyền,earnings per share, co phieu, gia co phieu, tin chung khoan,earnings per share, thi truong chung khoan,kis,eps,gia quyền, chung khoan viet nam, chứng khoán, cổ phiếu, earnings per share,giá cổ phiếu, kis,eps,gia quyền,tin chứng khoán, thị trường chứng khoán, chứng khoán việt nam, dau tu, tai chinh, dau tu tai chinh'; 
    }
    
}
?>