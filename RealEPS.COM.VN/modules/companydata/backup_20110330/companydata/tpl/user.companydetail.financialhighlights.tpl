<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU TONG QUAN -->	   		
   			<a href="#" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Tổng quan tài chính
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
        Tăng trưởng (Tính đến quý {$data.company.Quarter} năm {$data.company.Year})
        </div>
        <div class="text info margin_bottom_10px">
         <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    <th align="right">Quý gần nhất</th>
                    <th align="right">Quý gần nhì</th>
                    <th align="right">4 quý gần nhất</th>
                    <th align="right">Năm gần nhất</th>
                    <th align="right">3 năm</th>                    
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Doanh thu %</td>    
                    <td align="right">{$data.company.SalesGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.SalesGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.SalesGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.SalesGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.SalesGrowth_03Yr|num_format:2:'%'}</td> 
                               
                </tr>
                <tr>
                    <td>Lợi nhuận %</td>
                    <td align="right">{$data.company.ProfitGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.ProfitGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.ProfitGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.ProfitGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.ProfitGrowth_03Yr|num_format:2:'%'}</td>  
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>EPS (cơ bản) %</td>
                    <td align="right">{$data.company.BasicEPSGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.BasicEPSGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.BasicEPSGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.BasicEPSGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.BasicEPSGrowth_03Yr|num_format:2:'%'}</td>           
                </tr>
                
                <tr>
                    <td>EPS (điều chỉnh) %</td>
                    <td align="right">{$data.company.DilutedEPSGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DilutedEPSGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DilutedEPSGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DilutedEPSGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DilutedEPSGrowth_03Yr|num_format:2:'%'}</td>            
                </tr>
                
                <tr  bgcolor="#f0f0f0">
                    <td>Tổng tài sản %</td>
                    <td align="right">{$data.company.TotalAssetsGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.TotalAssetsGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.TotalAssetsGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.TotalAssetsGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.TotalAssetsGrowth_03Yr|num_format:2:'%'}</td>  
                </tr>
                <tr>
                    <td>Cổ tức %</td>
                    <td align="right">{$data.company.DividendGrowth_MRQ|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DividendGrowth_MRQ2|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DividendGrowth_TTM|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DividendGrowth_LFY|num_format:2:'%'}</td>   
                    <td align="right">{$data.company.DividendGrowth_03Yr|num_format:2:'%'}</td> 
                </tr>
                </tbody>    
            </table>
        </div>
         <!-- /TANG TRUONG -->  
         <!-- DOANH THU -->
        <div class="headline1 text margin_bottom_10px">
        Doanh thu
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                     {section name=foo start=`$data.company.Year-3` loop=`$data.company.Year+1` step=1}                     
                    <th align="right">{$smarty.section.foo.index}</th>
                    {/section}                        
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Quý 1</td>       
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>             
                </tr>
                <tr>
                    <td>Quý 2</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Quý 3</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr>
                    <td>Quý 4</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td><b>Tổng cộng</b></td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                
                </tbody>    
            </table>
        </div>
         <!-- /DOANH THU -->
         <!-- LOI NHUAN -->
        <div class="headline1 text margin_bottom_10px">
        Lợi nhuận
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                     {section name=foo start=`$data.company.Year-3` loop=`$data.company.Year+1` step=1}                     
                    <th align="right">{$smarty.section.foo.index}</th>
                    {/section}                       
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Quý 1</td>       
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>             
                </tr>
                <tr>
                    <td>Quý 2</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Quý 3</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr>
                    <td>Quý 4</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td><b>Tổng cộng</b></td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                
                </tbody>    
            </table>
        </div>
         <!-- /LOI NHUAN -->
           
         <!-- CO CAU CO DONG -->
        <div class="headline1 text margin_bottom_10px">
        EPS cơ bản (Tính theo số lượng cổ phiếu lưu hành bình quân)
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                     {section name=foo start=`$data.company.Year-3` loop=`$data.company.Year+1` step=1}                     
                    <th align="right">{$smarty.section.foo.index}</th>
                    {/section}                        
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Quý 1</td>       
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>             
                </tr>
                <tr>
                    <td>Quý 2</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Quý 3</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr>
                    <td>Quý 4</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td><b>Tổng cộng</b></td>
                    <td align="right">---</td>  
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
        EPS pha loãng (Tính theo số lượng cổ phiếu lưu hành cuối kỳ)
        </div>
        <div class="text info margin_bottom_10px">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th></th>
                    {section name=foo start=`$data.company.Year-3` loop=`$data.company.Year+1` step=1}                     
                    <th align="right">{$smarty.section.foo.index}</th>
                    {/section}                                   
                </tr>
                </thead>
                <tbody>                
                <tr bgcolor="#f0f0f0">
                    <td>Quý 1</td>       
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>             
                </tr>
                <tr>
                    <td>Quý 2</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr bgcolor="#f0f0f0">
                    <td>Quý 3</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr>
                    <td>Quý 4</td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td><b>Tổng cộng</b></td>
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td>  
                    <td align="right">---</td> 
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