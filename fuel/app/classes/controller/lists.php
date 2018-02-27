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

    public function post_createList()
    {
        if(!isset($_POST['title']) || !isset($_POST['id_users'])){
            $json = $this->response(array(
                'code' => 400,
                'message' => 'Parametro incorrecto, se necesita que el parametro se llame title,artist,reproducciones o url'
            ));
            return $json;
        }
        
        $userInToken = self::autorizate();
        if (! isset($userInToken->id)){
            $json = $this->response(array(
                'code' => 200,
                'message' => 'No ha podido ser autenticado',
                'data' => $userInToken
            ));
            return $json;
        }else{
            $input = $_POST;
            $lists = new Model_lists();
            $lists->title = $input['title'];
            $lists->id_users = $userInToken->id;                
            $lists->save();          

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Lista creada',
                'titulo' => $lists
                
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
            'title' => $lists
        ));       
        return $json;
    }

    public function post_changeTitle()
    {

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
            $lists = Model_Lists::find($lists->id);
            $lists->title = $_POST['title'];
            $lists->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Lista modificada',
                'data' => $lists
            ));
            return $json
    }      
    }
}