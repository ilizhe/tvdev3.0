<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:55:32
         compiled from "D:\htdocs\code3.0/template/member\person.htm" */ ?>
<?php /*%%SmartyHeaderCode:87515209a024331702-67482320%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be88fd7bcc413dd69442aac9c48a39fc96817f59' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/member\\person.htm',
      1 => 1376362448,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '87515209a024331702-67482320',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("../header.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php if ($_smarty_tpl->getVariable('action')->value=='info'){?>
<script>
$(document).ready(function(){
	PCT.init("#provid","#cityid","#townid");
	$("#provid").change(PCT.provc);
	$("#cityid").change(PCT.cityc);
	PCT.defval('<?php echo $_smarty_tpl->getVariable('U')->value->provid;?>
','<?php echo $_smarty_tpl->getVariable('U')->value->cityid;?>
','<?php echo $_smarty_tpl->getVariable('U')->value->townid;?>
');
});
</script>
<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<div class="bl f_r">
		<div class="tit f_c">
			<h3>开发者信息</h3>
		</div>		
		<div class="box_edit">
			<form method="POST" action="<?php echo $_smarty_tpl->getVariable('obj')->value->url('info');?>
" id="infoform">
		<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
				<ul>
					<li>
						<label>账号：</label><span><?php echo $_smarty_tpl->getVariable('U')->value->username;?>
</span>
					</li>
					<li>
						<label>账户性质：</label><span><?php if ($_smarty_tpl->getVariable('U')->value->status=='800'){?>已签约<?php }elseif($_smarty_tpl->getVariable('U')->value->status=='200'){?>已申请签约，请等待审核<?php }elseif($_smarty_tpl->getVariable('U')->value->status=='500'){?>暂停<?php }else{ ?>未签约用户　　<?php if ($_smarty_tpl->getVariable('U')->value->status=='0'){?><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=person&act=upgradeinfo">申请签约</a><?php }else{ ?><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=person&act=upgrade">申请签约</a><?php }?><?php }?></span>
					</li>
					<li>
						<label>注册时间：</label><span><?php echo date('Y-m-d H:i:s',$_smarty_tpl->getVariable('U')->value->regdate);?>
</span>
					</li>
					<li>
						<label>Email：</label><span><?php echo $_smarty_tpl->getVariable('U')->value->email;?>
</span><a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=member&act=email">修改邮箱</a>
					</li>
					<li>
						<label for="Ename">英文名：</label><input type="text" id="Ename" name="enname" class="text" value="<?php echo $_smarty_tpl->getVariable('U')->value->enname;?>
" maxlength="100"/>
					</li>
					<li>
						<label for="url">网址：</label>
						<input type="text" id="url" class="text" name="website" value="<?php echo $_smarty_tpl->getVariable('U')->value->website;?>
" maxlength="200">
					</li>
					<li>
						<label for="team">团队名称：</label><input type="text" id="team" class="text" name="nickname" value="<?php echo $_smarty_tpl->getVariable('U')->value->nickname;?>
" maxlength="100">
					</li>

					<li class="addr">
						<label>住址：</label>
						<select name="provid" id="provid"></select>
						<select name="cityid" id="cityid"></select>
						<select name="townid" id="townid"></select>
						<input type="text" name="address" value="<?php echo $_smarty_tpl->getVariable('U')->value->address;?>
" maxlength="200"/>
					</li>
					<li class="b_inline">
						<label for="zip">邮编：</label><input type="text" id="zip" name="postal" value="<?php echo $_smarty_tpl->getVariable('U')->value->postal;?>
" maxlength=6>
					</li>

					<li class="b_inline">
						<label for="fixedTel">座机：</label><input type="text" id="fixedTel" name="telephone" value="<?php echo $_smarty_tpl->getVariable('U')->value->telephone;?>
" maxlength="20">
					</li>
					<li class="b_inline">
						<label for="tel"><span class="c_red">&nbsp;*</span>手机：</label><input type="text" id="tel" name="mobile" value="<?php echo $_smarty_tpl->getVariable('U')->value->mobile;?>
" maxlength="11"/>
					</li>

					<li class="b_inline">
						<label for="fax">传真：</label><input type="text" id="fax" name="fax" value="<?php echo $_smarty_tpl->getVariable('U')->value->fax;?>
" maxlength="45"/>
					</li>
					<li class="b_inline">
						<label for="cqq">QQ：</label><input type="text" id="cqq" name="qq" value="<?php echo $_smarty_tpl->getVariable('U')->value->qq;?>
" maxlength="45"/>
					</li>
					<li class="b_inline">
						<label for="MSN">MSN：</label><input type="text" id="MSN" name="msn" value="<?php echo $_smarty_tpl->getVariable('U')->value->msn;?>
" maxlength="100"/>
					</li><?php if ($_smarty_tpl->getVariable('U')->value->status=='800'||$_smarty_tpl->getVariable('U')->value->status=='300'||$_smarty_tpl->getVariable('U')->value->status=='0'){?>
					<li class="b_btn">
						<input type="submit" value="确定" class="btn"><input type="reset" value="重置" class="btn">
					</li><?php }?>
				</ul>
			</form>
		</div>
</div>
	<?php }elseif($_smarty_tpl->getVariable('action')->value=="upgradeinfo"){?>

	<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<?php $_template = new Smarty_Internal_Template("fsupload.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	
	<div class="bl f_r">
		<div class="tit f_c"><h3>开发者签约资料</h3></div>
		<div class="box_edit">
			<form method="POST" action="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=person&act=upgradeinfo" id="upgradeinfoform" >
			<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
				<section>
					<h3>基本信息<span class="c_red">*</span></h3>
					<ul>
						<li class="b_inline">
							<label for="name">真实姓名：</label><input type="text" id="name"  name="realname" value="<?php echo $_smarty_tpl->getVariable('U')->value->realname;?>
" isw="2" regex="name" msg="请填写真实姓名" maxlength="30"/>
						</li>
						<li class="b_inline">
							<label for="contact">联系方式：</label><input type="text" id="contact"  name="mobile" isw="2"  value="<?php echo $_smarty_tpl->getVariable('U')->value->mobile;?>
" />
						</li>
						<li>
							<label>证件类型：</label>
								<select name="certtype" id="certtype">
									<option value="IDCARD">身份证</option>
									<option value="POSSPORT">护照</option>
								</select>
								<input type="text" name="certno" id="certno"  value="<?php echo $_smarty_tpl->getVariable('U')->value->certno;?>
" maxlength="18"/>
						</li>
						<li class="b_idimg">
							<label>证件照片：</label><input type="hidden" id="filename" name="filename" />
							<div style="padding-right: 5px;">
								<span id="spanButtonPlaceholder"></span><div id="fsUploadProgress"></div>
							</div>
							<div class="img" id="pic"><?php if ($_smarty_tpl->getVariable('U')->value->certpicture){?><img src="<?php echo $_smarty_tpl->getVariable('U')->value->certpicture;?>
" width="130"><?php }?></div>
						</li>
						<li>
							<label>个人介绍：</label>
							<textarea name="introduction" id="introduction"  maxlength="1000"><?php echo $_smarty_tpl->getVariable('U')->value->introduction;?>
</textarea>
						</li>								
					</ul>
				</section>
				<section>
					<h3>支付信息</h3>
					<ul>
						<li class="b_inline">
							<label for="bank">开户行：</label><input type="text" id="bank" name="bank" value="<?php echo $_smarty_tpl->getVariable('U')->value->bank;?>
" maxlength="100"/>
						</li>
						<li class="b_inline">
							<label for="bankAddr">开户行地址：</label><input type="text" id="bankAddr" name="bankaddress" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankaddress;?>
" maxlength="200"/>
						</li>
						<li style="overflow:hidden">
							<label for="bankTel">开户行电话：</label><input type="text" id="bankTel" name="bankphone" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankphone;?>
" maxlength="45"/>
						</li>
						<li class="b_inline">
							<label for="accountName">银行户名：</label><input type="text" id="accountName" name="bankaccountname" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankaccountname;?>
" maxlength="45"/>
						</li>
						<li class="b_inline">
							<label for="account">银行账号：</label><input type="text" id="account" name="bankaccount" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankaccount;?>
" maxlength="100"/>
						</li>							
					</ul>
				</section>
				<section>
					<h3>签约协议</h3>
					<ul>
						<li class="b_service">
							<label>　</label>
							<div class="serviceItem">
							<textarea readonly="true">
　　　　　　　　　欢网开发者联盟平台合作合同

合同版本：1.00
发布时间：2012年8月8日

授权方：开发者 (以下简称为甲方)

被授权方：欢网科技（北京）有限责任公司(以下简称为乙方)
地址：北京市朝阳区劲松三区甲302号华腾大厦25层
邮编：100021
电话：+86-10-87216363
传真：+86-10-87216200
甲乙双方经友好协商，本着互惠互利的原则，就产品合作运营事宜达成如下合同条款，以资遵守：

    智能电视开发者社区是一个专注于电视应用开发领域的社区网站，社区签约开发者提交的应用作品可申请进入中国智能多媒体终端技术联盟（以下简称“中智盟”）成员TCL、长虹、海信三家智能电视平台应用程序商店进行销售。作为中智盟的运营方，广州欢网科技有限责任公司将作为本合同的甲方履行本合同中的各项条款。
一、鉴于 
    1.1 甲方为中智盟的独家运营方，具有签署本合同的合法主体资格，且在签署本合同时无任何法律障碍和重大事件影响其继续正常存续和履行本合同的能力。
    1.2 乙方为应用产品提供商，是具有签署本合同的合法主体资格，且在签署本合同时无任何法律障碍和重大事件影响其继续正常存续和履行本合同的能力。 
    遵从《中华人民共和国民法通则》、《中华人民共和国合同法》等相关法律法规规定，利用甲方“智能电视开发者社区”向用户提供乙方应用商品服务，本着共赢原则，双方达成如下协议。
二、定义 
    2.1 智能电视开发者社区：是由中智盟聚合广大电视应用开发者、应用提供商及其创作的优秀应用商品资源，满足多类型终端用户对电视终端应用商品的体验和消费需求的社区平台。用户通过“智能电视开发者社区”所提供的电视终端平台，可便捷查找、下载、试用、购买、管理、评价和推荐适合自己和亲友电视终端的各类应用；同时，广大电视应用开发者和应用提供商可为社区供应各类自行创作或拥有合法知识产权的应用商品，并获取应用商品销售收入。 
    2.2 应用商品：指在“智能电视开发者社区”所提供的电视终端平台及其相关渠道销售的、可在电视终端设备安装或运行的应用程序及服务，包括但不限于电视软件、电视游戏类应用等。 
    2.3 用户信息：指包括但不限于用户的姓名或者名称、有效证件号、住址、位置信息、联系方式等内容。 
    2.4 “先使用后付费”（Try and Buy）计费销售模式：指应用开发者或应用提供商根据应用商品的特性采用不同的限制策略，以“共享软件”的形式销售应用商品，并授权用户试用。用户可以免费下载试用和体验应用商品，在满足一定条件（如使用时限、次数或其他功能逻辑等）后再触发向用户计费，用户自行确认是否同意付费。这是“智能电视开发者社区”提供的除“下载计费销售模式”以外的另一种计费销售模式。 
三、服务内容 
    3.1 甲方作为“智能电视开发者社区”平台提供商及运营方，为乙方提供应用商品测试、适配与展示、促销活动及受乙方的委托向用户代收代扣费用等相关服务。 
    3.2 乙方利用甲方的“智能电视开发者社区”所提供的电视终端平台，向用户提供应用商品，委托甲方向用户代收代扣费用。 
四、双方的权利和义务 
    4.1 甲方的权利和义务 
    4.1.1 甲方有权要求乙方提供并审核其个人有效证件、真实联系方式及银行帐户信息等资料。 
    4.1.2 甲方负责“智能电视开发者社区”平台的建设及运营，并制定相关的平台规划、应用商品组织、运营规则等方案及相关的管理规则、服务规范、工作手册等（统称“平台管理规则”），并有权要求乙方遵守和执行。 
    4.1.3 甲方有权对乙方提供的应用商品进行审核，包括但不限于内容审查、功能性测试、安全性测试等。如甲方发现乙方应用商品不符合国家法律法规、政策规定，或乙方不具备经授权的计费能力、联网能力，或乙方提供的应用商品可能侵犯他人合法权益或含有对其他第三方的广告信息等内容，或存在违反“智能电视开发者社区”的平台管理规则的情况或其他甲方认为不符合甲方要求的情况，甲方有权不予接入和传输，已接入和传输的，甲方有权按相关法律法规规定或平台管理规则立即停止接入和传输，保存有关记录，并向相关主管部门报告。但是，该项约定不得视为甲方对乙方提供的应用商品提供合法性担保，乙方应自行对其提供的商品提供保证，并承担可能由此引发的责任。 
    4.1.4 甲方通过供应商资格审核、应用商品测试、用户使用反馈等管理和监控手段，力求保证乙方通过“智能电视开发者社区”所提供的电视终端平台向用户提供的应用商品符合国家法律法规规定，并安全、可用，但是甲方不对乙方应用商品及其内容的合法性、安全性、可用性、著作权/商标权/专利权等知识产权、肖像或形象等授权承担责任。 
    4.1.5 甲方有义务将乙方提供的应用商品在“智能电视开发者社区”所提供的电视终端平台的销售产生的代收费用在符合向乙方支付条件时根据约定支付给乙方，详见第八条约定。 
    4.1.6 甲方有权对乙方遵守和执行平台管理规则的情况进行检查和监督。 
    4.1.7 甲方拥有用户信息的管理权，有权要求乙方提供其掌握的用户使用应用商品的情况。 
    4.1.8 甲方提供用户服务号码作为用户业务投诉和咨询的呼叫服务接入号，并且甲方的用户服务中心将作为用户服务问题的最终确认与分发方，乙方用户服务人员或用户服务系统应根据甲方要求协助甲方分析和处理用户的相关业务投诉与咨询问题。甲方有权将由非网络通信问题引起的用户咨询和投诉转到乙方处理，如应用商品可用性、兼容性等质量问题。
    4.1.9 甲方在受理因乙方责任引起的用户投诉时，对于需要向投诉用户退还信息费的，有权先代乙方垫付，然后再从与乙方结算的金额中扣除。 
    4.1.10 甲方有权进行“智能电视开发者社区”的市场推广、用户宣传等工作。甲方有权要求乙方在市场推广和用户宣传中标注“智能电视开发者社区”、中智盟或甲方的品牌或标识。若乙方在其宣传和广告内容中涉及甲方的公司名称、“智能电视开发者社区”及其他中智盟的品牌标识时，必须事先征得甲方或中智盟的书面同意（或签署商标使用许可合同等）。 
    4.1.11 甲方有权将乙方提供的应用商品标识图片、运行截图、宣传预览图及文字描述信息等用于“智能电视开发者社区”门户网站、中智盟终端或甲方相关营销传播活动、推广渠道等进行应用商品详情展示。 
    4.1.12 甲方有权根据实际终端消费市场发展趋势及用户行为意向趋势，对乙方发布的应用商品进行非自选机型的扩展适配，以增加应用商品的用户达到率，以覆盖更广的消费客户群体。 
    4.1.13 乙方提供的应用商品一旦发生纠纷，包括但不限于应用商品侵犯他人的知识产权、诉讼、重大投诉、发生违反合同约定的重大情形等，甲方有权停止该应用商品的测试、宣传、在线销售等活动并冻结甲方向乙方的代收费用结算，同时乙方需承担由此引起的全部法律责任及赔偿甲方由此遭受的全部损失，包括但不限于遭第三方追索所造成的损失。 
    4.1.14 甲方有权根据本协议约定、国家相关主管部门指令、平台管理规则以及对乙方运营考核的情况，暂停或终止乙方利用“智能电视开发者社区”所提供的电视终端平台销售应用商品，并暂停或终止提供代计、代收费等服务。 
    4.1.15 若乙方在合同有效期内出现欠费情况，甲方通知并提请乙方在30日内缴纳欠款，而乙方逾期未缴纳的，甲方有权终止本协议并向乙方追缴欠费及合理利息。 
    4.2 乙方的权利和义务 
    4.2.1 乙方应根据甲方要求向甲方提供个人有效证件、真实联系方式及银行帐户信息等资料。 
    4.2.2 乙方务必确保其所提供的结算银行资料、账户信息的准确性，确保在“智能电视开发者社区”业务平台填写登记的资料、上载的银行开户许可证电子文档附件等资料真实准确。如乙方资料发生变更，务必马上在“智能电视开发者社区”业务平台对相关信息和附件进行同步更新，并下载、打印、填写、签署相关的结算信息变更书面函件提供甲方进行相关财务资料变更管理。如因乙方提供资料不准确或未及时更新而导致结算失败，由乙方自行承担责任。 
    4.2.3 未经甲方同意，乙方不得将账号转让他人使用。 
    4.2.4 乙方需保证其通过“智能电视开发者社区”平台向用户提供的所有应用商品和信息资料均符合我国法律法规和其他规范性文件的规定、本协议的约定以及甲方的要求，包括但不限于本协议第五条、第六条、第七条的约定。 
    4.2.5 乙方有权获得其提供的应用商品在“智能电视开发者社区”所提供的电视终端平台销售产生的由甲方代收的相应销售收入，甲方将根据本协议第八条约定向乙方支付相应代收费用。 
    4.2.6 乙方提供、停止提供或变更应用商品均须经甲方审核同意后予以实施。 
    4.2.7 乙方需遵守和执行甲方“智能电视开发者社区”的平台管理规则，并接受甲方的检查和监督。 
    4.2.8 乙方如需通过“智能电视开发者社区”所提供的电视终端平台向用户传播广告信息，应事先获得甲方的书面授权，并按照甲方要求开展相应活动。 
    4.2.9 若甲方认为乙方提供的应用商品存在违反法律法规和其他规范性文件或侵权的可能，甲方即时通知乙方并有权即时将违法违规或侵权产品下线，乙方应在收到甲方通知后2小时内给予甲方初步回复，并在24小时内查明原因向甲方详细说明情况。若经核实情况属实，乙方应立即停止提供该应用商品，并尽最大努力降低影响范围和减少双方损失的进一步扩大。 
    4.2.10 乙方负责承担由非网络通信问题引起的用户咨询和投诉，并提供有效通畅的投诉受理渠道，积极配合甲方处理用户投诉。对甲乙双方均不能做出合理解释的用户投诉，最终由乙方负责进行处理和解决。如果甲方因为乙方应用商品受到用户起诉，乙方应按照本合同第6.4条执行。 
    4.2.11 乙方通过“智能电视开发者社区”所提供的电视终端平台向用户销售应用商品，在用户确认购买或使用前，需取得用户确认同意且告知用户由甲方代乙方收费。 
    4.2.12 乙方向用户销售的应用商品，需明确应用商品的内容，包括但不限于应用商品的信息、使用方式、资费标准、有效期限、应用商品的提供商或提供者、客服电话等。 
    4.2.13 乙方如在合同有效期内出现欠费情况，应在甲方指定的期限内缴纳欠款。 
    4.2.14 乙方应自行承担其税务义务，包括个人所得税等各种税费，月结算收入默认由甲方统一代理乙方到税务局进行缴税，如乙方需要自行缴税，可与甲方签订补充协议后，自行到当地税务机关进行缴税，并提供税务局代开的发票原件作为甲方付款的依据。 
    4.2.15 当乙方单个应用商品在此合同项下得到的结算信息费达到人民币 5000元时，乙方须自行于中国版权保护中心（www.ccopyright.com.cn）办理其接入的应用商品的著作权登记，并负责产生的相关费用。 
    4.2.16 乙方不得以任何形式实施任何不被许可的购买行为（包括但不限于下述行为）以损害甲方、其他开发者和用户的利益，包括但不限于： 
    （1）以“自消费”的形式通过“智能电视开发者社区”所提供的电视终端平台大量下载或购买乙方自身应用商品，以提高自身应用商品的销售排名展示位置或提高应用商品销售的信息费收入； 
    （2）在未经用户主动确认下载或购买应用商品的情况下，强行或提前触发应用商品计费或收费行为。
五、“智能电视开发者社区”应用商品发布基本协议 
    5.1 乙方需确保通过“智能电视开发者社区”平台所发布的应用商品及一切资料（包括名称、图片、文字、程序包、数字媒体内容、在线获取的内容等）符合《中华人民共和国宪法》、《互联网出版管理暂行规定》、《互联网信息服务管理办法》等相关法律法规的规定，不含有以下内容： 
    （1）反对宪法确定的基本原则的； 
    （2）危害国家统一、主权和领土完整的； 
    （3）泄露国家秘密、危害国家安全或者损害国家荣誉和利益的； 
    （4）煽动民族仇恨、民族歧视，破坏民族团结，或者侵害民族风俗、习惯的； 
    （5）宣扬邪教、迷信的； 
    （6）散布谣言，扰乱社会秩序，破坏社会稳定的； 
    （7）宣扬淫秽、赌博、暴力或者教唆犯罪的； 
    （8）侮辱或者诽谤他人，侵害他人合法权益的； 
    （9）危害社会公德或者民族优秀文化传统的； 
    （10）有法律、行政法规和国家规定禁止的其他内容的。 
    5.2 乙方不得通过“智能电视开发者社区”平台发布符合以下情况的应用商品： 
    （1）含有任何病毒、木马等恶意代码或功能的； 
    （2）可导致电视终端硬件损坏或功能故障的； 
    （3）可在未经用户确认的情况下读取、复制、转发、编辑、传播或删除终端内储存的文件或数据的； 
    （4）对“智能电视开发者社区”、中智盟或甲方形象、品牌、应用商品或业务造成损害的； 
    （5）内置医药、保健、美容类广告信息的； 
    （6）内置中奖或抽奖信息的。
六、“智能电视开发者社区”应用商品知识产权管理协议 
    6.1 甲方不对乙方提供的应用商品的知识产权权属负责，乙方对通过“智能电视开发者社区”平台发布的应用商品及一切资料的知识产权权属自行承担一切法律责任。 
    6.2 乙方需确保对所发布的应用商品及其相关素材拥有合法的知识产权或已取得合法充分的知识产权授权。 
    6.3 乙方如发布含有气象、教育、医疗、交通、金融、影视、动漫、刊物、资讯等行业专业信息的应用商品，或含有公众人物、名人、个人的头像、标识、肢体语言等信息的应用商品，需确保拥有合法的使用权、肖像权或形象权。 
    6.4 乙方保证其应用商品不会侵犯任何第三方的合法权利。如果乙方所发布的应用商品存在侵犯任何第三方合法权利的情况，乙方将承担一切相关法律责任和风险。如果甲方因乙方应用商品侵犯第三方合法权利而涉入诉讼、索赔或其他司法程序（以下称“侵权诉讼”），乙方同意按照以下规定进行处理和赔偿： 
    （1）甲方应在发生上述侵权诉讼后迅速通知乙方，并在上述侵权诉讼过程中中止向乙方提供服务。 
    （2）乙方应当在收到甲方书面通知后，指派代表为甲方的权益参与上述第三方提起的侵权诉讼，乙方应在上述侵权诉讼进行过程中就诉讼策略及其他事宜向甲方提供必要的支持与协助，并承担所产生的一切诉讼费用、律师费用、差旅费用、和解金额或生效法律文书中规定的损害赔偿金额、软件使用费等费用。 
    （3）甲方有权按照本合同关于违约责任的规定要求乙方承担违约责任。 
    6.5 如果任何第三方对乙方所发布的应用商品及其相关素材的知识产权归属提出质疑或投诉，乙方有责任出具相关知识产权证明材料，并配合甲方相关投诉处理工作，同时甲方有权对相关应用商品进行下线处理。 
七、应用商品“先使用后付费”计费模式使用协议 
    7.1 甲方为乙方在“智能电视开发者社区”及其授权渠道发布和销售的应用商品提供“先使用后付费”计费销售模式，并支持以下两种计费方式： 
    （1）图形鉴权方式：通过调用SDK代码组进行计费鉴权和计费触发（该方式可防止应用程序包被非法拷贝免费使用）； 
    （2）普通鉴权方式：通过调用SMS计费通道进行计费鉴权和计费触发（该方式不可防止应用程序包被非法拷贝免费使用）。 
    7.2 乙方如需对在“智能电视开发者社区”及其授权渠道发布和销售的应用商品使用“先使用后付费”计费销售模式，可向甲方申请使用上述两种计费方式之一，由甲方评估确认后授权使用。 
    7.3 乙方通过“智能电视开发者社区”业务平台申请的“先使用后付费”计费资源（SDK代码组或短信计费端口）只可使用于乙方自身在“智能电视开发者社区”及其授权渠道发布和销售的应用商品，不得使用于“智能电视开发者社区”未提供服务的或其他未获“智能电视开发者社区”授权的渠道销售的应用商品，或提供任何第三方机构或个人使用。 
    7.4 乙方在“智能电视开发者社区”业务平台申请的“先使用后付费”计费资源（SDK代码组或短信计费端口）时，每组计费资源与每个应用商品建立“一一对应”的绑定关系，乙方对每个应用商品只允许调用与之相对应的计费资源，不得将计费资源使用于非对应的应用商品。 
    7.5 乙方应用商品在执行计费触发行为前，务必在操作界面上向用户明示计费提示信息、明确具体的资费金额，并在用户自行触发“同意”或“确认”后，方可实施计费触发。 
    7.6 乙方对采用“普通鉴权方式”计费的应用商品，在用户确认同意付费后，无论是否实际计费成功，其应用商品逻辑设置均应立即向用户提供付费购买的应用商品内容。 
    7.7 甲方有权制定、发布和更新“先使用后付费”计费模式相关的使用规范文档或其他相关的业务规则，乙方应当遵照执行。对于乙方使用SDK或SMS计费资源时植入的计费提醒功能、计费确认触发的行为逻辑、调用触发计费的次数及资费设置规则等，甲方有权要求乙方按照相关规范文档落实执行。 
八、报酬、结算和付款 
    8.1 由甲方代乙方实际向用户收取信息费，在扣除税务成本、支付成本和坏账后，剩余信息费的30%，将作为甲方向乙方提供服务的服务费用，由甲方直接从代收的费用中扣除。 
    8.2  在扣除税务成本、支付成本和坏账后，乙方获得就本协议所述服务由甲方代乙方实际向用户收取的信息费的70%。以上所述信息费是指用户正常使用业务所产生的有效、合理信息费结算，但不包括乙方实施不被许可的购买行为所产生的收入，如自消费、非法套利等，以及沉默用户信息费、用户话费欠费等其他异常收入。 
    8.3 由于可能存在由于用户账号余额不足、欠费等原因导致少量应用商品订购记录未能成功计费的情况，上述“甲方代乙方向用户收取的信息费”以甲方计费系统成功扣费的金额为准。 
    8.4 乙方如认为甲方发布的结算数据与乙方自行统计的同一计费周期的应收总额存在差异，可在甲方发布结算数据当日起30天内通过“智能电视开发者社区”业务平台发起“对账”申请，甲方稽核后给予反馈；如乙方在甲方发布结算数据当日起30天内没有发起“对账”申请，则甲方不再受理该计费周期的对账请求；鉴于可能存在由于用户话费余额不足、欠费等原因导致少量应用商品订购记录未能成功计费的情况，如甲方对乙方提出的相关对账请求评估后发现差异率低于5%，甲方有权不接受对账申请并不反馈对账稽核结果。 
    8.5 “智能电视开发者社区”业务的计费周期为每自然月的一日0时至当月最后一日24时；结算周期为次月10日至次次月（即下个月的下个月）最后一日。 
    8.6 甲乙双方同意，在甲方向乙方结算信息费时，甲方有权先行扣除其服务报酬。甲方以月为周期，在扣除其服务报酬后向乙方支付其代乙方向用户实际收到的信息费，如乙方按照甲方要求依时完成结算付款前的准备工作（如交付有效发票等），甲方对本计费周期计收的信息费一般在次月最后一日前向乙方完成结算付款，如遇特殊情况，在次次月最后一日前向乙方完成结算付款。 
    8.7 当乙方任一个月其累计未结算信息费低于1000元时，甲乙双方同意当月暂不结算，待乙方累计未结算信息费超过1000元时，再行结算；如乙方至年末累计未结算信息费低于1000元，则结算时间为： 
    （1）如乙方本年最后一次结算时间为6月30日前（含6月30日），则累计未结算信息费于次年1月底前统一结算； 
    （2）如乙方本年最后一次结算时间为7月1日至12月31日期间，则累计未结算信息费于次年7月底前统一结算。 
    8.8 如因用户余额不足等原因导致甲方无法代乙方向用户正常收取的费用，甲方将在当前即将向乙方结算付款的金额中进行核减后再向乙方支付，如无法核减的，乙方应按甲方要求退还，并在20个工作日内将款项电汇至甲方指定账户。 
    8.9 由于乙方应用商品质量问题或因乙方未经用户确认或同意即执行计费触发行为等原因造成用户拒绝支付费用的，甲方将从甲方代乙方向用户收取的信息费中扣除后再与乙方进行结算。 
九、保密条款 
    9.1 本合同拥有信息的一方（“提供方”）根据本合同向另一方（“接受方”）提供的信息，或在业务开展过程中接受方从提供方获知的提供方开发、创造、发现的或为提供方所知的或转移至该提供方的对该提供方有商业价值的专有信息，包括但不限于有关商业秘密、电脑程序、设计技术、想法、专有技术、工艺、数据、业务和应用商品开发计划等，以及用户信息、本合同的条款和与本合同有关的其他商业信息和技术信息（以下统称“保密信息”），只能由接受方及其人员为本合同目的而使用。除本合同另有规定外，对于提供方提供的任何保密信息，未经提供方的书面同意，接受方及其知悉保密信息的人员均不得直接或间接地以任何方式提供或披露给任何“第三方”。在本条中，“第三方”是指任何自然人、法人或其它组织。 
    9.2 乙方同意并在此再次强调，其对用户信息负有严格的保密义务。 
    9.3 提供方向接受方提供或披露的保密信息，仅可由接受方为执行本合同需要披露给指定的人员，并且仅在为执行本合同所需的范围内进行该等披露；但是，接受方在采取一切合理的预防措施之前，不得向该人员披露任何保密信息，该等预防措施包括但不限于告知该人员将要披露信息的保密性质，由该人员做出至少与本合同保密义务一样严格的保密承诺等，以防止该人员为个人利益使用保密信息或向任何第三方做出未经授权的任何披露。 
    9.4 接受方的律师、会计师、承包商和顾问为提供专业协助而需要了解保密信息时，接受方可向其披露保密信息，但是，其应要求上述人员签订保密协议或按照有关职业道德标准履行保密义务。 
    9.5 如相关政府部门或监管机构要求接受方披露任何保密信息，接受方可在该政府部门或机构要求的范围内做出披露而无需承担本合同项下的责任。但前提是，该接受方应立即将需披露的信息书面通知提供方，以便提供方采取必要的保护措施，且该等通知应尽可能在信息披露前做出，并且接受方应尽商业上合理的努力确保该等被披露的信息获得有关政府机关或机构的保密待遇。 
    9.6 本条所规定的保密义务应永久持续有效。 
    9.7 本条规定的保密义务对以下信息不适用： 
    （1）在一方披露时已为公众所知的信息，或在披露后并非因接受方和/或其指定人员、律师、会计师、承包商、顾问或其他人员的原因而为公众所知的信息； 
    （2）有书面证据证明在披露时已由接受方掌握的信息，并且该信息并非直接或间接来自提供方； 
    （3） 有书面证据证明第三方已向接受方披露的信息，并且该第三方不承担保密义务且有权披露。 
    9.8 提供方有权随时书面通知接受方归还任何包含保密信息的材料和/或该等材料的任何复印件，并附上证明接受方在归还此类材料后不再直接或间接地保留或控制任何保密信息或包含保密信息的任何该等材料的书面声明。接受方应在收到该书面通知后的合理时限内遵守任何该等要求。对于双方约定不必归还提供方的任何包含保密信息的材料和/或该等材料的任何复印件，接受方应按照提供方的要求销毁或不可恢复地删除并应向提供方书面确认该等销毁或删除。 
十、违约责任及协议终止 
    10.1 任何一方不履行本合同约定的义务或履行义务不符合本合同约定的，视为违约，应停止违约行为，并承担继续履行、采取补救措施或赔偿损失等违约责任。 
    10.2 如果发生以下情况，甲方有权立即停止乙方相关业务或终止本协议，同时乙方应赔偿因此给甲方造成的全部损失： 
    （1）乙方履行本协议过程中有违反国家法律、法规、行政规章等规定的行为； 
    （2）乙方向甲方提供虚假的营业执照、银行账户及税务登记证、身份证件、知识产权权属证明等企业资料和信息； 
    （3）乙方假借他人的营业执照（身份证件）登记注册； 
    （4）乙方违反本协议关于知识产权或保密条款的约定的； 
    （5）出现本协议10.3条约定的情形的。 
    10.3 如果发生以下情况，甲方有权中止与乙方进行结算、停止代乙方应用商品计费或收费、清理用户与乙方应用商品的定购关系，并要求乙方立即整改，同时乙方应赔偿因此给甲方造成的全部损失，情节特别严重者，按本协议10.2条款约定处理： 
    （1）甲方用户对乙方应用商品质量或权利瑕疵提出强烈投诉并引发升级诉讼； 
    （2）乙方提供的应用商品存在安全缺陷或者其他程序漏洞，造成甲方用户强烈投诉； 
    （3）乙方提供的应用商品的测试、开通和系统修改工作引起甲方的网络系统故障或用户终端严重受损； 
    （4）乙方其他违反本协议内容的行为。 
十一、不可抗力 
    11.1 本合同所称“不可抗力”，是指不能预见、不能避免并不能克服的客观情况，如战争、火灾、台风、洪水、地震或其他双方共同认为属于不可抗力的原因等。 
    11.2 合同一方或双方在履行本合同的过程中因不可抗力而不能按约定全部或部分履行其义务，遇到不可抗力的一方（“受阻方”）满足下列所有条件的，不应被视为违反本合同： 
    （1）受阻方不能全部或部分履行其义务是由不可抗力直接造成的，并且在不可抗力发生前不存在迟延履行义务的情形； 
    （2）受阻方已尽最大努力履行其义务并且减少由于不可抗力给另一方造成的损失； 
    （3）受阻方在不可抗力发生后立即通知另一方，并且在不可抗力发生后的十五（15）日内向另一方提供有关该不可抗力的权威证明文件和书面说明，该书面说明中应包括对迟延或部分履行本合同的原因的说明。 
    11.3 不可抗力终止后，受阻方应继续履行本合同并尽快通知另一方。受阻方可以延长履行本合同，延长的时间相当于不可抗力实际造成延误的时间。 
    11.4 不可抗力或其影响持续达三十（30）日或以上的，双方应根据该不可抗力对履行本合同的影响程度，协商变更或终止本合同。自一方发出书面协商通知之日起十五（15）日内双方无法达成一致的，任何一方均有权终止本合同并且不承担违约责任。 
十二、适用法律和争议解决 
    12.1 本合同的成立、效力、解释、履行、签署、修订、终止以及争议解决等均适用中华人民共和国法律。 
    12.2 与本合同有关的任何争议，由双方友好协商解决；协商不成，向甲方住所地人民法院提起诉讼。 
    12.3 诉讼进行过程中，除双方有争议的部分外，本合同其他部分仍然有效，各方应继续履行。 
十三、协议生效及其他 
    13.1 在本协议有效期间，乙方同意遵守甲方不时制定、修改和颁布的“智能电视开发者社区”平台管理规则，包括但不限于业务管理规定、用户服务管理规定等，如平台管理规则与本协议有冲突，以平台管理规则为准。 
    13.2 本协议未尽事宜由甲乙双方友好协商后，以书面补充协议的形式加以补充。补充协议与本协议有不一致的，以补充协议为准。 

				</textarea>
							<label for="agree">同意以上协议</label>
							<input type="checkbox" id="agree" name="verify" value="1">
						</li>
					</ul>
				</section>
					<div class="b_btn">
						<input type="submit" value="申请签约"  name="upload_photo" id="uploadsuccessbuttom" <?php if (!$_smarty_tpl->getVariable('U')->value->certpicture){?>class="unavailable" disabled<?php }else{ ?>class="btn"<?php }?> />
					</div>
				</ul>
			</form>
		</div>				
	</div>
</div>
	<?php }elseif($_smarty_tpl->getVariable('action')->value=='upgrade'){?>
	<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<div class="bl f_r">
	<div class="tit f_c">
		<h3>开发者签约资料</h3></div>
		<div class="box_edit">
		<?php if ($_smarty_tpl->getVariable('U')->value->status=='800'){?>
				<section>
					<h3>基本信息<span class="c_red">*</span></h3>
					<ul>
						<li class="b_inline">
							<label for="name">真实姓名：</label><?php echo $_smarty_tpl->getVariable('U')->value->realname;?>

						</li>
						<li class="b_inline">
							<label for="contact">联系方式：</label><?php echo $_smarty_tpl->getVariable('U')->value->mobile;?>

						</li>
						<li>
							<label>证件类型：</label><?php echo $_smarty_tpl->getVariable('U')->value->certtypestr;?>
 <?php echo $_smarty_tpl->getVariable('U')->value->certno;?>

						</li>
						<li>
							<label>证件照片：</label>
								<div id="img" class="img"><img src="<?php echo $_smarty_tpl->getVariable('U')->value->certpicture;?>
" width="130">
								</div>
						</li>
						<li>
							<label>个人介绍：</label>
							<textarea name="introduction" isw="2" msg="个人说明不符合规范" regex="intro" readonly="true"><?php echo $_smarty_tpl->getVariable('U')->value->introduction;?>
</textarea>
						</li>								
					</ul>
				</section>
				<section>
					<h3>支付信息</h3>
					<ul>
						<li class="b_inline">
							<label for="bank">开户行：</label><?php echo $_smarty_tpl->getVariable('U')->value->bank;?>

						</li>
						<li class="b_inline">
							<label for="bankAddr">开户行地址：</label><?php echo $_smarty_tpl->getVariable('U')->value->bankaddress;?>

						</li>
						<li style="overflow:hidden">
							<label for="bankTel">开户行电话：</label><?php echo $_smarty_tpl->getVariable('U')->value->bankphone;?>

						</li>
						<li class="b_inline">
							<label for="accountName">银行户名：</label><?php echo $_smarty_tpl->getVariable('U')->value->bankaccountname;?>

						</li>
						<li class="b_inline">
							<label for="account">银行账号：</label><?php echo $_smarty_tpl->getVariable('U')->value->bankaccount;?>

						</li>							
					</ul>
				</section>
				<section>
					<h3>签约协议</h3>
					<ul>
						<li class="b_service">
							<label>　</label>
							<div class="serviceItem">
							<textarea readonly="true">
　　　　　　　　　欢网开发者联盟平台合作合同

合同版本：1.00
发布时间：2012年8月8日

授权方：开发者 (以下简称为甲方)

被授权方：欢网科技（北京）有限责任公司(以下简称为乙方)
地址：北京市朝阳区劲松三区甲302号华腾大厦25层
邮编：100021
电话：+86-10-87216363
传真：+86-10-87216200
甲乙双方经友好协商，本着互惠互利的原则，就产品合作运营事宜达成如下合同条款，以资遵守：

一、标的

    1.甲方加入乙方提供的“欢网开发者联盟”，使用“欢网开发者联盟”提供的功能和服务，并遵守“欢网开发者联盟”的要求。
    2.甲方将甲方研发并拥有的知识产权的基于授权产品（具体产品以甲方后台自主提交为准）的授予乙方。乙方有权在商城、工具软件、论坛、网站、手机预装等渠道向用户提供授权产品的发行、推广、捆绑销售、预装、复制生产、提供下载及收费，双方共享推广获得的用户的收益。

二、合作方式及结算

    1.甲方如使用欢网市场的下载收费功能，甲方授权发布产品所获得的全部收入由双方共享：甲方获得用户购买面值的70%，乙方获得用户购买面值的30%。
    2.如甲方授权发布产品为免费产品，则甲方无需向乙方支付任何费用。
    3.各结算数据以乙方平台数据为准，乙方需向甲方开放数据平台，提供并共享真实有效的收费和收入的数据，以保证双方利益的公正性。
    4.乙方以一个自然月为一个结算周期，每月初按上月实际获得收入支付甲方分成费用。乙方应在次月10日前将上月应支付数据发送给甲方。双方在确认数据后，如甲方为公司，则甲方应将合法有效的正式服务发票寄给乙方。乙方在收到正式发票后5个工作日内将甲方所得收入汇入甲方指定帐户。
    5.因乙方和移动运营商、SP、渠道商、代收通道之间账期而未实际结算的费用，在乙方收入实际费用后再和甲方进行结算。
    6.如当结算周期实际结算费用不足500元，则当期不进行结算，费用归入下一结算周期周期统一结算。
    7.如甲方为个人，无需提供发票，但需按国家规定，扣除应缴纳之所得税。目前国家规定每月收入超过800元部分，应由支付方代为扣缴20%的所得税款。甲方应提供身份证复印件（或照片）及身份证号码。
    8.乙方无故拖延向甲方定期发送的结算单或拖延经双方确认的结算金额的支付，甲方有权向乙方索还拖欠费用并有权单方面向对方发出书面通知终止双方确定的合作项目。

    1．甲方可自由选择以下产品收益模式，乙方推广甲方授权产品所获得的全部收入由双方共享。收入分配方式如下：

     产品收益模式	                                                开发者收入
        
    “欢网下载”收费下载	                                用户购买面值的70%
    通过开发者平台提交到其他商城和发行渠道获得的下载收入	获得实际收入的90%
    使用欢网SDK余额支付功能获得的收入	                    用户购买面值的70%
    使用欢网SDK短信支付功能获得的收入	                 甲方获得实际收入的50%
    免费下载	                                                    无
    
    具体授权产品对应之收费方式，以甲方提出产品时选择之支付方式为准。
	2.各结算数据以乙方平台数据为准，乙方需向甲方开放数据平台，提供并共享真实有效的收费和收入的数据，以保证双方利益的公正性。
    3.乙方以一个自然月为一个结算周期，每月初按上月实际获得收入支付甲方分成费用。乙方应在次月10日前将上月应支付数据发送给甲方。双方在确认数据后，如甲方为公司，则甲方应将合法有效的正式服务发票寄给乙方。乙方在收到正式发票后5个工作日内将甲方所得收入汇入甲方指定帐户。
    4.因乙方和移动运营商、SP、渠道商、代收通道之间账期而未实际结算的费用，在乙方收入实际费用后再和甲方进行结算。
    5.如当结算周期实际结算费用不足500元，则当期不进行结算，费用归入下一结算周期周期统一结算。
    6. 如甲方为个人，无需提供发票，但需按国家规定，扣除应缴纳之所得税。目前国家规定每月收入超过800元部分，应由支付方代为扣缴20%的所得税款。甲方应提供身份证复印件（或照片）及身份证号码。
    7.乙方无故拖延向甲方定期发送的结算单或拖延经双方确认的结算金额的支付，甲方有权向乙方索还拖欠费用并有权单方面向对方发出书面通知终止双方确定的合作项目。

三、权利与义务

    （一）甲方的权利和义务
    1.甲方有权使用乙方平台的各项技术及服务，包括数据统计、兼容测试、支付等。
    2.甲方负责提交授权产品的客户服务和日常维护工作，并保证稳定运行。
    3.根据市场运营情况，乙方有权要求甲方对合作授权产品依市场运营实际情况进行适当的机型适配、产品升级，或提供不同语言的版本，具体情况及成本负担由双方另立合同附件进行详细说明。
    4.甲方保证提供的授权产品不存在明显质量问题或严重BUG，若在授权产品运营的过程中出现BUG等质量问题，乙方可要求甲方进行无偿修正，甲方应给予积极配合。 
    5.甲方可在授权产品中增加连接网站和广告等内容，但必须告知乙方，不得隐藏连接网站和广告。甲方需对增加的连接网站和广告内容负全部连带责任。
    6.甲方保证授权产品符合中国的法律规定，不包括任何色情、政治等非法信息，不存在盗取、破坏用户数据及系统的隐藏内容。有任何违法犯罪行为，全部由甲方负责，乙方不承担任何联带责任。
    7.甲方保证其具备合法资格从事本合同规定的服务，向乙方提供的授权产品及其相关信息（包括但不限于授权产品中所含的任何内容、元素、创意、程序、代码、算法、文字、图像、声音）具有合法版权，不违反任何法律法规，也不侵犯任何第三方的合法权益。有任何违约侵权行为，全部由甲方负责，乙方不承担任何联带责任。
    （二）乙方的权利和义务
    1.乙方在开发者联盟平台、欢网下载商城、欢网网站及论坛，应对于甲方的授权产品提供必要的市场宣传和推广。
    2.乙方负责开发者平台的各项服务的日常维护工作，并保证稳定运行。
    3.乙方保证其具备合法资格从事本合同规定的服务，向甲方授权产品提供的相关推广和运营合法，不违反任何法律法规，也不侵犯任何第三方的合法权益。有任何违约侵权行为，全部由乙方负责，甲方不承担任何联带责任。

四、知识产权

    1.甲方授权给乙方的所有授权产品（包括但不限于许可软件中所含任何声音、音乐、图像、照片、动画、录像、视频软件以及应用程序），所有权仍归甲方所有，包括但不限于专利、著作权等知识产权，并不因双方的合作而有所改变。
    2.乙方不得以任何方式遮盖甲方产品的著作权标识，并在推广时说明授权产品为甲方所有。
    3.因双方合作需要，由乙方独立开发的技术、开发工具、宣传资料等权益，归乙方所有，并不因双方的合作而有所改变。
    4.由双方合作开发的技术、工具，或制作的广告、宣传资料等权益，归双方共有。
    5.甲方保证使直接或间接通过乙方合法拥有了授权产品的最终用户都能够获得必要的许可。
    6.甲方应按乙方要求为甲方授权产品出具必要的授权证明及其他可能需要的资料，以方便乙方开展业务。
    7.授权产品如涉及到第三方版权，合同一方应与第三方如制片公司，美工师、摄影师、模特儿、演员，和/或任何牵涉之个人、公司或组织签署合约、取得以本合同约定的方式使用人物肖像、图片、互动内容的许可，确保本合同的权利。
    8.任何一方需要在本合同所列授权产品的开发、生产或宣传中可使用对方商标、商号等商业标识，但应通知对方知晓并同意。
    9.一方故意或过失导致的该方及其员工以及其合同厂商或其他任何人对对方企业标识或知识产权的侵犯，该方应承担违约或侵权责任。

五、保密

    1.未经对方书面许可，任何一方不得向第三方泄露本合同的条款的任何内容以及本合同的签订及履行情况，以及通过签订和履行本合同而获知的对方及对方关联公司的任何信息。
    2.对于双方为对方提供的各种开发工具、技术、统计数据等，双方均有义务为对方保守机密，并制定公司规章保证自方雇员不泄露机密。
    3.有关法律、法规、政府部门、证券交易所或其它监管机构要求和甲乙双方的法律、会计、商业及其它顾问、授权雇员除外。
    4.在不可抗力消失后，双方应继续执行合同。

六、免责及赔偿条款

    1.任何一方直接或间接违反本合同的任何条款，或不承担或不及时、充分地承担本合同项下其应承担的义务即构成违约行为，守约方有权以书面通知要求违约方纠正其违约行为并采取充分、有效、及时的措施消除违约后果，并赔偿守约方因违约方之违约行为而遭致的损失。若违约方在收到守约方关于其违约行为的上述通知后10日内未纠正其违约行为，守约方有权以书面通知的方式单方提前终止本合同，并追究违约方之违约责任。
    2.在违约事实发生以后，经守约方的合理及客观的判断，该等违约事实已造成守约方履行本合同项下其相应的义务已不可能或不公平，则守约方有权以书面形式通知违约方提前终止本合同，违约方应赔偿守约方因违约方之违约行为而遭致的损失。
    3.因用户使用授权产品而导致任何第三方向任何一方提起索赔要求、诉讼或其他侵权指控行为，政府机构对任何一方作出处理/处罚，双方应互相配合进行处理。因违反合同、明显技术缺陷等过错等造成发生问题的一方应承担由此造成的一切责任、损失和赔偿，与另一方无关，包括但不限于诉讼费用、律师费用、差旅费用、和解金额、罚款或生效法律文书中规定的损害赔偿金额、软件使用费等全部损失等。一方给另一方造成名誉损失的，应当赔偿另一方名誉损失费用。

七、不可抗力

    1.除付款的义务外，任何一方由于自身合理控制以外的原因而无法履行本合同项下义务的，无须承担责任，如由于不可抗力、地震、洪水、政府行为、政策变更、大规模病毒爆发或互联网故障（非由于甲乙双方的行为引起的）。但是受影响的一方应立即通知对方，且尽力减少损失。
    2.在不可抗力消失后，双方应继续执行合同。

八、合同有效期

    本合同自甲方确认之日起生效，直到甲方将全部产品从乙方平台下架并书面通知乙方终止合作后终止。

九、合同有效区域

本合同有效区域为全球。

十、争议解决与适用法律

    1.本合同的订立、执行和解释及争议的解决均应适用中华人民共和国法律。
    2.如甲乙双方就本合同内容或其执行发生任何争议，甲乙双方应进行友好协商；不能达成一致，双方同意提交被告所在地仲裁委员会仲裁解决，任何该等争议应单独地仲裁，不得与任何其它方的争议在任何仲裁中合并处理，仲裁应在中国进行。

十一、其他

    1.条款独立性、弃权：如果本合同部分内容被有权的司法机关判定为违背法律而无效，不影响合同其它部分的效力。一次放弃追究违约责任不等于今后均放弃违约追偿，也不等于修改或放弃该弃权方其它权利。
    2.双方以电子方式签署本合同，合同最新版本可通过乙方平台查询到，乙方如更新合同内容应通知甲方。
    3.如本合同包含的某一条款或某些条款无论在任何方面由于任何原因被认为无效、非法或不可执行，则这种无效性、非法性或不可执行性将不影响本合同中的任何其它条款及整个合同的有效性，本合同将被视作从未包含过这类条款。

				</textarea>
							
						</li>
					</ul>
				</section>
				</ul>
			</form>
		</div>
<?php }else{ ?>
			<ul>
				<li>
					<label>账号：</label><span><?php echo $_smarty_tpl->getVariable('U')->value->username;?>
</span>
				</li>
				<li>
					<label>账户性质：</label><span><?php if ($_smarty_tpl->getVariable('U')->value->status=='800'){?>已签约
		<?php }elseif($_smarty_tpl->getVariable('U')->value->status=='200'){?>已申请签约，请等待审核
		<?php }elseif($_smarty_tpl->getVariable('U')->value->status=='300'){?>未通过签约，原因：<?php echo $_smarty_tpl->getVariable('U')->value->refuseinfo;?>

			<a href="<?php echo $_smarty_tpl->getVariable('obj')->value->url('upgradeinfo');?>
">重新申请签约</a>
		<?php }elseif($_smarty_tpl->getVariable('U')->value->status=='400'){?>注销
		<?php }elseif($_smarty_tpl->getVariable('U')->value->status=='500'){?>暂停
		<?php }elseif($_smarty_tpl->getVariable('U')->value->name==''||$_smarty_tpl->getVariable('U')->value->telephone==''||$_smarty_tpl->getVariable('U')->value->contactperson==''){?>资料不完整，请您先填写完整会员资料再申请签约
		<?php }else{ ?>未签约用户<a href="<?php echo $_smarty_tpl->getVariable('obj')->value->url('upgradeinfo');?>
">申请签约</a><?php }?></span>
				</li>
				
			</ul>
			</div>				
		</div>
		<?php }?>		
	</div>
</div>
	<?php }elseif($_smarty_tpl->getVariable('action')->value=='bankinfo'){?>
<?php $_template = new Smarty_Internal_Template("menu.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<div class="bl f_r">
	<div class="tit f_c">
		<h3>开发者签约资料</h3></div>
		<div class="box_edit">
			<form method="POST" action="<?php echo $_smarty_tpl->getVariable('url')->value;?>
?mod=person&act=bankinfo" onsubmit="return FRM.check(this);">
			<input type="hidden" name="formhash" value="<?php echo $_smarty_tpl->getVariable('formhash')->value;?>
"/>
				<section>
					<h3>支付信息</h3>
					<ul>
						<li class="b_inline">
							<label for="bank">开户行：</label><input type="text" id="bank" name="bank" value="<?php echo $_smarty_tpl->getVariable('U')->value->bank;?>
" maxlength="100"/>
						</li>
						<li class="b_inline">
							<label for="bankAddr">开户行地址：</label><input type="text" id="bankAddr" name="bankaddress" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankaddress;?>
" maxlength="200"/>
						</li>
						<li>
							<label for="bankTel">开户行电话：</label><input type="text" id="bankTel" name="bankphone" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankphone;?>
" maxlength="45"/>
						</li>
						<li class="b_inline">
							<label for="accountName">银行户名：</label><input type="text" id="accountName" name="bankaccountname" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankaccountname;?>
" maxlength="45"/>
						</li>
						<li class="b_inline">
							<label for="account">银行账号：</label><input type="text" id="account" name="bankaccount" value="<?php echo $_smarty_tpl->getVariable('U')->value->bankaccount;?>
" maxlength="100"/>
						</li>							
					</ul>
				</section>
				
					<div class="b_btn">
						<input type="submit" value="确定" class="btn" ><input type="reset" value="重置" class="btn">
					</div>
				</ul>
			</form>
		</div>				
	</div>
</div>
<?php }?>
	

<?php $_template = new Smarty_Internal_Template("../footer.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
