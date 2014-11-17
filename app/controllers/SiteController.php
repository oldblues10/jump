<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\core\utils\FlightStatsHelper;
use app\core\utils\OpenWeatherMapHelper;
use app\core\utils\GoogleApiHelper;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($currentAirportCode = null, $jump = false, $localArrivalTimeStamp = null)
    {
        if($currentAirportCode != null)
        {
            $atHome             = false;
        }
        else
        {
            $currentAirportCode = 'ORD';
            $atHome             = true;
        }
        if($jump)
        {
            $jumped = (bool)$jump;
        }
        else
        {
            $jumped = false;
        }

        $flightStatsHelper         = new FlightStatsHelper(Yii::$app->params['flightStats']['appId'], Yii::$app->params['flightStats']['appKey']);
        $currentAirportData        = $flightStatsHelper->getAirportDataByCode($currentAirportCode);
        $currentAirportWeatherData = OpenWeatherMapHelper::getWeatherByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);
        $weatherConditionIconUrl   = OpenWeatherMapHelper::getConditionImageUrlByIcon($currentAirportWeatherData['weather'][0]['icon']);
        $mapUrl                    = GoogleApiHelper::getMapByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);
        $streetViewUrl             = GoogleApiHelper::getStreetViewByLatitudeAndLongitude($currentAirportData['latitude'], $currentAirportData['longitude']);


        if(!empty($localArrivalTimeStamp))
        {
            $localTimeStamp = $localArrivalTimeStamp;
        }
        else
        {
            $localTimeStamp = strtotime($currentAirportData['localTime']);
        }
        $airportScheduledData = $flightStatsHelper->getScheduledFlightsByAirportCodeAndDateAndTime(
            $currentAirportCode,
            date('Y', $localTimeStamp),
            date('n', $localTimeStamp),
            date('j', $localTimeStamp),
            date('G', $localTimeStamp));
        //   echo "<pre>";
        // print_r($airportScheduledData);
        //  echo "</pre>";
        //   exit;
        return $this->render('board', ['mapUrl'                    => $mapUrl,
                                       'streetViewUrl'             => $streetViewUrl,
                                       'currentAirportWeatherData' => $currentAirportWeatherData,
                                       'localTimeStamp'            => $localTimeStamp,
                                       'weatherConditionIconUrl'   => $weatherConditionIconUrl,
                                       'currentAirportData'        => $currentAirportData,
                                       'airportScheduledData'      =>$airportScheduledData]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
