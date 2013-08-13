<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:46:57
         compiled from "D:\htdocs\code3.0/template/member\member.htm" */ ?>
<?php /*%%SmartyHeaderCode:240152099e21d334c7-23819429%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6bd06bdc066aca8ca43e0bc3bc863babe0cc5824' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/member\\member.htm',
      1 => 1376362015,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '240152099e21d334c7-23819429',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("../header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<?php if ($_smarty_tpl->getVariable('action')->value=="loggin"){?>
		<?php if ($_smarty_tpl->getVariable('casused')->value=='1'){?>
		<div class="ctt">
			<div class="box_login">
				<h2>登录成功</h2>
					<ul class="list_login">
						<li class="alert">您的账号登录成功，但是还没有激活。只有在激活后，才可以使用会员服务。</li>
						<li>您可以选择：</li>
						<li class="lrows"><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=resend" class="c_blue">重发送激活邮件</a></li>
						<li class="lrows"><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=emailchange" class="c_blue">修改邮箱</a></li>
						<li class="lrows"><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=logout" class="c_blue">退出登录</a></li>
					</ul>
			</div>
			<img src="<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/image/laside.jpg" class="laside">			
		</div>
		<?php }else{ ?>
		<div>
				<div class="tit f_c">
					<h3>用户登录</h3>
				</div>
				<div class="box_reg">
				<form method="POST" action="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=loggin" onsubmit="return FRM.check(this);">
				<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
					<ul class="list_login reg">
						<?php if ($_smarty_tpl->getVariable('msg')->value){?><li class="alert"><?php echo $_smarty_tpl->getVariable('msg')->value;?>
</li><?php }?>
						<li><label for="username">用户名：</label><input type="text" id="username" value="<?php echo $_smarty_tpl->getVariable('username')->value;?>
" name="username_<?php echo $_smarty_tpl->getVariable('frm')->value;?>
" maxlength="15"/></li>
						<li><label for="password">密码：</label><input type="password" id="password" name="password_<?php echo $_smarty_tpl->getVariable('frm')->value;?>
" maxlength="16"/></li>
						<?php if ($_smarty_tpl->getVariable('verify')->value>2){?>
						<li><label for="check">验证码：</label><input type="text" id="check" class="check" name="verify_<?php echo $_smarty_tpl->getVariable('frm')->value;?>
" maxlength="6"/><a href="#" onclick="return FRM.vu('#verifyimg','<?php echo $_smarty_tpl->getVariable('url')->value;?>
verify.php?random=');"><img src="<?php echo $_smarty_tpl->getVariable('url')->value;?>
verify.php" id="verifyimg"/></a></li>
						<li class="lrows"><label></label><span>字母不区分大小写</span><a href="#" onclick="return FRM.vu('#verifyimg','<?php echo $_smarty_tpl->getVariable('url')->value;?>
verify.php?random=');" class="refresh">点击图片刷新</a></li>
						<input type="hidden" name="verify" value="<?php echo $_smarty_tpl->getVariable('verify')->value;?>
"/>
						<?php }?>
						<li class="regsub"><label></label><input type="submit" value="登录" class="submit"/><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=register&act=lostpass" class="c_blue">忘记密码?</a></li>
						<li class="box_btn"><label></label>还没有账号？<a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=register">马上注册</a></li>						
					</ul>
				</form>
			</div>
			</div>
		</div>
		<?php }?>
	<?php }elseif($_smarty_tpl->getVariable('action')->value=='resend'){?>
	<div class="ctt">
			<div class="tit f_c"><h3>邮箱激活</h3></div>
			<div class="box_reg">
				<p class="tips c_red"><?php echo $_smarty_tpl->getVariable('U')->value->devname;?>
（<?php echo $_smarty_tpl->getVariable('U')->value->email;?>
）将会收到一封邮件，点击邮件中的链接，即可执行激活操作啦</p>
				<?php if ($_smarty_tpl->getVariable('mailserver')->value!=''){?><a href="http://<?php echo $_smarty_tpl->getVariable('mailserver')->value;?>
" target="_blank" class="go">立即登录邮箱</a><?php }?>
				<p class="littip">如果没找到激活邮件可以到垃圾邮件中找找或者<a href="<?php echo $_smarty_tpl->getVariable('resendurl')->value;?>
">重新发送激活邮件</a> 返回<a href="<?php echo $_smarty_tpl->getVariable('loginurl')->value;?>
">登录</a></p>
			</div>				
		</div>
	<?php }elseif($_smarty_tpl->getVariable('action')->value=='emailchange'){?>
		<div class="ctt">
			<div class="tit f_c"><h3>修改邮箱</h3></div>
			<div class="box_reg">
				<form method="POST" action="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=emailchange" onsubmit="return FRM.check(this);">
				<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
					<?php if ($_smarty_tpl->getVariable('cm')->value==1){?>

			<p class="tips c_red"><?php echo $_smarty_tpl->getVariable('U')->value->devname;?>
（<?php echo $_smarty_tpl->getVariable('U')->value->email;?>
）将会收到一封邮件，点击邮件中的链接，即可执行激活操作啦</p>
			<?php if ($_smarty_tpl->getVariable('mailserver')->value!=''){?><a href="http://<?php echo $_smarty_tpl->getVariable('mailserver')->value;?>
" target="_blank" class="go">立即登录邮箱</a><?php }?>
			<p class="littip">如果没找到激活邮件可以到垃圾邮件中找找或者<a href="<?php echo $_smarty_tpl->getVariable('resendurl')->value;?>
">重新发送激活邮件</a> 返回<a href="<?php echo $_smarty_tpl->getVariable('loginurl')->value;?>
">登录</a></p>

					<?php }else{ ?>
					<ul class="list_login list_get">
						<li>
							<label for="username">原邮箱：</label><?php echo $_smarty_tpl->getVariable('email')->value;?>

						</li>						
						<li>
							<label for="email">请输入新邮箱：</label><input type="text" name="email" isw="2" regex="email" id="email" msg="邮箱格式不正确"/>
						</li>
						<li class="box_btn"><input type="submit" value="提&nbsp;交" class="submit"/></li>
					</ul>
					<?php }?>
				</form>
			</div>				
		</div>
	<?php }elseif($_smarty_tpl->getVariable('action')->value=="email"){?>
		<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
			<div class="bl f_r">
				<div class="tit f_c"><h3>修改邮箱</h3></div>
				<div class="box_edit">
					<form method="POST" action="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=email" onsubmit="return FRM.check(this);">
					<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
						<ul>

							<li>
								<label for="passwd">原邮箱：</label><?php echo $_smarty_tpl->getVariable('email')->value;?>

							</li>
							<li>
								<label for="password">密码：</label><input type="password" id="password" class="text" isw="1" msg="请输入密码" name="password" maxlength="16">
							</li>
							<li>
								<label for="passwd">新邮箱：</label><input type="text" id="passwd" isw="2" regex="email" msg="请输入正确的邮箱" name="email" class="text">
							</li>

							<li class="b_btn">
								<input type="submit" value="确定" class="btn"><input type="reset" value="重置" class="btn">
							</li>
						</ul>
					</form>
				</div>				
			</div>
	<?php }elseif($_smarty_tpl->getVariable('action')->value=='select'){?>
		<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
		<div class="bl f_r">
			<div class="tit f_c">
				<h3 >选择账户属性</h3>
			</div>
				<div class="box_edit">
					<script>
					function confirmd(frm,ty,o){
						if(confirm('您确定选择 '+o+' 吗？')){
							frm.type.value=ty;
							frm.submit();
							return true;
						}else{
							return false;
						}
					}
					</script>
					<div class="bp">
					<form method="POST" action="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=select" name="frm">
					<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
					<input type="hidden" name="type" value=""/>
					<dl class="f_l">
						<dt><a href="#"  onclick="return confirmd(document.frm,0,'开发者')">开发者</a></dt>
						<dd>个人：指所有以个体身份提供应用的开发者，您在注册过程中需要提供个人身份证明资料。</dd>
					</dl>
					<dl class="f_r">
						<dt><a href="#" onclick="return confirmd(document.frm,1,'开发商')">开发商</a></dt>
						<dd>企业：指所有以企业法人身份提供应用的开发者，您在注册过程中需要提供公司营业执照等证明资料。</dd>
					</dl>	</form>				
				</div>
				</div>				
			</div>
		
	<?php }elseif($_smarty_tpl->getVariable('action')->value=='repass'){?>
		<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
			<div class="bl f_r">
				<div class="tit f_c"><h3>修改密码</h3></div>
				<div class="box_edit">
					<form method="POST" action="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=repass" onsubmit="return FRM.check(this);">
					<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
						<ul>
							<li>
								<label for="password">原密码：</label><input type="password" id="password" isw="1" msg="请输入原密码" class="text" name="password" maxlength="16">
							</li>
							<li>
								<label for="passwd">新密码：</label><input type="password" id="passwd" name="passwd" isw="1" msg="请输入新密码" class="text" maxlength="16">
							</li>
							<li>
								<label for="passwd">重复新密码：</label><input type="password" id="passwdcp" name="passwdcp" class="text" maxlength="16">
							</li>
							<li class="b_btn">
								<input type="submit" value="确定" class="btn"><input type="reset" value="重置" class="btn">
							</li>
						</ul>
					</form>
				</div>				
			</div>
	<?php }else{ ?>
<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
		<div class="bl f_r">
			<div class="tit f_c">
				<h3>会员公告</h3>
			</div>
				<div class="box_edit">
					<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('bbsurl')->value;?>
/api.php?mod=js&bid=4"></script>
				</div>				
			</div>
	<?php }?>
<?php $_template = new Smarty_Internal_Template("../footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>