<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'image',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function($model){
                    $webPath = str_replace(Yii::getAlias('@webroot'), '', $model->image);
                    $url = Yii::getAlias('@web') . $webPath;
                    return Html::img($url, ['width' => '200px','height' => '100px']);
                }
            ],
            'name',
            'price',
            
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function($data){
                    switch($data->status){
                        case Product::STATUS_INACTIVE:
                            return '<span class="label label-danger">InActive</span>';
                            break;
                        case Product::STATUS_DELETED:
                            return '<span class="label label-default">Deleted</span>';
                            break;
                        case Product::STATUS_ACTIVE:
                            return '<span class="label label-success">Active</span>';
                            break;
                    }
                }
            ],
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
