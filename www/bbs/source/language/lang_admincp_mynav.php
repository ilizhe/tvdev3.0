<?php
$extend_lang = array
(
	'menu_mynav_consulting' => '资讯扩展',
	'menu_mynav_essence' => '精华扩展',
	'menu_mynav_ads' => 'banner',
	'menu_mynav_banner' => 'banner位置',
	'menu_mynav_consultingextend' => '咨询帖子扩展管理',
	'menu_mynav_essenceextend' => '精华帖子扩展管理',
	'mynav_error'=>'只允许上传图片',
	'mynav_del_error'=>'删除失败',
	'mynav_del_success'=>'删除成功',
	'mynav_add_success'=>'添加成功',
	'mynav_valid_error'=>'表单不允许空值',
	'mynav_valid_help'=>'内容不能为空，且标题和分类不能都为空',
	'mynav_edit_error'=>'修改失败',
	'mynav_edit_success'=>'修改成功',
	'mynav_delhelp_error'=>'该分类下有数据，无法删除',
	'mynav_delhelp_error1'=>'该分类已经存在了',
	'mynav_addhelp_error'=>'该条记录已经存在，请不要重复添加',
	'mynav_addhelp_error1'=>'该分类下有标题为空的数据',
	'menu_mynav_type1'=>'首页banner',
	'menu_mynav_type2'=>'开发者banner',
	'menu_mynav_help'=>'帮助中心',
	'menu_mynav_helpcate'=>'帮助中心分类',
	'menu_mynav_hottags'=>'热门标签',
	'mynav_tag_empty'=>'标签不能为空',
	'mynav_tag_exists'=>'该类型标签已存在，返回',
	'menu_mynav_flush'=>'更新memcache缓存',
	'menu_flush_success'=>'更新memcache缓存成功！',
	'menu_mynav_email'=>'今日激活',
	'menu_mynav_getway'=>'签约资料重发',
	'mynav_getway_senderror'=>'更改状态失败'
);
$GLOBALS['admincp_actions_normal'][] = 'mynav';