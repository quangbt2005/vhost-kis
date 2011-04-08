<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU DANH SACH NGANH -->	   		
   			<a href="/doanh-nghiep/nganh/index.html#content" class="panel_button left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Danh sách ngành
        	</span></a>
        	<!-- /MENU DANH SACH NGANH -->
        	<!-- MENU SO SANH NGANH -->	
        	<a href="/doanh-nghiep/nganh/sosanh.html#content" class="panel_button_active margin_left_20px left">   			
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
		<div class="boldtext margin_bottom_10px">Chọn một ngành nghề/lĩnh vực trong danh sách bên dưới để xem thông tin chi tiết.</div>
		<!-- CAC NGHANH NGHE -->
		<div class="tabpanel margin_bottom_10px">
			<!--[if lte IE 7]>
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
	    	<![endif]--> 
			<div class="header">
				
				<a href="?view=0#content" {if $data.view==0}class="active"{/if}><span>Định giá</span></a>
				<a href="?view=1#content" {if $data.view==1}class="active"{/if}><span>Sức mạnh tài chính</span></a>
				<a href="?view=2#content" {if $data.view==2}class="active"{/if}><span>Khả năng hoạt động</span></a>
				<a href="?view=3#content" {if $data.view==3}class="active"{/if}><span>Khả năng sinh lợi</span></a>
				<a href="?view=4#content" {if $data.view==4}class="active"{/if}><span>Hiệu quả quản lý</span></a>
				<a href="?view=5#content" {if $data.view==5}class="active"{/if}><span>Tăng trưởng</span></a>
				<div class="clear"></div>
			</div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
			<div class="content">
			{include file="$_MODULE_ABSPATH/tpl/$_type.$_page.view`$data.view`.tpl"}
			</div>
		</div>
		<!-- /CAC NGHANH NGHE -->
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