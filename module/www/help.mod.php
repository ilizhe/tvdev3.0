<?php
class help extends GlobalClass{
	
	public function index(){
		$appstore=AppStore::init($this->C);
		$helps=$appstore->getHuanHelp('tvdev_help_all');
		T::A('helps',$helps->about);
		T::A('title','帮助中心 - ');
	}
	public function about(){
		$appstore=AppStore::init($this->C);
		$title='';
		if($this->A->get('id') !=''){
			$id=$this->A->get('id');
			$row=$appstore->getHuanHelp('tvdev_about_'.$id,1,$id);
			T::A('aboutrow',$row->about);
			$title=$row->about->title." - 关于我们 - ";
		}
		$type=$this->A->get('type')==''?'about':'links';
		if($type=='links'){
			$friendlinks=$appstore->getInfoList('tvdev_all_friendlinks',9);
			T::A('friendlinks',$friendlinks);
		}
		T::A('type',$type);
		T::A('title',$type=='links' ? '友情链接 - 关于我们 - ' : $title);
	}
}