<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h2>Список пользователей, репозитории которых отслеживаются</h2>
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],
        'columns' => [
            ['attribute' => 'username', 'label' => 'Имя'],
            ['attribute' => 'date_add', 'format' => ['date', 'php:Y-m-d H:i:s'], 'label' => 'Добавлен'],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}',],
        ]
    ]);?>
    <?php $form=ActiveForm::begin(
            ['layout' => 'horizontal',
             'options'=>['class' => 'form-horizontal']]);?>
    <?=$form->errorSummary($model)?>
    <div class="row">
        <div class="col-sm-8">
    <?= $form->field($model, 'username')
            ->textInput(['minlength' => 1, 'maxlength' => 39, 'style'=>'width:400px'])
            ->label('Имя пользователя'); ?>
        </div>
        <div class="col-sm-4">
    <?= Html::submitButton('Добавить пользователя',
        ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
