<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "object".
 *
 * @property string $id
 * @property string $name
 * @property string $note
 * @property int $status
 * @property int $area_id
 */
class Object extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'note', 'status', 'area_id'], 'required'],
            [['status', 'area_id'], 'integer'],
            [['id', 'name'], 'string', 'max' => 300],
            [['note'], 'string', 'max' => 500],
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
            'note' => 'Note',
            'status' => 'Status',
            'area_id' => 'Area ID',
        ];
    }
}
