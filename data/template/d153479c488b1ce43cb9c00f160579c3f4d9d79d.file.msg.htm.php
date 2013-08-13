<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 06:29:40
         compiled from "D:\GitHub\tvdev3.0/template/member\msg.htm" */ ?>
<?php /*%%SmartyHeaderCode:222215209d254671a77-06226221%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd153479c488b1ce43cb9c00f160579c3f4d9d79d' => 
    array (
      0 => 'D:\\GitHub\\tvdev3.0/template/member\\msg.htm',
      1 => 1376362092,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '222215209d254671a77-06226221',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("../header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<script language="javascript">

function redirect()
{
	var reload = '<?php echo $_smarty_tpl->getVariable('reload')->value;?>
';
	var url = '<?php echo $_smarty_tpl->getVariable('href')->value;?>
';
	if(url == '')return ;
	if( reload != '' )
	{
		window.parent<?php echo $_smarty_tpl->getVariable('reload')->value;?>
.location.reload();
	}
	if( url == 'back' )
	{
		window.history.back();
	}
	else
	{
		window.location.href='<?php echo $_smarty_tpl->getVariable('href')->value;?>
';
	}
}
var secs = '<?php echo $_smarty_tpl->getVariable('dtime')->value;?>
';
window.onload=function(){
	if(secs==-1)
	{
		document.getElementById("tips").innerHTML='';
	}else{
		for(var i=secs;i>=0;i--) 
		{ 
			window.setTimeout("doUpdate(" + i + ")", (secs-i) * 1000); 
		} 
	}
	
}

function doUpdate(num)
{ 
	document.getElementById("dtime").innerHTML = num ; 
	if (num == 0){
		redirect();
	}	
}

</script>	
		<div class="ctt">			
			<div class="box_tips">
				<h2>温馨提示</h2>
				<p><?php echo $_smarty_tpl->getVariable('msg')->value;?>
<?php if ($_smarty_tpl->getVariable('href')->value){?><a href="<?php echo $_smarty_tpl->getVariable('href')->value;?>
" onclick="redirect();return false">确定</a><?php }?></p>
				<p id="tips">如果您的浏览器没有自动跳转，请点击确定 <span id="dtime" style="color:red;"></span>...</p>
			</div>			
		</div>
<?php $_template = new Smarty_Internal_Template("../footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

