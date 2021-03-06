/**************************************************************************
 * Ce sript pertmet de faire d�filer de mani�re al�atoire des images de m�me dimention
 * dans un block pr�d�fini .
 * Le script original provient du site 	www.dhtmlgoodies.com 
 * Il ne permetait de faire d�filer que des miniatures sur un des c�t� de XOOPS 
 * Je l'ai largement modifi� dans sa partie PHP principalement pour r�pondre � mes besoins
 *  
 * Ajouts et modifications 
 * ------------------------ 
 * Calcul automatique de la taille des images. toutes les images doivent avoir 
 * la m�me taille, mais cette taille peut �tre diff�rentes selon le jeu dimages.
 * L'ancienne option � �t� conserver, il suffit de remettre la variable $modeSize � z�ro
 * Il est donc possible � pr�sent de le metttre au centre avec des images plus grandes
 *  
 * Le repertoire ou se trouve les image doit �tre dans le dossier uploads de Xoops
 * mais le sous-dossier peut �tre chang� plus facilement, il suffit de modifier la variable $folder
 * 
 * Le nombre d'image � �t� rendu automatique pour la construction du JavaScript
 * $nbImages est le nombre d'image du slideShow s�lectionn�e dans la liste 
 *    r�pondant au crit�re de filtre �nonc� plus pas 
 * Il suffit juste de modifier la variable $nbImages. 
 * Si $nbImages = z�ro ou plus grand que le nombre d'images disponibles, 
 *    $nbImages prends * la totalit� de la s�l�ction.
 * Il est possible � pr�sent de ne selectionner q'une seule image, 
 *    cela donne un effet de battement de coeur.
 * 
 *
 * Ajout d'options de filtrage dans la construction de la liste des images s�lectionables.
 *    $prefixe   : Filtre tous les fichiers qui commencent par ce pr�fixe
 *    $extention : Filtre tous les fichiers qui finissent par ce suffixe en g�n�ral une extention  
 *    $caseSensitiveOnPrefixe : Filtre sur la casse de $prefise et $extention  (serveur linux uniquement)           
 *    $caseSensitiveOnExtention : Filtre sur la casse de $extention et $extention (serveur linux uniquement)   
 * 
 * Ajout d'une l�gende optionnelle au dessus ou au dessous ($legendTop et $legendBottom);
 * Cette l�gende peut �tre du code HTML comme une adresse HTML 
 * 
 * Ajout de la possibilit� de param�trer le slide: 
 *    $timeBetweenSlides = d�lai en millieme de seconde entre chaque afichage
 *    $fadingSpeed       = rapidite de l'stompage  valeur plus petite = plus rapide
 *    $currentOpacity    = opacit� initiale
 *  
 * Ajout d'option de debugage. 
 * si_DEBUG = true, les noms des fichier sont affic�s sur la page ainsi 
 *  que d'autre information utilies pour les tests 
 * Il ne faut as oublier de remetre _Degug a false avant la mise en prod
 ***************************************************************************                 
 * Installation
 * Cr�er un bloqck, copier ce script dans le block
 * sp�cifiez que c'est un script PHP
 * n'oubliez pas de modifier les param�tres selon vos besoins    
 ***************************************************************************
 * Licence: c'est la m�me que celle du script d'origine
 *          je vous demanderais de garder aussi dans les commentaire 
 *          mes r�f�rences en plus de celles des auteurs d'origine  
 ***************************************************************************
 * script 
 * original     : (C) www.dhtmlgoodies.com, November 2005 
 * modification : Jean-Jacques DELALANDRE le 22/08/2006.
 * eMail        : jjd@kiolo.com
 * site         : http://ace.wakasensei.fr  
 **************************************************************************/


/**************************************************************************
version et nom du script
 *************************************************************************/
define ("_BLOCK_VERSION", '1.1.8');
define ("_BLOCK_NAME", 'Fondu');
 
/**************************************************************************
si vrai affiche la liste des fichier selectionn�, 
a utiliser uniquement pour faire des tests
ne pas oublier de la remmetre � false in fine
 *************************************************************************/
define ("_DEBUG", false);

/**************************************************************************
constantes definies pour la fonction d'affichage des infos de debugage
c'est la somme binaire de ces constante qui sera utilis� par la fonction
ex: si on veut envoyer le message "Hele sur une ligne cadre � gauche pr�c�d�e 
par un trait horizontale, et suivi d'un retour � la ligne il faudra passer en parametres:
    _HTML_LINE_BEFORE | _HTML_LEFT | _HTML_CRLF_AFTER
on peut aussi utiliser le signe "+" au lieu de "|" , mais attention aux valeurs passees en doublon
    _HTML_LINE_BEFORE | _HTML_LEFT | CRLF_AFTER | CRLF_AFTER   sera correct malgre le doublon CRLF_AFTER 
    _HTML_LINE_BEFORE + _HTML_LEFT + CRLF_AFTER + CRLF_AFTER   sera incorrect et ne donnera pas le r�sultat excompt�  
*************************************************************************/
//valeur de base
define ("_HTML_NONE",             0);
define ("_HTML_CRLF_BEFORE",      1);
define ("_HTML_CRLF_AFTER",       2);
define ("_HTML_BEGIN_LEFT",       4);
define ("_HTML_END_LEFT",         8);
define ("_HTML_LINE_BEFORE",     16);
define ("_HTML_LINE_AFTER",      32);

