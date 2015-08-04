<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Author;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'imageFile')->fileInput(); ?>
    <?php if ($model->preview): ?>
        <div class="form-group">
            <?= Html::img([$model->preview]) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'author_id')->dropDownList( ArrayHelper::map(Author::find()->all(), 'id', 'firstname')) ?>
    
    <?= $form->field($model, 'status')->checkBox(); ?>

    <?= $form->field($model, 'created_at')->widget(\yii\jui\DatePicker::classname(), ['dateFormat' => 'yyyy-MM-dd',]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
