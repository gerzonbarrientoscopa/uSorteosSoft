<?php

use backend\assets\ComisionesAsset;

ComisionesAsset::register($this);

$this->title = 'Administración Comisiones';
$this->params['breadcrumbs'] = [['label' => 'Admin. Comisiones']];
?>

<div class="box">
    <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearCargo">
            Nuevo
        </button>
    </div>
    <br/>
    <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablaComisiones" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL CREAR COMISION
======================================-->
<div id="modalCrearComision" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Comisión</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DE LA NUEVA COMISION
                    ======================================-->
                    <div class="form-group entrada-datos">
                        <label for="nombreCargoNew" class="control-label">Nombre</label>
                        <input id="nombreCargoNew" name="nombreCargoNew" type="text" maxlength="150"
                               placeholder="Ingresar nombre de la comisión" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="descripcionCargoNew" class="control-label">Descripción</label>
                        <textarea id="descripcionCargoNew" name="descripcionCargoNew" maxlength="120" rows="3"
                                  placeholder="Ingresar descripción de la comisión" class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearComision" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL ACTUALIZAR COMISION
======================================-->
<div id="modalActualizarComision" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Cargo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DE LA COMISION MODIFICADA
                     ======================================-->
                    <div class="form-group">
                        <label for="nombreComisionUpd" class="control-label">Nombre</label>
                        <input id="codigoComisionUpd" name="codigoComisionUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="nombreComisionUpd" name="nombreComisionUpd" type="text" maxlength="150"
                               placeholder="Ingresar nombre de la comisión" required class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="descripcionComisionUpd" class="control-label">Descripción</label>
                        <textarea id="descripcionComisionUpd" name="descripcionComisionUpd" maxlength="120" rows="3"
                                  placeholder="Ingresar descripción de la comisión" class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarComision" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>