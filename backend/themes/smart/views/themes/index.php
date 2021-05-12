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
        <h3 class="box-title"><?= Yii::t('templates', 'Themes') ?></h3>
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
                [
                    'attribute' => 'backend',
                    'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'backend', [
                        '1' => Yii::t('templates', 'Yes'),
                        '0' => Yii::t('templates', 'No')
                            ],
                            [
                                'class' => 'form-control',
                                'prompt' => 'Select...'
                            ]
                    ),
                    'value' => function ($model) {
                        if (Yii::$app->settings->getSettings('BackendTheme') == $model->name) {
                            return $model->Backendcheckicon . '<small class="label bg-red">'.Yii::t('templates', 'Active').'</small>';
                        } else {
                            return $model->Backendcheckicon;
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'frontend',
                    'filter' => \yii\bootstrap\Html::activeDropDownList($searchModel, 'frontend', [
                        '1' => Yii::t('templates', 'Yes'),
                        '0' => Yii::t('templates', 'No')
                            ],
                            [
                                'class' => 'form-control',
                                'prompt' => 'Select...'
                            ]
                    ),
                    'value' => function ($model) {
                        if (Yii::$app->settings->getSettings('FrontendTheme') == $model->name) {
                            return $model->Frontendcheckicon  . '<small class="label bg-red">'.Yii::t('templates', 'Active').'</small>';
                        } else {
                            return $model->Frontendcheckicon;
                        }
                    },
                    'format' => 'raw',
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}{copy}{download}',
                    'contentOptions' => ['style' => 'min-width: 80px;'],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'View'),
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'Update'),
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'Delete'),
                                        'data-confirm' => Yii::t('templates', 'Delete Theme ! Are you sure ?'),
                                        'data-method' => 'post'
                            ]);
                        },
                        'copy' => function ($url, $model) {
                            return Html::a('<i class="fa fa-copy"></i>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'Copy'),
                            ]);
                        },
                        'download' => function ($url, $model) {
                            return Html::a('<i class="fa fa-fw fa-download"></i>&nbsp;', $url, [
                                        'title' => Yii::t('templates', 'Download'),
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = Url::to(['themes/view', 'name' => $model->name]);
                            return $url;
                        }
                        if ($action === 'update') {
                            $url = Url::to(['themes/update', 'name' => $model->name]);
                            return $url;
                        }
                        if ($action === 'copy') {
                            $url = Url::to(['themes/copy', 'name' => $model->name]);
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url = Url::to(['themes/delete', 'name' => $model->name]);
                            return $url;
                        }
                        if ($action === 'download') {
                            $url = Url::to(['themes/download', 'name' => $model->name]);
                            return $url;
                        }
                    }
                ]
            ],
        ]);
        ?>

    </div>
</div>