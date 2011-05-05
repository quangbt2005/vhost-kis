<?php	
	function get_otc() {
		$otc = &new OTC(); 
		$result = $otc->list_otc(); 

		return $result; 		
	}
	
	function display_otc() {
	
	}
	
	function get_hcm_put_exec($trading) {
		$data = $trading->get_hcm_put_exec(); 
		$data = my_format_array_number($_SESSION["language"], $data); 
		
		$html = ""; 
		for ($i=0; $i<count($data); $i++) {
			$html .= ($i+1) . ". " . $data[$i]["symbol"] . "<span>Giá: " . $data[$i]["price"] . " KL: " . $data[$i]["vol"] . "</span>"; 
		}

		return $html; 
	}
	
	function get_hcm_put_ad($trading) {	
		$data = $trading->get_hcm_put_ad(); 
		$data = my_format_array_number($_SESSION["language"], $data); 

		$html = "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
    $html .= "<tr>"; 		

		$end = count($data)/3; 
		
		for ($i=0; $i<3; $i++) {		
			$html .= "<td>"; 
			$html .= "<div id='bottom'>"; 
			$html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
			$html .= "<thead>";
			$html .= "<tr>"; 
			$html .= "<th width='23%'>Mua/Bán</th>";
			$html .= "<th width='26%'>Mã CK</th>";
			$html .= "<th width='24%'>Giá</th>";
			$html .= "<th width='27%'>Khối lượng</th>";
			$html .= "</tr>";
			$html .= "</thead>";
			$html .= "<tbody>";		

			for ($j=0; $j<$end; $j++) {
				if ($data[$j*3+$i]["side"] == "B")
					$data[$j*3+$i]["side"] = "Mua"; 					
				elseif ($data[$j*3+$i]["side"] == "S")
					$data[$j*3+$i]["side"] = "Bán"; 
				else
					$data[$j*3+$i]["side"] = "&nbsp;"; 
					
				if ($data[$j*3+$i]["symbol"] == "") {
					$data[$j*3+$i]["symbol"] = "&nbsp;"; 
				}
				if ($data[$j*3+$i]["price"] == "") {
					$data[$j*3+$i]["price"] = "&nbsp;"; 
				}
				if ($data[$j*3+$i]["vol"] == "") {
					$data[$j*3+$i]["vol"] = "&nbsp;"; 
				}
				if ($data[$j*3+$i]["side"] == "") {
					$data[$j*3+$i]["side"] = "&nbsp;"; 
				}
				$class = (($j+3) % 2 == 0) ? "" : "special"; 
				$html .= "<tr class='" . $class . "'>";
				$html .= "<td>" . $data[$j*3+$i]["side"] . "</td>";
				$html .= "<td>" . $data[$j*3+$i]["symbol"] . "</td>";
				$html .= "<td>" . $data[$j*3+$i]["price"] . "</td>";
				$html .= "<td>" . $data[$j*3+$i]["vol"] . "</td>";
				$html .= "</tr>";
			}	
			$html .= "</tbody>";
			$html .= "</table>";

			$html .= "</div>"; 
			$html .= "</td>"; 			
			if ($i !=2)
				$html .= "<td width='10px'></td>"; 
		}
		$html .= "</tr>"; 
		$html .= "</table>"; 
		return $html; 
	}
	
	function get_hcm_trading_time($trading) {
		$trading_time = $trading->get_hcm_trading_time(); 

		$trading_time["date"] = resign_date_value( $trading_time["date"] ); 
		$html = "<ul>"; 
		$html .= "<li class='day'>" . $trading_time["date"] . "</li>"; 
		$html .= "<li class='time'>" . $trading_time["time"] . "</li>"; 
		$html .= "</ul>"; 
		
		return $html; 		
	}
	
	function get_hcm_session($trading) {
		$session = $trading->get_hcm_trading_session(); 
			
		switch($session) {
			case "0": 
				$market_title = "GD chưa bắt đầu";
				break; 
			case "1": 
				$market_title = "Xác định giá mở cửa";
				break; 
			case "2": 
				$market_title = "GD liên tục";
				break; 
			case "3": 
				$market_title = "Xác định giá đóng cửa";
				break; 
			case "4": 
				$market_title = "GD thỏa thuận";
				break; 
			case "5": 
			default:
				$market_title = "GD kết thúc";
				break;
		}	

		$html = get_hcm_trading_time($trading);
    $html .= "<ul id='list'>"; 
    $html .= "<li>Trạng Thái Thị Trường: <span>" . $market_title . "</span></li>";
		$html .= "</ul>";          				

		return $html; 

		return $market_title; 
	}
	
	function get_hcm_total_market($trading) {
		$total_market = $trading->get_hcm_total_market(); 		
		
		$class = ($total_market["vnindexchanges"] >= 0) ? "up" : "down"; 
		
		$total_market = my_format_array_number($_SESSION["language"], $total_market); 
		
    $html .= "<div id='box'><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>"; 
    $html .= "<td width='35%' align='left'><img src='images/icon.gif' /> Index: <span class='" . $class . "'>" 
							. $total_market["vnindex"] . "</span>&nbsp;&nbsp;&nbsp;<span class='" . $class . "'>" 
							. $total_market["vnindexchanges"] . " <img src='images/" . $class . ".gif' /> " . $total_market["percentchanges"] . "%</span></td>"; 
    $html .= "<td width='25%'><img src='images/icon.gif' /> KLGD: <span>" 
							. $total_market["totalshares"] . "</span></td>"; 
    $html .= "<td width='40%' class='right'><img src='images/icon.gif' /> GTGD: <span>" 
							. $total_market["totalvalues"] . "</span></td>"; 
    $html .= "</tr></table></div>"; 
		
		return $html; 
	}
	
	function get_hcm_security($trading, $pattern) {		
		$orign_data = $trading->get_hcm_security(str_replace("\\", "", $pattern)); 	
		$data = my_format_array_number($_SESSION["language"], $orign_data); 
		
		$session = $trading->get_hcm_trading_session();

		$html = get_hcm_security_header(); 
		
		$html .= display_hcm_security($session, $orign_data, $data);
		$_SESSION["data"] = $data; 

		$html_footer = get_hcm_security_footer(); 						
		$html .= $html_footer;

		return $html; 
	}

	function display_hcm_security($session, $orign_data, $data) {
		$size = sizeof($data); 
		for ($i=0; $i<$size; $i++) {			
			$tr_class = ($i%2==0) ? "" : "special"; 			
			$other_class = ($i%2==0) ? "other" : "other_special"; 			
			
			$class = get_css_class($data[$i]["change"]); 

			// ATO || ATC 
			$special_price = ($session >=3) ? "ATC" : "ATO";
				
			// get highlight

			if (!empty($_SESSION["data"][$i]))
				$highlight = get_highlight($data[$i], $_SESSION["data"][$i]); 

			// get notice for symbol
			$notice = $data[$i]["securityname"]; 
			
			$class_symbol = ""; 			
			if ($data[$i]["splitstock"] != " " && $data[$i]["splitstock"] != " ") {
				$class_symbol = "bgcolor='#744e21'"; 			
				$notice .= "" . " - Thực hiện tách cổ phiếu";
			}
			if ($data[$i]["benefit"] == "A") {
				$class_symbol = "bgcolor='#744e21'"; 			
				$notice .= "" . " - Phát hành thêm cổ phiếu";
			}
			elseif ($data[$i]["benefit"] == "D") {
				$class_symbol = "bgcolor='#744e21'"; 			
				$notice .= "" . " - Giao dịch không hưởng cổ tức";			
			}
			elseif ($data[$i]["benefit"] == "R") {
				$class_symbol = "bgcolor='#744e21'"; 			
				$notice .= "" . " - Giao dịch không hưởng quyền";			
			}
			else {
				$class_symbol = ""; 			
				$notice .= ""; 
			}
			
			
			$html .= "<tr class='" . $tr_class . "'>"; 
      $html .= "<td class='order'>" . ($i+1) . "</td>"; 

      $html .= "<td " . $class_symbol . " style='text-align: left;'><a href='' title='" . $notice . "'>" 
						. substr($data[$i]["stocksymbol"], 0, 3) . "</a></td>";

      $html .= "<td>" . $data[$i]["priorcloseprice"] . "</td>"; 

			// ======= Best Bid =======
			if ($orign_data[$i]["best2bid"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best2bid"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";

      $html .= "<td class='" . $highlight["best2bid"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2bid"], $orign_data[$i]["priorcloseprice"]) 
								. "' style=\"color: " . $color . ";\">" . $data[$i]["best2bid"] . "</span></td>"; 								
      $html .= "<td class='" . $highlight["best2bidvolume"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2bid"], $orign_data[$i]["priorcloseprice"]) 
								. "' style=\"color: " . $color . ";\">" . $data[$i]["best2bidvolume"] . "</td>"; 

			if ($orign_data[$i]["best1bid"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best1bid"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";

			if ($data[$i]["best1bid"] == "&nbsp;" && $data[$i]["best1bidvolume"] != "&nbsp;") {
				$html .= "<td class='" . $highlight["best1bid"]  . "'><span class='" . get_class_change(1, 0) 
									. "' style=\"color: " . $color . ";\">" . $special_price . "</span></td>"; 											
				$html .= "<td class='" . $highlight["best1bidvolume"]  . "' style='border-right:2px solid #9aa3ba;'><span class='" 
									. get_class_change(1, 0) . "' style=\"color: " . $color . ";\">" . $data[$i]["best1bidvolume"] . "</td>"; 
			}
			else {
				$html .= "<td class='" . $highlight["best1bid"]  . "'><span class='" .  
									get_class_change($orign_data[$i]["best1bid"], $orign_data[$i]["priorcloseprice"]) 
									. "' style=\"color: " . $color . ";\">" . $data[$i]["best1bid"] . "</span></td>"; 								
				$html .= "<td class='" . $highlight["best1bidvolume"]  . "' style='border-right:2px solid #9aa3ba;'><span class='" .  
									get_class_change($orign_data[$i]["best1bid"], $orign_data[$i]["priorcloseprice"]) 
									. "' style=\"color: " . $color . ";\">" . $data[$i]["best1bidvolume"] . "</td>"; 
			}

			// ======= Change =======			
			if ($highlight["last_price"] == "")
				$highlight["last_price"] = $other_class; 
			if ($highlight["last_change"] == "") 
				$highlight["last_change"] = $other_class; 
			if ($highlight["last_volume"] == "") 
				$highlight["last_volume"] = $other_class; 
			
			if ($orign_data[$i]["last_price"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["last_price"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";
						
      $html .= "<td class='" . $highlight["last_price"]  . "'><span class='" . 
								$class["change"] . "' style=\"color: " . $color . ";\">" . $data[$i]["last_price"] . "</td>"; 
      $html .= "<td class='" . $highlight["last_change"]  . "'><span class='" . 
								$class["fit"] . "' style=\"color: " . $color . ";\">" . $data[$i]["last_change"] . "</td>"; 
      $html .= "<td class='" . $highlight["last_volume"]  . "' style='border-right:2px solid #9aa3ba;'><span class='" . 
								$class["change"] . "' style=\"color: " . $color . ";\">"  . $data[$i]["last_volume"] . "</td>"; 

			// ======= Best Offer =======
			if ($orign_data[$i]["best1offer"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best1offer"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";
						
			if ($data[$i]["best1offer"] == "&nbsp;" && $data[$i]["best1offervolume"] != "&nbsp;") {
				$html .= "<td class='" . $highlight["best1offer"] . "'><span class='" .  
									get_class_change(1, 2) . "' style=\"color: " . $color . ";\">" . $special_price . "</span></td>"; 											
				$html .= "<td class='" . $highlight["best1offervolume"]  . "'><span class='" .  
									get_class_change(1, 2) . "' style=\"color: " . $color . ";\">" . $data[$i]["best1offervolume"] . "</td>"; 
			}
			else {
				$html .= "<td class='" . $highlight["best1offer"]  . "'><span class='" .  
									get_class_change($orign_data[$i]["best1offer"], $orign_data[$i]["priorcloseprice"]) 
									. "' style=\"color: " . $color . ";\">"	. $data[$i]["best1offer"] . "</span></td>"; 								
				$html .= "<td class='" . $highlight["best1offervolume"]  . "'><span class='" .  
									get_class_change($orign_data[$i]["best1offer"], $orign_data[$i]["priorcloseprice"]) 
									. "' style=\"color: " . $color . ";\">" . $data[$i]["best1offervolume"] . "</td>"; 
			}

			if ($orign_data[$i]["best2offer"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best2offer"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";

      $html .= "<td class='" . $highlight["best2offer"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2offer"], $orign_data[$i]["priorcloseprice"]) 
								. "' style=\"color: " . $color . ";\">"	. $data[$i]["best2offer"] . "</span></td>"; 								
      $html .= "<td class='" . $highlight["best2offervolume"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2offer"], $orign_data[$i]["priorcloseprice"]) 
								. "' style=\"color: " . $color . ";\">"	. $data[$i]["best2offervolume"] . "</td>"; 
			$html .= "<td>" . $data[$i]["fbuy"] . "</td>";
/*
      $html .= "<td class='" . $highlight["currentroom"]  . "'>" 
								. $data[$i]["currentroom"] . "</span></td>"; 				
*/
			$html .= "<tr>"; 
 		}

		return $html;	
	}

	function get_hcm_security_header() {
		$header = "<div id='content'>"; 
		$header .=	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
		$header .=	"<thead style=\"height: 80px;\"><tr>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='1%' rowspan='2'>STT</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>Mã CK</th>"; 

		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>TC</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" colspan='4'>Mua</th>";

		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>Giá<br>khớp</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>Thay<br>đổi</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='6%' rowspan='2'>KL khớp</th>";
		 
		$header .=	"<th colspan='4' style='border: 0px; color: #00040f;'>Bán</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\">Nước Ngoài</th>"; 
		$header .=	"</tr>"; 
		$header .=	"<tr>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 2</td>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 2</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 1</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 1</th>";

		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 1</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 1</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 2</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 2</th>";

		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Mua</th>";
		$header .=	"</tr>";
		$header .=	"</thead>";
		$header .=	"<tbody>";

		return $header; 	
	}

	function get_hcm_security_footer() {
		$footer = "</div>"; 
    $footer .= "</tbody>";
    $footer .= "</table>"; 
		
		return $footer; 
	}	
	
	function get_hn_total_market($trading) {
		$total_market = $trading->get_hn_total_market(); 		

		$class = ($total_market["chgindex"] >= 0) ? "up" : "down"; 
		$total_market = my_format_array_number($_SESSION["language"], $total_market); 
		
    $html = "<div id='box'>";
    $html .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>"; 
		$html .= "<tr>"; 
    $html .= "<td width='35%' align='left'><img src='images/icon.gif'> Index: <span class='" . $class . "'>" 
							. $total_market["marketindex"] . "</span>&nbsp;&nbsp;<span class='" . $class . "'>" 
							. $total_market["chgindex"] . " <img src='images/" . $class . ".gif'> " . $total_market["pctindex"] . "%</span></td>"; 
    $html .= "<td width='25%'><img src='images/icon.gif'> KLGD: <span>" 
							. $total_market["totalquantity"] . "</span></td>"; 
    $html .= "<td width='40%' class='right'><img src='images/icon.gif'> TKLGD: <span>" 
							. $total_market["totalvalue"] . "</span></td>"; 
    $html .= "</tr>"; 
    $html .= "</table>"; 
    $html .= "</div>"; 
    $html .= "<br class='clear' />"; 

		return $html; 
	}
				

	function get_hn_session($trading) {			
		$current_time = strtotime(date("H:i:s")); 
		
		if ($current_time > strtotime("08:30:00") && $current_time < strtotime("11:01:00"))
			$market_title = "Thị trường mở cửa"; 	
		else 
			$market_title = "Thị trường đóng cửa"; 		
		
		$html = get_hcm_trading_time($trading);
    $html .= "<ul id='list'>"; 
    $html .= "<li>Trạng Thái Thị Trường: <span>" . $market_title . "</span></li></ul>";
          				
		return $html; 
	}
	
	function get_hn_security($trading, $pattern) {
		$orign_data = $trading->get_hn_security(str_replace("\\", "", $pattern)); 	
		$data = my_format_array_number($_SESSION["language"], $orign_data); 
		
		$total_market = get_hn_total_market($trading); 		

		$html = get_hn_security_header(); 
		$html .= display_hn_security($orign_data, $data);

		$_SESSION["data_hn"] = $data; 
		$html_footer = get_hn_security_footer(); 		
		$html .= $html_footer;

		return $html; 		
	}

	function display_hn_security($orign_data, $data) {			
		$size = sizeof($data); 
		for ($i=0; $i<$size; $i++) {
			$tr_class = ($i%2==0) ? "" : "special"; 			
			$class = get_css_class($data[$i]["change"]); 

			// get highlight
			if (!empty($_SESSION["data_hn"][$i]))
				$highlight = get_highlight($data[$i], $_SESSION["data_hn"][$i]); 
			
			$html .= "<tr class='" . $tr_class . "'>"; 
      $html .= "<td class='order'>" . ($i+1) . "</td>"; 
      $html .= "<td style=\"text-align: left;\">"	. $data[$i]["stocksymbol"] . "</td>"; 
      $html .= "<td>" . $data[$i]["priorcloseprice"] . "</td>"; 
			
			// ======= Best Bid =======
			if ($orign_data[$i]["best2bid"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best2bid"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";
      $html .= "<td class='" . $highlight["best2bid"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2bid"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">"
								. $data[$i]["best2bid"] . "</span></td>"; 								
      $html .= "<td class='" . $highlight["best2bidvolume"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2bid"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">" 
								. $data[$i]["best2bidvolume"] . "</td>"; 

			if ($orign_data[$i]["best1bid"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best1bid"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";
			$html .= "<td class='" . $highlight["best1bid"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best1bid"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">" 
								. $data[$i]["best1bid"] . "</span></td>"; 								
      $html .= "<td class='" . $highlight["best1bidvolume"]  . "' style='border-right:2px solid #9aa3ba;'><span class='" .  
								get_class_change($orign_data[$i]["best1bid"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">" 
								. $data[$i]["best1bidvolume"] . "</td>"; 

			if ($orign_data[$i]["last_price"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["last_price"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";

			// ======= Change =======
      $html .= "<td class='" . $highlight["last_price"]  . "'><span class='" . 
								$class["change"] . "' style=\"color: " . $color . ";\">" . $data[$i]["last_price"] . "</td>"; 
      $html .= "<td class='" . $highlight["last_change"]  . "'>" . $more_change . "<span class='" . 
								$class["fit"] . "' style=\"color: " . $color . ";\">" . $data[$i]["last_change"] . "</td>"; 
      $html .= "<td class='" . $highlight["totaltradingquantity"]  . "' style='border-right:2px solid #9aa3ba;'><span class='" . 
								$class["change"] . "' style=\"color: " . $color . ";\">" . $data[$i]["totaltradingquantity"] . "</td>"; 

			// ======= Best Offer =======
			if ($orign_data[$i]["best1offer"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best1offer"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";
			$html .= "<td class='" . $highlight["best1offer"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best1offer"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">" 
								. $data[$i]["best1offer"] . "</span></td>"; 								
      $html .= "<td class='" . $highlight["best1offervolume"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best1offer"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">" 
								. $data[$i]["best1offervolume"] . "</td>"; 

			if ($orign_data[$i]["best2offer"] == $orign_data[$i]["ceiling"]) 
				$color = "#990066"; 
			else if ($orign_data[$i]["best2offer"] == $orign_data[$i]["floor"]) 
				$color = "#66ccff"; 
			else
				$color = "";
      $html .= "<td class='" . $highlight["best2offer"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2offer"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">" 
								. $data[$i]["best2offer"] . "</span></td>"; 								
      $html .= "<td class='" . $highlight["best2offervolume"]  . "'><span class='" .  
								get_class_change($orign_data[$i]["best2offer"], $data[$i]["priorcloseprice"]) . "' style=\"color: " . $color . ";\">" 
								. $data[$i]["best2offervolume"] . "</td>"; 

      $html .= "<td>" . $data[$i]["fbuy"] . "</td>"; 
      $html .= "<td>" . $data[$i]["fsell"] . "</td>"; 
      $html .= "</tr>"; 
		}
		return $html;	
	}
		
	function get_hn_security_header() {
		$header = "<div id='content'>"; 
		$header .=	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
		$header .=	"<thead style=\"height: 60px;\">"; 
		$header .=	"<tr>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='1%' rowspan='2'>STT</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>CK</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>TC</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" colspan='4'>Mua</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>GK</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%' rowspan='2'>Thay đổi</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='7%' rowspan='2'>TKL<br>khớp</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" colspan='4' style='border-right:2px solid #9aa3ba;'>Bán</th>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" colspan='2'>Nước Ngoài</th>"; 
		$header .=	"</tr>"; 
		$header .=	"<tr>"; 
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 2</td>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 2</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 1</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 1</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 1</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 1</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Giá 2</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>KL 2</th>";

		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Mua</th>";
		$header .=	"<th style=\"border: 0px; color: #00040f;\" width='5%'>Bán</th>";
		$header .=	"</tr>";
		$header .=	"</thead>";
		$header .=	"<tbody>";
				
		return $header; 	
	}

	function get_hn_security_footer() {
		$footer = "</div>"; 
    $footer .= "</tbody>";
    $footer .= "</table>"; 
		
		return $footer; 
	}	

	function get_css_class($change) {
		$class = array(); 
		if ($change > 0) {
			$class["change"] = "price-up"; 			
			$class["icon"] = "icon-up"; 
			$class["fit"] = "fit-up"; 
		}			
		elseif ($change < 0) {
			$class["change"] = "price-down"; 			
			$class["icon"] = "icon-down"; 
			$class["fit"] = "fit-down"; 
		}						
		else {
			$class["change"] = "price-equal"; 			
			$class["icon"] = "icon-equal"; 
			$class["fit"] = "fit-equal"; 
		}	
		return $class; 
	}
	
	function get_class_change($obj, $obj1) {
		if ($obj > $obj1) 	
			return "price-up"; 
		elseif ($obj < $obj1)
			return "price-down"; 
		else 
			return "price-equal"; 
	}
	
	function get_highlight($value, $old_value) {		
		foreach($value as $k => $v) {
			if ($v != "" && $v != $old_value[$k]) 
				$highlight[$k] = "highlight";				
			else 
				$highlight[$k] = "";				

		}
		
		return $highlight; 
	}
		
?>
