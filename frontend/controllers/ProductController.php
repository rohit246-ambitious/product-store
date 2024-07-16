<?php

namespace frontend\controllers;

use Yii;
use common\models\Cart;
use common\models\Product;

class ProductController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $products = Product::find()->all();
        return $this->render('index', ['products' => $products]);
    }

    public function actionView($id){
        $product = Product::findOne($id);
        return $this->render('view', ['product' => $product]);
    }

    public function actionAddCart($id){

        $response = [
            'status' => 0,
            'message' => 'Product not found',
        ];

        if(Yii::$app->request->post()){
            $product = Product::findOne($id);
            $quantity = Yii::$app->request->post('quantity');
            $cartModel = new Cart();
            $cartModel->product_id = $product->id;
            $cartModel->customer_id = "1";
            $cartModel->quantity = $quantity;
            if($cartModel->save()){
                $response = [
                    'status' => 1,
                    'message' => 'Product added to cart',
                ];
            }else{
                $response = [
                    'status' => 1,
                    'message' => 'something went wrong',
                ];
                
            }
        }

        return json_encode($response);

    }

}
