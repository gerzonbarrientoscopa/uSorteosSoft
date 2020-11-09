<?php

namespace common\models;

class Comision extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'Sorteos';
    }

    public function rules()
    {
        return [
            [['CodigoComision'], 'unique'],
            [['CodigoComision'], 'required'],
            [['CodigoComision'], 'string', 'max' => 6],
            [['NombreComision'], 'required'],
            [['NombreComision'], 'string', 'max' => 150],
            [['DescripcionComision'], 'string', 'max' => 500],
            [['FechaHoraRegistro'], 'safe'],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'CodigoComision' => 'Codigo',
            'NombreComision' => 'Nombre',
            'DescripcionComision' => 'Descripcion',
            'FechaHoraRegistro' => 'Registro',
            'CodigoEstado' => 'Estado',
            'CodigoUsuario' => 'Usuario',
        ];
    }

    public function isUsed()
    {
        $items = Persona::find()->where(["CodigoComision" =>$this->CodigoSorteo])->all();
        if(!empty($items)){
            return true;
        }else{
            return false;
        }
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }
}