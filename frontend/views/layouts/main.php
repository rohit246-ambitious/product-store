<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/product/index']],
        // ['label' => 'About', 'url' => ['/site/about']],
        // ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    echo '<div class="btn btn-link cart-button"><i class="bi bi-cart"></i></div>';
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>

        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-slideout modal-md right">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Cart content will be loaded here via Ajax -->
                        <div id="cart-content">
                          
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row w-100">
                            <div class="col-6">
                                <span class="total-price"></span>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="#" class="btn btn-primary" id="checkout-btn">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php
$this->registerJs("
$('.cart-button').on('click',function(){
    $.ajax({
        url:'".Yii::$app->urlManager->createAbsoluteUrl(['site/open-cart'])."',
        type:'get',
        success:function(response){
            var parsedResponse = JSON.parse(response);
            if(parsedResponse.status){
                var data = parsedResponse.data;
                var totalPrice = parsedResponse.cartTotalPrice;
                $('#cart-content').empty();
                data.forEach(function (item) {
                    var cartItemHtml = '<div class=\"cart-item\" style=\"border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;\">' +
                    '<img src=\"' + item.image + '\" alt=\"' + item.name + '\" class=\"cart-item-image\">' +
                    '<div class=\"cart-item-details\">' +
                    '<h5 class=\"cart-item-name\">' + item.name + '</h5>' +
                    '<p class=\"cart-item-quantity\">Quantity: ' + item.quantity + '</p>' +
                    '<p class=\"cart-item-price\">Price: ₹' + (item.price * item.quantity) + '</p>' +
                    '</div>' +
                    '</div>';

                    $('#cart-content').append(cartItemHtml);
                });
                $('.total-price').html('<strong>Total Price: ₹' + totalPrice + '</strong>');
                $('#checkout-btn').removeClass('disabled');
                $('#cartModal').modal('show');
            }else{
                $('#cart-content').text('Your cart is empty');
                $('#checkout-btn').addClass('disabled');
                $('#cartModal').modal('show');
            }
        }

    });
});

", View::POS_READY);

$this->registerCss("
#cartModal .modal-body {
    overflow-y: auto; 
    max-height: 60vh; 
}

#cartModal .modal-body img {
    max-width: 100%; 
    height: auto; 
    display: block; 
    margin: 0 auto; 
}

.modal-dialog-slideout.modal-md.right {
    right: 0;
    top: 0;
    margin-right: 0;
}

")
?>

<?php $this->endPage();
