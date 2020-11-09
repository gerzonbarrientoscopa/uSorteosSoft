<aside class="main-sidebar sidebar-light-primary elevation-0">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/icono.png" alt="UrrhhSoft Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?=Yii::$app->name?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Administración',
                        'icon' => 'th',
                        'badge' => '<span class="right badge badge-info">7</span>',
                        'items' => [
                            ['label' => 'Sorteos', 'url' => ['sorteos/index'], 'iconStyle' => 'far'],
                            ['label' => 'Participantes', 'url' => ['participantes/index'], 'iconStyle' => 'far'],
                            ['label' => 'Elegidos', 'url' => ['elegidos/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>