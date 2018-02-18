<?php
class Zendvn_Config{
    
    public function config() {
        $arrConfig = array(
            'paginator' => array(
                'itemCountPerPage' => 10,
                'pageRange'        => 3
            ),
        );
        return $arrConfig;
    }
            
}
