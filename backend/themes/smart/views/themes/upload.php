<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Upload Theme';
$this->params['breadcrumbs'][] = ['label' => 'Template Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-create">

 
    <?=
    $this->render('_form_upload', [
        'model' => $model,
    ])
    ?>

</div>
