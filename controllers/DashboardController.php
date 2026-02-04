<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Lancamento;

class DashboardController extends Controller
{
    public function actionIndex($periodo = 'diario', $data = null)
    {
        // data base (YYYY-MM-DD). se não vier, usa hoje
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

        // Totais do período
        $totalEntradas = (float) (Lancamento::find()
            ->where(['tipo' => 'entrada'])
            ->andWhere(['between', 'data', $inicio, $fim])
            ->sum('valor') ?? 0);

        $totalSaidas = (float) (Lancamento::find()
            ->where(['tipo' => 'saida'])
            ->andWhere(['between', 'data', $inicio, $fim])
            ->sum('valor') ?? 0);

        $saldoPeriodo = $totalEntradas - $totalSaidas;

        // Totais acumulados até o fim do período
        $totalEntradasAte = (float) (Lancamento::find()
            ->where(['tipo' => 'entrada'])
            ->andWhere(['<=', 'data', $fim])
            ->sum('valor') ?? 0);

        $totalSaidasAte = (float) (Lancamento::find()
            ->where(['tipo' => 'saida'])
            ->andWhere(['<=', 'data', $fim])
            ->sum('valor') ?? 0);

        $saldoAcumulado = $totalEntradasAte - $totalSaidasAte;

        // Últimos lançamentos do período (ex: 10)
        $ultimosLancamentos = Lancamento::find()
            ->where(['between', 'data', $inicio, $fim])
            ->orderBy(['data' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('index', compact(
            'periodo',
            'data',
            'inicio',
            'fim',
            'tituloPeriodo',
            'totalEntradas',
            'totalSaidas',
            'saldoPeriodo',
            'saldoAcumulado',
            'ultimosLancamentos'
        ));
    }
}
