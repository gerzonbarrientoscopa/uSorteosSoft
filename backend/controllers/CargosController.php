<?php

namespace backend\controllers;

use backend\models\CargosDao;
use common\models\Comision;
use common\models\SectorTrabajo;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class CargosController extends Controller
{
    private $dao;

    public function getDao()
    {
        if ($this->dao == null) {
            $this->dao = new CargosDao();
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
        if($action->id == "listar-cargos-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaSectoresTrabajo = ArrayHelper::map(SectorTrabajo::find()->orderBy('NombreSectorTrabajo')->all(), 'CodigoSectorTrabajo', 'NombreSectorTrabajo');
        return $this->render('cargos', [
            'sectoresTrabajo' => $listaSectoresTrabajo,
        ]);
    }

    public function actionListarCargosAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            $cargos = Comision::find()->orderBy('CodigoCargo')->all();
            $datosJson = '{"data": [';
            $cantidad = count($cargos);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($cargos[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoCargo = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "CADUCADO";
                    $estadoCargo = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoCargo . "' codigo='" . $cargos[$i]->CodigoCargo . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarCargo' codigo='" . $cargos[$i]->CodigoCargo . "' data-toggle='modal' data-target='#modalActualizarCargo'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnEliminarCargo' codigo='" . $cargos[$i]->CodigoCargo . "' nombre='" . $cargos[$i]->NombreCargo . "'><i class='fa fa-times'></i></button></div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $cargos[$i]->CodigoCargo . '",
					 	"' . $cargos[$i]->NombreCargo . '",
					 	"' . $cargos[$i]->DescripcionCargo . '",
					 	"' . $cargos[$i]->sectorTrabajo->NombreSectorTrabajo . '",
				 	 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $cargos[$i]->CodigoCargo . '",
					 	"' . $cargos[$i]->NombreCargo . '",
					 	"' . $cargos[$i]->DescripcionCargo . '",
					 	"' . $cargos[$i]->sectorTrabajo->NombreSectorTrabajo . '",
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

    public function actionActivarCargoAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoactivar"]) && isset($_POST["estadoactivar"])) {
                $cargo = Comision::findOne($_POST["codigoactivar"]);
                $estadoActualCargo = $cargo->CodigoEstado;
                if ($estadoActualCargo == "V") {
                    $cargo->CodigoEstado = "C";
                } else {
                    $cargo->CodigoEstado = "V";
                }
                $cargo->save();
                return "ok";
            }else{
                return "error";
            }
        }else{
            return "error";
        }
    }

    public function actionBuscarCargoAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoeditar"])) {
                $cargo = CargosDao::buscaCargoArray("CodigoCargo", $_POST["codigoeditar"]);
                return json_encode($cargo);
            }else{
                return "error";
            }
        }else{
            return "error";
        }
    }

    public function actionCrearCargoAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            $maximo = CargosDao::maximoCargos($_POST["sectorcrear"]);
            $maximo = $maximo + 1;
            $nuevoCodigo = $_POST["sectorcrear"];
            if ($maximo <= 99) {
                $nuevoCodigo = $nuevoCodigo . '0';
            }
            if ($maximo <= 9) {
                $nuevoCodigo = $nuevoCodigo . '0';
            }
            $nuevoCodigo = $nuevoCodigo . $maximo;
            $cargo = new Comision();
            $cargo->CodigoCargo = $nuevoCodigo;
            $cargo->NombreCargo = $_POST["nombrecrear"];
            $cargo->DescripcionCargo = $_POST["descripcioncrear"];
            $cargo->RequisitosPrincipales = $_POST["requisitosprincipalescrear"];
            $cargo->RequisitosOpcionales = $_POST["requisitosopcionalescrear"];
            $cargo->ArchivoManualFunciones = $nuevoCodigo . '.pdf';
            $cargo->CodigoSectorTrabajo = $_POST["sectorcrear"];
            $cargo->CodigoEstado = 'V';
            $cargo->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if(!$cargo->exist()){
                $cargo->save();
                return "ok";
            }else{
                return "existe";
            }
        }else{
            return "error";
        }
    }

    public function actionActualizarCargoAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoactualizar"])) {
                $cargo = Comision::findOne($_POST["codigoactualizar"]);
                $cargo->NombreCargo = $_POST["nombreactualizar"];
                $cargo->DescripcionCargo = $_POST["descripcionactualizar"];
                $cargo->RequisitosPrincipales = $_POST["requisitosprincipalesactualizar"];
                $cargo->RequisitosOpcionales = $_POST["requisitosopcionalesactualizar"];
                if(!$cargo->exist()){
                    $cargo->save();
                    return "ok";
                }else{
                    return "existe";
                }
            }else{
                return "error";
            }
        }else{
            return "error";
        }
    }

    public function actionEliminarCargoAjax(){
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if (isset($_POST["codigoeliminar"])) {
                $cargo = Comision::findOne($_POST["codigoeliminar"]);
                if(!$cargo->isUsed()){
                    $cargo->delete();
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