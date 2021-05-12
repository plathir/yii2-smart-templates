<?php

namespace plathir\templates\backend\controllers;

use yii\web\Controller;
use plathir\templates\backend\models\Themes;
use plathir\templates\backend\models\Themes_s;
use Yii;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use common\helpers\ThemesHelper;
use common\helpers\MyZipArchive;

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
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $searchModel = new Themes_s();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to View Themes '));
        }
    }

    public function actionCreate() {
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $model = new Themes();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Theme : {name} created ! ', ['name' => $model->name]));
                return $this->redirect(['view', 'name' => $model->name]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Create Theme '));
        }
    }

    public function actionUpload() {
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $model = new Themes();
            $model->Destination = $this->module->themesExtractPath;
            $model->Destination_www = $this->module->www_themesExtractPath;

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
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Install Themes '));
        }
    }

    public function actionCopy($name) {
        if (\yii::$app->user->can('TemplatesAdmin')) {

            $from_model = $this->findModel($name);
            $new_model = new Themes();
            $new_model->created_by = \Yii::$app->user->getId();
            $new_model->updated_by = \Yii::$app->user->getId();

            if ($new_model->load(Yii::$app->request->post())) {
                $new_model->name = $new_model->copy_to;
                $new_model->descr = $from_model->descr;
                $new_model->backend = $from_model->backend;
                $new_model->frontend = $from_model->frontend;
                $new_model->version = $from_model->version;

                if ($new_model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Theme : {name} created ! ', ['name' => $new_model->name]));
                    $Helper = new ThemesHelper();
                    if ($new_model->frontend == true) {
                        $Helper->copy_theme_files($name, $new_model->name, 'frontend');
                    }
                    if ($new_model->backend == true) {
                        $Helper->copy_theme_files($name, $new_model->name, 'backend');
                    }

                    return $this->redirect(['view', 'name' => $new_model->name]);
                } else {
//                    foreach ($new_model->getErrors() as $attribute => $error) {
//                        foreach ($error as $message) {
//                           echo $message.'<br>';
//                        }
//                    }
//                   die();

                    Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme cannot copy !'));
                    return $this->render('copy', [
                                'model' => $new_model,
                    ]);
                }
            } else {
                return $this->render('copy', [
                            'model' => $new_model,
                ]);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Copy Theme '));
        }
    }

    public function actionDownload($name) {
        if (\yii::$app->user->can('TemplatesAdmin')) {
            $model = $this->findModel($name);
            $zip = new MyZipArchive();
            $tmpfname = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $name . '.zip';
            $zip->open($tmpfname, MyZipArchive::CREATE);

            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $rootPath = $this->module->themesExtractPath;
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($rootPath), \RecursiveIteratorIterator::LEAVES_ONLY);


            $uploads_path_excl = $rootPath . DIRECTORY_SEPARATOR . 'uploads';
            $select_tamplate_admin = $rootPath . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
            $select_tamplate_site = $rootPath . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;

            foreach ($files as $fname => $file) {
                //   echo $file . '<br>';
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                if (substr($filePath, 0, strlen($uploads_path_excl)) != $uploads_path_excl) {
                    if (substr($filePath, 0, strlen($select_tamplate_admin)) == $select_tamplate_admin ||
                            substr($filePath, 0, strlen($select_tamplate_site)) == $select_tamplate_site) {

                        $relativePath = 'views/' . substr($filePath, strlen($rootPath) + 1);

                        if (!$file->isDir()) {
                            // Add current file to archive
                            $zip->addFile($filePath, $relativePath);
                        } else {
                            if ($relativePath !== false)
                                $zip->addEmptyDir($relativePath);
                        }
                    }
                }
            }

            $rootPath_www = $this->module->www_themesExtractPath;
            $files_www = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($rootPath_www), \RecursiveIteratorIterator::LEAVES_ONLY);

            $select_tamplate_admin_www = $rootPath_www . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
            $select_tamplate_site_www = $rootPath_www . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;

            foreach ($files_www as $fname => $file) {

                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                if (substr($filePath, 0, strlen($select_tamplate_admin_www)) == $select_tamplate_admin_www ||
                        substr($filePath, 0, strlen($select_tamplate_site_www)) == $select_tamplate_site_www) {

                    $relativePath = 'www/' . substr($filePath, strlen($rootPath_www) + 1);

                    if (!$file->isDir()) {
                        // Add current file to archive
                        $zip->addFile($filePath, $relativePath);
                    } else {
                        if ($relativePath !== false)
                            $zip->addEmptyDir($relativePath);
                    }
                }
            }

            $model_xml = [
                $model->name => 'name',
                $model->descr => 'descr',
                $model->version => 'version',
                $model->backend => 'backend',
                $model->frontend => 'frontend',
            ];

            $xml = new \SimpleXMLElement('<theme/>');
            $xml->addChild('name', $model->name);
            $xml->addChild('descr', $model->descr);
            $xml->addChild('version', $model->version);
            $xml->addChild('backend', $model->backend);
            $xml->addChild('frontend', $model->frontend);
            $str_xml = $xml->asXML();

            $zip->addFromString('theme.xml', $str_xml);
            $zip->close();

            # send the file to the browser as a download
            header("Content-disposition: attachment; filename=" . basename($tmpfname) . "");
            header('Content-type: application/zip');
            readfile($tmpfname);
            unlink($tmpfname);

            return $this->redirect(['index']);
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Download Theme '));
        }
    }

    public function ExtractAndInstallTheme($model) {
        $basename = \basename($model->FileName, ".zip");

        $theme_xml = file_get_contents('zip://' . $model->FileName . '#theme.xml');
        $xml = \simplexml_load_string($theme_xml);

        if ($basename == $xml->name) {
            if (!Themes::findOne($basename)) {

                if ($this->ExtractFile($model->FileName, $model->Destination, $model->Destination_www)) {
                    $basename = \basename($model->FileName, ".zip");
                    $admin_theme = false;
                    $site_theme = false;

                    $new_theme = new Themes();
                    $new_theme->created_by = \Yii::$app->user->getId();
                    $new_theme->updated_by = \Yii::$app->user->getId();

                    $new_theme->name = $basename;
                    $new_theme->descr = strval($xml->descr);
                    $new_theme->backend = $xml->backend;
                    $new_theme->frontend = $xml->frontend;
                    $new_theme->version = strval($xml->version);

                    if ($new_theme->save()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Theme {name} Uploaded !', ['name' => $new_theme->name]));
                        return $this->redirect(['index']);
                    } else {
                        //print_r($new_theme->getErrors();
                        //die();
                        Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme cannot Upload !'));

                        return $this->redirect(['index']);
                    }
                } else {
                    Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme cannot extract !'));
                    $this->deleteZip($model->FileName);
                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme already exist !'));
                $this->deleteZip($model->FileName);
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme name different from zip name !'));
            $this->deleteZip($model->FileName);
            return $this->redirect(['index']);
        }
    }

    public function actionUpdate($name) {
        if (\yii::$app->user->can('TemplatesAdmin')) {

            $model = $this->findModel($name);
            if ($model->locked != true) {

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Theme : {name} updated ! ', ['name' => $model->name]));
                    return $this->redirect(['view', 'name' => $model->name]);
                } else {
                    return $this->render('update', [
                                'model' => $model,
                    ]);
                }
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme : {name} is locked ! Cannot updated ! ', ['name' => $model->name]));
                return $this->redirect(['index']);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Update Theme '));
        }
    }

    public function actionView($name) {
        $model = $this->findModel($name);
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    public function actionDelete($name) {
        $h_theme = $this->findModel($name);

        if (\yii::$app->user->can('TemplatesAdmin')) {
            if ($h_theme->locked != true) {
                if (( Yii::$app->settings->getSettings('FrontendTheme') != $h_theme->name ) &&
                        ( Yii::$app->settings->getSettings('FrontendTheme') != $h_theme->name)) {

                    if ($this->findModel($name)->delete()) {
                        $helper = new ThemesHelper();


                        if ($h_theme->frontend == true) {
                            $helper->remove_theme_files($h_theme->name, 'frontend');
                        }

                        if ($h_theme->backend == true) {
                            $helper->remove_theme_files($h_theme->name, 'backend');
                        }
                    }

                    Yii::$app->getSession()->setFlash('success', Yii::t('templates', 'Theme : {name} deleted ! ', ['name' => $name]));
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme : {name} in use ! ', ['name' => $name]));
                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('templates', 'Theme : {name} is locked ! Cannot Delete ! ', ['name' => $h_theme->name]));
                return $this->redirect(['index']);
            }
        } else {
            throw new \yii\web\NotAcceptableHttpException(Yii::t('templates', 'No Permission to Delete Theme '));
        }
    }

    protected function findModel($name) {
        if (($model = Themes::findOne($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('templates', 'The requested page does not exist.'));
        }
    }

    public function ExtractFile($filename, $destination, $www_destination) {
        $zip = new MyZipArchive();
        $basename = \basename($filename, ".zip");

        if (!file_exists($destination . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . $basename) &&
                !file_exists($destination . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . $basename)) {

            if ($zip->open($filename) === TRUE) {
                $zip->extractSubdirTo($destination, 'views/');
                $zip->extractSubdirTo($www_destination, 'www/');
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
