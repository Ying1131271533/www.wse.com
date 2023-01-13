$(document).ready(function () {
    let url = window.location.href, token = null;
    if (url.search("api") !== -1) {
        token = getApiToken();
    } else {
        token = getToken();
    }
    $.ajaxSetup({
        async: false,
        beforeSend: function (request) {
            request.setRequestHeader("access-token", token);
        },
    });
});

// 获取时间
function time() {
    let tmp = Date.parse(new Date()).toString();
    tmp = tmp.substr(0, 10);
    return tmp;
}

// 模仿php的empty()函数
function empty(val) {
    // 如果是数组
    if (val instanceof Array === true) {
        if ($(val).length < 1) {
            return true
        }
        return false;
    }
    // 如果是对象
    else if (val instanceof Object === true) {
        if ($.isEmptyObject(val)) {
            // if(JSON.stringify(data) == "{}"){
            return true
        }
        return false;
    }
    else {
        return typeof (val) === "undefined" || val == null || val === "" || val === "NaN";
    }

}

function arrayDuplicate(a, b) {
    let c = [];
    a.forEach(v => {
        if (b.indexOf(v) === -1) {
            c.push(v);
        }
    });
    return c;
}

// 获取url后面的参数 红叶
function getParams() {
    var url = location.search;
    url = decodeURI(url);
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        // if (url.indexOf("''") != -1) {
        var str = url.substring(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
        }
    }
    // url后传递的参数
    // var id = theRequest.id;
    return theRequest;
}

// 获取时间戳
function timeToTimeStamp($time) {
    if (empty($time)) {
        return null;
    }
    let date = new Date($time);
    return Date.parse(date) / 1000;
}

// 时间戳转换成日期
function timestampToTime(timestamp, is_date = false) {
    if (empty(timestamp)) {
        return "缺失时间";
    }
    let date = new Date(timestamp * 1000);
    // 年月日
    let Y = date.getFullYear() + '-';
    let M = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
    let D = date.getDate() < 10 ? '0' + date.getDate() + ' ' : date.getDate() + ' ';
    // 时分秒
    let H = date.getHours() + ':';
    let m = (date.getMinutes() < 10 ? '0' + (date.getMinutes()) : date.getMinutes()) + ':';
    let s = (date.getSeconds() < 10 ? '0' + (date.getSeconds()) : date.getSeconds());
    let result = is_date === false ? Y + M + D + H + m + s : Y + M + D;
    return result;
}

// 读取配置
function config(status) {

    $.ajaxSetup({ async: false });
    let res = null;
    $.getJSON("/static/common/js/code.json", function (data) {
        res = data[status];
    });
    return res;
}

// 获取api的token
function getApiToken() {
    return $.cookie('api_login_token');
}

// 获取管理员的token
function getToken() {
    return $.cookie('admin_login_token');
}

// 是否已登录
function isAdminLogin(secret) {
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: '/' + secret + '/Admin/isLogin',
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', { time: 500 }, function () {
                    $.remvoeCookie('admin_login_token', { path: '/' });
                    // $(window).attr('location', '/' + secret + 'loginView');
                });
            }
        }
    });
}

// 用户是否已登录
function isApiLogin() {
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: 'http://api.wse.com/user/is_login',
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getApiToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', { time: 500 }, function () {
                    $.removeCookie('api_login_token', { path: '/' });
                    // $.removeCookie('api_login_token', {domain: document.domain, path: '/'});
                    $(window).attr('location', '/api/View/user/login');
                });
            }
        }
    });
}

// 管理员是否已登录
function isAdminLogin() {
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: '/admin/is_login',
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg(res.msg, { time: 500 }, function () {
                    $.removeCookie('admin_login_token', { path: '/' });
                    // $.removeCookie('api_login_token', {domain: document.domain, path: '/'});
                    $(window).attr('location', '/view/login');
                });
            }
        }
    });
}

// 获取用户
function getUserById(uid) {
    let user = null;
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: '/api/User/getUserById',
        data: { id: uid },
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getApiToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', {}, function () {
                    $.removeCookie('api_login_token', { path: '/' });
                    $(window).attr('location', '/api/View/user/login');
                });
            }

            if (res.code === config('failed')) {
                layer.msg(res.msg);
                return false;
            }
            // console.log(res.data);
            user = res.data;
        }
    });
    // 返回用户信息，必须要在ajax外面返回值
    return user;
}

