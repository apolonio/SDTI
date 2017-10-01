    <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemSoftware
 *
 * @author DTI
 */
class Software extends TRecord{
   
    const TABLENAME = 'system_software';
    const PRIMARYKEY= 'codSoft';
    const IDPOLICY =  'max'; // {max, serial}
}
