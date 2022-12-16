

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
            request.setRequestHeader("access-token", getToken());
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
 * 表单的input分配值
 *
 * @param  obj      data    数据
 */
function input_assign_value(data = null) {
    for(let key in data){
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

// 获取表单值
function get_input_value() {
    let data = {};
    $('.input-value').each(function (index, element) {
        var name = $(this).attr('name');
        var title = $(this).attr('title');
        var val = $(this).val();
        if (!val) {
            layer.msg(title + '不能为空', { icon: 2, tiem: 500});
            success = false;
            return false;
        }
        data[name] = val;
    });
    return data;
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

// 读取多条数据
function ajax_list(url) {
    let data = null;
    $.ajax({
        type: "GET",
        contentType: "application/x-www-form-urlencoded",
        url: url,
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
 */
function ajax_delete(obj, url) {
    $.ajax({
        type: "DELETE",
        url: url,
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

// 获取地址的id
function get_url_id() {

    var id = location.href.match(/\d+/g)[0];
    if (empty(id)) {
        layer.msg('地址参数出错！，请刷新页面', { icon: 2 });
        return false;
    }
    return id;
}
