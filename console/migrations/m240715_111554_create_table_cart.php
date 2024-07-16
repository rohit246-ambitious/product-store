<?php

use yii\db\Migration;

/**
 * Class m240715_111554_create_table_cart
 */
class m240715_111554_create_table_cart extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'phone_no' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_cart_product','cart','product_id','product','id','CASCADE');
        $this->addForeignKey('fk_cart_customer','cart','customer_id','customer','id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240715_111554_create_table_cart cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240715_111554_create_table_cart cannot be reverted.\n";

        return false;
    }
    */
}
