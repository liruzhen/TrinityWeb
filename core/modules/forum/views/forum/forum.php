<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\rbac\Rbac;
use yii\helpers\Url;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Main Forum'), 'url' => ['forum/index']];
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['forum/category', 'id' => $model->category->id, 'slug' => $model->category->slug]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Podium::getInstance()->user->isGuest): ?>
<div class="row">
    <div class="col-sm-12 text-right">
        <ul class="list-inline">
            <?php if (
                User::can(Rbac::PERM_CREATE_THREAD,['category' => $model->category]) ||
                User::can(Rbac::PERM_CREATE_IN_CLOSED_CATEGORY)
            ): ?>
                <li class="list-inline-item"><a href="<?php echo Url::to(['forum/new-thread', 'cid' => $model->category->id, 'fid' => $model->id]); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('podium/view', 'Create new thread'); ?></a></li>
            <?php endif; ?>
            <li class="list-inline-item"><a href="<?php echo Url::to(['forum/unread-posts']); ?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span> <?php echo Yii::t('podium/view', 'Unread posts'); ?></a></li>
        </ul>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12" id="forum-content">
        <div class="panel-group" role="tablist">
            <?php echo $this->render('/elements/forum/_forum_section', ['model' => $model, 'filters' => $filters]); ?>
        </div>
    </div>
</div>
