<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:48:20
         compiled from "D:\htdocs\code3.0/template/member\menu.html" */ ?>
<?php /*%%SmartyHeaderCode:1505252099e74128b70-33247430%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7aa0be9969e6a8ea74d3664ed94d942178933dd8' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/member\\menu.html',
      1 => 1358326639,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1505252099e74128b70-33247430',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="br f_l">			
	<!--给menu下的第一个li切换class名，收缩的时候添加class="hidden"；展开的时候去掉-->
	<ul class="menu">
		<?php $_template = new Smarty_Internal_Template("submenu.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	</ul>
</div>