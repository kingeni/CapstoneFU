<?php

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
            'safety_distance',
            'note',
            'status',
            'area_id',
        ],
    ]) ?>

</div>
