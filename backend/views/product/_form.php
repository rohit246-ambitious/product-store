<?php

use common\models\Product;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('Name') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('Price') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'imageFile')->fileInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('Display Image') ?>
        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Product Images') ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'status')->dropdownList(Product::$statuses, ['class' => 'form-control form-control-sm', 'prompt' => 'Set status'])->label('Status') ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>