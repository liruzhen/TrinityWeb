<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\models\Post;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Yii::t('podium/view', 'Posts created by {name}', ['name' => $user->podiumName]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Members List'), 'url' => ['members/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Member View'), 'url' => ['members/view', 'id' => $user->id, 'slug' => $user->podiumSlug]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Pjax::begin();
echo ListView::widget([
    'dataProvider'     => (new Post())->searchByUser($user->id),
    'itemView'         => '/elements/forum/_post',
    'viewParams'       => ['parent' => true],
    'summary'          => '',
    'emptyText'        => Yii::t('podium/view', 'No posts have been added yet.'),
    'emptyTextOptions' => ['tag' => 'h3', 'class' => 'text-muted'],
    'pager'            => ['options' => ['class' => 'pagination float-right']]
]);
Pjax::end(); ?>
<br>