//valeur composite
define ("_HTML_ONLINE_ALONE",     3);
define ("_HTML_ONLEFT_ALONE",    15);
define ("_HTML_LINES",           48);
define ("_HTML_LEFT",            12);






////////////////////////////////////////////////////////////////////////////



/***************************************************************************
* Renvoie un tableau du chemin complet des fichier r�pondant aux crit�res
* pass� en param�rtes
* permet de filtrer sur un prefixe et sur l'extention
* auteur: Jean-Jacques DELALANDRE
function fondu_getFiles($chemin, 
                        $prefixe = "" , 
                        $extention = "", 
                        $caseSensitiveOnPrefixe   = false, 
                        $caseSensitiveOnExtention = false){

***************************************************************************/
function fondu_getFiles($p){

$chemin = $_POST['$chemin'];
$prefixe = $_POST['$prefixe'];
$extention = $_POST['$extention'];
$caseSensitiveOnPrefixe = $_POST['$caseSensitiveOnPrefixe'];
$caseSensitiveOnExtention = $_POST['$caseSensitiveOnExtention'];




  $tFiles = array ();
  if (substr($chemin, -1, 1) <> "/"){$chemin .= "/";}

  if (_DEBUG){
    jdecho ($chemin, _HTML_ONLINE_ALONE + _HTML_BEGIN_LEFT);
    jdecho ("Prefixe cs =".(($caseSensitiveOnPrefixe)?"True":"False")." = '".$prefixe."'", _HTML_CRLF_AFTER);
    jdecho ("Extention cs =".(($caseSensitiveOnExtention)?"True":"False")." = '".$extention."'", _HTML_LINE_AFTER + _HTML_END_LEFT);
  }


  if ($caseSensitiveOnPrefixe && $caseSensitiveOnExtention){
    if ($extention == "" or $extention == "." ) {$extention = ".*" ;}
    if (substr($extention,0,1)<> ".") {$extention = ".".$extention ;}
    $modele = $chemin.$prefixe.'*'.$extention ;
    if (_DEBUG){jdecho ("Modele = ".$modele, _HTML_ONLEFT_ALONE);}
  
    $tFiles = glob($modele);
    }
  
  else {
      $prefixe   = str_replace("*", "", $prefixe);
      $extention = str_replace("*", "", $extention);
      
      $lgPrefixe   = strlen($prefixe);
      $lgExtention = strlen($extention);
      
      $repertoire = opendir($chemin);
      
      if (_DEBUG){jdecho ("", _HTML_BEGIN_LEFT);}
    
      while ($fichier = readDir($repertoire)){
        if (_DEBUG){jdecho ($fichier." = ", _HTML_CRLF_BEFORE );}

       //--------------------------------------------------------        
        if ($fichier == "." or $fichier == ".."){ continue;}
        //--------------------------------------------------------        
        if ($lgPrefixe > 0){
          if (caseSensitiveOnPrefixe){
            if ( strncmp( $fichier, $prefixe, $lgPrefixe) <> 0 ){ continue;}
          }
          else {
            if ( strncasecmp( $fichier, $prefixe, $lgPrefixe) <> 0 ){ continue;}
          }
        } 
        //--------------------------------------------------------        
        if ($lgExtention > 0){
          $tmp = substr($fichier, -$lgExtention, $lgExtention) ;
          if ($caseSensitiveOnExtention){
            if ( strncmp( $tmp, $extention, $lgExtention) <> 0 ){ continue;}          }
          else {
            if ( strncasecmp( $tmp, $extention, $lgExtention) <> 0 ){ continue;}
          }
        } 
        //--------------------------------------------------------        
        
        $tFiles [] = $chemin.$fichier;
        if (_DEBUG){jdecho ("ok", _HTML_NONE);}
      } 
    closeDir ($repertoire); 
    if (_DEBUG){jdecho ("---Fin de fondu_getFiles----------------------", _HTML_CRLF_BEFORE + _HTML_END_LEFT + _HTML_LINE_AFTER);}
    
  }
  
  return $tFiles;
}

/***************************************************************************
fonction d'affiche des information de debugage
auteur: Jean-Jacques DELALANDRE
***************************************************************************/
function jdecho ($expression, $flag = _HTML_NONE){

  if (!_DEBUG) {return;}

  if (($flag &  _HTML_LINE_BEFORE) <> 0){echo '<hr>';}
  if (($flag &  _HTML_CRLF_BEFORE) <> 0){echo '<br>';}
  if (($flag &  _HTML_BEGIN_LEFT)  <> 0){echo '<p align="left">';}

  echo $expression;

  if (($flag &  _HTML_END_LEFT)    <> 0){echo '</p>';}
  if (($flag &  _HTML_CRLF_AFTER)  <> 0){echo '<br>';}
  if (($flag &  _HTML_LINE_AFTER)  <> 0){echo '<hr>';} 
}



