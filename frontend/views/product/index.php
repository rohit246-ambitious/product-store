<?php

use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\web\View;
use yii\helpers\Html;
/** @var yii\web\View $this */
?>
<div class="product-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <?php foreach ($products as $product){?>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <?php  
                        $url = Yii::$app->params['backendUrl'].'/' . $product->image; 
                    ?>
                    <img class="card-img-top" src="<?= $url ?>" alt="<?= Html::encode($product->name) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($product->name) ?></h5>
                        <p class="card-text">₹<?= Html::encode($product->price) ?></p>
                        <a href="<?= Html::encode(Yii::$app->urlManager->createAbsoluteUrl(['product/view', 'id' => $product->id])); ?>" class="btn btn-primary">View Product</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php $this->registerCss(" 
.card {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: 0.3s;
    border: none;
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
"); 
?>
