<?php
namespace plathir\templates\backend\controllers;

use yii\web\Controller;
use plathir\templates\backend\models\Themes;
use plathir\templates\backend\models\Themes_s;
use Yii;
use yii\web\UploadedFile;

/**
 * AdminController implements the CRUD actions for Settings model.
 *  @property \plathir\templates\backend\Module $module
 */
class ThemesController extends Controller {

    public function __construct($name, $module) {
        parent::__construct($name, $module);
        $this->layout = "main";
    }

    public function actionIndex() {
        $searchModel = new Themes_s();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new Themes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Template Type : {id} created ! ', ['id' => $model->name]));
            return $this->redirect(['view', 'name' => $model->name]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpload() {
        //  if (\yii::$app->user->can('ThemesInstall')) {
        $model = new Themes();
        $model->Destination = $this->module->themesExtractPath;

        if ($model->load(Yii::$app->request->post())) {
            if (($model->file = UploadedFile::getInstance($model, 'file')) &&
                    ( $model->file->saveAs($this->module->uploadZipPath . '/' . $model->file->name) ) && ($model->FileName = $this->module->uploadZipPath . '/' . $model->file->name )) {

                $this->ExtractAndInstallTheme($model);
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Theme cannot upload !');
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('upload', [
                        'model' => $model,
            ]);
        }

//        }
//         else {
//            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Install Themes '));
//        }
    }

    public function ExtractAndInstallTheme($model) {

        if ($this->ExtractFile($model->FileName, $model->Destination)) {
//           $model = $this->FillModelValuesFromThemeFiles($model);
//            $this->installApp($model);
            return $this->redirect(['index']);
        } else {
            Yii::$app->getSession()->setFlash('danger', 'Theme cannot extract !');
            $this->deleteZip($model->FileName);
            return $this->redirect(['index']);
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
        if (($model = Themes::findOne($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('templates', 'The requested page does not exist.'));
        }
    }

    public function ExtractFile($filename, $destination) {
        $zip = new \ZipArchive();
        $basename = \basename($filename, ".zip");

        if (!file_exists($destination . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . $basename) &&
                !file_exists($destination . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . $basename)) {

            if ($zip->open($filename) === TRUE) {
                $zip->extractTo($destination);
                $zip->close();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function deleteZip($filename) {
        if (file_exists($filename)) {
            return unlink($filename);
        }
    }
    
}
