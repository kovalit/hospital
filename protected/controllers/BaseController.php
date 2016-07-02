<?php

abstract class BaseController extends CController {

	public $layout = null;
        
        public function renderList(array $data) {
		$items = [];
                foreach ($data as $item) {
                        $items[$item['id']] = $item['name'];
                }
                
                $this->renderJson($items);
	}

	public function renderJson(array $data) {
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data, defined('JSON_UNESCAPED_UNICODE')? JSON_UNESCAPED_UNICODE: 0 );
		Yii::app()->end();
	}
}
