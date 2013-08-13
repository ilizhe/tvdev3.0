<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 05:31:01
         compiled from "D:\htdocs\code3.0/template/www\help.htm" */ ?>
<?php /*%%SmartyHeaderCode:260015209c49513dba0-02293061%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52ecea50723dd1b48a044448eafc19ff8ee5de40' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/www\\help.htm',
      1 => 1376371858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '260015209c49513dba0-02293061',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("../header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php if ($_smarty_tpl->getVariable('action')->value=='index'){?>
			<div class="bread">
				<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
">首页</a> &gt; <a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/help.html">帮助中心</a>
			</div>
			<div>
				<section class="br f_l">
					<div class="tit f_c">
						<h3 class="tithelp">帮助中心</h3>						
					</div>
					<ul class="menu" id="menu">
						<?php  $_smarty_tpl->tpl_vars['help'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('helps')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['help']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['help']->key => $_smarty_tpl->tpl_vars['help']->value){
 $_smarty_tpl->tpl_vars['category']->value = $_smarty_tpl->tpl_vars['help']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['help']['index']++;
?>
						<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['help']['index']==0){?> 
						<li>
							<a href="#" class="m1" id="first"><?php echo $_smarty_tpl->tpl_vars['category']->value;?>
<span>>></span></a>							
							<ul class="m2">
								<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['help']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
								<?php if ($_smarty_tpl->getVariable('row')->value->title==''){?>
								<div class="summary" style="display:none;"><?php echo $_smarty_tpl->getVariable('row')->value->description;?>
</div>
								<?php }else{ ?>
								<li><a title="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
"  class="title"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
</a><div class="summary" style="display:none;"><?php echo $_smarty_tpl->getVariable('row')->value->description;?>
</div></li>
								<?php }?>
								
								<?php }} ?>
							</ul>							
						</li>
						<?php }else{ ?>
						<li>
							<a href="#" class="m1"><?php echo $_smarty_tpl->tpl_vars['category']->value;?>
<span>>></span></a>							
							<ul class="m2">
								<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['help']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
								<?php if ($_smarty_tpl->getVariable('row')->value->title==''){?>
								<div class="summary" style="display:none;"><?php echo $_smarty_tpl->getVariable('row')->value->description;?>
</div>
								<?php }else{ ?>
								<li><a title="<?php echo $_smarty_tpl->getVariable('row')->value->title;?>
"  class="title"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
</a><div class="summary" style="display:none;"><?php echo $_smarty_tpl->getVariable('row')->value->description;?>
</div></li>
								<?php }?>
								
								<?php }} ?>
							</ul>							
						</li>
						<?php }?>
						<?php }} ?>
							
					</ul>
				</section>
				<div class="bl f_r">
					<div class="tit f_c">
						<h3 id="helptitle"></h3>						
					</div>
					<div class="helpct"></div>
				</div>
			</div>
		</div>
		<script type="text/javascript">		
		function getByClass(cName){
			var oClassArray=[];
			var list=document.getElementsByTagName("*");
			for(var i=0;i<list.length;i++){
				if(list[i].className==cName) oClassArray.push(list[i]);
			}
			return oClassArray;
		}
		var mList=getByClass("m1");
		for(var i in mList){
			mList[i].onclick=function(){
				var parent=this.parentNode;
				var className = parent.className;
				if(className && className.indexOf("hidden")>-1){
					var point =className.indexOf("hidden");
					var newstr ='';
					newstr = className.substring(0,point);
					newstr += ' '+className.substring(point+6);
					parent.className = newstr;			
				}else{
					parent.className = parent.className+' hidden';
				}
			}
		}
	$(document).ready(function(){
		$(".title").live("click",function(){
			var content=$(this).next(".summary").html();
			var title=$(this).html();
			$(".helpct").html(content);
			$("#helptitle").html(title);
		});
		$(".m1").live("click",function(){
			var content=$(this).next(".m2").find(".summary").html();
			var title=$(this).html();
			$(".helpct").html(content);
			$("#helptitle").html(title);
		});
		$("#first").trigger("click").closest("li").removeClass("hidden");
	});	
	</script>
<?php }elseif($_smarty_tpl->getVariable('action')->value=='about'){?>
<div>
				<section class="br f_l">
					<div class="tit f_c">
						<h3 class="tithelp">关于我们</h3>						
					</div>
					<ul class="menu" id="menu">
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
						<?php if ($_smarty_tpl->getVariable('type')->value=='about'){?>
						<?php if ($_smarty_tpl->getVariable('row')->value->id==$_smarty_tpl->getVariable('aboutrow')->value->id){?>
						<li>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/about-<?php echo $_smarty_tpl->getVariable('row')->value->id;?>
.html"class="m1"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
<span>>></span></a>
						</li>
						<?php }else{ ?>
						<li class="hidden">
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/about-<?php echo $_smarty_tpl->getVariable('row')->value->id;?>
.html"class="m1"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
<span>>></span></a>
						</li>
						<?php }?>
						<?php }else{ ?>
						<li class="hidden">
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/about-<?php echo $_smarty_tpl->getVariable('row')->value->id;?>
.html"class="m1"><?php echo $_smarty_tpl->getVariable('row')->value->title;?>
<span>>></span></a>
						</li>
						<?php }?>
						<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['about']['last']){?>
						<?php if ($_smarty_tpl->getVariable('type')->value=='links'){?>
						<li>
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/friendlink.html"class="m1">友情链接<span>>></span></a>
						</li>
						<?php }else{ ?>
						<li class="hidden">
							<a href="<?php echo $_smarty_tpl->getVariable('siteurl')->value;?>
/friendlink.html"class="m1">友情链接<span>>></span></a>
						</li>
						<?php }?>
						<?php }?>
						<?php }} ?>
													
					</ul>
				</section>
				<div class="bl f_r">
					<?php if ($_smarty_tpl->getVariable('type')->value=='links'){?>
					<div class="tit f_c">
						<h3>友情链接</h3>						
					</div>
					<div class="helpct alllinks">
						<?php echo $_smarty_tpl->getVariable('friendlinks')->value;?>

					</div>
					<?php }else{ ?>
					<div class="tit f_c">
						<h3><?php echo $_smarty_tpl->getVariable('aboutrow')->value->title;?>
</h3>						
					</div>
					<div class="helpct"><?php echo $_smarty_tpl->getVariable('aboutrow')->value->description;?>
</div>
					<?php }?>
				</div>
			</div>		
		</div>	
<?php }?>
<?php $_template = new Smarty_Internal_Template("../footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>			