
var FRM = {
	fid:null,
	ids:null,
	func:null,
	init:function(id){
		this.fid=id;
	},
	check:function(id){
		this.fid=id;
		var chkbox = 0;
		for (i=0; i<this.fid.elements.length; i++){
			var r = true;
			var o = $(this.fid.elements[i]);
//			if( o.attr("isw")>'0' ){;}else{ continue;}
			if( o.attr("isw")=="1" || o.attr("isw")=="2" || o.attr("isw")=="3" ){
				switch(o.attr("type")){
					case "text":
					case "hidden":  r = this.text(o);break;
					case "textarea":r = this.textarea(o);break;
					case "password":r = this.password(o);break;
					case "select":r = this.select(o);break;
					case "checkbox":r=this.checkbox(o);break;
					default:break;
				}
				if( !r ){ return false;}
				if( o.attr("isw")==2 && !this.regex(o.attr("regex"),o.attr("value"))){ return this.alert(((typeof o.attr("tip") != "undefined")?o.attr("tip"):o.attr("msg")),o,false);}
				if( o.attr("isw")==3 && !(o.attr("value")).replace(/[^\x00-\xff]/g,"**").length ){ return this.alert(o.attr("msg1"),o,false);}
			}
		}
		return true;
	},
	regex:function(name,str){
		if( name == 'username' ){
			return pn_username.exec(str);
		}
		if( name == "desci")
			return pn_desci.exec(str);
		if( name == "attribute")
			return pn_attribute.exec(str);
		if( name == 'fee' )
			return pn_fee.exec(str);
		if( name == "password" )
			return pn_password.exec(str);
		if( name == 'email' )
			return pn_email.exec(str);
		if( name == "name" )
			return pn_name.exec(str);
		if( name == "mobile" )
			return pn_mobile.exec(str);
		if( name == 'intro' )
			return pn_intro.exec(str);
		if( name == 'bankname' )
			return pn_bankname.exec(str);
		if( name == 'banktel' )
			return pn_banktel.exec(str);
		if( name == "appname" )
			return pn_appname.exec(str);
//		alert(name);
		return true;
	},
	alert:function(msg,obj,ret){
		try{
			alert(msg);
			obj.focus();
		}catch(exception ){}
		return ret;
	},
	password:function(o){
		if( o.attr("value") == "" ){
			return this.alert(o.attr("msg"),o,false);
		}

		if( typeof o.attr("pid") != "undefined" ){
			var p = "#"+o.attr("pid");
			if( o.attr("value") != $("#"+o.attr("pid")).attr("value") ){
				return this.alert(o.attr("msg"),o,false);
			}
		}
		return true;
	},
	select:function(o){
	},
	checkbox:function(o){
		if(!o.attr("checked"))
			return this.alert(o.attr("msg"),o,false);
		else
			return true;
	},
	text:function(o){
		if( o.attr("value") == "" )
			return this.alert(o.attr("msg"),o,false);
		else
			return true;
	},
	textarea:function(o){
		if( o.attr("value") == "" || o.attr("value").length >500)
			return this.alert(o.attr("msg"),o,false);
		else
			return true;
	},
	vu:function(id,src){
		$(id).attr('src',src+Math.random());
		return false;
	},
	testing:function(obj,ids,func){
		var o = $(obj);
		var ret='0';
		FRM.ids=ids;
		FRM.func=func;
		if( o.attr("isw")=="1" || ( o.attr("isw")==2 && this.regex(o.attr("regex"),o.attr("value")) )){
			$.get(o.attr("url")+o.attr("value"),function(data){
				FRM.func(FRM.ids,data);
			});
		}else{
			func(ids,o.attr("msg"));
		}
		return ret;
	}
};

