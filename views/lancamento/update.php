<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Lancamento $model */

$this->title = 'Update Lancamento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lancamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lancamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
