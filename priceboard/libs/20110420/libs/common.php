<?php
	/**
	 * Purpose:   
	 * Function name: GetPageInfo
	 * Parameters:
	 */
	function GetPageInfo($PageID, $Language)
	{
		$_Result = array("CAPTIONS" => array());

		// Read XML language file
		$_LanguageFile = $_SERVER["DOCUMENT_ROOT"] . "/languages/" . $Language . ".xml";
		if (file_exists($_LanguageFile))
		{
			$_XML = new XML_Unserializer(array("complexType" => "array", "parseAttributes" => TRUE));
			$_XML->unserialize($_LanguageFile, TRUE);
			$_Data = $_XML->getUnserializedData();
			$_Pages = $_Data["pages"];

			// Get page data
			$_Page = array();
			if (!is_array($_Pages["page"][0]))
			{
				if ($_Pages["page"]["name"] == $PageID)
					$_Page = $_Pages["page"];
			}
			else
			{
				$i = 0;
				$_Length = count($_Pages["page"]);
				while (($_Pages["page"][$i]["name"] != $PageID) && ($i < $_Length))
					$i++;
				if ($i < $_Length)
					$_Page = $_Pages["page"][$i];
			}
			
			// Get title data
			$_Result["TITLE"] = $_Page["title"];

			// Get caption data
			$_Captions = $_Page["captions"];
			if (!is_array($_Captions["caption"][0]))
				$_Result["CAPTIONS"][$_Captions["caption"]["name"]] = $_Captions["caption"]["value"];
			else
			{
				for ($i = 0; $i < count($_Captions["caption"]); $i++)
					$_Result["CAPTIONS"][$_Captions["caption"][$i]["name"]] = $_Captions["caption"][$i]["value"];
			}
		}
		// Return data
		return $_Result;
	}

	/**
	 * Purpose: resign date  
	 * Function name: resign_date_value
	 * Parameters:
	 *		- $date: date
	 */
	function resign_date_value($date) {
		if ($_SESSION['language'] == "vie")
			return date("d-m-Y", strtotime($date)); 
		else 
			return $date; 
	}

	/**
	 * Purpose: chang wsdl object to array 
	 * Function name: obj_to_array
	 * Parameters:
	 *		- $obj: wsdl object
	 */
	function obj_to_array($obj) {
		$result = array(); 
		if (is_object($obj)) {
			foreach($obj as $k => $v) {
				$result[$k] = $v;
			}		
		}
		return $result; 
	}

	/**
	 * Purpose: format number depend on language
	 * Function name: resign_value
	 * Parameters:
	 *		- $language: language
	 *		- $value: number value
	 *		- $non_zero: get decimal or not
	 */
	function resign_value($language, $value, $non_zero=1) {
		// set default eng as $language
		$language = "eng"; 
		$value = number_format($value, 2, ".", ",");
		$digit = substr($value, strpos($value,'.')+1, strlen($value)-strpos($value, '.'));		
		if (intval($digit) == 0)
			$value = substr($value, 0, strpos($value, '.'));
		else if ($digit[1] ==0)
			$value = substr($value, 0, strpos($value, '.')+2);
		if ($value == 0)
			$value = "&nbsp;";			
	
		switch(strtolower($language)) {
			case "vie":			
				$value = str_replace(".", "|", $value);
				$value = str_replace(",", ".", $value);
				$value = str_replace("|", ",", $value);				
				break;
			case "jpn":
			case "eng":
			default:
				break;
		}
		return $value;
	}

	/**
	 * Purpose: format number array depend on language
	 * Function name: my_format_array_number
	 * Parameters:
	 *		- $language: language
	 *		- $array: number value array
	 *		- $non_zero: get decimal or not
	 */
	function my_format_array_number($language, $array, $non_zero=1) {
		$pattern = array("change", "stocksymbol", "side", "symbol", "securityname", "meeting", "splitstock", "benefit");
		
		$return = array();
		if (is_array($array)) {
			foreach($array as $key=>$value) {
				if (is_array($value)) {
					$ret = array();
					foreach($value as $k=>$v) {
						if (in_array($k, $pattern))
							$ret[$k] = $v;
						else 
							$ret[$k] = resign_value($language, $v, $non_zero);
					}
					$return[$key] = $ret;
				}
				elseif (in_array($k, $pattern))
					$return[$key] = $value;			
				else
					$return[$key] = resign_value($language, $value, $non_zero);
			}
		}
		return $return;		
	}	
?>