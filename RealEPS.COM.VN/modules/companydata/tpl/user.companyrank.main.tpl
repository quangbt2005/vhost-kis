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
        	<a href="/doanh-nghiep/nganh/sosanh.html" class="panel_button margin_left_20px left">   			
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
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/index.html" ><span>Tổng quan ngành</span></a>
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/tintuc.html"><span>Tin tức liên quan</span></a>
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/sosanh.html"><span>Thống kê ngành</span></a>
				<a href="#" class="active"><span>Xếp hạng doanh nghiệp</span></a>
				{else}
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/index.html"><span>Tổng quan ngành</span></a>
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/tintuc.html"><span>Tin tức liên quan</span></a>
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/sosanh.html"><span>Thống kê ngành</span></a>
				<a href="#" class="active"><span>Xếp hạng doanh nghiệp</span></a>
				{/if}
				<div class="clear"></div>
			</div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
			<div class="content text">
			<div style="background: #e5e5e5; height: 4px;"></div>
			<div style="background: #F8F8F8; padding:5px;" >
				<a href="?view=0" {if $data.view==0}class="bluelink"{/if}>Tổng quan</a> | 
				<a href="?view=1" {if $data.view==1}class="bluelink"{/if}>Giao dịch hôm nay</a> | 
				<a href="?view=2" {if $data.view==2}class="bluelink"{/if}>Biến động giá</a> |
				<a href="?view=3" {if $data.view==3}class="bluelink"{/if}>Thống kê chính</a> |
				<a href="?view=4" {if $data.view==4}class="bluelink"{/if}>Định giá</a> |
				<a href="?view=5" {if $data.view==5}class="bluelink"{/if}>Tăng trưởng</a>
			</div>
			{include file="$_MODULE_ABSPATH/tpl/$_type.$_page.view`$data.view`.tpl"}
			<div style="background: #e5e5e5; height: 1px;"></div>
			</div>
		</div>
		<!-- /TONG QUAN NGANH -->		
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