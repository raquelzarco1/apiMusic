<?php 
use \Firebase\JWT\JWT;

class Controller_Notice extends Controller_Rest 
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

    public function post_createNew()
    {
        if(!isset($_POST['title']) || !isset($_POST['id_user'])){
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
            $noticias = new Model_Noticias();
            $noticias->title = $input['title'];
            $noticias->id_users = $input['id_users'];
        
            $noticias->id_users = $userInToken->id;                
            $noticias->save();          

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Noticia creada',
                'titulo' => $noticias
                
            ));            
            return $json;  
        }
           
    }

    public function get_news()
    {
        $new = Model_Noticias::find('all');
        return $new;
    }




}

