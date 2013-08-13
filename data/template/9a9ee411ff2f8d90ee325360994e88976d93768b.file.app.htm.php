<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:24:33
         compiled from "D:\htdocs\code3.0/template/tvstore\app.htm" */ ?>
<?php /*%%SmartyHeaderCode:16123520998e19fb5d3-91009095%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a9ee411ff2f8d90ee325360994e88976d93768b' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/tvstore\\app.htm',
      1 => 1376360101,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16123520998e19fb5d3-91009095',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include 'D:\htdocs\code3.0\cgi\plugins\modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template("../header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php if ($_smarty_tpl->getVariable('action')->value=='index'){?>
			<div class="bread">
				<a href="/">首页</a> > <a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/tv.html">TV应用</a>
			</div>
			<div>
				<section class="br f_l">
					<div class="tit f_c">
						<h3 class="tapp">应用分类</h3>						
					</div>
					<ul class="classific">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('appClasses')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
						<li <?php if ($_smarty_tpl->getVariable('classid')->value==($_smarty_tpl->getVariable('row')->value->classid)){?>class="cur"<?php }?>><a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app-<?php echo $_smarty_tpl->getVariable('row')->value->classid;?>
-N-1.html"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
<span>>></span></a></li>
						<?php }} ?>
					</ul>
					<div class="tit f_c">
						<h3>热门专题</h3>						
					</div>
					<ul class="topic">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('smarttvlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
						<li>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app-<?php echo $_smarty_tpl->getVariable('row')->value->classid;?>
-N-1.html" class="thimg"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
"  width="125" height="50"></a>
							<div>
								<h4><a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app-<?php echo $_smarty_tpl->getVariable('row')->value->classid;?>
-N-1.html"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
</a></h4>
								<p><?php echo $_smarty_tpl->getVariable('row')->value->desci;?>
</p>
							</div>							
						</li>
						<?php }} ?>
					</ul>
				</section>
				<div class="bl f_r">
					<div class="tit tabtit f_c">
						<h3 <?php if ($_smarty_tpl->getVariable('order')->value=='N'){?>class="cur" <?php }?>><a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app-<?php echo $_smarty_tpl->getVariable('classid')->value;?>
-N-<?php echo $_smarty_tpl->getVariable('page')->value;?>
.html">按最新</a></h3>
						<h3 <?php if ($_smarty_tpl->getVariable('order')->value=='H'){?>class="cur" <?php }?>><a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app-<?php echo $_smarty_tpl->getVariable('classid')->value;?>
-H-<?php echo $_smarty_tpl->getVariable('page')->value;?>
.html">按下载量</a></h3>
					</div>
					<ul class="listapp">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('apps')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
						<li>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="f_l"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
"></a>
							<div>
								<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="aname" title="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
" ><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->title,8,'');?>
</a>
								<span class="score"><span style="width:<?php echo $_smarty_tpl->getVariable('row')->value->level*20;?>
%;"></span></span>
								<p>更新：<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->onlinetime,10,'');?>
</p>			
							</div>
											
						</li>
						<?php }} ?>
						
					</ul>
					<div class="page">
						<?php echo $_smarty_tpl->getVariable('subPages')->value;?>

					</div>
				</div>
			</div>
		</div>
<?php }elseif($_smarty_tpl->getVariable('action')->value=='detail'){?>
		<div class="bread">
				<a href="/">首页</a> > <a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/tv.html">TV应用</a> > <span><?php echo $_smarty_tpl->getVariable('app')->value->title;?>
</span>
			</div>
			<div>
				<section class="br f_l">
					<div class="sapp">
						<h3><?php echo $_smarty_tpl->getVariable('app')->value->title;?>
</h3>
						<img src="<?php echo $_smarty_tpl->getVariable('app')->value->icon;?>
" alt="<?php echo $_smarty_tpl->getVariable('app')->value->title;?>
">
						<span class="score"><span style="width:<?php echo $_smarty_tpl->getVariable('app')->value->level*20;?>
%;"></span></span>
						<div class="opr">
							
							<!-- Baidu Button BEGIN -->
							<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
							<span class="my_bds_more">分享到：</span>
							</div>
							<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6618735" ></script>
							<script type="text/javascript" id="bdshell_js"></script>
							<script type="text/javascript">
							var bds_config = {'bdPic':'<?php echo $_smarty_tpl->getVariable('app')->value->icon;?>
','bdText':'<?php echo $_smarty_tpl->getVariable('app')->value->title;?>
'};
							document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
							</script>
							<!-- Baidu Button END -->
							
							<a href="javascript:;" class="f_r" id="saveFavorite">收藏</a>
						</div>
					</div>
					<script type="text/javascript">
					$(document).ready(function(){
						$("#saveFavorite").click(function(){
							var uid=<?php echo $_smarty_tpl->getVariable('uid')->value;?>
;
							if(uid==0){
								var flag=confirm("请先登录,跳转到登录页面？");
								if(flag)
									location.href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=member&act=loggin&returnurl=<?php echo $_smarty_tpl->getVariable('referer')->value;?>
";
								return false;
							}else{
								$.getJSON("?mod=app&act=saveFavorite&appkey=<?php echo $_smarty_tpl->getVariable('app')->value->appid;?>
",function(data){
									if(data.msg=='success')
										alert("收藏成功");
									else
										alert("收藏失败，请稍后再试");
									return false;
								});
							}
							
						});
						
					});
					</script>
					<div>
						<div class="tit f_c">
							<h3>论坛精华</h3>						
						</div>
						<ul class="flight">
							<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/api.php?mod=js&bid=19"></script>
						</ul>
					</div>
				</section>
				<div class="bl f_r">
					<div>
						<ul class="dinfo">
							<li><strong>价&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格：</strong><?php echo $_smarty_tpl->getVariable('app')->value->charge;?>
欢币</li>
							<li><strong>分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类：</strong><?php echo $_smarty_tpl->getVariable('app')->value->category;?>
</li>
							<li><strong>版&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本：</strong><?php echo $_smarty_tpl->getVariable('app')->value->ver;?>
</li>
							<li><strong>操控方式：</strong><?php echo $_smarty_tpl->getVariable('app')->value->operatetype;?>
</li>
							<li><strong>发布日期：</strong><?php echo $_smarty_tpl->getVariable('app')->value->onlinetime;?>
</li>
							<li><strong>文件大小：</strong><?php echo $_smarty_tpl->getVariable('app')->value->size;?>
 KB</li>
							<li class="downtips"><strong>友情提示：</strong><span>暂不提供应用下载，请到相关智能电视应用商店进行下载</span></li>
							<li class="intro">
								<strong>应用介绍：</strong>
								<div>
								<?php echo $_smarty_tpl->getVariable('app')->value->description;?>

								</div>
								<div class="bimg" id="bimg"><!--图片大小必须相同-->
									<div>
										<?php  $_smarty_tpl->tpl_vars['pic'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pics')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pic']->key => $_smarty_tpl->tpl_vars['pic']->value){
?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['pic']->value;?>
" />
										<?php }} ?>
									</div>
									<span class="pre"><</span>
									<span class="next">></span>
								</div>
							</li>
						</ul>
					</div>
					<div>
						<div class="tit f_c">
							<h3>相关应用</h3>						
						</div>
						<ul class="listapp">
							<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('recommand')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>						
							<li>
								<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="f_l"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
"></a>
								<div>
									<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="aname"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->title,8,'');?>
</a>
									<span class="score"><span style="width:<?php echo $_smarty_tpl->getVariable('row')->value->level*20;?>
%;"></span></span>
									<p>更新：<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->onlinetime,10,'');?>
</p>
								</div>															
							</li>
							<?php }} ?>
						</ul>						
					</div>
				</div>
			</div>
			<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/apppic.js"></script>
		</div>
			
<?php }elseif($_smarty_tpl->getVariable('action')->value=='searchApp'){?>
	<div class="bread">
				<a href="">首页</a> > <a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app.html">应用软件</a> > <span>关于“<em><?php echo $_smarty_tpl->getVariable('keyword')->value;?>
</em>”的安卓游戏/安卓软件</span>
	</div>			
		<div>
		<div class="tit f_c">
			<h3>搜索结果</h3>
		</div>
		<p class="sr">搜索发现关于"<em><?php echo $_smarty_tpl->getVariable('keyword')->value;?>
</em>"的安卓游戏/安卓软件<?php echo $_smarty_tpl->getVariable('appcount')->value;?>
个</p>
		<?php if ($_smarty_tpl->getVariable('appcount')->value==0){?>
			<div class="noresult">
				<em>对不起，没有找到您想要的结果</em>
				<dl>
					<dt>建议您</dt>
					<dd>1. 去掉不必要的字词，如“的”、“或”等；</dd>
					<dd>2. 精简搜索关键词，使用其中最主要的字词；</dd>
					<dd>3. 确认关键词的拼写没有错误；</dd>
				</dl>
			</div>
			<div class="tit f_c">
				<h3>热门推荐</h3>
		    </div>
			<ul class="listapp sresult">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('latestapp')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
						<li>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="f_l"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
" /></a>
							<div>
								<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="aname"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->title,8,'');?>
</a>
								<span class="score"><span style="width:<?php echo $_smarty_tpl->getVariable('row')->value->level*20;?>
%;"></span></span>
								<p>更新：<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->onlinetime,10,'');?>
</p>	
							</div>
						</li>
						<?php }} ?>
			</ul>
		<?php }else{ ?>
				<ul class="listapp sresult">
					<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('apps')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
					<li>
						<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="f_l"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
" /></a>
						<div>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="aname"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->title,8,'');?>
</a>
							<span class="score"><span style="width:<?php echo $_smarty_tpl->getVariable('row')->value->level*20;?>
%;"></span></span>
							<p>更新：<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->onlinetime,10,'');?>
</p>
						</div>	
					</li>
					<?php }} ?>
				</ul>
				<div class="page">
					<?php echo $_smarty_tpl->getVariable('subPages')->value;?>

				</div>
		<?php }?>
	</div>
	</div>
				
<?php }?>
<?php $_template = new Smarty_Internal_Template("../footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>	