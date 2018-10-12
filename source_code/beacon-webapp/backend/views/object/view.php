<?php

use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Object */
?>
<div class="object-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'note',
            'status',
            'area_id',
        ],
    ]) ?>

    <h3>Coordinates History </h3>
    <div class="object-coordinates-index">
        <div id="ajaxCrudDatatable">
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'object_id',
                    'x',
                    'y',
                    'created_at',
                ],
            ]) ?>
        </div>
    </div>
</div>
