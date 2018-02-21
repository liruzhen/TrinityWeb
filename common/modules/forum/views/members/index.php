<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\helpers\Helper;
use common\modules\forum\models\User;
use common\modules\forum\Podium;
use common\modules\forum\widgets\gridview\ActionColumn;
use common\modules\forum\widgets\gridview\GridView;
use common\modules\forum\widgets\Readers;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('view', 'Members List');
Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<ul class="nav nav-tabs">
    <li role="presentation" class="active">
        <a href="<?= Url::to(['members/index']) ?>">
            <span class="glyphicon glyphicon-user"></span>
            <?= Yii::t('view', 'Members List') ?>
        </a>
    </li>
    <li role="presentation">
        <a href="<?= Url::to(['members/mods']) ?>">
            <span class="glyphicon glyphicon-scissors"></span>
            <?= Yii::t('view', 'Moderation Team') ?>
        </a>
    </li>
</ul>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'username',
            'label' => Yii::t('view', 'Username'),
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->podiumName, ['members/view', 'id' => $model->id, 'slug' => $model->podiumSlug], ['data-pjax' => '0']);
            },
        ],
        [
            'attribute' => 'role',
            'label' => Yii::t('view', 'Role'),
            'format' => 'raw',
            'filter' => User::getRoles(),
            'value' => function ($model) {
                return Helper::roleLabel($model->role);
            },
        ],
        [
            'attribute' => 'created_at',
            'label' => Yii::t('view', 'Joined'),
            'format' => 'datetime'
        ],
        [
            'attribute' => 'threads_count',
            'label' => Yii::t('view', 'Threads'),
            'value' => function ($model) {
                return $model->threadsCount;
            },
        ],
        [
            'attribute' => 'posts_count',
            'label' => Yii::t('view', 'Posts'),
            'value' => function ($model) {
                return $model->postsCount;
            },
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{view}' . (!Podium::getInstance()->user->isGuest ? ' {pm}' : ''),
            'buttons' => [
                'view' => function($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['members/view', 'id' => $model->id, 'slug' => $model->podiumSlug], ActionColumn::buttonOptions([
                        'title' => Yii::t('view', 'View Member')
                    ]));
                },
                'pm' => function($url, $model) {
                    if ($model->id !== User::loggedId()) {
                        return Html::a('<span class="glyphicon glyphicon-envelope"></span>', ['messages/new', 'user' => $model->id], ActionColumn::buttonOptions([
                            'title' => Yii::t('view', 'Send Message')
                        ]));
                    }
                    return ActionColumn::mutedButton('glyphicon glyphicon-envelope');
                },
            ],
        ]
    ],
]); ?>
<div class="panel panel-default">
    <div class="panel-body small">
        <ul class="list-inline pull-right">
            <li><a href="<?= Url::to(['forum/index']) ?>" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('view', 'Go to the main page') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="#top" data-toggle="tooltip" data-placement="top" title="<?= Yii::t('view', 'Go to the top') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a></li>
        </ul>
        <?= Readers::widget(['what' => 'members']) ?>
    </div>
</div>