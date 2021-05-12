<?php

namespace plathir\templates\backend\traits;

use plathir\templates\backend\Module;
use Yii;

/**
 * Class ModuleTrait
 * @package plathir\templates\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait
{
    /**
     * @var \plathir\templates\Module|null Module instance
     */
    private $_module;

    /**
     * @return \plathir\templates\Module|null Module instance
     */
    public function getModule()
    {
        if ($this->_module === null) {
            $module = Module::getInstance();
            if ($module instanceof Module) {
                $this->_module = $module;
            } else {
                $this->_module = Yii::$app->getModule('templates');
            }
        }
        return $this->_module;
    }
}
