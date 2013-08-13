
$(document).ready(function() {
    var t = false;
    var str = '';
    var speed = 500;
    var w = 960;
    var n = $('#actor li').length;
    //var numWidth = n * 29;
    //var _left = (w - (numWidth + 26)) / 1.5;
    var c = 0;
    $('#actor').width(w * n);
    //$('#index_top_imgply .mc').width(numWidth);

    $('#numInner span:first').addClass('on');
    function cur(ele, currentClass) {
        ele = $(ele) ? $(ele) : ele;
        ele.addClass(currentClass).siblings().removeClass(currentClass)
    }
    $('#index_top_imgply .next').click(function() {
        slide(1)
    });
    $('#index_top_imgply .prev').click(function() {
        slide( - 1)
    });
    function slide(j) {
        if ($('#actor').is(':animated') == false) {
            c += j;
            if (c != -1 && c != n) {
                $('#actor').animate({
                    'marginLeft': -c * w + 'px'
                },
                speed)
            } else if (c == -1) {
                c = n - 1;
                $("#actor").css({
                    "marginLeft": -(w * (c - 1)) + "px"
                });
                $("#actor").animate({
                    "marginLeft": -(w * c) + "px"
                },
                speed)
            } else if (c == n) {
                c = 0;
                $("#actor").css({
                    "marginLeft": -w + "px"
                });
                $("#actor").animate({
                    "marginLeft": 0 + "px"
                },
                speed)
            }
            cur($('#numInner span').eq(c), 'on')
        }
    }
    $('#numInner span').click(function() {
        c = $(this).index();
        fade(c);
        cur($('#numInner span').eq(c), 'on')
    });
    function fade(i) {
        if ($('#actor').css('marginLeft') != -i * w + 'px') {
            $('#actor').css('marginLeft', -i * w + 'px');
            $('#actor').fadeOut(0, 
            function() {
                $('#actor').fadeIn(500)
            })
        }
    }
    function start() {
        t = setInterval(function() {
            slide(1)
        },
        5000)
    }
    function stopt() {
        if (t) clearInterval(t)
    }
    $("#index_top_imgply").hover(function() {
        stopt()
    },
    function() {
        start()
    });
    start()
});
