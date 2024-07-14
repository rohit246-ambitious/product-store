<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string|null $image
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProductImages[] $productImages
 */
class Product extends \yii\db\ActiveRecord
{


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_DELETED = 5;

    public static $statuses = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DELETED => 'Deleted',
    ];

    public $imageFile; // Single image file attribute
    public $imageFiles; // Multiple image files attribute

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
			BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'image' => 'Image',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::class, ['product_id' => 'id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {
                $filePath = 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                if ($this->imageFile->saveAs($filePath)) {
                    $this->image = $filePath; // Save main image path to the 'image' column
                }
              
            }

            if ($this->imageFiles) {
                foreach ($this->imageFiles as $file) {
                    $filePath = 'uploads/' . $file->baseName . '.' . $file->extension;
                    if ($file->saveAs($filePath)) {
                        $productImage = new ProductImages();
                        $productImage->product_id = $this->id;
                        $productImage->image = $filePath;
                        $productImage->save();
                    }
                }
            }

            return true;
        }

        return false;
    }
}
