<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Lancamento;

class DashboardController extends Controller
{
    public function actionIndex($periodo = 'diario', $data = null, $forma = '')
    {
        $data = $data ?: date('Y-m-d');
        $forma = trim((string)$forma);

        if ($periodo === 'mensal') {
            $inicio = date('Y-m-01', strtotime($data));
            $fim    = date('Y-m-t', strtotime($data));
            $tituloPeriodo = 'Mês: ' . date('m/Y', strtotime($data));
        } else {
            $inicio = $data;
            $fim    = $data;
            $tituloPeriodo = 'Dia: ' . date('d/m/Y', strtotime($data));
        }

        // Helper para aplicar filtro de forma_pagamento
        $aplicarFiltroForma = function ($query) use ($forma) {
            if ($forma !== '') {
                $query->andWhere(['forma_pagamento' => $forma]);
            }
            return $query;
        };

        // Totais do período
        $qEntradasPeriodo = Lancamento::find()
            ->where(['tipo' => 'entrada'])
            ->andWhere(['between', 'data', $inicio, $fim]);
        $aplicarFiltroForma($qEntradasPeriodo);

        $totalEntradas = (float) ($qEntradasPeriodo->sum('valor') ?? 0);

        $qSaidasPeriodo = Lancamento::find()
            ->where(['tipo' => 'saida'])
            ->andWhere(['between', 'data', $inicio, $fim]);
        $aplicarFiltroForma($qSaidasPeriodo);

        $totalSaidas = (float) ($qSaidasPeriodo->sum('valor') ?? 0);

        $saldoPeriodo = $totalEntradas - $totalSaidas;

        // Totais acumulados até o fim do período
        $qEntradasAte = Lancamento::find()
            ->where(['tipo' => 'entrada'])
            ->andWhere(['<=', 'data', $fim]);
        $aplicarFiltroForma($qEntradasAte);

        $totalEntradasAte = (float) ($qEntradasAte->sum('valor') ?? 0);

        $qSaidasAte = Lancamento::find()
            ->where(['tipo' => 'saida'])
            ->andWhere(['<=', 'data', $fim]);
        $aplicarFiltroForma($qSaidasAte);

        $totalSaidasAte = (float) ($qSaidasAte->sum('valor') ?? 0);

        $saldoAcumulado = $totalEntradasAte - $totalSaidasAte;

        // Últimos lançamentos do período
        $qUltimos = Lancamento::find()
            ->where(['between', 'data', $inicio, $fim])
            ->orderBy(['data' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(10);
        $aplicarFiltroForma($qUltimos);

        $ultimosLancamentos = $qUltimos->all();

        // Label para o filtro (pra mostrar na tela)
        $mapForma = [
            '' => 'Todas',
            'dinheiro' => 'Dinheiro',
            'pix' => 'Pix',
            'cartao' => 'Cartão',
        ];
        $formaLabel = $mapForma[$forma] ?? 'Todas';

        return $this->render('index', compact(
            'periodo',
            'data',
            'inicio',
            'fim',
            'tituloPeriodo',
            'forma',
            'formaLabel',
            'totalEntradas',
            'totalSaidas',
            'saldoPeriodo',
            'saldoAcumulado',
            'ultimosLancamentos'
        ));
    }
}
