$().ready(function() {
	$("#infoform").validate({
		rules: {
			mobile: {
				required: true,
				mobile: true
			},
			postal:"postal",
			telephone:"fixedTel",
			qq:"qq",
			website: {
				url:true,
				maxlength:200
			}
		},
		messages: {
			mobile: {
				required: "请输入电话号码",
				mobile: "电话号码格式不对"
			},
			postal:"邮编格式不对",
			telephone:"座机号码格式不对",
			qq:"qq号码格式不对",
			website: {
				url:"请输入正确的网址"
			}	
		}
	});
	
	$("#upgradeinfoform").validate({
		rules: {
		    realname: {
				required: true,
				maxlength:60
			},
			mobile: {
				required: true,
				mobile: true
			},
			certno: {
				required:true,
				IDCard:true
			},
			introduction:{
				required:true,
				maxlength:1000
			},
			filename:"required",
			verify:"required"
		},
		messages: {
			realname: {
				required: "请输入真实姓名"
			},
			mobile: {
				required: "请输入电话号码",
				mobile: "电话号码格式不对"
			},
			certno: {
				required:"请输入证件号码",
				IDCard:"证件号码格式不对"
			},
			introduction: {
				required: "请输入个人介绍"
			},
			filename:"请上传证件照片",
			verify:"您必须同意该协议"
		}
	});
	
	$("#companyinfo").validate({
		rules: {
			name: {
				required:true,
				maxlength:100
			},
			enname:{
				maxlength:100
			},
			contactperson: {
				required:true,
				maxlength:100
			},
			mobile: {
				required: true,
				mobile: true
			},
			postal:"postal",
			telephone:{
				required:true,
				fixedTel:true
			},
			qq:"qq",
			website: "url"
		},
		messages: {
			name: {
				required:"请输入公司名称"
			},
			mobile: {
				required: "请输入电话号码",
				mobile: "电话号码格式不对"
			},
			contactperson: {
				required: "请输入联系人姓名"
			},
			postal:"邮编格式不对",
			telephone:{
				required:"请输入座机号码",
				fixedTel:"座机号码格式不对"
			},
			qq:"qq号码格式不对",
			website:"请输入正确的网址"	
		}
	});
	
	$("#companyupgradeinfo").validate({
		rules: {
			license: {
				required: true
			},
		
			introduction: {
				required: true,
				maxlength: 5000
			},
			verify:"required"
		},
		messages: {
			license: {
				required: "请输入营业执照号"
			},
			introduction:{
				required:"请输入公司介绍"
			},
			verify:"您必须同意该协议"
		}
	});
});