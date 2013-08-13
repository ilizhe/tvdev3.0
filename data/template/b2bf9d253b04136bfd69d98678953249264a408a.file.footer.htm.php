<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:46:58
         compiled from "D:\htdocs\code3.0/template/member\../footer.htm" */ ?>
<?php /*%%SmartyHeaderCode:1875952099e22258527-32956530%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b2bf9d253b04136bfd69d98678953249264a408a' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/member\\../footer.htm',
      1 => 1371108522,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1875952099e22258527-32956530',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
</div>
<footer class="ft">
			<nav>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rows')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['row']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['row']->iteration=0;
if ($_smarty_tpl->tpl_vars['row']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
 $_smarty_tpl->tpl_vars['row']->iteration++;
 $_smarty_tpl->tpl_vars['row']->last = $_smarty_tpl->tpl_vars['row']->iteration === $_smarty_tpl->tpl_vars['row']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['about']['last'] = $_smarty_tpl->tpl_vars['row']->last;
?>
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/about-<?php echo $_smarty_tpl->getVariable('row')->value->id;?>
.html" target="_blank"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
</a>
					<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['about']['last']){?>
					<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/friendlink.html" class="last" target="_blank">友情链接</a>
					<?php }?>
				<?php }} ?>
			</nav>
			<div class="innerft">
				<div class="contact">
					<span>智能TV用户交流群：300194185</span>
					<span>智能机顶盒★讨论群：154028165</span>
					<span>客服邮箱：kefu@huan.tv</span>
					<span>合作咨询QQ： 1337564822</span>
					<span class="last">联系电话：(010)87216363-8093 、(010)87216363-8005 </span>					
				</div>
				<div class="cr">粤ICP备110042161号-17 京公网安备11010502021723号</div>
			</div>
		</footer>	
	<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/focus.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/common.js"></script>
<div style="display:none">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F09a5668e26ca68332071ff263ebd917b' type='text/javascript'%3E%3C/script%3E"));
</script>
</div>

</body>
</html>