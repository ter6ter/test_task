<?php

namespace app\controllers;

use app\models\Repo;
use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Repo::find()
                ->innerJoin('user', 'user.id = repo.user_id')
                ->orderBy(['updated_at' => SORT_DESC]),
            'totalCount' => 10,
            'sort' => false,
        ]);
        return $this->render('index',
            [ 'dataProvider' => $dataProvider]);
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionUsers()
    {
        $user = new User();

        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            if (User::find()->where(['username' => $user->username])->count()) {
                $user->addError('username', 'Этот пользователь уже добавлен');
            } elseif (!Yii::$app->githubApi->getUser($user->username)) {
                $user->addError('username', 'Такой пользователь не найден');
            } else {
                $user->save();
                $user->updateRepos();
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);
        return $this->render('users',
            [ 'dataProvider' => $dataProvider,
              'model' => $user]);
    }

    public function actionDelete()
    {
        $user = User::findOne(Yii::$app->request->queryParams['id']);
        if ($user) {
            $user->delete();
        }
        $this->redirect(['/site/users']);
}
}
