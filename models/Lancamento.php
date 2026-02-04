<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lancamento".
 *
 * @property int $id
 * @property string $data
 * @property string $descricao
 * @property string $tipo
 * @property float $valor
 * @property string $forma_pagamento
 * @property string|null $created_at
 */
class Lancamento extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TIPO_ENTRADA = 'entrada';
    const TIPO_SAIDA = 'saida';
    const FORMA_PAGAMENTO_DINHEIRO = 'dinheiro';
    const FORMA_PAGAMENTO_PIX = 'pix';
    const FORMA_PAGAMENTO_CARTAO = 'cartao';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lancamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'descricao', 'tipo', 'valor', 'forma_pagamento'], 'required'],
            [['data', 'created_at'], 'safe'],
            [['tipo', 'forma_pagamento'], 'string'],
            [['valor'], 'number'],
            [['descricao'], 'string', 'max' => 255],
            ['tipo', 'in', 'range' => array_keys(self::optsTipo())],
            ['forma_pagamento', 'in', 'range' => array_keys(self::optsFormaPagamento())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'descricao' => 'Descricao',
            'tipo' => 'Tipo',
            'valor' => 'Valor',
            'forma_pagamento' => 'Forma Pagamento',
            'created_at' => 'Created At',
        ];
    }


    /**
     * column tipo ENUM value labels
     * @return string[]
     */
    public static function optsTipo()
    {
        return [
            self::TIPO_ENTRADA => 'entrada',
            self::TIPO_SAIDA => 'saida',
        ];
    }

    /**
     * column forma_pagamento ENUM value labels
     * @return string[]
     */
    public static function optsFormaPagamento()
    {
        return [
            self::FORMA_PAGAMENTO_DINHEIRO => 'dinheiro',
            self::FORMA_PAGAMENTO_PIX => 'pix',
            self::FORMA_PAGAMENTO_CARTAO => 'cartao',
        ];
    }

    /**
     * @return string
     */
    public function displayTipo()
    {
        return self::optsTipo()[$this->tipo];
    }

    /**
     * @return bool
     */
    public function isTipoEntrada()
    {
        return $this->tipo === self::TIPO_ENTRADA;
    }

    public function setTipoToEntrada()
    {
        $this->tipo = self::TIPO_ENTRADA;
    }

    /**
     * @return bool
     */
    public function isTipoSaida()
    {
        return $this->tipo === self::TIPO_SAIDA;
    }

    public function setTipoToSaida()
    {
        $this->tipo = self::TIPO_SAIDA;
    }

    /**
     * @return string
     */
    public function displayFormaPagamento()
    {
        return self::optsFormaPagamento()[$this->forma_pagamento];
    }

    /**
     * @return bool
     */
    public function isFormaPagamentoDinheiro()
    {
        return $this->forma_pagamento === self::FORMA_PAGAMENTO_DINHEIRO;
    }

    public function setFormaPagamentoToDinheiro()
    {
        $this->forma_pagamento = self::FORMA_PAGAMENTO_DINHEIRO;
    }

    /**
     * @return bool
     */
    public function isFormaPagamentoPix()
    {
        return $this->forma_pagamento === self::FORMA_PAGAMENTO_PIX;
    }

    public function setFormaPagamentoToPix()
    {
        $this->forma_pagamento = self::FORMA_PAGAMENTO_PIX;
    }

    /**
     * @return bool
     */
    public function isFormaPagamentoCartao()
    {
        return $this->forma_pagamento === self::FORMA_PAGAMENTO_CARTAO;
    }

    public function setFormaPagamentoToCartao()
    {
        $this->forma_pagamento = self::FORMA_PAGAMENTO_CARTAO;
    }
}
