
function slides(category_id) {
    // 获取轮播图列表
    var slidesList = ajax_list('/slides/get_slieds_list/' + category_id);
    // console.log(slidesList);
    var html = '';
    $.each(slidesList, function (key, value) {
        html += '<div>';
        html += '<a href="' + value.url + '" target="_blank">';
        html += '<img src="' + value.image + '">';
        html += '</a>';
        html += '</div>';
    });
    $('#assign-slides').append(html);

    layui.use('carousel', function () {
        var carousel = layui.carousel;
        // 建造实例
        carousel.render({
            elem: '#test1'
            , width: '100%' //设置容器宽度
            , height: '100%' //设置容器高度
            //,arrow: 'always' // 始终显示箭头
            //,anim: 'updown' // 切换动画方式
        });
    });
}