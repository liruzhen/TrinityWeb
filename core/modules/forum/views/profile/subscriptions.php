<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\widgets\gridview\ActionColumn;
use core\modules\forum\widgets\gridview\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;

$this->title = Yii::t('podium/view', 'Subscriptions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'My Profile'), 'url' => ['profile/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row mt-3">
    <div class="col-12">
        <h4><?php echo Yii::t('podium/view', 'Subscriptions'); ?></h4>
        <?php echo Html::beginForm(); ?>
                <?php echo GridView::widget([
                    'dataProvider'   => $dataProvider,
                    'columns'        => [
                        [
                            'class'           => CheckboxColumn::class,
                            'headerOptions'   => ['class' => 'col-sm-1 text-center'],
                            'contentOptions'  => ['class' => 'col-sm-1 text-center'],
                            'checkboxOptions' => function($model) {
                                return ['value' => $model->id];
                            }
                        ],
                        [
                            'attribute' => 'thread.name',
                            'label'     => Yii::t('podium/view', "Thread's Name"),
                            'format'    => 'raw',
                            'value'     => function ($model) {
                                return Html::a($model->thread->name, ['forum/show', 'id' => $model->thread->latest->id], ['class' => 'center-block']);
                            },
                        ],
                        [
                            'attribute'      => 'post_seen',
                            'headerOptions'  => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'label'          => Yii::t('podium/view', 'New Posts'),
                            'format'         => 'raw',
                            'value'          => function ($model) {
                                return $model->post_seen ? '' : '<span class="glyphicon glyphicon-ok-sign"></span>';
                            },
                        ],
                        [
                            'class'    => ActionColumn::class,
                            'template' => '{mark} {delete}',
                            'buttons'  => [
                                'mark' => function($url, $model) {
                                    if ($model->post_seen) {
                                        return Html::a('<span class="glyphicon glyphicon-eye-close"></span> <span class="d-sm-none">' . Yii::t('podium/view', 'Mark unseen') . '</span>', $url, [
                                            'class' => 'btn btn-warning btn-xs'
                                        ]);
                                    }

                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span> <span class="d-sm-none">' . Yii::t('podium/view', 'Mark seen') . '</span>', $url, [
                                        'class' => 'btn btn-success btn-xs'
                                    ]);
                                },
                                'delete' => function($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span> <span class="d-sm-none">' . Yii::t('podium/view', 'Unsubscribe') . '</span>', $url, [
                                        'class' => 'btn btn-danger btn-xs'
                                    ]);
                                },
                            ],
                        ]
                    ],
                ]); ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo Html::submitButton('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('podium/view', 'Unsubscribe Selected Threads'), ['class' => 'btn btn-danger btn-sm', 'name' => 'delete-button']); ?>
                </div>
            </div>
        <?php echo Html::endForm(); ?>
    </div>
</div><br>
