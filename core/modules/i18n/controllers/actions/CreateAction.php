<?php

namespace core\modules\i18n\controllers\actions;

use core\modules\i18n\models\Language;
use Yii;
use yii\widgets\ActiveForm;

/**
 * Creates a new Language model.
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.3
 */
class CreateAction extends \yii\base\Action
{
    /**
     * Creates a new Language model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function run()
    {
        $model = new Language();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        } elseif ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['view', 'id' => $model->language_id]);
        }
  
            return $this->controller->render('create', [
                'model' => $model,
            ]);
    }
}
