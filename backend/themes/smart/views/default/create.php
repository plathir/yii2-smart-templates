<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = Yii::t('templates','Create Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('templates','Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-create">

 
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
