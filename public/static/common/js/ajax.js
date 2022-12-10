

/**
 * 改变数据状态，只能是0和1
 *
 * @param  this
 * @return $
 */
function ajax_change_status(obj) {
    // 数据
    var id = $(obj).attr("data-id"); // id
    var value = $(obj).attr("data-value") == 1 ? 0 : 1; // 要修改的值
    var field = $(obj).attr("data-field"); // 字段名称
    var db = $(obj).attr("data-db"); // 表名

    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: '/ajax/update_field_value',
        data: {
            id: id,
            field: field,
            value: value,
            db: db,
        },
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getToken());
        },
        success: function (res) {

            if (res.code == config('failed')) {
                layer.msg(res.msg, { icon: 2 });
                return false;
            }

            if (res.data.value == 1) {
                $(obj).removeClass("layui-btn-danger").attr("data-value", 1).text("开启");
            } else {
                $(obj).addClass("layui-btn-danger").attr("data-value", 0).text("关闭");
            }
        }
    });
}

/**
 * 修改数据字段的值
 *
 * @param  id 数据id
 * @param  field 字段
 * @param  value 要修改的值
 * @param  db 表名
 * @return json
 */
function ajax_field_value(id, field, value, db) {

    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: '/ajax/update_field_value',
        data: {
            id: id,
            field: field,
            value: value,
            db: db,
        },
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getToken());
        },
        success: function (res) {

            if (res.code == config('failed')) {
                layer.msg(res.msg, { icon: 2 });
                return false;
            }

            layer.msg('修改成功');
        }
    });
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 数据保存
 *
 * @param  obj      from            layui表单实例
 * @param  string 	url             提交的url
 * @param  obj      layer           layer实例
 * @param  bool     father_reload   是否对父窗口进行刷新 
 */
function layui_ajax_save(form, url, layer, father_reload = true) {
    form.on('submit(form)', function (data) {
        console.log(data);
        //发异步，把数据提交给php
        $.ajax({
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            url: url,
            data: data.field,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                if (res.code === config('failed')) {
                    layer.msg(res.msg);
                } else if (res.code === config('success')) {
                    layer.msg("保存成功", { time: 500 }, function () {
                        // 关闭当前frame
                        xadmin.close();
                        // 可以对父窗口进行刷新 
                        if (father_reload) xadmin.father_reload();
                    });
                }
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
 * @param  obj      from            layui表单实例
 * @param  string 	url             提交的url
 * @param  obj      layer           layer实例
 * @param  bool     father_reload   是否对父窗口进行刷新 
 */
function layui_ajax_update(form, url, layer, father_reload = true) {
    form.on('submit(form)', function (data) {
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
                if (res.code === config('failed')) {
                    layer.msg(res.msg);
                } else if (res.code === config('success')) {
                    layer.msg("保存成功", { time: 500 }, function () {
                        // 关闭当前frame
                        xadmin.close();
                        // 可以对父窗口进行刷新 
                        if (father_reload) xadmin.father_reload();
                    });
                }
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
 * 搜索
 *
 * @param  obj      from            layui表单实例
 * @param  string 	url             提交的url
 */
function layui_ajax_search(form, url) {
    let data = null;
    form.on('submit(form)', function (data) {
        // console.log(data);
        //发异步，把数据提交给php
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
                    layer.msg(res.msg);
                    return false;
                }
                
                data = res.data;
            }
        });

        return data;
    });
}


// 读取单条数据
function ajax_read(url) {
    // url后传递的参数
    var id = get_url_id();
    let data = null;

    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: url + '/' + id,
        async: false, // 关闭异步
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getToken());
        },
        success: function (res) {
            if (res.code !== config('success')) {
                layer.msg(res.msg);
                return false;
            }
            data = res.data;
        }
    });

    // 返回数据
    return data;
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 删除单条数据
 *
 * @param  obj      obj     当前元素
 * @param  string 	url     提交的url
 * @param  int      id      数据id
 */
function ajax_delete(obj, url, id) {
    $.ajax({
        type: "GET",
        url: url + '/' + id,
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getToken());
        },
        success: function (res) {
            layer.msg(res.msg);
            if (res.code === config('success')) {
                return true;
            }
        }
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
 * @param  int      id      数据id
 */
function layui_form_delete(obj, url, id) {

    layer.confirm('确认要删除吗？', function (index) {
        // 发异步删除数据
        $.ajax({
            type: "DELETE",
            url: url + '/' + id,
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getToken());
            },
            success: function (res) {
                layer.msg(res.msg, { icon: 1, time: 500 });
                if (res.code === config('success')) {
                    // 移除元素
                    $(obj).parents("tr").remove();
                }
            }
        });
    });
}

// 获取地址的id
function get_url_id() {

    var id = location.href.match(/\d+/g)[0];
    if (empty(id)) {
        layer.msg('地址参数出错！，请刷新页面', { icon: 2 });
        return false;
    }
    return id;
}
