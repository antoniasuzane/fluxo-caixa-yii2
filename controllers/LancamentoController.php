<?php

namespace app\controllers;

use Yii;
use app\models\Lancamento;
use app\models\LancamentoSearch;
use app\models\Caixa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * LancamentoController implements the CRUD actions for Lancamento model.
 */
class LancamentoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Lancamento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LancamentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lancamento model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Lancamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Lancamento();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // bloqueia criação se o caixa da data estiver fechado (exceto admin)
                $this->bloquearSeCaixaFechado($model->data);

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lancamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataOriginal = $model->data;

        if ($this->request->isPost && $model->load($this->request->post())) {
            // bloqueia se o lançamento era de um dia fechado
            $this->bloquearSeCaixaFechado($dataOriginal);

            // bloqueia se tentarem mover para um dia fechado
            $this->bloquearSeCaixaFechado($model->data);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lancamento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // bloqueia exclusão se o caixa da data estiver fechado (exceto admin)
        $this->bloquearSeCaixaFechado($model->data);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lancamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Lancamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lancamento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function isAdmin(): bool
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        // método simples: username admin
        $username = Yii::$app->user->identity->username ?? null;
        if ($username && strtolower($username) === 'admin') {
            return true;
        }

        // se no futuro você usar RBAC, isso já funciona também:
        return Yii::$app->user->can('admin');
    }

    private function caixaFechadoParaData(string $data): bool
    {
        $caixa = Caixa::findOne(['data' => $data]);

        // Se não existe caixa criado para a data, consideramos "não fechado" (libera)
        if (!$caixa) {
            return false;
        }

        return $caixa->status === 'fechado';
    }

    private function bloquearSeCaixaFechado(string $data): void
    {
        if ($this->isAdmin()) {
            return; // admin pode
        }

        if ($this->caixaFechadoParaData($data)) {
            throw new ForbiddenHttpException(
                'O caixa deste dia está FECHADO. Apenas o administrador pode criar/editar/excluir lançamentos nessa data.'
            );
        }
    }
}
