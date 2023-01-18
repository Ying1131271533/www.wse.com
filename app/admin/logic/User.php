<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Forbidden;
use app\common\lib\exception\Miss;
use app\common\lib\facade\Redis as FacadeRedis;
use app\common\lib\facade\Token;
use app\common\logic\lib\Redis;
use app\common\lib\facade\Str;
use app\common\model\User as UserModel;
use Exception;

class User
{
    private $userModel = null;
    private $redis      = null;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->redis      = new Redis();
    }
    
    // 获取用户列表
    public function getUserList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['usernameReload']) and $where[] = ['username', 'like', "%{$data['usernameReload']}%"];
        $userList                                   = UserModel::getPageList(
            $data['page'],
            $data['limit'],
            $where,
            ['password', 'password_salt', 'last_login_token'], ['id' => 'asc']
        );
        return $userList;
    }

    public function update($data)
    {
        // 用户是否存在
        $user = UserModel::find($data['id']);
        if (empty($user)) {
            throw new Miss('该用户不存在');
        }

        // 重新生成密码
        // $data['password'] = md5($user['password_salt'] . $data['password'] . $user['password_salt']);

        // 启动事务
        $user->startTrans();

        try {
            // redis开启事务
            $this->redis->multi();

            // 保存用户
            $userResult = $user->save($data);
            if (!$userResult) {
                throw new Exception('用户保存失败');
            }

            // 删除用户信息的缓存
            $this->redis->drdelete('user:' . $user['id']);

            // 提交事务
            $user->commit();
            $this->redis->exec();
            return $user;
        } catch (Exception $e) {
            $user->rollback();
            $this->redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    // 修改密码
    public function updatePassword($data)
    {
        // 用户是否存在
        $user = UserModel::find($data['id']);
        if (empty($user)) {
            throw new Miss('该用户不存在');
        }

        // 生成5个字符长度的盐
        $salt = salt(5);
        // 数据加入密码盐
        $data['password_salt'] = $salt;
        // 明文密码前后加盐，生成密码
        $data['password'] = md5($salt . $data['password'] . $salt);


        // 启动事务
        $user->startTrans();

        try {
            // redis开启事务
            $this->redis->multi();

            // 保存
            $result = $user->save($data);
            if (empty($result)) {
                throw new Fail('更新失败');
            }

            // 删除用户信息的缓存
            $this->redis->drdelete('user:' . $user['id']);

            // 提交事务
            $user->commit();
            $this->redis->exec();
        } catch (Exception $e) {
            $user->rollback();
            $this->redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    public function delete($id)
    {
        // 用户是否存在
        $user = UserModel::find($id);
        if (empty($user)) {
            throw new Miss('该用户不存在');
        }

        // 启动事务
        $user->startTrans();

        try {
            // redis开启事务
            $this->redis->multi();

            $result = $user->delete();
            if (!$result) {
                throw new Exception('用户删除失败');
            }

            // 删除用户信息的缓存
            $this->redis->drdelete('user:' . $user['id']);

            // 提交事务
            $user->commit();
            $this->redis->exec();
        } catch (Exception $e) {
            $user->rollback();
            $this->redis->discard();
            throw new Fail($e->getMessage());
        }
    }
}
