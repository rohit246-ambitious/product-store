<?php

use yii\db\Migration;

/**
 * Class m240713_145248_add_record_in_user_table
 */
class m240713_145248_add_record_in_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'rohit',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('rohit'),
            'password_reset_token' => NULL,
            'email' => 'rohit.mhatre@redplanner.travel',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240713_145248_add_record_in_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240713_145248_add_record_in_user_table cannot be reverted.\n";

        return false;
    }
    */
}
