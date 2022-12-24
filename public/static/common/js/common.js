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

// php的empty()函数
function empty(str) {
    return typeof (str) === "undefined" || str == null || str === "" || str === "NaN";
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
function timestampToTime(timestamp) {
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
    return Y + M + D + H + m + s;
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
        url: '/api/User/isLogin',
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

// 循环获取表单的值
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