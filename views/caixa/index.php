<?php
use yii\helpers\Html;

$this->title = '🧾 Caixas';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="mb-3">
    <?= Html::a('➕ Abrir Caixa de Hoje', ['abrir'], ['class' => 'btn btn-success']) ?>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Data</th>
            <th>Status</th>
            <th>Inicial</th>
            <th>Entradas</th>
            <th>Saídas</th>
            <th>Teórico</th>
            <th>Contado</th>
            <th>Diferença</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($caixas as $c): ?>
        <tr>
            <td><?= Html::encode(date('d/m/Y', strtotime($c->data))) ?></td>
            <td><strong><?= Html::encode($c->status) ?></strong></td>
            <td>R$ <?= number_format($c->saldo_inicial, 2, ',', '.') ?></td>
            <td>R$ <?= number_format($c->total_entradas, 2, ',', '.') ?></td>
            <td>R$ <?= number_format($c->total_saidas, 2, ',', '.') ?></td>
            <td>R$ <?= number_format($c->saldo_teorico, 2, ',', '.') ?></td>
            <td><?= $c->saldo_informado === null ? '-' : 'R$ ' . number_format($c->saldo_informado, 2, ',', '.') ?></td>
            <td><?= $c->diferenca === null ? '-' : 'R$ ' . number_format($c->diferenca, 2, ',', '.') ?></td>
            <td>
                <?= Html::a('Ver', ['ver', 'id' => $c->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                <?php if ($c->status === 'aberto'): ?>
                    <?= Html::a('Fechar', ['fechar', 'id' => $c->id], ['class' => 'btn btn-sm btn-outline-danger ms-1']) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
