<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Create Template Type';
$this->params['breadcrumbs'][] = ['label' => 'Template Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-create">

 
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
