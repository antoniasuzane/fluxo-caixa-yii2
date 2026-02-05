<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Caixa;

class CaixaController extends Controller
{
    public function actionIndex()
    {
        $caixas = Caixa::find()->orderBy(['data' => SORT_DESC])->all();
        return $this->render('index', ['caixas' => $caixas]);
    }

    public function actionAbrir($data = null)
    {
        $data = $data ?: date('Y-m-d');

        $model = Caixa::findOne(['data' => $data]);
        if ($model && $model->status === 'aberto') {
            Yii::$app->session->setFlash('info', 'Caixa já está aberto para esta data.');
            return $this->redirect(['ver', 'id' => $model->id]);
        }
        if ($model && $model->status === 'fechado') {
            Yii::$app->session->setFlash('warning', 'Este caixa já foi fechado e não pode ser reaberto (por enquanto).');
            return $this->redirect(['ver', 'id' => $model->id]);
        }

        $model = new Caixa();
        $model->data = $data;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Caixa aberto com sucesso!');
            return $this->redirect(['ver', 'id' => $model->id]);
        }

        return $this->render('abrir', ['model' => $model]);
    }

    public function actionVer($id)
    {
        $model = $this->findModel($id);
        $model->recalcularTotais(); // atualiza visão
        return $this->render('ver', ['model' => $model]);
    }

    public function actionFechar($id)
    {
        $model = $this->findModel($id);

        if ($model->status === 'fechado') {
            Yii::$app->session->setFlash('info', 'Este caixa já está fechado.');
            return $this->redirect(['ver', 'id' => $model->id]);
        }

        if (Yii::$app->request->isPost) {
            $saldoInformado = Yii::$app->request->post('saldo_informado');
            $observacao = Yii::$app->request->post('observacao');

            $model->fechar($saldoInformado, $observacao);

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Caixa fechado com sucesso!');
                return $this->redirect(['ver', 'id' => $model->id]);
            }
        }

        // antes de mostrar, recalcula os números do dia
        $model->recalcularTotais();

        return $this->render('fechar', ['model' => $model]);
    }

    protected function findModel($id)
    {
        if (($model = Caixa::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Caixa não encontrado.');
    }
}
