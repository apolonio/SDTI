<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoSoftware
 *
 * @author DTI
 */
class TipoSoftware extends TRecord{
   
    const TABLENAME = 'system_tipo_software';
    const PRIMARYKEY= 'codTipoSoft';
    const IDPOLICY =  'max'; // {max, serial}
}

