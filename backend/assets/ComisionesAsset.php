<?php

namespace backend\assets;

use yii\web\AssetBundle;

class ComisionesAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/datatables-bs4/css/dataTables.bootstrap4.css',
        'plugins/datatables-responsive/css/responsive.bootstrap4.css',
        'plugins/datatables-buttons/css/buttons.bootstrap4.css',
        'plugins/fontawesome-free/css/fontawesome.css',
        'plugins/sweetalert2/sweetalert2.css',

    ];
    public $js = [
        'plugins/datatables/jquery.dataTables.js',
        'plugins/sweetalert2/sweetalert2.all.js',
        'js/cargos.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
