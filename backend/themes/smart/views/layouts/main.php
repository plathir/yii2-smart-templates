<?php

use yii\helpers\Html;
?>


<?php
if (\Yii::$app->view->theme) {
    $layoutFile = \Yii::$app->view->theme->pathMap['@app/views'] . DIRECTORY_SEPARATOR . 'layouts/main.php';
} else {
    $layoutFile = '@app/views/layouts/main.php';
}
?>

<?php $this->beginContent($layoutFile); ?>

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Templates</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?= Html::a(Yii::t('app', '<i class="fa fa-file-o"></i> Types'), ['/templates/types'], ['class' => 'btn btn-app']) ?>
        <?= Html::a(Yii::t('app', '<i class="fa fa-file-code-o"></i> Templates'), ['/templates'], ['class' => 'btn btn-app']) ?>
    </div>
</div>
<?php
?>

<?= $content ?>

<?php $this->endContent(); ?>


