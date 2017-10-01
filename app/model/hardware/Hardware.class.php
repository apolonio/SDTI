<?php


class Hardware extends TRecord{
   
    const TABLENAME = 'system_hard';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
}
