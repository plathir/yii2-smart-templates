<?php

namespace plathir\templates\backend\controllers;

use yii\web\Controller;
use plathir\templates\backend\models\Types;
use plathir\templates\backend\models\Types_s;
use Yii;

/**
 * AdminController implements the CRUD actions for Settings model.
 *  @property \plathir\templates\backend\Module $module
 */
class TypesController extends Controller {

    public function __construct($name, $module) {
        parent::__construct($name, $module);
        $this->layout = "main";
    }

    public function actionIndex() {
        $searchModel = new Types_s();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Types();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Template Type : {id} created ! ', ['id' => $model->name]));
            return $this->redirect(['view', 'name' => $model->name ]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($name) {
        $model = $this->findModel($name);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Template Type : {name} updated ! ', ['name' => $model->name]));
            return $this->redirect(['view', 'name' => $model->name]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionView($name) {
        $model = $this->findModel($name);
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    public function actionDelete($name) {
        if ($this->findModel($name)->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Template entry : {name} deleted', ['name' => $name]));
        }
        return $this->redirect(['index']);
    }

    protected function findModel($name) {
        if (($model = Types::findOne($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('templates', 'The requested page does not exist.'));
        }
    }

}
