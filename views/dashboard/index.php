<?php
use yii\helpers\Html;

$this->title = '📊 Resumo do Caixa';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row mb-3">
    <div class="col-md-6">
        <?= Html::label('Data base', 'data-base', ['class' => 'form-label']) ?>
        <form class="d-flex gap-2" method="get">
            <input type="hidden" name="r" value="dashboard/index">
            <input type="hidden" name="periodo" value="<?= Html::encode($periodo) ?>">

            <input id="data-base" type="date" name="data" class="form-control" value="<?= Html::encode($data) ?>">
            <button class="btn btn-outline-dark" type="submit">Aplicar</button>
        </form>
        <small class="text-muted">No modo mensal, usa o mês da data escolhida.</small>
    </div>

    <div class="col-md-6 d-flex align-items-end justify-content-md-end mt-3 mt-md-0">
        <div class="btn-group">
            <?= Html::a('📅 Diário', ['index', 'periodo' => 'diario', 'data' => $data],
                ['class' => 'btn btn-outline-primary ' . ($periodo === 'diario' ? 'active' : '')]) ?>

            <?= Html::a('📆 Mensal', ['index', 'periodo' => 'mensal', 'data' => $data],
                ['class' => 'btn btn-outline-secondary ' . ($periodo === 'mensal' ? 'active' : '')]) ?>
        </div>
    </div>
</div>

<p><strong><?= Html::encode($tituloPeriodo) ?></strong></p>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-muted">Entradas</div>
                <div style="color:green; font-weight:800; font-size:22px;">
                    R$ <?= number_format($totalEntradas, 2, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-muted">Saídas</div>
                <div style="color:red; font-weight:800; font-size:22px;">
                    R$ <?= number_format($totalSaidas, 2, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="text-muted">Saldo do período</div>
                <div style="font-weight:900; font-size:22px;">
                    R$ <?= number_format($saldoPeriodo, 2, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <?= Html::a('➕ Novo Lançamento', ['/lancamento/create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('📋 Ver Lançamentos', ['/lancamento/index'], ['class' => 'btn btn-primary']) ?>
</div>
