<?php

namespace common\models;

class Persona extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Personas';
    }

    public function rules()
    {
        return [
            [['IdPersona'], 'unique'],
            [['IdPersona'], 'required'],
            [['IdPersona'], 'string', 'max' => 15],
            [['Paterno', 'Materno'], 'string', 'max' => 25],
            [['Nombres'], 'string', 'max' => 50],
            [['Sexo'], 'string', 'max' => 1],
            [['Tipo'], 'string', 'max' => 10],
            [['FechaHoraRegistro'], 'safe'],
            [['CodigoComision'], 'required'],
            [['CodigoComision'], 'string', 'max' => 6],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['CodigoComision'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['CodigoComision' => 'CodigoComision']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdPersona' => 'C.I.',
            'Paterno' => 'Paterno',
            'Materno' => 'Materno',
            'Nombres' => 'Nombres',
            'FechaNacimiento' => 'Fec. Nac.',
            'Sexo' => 'Sexo',
            'Tipo' => 'Estamento',
            'FechaHoraRegistro' => 'Registro',
            'CodigoComision' => 'Comision',
            'CodigoEstado' => 'Estado',
            'CodigoUsuario' => 'Usuario',
        ];
    }

    public function getSexoLiteral()
    {
        if ($this->Sexo == 'F') {
            $sexoLiteral = 'Femenino';
        } else {
            if ($this->Sexo == 'M') {
                $sexoLiteral = 'Masculino';
            } else {
                $sexoLiteral = 'otro';
            }
        }
        return $sexoLiteral;
    }

    public function getNombreCompleto()
    {
        $nombreCompleto = "";
        if(!$this->Paterno){
            $nombreCompleto=$nombreCompleto."";
        }else{
            $nombreCompleto=$nombreCompleto.$this->Paterno;
        }
        $nombreCompleto=$nombreCompleto." ";
        if(!$this->Materno){
            $nombreCompleto=$nombreCompleto."";
        }else{
            $nombreCompleto=$nombreCompleto.$this->Materno;
        }
        $nombreCompleto=$nombreCompleto." ";
        if(!$this->Nombres){
            $nombreCompleto=$nombreCompleto."";
        }else{
            $nombreCompleto=$nombreCompleto.$this->Nombres;
        }
        return strtoupper($nombreCompleto);
    }

    public function isUsed()
    {
        $personasorteada = PersonaSorteada::findOne(['IdPersona' => $this->IdPersona]);
        if($personasorteada != null){
            return true;
        }else{
            return false;
        }
    }

    public function getComision()
    {
        return $this->hasOne(Comision::className(), ['CodigoComision' => 'CodigoComision']);
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