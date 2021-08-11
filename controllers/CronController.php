<?php

namespace app\controllers;
use app\models\User;
use yii\console\Controller;

class CronController extends Controller
{
    public function actionIndex()
    {
        echo "Yes, cron service is running.";
    }

    public function actionUpdate()
    {
        foreach (User::find()->all() as $user) {
            $user->updateRepos();
        }
    }
}