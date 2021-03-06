<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('common', 'Добавление иконки');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Иконки'), 'url' => ['icons']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="icons-create">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <?php echo $this->render('icon_form', [
        'model' => $model,
    ]); ?>

</div>
