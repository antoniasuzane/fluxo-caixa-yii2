<?php

use yii\db\Migration;

class m260204_133936_create_lancamento_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%lancamento}}', [
            'id' => $this->primaryKey(),
            'data' => $this->date()->notNull(),
            'descricao' => $this->string(255)->notNull(),
            'tipo' => "ENUM('entrada','saida') NOT NULL",
            'valor' => $this->decimal(10, 2)->notNull(),
            'forma_pagamento' => "ENUM('dinheiro','pix','cartao') NOT NULL",
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_lancamento_data', '{{%lancamento}}', 'data');
        $this->createIndex('idx_lancamento_tipo', '{{%lancamento}}', 'tipo');
    }

    public function safeDown()
    {
        $this->dropTable('{{%lancamento}}');
    }
}