/************************************************************************
 *
 ************************************************************************/
function buildFondu($ini){
/***************************************************************************
Parametrage du SlideShow
***************************************************************************/

$folder = $ini['folder']['value'];
$prefixe = $ini['prefixe']['value'];
$extention = $ini['extention']['value'];
$caseSensitiveOnPrefixe = $ini['caseSensitiveOnPrefixe']['value'];
$caseSensitiveOnExtention = $ini['caseSensitiveOnExtention']['value'];
 = $ini['']['value'];
 = $ini['']['value'];
 = $ini['']['value'];
 = $ini['']['value'];
 = $ini['']['value'];
 = $ini['']['value'];
 = $ini['']['value'];
 = $ini['']['value'];


/***************************************************************************
Nombre d'image s�lectionn�es pour l'afichage dans la moulinette - 0 = toutes
***************************************************************************/
$nbImages = 0;

/**************************************************************************
D�fitinition de la taille par defaut
j'ai gard� cette option pour garder la compatibilit� avec le script d'origine
 *************************************************************************/
$thumbWidthDefault  = 141;
$thumbHeightDefault = 100;


/***************************************************************************
Message affich� audessus ou au dessous des images il peut inclure des balises HTML
ils seront automatiquement centr� donc pas besoin d'ajouter la balise center
Afect� une chaine vide pour ne pas afficher de l�gende
***************************************************************************/
$legendTop   = '<B>Bienvenue - '._BLOCK_NAME.' v '._BLOCK_VERSION.'</B>';
$legendBotom = '<p align="center"><a href="mailto:JJD@kiolo.com">mailto:JJD@kiolo.com</a></p>';





/***************************************************************************
Construction de la liste des images
***************************************************************************/

    $images = array();
    $f = str_replace("//", "/", XOOPS_UPLOAD_PATH.'/'.$folder.'/');
    
    $images = fondu_getFiles($f, $prefixe, $extention, 
                             $caseSensitiveOnPrefixe, $caseSensitiveOnExtention);
    
    $tbluneimage = array();
    srand((double) microtime() * 10000000);
    $tImagesSelected = array();
    
    //si le nombre d'images est z�ro ou plus grand que le nombre d'image disponible on les prends toutes
    if ($nbImages == 0 or $nbImages > count($images)){ $nbImages = count($images);}
    
    /*
    si le nombre d'image est 1 on les prends une image au hazard et 
    on cre un tableau de 2 itel aec la meme image, sinon il y un blanc pas tres �l�gant
    */
    if ($nbImages == 1){
      $tbluneimage[] = array_rand($images, $nbImages );
      $tbluneimage[] = $tbluneimage[0] ;
    }
    else{
      $tbluneimage = array_rand($images, $nbImages );
    }
    
    
    //construction de la liste des images a ins�rer dans le script
    foreach($tbluneimage as $uneimage) {
      $img =  XOOPS_UPLOAD_URL.'/'.$folder.'/'.basename($images[$uneimage]);
    	$tImagesSelected[] = '<img src="'.$img.'">';
    	//echo "==>".$img."<br>";
    }
    
    //initialisation de la chaine � inserer dans la liste dans la page HTML (voir $headerArray)
    $sep = chr(13).chr(10);
    $lstImages = implode($sep, $tImagesSelected); 
    
    /***************************************************************************
    Calcule la taille des images
    ***************************************************************************/
    if ($modeSize == 0){
      /***************************************************************************
      taille pr�d�finie par les constantes
      ***************************************************************************/
      $thumb_width  = $thumbWidthDefault.'px';
      $thumb_height = $thumbHeightDefault.'px';
    }
    else {
      /***************************************************************************
      Recupere la taille de la preiiere image qui servira pour toutes les images
      toutes les images du r�pertoires doivent donc avoir la meme taille
      ***************************************************************************/
      //echo "<hr>{$images[0]}<hr>";
      //$img = imagecreatefromjpeg($images[0]);
      //$thumb_width  = imageSX($img).'px';
      //$thumb_height = imageSY($img).'px';
      
      $thumb_width  = '300'.'px';
      $thumb_height = '100'.'px';
      
    }


  

/***************************************************************************
cnstruction du tableau pour le script
***************************************************************************/
$headerArray = 


$headerArray = <<<fintexte
	<div id="imageSlideshowHolder">
	  $lstImages
	</div>
<script type="text/javascript">
initImageGallery();	// Initialize the gallery
</script>
fintexte;

/***************************************************************************
On envoie la soudure
***************************************************************************/

$t = array();
    
    if ($legendTop <>""){ $t[] = "<center>".$legendTop."</center>";}
    $t[] = $headerStyle;
    $t[] = $headerScript;
    $t[] = $headerArray;
    if ($legendBotom <>""){$t[] = "<center>".$legendBotom."</center>";}
        
    return implode ("\n", $t);
}

/***************************************************************************/

/*

switch ($_POST['op']){
  case 'getFiles'
    $t = fondu_getFiles($_POST);
    break;
    
    default:
      break;
  
}
*/