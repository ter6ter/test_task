<?php

namespace app\models;

use Codeception\PHPUnit\ResultPrinter\Report;
use Yii;

class User extends \yii\db\ActiveRecord
{

    public function getRepos()
    {
        return $this->hasMany(Repo::class, ['user_id' => 'id']);
    }

    public function rules()
    {
        return [
            [['username'], 'string', 'min' => 1, 'max' => 60],
            [['date_add'], 'integer']
        ];
    }

    public static function tableName()
    {
        return 'user';
    }

    public function updateRepos()
    {
        $repos = Yii::$app->githubApi->getRepos($this->username);
        if ($repos === false) {
            return false;
        } else {
            Repo::deleteAll(['user_id' => $this->id]);
            foreach ($repos as $data) {
                $this->addRepo($data);
            }
        }
    }

    public function addRepo($data)
    {
        $repo = new Repo();
        $repo->loadData($data);
        $repo->user_id = $this->id;
        $repo->save();
    }

    public function delete()
    {
        Repo::deleteAll(['user_id' => $this->id]);
        return parent::delete();
    }
}