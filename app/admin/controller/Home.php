<?php
namespace app\admin\controller;

use app\common\lib\facade\Token;
use app\common\model\Article as ArticleModel;
use app\common\model\CustomerService as CustomerServiceModel;
use app\common\model\News as NewsModel;
use app\common\model\Platform as PlatformModel;
use app\common\model\Product as ProductModel;
use app\common\model\User as UserModel;
use think\facade\App;
use think\facade\Request;

class Home
{
    // 首页
    public function index()
    {

    }

    public function welcome()
    {
        // 组装数据
        $data = [
            'username' => Token::getUser()['username'],
            'date'     => date('Y-m-d H:i:s'),
            // 数据统计
            'count'    => [
                ['文章数', ArticleModel::where('status', 1)->count()],
                ['新闻数', NewsModel::where('status', 1)->count()],
                ['会员数', UserModel::count()],
                ['评论数', '--'],
                ['公司产品数', ProductModel::count()],
                ['跨境平台数', PlatformModel::count()],
                ['客服数', CustomerServiceModel::count()],
            ],
            // 系统信息
            'system'   => [
                ['服务器地址', Request::server('HTTP_HOST')],
                ['操作系统', php_uname()],
                ['运行环境', 'LNMP'],
                ['Nginx版本', Request::server('SERVER_SOFTWARE')],
                ['PHP版本', PHP_VERSION],
                ['PHP运行方式', php_sapi_name()],
                ['MYSQL版本', getMysqlVersion()],
                ['Redis版本', getRedisVersion()],
                ['ThinkPHP版本', App::version()],
                ['上传附件限制', '2M'],
                // ['执行时间限制', ini_set()],
                ['磁盘剩余空间', get_disk_total(disk_free_space('.'))],
                ['磁盘总容量', get_disk_total(disk_total_space('.'))],
            ],
        ];
        
        // 返回数据
        return success($data);
    }
}