<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cidade
 *
 * @author DTI
 */
class Cidade extends TRecord{
   
    const TABLENAME = 'cidade';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
}
