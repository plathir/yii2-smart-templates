<?php

namespace plathir\templates\backend\models;

/**
 * This is the model class for table "log".
 *
 *  @property \plathir\log\Module $module
 */
class Templates extends \plathir\templates\common\models\Templates {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'templates';
    }

}
