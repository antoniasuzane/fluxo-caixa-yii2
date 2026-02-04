<?php

use app\models\Lancamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LancamentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lancamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lancamento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Lancamento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

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

            ['class' => 'yii\grid\ActionColumn'],
        ],        
    ]); ?>


</div>