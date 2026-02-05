<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '➕ Abrir Caixa';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'data')->input('date') ?>
<?= $form->field($model, 'saldo_inicial')->textInput(['type' => 'number', 'step' => '0.01']) ?>

<div class="mt-3">
    <button class="btn btn-success">Abrir Caixa</button>
    <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
</div>

<?php ActiveForm::end(); ?>
