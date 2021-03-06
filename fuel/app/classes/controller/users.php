<?php

use \Firebase\JWT\JWT;

class Controller_Users extends Controller_Rest
{
    public function post_create()
    {
        try {
            if(!isset($_POST['name']) || !isset($_POST['pass']) || !isset($_POST['email']) || !isset($_POST['id_rol'])){
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'Se necesitan mas parametros'
                ));
                return $json;
            }
            
            $input = $_POST;
            $user = new Model_Users();
            $user->username = $input['name'];
            $user->password = $input['pass'];
            $user->email = $input['email'];
            $user->id_rol = $input['id_rol'];
            $user->save(); 

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'data' => $user
                     
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

    public function get_loginUser()
    {
        try {
            if(!isset($_GET['name']) || !isset($_GET['pass'])){
                
                $json = $this -> response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame name o pass'
                ));
                return $json;

            } else {
                $users = Model_Users::find('all', array(
                    'where' => array(
                        array('username' => $_GET['name']),
                        array('password'=> $_GET['pass'])
                    )             
                ));

                if (empty($users)){
                    $json = $this->response(array(
                        'code' => 400,
                        'message' => 'Usuario o contraseña erroneos',
                        'data' => null
                    ));
                    
                    return $json; 
                }else{                
                    foreach($users as $key => $user)
                    {
                        $token = array(
                            "id" => $user->id,
                            "name" => $user->username,
                            "pass" => $user->password
                        );
                    }

                    $keyToken = "oliasdfkljasdfoujbasdfkjbsfadvkljhberwioyhgvdsfajhlbvaerfuygcvasjhbqwefolakasekhjadsfilkhjfadib";
                        
                    $jwt = JWT::encode($token, $keyToken);

                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'usuario logeado',
                        'data' => array(
                            'token' => $jwt,
                            'name' => $_GET['name']
                        )
                    ));
                    
                    return $json;                     
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
    
    public function get_users()
    {
        $users = Model_Users::find('all');
        return $users;
    }
    
    public function post_delete()
    {
    
    $userInToken = self::autorizate();
  
          if($userInToken->id_rol != 1){
            $user = Model_Users::find($userInToken->id);
            $user->delete();
            
            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario borrado',
                'name' => $user
            ));       
            return $json;
        }
    }
     
    public function post_changePass()
    {
        if ( ! isset($_POST['passOld'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto, se necesita que el parametro se llame pass',
                'data' => null
            ));

            return $json;
        }

        if ( ! isset($_POST['pass'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto, se necesita que el parametro se llame pass',
                'data' => null
            ));

            return $json;
        }

        $input = $_POST;
        $userInToken = self::autorizate();
        if (! isset($userInToken->id)){
        	$json = $this->response(array(
                'code' => 200,
                'message' => 'No ha podido ser autenticado',
                'data' => $userInToken
            ));
            return $json;
        }
        if ($_POST['passOld'] == $userInToken->password){
            $user = Model_Users::find($userInToken->id);
            $user->password = $_POST['pass'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'contraseña modificada',
                'data' => $user
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

    
    public function post_addUser()
    {
        if(!isset($_POST['id_seguido'])){
            $json = $this->response(array(
                'code' => 400,
                'message' => 'Parametro incorrecto, se necesita que el parametro se llame id_seguidor o id_seguido'
            ));

            return $json;
        }

        $userInToken = self::autorizate();

        $add = new Model_Siguen();
        $add->id_seguido = $_POST['id_seguido'];
        $add->id_seguidor =  $userInToken->id;
        $add->save();

        $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario seguido',
                'titulo' => $add
                
            ));            
            return $json;
    }
}