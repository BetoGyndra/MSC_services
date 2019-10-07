<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DAO extends CI_Model{
	function __construct(){
        parent::__construct();
    }

    
    function selectEntity($entityName, $whereClause=NULL, $isUnique=FALSE){
    	if ($whereClause) {
    		$this->db->where($whereClause);
    	}
    	$query=$this->db->get($entityName);

    		$responseDB = array(
                "status"=>"success", 
                "status_code"=>200, 
                "message"=>"DATA FOUND",
                "validations"=>NULL, 
                "data"=>$isUnique ? $query->row() : $query->result()
            );
    	return $responseDB;
    }


    
    function insertData($entityName, $data){
    	$this->db->insert($entityName,$data);
    	if ($this->db->error()['message']!='') {
    		$responseDB = array(
	    		"status"=>"error", 
	            "status_code"=>409, 
	            "message"=>"Error Saving Data",
	            "validations"=>$this->db->error(),
	            "data"=>NULL
    		);
    	}else{
    		$responseDB = array(
                "status"=>"success", 
                "status_code"=>201, 
                "message"=>"OK Data Saved",
                "validations"=>NULL,  
                "data"=>NULL
            );
    	}
    	return $responseDB;
    }

	
	function saveOrUpdate($entity,$data,$whereClause = null, $returnKey = FALSE){
    	if($whereClause){
    		$this->db->where($whereClause);
        $this->db->update($entity,$data);
    	}else{
        $this->db->insert($entity,$data);
      }
    	if($this->db->error()['message']!=''){
    		$response = array(
    			"status"=>"error",
    			"message"=>$this->db->error()['message'],
    			"data"=>null
    		);
    	}else{
        if($whereClause){
          $msg = "Información actualizada correctamente!";
        }else{
          $msg = "Información registrada correctamente!";
        }
    		$response = array(
    			"status"=>"success",
				"message"=>$msg,
				"data"=>null
    		);        
          $response['data'] = $this->db->insert_id();        
    	}
    	return $response;
    }

    function updateData($entityName, $data, $whereClause){
   	$this->db->where($whereClause);
   	$this->db->update($entityName,$data);
    	if ($this->db->error()['message']!='') {
    		$responseDB = array(
	    		"status"=>"error", 
	            "status_code"=>409, 
	            "message"=>"Error Updating Data",
	            "validations"=>$this->db->error(),
	            "data"=>NULL
    		);
    	}else{
    		$responseDB = array(
                "status"=>"success", 
                "status_code"=>201, 
                "message"=>"OK Data Updated",
                "validations"=>NULL,  
                "data"=>NULL
            );
    	}
    	return $responseDB;
    }

    
    function deleteData($entityName, $whereClause){
   	$this->db->where($whereClause);
   	$this->db->delete($entityName);
    	if ($this->db->error()['message']!='') {
    		$responseDB = array(
	    		"status"=>"error", 
	            "status_code"=>409, 
	            "message"=>"Error Deleting Data",
	            "validations"=>$this->db->error(),
	            "data"=>NULL
    		);
    	}else{
    		$responseDB = array(
                "status"=>"success", 
                "status_code"=>201, 
                "message"=>"OK Data Deleted",
                "validations"=>NULL,  
                "data"=>NULL
            );
    	}
    	return $responseDB;
	}
	
	function login($email,$password){
		$this->db->where('emailUser',$email);
		$query = $this->db->get('users');

		if($this->db->error()['message']!=''){
			$response = array(
				"status"=>"error",
				"message"=> "error interno, intenta nuevamente"
			);		
				
		}else{
			$usuario = $query->row();
			if($usuario){
				if($usuario->statusUser == "Active"){
					if($usuario->passUser == $password){
						switch($usuario->typeUser){
							case 'Admin': 
							$this->db->where('users',$usuario->idUser);
							$query = $this->db->get('admin_view');
							$response = array(
								"status"=>"success",
								"message"=>"Informacion Cargada",
								 "data"=>$query
							);
							break;

							case 'Paciente': 
							$this->db->where('persona',$usuario->fkPerson);
							$query = $this->db->get('paciente_view');
							$response = array(
								"status"=>"success",
								"message"=>"Informacion Cargada",
								"data"=>$query->row()
							);
							break;

							case 'Medico': 
							$this->db->where('persona',$usuario->fkPerson);
							$query = $this->db->get('medico_view');
							$response = array(
								"status"=>"success",
								"message"=>"Informacion Cargada",
								"data"=>$query->row()
							);
							break;

							case 'Recepcionista': 
							$this->db->where('persona',$usuario->fkPerson);
							$query = $this->db->get('Recepcionista_view');
							$response = array(
								"status"=>"success",
								"message"=>"Informacion Cargada",
								"data"=>$query->row()
							);
							break;

							default:
							$response = array(
								"status"=>"error",
								"message"=> "error interno, intenta nuevamente"
							);
						}						
					}else{
						$response = array(
							"status"=>"error",
							"message"=> "contraseña incorrecta"
						);
					}
				}else{
					$response = array(
						"status"=>"error",
						"message"=> "el usuario no se encuentra activo"
					);
				}
			}else{
				$response = array(
					"status"=>"error",
					"message"=> "usuario no encontrado"
				);
			}
		}
		return $response;
	}		

}