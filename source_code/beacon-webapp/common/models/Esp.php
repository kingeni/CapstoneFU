<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "esp".
 *
 * @property string $id
 * @property string $name
 * @property double $x
 * @property double $y
 * @property int $status
 * @property int $area_id
 */
class Esp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'esp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'x', 'y', 'status', 'area_id'], 'required'],
            [['x', 'y'], 'number'],
            [['status', 'area_id'], 'integer'],
            [['id', 'name'], 'string', 'max' => 300],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'x' => 'X',
            'y' => 'Y',
            'status' => 'Status',
            'area_id' => 'Area ID',
        ];
    }
}
