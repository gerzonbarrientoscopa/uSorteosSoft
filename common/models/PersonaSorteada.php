<?php

namespace common\models;

class PersonaSorteada extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'PersonasSorteadas';
    }

    public function rules()
    {
        return [
            [['IdPersona'], 'required'],
            [['IdPersona'], 'string', 'max' => 15],
            [['CodigoSorteo'], 'required'],
            [['CodigoSorteo'], 'string', 'max' => 6],
            [['FechaHoraRegistro'], 'safe'],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['IdPersona'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['IdPersona' => 'IdPersona']],
            [['CodigoSorteo'], 'exist', 'skipOnError' => true, 'targetClass' => Comision::className(), 'targetAttribute' => ['CodigoSorteo' => 'CodigoSorteo']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdPersona' => 'C.I.',
            'CodigoSorteo' => 'Comision',
            'FechaHoraRegistro' => 'Registro',
            'CodigoEstado' => 'Estado',
            'CodigoUsuario' => 'Usuario',
        ];
    }

    public function isUsed()
    {
        $persona = Persona::findOne(['IdPersona' => $this->IdPersona]);
        if($persona != null){
            return true;
        }else{
            $comision = Comision::findOne(['CodigoComision' => $this->CodigoComision]);
            if($comision != null){
                return true;
            }else{
                return false;
            }
        }
    }

    public function getPersona()
    {
        return $this->hasOne(Persona::className(), ['IdPersona' => 'IdPersona']);
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