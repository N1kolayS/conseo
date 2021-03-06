<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 04.12.2018
 * Time: 16:33
 */

namespace frontend\controllers;


use common\models\Channel;
use common\models\Project;
use common\models\Visit;
use common\models\WidgetFrame;
use Yii;

use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\Template;

class FrameController extends Controller
{

    /**
     * @param $id - widget_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDebug($id)
    {
        $this->layout = 'frame';
        $widget = $this->findWidget($id);

        $widget->mobile = Yii::$app->getRequest()->getQueryParam('mobile');
        return $this->render('debug', [
            'widget' => $widget,
        ]);
    }

    /**
     * @param $id - widget_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDemo($id)
    {
        $params = Yii::$app->getRequest()->getQueryParams();
        $this->layout = 'frame';
        $widget = $this->findWidget($id);
        $widget->setAttributes($params);
        $widget->mobile = false;
        return $this->render('demo', [
            'widget' => $widget,
            'visit' => false
        ]);
    }

    /**
     * Production
     * @param $id - widget_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProd($id)
    {

        $this->layout = 'frame';
        $widget = $this->findWidget($id);
        $request =  Yii::$app->getRequest();
        $visit = Visit::findByCookieAndChannel($request->getQueryParam('cookie'), $request->getQueryParam('channel'));
        $channel = Channel::findOne( $request->getQueryParam('channel'));
        if ($channel)
        {
            $widget->mobile = $request->getQueryParam('mobile');
            $widget->code = $channel->code;

            return $this->render('demo', [
                'widget' => $widget,
                'visit' => $visit
            ]);
        }
        else
        {
            $widget->mobile = $request->getQueryParam('mobile');
            return $this->render('demo', [
                'widget' => $widget,
                'visit' => false
            ]);
        }


    }

    /**
     * Finds the Default Widgets by Project id
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WidgetFrame the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findWidget($id)
    {
        if (($model = WidgetFrame::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Widget not exist.');
        }
    }


}