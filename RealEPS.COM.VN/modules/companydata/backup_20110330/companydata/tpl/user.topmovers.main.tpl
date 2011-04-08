<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
        <table cellpadding="0" cellspacing="0" class="header_right">
        <tr><td>                            
            <!-- MENU LOC CO PHIEU -->           
            <a href="#" class="panel_button_active left">             
            <span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
            TOP cổ phiếu
            </span></a>
            <!-- /MENU LOC CO PHIEU -->                                 
        <span class="clear"></span>  
        </td></tr></table>
    </div>
    <div class="panel_content">
    	<div class="text">  
       		Sử dụng công cụ TOP cổ phiếu để tìm ra các cổ phiếu dẫn đầu thị trường theo các tiêu chí khác nhau. Hãy lựa chọn các tiêu chí để xếp hạng cổ phiếu.
       	</div>   
        
       	<div style="background: #F8F8F8" class="text">
       		<table cellpadding="10" cellspacing="10">
       			<tr>
       				<td>Sàn</td>
       				<td>Lĩnh vực</td>
       			</tr>
       			<tr>
       				<td valign="top">       					
       					<select name="tm_se" id="tm_se">
       						<option value="0">Bất kỳ</option>
       						<option value="1">HOSE</option>
       						<option value="2">HASE</option>
       					</select>	
       				</td>
       				<td>
       					
       					<select multiple="multiple" name="tm_industry" id="tm_industry">
       						{getsectors assign="sectors"}
   							{foreach from=$sectors item="sector"}
   							<option value="{$sector.SectorId}">{$sector.Name}</option>
   							{/foreach}
       					</select>       					       				
						<p>Giữ phím Shift hoặc Ctrl trong khi click để lựa chọn nhiều lĩnh vực.</p> 
       				</td>
       			</tr>
       		</table>
       	</div>   
      	 <!-- LINH VUC KINH DOANH -->
        <div class="headline1 margin_bottom_10px text">
       	Xem cổ phiếu theo 
        </div>
        <div class="info margin_bottom_10px" style="padding: 10px;">
        <select name="tm_orderby" id="tm_orderby">
			<option value="MarketCapitalization">Thị giá vốn</option>
			<option value="SharesOutstanding">Số cổ phần đang lưu hành</option>
			<!-- <option value="PercentChange">% Thay đổi giá trong ngày</option> 
			<option value="SevenDaysChange">% Thay đổi giá 7 ngày</option>  
			<option value="ThirtyDaysChange">% Thay đổi giá 30 ngày</option>
			<option value="ThreeMonthsChange">% Thay đổi giá 3 tháng</option>
			<option value="SixMonthsChange">% Thay đổi giá 6 tháng</option>
			<option value="OneYearChange">% Thay đổi giá 1 năm</option>
			<option value="TwoYearsChange">% Thay đổi giá 2 năm</option>
			<option value="ThreeYearsChange">% Thay đổi giá 3 năm</option>
			<option value="FiveYearsChange">% Thay đổi giá 5 năm</option> -->
			<option value="BasicPE_TTM">P/E cơ bản (TTM)</option>
			<option value="BasicPE_LFY">P/E cơ bản (LFY)</option>
			<option value="DilutedPE_TTM">P/E điều chỉnh (TTM)</option>
			<option value="DilutedPE_LFY">P/E điều chỉnh (LFY)</option>
			<option value="PB_MRQ">P/B (MRQ)</option>
			<option value="PS_TTM">P/S (TTM)</option>
			<option value="BasicEPS_TTM">EPS cơ bản (TTM)</option>
			<option value="BasicEPS_LFY">EPS cơ bản (LFY)</option>
			<option value="DilutedEPS_TTM">EPS pha loãng (TTM)</option>
			<option value="DilutedEPS_LFY">EPS pha loãng (LFY)</option>
			<option value="GrossMargin_TTM">Tỷ lệ lãi gộp (TTM)</option>
			<option value="GrossMargin_LFY">Tỷ lệ lãi gộp (LFY)</option>
			<option value="EBITMargin_TTM">Tỷ lệ EBIT (TTM)</option>
			<option value="EBITMargin_LFY">Tỷ lệ EBIT (LFY)</option>
			<option value="OperatingMargin_TTM">Tỷ lệ lãi từ HĐ SXKD (TTM)</option>
			<option value="OperatingMargin_LFY">Tỷ lệ lãi từ HĐ SXKD (LFY)</option>
			<option value="ProfitMargin_TTM">Tỷ lệ lãi ròng (TTM)</option>
			<option value="ProfitMargin_LFY">Tỷ lệ lãi ròng (LFY)</option>
			<option value="QuickRatio_MRQ">Khả năng thanh toán nhanh (MRQ)</option>
			<option value="CurrentRatio_MRQ">Khả năng thanh toán tức thời (MRQ) </option>
			<option value="InterestCoverageRatio_TTM">Khả năng thanh toán lãi vay (TTM)</option>
			<option value="LTDebtOverEquity_MRQ">Nợ dài hạn/Vốn CSH (MRQ)</option>
			<option value="TotalDebtOverEquity_MRQ">Tổng nợ/Vốn CSH (MRQ)</option>
			<option value="TotalDebtOverAssets_MRQ">Tổng nợ/Tổng tài sản (MRQ)</option>
			<option value="ROE_TTM">ROE (TTM)</option>
			<option value="ROE_LFY">ROE (LFY)</option>
			<option value="ROA_TTM">ROA (TTM)</option>
			<option value="ROA_LFY">ROA (LFY)</option>
			<option value="AnnualDividend_LFY">Cổ tức hàng năm (LFY)</option>
			<option value="DividendYield_LFY">Thu nhập tính trên cổ tức (LFY)</option>
			<option value="PayoutRatio_LFY">Tỷ lệ trả cổ tức (LFY)</option>
			<option value="CurrentAssetsTurnover_TTM">Vòng quay vốn lưu động (TTM)</option>
			<option value="InventoryTurnover_TTM">Vòng quay hàng tồn kho (TTM)</option>
			<option value="AssetsTurnover_TTM">Vòng quay tổng tài sản (TTM)</option>
			<option value="ReceivablesTurnover_TTM">Vòng quay các khoản phải thu (TTM)</option>
			<option value="SalesGrowth_MRQ">Tăng trưởng doanh thu (MRQ)</option>
			<option value="SalesGrowth_MRQ2">Tăng trưởng doanh thu (MRQ2)</option>
			<option value="SalesGrowth_TTM">Tăng trưởng doanh thu (TTM)</option>
			<option value="SalesGrowth_LFY">Tăng trưởng doanh thu (LFY)</option>
			<option value="ProfitGrowth_MRQ">Tăng trưởng lợi nhuận (MRQ)</option>
			<option value="ProfitGrowth_MRQ2">Tăng trưởng lợi nhuận (MRQ2)</option>
			<option value="ProfitGrowth_TTM">Tăng trưởng lợi nhuận (TTM)</option>
			<option value="ProfitGrowth_LFY">Tăng trưởng lợi nhuận (LFY)</option>
			<option value="BasicEPSGrowth_MRQ">Tăng trưởng EPS cơ bản (MRQ)</option>
			<option value="BasicEPSGrowth_MRQ2">Tăng trưởng EPS cơ bản (MRQ2)</option>
			<option value="BasicEPSGrowth_TTM">Tăng trưởng EPS cơ bản (TTM)</option>
			<option value="BasicEPSGrowth_LFY">Tăng trưởng EPS cơ bản (LFY)</option>
			<option value="DilutedEPSGrowth_MRQ">Tăng trưởng EPS pha loãng (MRQ)</option>
			<option value="DilutedEPSGrowth_MRQ2">Tăng trưởng EPS pha loãng (MRQ2)</option>
			<option value="DilutedEPSGrowth_TTM">Tăng trưởng EPS pha loãng (TTM)</option>
			<option value="DilutedEPSGrowth_LFY">Tăng trưởng EPS pha loãng (LFY)</option>
			<option value="Sales_TTM">Doanh thu (TTM)</option>
			<option value="Sales_LFY">Doanh thu (LFY)</option>
			<option value="ProfitFromOperatingActivities_TTM">Lợi nhuận từ HĐ SXKD (TTM)</option>
			<option value="ProfitFromOperatingActivities_LFY">Lợi nhuận từ HĐ SXKD (LFY)</option>
			<option value="ProfitFromFinancialActivities_TTM">Lợi nhuận từ HĐ tài chính (TTM)</option>
			<option value="ProfitFromFinancialActivities_LFY">Lợi nhuận từ HĐ tài chính (LFY)</option>
			<option value="ProfitAfterTax_TTM">Lợi nhuận sau thuế (TTM)</option>
			<option value="ProfitAfterTax_LFY">Lợi nhuận sau thuế (LFY)</option>
			<option value="Cash_MRQ">Tiền mặt (MRQ)</option>
			<option value="Cash_LFY">Tiền mặt (LFY)</option>
			<option value="LiquidAssets_MRQ">Tài sản lưu động (MRQ)</option>
			<option value="LiquidAssets_LFY">Tài sản lưu động (LFY)</option>
			<option value="NetLiquidAssets_MRQ">Tài sản lưu động ròng (MRQ)</option>
			<option value="NetLiquidAssets_LFY">Tài sản lưu động ròng (LFY)</option>
			<option value="TotalAssets_MRQ">Tổng tài sản (MRQ)</option>
			<option value="TotalAssets_LFY">Tổng tài sản (LFY)</option>
			<option value="Equity_MRQ">Vốn CSH (MRQ)</option>
			<option value="Equity_LFY">Vốn CSH (LFY)</option>
		</select>
		<select name="tm_ordertype" id="tm_ordertype">
			<option value="0">Tăng dần</option>
			<option value="1">Giảm dần</option>
		</select>
        </div>
        <!-- /LINH VUC KINH DOANH--> 
         <!-- LINH VUC KINH DOANH -->
        <div class="headline1 margin_bottom_10px text">
       	Hiển thị kết quả - Lựa chọn cách bạn muốn hiển thị kết quả 
        </div>
        <div class="info margin_bottom_10px text">
        <table cellpadding="0" cellspacing="0" width="100%">        	
        	<tr>
        		<td style="border-bottom: 1px solid #CCCCCC; padding: 10px; width: 200px;">Hiển thị bảng </td>
        		<td style="border-bottom: 1px solid #CCCCCC;">
        			<select id="tm_view" name="tm_view">
						<option value="0">Tổng quan</option>
						<option value="1">Giao dịch hôm nay</option>
						<option value="2">Biến động giá</option>
						<option value="3">Thống kê chính</option>
						<option value="4">Định giá</option>
						<option value="5">Tăng trưởng</option>
					</select>
				</td>
        	</tr>
        	<tr>
        		<td style="border-bottom: 1px solid #CCCCCC;padding: 10px;">Số lượng kết quả </td>
        		<td style="border-bottom: 1px solid #CCCCCC;">
        			<select name="tm_limit" id="tm_limit">
						<option value="10">10</option>
						<option value="25" selected="selected">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
					</select>
				</td>
        	</tr>        	
        </table>
        	
        </div>
        <!-- /LINH VUC KINH DOANH-->
    	<div>
     		<a href="#" class="button" style="width: 100px;" onclick="onSubmit(); return false;"><span>Thự hiện lọc</span></a>
     	</div>    	 
    </div> 
      
    <div class="panel_bottom_left"></div>
    <div class="panel_bottom" style="width: 747px;"></div>
    <div class="panel_bottom_right"></div>
    <div class="clear"></div>          
</div>  
<div class="clear"></div>