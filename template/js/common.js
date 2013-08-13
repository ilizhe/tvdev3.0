var nav = document.getElementById("mynav");
var links = nav.getElementsByTagName("a");
var currenturl = document.location.href;
var last = 0;
for (var i=0;i<links.length;i++)
{
   var linkurl =  links[i].getAttribute("href");
     if(currenturl.indexOf(linkurl)!=-1)
        {
         last = i;
        }
}
links[last].className = "cur";  //高亮代码样式