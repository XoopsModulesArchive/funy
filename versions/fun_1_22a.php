<?php
//  ------------------------------------------------------------------------ //
//       FUNY - Module de gestion de  JAVASCRIPT pour XOOPS                  //
//                    Copyright (c) janvier 2008 JJ Delalandre               //
//                       <http://xoops.kiolo.com>                            //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon
les termes de la Licence Publique G�n�rale GNU publi�e par la Free Software 
Foundation (version 2 ou bien toute autre version ult�rieure choisie par vous). 

Ce programme est distribu� car potentiellement utile, 
mais SANS AUCUNE GARANTIE, ni explicite ni implicite, 
y compris les garanties de commercialisation ou d'adaptation 
dans un but sp�cifique. Reportez-vous � la Licence Publique G�n�rale GNU 
pour plus de d�tails. 

Vous devez avoir re�u une copie de la Licence Publique G�n�rale GNU 
en m�me temps que ce programme ; si ce n'est pas le cas, 
�crivez � la 
               Free Software Foundation, Inc., 
               59 Temple Place, Suite 330, 
            Boston, MA 02111-1307, +tats-Unis. 

Cr�eation janvier 2007
Derni�re modification : janvier 2009 
******************************************************************************/


class cls_fun_1_22a{  

/************************************************************
 * declaration des varaibles membre:
 ************************************************************/
  var $version      = '1.06a';  
  var $dateVersion  = "2008-12-31 12:12:12"; //date("Y-m-d h:m:s");
  var $description  = "mofification pour nouveaux type de plugin";

            

/************************************************************
 * Constructucteur:
 ************************************************************/
  function  cls_fun_1_22a($options){
 
  }

/*************************************************************************
 *
 *************************************************************************/
function getVersion()     {return $this->version;}
function getDateVersion() {return $this->dateVersion;}
function getDescription() {return $this->description;}


/*************************************************************************
 *
 *************************************************************************/

function updateModule(&$module){

    $this->alter_event();
    $this->alter_smarty();    
    return true;

} // fin updtateModule




/*************************************************************************
 *
 *************************************************************************/
function alter_event(){
global $xoopsModuleConfig, $xoopsDB;

  //-------------------------------------------  
  $table = $xoopsDB->prefix('fun_event');  
  
  $sql = "ALTER TABLE {$table} "
        ." ADD `description` VARCHAR( 255 ) NOT NULL,"  
        ." ADD `multi` TINYINT NOT NULL DEFAULT '0';";  
  $xoopsDB->queryF ($sql);  
  //--------------------------------------------------  
  return true;   
   
}//fin 


/*************************************************************************
 *
 *************************************************************************/
function alter_smarty(){
global $xoopsModuleConfig, $xoopsDB;

  //-------------------------------------------  
  $table = $xoopsDB->prefix('fun_smarty');  
  
  $sql = "ALTER TABLE {$table} "
        ." ADD `flag` TINYINT NOT NULL DEFAULT '0';";  
  
  $xoopsDB->queryF ($sql);  
  //--------------------------------------------------  
  return true;   
   
}//fin 


//-----------------------------------------------------------
//-----------------------------------------------------------

} // fin de la classe

?>


