<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\apps\models\Apps */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apps-form">
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('templates', 'Upload and install new Theme') ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-flat btn-loader btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-flat btn-loader btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'CopyTheme']]); ?>
            <?= $form->field($model, 'copy_to')->textInput(['maxlength' => 255]) ?>
            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-fw fa-copy"></i>' .Yii::t('templates', 'Copy'), ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
            </div>
            <?php ActiveForm::end(); ?>            
        </div>
    </div>
</div>
