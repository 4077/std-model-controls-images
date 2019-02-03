<?php namespace std\modelControls\images\controllers;

class Main extends \Controller
{
    private $model;

    public function __create()
    {
        $model = $this->model = $this->data['model'];

        $this->instance_(underscore_model($model));

        $this->dmap('|' . underscore_model($model), 'data');
    }

    public function reload()
    {
        $this->jquery('|')->replace($this->view());
    }

    public function view()
    {
        $v = $this->v('|');

        $model = $this->model;

        $query = $this->data('data/query') or
        $query = '16 16';

        $imagesInstance = $this->data('data/instance');

        $images = $this->c('\std\images~:get', [
            'model'       => $model,
            'instance'    => $imagesInstance,
            'query'       => $query,
            'cache_field' => $this->data('data/cache_field') ?: 'images_cache'
        ]);

        $limit = $this->data('data/limit');

        foreach ($images as $n => $image) {
            $v->assign('image', [
                'CONTENT' => $image->view
            ]);

            if ($limit && $n + 1 >= $limit) {
                break;
            }
        }

        $this->c('\std\ui button:bind', [
            'selector'                    => $this->_selector('|'),
            'path'                        => '>xhr:openDialog',
            'data'                        => [
                'model' => pack_model($model)
            ],
            'eventTriggerClosestSelector' => '.cell'
        ]);

        $this->css();

        $this->c('\std\ui\dialogs~:addContainer:' . $this->_nodeId());

        $this->se(underscore_model($model))->rebind(':reload');

        return $v;
    }
}
