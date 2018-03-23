<?php

namespace plathir\templates\common\models;

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
        return 'templates';
    }

}
