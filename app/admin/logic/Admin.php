<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Forbidden;
use app\common\lib\exception\Miss;
use app\common\lib\Token;
use app\common\logic\lib\Redis;
use app\common\logic\lib\Str;
use app\common\model\Admin as AdminModel;
use Exception;

class Admin
{
    private $adminModel = null;
    private $redis      = null;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->redis      = new Redis();
    }

    // 登录
    public function login($data)
    {
        // 找到管理员
        $admin = $this->adminModel->findAdminByUserName($data['username']);
        if (empty($admin)) {
            throw new Fail('帐号不存在！');
        }

        // 用户状态
        if ($admin['status'] == 0) {
            throw new Fail('该用户被禁止登录');
        }

        // 对比密码
        $salt     = $admin['password_salt'];
        $password = md5($salt . $data['password'] . $salt);
        if ($password != $admin['password']) {
            throw new Fail('密码不正确！');
        }

        // 如果IsLogin中间件那里使用了账号异地登录的话，就删除redis的token
        // 删除上次的token
        // $this->redis->delete(config('redis.token_pre') . $admin['last_login_token']);

        // 生成token
        $token = Str::createToken($admin['username']);

        // 更新用户登录信息
        $admin->save([
            'last_login_token' => $token,
            'login_number'     => $admin['login_number'] + 1,
            'last_login_ip'    => get_client_ip(),
            'last_login_time'  => time(),
        ]);

        $data = [
            'id'       => $admin['id'],
            'username' => $admin['username'],
        ];

        // 获取权限
        if (config('auth.type') == 2 && !in_array($admin['username'], config('auth.super'))) {
            $auth   = new Auth;
            $access = $auth->getAccess($admin['id']);
            $data['access'] = $access;
        }
        
        // 保存token，设置过期时间：一个月
        $this->redis->set(config('redis.token_pre') . $token, $data, cache_time('one_month'));

        // 返回token
        return $token;
    }

    // 退出登录
    public function logout()
    {
        // 删除token
        Token::deleteToken();
    }

    // 获取管理员列表
    public function getAdminList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['usernameReload']) and $where[] = ['username', 'like', "%{$data['usernameReload']}%"];
        $adminList = AdminModel::getPageList(
            $data['page'],
            $data['limit'],
            $where,
            ['password', 'password_salt', 'last_login_token'], ['id' => 'asc']
        );
        return $adminList;
    }

    public function save($data)
    {
        // 用户是否已经存在
        $admin = AdminModel::find($data['username']);
        if (!empty($admin)) {
            throw new Exception('用户名已被注册！');
        }

        // 生成5个字符长度的盐
        $salt = Str::salt(5);
        // 数据加入密码盐
        $data['password_salt'] = $salt;
        // 明文密码前后加盐，生成密码
        $data['password'] = md5($salt . $data['password'] . $salt);

        // 启动事务
        $this->adminModel->startTrans();

        try {
            // 保存管理员
            $adminResult = $this->adminModel->save($data);
            if (!$adminResult) {
                throw new Exception('管理员保存失败');
            }

            $role = array_unique($data['roles']);
            if (!empty($role)) {
                // 保存中间表数据
                $result = $this->adminModel->roles()->saveAll($role);
                if (!$result) {
                    throw new Exception('保存角色关联数据失败');
                }

            }

            // 提交事务
            $this->adminModel->commit();
            return $this->adminModel;
        } catch (Exception $e) {
            $this->adminModel->rollback();
            throw new Fail($e->getMessage());
        }
    }

    public function update($data)
    {
        // 用户是否存在
        $admin = AdminModel::find($data['id']);
        if (empty($admin)) {
            throw new Miss('该用户不存在');
        }

        // 重新生成密码
        // $data['password'] = md5($admin['password_salt'] . $data['password'] . $admin['password_salt']);

        // 启动事务
        $admin->startTrans();

        try {

            // 删除原来的角色数据
            if (!$admin['roles']->isEmpty()) {
                $rolesResult = $admin->roles()->detach();
                if (!$rolesResult) {
                    throw new Exception('原来的角色数据删除失败');
                }

            }

            // 保存管理员
            $adminResult = $admin->save($data);
            if (!$adminResult) {
                throw new Exception('管理员保存失败');
            }

            // 保存角色
            $role = array_unique($data['roles']);
            if (!empty($role)) {
                // 保存中间表数据
                $result = $admin->roles()->saveAll($role);
                if (!$result) {
                    throw new Exception('保存角色关联数据失败');
                }

            }

            // 提交事务
            $admin->commit();
            return $admin;
        } catch (Exception $e) {
            $admin->rollback();
            throw new Fail($e->getMessage());
        }
    }

    public function updatePassword($data)
    {
        // 用户是否存在
        $admin = AdminModel::find($data['id']);
        if (empty($admin)) {
            throw new Miss('该用户不存在');
        }

        // 生成5个字符长度的盐
        $salt = salt(5);
        // 数据加入密码盐
        $data['password_salt'] = $salt;
        // 明文密码前后加盐，生成密码
        $data['password'] = md5($salt . $data['password'] . $salt);

        // 保存
        $result = $admin->save($data);
        if (empty($result)) {
            throw new Fail('更新失败');
        }
    }

    public function changeStatus($id, $value)
    {
        $admin = AdminModel::find($id);
        if (empty($admin)) {
            throw new Miss('管理员不存在');
        }

        $result = $admin->save(['status' => $value]);
        if (empty($result)) {
            throw new Fail('更新失败');
        }

        return [
            'id'    => $admin['id'],
            'value' => $admin['status'],
        ];
    }

    public function delete($id)
    {
        // 用户是否存在
        $admin = AdminModel::with('roles')->find($id);
        if (empty($admin)) {
            throw new Miss('该用户不存在');
        }

        // 开启事务
        $admin->startTrans();
        try {
            // 删除角色数据
            if (!$admin['roles']->isEmpty()) {
                $rolesResult = $admin->roles()->detach();
                if (!$rolesResult) {
                    throw new Exception('角色数据删除失败');
                }

            }

            $result = $admin->delete();
            if (!$result) {
                throw new Exception('管理员删除失败');
            }

            $admin->commit();
        } catch (Exception $e) {
            $admin->rollback();
            throw new Fail($e->getMessage());
        }

        // 删除用户，没想到不用cache(true)都能删除缓存
        // $result = $admin->delete();
        // if (!$result) {
        //     throw new Fail('删除失败！');
        // }

    }
}
