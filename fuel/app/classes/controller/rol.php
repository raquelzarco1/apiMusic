<?php

use \Firebase\JWT\JWT;

class Controller_Rol extends Controller_Rest
{
    public function post_create()
    {
        try {
            if(!isset($_POST['rol'])){
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesitan mas parametros'
                ));
                return $json;
            }
            
            $input = $_POST;
            $rol = new Model_Rol();
            $rol->tipe = $input['rol'];
            $rol->save(); 

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Rol creado',
                'data' => $rol
                     
            ));            
            return $json;  
        }
        
        catch (Exception $e){
            $json = $this->response(array(
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => null
            ));         
            return $json;
        }       
    }

    
    public function get_rols()
    {
        $rols = Model_Rol::find('all');
        return $rols;
    }
    
    public function post_delete()
    {
    	if ( ! isset($_POST['id_rol'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Parametros incorrectos',
                    'data' => null
                ));

                return $json;
        }

        $rol = Model_Rol::find($_POST['id_rol']);
        $rol->delete();
        
        $json = $this->response(array(
            'code' => 200,
            'message' => 'Rol borrado',
            'name' => $rol
        ));       
        return $json;
    }
     
    public function post_editRol()
    {
            if ( ! isset($_POST['id_rol']) || ! isset($_POST['tipe'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Parametros incorrectos',
                    'data' => null
                ));

                return $json;
            }

            $input = $_POST;
            $rol = Model_Rol::find($_POST['id_rol']);
            $rol->tipe = $_POST['tipe'];
            $rol->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Rol modificado',
                'data' => $rol
            ));
            return $json;  
    }

     protected function beAdmin(){
        try{
              if($rol->id == 1){
                $rol->tipe =='admin'
                $rol->save();
              }
            }
        }
        catch (Exception $e){
            $json = $this->response(array(
                'code' => 500,
                'message' => $e->getMessage()
            ));         
            return $json;
        }
    }

}