<?php

class App_Controller_Action_Helper_ReceiveMessage extends Zend_Controller_Action_Helper_Abstract {

    protected $_config;
    private $_USER = "";
    private $_PASSWORD = "";

    public function __construct() {
        $this->_config = Zend_Registry::get('config');
        $this->_USER = $this->_config['resources']['view']['userIdServer'];
        $this->_PASSWORD = base64_encode($this->_config['resources']['view']['passwordServerDevel']);
    }

    public function _receiveMessages($dataMessage) {

        if ($dataMessage->userID == $this->_USER && $dataMessage->password ==$this->_PASSWORD) {

            $util = new Server_Util();
            $data = $util->xml2array($dataMessage->xmlMsg);
            $dataForm = array();
            $dataForm['IdentificadorProceso'] = $data['MensajeABDCP']['CabeceraMensaje']['IdentificadorProceso'];
            $dataForm['IdentificadorMensaje'] = $data['MensajeABDCP']['CabeceraMensaje']['IdentificadorMensaje'];
            $dataForm['Remitente']            = $data['MensajeABDCP']['CabeceraMensaje']['Remitente'];
            $dataForm['Destinatario']         = $data['MensajeABDCP']['CabeceraMensaje']['Destinatario'];
            $dataForm['FechaCreacionMensaje'] = $data['MensajeABDCP']['CabeceraMensaje']['FechaCreacionMensaje'];
            switch ($data['MensajeABDCP']['CuerpoMensaje_attr']['IdMensaje']) {
                //Asignación de Número de Consulta Previa 
                case 'ANCP':
                    $statusBlogId = new Admin_Model_Cp();
                    $id = $statusBlogId->statusCp($dataForm['IdentificadorProceso']);
                    $dataForm['IdentificacionSolicitud']       = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroConsultaPrevia']['IdentificacionSolicitud'];
                    $dataForm['FechaRecepcionMensajeAnterior'] = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroConsultaPrevia']['FechaRecepcionMensajeAnterior'];
                    $dataForm['FechaReferenciaABDCP']          = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroConsultaPrevia']['FechaReferenciaABDCP'];
                    $dataForm['Numeracion']                    = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroConsultaPrevia']['Numeracion'];
                    $dataForm['idcp']                          = $id['idtCp'];
                    $obj = new Application_Entity_RunSql('Ancp');
                    $obj->save = $dataForm;
                    return 'ack';
                    break;
                //Consulta Previa Rechazada por el ABDCP 
                case 'CPRABD':
                    $statusBlogId = new Admin_Model_Ancp();
                    $id = $statusBlogId->statusCp($dataForm['IdentificadorProceso']);
                    $dataForm['IdentificacionSolicitud'] = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaRechazadaABDCP']['IdentificacionSolicitud'];
                    $dataForm['CausaRechazo']            = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaRechazadaABDCP']['CausaRechazo'];
                    $dataForm['Numeracion']              = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaRechazadaABDCP']['Numeracion'];
                    $dataForm['idancp']                  = $id['iancp'];
                    $obj = new Application_Entity_RunSql('Cprabd');
                    $obj->save = $dataForm;
                    return 'ack';
                    break;
                //Consulta Previa Procedente 
                case 'CPPR':
                    $statusBlogId = new Admin_Model_Ancp();
                    $id = $statusBlogId->statusCp($dataForm['IdentificadorProceso']);
                    $dataForm['IdentificadorMensaje'] = $data['MensajeABDCP']['CabeceraMensaje']['IdentificadorMensaje'];
                    $dataForm['Remitente']            = $data['MensajeABDCP']['CabeceraMensaje']['Remitente'];
                    $dataForm['Destinatario']         = $data['MensajeABDCP']['CabeceraMensaje']['Destinatario'];
                    $dataForm['FechaCreacionMensaje'] = $data['MensajeABDCP']['CabeceraMensaje']['FechaCreacionMensaje'];
                    $dataForm['NumeroConsultaPrevia'] = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaProcedente']['NumeroConsultaPrevia'];
                    $dataForm['idancp']               = $id['iancp'];
                    $obj = new Application_Entity_RunSql('Cppr');
                    $obj->save = $dataForm;
                    return 'ack';
                    break;
                //Asignación de Número de Solicitud de Portabilidad 
                case 'ANS':
                    $statusBlogId = new Admin_Model_Sp();
                    $id = $statusBlogId->statusSp($dataForm['IdentificadorProceso']);
                    $dataForm['IdentificacionSolicitud']       = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroSolicitud']['IdentificacionSolicitud'];
                    $dataForm['FechaRecepcionMensajeAnterior'] = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroSolicitud']['FechaRecepcionMensajeAnterior'];
                    $dataForm['FechaReferenciaABDCP']          = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroSolicitud']['FechaReferenciaABDCP'];
                    $dataForm['Numeracion']                    = $data['MensajeABDCP']['CuerpoMensaje']['AsignacionNumeroSolicitud']['Numeracion'];
                    $dataForm['idtSp']                         = $id['idtSp'];
                    $obj = new Application_Entity_RunSql('Ans');
                    $obj->save = $dataForm;
                    return 'ack';
                    break;
                //Solicitud de Portabilidad Rechazada por el ABDCP 
                case 'RABDCP':
                    $statusBlogId = new Admin_Model_Ans();
                    $id = $statusBlogId->statusAns($dataForm['IdentificadorProceso']);
                    $dataForm['IdentificacionSolicitud'] = $data['MensajeABDCP']['CuerpoMensaje']['RechazadaABDCP']['IdentificacionSolicitud'];
                    $dataForm['CausaRechazo']            = $data['MensajeABDCP']['CuerpoMensaje']['RechazadaABDCP']['CausaRechazo'];
                    $dataForm['Numeracion']              = $data['MensajeABDCP']['CuerpoMensaje']['RechazadaABDCP']['Numeracion'];
                    $dataForm['idtAns']                  = $id['idtAns'];
                    $obj = new Application_Entity_RunSql('Rabdcp');
                    $obj->save = $dataForm;
                    return 'ack';
                    break;
                //Solicitud de Portabilidad Procedente 
                case 'SPR':
                    $statusBlogId = new Admin_Model_Ans();
                    $id = $statusBlogId->statusAns($dataForm['IdentificadorProceso']);
                    if ($id) {
                        $dataForm['idtAns'] = $id['idtAns'];
                    } else {
                       $statusEsc = new Admin_Model_Esc();
                      $id = $statusEsc->IdentificacionProceso($dataForm['IdentificadorProceso']);
                        $dataForm['idtEsc'] = $id['idtEsc'];
                    }
                    $dataForm['FechaLimiteProgramacionPortabilidad'] = $data['MensajeABDCP']['CuerpoMensaje']['SolicitudProcedente']['FechaLimiteProgramacionPortabilidad'];
                    $dataForm['FechaLimiteEjecucionPortabilidad']    = $data['MensajeABDCP']['CuerpoMensaje']['SolicitudProcedente']['FechaLimiteEjecucionPortabilidad'];
                    $dataForm['FechaReferenciaABDCP']                = $data['MensajeABDCP']['CuerpoMensaje']['SolicitudProcedente']['FechaReferenciaABDCP'];
                    $obj = new Application_Entity_RunSql('Spr');
                    $obj->save = $dataForm;

                    return 'ack';
                    break;
                //Fuera del Límite para Ejecutar la Portabilidad 
                case 'FLEP':
                    $statusBlogId = new Admin_Model_Ans();
                    $id = $statusBlogId->statusAns($dataForm['IdentificadorProceso']);
                    $dataForm['FechaLimiteProgramacionPortabilidad'] = $data['MensajeABDCP']['CuerpoMensaje']['FueraLimiteEjecutarPortabilidad']['FechaLimiteProgramacionPortabilidad'];
                    $dataForm['FechaLimiteEjecucionPortabilidad']    = $data['MensajeABDCP']['CuerpoMensaje']['FueraLimiteEjecutarPortabilidad']['FechaLimiteEjecucionPortabilidad'];
                    $dataForm['idtAns']                              = $id['idtAns'];
                    $obj = new Application_Entity_RunSql('Flep');
                    $obj->save = $dataForm;
                    return 'ack';
                    break;
                //Programada para Ejecutar Portabilidad 
                case 'PEP':
                    $statusBlogId = new Admin_Model_Ans();
                    $id = $statusBlogId->statusAns($dataForm['IdentificadorProceso']);
                    $dataForm['FechaEjecucionPortabilidad'] = $data['MensajeABDCP']['CuerpoMensaje']['ProgramadaEjecutarPortabilidad']['FechaEjecucionPortabilidad'];
                    $dataForm['idtAns']                     = $id['idtAns'];
                    $obj = new Application_Entity_RunSql('Pep');
                    $obj->save = $dataForm;
                    return 'ack';
                    break;
                //Envío de Consulta Previa al Cedente 
                case 'ECPC':
                    $dataForm['FechaEjecucionPortabilidad'] = $data['MensajeABDCP']['CuerpoMensaje']['ProgramadaEjecutarPortabilidad']['FechaEjecucionPortabilidad'];
                    $dataForm['FechaReferenciaABDCP']       = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['FechaReferenciaABDCP'];
                    $dataForm['Numeracion']                 = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['Numeracion'];
                    $dataForm['CodigoReceptor']             = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['CodigoReceptor'];
                    $dataForm['CodigoCedente']              = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['CodigoCedente'];
                    $dataForm['TipoDocumentoIdentidad']     = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['TipoDocumentoIdentidad'];
                    $dataForm['NumeroDocumentoIdentidad']   = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['NumeroDocumentoIdentidad'];
                    $dataForm['TipoPortabilidad']           = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['TipoPortabilidad'];
                    $dataForm['TipoServicio']               = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['TipoServicio'];
                    $dataForm['NombreContacto']             = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['NombreContacto'];
                    $dataForm['EmailContacto']              = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['EmailContacto'];
                    $dataForm['TelefonoContacto']           = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['TelefonoContacto'];
                    $dataForm['FaxContacto']                = $data['MensajeABDCP']['CuerpoMensaje']['ConsultaPreviaEnvioCedente']['FaxContacto'];
                    $obj = new Application_Entity_RunSql('Ecpc');
                    $obj->save = $dataForm;
                    $archivo = APPLICATION_PATH . '/cron/Rcp.php';
                    $archivodos = APPLICATION_PATH . '/cron/outEcpc.txt';
                    $archivotres = APPLICATION_PATH . '/cron/errorEcpc.txt';
                    $var1 = escapeshellcmd($dataForm['IdentificadorProceso']);
                    system("php " . $archivo . " $var1 >>" . $archivodos . " 2>>" . $archivotres . " &");
                    return 'ack';
                    break;
                //Envío de Solicitud al Cedente 
                case 'ESC':
                    $dataForm['FechaReferenciaABDCP']     = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['FechaReferenciaABDCP'];
                    $dataForm['Numeracion']               = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['Numeracion'];
                    $dataForm['CodigoReceptor']           = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['CodigoReceptor'];
                    $dataForm['CodigoCedente']            = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['CodigoCedente'];
                    $dataForm['TipoDocumentoIdentidad']   = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['TipoDocumentoIdentidad'];
                    $dataForm['NumeroDocumentoIdentidad'] = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['NumeroDocumentoIdentidad'];
                    $dataForm['TipoPortabilidad']         = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['TipoPortabilidad'];
                    $dataForm['TipoServicio']             = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['TipoServicio'];
                    $dataForm['NombreContacto']           = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['NombreContacto'];
                    $dataForm['EmailContacto']            = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['EmailContacto'];
                    $dataForm['TelefonoContacto']         = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['TelefonoContacto'];
                    $dataForm['FaxContacto']              = $data['MensajeABDCP']['CuerpoMensaje']['EnvioSolicitudCedente']['FaxContacto'];
                    $obj = new Application_Entity_RunSql('Esc');
                    $obj->save = $dataForm;
                        $archivo = APPLICATION_PATH . '/cron/Esc.php';
                        $archivodos = APPLICATION_PATH . '/cron/outEsc.txt';
                        $archivotres = APPLICATION_PATH . '/cron/errorEsc.txt';
                        $var1 = escapeshellcmd($dataForm['IdentificadorProceso']);
                        system("php ". $archivo." $var1 >>".$archivodos." 2>>".$archivotres." &" );  
                    return 'ack';
                    break;
                //Solicitud de Portabilidad Procedente por Consulta Previa Procedente 
                case 'CPSPR':

                    return 'ack';
                    break;
                //Acreditación Pago Deuda al Cedente 
                case 'APDC':


                    return 'ack';
                    break;
                //Cancelación de Portabilidad por No  Programación 
                case 'CNPF':


                    return 'ack';
                    break;
                // Detección de Errores NI y NE
                //No Integridad 
                case 'NI':


                    return 'ack';
                    break;
                //Notificación de Error 
                case 'NE':
                    return 'ack';
                    break;
                default:

                    return 'ack';
            }
        } else {

            return 'ERRSOAP012: Error en las credenciales';
        }
    }

    
}
