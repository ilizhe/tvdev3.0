<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:38:31
         compiled from "D:\htdocs\code3.0/template/www\salon.htm" */ ?>
<?php /*%%SmartyHeaderCode:1626352099c27af6883-90663840%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'acc685a440a88ff4160cf1a2fb377814fcacd707' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/www\\salon.htm',
      1 => 1376361508,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1626352099c27af6883-90663840',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("../header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
			<div class="bread">
				<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
">首页</a> > <a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/salon.html">沙龙活动</a>
			</div>
			<div>
				<div class="bl f_l">
					<div>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('salon')->value->rows; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['row']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['row']->index++;
 $_smarty_tpl->tpl_vars['row']->first = $_smarty_tpl->tpl_vars['row']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['salon']['first'] = $_smarty_tpl->tpl_vars['row']->first;
?>
							<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['salon']['first']){?>
								<div class="hotsalon">
								<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('row')->value->salon;?>
-1-1.html"><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/data/attachment/common/<?php echo $_smarty_tpl->getVariable('row')->value->banner;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->name;?>
"></a>
								<h3 class="bgblue"><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('row')->value->salon;?>
-1-1.html"><?php echo $_smarty_tpl->getVariable('row')->value->name;?>
</a></h3>
								</div>
								<?php if ($_smarty_tpl->getVariable('row')->value->threads){?>
								<ul class="listsl">
									<?php  $_smarty_tpl->tpl_vars['thread'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('row')->value->threads; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['thread']->key => $_smarty_tpl->tpl_vars['thread']->value){
?>
									<li><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('thread')->value->tid;?>
-1-1.html" target="_blank"><?php echo $_smarty_tpl->getVariable('thread')->value->subject;?>
</a><a><img src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/img/play.png"></a></li>
									<?php }} ?>
								</ul>
								<?php }?>
							<?php }else{ ?>	
								<div class="hotsalon">
								<a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('row')->value->salon;?>
-1-1.html"><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/data/attachment/common/<?php echo $_smarty_tpl->getVariable('row')->value->banner;?>
" alt="<?php echo $_smarty_tpl->getVariable('row')->value->name;?>
"></a>
								<h3 class="bggray"><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('row')->value->salon;?>
-1-1.html"><?php echo $_smarty_tpl->getVariable('row')->value->name;?>
</a></h3>
								</div>
								<?php if ($_smarty_tpl->getVariable('row')->value->threads){?>
								<ul class="listsl">
									<?php  $_smarty_tpl->tpl_vars['thread'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('row')->value->threads; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['thread']->key => $_smarty_tpl->tpl_vars['thread']->value){
?>
									<li><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/thread-<?php echo $_smarty_tpl->getVariable('thread')->value->tid;?>
-1-1.html" target="_blank"><?php echo $_smarty_tpl->getVariable('thread')->value->subject;?>
</a><a><img src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/img/play.png"></a></li>
									<?php }} ?>
								</ul>
								<?php }?>
							<?php }?>
						<?php }} ?>
						
						<div class="page">
							<?php echo $_smarty_tpl->getVariable('subPages')->value;?>

						</div>
					</div>
				</div>
				<section class="br f_r">
					<div>
						<div class="tit f_c">
							<h3>新浪微博</h3>						
						</div>
						<div>
							<iframe width="100%" height="550" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=550&fansRow=2&ptype=1&speed=0&skin=10&isTitle=0&noborder=0&isWeibo=1&isFans=1&uid=2887330904&verifier=836add2b&dpc=1"></iframe>
						</div>
					</div>
					<div>
						<div class="tit f_c">
							<h3>品牌专区</h3>						
						</div>
						<ul class="brandZone">
							<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('ppzq')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
							<li><a href="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/forum-<?php echo $_smarty_tpl->getVariable('row')->value->fid;?>
-1.html"><img src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/data/attachment/common/<?php echo $_smarty_tpl->getVariable('row')->value->icon;?>
"></a></li>
							<?php }} ?>						
						</ul>
					</div>
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
			</div>
			
		</div>
<?php $_template = new Smarty_Internal_Template("../footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>	