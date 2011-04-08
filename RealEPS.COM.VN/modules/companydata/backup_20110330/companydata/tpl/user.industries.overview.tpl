{if $data.display=='sector'}
{assign var='id' value=`$data.sector.SectorId`}
{else}
{assign var='id' value=`$data.industry.IndustryId`}
{/if}
<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU DANH SACH NGANH -->	   		
   			<a href="/doanh-nghiep/nganh/index.html" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Danh sách ngành
        	</span></a>
        	<!-- /MENU DANH SACH NGANH -->
        	<!-- MENU SO SANH NGANH -->	
            {if $data.display == 'sector'}
        	<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/sosanh.html#sector{$data.sector.SectorId}" class="panel_button margin_left_20px left">
            {else}
            <a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/sosanh.html#industry{$data.industry.IndustryId}" class="panel_button margin_left_20px left">
            {/if}   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	So sánh ngành
        	</span></a>
   		   	<!-- /MENU SO SANH NGANH -->	            	
       	<span class="clear"></span>  
      	</td></tr></table>
    </div>
    <div class="panel_content">
    	<!--[if lte IE 6]>
    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
    	<![endif]--> 
    	<!-- NGANH CHA -->   	    	
		<div class="boldtext margin_bottom_5px headline">
		<img src="/images/icon_arrow1.gif" />
		{if $data.display == 'sector'}
		Lĩnh vực: {$data.sector.Name}
		{else}
		Ngành: {$data.industry.Name}
		{/if}
		</div>
		<!-- /NGANH CHA -->
		
		<div class="margin_bottom_10px">
		{if $data.display == 'sector'}
		<!-- CAC NGANH CON -->
		<b>Các ngành con:</b>
		{foreach from=$data.sector.Industries item=item}
		<span style="margin-left: 5px;">
		<img src="/images/icon_triangle.gif" /> <a href="/doanh-nghiep/nganh/{$item.IndustryId}/index.html" class="bluelink">{$item.Name}</a>
		</span>
		{/foreach}
		 <!-- /CAC NGANH CON -->
		{else}
		<!-- THUOC LINH VUC -->
		<b>Thuộc lĩnh vực:</b>
		<span style="margin-left: 5px;">
		<img src="/images/icon_triangle.gif" /> <a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/index.html" class="bluelink">{$data.sector.Name}</a>
		</span>
		<!-- /THUOC LINH VUC -->
		{/if}
		</div>
		
		
		<!-- TONG QUAN NGANH -->
		<div class="tabpanel margin_bottom_10px">
			<!--[if lte IE 7]>
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
	    	<![endif]--> 
			<div class="header">
				{if $data.display == 'sector'}
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/index.html" class="active"><span>Tổng quan ngành</span></a>
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/tintuc.html"><span>Tin tức liên quan</span></a>
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/sosanh.html"><span>Thống kê ngành</span></a>
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/xephang.html"><span>Xếp hạng doanh nghiệp</span></a>
				{else}
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/index.html" class="active"><span>Tổng quan ngành</span></a>
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/tintuc.html"><span>Tin tức liên quan</span></a>
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/sosanh.html"><span>Thống kê ngành</span></a>
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/xephang.html"><span>Xếp hạng doanh nghiệp</span></a>
				{/if}
				<div class="clear"></div>
			</div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
			<div class="content">
			<div style="background: #e5e5e5; height: 4px;"></div>
			<div style="padding: 10px;">
			<!-- TONG QUAN NGANH -->
    			<div class="chart_info left" style="width: 350px;">
    	        	<div>
                    	<div class="left">Index ngày</div>
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
                    <div class="odd">
                    	<div class="left">Đóng cửa trước</div>                    	
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left">Khối lượng</div>
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
                    <div class="odd">
                    	<div class="left">Giá trị</div>
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left">Khối lượng NN Mua</div>
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
                    <div class="odd">
                    	<div class="left">Giá trị NN Mua</div>
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
                    <div>
                        <div class="left">Khối lượng NN Bán</div>
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
                    <div class="odd">
                        <div class="left">Giá trị NN Bán</div>
                        <div class="right">---</div>
                        <div class="clear"></div>
                    </div>
    	        </div>	 
                <div class="left" style="margin-left: 10px;">
                <object id='mySwf' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab' height='200px' width='360px'>
                <param name='src' value='/images/FinalIndexChart.swf?tradingSym=HOSE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl'/>                                                
                <param name='flashVars' value=''/>   
                <param name='wmode' value='transparent'/>                                                   
                <embed name='mySwf' wmode="transparent" src='/images/FinalIndexChart.swf?tradingSym=HOSE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.eps.com.vn/ws/chart.php?wsdl'  pluginspage='http://www.adobe.com/go/getflashplayer' height='200px' width='360px' flashVars=''/>                                    
                </object>
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
				<a href="#" class="active" onclick="changeTab(this,'stat_group_tab1', '', 'active'); return false;" rel="stat_group">
					<span>Chỉ số định giá</span>
				</a>
				<a href="#" onclick="changeTab(this,'stat_group_tab2', '', 'active'); return false;" rel="stat_group">
					<span>Khả năng sinh lợi</span>
				</a>
				<a href="#" onclick="changeTab(this,'stat_group_tab3', '', 'active'); return false;" rel="stat_group">
					<span>Sức mạnh tài chính</span>
				</a>
				<a href="#" onclick="changeTab(this,'stat_group_tab4', '', 'active'); return false;" rel="stat_group">
					<span>Hiệu quả quản lý</span>
				</a>
				<div class="clear"></div>
			</div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
			<div class="content">
			<div style="background: #e5e5e5; height: 4px;"></div>
			
			<!-- CHI SO DINH GIA -->
			<div id="stat_group_tab1" class="stat_group">
				<table width="100%" cellpadding="10" cellspacing="10">
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<tr>
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/> 
							P/E (Theo EPS pha loãng)
						</td>
						<td><b>{$data.obj_ratios.DilutedPE_TTM|num_format}</b></td>	
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							P/B
						</td>
						<td><b>{$data.obj_ratios.PB_MRQ|num_format}</b></td>					
					</tr>
					<tr>
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							P/E (Theo EPS cơ bản)
						</td>
						<td><b>{$data.obj_ratios.BasicPE_TTM|num_format}</b></td>
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							P/S
						</td>
						<td><b>{$data.obj_ratios.PS_TTM|num_format}</b></td>
					</tr>
				</table>
			</div>
			<!-- /CHI SO DINH GIA -->
			
			<!-- KHA NANG SINH LOI -->
			<div id="stat_group_tab2" style="display: none;" class="stat_group">
				<table width="100%" cellpadding="10" cellspacing="10">
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<tr>
						<!-- GrossMargin -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/> 
							Tỷ lệ lãi gộp (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.GrossMargin_TTM*100|num_format}%</b></td>
						<!-- /GrossMargin -->
							
						<!-- PreTaxMargin_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Tỷ lệ lãi trước thuế (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.PreTaxMargin_TTM*100|num_format}%</b></td>	
						<!-- /PreTaxMargin_TTM -->				
					</tr>
					<tr>
						<!-- EBITMargin -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Tỷ lệ EBIT (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.EBITMargin_TTM*100|num_format}%</b></td>
						<!-- /EBITMargin -->
						
						<!-- ProfitMargin_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Tỷ lệ lãi ròng (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.ProfitMargin_TTM*100|num_format}%</b></td>
						<!-- /ProfitMargin_TTM -->
					</tr>
					<tr>
						<!-- OperatingMargin_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Tỷ lệ lãi từ hoạt động KD (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.OperatingMargin_TTM*100|num_format}%</b></td>
						<!-- /OperatingMargin_TTM -->
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
			<!-- /KHA NANG SINH LOI -->
			
			<!-- SUC MANH TAI CHINH -->
			<div id="stat_group_tab3" style="display: none;" class="stat_group">
				<table width="100%" cellpadding="10" cellspacing="10">
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<tr>
						<!-- QuickRatio_MRQ -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/> 
							Khả năng thanh toán nhanh (Quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.QuickRatio_MRQ*100|num_format}%</b></td>
						<!-- /QuickRatio_MRQ -->
							
						<!-- TotalDebtOverEquity_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Tổng nợ trên vốn chủ (Quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.TotalDebtOverEquity_TTM*100|num_format}%</b></td>	
						<!-- /TotalDebtOverEquity_TTM -->				
					</tr>
					<tr>
						<!-- CurrentRatio_MRQ -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Khả năng thanh toán hiện hành (Quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.CurrentRatio_MRQ*100|num_format}%</b></td>
						<!-- /CurrentRatio_MRQ -->
						
						<!-- InterestCoverageRatio_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Khả năng thanh toán lãi vay (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.InterestCoverageRatio_TTM*100|num_format}%</b></td>
						<!-- /InterestCoverageRatio_TTM -->
					</tr>
					<tr>
						<!-- LTDebtOverEquity_MRQ -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							Nợ dài hạn trên vốn chủ (Quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.LTDebtOverEquity_MRQ*100|num_format}%</b></td>
						<!-- /LTDebtOverEquity_MRQ -->
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
			<!-- /SUC MANH TAI CHINH -->
			
			<!-- HIEU QUA QUAN LY -->
			<div id="stat_group_tab4" style="display: none;" class="stat_group">
				<table width="100%" cellpadding="10" cellspacing="10">
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<col width="40%" align="left"/>
					<col width="10%" align="left"/>
					<tr>
						<!-- ROA_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/> 
							ROA (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.ROA_TTM*100|num_format}%</b></td>
						<!-- /ROA_TTM -->
							
						<!-- TotalDebtOverEquity_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							ROIC (4 quý gần nhất)
						</td>
						<td><b>---%</b></td>	
						<!-- /TotalDebtOverEquity_TTM -->				
					</tr>
		
					<tr>
						<!-- ROE_TTM -->
						<td class="boldtext">
							<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
							ROE (4 quý gần nhất)
						</td>
						<td><b>{$data.obj_ratios.ROE_TTM*100|num_format}%</b></td>
						<!-- /ROE_TTM -->
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
			<!-- /HIEU QUA QUAN LY -->
			<div style="background: #e5e5e5; height: 1px;"></div>
			</div>
		</div>
	
		<!-- /THONG KE -->
		<!-- DOANH NGHIEP TRONG NGANH -->
		<div>
			<!--[if lte IE 7]>
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
	    	<![endif]-->  
			<div class="table_panel left" style="width:355px">
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
			        	<!-- MENU TIN THI TRUONG -->	        	 		   		
				        <a href="#" class="panel_button left margin_left_10px" onclick="changeTab(this,'newsgroup_tab2', 'panel_button', 'panel_button_active'); return false;" rel="newsgroup">   			
			   			<span>
			        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
			        	Tin thị trường
			        	</span></a>	       
			        	<!-- /MENU TIN THI TRUONG -->	
			        	<!-- MENU TIN THI TRUONG -->	        	 		   		
				        <a href="#" class="panel_button left margin_left_10px" onclick="changeTab(this,'newsgroup_tab3', 'panel_button', 'panel_button_active'); return false;" rel="newsgroup">   			
			   			<span>
			        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
			        	Tin kinh tế
			        	</span></a>	       
			        	<!-- /MENU TIN THI TRUONG -->                
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
					{foreach from=$data.newsgroup3 item=item}
					<tr>
						<td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
						<td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
					</tr>
					{/foreach}
					</tbody>
					<tfoot>
					{if $data.newsgroup3_totalpage > 0}
					<tr>
						<td colspan="2" align="right">
							<a href="#" onclick="prevNewsGroup3({$id},'{$data.display}'); return false;" id="nextNewsGroup3_prev" style="display: none;">&lsaquo;Trước</a>
							<span id="currentNewsGroup3">1</span>/{$data.newsgroup3_totalpage}		
							{if $data.newsgroup3_totalpage > 1}				
							<a href="#" onclick="nextNewsGroup3({$id},'{$data.display}',{$data.newsgroup3_totalpage}); return false;" id="nextNewsGroup3_next">Tiếp&rsaquo;</a>
							{/if}
						</td>
					</tr>
					{/if} 
					</tfoot>
					</table>
					<!-- /TIN DOANH NGHIEP -->
					<!-- TIN THI TRUONG -->
					<table width="100%" id="newsgroup_tab2" style="display: none;" class="newsgroup">
					<tbody id="tbody_newsgroup5">
					{foreach from=$data.newsgroup5 item=item}
					<tr>
						<td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
						<td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
					</tr>
					{/foreach}
					</tbody>
					<tfoot>
					{if $data.newsgroup5_totalpage > 0}
					<tr>
						<td colspan="2" align="right">
							<a href="#" onclick="prevNewsGroup5(); return false;" id="nextNewsGroup5_prev" style="display: none;">&lsaquo;Trước</a>
							<span id="currentNewsGroup5">1</span>/{$data.newsgroup5_totalpage}		
							{if $data.newsgroup5_totalpage > 1}				
							<a href="#" onclick="nextNewsGroup5({$data.newsgroup5_totalpage}); return false;" id="nextNewsGroup5_next">Tiếp&rsaquo;</a>
							{/if}
						</td>
					</tr>
					{/if} 
					</tfoot>
					</table>
					<!-- /TIN THI TRUONG -->
					<!-- TIN KINH TE -->
					<table width="100%" id="newsgroup_tab3" style="display: none;" class="newsgroup">
					<tbody class="tbody_newsgroup" id="tbody_newsgroup2">
					{foreach from=$data.newsgroup2 item=item}
					<tr>
						<td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
						<td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
					</tr>
					{/foreach}
					</tbody>
					<tfoot>
					{if $data.newsgroup2_totalpage > 0}
					<tr>
						<td colspan="2" align="right">
							<a href="#" onclick="prevNewsGroup2(); return false;" id="nextNewsGroup2_prev" style="display: none;">&lsaquo;Trước</a>
							<span id="currentNewsGroup2">1</span>/{$data.newsgroup2_totalpage}		
							{if $data.newsgroup2_totalpage > 1}				
							<a href="#" onclick="nextNewsGroup2({$data.newsgroup2_totalpage}); return false;" id="nextNewsGroup2_next">Tiếp&rsaquo;</a>
							{/if}
						</td>
					</tr>
					{/if} 
					</tfoot>
					</table>
					<!-- /TIN KINH TE -->
					</div>				
					<!--[if lte IE 6]>   
					</td></tr></table>
					<![endif]-->
			    </div>    
			    <div class="panel_bottom_left"></div>
			    <div class="panel_bottom" style="width: 347px;"></div>
			    <div class="panel_bottom_right"></div>
			    <div class="clear"></div>          
			</div>  
			
			<div class="table_panel right" style="width:380px">
			    <div class="header_left">
			    	<table cellpadding="0" cellspacing="0" class="header_right">
			    	<tr><th align="left">        	 	        	 		   		
				    	<!-- MENU QUY MO -->	        	 		   		
				       	<a href="#" class="panel_button_active left" onclick="changeTab(this,'finalcial_quymo', 'panel_button', 'panel_button_active'); return false;" rel="finalcial">   			
			   			<span>
			        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
			        	Quy mô
			        	</span></a>	       
			        	<!-- /MENU QUY MO -->	  
			        	<!-- MENU DINH GIA -->	        	 		   		
				        <a href="#" class="panel_button left margin_left_10px" onclick="changeTab(this,'finalcial_dinhgia', 'panel_button', 'panel_button_active'); return false;" rel="finalcial">   			
			   			<span>
			        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
			        	Định giá
			        	</span></a>	       
			        	<!-- /MENU DINH GIA -->	
			        	<!-- MENU DAONH THU -->	        	 		   		
				        <a href="#" class="panel_button left margin_left_10px" onclick="changeTab(this,'finalcial_doanhthu', 'panel_button', 'panel_button_active'); return false;" rel="finalcial">   			
			   			<span>
			        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
			        	Doanh thu
			        	</span></a>	       
			        	<!-- /MENU DAONH THU -->  
			        	<!-- MENU LOI NHHUAN -->	        	 		   		
				        <a href="#" class="panel_button left margin_left_10px" onclick="changeTab(this,'finalcial_loinhuan', 'panel_button', 'panel_button_active'); return false;" rel="finalcial">   			
			   			<span>
			        	<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
			        	Lợi nhuận
			        	</span></a>	       
			        	<!-- /MENU LOI NHHUAN --> 	                        
			      	</th></tr></table>
			    </div>
			    <div class="panel_content">
			    	<!--[if lte IE 6]>
			    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
			    	<![endif]-->    	    	
					<div class="detail_content margin_bottom_10px" >
					<!-- QUY MO -->
					<table class="small finalcial" width="100%" style="color: #333333" id="finalcial_quymo">
						<thead >
						<tr>
							<th>Mã CK</th>
							<th>Tên</th>
							<th align="center" nowrap="nowrap">Thị giá<br/>vốn</th>
							<th nowrap="nowrap">Vốn CSH<br/>(MRQ)</th>
							<th nowrap="nowrap">Tổng T.S<br/>(MRQ)</th>
						</tr>
						</thead>
						<tbody id="tbody_quymo">
						{foreach from=$data.company item=item name=loop}
						{if $smarty.foreach.loop.index % 2==0}
						<tr bgcolor="#F4F4F4">
						{else}
						<tr>
						{/if}
							<td><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink">{$item.Symbol}</a></td>
							<td>{$item.CompanyName}</td>
							<td align="right">{$item.MarketCapitalization|num_format}</td>
							<td align="right">{$item.Equity_MRQ|num_format}</td>
							<td align="right">{$item.TotalAssets_MRQ|num_format}</td>
						</tr>
						{/foreach}
						</tbody>
						<tfoot>
						
						{if $data.company_totalpage > 0}
						<tr style="font-size: 12px;">
							<td colspan="5" align="right">
								<a href="#" onclick="prevQuymo({$id},'{$data.display}'); return false;" id="prevQuymo" style="display: none;">&lsaquo;Trước</a>
								<span id="currentQuymo">1</span>/{$data.company_totalpage}		
								{if $data.company_totalpage > 1}				
								<a href="#" onclick="nextQuymo({$id},{$data.company_totalpage},'{$data.display}'); return false;" id="nextQuymo">Tiếp&rsaquo;</a>
								{/if}
							</td>
						</tr>
						{/if} 
						<tr>
							<td colspan="5" align="right">(Đơn vị: 1 tỷ đồng)</td>
						</tr>
						</tfoot>
					</table>
					<!-- /QUY MO -->
					<!-- DINH GIA -->
					<table class="small finalcial" width="100%" style="color: #333333; display: none;" id="finalcial_dinhgia" class="finalcial">
						<thead>
						<tr>
							<th>Mã CK</th>
							<th>Tên</th>
							<th align="center" nowrap="nowrap">P/E cơ bản<br/>(TTM)</th>
							<th nowrap="nowrap">P/S(MRQ)</th>
							<th nowrap="nowrap">P/B(MRQ)</th>
						</tr>
						</thead>
						<tbody id="tbody_dinhgia">
						{foreach from=$data.company item=item name=loop}
						{if $smarty.foreach.loop.index % 2==0}
						<tr bgcolor="#F4F4F4">
						{else}
						<tr>
						{/if}
							<td><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink">{$item.Symbol}</a></td>
							<td>{$item.CompanyName}</td>
							<td align="right">{$item.BasicPE_TTM|num_format:2:'x'}</td>
							<td align="right">{$item.PS_MRQ|num_format:2:'x'}</td>
							<td align="right">{$item.PB_MRQ|num_format:2:'x'}</td>
						</tr>
						{/foreach}
						</tbody>
						<tfoot>
						
						{if $data.company_totalpage > 0}
						<tr style="font-size: 12px;">
							<td colspan="5" align="right">
								<a href="#" onclick="prevDinhgia({$id},'{$data.display}'); return false;" id="prevDinhgia" style="display: none;">&lsaquo;Trước</a>
								<span id="currentDinhgia">1</span>/{$data.company_totalpage}		
								{if $data.company_totalpage > 1}				
								<a href="#" onclick="nextDinhgia({$id},{$data.company_totalpage},'{$data.display}'); return false;" id="nextDinhgia">Tiếp&rsaquo;</a>
								{/if}
							</td>
						</tr>
						{/if} 
						
						</tfoot>
					</table>
					<!-- /DINH GIA -->
					<!-- DOANH THU -->
					<table class="small finalcial" width="100%" style="color: #333333; display: none;" id="finalcial_doanhthu" class="finalcial">
						<thead>
						<tr>
							<th>Mã CK</th>
							<th>Tên</th>
							<th nowrap="nowrap">Doanh thu<br/>(TTM)</th>
							<th nowrap="nowrap">Doanh thu<br/>(LFY)</th>
						</tr>
						</thead>
						<tbody id="tbody_doanhthu">
						{foreach from=$data.company item=item name=loop}
						{if $smarty.foreach.loop.index % 2==0}
						<tr bgcolor="#F4F4F4">
						{else}
						<tr>
						{/if}
							<td><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink">{$item.Symbol}</a></td>
							<td>{$item.CompanyName}</td>
							<td align="right">{$item.Sales_TTM|num_format}</td>
							<td align="right">{$item.Sales_LFY|num_format}</td>
						</tr>
						{/foreach}
						</tbody>
						<tfoot>
						
						{if $data.company_totalpage > 0}
						<tr style="font-size: 12px;">
							<td colspan="5" align="right">
								<a href="#" onclick="prevDoanhthu({$id},'{$data.display}'); return false;" id="prevDoanhthu" style="display: none;">&lsaquo;Trước</a>
								<span id="currentDoanhthu">1</span>/{$data.company_totalpage}		
								{if $data.company_totalpage > 1}				
								<a href="#" onclick="nextDoanhthu({$id},{$data.company_totalpage},'{$data.display}'); return false;" id="nextDoanhthu">Tiếp&rsaquo;</a>
								{/if}
							</td>
						</tr>
						{/if}
						<tr>
							<td colspan="4" align="right">(Đơn vị: 1 tỷ đồng)</td>
						</tr> 
						</tfoot>
					</table>
					<!-- /DOANH THU -->
					<!-- LOI NHUAN -->
					<table class="small finalcial" width="100%" style="color: #333333; display: none;" id="finalcial_loinhuan" class="finalcial">
						<thead>
						<tr>
							<th>Mã CK</th>
							<th>Tên</th>
							<th nowrap="nowrap">Sau thuế<br/>(TTM)</th>
							<th nowrap="nowrap">Sau thuế <br/>(LFY)</th>
						</tr>
						</thead>
						<tbody id="tbody_loinhuan">
						{foreach from=$data.company item=item name=loop}
						{if $smarty.foreach.loop.index % 2==0}
						<tr bgcolor="#F4F4F4">
						{else}
						<tr>
						{/if}
							<td><a href="/doanh-nghiep/cong-ty/{$item.Symbol}/overview.html" class="bluelink">{$item.Symbol}</a></td>
							<td>{$item.CompanyName}</td>
							<td align="right">{$item.ProfitAfterTax_TTM|num_format}</td>
							<td align="right">{$item.ProfitAfterTax_LFY|num_format}</td>
						</tr>
						{/foreach}
						</tbody>
						<tfoot>
						
						{if $data.company_totalpage > 0}
						<tr style="font-size: 12px;">
							<td colspan="5" align="right">
								<a href="#" onclick="prevLoinhuan({$id},'{$data.display}'); return false;" id="prevLoinhuan" style="display: none;">&lsaquo;Trước</a>
								<span id="currentLoinhuan">1</span>/{$data.company_totalpage}		
								{if $data.company_totalpage > 1}				
								<a href="#" onclick="nextLoinhuan({$id},{$data.company_totalpage},'{$data.display}'); return false;" id="nextLoinhuan">Tiếp&rsaquo;</a>
								{/if}
							</td>
						</tr>
						{/if}
						<tr>
							<td colspan="4" align="right">(Đơn vị: 1 tỷ đồng)</td>
						</tr> 
						</tfoot>
					</table>
					<!-- /LOI NHUAN -->
					</div>				
					<!--[if lte IE 6]>   
					</td></tr></table>
					<![endif]-->
			    </div>    
			    <div class="panel_bottom_left"></div>
			    <div class="panel_bottom" style="width: 372px;"></div>
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