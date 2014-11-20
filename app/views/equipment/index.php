<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
    <h1>Equipment</h1>
    <ul>
        <?php foreach ($equipment as $pieceOfEquipment): ?>
            <li>
                <?= Html::encode("{$pieceOfEquipment->name}") ?>:
                <?= $pieceOfEquipment->IATACode ?>:
                <?= $pieceOfEquipment->ICAOCode ?>:
                <?= $pieceOfEquipment->representativeName ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>