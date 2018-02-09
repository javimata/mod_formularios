<?php
/**
 * Helper class for mod_formularios module
 */

 class modFormularios
{

    /**
     * @param array $params An object containing the module parameters
     * @access public
     */    
    public static function getList( $params )
    {
        //return 'Hello, World!';
        //echo $params->get("titulo");

    }

    public static function getCampos( &$params )
    {

        $campos_lista = $params->get("campo_nombre");

        if ($campos_lista){

            $campos = explode(PHP_EOL, $campos_lista);

        }

        return $campos;

    }

    public function _getCategories ( $componente,$catfield,$published,$orden,$categoria ) 
    {

        /*
         * $componente = identificador del componente (content, k2, etc.)
         * $catfield   = campo de la categoria
         * $published  = campo para verificar status de publicacion
         * $orden      = campo de orden
         * $categoria  = id de la categoria
         */


        $db=JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->select( "*" );
        $query->from( "#__".$componente );

        switch ( $componente ){

            case "k2":
                $query->where('(publish_down = "0000-00-00 00:00:00" OR publish_down >= NOW())');
                $query->where( $published . ' = 1');
                
                $treeCats = self::_getCategoriesTree( $categoria );
                if ( is_array($treeCats) )
                    $whereCats = "(" . $catfield . ' = ' . $categoria;

                if ( count( $treeCats ) )
                    $whereCats .= " OR ";
                foreach ($treeCats as $cats) {
                    $whereCats .= $catfield . ' = ' . $cats->id . " OR ";
                }
                $whereCats = trim( $whereCats, " OR " );
                $whereCats .= ")";
                $query->where( $whereCats );

                break;

            case "content":

                $query->where('(publish_down = "0000-00-00 00:00:00" OR publish_down >= NOW())');
                $query->where($published . ' = 1');
                
                $treeCats = self::_getCategoriesTree( $categoria );
                if ( is_array($treeCats) )
                    $whereCats = "(" . $catfield . ' = ' . $categoria;

                if ( count( $treeCats ) )
                    $whereCats .= " OR ";
                foreach ($treeCats as $cats) {
                    $whereCats .= $catfield . ' = ' . $cats->id . " OR ";
                }
                $whereCats = trim( $whereCats, " OR " );
                $whereCats .= ")";
                $query->where( $whereCats );

                break;

        }

        $query->order( $orden . ' ASC' );
        // echo $query;
        $db->setQuery( $query );
        $lista = $db->loadObjectList(); 

        return $lista;


    }

    private function _getCategoriesTree ( $catid ) 
    {

        $db=JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->select( "id" );
        $query->from( "#__categories" );
        $query->where( 'parent_id = ' . $catid );
        $query->where( 'published = 1' );

        $db->setQuery($query);
        $categoriesTree = $db->loadObjectList();

        return $categoriesTree;
    }
   
}