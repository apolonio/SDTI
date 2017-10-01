<?php


class AcessoManutencao extends TRecord{
   
    const TABLENAME = 'system_manutencao';
    const PRIMARYKEY= 'idMnt';
    const IDPOLICY =  'max'; // {max, serial}
}
