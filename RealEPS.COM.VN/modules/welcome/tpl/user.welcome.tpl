        {if $data.hose_total_market.VNIndexChanges > 0}
       		{assign var='hose_market_class' value='up'}
       	{elseif $data.hose_total_market.VNIndexChanges < 0}
       		{assign var='hose_market_class' value='down'}
       	{else}
       		{assign var='hose_market_class' value='stand'}
       	{/if}
       	
       	{if $data.hase_total_market.CHGIndex > 0}
       		{assign var='hase_market_class' value='up'}
       	{elseif $data.hase_total_market.CHGIndex < 0}
       		{assign var='hase_market_class' value='down'}
       	{else}
       		{assign var='hase_market_class' value='stand'}
       	{/if}
       
       	{if $data.upcom_total_market.CHGIndex > 0}
       		{assign var='upcom_market_class' value='up'}
       	{elseif $data.upcom_total_market.CHGIndex < 0}
       		{assign var='upcom_market_class' value='down'}
       	{else}
       		{assign var='upcom_market_class' value='stand'}
       	{/if}
		<!-- SLIDE & LOGIN -->
        <div class="margin_bottom_10px_float">
            <div id="slideshow" class="left">
            {ads alias="SLIDER"}            
            {if count($SLIDER) == 1}
            <a href="$SLIDER[0].link"><a href="{$SLIDER[0].link}"><img src="{$SLIDER[0].image}" /></a>
            {/if}    
            </div>
            <div class="panel right" style="width:230px;">
                <h4>
                    <span class="header"><img src="/images/transparent.png" class="icon_panel" style="margin-right:5px"/>Đăng nhập giao dịch trực tuyến EOT</span>
                </h4>
                <form action="https://online.eps.com.vn/login.php" method="post" name="frm_login">
                <div class="panel_content panel_style" style="height: 155px;">
                    <ul class="form">
                        <li>
                            <label for="txt_login_username">Tài khỏan</label>
                            <input type="text" value="Tên đăng nhập" onfocus="inputOnFocus(this,'Tên đăng nhập');" onblur="inputOnBlur(this, 'Tên đăng nhập');" class="input" size="35" id="txt_login_username" name="account_no"/>
                        </li>
                        <li>
                            <label for="txt_login_password">Mật khẩu</label>
                            <input type="password" value ="" class="input" size="35" id="txt_login_password" name="password"/>
                        </li>
                        <li>
                            <a class="button" href="#" style="width: 100px; margin:auto;" onclick="document.frm_login.submit();this.blur();"><span>Đăng nhập</span></a>                                
                        </li>
                        <li style="text-align: right">
                            <p><a href="https://online.eps.com.vn/forgot_password.php">Quên mật khẩu?</a></p>
                            <p><a href="https://online.eps.com.vn/open_account_qd.php">Mở tài khỏan trực tuyến tại KIS?</a></p>
                        </li>
                    </ul>                                
                    <div class="clear"></div>
                </div>
                <div class="panel_style_bottom_left"></div>       
                <div class="panel_style_bottom" style="width:222px;"></div>
                <div class="panel_style_bottom_right"></div>     
                <div class="clear"></div> 
                </form>
            </div>      
            <div class="clear"></div>                      
        </div>               	      
		<!-- /SLIDE & LOGIN -->
        <div id="market_summary" class="margin_bottom_10px">        
       		<ul>
            	<li class="first">	
                	<div class="margin_bottom_5px">
                    	<div class="left name">HOSE</div>
                        <div class="right" style="text-align:right;"><span id="hose_VNIndex">{$data.hose_total_market.VNIndex|num_format}</span></div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left" id="hose_img"><img src="/images/transparent.png" class="icon_{$hose_market_class}"/></div>
                        <div class="right {$hose_market_class}" style="text-align:right;" id="hose_change_container"><span id="hose_VNIndexChanges">{$data.hose_total_market.VNIndexChanges|num_format}</span> - (<span id="hose_PercentChanges">{$data.hose_total_market.PercentChanges|num_format}</span>%)</div>
                        <div class="clear"></div>
                    </div>
                </li>
                <li>	
                	<div class="margin_bottom_5px">
                    	<div class="left name">HASE</div>
                        <div class="right" style="text-align:right;"><span id="hase_MarketIndex">{$data.hase_total_market.MarketIndex|num_format}</span></div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left" id="hase_img"><img src="/images/transparent.png" class="icon_{$hase_market_class}"/></div>
                        <div class="right {$hase_market_class}" style="text-align:right;" id="hase_change_container"><span id="hase_CHGIndex">{$data.hase_total_market.CHGIndex|num_format}</span> - (<span id="hase_PCTIndex">{$data.hase_total_market.PCTIndex|num_format}</span>%)</div>
                        <div class="clear"></div>
                    </div>
                </li>
                <li>	
                	<div class="margin_bottom_5px">
                    	<div class="left name">UPCOM</div>
                        <div class="right" style="text-align:right;"><span id="upcom_MarketIndex">{$data.upcom_total_market.MarketIndex|num_format}</span></div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left" id="upcom_img"><img src="/images/transparent.png" class="icon_{$upcom_market_class}"/></div>
                        <div class="right {$upcom_market_class}" style="text-align:right;" id="upcom_change_container"><span id="upcom_CHGIndex">{$data.upcom_total_market.CHGIndex|num_format}</span> - (<span id="upcom_PCTIndex">{$upcom_total_market.PCTIndex|num_format}</span>%)</div>
                        <div class="clear"></div>
                    </div>
                </li>
                <li>	
                	<div class="margin_bottom_5px">
                    	<div class="left name">STOXX 50</div>
                        <div class="right" style="text-align:right;"><span id="stoxx_index">-</span></div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left" id="stoxx_img"></div>
                        <div class="right" style="text-align:right;" id="stoxx_change_container"><span id="stoxx_change">-</span> - (<span id="stoxx_percent_change">-</span>%)</div>
                        <div class="clear"></div>
                    </div>
                </li>
                <li>	
                	<div class="margin_bottom_5px">
                    	<div class="left name">NIKKEI</div>
                        <div class="right" style="text-align:right;"><span id="nikkei_index">-</span></div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left" id="nikkei_img"></div>
                        <div class="right" style="text-align:right;" id="nikkei_change_container"><span id="nikkei_change">-</span> - (<span id="nikkei_percent_change">-</span>%)</div>
                        <div class="clear"></div>
                    </div>
                </li>
                <li class="last">	
                	<div class="margin_bottom_5px">
                    	<div class="left name">DOW</div>
                        <div class="right" style="text-align:right;"><span id="dow_index">-</span></div>
                        <div class="clear"></div>
                    </div>
                    <div>
                    	<div class="left" id="dow_img"></div>
                        <div class="right" style="text-align:right;" id="dow_change_container"><span id="dow_change">-</span> - (<span id="dow_percent_change">-</span>%)</div>
                        <div class="clear"></div>
                    </div>
                </li>
            </ul>
        </div>
        <div id="home_buttons" class="margin_bottom_10px">
            <div class="button left">
                <div id="bang_gia">
                <img src="/images/transparent.png" class="icon_stockquotes margin_right_5px" align="absmiddle"/>
                {menu alias="PRICEBOARD"}                
                <a href="{$PRICEBOARD.link}" target="_blank" class="bang_gia" ><img src="/images/transparent.png"  align="absmiddle"/></a>
                </div>
            </div>
             <div class="button left margin_left_12px">
                <div>
                <img src="/images/transparent.png" class="icon_pc margin_right_5px" align="absmiddle"/>
                {menu alias="E_TRADER"}
                <a href="{$E_TRADER.link}" target="_blank" class="download_pm_etrade" ><img src="/images/transparent.png"  align="absmiddle"/></a>
                </div>
            </div>
             <div class="button left margin_left_12px">
                <div>
                    <img src="/images/transparent.png" class="icon_note margin_right_5px" align="absmiddle"/>
                    {menu alias="OPEN_ACCOUNT"}
                    <a href="{$OPEN_ACCOUNT.link}" target="_blank" class="mo_tk" ><img src="/images/transparent.png"  align="absmiddle"/></a>
                </div>
            </div>
             <div class="button left margin_left_12px">
				<div style="padding:10px 3px 6px 0px;">
                	<p class="left">
               			<img src="/images/transparent.png" class="icon_gui_mail margin_right_5px" align="absmiddle" />
                    </p>
                    <form action="/dang-ky-nhan-tin/index.html" method="post">    
                	<p class="left" style="border:1px solid #dddddd;">                        		         
	                        <input type="text" name="email" class="input1" value="- Email đăng ký nhận tin -" size="22" onfocus="inputOnFocus(this,'- Email đăng ký nhận tin -');" onblur="inputOnBlur(this, '- Email đăng ký nhận tin -');"/>
	                        <input type="image" src="/images/gui_en.gif" align="absmiddle"/>
	                        <input type="hidden" name="from" value="home" />                        
                 	</p>
                 	</form>
                    <p class="clear"></p>
				</div>
            </div>              
            <div class="clear"></div>  
    	</div>
    
	    <div id="home_news" class="margin_bottom_10px_float">
	    	<!-- HOME NEWS -->
	        <!-- HEADER -->
	        <div class="multi_col" id="home_group">        	     
	        	<div class="header">
	            	<table cellpadding="0" cellspacing="0" border="0">
	                <col class="col1" />
	                <col class="col2" />            	
	                <col class="col3" />            	
	                <tr>
	                    <td class="first">                    	
	                         <div class="left"><a href="#" class="home_panel_button_active" style="width:60px;" title="Thống kê sàn HOSE" onclick="changeTab(this,'group_chart_hose', 'home_panel_button', 'home_panel_button_active');return false;" rel="group_chart"><span>HOSE</span></a></div>
	                         <div class="left margin_left_10px"><a href="#" class="home_panel_button" style="width:60px;" title="Thống kê sàn HASE" onclick="changeTab(this,'group_chart_hase', 'home_panel_button', 'home_panel_button_active');return false;" rel="group_chart"><span>HASE</span></a></div>
	                         <div class="clear"></div>
	                    </td>
	                    <td class="middle">                                                
	                         <div class="left"><a href="#" class="home_panel_button_active" title="Các tin tiêu điểm" onclick="changeTab(this,'group_news_tieudiem', 'home_panel_button', 'home_panel_button_active');return false;" rel="group_news"><span>Tiêu điểm</span></a></div>
	                         <div class="left margin_left_10px"><a href="#" class="home_panel_button" title="Các tin được quan tâm" onclick="changeTab(this, 'group_news_quantam', 'home_panel_button', 'home_panel_button_active');return false;" rel="group_news"><span>Tin được quan tâm</span></a></div>
	                         <div class="clear"></div>
	                    </td>
	                    <td class="last">                    
	                         <a href="#" class="home_panel_button_active" style="width:60px;" title="Tin tức từ EPS">
	                         <span>Tin KIS</span></a>
	                    </td>
	                </tr>                   
	               	</table>
	            </div>
	            <div class="body">
	            	<table border="0" cellpadding="0" cellspacing="0">               
	                    <col width="322" />
	                    <col width="338" />     
	                    <col width="338" />            	          
	                    <tbody>
	                	<tr>
	                    	<td rowspan="2">	                    		
	                    		<!-- HOSE -->
	                    		<div id="group_chart_hose" class="group_chart">
		                        	<div style="overflow: auto; height: 220px;width:309px">
		                            	<object id='mySwf' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab' height='200px' width='360px'>
								        <param name='src' value='/images/FinalIndexChart.swf?tradingSym=HOSE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.kisvn.vn/ws/chart.php?wsdl'/>                								
								        <param name='flashVars' value=''/>                    									
								        <embed name='mySwf' src='/images/FinalIndexChart.swf?tradingSym=HOSE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.kisvn.vn/ws/chart.php?wsdl'  pluginspage='http://www.adobe.com/go/getflashplayer' height='200px' width='360px' flashVars=''/>									
										</object>
		                            </div>                            
		                            <div class="chart_info">
		                            	<div>
		                                	<div class="left">HOSE-Index</div>
		                                    <div class="right"><span id="hose_VNIndex1">{$data.hose_total_market.VNIndex|num_format}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div class="odd">
		                                	<div class="left">Thay đổi</div>
		                                	
		                                    <div class="right {$hose_market_class}" id="hose_change_container1"><span id="hose_VNIndexChanges1">{$data.hose_total_market.VNIndexChanges|num_format}</span> (<span id="hose_PercentChanges">{$data.hose_total_market.PercentChanges|num_format}</span>%)</div>
		                                    <div class="clear"></div>                                           
		                                </div>
		                                <div>
		                                	<div class="left">Số mã chứng khoán tăng giá</div>
		                                    <div class="right up"><span id="hose_Gainers1">{$data.hose_total_market.Gainers}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div class="odd">
		                                	<div class="left">Số mã chứng khoán đứng giá</div>
		                                    <div class="right stand"><span id="hose_Unchanged1">{$data.hose_total_market.Unchanged}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div>
		                                	<div class="left">Số mã chứng khoán giảm giá</div>
		                                    <div class="right down"><span id="hose_Losers1">{$data.hose_total_market.Losers}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div class="odd">
		                                	<div class="left">Giá trị giao dịch</div>
		                                    <div class="right"><span id="hose_TotalValues1">{$data.hose_total_market.TotalValues|num_format:0}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div>
		                                	<div class="left">Khối lượng giao dịch</div>
		                                    <div class="right"><span id="hose_TotalShares1">{$data.hose_total_market.TotalShares|num_format:0}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                            </div>
		                        </div>
	                            <!-- /HOSE -->
	                            <!-- HASE -->
	                            <div id="group_chart_hase" class="group_chart" style="display: none;">
		                        	<div>
		                            	<object id='mySwf' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab' height='200px' width='309px'>
								        <param name='src' value='/images/FinalIndexChart.swf?tradingSym=HASE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.kisvn.vn/ws/chart.php?wsdl'/>                								
								        <param name='flashVars' value=''/>                    									
								        <embed name='mySwf' src='/images/FinalIndexChart.swf?tradingSym=HASE&dateFrom={$data.chart_startdate}&dateTo={$data.chart_today}&wsdl=http://www.kisvn.vn/ws/chart.php?wsdl'  pluginspage='http://www.adobe.com/go/getflashplayer' height='200px' width='309px' flashVars=''/>									
										</object>
		                            </div>                            
		                            <div class="chart_info">
		                            	<div>
		                                	<div class="left">HASE-Index</div>
		                                    <div class="right"><span id="hase_MarketIndex1">{$data.hase_total_market.MarketIndex|num_format}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div class="odd">
		                                	<div class="left">Thay đổi</div>
		                                    <div class="right {$hase_market_class}" id="hase_change_container1"><span id="hase_CHGIndex1">{$data.hase_total_market.CHGIndex|num_format}</span> (<span id="hase_PCTIndex1">{$data.hase_total_market.PCTIndex|num_format}</span>%)</div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div>
		                                	<div class="left">Số mã chứng khoán tăng giá</div>
		                                    <div class="right up"><span id="hase_Gainers1">{$data.hase_total_market.Gainers}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div class="odd">
		                                	<div class="left">Số mã chứng khoán đứng giá</div>
		                                    <div class="right stand"><span id="hase_Unchanged1">{$data.hase_total_market.Unchanged}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div>
		                                	<div class="left">Số mã chứng khoán giảm giá</div>
		                                    <div class="right down"><span id="hase_Losers1">{$data.hase_total_market.Losers}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div class="odd">
		                                	<div class="left">Giá trị giao dịch</div>
		                                    <div class="right"><span id="hase_TotalValue1">{$data.hase_total_market.TotalValue|num_format:0}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                                <div>
		                                	<div class="left">Khối lượng giao dịch</div>
		                                    <div class="right"><span id="hase_TotalQuantity1">{$data.hase_total_market.TotalQuantity|num_format:0}</span></div>
		                                    <div class="clear"></div>
		                                </div>
		                            </div>
	                            </div>
	                            <!-- /HASE -->
	                        </td>
	                        <td>
	                        	<div id="group_news_tieudiem" class="group_news">
		                            <ul class="news_list">
		                            {news_tieudiem assign="items"}
		                            {foreach from=$items item=item}	                            	
		                                <li>
		                                    <a class="news_title" href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" title="{$item.news_title}">{$item.news_title}</a>                                    
		                                    <span class="news_created">({$item.news_created|date_format})</span>
		                                    {if $item.intro != '<br />'}
		                                    <div class="news_summary text">{$item.intro|truncate:217}</div>
		                                    {/if}
		                                    <div class="news_detail"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html">Chi tiết</a></div>
		                                    <div class="line"></div>
		                                 </li>
		                             {/foreach}                    
		                             </ul> 		                          
		                             <div class="text_align_center">
		                                 <a href="/tin-tuc/tieu-diem/index.html" class="link">Xem tất cả tin</a>
		                             </div>    
	                             </div>   
	                             <div id="group_news_quantam" style="display: none;" class="group_news">
		                            <ul class="news_list">
		                            {news_quantam assign="items"}
		                            {foreach from=$items item=item}	                            	
		                                <li>
		                                    <a class="news_title" href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" title="{$item.news_title}">{$item.news_title}</a>                                    
		                                    <span class="news_created">({$item.news_created|date_format})</span>
		                                    
		                                    {if $item.intro != '<br />'}
		                                    <div class="news_summary text">{$item.intro|truncate:217}</div>
		                                    {/if}
		                                    <div class="news_detail"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html">Chi tiết</a></div>
		                                    <div class="line"></div>
		                                 </li>
		                             {/foreach}                    
		                             </ul> 		                          
		                             <div class="text_align_center">
		                                 <a href="/tin-tuc/quan-tam/index.html" class="link">Xem tất cả tin</a>
		                             </div>    
	                             </div>                        
	                        </td>
	                        <td class="last">
	                        	<ul class="news_list">
	                                {news_tineps assign="tineps"}
		                            {foreach from=$tineps item=item}	                            	
		                                <li>
		                                    <a class="news_title" href="/tin-tuc/chi-tiet/{$item.news_id}/index.html" title="{$item.news_title}">{$item.news_title}</a>                                    
		                                    <span class="news_created">({$item.news_created|date_format}) </span>
		                                    {if $item.intro != '<br />'}
		                                    <div class="news_summary text">{$item.intro|truncate:217}</div>
		                                    {/if}
		                                    <div class="news_detail"><a href="/tin-tuc/chi-tiet/{$item.news_id}/index.html">Chi tiết</a></div>
		                                    <div class="line"></div>
		                                 </li>
		                             {/foreach}                        
	                             </ul> 
	                             <div class="text_align_center">	                             	
	                                 <a href="/tin-tuc/tin-eps/index.html" class="link">Xem tất cả tin</a>
	                             </div>
	                        </td>
	                    </tr>	                    
	                    </tbody>
	                </table>                
	            </div>           
	            <div class="panel_bottom_left"></div>
	            <div class="panel_bottom"></div>
	            <div class="panel_bottom_right"></div>            
	            <div class="clear"></div>
	            <!-- /HEADER -->           
			</div>
			<!-- /HOME NEWS -->
	    </div>
	    <div id="parner">	    
	    {ads alias="QC_TRANGCHU"}
	    {foreach from=$QC_TRANGCHU item="item"}	    	    
	    <a href="{$item.link}" target="_blank" rel="nofollow">{image src=$item.image title=$item.ad_title height=50}</a>	    
	    {/foreach}
	    </div>	    
