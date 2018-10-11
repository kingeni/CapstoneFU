<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ObjectCoordinates */
?>
<div class="object-coordinates-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'object_id',
            'x',
            'y',
            'created_at',
        ],
    ]) ?>

</div>
