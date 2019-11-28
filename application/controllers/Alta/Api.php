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
class Api extends REST_Controller {

  
    function __construct(){
        parent::__construct();
        $this->load->model('DAO');
    }

    /**
  *@param id 
  *@return response
  */

  

    function alta_get(){
      
      $id = $this->get('id');
      if (count($this->get())>1) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array('id'=>"Send Id To Get An person"), 
                "data"=>NULL
        );
      }else if ($id) {
        $response = $this->DAO->selectEntity('altaview',array('idPerson'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('altaview', null, false);
      }
      $this->response($response,$response['status_code']);
    }

    
    function altaV_get(){
      
      $id = $this->get('id');
      if (count($this->get())>1) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array('id'=>"Send Id To Get An person"), 
                "data"=>NULL
        );
      }else if ($id) {
        $response = $this->DAO->selectEntity('altaview',array('idPerson'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('altaview', null, false);
      }
      $this->response($response,$response['status_code']);
    }

    function employeeV_get(){
      
      $id = $this->get('id');
      if (count($this->get())>1) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array('id'=>"Send Id To Get An person"), 
                "data"=>NULL
        );
      }else if ($id) {
        $response = $this->DAO->selectEntity('emleadoview',array('idPerson'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('emleadoview', null, false);
      }
      $this->response($response,$response['status_code']);
    }

    function alta_post(){
      if (count($this->post())>25){
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
      }else if(count($this->post())==0){
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
      }else{
          $this->form_validation->set_data($this->post());
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
              "street"=>$this->post('street'),
              "numberInt"=>$this->post('numberInt'),
              "numberExt"=>$this->post('numberExt'),
              "neighborhood"=>$this->post('neighborhood'),
              "postalCode"=>$this->post('postalCode'),
              "state"=>$this->post('state'),
              "townShip"=>$this->post('townShip')
            );
            $addressId = $this->DAO->saveOrUpdate('address',$data);            
            if($addressId){
              $data2 = array(              
              "namePerson"=>$this->post('namePerson'),
              "lastnamePerson"=>$this->post('lastnamePerson'),
              "genre"=>$this->post('genre'),
              "birtdate"=>$this->post('birtdate'),
              "age"=>$this->post('age'),
              "CURP"=>$this->post('CURP'),
              "civilStatus"=>$this->post('civilStatus'),
              "phonePerson"=>$this->post('phonePerson'),
              "fkAddress"=>$addressId['data']                
              );
              $personid = $this->DAO->saveOrUpdate('persons',$data2);
              $data3 = array(
                "emailUser"=>$this->post('emailUser'),
                "passUser"=>$this->post('passUser'),
                "typeUser"=>$this->post('typeUser'),              
                "fkPerson"=>$personid['data'],
              );                       
              $response = $this->DAO->saveOrUpdate('users',$data3);             
              $data4 = array(
                "RFC"=>$this->post('RFC'),
                "tipeContract"=>$this->post('tipeContract'),
                "noSecure"=>$this->post('noSecure'),              
                "fkPerson"=>$personid['data'],
              );                       
              $responseid = $this->DAO->saveOrUpdate('employee',$data4); 

              $tipo = $data3['typeUser'];  
              switch($tipo){                
                case 'Medic':
                $data5 = array(
                  "professionalId"=>$this->post('professionalId'),                             
                  "fkEmployee"=>$responseid['data']
                );
                $responseid = $this->DAO->saveOrUpdate('medics',$data5);
                case 'Collection':
                $data4 = array(                                
                  "fkEmployee"=>$responseid['data']
                );
               // $responseid = $this->DAO->saveOrUpdate('persons',$data2);
                break;
                case 'Receptionist':
                $data4 = array(                                
                  "fkEmployee"=>$responseid['data']
                );
                //$responseid = $this->DAO->saveOrUpdate('persons',$data2);
                break;
              }              
            }else{
              $response = array(
                "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"No ID Provided OR It Does't Exists",
                    "validations"=>array(                      
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
          }
      }
      $this->response($response,200);
    }


    function altastatus_put(){
      $id = $this->get('id');
      $EnoatencionExists = $this->DAO->selectEntity('persons',array('idPerson'=>$id),TRUE);
      if ($id && $EnoatencionExists['data']) {
        if (count($this->put())>2) {
          $response = array(
            "status"=>"error", 
                  "status_code"=>409, 
                  "message"=>"Too Many Params Recived",
                  "validations"=>array(
                      "statusPerson"=>"Required" 
                  ), 
                  "data"=>NULL
          );
        }else if(count($this->put())==0){
          $response = array(
            "status"=>"error", 
                  "status_code"=>409, 
                  "message"=>"No Params Recived",
                  "validations"=>array(
                    "statusPerson"=>"Required" 
                  ), 
                  "data"=>NULL
          );
        }else{
          $this->form_validation->set_data($this->put());          
          $this->form_validation->set_rules('statusPerson','statusPerson','required');           
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
                  "statusPerson"=>$this->put('statusPerson')                    
              );                
              $response = $this->DAO->saveOrUpdate('persons',$data,array('idPerson'=>$id));                                      
            }
        }
      }else{
        $response = array(
          "status"=>"error", 
              "status_code"=>409, 
              "message"=>"No ID Provided OR It Does't Exists",
              "validations"=>array(
                "id"=>"Id Via Get",
                "statusPerson"=>"Required" 
                ), 
              "data"=>NULL
            );
          }
          $this->response($response);
    }


    
    
 }
