<?php
class app extends GlobalClass{
	
	public function index(){
		$appstore=AppStore::init($this->C);
		$title="";
		$page_size=18;  
		if($this->A->get('classid')==''){
			$key='class0page1orderN';//默认显示第一个分类的数据
			$data=$appstore->getAppClasses($key,1,$page_size,TRUE);
			
			T::A('appClasses',$data->appClasses->appClass);
		 	T::A('apps',$data->appClasses->appClass[0]->app);
		 	$order='N'; 
		 	$classid=$data->appClasses->appClass[0]->classid;
		 	$title= $data->appClasses->appClass[0]->title.' - TV应用 - ';
			//总条目数  
		  	$nums=$data->appClasses->appClass[0]->appcount;  
		}else{
			
			$pageCurrent=$this->A->get('page')=='' ? 1: $this->A->get('page');
			$order=$this->A->get('order')=='' ? 'N': $this->A->get('order'); 
			$classid=$this->A->get('classid');
			$sub_pages=9;
			$key="class{$classid}page{$pageCurrent}order{$order}";
			
			$appClasses=$appstore->getAppClasses('tvdev_appClasses',1,$page_size,FALSE);
			
			T::A('appClasses',$appClasses->appClasses->appClass);
			foreach($appClasses->appClasses->appClass as $row){
				if($row->classid==$classid){
					$title=$row->title.' - TV应用 - ';
					break;
				}
			}
			
			$apps=$appstore->getAppClass($key,$classid,$pageCurrent,$page_size,$order);
			T::A('apps',$apps->appClass->app);
			$nums=$apps->appClass->appcount;
		}
		
		//每次显示的页数  
		  $sub_pages=9;  
		//得到当前是第几页  
		  $pageCurrent=$this->A->get('page')=='' ? 1: $this->A->get('page'); 
		  $subPages=new SubPages($page_size,$nums,$pageCurrent,$sub_pages,$this->C->PROJECT['siteurl']."/app-{$classid}-{$order}-",2,TRUE);
		  T::A('subPages',$subPages->pageStr);

		  $rs=$appstore->getSmartTV('tvdev_smarttvlist',1,4);
		  $smarttvlist=$rs ? $rs->appClasses->appClass : '';
		 T::A('smarttvlist',$smarttvlist);
		if($title ==''){
			foreach($smarttvlist as $row){
					if($row->classid==$classid){
						$title=$row->title.' - TV应用 - ';
						break;
					}
			}
		}
		T::A('page',$pageCurrent);
		T::A('order',$order);
		T::A('classid',$classid);
		T::A('title',$title ? $title : 'TV应用 - ');
	}
	
	public function detail(){
		$appid=$this->A->get('appid');
		$appstore=AppStore::init($this->C);
		$app=$appstore->getAppDetail('tvdev_'.$appid,$appid);
		T::A('app',$app->app);
		$apppics=$app->app->apppic;
		$pics=explode(";",$apppics);
		$title=$app->app->title." -TV应用 - ";
		T::A("pics",$pics);
		T::A('recommand',$app->recommand->app);
		T::A('title',$title);
	}
	
	public function searchApp(){
		$appstore=AppStore::init($this->C);
		$page_size=20;
		$pageCurrent=$this->A->get('page')=='' ? 1: $this->A->get('page'); 
		$keyword=$this->A->post('keyword')==''?$this->A->get('keyword'):$this->A->post('keyword');
		if($keyword=='')
			GF::MSG("请输入搜索关键字",'?mod=app');
		$rs=$appstore->searchAppInfos('tvdev_'.$keyword,$keyword,1,$page_size);
		$appcount=$rs->appClass->appcount;
		T::A('appcount',$appcount);
		if($appcount==0){
			$latestapp=$appstore->getAllAppInfos('tvdev_latestapp',1,8);
			T::A('latestapp',$latestapp->appClass->app);
		}
		$apps=$rs->appClass->app;
		T::A('apps',$apps);
		T::A('keyword',$keyword);
		
		//每次显示的页数  
	   $sub_pages=9;  
	   $subPages=new SubPages($page_size,$appcount,$pageCurrent,$sub_pages,"?mod=app&act=searchApp&keyword=".urlencode($keyword)."&page=",2);
	   T::A('subPages',$subPages->pageStr);
	}
	
	public function saveFavorite(){
		$appid=$this->A->get('appkey');
		$huanid=$this->U->huanid;
		$appstore=AppStore::init($this->C);
		$rs=$appstore->saveFavoriteApp($huanid,$appid);
		$msg=array('msg'=>'failture');
		if($rs)
			$msg['msg']='success';
		echo json_encode($msg);exit;
	}
	
}