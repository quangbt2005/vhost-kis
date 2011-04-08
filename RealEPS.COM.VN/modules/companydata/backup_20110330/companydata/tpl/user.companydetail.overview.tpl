<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU TONG QUAN -->	   		
   			<a href="#" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Tổng quan công ty
        	</span></a>
        	<!-- /MENU TONG QUAN -->        	           
       	<span class="clear"></span>  
      	</td></tr></table>
    </div>
    <div class="panel_content">
    	<!--[if lte IE 6]>
    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
    	<![endif]--> 
    	<!-- TEN CONG TY -->   	    	
		<div class="boldtext margin_bottom_5px headline">
		<img src="/images/icon_arrow1.gif" />
		{$data.company.CompanyName} ({$data.company.Symbol} : <span style="text-transform: uppercase">{$data.company.Bourse}</span>)
		</div>
		<!-- /TEN CONG TY -->
		
		<div class="margin_bottom_10px">		
		<!-- THUOC LINH VUC -->		
		<span style="margin-left: 5px;">
		<img src="/images/icon_triangle.gif" /> 
        <a href="/doanh-nghiep/linh-vuc/{$data.company.SectorId}/index.html" class="bluelink">{$data.company.SectorName}</a> :
        <a href="/doanh-nghiep/nganh/{$data.company.IndustryID}/index.html" class="bluelink">{$data.company.IndustryName}</a>
		</span>
		<!-- /THUOC LINH VUC -->		
		</div>
		
		
		<!-- TONG QUAN NGANH -->
		<div class="tabpanel margin_bottom_10px">
			<!--[if lte IE 7]>
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
	    	<![endif]--> 
			<div class="header">            				
				<a href="#" class="active"><span>Tổng quan</span></a>				
				<div class="clear"></div>
			</div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
			<div class="content">
			<div style="background: #e5e5e5; height: 4px;"></div>
			<div style="padding: 10px;">
			<!-- TONG QUAN NGANH -->
    			<div class="chart_info left" style="width: 305px;">
    	        	<div>
                    	<div class="left">Giá tham chiếu</div>
                        <div class="right">{$data.quotes.PriorClosePrice|num_format:0}</div>
                        <div class="clear"></div>
                    </div>
                    <div class="odd">
                    	<div class="left">Mở cửa</div>                    	
                        <div class="right">{$data.quotes.OpenPrice|num_format:0}</div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left">Khối lượng</div>
                        <div class="right">{$data.quotes.LastVal|num_format:0}</div>
                        <div class="clear"></div>
                    </div>
                    <div class="odd">
                    	<div class="left">Khối lượng trung bình (10 ngày)</div>
                        <div class="right">{$data.company.AvgVolume10d|num_format:0}</div>
                        <div class="clear"></div>
                    </div>
                    <div>
                        <div class="left">Thị giá vốn</div>
                        <div class="right">{$data.company.MarketCapitalization|num_format:2:' tỷ'}</div>
                        <div class="clear"></div>
                    </div>
                    <div class="odd">
                        <div class="left">Số cổ phần đang lưu hành</div>
                        <div class="right">{$data.company.SharesOutstanding|num_format:2:' triệu'}</div>
                        <div class="clear"></div>
                    </div>
                    {if $data.company.DilutedPE_TTM != ''}
                    <div>
                        <div class="left">P/E pha loãng (4 quý gần nhất)</div>
                        <div class="right">{$data.company.DilutedPE_TTM|num_format:2:'x'}</div>
                        <div class="clear"></div>
                    </div>
                    {elseif $data.company.DilutedPE_LFY != ''}
                    <div>
                        <div class="left">P/E pha loãng (năm gần nhất)</div>
                        <div class="right">{$data.company.DilutedPE_LFY|num_format:2:'x'}</div>
                        <div class="clear"></div>
                    </div>
                    {/if}
    	        </div>	 
                <div class="left" style="margin-left: 10px;">
                
                    <div style="border:  1px solid #CCC; width:400px; height: 250px">
                    <object  id='mySwf' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab' height="250" width="400" >     
                    <param name='src' value="/images/TechnicalChart_Small.swf?stockSymbol={$data.company.Symbol}&stockExchangeID={$data.company.SeId}&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl"/>     
                    <embed src="/images/TechnicalChart_Small.swf?stockSymbol={$data.company.Symbol}&stockExchangeID={$data.company.SeId}&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl" height="250" width="400" pluginspage='http://www.adobe.com/go/getflashplayer'  />     
                    </object>
                    </div>
                    <div style="text-align: right;">
                                       
                    <a href="/index.php?mod=securities&seid=1&view=4&symbol={$data.company.Symbol}#info"><img src="/images/small_chart_ico.gif" title="{option name="image_title"}" align="absmiddle"/> Biểu đồ kỹ thuật</a>
                    
                    <a href="#" onclick="alert('Du lieu dang duoc cap nhap'); return false;" class="bluelink">
                    <img src="/images/download.png" title="{option name="image_title"}" align="absmiddle"/>Tải về báo cáo chi tiết</a></div>
                 
                </div>
                <div class="clear"></div>
            </div>
			<!-- /TONG QUAN NGANH -->
			
			<div style="background: #e5e5e5; height: 1px;"></div>
			</div>
		</div>
		<!-- /TONG QUAN NGANH -->
		
		<!-- THONG KE -->
		<div class="tabpanel margin_bottom_10px">
			<!--[if lte IE 7]>
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
	    	<![endif]--> 
			<div class="header">
				<a href="#" class="active"><span>Thông tin tài chính</span></a>
				
				<div class="clear"></div>
			</div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
			<div class="content">
			<div style="background: #e5e5e5; height: 4px;"></div>
			
			<!-- THONG TIN TAI CHINH -->
			<div>
				<table width="100%" cellpadding="10" cellspacing="10" border="0">
                    <!-- LINE 1 -->
                    <tr>
                        <td valign="top" width="33%">
                            <table width="100%" class="coltable" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th colspan="2">                                      
                                        <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                                        Định giá                                        
                                    </th>
                                </tr>
                                {if $data.company.DilutedPE_TTM != ''}
                                 <tr>
                                    <td>P/E pha loãng (TTM)</td>
                                    <td align="right"><b>{$data.company.DilutedPE_TTM|num_format:2:'x'}</b></td>
                                </tr>
                                {elseif $data.company.DilutedPE_LFY != ''}
                                <tr>
                                    <td>P/E pha loãng (LFY)</td>
                                    <td align="right"><b>{$data.company.DilutedPE_LFY|num_format:2:'x'}</b></td>
                                </tr>
                                {/if}
                                
                                {if $data.company.PS_MRQ != ''}
                                <tr>
                                    <td>P/S (MQR)</td>
                                    <td align="right"><b>{$data.company.PS_MRQ|num_format:2:'x'}</b></td>
                                </tr>
                                {elseif $data.company.PS_TTM != ''}
                                <tr>
                                    <td>P/S (TTM)</td>
                                    <td align="right"><b>{$data.company.PS_TTM|num_format:2:'x'}</b></td>
                                </tr>
                                {elseif $data.company.PS_LFY != ''}
                                <tr>
                                    <td>P/S (LFY)</td>
                                    <td align="right"><b>{$data.company.PS_LFY|num_format:2:'x'}</b></td>
                                </tr>
                                {/if}
                                
                                <tr>
                                    <td>P/B (MQR)</td>
                                    <td align="right"><b>{$data.company.PB_MRQ|num_format:2:'x'}</b></td>
                                </tr>
                             
                                {if $data.company.DilutedEPS_TTM != ''}
                                <tr>
                                    <td>EPS pha loãng (TTM)</td>
                                    <td align="right"><b>{$data.company.DilutedEPS_TTM|num_format}</b></td>
                                </tr>
                                {elseif $data.company.DilutedEPS_LFY != ''}
                                <tr>
                                    <td>EPS pha loãng (LFY)</td>
                                    <td align="right"><b>{$data.company.DilutedEPS_LFY|num_format}</b></td>
                                </tr>
                                {/if}
                            </table>
                        </td>
                        <td valign="top" width="33%">
                            <table width="100%" class="coltable" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th colspan="2">
                                     <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                                    Sức mạnh tài chính</th>
                                </tr>
                                 <tr>
                                    <td>Thanh toán nhanh (MRQ)</td>
                                    <td align="right"><b>{$data.company.QuickRatio_MRQ|num_format:2:'x'}</b></td>
                                </tr>
                                <tr>
                                    <td>Thanh toán hiện hành (MRQ)</td>
                                    <td align="right"><b>{$data.company.CurrentRatio_MRQ|num_format:2:'x'}</b></td>
                                </tr>
                                <tr>
                                    <td>Nợ/Vốn chủ SH (MRQ)</td>
                                    <td align="right"><b>{$data.company.TotalDebtOverEquity_MRQ|num_format:2:'x'}</b></td>
                                </tr>
                                 <tr>
                                    <td>Nơ/Tổng tài sản (MRQ)</td>
                                    <td align="right"><b>{$data.company.TotalDebtOverAssets_MRQ|num_format:2:'x'}</b></td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top" width="33%">
                             <table width="100%" class="coltable" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th colspan="2"><div>
                                    <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                                    Khả năng hoạt động</div></th>
                                </tr>
                                 <tr>
                                    <td>Vòng quay tổng tài sản (TTM)</td>
                                    <td align="right"><b>{$data.company.AssetsTurnover_TTM|num_format:2:'x'}</b></td>
                                </tr>
                                <tr>
                                    <td>Vòng quay hàng tồn kho (TTM)</td>
                                    <td align="right"><b>{$data.company.InventoryTurnover_TTM|num_format:2:'x'}</b></td>
                                </tr>
                                <tr>
                                    <td>Vòng quay các khoản phải thu (TTM)</td>
                                    <td align="right"><b>---</b></td>
                                </tr>                                
                            </table>
                        </td>
                    </tr>
                    <!-- /LINE 1 -->
                    <!-- LINE 2-->
                    <tr>
                        <td valign="top" width="33%">
                            <table width="100%" class="coltable" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th colspan="2">                                      
                                        <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                                        Khả năng sinh lợi                                       
                                    </th>
                                </tr>
                                {if $data.company.GrossMargin_TTM != ''}
                                 <tr>
                                    <td>Tỷ lệ lãi gộp (TTM)</td>
                                    <td align="right"><b>{$data.company.GrossMargin_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.GrossMargin_LFY != ''}
                                 <tr>
                                    <td>Tỷ lệ lãi gộp (LFY)</td>
                                    <td align="right"><b>{$data.company.GrossMargin_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                                {if $data.company.OperatingMargin_TTM != ''}
                                <tr>
                                    <td>Tỷ lệ lãi từ SXKD (TTM)</td>
                                    <td align="right"><b>{$data.company.OperatingMargin_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.OperatingMargin_LFY != ''}
                                 <tr>
                                    <td>Tỷ lệ lãi từ SXKD (LFY)</td>
                                    <td align="right"><b>{$data.company.OperatingMargin_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                                {if $data.company.EBITMargin_TTM != ''}
                                <tr>
                                    <td>Tỷ lệ EBIT (TTM)</td>
                                    <td align="right"><b>{$data.company.EBITMargin_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.EBITMargin_LFY != ''}
                                 <tr>
                                    <td>Tỷ lệ EBIT (LFY)</td>
                                    <td align="right"><b>{$data.company.EBITMargin_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                                {if $data.company.ProfitMargin_TTM != ''}
                                 <tr>
                                    <td>Tỷ lệ lãi ròng (LFY)</td>
                                    <td align="right"><b>{$data.company.ProfitMargin_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {else if $data.company.ProfitMargin_LFY != ''}
                                <tr>
                                    <td>Tỷ lệ lãi ròng (LFY)</td>
                                    <td align="right"><b>{$data.company.ProfitMargin_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                            </table>
                        </td>
                        <td valign="top" width="33%">
                            <table width="100%" class="coltable" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th colspan="2">
                                     <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                                        Hiệu quả quản lý</th>
                                </tr>
                                {if $data.company.ROA_TTM != ''}
                                 <tr>
                                    <td>ROA (TTM)</td>
                                    <td align="right"><b>{$data.company.ROA_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.ROA_LFY != ''}
                                <tr>
                                    <td>ROA (LFY)</td>
                                    <td align="right"><b>{$data.company.ROA_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                                
                                {if $data.company.ROE_TTM != ''}
                                 <tr>
                                    <td>ROE (TTM)</td>
                                    <td align="right"><b>{$data.company.ROE_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.ROE_LFY != ''}
                                <tr>
                                    <td>ROE (LFY)</td>
                                    <td align="right"><b>{$data.company.ROE_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                                
                                {if $data.company.ROIC_TTM != ''}
                                 <tr>
                                    <td>ROIC (TTM)</td>
                                    <td align="right"><b>{$data.company.ROIC_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.ROIC_LFY != ''}
                                <tr>
                                    <td>ROIC (LFY)</td>
                                    <td align="right"><b>{$data.company.ROIC_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}                                
                            </table>
                        </td>
                        <td valign="top" width="33%">
                             <table width="100%" class="coltable" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th colspan="2"><div>
                                    <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                                    Tăng trưởng</div></th>
                                </tr>
                                {if $data.company.BasicEPSGrowth_TTM != ''}
                                 <tr>
                                    <td>EPS cơ bản (TTM)</td>
                                    <td align="right"><b>{$data.company.BasicEPSGrowth_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.BasicEPSGrowth_LFY != ''}
                                 <tr>
                                    <td>EPS cơ bản (LFY)</td>
                                    <td align="right"><b>{$data.company.BasicEPSGrowth_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                                
                                
                                 {if $data.company.SalesGrowth_TTM != ''}
                                 <tr>
                                    <td>Doanh thu (TTM)</td>
                                    <td align="right"><b>{$data.company.SalesGrowth_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.SalesGrowth_LFY != ''}
                                 <tr>
                                    <td>Doanh thu (LFY)</td>
                                    <td align="right"><b>{$data.company.SalesGrowth_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}
                                
                                
                                {if $data.company.ProfitGrowth_TTM != ''}
                                 <tr>
                                    <td>Lợi nhuận (TTM)</td>
                                    <td align="right"><b>{$data.company.ProfitGrowth_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.ProfitGrowth_LFY != ''}
                                 <tr>
                                    <td>Lợi nhuận (LFY)</td>
                                    <td align="right"><b>{$data.company.ProfitGrowth_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}    
                                
                                {if $data.company.ProfitGrowth_TTM != ''}
                                 <tr>
                                    <td>Tài sản (TTM)</td>
                                    <td align="right"><b>{$data.company.TotalAssetsGrowth_TTM|num_format:2:'%'}</b></td>
                                </tr>
                                {elseif $data.company.ProfitGrowth_LFY != ''}
                                 <tr>
                                    <td>Tài sản (LFY)</td>
                                    <td align="right"><b>{$data.company.TotalAssetsGrowth_LFY|num_format:2:'%'}</b></td>
                                </tr>
                                {/if}  
                                                            
                            </table>
                        </td>
                    </tr>
                    <!-- /LINE 2 -->
                    <tr>
                        <td colspan="3" align="right">
                       <b>MRQ</b>: Quý gần nhất   
            			<b>MRQ2</b>: Quý gần nhì   
            			<b>TTM</b>: 4 quý gần nhất   
            			<b>LFY</b>: Năm tài chính gần nhất 
                        </td>
                    </tr>
                </table>
			</div>
			<!-- /THONG TIN TAI CHINH -->
			
			
			<div style="background: #e5e5e5; height: 1px;"></div>
			</div>
		</div>
	
		<!-- /THONG KE -->
		<!-- DOANH NGHIEP TRONG NGANH -->
		<div>
			<!--[if lte IE 7]>
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
	    	<![endif]-->  
            <!-- TIN DOANH NGIEP -->
			<div class="table_panel left margin_bottom_10px" style="width: 365px;">
			    <div class="header_left">
			    	<table cellpadding="0" cellspacing="0" class="header_right">
			    	<tr><th align="left">        	 
			    		<!-- MENU TIN DOANH NGHIEP -->	        	 		   		
				        <a href="#" class="panel_button_active left" onclick="changeTab(this,'newsgroup_tab1', 'panel_button', 'panel_button_active'); return false;" rel="newsgroup">   			
			   			<span>
			        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
			        	Tin doanh nghiệp
			        	</span></a>	       
			        	<!-- /MENU TIN DOANH NGHIEP -->	  		        	            
			      	</th></tr></table>
			    </div>
			    <div class="panel_content">
			    	<!--[if lte IE 6]>
			    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
			    	<![endif]-->    	    	
					<div class="detail_content text margin_bottom_10px">
					<!-- TIN DOANH NGHIEP -->
					<table width="100%" id="newsgroup_tab1" class="newsgroup" >
					<tbody id="tbody_newsgroup3">
					{foreach from=$data.newsgroup3 item=item}
					<tr>
						<td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
						<td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
					</tr>
                    {foreachelse}
                    <tr>
                        <th align="center">Hiện không có tin tức</th>
                    </tr>
                    {/foreach}
					</tbody>
					<tfoot>					
					</tfoot>
					</table>
					<!-- /TIN DOANH NGHIEP -->
					</div>				
					<!--[if lte IE 6]>   
					</td></tr></table>
					<![endif]-->
			    </div>    
			    <div class="panel_bottom_left"></div>
			    <div class="panel_bottom" style="width: 357px;"></div>
			    <div class="panel_bottom_right"></div>
			    <div class="clear"></div>          
			</div>  
			<!-- /TIN DOANH NGIEP -->
            
            <!-- TIN lIEN QUAN KHAC -->
            <div class="table_panel left margin_bottom_10px margin_left_10px" style="width: 366px;">
                <div class="header_left">
                    <table cellpadding="0" cellspacing="0" class="header_right">
                    <tr><th align="left">            
                        <!-- MENU TIN LIEN QUAN KHAC -->                                
                        <a href="#" class="panel_button_active left margin_left_10px">            
                        <span>
                        <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                        Tin liên quan khác
                        </span></a>        
                        <!-- /MENU TIN LIEN QUAN KHAC -->                                       
                    </th></tr></table>
                </div>
                <div class="panel_content">
                    <!--[if lte IE 6]>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
                    <![endif]-->                
                    <div class="detail_content text margin_bottom_10px">
                    <!-- TIN DOANH NGHIEP -->
                    <table width="100%" id="newsgroup_tab1" class="newsgroup">
                    <tbody id="tbody_newsgroup3">
                    {foreach from=$data.newsgroup item=item}
                    <tr>
                        <td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
                        <td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
                    </tr>
                    {foreachelse}
                    <tr>
                        <th align="center">Hiện không có tin tức</th>
                    </tr>
                    {/foreach}
                    </tbody>
                    <tfoot>                   
                    </tfoot>
                    </table>
                    <!-- /TIN lIEN QUAN KHAC -->
                    </div>              
                    <!--[if lte IE 6]>   
                    </td></tr></table>
                    <![endif]-->
                </div>    
                <div class="panel_bottom_left"></div>
                <div class="panel_bottom" style="width: 358px;"></div>
                <div class="panel_bottom_right"></div>
                <div class="clear"></div>          
            </div>  
            <!-- /TIN lIEN QUAN KHAC -->
            
			<div class="table_panel left" style="width: 742px;">
                <div class="header_left">
                    <table cellpadding="0" cellspacing="0" class="header_right">
                    <tr><th align="left">            
                        <!-- MENU TIN DOANH NGHIEP -->                              
                        <a href="#" class="panel_button_active left" onclick="changeTab(this,'newsgroup_tab1', 'panel_button', 'panel_button_active'); return false;" rel="newsgroup">              
                        <span>
                        <img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
                        Hồ sơ doanh nghiệp
                        </span></a>        
                        <!-- /MENU TIN DOANH NGHIEP -->   
                                                       
                    </th></tr></table>
                </div>
                <div class="panel_content">
                    <!--[if lte IE 6]>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
                    <![endif]-->                
                    <div class="detail_content text margin_bottom_10px">
                       <div>{$data.company.Overview|truncate:500}</div>
                       <div>
                           <table width="100%">
                            <thead>
                            <tr>
                            <th style="border-bottom: 2px solid #CCCCCC;">Trụ sợ</th>
                            <th align="right" style="border-bottom: 2px solid #CCCCCC;">{$data.company.HeadQuarters}<th></tr>
                            </thead>
                            <tr>
                                <th style="border-bottom: 1px solid #CCCCCC;">Số cổ phần đang lưu hành</th>
                                <th align="right" style="border-bottom: 1px solid #CCCCCC;">{$data.company.SharesOutstanding|num_format:2:' triệu'}</th>
                            </tr> 
                            <tr>
                                <th style="border-bottom: 1px solid #CCCCCC;">Tổng cộng tài sản</th>
                                <th align="right" style="border-bottom: 1px solid #CCCCCC;">{$data.company.ListingVolume|num_format:0:' tỷ'}</th>
                            </tr> 
                            <tr>
                                <th style="border-bottom: 1px solid #CCCCCC;">Vốn chủ sở hữu</th>
                                <th align="right" style="border-bottom: 1px solid #CCCCCC;">{$data.company.ListingVolume|num_format:0:' tỷ'}</th>
                            </tr>  
                            <tr>
                                <th style="border-bottom: 1px solid #CCCCCC;">Thị giá vốn</th>
                                <th align="right" style="border-bottom: 1px solid #CCCCCC;">{$data.company.MarketCapitalization|num_format:2:' tỷ'} </th>
                            </tr>
                            <tr>
                                <th style="border-bottom: 1px solid #CCCCCC;">Số lượng nhân sự</th>
                                <th align="right" style="border-bottom: 1px solid #CCCCCC;">{$data.company.Employees|num_format:0}</th>
                            </tr>
                            <tr>
                                <th style="border-bottom: 1px solid #CCCCCC;">Số lượng chi nhánh</th>
                                <th align="right" style="border-bottom: 1px solid #CCCCCC;">{$data.company.Branches|num_format:0}</th>
                            </tr>
                            <tr>
                                <th style="border-bottom: 1px solid #CCCCCC;">Ngành</th>
                                <th align="right" style="border-bottom: 1px solid #CCCCCC;"><a href="/doanh-nghiep/nganh/{$data.company.IndustryID}/index.html" rel="nofollow">{$data.company.IndustryName}</a></th>
                            </tr>
                            <tr>
                                <th style="border-bottom: 2px solid #CCCCCC;">Website</th>
                                <th align="right" style="border-bottom: 2px solid #CCCCCC;"><a href="http://{$data.company.WebAddress}" rel="nofollow">{$data.company.WebAddress}</a></th>
                            </tr>  
                                                         
                           </table>
                       </div>
                    </div>              
                    <!--[if lte IE 6]>   
                    </td></tr></table>
                    <![endif]-->
                </div>    
                <div class="panel_bottom_left"></div>
                <div class="panel_bottom" style="width: 734px;"></div>
                <div class="panel_bottom_right"></div>
                <div class="clear"></div>          
            </div>
            
			<div class="clear"></div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
		</div>
		<!-- /DOANH NGHIEP TRONG NGANH -->
		<!--[if lte IE 6]>   
		</td></tr></table>
		<![endif]-->
    </div>    
    <div class="panel_bottom_left"></div>
    <div class="panel_bottom" style="width: 747px;"></div>
    <div class="panel_bottom_right"></div>
    <div class="clear"></div>          
</div>  
<div class="clear"></div>