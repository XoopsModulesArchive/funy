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


// Nav box admin Menu
$i=0;

$adminmenu[++$i]['title'] = _MI_FUN_MANAGEMENT;
$adminmenu[$i]['link'] = "admin/index.php?onglet=0&op=";

$adminmenu[++$i]['title'] = _MI_FUN_PLUGINS;
$adminmenu[$i]['link'] = "admin/admin_plugin.php";

$adminmenu[++$i]['title'] = _MI_FUN_EVENT;
$adminmenu[$i]['link'] = "admin/admin_event.php";

$adminmenu[++$i]['title'] = _MI_FUN_PROVERBES;
$adminmenu[$i]['link'] = "admin/admin_proverbe.php";


$adminmenu[++$i]['title'] = _MI_FUN_BALISE;
$adminmenu[$i]['link'] = "admin/admin_balise.php";

//-----------------------------------------------------
$adminmenu[++$i]['title'] = _MI_FUN_BLOCKS;
$adminmenu[$i]['link'] = "admin/admin_block.php?op=list";

$adminmenu[++$i]['title'] = _MI_FUN_DOCUMENTATION;
$adminmenu[$i]['link'] = "admin/admin_doc.php?op=readDoc&numDoc=0";

$adminmenu[++$i]['title'] = _MI_FUN_LICENCE;
$adminmenu[$i]['link'] = "admin/admin_doc.php?op=readDoc&numDoc=1";

$adminmenu[++$i]['title'] = _MI_FUN_HISTO;
$adminmenu[$i]['link'] = "admin/admin_doc.php?op=readDoc&numDoc=2";

/*

$adminmenu[++$i]['title'] = _MI_XOOPSOTRON_SETTINGS;
$adminmenu[$i]['link'] = "admin/settings.php";
*/


?>
