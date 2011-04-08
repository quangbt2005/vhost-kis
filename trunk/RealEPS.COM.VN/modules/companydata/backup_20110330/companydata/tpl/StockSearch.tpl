<!-- TIM KIEM -->
<div class="panel margin_bottom_10px_float">
    <h4>
        <span class="header"><img src="/images/transparent.png" class="icon_panel" style="margin-right:5px"/>Tìm kiếm nâng cao</span>
    </h4>      
    <div class="panel_content">
        <table>
            <tr>
                <td><table>
                        <tr>
                            <td><label for="txt_stock_symbol">Mã chứng khoán:</label></td >
                            <td><input type="text" name="symbol" class="input" size="35" id="txt_stock_symbol"/></td>
                        </tr>
                        <tr>
                            <td><label for="cb_board">Sàn giao dịch:</label></td>
                            <td>
                                <select class="input" style="width: 120px;" id="cb_board" name="se" onchange="onBoardChange(this);">
                                <option value="0">- Tất cả các sàn -</option>
                                <option value="1">Sàn HOSE</option>
                                <option value="2">Sàn HASE</option>
                                <option value="3">Sàn UPCOM</option>
                                </select>
                            </td>
                        </tr>
                </table></td>
                <td><table>
                        <tr>
                            <td><label for="cb_info">Danh mục thông tin:</label></td>
                            <td>
                                <select class="input" style="width: 150px;" id="cb_info" name="view">
                                    <option value="overview">- Chọn thông tin -</option>
                                    <option value="overview">Tổng quan công ty</option>
                                    <option value="snapshot">Hồ sơ doanh nghiệp</option>
                                    <option value="majorholder">Các cổ đông chính</option>
                                    <option value="companynews">Tin tức liên quan</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="cb_sector">Lĩnh vực kinh doanh:</label></td>
                            <td>
                                {getindustries assign="industries"}                                
                                <select class="input" style="width: 150px;" id="cb_sector" name="industry" onchange="onIndustryChange(this);">
                                <option value="0">- Tất cả các lĩnh vực -</option>
                                {foreach from=$industries item=item}
                                <option value="{$item.IndustryId}">{$item.Name}</option>
                                {/foreach}                                
                                </select>
                            </td>
                        </tr>
                    </table></td>
                <td valign="top">
                    <a class="button left" onclick="viewStock(); this.blur();" style="margin: auto; width: 60px;" href="#">
                    <span>Xem</span>
                    </a>
                    <!-- <span class="margin_left_10px">
                        <img src="/images/icon_search.gif" align="absmiddle"/>
                        <a href="#">Tra cứu</a>
                    </span>  -->
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="margin_bottom_5px"><img src="/images/transparent.png" class="icon_panel1" style="margin-right:5px"/> <b>Công ty A - Z</b></div>
                    <div class="azleft"></div>
                    <div class="azcontent">
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=A">A</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=B">B</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=C">C</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=D">D</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=E">E</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=F">F</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=G">G</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=H">H</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=I">I</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=J">J</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=K">K</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=L">L</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=M">M</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=N">N</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=O">O</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=P">P</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=Q">Q</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=R">R</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=S">S</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=T">T</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=U">U</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=V">V</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=W">W</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=X">X</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=Y">Y</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}&alphabet=Z">Z</a>
                        <a href="/doanh-nghiep/cong-ty/index.html?view={$get.view}">Tất cả</a>
                    </div>
                    <div class="azright"></div>
                    <div class="clear"></div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div style="margin-top: 10px;">
                        <span class="eps_link">
                            <img src="/images/icon_arrow.gif" align="absmiddle" />
                            Dành riêng cho khách hàng của EPS:
                        </span>
                        <!--<a href="#" class="eps_link"><img src="/images/icon_check.gif" align="absmiddle" /> LỌC CỔ PHIẾU</a>
                        --><a href="/doanh-nghiep/tien-ich/loc-co-phieu.html" class="eps_link"><img src="/images/icon_check.gif" align="absmiddle" /> TOP CỔ PHIẾU</a>
                        <!-- <a href="#" class="eps_link"><img src="/images/icon_check.gif" align="absmiddle" /> CẢNH BÁO THÔNG TIN</a>  -->
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="panel_bottom_left"></div>       
    <div class="panel_bottom"></div>
    <div class="panel_bottom_right"></div>     
    <div class="clear"></div>                       
</div>
<link rel="stylesheet" type="text/css" href="/js/jquery.autocomplete.css" />
<script type="text/javascript" src="/js/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="/js/jquery.autocomplete.pack.js"></script>
{literal}
<script type="text/javascript">
var se=0, industry=0;
bindSymbolAutocomplete(se,industry);
function viewStock(){
	var view = $('#cb_info').val();
	var symbol = $('#txt_stock_symbol').val();
    var link = "/doanh-nghiep/cong-ty/index.html";
    if (symbol != '') link = "/doanh-nghiep/cong-ty/"+symbol+"/"+view+".html"
    window.location = link;
}
function onBoardChange(obj){	
	se=$(obj).val();
	bindSymbolAutocomplete(se,industry);
}
function onIndustryChange(obj){	
	industry=$(obj).val();
	bindSymbolAutocomplete(se,industry);
}
function bindSymbolAutocomplete(exchangeId, industryId){    
    //{ Autocomplete
    $("#txt_stock_symbol").unautocomplete();            
    $("#txt_stock_symbol").autocomplete('/ajax.php?mod=companydata&func=getsymbol&se=' + exchangeId + '&industry=' + industryId ,             
    {
        minChars: 0,
        width: 400,
        highlight: false,
        autoFill: true,
        formatItem: function(row) {
          return row[0] + ' - ' + row[1];
        },
        formatMatch: function(row) {
            return row[0];
        },
        formatResult: function(row) {
          return row[0] ;
        }
    });  
    //}
}
//}
</script>
{/literal}
<!-- /TIM KIEM -->  