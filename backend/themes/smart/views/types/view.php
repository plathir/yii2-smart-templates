<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Template Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= 'View Template Type :' . Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">

        <div class="template-types-view">
            <p>
                <?= Html::a('Update', ['update', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->name], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>


            <?php
            echo DetailView::widget([
                'model' => $model,
                'template' => '<tr><th style="width:20%">{label}</th><td style="width:80%">{value}</td></tr>',
                'attributes' => [
                    'name',
                    'descr',
                ],
            ])
            ?>
        </div>
    </div>
</div>

