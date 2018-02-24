<?php 
use \Firebase\JWT\JWT;

class Controller_Notice extends Controller_Rest 
{   
    public function post_createNew()
    {
        try {
            if ( ! isset($_POST['title'])) 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita que el parametro se llame title',
                    'data' => null
                ));

                return $json;
            }

            $newNotice = Model_News::find('all', ['where' => ['title' => $_POST['title']]]);
                       
                $input = $_POST;
                $new = new Model_News();
                $new->title = $input['title']
                $new->save();

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Cancion creada',
                    'data' => $song
                ));
       		      return $json;  
        } 


        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
                'data' => null
            ));

            return $json;
        }        
    }

    public function post_editNew()
    {
        if ( ! isset($_POST['title'])) 
        {
            $json = $this->response(array(
                'code' => 400,
                'message' => 'necesitas un parametro se llame title',
                'data' => null
            ));

            return $json;
        }

        $input = $_POST;
        $new = new Model_News();
        $new->title = $input['title']
        $new->save();

        $json = $this->response(array(
                'code' => 200,
                'message' => 'Cancion editada',
                'data' => $new->title
        ));
        return $json;

        }

    public function get_playOneSong()
    {
    	$tokenDecoded = self::checkToken();
    	if ($tokenDecoded != null){
	    	if ( ! isset($_GET['id'])) 
	        {
	            $json = $this->response(array(
	                'code' => 400,
	                'message' => 'parametro incorrecto, se necesita que el parametro id valido',
	                'data' => null
	            ));

	            return $json;
	        }else{
		        $song = Model_Cancion::find($_GET['id']);
		        if(empty($song)){
		        	$json = $this->response(array(
			            'code' => 400,
			            'message' => 'Canción solicitada no existe',
			            'data' => null
			        ));

			        return $json; 
		        }else{
		        	$sumador = $song->playsCount + 1;
			        $song->playsCount = $sumador;
			        $song->save();

			        $listToAdd = Model_List::find('all', ['where' => ['id_user' =>$tokenDecoded, 'systemList' => 1]]);
			        $songToAdd = Model_Cancion::find('all', ['where' => ['id' =>$_GET['id']]]);
			        $dataList = Arr::reindex($listToAdd);
			        $songList = Arr::reindex($songToAdd);

			        $add = new Model_Contiene();
            		$add->id_cancion = $songList[0]->id;
            		$add->id_lista = $dataList[0]->id;
            		$add->createdAt = time();
            		$add->save();

			        $json = $this->response(array(
			            'code' => 200,
			            'message' => 'Mostrando cancion solicitada',
			            'data' => $song
			        ));

			        return $json;  
		    	}
		    }
		}else{
			$json = $this->response(array(
			            'code' => 200,
			            'message' => 'Autenticacion fallida',
			            'data' => $song
			        ));
			return $json; 
		}
    }

    public function get_songs(){
		$song = Model_Cancion::find('all');

        $json = $this->response(array(
            'code' => 200,
            'message' => 'mostrando todas las canciones',
            'data' => $song
        ));

        return $json; 
    }

    public function post_delete()
    {
        $song = Model_Cancion::find($_POST['id']);
        $song->delete();

        $json = $this->response(array(
            'code' => 200,
            'message' => 'cancion borrado',
            'name' => $song
        ));

        return $json;
    }

    public function get_views()
   	{
		$song = Model_Cancion::find('all',array('order_by' => array('playsCount' => 'desc')));

        $json = $this->response(array(
            'code' => 200,
            'message' => 'mostrando todas las canciones',
            'data' => Arr::reindex($song)
        ));

        return $json; 
   	} 
}
