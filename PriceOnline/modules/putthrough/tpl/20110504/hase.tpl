	<center><table width="900"><tr><td>
	<!-- SUMMARY -->
    <div id="summary">
    	<table border="0"  cellpadding="5" cellspacing="0" bordercolor="6f6f6f"  width="100%" >
        	<tr>
            	<td width="40%">
                    <table width="100%" class="summary_table">
                    	<tr>
                    		<td align="left" width="10%">HASE-INDEX</td>
                    		<td align="right" width="15%" id="VNIndexSession_MarketIndex"></td>
                    		<td align="left" width="15%" id="VNIndexSession_CHGIndex"></td>
                    		<td align="right" width="15%" id="VNIndexSession_PCTIndex"></td>
                    		<td align="right" width="15%" id="VNIndexSession_Gainers" width="15%" style="color: #32CD32"></td>
                            <td align="right" width="15%" id="VNIndexSession_Losers" width="15%" style="color: #F70033;"></td>
                            <td align="right" width="15%" id="VNIndexSession_Unchanged" width="15%" style="color: #EEFB00;"></td>
                    	</tr>
                    </table>
                </td>                                
                <td width="30%">
                    <table width="100%" class="summary_table">
                    	<tr>
                    		<td align="right" width="50%">{$_mod_lang.khoi_luong_gd} : </td>
                    		<td align="left" width="50%" style="color: #EEFB00" id="VNIndexSession_TotalQuantity"></td>
                    	</tr>
                    </table>
                </td>
                <td width="30%">
                    <table width="100%" class="summary_table">
                    	<tr>
                    		<td align="right" width="50%">{$_mod_lang.tong_gia_tri_gd} : </td>
                    		<td align="left" width="50%" style="color: #EEFB00" id="VNIndexSession_TotalValue"></td>
                    	</tr>
                    </table>
                </td>
            </tr>            
        </table>         
    </div>
    <!-- /SUMMARY -->
    
    <!-- CONTROLLER -->   
        <div id="tabs">
        	<div>
	        	<ul class="tabs">		        	
		            <li><div><a href="/{$_mod_lang.code}/putthrough/hose/index.html">HOSE</a></div></li>
		            <li class="active"><div>HASE</div></li>		         
		        </ul>
		        <div style="clear:both"></div>            
            </div>  
            <div class="content" style="padding:10px;">            	
                <table width="100%" border="0">
				<tr>
					<td valign="top">
						<table width="100%" border="1" class="summary_table">
							<thead>
							<tr height="24">
								<th colspan="3" class="none">{$_lang.gdtt} - {$_mod_lang.chao_mua}</th>
							</tr>
							<tr bgcolor="#2b2b2b">
								<th>{$_mod_lang.ma_ck}</th>
								<th>{$_mod_lang.gia}</th>
								<th>{$_mod_lang.khoi_luong}</th>
							</tr>
							</thead>
							<tbody id="buy">				
							</tbody>
						</table>
					</td>	
					
					<td valign="top">
						<table width="100%" width="100%" border="1" class="summary_table">
							<thead>
							<tr height="24">
								<th colspan="5" class="none">{$_lang.gdtt} - {$_mod_lang.khop_lenh}</th>
							</tr>
							<tr bgcolor="#2b2b2b">
								<th>{$_mod_lang.ma_ck}</th>
								<th>{$_mod_lang.gia}</th>
								<th>{$_mod_lang.khoi_luong}</th>
								<th>{$_mod_lang.tong_gia_tri}</th>
								<th>{$_mod_lang.tong_khoi_luong}</th>
							</tr>
							</thead>
							<tbody id="exec">				
							</tbody>
						</table>
					</td>
					<td valign="top">
						<table width="100%" width="100%" border="1" class="summary_table">
							<thead>
							<tr height="24">
								<th colspan="3" class="none">{$_lang.gdtt} - {$_mod_lang.chao_ban}</th>
							</tr>
							<tr bgcolor="#2b2b2b">
								<th>{$_mod_lang.ma_ck}</th>
								<th>{$_mod_lang.gia}</th>
								<th>{$_mod_lang.khoi_luong}</th>
							</tr>
							</thead>
							<tbody id="sell">				
							</tbody>
						</table>
					</td>
				</tr>
				</table>
            </div>           
       </div>          
    <!-- /CONTROLLER -->
     
    
    </td></tr></table>
    </center>
    <!-- /STOCK TABLE -->    