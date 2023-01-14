// 页码
var page = 1;
// 条数
var limit = 10;

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

// 渲染文章列表
function renderArticleList(url, type) {
    // 获取文章列表
    var list = ajax_list(url + '?page=' + page + '&limit=' + limit);
    // 页码加1
    page += 1;
    // html内容
    var html = '';
    $.each(list, function (key, value) {
        html += '<li>';
        html += '<div class="pdivnewslitb">';
        html += '<a href="/' + type + '/' + value.id + '" target="_blank">';
        html += '<img class="pdivnewslitbimg" src="' + value.image + '" alt="' + value.title + '" title="' + value.title + '" style="width: 170px; height: 128px" />';
        html += '</a>';
        html += '</div>';
        html += '<div class="pdivnewslileft">';
        html += '<h8><a href="/' + type + '/' + value.id + '" target="_blank">' + value.title + '</a></h8>';
        html += '<div class="pdivtimes">' + timestampToTime(value.create_time, true) + '</div>';
        html += '<div class="divteanbcent">';
        html += '<a href="/' + type + '/' + value.id + '" target="_blank">';
        html += '<p>' + value.description + '</p>';
        html += '</div>';
        html += '</div>';
        html += '</li>';
    });
    // 追加
    $('#' + type + '_list ul').append(html);
}

// 渲染跨境平台列表
function renderPlatformList(url, type) {
    // 获取平台列表
    var list = ajax_list(url + '?page=' + page + '&limit=' + limit);
    // 页码加1
    page += 1;
    // html内容
    var html = '';
    $.each(list, function (key, value) {
        html += '<li>';
        html += '<a href="/platform/' + value.id + '">';
        html += '<img src="' + value.image + '" alt="' + value.title + '" title="' + value.title + '" />';
        html += '<p>' + value.title + '</p>';
        html += '</a>';
        html += '</li>';
    });
    // 追加
    $('#' + type + '_list ul').append(html);
}


/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 上传图片
 *
 * @param  obj      upload      layui的上传文件对象
 * @param  string 	name        接收图片的input名称
 */
function upload_image(id) {
    layui.use(['upload', 'layer'], function () {
        var upload = layui.upload;
        var layer = layui.layer;
        // 上传文件
        //执行实例
        var uploadInst = upload.render({
            elem: '#' + id // 绑定元素
            , url: 'http://api.wse.com/upload/file' // 上传接口
            , method: 'POST'  // 可选项。HTTP类型，默认post
            , data: { type: 'images' } // 可选项。额外的参数，如：{id: 123, abc: 'xxx'}
            , field: 'images' // 上传文件的字段名
            , before: function (obj) {
                // 预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#' + id).parents('.layui-upload').find('#upload-preview').attr('src', result); // 图片链接（base64）
                });
                // layer.msg('上传中', {icon: 16, time: 0});
            }
            , done: function (res) {
                // 上传完毕回调
                if (res.code !== config('success')) {
                    layer.msg(res.msg, { icon: 2 });
                    return false;
                }
                layer.msg('上传成功', { icon: 1, time: 500 });
                $('#' + id).parents('.layui-upload').find('input[name="'+id+'"]').val(res.data.path);
            }
            , error: function () {
                // 请求异常回调
                layer.msg('上传失败', { icon: 2 });
            }
        });
    });

}