<?php

namespace backend\controllers;

use Yii;
use common\models\Object;
use backend\models\search\ObjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use common\helper\MQTT;

/**
 * ObjectController implements the CRUD actions for Object model.
 */
class ObjectController extends Controller
{
    public static $brokerAddress = '192.168.43.103';
    public static $host = 1883;
    public static $topic = 'presence';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Object models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Object model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Object #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Object model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Object();
        $model->status = Object::STATUS_ACTIVE;
        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new Object",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {
                $mqtt = new MQTT(self::$brokerAddress, self::$host, "ClientID" . rand()); //Change client name to something unique
                if ($mqtt->connect()) {
                    $mqtt->publish(self::$topic, "NewObj|" . $model->id . "|" . $model->safety_distance, 0);
                    $mqtt->close();
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new Object",
                    'content' => '<span class="text-success">Create Object success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])

                ];
            } else {
                return [
                    'title' => "Create new Object",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                $mqtt = new MQTT(self::$brokerAddress, self::$host, "ClientID" . rand()); //Change client name to something unique
                if ($mqtt->connect()) {
                    $mqtt->publish(self::$topic, "NewObj|" . $model->id . "|" . $model->safety_distance, 0);
                    $mqtt->close();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Object model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update Object #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Object #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update Object #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Object model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();
        $mqtt = new MQTT(self::$brokerAddress, self::$host, "ClientID" . rand()); //Change client name to something unique
        if ($mqtt->connect()) {
            $mqtt->publish(self::$topic, "DeleteObj|" . $id, 0);
            $mqtt->close();
        }
        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    /**
     * Delete multiple existing Object model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Object model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Object the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Object::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateToRas()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            $listObj = Object::find()->where('status<>' . Object::STATUS_NOT_ACTIVE)->all();
            $listObjMAC = '';
            $count = 0;
            if (count($listObj) > 0) {
                foreach ($listObj as $item) {
                    if ($count == count($listObj)) {
                        $listObjMAC = $listObjMAC . $item->id . ';';
                    } else {
                        $listObjMAC = $listObjMAC . $item->id . '.';
                    }
                }
            }

            $mqtt = new MQTT(self::$brokerAddress, self::$host, "ClientID" . rand()); //Change client name to something unique
            if ($mqtt->connect()) {
                $mqtt->publish(self::$topic, "UpdateObjMAC|" . $listObjMAC, 0);
                $mqtt->close();
            }
            return $this->redirect(['index']);
        } else {
            /*
            *   Process for non-ajax request
            */
            $listObj = Object::find()->all();
            $listObjMAC = '';
            $count = 0;
            if (count($listObj) > 0) {
                foreach ($listObj as $item) {
                    if ($count == count($listObj)) {
                        $listObjMAC = $listObjMAC . $item->id . ';';
                    } else {
                        $listObjMAC = $listObjMAC . $item->id . '.';
                    }
                }
            }

            $mqtt = new MQTT(self::$brokerAddress, self::$host, "ClientID" . rand()); //Change client name to something unique
            if ($mqtt->connect()) {
                $mqtt->publish(self::$topic, $listObjMAC, 0);
                $mqtt->close();
            }
            return $this->redirect(['index']);
        }
    }

}
