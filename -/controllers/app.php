<?php namespace std\modelControls\images\controllers;

class App extends \Controller
{
    public function updateCallback()
    {
        if ($model = $this->data('model')) {
            $this->dmap('~|' . underscore_model($model), 'data');

            if ($updateCallback = $this->data('data/editor/callbacks/update')) {
                $this->_call($updateCallback)->ra(['model' => $model])->perform();
            }

            $this->se(underscore_model($model))->trigger(['model' => $model]);
        }
    }
}
