<?php

use evgeniyrru\yii2slick\Slick;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\web\View;
use yii\helpers\Html;
/** @var yii\web\View $this */

$allProductImages = [];

$allProductImages[] =  Html::img(Yii::$app->params['backendUrl'].'/' . $product->image, ['class' => 'slick-img']); 

foreach ($product->productImages as $productImage) {
    $url = Yii::$app->params['backendUrl'].'/' . $productImage->image; 
    $allProductImages[] = Html::img($url, ['class' => 'slick-img']);
}

//echo "<pre>";print_r($allProductImages);exit;

?>
<div class="product-view-container">
    <div class = "row no-gutters">
        <div class = "col-md-7">
            <div class="product-image">
                <div class = "row ">
                    <div class = "col-md-12">
                        <?=Slick::widget([
                            'itemContainer' => 'div',

                            'containerOptions' => ['class' => 'product-image-container'],

                            'items' => $allProductImages,

                            'itemOptions' => ['class' => 'product-images'],

                            'clientOptions' => [
                                'dots' => true,
                                'infinite' => true,
                                'autoplay' => true,
                                'speed' => 200,
                                'slidesToShow' => 1,
                            ],

                        ]);?>
                    </div>
                    
                    <div class = "col-md-12">
                        <?=Slick::widget([
                            'itemContainer' => 'div',

                            'containerOptions' => ['class' => 'thumbnail-image-container'],

                            'items' => $allProductImages,

                            'itemOptions' => ['class' => 'thumbnail-images'],

                            'clientOptions' => [
                                'dots' => false,
                                'infinite' => true,
                                'autoplay' => true,
                                'speed' => 200,
                                'slidesToShow' => 3, // Show 3 images at a time
                                'slidesToScroll' => 1,
                            ],

                        ]);?>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class = "col-md-5">
            <div class="product-name"><?= Html::encode($product->name) ?></div>
       
            <div class="product-price">₹<?= Html::encode($product->price) ?></div>
            <div class="row">
                <div class = "col-md-3">
                    <?= Html::input('number', 'addQuantity', 1, ['class' => 'form-control form-control-sm', 'min' => 1, 'id' => 'addQuantity']) ?>
                </div>
                <div class = "col-md-3">
                    <button type="button" class="btn btn-success btn-sm " data-product-id="<?= Html::encode($product->id) ?>" id="addToCart">Add To Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>



<?php 
$this->registerCss("
.product-view-container {
    padding: 20px;
}

.product-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.product-price {
    font-size: 20px;
    color: #d9534f;
    margin-bottom: 20px;
}

.card-img-top, .thumbnail-img {
    width: 100%;
    height: auto;
    object-fit: cover;
    margin-bottom: 15px;
}

.thumbnail-images {
    padding: 1px 7px 1px 7px; /* Add padding to the left and right of each thumbnail image */
}

.slick-img {
    height: 400px; /* Fixed height for Slick images */
    //width: auto; /* Maintain aspect ratio */
    object-fit: cover; /* Ensures the image covers the container while maintaining aspect ratio */
}

.thumbnail-images .slick-img {
    height: 50px;
    width: auto;
}
.product-image-container {
    max-height: 400px; /* Ensure the container height matches the image height */
}

.thumbnail-image-container {
    max-height: 100px; /* Ensure the container height matches the image height */
}
");

$this->registerJs("

    $('#addToCart').on('click',function(){
        var productId = $(this).attr('data-product-id');
        var quantity = $('#addQuantity').val();
        $.ajax({
            type:'post',
            url:'".Yii::$app->urlManager->createAbsoluteUrl(['product/add-cart', 'id' => $product->id])."',
            data:{productId: productId , quantity: quantity},
            beforeSend: function(){
                $(this).prop('disabled', true);
            },
            success: function(response){
                var parsedResponse = JSON.parse(response);
                if(parsedResponse.status) {
                    //rcSnackbar(parsedResponse.message, {'classes':'snackbar snackbar-success'});
                    alert(parsedResponse.message);
                }else{
                    //rcSnackbar(parsedResponse.message, {'classes':'snackbar snackbar-error'});
                    alert(parsedResponse.message);
                }
            },
            error: function(response){
                if(response.status == 404 || response.status == 500 ){
                    rcSnackbar(response.statusText, {'classes':'snackbar snackbar-error'});
                }
            },
            complete: function(){
                $(this).prop('disabled', false);
            },
        });
    });
")



?>