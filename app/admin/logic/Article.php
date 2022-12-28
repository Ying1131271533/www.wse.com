<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Article as ArticleModel;
use Exception;

class Article
{
    public static function saveArticle($data)
    {
        $Article = new ArticleModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $Article = $Article->find($id);
            if (empty($Article)) {
                throw new Miss('该文章不存在！');
            }
        }

        $result = $Article->save($data);
        if (empty($result)) {
            throw new Fail('保存失败');
        }
        return $Article;
    }

    // 获取文章列表
    public static function getArticleList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['usernameReload']) and $where[] = ['username', 'like', "%{$data['usernameReload']}%"];
        return $this->adminModel->getAdminList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        $Article = ArticleModel::with('admins')->find($id);
        if (empty($Article)) {
            throw new Miss();
        }

        // 开启事务
        $Article->startTrans();
        try {

            // 删除管理员中间表数据
            if (!$Article['admins']->isEmpty()) {
                $adminsResult = $Article->admins()->detach();
                if (!$adminsResult) {
                    throw new Exception('管理员中间表数据删除失败');
                }
            }

            // 删除节点中间表数据
            if (!$Article['nodes']->isEmpty()) {
                $nodesResult = $Article->nodes()->detach();
                if (!$nodesResult) {
                    throw new Exception('节点中间表数据删除失败');
                }

            }

            $result = $Article->delete();
            if (!$result) {
                throw new Exception('文章删除失败');
            }

            $Article->commit();
        } catch (Exception $e) {
            $Article->rollback();
            throw new Fail($e->getMessage());
        }
    }

    public static function saveAuth($data)
    {
        $Article = ArticleModel::with('nodes')->find($data['id']);
        if (empty($Article)) {
            throw new Miss();
        }

        // 开启事务
        $Article->startTrans();
        try {

            // 删除旧的节点中间表数据
            if (!$Article['nodes']->isEmpty()) {
                $nodesResult = $Article->nodes()->detach();
                if (!$nodesResult) {
                    throw new Exception('原来的节点中间表数据删除失败');
                }

            }

            // 如果有节点权限，则保存
            if (!empty($data['checkData'])) {
                $ids        = get_key_cloumn('id', $data['checkData']);
                $saveResult = $Article->nodes()->saveAll($ids);
                if (!$saveResult) {
                    throw new Exception('节点保存失败');
                }

            }

            $Article->commit();
        } catch (Exception $e) {
            $Article->rollback();
            throw new Fail($e->getMessage());
        }

    }

    public static function getCheckedNode($id)
    {
        // 获取文章
        $Article = ArticleModel::with('nodes')->find($id);
        if (empty($Article)) {
            throw new Miss('找不到该文章！');
        }

        $checkedNode = [];
        if (!$Article['nodes']->isEmpty()) {
            $nodes       = $Article['nodes']->toArray();
            $checkedNode = $nodes;
            foreach ($nodes as $key => $value) {
                foreach ($nodes as $k => $val) {
                    if ($value['id'] == $val['parent_id']) {
                        unset($checkedNode[$key]);
                        continue;
                    }
                }
            }
        }
        return array_column($checkedNode, 'id');
    }
}
