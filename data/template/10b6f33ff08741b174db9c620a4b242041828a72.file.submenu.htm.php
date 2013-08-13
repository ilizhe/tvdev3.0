<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:48:20
         compiled from "D:\htdocs\code3.0/template/member\submenu.htm" */ ?>
<?php /*%%SmartyHeaderCode:2485352099e7419c6a1-77344301%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10b6f33ff08741b174db9c620a4b242041828a72' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/member\\submenu.htm',
      1 => 1358326639,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2485352099e7419c6a1-77344301',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php if (is_array($_smarty_tpl->getVariable('menu')->value)){?>
<?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['m']->key;
?>
<li >
	<a href="#" class="m1"><?php echo $_smarty_tpl->tpl_vars['m']->value['title'];?>
</a>
	<ul class="m2">
		<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['m']->value['subc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
 $_smarty_tpl->tpl_vars['p']->value = $_smarty_tpl->tpl_vars['t']->key;
?>
		<li <?php if ($_smarty_tpl->getVariable('action')->value==$_smarty_tpl->tpl_vars['p']->value){?>class="cur"<?php }?>><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=<?php echo $_smarty_tpl->tpl_vars['m']->value['mod'];?>
&act=<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value;?>
</a></li>
		<?php }} ?>
	</ul>	
</li>
<?php }} ?>
<?php }?>
<script>
$(document).ready(function(){
	$(".menu > li > a ").toggle(function(){
		$(this).parent().addClass("hidden").find("ul").hide();
	},function(){
		$(this).parent().removeClass("hidden").find("ul").show();
	});
});
</script>