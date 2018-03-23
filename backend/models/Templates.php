<?php

namespace plathir\templates\backend\models;

/**
 * This is the model class for table "log".
 *
 *  @property \plathir\log\Module $module
 */
class Log extends \plathir\templates\common\Templates {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'templates';
    }

}
