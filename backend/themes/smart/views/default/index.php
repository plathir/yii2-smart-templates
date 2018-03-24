<?php

use yii\helpers\Html;
use yii\grid\GridView;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Templates</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?=
        Html::a(Html::tag('span', '<i class="fa fa-fw fa-plus"></i>' . '&nbsp' . Yii::t('templates', 'Create'), [
                    'title' => Yii::t('templates', 'Create New Template'),
                    'data-toggle' => 'tooltip',
                ]), ['create'], ['class' => 'btn btn-success btn-flat btn-loader'])
        ?>                  


        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'type',
                'descr',
                ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'min-width: 70px;']
                ],
            ],
        ]);
        ?>

    </div>
</div>