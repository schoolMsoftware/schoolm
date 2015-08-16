<?php

namespace Admin\Model;

class UserTable {
    public function __construct() {
        $this->cObj = new curl();
    }
    
    public function webService($data) {
        $action = isset($data['param']['action'])?$data['param']['action']:'';
        $queryStr = http_build_query($data['param']);
        $url = ADMIN_API.$action.'?'.$queryStr;
        return $this->cObj->callCurl($url);
    }

}
