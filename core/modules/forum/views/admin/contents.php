<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 */

use core\modules\forum\models\Content;
use core\modules\forum\widgets\quill\QuillFull;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('podium/view', 'Contents');
$this->params['breadcrumbs'][] = ['label' => Yii::t('podium/view', 'Administration Dashboard'), 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('/elements/admin/_navbar', ['active' => 'contents']);

?>
<br>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="<?php echo $model->name === Content::TERMS_AND_CONDS ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin/contents', 'name' => Content::TERMS_AND_CONDS]); ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?php echo Yii::t('podium/view', 'Forum Terms and Conditions'); ?></a></li>
            <li role="presentation" class="<?php echo $model->name === Content::EMAIL_REGISTRATION ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin/contents', 'name' => Content::EMAIL_REGISTRATION]); ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?php echo Yii::t('podium/view', 'Registration e-mail'); ?></a></li>
            <li role="presentation" class="<?php echo $model->name === Content::EMAIL_NEW ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin/contents', 'name' => Content::EMAIL_NEW]); ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?php echo Yii::t('podium/view', 'New address activation e-mail'); ?></a></li>
            <li role="presentation" class="<?php echo $model->name === Content::EMAIL_REACTIVATION ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin/contents', 'name' => Content::EMAIL_REACTIVATION]); ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?php echo Yii::t('podium/view', 'Account reactivation e-mail'); ?></a></li>
            <li role="presentation" class="<?php echo $model->name === Content::EMAIL_PASSWORD ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin/contents', 'name' => Content::EMAIL_PASSWORD]); ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?php echo Yii::t('podium/view', 'Password reset e-mail'); ?></a></li>
            <li role="presentation" class="<?php echo $model->name === Content::EMAIL_SUBSCRIPTION ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin/contents', 'name' => Content::EMAIL_SUBSCRIPTION]); ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?php echo Yii::t('podium/view', 'New post in subscribed thread'); ?></a></li>
        </ul>
<?php if (substr($model->name, 0, 6) === 'email-'): ?>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo Yii::t('podium/view', 'Content variables'); ?></h3>
            </div>
            <div class="panel-body">
                <strong>{forum}</strong> <?php echo Yii::t('podium/view', "This forum's name"); ?><br>
                <strong>{link}</strong> <?php echo Yii::t('podium/view', 'The link coming with email'); ?><br>
            </div>
        </div>
<?php endif; ?>
    </div>
    <div class="col-md-9 col-sm-8">
        <?php $form = ActiveForm::begin(['id' => 'content-form']); ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $form->field($model, 'topic')->textInput(['placeholder' => Yii::t('podium/view', 'Topic'), 'autofocus' => true])->label(false); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $form->field($model, 'content')->label(false)->widget(QuillFull::class, ['options' => ['style' => 'min-height:320px;']]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('podium/view', 'Save Content'), ['class' => 'btn btn-block btn-primary', 'name' => 'save-button']); ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><br>
