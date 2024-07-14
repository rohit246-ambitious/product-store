<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'price',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function($model){
                    $webPath = str_replace(Yii::getAlias('@webroot'), '', $model->image);
                    $url = Yii::getAlias('@web') . $webPath;
                    return Html::img($url, ['width' => '200px','height' => '100px']);
                }
            ],
            [
                'attribute' => 'product images',
                'format' => 'html',
                'value' => function($model){
                    $images = '';
                    foreach ($model->productImages as $productImage) {
                        $webPath = str_replace(Yii::getAlias('@webroot'), '', $productImage->image);
                        $url = Yii::getAlias('@web') . $webPath;
                        $images .= Html::img($url, ['width' => '200px', 'height' => '100px']) . ' ';
                    }
                    return $images;
                }
            ],
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ],
    ]) ?>



</div>
