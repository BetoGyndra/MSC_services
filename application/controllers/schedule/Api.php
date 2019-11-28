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

  
    function schedule_get(){
      
      $id = $this->get('id');
      if (count($this->get())>1) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array('id'=>"Send Id To Get A Specific Schedule"), 
                "data"=>NULL
        );
      }else if ($id) {
        $response = $this->DAO->selectEntity('schedule',array('idSchedule'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('schedule', null, false);
      }
      $this->response($response,$response['status_code']);
    }

    function scheduleV_get(){
      
      $id = $this->get('id');
      if (count($this->get())>1) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array('id'=>"Send Id To Get A Specific Schedule"), 
                "data"=>NULL
        );
      }else if ($id) {
        $response = $this->DAO->selectEntity('scheduleview',array('idSchedule'=>$id),TRUE);
      }else{
        $response = $this->DAO->selectEntity('scheduleview', null, false);
      }
      $this->response($response,$response['status_code']);
    }


    function schedule_post(){
      if (count($this->post())>19) {
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"Too Many Params Recived",
                "validations"=>array(

                  "lunes"=>"Required",
                  "martes"=>"Required",
                  "miercoles"=>"Required",
                  "jueves"=>"Required",
                  "viernes"=>"Required",
                  "sabado"=>"Required",
                  "domingo"=>"Required",
                  "Empleado"=>"Required"
                ), 
                "data"=>NULL
        );
      }else if(count($this->post())==0){
        $response = array(
          "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No Params Recived",
                "validations"=>array(
                  
                  "lunes"=>"Required",
                  "martes"=>"Required",
                  "miercoles"=>"Required",
                  "jueves"=>"Required",
                  "viernes"=>"Required",
                  "sabado"=>"Required",
                  "domingo"=>"Required",
                  "Empleado"=>"Required"                
                ), 
                "data"=>NULL
        );
      }else{
          $this->form_validation->set_data($this->post());
          $this->form_validation->set_rules('lunes','lunes','required');
          $this->form_validation->set_rules('martes','martes','required');
          $this->form_validation->set_rules('miercoles','miercoles','required');
          $this->form_validation->set_rules('jueves','jueves','required');
          $this->form_validation->set_rules('viernes','viernes','required');
          $this->form_validation->set_rules('sabado','sabado','required');
          $this->form_validation->set_rules('domingo','domingo','required');
          $this->form_validation->set_rules('Empleado','Empleado','required');                    
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
              "lunes"=>$this->post('lunes'),
              "martes"=>$this->post('martes'),
              "miercoles"=>$this->post('miercoles'),
              "jueves"=>$this->post('jueves'),
              "viernes"=>$this->post('viernes'),
              "sabado"=>$this->post('sabado'),
              "domingo"=>$this->post('domingo'),
              "fkEmployee"=>$this->post('Empleado')              
            );
            $response = $this->DAO->saveOrUpdate('schedule',$data);                                
          }
      }
      $this->response($response,200);
    }

    
    function schedule_put(){
        $id = $this->get('id');
        $EscheduleExists = $this->DAO->selectEntity('schedule',array('idSchedule'=>$id),TRUE);
        if ($id && $EscheduleExists['data']) {
          if (count($this->put())>29) {
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"Too Many Params Recived",
                    "validations"=>array(
                        
                  "uplunes"=>"Required",
                  "upmartes"=>"Required",
                  "upmiercoles"=>"Required",
                  "upjueves"=>"Required",
                  "upviernes"=>"Required",
                  "upsabado"=>"Required",
                  "updomingo"=>"Required",
                  "Empleadoupdate"=>"Required"   

                    ), 
                    "data"=>NULL
            );
          }else if(count($this->put())==0){
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"No Params Recived",
                    "validations"=>array(                    
                      "lunes"=>$this->put('uplunes'),
                      "martes"=>$this->put('upmartes'),
                      "miercoles"=>$this->put('upmiercoles'),
                      "jueves"=>$this->put('upjueves'),
                      "viernes"=>$this->put('upviernes'),
                      "sabado"=>$this->put('upsabado'),
                      "domingo"=>$this->put('updomingo'),
                      "fkEmployee"=>$this->put('Empleadoupdate')  
                    ), 
                    "data"=>NULL
            );
          }else{
            $this->form_validation->set_data($this->put());          
            $this->form_validation->set_rules('uplunes','lunes','required');
          $this->form_validation->set_rules('upmartes','martes','required');
          $this->form_validation->set_rules('upmiercoles','miercoles','required');
          $this->form_validation->set_rules('upjueves','jueves','required');
          $this->form_validation->set_rules('upviernes','viernes','required');
          $this->form_validation->set_rules('upsabado','sabado','required');
          $this->form_validation->set_rules('updomingo','domingo','required');
          $this->form_validation->set_rules('Empleadoupdate','Empleado','required');  
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
                  "lunes"=>$this->put('uplunes'),
                  "martes"=>$this->put('upmartes'),
                  "miercoles"=>$this->put('upmiercoles'),
                  "jueves"=>$this->put('upjueves'),
                  "viernes"=>$this->put('upviernes'),
                  "sabado"=>$this->put('upsabado'),
                  "domingo"=>$this->put('updomingo'),
                  "fkEmployee"=>$this->put('Empleadoupdate')
                );                
                $response = $this->DAO->saveOrUpdate('schedule',$data,array('idSchedule'=>$id));                                      
              }
          }
        }else{
          $response = array(
            "status"=>"error", 
                "status_code"=>409, 
                "message"=>"No ID Provided OR It Does't Exists",
                "validations"=>array(
                  "id"=>"Id Via Get",
                      "lunes"=>$this->put('uplunes'),
                      "martes"=>$this->put('upmartes'),
                      "miercoles"=>$this->put('upmiercoles'),
                      "jueves"=>$this->put('upjueves'),
                      "viernes"=>$this->put('upviernes'),
                      "sabado"=>$this->put('upsabado'),
                      "domingo"=>$this->put('updomingo'),
                      "fkEmployee"=>$this->put('Empleadoupdate') 
                  ), 
                "data"=>NULL
          );
        }
        $this->response($response);
      }



      function schedulestatus_put(){
        $id = $this->get('id');
        $EscheduleExists = $this->DAO->selectEntity('schedule',array('idSchedule'=>$id),TRUE);
        if ($id && $EscheduleExists['data']) {
          if (count($this->put())>4) {
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"Too Many Params Recived",
                    "validations"=>array(
                        "statusSchedule"=>"Required" 
                    ), 
                    "data"=>NULL
            );
          }else if(count($this->put())==0){
            $response = array(
              "status"=>"error", 
                    "status_code"=>409, 
                    "message"=>"No Params Recived",
                    "validations"=>array(
                      "statusSchedule"=>"Required" 
                    ), 
                    "data"=>NULL
            );
          }else{
            $this->form_validation->set_data($this->put());          
            $this->form_validation->set_rules('statusSchedule','statusSchedule','required');           
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
                    "statusSchedule"=>$this->put('statusSchedule')                    
                );                
                $response = $this->DAO->saveOrUpdate('schedule',$data,array('idSchedule'=>$id));                                      
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