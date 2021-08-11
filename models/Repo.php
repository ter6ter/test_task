<?php

namespace app\models;

class Repo extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['updated_at'], 'required'],
            [['user_id'], 'integer']
        ];
    }

    public static function tableName()
    {
        return 'repo';
    }

    public function loadData($data)
    {
        foreach (['name', 'description', 'updated_at'] as $field) {
            $this->$field = $data->$field ?? '';
        }
        $this->updated_at = date('Y-m-d H:i:s', strtotime($this->updated_at));
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}