<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->id. ' - '. $model->descr;
$this->params['breadcrumbs'][] = ['label' => Yii::t('templates','Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('templates','View Template : ') . Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">

        <div class="posts-view">
            <p>
                <?= Html::a('<i class="fa fa-fw fa-edit"></i> '.Yii::t('templates', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?=
                Html::a('<i class="fa fa-fw fa-trash"></i> '. Yii::t('templates', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => Yii::t('templates', 'Are you sure you want to delete this item ?'),
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
                    'id',
                    'type',
                    'descr',
                    'availfields',
                    'text:html',
                ],
            ])
            ?>
        </div>
    </div>
</div>

