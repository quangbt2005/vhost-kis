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
        	<a href="/doanh-nghiep/nganh/so-sanh/index.html" class="panel_button margin_left_20px left">   			
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
				<a href="#" class="active"><span>Tin tức liên quan</span></a>
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/sosanh.html"><span>Thống kê ngành</span></a>
				<a href="/doanh-nghiep/linh-vuc/{$data.sector.SectorId}/xephang.html"><span>Xếp hạng doanh nghiệp</span></a>
				{else}
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/index.html"><span>Tổng quan ngành</span></a>
				<a href="#" class="active"><span>Tin tức liên quan</span></a>
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/sosanh.html"><span>Thống kê ngành</span></a>
				<a href="/doanh-nghiep/nganh/{$data.industry.IndustryId}/xephang.html"><span>Xếp hạng doanh nghiệp</span></a>
				{/if}
				<div class="clear"></div>
			</div>
			<!--[if lte IE 7]>   
			</td></tr></table>
			<![endif]-->
			<div class="content text">
			<div style="background: #e5e5e5; height: 4px;"></div>
			<div style="background: #F8F8F8; padding:5px;" >
				<a href="#" class="bluelink" onclick="changeTab(this,'newsgroup_tab1', '', 'bluelink'); return false;" rel="newsgroup">Doanh nghiệp</a> | 
				<a href="#" onclick="changeTab(this,'newsgroup_tab2', '', 'bluelink'); return false;" rel="newsgroup">Thị trường</a> | 
				<a href="#" onclick="changeTab(this,'newsgroup_tab3', '', 'bluelink'); return false;" rel="newsgroup">Kinh tế - Đầu tư</a> 
			</div>
			<!-- TIN DOANH NGHIEP -->
			<table width="100%" id="newsgroup_tab1" class="newsgroup">
			<tbody id="tbody_newsgroup3">
			{foreach from=$data.newsgroup3 item=item}
			<tr>
				<td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
				<td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
			</tr>
			{/foreach}
			</tbody>
			<tfoot>
			{if $data.newsgroup3_totalpage > 0}
			<tr>
				<td colspan="2" align="right">
					<a href="#" onclick="prevNewsGroup3({$id},'{$data.display}','news'); return false;" id="nextNewsGroup3_prev" style="display: none;">&lsaquo;Trước</a>
					<span id="currentNewsGroup3">1</span>/{$data.newsgroup3_totalpage}		
					{if $data.newsgroup3_totalpage > 1}				
					<a href="#" onclick="nextNewsGroup3({$id},'{$data.display}',{$data.newsgroup3_totalpage},'news'); return false;" id="nextNewsGroup3_next">Tiếp&rsaquo;</a>
					{/if}
				</td>
			</tr>
			{/if} 
			</tfoot>
			</table>
			<!-- /TIN DOANH NGHIEP -->

			<!-- TIN THI TRUONG -->
			<table width="100%" id="newsgroup_tab2" style="display: none;" class="newsgroup">
			<tbody id="tbody_newsgroup5">
			{foreach from=$data.newsgroup5 item=item}
			<tr>
				<td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
				<td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
			</tr>
			{/foreach}
			</tbody>
			<tfoot>
			{if $data.newsgroup5_totalpage > 0}
			<tr>
				<td colspan="2" align="right">
					<a href="#" onclick="prevNewsGroup5('news'); return false;" id="nextNewsGroup5_prev" style="display: none;">&lsaquo;Trước</a>
					<span id="currentNewsGroup5">1</span>/{$data.newsgroup5_totalpage}		
					{if $data.newsgroup5_totalpage > 1}				
					<a href="#" onclick="nextNewsGroup5({$data.newsgroup5_totalpage},'news'); return false;" id="nextNewsGroup5_next">Tiếp&rsaquo;</a>
					{/if}
				</td>
			</tr>
			{/if} 
			</tfoot>
			</table>
			<!-- /TIN THI TRUONG -->
			
			<!-- TIN KINH TE -->
			<table width="100%" id="newsgroup_tab3" style="display: none;" class="newsgroup">
			<tbody class="tbody_newsgroup" id="tbody_newsgroup2">
			{foreach from=$data.newsgroup2 item=item}
			<tr>
				<td class="news_created" width="8%"><b>{$item.news_created|mydate_format:"%d/%m/%y"}</b></td>
				<td valign="top" style="padding-left: 5px;"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" class="bluelink">{$item.news_title}</a></td>
			</tr>
			{/foreach}
			</tbody>
			<tfoot>
			{if $data.newsgroup2_totalpage > 0}
			<tr>
				<td colspan="2" align="right">
					<a href="#" onclick="prevNewsGroup2('news'); return false;" id="nextNewsGroup2_prev" style="display: none;">&lsaquo;Trước</a>
					<span id="currentNewsGroup2">1</span>/{$data.newsgroup2_totalpage}		
					{if $data.newsgroup2_totalpage > 1}				
					<a href="#" onclick="nextNewsGroup2({$data.newsgroup2_totalpage},'news'); return false;" id="nextNewsGroup2_next">Tiếp&rsaquo;</a>
					{/if}
				</td>
			</tr>
			{/if} 
			</tfoot>
			</table>
			<!-- /TIN KINH TE -->
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