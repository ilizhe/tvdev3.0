<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:26:54
         compiled from "D:\htdocs\code3.0/template/www\dev.htm" */ ?>
<?php /*%%SmartyHeaderCode:167195209996e203694-67326094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee7783986da96f03cb9440f0d939214cbbafd7d0' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/www\\dev.htm',
      1 => 1376017125,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '167195209996e203694-67326094',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include 'D:\htdocs\code3.0\cgi\plugins\modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template("header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php if ($_smarty_tpl->getVariable('action')->value=='index'){?>
			<div class="bfocus f_c">
				<div id="focus" class="f680">
					<ul>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banner')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
							<?php if ($_smarty_tpl->getVariable('row')->value->linkurl==''){?>
							<li><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/<?php echo $_smarty_tpl->getVariable('row')->value->pic;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
" /></li>
							<?php }else{ ?>
							<li><a href="<?php echo $_smarty_tpl->getVariable('row')->value->linkurl;?>
"><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/<?php echo $_smarty_tpl->getVariable('row')->value->pic;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
" /></a></li>
							<?php }?>
						<?php }} ?>
					</ul>
				</div>
				<section class="br f_r">
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
" width="125" height="50" /></a>
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
			</div>
			<div class="box f_c">
				<div class="bl f_l">
					<div class="spe">
						<div class="tit f_c">
							<h3>TV精品应用推荐</h3>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/app.html" class="more">More>></a>
						</div>
						<div id="TVRecommand">
							<ul class="lapp">
							<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('TV_GAME_SOFTWARE_RECOMMAND')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['app']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['app']['index']++;
?>
								<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['app']['index']>5){?>
									<?php break 1?>
								<?php }else{ ?>
								<li>
									<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
" /></a>
									<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="aname" title="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->title,6,'');?>
</a>
									<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><?php echo $_smarty_tpl->getVariable('row')->value->category;?>
</a>
								</li>	
								<?php }?>
							<?php }} ?>
							</ul>
							<?php if ($_smarty_tpl->getVariable('appcount')->value>6){?>
								<ul class="lapp">
								<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('TV_GAME_SOFTWARE_RECOMMAND')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['app']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['app']['index']++;
?>
									<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['app']['index']>11){?>
										<?php break 1?>
									<?php }else{ ?>
										<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['app']['index']>5){?>
										<li>
											<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
" /></a>
											<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="aname" title="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->title,6,'');?>
</a>
											<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><?php echo $_smarty_tpl->getVariable('row')->value->category;?>
</a>
										</li>
										<?php }?>
									<?php }?>
								<?php }} ?>
								</ul>
							<?php }?>
							<?php if ($_smarty_tpl->getVariable('appcount')->value>12){?>
								<ul class="lapp">
								<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('TV_GAME_SOFTWARE_RECOMMAND')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['app']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['app']['index']++;
?>
									<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['app']['index']>17){?>
										<?php break 1?>
									<?php }else{ ?>
										<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['app']['index']>11){?>
										<li>
											<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
" /></a>
											<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html" class="aname" title="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('row')->value->title,6,'');?>
</a>
											<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><?php echo $_smarty_tpl->getVariable('row')->value->category;?>
</a>
										</li>
										<?php }?>
									<?php }?>
								<?php }} ?>
								</ul>
							<?php }?>
						</div>
					</div>
					<div>
						<div class="tit f_c">
							<h3>TV资讯</h3>
						</div>						
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('zixun')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
							<div class="hotnews">
								<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/article-<?php echo $_smarty_tpl->getVariable('row')->value->tid;?>
-1.html" target="_blank"><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/<?php echo $_smarty_tpl->getVariable('row')->value->pic;?>
"></a>
								<h4>
									<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/article-<?php echo $_smarty_tpl->getVariable('row')->value->tid;?>
-1.html" target="_blank"><?php echo $_smarty_tpl->getVariable('row')->value->subject;?>
</a>
								</h4>
								<p><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/article-<?php echo $_smarty_tpl->getVariable('row')->value->tid;?>
-1.html" target="_blank"><?php echo $_smarty_tpl->getVariable('row')->value->description;?>
</a></p>
							</div>
						<?php }} ?>
						
						<ul class="lnews">
							<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/api.php?mod=js&bid=18"></script>
						</ul>
					</div>
					<div>
						<div class="tit f_c">
							<h3>论坛精华</h3>		
						</div>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('jinghua')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
							<div class="hotnews">
								<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('row')->value->tid;?>
-1-1.html" target="_blank"><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/<?php echo $_smarty_tpl->getVariable('row')->value->pic;?>
"></a>
								<h4>
									<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('row')->value->tid;?>
-1-1.html" target="_blank"><?php echo $_smarty_tpl->getVariable('row')->value->subject;?>
</a>
								</h4>
								<p><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('row')->value->tid;?>
-1-1.html" target="_blank"><?php echo $_smarty_tpl->getVariable('row')->value->description;?>
</a></p>
							</div>
						<?php }} ?>
						<ul class="lnews">
							<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/api.php?mod=js&bid=19"></script>
						</ul>
					</div>
					
				</div>				
				<section class="br f_r">
					<div class="tit">
						<h3 class="tgame">热门游戏榜</h3>						
					</div>
					<ol class="rank" id="hotgame">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('TV_GAME_RANK')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['game']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['game']['index']++;
?>
						<li>
							<span><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['game']['index']+1;?>
</span>
							<img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
"></img>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
</a>
						</li>
						<?php }} ?>
					</ol>
					<div class="tit">
						<h3 class="tapp">热门应用榜</h3>						
					</div>
					<ol class="rank" id="hotapp">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('TV_SOFTWARE_RANK')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['soft']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['soft']['index']++;
?>
						<li>
							<span><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['soft']['index']+1;?>
</span>
							<img src="<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
"></img>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/detail-<?php echo $_smarty_tpl->getVariable('row')->value->appid;?>
.html"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
</a>
						</li>
						<?php }} ?>
					</ol>
				</section>
			</div>
			<div>
				<div class="tit">
					<h3>友情链接</h3>						
				</div>
				<div class="link">
					<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('friendlinks')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
						<a href="<?php echo $_smarty_tpl->getVariable('row')->value->url;?>
" title="<?php echo $_smarty_tpl->getVariable('row')->value->name;?>
"><?php echo $_smarty_tpl->getVariable('row')->value->name;?>
</a>
					<?php }} ?>
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/friendlink.html" title="更多" class="more">更多>></a>					
				</div>
			</div>
		</div>
<?php }elseif($_smarty_tpl->getVariable('action')->value=='developer'){?>
	<div class="bread">
				<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
">首页</a> > <a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/developer.html">开发者</a>
			</div>
			<div class="bfocus">
				<div id="focus" class="f960">
					<ul>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('banner')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
							<?php if ($_smarty_tpl->getVariable('row')->value->linkurl==''){?>
							<li><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/<?php echo $_smarty_tpl->getVariable('row')->value->pic;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
" /></li>
							<?php }else{ ?>
							<li><a href="<?php echo $_smarty_tpl->getVariable('row')->value->linkurl;?>
"><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/<?php echo $_smarty_tpl->getVariable('row')->value->pic;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
" /></a></li>
							<?php }?>
						<?php }} ?>
					</ul>
				</div>				
			</div>
			<div class="box f_c">
				<div class="bl f_l">
					<div class="spe">
						<div class="tit f_c">
							<h3>成为我们的伙伴</h3>							
						</div>
						<div class="jus">
							<img src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/img/jionus.png" alt="加入我们" />
						</div>						
					</div>
					<div class="dindex">
						<section>
							<div class="tit f_c">
								<h3>热门动态</h3>								
							</div>
							<ul>
								<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/api.php?mod=js&bid=6"></script>
							</ul>
							
						</section>
						<section>
							<div class="tit f_c">
								<h3>TV应用开发</h3>								
							</div>
							<ul>
								<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/api.php?mod=js&bid=7"></script>
							</ul>
							
						</section>												
						<section>
							<div class="tit f_c">
								<h3>开发文档</h3>								
							</div>
							<ul>
								<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/api.php?mod=js&bid=8"></script>
							</ul>
							
						</section>
					</div>
				</div>				
				<section class="br f_r">
					<div>
						<?php if ($_smarty_tpl->getVariable('uid')->value){?>
							<div class="tit">
								<h3>用户中心</h3>						
							</div>
							<form class="blogin">
								<ul>
									<li>欢迎您，<?php echo $_smarty_tpl->getVariable('username')->value;?>
, <a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=member&act=logout&returnurl=<?php echo $_smarty_tpl->getVariable('referer')->value;?>
">退出</a></li>
									<?php if ($_smarty_tpl->getVariable('userstatus')->value==1){?>
									<li><?php echo $_smarty_tpl->getVariable('userinfo')->value->name;?>
<br><?php echo $_smarty_tpl->getVariable('userinfo')->value->mobile;?>
</li>
									<li><a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
">进入开发者管理中心</a></li>
									<?php }else{ ?>
									<li><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/home.php?mod=space&uid=<?php echo $_smarty_tpl->getVariable('uid')->value;?>
&do=profile&from=space">进入用户中心</a></li>
									<li class="applyfor"><a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=member&act=select">申请成为开发者</a></li>
									<?php }?>
								</ul>
							</form>
						<?php }else{ ?>
							<div class="tit">
								<h3>登录</h3>						
							</div>
							<form class="blogin" method="post" name="loginform" action="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=member&act=loggin&returnurl=<?php echo $_smarty_tpl->getVariable('referer')->value;?>
">
								<ul>
									<li><label for="username">用户名：</label><input type="text" id="username" class="text" name="username_" maxlength="15"></li>
									<li><label for="password">密&nbsp;&nbsp;码：</label><input type="password" id="password" class="text" name="password_"  maxlength="16"></li>
									<li><input type="submit" class="submit" value="登&nbsp;&nbsp;录"><a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=register&act=lostpass">忘记密码?</a></li>
									<li class="toreg"><a href="<?php echo $_smarty_tpl->getVariable('memberurl')->value;?>
/?mod=register">注册成为开发者</a></li>
									<input type="hidden" name="formhash" value="randfm"/>
								</ul>
							</form>
						<?php }?>
					</div>
					<div>				
						<div class="tit">
							<h3>联系我们</h3>						
						</div>
						<div class="chart">
							<dl>
								<dt>QQ咨询</dt>
								<dd>
									<a href="http://wpa.qq.com/msgrd?v=3&uin=1011318257&site=qq&menu=yes" target="_blank">
										<img border="0" title="点击这里给我发消息" alt="点击这里给我发消息" src="http://wpa.qq.com/pa?p=2:1011318257:41">
									</a>
									<a href="http://wpa.qq.com/msgrd?v=3&uin=1532490133&site=qq&menu=yes" target="_blank">
										<img border="0" title="点击这里给我发消息" alt="点击这里给我发消息" src="http://wpa.qq.com/pa?p=2:1532490133:41">
									</a>
								</dd>
								<dt>客服邮箱（周一到周五 9:30-18:30）</dt>
								<dd>kefu@huan.tv</dd>
								<dt>QQ群</dt>
								<dd>智能TV开发者交流群 261722115</dd>
								<dd>智能TV用户交流群&nbsp;&nbsp;&nbsp;&nbsp;300194185</dd>								
								<dt>合作咨询（周一到周五 9:30-18:30）</dt>
								<dd>lipei@huan.tv </dd>
								<dt>应用合作</dt>
								<dd>zhangkaiying@huan.tv</dd>
							</dl>
						</div>
						
					</div>
				</section>
			</div>			
		</div>
<?php }?>
<?php $_template = new Smarty_Internal_Template("footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>	