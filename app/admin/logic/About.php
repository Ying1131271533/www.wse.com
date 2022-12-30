<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\About as AboutModel;
use Exception;

class About
{
    public static function saveAbout($data)
    {
        $about = new AboutModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $about = $about->find($id);
            if (empty($about)) {
                throw new Miss('该文章不存在！');
            }
        }

        // 启动事务
        $about->startTrans();

        try {

            // 保存文章
            $adminResult = $about->save($data);
            if (!$adminResult) throw new Exception('文章保存失败');

            // 保存中间表数据
            $result = $about->desc()->save($data);
            if (!$result) throw new Exception('保存文章内容关联数据失败');

            // 提交事务
            $about->commit();
            return $about;
        } catch (Exception $e) {
            $about->rollback();
            throw new Fail($e->getMessage());
        }
    }

    // 获取文章列表
    public static function getAboutList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return AboutModel::getAboutList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        // 找到文章
        $about = AboutModel::with('desc')->find($id);
        if (empty($about)) throw new Miss();

        // 开启事务
        $about->startTrans();
        try {
            // 删除文章
            $result = $about->together(['desc'])->delete();
            if (!$result) throw new Exception('文章删除失败');
            $about->commit();
        } catch (Exception $e) {
            $about->rollback();
            throw new Fail($e->getMessage());
        }
    }

}
