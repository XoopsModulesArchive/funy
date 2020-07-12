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

include_once (XOOPS_ROOT_PATH . "/modules/jjd_tools/_common/class/cls_jjd_ado.php");

class cls_funy_proverbe extends cls_jjd_ado {  

/************************************************************
 * declaration des variables membre:
 ************************************************************/

      
/*============================================================
 * Constructucteur:
 =============================================================*/
//function  cls_hermes_texte($table, $colNameId, $becho = 0){
function  cls_funy_proverbe($becho = 0){
  cls_jjd_ado::cls_jjd_ado(_FUN_TFN_PROVERBE, "idProverbe", $becho); 
  
  return true;
  
}

/*============================================================
 * methodes:
 =============================================================*/
  
/******************************************************
 *
 ******************************************************/
function getArray ($id,$colList = '*', $becho = 0){
	global  $xoopsDB;

  if ($id == 0) {
      $p = array ('idProverbe'      => 0, 
                  'texte'           => '',
                  'categorie'       => '',                  
                  'auteur'          => '',
                  'pays'            => '');

  }
  else {
    $sqlQuery = $this->getRow($id,$colList,$becho);
    $p = $xoopsDB->fetchArray($sqlQuery);
    
    //$p['nom']   = sql2string ($p['nom']);
    $p['texte'] = sql2string ($p['texte']);
  }
  return $p;
}

/****************************************************************
 *
 ****************************************************************/

function newRow ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	$sql = "INSERT INTO {$this->table}"
	      ." (categorie,pays,auteur,texte) "
	      ." VALUES ('???','???','???','???')";
	
       $xoopsDB->query($sql);	

  
}
/****************************************************************
 *
 ****************************************************************/

function newEmptyRow () {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
	$sql = "INSERT INTO {$this->table}"
	      ." (categorie,pays,auteur,texte) "
	      ." VALUES ('','','','')";

 $xoopsDB->query($sql);	
 $newId = $xoopsDB->getInsertId() ;
 return $newId;
  
}

/*******************************************************************
 *
 *******************************************************************/
function saveRequest ($t) {
	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	   $myts =& MyTextSanitizer::getInstance();
	   // $name = $myts->displayTarea();	

  //------------------------------------
  
  $idProverbe = $t['idProverbe'];
  //-----------------------------------------------------------
  //-----------------------------------------------------------
   $t['txtAuteur']     = string2sql($t['txtAuteur']);
   //$t['txtCategorie'] =  string2sql($t['txtCategorie']);   
   //$t['txtTexte'] = string2sql($t['txtTexte']);
   $txt = $t['txtTexte'];
   $txt = $myts->addSlashes($txt);   
    
  if ($idProverbe == 0){
    
      $sql = "INSERT INTO {$this->table} "
            ." (categorie,pays,auteur,texte)"
            ."VALUES (" 
            ."'{$t['txtCategorie']}'," 
            ."'{$t['txtPays']}',"
            ."'{$t['txtAuteur']}',"                         
            ."'{$txt}'"
            .")";

            
      $xoopsDB->query($sql);
    
  }else{
      $sql = "UPDATE {$this->table} SET "
           ." categorie  = '{$t['txtCategorie']}',"
           ." pays       = '{$t['txtPays']}',"           
           ." auteur     = '{$t['txtAuteur']}',"  
           ." texte   = '{$txt}'"  
           ." WHERE idProverbe = ".$idProverbe;
          
      $xoopsDB->query($sql);            
  }
           
//echo "<hr>{$sql}<hr>";
//exit;
}
//==============================================================================
} // fin de la classe

?>



