<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Equipment;

class EquipmentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = Equipment::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $equipment = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'equipment' => $equipment,
            'pagination' => $pagination,
        ]);
    }

}
