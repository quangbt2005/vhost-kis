<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU TONG QUAN -->	   		
   			<a href="#" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Thống kê chính
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
        <!-- LINE 1 -->
        <!-- Quy mo -->
        <div class="left" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Quy mô
        </div>
        <div class="text info margin_bottom_10px">
         <table cellpadding="0" cellspacing="0" width="100%" class="small">              
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Số cổ phần đang lưu hành</td>    
                    <th align="right">{$data.company.SharesOutstanding|num_format:2:' triệu'}</th>                                                      
                </tr>
                {if $data.company.TotalAssets_MRQ != ''}
                <tr>
                    <td>Tổng cộng tài sản (MRQ)</td>
                    <th align="right">{$data.company.TotalAssets_MRQ|num_format:2:' tỷ'}</th>                       
                </tr>
                {else}
                <tr>
                    <td>Tổng cộng tài sản (LFY)</td>
                    <th align="right">{$data.company.TotalAssets_LFY|num_format:2:' tỷ'}</th>                       
                </tr>
                {/if}
                
                {if $data.company.Equity_MRQ != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Vốn chủ sở hữu (MRQ)</td>
                    <th align="right">{$data.company.Equity_MRQ|num_format:2:' tỷ'}</th>                               
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Vốn chủ sở hữu (LFY)</td>
                    <th align="right">{$data.company.Equity_LFY|num_format:2:' tỷ'}</th>                               
                </tr>
                {/if}
                
                {if $data.company.Sales_TTM != ''}
                <tr>
                    <td>Doanh thu thuần (TTM)</td>
                    <th align="right">{$data.company.Sales_TTM|num_format:2:' tỷ'}</th>                              
                </tr>
                {else}
                <tr>
                    <td>Doanh thu thuần (LFY)</td>
                    <th align="right">{$data.company.Sales_LFY|num_format:2:' tỷ'}</th>                              
                </tr>
                {/if}
                
                {if $data.company.ProfitAfterTax_TTM != ''}
                <tr  bgcolor="#f0f0f0">
                    <td>Lợi nhuận sau thuế (TTM)</td>
                    <th align="right">{$data.company.ProfitAfterTax_TTM|num_format:2:' tỷ'}</th>                      
                </tr>
                {else}
                <tr  bgcolor="#f0f0f0">
                    <td>Lợi nhuận sau thuế (LFY)</td>
                    <th align="right">{$data.company.ProfitAfterTax_LFY|num_format:2:' tỷ'}</th>                      
                </tr>
                {/if}
                
                <tr>
                    <td>Thị giá vốn</td>
                    <th align="right">{$data.company.MarketCapitalization|num_format:2:' tỷ'}</th>                       
                </tr>
                </tbody>    
            </table>
        </div>
        </div>
         <!-- /Quy mo -->  
         <!-- Suc manh tai chinh -->
        <div class="right" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Doanh thu
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">                
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Khả năng thanh toán nhanh (MRQ)</td>       
                    <th align="right">{$data.company.QuickRatio_MRQ|num_format:2:'x'}</th>                             
                </tr>
                <tr>
                    <td>Khả năng thanh toán hiện hành (MRQ)</td>
                    <th align="right">{$data.company.CurrentRatio_MRQ|num_format:2:'x'}</th>                      
                </tr>
                
                {if $data.company.TotalDebtOverEquity_TTM != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Nợ/Vốn chủ sở hữu (TTM)</td>
                    <th align="right">{$data.company.TotalDebtOverEquity_TTM|num_format:2:'x'}</th>                      
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Nợ/Vốn chủ sở hữu (MRQ)</td>
                    <th align="right">{$data.company.TotalDebtOverEquity_MRQ|num_format:2:'x'}</th>                      
                </tr>
                {/if}
                
                <tr>
                    <td>Nợ/Tổng tài sản (MRQ)</td>
                    <th align="right">{$data.company.TotalDebtOverAssets_MRQ|num_format:2:'x'}</th>                      
                </tr>                
                </tbody>    
            </table>
        </div>
         <!-- /Suc manh tai chinh -->
         </div>
         <div class="clear"></div>
         <!-- /LINE 1 -->
         
         <!-- LINE 2 -->
        <!-- Quy mo -->
        <div class="left" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Định giá
        </div>
        <div class="text info margin_bottom_10px">
         <table cellpadding="0" cellspacing="0" width="100%" class="small">              
                <tbody>       
                {if $data.company.DilutedPE_MRQ != ''}         
                <tr bgcolor="#f0f0f0">
                    <td>P/E pha loãng (MRQ)</td>    
                    <th align="right">{$data.company.DilutedPE_MRQ|num_format:2:'x'}</th>                                                      
                </tr>
                {elseif $data.company.DilutedPE_TTM != ''}
                <tr bgcolor="#f0f0f0">
                    <td>P/E pha loãng (TTM)</td>    
                    <th align="right">{$data.company.DilutedPE_TTM|num_format:2:'x'}</th>                                                      
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>P/E pha loãng (LFY)</td>    
                    <th align="right">{$data.company.DilutedPE_LFY|num_format:2:'x'}</th>                                                      
                </tr>
                {/if}
                
                {if $data.company.PS_MRQ != ''}
                <tr>
                    <td>P/S (LFY)</td>
                    <th align="right">{$data.company.PS_MRQ|num_format:2:'x'}</th>                       
                </tr>
                {elseif $data.company.PS_TTM != ''}
                <tr>
                    <td>P/S (TTM)</td>
                    <th align="right">{$data.company.PS_TTM|num_format:2:'x'}</th>                       
                </tr>
                {else}
                <tr>
                    <td>P/S (LFY)</td>
                    <th align="right">{$data.company.PS_LFY|num_format:2:'x'}</th>                       
                </tr>
                {/if}
                
                <tr bgcolor="#f0f0f0">
                    <td>P/B (MRQ)</td>
                    <th align="right">{$data.company.PB_MRQ|num_format:2:'x'}</th>                               
                </tr>
               {if $data.company.BasicEPS_MRQ != ''}
                <tr>
                    <td>EPS cơ bản (MRQ)</td>
                    <th align="right">{$data.company.BasicEPS_MRQ|num_format:2:'x'}</th>                              
                </tr>
                {else}
                <tr>
                    <td>EPS cơ bản (TTM)</td>
                    <th align="right">{$data.company.BasicEPS_TTM|num_format:2:'x'}</th>                              
                </tr>
                {/if}               
                </tbody>    
            </table>
        </div>
        </div>
         <!-- /Quy mo -->  
         <!-- Suc manh tai chinh -->
        <div class="right" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Khả năng sinh lợi
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">                
                <tbody>        
                {if $data.company.GrossMargin_TTM != ''}        
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi gộp (TTM)</td>       
                    <th align="right">{$data.company.GrossMargin_TTM|num_format:2:' %'}</th>                             
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ lãi gộp (LFY)</td>       
                    <th align="right">{$data.company.GrossMargin_LFY|num_format:2:' %'}</th>                             
                </tr>
                {/if}
                {if $data.company.OperatingMargin_TTM}
                <tr>
                    <td>Tỷ lệ lãi từ HĐ SXKD (TTM)</td>
                    <td align="right">{$data.company.OperatingMargin_TTM|num_format:2:' %'}</td>                      
                </tr>
                {else}
                <tr>
                    <td>Tỷ lệ lãi từ HĐ SXKD (LFY)</td>
                    <th align="right">{$data.company.OperatingMargin_LFY|num_format:2:' %'}</th>                      
                </tr>
                {/if}
                {if $data.company.EBITMargin_TTM}
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ EBIT (TTM)</td>
                    <th align="right">{$data.company.EBITMargin_TTM|num_format:2:' %'}</th>                      
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ EBIT (LFY)</td>
                    <th align="right">{$data.company.EBITMargin_LFY|num_format:2:' %'}</th>                      
                </tr>
                {/if}
                {if $data.company.ProfitMargin_TTM != ''}
                <tr>
                    <td>Tỷ lệ lãi ròng (TTM)</td>
                    <th align="right">{$data.company.ProfitMargin_TTM|num_format:2:' %'}</th>                      
                </tr>                
                {else}
                <tr>
                    <td>Tỷ lệ lãi ròng (LFY)</td>
                    <th align="right">{$data.company.ProfitMargin_LFY|num_format:2:' %'}</th>                      
                </tr>  
                {/if}
                </tbody>    
            </table>
        </div>
         <!-- /Suc manh tai chinh -->
         </div>
         <div class="clear"></div>
         <!-- /LINE 2 -->
         
          <!-- LINE 3 -->
        <!-- Quy mo -->
        <div class="left" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Hiệu quả quản lý
        </div>
        <div class="text info margin_bottom_10px">
         <table cellpadding="0" cellspacing="0" width="100%" class="small">              
                <tbody>                
                {if $data.company.ROA_TTM}
                <tr bgcolor="#f0f0f0">
                    <td>Thu nhập trên tài sản - ROA (TTM)</td>     
                    <th align="right">{$data.company.ROA_TTM|num_format:2:' %'}</th>                                                      
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Thu nhập trên tài sản - ROA (LFY)</td>     
                    <th align="right">{$data.company.ROA_LFY|num_format:2:' %'}</th>                                                      
                </tr>
                {/if}
                {if $data.company.ROE_TTM != ''}
                <tr>
                    <td>Thu nhập trên vốn chủ - ROE (TTM)</td>
                    <th align="right">{$data.company.ROE_TTM|num_format:2:' %'}</th>                       
                </tr>
                {else}
                <tr>
                    <td>Thu nhập trên vốn chủ - ROE (LFY)</td>
                    <th align="right">{$data.company.ROE_LFY|num_format:2:' %'}</th>                       
                </tr>
                {/if}
                
                <tr bgcolor="#f0f0f0">
                    <td>Thu nhập trên vốn đầu tư - ROIC (TTM)</td>
                    <td align="right">---</td>                               
                </tr>                      
                </tbody>    
            </table>
        </div>
        </div>
         <!-- /Quy mo -->  
         <!-- Suc manh tai chinh -->
        <div class="right" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Tăng trưởng
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">                
                <tbody>        
                {if $data.company.BasicEPSGrowth_MRQ != ''}        
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS cơ bản (MRQ)</td>       
                    <th align="right">{$data.company.BasicEPSGrowth_MRQ|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.BasicEPSGrowth_MRQ2 != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS cơ bản (MRQ2)</td>       
                    <th align="right">{$data.company.BasicEPSGrowth_MRQ2|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.BasicEPSGrowth_TTM != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS cơ bản (TTM)</td>       
                    <th align="right">{$data.company.BasicEPSGrowth_TTM|num_format:2:' %'}</th>                             
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng EPS cơ bản (LFY)</td>       
                    <th align="right">{$data.company.BasicEPSGrowth_LFY|num_format:2:' %'}</th>                             
                </tr>
                {/if}
                
                {if $data.company.SalesGrowth_MRQ != ''}        
                <tr>
                    <td>Tăng trưởng doanh thu (MRQ)</td>       
                    <th align="right">{$data.company.SalesGrowth_MRQ|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.SalesGrowth_MRQ2 != ''}
                <tr>
                    <td>Tăng trưởng doanh thu (MRQ2)</td>       
                    <th align="right">{$data.company.SalesGrowth_MRQ2|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.SalesGrowth_TTM != ''}
                <tr>
                    <td>Tăng trưởng doanh thu (TTM)</td>       
                    <th align="right">{$data.company.SalesGrowth_TTM|num_format:2:' %'}</th>                             
                </tr>
                {else}
                <tr>
                    <td>Tăng trưởng doanh thu (LFY)</td>       
                    <th align="right">{$data.company.SalesGrowth_LFY|num_format:2:' %'}</th>                             
                </tr>
                {/if}
                                              
                
                
                {if $data.company.ProfitGrowth_MRQ != ''}        
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng lợi nhuận (MRQ)</td>       
                    <th align="right">{$data.company.ProfitGrowth_MRQ|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.ProfitGrowth_MRQ2 != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng lợi nhuận (MRQ2)</td>       
                    <th align="right">{$data.company.ProfitGrowth_MRQ2|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.ProfitGrowth_TTM != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng lợi nhuận (TTM)</td>       
                    <th align="right">{$data.company.ProfitGrowth_TTM|num_format:2:' %'}</th>                             
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng lợi nhuận (LFY)</td>       
                    <th align="right">{$data.company.ProfitGrowth_LFY|num_format:2:' %'}</th>                             
                </tr>
                {/if}
                   
                {if $data.company.TotalAssetsGrowth_MRQ != ''}        
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng tài sản (MRQ)</td>       
                    <th align="right">{$data.company.TotalAssetsGrowth_MRQ|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.TotalAssetsGrowth_MRQ2 != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng tài sản (MRQ2)</td>       
                    <th align="right">{$data.company.TotalAssetsGrowth_MRQ2|num_format:2:' %'}</th>                             
                </tr>
                {elseif $data.company.TotalAssetsGrowth_TTM != ''}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng tài sản (TTM)</td>       
                    <th align="right">{$data.company.TotalAssetsGrowth_TTM|num_format:2:' %'}</th>                             
                </tr>
                {else}
                <tr bgcolor="#f0f0f0">
                    <td>Tăng trưởng tài sản (LFY)</td>       
                    <th align="right">{$data.company.TotalAssetsGrowth_LFY|num_format:2:' %'}</th>                             
                </tr>
                {/if}                                         
                </tbody>    
            </table>
        </div>
         <!-- /Suc manh tai chinh -->
         </div>
         <div class="clear"></div>
         <!-- /LINE 3 -->
         
         <!-- LINE 4 -->
        <!-- Quy mo -->
        <div class="left" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Cổ tức
        </div>
        <div class="text info margin_bottom_10px">
         <table cellpadding="0" cellspacing="0" width="100%" class="small">              
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Tỷ lệ cổ tức/giá (LFY)</td>    
                    <td align="right">{$data.company.DividendYield_LFY|num_format:2:'x'}</td>                                                      
                </tr>
                <tr>
                    <td>Tỷ lệ trả cổ tức (LFY)</td>
                    <td align="right">{$data.company.PayoutRatio_LFY|num_format:2:'x'}</td>                       
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Cổ tức hàng năm (LFY)</td>
                    <td align="right">{$data.company.AnnualDividend_LFY|num_format:2:'x'}</td>                               
                </tr>                      
                </tbody>    
            </table>
        </div>
        </div>
         <!-- /Quy mo -->  
         <!-- Suc manh tai chinh -->
        <div class="right" style="width: 365px;">
        <div class="headline1 text margin_bottom_10px">
        Khả năng hoạt động
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">                
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Vòng quay tổng tài sản (TTM)</td>       
                    <td align="right">{$data.company.AssetsTurnover_TTM|num_format}</td>                             
                </tr>
                <tr>
                    <td>Vòng quay hàng tồn kho (TTM)</td>
                    <td align="right">{$data.company.InventoryTurnover_TTM|num_format}</td>                      
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Vòng quay các khoản phải thu (TTM)</td>
                    <td align="right">{$data.company.ReceivablesTurnover_TTM|num_format}</td>                      
                </tr>                        
                </tbody>    
            </table>
        </div>
         <!-- /Suc manh tai chinh -->
         </div>
         <div class="clear"></div>
         <!-- /LINE 3 -->
         
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