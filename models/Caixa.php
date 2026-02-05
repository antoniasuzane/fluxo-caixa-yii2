<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class Caixa extends ActiveRecord
{
    public static function tableName()
    {
        return 'caixa';
    }

    public function rules()
    {
        return [
            [['data', 'saldo_inicial'], 'required'],
            [['data'], 'safe'],
            [['saldo_inicial', 'total_entradas', 'total_saidas', 'saldo_teorico', 'saldo_informado', 'diferenca'], 'number'],
            [['observacao'], 'string'],
            [['status'], 'in', 'range' => ['aberto', 'fechado']],
            [['data'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'data' => 'Data',
            'status' => 'Status',
            'saldo_inicial' => 'Caixa Inicial (R$)',
            'total_entradas' => 'Total Entradas (R$)',
            'total_saidas' => 'Total Saídas (R$)',
            'saldo_teorico' => 'Saldo Teórico (R$)',
            'saldo_informado' => 'Saldo Contado (R$)',
            'diferenca' => 'Diferença (R$)',
            'observacao' => 'Observação',
            'aberto_em' => 'Aberto em',
            'fechado_em' => 'Fechado em',
        ];
    }

    public function recalcularTotais()
    {
        $entradas = (float) (Lancamento::find()
            ->where(['tipo' => 'entrada', 'data' => $this->data])
            ->sum('valor') ?? 0);

        $saidas = (float) (Lancamento::find()
            ->where(['tipo' => 'saida', 'data' => $this->data])
            ->sum('valor') ?? 0);

        $this->total_entradas = $entradas;
        $this->total_saidas = $saidas;
        $this->saldo_teorico = (float)$this->saldo_inicial + $entradas - $saidas;
    }

    public function fechar($saldoInformado, $observacao = null)
    {
        $this->recalcularTotais();

        $this->saldo_informado = (float)$saldoInformado;
        $this->diferenca = (float)$this->saldo_informado - (float)$this->saldo_teorico;
        $this->status = 'fechado';
        $this->fechado_em = new Expression('NOW()');

        if ($observacao !== null) {
            $this->observacao = $observacao;
        }
    }

    public static function estaFechado($data): bool
    {
        $caixa = self::findOne(['data' => $data]);
        return $caixa && $caixa->status === 'fechado';
    }
}
