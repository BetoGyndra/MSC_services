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
        $response = $this->DAO->selectEntity('persons',array('idPerson'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('persons', null, false);
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


    function alta_post(){
      if (count($this->post())>19) {
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
                  "townShip"=>"Required"                          
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
                    "townShip"=>"Required"                  
                ), 
                "data"=>NULL
        );
      }else{
          $this->form_validation->set_data($this->post());
          $this->form_validation->set_rules('namePerson','namePerson','required');
          $this->form_validation->set_rules('lastnamePerson','lastnamePerson','required');
          $this->form_validation->set_rules('genre','genre','required');
          $this->form_validation->set_rules('birtdate','birtdate','required');
          $this->form_validation->set_rules('CURP','CURP','required');
          $this->form_validation->set_rules('age','age','required');
          $this->form_validation->set_rules('civilStatus','civilStatus','required');
          $this->form_validation->set_rules('phonePerson','phonePerson','required');
          $this->form_validation->set_rules('emailUser','emailUser','required');
          $this->form_validation->set_rules('passUser','passUser','required');
          $this->form_validation->set_rules('typeUser','typeUser','required');
          $this->form_validation->set_rules('street','street','required');
          $this->form_validation->set_rules('numberInt','numberInt','required');
          $this->form_validation->set_rules('numberExt','numberExt','required');
          $this->form_validation->set_rules('neighborhood','neighborhood','required');
          $this->form_validation->set_rules('postalCode','postalCode','required');
          $this->form_validation->set_rules('state','state','required');
          $this->form_validation->set_rules('townShip','townShip','required');
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
            $responseId = $this->DAO->saveOrUpdate('address',$data);            
            if($responseId){
              $data2 = array(              
              "namePerson"=>$this->post('namePerson'),
              "lastnamePerson"=>$this->post('lastnamePerson'),
              "genre"=>$this->post('genre'),
              "birtdate"=>$this->post('birtdate'),
              "CURP"=>$this->post('CURP'),
              "civilStatus"=>$this->post('civilStatus'),
              "phonePerson"=>$this->post('phonePerson'),
              "fkAddress"=>$responseId['data']                
              );
              $responseid = $this->DAO->saveOrUpdate('persons',$data2);
              $data3 = array(
                "emailUser"=>$this->post('emailUser'),
                "passUser"=>$this->post('passUser'),
                "typeUser"=>$this->post('typeUser'),              
                "fkPerson"=>$responseid['data'],
              );            
              $response = $this->DAO->saveOrUpdate('users',$data3);
            }else{
            }           
          }
      }
      $this->response($response,200);
    }

    
    function alta_put(){
        $id = $this->get('id');
        $userExists = $this->DAO->selectEntity('users',array('userId'=>$id),TRUE);
        if ($id && $userExists['data']) {
          if (count($this->put())>18) {
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
                        "fkPerson"=>"fkPerson",
                        "fkAddress"=>"fkAddress"

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
                        "fkPerson"=>"fkPerson",
                        "fkAddress"=>"fkAddress"  
                    ), 
                    "data"=>NULL
            );
          }else{
            $this->form_validation->set_data($this->put());          
            $this->form_validation->set_rules('namePerson','namePerson','required');
            $this->form_validation->set_rules('lastnamePerson','lastnamePerson','required');
            $this->form_validation->set_rules('genre','genre','required');
            $this->form_validation->set_rules('birtdate','birtdate','required');
            $this->form_validation->set_rules('CURP','CURP','required');
            $this->form_validation->set_rules('civilStatus','civilStatus','required');
            $this->form_validation->set_rules('phonePerson','phonePerson','required');
            $this->form_validation->set_rules('emailUser','emailUser','required');
            $this->form_validation->set_rules('passUser','passUser','required');
            $this->form_validation->set_rules('typeUser','typeUser','required');
            $this->form_validation->set_rules('street','street','required');
            $this->form_validation->set_rules('numberInt','numberInt','required');
            $this->form_validation->set_rules('numberExt','numberExt','required');
            $this->form_validation->set_rules('neighborhood','neighborhood','required');
            $this->form_validation->set_rules('postalCode','postalCode','required');
            $this->form_validation->set_rules('state','state','required');
            $this->form_validation->set_rules('townShip','townShip','required');
            $this->form_validation->set_rules('fkPerson','fkPerson','required');
            $this->form_validation->set_rules('fkAddress','fkAddress','required');
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
                $responseId = $this->DAO->saveOrUpdate('address',$data);            
                if($responseId){
                  $data2 = array(              
                  "namePerson"=>$this->put('namePerson'),
                  "lastnamePerson"=>$this->put('lastnamePerson'),
                  "genre"=>$this->put('genre'),
                  "birtdate"=>$this->put('birtdate'),
                  "CURP"=>$this->put('CURP'),
                  "civilStatus"=>$this->put('civilStatus'),
                  "phonePerson"=>$this->put('phonePerson'),
                  "fkAddress"=>$this->put('fkAddress'),                 
                  );
                  $responseid = $this->DAO->saveOrUpdate('persons',$data2);
                  $data3 = array(
                    "emailUser"=>$this->put('emailUser'),
                    "passUser"=>$this->put('passUser'),
                    "typeUser"=>$this->put('typeUser'),              
                    "fkPerson"=>$this->puto('fkPerson'), 
                  );            
                  $response = $this->DAO->saveOrUpdate('users',$data3);
                }else{
                }           
              }
          }
        }else{
          $response = array(
            "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No ID Provided OR It Does't Exists",
                "validations"=>array(
                  "id"=>"Id Via Get",
                  "userEmail"=>"Required, between 3 and 70 characters in length, only alph characters",
                  "userPass"=>"Required, between 3 and 150 characters in length, only alph characters",
                  "userType"=>"Required",
                  "fkPersona"=>"Required, Person registered in database"
                  ), 
                "data"=>NULL
          );
        }
        $this->response($response,$response['status_code']);
      }

}