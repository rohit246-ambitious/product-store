<?php

use yii\db\Migration;

/**
 * Class m240713_192031_add_foreignkey_table_product_images
 */
class m240713_192031_add_foreignkey_table_product_images extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            '{{%idx-product_images-product_id}}',
            '{{%product_images}}',
            'product_id'
        );

        $this->addForeignKey('fk_product_images_product','product_images','product_id','product','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240713_192031_add_foreignkey_table_product_images cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240713_192031_add_foreignkey_table_product_images cannot be reverted.\n";

        return false;
    }
    */
}
