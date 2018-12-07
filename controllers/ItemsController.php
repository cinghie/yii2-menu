<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.4
 */

namespace cinghie\menu\controllers;

use Throwable;
use Yii;
use cinghie\menu\models\Items;
use cinghie\menu\models\ItemsSearch;
use yii\base\InvalidParamException;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ItemsController extends Controller
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
                        'actions' => ['index','create','update','delete','deletemultiple','changestate','activemultiple','deactivemultiple'],
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
                    'activemultiple' => ['POST'],
                    'changestate' => ['POST'],
                    'deactivemultiple' => ['POST'],
                    'delete' => ['POST'],
                    'deletemultiple' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Items models.
     *
     * @return mixed
     * @throws InvalidParamException
     */
    public function actionIndex()
    {
        $searchModel = new ItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     * @throws InvalidParamException
     */
    public function actionCreate()
    {
        $model = new Items();
	    $post = Yii::$app->request->post();

        if ( $model->load($post) )
        {
            // If alias is not set, generate it
	        $model->setAlias($post['Items'],'title');

	        // Set Empty as null
	        if($model->icon === 'empty') {
		        $model->icon = null;
	        }

            if( $model->save() )
            {
                // Set Success Message
                Yii::$app->session->setFlash('success', Yii::t('menu', 'Menu Item has been created'));

	            return $this->redirect(['update', 'id' => $model->id]);
            }

	        // Set Error Message
	        Yii::$app->session->setFlash('error', Yii::t('menu', 'Menu Item could not be saved'));

	        return $this->render('create', [
		        'model' => $model,
	        ]);
        }

	    return $this->render('create', [
		    'model' => $model,
	    ]);
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws InvalidParamException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        if ($model->load($post))
        {
	        // If alias is not set, generate it
	        $model->setAlias($post['Items'],'title');

	        // Set Empty as null
	        if($model->icon === 'empty') {
		        $model->icon = null;
	        }

            if($model->save())
            {
                // Set Success Message
                Yii::$app->session->setFlash('success', Yii::t('menu', 'Menu Item has been updated'));

	            return $this->render('update', [
		            'model' => $model,
	            ]);
            }

	        // Set Error Message
	        Yii::$app->session->setFlash('error', Yii::t('menu', 'Menu Item could not be saved'));

	        return $this->render('update', [
		        'model' => $model,
	        ]);
        }

	    return $this->render('update', [
		    'model' => $model,
	    ]);
    }

	/**
	 * Deletes an existing Items model.
	 * If deletion is successful, the browser will be redirected to the 'index' page
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 * @throws NotFoundHttpException
	 * @throws StaleObjectException
	 * @throws Throwable
	 */
    public function actionDelete($id)
    {
        if ($id !== 1) {
            $this->findModel($id)->delete();
        }

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
            if ($id !== 1) {

                $model = $this->findModel($id);

                if ($model->delete()) {
                    Yii::$app->session->setFlash('success', Yii::t('menu', 'Menu Item has been deleted'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('menu', 'Error deleting Menu Item'));
                }

            } else {
                Yii::$app->session->setFlash('error', Yii::t('menu', 'You can\'t delete this item' ));
            }
        }
    }

    /**
     * Change Items state: active or inactive
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionChangestate($id)
    {
        $model = $this->findModel($id);

        if($model->state) {
            $model->deactive();
            Yii::$app->getSession()->setFlash('warning', Yii::t('menu', 'Menu Item inactived'));
        } else {
            $model->active();
            Yii::$app->getSession()->setFlash('success', Yii::t('menu', 'Menu Item actived'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Active selected Items models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return void
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionActivemultiple()
    {
        $ids = Yii::$app->request->post('ids');

        if (!$ids) {
            return;
        }

        foreach ($ids as $id) {

            $model = $this->findModel($id);

            if(!$model->state) {
                $model->active();
                Yii::$app->getSession()->setFlash('success', Yii::t('menu', 'Menu Item actived'));
            } else {
                throw new ForbiddenHttpException;
            }
        }
    }

    /**
     * Active selected Items models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return void
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionDeactivemultiple()
    {
        $ids = Yii::$app->request->post('ids');

        if (!$ids) {
            return;
        }

        foreach ($ids as $id)
        {
            $model = $this->findModel($id);

            if($model->state) {
                $model->deactive();
                Yii::$app->getSession()->setFlash('warning', Yii::t('menu', 'Menu Item inactived'));
            } else {
                throw new ForbiddenHttpException;
            }
        }
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        }

	    throw new NotFoundHttpException('The requested page does not exist.');
    }

}
