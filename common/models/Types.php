<?php

namespace plathir\templates\common\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 *  @property \plathir\log\Module $module
 */
class Types extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'templates_types';
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
            'name' => Yii::t('templates', 'Type Name'),
            'descr' => Yii::t('templates', 'Description'),
        ];
    }

}
