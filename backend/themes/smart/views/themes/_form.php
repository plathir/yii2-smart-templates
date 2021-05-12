<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">
        <?php
        $items_active = [
            '0' => Yii::t('templates', 'Inactive'),
            '1' => Yii::t('templates', 'Active')
        ];
        ?>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdPost']]); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'descr')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'version')->textInput(['maxlength' => 255]) ?>      
        <?php echo $form->field($model, 'backend')->widget(SwitchInput::classname(), []); ?>
        <?php echo $form->field($model, 'frontend')->widget(SwitchInput::classname(), []); ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Create' : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat btn-loader' : 'btn btn-primary btn-flat btn-loader']) ?>
        </div>

        <?php ActiveForm::end(); ?>        

    </div>

</div>