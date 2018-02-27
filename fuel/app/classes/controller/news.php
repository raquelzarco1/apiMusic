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
        if(!isset($_POST['title']) || !isset($_POST['id_users'])){
            $json = $this->response(array(
                'code' => 400,
                'message' => 'Parametro incorrecto, se necesita que el parametro se llame title o id_users'
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
            $news = new Model_Songs();
            $news->title = $input['title'];
            $news->id_users = $userInToken->id;                
            $news->save();          

            $json = $this->response(array(
                'code' => 200,
                'message' => 'Noticia creada',
                'titulo' => $news
                
            ));            
            return $json;  
        }
           
    }

    public function get_news()
    {
        $news = Model_Noticias::find('all');
        return $news;
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

        $news = Model_Noticias::find($_POST['id']);
        $news->delete();
        
        $json = $this->response(array(
            'code' => 200,
            'message' => 'Noticia borrada',
            'name' => $news
        ));       
        return $json;
    }






}

