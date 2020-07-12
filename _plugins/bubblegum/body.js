
////////////////////////////////////////////////////////////////////////////////////////////////////////

function $(id)
{	// pour les inconditionnels de "prototype"
	return document.getElementById(id);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

function hex(x)
{	// convertit un octet num�rique en un format "string hexad�cimal"
	var s=Math.round(x).toString(16).toUpperCase();
	
	return (s.length==2)? s : '0'+s;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

function getgradient(color1,color2,n)
{	// renvoie un tableau de n d�grad�s allant des couleurs color1 � color2 comprises
	var 
		i,gradient=[],
		r0=(color1>>16)& 0xFF,
		g0=(color1>>8)& 0xFF,
		b0=(color1>>0)& 0xFF,
		r=(((color2>>16)& 0xFF)-r0)/(n-1),
		g=(((color2>>8)& 0xFF)-g0)/(n-1),
		b=(((color2>>0)& 0xFF)-b0)/(n-1);

	for (i=0;i<n;i++) gradient[i]='#'+hex(r0+r*i)+hex(g0+g*i)+hex(b0+b*i);
	
	return gradient;
}

// ici commence la classe //////////////////////////////////////////////////////////////////////////////

function animation(){}									// pas tr�s original comme nom, mais bon...

////////////////////////////////////////////////////////////////////////////////////////////////////////

animation.prototype.sonjob=function(p)
{	// ex�cution du "processus fils"
	with (this.PROCESS[p]) {							// "chaud bouillant", les 2 blocs "with"	imbriqu�s!
		//alert ("t= " + t);
    if (t>=0) with ($('absolute'+charnum).style) {			// caract�re en cours de traitement
			color=this.GRADIENT[t];
			fontSize = (this.INCR * t)+this.SIZEMIN + "px";		// calcul de la taille de police
			//zzz= this.INCR * t;
			//alert("this.INCR = " + this.INCR + " - t = " + t + " - fontsize = " + fontSize + " - zzz = " + zzz);
			top=((this.HEIGHT[0]-this.HEIGHT[t])/2)+"px";	// positionnements "top" et "left" du caract�re
			left=(posleft+(this.WIDTH[charnum][0]-this.WIDTH[charnum][t])/2)+"px";
			t--;
		}	
		else {												// le traitement du caract�re courant est termin�											
			if (charnum==this.CHARMAX-1) clearInterval(timer); // le processus est termin� : on le "tue"
			else {											// traitement d'un nouveau caract�re
				t=this.TMAX-1;
				posleft+=(this.WIDTH[charnum++][0])+"px";
			}
		}
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

animation.prototype.createson=function(p)
{	// cr�ation d'un "processus fils" et initialisation de ses attributs
	var _this=this;			// astuce pour contourner le rejet de "this" dans la fonction "setInterval"
	
	return {
		t : this.TMAX-1,		// on commence par la taille de police la plus grande
		charnum : 0,			// n� du caract�re en cours de traitement
		posleft : 0+"px",			// positionnement "left" de ce caract�re dans la plus petite taille de police
		timer : setInterval(function(){_this.sonjob(p);},this.DELAY)	// identifiant du "processus fils"
	};
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

animation.prototype.fatherjob=function()
{	// la t�che du "processus p�re" : cr�er ses 4 "processus fils" � intervalles r�guliers
	this.PROCESS[this.PROCESSNUM]= this.createson(this.PROCESSNUM);
	if (++this.PROCESSNUM==this.PROCESSMAX) clearInterval(this.TIMER);		
}

//////////////////////////////////////////////////////////////////////////////////////////////////////// 

animation.prototype.createfather=function()
{	// d�marre l'animation en cr�ant le "processus p�re"
	var _this=this;			// astuce pour contourner le rejet de "this" dans la fonction "setInterval"
	
	this.TIMER=setInterval(function(){_this.fatherjob();},this.DELAY*this.DELTA);
/*

	if (funy_bubblegum_reprise > 0){
    funy_bubblegum_reprise --;
    //this.createfather();	
	  //setTimeout(function(){_this.createfather();}, 10000);    
	  alert ("reprise = "+ funy_bubblegum_reprise);	  
	  setTimeout(function(){_this.createfather();}, 30000);	  

  }
*/
}
 
////////////////////////////////////////////////////////////////////////////////////////////////////////

animation.prototype.init=function(logo)
{	// calculs et op�rations pr�alables
	var i, j, len=logo.length, w, size,posleft, s='', div1=$('div1');
	
//div1.style.width  = "300px";
//div1.style.height  = "600px";
      
	// attribution de la premi�re couleur 
	div1.style.color=this.GRADIENT[0];	
	// affichage du logo en positionnement "static"
	for (i=0;i<len;i++) 
		s+='<span id="static'+i+'" style="position:static; font-size:'+this.SIZEMIN+'px;">'+logo.charAt(i)+
			'</span>';
			
//		s+='<span id="static'+i+'" style="position:static; font-size:'+this.SIZEMIN*2+'px;">'+ "X" +
//			'</span>';

	div1.innerHTML=s;
	
	// calcul de la largeur w du logo et stockage de la largeur de chaque caract�re dans chaque taille
	for (i=w=0;i<len;i++) with ($('static'+i)) {								// pour chaque caract�re
		w+=offsetWidth;	
		this.WIDTH[i]=[];
		for (j=0,size=this.SIZEMIN;j<this.TMAX;j++,size+=this.INCR) {	// pour chaque taille
		//alert("j = " + j + " - size = " + size);
			style.fontSize=size;
			this.WIDTH[i][j]=offsetWidth;		
			if (!i) this.HEIGHT[j]=offsetHeight;	
		}
	}
	
	// centrage du logo
/*

alert (div1.id
      + " - lw = " + div1.style.width 
      + " - lh = " + div1.style.height
      + " - ll = " + div1.style.left      
      + " - lt = " + div1.style.top);    
      
*/        
	div1.style.width=w + "px";
	div1.style.marginLeft = funy_bubblegum_marginLeft + "px"; // (w/2);

	// maintenant, affichage du logo en positionnement "absolute"
	ll= div1.style.left;
	for (i=posleft=0,s='';i<len;posleft+=this.WIDTH[i][0],i++) {

		s+='<span id="absolute'+i+'" style="position:absolute; left:'+posleft+'px; font-size:'+this.SIZEMIN+
			'px; z-index:'+(len-i)+';">'+logo.charAt(i)+'</span>';
    
  }

//		s+='<span id="absolute'+i+'" style="position:absolute; left:'+posleft+'; font-size:'+this.SIZEMIN*2+
//			'px; z-index:'+(len-i)+';">'+"Y"+'</span>';
	div1.innerHTML=s;	
	//div1.innerHTML=">>>>>" + s + "<<<<<";	
	//alert ("posleft = " +	posleft );
	
	return len;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

animation.prototype.construct=function(logo,color1,color2)
{	// "constructeur" de la classe
	this.TMAX=15;			// nombre de tailles de police : en partant de SIZEMIN par incr�ment de INCR
	this.SIZEMIN=30;		// en pixels, plus petite taille de police
	this.INCR=6;			// sert � calculer les tailles successives de police
	this.CHARMAX=0;		// nombre de caract�res du logo
	this.WIDTH=[];			// tableau 2 dimensions des largeurs de chaque caract�re dans chaque taille de police
	this.HEIGHT=[];		// tableau 1 dimension de la hauteur de chaque taille de police 
	this.GRADIENT=[];		// tableau des d�grad�s : un pour chaque taille de police
	this.TIMER=0;			// identifiant du "processus p�re"
	this.PROCESS=[];		// tableau des "processus fils" cr��s
	this.PROCESSMAX= funy_bubblegum_processMax ;	// nombre de "processus fils" � cr�er
	this.PROCESSNUM=0;	// n� du "processus fils" � cr�er
	this.DELTA=13;			// nombre de "DELAY" s�parant la cr�ation de 2 "processus fils" cons�cutifs
	this.DELAY=30;			// en ms, laps de temps s�parant, pour chaque "processus fils", le traitement de 2...
								// tailles cons�cutives du m�me caract�re
								
	// calcul des couleurs (fonc� pour les petits caract�res -> clair pour les gros)
	this.GRADIENT=getgradient(color1,color2,this.TMAX);
	// calcul des dimensions des caract�res dans les diff�rentes tailles de polices
	this.CHARMAX=this.init(logo);
	// lancement de l'animation proprement dite
	this.createfather();	
	//this.createfather();  							
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
function testdiv(){
var  div1=$('div1');
	div1.innerHTML="testdiv";  
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
function funy_bubblegum_start(){
  
  obj.construct(funy_bubblegum_logo, "0x" + funy_bubblegum_color1, "0x" + funy_bubblegum_color2);
  
	
  if (funy_bubblegum_reprise != 0 ){
    funy_bubblegum_reprise --;
    //if (funy_bubblegum_reprise != 1 ) funy_bubblegum_reprise --;    
    //this.createfather();	
	  //setTimeout(function(){_this.createfather();}, 10000);    
	  //alert ("reprise = "+ funy_bubblegum_reprise);	  
	  setTimeout(" funy_bubblegum_start()", funy_bubblegum_delai * 1000);	  

  }

}

////////////////////////////////////////////////////////////////////////////////////////////////////////
function funy_bubblegum_stop(){
  

}
////////////////////////////////////////////////////////////////////////////////////////////////////////

//alert ("bulle");
var obj=new animation();
//obj.construct('MONLOGO',0x336699,0x99CCCC);

// testdiv();
funy_bubblegum_reprise-- ;
funy_bubblegum_start();

