<?php
namespace plathir\templates\common\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 *  @property \plathir\log\Module $module
 */
class Themes extends \yii\db\ActiveRecord {

    public $file;
    public $FileName;
    public $Destination;
    public $Destination_www;
    public $copy_to;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%templates_themes}}';
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string'],
            [['descr'], 'string'],
            [['backend'], 'integer'],
            [['frontend'], 'integer'],
            [['version'], 'string'],
            [['copy_to'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => Yii::t('templates', 'Theme Name'),
            'descr' => Yii::t('templates', 'Description'),
            'version' => Yii::t('templates', 'Version'),
            'backend' => Yii::t('templates', 'Backend'),
            'forntend' => Yii::t('templates', 'Frontend'),
            'created_at' => Yii::t('templates', 'Created At'),
            'created_by' => Yii::t('templates', 'Created By'),
            'updated_at' => Yii::t('templates', 'Updated At'),
            'updated_by' => Yii::t('templates', 'Updated By'),
            
        ];
    }
 
    
    public function getUsername_cr() {
        $userModel = new \plathir\user\common\models\account\User();
        $usr = $userModel::findOne($this->created_by);
        return $usr->username;
    }
    
    public function getUsername_up() {
        $userModel = new \plathir\user\common\models\account\User();
        $usr = $userModel::findOne($this->updated_by);
        return $usr->username;
    }
    
    
    public function getBackendcheckicon() {
        $icon = '';
        switch ($this->backend) {
            case 1:
                $icon = '<i class="fa fa-fw fa-check-square-o"></i>';
                break;
            default:
                break;
        }

        return $icon;
    }    
    
        public function getFrontendcheckicon() {
        $icon = '';
        switch ($this->frontend) {
            case 1:
                $icon = '<i class="fa fa-fw fa-check-square-o"></i>';
                break;
            default:
                break;
        }

        return $icon;
    }  
    
     
    
}