// 获取用户
function getUser() {
    let user = null;
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: '/api/User/getUserByToken',
        async: false,
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getApiToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', {}, function () {
                    $.removeCookie('api_login_token', { path: '/' });
                    $(window).attr('location', '/api/View/user/login');
                });
            }

            if (res.code === config('failed')) {
                layer.msg(res.msg);
                return false;
            }
            // console.log(res.data);
            user = res.data;
        }
    });
    // 返回用户信息，必须要在ajax外面返回值
    return user;
}

// 获取管理员
function getAdmin() {
    let admin = null;
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded",
        url: '/admin/get_admin_by_token',
        async: false,
        beforeSend: function (request) {
            request.setRequestHeader("access-token", getToken());
        },
        success: function (res) {
            if (res.code === config('goto')) {
                layer.msg('登录凭证失效！', {}, function () {
                    $.removeCookie('admin_login_token', { path: '/' });
                    $(window).attr('location', '/view/login');
                });
            }

            if (res.code === config('failed')) {
                layer.msg(res.msg);
                return false;
            }
            // console.log(res.data);
            admin = res.data;
        }
    });
    // 返回用户信息，必须要在ajax外面返回值
    return admin;
}

// 滚动到指定位置 上、中、下
function scrollToEnd(val) {
    var h = null;
    switch (val) {
        case 1:
            h = 0;
            break;
        case 2:
            h = $(document).height() - $(window).height() / 2;
            break;
        case 3:
            h = $(document).height() - $(window).height();
            break;
    }
    $(document).scrollTop(h);
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2023/01/12 11:11
 *
 * 循环获取表单的值
 *
 * @param  bool     not_empty   表单数据是否不能为空
 * @return array                返回表单数据
 */
function get_input_value(not_empty = false) {
    let data = {};
    $('.input-value').each(function (key, value) {
        var name = $(this).attr('name');
        var title = $(this).attr('title');
        var val = $(this).val();
        if (!val && not_empty == true) {
            layer.msg(title + '不能为空', { icon: 2, tiem: 500 });
            return false;
        }
        data[name] = val;
    });
    return data;
}

function open_img(obj) {

    // 获取图片路径
    var src = $(obj).attr("src");

    // 获取图片的真实宽高
    $('<img/>').attr("src", src).on('load', function () {

        // 设置图片的宽度不能超过1280px
        var width = this.width > 1280 ? 1280 : this.width;
        var height = this.height;
        var html = '<img src="' + src + '" width="' + width + '" />';

        // 页面层-佟丽娅
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: width + 'px',
            skin: 'layui-layer-nobg', // 没有背景色
            shadeClose: true,
            content: html
        });
    });
}

// Layui 中的富文本编辑器中遇到的html代码没有转换的解决方案
var HtmlUtil = {
    /*1.用浏览器内部转换器实现html转码*/
    htmlEncode: function (html) {
        //1.首先动态创建一个容器标签元素，如DIV
        var temp = document.createElement("div");
        //2.然后将要转换的字符串设置为这个元素的innerText(ie支持)或者textContent(火狐，google支持)
        (temp.textContent != undefined) ? (temp.textContent = html) : (temp.innerText = html);
        //3.最后返回这个元素的innerHTML，即得到经过HTML编码转换的字符串了
        var output = temp.innerHTML;
        temp = null;
        return output;
    },

    /*2.用浏览器内部转换器实现html解码*/
    htmlDecode: function (text) {
        //1.首先动态创建一个容器标签元素，如DIV
        var temp = document.createElement("div");
        //2.然后将要转换的字符串设置为这个元素的innerHTML(ie，火狐，google都支持)
        temp.innerHTML = text;
        //3.最后返回这个元素的innerText(ie支持)或者textContent(火狐，google支持)，即得到经过HTML解码的字符串了。
        var output = temp.innerText || temp.textContent;
        temp = null;
        return output;
    }

};


// 获取地址的id
function get_url_id() {
    // 正则匹配地址栏最后的数字
    var id = location.href.match(/\d+/g)[0];
    if (empty(id)) {
        layer.msg('地址参数出错！，请刷新页面', { icon: 2 });
        return false;
    }
    return id;
}

/**
 * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
 * @author: 神织知更
 * @time: 2022/03/31 21:56
 *
 * 递归找子级数据
 *
 * @param  array    data            数据
 * @param  int      parent_id       父级id
 * @return array                    返回处理好的数组
 */
function get_chlidren(data = [], parent_id = 0) {
    var tmp = [];
    for (let value of data) {
        if (value['parent_id'] == parent_id) {
            value['children'] = get_chlidren(data, value['id']);
            tmp.push(value);
        }
    }
    return tmp;
}