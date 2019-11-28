<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
/**
*
*@author Alberto Cortes Morales
*@since 16-jun-2019
*@version 1.0
* 
*/
class Api2 extends REST_Controller {

  
    function __construct(){
        parent::__construct();
        $this->load->model('DAO');
    }

    /**
  *@param id 
  *@return response
  */ 


  function alta_put(){
    $id = $this->get('id');
    $id1 = $this->get('id1');
    $id2 = $this->get('id2');
    $id3 = $this->get('id3');
    $idExists = $this->DAO->selectEntity('persons',array('idPerson'=>$id),TRUE);
    $id1Exists = $this->DAO->selectEntity('users',array('idUser'=>$id1),TRUE);
    $id2Exists = $this->DAO->selectEntity('address',array('idAddress'=>$id2),TRUE);
    $id3Exists = $this->DAO->selectEntity('employee',array('idEmployee'=>$id3),TRUE);
    if ($id && $id1 &&  $id2 && $id3 && $idExists['data'] && $id1Exists['data'] && $id2Exists['data'] && $id3Exists['data']) {
      if (count($this->put())>29) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array(
                  "namePerson"=>"Required",
                  "lastnamePerson"=>"Required",
                  "genre"=>"Required",
                  "birtdate"=>"Required",
                  "CURP"=>"Required",
                  "age"=>"Required",
                  "civilStatus"=>"Required",
                  "phonePerson"=>"Required",
                  "fkAddress"=>"Required",
                  "emailUser"=>"Required",
                  "passUser"=>"Required",
                  "typeUser"=>"Required",
                  "fkPerson"=>"Required",
                  "street"=>"Required",
                  "numberInt"=>"Required",
                  "numberExt"=>"Required",
                  "neighborhood"=>"Required",
                  "postalCode"=>"Required",
                  "state"=>"Required",
                  "townShip"=>"Required",
                  "RFC"=>"Required",
                  "tipeContract"=>"Required",
                  "noSecure"=>"Required"
                ), 
                "data"=>NULL
        );
      }else if(count($this->put())==0){
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No Params Recived",
                "validations"=>array(
                  "namePerson"=>"Required",
                    "lastnamePerson"=>"Required",
                    "genre"=>"Required",
                    "birtdate"=>"Required",
                    "CURP"=>"Required",
                    "age"=>"Required",
                    "civilStatus"=>"Required",
                    "phonePerson"=>"Required",
                    "fkAddress"=>"Required",
                    "emailUser"=>"Required",
                    "passUser"=>"Required",
                    "typeUser"=>"Required",
                    "fkPerson"=>"Required",
                    "street"=>"Required",
                    "numberInt"=>"Required",
                    "numberExt"=>"Required",
                    "neighborhood"=>"Required",
                    "postalCode"=>"Required",
                    "state"=>"Required",
                    "townShip"=>"Required",
                    "RFC"=>"Required",
                    "tipeContract"=>"Required",
                    "noSecure"=>"Required" 
                ), 
                "data"=>NULL
        );
      }else{
        $this->form_validation->set_data($this->put());          
        $this->form_validation->set_rules('namePerson','Nombre','required');
        $this->form_validation->set_rules('lastnamePerson','Apellido','required');
        $this->form_validation->set_rules('genre','Genero','required');
        $this->form_validation->set_rules('birtdate','Nacimiento','required');
        $this->form_validation->set_rules('CURP','CURP','required');
        $this->form_validation->set_rules('age','Edad','required');
        $this->form_validation->set_rules('civilStatus','Estado civil','required');
        $this->form_validation->set_rules('phonePerson','Telefono','required');
        $this->form_validation->set_rules('emailUser','Email','required');
        $this->form_validation->set_rules('passUser','passUser','required');
        $this->form_validation->set_rules('typeUser','Tipo Usuario','required');
        $this->form_validation->set_rules('street','calle','required');
        $this->form_validation->set_rules('numberInt','Numero Interior','required');
        $this->form_validation->set_rules('numberExt','Numero Exterior','required');
        $this->form_validation->set_rules('neighborhood','Colonia','required');
        $this->form_validation->set_rules('postalCode','Codigo Postal','required');
        $this->form_validation->set_rules('state','Estado','required');
        $this->form_validation->set_rules('townShip','Municipio','required');
        $this->form_validation->set_rules('RFC','RFC','required');
        $this->form_validation->set_rules('tipeContract','Tipo de Contrato','required');
        $this->form_validation->set_rules('noSecure','Numero de Seguro','required');        
          if ($this->form_validation->run()==FALSE) {
            $response = array(
            "status"=>"error", 
                  "status_code"=>409, 
                  "message"=>"Validations Failed",
                  "validations"=>$this->form_validation->error_array(),
                  "data"=>NULL
          );
          }else{
            $data = array(
              "street"=>$this->put('street'),
              "numberInt"=>$this->put('numberInt'),
              "numberExt"=>$this->put('numberExt'),
              "neighborhood"=>$this->put('neighborhood'),
              "postalCode"=>$this->put('postalCode'),
              "state"=>$this->put('state'),
              "townShip"=>$this->put('townShip')
            );
            $response1 = $this->DAO->saveOrUpdate('address',$data,array('idAddress'=>$id2)); 
            $data2 = array(              
              "namePerson"=>$this->put('namePerson'),
              "lastnamePerson"=>$this->put('lastnamePerson'),
              "genre"=>$this->put('genre'),
              "birtdate"=>$this->put('birtdate'),
              "age"=>$this->put('age'),
              "CURP"=>$this->put('CURP'),
              "civilStatus"=>$this->put('civilStatus'),
              "phonePerson"=>$this->put('phonePerson'),                               
              );
              $response2 = $this->DAO->saveOrUpdate('persons',$data2,array('idPerson'=>$id));                
              $data3 = array(
                "emailUser"=>$this->put('emailUser'),
                "passUser"=>$this->put('passUser'),
                "typeUser"=>$this->put('typeUser'),                                
              );
              $response3 = $this->DAO->saveOrUpdate('users',$data3,array('idUser'=>$id1));                            
              $data4 = array(
                "RFC"=>$this->put('RFC'),
                "tipeContract"=>$this->put('tipeContract'),
                "noSecure"=>$this->put('noSecure'),                  
              );
              $response3 = $this->DAO->saveOrUpdate('employee',$data4,array('idEmployee'=>$id3)); 
          }
      }
    }else{
      $response = array(
        "status"=>"error", 
            "status_code"=>409, 
            "message"=>"No ID Provided OR It Does't Exists",
            "validations"=>array(
              "id"=>"Id Via Get",
              "namePerson"=>"Required",
                      "lastnamePerson"=>"Required",
                      "genre"=>"Required",
                      "birtdate"=>"Required",
                      "CURP"=>"Required",
                      "civilStatus"=>"Required",
                      "phonePerson"=>"Required",
                      "age"=>"Required",
                      "fkAddress"=>"Required",
                      "emailUser"=>"Required",
                      "passUser"=>"Required",
                      "typeUser"=>"Required",
                      "fkPerson"=>"Required",
                      "street"=>"Required",
                      "numberInt"=>"Required",
                      "numberExt"=>"Required",
                      "neighborhood"=>"Required",
                      "postalCode"=>"Required",
                      "state"=>"Required",
                      "townShip"=>"Required",
                      "RFC"=>"Required",
                      "tipeContract"=>"Required",
                      "noSecure"=>"Required"
              ), 
            "data"=>NULL
      );
    }
    $this->response($response3);
  }

    
 }
