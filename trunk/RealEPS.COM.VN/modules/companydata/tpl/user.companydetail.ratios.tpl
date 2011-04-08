<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU TONG QUAN -->	   		
   			<a href="#" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Thống kê chi tiết
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
        <!-- THUOC LINH VUC -->  
        <div class="margin_bottom_10px" >                 
        <span style="margin-left: 5px;">
        <img src="/images/icon_triangle.gif" /> 
        <a href="/doanh-nghiep/linh-vuc/{$data.company.SectorId}/index.html" class="bluelink">{$data.company.SectorName}</a> :
        <a href="/doanh-nghiep/nganh/{$data.company.IndustryID}/index.html" class="bluelink">{$data.company.IndustryName}</a>
        </span>   
        </div>
        
        <!-- TANG TRUONG -->
        <div class="headline1 text margin_bottom_10px">
        Các chỉ số định giá (Tính đến ngày {$smarty.now|date_format:"%d/%m/%Y"})        
        </div>
        <div class="text info margin_bottom_10px">
         <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    <th align="right">Doanh nghiệp</th>
                    <th align="right">Ngành</th>
                    <th align="right">Lĩnh vực</th>                                 
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>P/E pha loãng (TTM)</td>                        
                    <td align="right">{$data.company.DilutedPE_TTM|num_format}</td>                                                                                
                    <td align="right">{$data.industry.DilutedPE_TTM|num_format}</td>
                    
                    
                    {if $data.sector.High52WkDilutedPEDate != ''}
                    <td align="right">{$data.sector.DilutedPE_TTM|num_format}</td>
                    {else}
                    <td align="right">---</td>
                    {/if}                                                                           
                </tr>
                <tr>
                    <td>P/E pha loãng cao nhất trong 52 tuần (TTM)</td>
                    <td align="right">{$data.company.High52WkDilutedPE|num_format}</td>   
                    {if $data.industry.High52WkDilutedPEDate != ''}
                    <td align="right">{$data.industry.High52WkDilutedPE|num_format}</td>   
                    {else}
                    <td align="right">---</td>
                    {/if}   
                    {if $data.sector.High52WkDilutedPEDate != ''}
                    <td align="right">{$data.sector.High52WkDilutedPE|num_format}</td> 
                    {else}
                    <td align="right">---</td>
                    {/if}                                                          
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>P/E pha loãng thấp nhất trong 52 tuần (TTM)</td>
                    <td align="right">{$data.company.Low52WkDilutedPE|num_format}</td>   
                    {if $data.industry.Low52WkDilutedPEDate != ''}
                    <td align="right">{$data.industry.Low52WkDilutedPE|num_format}</td>   
                    {else}
                    <td align="right">---</td>
                    {/if}   
                    {if $data.sector.Low52WkDilutedPEDate != ''}
                    <td align="right">{$data.sector.Low52WkDilutedPE|num_format:2:'%'}</td> 
                    {else}
                    <td align="right">---</td>
                    {/if}                                  
                </tr>
                
                <tr>
                    <td>P/E cơ bản (TTM)</td>
                    <td align="right">{$data.company.BasicPE_TTM|num_format}</td>   
                    <td align="right">{$data.industry.BasicPE_TTM|num_format}</td>   
                    <td align="right">{$data.sector.BasicPE_TTM|num_format}</td>                                                     
                </tr>
                
                <tr  bgcolor="#f0f0f0">
                    <td>P/E cơ bản cao nhất trong 52 tuần (TTM)</td>
                    {if $data.company.High52WkBasicPEDate != ''}
                    <td align="right">{$data.company.High52WkBasicPE|num_format}</td>
                    {else}
                    <td align="right">---</td>
                    {/if}
                    {if $data.industry.High52WkBasicPEDate != ''}
                    <td align="right">{$data.industry.High52WkBasicPE|num_format}</td>
                    {else}
                    <td align="right">---</td>
                    {/if}   
                    {if $data.sector.High52WkBasicPEDate != ''}
                    <td align="right">{$data.sector.High52WkBasicPE|num_format}</td>
                    {else}
                    <td align="right">---</td>
                    {/if}                 
                </tr>
                <tr>
                    <td>P/E cơ bản thấp nhất trong 52 tuần (TTM)</td>
                    {if $data.company.Low52WkBasicPEDate != ''}
                    <td align="right">{$data.company.Low52WkBasicPE|num_format}</td>
                    {else}
                    <td align="right">---</td>
                    {/if}
                    {if $data.industry.Low52WkBasicPEDate != ''}
                    <td align="right">{$data.industry.Low52WkBasicPE|num_format}</td>
                    {else}
                    <td align="right">---</td>
                    {/if}   
                    {if $data.sector.Low52WkBasicPEDate != ''}
                    <td align="right">{$data.sector.Low52WkBasicPE|num_format}</td>
                    {else}
                    <td align="right">---</td>
                    {/if}                        
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>P/B (MRQ)</td>
                    <td align="right">{$data.company.PB_MRQ|num_format}</td>   
                    <td align="right">{$data.industry.PB_MRQ|num_format}</td>   
                    <td align="right">{$data.sector.PB_MRQ|num_format}</td>                                
                </tr>
                <tr>
                    <td>P/S (TTM)</td>
                    <td align="right">{$data.company.PS_TTM|num_format}</td>   
                    <td align="right">{$data.industry.PS_TTM|num_format}</td>   
                    <td align="right">{$data.sector.PS_TTM|num_format}</td>                                      
                </tr>
                </tbody>    
            </table>
        </div>
         <!-- /TANG TRUONG -->  
         <!-- DOANH THU -->
        <div class="headline1 text margin_bottom_10px">
        Tăng trưởng (Tính đến quý {$data.company.Quarter} năm {$data.company.Year})
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    <th align="right">Doanh nghiệp</th>
                    <th align="right">Ngành</th>
                    <th align="right">Lĩnh vực</th>                  
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng doanh thu (Quý gần nhất)</td>    
                    <td align="right">{$data.company.SalesGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.SalesGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.SalesGrowth_MRQ|num_format:2:'%'}</td>                                                        
                </tr>
                <tr>
                    <td>Tăng trưởng doanh thu (Quý gần nhì)</td>
                    <td align="right">{$data.company.SalesGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.SalesGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.SalesGrowth_MRQ2|num_format:2:'%'}</td>                         
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng doanh thu (4 quý gần nhất)</td>
                    <td align="right">{$data.company.SalesGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.SalesGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.SalesGrowth_TTM|num_format:2:'%'}</td>                                 
                </tr>
                
                <tr>
                    <td>Tăng trưởng doanh thu (Năm gần nhất)</td>
                    <td align="right">{$data.company.SalesGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.SalesGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.SalesGrowth_LFY|num_format:2:'%'}</td>                                
                </tr>
                
                <tr  bgcolor="#f0f0f0">
                    <td>Tăng trưởng doanh thu (3 năm)</td>
                    <td align="right">{$data.company.SalesGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.SalesGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.SalesGrowth_03Yr|num_format:2:'%'}</td>                                      
                </tr>
                <tr>
                    <td>Tăng trưởng lợi nhuận (Quý gần nhất)</td>
                    <td align="right">{$data.company.ProfitGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitGrowth_MRQ|num_format:2:'%'}</td>                       
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng lợi nhuận (Quý gần nhì)</td>
                    <td align="right">{$data.company.ProfitGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitGrowth_MRQ2|num_format:2:'%'}</td>                       
                </tr>
                <tr>
                    <td>Tăng trưởng lợi nhuận (4 quý gần nhất)</td>
                    <td align="right">{$data.company.ProfitGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitGrowth_TTM|num_format:2:'%'}</td>                            
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td>Tăng trưởng lợi nhuận (Năm gần nhất)</td>
                    <td align="right">{$data.company.ProfitGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitGrowth_LFY|num_format:2:'%'}</td>                        
                </tr>
                <tr>
                    <td>Tăng trưởng lợi nhuận (3 năm)</td>
                    <td align="right">{$data.company.ProfitGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitGrowth_03Yr|num_format:2:'%'}</td>                     
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS cơ bản (Quý gần nhất)</td>
                    <td align="right">{$data.company.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>                    
                </tr>
                <tr>
                    <td>Tăng trưởng EPS cơ bản (Quý gần nhì)</td>
                    <td align="right">{$data.company.BasicEPSGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.BasicEPSGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.BasicEPSGrowth_MRQ2|num_format:2:'%'}</td>                     
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS cơ bản (4 quý gần nhất)</td>
                    <td align="right">{$data.company.BasicEPSGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.BasicEPSGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.BasicEPSGrowth_TTM|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Tăng trưởng EPS cơ bản (Năm gần nhất)</td>
                    <td align="right">{$data.company.BasicEPSGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.BasicEPSGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.BasicEPSGrowth_03Yr|num_format:2:'%'}</td>                      
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS cơ bản (3 năm)</td>
                    <td align="right">{$data.company.BasicEPSGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.BasicEPSGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.BasicEPSGrowth_LFY|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Tăng trưởng EPS pha loãng (Quý gần nhất)</td>
                    <td align="right">{$data.company.DilutedEPSGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.DilutedEPSGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.DilutedEPSGrowth_MRQ|num_format:2:'%'}</td>                        
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS pha loãng (Quý gần nhì)</td>
                    <td align="right">{$data.company.DilutedEPSGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.DilutedEPSGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.DilutedEPSGrowth_MRQ2|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Tăng trưởng EPS pha loãng (4 quý gần nhất)</td>
                    <td align="right">{$data.company.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>                      
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS pha loãng (Năm gần nhất)</td>
                    <td align="right">{$data.company.DilutedEPSGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.DilutedEPSGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.DilutedEPSGrowth_LFY|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Tăng trưởng EPS pha loãng (3 năm)</td>
                    <td align="right">{$data.company.DilutedEPSGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.DilutedEPSGrowth_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.DilutedEPSGrowth_03Yr|num_format:2:'%'}</td>                      
                </tr>                
                </tbody>    
            </table>
        </div>
         <!-- /DOANH THU -->
         <!-- LOI NHUAN -->
        <div class="headline1 text margin_bottom_10px">
        Sức mạnh tài chính
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    <th align="right">Doanh nghiệp</th>
                    <th align="right">Ngành</th>
                    <th align="right">Lĩnh vực</th>                            
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Khả năng thanh toán nhanh - Quick Ratio (Quý gần nhất)</td>    
                    <td align="right">{$data.company.QuickRatio_MRQ|num_format}</td>   
                    <td align="right">{$data.industry.QuickRatio_MRQ|num_format}</td>   
                    <td align="right">{$data.sector.QuickRatio_MRQ|num_format}</td>                                                                          
                </tr>
                <tr>
                    <td>Khả năng thanh toán tức thời - Current Ratio (Quý gần nhất)</td>
                    <td align="right">{$data.company.CurrentRatio_MRQ|num_format}</td>   
                    <td align="right">{$data.industry.CurrentRatio_MRQ|num_format}</td>   
                    <td align="right">{$data.sector.CurrentRatio_MRQ|num_format}</td>                           
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Nợ dài hạn trên vốn chủ - LT Debt to Equity (Quý gần nhất)</td>                    
                    <td align="right">{$data.company.LTDebtOverEquity_MRQ|num_format}</td>   
                    <td align="right">{$data.industry.LTDebtOverEquity_MRQ|num_format}</td>   
                    <td align="right">{$data.sector.LTDebtOverEquity_MRQ|num_format}</td>                                 
                </tr>
                
                <tr>                
                    <td>Tổng nợ trên vốn chủ - Total Debt to Equity (Quý gần nhất)</td>
                    <td align="right">{$data.company.TotalDebtOverEquity_MRQ|num_format}</td>   
                    <td align="right">{$data.industry.TotalDebtOverEquity_MRQ|num_format}</td>   
                    <td align="right">{$data.sector.TotalDebtOverEquity_MRQ|num_format}</td>                              
                </tr>
                
                <tr  bgcolor="#f0f0f0">
                
                    <td>Khả năng thanh toán lãi vay - Interest Coverage (4 quý gần nhất)</td>
                    <td align="right">{$data.company.InterestCoverageRatio_TTM|num_format}</td>   
                    <td align="right">{$data.industry.InterestCoverageRatio_TTM|num_format}</td>   
                    <td align="right">{$data.sector.InterestCoverageRatio_TTM|num_format}</td>                         
                </tr>               
                </tbody>    
            </table>
        </div>
         <!-- /LOI NHUAN -->
           
         <!-- CO CAU CO DONG -->
        <div class="headline1 text margin_bottom_10px">
        Khả năng sinh lời
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    <th align="right">Doanh nghiệp</th>
                    <th align="right">Ngành</th>
                    <th align="right">Lĩnh vực</th>                     
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi gộp (4 quý gần nhất)</td>    
                    <td align="right">{$data.company.GrossMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.GrossMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.GrossMargin_TTM|num_format:2:'%'}</td>                                                            
                </tr>
                <tr>
                    <td>Tỷ lệ lãi gộp (Năm gần nhất)</td>
                    <td align="right">{$data.company.GrossMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.GrossMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.GrossMargin_LFY|num_format:2:'%'}</td>                                              
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi gộp (Bình quân 3 năm gần nhất)</td>
                    <td align="right">{$data.company.GrossMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.GrossMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.GrossMargin_03Yr|num_format:2:'%'}</td>                                     
                </tr>
                
                <tr>
                    <td>Tỷ lệ EBIT (4 quý gần nhất)</td>
                    <td align="right">{$data.company.EBITMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.EBITMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.EBITMargin_TTM|num_format:2:'%'}</td>                              
                </tr>
                
                <tr  bgcolor="#f0f0f0">
                    <td>Tỷ lệ EBIT (Năm gần nhất)</td>
                    <td align="right">{$data.company.EBITMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.EBITMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.EBITMargin_LFY|num_format:2:'%'}</td>                         
                </tr>
                <tr>
                    <td>Tỷ lệ EBIT (Bình quân 3 năm gần nhất)</td>
                    <td align="right">{$data.company.EBITMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.EBITMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.EBITMargin_03Yr|num_format:2:'%'}</td>                      
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi từ hoạt động KD (4 quý gần nhất)</td>
                    <td align="right">{$data.company.OperatingMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.OperatingMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.OperatingMargin_TTM|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Tỷ lệ lãi từ hoạt động KD (Năm gần nhất)</td>
                    <td align="right">{$data.company.OperatingMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.OperatingMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.OperatingMargin_LFY|num_format:2:'%'}</td>                      
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi từ hoạt động KD (Bình quân 3 năm gần nhất)</td>
                    <td align="right">{$data.company.OperatingMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.OperatingMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.OperatingMargin_03Yr|num_format:2:'%'}</td>                      
                </tr>
                <tr>                
                    <td>Tỷ lệ lãi trước thuế (4 quý gần nhất)</td>
                    <td align="right">{$data.company.PreTaxMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.PreTaxMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.PreTaxMargin_TTM|num_format:2:'%'}</td>                      
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi trước thuế (Năm gần nhất)</td>
                     <td align="right">{$data.company.PreTaxMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.PreTaxMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.PreTaxMargin_LFY|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Tỷ lệ lãi trước thuế (Bình quân 3 năm gần nhất)</td>
                    <td align="right">{$data.company.PreTaxMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.PreTaxMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.PreTaxMargin_03Yr|num_format:2:'%'}</td>                      
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi ròng (4 quý gần nhất)</td>                    
                    <td align="right">{$data.company.ProfitMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitMargin_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitMargin_TTM|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Tỷ lệ lãi ròng (Năm gần nhất)</td>
                    <td align="right">{$data.company.ProfitMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitMargin_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitMargin_LFY|num_format:2:'%'}</td>                      
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi ròng (Bình quân 3 năm gần nhất)</td>
                    <td align="right">{$data.company.ProfitMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ProfitMargin_03Yr|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ProfitMargin_03Yr|num_format:2:'%'}</td>                      
                </tr>
                </tbody>    
            </table>
        </div>
         <!-- /CO CAU CO DONG -->
        
        <!-- CO CAU CO DONG -->
        <div class="headline1 text margin_bottom_10px">
        Hiệu quả quản lý
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    <th align="right">Doanh nghiệp</th>
                    <th align="right">Ngành</th>
                    <th align="right">Lĩnh vực</th>
                                
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Lợi nhuận trên tổng tài sản - ROA (4 quý gần nhất)</td>    
                    <td align="right">{$data.company.ROA_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ROA_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ROA_TTM|num_format:2:'%'}</td>                                                     
                </tr>
                <tr>
                    <td>Lợi nhuận trên tổng tài sản - ROA (Năm gần nhất)</td>
                    <td align="right">{$data.company.ROA_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ROA_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ROA_LFY|num_format:2:'%'}</td>                           
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Lợi nhuận trên tổng tài sản - ROA (Bình quân 3 năm gần nhất)</td>
                    <td align="right">{$data.company.ROA_03YrAvg|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ROA_03YrAvg|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ROA_03YrAvg|num_format:2:'%'}</td>                                  
                </tr>
                
                <tr>
                    <td>Lợi nhuận trên vốn CSH - ROE (4 quý gần nhất)</td>
                    <td align="right">{$data.company.ROE_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ROE_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ROE_TTM|num_format:2:'%'}</td>                              
                </tr>
                
                <tr  bgcolor="#f0f0f0">
                    <td>Lợi nhuận trên vốn CSH - ROE (Năm gần nhất)</td>
                    <td align="right">{$data.company.ROE_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ROE_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ROE_LFY|num_format:2:'%'}</td>                         
                </tr>
                <tr>
                    <td>Lợi nhuận trên vốn CSH - ROE (Bình quân 3 năm gần nhất)</td>
                    <td align="right">{$data.company.ROE_03YrAvg|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ROE_03YrAvg|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ROE_03YrAvg|num_format:2:'%'}</td>                      
                </tr>
                <tr>
                    <td>Lợi nhuận trên vốn đầu tư (4 quý gần nhất)</td>
                    <td align="right">---</td>   
                    <td align="right">---</td>   
                    <td align="right">---</td>                                            
                </tr>
                <tr>
                    <td>Lợi nhuận trên vốn đầu tư (Bình quân 3 năm gần nhất)</td>
                    <td align="right">---</td>   
                    <td align="right">---</td>   
                    <td align="right">---</td>                      
                </tr>
                </tbody>    
            </table>
        </div>
         <!-- /CO CAU CO DONG -->
         <!-- CO CAU CO DONG -->
        <div class="headline1 text margin_bottom_10px">
        Năng lực hoạt động
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    <th align="right">Doanh nghiệp</th>
                    <th align="right">Ngành</th>
                    <th align="right">Lĩnh vực</th>                              
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Vòng quay hàng tồn kho (4 quý gần nhất)</td>    
                    <td align="right">{$data.company.InventoryTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.InventoryTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.InventoryTurnover_TTM|num_format:2:'%'}</td>                                                                         
                </tr>
                <tr>
                    <td>Vòng quay các khoản phải thu (4 quý gần nhất)</td>
                    <td align="right">{$data.company.ReceivablesTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.ReceivablesTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.ReceivablesTurnover_TTM|num_format:2:'%'}</td>                                 
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Vòng quay vốn lưu động (4 quý gần nhất)</td>
                    <td align="right">{$data.company.CurrentAssetsTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.CurrentAssetsTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.CurrentAssetsTurnover_TTM|num_format:2:'%'}</td>                                                       
                </tr>
                
                <tr>
                    <td>Vòng quay tổng tài sản (4 quý gần nhất)</td>
                    <td align="right">{$data.company.AssetsTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.industry.AssetsTurnover_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.sector.AssetsTurnover_TTM|num_format:2:'%'}</td>                               
                </tr>                
                </tbody>    
            </table>
        </div>
         <!-- /CO CAU CO DONG -->
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