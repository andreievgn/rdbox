<?php

use yii\db\Migration;

/**
 * Class m220412_201407_order
 */
class m220412_201407_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    const TABLE = '{{%order}}';

    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id'       => $this->bigPrimaryKey(),
            'client_id' => $this->integer(),
            'price'     => $this->string(255),
            'discount_price'    => $this->string(255),
            'url_qrcode'    => $this->string(255),
            'url_activate'  => $this->string(255),
            'visit' => $this->boolean()->defaultValue(false),
            
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220412_201407_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220412_201407_order cannot be reverted.\n";

        return false;
    }
    */
}
