<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 03:29:33
         compiled from "D:\htdocs\code3.0/template/member\../header.htm" */ ?>
<?php /*%%SmartyHeaderCode:307935209a81d199e19-40492403%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2f90ed2be5a711ae963ea22f845f9caf2670023' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/member\\../header.htm',
      1 => 1376364501,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '307935209a81d199e19-40492403',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $_smarty_tpl->getVariable('bbname')->value;?>
</title>
<meta http-equiv="Content-Type" content="test/html; charset=utf-8">
<meta content="<?php echo $_smarty_tpl->getVariable('keywords')->value;?>
" name="keywords" />
<meta name="description" content="" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<!--[if lte IE 6]>
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
<link href="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/css/common.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/jquery-1.3.2.min.js"></script>
<?php if ($_smarty_tpl->getVariable('mod')->value=='member'){?>
<link href="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/css/added.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/fileprogress.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/handlers.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/validate.js"></script>
<?php echo GF::PCTJS("region.js");?>


<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/select.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/form.js"></script>
<?php }elseif($_smarty_tpl->getVariable('mod')->value=='mtc'){?>
<link href="mtc/style/common.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="mtc/js/jquery.min.js"></script>
<script type="text/javascript" src="mtc/js/focus.js"></script>
<script type="text/javascript" src="mtc/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="mtc/js/jquery.elastislide.js"></script>
<?php }?>
</head>
<body>
	<div id="zhezhao"></div>
	<div class="all">
		<header class="hd">
			<div class="tophd">
				<h1 class="logo"><a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
"><img src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/image/logo.png" alt="智能电视开发者社区" /></a></h1>
				<div class="hr">
					<div class="tofocus">
						<span class="f_l">关注我们：</span>
						<a href="http://weibo.com/u/2887330904" title="新浪微博" class="wb"><img src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/image/weibo.png"></a>
						<a href="http://www.tvdev.net/bbs/thread-2113-1-1.html" title="微信" class="wb"><img src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/image/weixin.png"></a>
					</div>
					<?php if ($_smarty_tpl->getVariable('uid')->value){?>
					<div> <?php echo $_smarty_tpl->getVariable('username')->value;?>
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
					<form action="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/?mod=app&act=searchApp" name="appsearch" method="post">
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
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/mtc.html">首页</a>
					<a href="<?php echo $_smarty_tpl->getVariable('tvstoreurl')->value;?>
">TV应用</a>
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
		<div class="main loginmain">
