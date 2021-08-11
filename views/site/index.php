<?php

/* @var $this yii\web\View */

use yii\grid\GridView;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">
        Последние 10 репозиториев:

        <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'columns' => [
                ['attribute' => 'user.username', 'label' => 'Пользователь'],
                ['attribute' => 'name', 'label' => 'Репозиторий'],
                ['attribute' => 'description', 'label' => 'Description'],
                ['attribute' => 'updated_at', 'format' => ['date', 'php:Y-m-d H:i:s'], 'label' => 'Добавлен'],
            ]
        ]);?>

    </div>
</div>
