<?php

use yii\helpers\Html;

$this->title = '📊 Resumo do Caixa';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- FILTRO DE DATA + PERÍODO -->
<div class="row mb-4">
    <div class="col-md-6">
        <?= Html::label('Data base', 'data-base', ['class' => 'form-label']) ?>

        <form class="d-flex gap-2" method="get">
            <input type="hidden" name="r" value="dashboard/index">
            <input type="hidden" name="periodo" value="<?= Html::encode($periodo) ?>">

            <input
                id="data-base"
                type="date"
                name="data"
                class="form-control"
                value="<?= Html::encode($data) ?>"
            >

            <button class="btn btn-outline-dark" type="submit">
                Aplicar
            </button>
        </form>

        <small class="text-muted">
            No modo mensal, considera todo o mês da data escolhida.
        </small>
    </div>

    <div class="col-md-6 d-flex align-items-end justify-content-md-end mt-3 mt-md-0">
        <div class="btn-group">
            <?= Html::a(
                '📅 Diário',
                ['index', 'periodo' => 'diario', 'data' => $data],
                ['class' => 'btn btn-outline-primary ' . ($periodo === 'diario' ? 'active' : '')]
            ) ?>

            <?= Html::a(
                '📆 Mensal',
                ['index', 'periodo' => 'mensal', 'data' => $data],
                ['class' => 'btn btn-outline-secondary ' . ($periodo === 'mensal' ? 'active' : '')]
            ) ?>
        </div>
    </div>
</div>

<p>
    <strong><?= Html::encode($tituloPeriodo) ?></strong>
</p>

<!-- CARDS RESUMO -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted">Entradas</div>
                <div style="color:green; font-weight:800; font-size:22px;">
                    R$ <?= number_format($totalEntradas, 2, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted">Saídas</div>
                <div style="color:red; font-weight:800; font-size:22px;">
                    R$ <?= number_format($totalSaidas, 2, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted">Saldo do período</div>
                <div style="font-weight:900; font-size:22px;">
                    R$ <?= number_format($saldoPeriodo, 2, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-dark">
            <div class="card-body">
                <div class="text-muted">
                    Saldo acumulado até <?= date('d/m/Y', strtotime($fim)) ?>
                </div>
                <div style="font-weight:900; font-size:22px;">
                    R$ <?= number_format($saldoAcumulado, 2, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ÚLTIMOS LANÇAMENTOS -->
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Últimos lançamentos do período</strong>
        <?= Html::a('Ver todos', ['/lancamento/index'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
    </div>

    <div class="card-body p-0">
        <?php if (empty($ultimosLancamentos)): ?>
            <div class="p-3">
                <em>Nenhum lançamento encontrado para este período.</em>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 140px;">Data</th>
                            <th>Descrição</th>
                            <th style="width: 120px;">Tipo</th>
                            <th style="width: 160px;" class="text-end">Valor</th>
                            <th style="width: 180px;">Pagamento</th>
                            <th style="width: 140px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ultimosLancamentos as $l): ?>
                            <?php
                                $isEntrada = $l->tipo === 'entrada';
                                $tipoLabel = $isEntrada ? 'Entrada' : 'Saída';
                                $tipoStyle = $isEntrada
                                    ? 'color: green; font-weight:700;'
                                    : 'color: red; font-weight:700;';
                            ?>
                            <tr>
                                <td><?= Html::encode(date('d/m/Y', strtotime($l->data))) ?></td>
                                <td><?= Html::encode($l->descricao) ?></td>
                                <td style="<?= $tipoStyle ?>"><?= Html::encode($tipoLabel) ?></td>
                                <td class="text-end" style="<?= $tipoStyle ?>">
                                    R$ <?= number_format($l->valor, 2, ',', '.') ?>
                                </td>
                                <td><?= Html::encode($l->forma_pagamento) ?></td>
                                <td>
                                    <?= Html::a('Ver', ['/lancamento/view', 'id' => $l->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                    <?= Html::a('Editar', ['/lancamento/update', 'id' => $l->id], ['class' => 'btn btn-sm btn-outline-dark ms-1']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- AÇÕES -->
<div class="mt-4 d-flex gap-2">
    <?= Html::a('➕ Novo Lançamento', ['/lancamento/create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('📋 Ver Lançamentos', ['/lancamento/index'], ['class' => 'btn btn-primary']) ?>
</div>
