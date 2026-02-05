<?php
use yii\helpers\Html;

$this->title = '📌 Caixa ' . date('d/m/Y', strtotime($model->data));
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Status:</strong> <?= Html::encode($model->status) ?></p>

<table class="table table-bordered">
    <tr><th>Caixa Inicial</th><td>R$ <?= number_format($model->saldo_inicial, 2, ',', '.') ?></td></tr>
    <tr><th>Entradas</th><td style="color:green;font-weight:700">R$ <?= number_format($model->total_entradas, 2, ',', '.') ?></td></tr>
    <tr><th>Saídas</th><td style="color:red;font-weight:700">R$ <?= number_format($model->total_saidas, 2, ',', '.') ?></td></tr>
    <tr><th>Saldo Teórico</th><td><strong>R$ <?= number_format($model->saldo_teorico, 2, ',', '.') ?></strong></td></tr>
    <tr><th>Saldo Contado</th><td><?= $model->saldo_informado === null ? '-' : 'R$ ' . number_format($model->saldo_informado, 2, ',', '.') ?></td></tr>
    <tr><th>Diferença</th><td><?= $model->diferenca === null ? '-' : 'R$ ' . number_format($model->diferenca, 2, ',', '.') ?></td></tr>
</table>

<?php if (!empty($model->observacao)): ?>
    <div class="alert alert-info">
        <strong>Observação:</strong><br>
        <?= nl2br(Html::encode($model->observacao)) ?>
    </div>
<?php endif; ?>

<div class="mt-3 d-flex gap-2">
    <?= Html::a('📋 Lançamentos', ['/lancamento/index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('🧾 Lista de Caixas', ['index'], ['class' => 'btn btn-secondary']) ?>

    <?php if ($model->status === 'aberto'): ?>
        <?= Html::a('✅ Fechar Caixa', ['fechar', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    <?php endif; ?>
</div>
