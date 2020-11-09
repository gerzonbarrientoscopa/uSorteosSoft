<?php

namespace backend\models;

use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class ComisionesDao
{
    /*=============================================
    CORRELATIVO MAXIMO DE LAS COMISIONES
    =============================================*/
    static public function maximoComisiones()
    {
        $consulta = new Query();
        $arrayMaximo = $consulta->select('max(cast(substring(CodigoComision, len(CodigoComision)-2,len(CodigoComision)) AS int)) AS Maximo')
            ->from('Comisiones')
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }
    }

    /*=============================================
    BUSCA COMISION
    =============================================*/
    static public function buscaComision($campo, $valor)
    {
        //devolver un objeto de la clase CargoObj en caso de ser necesario.
    }

    static public function buscaComisionArray($campo, $valor)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoComision, NombreComision, DescripcionComision, CodigoEstado, FechaHoraRegistro, CodigoUsuario 
                     FROM Comisiones                     
                     WHERE $campo = :$campo ";
        $cargo = $dbRRHH->createCommand($consulta)
                        ->bindParam(":" . $campo, $valor, PDO::PARAM_STR)
                        ->queryOne();
        return $cargo;
    }
}