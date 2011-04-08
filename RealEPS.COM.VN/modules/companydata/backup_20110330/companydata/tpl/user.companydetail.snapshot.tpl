<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU TONG QUAN -->	   		
   			<a href="#" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Hồ sơ doanh nghiệp
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
        <!-- /THUOC LINH VUC --> 
		<div class="text margin_bottom_5px" style="border-bottom: 1px solid #d3dce9; padding-bottom: 5px;">
        {$data.company.Overview}
        </div>
        <div class="margin_bottom_10px">
            <div class="left" style="line-height: 160%">
            <b>{$data.company.CompanyName}</b><br/>
            {$data.company.HeadQuarters}<br/>
            Phone: {$data.company.Phone}<br/> 
            Fax: {$data.company.Fax}<br/>
            Email: {$data.company.Email}<br/>
            </div>
            <div class="right margin_left_10px text">
            <table cellpadding="0" cellspacing="0" class="small">
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Số lượng nhân sự</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">---</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Số lượng chi nhánh</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">---</th>
                </tr>
                <tr>
                    <td style="border-bottom: 2px solid #CCCCCC;">Website</td>
                    <th style="border-bottom: 2px solid #CCCCCC;" align="right"><a href="http://{$data.company.WebAddress}">{$data.company.WebAddress}</a></th>
                </tr>
            </table>
            </div>
            <div class="clear"></div>
        </div>
        <!-- LICH SU HINH THANH -->
        <div class="headline1 text">
        Lịch sử hình thành
        </div>
        <div class="text info margin_bottom_10px">{$data.company.History}</div>
        <!-- /LICH SU HINH THANH -->
        <!-- LINH VUC KINH DOANH -->
        <div class="headline1 text margin_bottom_10px">
       	Lĩnh vực kinh doanh
        </div>
        <div class="text info">{$data.company.BusinessAreas}</div>
        <!-- /LINH VUC KINH DOANH-->
         <!-- THONG TIN HDKD -->
        <div class="headline1 text margin_bottom_10px">
        Thông tin HĐKD
        </div>
        <div class="text info">
         <table cellpadding="0" cellspacing="5" width="100%" class="small">
                <col width="30%" />
                <col width="70%" />
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Số ĐKKD</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.BusinessLicenseNumber}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Ngày cấp ĐKKD</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.DateOfIssue|date_format:"%d/%m/%Y"}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Vốn điều lệ</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.RegisteredCapital|num_format:0}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Mã số thuế</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.TaxIDNumber}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 2px solid #CCCCCC;">Ngành nghề KD</td>
                    <th style="border-bottom: 2px solid #CCCCCC;" align="right">
                    <a href="/doanh-nghiep/linh-vuc/{$data.company.SectorId}/index.html" class="bluelink">{$data.company.SectorName}</a> >
        <a href="/doanh-nghiep/nganh/{$data.company.IndustryID}/index.html" class="bluelink">{$data.company.IndustryName}</a>
                    </th>
                </tr>
            </table>
        </div>
        <!-- /THONG TIN HDKD-->
        <!-- THONG TIN NIEM YET -->
        <div class="headline1 text margin_bottom_10px">
        Thông tin niêm yết
        </div>
        <div class="text info">
         <table cellpadding="0" cellspacing="5" width="100%" class="small">
                <col width="30%" />
                <col width="70%" />
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Ngày niêm yết</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.DateOfListing|date_format:"%d/%m/%Y"}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Nơi niêm yết</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.Bourse}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Mệnh giá</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.ParValue|num_format:0}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">Giá chào sàn</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.InitialListingPrice|num_format:0}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #CCCCCC;">KL đang niêm yết</td>
                    <th style="border-bottom: 1px solid #CCCCCC;" align="right">{$data.company.ListingVolume|num_format:0}</th>
                </tr>
                <tr>
                    <td style="border-bottom: 2px solid #CCCCCC;">Tổng giá trị niêm yết</td>
                    <th style="border-bottom: 2px solid #CCCCCC;" align="right">
                    {$data.company.TotalListingValue|num_format:0}
                    </th>
                </tr>
            </table>
        </div>
        <!-- /THONG TIN NIEM YET-->
        <!-- BAN LANH DAO -->
        <div class="headline1 text margin_bottom_10px">
        Ban lãnh đạo
        </div>
        <div class="text info">
         <table cellpadding="0" cellspacing="5" width="100%" class="small">
                <col width="30%" />
                <col width="70%" />
                {foreach from=$data.officers item=item name=loop}                
                <tr>
                    <td style="border-bottom: {if $smarty.foreach.loop.last}2px{else}1px{/if} solid #CCCCCC;">{$item.OfficerName}</td>
                    <th style="border-bottom: {if $smarty.foreach.loop.last}2px{else}1px{/if} solid #CCCCCC;" align="right">{$item.Position}</th>
                </tr>    
                {/foreach}           
            </table>
        </div>
        <!-- /BAN LANH DAO-->
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