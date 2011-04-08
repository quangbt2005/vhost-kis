<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
    	<table cellpadding="0" cellspacing="0" class="header_right">
    	<tr><td>        	 	        	
 		   	<!-- MENU DANH SACH NGANH -->	   		
   			<a href="/doanh-nghiep/nganh/index.html#content" class="panel_button_active left">   			
   			<span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
        	Danh sách ngành
        	</span></a>
        	<!-- /MENU DANH SACH NGANH -->
        	<!-- MENU SO SANH NGANH -->	
        	<a href="/doanh-nghiep/nganh/sosanh.html#content" class="panel_button margin_left_20px left">   			
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
		<table width="100%"><tr>
		<td valign="top">
			{foreach from=$data.sector_col1 item=item name=loop} 
			<ul class="list">
				<li>
					<div class="header"><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
					<a href="/doanh-nghiep/linh-vuc/{$item.SectorId}/index.html#content">{$item.Name}</a></div>
					<ul>
						{foreach from=$item.Industries item=subitem}
						<li>
						<img src="/images/icon_arrow1.gif" />
						<a href="/doanh-nghiep/nganh/{$subitem.IndustryId}/index.html#content">{$subitem.Name}</a>
						</li>
						{/foreach}
					</ul>
				</li>
			</ul>
			{/foreach}
		</td>
	
		<td valign="top">
			{foreach from=$data.sector_col2 item=item name=loop} 
			<ul class="list">
				<li>
					<div class="header"><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
					<a href="/doanh-nghiep/linh-vuc/{$item.SectorId}/index.html">{$item.Name}</a></div>
					<ul>
						{foreach from=$item.Industries item=subitem}
						<li>
						<img src="/images/icon_arrow1.gif" />
						<a href="/doanh-nghiep/nganh/{$subitem.IndustryId}/index.html">{$subitem.Name}</a>
						</li>
						{/foreach}
					</ul>
				</li>
			</ul>
			{/foreach}
		</td>
		
		</tr>
		</table>
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