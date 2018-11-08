<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Esp */
?>
<div class="esp-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'x',
            'y',
            'status',
            'area_id',
        ],
    ]) ?>

</div>
