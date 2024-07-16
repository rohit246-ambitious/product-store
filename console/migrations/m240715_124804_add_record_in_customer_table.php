<?php

use yii\db\Migration;

/**
 * Class m240715_124804_add_record_in_customer_table
 */
class m240715_124804_add_record_in_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('customer', [
            'username' => 'rohit',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('rohit'),
            'password_reset_token' => NULL,
            'phone_no' => '7506970818',
            'email' => 'rohitmhatre578@gmail.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240715_124804_add_record_in_customer_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240715_124804_add_record_in_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
