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
        ];
    }

    public function attributeLabels() {
        return [
            'name' => Yii::t('templates', 'Theme Name'),
            'descr' => Yii::t('templates', 'Description'),
        ];
    }

}
