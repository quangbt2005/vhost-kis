<?php
	require_once("includes2.php"); 
	require_once("php_speedy/php_speedy.php"); 
/*
	$trading = &new cTrading(1); // hcm: parameter = 1 
	$stock_list = $trading->get_hcm_stock_list(); 
	$size = sizeof($stock_list); 
	
	if (isset($_POST['sb']) && $_POST['sb'] !== "") {
		$pattern = ""; 
		for ($i = 0; $i<$size; $i++) {			
			if ( $_POST[$stock_list[$i]["stocksymbol"]] == "on") 
				$pattern .= "'" . $stock_list[$i]["stocksymbol"] . "',"; 
		}
		
		$_COOKIE['pattern'] = substr($pattern, 0, strlen($pattern)-1); ; 
	}

	$chks = explode(",", $_COOKIE['pattern']); 
	$size_chks = sizeof($chks); 
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bảng giá trực tuyến (HoSE)</title>
<link href="css/format_02.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="javascripts/prototype.js"></script>
<script type="text/javascript" src="javascripts/myAjax.js"></script>
</head>

<body>
<div id="pagewrap">
		<div id="top">
    	<h1>BẢNG GIÁ TRỰC TUYẾN (HoSE)</h1>
        <div id="session">Loading...</div>         
    </div>
    <br class="clear" />
    <div style="float: left; overflow: hidden; width: 20%;">
    	<h2>Chọn cổ phiếu để xem</h2>
    </div>
    <div style="float: left; overflow: hidden">
			<ul> 
      	<li style="display:inline; padding-right: 10px;"><a href="javascript: changeDiv('block');">Mở rộng</a></li>|
        <li style="display:inline; padding-left: 10px;"><a href="javascript: changeDiv('none');">Thu nhỏ</a></li>
      </ul>
    </div>
		<br class="clear" />
    <div id="stock_list" style="border: 1px solid #999999; padding: 10px;">
    <form name="frm01" method="post">
    <?php
      for ($i=0; $i<$size; $i++) {				
        $chk = "";  
        for ($j=0; $j<$size_chks; $j++) {
          if ($stock_list[$i]['stocksymbol'] == str_replace("'", "", $chks[$j])) {
            $chk = "checked"; 
            break; 
          }
        }
    ?>
      <div style="width: 76px; float: left; overflow: hidden;">
      <input type="checkbox" id="id<?php echo $i; ?>" name="<?php echo $stock_list[$i]['stocksymbol']; ?>" <?php echo $chk; ?>>
      &nbsp;<?php echo $stock_list[$i]["stocksymbol"]; ?>
      </div>
      
    <?php
      if (($i+1) % 15 == 0) 
        echo "<br class='clear'>"; 
      }
    ?>
      <br class="clear" />
      <input type="hidden" id="total" value="<?php echo $size; ?>" name="total">
      <input type="button" onClick="selectAll();" value="Chọn tất cả"> &nbsp;&nbsp;
      <input type="button" onClick="unselectAll();" value="Xóa tất cả"> &nbsp;&nbsp;
      <input type="submit" name="sb" value="Xem">
    </form>
    </div>
    <br class="clear" />
    <br class="clear" />
    <div id="security">Loading ...</div>
    <br class="clear"/>
    <div>
    	<h2>KẾT QUẢ GIAO DỊCH THỎA THUẬN</h2>
        <div id="bottom">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%" class="title">Khớp GDTT</td>
                <td width="90%">
                	<marquee direction="left" behavior="scroll" scrollamount="4">
                    	<div id="put_exec">Loading ...</div>
                    </marquee>
                </td>
              </tr>
            </table>
        </div>
        <br class="clear"/>
        <div id="putad">Loading ...</div>
    </div>
</div>
	<script>		
		Event.observe(window, "load", get_HOSE_HTML("<?php echo $_COOKIE['pattern']; ?>"));
  </script>  

</body>
</html>
<?php
	$compressor->finish();
?>