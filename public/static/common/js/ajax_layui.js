
/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 数据保存(添加)
 *
 * @param  obj      form            layui表单实例
 * @param  string 	url             提交的url
 * @param  string   back_url        要返回的页面
 */
function layui_ajax_save(form, url, back_url = null) {
    form.on('submit(formSubmit)', function (data) {
        console.log(data);
        // return false;
        // 发异步，把数据提交给php
        $.ajax({
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            url: url,
            data: data.field,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg, { icon: 2 });
                    return false;
                }
                layer.msg(res.msg, { icon: 1, time: 500 }, function () {
                    if (back_url) {
                        window.location.href = back_url;
                        return false;
                    }
                    location.reload();
                });

            }
        });

        return false;
    });
}


/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 数据更新
 *
 * @param  obj      form            layui表单实例
 * @param  string 	url             提交的url
 * @param  string   back_url        要返回的页面
 */
function layui_ajax_update(form, url, back_url) {
    form.on('submit(formSubmit)', function (data) {
        // console.log(data);
        //发异步，把数据提交给php
        $.ajax({
            type: "PUT",
            contentType: "application/x-www-form-urlencoded",
            url: url,
            data: data.field,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg, { icon: 2 });
                    return false;
                }
                layer.msg(res.msg, { icon: 1, time: 500 }, function () {
                    if (back_url) {
                        window.location.href = back_url;
                        return false;
                    }
                    location.reload();
                });
            }
        });

        return false;
    });
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * layui表单删除单条数据
 *
 * @param  obj      obj     当前元素
 * @param  string 	url     提交的url
 */
function layui_form_delete(obj, url) {

    layer.confirm('确认要删除吗？', function (index) {
        // 发异步删除数据
        $.ajax({
            type: "DELETE",
            url: url,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg, { icon: 2 });
                    return false;
                }
                layer.msg(res.msg, { icon: 1, time: 500 }, function () {
                    $(obj).parents("tr").remove();
                });
            }
        });
    });
}
