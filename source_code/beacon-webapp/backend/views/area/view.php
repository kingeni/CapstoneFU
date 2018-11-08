<?php

use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\EspSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\Area */

$this->title = 'Area';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

$length = $model['length'] * 1000;
$lengthSquare = $length / 100;

$width = $model['width'] * 1000;
$widthSquare = $width / 100;
?>
<div class="area-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'length',
            'width',
            'note',
        ],
    ]) ?>
</div>
<div class="esp-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProviderEsp,
            'filterModel' => $searchModelEsp,
            'pjax' => true,
            'columns' => [
                [
                    'class' => 'kartik\grid\CheckboxColumn',
                    'width' => '20px',
                ],
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'width' => '30px',
                ],
                // [
                // 'class'=>'\kartik\grid\DataColumn',
                // 'attribute'=>'id',
                // ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'name',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'x',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'y',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'status',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'area_id',
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::to(['esp/' . $action, 'id' => $key]);
                    },
                    'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
                    'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
                    'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
                        'data-confirm' => false, 'data-method' => false,// for overide yii data api
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => 'Are you sure?',
                        'data-confirm-message' => 'Are you sure want to delete this item'],
                ],

            ],
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['esp/create'],
                        ['role' => 'modal-remote', 'title' => 'Create new Esps', 'class' => 'btn btn-default']) .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                        ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Esps listing',
                'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after' => BulkButtonWidget::widget([
                        'buttons' => Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                            ["bulk-delete"],
                            [
                                "class" => "btn btn-danger btn-xs",
                                'role' => 'modal-remote-bulk',
                                'data-confirm' => false, 'data-method' => false,// for overide yii data api
                                'data-request-method' => 'post',
                                'data-confirm-title' => 'Are you sure?',
                                'data-confirm-message' => 'Are you sure want to delete this item'
                            ]),
                    ]) .
                    '<div class="clearfix"></div>',
            ]
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
<?php Pjax::begin(); ?>
<div class="map">
    <svg viewBox="0 0 <?= $length ?> <?= $width ?>" style="border: green solid;">
        <style>
            .small1 {
                font: 30px sans-serif;
            }

            .small2 {
                font: 20px sans-serif;
            }

            /* Note that the color of the text is set with the    *
             * fill property, the color property is for HTML only */
            .Rrrrr {
                font: italic 40px serif;
                fill: red;
            }

            .blink_me {
                animation: blinker 5s linear infinite;
            }
        </style>
        <?php for ($i = 1; $i <= $lengthSquare; $i++) { ?>
            <path stroke="green" stroke-width=".2" d="M<?= $i * 100 ?> 0 V<?= $width ?>"/>
        <?php } ?>

        <?php for ($i = 1; $i <= $widthSquare; $i++) { ?>
            <path stroke="green" stroke-width=".2" d="M0 <?= $i * 100 ?> H<?= $length ?>"/>
        <?php } ?>

        <?php foreach ($modelEsp as $esp) { ?>
            <circle cx="<?= $esp->x * 100 ?>" cy="<?= $esp->y * 100 ?>" r="30" fill="red"/>
            <text x="<?= $esp->x * 100 - 30 ?>" y="<?= $esp->y * 100 + 60 ?>"
                  class="small1"><?= $esp->name ?></text>
        <?php } ?>

        <?php foreach ($listObjCoo as $item) { ?>
            <circle cx="<?= $item->x * 100 ?>" cy="<?= $item->y * 100 ?>" r="15" fill="blue">
                <animate attributeType="XML" attributeName="opacity" from="0" to="1"
                         dur="3s" repeatCount="indefinite"/>
            </circle>
            <text x="<?= $item->x * 100 - 30 ?>" y="<?= $item->y * 100 + 30 ?>"
                  class="small2"><?= \common\models\Object::getNameOfObj($item->object_id) ?></text>
        <?php } ?>

    </svg>
</div>
<?php Pjax::end(); ?>
