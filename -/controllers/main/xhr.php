<?php namespace std\modelControls\images\controllers\main;

class Xhr extends \Controller
{
    public $allow = self::XHR;

    public function openDialog()
    {
        if ($model = $this->unpackModel()) {
            $this->dmap('~|' . underscore_model($model), 'data');

            $editorInstance = $this->data('editor/instance');

            if ($titleCall = $this->data('editor/calls/title')) {
                $titleCall = \ewma\Data\Data::tokenize($titleCall, [
                    '%model' => $model
                ]);
            }

            $this->c('\std\ui\dialogs~:open:images, ss|' . $this->_nodeId('<'), [
                'path'          => '\std\images\ui~:view|' . $editorInstance,
                'data'          => [
                    'imageable'   => pack_model($model),
                    'instance'    => $this->data('data/instance'),
                    'cache_field' => $this->data('data/cache_field'),
                    'href'        => $this->data('data/href'),
                    'callbacks'   => [
                        'update' => $this->_abs('app:updateCallback', [
                            'model' => '%imageable',
                        ])
                    ]
                ],
                'class'         => 'padding',
                'pluginOptions' => [
                    'title' => $titleCall ? $this->_call($titleCall)->perform() : ''
                ],
                'default'       => [
                    'pluginOptions' => [
                        'width'  => 600,
                        'height' => 200
                    ]
                ]
            ]);
        }

        // todo close on delete
//            $this->e(underscore_model($model))->trigger([
//                                                            'model'    => $model,
//                                                            'data_set' => _j64($this->data('data_set'))
//                                                        ]);
    }
}
