<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Lancamento;

class DashboardController extends Controller
{
    public function actionIndex($periodo = 'diario', $data = null)
    {
        $data = $data ?: date('Y-m-d');

        if ($periodo === 'mensal') {
            $inicio = date('Y-m-01', strtotime($data));
            $fim    = date('Y-m-t', strtotime($data));
            $tituloPeriodo = 'Mês: ' . date('m/Y', strtotime($data));
        } else {
            $inicio = $data;
            $fim    = $data;
            $tituloPeriodo = 'Dia: ' . date('d/m/Y', strtotime($data));
        }

        $totalEntradas = (float) (Lancamento::find()
            ->where(['tipo' => 'entrada'])
            ->andWhere(['between', 'data', $inicio, $fim])
            ->sum('valor') ?? 0);

        $totalSaidas = (float) (Lancamento::find()
            ->where(['tipo' => 'saida'])
            ->andWhere(['between', 'data', $inicio, $fim])
            ->sum('valor') ?? 0);

        $saldoPeriodo = $totalEntradas - $totalSaidas;

        return $this->render('index', [
            'periodo' => $periodo,
            'data' => $data,
            'inicio' => $inicio,
            'fim' => $fim,
            'tituloPeriodo' => $tituloPeriodo,
            'totalEntradas' => $totalEntradas,
            'totalSaidas' => $totalSaidas,
            'saldoPeriodo' => $saldoPeriodo,
        ]);
    }
}
