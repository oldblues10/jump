<?php
use yii\helpers\Html;
use app\core\utils\MiscUtil;
use app\core\utils\ViewUtil;
?>
<div class="site-board">
    <img src='<?= $mapUrl ?>'>
    <img src='<?= $streetViewUrl ?>'>
    <BR>weather:<?= $currentAirportWeatherData['weather'][0]['description'] ?>
    <BR><img src='<?= $weatherConditionIconUrl  ?>'><BR>
    current temp: <?= MiscUtil::convertKelvinToFarenheit($currentAirportWeatherData['main']['temp']) ?><BR>
    max temp: <?= MiscUtil::convertKelvinToFarenheit($currentAirportWeatherData['main']['temp_min']) ?><BR>
    min temp: <?= MiscUtil::convertKelvinToFarenheit($currentAirportWeatherData['main']['temp_max']) ?><BR>
    <?= date("F j, Y, g:i a", $localTimeStamp) ?>
    <?= ViewUtil::renderScheduledView($currentAirportData, $localTimeStamp, $airportScheduledData) ?>
</div>
