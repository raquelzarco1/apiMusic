<?php

use \Firebase\JWT\JWT;

class Controller_Songs extends Controller_Rest
{

post_autorizate()

if ($json->code->200) {
	

	public function post_createSong()
    {
	        try {

	        	 $jwt = apache_request_headers()['Authorization'];

	            if(!isset($_POST['title']) && !isset($_POST['url']) && !isset($_POST['artist']) || $_POST['title'] == "" && $_POST['url'] == "" && $_POST['artist'] == ""){
	                $json = $this->response(array(
	                    'code' => 400,
	                    'message' => 'parametro incorrecto, se necesita que el parametro se llame title o url'
	                ));
	                return $json;
	            }
	            
	            $input = $_POST;
	            $song = new Model_Songs();
	            $song->title = $input['title'];
	            $song->url = $input['url'];
	            $song->artist = $input['artist'];


	            $song->save();          
	            $json = $this->response(array(
	                'code' => 200,
	                'message' => 'cancion creada',
	                'title' => $input['title']
	                
	                
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

 function post_PlaySong(){
        try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->post_autorizate($jwt)){
                if(!isset($_POST['id']) || $_POST['id'] == ""){
                   $json = $this->response(array(
	                    'code' => 400,
	                    'message' => 'parametro incorrecto, se necesita que el parametro se llame id'
	                ));        
	           		
	           		 return $json;
                }

                $id = $_POST['id'];
           
                $songs = Model_Songs::find($id);
                if($songs != null){
                    $songs->reproducciones += 1;
                    $songs->save();
                     $json = $this->response(array(
	                    'code' => 200,
	                    'message' => 'Cancion encontrada: '
	                    'songs' => $songs

	                ));        
	           	    return $json;
                }else{
                    $json = $this->response(array(
	                    'code' => 400,
	                    'message' => 'no existe esa cancion'
	                ));        
	           		
	           		 return $json;
                }
              
            }
            
        }catch (Exception $e) {
            return $this->createResponse(500, $e->getMessage());
        }
    }

	function post_deleteSong(){
        try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->post_autorizate($jwt)){
                $token = JWT::decode($jwt, $this->key, array('HS256'));
                $id = $token->data->id;
     
                $usuario = Model_Users::find($id);
                if ($usuario->id_rol != 1){
                     $json = $this->response(array(
	                    'code' => 400,
	                    'message' => 'no existe rol'
	                )); 
	                return $json;       
	           		
                }
                if(!isset($_POST['id_song']) || $_POST['id_song'] == ""){
                     $json = $this->response(array(
	                    'code' => 200,
	                    'message' => 'eres admin'
	                )); 
	                return $json;       
	           		
                }
                $id_song = $_POST['id_song'];
           
                $song = Model_Songs::find($id_song);
                if($song != null){
                    $song->delete();

                     $json = $this->response(array(
	                    'code' => 200,
	                    'message' => 'has borrado la cancion: ' + ['song' => $song]);
	                )); 
	                return $json;
                }else{
                     $json = $this->response(array(
	                    'code' => 400,
	                    'message' => 'no se ha encontrado cancion con ese id'
	                )); 
	                return $json;
                }
              
            }

        }catch (Exception $e) {
            return $this->createResponse(500, $e->getMessage());
        }
    	
    }

	function get_Findsongs(){
        try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->post_autorizate($jwt)){              
                $songs = Model_Songs::find('all');
                if($songs != null){
                	 $json = $this->response(array(
	                    'code' => 200,
	                    'message' => 'Estas son las canciones exitentes: ' + ['song' => $song]);
	                )); 
	                return $json;

                }
            }

        }catch (Exception $e) {
            $this->createResponse(500, $e->getMessage());
        }
    }





	}
}