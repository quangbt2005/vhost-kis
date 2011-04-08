<div class="table_panel right margin_left_10px margin_bottom_10px" style="width:755px" id="group_{$key}">
    <div class="header_left">
        <table cellpadding="0" cellspacing="0" class="header_right">
        <tr><td>                            
            <!-- MENU LOC CO PHIEU -->           
            <a href="/doanh-nghiep/cong-ty/index.html" class="panel_button_active left">             
            <span><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/>
            Thông tin tài chính
            </span></a>
            <!-- /MENU LOC CO PHIEU -->                                 
        <span class="clear"></span>  
        </td></tr></table>
    </div>
    <div class="panel_content">
  
        <!--[if lte IE 6]>
        <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
        <![endif]-->                
        <div class="boldtext margin_bottom_10px"><!--Kết quả tìm kiếm--></div>
        <!-- CAC NGHANH NGHE -->
        <div class="tabpanel margin_bottom_10px">
            <!--[if lte IE 7]>
            <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td>
            <![endif]--> 
            <div class="header">                
                <a href="?view=0{$data.pagingParams}" {if $data.view==0}class="active"{/if}><span>Tổng quan</span></a>
                <a href="?view=1{$data.pagingParams}" {if $data.view==1}class="active"{/if}><span>Giao dịch hôm nay</span></a>
                <a href="?view=2{$data.pagingParams}" {if $data.view==2}class="active"{/if}><span>Biến động giá</span></a>
                <a href="?view=3{$data.pagingParams}" {if $data.view==3}class="active"{/if}><span>Thống kê chính</span></a>
                <a href="?view=4{$data.pagingParams}" {if $data.view==4}class="active"{/if}><span>Định giá</span></a>
                <a href="?view=5{$data.pagingParams}" {if $data.view==5}class="active"{/if}><span>Tăng trưởng</span></a>
                <div class="clear"></div>
            </div>
            <!--[if lte IE 7]>   
            </td></tr></table>
            <![endif]-->
            <div class="content">
            {include file="$_MODULE_ABSPATH/tpl/$_type.$_page.view`$data.view`.tpl"}
            </div>
            {if isset($data.paging)}
            <div style="margin-top: 10px;">
                <div class="left"></div>
                <div class="right">
                    <div class="paging">{$data.paging}</div>
                </div>
                <div class="clear"></div>
            </div>
            {/if}
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