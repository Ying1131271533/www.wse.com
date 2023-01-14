

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
        type: "PUT",
        contentType: "application/x-www-form-urlencoded",
        url: '/ajax/update_field_value',
        data: {
            id: id,
            field: field,
            value: value,
            db: db,
        },
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getApiToken());
        },
        success: function (res) {

            if (res.code !== config('success')) {
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
        type: "PUT",
        contentType: "application/x-www-form-urlencoded",
        url: '/ajax/update_field_value',
        data: {
            id: id,
            field: field,
            value: value,
            db: db,
        },
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getApiToken());
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



// 读取单条数据
function ajax_read(url, is_token = false) {
    // url后传递的参数
    // var id = getParams()['id'];
    var id = get_url_id();
    let is_toekn = is_token;
    let data = null;

    if(is_token){
        $.ajax({
            type: "GET",
            contentType: "application/x-www-form-urlencoded",
            url: 'http://api.wse.com' + url + '/' + id,
            async: false, // 关闭异步
            beforeSend: function (request) {
                request.setRequestHeader("access-token", getApiToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg);
                    return false;
                }
                data = res.data;
            }
        });
    }else{
        $.ajax({
            type: "GET",
            contentType: "application/x-www-form-urlencoded",
            url: 'http://api.wse.com' + url + '/' + id,
            async: false, // 关闭异步
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg);
                    return false;
                }
                data = res.data;
            }
        });
    }

    // 返回数据
    return data;
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 数据保存(添加)
 *
 * @param  string 	url             提交的url
 * @param  json     data            数据
 * @param  string   back_url        要返回的页面
 * @param  bool     is_token        是否需要登录token
 */
function ajax_save(url, data, back_url = null, is_token = false) {
    // console.log(data);
    // return false;
    let is_toekn = is_token;
    // 发异步，把数据提交给php
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: 'http://api.wse.com' + url,
        data: data,
        beforeSend: function (request) {
            if (is_toekn) {
                request.setRequestHeader("access-token", getApiToken());
            }
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
}

// 读取多条数据
function ajax_list(url, is_token = false) {
    let is_toekn = is_token;
    let data = null;
    if(is_token){
        $.ajax({
            type: "GET",
            contentType: "application/x-www-form-urlencoded",
            url: 'http://api.wse.com' + url,
            async: false, // 关闭异步
            beforeSend: function (request) {;
                request.setRequestHeader("access-token", getApiToken());
            },
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg);
                    return false;
                }
                data = res.data;
            }
        });
    }else{
        $.ajax({
            type: "GET",
            contentType: "application/x-www-form-urlencoded",
            url: 'http://api.wse.com' + url,
            async: false, // 关闭异步
            dataType: "json",
            success: function (res) {
                if (res.code !== config('success')) {
                    layer.msg(res.msg);
                    return false;
                }
                data = res.data;
            }
        });
    }

    // 返回数据
    return data;
}


// 原生xhr请求
function xhr_get(url) {
    var xhr = new XMLHttpRequest();
    xhr.open("get", "http://api.wse.com" + url, false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=UTF-8");
    xhr.send(null);
    // xhr.send('"id=id&username=akali"');
    // xhr.send('id:1,username:akali');
    // console.log(xhr);
    res = xhr.response;
    res = JSON.parse(res);
    // console.log(res);
    if (res.code !== config('success')) {
        layer.msg(res.msg);
        return false;
    }
    // 返回数据
    return res.data;
}


/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 删除单条数据
 *
 * @param  string 	url     提交的url
 */
function ajax_delete(url) {
    let result = null;
    $.ajax({
        type: "DELETE",
        contentType: "application/x-www-form-urlencoded",
        url: 'http://api.wse.com' + url,
        async: false,
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getApiToken());
        },
        success: function (res) {
            if (res.code === config('success')) {
                layer.msg(res.msg, { icon: 1, time: 500 });
                result = true;
            } else {
                layer.msg(res.msg, { icon: 2, time: 500 });
                result = false;
            }
        }
    });
    return result;
}




/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/04/06 15:57
 *
 * 表单的input分配值
 *
 * @param  obj      data    数据
 */
function input_assign_value(data = null) {
    for (let key in data) {
        var length = $('#' + key).length;
        if (length > 0) {
            if ($('#' + key).is("input")) {
                $('#' + key).val(data[key]);
                var type = $('#' + key).attr('type');
                if (type == 'radio' && key == 'status') {
                    $('input[name="status"][value="' + data[key] + '"]').attr('checked', true);
                }
            }
            if ($('#' + key).is("select")) {

            }
            if ($('#' + key).is("textarea")) {

            }
        };
    }

}

// 赋值
function assign(data) {
    for(let key in data){
        
    }
    $.each(data, function (key, value) {
        console.log('#assign-'.key);
        if($('#assign-'.key).length > 0){
            $('#assign-'.key).text(value);
        }
    });
}