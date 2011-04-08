<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU TONG QUAN -->	   		
   			<a href="#" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Các cổ đông chính
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
            <div class="clear"></div>
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