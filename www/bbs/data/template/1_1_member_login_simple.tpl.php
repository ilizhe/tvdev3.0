<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if(CURMODULE != 'logging') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>logging.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<style>
.lorg{color:#fff;float:right;font-size:14px;margin-top:20px;font-family:"microsoft YaHei";}
.lorg a{color:#C7EEFD;margin:0 3px;}
</style>
<div class="sl">
<div class="share">
<span>关注我们：</span><a class="wb" title="新浪微博" href="http://weibo.com/u/2887330904"><img src="<?php echo IMGDIR;?>/wb.png" style="vertical:middle;line-height:21px;"></img></a>
</div>
<div class="lorg">
<a href="javascript:;" onclick="javascript:loginredirect()"><em>登录&nbsp;</em></a>|
<a href="javascript:;" onclick="javascript:regredirect()"><em><?php echo $_G['setting']['reglinkname'];?></em></a>
<?php if(!empty($_G['setting']['pluginhooks']['global_login_extra'])) echo $_G['setting']['pluginhooks']['global_login_extra'];?>
</div>
    </div>
<form method="post" name="appsearch" id="appsearch" action="<?php echo $_G['config']['url']['www'];?>/?mod=app&act=searchApp" class="sbbs" onsubmit="return false;">
<input type="text" onclick="if (this.value=='请输入搜索关键字') this.value=''" onfocus="this.select()" onblur="if (this.value =='') this.value='请输入搜索关键字'" onmouseover="this.focus()" value="请输入搜索关键字" name="keyword" id="mykeyword">
<button class="forapp"  onclick="javascript:searchapps()">搜应用</button><button class="forinfo" onclick="javascript:searchnews()">搜资讯</button>
</form>
<script type="text/javascript">
function loginredirect()
{
var url=window.location.href;
window.location.href="<?php echo $_G['config']['url']['login'];?>&returnurl="+encodeURIComponent(url);
}
function regredirect()
{
var url=window.location.href;
window.location.href="<?php echo $_G['config']['url']['reg'];?>&returnurl="+encodeURIComponent(url);
}

function searchapps()
{
var keyword=$("mykeyword").value;
if(keyword=='' || keyword=='请输入搜索关键字')
window.location.href="<?php echo $_G['config']['url']['www'];?>/app.html";
else
document.getElementById("appsearch").submit();
return true;
}

function searchnews()
{
var keyword=$("mykeyword").value;
if(keyword=='' || keyword=='请输入搜索关键字')
window.location.href=encodeURI('portal.php?mod=list&catid=1');
else
window.location.href=encodeURI('search.php?mod=portal&searchsubmit=true&source=hotsearch&srchtxt=')+encodeURIComponent(keyword);
return false;
}
</script>
<?php } ?>