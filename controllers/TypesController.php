<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.5
 */

namespace cinghie\menu\controllers;

use Throwable;
use Yii;
use cinghie\menu\models\Types;
use cinghie\menu\models\TypesSearch;
use yii\base\InvalidParamException;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class TypesController extends Controller
{

	/**
	 * @inheritdoc
	 *
	 * @return array
	 */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','create','update','delete','deletemultiple'],
                        'roles' => $this->module->menuRoles
                    ],
                ],
                'denyCallback' => function () {
                    throw new ForbiddenHttpException;
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'deletemultiple' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Types models.
     *
     * @return mixed
     * @throws InvalidParamException
     */
    public function actionIndex()
    {
        $searchModel = new TypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Types model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @throws InvalidParamException
     */
    public function actionCreate()
    {
        $model = new Types();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            // Set Success Message
            Yii::$app->session->setFlash('success', Yii::t('menu', 'Menu Type has been created'));

            return $this->redirect(['index']);
        }

	    return $this->render('create', [
		    'model' => $model,
	    ]);
    }

    /**
     * Updates an existing Types model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     *
     * @return mixed
     * @throws InvalidParamException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // Set Success Message
            Yii::$app->session->setFlash('success', Yii::t('menu', 'Menu Type has been updated'));

            return $this->redirect(['index']);

        }

	    return $this->render('update', [
		    'model' => $model,
	    ]);
    }

	/**
	 * Deletes an existing Types model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param string $id
	 *
	 * @return mixed
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	/**
	 * Deletes selected Settings models.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @return void
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
    public function actionDeletemultiple()
    {
        $ids = Yii::$app->request->post('ids');

        if (!$ids) {
            return;
        }

        foreach ($ids as $id)
        {
            $model = $this->findModel($id);

            if ($model->delete()) {
                Yii::$app->session->setFlash('success', Yii::t('menu', 'Menu Type has been deleted'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('menu', 'Error deleting Menu Type'));
            }
        }
    }

    /**
     * Finds the Types model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return Types the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Types::findOne($id)) !== null) {
            return $model;
        }

	    throw new NotFoundHttpException('The requested page does not exist.');
    }

}
