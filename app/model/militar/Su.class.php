<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Su
 *
 * @author DTI
 */
class Su extends TRecord{
     const TABLENAME = 'su';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
}
