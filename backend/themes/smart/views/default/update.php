<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = Yii::t('templates','Update Template : ') . ' ' . $model->id . ' - '.$model->descr;
$this->params['breadcrumbs'][] = ['label' => Yii::t('templates', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id. ' - '. $model->descr , 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('templates', 'Update');
?>
<div class="templates-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
