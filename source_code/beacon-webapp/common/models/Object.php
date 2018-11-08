<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "object".
 *
 * @property string $id
 * @property string $name
 * @property double $safety_distance
 * @property string $note
 * @property int $status
 * @property int $area_id
 */
class Object extends \yii\db\ActiveRecord
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_UNSAFETY = 3;

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
            [['id', 'name', 'safety_distance'], 'required'],
            [['safety_distance'], 'number'],
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
            'safety_distance' => 'Safety Distance',
            'note' => 'Note',
            'status' => 'Status',
            'area_id' => 'Area ID',
        ];
    }

    /**
     * Returns object statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_UNSAFETY => Yii::t('common', 'Unsafety')
        ];
    }

    public static function getNameOfObj($id){
        return (Object::find()->where(['id'=>$id])->one())->name;
    }
}
