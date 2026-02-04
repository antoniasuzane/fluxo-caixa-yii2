<?php

use yii\helpers\Html;

$this->title = '📊 Resumo do Caixa';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="mb-3">
    <?= Html::a('📅 Diário', ['index', 'periodo' => 'diario', 'data' => $data],
        ['class' => 'btn btn-outline-primary ' . ($periodo === 'diario' ? 'active' : '')]) ?>

    <?= Html::a('📆 Mensal', ['index', 'periodo' => 'mensal', 'data' => $data],
        ['class' => 'btn btn-outline-secondary ' . ($periodo === 'mensal' ? 'active' : '')]) ?>
</div>

<p><strong><?= Html::encode($tituloPeriodo) ?></strong></p>

<table class="table table-bordered">
    <tr>
        <th>Total de Entradas</th>
        <td style="color:green; font-weight:600">
            R$ <?= number_format($totalEntradas, 2, ',', '.') ?>
        </td>
    </tr>
    <tr>
        <th>Total de Saídas</th>
        <td style="color:red; font-weight:600">
            R$ <?= number_format($totalSaidas, 2, ',', '.') ?>
        </td>
    </tr>
    <tr>
        <th>Saldo do Período</th>
        <td style="font-weight:700">
            R$ <?= number_format($saldoPeriodo, 2, ',', '.') ?>
        </td>
    </tr>
</table>

<div class="mt-3">
    <?= Html::a('➕ Novo Lançamento', ['/lancamento/create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('📋 Ver Lançamentos', ['/lancamento/index'], ['class' => 'btn btn-primary ms-2']) ?>
</div>
