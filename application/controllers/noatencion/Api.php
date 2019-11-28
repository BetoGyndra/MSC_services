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

  
    function noatencionV_get(){
      
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
        $response = $this->DAO->selectEntity('noatencionAdminview ',array('idNoAtention'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('noatencionAdminview ', null, false);
      }
      $this->response($response,$response['status_code']);
    }

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
        $response = $this->DAO->selectEntity('noatention',array('idNoAtention'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('noatention', null, false);
      }
      $this->response($response,$response['status_code']);
    }


    function noatencion_post(){
      if (count($this->post())>4) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array(

                  "nameSpecialty"=>"Required",
                  "fecha"=>"Required",
                  "motivo"=>"Required",
                  "desde"=>"Required"                                    
                ), 
                "data"=>NULL
        );
      }else if(count($this->post())==0){
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No Params Recived",
                "validations"=>array(
                  
                  "nameSpecialty"=>"Required",
                  "fecha"=>"Required",
                  "motivo"=>"Required",
                  "desde"=>"Required"                     
                ), 
                "data"=>NULL
        );
      }else{
          $this->form_validation->set_data($this->post());
          $this->form_validation->set_rules('nameSpecialty','nameSpecialty','required');
          $this->form_validation->set_rules('fecha','Fecha','required');
          $this->form_validation->set_rules('motivo','Motivo','required');
          $this->form_validation->set_rules('desde','Hora de inicio','required');                 
          if ($this->form_validation->run()==FALSE) {
            $response = array(
            "status"=>"error", 
                  "status_code"=>409, 
                  "message"=>"Validations Failed",
                  "validations"=>$this->form_validation->error_array(),
                  "data"=>NULL
          );
          }else{
            $data0 = array(
              "fecha"=>$this->post('fecha'),
              "motivo"=>$this->post('motivo'),              
              "desde"=>$this->post('desde')
            );
            $responseid = $this->DAO->saveOrUpdate('noatention',$data0);  
            
            $data1 = array(              
              "fkSpecialties"=>$this->post('nameSpecialty'),
              "fkNoAtention"=>$responseid['data']
            );
            $response = $this->DAO->saveOrUpdate('specialnoatetion',$data1); 
          }
      }
      $this->response($response,200);
    }
    
      function noatencion_put(){
        $id = $this->get('id');
        $id2 = $this->get('id2');
        $EnoatencionExists = $this->DAO->selectEntity('noatention',array('idNoAtention'=>$id),TRUE);
        $SpecialNoAtention = $this->DAO->selectEntity('specialnoatetion',array('idSpecialNoAtention'=>$id2),TRUE);
        if ($id and $id2 and $EnoatencionExists['data'] and $SpecialNoAtention['data']){
          if (count($this->put())>6) {
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"Too Many Params Recived",
                    "validations"=>array(
                      "nameSpecialty"=>"Required",
                      "fecha"=>"Required",
                      "motivo"=>"Required",
                      "desde"=>"Required"  
                    ), 
                    "data"=>NULL
            );
          }else if(count($this->put())==0){
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"No Params Recived",
                    "validations"=>array(
                      "nameSpecialty"=>"Required",
                      "fecha"=>"Required",
                      "motivo"=>"Required",
                      "desde"=>"Required"     
                    ), 
                    "data"=>NULL
            );
          }else{
            $this->form_validation->set_data($this->put());          
            $this->form_validation->set_rules('nameSpecialty','nameSpecialty','required');
            $this->form_validation->set_rules('fecha','Fecha','required');
            $this->form_validation->set_rules('motivo','Motivo','required');
            $this->form_validation->set_rules('desde','Hora de inicio','required');           
              if ($this->form_validation->run()==FALSE) {
                $response = array(
                "status"=>"error", 
                      "status_code"=>409, 
                      "message"=>"Validations Failed",
                      "validations"=>$this->form_validation->error_array(),
                      "data"=>NULL
              );
              }else{
                $data0 = array(
                  "fecha"=>$this->put('fecha'),
                  "motivo"=>$this->put('motivo'),              
                  "desde"=>$this->put('desde')
                );          
                $response = $this->DAO->saveOrUpdate('noatention',$data0,array('idNoAtention'=>$id));
                $data1 = array(              
                  "fkSpecialties"=>$this->put('nameSpecialty'),                
                );   
              $response = $this->DAO->saveOrUpdate('specialnoatetion',$data1,array('idSpecialNoAtention'=>$id2)); 
                           
              }
          }
        }else{
          $response = array(
            "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No ID Provided OR It Does't Exists",
                "validations"=>array(
                  "id"=>"Id Via Get",
                  "id2"=>"Id Via Get",
                  "nameSpecialty"=>"Required",
                  "fecha"=>"Required",
                  "motivo"=>"Required",
                  "desde"=>"Required" 
                  ), 
                "data"=>NULL
          );
        }
        $this->response($response);
      }

      
      function noatencionstatus_put(){
        $id = $this->get('id');
        $EnoatencionExists = $this->DAO->selectEntity('noatention',array('idNoAtention'=>$id),TRUE);
        if ($id && $EnoatencionExists['data']) {
          if (count($this->put())>2) {
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"Too Many Params Recived",
                    "validations"=>array(
                        "statusNoAtention"=>"Required" 
                    ), 
                    "data"=>NULL
            );
          }else if(count($this->put())==0){
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"No Params Recived",
                    "validations"=>array(
                      "statusNoAtention"=>"Required" 
                    ), 
                    "data"=>NULL
            );
          }else{
            $this->form_validation->set_data($this->put());          
            $this->form_validation->set_rules('statusNoAtention','statusNoAtention','required');           
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
                    "statusNoAtention"=>$this->put('statusNoAtention')                    
                );                
                $response = $this->DAO->saveOrUpdate('noatention',$data,array('idNoAtention'=>$id));                                      
              }
          }
        }else{
          $response = array(
            "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No ID Provided OR It Does't Exists",
                "validations"=>array(
                  "id"=>"Id Via Get",
                  "statusNoAtention"=>"Required" 
                  ), 
                "data"=>NULL
          );
        }
        $this->response($response);
      }

}