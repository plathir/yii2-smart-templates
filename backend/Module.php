<?php
namespace plathir\templates\backend;

use Yii;
use \common\helpers\ThemesHelper;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\templates\backend\controllers';
    //  public $defaultRoute = 'templates';
    //  public $modulename = '';
    public $Theme = 'smart';
    public $mediaPath = '';
    public $mediaUrl = '';
    public $themesExtractPath = '';
    public $uploadZipPath = '';

    public function init() {

        parent::init();

        //  $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-templates/backend/themes/' . $this->Theme . '/views';
        $this->themesExtractPath = Yii::getAlias('@themes');
        $this->uploadZipPath = Yii::getAlias('@themes') . '/uploads';

        $helper = new ThemesHelper();
        $path = $helper->ModuleThemePath('templates', 'backend', dirname(__FILE__) . "/themes/$this->Theme");
        $path = $path . '/views';


        $this->setViewPath($path);
        $this->registerTranslations();

        $this->mediaPath = Yii::$app->settings->getSettings('TemplatesMediaPath'); //$this->settings->getSettings('TemplatesMediaPath');
        $this->mediaUrl = Yii::$app->settings->getSettings('TemplatesMediaUrl');   //$this->settings->getSettings('TemplatesMediaUrl');

        $this->controllerMap = [
            'elfinder' => [
                'class' => 'mihaildev\elfinder\Controller',
                'access' => ['@'],
                'disabledCommands' => ['netmount'],
                'roots' => [
                    [
                        'baseUrl' => $this->mediaUrl,
                        'basePath' => $this->mediaPath,
                        'path' => '',
                        'name' => 'Global'
                    ],
                ],
            ],
        ];
    }

    public function registerTranslations() {
        /*         * This registers translations for the widgets module * */
        Yii::$app->i18n->translations['templates'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => Yii::getAlias('@vendor/plathir/yii2-smart-templates/backend/messages'),
        ];
    }

}
