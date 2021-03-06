<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 28.11.2018
 * Time: 21:29
 */

namespace app\widgets;


use yii\base\Widget;

/**
 * LeftMenu generated by Project model
 * Class MenuWidget
 * @package app\widgets
 */
class LeftMenu extends Widget {

    public $model;

    public function init () {
        parent::init();
    }

    /**
     * @return string
     */
    public function run() {

        if ($this->model != null)
        {
            return $this->render('left-menu',
                ['model' => $this->model]
            );
        }
    }
}