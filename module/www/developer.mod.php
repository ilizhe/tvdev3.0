<?php
class developer extends GlobalClass{

	public function index(){
		$appstore=AppStore::init($this->C);
		$banner=$appstore->getHuanAds('tvdev_developer_banner',2);
		T::A('banner',$banner);
		T::A('title','开发者 - ');
	}
	
}