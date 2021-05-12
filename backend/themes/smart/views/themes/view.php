<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('templates', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('templates', 'View Theme : ') . Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>

    </div><!-- /.box-header -->
    <div class="box-body">

        <div class="template-types-view">
            <p>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> ' . Yii::t('templates', 'Update'), ['update', 'name' => $model->name], ['class' => 'btn btn-primary btn-flat btn-loader']) ?>
                <?=
                Html::a('<i class="fa fa-trash-o"></i> ' . Yii::t('templates', 'Delete'), ['delete', 'name' => $model->name], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => Yii::t('templates', 'Are you sure you want to delete this item ?'),
                        'method' => 'post',
                    ],
                ])
                ?>
                <?= Html::a('<i class="fa fa-copy"></i> ' . Yii::t('templates', 'Copy'), ['copy', 'name' => $model->name], ['class' => 'btn btn-success btn-flat btn-loader']) ?>
                <?= Html::a('<i class="fa fa-fw fa-download"></i> ' . Yii::t('templates', 'Download'), ['download', 'name' => $model->name], ['class' => 'btn btn-success btn-flat']) ?>
            </p>

            <?php
            echo DetailView::widget([
                'model' => $model,
                'template' => '<tr><th style="width:20%">{label}</th><td style="width:80%">{value}</td></tr>',
                'attributes' => [
                    'name',
                    'descr',
                           
                    'version',

                    [
                        'attribute' => 'backend',
                        'value' => function($model) {
                            return $model->Backendcheckicon;
                        },
                        'format' => 'raw',
                    ],                                

                    [
                        'attribute' => 'frontend',
                        'value' => function($model) {
                            return $model->Frontendcheckicon;
                        },
                        'format' => 'raw',
                    ],                                
                    
                    'created_at:datetime',
                    [
                        'attribute' => 'created_by',
                        'value' => function($model) {
                            return $model->Username_cr;
                        },
                        'format' => 'raw',
                    ],                                
                    'updated_at:datetime',
                    [
                        'attribute' => 'updated_by',
                        'value' => function($model) {
                            return $model->Username_up;
                        },
                        'format' => 'raw',
                    ],                                  
                ],
            ])
            ?>
        </div>
    </div>
</div>

