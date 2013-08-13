<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
cpheader();

if($operation == 'consulting') {
	showsubmenu('menu_mynav_consultingextend', array(
		array('add', 'mynav&operation=add&type=1', 1),
	));
	$list=C::t('forum_threadextend')->getlist(1);

	showtable($list);

}else if($operation == 'essence') {
	showsubmenu('menu_mynav_essenceextend', array(
		array('add', 'mynav&operation=add&type=2', 1),
	));
	$list=C::t('forum_threadextend')->getlist(2);

	showtable($list);
}else if($operation == 'add'){
	if($_GET['type']==1){
		showsubmenu('menu_mynav_consultingextend', array(
		array('menu_mynav_consulting', 'mynav&operation=consulting', 1),
		));
		showformheader('mynav&operation=addextend','enctype="multipart/form-data"');
		showtableheader();
		showhiddenfields(array('type'=>1));
			
	}else if($_GET['type']==2){
		showsubmenu('menu_mynav_essenceextend', array(
		array('menu_mynav_essence', 'mynav&operation=essence', 1),
		));
		showformheader('mynav&operation=addextend','enctype="multipart/form-data"');
		showtableheader();
		showhiddenfields(array('type'=>2));	
	}
	
	showsetting('mynav_id', 'tid', '', 'text');
	
	showsetting('mynav_subject', 'subject', '', 'text');
	
	showsetting('mynav_description', 'description', '', 'textarea');
	
	showsetting('mynav_pic', 'pic', '', 'file');

	showsubmit('submit','ok');
	showtablefooter();
	showformfooter();
}else if($operation == 'addextend'){
			if($_FILES['pic']) {
				$upload = new discuz_upload();
				if($upload->init($_FILES['pic'], 'common') && $upload->save()) {
					$pic = 'data/attachment/common/'.$upload->attach['attachment'];
					$data=array(
			      	'tid'=>$_POST['tid'],
			      	'type'=>$_POST['type'],
			      	'subject'=>$_POST['subject'],
			        'description'=>$_POST['description'],
			        'pic'=>$pic,
			      	'creationUTC'=>time(),
			      );
			      
			      if($_POST['type']==1)
			      	$op='consulting';
			      else
			      	$op='essence';
			      		
			      foreach ($data as $v){
			      	if(empty($v))
			      		cpmsg('mynav_valid_error', 'action=mynav&operation='.$op, 'error');
			      }
			      C::t('forum_threadextend')->insert($data);
			      cpmsg('mynav_add_success', 'action=mynav&operation='.$op, 'succeed');
				}
			}else{
				cpmsg('mynav_error', 'action=mynav&operation=add', 'error');
			}
}else if($operation=='delete'){
	if(!isset($_GET['id']))
		cpmsg('mynav_del_error', '', 'error');
	C::t('forum_threadextend')->delete($_GET['id']);
	cpmsg('mynav_del_success', '', 'succeed');
		
}else if($operation=='edit'){
	$row=C::t('forum_threadextend')->fetch($_GET['id']);
	if(empty($row))
		cpmsg('mynav_edit_error', '', 'error');
	if(isset($_POST['submit'])){
		if($_FILES['pic']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['pic'], 'common') && $upload->save()) {
				$pic = 'data/attachment/common/'.$upload->attach['attachment'];
				$data=array(
					      	'tid'=>$_POST['tid'],
					      	'type'=>$row['type'],
					      	'subject'=>$_POST['subject'],
					        'description'=>$_POST['description'],
					        'pic'=>$pic,
					      	'creationUTC'=>time(),
					      );
					      
			      if($row['type']==1)
			      $op='consulting';
			      else
			      $op='essence';
			      foreach ($data as $v){
			      if(empty($v))
			      	cpmsg('mynav_valid_error', 'action=mynav&operation='.$op, 'error');
			      }
			      C::t('forum_threadextend')->update($_GET['id'],$data);
			      cpmsg('mynav_edit_success', 'action=mynav&operation='.$op, 'succeed');
			}else{
				cpmsg('mynav_error', 'action=mynav&operation=add', 'error');		
			}
		}
	}else{
		showformheader('mynav&operation=edit&id='.$_GET['id'],'enctype="multipart/form-data"');
		showtableheader();
		showsetting('mynav_id', 'tid', $row['tid'], 'text');
		
		showsetting('mynav_subject', 'subject', $row['subject'], 'text');
		
		showsetting('mynav_description', 'description', $row['description'], 'textarea');
		
		showsetting('mynav_pic', 'pic', '', 'file');
		echo "<img width=\"200px\" height=\"100px\" src=\"{$row['pic']}\" />";
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}
}else if($operation=='ads'){
	showsubmenu('menu_mynav_ads', array(
		array('menu_mynav_type1', 'mynav&operation=ads', 1),
		array('menu_mynav_type2', 'mynav&operation=ads&type=2', 1),
		array('add', 'mynav&operation=addads', 1),
		
	));
	$type=isset($_GET['type'])?$_GET['type']:1;
	$list=C::t('portal_banner')->getlist($type);
	showformheader('mynav&operation=modifyorder&type='.$type);
	showtableheader();
	if(is_array($list) && count($list)>0){
		echo "<tbody><tr><th>排序</th><th>banner图</th><th>标题</th><th>链接</th><th>修改时间</th><th></th></tr></tbody>";
		foreach ($list as $row)
			showtablerow('','',array('<input type="text" class="txt" name="displayorder['.$row['id'].']" value="'.$row['displayorder'].'">','<img width="200px" height="100px" src="'.$row['pic'].'" ></img>',
			$row['title'],$row['linkurl'],date('Y-m-d H:i:s',$row['updateUTC']),
			'<a href="admin.php?action=mynav&operation=editads&id='.$row['id'].'">edit</a>&nbsp;|&nbsp;<a href="admin.php?action=mynav&operation=deleteads&id='.$row['id'].'">delete</a>'));
	}
	showsubmit('submit','ok');
	showtablefooter();	
	showformfooter();
	
}else if($operation=='modifyorder'){
	$order=$_POST['displayorder'];
	C::t('portal_banner')->displayorder($order);
	 cpmsg('mynav_edit_success', 'action=mynav&operation=ads&type='.$_GET['type'], 'succeed');
}else if($operation=='addads'){
	if(!isset($_POST['submit'])){
		showsubmenu('menu_mynav_ads', array(
			array('menu_mynav_type1', 'mynav&operation=ads', 1),
			array('menu_mynav_type2', 'mynav&operation=ads&type=2', 1),
		));
		showformheader('mynav&operation=addads','enctype="multipart/form-data"');
		showtableheader();
			
		showsetting('mynav_pic', 'pic', '', 'file');
		
		showsetting('mynav_link', 'linkurl', '', 'text');
	
		showsetting('mynav_title', 'title', '', 'text');
		
		echo '<select name="type"><option value="1">'.$lang['mynav_type1'].'</option><option value="2">'.$lang['mynav_type2'].'</option></select>';
		
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}else{
		if($_FILES['pic']) {
				$upload = new discuz_upload();
				if($upload->init($_FILES['pic'], 'common') && $upload->save()) {
					$pic ='data/attachment/common/'. $upload->attach['attachment'];
					$data=array(
			      	'title'=>$_POST['title'],
			      	'type'=>$_POST['type'],
			      	'linkurl'=>$_POST['linkurl'],
			        'pic'=>$pic,
			      	'updateUTC'=>time(),
			      );
			      
			      C::t('portal_banner')->insert($data);
			      cpmsg('mynav_add_success', 'action=mynav&operation=ads&type='.$_POST['type'], 'succeed');		
				}
		} else {
			cpmsg('mynav_error', 'action=mynav&operation=add', 'error');
		}
	}
}else if($operation=='editads'){
	$row=C::t('portal_banner')->fetch($_GET['id']);
	if(empty($row))
		cpmsg('mynav_edit_error', '', 'error');
	if(isset($_POST['submit'])){
		if($_FILES['pic']) {
					$upload = new discuz_upload();
					if($upload->init($_FILES['pic'], 'common') && $upload->save()) {
						$pic ='data/attachment/common/'. $upload->attach['attachment'];
						$data=array(
				      	'linkurl'=>$_POST['linkurl'],
				      	'type'=>$_POST['type'],
				      	'title'=>$_POST['title'],
				        'pic'=>$pic,
				      	'updateUTC'=>time(),
				      );
				      C::t('portal_banner')->update($_GET['id'],$data);
				      cpmsg('mynav_edit_success', 'action=mynav&operation=ads&type='.$_POST['type'], 'succeed');	
					}
			} else {
				cpmsg('mynav_error', 'action=mynav&operation=add', 'error');
			}
	}else{
		showformheader('mynav&operation=editads&id='.$_GET['id'],'enctype="multipart/form-data"');
		showtableheader();
		
		showsetting('mynav_pic', 'pic', '', 'file');
		
		showsetting('mynav_link', 'linkurl', $row['linkurl'], 'text');
	
		showsetting('mynav_title', 'title', $row['title'], 'text');
		
		echo '<select name="type"><option value="1"'.($row['type']==1?' selected ':'').'>'.$lang['mynav_type1'].'</option><option value="2"'.($row['type']==2?' selected ':'').'>'.$lang['mynav_type2'].'</option></select>';
		echo "<img width=\"200px\" height=\"100px\" src=\"{$row['pic']}\" />";
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}
}else if($operation=='deleteads'){
	if(!isset($_GET['id']))
		cpmsg('mynav_del_error', '', 'error');
	C::t('portal_banner')->delete($_GET['id']);
	cpmsg('mynav_del_success', '', 'succeed');
		
}else if($operation=='help'){
	showsubmenu('menu_mynav_help', array(
		array('add', 'mynav&operation=addhelp', 1),
	));
	$cates=C::t('common_helpcate')->getlist();
	$helpcate=array();
	foreach($cates as $cate){
		$helpcate[$cate['id']]=$cate['category'];
	}
	$helps=C::t('common_help')->getlist();
	showtableheader();
	
	echo "<tbody><tr><th>分类名称</th><th>标题</th><th>内容</th><th></th></tr></tbody>";
		foreach ($helps as $row)
			showtablerow('','',array(empty($row['categoryID'])?'':$helpcate[$row['categoryID']],$row['title'],
			mb_substr(strip_tags($row['description']),0,40,'UTF-8'),
			'<a href="admin.php?action=mynav&operation=edithelp&id='.$row['id'].'">edit</a>&nbsp;|&nbsp;
			<a href="admin.php?action=mynav&operation=deletehelp&id='.$row['id'].'">delete</a>'));
	showtablefooter();
	
}else if($operation=='addhelp'){
	if(isset($_POST['submit'])){
		if(empty($_POST['title']) && empty($_POST['category']) || empty($_POST['description']))
			cpmsg('mynav_valid_help', 'action=mynav&operation=addhelp', 'error');
		if(empty($_POST['title']) && !empty($_POST['category'])){
			$count=C::t('common_helpcate')->gethelps($_POST['category']);
			if($count >0)
				cpmsg('mynav_addhelp_error', 'action=mynav&operation=addhelp', 'error');
		}
		if(!empty($_POST['title']) && !empty($_POST['category'])){
			$count=C::t('common_help')->gethelps($_POST['category']);
			if($count >0)
				cpmsg('mynav_addhelp_error1', 'action=mynav&operation=addhelp', 'error');
		}		
		$data=array(
		      	'title'=>$_POST['title'],
		      	'categoryID'=>$_POST['category'],
		      	'description'=>$_POST['description'],
		      	'sort'=>$_POST['sort'],
		      );
		      C::t('common_help')->insert($data);
		      cpmsg('mynav_add_success', 'action=mynav&operation=help', 'succeed');
	}else{
		$cates=C::t('common_helpcate')->getlist();
		$catestr='<option value="">请选择分类</option>';
		foreach($cates as $cate){
			$catestr.='<option value="'.$cate['id'].'">'.$cate['category'].'</option>';
		}
		$str=<<<EOT
	<script type="text/javascript" src="static/js/ckeditor/ckeditor.js" ></script>
	<form action="admin.php?action=mynav&operation=addhelp" method="post">
		<p>
			<label for="category">分类：</label>
			<select name="category">$catestr</select>
		</p>
		<p>
			<label for="title">标题：</label>
			<input type="text" name="title"></input>
		</p>
		<p>
			<label for="description">内容:</label>
			<textarea cols="80" id="editor1" name="description" rows="10"></textarea>
		</p>
		<p>
			<label for="sort">排序：</label>
			<input type="text" name="sort" value="0"></input>
		</p>
		<p>
			<input type="submit" value="Submit" name="submit">
		</p>
	</form>
	<script>
		CKEDITOR.replace( 'editor1');
	</script>
EOT;
	echo $str;
	}
}else if($operation=='helpcate'){
	showsubmenu('menu_mynav_helpcate', array(
		array('add', 'mynav&operation=addhelpcate', 1),
	));
	$cates=C::t('common_helpcate')->getlist();
	showtableheader();
	echo "<tbody><tr><th>分类名称</th><th>排序</th><th></th></tr></tbody>";
		foreach ($cates as $row)
			showtablerow('','',array($row['category'],$row['sort'],
			'<a href="admin.php?action=mynav&operation=editcate&id='.$row['id'].'">edit</a>&nbsp;|&nbsp;
			<a href="admin.php?action=mynav&operation=deletecate&id='.$row['id'].'">delete</a>'));
	showtablefooter();
	
}else if($operation=='addhelpcate'){
		if(isset($_POST['submit'])){
			if(empty($_POST['category']))
				cpmsg('mynav_valid_error', 'action=mynav&operation=addhelpcate', 'error');
			$count=C::t('common_helpcate')->gethelpcate($_POST['category']);
			if($count >0)
				cpmsg('mynav_delhelp_error1', 'action=mynav&operation=helpcate', 'error');	
			C::t('common_helpcate')->insert(array('category'=>$_POST['category'],'sort'=>$_POST['sort']));
		    cpmsg('mynav_add_success', 'action=mynav&operation=helpcate', 'succeed');	
		}else{
			showformheader('mynav&operation=addhelpcate');
			showtableheader();
			showsetting('mynav_category', 'category', '', 'text');
			showsetting('mynav_sort', 'sort', '', 'text');
			showsubmit('submit','ok');
			showtablefooter();
			showformfooter();
		}
}else if($operation=='editcate'){
	$row=C::t('common_helpcate')->fetch($_GET['id']);
	if(empty($row))
		cpmsg('mynav_edit_error', '', 'error');
	if(isset($_POST['submit'])){
		if(empty($_POST['category']))
				cpmsg('mynav_valid_error', 'action=mynav&operation=addhelpcate', 'error');
		$count=C::t('common_helpcate')->gethelpcate($_POST['category']);
		if($count >0)
				cpmsg('mynav_delhelp_error1', 'action=mynav&operation=editcate&id='.$_GET['id'], 'error');			
		C::t('common_helpcate')->update($_GET['id'],array('category'=>$_POST['category'],'sort'=>$_POST['sort']));
		cpmsg('mynav_edit_success', 'action=mynav&operation=helpcate', 'succeed');
	}else{
		showformheader('mynav&operation=editcate&id='.$_GET['id']);
		showtableheader();
		showsetting('mynav_category', 'category', $row['category'], 'text');
		showsetting('mynav_sort', 'sort', $row['sort'], 'text');
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}	
}else if($operation=='deletecate'){
	if(!isset($_GET['id']))
		cpmsg('mynav_del_error', '', 'error');
	$count=C::t('common_helpcate')->gethelps($_GET['id']);
	if($count >0)
		cpmsg('mynav_delhelp_error', 'action=mynav&operation=helpcate', 'error');
	C::t('common_helpcate')->delete($_GET['id']);
	cpmsg('mynav_del_success', 'action=mynav&operation=helpcate', 'succeed');
}else if($operation=='edithelp'){
	$row=C::t('common_help')->fetch($_GET['id']);
	if(empty($row))
		cpmsg('mynav_edit_error', '', 'error');
	if(isset($_POST['submit'])){
		if(empty($_POST['title']) && empty($_POST['category']) || empty($_POST['description']))
			cpmsg('mynav_valid_help', 'action=mynav&operation=addhelp', 'error');
		$data=array(
		      	'title'=>$_POST['title'],
		      	'categoryID'=>$_POST['category'],
		      	'description'=>$_POST['description'],
		      	'sort'=>$_POST['sort'],
		      );
		      C::t('common_help')->update($_GET['id'],$data);
		      cpmsg('mynav_edit_success', 'action=mynav&operation=help', 'succeed');
	}else{
		$cates=C::t('common_helpcate')->getlist();
		$catestr='<option value="">请选择分类</option>';
		foreach($cates as $cate){
			if($row['categoryID']==$cate['id'])
				$catestr.='<option value="'.$cate['id'].'" selected="selected">'.$cate['category'].'</option>';
			else
				$catestr.='<option value="'.$cate['id'].'">'.$cate['category'].'</option>';	
		}
		
		$str=<<<EOT
	<script type="text/javascript" src="static/js/ckeditor/ckeditor.js" ></script>
	<form action="admin.php?action=mynav&operation=edithelp&id={$_GET['id']}" method="post">
		<p>
			<label for="category">分类：</label>
			<select name="category">$catestr</select>
		</p>
		<p>
			<label for="title">标题：</label>
			<input type="text" name="title" value="{$row['title']}"></input>
		</p>
		<p>
			<label for="description">内容:</label>
			<textarea cols="80" id="editor1" name="description" rows="10">{$row['description']}</textarea>
		</p>
		<p>
			<label for="sort">排序：</label>
			<input type="text" name="sort" value="{$row['sort']}"></input>
		</p>
		<p>
			<input type="submit" value="Submit" name="submit">
		</p>
	</form>
	<script>
		CKEDITOR.replace('editor1');
	</script>
EOT;
	echo $str;
	}	
}else if($operation=='deletehelp'){
	if(!isset($_GET['id']))
		cpmsg('mynav_del_error', '', 'error');
	C::t('common_help')->delete($_GET['id']);
	cpmsg('mynav_del_success', 'action=mynav&operation=help', 'succeed');
}else if($operation=='hottags'){
	$page=isset($_GET['page']) ? intval($_GET['page']) : 1;
	$order=isset($_GET['order']) ? $_GET['order'] : 'searchnum';
	$sort=isset($_GET['sort']) ? $_GET['sort'] : 'desc';
	showsubmenu('menu_mynav_hottags', array(
		array('add', 'mynav&operation=addtag&page='.$page.'&order='.$order.'&sort='.$sort, 1),
	));
	$data=C::t('portal_hottag')->getlist($page,$order,$sort);
	$tags=$data['rows'];
	showtableheader();
	echo '<tbody><tr><th>标签&nbsp;&nbsp; <a href="admin.php?action=mynav&operation=hottags&page='.$page.'&order=name&sort=asc"><img src="static/image/common/tip_top.png" /></a>&nbsp;&nbsp;<a href="admin.php?action=mynav&operation=hottags&page='.$page.'&order=name&sort=desc"><img src="static/image/common/tip_bottom.png" /></a></th>
	<th>搜索次数&nbsp;&nbsp; <a href="admin.php?action=mynav&operation=hottags&page='.$page.'&order=searchnum&sort=asc"><img src="static/image/common/tip_top.png" /></a>&nbsp;&nbsp;<a href="admin.php?action=mynav&operation=hottags&page='.$page.'&order=searchnum&sort=desc"><img src="static/image/common/tip_bottom.png" /></a></th>
	<th>修改时间</th><th>显示</th><th></th></tr></tbody>';
		foreach ($tags as $row)
			showtablerow($row['isactived']==1 ? 'style="background: #B3D3A7;"' : '','',array($row['name'],$row['searchnum'],date('Y-m-d H:i:s',$row['creationUTC']),$row['isactived']==1 ? '是' : '否',
			($row['isactived']==1 ? '<a href="admin.php?action=mynav&operation=changestatus&id='.$row['id'].'&page='.$page.'&isActived=0&order='.$order.'&sort='.$sort.'">关闭</a>' : '<a href="admin.php?action=mynav&operation=changestatus&id='.$row['id'].'&page='.$page.'&isActived=1&order='.$order.'&sort='.$sort.'">开启</a>').'&nbsp;|&nbsp;<a href="admin.php?action=mynav&operation=edittag&id='.$row['id'].'&page='.$page.'&order='.$order.'&sort='.$sort.'">修改</a>&nbsp;|&nbsp;<a href="admin.php?action=mynav&operation=deletetag&id='.$row['id'].'&page='.$page.'&order='.$order.'&sort='.$sort.'"><span style="color:red;">删除</span></a>' ));
	showtablefooter();
	$prepage=$page<2 ? 1 : $page-1;
	echo ($data['currentPage']>1 ? '<a href="admin.php?action=mynav&operation=hottags&page=1&order='.$order.'&sort='.$sort.'">首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php?action=mynav&operation=hottags&page='.$prepage.'&order='.$order.'&sort='.$sort.'">上页</a>&nbsp;&nbsp;&nbsp;&nbsp;' : '').'<a href="admin.php?action=mynav&operation=hottags&page='.($page+1).'&order='.$order.'&sort='.$sort.'">下页</a>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red;">当前第 '.$data['currentPage'].'/'.$data['totalPages'].' 页，每页 '.$data['pageNum'].' 条，共 '.$data['count'].' 条记录</span>';
}else if($operation=='changestatus'){
	$row=C::t('portal_hottag')->fetch($_GET['id']);
	if(empty($row))
		cpmsg('mynav_edit_error', '', 'error');
	$page=$_GET['page'];
	$sort=$_GET['sort'];
	$order=$_GET['order'];
	C::t('portal_hottag')->update($_GET['id'],array('isActived'=>$_GET['isActived']));
	cpmsg('mynav_edit_success', 'action=mynav&operation=hottags&page='.$page.'&order='.$order.'&sort='.$sort, 'succeed');
		
}else if($operation=='addtag'){
	$page=$_GET['page'];
	$sort=$_GET['sort'];
	$order=$_GET['order'];
	showsubmenu('menu_mynav_hottags', array(
		array('menu_mynav_hottags', 'mynav&operation=hottags&page='.$page.'&order='.$order.'&sort='.$sort, 1),
	));
	if(isset($_POST['submit'])) {
		$name=trim($_POST['name']);
		if(empty($name))
				cpmsg('mynav_tag_empty', 'action=mynav&operation=addtag&page='.$page.'&order='.$order.'&sort='.$sort, 'error');
		$count=C::t('portal_hottag')->hastag($name);
		if($count >0)
			cpmsg('mynav_tag_exists', 'action=mynav&operation=addtag&page='.$page.'&order='.$order.'&sort='.$sort, 'error');
		C::t('portal_hottag')->insert(array('name'=>$name,'searchnum'=>$_POST['searchnum'],'isactived'=>$_POST['isactived'],'creationUTC'=>time()));
	    cpmsg('mynav_add_success', 'action=mynav&operation=hottags&page='.$page.'&order='.$order.'&sort='.$sort, 'succeed');	
	} else {
		showformheader('mynav&operation=addtag&page='.$page.'&order='.$order.'&sort='.$sort);
		showtableheader();
		showsetting('mynav_tag', 'name', '', 'text');
		showsetting('mynav_searchnum', 'searchnum', '1', 'text');
		showsetting('mynav_isactived', 'isactived', 0, 'radio');
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}
} else if($operation=='edittag') {
	$page=$_GET['page'];
	$sort=$_GET['sort'];
	$order=$_GET['order'];
	showsubmenu('menu_mynav_hottags', array(
		array('menu_mynav_hottags', 'mynav&operation=hottags&page='.$page.'&order='.$order.'&sort='.$sort, 1),
	));
	$row=C::t('portal_hottag')->fetch($_GET['id']);
	if(empty($row))
		cpmsg('mynav_edit_error', '', 'error');
	if(isset($_POST['submit'])){
		$name=trim($_POST['name']);
		if(empty($name))
				cpmsg('mynav_tag_empty', 'action=mynav&operation=edittag&id='.$_GET['id'].'&page='.$page.'&order='.$order.'&sort='.$sort, 'error');
		$count=C::t('portal_hottag')->hastag($name);
		if($count >1)
			cpmsg('mynav_tag_exists', 'action=mynav&operation=edittag&id='.$_GET['id'].'&order='.$order.'&sort='.$sort, 'error');
		$data=array(
		      	'name'=>$name,
		      	'searchnum'=>$_POST['searchnum'],
		      	'sort'=>$_POST['sort'],
				'isactived'=>intval($_POST['isactived']),
				'creationUTC'=>time(),
		      );
	      C::t('portal_hottag')->update($_GET['id'],$data);
	      cpmsg('mynav_edit_success', 'action=mynav&operation=hottags&page='.$page.'&order='.$order.'&sort='.$sort, 'succeed');
	}else{
		
		showformheader('mynav&operation=edittag&id='.$_GET['id'].'&page='.$page.'&order='.$order.'&sort='.$sort);
		showtableheader();
		showsetting('mynav_tag', 'name', $row['name'], 'text');
		showsetting('mynav_searchnum', 'searchnum', $row['searchnum'], 'text');
		showsetting('mynav_isactived', 'isactived', $row['isactived'], 'radio');
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}	
}else if($operation=='deletetag'){
	if(!isset($_GET['id']))
		cpmsg('mynav_del_error', '', 'error');
	C::t('portal_hottag')->delete($_GET['id']);
	cpmsg('mynav_del_success', 'action=mynav&operation=hottags&page='.$_GET['page'].'&order='.$_GET['order'].'&sort='.$_GET['sort'], 'succeed');
}else if($operation=='flush'){
	if(isset($_POST['submit'])){
		$configfile=dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/config/config.ini";
		$config=parse_ini_file($configfile,true);
		$memcache_obj = new Memcache;
		$memcache_obj->connect($config['MEMCACHE']['host'], $config['MEMCACHE']['port']);
		$key=$_POST['key'];
		if($key=='all'){
			$memcache_obj->flush();
		}else{
			$memcache_obj->delete($key);
		}
		cpmsg('menu_flush_success', 'action=mynav&operation=flush', 'succeed');
	}else {
		echo "<h1>更新memcache缓存</h1>";
		showformheader('mynav&operation=flush');
		showtableheader();
		showsetting('mynav_tag', array('key', array(
	array('tvdev_index_banner', '首页banner'),
	array('tvdev_developer_banner', '开发者banner'),
	array('tvdev_zixun', '首页资讯'),
	array('tvdev_jinghua', '首页精华'),
	array('tvdev_index_friendlink', '首页友情链接'),
	array('tvdev_help_1', '底部关于我们、网页title'),
	array('tvdev_smarttvlist', '热门专题'),
	array('tvdev_TV_GAME_RANK', '热门游戏榜'),
	array('tvdev_TV_SOFTWARE_RANK', '热门应用榜'),
	array('tvdev_TV_GAME_SOFTWARE_RECOMMAND', 'TV精品应用推荐'),
	array('tvdev_ppzq', '沙龙活动-品牌专区'),
	array('tvdev_help_all', '帮助中心'),
	array('tvdev_all_friendlinks', '全部友情链接'),
	array('all', '全部'))), 'tvdev_index_banner', 'mradio');
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}	
} elseif ($operation=='email') {
	$dev_mm_tt=getdevdb();
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config/member.ucenter.inc.php';
	
	$now=time()-86400;
	$sql="SELECT email.devid,email.email,email.sdtime,email.edtime,mem.username 
FROM `{$dev_mm_tt}`.emailcheck as email 
left join ".UC_DBTABLEPRE."members as mem
on email.devid=mem.uid WHERE email.edtime > $now and email.counts >=3";
	$tags=DB::fetch_all($sql);
	if($tags){
		showtableheader();
		echo "<tbody><tr><th>用户名</th><th>邮箱</th><th>激活码发送时间</th><th></th></tr></tbody>";
			foreach ($tags as $row)
				showtablerow('','',array($row['username'],$row['email'],date('Y-m-d H:i:s',$row['edtime']),
				'<a href="admin.php?action=mynav&operation=delemail&devid='.$row['devid'].'"><span style="color:red;">删除</span></a>' ));
		showtablefooter();
	} else {
		echo "<h1>今日无待激活账号</h1>";
	}
	
} elseif ($operation=='delemail') {
	$devid=$_GET['devid'];
	if(!$devid) {
		cpmsg('mynav_del_error', 'action=mynav&operation=email', 'error');
	}
	$dev_mm_tt=getdevdb();
	$sql="delete from `{$dev_mm_tt}`.emailcheck where devid=$devid";
	DB::query($sql);
	cpmsg('mynav_del_success', 'action=mynav&operation=email', 'succeed');
} elseif ($operation=='gateway') {
	
	$dev_mm_tt=getdevdb();
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config/member.ucenter.inc.php';
	
	showformheader('mynav&operation=gateway');
	showtableheader();
	showsetting('关键字(用户名或邮箱)', 'keyword', '', 'text');
	showsubmit('submit','ok');
	showtablefooter();
	showformfooter();
	if(isset($_POST['keyword'])){
		$keyword=$_POST['keyword'];
		if($keyword){
			$sql="select gw.id,mem.username,mem.email,mem.huanid from `{$dev_mm_tt}`.gateway as gw left join ".UC_DBTABLEPRE."members as mem on gw.dataid=mem.uid where mem.email like '%{$keyword}%' or username like '%{$keyword}%'";
			$data=DB::fetch_all($sql);
			if($data){
				showtableheader();
				echo "<tbody><tr><th>用户名</th><th>邮箱</th><th>huanID</th><th></th></tr></tbody>";
					foreach ($data as $row)
						showtablerow('','',array($row['username'],$row['email'],$row['huanid'],
						'<a href="admin.php?action=mynav&operation=updategw&id='.$row['id'].'"><span style="color:red;">重发</span></a>' ));
				showtablefooter();
			} else {
				echo "<h1 style='color:red;'>找不到签约发送失败用户</h1>";
			}
		}else{
			echo "<h1 style='color:red;'>请输入用户名或者邮箱</h1>";
		}
	}
	
} elseif ($operation=='updategw') {
	$id=$_GET['id'];
	if(!$id) {
		cpmsg('mynav_getway_senderror', 'action=mynav&operation=gateway', 'error');
	}
	$dev_mm_tt=getdevdb();
	$sql="update `{$dev_mm_tt}`.gateway set state=0 where id=$id";
	DB::query($sql);
	cpmsg('mynav_edit_success', 'action=mynav&operation=gateway', 'succeed');
}else if ($operation=='addadv') {
	if(isset($_POST['submit'])){
		if($_FILES['pic']) {
					$data=array();
					foreach($_FILES['pic']['name'] as $key=>$name){
						if(!$name)continue;
						$data[$key]['name']=$name;
						$data[$key]['type']=$_FILES['pic']['type'][$key];
						$data[$key]['tmp_name']=$_FILES['pic']['tmp_name'][$key];
						$data[$key]['error']=$_FILES['pic']['error'][$key];
						$data[$key]['size']=$_FILES['pic']['size'][$key];
					}
					
					$upload = new discuz_upload();
					foreach ($data as $file){
						if($upload->init($file, 'common') && $upload->save()) {
							$pic ='data/attachment/common/'. $upload->attach['attachment'];
					      	echo $pic."<br />";	
						}
					}
					
			} else {
				cpmsg('mynav_error', '', 'error');
			}
	}else{
		showformheader('mynav&operation=addadv','enctype="multipart/form-data"');
		showtableheader();
		showsetting('mynav_adv', 'pic[]', '', 'file');
		showsetting('mynav_adv', 'pic[]', '', 'file');
		showsetting('mynav_adv', 'pic[]', '', 'file');
		showsetting('mynav_adv', 'pic[]', '', 'file');
		showsetting('mynav_adv', 'pic[]', '', 'file');
		showsubmit('submit','ok');
		showtablefooter();
		showformfooter();
	}
}

function showtable($list){
	$str='';
	showtableheader();
	echo "<tbody><tr><th>展示图</th><th>主题</th><th>内容</th><th>修改时间</th><th></th></tr></tbody>";
	if(is_array($list) && count($list)>0){
		foreach ($list as $row)
			showtablerow('','',array('<img width="200px" height="100px" src="'.$row['pic'].'" ></img>',
			'<a href="forum.php?mod=viewthread&tid='.$row['tid'].'" target="_blank"> '.$row['subject'].'</a>',$row['description'],date('Y-m-d H:i:s',$row['creationUTC']),
			'<a href="admin.php?action=mynav&operation=edit&id='.$row['id'].'">edit</a>&nbsp;|&nbsp;<a href="admin.php?action=mynav&operation=delete&id='.$row['id'].'">delete</a>'));
	}
	showtablefooter();
}

function getdevdb(){
	$ini=dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/config/config.ini';
	$config=parse_ini_file($ini,true);
	return $config['DB']['name'];
}
