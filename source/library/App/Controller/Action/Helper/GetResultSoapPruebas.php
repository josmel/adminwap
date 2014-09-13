<?php

class App_Controller_Action_Helper_GetResultSoapPruebas extends Zend_Controller_Action_Helper_Abstract {

    protected $_config;

    public function init() 
    {
        $this->_config = Zend_Registry::get('config');
        $this->_clienteCip = new Zend_Soap_Client(
                $this->_config['resources']['view']['urlSoapPrueba']
        );
    }

    public function _getResultSoap($params) 
    {
        try {
            $response = $this->_clienteCip->CheckCC($params);
        } catch (Exception $ex) {
            echo 'error de conexion';
            exit;
        }
        return $response;
    }

}
