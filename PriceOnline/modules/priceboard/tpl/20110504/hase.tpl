	<center><table><tr><td>
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
		        	<li class="active"><div>{$_mod_lang.xem_tat_ca}</div></li>
		            <li><div>{$_mod_lang.xem_danh_sach} 1</div></li>
		            <li><div>{$_mod_lang.xem_danh_sach} 2</div></li>
		            <li><div>{$_mod_lang.xem_danh_sach} 3</div></li>
		            <li><div>{$_mod_lang.xem_danh_sach} 4</div></li>
		            <li id="button_close" class="none">
                    	<a href="#" onclick="onclick_showStockList(); return false;"><img src="/images/btt_open{$_mod_lang.prefix}.gif" width="130" height="25" title="{$_mod_lang.mo}"/></a>
                    </li>
		        </ul>
		        <div style="clear:both"></div>            
            </div>  
            <div class="content">
            	<div id="sort_custom" style="display:none;">
                    <div id="sort_alphabet" >
                        <a href="#" onclick="onclick_showStockByAlphabet('A', true);">A</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('B', true);">B</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('C', true);">C</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('D', true);">D</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('E', true);">E</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('F', true);">F</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('G', true);">G</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('H', true);">H</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('I', true);">I</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('J', true);">J</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('K', true);">K</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('L', true);">L</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('M', true);">M</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('N', true);">N</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('O', true);">O</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('P', true);">P</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('Q', true);">Q</a> |        
                        <a href="#" onclick="onclick_showStockByAlphabet('R', true);">R</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('S', true);">S</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('T', true);">T</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('U', true);">U</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('V', true);">V</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('W', true);">W</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('X', true);">X</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('Y', true);">Y</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('Z', true);">Z</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('CCQ', true);">{$_mod_lang.CCQ}</a> |
                        <a href="#" onclick="onclick_showStockByAlphabet('ALL', true);">{$_mod_lang.tat_ca}</a>
                    </div>					
                    <div class="clear"></div>
                </div>
                <div id="stock_names" style="display:none">               
	               <table border="0" width="100%" >
	               <tbody id="stockSymbols">
	               		{foreach from=$data.StockSymbols item="item" name="loop"}
	               		{if $smarty.foreach.loop.index % 18 == 0}               
	               		<tr>		
						{/if}
						<td align="left"><input type="checkbox" name="{$item}" id="chk{$item}" />{$item}</td>					
						{if $smarty.foreach.loop.index + 1 % 18 == 0}               
	               		</tr>		
						{/if}		
						{/foreach}
	                </tbody>
	               </table>                	
                </div>                
                <div id="buttons">
                    <div id="button_show" style="display:none;">
                    <a href="#" onclick="onclick_selectAllStocks(); return false;"><img src="/images/btt_all{$_mod_lang.prefix}.gif"  width="130" height="25" title="{$_mod_lang.chon_tat_ca}"/> </a>
                    <a href="#" onclick="onclick_deselectAllStocks(); return false;"><img src="/images/btt_del_all{$_mod_lang.prefix}.gif" width="130" height="25" title="{$_mod_lang.xoa_tat_ca}"/></a>
                    <a href="#" onclick="onclick_viewSelectedSotck(); return false;"><img src="/images/btt_view{$_mod_lang.prefix}.gif" width="71" height="25" title="{$_mod_lang.xem}"/></a>                    
                    <a href="#" onclick="onclick_hideStockList(); return false;"><img src="/images/btt_close{$_mod_lang.prefix}.gif" width="130" height="25" title="{$_mod_lang.dong}"/></a>
                    </div>                    
                </div>
            </div>           
       </div>          
    <!-- /CONTROLLER -->
  
    <div style="margin-top: 10px;">     
	    <table width="100%" ><tr>
	    <td align="left" nowrap="nowrap" width="33%">       
			{$_mod_lang.tuy_chon_cot}: <img src="/images/hose_03{$_mod_lang.prefix}.gif" id="dropdown"  width="155" height="20" title="{$_mod_lang.tuy_chon_cot}" align="absmiddle"/>    
	    </td>
	    <td align="center" nowrap="nowrap" width="33%">
	    	{$_mod_lang.so_ck_trang}: <input type="text" value="30" size="4" id="rowPerPage1"/>
	    	<input type="button" value="{$_mod_lang.xem}" onclick="onclick_changeRowPerPage('rowPerPage1');" style="border: 1px solid #FFF;"/>
	    	(<a href="#" onclick="onclick_changeRowPerPage('all'); return false;" class="link3">Xem tất cả</a>) 
	    </td>
	    <td align="right" nowrap="nowrap" id="paging" width="34%">    	
		   	<a href="#" onclick="onclick_nextPage(); return false;" class="link2">&raquo;</a>
		   	{section name=loop start=$data.total_page loop=$data.total_page step=-1}
		   	{if $smarty.section.loop.index+1 == 1}
		   	<a href="#" onclick="onclick_gotoPage({$smarty.section.loop.index+1}); return false;" class="link2 selected" id="p{$smarty.section.loop.index+1}">{$smarty.section.loop.index+1}</a>
		   	{else}
		   	<a href="#" onclick="onclick_gotoPage({$smarty.section.loop.index+1}); return false;" class="link2" id="p{$smarty.section.loop.index+1}">{$smarty.section.loop.index+1}</a>
		   	{/if}		    	      
		    {/section}
		    <a href="#" onclick="onclick_prevPage(); return false;" class="link2">&laquo;</a>
		    <div class="clear"></div>	              
	    </td>
	    </tr></table>
  	</div>
    <!-- STOCK TABLE -->
    <div id="overflowHeader" style="display:none;position: fixed; top: 0px;">
    	<table id="header_table" cellpadding="0" cellspacing="0" border="1" bordercolor="6f6f6f" width="100%">
        	<thead bgcolor="#171717" style="border: 2px solid #B2B2B2;">
            	<tr height="26">
                	<th rowspan="2" width="30" class="sortable">{$_mod_lang.stt}</th>
                    <th rowspan="2" width="80">{$_mod_lang.ma_ck}</th>
                    <th colspan="6" bgcolor="#2b2b2b" class="border_right">{$_mod_lang.gia}</th>
                    <th colspan="6" id="col_buy" class="border_right">{$_mod_lang.mua}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="38">{$_mod_lang.gia_khop}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="60">{$_mod_lang.thay_doi}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="40">{$_mod_lang.kl_khop}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="40" class="border_right">{$_mod_lang.tong_kl_khop}</th>
                    <th colspan="6" class="border_right">{$_mod_lang.ban}</th>
                    <th colspan="3" bgcolor="#2b2b2b">{$_mod_lang.nuoc_ngoai}</th>                    
                </tr>
            	<tr height="39">
                    <th bgcolor="#2b2b2b" width="38">{$_mod_lang.tran}</th>
                    <th bgcolor="#2b2b2b" width="38">{$_mod_lang.san}</th>
					<th bgcolor="#2b2b2b" width="38">{$_mod_lang.tc}</th>
                    <th bgcolor="#2b2b2b" width="38">{$_mod_lang.mo_cua}</th>
                    <th bgcolor="#2b2b2b" width="38">{$_mod_lang.cao_nhat}</th>
                    <th bgcolor="#2b2b2b" width="38" class="border_right">{$_mod_lang.thap_nhat}</th>
                    <th width="38">{$_mod_lang.gia} 3</th>
                    <th width="40">{$_mod_lang.KL} 3</th>                     
                    <th width="38">{$_mod_lang.gia} 2</th>
                    <th width="40">{$_mod_lang.KL} 2</th>
                    <th width="38">{$_mod_lang.gia} 1</th>
                    <th width="40" class="border_right">{$_mod_lang.KL} 1</th>              
                    
                    <th width="38">{$_mod_lang.gia} 1</th>
                    <th width="40">{$_mod_lang.KL} 1</th>
                    <th width="38">{$_mod_lang.gia} 2</th>
                    <th width="40">{$_mod_lang.KL} 2</th>
                    <th width="38">{$_mod_lang.gia} 3</th>
                    <th width="40" class="border_right">{$_mod_lang.KL} 3 </th>                                       
                    <th bgcolor="#2b2b2b" width="40">{$_mod_lang.mua}</th>
                    <th bgcolor="#2b2b2b" width="40">{$_mod_lang.ban}</th>
                    <th bgcolor="#2b2b2b" width="80">{$_mod_lang.room}</th>
                </tr>
            </thead>  
		</table>
    </div>  
    <div id="stocks">    
    	  
        <table cellpadding="0" cellspacing="0" border="1" id="stocks_table" bordercolor="6f6f6f" width="100%">
        	<thead bgcolor="#171717" style="border: 2px solid #B2B2B2;">
            	<tr height="26">
                	<th rowspan="2" width="30" id="sort_1">{$_mod_lang.stt}</th>
                    <th rowspan="2" width="80">{$_mod_lang.ma_ck}</th>
                    <th colspan="6" bgcolor="#2b2b2b" class="border_right">{$_mod_lang.gia}</th>
                    <th colspan="6" id="col_buy" class="border_right">{$_mod_lang.mua}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="38">{$_mod_lang.gia_khop}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="60">{$_mod_lang.thay_doi}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="40">{$_mod_lang.kl_khop}</th>
                    <th rowspan="2" bgcolor="#2b2b2b" width="40" class="border_right">{$_mod_lang.tong_kl_khop}</th>
                    <th colspan="6" class="border_right">{$_mod_lang.ban}</th>
                    <th colspan="3" bgcolor="#2b2b2b">{$_mod_lang.nuoc_ngoai}</th>                    
                </tr>
            	<tr height="39">
                    <th bgcolor="#2b2b2b" width="38" id="sort_3">{$_mod_lang.tran}</th>
                    <th bgcolor="#2b2b2b" width="38">{$_mod_lang.san}</th>
					<th bgcolor="#2b2b2b" width="38">{$_mod_lang.tc}</th>
                    <th bgcolor="#2b2b2b" width="38">{$_mod_lang.mo_cua}</th>
                    <th bgcolor="#2b2b2b" width="38">{$_mod_lang.cao_nhat}</th>
                    <th bgcolor="#2b2b2b" width="38" class="border_right">{$_mod_lang.thap_nhat}</th>
                    <th width="38">{$_mod_lang.gia} 3</th>
                    <th width="40">{$_mod_lang.KL} 3</th>                     
                    <th width="38">{$_mod_lang.gia} 2</th>
                    <th width="40">{$_mod_lang.KL} 2</th>
                    <th width="38">{$_mod_lang.gia} 1</th>
                    <th width="40" class="border_right">{$_mod_lang.KL} 1</th>              
                    
                    <th width="38">{$_mod_lang.gia} 1</th>
                    <th width="40">{$_mod_lang.KL} 1</th>
                    <th width="38">{$_mod_lang.gia} 2</th>
                    <th width="40">{$_mod_lang.KL} 2</th>
                    <th width="38">{$_mod_lang.gia} 3</th>
                    <th width="40" class="border_right">{$_mod_lang.KL} 3</th>                                       
                    <th bgcolor="#2b2b2b" width="40">{$_mod_lang.mua}</th>
                    <th bgcolor="#2b2b2b" width="40">{$_mod_lang.ban}</th>
                    <th bgcolor="#2b2b2b" width="80">{$_mod_lang.room}</th>
                </tr>
            </thead>                        
            <tbody id="stock_table">            				
            {foreach from=$data.Items item="item" name="loop"}				           					                	
				<tr height="24" id="{$item}" class="stock_row">
				<td>{$smarty.foreach.loop.index+1}</td>
				<th align="left">
					<table cellpadding="0" cellspacing="0">
					<tr>
						<td width="50"><input type="checkbox" onclick="onclick_toggle(this,'{$item}');" /><a href="#" onclick="return false;" title="{$data.ItemNames[$smarty.foreach.loop.index]}">{$item}</a></td>
						<td><span source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="Icon"></span></td>
					</tr>
					</table>
				</th>			
				<td bgcolor="#2b2b2b" class="max"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="CeilingPrice" class="non-hightlight"></div></td>
				<td bgcolor="#2b2b2b" class="min"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="FloorPrice" class="non-hightlight"></div></td>
				<td bgcolor="#2b2b2b" class="none"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="BasicPrice" class="non-hightlight"></div></td>
				<td bgcolor="#2b2b2b"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="OpenPrice"></div></td>
				<td bgcolor="#2b2b2b"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="HighestPrice"></div></td>
				<td bgcolor="#2b2b2b" class="border_right"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="LowestPrice"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="BOrdPrice3"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="BOrdQtty3"></div></td>				
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="BOrdPrice2"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="BOrdQtty2"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="BOrdPrice1"></div></td>
				<td class="border_right"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="BOrdQtty1"></div></td>
				<td bgcolor="#2b2b2b"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="MatchPrice"></div></td>
				<td bgcolor="#2b2b2b">
				<table width="100%">
				<tr>
				<td width="20%"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="Icon1"></div></td>
				<th width="60%"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="Change" class="non-hightlight"></div></th>
				</tr>
				</table>
				</td>
				<th bgcolor="#2b2b2b"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="MatchQtty" class="non-hightlight"></div></th>
				<th bgcolor="#2b2b2b" class="border_right"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="NmTotalTradedQtty" class="non-hightlight"></div></th>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="SOrdPrice1"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="SOrdQtty1"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="SOrdPrice2"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="SOrdQtty2"></div></td>
				<td><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="SOrdPrice3"></div></td>
				<td class="border_right"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="SOrdQtty3"></div></td>
				<th bgcolor="#2b2b2b"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="FBuy" class="non-hightlight"></div></th>
				<th bgcolor="#2b2b2b"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="FSell" class="non-hightlight"></div></th>
				<th bgcolor="#2b2b2b"><div source="lightstreamer" table="StockQuotes" item="{$smarty.foreach.loop.index+1}" field="RemainForeignQtty" class="non-hightlight"></div></th>
				</tr>
				{/foreach}
            </tbody>          
        </table>       
    </div>    
    <div style="margin-top:10px;">
	    <table width="100%" ><tr>
	    <td width="33%">&nbsp;</td>
	    <td align="center" nowrap="nowrap" width="33%">
	    	{$_mod_lang.so_ck_trang}: <input type="text" value="30" size="4" id="rowPerPage2"/>
	    	<input type="button" value="{$_mod_lang.xem}" onclick="onclick_changeRowPerPage('rowPerPage2');" style="border: 1px solid #FFF;"/>
	    	(<a href="#" onclick="onclick_changeRowPerPage('all'); return false;" class="link3">Xem tất cả</a>) 
	    </td>
	    <td align="right" nowrap="nowrap" id="paging1" width="34%">    	
		   	<a href="#" onclick="onclick_nextPage(); return false;" class="link2">&raquo;</a>
		   	{section name=loop start=$data.total_page loop=$data.total_page step=-1}
		   	{if $smarty.section.loop.index+1 == 1}
		   	<a href="#" onclick="onclick_gotoPage({$smarty.section.loop.index+1}); return false;" class="link2 selected" id="p{$smarty.section.loop.index+1}">{$smarty.section.loop.index+1}</a>
		   	{else}
		   	<a href="#" onclick="onclick_gotoPage({$smarty.section.loop.index+1}); return false;" class="link2" id="p{$smarty.section.loop.index+1}">{$smarty.section.loop.index+1}</a>
		   	{/if}		    	      
		    {/section}
		    <a href="#" onclick="onclick_prevPage(); return false;" class="link2">&laquo;</a>
		    <div class="clear"></div>	              
	    </td>
	    </tr></table>
	  </div>
    
    </td></tr></table>
    </center>
    <!-- /STOCK TABLE -->    