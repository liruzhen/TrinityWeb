<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\models\User;
use core\modules\forum\Podium;
use core\modules\forum\rbac\Rbac;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

$items = [['label' => Yii::t('podium/view', 'Home'), 'url' => ['forum/index']]];

$podiumModule = Podium::getInstance();

if (Podium::getInstance()->user->isGuest) {
    if (Podium::getInstance()->podiumConfig->get('forum.members_visible')) {
        $items[] = [
            'label'  => Yii::t('podium/view', 'Members'),
            'url'    => ['members/index'],
            'active' => $this->context->id === 'members'
        ];
    }
} else {
    $podiumUser = User::findMe();
    $messageCount = $podiumUser->newMessagesCount;
    $subscriptionCount = $podiumUser->subscriptionsCount;

    if (User::can(User::ROLE_ADMINISTRATOR)) {
        $items[] = [
            'label'  => Yii::t('podium/view', 'Administration'),
            'url'    => ['admin/index'],
            'active' => $this->context->id === 'admin'
        ];
    }
    $items[] = [
        'label'  => Yii::t('podium/view', 'Members'),
        'url'    => ['members/index'],
        'active' => $this->context->id === 'members'
    ];
    $items[] = [
        'label' => Yii::t('podium/view', 'Profile ({name})', ['name' => $podiumUser->podiumName])
                    . ($subscriptionCount ? ' ' . Html::tag('span', $subscriptionCount, ['class' => 'badge']) : ''),
        'url'   => ['profile/index'],
        'items' => [
            ['label' => Yii::t('podium/view', 'My Profile'), 'url' => ['profile/index']],
            ['label' => Yii::t('podium/view', 'Account Details'), 'url' => ['profile/details']],
            ['label' => Yii::t('podium/view', 'Forum Details'), 'url' => ['profile/forum']],
            ['label' => Yii::t('podium/view', 'Subscriptions'), 'url' => ['profile/subscriptions']],
        ]
    ];
    $items[] = [
        'label' => Yii::t('podium/view', 'Messages') . ($messageCount ? ' ' . Html::tag('span', $messageCount, ['class' => 'badge']) : ''),
        'url'   => ['messages/inbox'],
        'items' => [
            ['label' => Yii::t('podium/view', 'Inbox'), 'url' => ['messages/inbox']],
            ['label' => Yii::t('podium/view', 'Sent'), 'url' => ['messages/sent']],
            ['label' => Yii::t('podium/view', 'New Message'), 'url' => ['messages/new']],
        ]
    ];
    if ($podiumModule->userComponent === true) {
        $items[] = ['label' => Yii::t('podium/view', 'Sign out'), 'url' => ['profile/logout'], 'linkOptions' => ['data-method' => 'post']];
    }
}

NavBar::begin([
    'brandLabel'            => $podiumModule->podiumConfig->get('forum.name'),
    'brandUrl'              => ['forum/index'],
    'options'               => ['class' => 'navbar-inverse navbar-default', 'id' => 'top'],
    'innerContainerOptions' => ['class' => 'container-fluid',]
]);
echo Nav::widget([
    'options'         => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels'    => false,
    'activateParents' => true,
    'items'           => $items,
]);
NavBar::end();
