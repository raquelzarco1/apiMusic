<?php

use \Firebase\JWT\JWT;

class Controller_Lists extends Controller_Rest
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
        if(!isset($_POST['titulo'])){
            $json = $this->response(array(
                'code' => 400,
                'message' => 'Parametro incorrecto, se necesita que el parametro se llame titulo'
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
            $list = new Model_Lists();
            $list->title = $input['titulo'];
            $list->id_users = $userInToken->id;	            
            $list->save();          

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Lista creada',
                'titulo' => $list
                
            ));            
            return $json;  
        }
           
    }

    public function get_lists()
    {
        $lists = Model_Lists::find('all');
        return $lists;
    }
}