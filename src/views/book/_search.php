<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Author;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">
<div class="row">
  
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'name') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'author_id')->dropDownList( ArrayHelper::map(Author::find()->all(), 'id', 'firstname'),['prompt'=>'Empty string']) ?>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <?php  echo $form->field($model, 'min_date')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
    </div>
    <div class="col-md-2">
        <?php  echo $form->field($model, 'max_date')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
    </div>
    <div class="col-md-2 col-md-offset-2">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>
</div>
</div>
