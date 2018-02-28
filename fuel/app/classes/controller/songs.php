<?php

use \Firebase\JWT\JWT;

class Controller_Songs extends Controller_Rest
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

	public function post_createSong()
    {
        if(!isset($_POST['title']) || !isset($_POST['artist']) || !isset($_POST['reproducciones']) || !isset($_POST['url'])){
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
            $songs = new Model_Songs();
            $songs->title = $input['title'];
            $songs->artist = $input['artist'];
            $songs->reproducciones = $input['reproducciones'];
            $songs->url = $input['url'];
            $songs->id_users = $userInToken->id;	            
            $songs->save();          

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Cancion creada',
                'titulo' => $songs
                
            ));            
            return $json;  
        }
           
    }

    public function get_songs()
    {
        $songs = Model_Songs::find('all');
        return $songs;
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

        $songs = Model_Songs::find($_POST['id']);
        $songs->delete();
        
        $json = $this->response(array(
            'code' => 200,
            'message' => 'Cancion borrada',
            'name' => $songs
        ));       
        return $json;
    }

    public function post_changeNameSong()
    {
        if ( ! isset($_POST['nameOld'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto, se necesita que el parametro se llame nameOld',
                'data' => null
            ));

            return $json;
        }

        if ( ! isset($_POST['name'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'parametro incorrecto, se necesita que el parametro se llame name',
                'data' => null
            ));

            return $json;
        }

        $input = $_POST;
        $userInToken = self::autorizate();
       
        if ($_POST['nameOld'] != $_POST['name'] ){
            $songs = Model_Songs::find('first', array(
                'where' => array(
                    array('title', $_POST['nameOld'])
                )));
            $songs->title = $_POST['name'];
            $songs->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Nombre cancion modificado',
                'data' => $songs
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
    public function post_playSong()
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
            $input = $_POST;
            $songs = new Model_Songs();
            $songs->id = $input['id'];
            $songs->reproducciones += 1;
            $songs->save();

            $json = $this->response(array(
            'code' => 200,
            'message' => 'Cancion reporducida',
            'name' => $songs
        ));       
        return $json;
        
    }
    */
}