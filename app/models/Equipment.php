<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment".
 *
 * @property string $name
 * @property string $IATACode
 * @property string $ICAOCode
 * @property string $representativeName
 * @property string $type
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 64],
            [['IATACode', 'ICAOCode'], 'string', 'max' => 8],
            [['representativeName'], 'string', 'max' => 36],
            [['type'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'IATACode' => Yii::t('app', 'Iatacode'),
            'ICAOCode' => Yii::t('app', 'Icaocode'),
            'representativeName' => Yii::t('app', 'Representative Name'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
