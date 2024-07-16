<?php

use common\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Carts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Cart', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'product_id',
            [
                'attribute'=>'product_id',
                'label' => 'Product Image',
                'format' => 'html',
                'value' => function($model){
                    $product = $model->product;
                    $webPath = str_replace(Yii::getAlias('@webroot'), '', $product->image);
                    $url = Yii::getAlias('@web') . $webPath;
                    return Html::img($url, ['width' => '200px','height' => '100px']);
                }
            ],
            [
                'attribute'=>'product_id',
                'label' => 'Product Name',
                'format' => 'html',
                'value' => function($model){
                    $product = $model->product;
                    $name = $product->name;
                    return '<div><strong>'.$name.'</storng></div>';
                }
            ],
            'customer_id',
            'quantity',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
                'urlCreator' => function ($action, Cart $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
