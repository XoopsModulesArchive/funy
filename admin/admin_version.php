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

// General settings
//include_once ("header.php");
global $xoopsModule;

/*

include_once (XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/')
                               ."modules/".$xoopsModule->getVar('dirname')
                               ."/include/funy_constantes.php");

*/
$root = XOOPS_ROOT_PATH.((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/').
                          "modules/jjd_tools/";
include_once ($root."include/jjd_constantes.php");
include_once ($root."_common/include/version_functions.php");


//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'pinochio',  'default' => false));
              
require (_FUN_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------



/**********************************************************************
 *
 **********************************************************************/ 
//function xoops_module_install_xoopshack(&$module) {
function xoops_module_install_funy(&$module) {
global $xoopsModuleConfig, $xoopsDB;


}


/**********************************************************************
 *
 **********************************************************************/ 
//function xoops_module_update_xoopshack(&$module) {
function xoops_module_update_funy(&$module) {
global $xoopsModuleConfig, $xoopsDB;
  
  return update_module($module);
  

}

/**********************************************************************
 *
 **********************************************************************/ 
//function xoops_module_uninstall_xoopshack(&$module) {
function xoops_module_uninstall_funy(&$module) {
global $xoopsModuleConfig, $xoopsDB;

  kill_Module($module);

}
 
 

?>

