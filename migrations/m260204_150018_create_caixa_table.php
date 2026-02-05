<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%caixa}}`.
 */
class m260204_150018_create_caixa_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%caixa}}', [
            'id' => $this->primaryKey(),
            'data' => $this->date()->notNull()->unique(),
            'status' => $this->string(10)->notNull()->defaultValue('aberto'),

            'saldo_inicial' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'total_entradas' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'total_saidas' => $this->decimal(10, 2)->notNull()->defaultValue(0),
            'saldo_teorico' => $this->decimal(10, 2)->notNull()->defaultValue(0),

            'saldo_informado' => $this->decimal(10, 2)->null(),
            'diferenca' => $this->decimal(10, 2)->null(),

            'observacao' => $this->text()->null(),
            'aberto_em' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'fechado_em' => $this->dateTime()->null(),
        ]);

        $this->createIndex('idx_caixa_data', '{{%caixa}}', 'data');
    }

    public function safeDown()
    {
        $this->dropTable('{{%caixa}}');
    }
}
