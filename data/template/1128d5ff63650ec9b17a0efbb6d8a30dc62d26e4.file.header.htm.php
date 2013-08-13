<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:26:54
         compiled from "D:\htdocs\code3.0/template/www\header.htm" */ ?>
<?php /*%%SmartyHeaderCode:43165209996e8e4c05-08357490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1128d5ff63650ec9b17a0efbb6d8a30dc62d26e4' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/www\\header.htm',
      1 => 1375064257,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '43165209996e8e4c05-08357490',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /><!--[if lte IE 6]>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/pngmin.js"></script>
<script>
	DD_belatedPNG.fix(".logo a,.share a,.hr form,.hr button,.lapp img,.rank li img");
</script>
<![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/html5.js"></script>
<![endif]-->
<title><?php echo $_smarty_tpl->getVariable('title')->value;?>
<?php echo $_smarty_tpl->getVariable('bbname')->value;?>
</title>
<meta content="<?php echo $_smarty_tpl->getVariable('keywords')->value;?>
" name="keywords" />
<link href="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/style/common.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/jquery.min.js"></script>
</head>
<body>
	<div class="all">
		<header class="hd">
			<div class="tophd">
				<h1 class="logo"><a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
"><img src="templates/img/logo.png" alt="智能电视开发者社区" /></a></h1>
				<div class="hr">
					<div class="tofocus">
						<span class="f_l">关注我们：</span>
						<a href="http://weibo.com/u/2887330904" title="新浪微博" class="wb"><img src="templates/images/weibo.png"></a>
						<a href="http://www.tvdev.net/bbs/thread-2113-1-1.html" title="微信" class="wb"><img src="templates/images/weixin.png"></a>
					</div>
					<?php if ($_smarty_tpl->getVariable('uid')->value){?>
					<div><?php echo $_smarty_tpl->getVariable('username')->value;?>
</a>，欢迎您 [<?php if ($_smarty_tpl->getVariable('userstatus')->value){?><a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
">管理中心</a><?php }else{ ?><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/home.php?mod=space&uid=<?php echo $_smarty_tpl->getVariable('uid')->value;?>
&do=profile&from=space">用户中心</a><?php }?>] <a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=member&act=logout&returnurl=<?php echo $_smarty_tpl->getVariable('referer')->value;?>
">退出</a></div>
					<?php }else{ ?>
					<div class="login">
						<a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=register">注册</a> |
						<a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=member&act=loggin&returnurl=<?php echo $_smarty_tpl->getVariable('referer')->value;?>
">登录</a>
					</div>
					<?php }?>
					<form action="?mod=app&act=searchApp" name="appsearch" method="post">
						<input name="keyword" type="text" value="请输入搜索关键字" onmouseover="this.focus()" onblur="if (this.value =='') this.value='请输入搜索关键字'" 
onfocus="this.select()" onclick="if (this.value=='请输入搜索关键字') this.value=''"/><button class="forapp">搜应用</button><button class="forinfo">搜资讯</button>
					</form>
					<script type="text/javascript">
						$(document).ready(function(){
							$(".forapp").bind("click",function(){
								var keyword=$("input[name=keyword]").val();
								if(keyword=='' || keyword=='请输入搜索关键字')
									window.location.href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app.html";
								else
									$("form[name=appsearch]").submit();
								return false;
							});

							$(".forinfo").bind("click",function(){
								var keyword=$("input[name=keyword]").val();
								if(keyword=='' || keyword=='请输入搜索关键字')
									window.location.href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/portal.php?mod=list&catid=1";
								else
									window.location.href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/search.php?mod=portal&searchsubmit=true&source=hotsearch&srchtxt="+encodeURIComponent(keyword);
								return false;
							});
						});
					</script>
				</div>					
			</div>			
			<nav id="mynav">
				<div>
					<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/forum.php">首页</a>
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/tv.html">TV应用</a>
					<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/portal.php?mod=list&catid=1">TV资讯</a>
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/salon.html">沙龙活动</a>
					<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/plugin.php?id=hux_zhidao:hux_zhidao">问题互助</a>
					<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/plugin.php?id=huxdown:huxdown">固件下载</a>
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/developer.html">开发者</a>
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/help.html">帮助中心</a>
				</div>
			</nav>
		</header>
		<div class="main">		