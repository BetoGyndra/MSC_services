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

  
    function noatencion_get(){
      
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
        $response = $this->DAO->selectEntity('specialties',array('idSpecialty'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('specialties', null, false);
      }
      $this->response($response,$response['status_code']);
    }


    function noatencion_post(){
      if (count($this->post())>3) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array(

                  "code"=>"Required",
                  "nameSpecialty"=>"Required",
                  "description"=>"Required"                                    
                ), 
                "data"=>NULL
        );
      }else if(count($this->post())==0){
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No Params Recived",
                "validations"=>array(
                  
                  "code"=>"Required",
                  "nameSpecialty"=>"Required",
                  "description"=>"Required"                   
                ), 
                "data"=>NULL
        );
      }else{
          $this->form_validation->set_data($this->post());
          $this->form_validation->set_rules('code','Abreviacion','required');
          $this->form_validation->set_rules('nameSpecialty','Nombre Especialidad','required');
          $this->form_validation->set_rules('description','Descripción','required');                 
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
              "code"=>$this->post('code'),
              "nameSpecialty"=>$this->post('nameSpecialty'),
              "description"=>$this->post('description')
            );
            $response = $this->DAO->saveOrUpdate('specialties',$data);                                
          }
      }
      $this->response($response,200);
    }

    
    function noatencion_put(){
        $id = $this->get('id');
        $EnoatencionExists = $this->DAO->selectEntity('specialties',array('idSpecialty'=>$id),TRUE);
        if ($id && $EnoatencionExists['data']) {
          if (count($this->put())>4) {
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"Too Many Params Recived",
                    "validations"=>array(
                        "code"=>"Required",
                        "nameSpecialty"=>"Required",
                        "description"=>"Required"   

                    ), 
                    "data"=>NULL
            );
          }else if(count($this->put())==0){
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"No Params Recived",
                    "validations"=>array(
                    "code"=>"Required",
                    "nameSpecialty"=>"Required",
                    "description"=>"Required"   
                    ), 
                    "data"=>NULL
            );
          }else{
            $this->form_validation->set_data($this->put());          
            $this->form_validation->set_rules('code','Abreviacion','required');
            $this->form_validation->set_rules('nameSpecialty','Nombre Especialidad','required');
            $this->form_validation->set_rules('description','Descripción','required');  
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
                    "code"=>$this->put('code'),
                    "nameSpecialty"=>$this->put('nameSpecialty'),                    
                    "description"=>$this->put('description')
                );                
                $response = $this->DAO->saveOrUpdate('specialties',$data,array('idSpecialty'=>$id));                                      
              }
          }
        }else{
          $response = array(
            "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No ID Provided OR It Does't Exists",
                "validations"=>array(
                  "id"=>"Id Via Get",
                  "code"=>"Required",
                  "nameSpecialty"=>"Required",
                  "description"=>"Required" 
                  ), 
                "data"=>NULL
          );
        }
        $this->response($response);
      }

      function noatencionstatus_put(){
        $id = $this->get('id');
        $EnoatencionExists = $this->DAO->selectEntity('specialties',array('idSpecialty'=>$id),TRUE);
        if ($id && $EnoatencionExists['data']) {
          if (count($this->put())>4) {
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"Too Many Params Recived",
                    "validations"=>array(
                        "statusSpecialty"=>"Required" 
                    ), 
                    "data"=>NULL
            );
          }else if(count($this->put())==0){
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"No Params Recived",
                    "validations"=>array(
                    "code"=>"Required",
                    "nameSpecialty"=>"Required",
                    "description"=>"Required"   
                    ), 
                    "data"=>NULL
            );
          }else{
            $this->form_validation->set_data($this->put());          
            $this->form_validation->set_rules('statusSpecialty','statusSpecialty','required');           
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
                    "statusSpecialty"=>$this->put('statusSpecialty')                    
                );                
                $response = $this->DAO->saveOrUpdate('specialties',$data,array('idSpecialty'=>$id));                                      
              }
          }
        }else{
          $response = array(
            "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No ID Provided OR It Does't Exists",
                "validations"=>array(
                  "id"=>"Id Via Get",
                  "code"=>"Required",
                  "nameSpecialty"=>"Required",
                  "description"=>"Required" 
                  ), 
                "data"=>NULL
          );
        }
        $this->response($response);
      }

}