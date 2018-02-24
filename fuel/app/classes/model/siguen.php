<?php 

class Model_Siguen extends Orm\Model
{
    protected static $_table_name = 'siguen';
    protected static $_primary_key = array('id_seguidor','id_seguido');
    protected static $_properties = array(
        'id_seguidor' => array(
            'data_type' => 'int'   
        ),
        'id_seguido' => array(
            'data_type' => 'int'   
        )
    );
}