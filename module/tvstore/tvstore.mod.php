<?php
class tvstore extends GlobalClass{
	
	public function index(){
		//banner
		$appstore=AppStore::init($this->C);
		$zixun=$appstore->getHuanType('tvdev_zixun',1);
		$jinghua=$appstore->getHuanType('tvdev_jinghua',2);
		T::A('zixun',$zixun);
		T::A('jinghua',$jinghua);
		$banner=$appstore->getHuanAds('tvdev_index_banner',1);
		T::A('banner',$banner);
		
		//友情链接
		$friendlinks=$appstore->getFriendLink('tvdev_index_friendlink');
		T::A('friendlinks',$friendlinks);
		//smartTV
		$rs=$appstore->getSmartTV('tvdev_smarttvlist',1,4);
		$smarttvlist=$rs ? $rs->appClasses->appClass : '';

		T::A('smarttvlist',$smarttvlist);
		//热门游戏榜
		$rs=$appstore->getTVRecommandAndRank('tvdev_TV_GAME_RANK','TV_GAME_RANK',1,10,'H');
		$TV_GAME_RANK=$rs ? $rs->appClass->app : '';
		T::A('TV_GAME_RANK',$TV_GAME_RANK);
		//热门软件榜
		$rs=$appstore->getTVRecommandAndRank('tvdev_TV_SOFTWARE_RANK','TV_SOFTWARE_RANK',1,10,'H');
		$TV_SOFTWARE_RANK=$rs ? $rs->appClass->app : '';
		T::A('TV_SOFTWARE_RANK',$TV_SOFTWARE_RANK);
		
		//TV游戏推荐/品牌专区
		$rs=$appstore->getTVRecommandAndRank('tvdev_TV_GAME_SOFTWARE_RECOMMAND','TV_GAME_SOFTWARE_RECOMMAND',1,18,'H');
		$TV_GAME_SOFTWARE_RECOMMAND=$rs ? $rs->appClass->app : '';
		T::A('TV_GAME_SOFTWARE_RECOMMAND',$TV_GAME_SOFTWARE_RECOMMAND);
		$appcount=$rs ? $rs->appClass->appcount : 0;
		T::A('appcount',$appcount);
		T::A('title','首页 - ');
	}
	
}