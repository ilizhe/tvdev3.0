<?php
class salon extends GlobalClass{
	
	public function index(){
		$appstore=AppStore::init($this->C);
		$pagesize=3;
		$page=isset($_GET['page'])? intval($_GET['page']) :1;
		$key='tvdev_salon_'.$pagesize.'_'.$page;
		$salon=$appstore->getSalon($key,$page,$pagesize);
		T::A('salon',$salon);
		
	    $sub_pages=9;  
	    $subPages=new SubPages($pagesize,$salon->count,$page,$sub_pages,$this->C->PROJECT['siteurl']."/salon-",2,TRUE);
	    T::A('subPages',$subPages->pageStr);
	    //品牌专区
	 
		$ppzq = $appstore->getPpzq('tvdev_ppzq');
		T::A('ppzq',$ppzq);
		T::A('title','沙龙活动 - ');
	}

}