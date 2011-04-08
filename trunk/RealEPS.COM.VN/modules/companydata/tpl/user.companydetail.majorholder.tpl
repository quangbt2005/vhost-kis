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
        
        <!-- CO CAU CO DONG -->
        <div class="headline1 text margin_bottom_10px">
        Cơ cấu cổ đông
        </div>
        <div class="text info margin_bottom_10px">
         <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <col width="30%" />
                <col width="70%" />
                <tr  bgcolor="#f0f0f0">
                    <td>Sở hữu nhà nước</td>
                    <th align="right">{$data.company.StateOwnership|num_format}</th>
                </tr>
                <tr>
                    <td>Sở hữu nước ngoài</td>
                    <th align="right">{$data.company.ForeignOwnership|num_format:2:'%'}</th>
                </tr>
                <tr  bgcolor="#f0f0f0">
                    <td>Sở hữu nước ngoài</td>
                    <th align="right">{$data.company.OtherOwnership|num_format:2:'%'}</th>
                </tr>
            </table>
        </div>
         <!-- /CO CAU CO DONG -->  
         
         <!-- CO CAU CO DONG -->
        <div class="headline1 text margin_bottom_10px">
        Cổ đông quan trọng
        </div>
        <div class="text info">
            <table cellpadding="0" cellspacing="0" width="100%" class="small">
                <thead>
                <tr>
                    <th>Tên</th>
                    <th>Vị trí</th>
                    <th>Số cổ phần</th>
                    <th>Tỷ lệ sở hữu</th>
                    <th>Ngày cập nhật</th>
                </tr>
                </thead>
                <tbody>                
                {foreach from=$data.officers item=item name=loop}
                {if $smarty.foreach.loop.index % 2 == 0}
                <tr bgcolor="#f0f0f0">
                {else}
                <tr>
                {/if}
                    <td>{$item.Name}</td>
                    {if $item.Position}
                    <td>{$item.Position}</td>
                    {else}
                    <td>---</td>
                    {/if}
                    <td align="right">{$item.Shares|num_format:0}</td>
                    <td align="right">{$item.Ownership|num_format:2:'%'}</td>
                    <td align="center">{$item.Reported|date_format:"%d/%m/%Y"}</td>                    
                </tr>
                {/foreach}
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