<?php /* Smarty version Smarty-3.0.8, created on 2013-08-13 02:55:32
         compiled from "D:\htdocs\code3.0/template/member\fsupload.html" */ ?>
<?php /*%%SmartyHeaderCode:41565209a02499c297-32377409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c55ad983452291a9de6ce51e5d2a251828adad44' => 
    array (
      0 => 'D:\\htdocs\\code3.0/template/member\\fsupload.html',
      1 => 1376026295,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41565209a02499c297-32377409',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript">
	var swfu;
	window.onload = function() {
		var settings = {
			flash_url : "<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/js/swfupload.swf",
			upload_url: "<?php echo $_smarty_tpl->getVariable('remoteuploadurl')->value;?>
",	// Relative to the SWF file
			post_params: { "PHPSESSID" : "<?php echo $_smarty_tpl->getVariable('SESSIONID')->value;?>
",'type':'developer'},
			file_size_limit : "<?php echo $_smarty_tpl->getVariable('fsize')->value;?>
 MB",

			file_types : "<?php echo $_smarty_tpl->getVariable('filetype')->value;?>
",
			file_types_description : "<?php echo $_smarty_tpl->getVariable('filedesc')->value;?>
",
			file_upload_limit : "<?php echo $_smarty_tpl->getVariable('upnum')->value;?>
",
			file_queue_limit : 0,
			custom_settings : {
				file_type:'developer',
				file_input_name:'filename',
				file_thumb_id: 'pic',
				progressTarget : "fsUploadProgress"
			},
			debug: false,

			// Button settings
			button_image_url: "<?php echo $_smarty_tpl->getVariable('objdir')->value;?>
/image/swfupload.png",	// Relative to the Flash file
			button_width: "110",
			button_height: "29",
			button_placeholder_id: "spanButtonPlaceholder",
			button_text: '<span class="theFont">浏　览</span>',
			button_text_style: ".theFont { font-size: 16; } ",
			button_text_left_padding: 28,
			button_text_top_padding: 3,
			
			// The event handler functions are defined in handlers.js
			file_dialog_start_handler : fileDialogStart,
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete
		};
		swfu = new SWFUpload(settings);		
     };
	</script>