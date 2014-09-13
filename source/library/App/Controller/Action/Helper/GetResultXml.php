<?php

class App_Controller_Action_Helper_GetResultXml extends Zend_Controller_Action_Helper_Abstract {

     public  function _cabeceraXml($tp, $IdentificadorProceso = null)
      {
          if ($IdentificadorProceso==null) { 
           $IdentificadorProceso = '59'.date("Ymd").''.$tp.''.rand(10000,99999);
         } 
        $cabecera ='<MensajeABDCP xsi:noNamespaceSchemaLocation="SP.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                           <CabeceraMensaje>             
                                   <IdentificadorMensaje>59'.date("Ymd").''.rand(1000000,9999999).'</IdentificadorMensaje>
                                   <Remitente>59</Remitente>
                                   <Destinatario>00</Destinatario>
                                   <FechaCreacionMensaje>'.date("YmdHis").'</FechaCreacionMensaje>
                                   <IdentificadorProceso>'.$IdentificadorProceso.'</IdentificadorProceso>
                           </CabeceraMensaje>';
         return $cabecera;   

      }
            public  function _ConsultaPrevia($Data,$tp)
      {
        $cabecera = $this->_cabeceraXml($tp,null);
          $EnvioSolicitudCedente = ''.$cabecera.'
                   <CuerpoMensaje IdMensaje="CP">
                        <ConsultaPrevia>
                            <CodigoReceptor>59</CodigoReceptor>
                            <CodigoCedente>'.$Data['CodigoCedente'] .'</CodigoCedente>
                            <TipoDocumentoIdentidad>'.$Data['TipoDocumentoIdentidad'] .'</TipoDocumentoIdentidad>
                            <NumeroDocumentoIdentidad>'.$Data['NumeroDocumentoIdentidad'] .'</NumeroDocumentoIdentidad>
                            <CantidadNumeraciones>'.$Data['CantidadNumeraciones'] .'</CantidadNumeraciones>
                            <NumeracionSolicitada>
                                  <RangoNumeracion>
                                    <InicioRango>'.$Data['NumeracionSolicitada'] .'</InicioRango>
                                    <FinalRango>'.$Data['NumeracionSolicitada'] .'</FinalRango>
                                    <TipoPortabilidad>'.$Data['TipoPortabilidad'] .'</TipoPortabilidad>
                                  </RangoNumeracion>
                            </NumeracionSolicitada>
                            <Observaciones></Observaciones>
                            <NombreContacto>'.$Data['NombreContacto'] .'</NombreContacto>
                            <EmailContacto>'.$Data['EmailContacto'] .'</EmailContacto>
                            <TelefonoContacto>'.$Data['TelefonoContacto'] .'</TelefonoContacto>
                            <FaxContacto>'.$Data['FaxContacto'] .'</FaxContacto>
                            <TipoServicio>'.$Data['TipoServicio'] .'</TipoServicio>
                            <Cliente>'.$Data['Cliente'] .'</Cliente>
                        </ConsultaPrevia>
                    </CuerpoMensaje>
                </MensajeABDCP>';
         return $EnvioSolicitudCedente;   

      }
    
 
    public  function _SolicitudPortabilidadXml($Data,$tp)
      {
        $cabecera = $this->_cabeceraXml($tp,null);
          $EnvioSolicitudCedente = ''.$cabecera.'
                   <CuerpoMensaje IdMensaje="SP">
                        <SolicitudPortabilidad>
                            <CodigoReceptor>59</CodigoReceptor>
                            <CodigoCedente>'.$Data['CodigoCedente'] .'</CodigoCedente>
                            <TipoDocumentoIdentidad>'.$Data['TipoDocumentoIdentidad'] .'</TipoDocumentoIdentidad>
                            <NumeroDocumentoIdentidad>'.$Data['NumeroDocumentoIdentidad'] .'</NumeroDocumentoIdentidad>
                            <CantidadNumeraciones>'.$Data['CantidadNumeraciones'] .'</CantidadNumeraciones>
                            <NumeracionSolicitada>
                                  <RangoNumeracion>
                                    <InicioRango>'.$Data['NumeracionSolicitada'] .'</InicioRango>
                                    <FinalRango>'.$Data['NumeracionSolicitada'] .'</FinalRango>
                                    <TipoPortabilidad>'.$Data['TipoPortabilidad'] .'</TipoPortabilidad>
                                  </RangoNumeracion>
                            </NumeracionSolicitada>
                            <Observaciones></Observaciones>
                            <NombreContacto>'.$Data['NombreContacto'] .'</NombreContacto>
                            <EmailContacto>'.$Data['EmailContacto'] .'</EmailContacto>
                            <TelefonoContacto>'.$Data['TelefonoContacto'] .'</TelefonoContacto>
                            <FaxContacto>'.$Data['FaxContacto'] .'</FaxContacto>
                            <TipoServicio>'.$Data['TipoServicio'] .'</TipoServicio>
                            <Cliente>'.$Data['Cliente'] .'</Cliente>
                        </SolicitudPortabilidad>
                    </CuerpoMensaje>
                </MensajeABDCP>';
         return $EnvioSolicitudCedente;   

      }
      
