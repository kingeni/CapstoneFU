<?php

namespace backend\controllers;

use common\helper\MQTT;
use Yii;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';

        return parent::beforeAction($action);
    }

    public function actionPublish()
    {
        $mqtt = new MQTT("broker.hivemq.com", 1883, "phpMQTT-subscriber"); //Change client name to something unique

        if ($mqtt->connect()) {
            $mqtt->publish("presence", "asjjldjalksjd", 0);
            $mqtt->close();
        }
    }

}
