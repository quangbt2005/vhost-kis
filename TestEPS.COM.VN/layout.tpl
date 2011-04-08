<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="aaWe0kONeZurs1Y55m5p4DftfapEczJ1Rb-xdmDmjFI" />
<meta name="alexaVerifyID" content="BUHyXYwxs58DxN0i6ZdHk29I_Hw" />
<meta name="robots" content="index, follow" />
<meta name="keywords" content="{random_keywords mod=$_mod page=$_page}" />
<meta name="description" content="Gia Quyen (EPS) - Cong ty chung khoan hang dau Vietnam. Cung cap cac dich vu chung khoan uy tin va chuyen nghiep: Moi gioi chung khoan,tu van dau gia,quan ly co dong,cam co ung truoc" />

<title>{option name="title"} - {random_title mod=$_mod page=$_page}</title>
<link href="/css/layout.css" rel="stylesheet" type="text/css" />
<link href="/css/general.css" rel="stylesheet" type="text/css" />
<link href="/css/paging.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="/js/lib.js"></script>
{include file="$_HEAD"}
<!--[if IE]>
<link href="/css/fixie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if lte IE 6]>
<link href="/css/fixie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if lte IE 7]>
<link href="/css/fixielte7.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if gt IE 7]>
<link href="/css/fixiegt7.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
<div id="wrapper">
	<!-- HEADER BAR -->
	<div id="headerbar_left"></div>
	<div id="headerbar">
		<div class="left">
        	<!-- <span class="margin_left_10px"><a href="#"><img  class="icon_flag_vn" src="/images/transparent.png"/></a></span>
            <span class="margin_left_10px"><a href="#"><img  class="icon_flag_en" src="/images/transparent.png"/></a></span>  -->           
        </div>
        <div class="right">           	
        	{menu alias="HEADERMENU"}
        	{foreach from=$HEADERMENU item="item"}        	
        	<span class="margin_right_10px"><a href="{$item.link}" title="{$item.menu_title}"><img  class="{$item.image}" src="/images/transparent.png"/></a></span>
        	{/foreach}                 
        </div>
        <div class="clear"></div>
    </div>
    <div id="headerbar_right"></div>
	<div class="clear"></div>
    <!-- /HEADER BAR -->
    <!-- BANNER -->
    <form action="" method="get" onsubmit="onsearchsubmit(this);" name="frmQuickSearch">
	<div id="banner">
    	<div class="right">
        	<div class="margin_bottom_5px"><label for="txt_quick_search">Tìm kiếm</label></div>
            <div class="margin_bottom_5px"><input type="text" value="Nhập từ khóa cần tìm..." onkeypress="submitsearch(this,event);" onfocus="inputOnFocus(this,'Nhập từ khóa cần tìm...');" onblur="inputOnBlur(this, 'Nhập từ khóa cần tìm...');" id="txt_quick_search"  class="input_search"/>
            <input type="submit" value="Xem" style="border: 1px dotted #FFF; background: #CCC"/>
            </div>
            <div>
           	<input type="radio" id="rad_ma_chung_khoan" {if $get.opt != 2}checked="checked"{/if} name="opt" value="1"/> <label for="rad_ma_chung_khoan">Mã chứng khoán</label>
            <input type="radio" id="rad_tintuc" name="opt" value="2" {if $get.opt == 2}checked="checked"{/if}/> <label for="rad_tintuc" >Tin tức</label>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    </form>  
    <!-- /BANNER -->
    <!-- NAVIGATION -->
    {menu alias="TOPMENU"}        
    <ul id="nav">
    	{foreach from=$TOPMENU item="item"}
    	{if $_mod == $item.menu_alias || ($_mod == 'content' && ( ($get.id==$item.menu_alias && isset($get.id)) || ($get.groupid==$item.menu_alias && isset($get.groupid))) )}    	
        <li class="current"><a href="{$item.link}" title="{$item.menu_title}"><span>{$item.menu_title}</span></a></li>
        {else}
        <li><a href="{$item.link}" title="{$item.menu_title}"><span>{$item.menu_title}</span></a></li>
        {/if}              
        {/foreach}       
    </ul>  
    <!-- /NAVIGATION -->
    <a name="content"></a>
    <div id="container" class="margin_bottom_10px_float">    	
   	{include file="$_MODULE_ABSPATH/tpl/$_MODULE_TPL"}
	</div>
    <div id="footer">
    	{menu alias="BOTTOMMENU"}
		<ul id="footer_nav" class="margin_bottom_10px">
			{foreach from=$BOTTOMMENU item="item" name="loop"}
			{if $smarty.foreach.loop.last}
			<li><a href="{$item.link}" title="{$item.menu_title}">{$item.menu_title}</a></li>
			{else}
			<li><a href="{$item.link}" title="{$item.menu_title}">{$item.menu_title}</a>|</li>
			{/if} 
			{/foreach}       	
        </ul>
        <div id="copyright">        
        	{content alias="COPYRIGHT"}
        </div>
    </div>
</div>
{literal}
<script type="text/javascript"> 
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script> 
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-12236464-1");
pageTracker._trackPageview();
} catch(err) {}</script> 
{/literal}
{include file="$_FOOT"}
</body>
</html>
