<?php

namespace backend\models;

use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class CargosDao
{
    /*=============================================
    CORRELATIVO MAXIMO DE LOS CARGOS
    =============================================*/
    static public function maximoCargos($codigoSectorTrabajo)
    {
        $consulta = new Query();
        $arrayMaximo = $consulta->select('max(cast(substring(CodigoCargo, len(CodigoCargo)-2,len(CodigoCargo)) AS int)) AS Maximo')
            ->from('Cargos')
            ->where(['CodigoSectorTrabajo' => $codigoSectorTrabajo])
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }
    }

    /*=============================================
    BUSCA CARGO
    =============================================*/
    static public function buscaCargo($campo, $valor)
    {
        //devolver un objeto de la clase CargoObj en caso de ser necesario.
    }

    static public function buscaCargoArray($campo, $valor)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT car.CodigoCargo, car.NombreCargo, car.DescripcionCargo, car.RequisitosPrincipales, car.RequisitosOpcionales, car.ArchivoManualFunciones, car.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoEstado, car.FechaHoraRegistro, car.CodigoUsuario 
                     FROM Cargos car
                     INNER JOIN SectoresTrabajo sec ON car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo
                     WHERE $campo = :$campo ";
        $cargo = $dbRRHH->createCommand($consulta)
                        ->bindParam(":" . $campo, $valor, PDO::PARAM_STR)
                        ->queryOne();
        return $cargo;
    }
}