<?php
	require_once("includes2.php"); 
	require_once("php_speedy/php_speedy.php"); 

	$trading = &new cTrading(1); // hcm: parameter = 1 

	$conbano = get_hcm_security($trading);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bảng giá trực tuyến (HoSE)</title>
<link href="css/format_03.css" rel="stylesheet" type="text/css">
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
  <div id="total_market">Loading...</div>
	<br class="clear" />
		<div id='content'> 
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<thead><tr> 
		<th width='1%' rowspan='2'>STT</th> 
		<th width='6%' rowspan='2'>Mã CK</th> 

		<th colspan='6' style='border-right:2px solid #9aa3ba;'>Giá</th>
		<th colspan='6' style='border-right:2px solid #9aa3ba;'>Mua</th>

		<th width='5%' rowspan='2'>Giá<br>khớp</th>
		<th width='7%' rowspan='2'>Thay<br>đổi</th>
		<th width='5%' rowspan='2' style='border-right:2px solid #9aa3ba;'>KL khớp</th>
		 
		<th colspan='6' style='border-right:2px solid #9aa3ba;'>Bán</th> 

		<th colspan='2'>Nước Ngoài</th> 
		</tr> 
		<tr> 
		<th width='3%'>Tham chiếu</th> 
		<th width='3%'>Trần</th> 
		<th width='3%'>Sàn</th>
		<th width='3%'>Mở cửa</th>
		<th width='3%'>Cao nhất</th>
		<th width='3%' style='border-right:2px solid #9aa3ba;'>Thấp nhất</th>

		<th width='3%'>Giá 3</th>
		<th width='4%'>KL 3</th>
		<th width='3%'>Giá 2</td>
		<th width='4%'>KL 2</th>
		<th width='3%'>Giá 1</th>
		<th width='4%' style='border-right:2px solid #9aa3ba;'>KL 1</th>

		<th width='3%'>Giá 1</th>
		<th width='4%'>KL 1</th>
		<th width='3%'>Giá 2</th>
		<th width='4%'>KL 2</th>
		<th width='3%'>Giá 3</th>
		<th width='4%' style='border-right:2px solid #9aa3ba;'>KL 3</th>

		<th width='5%'>Mua</th>
		<th width='6%'>Room</th>
		</tr>
		</thead>
    </table>
		<script type="text/javascript">
    /******************************************
    * Scrollable content script II- © Dynamic Drive (www.dynamicdrive.com)
    * Visit http://www.dynamicdrive.com/ for full source code
    * This notice must stay intact for use
    ******************************************/
    
    iens6=document.all||document.getElementById
    ns4=document.layers
    
    //specify speed of scroll (greater=faster)
    var speed=1
    if (iens6){
    document.write('<div id="container" style="position:relative;width: 100%;height:850px;overflow:hidden">')
    document.write('<div id="content1" style="position:absolute;width: 100%;left:0;top:0">')
    }
    </script>
    
    <ilayer name="nscontainer" width="100%" height=800>
    <layer name="nscontent1" width="100%" height=800 visibility=hidden>		
        <div id="security"><?php echo $conbano; ?></div>
    </layer>
    </ilayer>
    
    <script language="JavaScript1.2">
    if (iens6)
    document.write('</div></div>')
    </script>
    
    <script language="JavaScript1.2">
    if (iens6){
      var crossobj=document.getElementById? document.getElementById("content1") : document.all.content1
      var contentheight=crossobj.offsetHeight
    }
    else if (ns4){
      var crossobj=document.nscontainer.document.nscontent1
      var contentheight=crossobj.clip.height
    }
    
    function movedown2() {
      if (iens6) {
        if (parseInt(crossobj.style.top) >= (contentheight*(-1) + 600)) 
          crossobj.style.top = parseInt(crossobj.style.top)-speed+"px"; 
        else {
          crossobj.style.top = -1+"px"; 
        }				
      }
      else if (ns4) {
        if (crossobj.top >= (contentheight*(-1)+600))
          crossobj.top -=speed
        else 
          crossobj.top = contentheight*(-1)				
      }
      movedownvar=setTimeout("movedown2()", 30); 
    }
    
    function getcontent_height(){
      if (iens6)
        contentheight=crossobj.offsetHeight
      else if (ns4)
        document.nscontainer.document.nscontent.visibility="show"
    }
    </script>
	<br class="clear"/>
</div> <!-- end div wrapper -->
<script>		
	Event.observe(window, "load", get_HOSE_HTML2("<?php echo $_COOKIE['pattern']; ?>"));
	window.onload=getcontent_height
	movedown2();
</script>  
</body>
</html>
<?php
	$compressor->finish();
?>
