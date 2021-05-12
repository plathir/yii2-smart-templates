<?php

namespace plathir\templates\common\models;
use Yii;
use plathir\templates\common\models\Types;

/**
 * This is the model class for table "log".
 *
 *  @property \plathir\log\Module $module
 */
class Templates extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%templates}}';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['type', 'descr', 'text'], 'string'],
            [['type'], 'required'],
        ];
    }

    
     public function attributeLabels() {
        return [
            'id' => Yii::t('templates', 'ID'),
            'type' => Yii::t('templates', 'Type'),
            'descr' => Yii::t('templates', 'Description'),
            'text' => Yii::t('templates', 'Text'),
            'availfields' => Yii::t('templates', 'Available Fields'),
        ];
    }
    
    public function getTypes() {
       return $this->hasOne(Types::className(), ['name' => 'type']);
    }
    
    public function getAvailfields() {
          return $this->types["avail_fields"];    
    }
    
}
