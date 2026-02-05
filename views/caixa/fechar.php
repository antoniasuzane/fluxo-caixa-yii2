<?php
use yii\helpers\Html;

$this->title = '✅ Fechar Caixa ' . date('d/m/Y', strtotime($model->data));
?>

<h1><?= Html::encode($this->title) ?></h1>

<p class="text-muted">Confira os valores do dia e informe o saldo contado.</p>

<table class="table table-bordered">
    <tr><th>Caixa Inicial</th><td>R$ <?= number_format($model->saldo_inicial, 2, ',', '.') ?></td></tr>
    <tr><th>Entradas</th><td style="color:green;font-weight:700">R$ <?= number_format($model->total_entradas, 2, ',', '.') ?></td></tr>
    <tr><th>Saídas</th><td style="color:red;font-weight:700">R$ <?= number_format($model->total_saidas, 2, ',', '.') ?></td></tr>
    <tr><th>Saldo Teórico</th><td><strong>R$ <?= number_format($model->saldo_teorico, 2, ',', '.') ?></strong></td></tr>
</table>

<form method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">

    <div class="mb-3">
        <label class="form-label">Saldo contado (R$)</label>
        <input type="number" step="0.01" name="saldo_informado" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Observação (opcional)</label>
        <textarea name="observacao" class="form-control" rows="3"></textarea>
    </div>

    <button class="btn btn-danger">Fechar Caixa</button>
    <?= Html::a('Cancelar', ['ver', 'id' => $model->id], ['class' => 'btn btn-secondary ms-2']) ?>
</form>
