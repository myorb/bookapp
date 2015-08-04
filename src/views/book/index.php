<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php //\yii\widgets\Pjax::begin(['enablePushState'=>true]); ?>

    <?= GridView::widget([
        'id' => 'books',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'preview',
                'format' => 'html',    
                'value' => function ($data) {
                    return Html::a(
                     Html::img('/'. $data['preview'],['width' => '70px']),'#', 
                        [
                        'class' => 'myfancybox',
                        'title' => Yii::t('yii', 'Zoom'),
                        ]
                     );
                },
            ],
            'author.fullName',
            // 'status',
            'created_at',
            // 'updated_at',
            [   'class' => 'yii\grid\ActionColumn', 
                'template' => '{view} {update} {delete}',
                'headerOptions' => ['class' => 'activity-view-link',],        
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view','id'=>$key], [
                            'class' => 'activity-view-link',
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function($url, $model,$key){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['update','id'=>$key], [
                            'onclick' => Yii::$app->session->set('referrer', Yii::$app->request->url),
                            'target' => '_blank',
                            'class' => 'activity-update-link',
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]); 
                    },
                ],
            ],
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php //\yii\widgets\Pjax::end(); ?>

</div>

<?php $this->registerJs(
    "$('.activity-view-link').click(function(event) {
    event.preventDefault();
    $.get($(this).attr('href'),
        function (data) {
            $('.modal-body').html(data);
            $('#modal').modal();
        }  
    );
});
$('.myfancybox').click(function(event) {
    event.preventDefault();
    $('.modal-body').html($(this).find('img').width(250));
    $('#modal').modal();
});
    "
); ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>
