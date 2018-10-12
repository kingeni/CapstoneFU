<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "object_coordinates".
 *
 * @property int $id
 * @property string $object_id
 * @property double $x
 * @property double $y
 * @property string $created_at
 */
class ObjectCoordinates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_coordinates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'x', 'y'], 'required'],
            [['x', 'y'], 'number'],
            [['created_at'], 'safe'],
            [['object_id'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'object_id' => 'Object ID',
            'x' => 'X',
            'y' => 'Y',
            'created_at' => 'Created At',
        ];
    }
}
