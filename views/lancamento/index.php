<?php

use app\models\Lancamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Caixa;

/** @var yii\web\View $this */
/** @var app\models\LancamentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$hoje = date('Y-m-d');
$fechadoHoje = Caixa::estaFechado($hoje);
$isAdmin = !Yii::$app->user->isGuest && strtolower(Yii::$app->user->identity->username ?? '') === 'admin';

$this->title = 'Lancamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lancamento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!$fechadoHoje || $isAdmin): ?>
        <p>
            <?= Html::a('➕ Novo Lançamento', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php else: ?>
        <div class="alert alert-warning">
            O caixa de hoje está <strong>FECHADO</strong>. Somente o administrador pode incluir lançamentos.
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'data:date',
            'descricao',

            [
                'attribute' => 'tipo',
                'value' => fn($m) => $m->tipo === 'entrada' ? 'Entrada' : 'Saída',
                'contentOptions' => fn($m) => [
                    'style' => $m->tipo === 'entrada' ? 'color: green; font-weight:600' : 'color: red; font-weight:600'
                ],
            ],

            [
                'attribute' => 'valor',
                'format' => ['currency', 'BRL'],
                'contentOptions' => fn($m) => [
                    'style' => $m->tipo === 'entrada' ? 'color: green; font-weight:600' : 'color: red; font-weight:600'
                ],
            ],

            'forma_pagamento',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function ($model) {
                        $isAdmin = !Yii::$app->user->isGuest && strtolower(Yii::$app->user->identity->username ?? '') === 'admin';
                        if ($isAdmin) return true;
                        return !\app\models\Caixa::estaFechado($model->data);
                    },
                    'delete' => function ($model) {
                        $isAdmin = !Yii::$app->user->isGuest && strtolower(Yii::$app->user->identity->username ?? '') === 'admin';
                        if ($isAdmin) return true;
                        return !\app\models\Caixa::estaFechado($model->data);
                    },
                ],
            ],
        ],
    ]); ?>


</div>