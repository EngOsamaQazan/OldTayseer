<?php

namespace common\helper;

use yii\base\Widget;
use yii\helpers\Html;

class BulkButtonWidget extends Widget{

    public $buttons;

    public function init(){
        parent::init();

    }

    public function run(){
        $content = '<div class="float-left">'.
            '<span class="fas fa-arrow-right"></span>&nbsp;&nbsp;With selected&nbsp;&nbsp;'.
            $this->buttons.
            '</div>';
        return $content;
    }
}