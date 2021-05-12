<?php

namespace plathir\templates\backend\controllers;

use yii\web\Controller;
use plathir\templates\backend\models\Templates;
use plathir\templates\backend\models\Templates_s;
use Yii;

/**
 * AdminController implements the CRUD actions for Settings model.
 *  @property \plathir\templates\backend\Module $module
 */
class DefaultController extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
        $this->layout = "main";
    }

    public function actionIndex() {
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $searchModel = new Templates_s();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to View Templates '));
        }
    }

    public function actionCreate() {
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $model = new Templates();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Template : {id} created ! ', ['id' => $model->id]));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Create Template '));
        }
    }

    public function actionUpdate($id) {
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Template : {id} updated ! ', ['id' => $model->id]));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Update Template '));
        }
    }

    public function actionView($id) {
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $model = $this->findModel($id);
            return $this->render('view', [
                        'model' => $model,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to View Template '));
        }
    }

    public function actionDelete($id) {
        if (\yii::$app->user->can('TemplatesAdmin')) {

            if ($this->findModel($id)->delete()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Template entry : {id} deleted', ['id' => $id]));
            }
            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Delete Template '));
        }
    }

    protected function findModel($id) {
        if (($model = Templates::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('templates', 'The requested page does not exist.'));
        }
    }

}
