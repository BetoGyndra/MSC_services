<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
/**
*
*@author Alberto Cortes Morales
*@since 03-octubre-2019
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


     function login_post(){
         if( count($this->post())>2 || count($this->post())==0){
             $response = array(
                 "status" => "error",
                 "message" => "demasiados parametros o ningun parametro fue enviado, parametros permitidos [2]",
                 "validations" => array(
                     "email"=>"Parametro requerido",
                     "password"=>"Parametro requerido"
                 ),
                 "data"=> null
                );
             }else{
                 $this->form_validation->set_data($this->post());
                 $this->form_validation->set_rules('email','email','required');
                 $this->form_validation->set_rules('password','password','required');
                 if($this->form_validation->run()==false){
                    $response = array(
                        "status" => "error",
                        "message" => "validaciones fallidas",
                        "validations" =>$this->form_validation->error_array(),
                        "data"=>null
                    );
                 }else{
                   $response = $this->DAO->login($this->post('email'),$this->post('password'));
                 }
             }
             $this->response($response,200);
         }

        
     }





