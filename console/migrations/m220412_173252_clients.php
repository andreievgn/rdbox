<?php

use yii\db\Migration;

/**
 * Class m220412_173252_clients
 */
class m220412_173252_clients extends Migration
{
    /**
     * {@inheritdoc}
     */
    const TABLE = '{{%client}}';

    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id'       => $this->bigPrimaryKey(),
            'name'     => $this->string(255),
            'phone'    => $this->string(255),
            
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220412_173252_clients cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220412_173252_clients cannot be reverted.\n";

        return false;
    }
    */
}
