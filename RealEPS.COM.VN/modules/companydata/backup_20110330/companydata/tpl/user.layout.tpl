{include file="$_MODULE_ABSPATH/tpl/StockSearch.tpl"}
<div class="left">
	<!-- DU LIEU DOANH NGHIEP -->	
	<div class="panel margin_bottom_10px_float" style="width:235px;">
	    <h4>
	        <span class="header"><img src="/images/transparent.png" class="icon_panel" style="margin-right:5px"/>Dữ liệu doanh nghiệp</span>
	    </h4>	   
	    <div class="panel_content">
	     	<ul class="menu">	     
	     		<!-- LOOP -->	   	     	
	     		<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="/doanh-nghiep/nganh/index.html#content">Dữ liệu ngành nghề</a>	     		
	     		</li>
	     		<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="/doanh-nghiep/cong-ty/index.html#content">Dữ liệu công ty</a>	     		
	     		</li>
	     		<!--<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="#">Dành cho khách hàng của EPS</a>	     		
	     		</li>
	     		--><!-- /LOOP -->
	     	</ul>
	    </div>
	    <div class="panel_bottom_left"></div>       
	    <div class="panel_bottom" style="width: 227px;"></div>
	    <div class="panel_bottom_right"></div>     
      	<div class="clear"></div>        	        
	</div>    
	<!-- /DU LIEU DOANH NGHIEP -->
	
	<!-- XEM BAO CAO THEO LOAI -->	
	<!--<div class="panel margin_bottom_10px_float" style="width:235px;">
	    <h4>
	        <span class="header"><img src="/images/transparent.png" class="icon_panel" style="margin-right:5px"/>Xem báo cáo theo loại</span>
	    </h4>	   
	    <div class="panel_content">
	     	<ul class="menu">	     
	     		 LOOP 	   	     	
	     		<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="#">Phân tích công ty</a>	     		
	     		</li>
	     		<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="#">Tổng quan thị trường</a>	     		
	     		</li>
	     		<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="#">Phân tích ngành</a>	     		
	     		</li>
	     		<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="#">Thị trường thế giới</a>	     		
	     		</li>
	     		<li>	     				     			
	     			<img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
	     			<a href="#">Kinh tế vĩ mô</a>	     		
	     		</li>
	     		 /LOOP 
	     	</ul>
	    </div>
	    <div class="panel_bottom_left"></div>       
	    <div class="panel_bottom" style="width: 227px;"></div>
	    <div class="panel_bottom_right"></div>     
      	<div class="clear"></div>         	        
	</div>    
	--><!-- /XEM BAO CAO THEO LOAI -->
	
	<!-- BAO CAO PHAN TICH MOI NHAT -->
	<div class="panel margin_bottom_10px_float" style="width:235px;">
	    <h4>
	        <span class="header"><img src="/images/transparent.png" class="icon_panel" style="margin-right:5px"/>Tiêu điểm thị trường</span>
	    </h4>
	   
	    <div class="panel_content" style="font-weight: bold;">
	    	<ul style="list-style: none;">
	    	{news_tieudiem assign="tieudiem"}
	    	{foreach from=$tieudiem item=item}	    																	
            <li class="margin_bottom_10px" style="border-bottom: 1px dotted #000;">                  	  
                <div class="title margin_bottom_5px" ><img src="/images/transparent.png" class="icon_panel1"/> <a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" title="">{$item.news_title}</a></div>                                                                               
                <table width="100%"><tr>             	              	
            	  </tr><tr>
            	  <td align="left" style="color: #3030a2">{$item.news_created|date_format}</td><td align="right" valign="bottom"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html">Chi tiết</a></td></tr>
            	  </table>                      	                                                                                                                                      
                <div class="line"></div>                
             </li>                          		               							
	    	{/foreach}
	    	</ul> 
	    	<div style="text-align: center;">
	    	<a href="/tin-tuc/tieu-diem/index.html" class="link">Xem tất cả</a>
	    	</div>
	    </div>
	    <div class="panel_bottom_left"></div>       
	    <div class="panel_bottom" style="width: 227px;"></div>
	    <div class="panel_bottom_right"></div>     
      	<div class="clear"></div>         	        
	</div>    
	<!-- /BAO CAO PHAN TICH MOI NHAT -->
	
	<!-- LICH SU TRA CUU -->
	<div class="panel" style="width:235px;">
	    <h4>
	        <span class="header"><img src="/images/transparent.png" class="icon_panel" style="margin-right:5px"/>Lịch sử tra cứu</span>
	    </h4>
	   
	    <div class="panel_content" style="font-weight: normal;" id="stock_history">
	    	{stock_history}	    	
	    </div>
	    <div class="panel_bottom_left"></div>       
	    <div class="panel_bottom" style="width: 227px;"></div>
	    <div class="panel_bottom_right"></div>     
      	<div class="clear"></div>            	        
	</div>    
	<!-- /LICH SU TRA CUU -->
</div>
<a name="content"></a>
{include file="$_MODULE_ABSPATH/tpl/$_type.$_page.$_func.tpl"}
