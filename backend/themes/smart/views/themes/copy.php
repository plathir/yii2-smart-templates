<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = Yii::t('templates','Copy Theme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('templates','Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view','name' => $model->name]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-create">

 
    <?=
    $this->render('_form_copy', [
        'model' => $model,
    ])
    ?>

</div>
