<?php
namespace backend\models;

class CargoObj extends yii\base\Model {
    private $CodigoCargo;
    private $NombreCargo;
    private $DescripcionCargo;
    private $RequisitosPrincipales;
    private $RequisitosOpcionales;
    private $ArchivoManualFunciones;
    private $CodigoSectorTrabajo;
    private $NombreSectorTrabajo;
    private $CodigoEstado;
    private $FechaHoraRegistro;
    private $CodigoUsuario;

    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function attributeLabels()
    {
        return [
            'CodigoCargo' => 'Codigo',
            'NombreCargo' => 'Nombre',
            'DescripcionCargo' => 'Descripcion',
            'RequisitosPrincipales' => 'Requisitos Principales',
            'RequisitosOpcionales' => 'Requisitos Opcionales',
            'ArchivoManualFunciones' => 'Archivo Manual Funciones',
            'CodigoSectorTrabajo' => 'Codigo Sector',
            'NombreSectorTrabajo' => 'Sector Trabajo',
            'CodigoEstado' => 'Estado',
            'FechaHoraRegistro' => 'Registro',
            'CodigoUsuario' => 'Usuario',
        ];
    }
}