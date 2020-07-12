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



include_once ("admin_header.php");
include_once (XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/')
                             ."modules/jjd_tools/_common/include/functions.php");


include_once ("../include/funy_data.php");
include_once ('admin_event_fnc.php');
//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'ok',        'default' => 0),
              array('name' =>'pinochio',  'default' => false));    
                        
require (_FUN_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

/****************************************************************
 *
 ****************************************************************/ 

  $msg = _AD_FUN_ADDOK;
 // echo "<hr>";
//  echo $op.'<br>';
  //---------------------------------------------------------
  switch ($op){
  
  case "initFunyBlocks":

    initFunyBlocks();  
    saveEventVierge();
    //echo "<hr>";    
    $msg = _AD_FUN_BLOCKS_INITIALISES;
    break;
    
  }

  
  redirect_header("index.php",3,$op."<br>".$msg);
  
?>
