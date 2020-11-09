<?php

namespace backend\controllers;

use backend\models\ComisionesDao;
use common\models\Comision;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class ComisionesController extends Controller
{
    private $dao;

    public function getDao()
    {
        if ($this->dao == null) {
            $this->dao = new ComisionesDao();
        }
        return $this->dao;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if($action->id == "listar-comisiones-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('cargos');
    }

    public function actionListarComisionesAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            $comisiones = Comision::find()->orderBy('CodigoComision')->all();
            $datosJson = '{"data": [';
            $cantidad = count($comisiones);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($comisiones[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoCargo = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "CADUCADO";
                    $estadoCargo = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoCargo . "' codigo='" . $comisiones[$i]->CodigoComision . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarComision' codigo='" . $comisiones[$i]->CodigoComision . "' data-toggle='modal' data-target='#modalActualizarComision'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnEliminarComision' codigo='" . $comisiones[$i]->CodigoComision . "' nombre='" . $comisiones[$i]->NombreComision . "'><i class='fa fa-times'></i></button></div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $comisiones[$i]->CodigoComision . '",
					 	"' . $comisiones[$i]->NombreComision . '",
					 	"' . $comisiones[$i]->DescripcionComision . '",					 	
				 	 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $comisiones[$i]->CodigoComision . '",
					 	"' . $comisiones[$i]->NombreComision . '",
					 	"' . $comisiones[$i]->DescripcionComision . '",					 	
				 	 	"' . $estado . '",
				      	"' . $acciones . '"
  			  ],';
                }
            }
            $datosJson .= ']}';
            return $datosJson;
        }else{
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function actionActivarComisionAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoactivar"]) && isset($_POST["estadoactivar"])) {
                $comision = Comision::findOne($_POST["codigoactivar"]);
                $estadoActualComision = $comision->CodigoEstado;
                if ($estadoActualComision == "V") {
                    $comision->CodigoEstado = "C";
                } else {
                    $comision->CodigoEstado = "V";
                }
                $comision->save();
                return "ok";
            }else{
                return "error";
            }
        }else{
            return "error";
        }
    }

    public function actionBuscarComisionAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoeditar"])) {
                $comision = ComisionesDao::buscaComisionArray("CodigoComision", $_POST["codigoeditar"]);
                return json_encode($comision);
            }else{
                return "error";
            }
        }else{
            return "error";
        }
    }

    public function actionCrearComisionAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            $maximo = ComisionesDao::maximoComisiones();
            $maximo = $maximo + 1;
            $nuevoCodigo = 'COM';
            if ($maximo <= 99) {
                $nuevoCodigo = $nuevoCodigo . '0';
            }
            if ($maximo <= 9) {
                $nuevoCodigo = $nuevoCodigo . '0';
            }
            $nuevoCodigo = $nuevoCodigo . $maximo;
            $comision = new Comision();
            $comision->CodigoComision = $nuevoCodigo;
            $comision->NombreComision = $_POST["nombrecrear"];
            $comision->DescripcionComision = $_POST["descripcioncrear"];
            $comision->CodigoEstado = 'V';
            $comision->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            $comision->save();
            return "ok";
        }else{
            return "error";
        }
    }

    public function actionActualizarComisionAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoactualizar"])) {
                $comision = Comision::findOne($_POST["codigoactualizar"]);
                $comision->NombreComision = $_POST["nombreactualizar"];
                $comision->DescripcionComision = $_POST["descripcionactualizar"];
                $comision->save();
                return "ok";
            }else{
                return "error";
            }
        }else{
            return "error";
        }
    }

    public function actionEliminarComisionAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoeliminar"])) {
                $comision = Comision::findOne($_POST["codigoeliminar"]);
                if(!$comision->isUsed()){
                    $comision->delete();
                    return "ok";
                }else{
                    return "enUso";
                }
            }else{
                return "error";
            }
        }else{
            return "error";
        }
    }
}