      public function _ProgramacionPortabilidad($Date,$tp,$IdentificadorProceso) {
         $cabecera = $this->_cabeceraXml($tp,$IdentificadorProceso);
          $EnvioProgramacionPortabilidad = ''.$cabecera.' 
                  <CuerpoMensaje IdMensaje="PP">
                          <ProgramacionPortabilidad>
                                  <FechaEjecucionPortabilidad>'.$Date.'</FechaEjecucionPortabilidad>
                          </ProgramacionPortabilidad>
                  </CuerpoMensaje>
             </MensajeABDCP>';
         return $EnvioProgramacionPortabilidad; 
      //59201407210108187
      }
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      

    public function _AsignacionNumeroSolicitudXml($numero)
     {
          $cabecera = $this->_cabeceraXml();
          $AsignacionNumeroSolicitud = ''.$cabecera.'
                        <CuerpoMensaje IdMensaje="ANS">
                            <AsignacionNumeroSolicitud>
                                <IdentificacionSolicitud>20201405060102017</IdentificacionSolicitud>
                                <FechaRecepcionMensajeAnterior>20140506112410</FechaRecepcionMensajeAnterior>
                                <FechaReferenciaABDCP>20140506112418</FechaReferenciaABDCP>
                                <Numeracion>'.$numero.'</Numeracion>
                            </AsignacionNumeroSolicitud>
                        </CuerpoMensaje>
                      </MensajeABDCP>';
            
           return $AsignacionNumeroSolicitud;   

    }

    
    
      
       public  function _EnvioSolicitudCedente()
      {
        $cabecera = $this->_cabeceraXml();
          $EnvioSolicitudCedente = ''.$cabecera.'
                   <CuerpoMensaje IdMensaje="ESC">
                    <EnvioSolicitudCedente>
                        <FechaReferenciaABDCP>20140506112419</FechaReferenciaABDCP>
                        <Numeracion>73269953</Numeracion>
                        <CodigoReceptor>20</CodigoReceptor>
                        <CodigoCedente>21</CodigoCedente>
                        <TipoDocumentoIdentidad>05</TipoDocumentoIdentidad>
                        <NumeroDocumentoIdentidad>1</NumeroDocumentoIdentidad>
                        <TipoPortabilidad>01</TipoPortabilidad>
                        <NombreContacto>Test</NombreContacto>
                        <EmailContacto>a@a.com</EmailContacto>
                        <TelefonoContacto>73269901</TelefonoContacto>
                        <FaxContacto>73269901</FaxContacto>
                        <TipoServicio>1</TipoServicio>
                        <Cliente>2</Cliente>
                    </EnvioSolicitudCedente>
                      </CuerpoMensaje>
                 </MensajeABDCP>';
             return $EnvioSolicitudCedente;   

      }
      
            public  function _ConsultaPreviaAceptadaCedente($Date,$tp,$IdentificadorProceso) 
          {
            $cabecera = $this->_cabeceraXml($tp,$IdentificadorProceso);
            $ConsultaPreviaAceptadaCedente = ''.$cabecera.' 
                      <CuerpoMensaje IdMensaje="CPAC">
                           <ConsultaPreviaAceptadaCedente>
                               <Numeracion>'.$Date.'</Numeracion>
                               <Observaciones>Previous Consultation Donor Acceptance Response</Observaciones>
                           </ConsultaPreviaAceptadaCedente>
                      </CuerpoMensaje>
                   </MensajeABDCP>';
            return $ConsultaPreviaAceptadaCedente;   

         }

          public  function _ConsultaPreviaObjecion($Date,$tp,$IdentificadorProceso)
       {
         $cabecera = $this->_cabeceraXml($tp,$IdentificadorProceso);
          $ConsultaPreviaObjecion = ''.$cabecera.' 
                   <CuerpoMensaje IdMensaje="CPOCC">
                        <ConsultaPreviaObjecionConcesionarioCedente>
                                <CausaObjecion>'.$Date['ERROR'].'</CausaObjecion>
                                <Numeracion>'.$Date['Numeracion'].'</Numeracion>
                        </ConsultaPreviaObjecionConcesionarioCedente>
                   </CuerpoMensaje>
                </MensajeABDCP>';
         return $ConsultaPreviaObjecion;   

      }

      
              
              
                 public  function _ObjecionConcesionarioCedente($Date,$tp,$IdentificadorProceso)
       {
         $cabecera = $this->_cabeceraXml($tp,$IdentificadorProceso);
          $ConsultaPreviaObjecion = ''.$cabecera.' 
                    <CuerpoMensaje IdMensaje="OCC">
                        <ObjecionConcesionarioCedente>
                                <CausaObjecion>'.$Date['ERROR'].'</CausaObjecion>
                                <Numeracion>'.$Date['Numeracion'].'</Numeracion>
                                </ObjecionConcesionarioCedente>
                        </CuerpoMensaje>
                </MensajeABDCP>';
         return $ConsultaPreviaObjecion;   

      }
      
      
                public  function _SolicitudAceptadaCedente($Date,$tp,$IdentificadorProceso)
       {
         $cabecera = $this->_cabeceraXml($tp,$IdentificadorProceso);
          $ConsultaPreviaObjecion = ''.$cabecera.' 
                    <CuerpoMensaje IdMensaje="SAC">
                            <SolicitudAceptadaCedente>
                                    <Observaciones>Test numeracion '.$Date['Numeracion'].'-SAC</Observaciones>
                            </SolicitudAceptadaCedente>
                    </CuerpoMensaje>
            </MensajeABDCP>';
         return $ConsultaPreviaObjecion;   

      }
      
}
