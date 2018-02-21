<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use yii\helpers\Html;

$this->title = Yii::t('view', 'Delete Post');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Main Forum'), 'url' => ['forum/index']];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->forum->category->name, 'url' => ['forum/category', 'id' => $model->forum->category->id, 'slug' => $model->forum->category->slug]];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->forum->name, 'url' => ['forum/forum', 'cid' => $model->forum->category->id, 'id' => $model->forum->id, 'slug' => $model->forum->slug]];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->thread->name, 'url' => ['forum/thread', 'cid' => $model->forum->category->id, 'fid' => $model->forum->id, 'id' => $model->thread->id, 'slug' => $model->thread->slug]];
Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <?= Html::beginForm(); ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <?= Html::hiddenInput('post', $model->id) ?>
                            <h3 class="text-danger"><?= Yii::t('view', 'Are you sure you want to delete this post?') ?></h3>
                            <p><?= Yii::t('view', 'This action can not be undone.') ?></p>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('view', 'Delete Post'), ['class' => 'btn btn-block btn-danger', 'name' => 'delete-button']) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span> ' . Yii::t('view', 'Cancel'), ['forum/thread', 'cid' => $model->forum->category->id, 'fid' => $model->forum->id, 'id' => $model->thread->id, 'slug' => $model->thread->slug], ['class' => 'btn btn-block btn-default', 'name' => 'cancel-button']) ?>
                        </div>
                    </div>
                </div>
            <?= Html::endForm(); ?>
        </div>
    </div>
</div><br>
<?= $this->render('/elements/forum/_post', ['model' => $model, 'category' => $model->forum->category->id, 'slug' => $model->thread->slug]) ?>
<br>
