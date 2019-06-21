<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Themes</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?=
        Html::a(Html::tag('span', '<i class="fa fa-fw fa-upload"></i>' . '&nbsp' . Yii::t('templates', 'Upload'), [
                    'title' => Yii::t('templates', 'Upload New Theme'),
                    'data-toggle' => 'tooltip',
                ]), ['upload'], ['class' => 'btn btn-success btn-flat btn-loader'])
        ?>                  


        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'name',
                'descr',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'contentOptions' => ['style' => 'min-width: 80px;'],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'view'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'view'),
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'delete'),
                                        'data-confirm' => Yii::t('templates', 'Delete Theme ! Are you sure ?'),
                                        'data-method' => 'post'
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = Url::to(['types/view', 'name' => $model->name]);
                            return $url;
                        }
                        if ($action === 'update') {
                            $url = Url::to(['types/update', 'name' => $model->name]);
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url = Url::to(['types/delete', 'name' => $model->name]);
                            return $url;
                        }
                    }
                ]
            ],
        ]);
        ?>

    </div>
</div>