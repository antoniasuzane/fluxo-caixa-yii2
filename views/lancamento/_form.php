<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Lancamento $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lancamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data')->input('date') ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList([
        'entrada' => 'Entrada',
        'saida' => 'Saída',
    ], ['prompt' => 'Selecione']) ?>

    <?= $form->field($model, 'valor')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <?= $form->field($model, 'forma_pagamento')->dropDownList([
        'dinheiro' => 'Dinheiro',
        'pix' => 'Pix',
        'cartao' => 'Cartão',
    ], ['prompt' => 'Selecione']) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>