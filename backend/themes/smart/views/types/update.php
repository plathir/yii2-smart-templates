<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = Yii::t('templates','Update Template type : ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('templates','Template Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('templates','Update');
?>
<div class="templates-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
