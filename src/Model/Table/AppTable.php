<?php

/**
 * 
 * Appテーブル
 *
 * @author schiba
 * @since  20190710
 *
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class AppTable extends Table
{

    // whereで単一検索
    public function getData($where, $deleteFlg = DELETE_FLG_DISABLE) {
        $where['delete_flg'] = $deleteFlg;
        $data = $this->find()
            ->where($where)
            ->first();
        return $data;
    }

    // whereで複数検索
    public function getList($where, $limit, $deleteFlg = DELETE_FLG_DISABLE) {
        $where['delete_flg'] = $deleteFlg;
        $list = $this->find()
            ->where($where)
            ->limit($limit);
        return $list;
    }

    // whereでorder desc検索
    public function getListOrderDesc($where, $limit, $deleteFlg = DELETE_FLG_DISABLE) {
        $where['delete_flg'] = $deleteFlg;
        $list = $this->find()
            ->where($where)
            ->limit($limit)
            ->order(["id" => "desc"]);
        return $list;
    }

    // 新着データ
    public function getNewListOrderDesc($limit, $deleteFlg = DELETE_FLG_DISABLE, $page = 1, $where = null) {
        $where['delete_flg'] = $deleteFlg;
        $list = $this->find()
            ->where($where)
            ->limit($limit)
            ->page($page)
            ->order(["id" => "desc"]);
        return $list;
    }

    /* insert 
        array(["v1"] => "A", ["v2"] => "B");
    */
    public function setData(array $data, $deleteFlg = DELETE_FLG_DISABLE) {
        //create, update, deleteの追加
        $now = date('Y-m-d H:i:s');
        $data["create_time"] = $now;
        $data["update_time"] = $now;
        $data["delete_flg"] = $deleteFlg;
        // insert
        $user = $this->newEntity($data);
        if ($this->save($user)->hasErrors()) {
            $this->log('レコードのINSERTに失敗', LOG_ERR);
            return false;
        }
        // insertしたidを返却
        return $user->id;
    }

    public function updateData($id, $data){
        $now = date('Y-m-d H:i:s');
        $data["update_time"] = $now;
        return $this->query()->update()
          ->set($data)
          ->where(['id' => $id])
          ->execute();
    } 

    public function deleteData($id){
        $entity = $this->get($id);
        return $this->delete($entity);
    }

}
