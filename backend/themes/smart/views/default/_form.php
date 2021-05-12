<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use plathir\templates\backend\models\Types;
use yii\helpers\ArrayHelper;

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
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'UpdPost']]); ?>
        <?php
        $templates_types_model = new Types();
        $items = ArrayHelper::map($templates_types_model::find()->all(), 'name', 'name');
        $allTypes = ArrayHelper::map($templates_types_model::find()->all(), 'name', 'avail_fields');
        $jsallTypes = json_encode($allTypes);
        $avail_text = Yii::t('templates', 'Available Fields');
        ?>  

        <?=
        $form->field($model, 'type')->dropDownList($items, [
            'prompt' => Yii::t('templates','-- Select Value --'),
            'onLoad' => 'alert("In")',
            'onchange' => "var a= $jsallTypes ;
                           $('#availfields').html('<strong>$avail_text : </strong>'+a[this.value])",
        ]);
        ?> 
        <?= $form->field($model, 'descr')->textInput(['maxlength' => 255]) ?>


        <div id="availfields">
            <?php if (!$model->isNewRecord ) { ?>
            <?= '<strong>' . $avail_text . ' : </strong>' . $allTypes[$model->type]; ?>
            <?php } ?>
        </div> <br><br>
        <?=
        $form->field($model, 'text')->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions('/templates/elfinder', [/* Some CKEditor Options */
            ]),
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> '.Yii::t('templates', 'Save') : '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> '.Yii::t('templates', 'Save Changes'), ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-primary btn-flat']) ?>
        </div>

        <?php ActiveForm::end(); ?>        

    </div>

</div>