var REG = {
	init:function(formid,eid){
		$("#"+eid).focus();
	},
	focus:function(id){
		$(id).focus();
	},
	msg:function(id,msg){
		if(!msg)
			$(id).hide();
		else
			$(id).html(msg).show();
	},
	trim:function(str){
		return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
	},
	xy:function(id,val){
		$(id).removeClass("no");
		$(id).removeClass("ok");
		if( val=="0" || val == "" ){
			$(id).addClass("ok");
		}else{
			$(id).addClass("no");
		}
	},
	check:function(frms){
		var kbds = frms.getElementsByTagName('kbd');
		var ret=true;
		for(i=0;i<kbds.length;i++){
			if(kbds[i].className != 'ok'){
				REG.focus($("#"+$(kbds[i]).attr("fdt")));
				ret=false;
				break;
			}
		}

		return ret;
	},
	checkusername:function(obj,objid,xyid){
		REG.msg(objid);
		var username = REG.trim($(obj).val());
		var unlen = username.replace(/[^\x00-\xff]/g, "**").length;
		if(unlen < 3 || unlen > 15) {
			REG.msg(objid, unlen < 3 ? '用户名不得小于 3 个字符' : '用户名不得超过 15 个字符');
			REG.xy(xyid,1);
			return;
		}
		
		if(!username.match(/^(\w|[\u4E00-\u9FA5]|[_]){3,15}$/)) {
			REG.msg(objid, '用户名不符合规范');
			REG.xy(xyid,1);
			return;
		}
		
		REG.userid=objid;
		REG.userxyid = xyid;
		REG.username = obj;
		$.get($(obj).attr("url")+username,function(data){
			if(data=='0'){
				REG.msg(REG.userid);
				REG.xy(REG.userxyid,0);
			}else{
				REG.msg(REG.userid,data);
				REG.xy(REG.userxyid,1);
				return ;
			}
		});

	},
	passwdck:function(obj,objid,xyid){
		REG.msg(objid);
		var passwd = REG.trim($(obj).val());
		var len = passwd.length;
		if( len < 1 || len > 16 ){
			REG.msg(objid,len<2?'密码长度太小':'密码不能超过16个字符');
			REG.xy(xyid,1);
			return ;
		}
		REG.xy(xyid,0);
		return 0;
	},
	passcpck:function(obj,objid,xyid,ooid){
		REG.msg(objid);
		var passcp = REG.trim($(obj).val());
		var passwd = REG.trim($(ooid).val());
		if(passcp != passwd){
			REG.msg(objid,'二次输入的密码不一致');
			REG.xy(xyid,1);
			return ;
		}
		REG.xy(xyid,0);
		return 0;
	},
	emailck:function(obj,objid,xyid){
		REG.emailid = objid;
		REG.emailxyid = xyid;
		REG.msg(objid);
		var code = REG.trim($(obj).val());
		$.get($(obj).attr("url")+code,function(data){
			if(data=='0'){
				REG.msg(REG.emailid);
				REG.xy(REG.emailxyid,0);
			}else{
				REG.msg(REG.emailid,data);
				REG.xy(REG.emailxyid,1);
				return ;
			}
		});
		return 0;
	},
	verify:function(obj,objid,xyid){
		REG.callid = objid;
		REG.callback=obj;
		REG.callxyid = xyid;
		REG.msg(objid);
		var code = REG.trim($(obj).val());
		$.get($(obj).attr("url")+code,function(data){
			if(data=='0'){
				REG.msg(REG.callid);
				REG.xy(REG.callxyid,0);
			}else{
				REG.msg(REG.callid,data);
				REG.xy(REG.callxyid,1);
				return ;
			}
		});
		return 0;
	}
};

var LP = {
	passwd:function(obj){
		var s = REG.trim($(obj).val());
		var len = s.length;
		if( len < 1 || len > 16 ){
			alert(len<2?'密码长度太小':'密码不能超过16个字符');
			return ;
		}
	},
	passcp:function(obj,pid){
		var s = REG.trim(obj.value);
		var len = s.length;
		if( len < 1 || len > 16 ){
			alert(len<2?'密码长度太小':'密码不能超过16个字符');
			return ;
		}
		if(s != REG.trim($(pid).val())){
			alert('二次输入的密码不一致');
			return ;
		}
	},
	check:function(frm){

	}
};