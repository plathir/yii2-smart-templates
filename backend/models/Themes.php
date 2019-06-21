<?php

namespace plathir\templates\backend\models;

/**
 * This is the model class for table "log".
 *
 *  @property \plathir\log\Module $module
 */
class Themes extends \plathir\templates\common\models\Themes {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%templates_themes}}';
    }

}
