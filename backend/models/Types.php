<?php

namespace plathir\templates\backend\models;

/**
 * This is the model class for table "log".
 *
 *  @property \plathir\log\Module $module
 */
class Types extends \plathir\templates\common\models\Types {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'templates_types';
    }

}
