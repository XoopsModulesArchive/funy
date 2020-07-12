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
include_once (_FUN_JJD_PATH.'include/adminOnglet/adminOnglet.php');
include_once (_FUN_JJD_PATH.'class/cls_admin_block.php');

//-----------------------------------------------------------------------------------
global $xoopsModule;
$slash = ((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/');
include_once (XOOPS_ROOT_PATH.$slash."/modules/".$xoopsModule->getVar('dirname')
                                    ."/include/funy_constantes.php");
include_once (XOOPS_ROOT_PATH.$slash."/modules/".$xoopsModule->getVar('dirname')
                                    ."/include/funy_generique.php");
                                     
                                     
//-----------------------------------------------------------------------------------


//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => 'list'),
              array('name' =>'idBlock',   'default' => 0),
              array('name' =>'pinochio',  'default' => false));
require (_FUN_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------


/************************************************************************
 *
 ************************************************************************/
 if (isset($gepeto['cancel'])) $op="list";
 //echo "<hr>op = {$op}<hr>";
global $xoopsModule;

$clBlock = new cls_admin_block($xoopsModule->mid());
 	
  admin_xoops_cp_header(_FUN_ONGLET_BLOCK, $xoopsModule); 

  switch($op) {
  case "list":
		//listBlock ();
		$clBlock->listBlock (_AD_FUN_BLOCKS, _AD_FUN_BLOCKS_FUNY_DSC);
		break;


  case "save":
		$clBlock->saveBlocks ($gepeto['txtBlock']);
		//buildFileBlock2Insertt();
    redirect_header("admin_block.php?op=list",1,_AD_FUN_ADDOK);		
		break;

		
	default:
	 $state = _FUN_STATE_WAIT;
    redirect_header("admin_block.php?op=list",1,_AD_FUN_ADDOK);
    break;
}


   
admin_xoops_cp_footer();

 

 
//---------------------------------------------------------------------
    

?>
