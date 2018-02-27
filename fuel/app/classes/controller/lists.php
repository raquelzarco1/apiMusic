<?php

use \Firebase\JWT\JWT;

class Controller_lists extends Controller_Rest
{	
 protected function autorizate(){
        try{
            $keyToken = "oliasdfkljasdfoujbasdfkjbsfadvkljhberwioyhgvdsfajhlbvaerfuygcvasjhbqwefolakasekhjadsfilkhjfadib";
            $header = apache_request_headers();
            $token = $header['Authorization'];
            $decodedmyToken = JWT::decode($token, $keyToken, array('HS256'));
            $userInToken = Model_Users::find($decodedmyToken->id);

            if($userInToken == null){                      
                return 'No se reconoce el token';
            }else{  
                return $userInToken;
            }
        }
        catch (Exception $e){
            return 'No se reconoce el token';
        }
    }

   public function post_createLists()
    {
        try {
            if(!isset($_POST['title']) || !isset($_POST['id_users'])){
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesitan mas parametros'
                ));
                return $json;
            }
            
            $input = $_POST;
            $lists = new Model_Lists();
            $lists->title = $input['title'];
            $lists->id_users = $input['id_users'];
            $lists->save(); 

            $json = $this->response(array(
                'code' => 200,
                'message' => 'lista creada',
                'data' => $lists
                     
            ));            
            return $json;  
        }
        
        catch (Exception $e){
            $json = $this->response(array(
                'code' => 500,
                'message' => $e->getMessage()
            ));         
            return $json;
        }       
    }


    public function get_lists()
    {
        $lists = Model_Lists::find('all');
        return $lists;
    }

     public function post_delete()
    {
        if ( ! isset($_POST['id'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto, se necesita que el parametro se llame id',
                'data' => null
            ));

            return $json;
        }

        $lists = Model_Lists::find($_POST['id']);
        $lists->delete();
        
        $json = $this->response(array(
            'code' => 200,
            'message' => 'lista borrada',
            'name' => $lists
        ));       
        return $json;
    }

    public function post_changeTitle()
    {
        if ( ! isset($_POST['titleOld'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto, se necesita que el parametro se llame title',
                'data' => null
            ));

            return $json;
        }

        if ( ! isset($_POST['title'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto, se necesita que el parametro se llame title',
                'data' => null
            ));

            return $json;
        }

        $input = $_POST;
        $userInToken = self::autorizate();
       
        if ($_POST['titleOld'] != $_POST['title'] ){
            $lists = Model_Lists::find('all');
            $lists->title = $_POST['title'];
            $lists->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'contraseña modificada',
                'data' => $lists
            ));
            return $json;
        }else{
            $json = $this->response(array(
                'code' => 500,
                'message' => 'No ha podido ser autenticado',
                'data' => null
            ));
            return $json;
        }  
    }
/*
    public function post_noReproductionsList()
    {
        if(!isset($_POST['id_song']) || !isset($_POST['id_list'])){
            $json = $this->response(array(
                'code' => 400,
                'message' => 'Parametro incorrecto, se necesita que el parametro se llame id_lists'
            ));

            return $json;
        }
        if ($songs->reproducciones == 0) {
        
        $add = new Model_Contienen();
        $add-> $id_song = $input['id_song'];
        $add->$id_list =  $input['id_list'];
        $add->save();

        return $add;
        }  
    }
    */
 public function post_addSongs()
    {
        if(!isset($_POST['id_song']) || !isset($_POST['id_list'])){
            $json = $this->response(array(
                'code' => 400,
                'message' => 'Parametro incorrecto, se necesita que el parametro se llame id_lists'
            ));

            return $json;
        }

        $add = new Model_Contienen();
        $add->id_list =  $_POST['id_list'];
        $add->id_song = $_POST['id_song'];
        $add->save();

        $json = $this->response(array(
                'code' => 200,
                'message' => 'Cancion añadida',
                'titulo' => $add
                
            ));            
            return $json;
    }
}