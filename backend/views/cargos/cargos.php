<?php

use yii\helpers\Html;
use backend\assets\ComisionesAsset;

ComisionesAsset::register($this);

$this->title = 'Administración Cargos';
$this->params['breadcrumbs'] = [['label' => 'Admin. Cargos']];
?>

<div class="box">
    <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearCargo">
            Nuevo
        </button>
    </div>
    <br/>
    <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablaCargos" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Sector</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL CREAR CARGO
======================================-->
<div id="modalCrearCargo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Cargo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DEL NUEVO CARGO
                    ======================================-->
                    <div class="form-group">
                        <label for="codigoSectorTrabajoNew">Sector de Trabajo</label>
                        <select id="codigoSectorTrabajoNew" name="codigoSectorTrabajoNew" required
                                class="form-control input-lg">
                            <option value="">Selecionar Sector</option>
                            <?php
                            foreach ($sectoresTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos" style="display: none;">
                        <label for="nombreCargoNew" class="control-label">Nombre</label>
                        <input id="nombreCargoNew" name="nombreCargoNew" type="text" maxlength="150"
                               placeholder="Ingresar nombre del cargo" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos" style="display: none;">
                        <label for="descripcionCargoNew" class="control-label">Descripción</label>
                        <textarea id="descripcionCargoNew" name="descripcionCargoNew" maxlength="120" rows="3"
                                  placeholder="Ingresar descripción del cargo" class="form-control input-lg"></textarea>
                    </div>
                    <div class="form-group entrada-datos" style="display: none;">
                        <label for="requisitosPrincipalesNew" class="control-label">Requisitos Principales</label>
                        <textarea id="requisitosPrincipalesNew" name="requisitosPrincipalesNew" maxlength="120" rows="3"
                                  placeholder="Ingresar requisitos principales del cargo"
                                  class="form-control input-lg"></textarea>
                    </div>
                    <div class="form-group entrada-datos" style="display: none;">
                        <label for="requisitosOpcionalesNew" class="control-label">Requisitos Principales</label>
                        <textarea id="requisitosOpcionalesNew" name="requisitosOpcionalesNew" maxlength="120" rows="3"
                                  placeholder="Ingresar requisitos opcionales del cargo"
                                  class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearCargo" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL ACTUALIZAR CARGO
======================================-->
<div id="modalActualizarCargo" class="modal fade" role="dialog">
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
                     DATOS DEL CARGO MODIFICADO
                     ======================================-->
                    <div class="form-group">
                        <label for="sectorTrabajoUpd" class="control-label">Sector Trabajo</label>
                        <input id="sectorTrabajoUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="nombreCargoUpd" class="control-label">Nombre</label>
                        <input id="codigoCargoUpd" name="codigoCargoUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="nombreCargoUpd" name="nombreCargoUpd" type="text" maxlength="150"
                               placeholder="Ingresar nombre del cargo" required class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="descripcionCargoUpd" class="control-label">Descripción</label>
                        <textarea id="descripcionCargoUpd" name="descripcionCargoUpd" maxlength="120" rows="3"
                                  placeholder="Ingresar descripción del cargo" class="form-control input-lg"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="requisitosPrincipalesUpd" class="control-label">Requisitos Principales</label>
                        <textarea id="requisitosPrincipalesUpd" name="requisitosPrincipalesUpd" maxlength="120" rows="3"
                                  placeholder="Ingresar requisitos principales del cargo"
                                  class="form-control input-lg"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="requisitosOpcionalesUpd" class="control-label">Requisitos Principales</label>
                        <textarea id="requisitosOpcionalesUpd" name="requisitosOpcionalesUpd" maxlength="120" rows="3"
                                  placeholder="Ingresar requisitos opcionales del cargo"
                                  class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarCargo" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>