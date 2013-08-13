<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:20:40
         compiled from "D:\htdocs\code3.0/template/tvstore\tvstore.htm" */ ?>
<?php /*%%SmartyHeaderCode:15262520997f84b6db6-72568321%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b783d26491f95efef784c1f516a57978be5077ab' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/tvstore\\tvstore.htm',
      1 => 1376360428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15262520997f84b6db6-72568321',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include 'D:\htdocs\code3.0\cgi\plugins\modifier.truncate.php';
?><?php $_template = new Smarty_Internal_Template("../header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
<?php }?>
<?php $_template = new Smarty_Internal_Template("../footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>	