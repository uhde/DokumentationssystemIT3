<?php
include_once('../include/config.inc.php');
class Template{
	/**
	 * Constructor
	 * @access protected
	 */

	protected $arrTemplate;
	protected $arrTemplateBlocks;
	protected $TemplateIsLoaded;
	protected $arrData;
	protected $CurrentTemplate;
	protected $fp;
	protected $TemplateCaching;

// ###################################################### Konstruktor ##################################################
	function __construct($strTemplateFile="",$Charset="iso-8859-1"){
		//iso-8859-1
		$this->Config["UseTemplateCaching"]=False;
		$this->Config["ShowAssignErrors"]=False;
		$this->Config["TemplateCacheTTL"]=28800;
		$this->Config["TemplateCachePath"]="cache";
		$this->Config["DBTemplateType"]="MySQL";
    	$this->Config["DBTemplateDatabase"]="template";
		$this->Config["DBTemplateLogin"]="root";
		$this->Config["DBTemplatePassword"]=DB_PASSWORD;
		$this->Config["DBTemplateTable"]="template";
		$this->Config["DBTemplateSection"]="section";
		$this->Config["DBTemplateContent"]="content";
		$this->Config["Charset"]=$Charset;
		$this->TemplateIsLoaded=False;
		$this->TemplateCaching=False;
		$this->CurrentTemplate="";
		$this->ActiveInputFilter=array();
		$this->ActiveOutputFilter=array();
		$this->Filter=array();
		if ($strTemplateFile<>"" AND file_exists($strTemplateFile)) {
			$this->LoadTemplateFromFile($strTemplateFile);
		}
	}

// ####################################################### Destruktor ###################################################
	function __destruct(){
		unset($this->ActiveInputFilter);
		unset($this->ActiveOutputFilter);
		unset($this->Config);
		unset($this->Filter);
		if (isset($this->fp)) {
			fclose($this->fp);
		}
	}

// #################################################### Caching starten ################################################
	function StartCache($strValue){
		if ($this->Config["UseTemplateCaching"]===True) {

			$strValue=strtolower(eregi_replace("[^a-z0-9_-]","_", $strValue));
			$strFilename= substr(basename($this->CurrentTemplate),0,strpos(basename($this->CurrentTemplate),"."))."_".$strValue.".html";
	// Datei aus Cache holen?
			if (!empty($strValue)) {
				if (file_exists($this->Config["TemplateCachePath"]."/".$strFilename) AND (time()-filemtime($this->Config["TemplateCachePath"]."/".$strFilename))<$this->Config["TemplateCacheTTL"]) {
					readfile($this->Config["TemplateCachePath"]."/".$strFilename);
					$this->TemplateCaching=True;
				}else{
		// Neu generieren?
					$this->TemplateCaching=False;
					$this->fp=fopen($this->Config["TemplateCachePath"]."/".$strFilename,"wb+");
				}
			}else{
				$this->TemplateCaching=False;
			}
		}else{
				$this->TemplateCaching=False;
		}
	}

// ################################################### Caching beenden ################################################
	function EndCache(){
		if ($this->fp) {
			fclose($this->fp);
			unset($this->fp);
		}
		$this->TemplateCaching=False;
	}

// ################################################### Cachingstatus ##################################################
	function isCached(){
		return $this->TemplateCaching;
	}

// ############################################### Template ausgeben ################################################
	function Display($strSection) {
		if ($this->TemplateCaching===False) {
			$this->SetDefaultAssign();
// Nur falls Sektion existiert
			if (array_search($strSection, $this->arrTemplateBlocks)!==False) {
// Nur falls Sektion nicht leer
				if (is_array($this->arrTemplate[$strSection])) {
					$booClass=-1;
// Jede Zeile des  Templates durchlaufen
					foreach ($this->arrTemplate[$strSection] as $strTemplate){
// Template ausgeben
						$strOutput=preg_replace_callback("/{[$]([a-zA-z0-9]*)}/",array( &$this,"DataReplace"),$strTemplate);
						if (count($this->ActiveOutputFilter)>0) {
							for ($i=0;$i<count($this->ActiveOutputFilter);$i++) {
								$strOutput=preg_replace($this->Filter[$this->ActiveOutputFilter[$i]][0],$this->Filter[$this->ActiveOutputFilter[$i]][1],$strOutput);
							}
						}
						if (strtolower($this->Config['Charset'])=='utf-8') {
							echo utf8_encode($strOutput);
						}else{
							echo $strOutput;
						}

// Falls notwendig Cachefile erzeugen
						if (isset($this->fp)) {
							fwrite($this->fp,$strOutput);
						}
					}
// Cachefile schliessen
				}
			}else{
// Sektion existiert nicht
				echo  "<span style='color:#ff0000;font-weight:bold;'>Sektion '$strSection' existiert nicht!</span><br>";
			}
		}
	}


	// ############################################### Template ausgeben ################################################
	function DisplayToString($strSection) {
		$this->SetDefaultAssign();
		$strOutput="";
		// Nur falls Sektion existiert
		if (array_search($strSection, $this->arrTemplateBlocks)!==False) {
			// Nur falls Sektion nicht leer
			if (is_array($this->arrTemplate[$strSection])) {
				$booClass=-1;
				// Jede Zeile des  Templates durchlaufen
				foreach ($this->arrTemplate[$strSection] as $strTemplate){
					// Template ausgeben
					$strOutput.=preg_replace_callback("/{[$]([a-zA-z0-9]*)}/",array( &$this,"DataReplace"),$strTemplate);
					if (count($this->ActiveOutputFilter)>0) {
						for ($i=0;$i<count($this->ActiveOutputFilter);$i++) {
							$strOutput.=preg_replace($this->Filter[$this->ActiveOutputFilter[$i]][0],$this->Filter[$this->ActiveOutputFilter[$i]][1],$strOutput);
						}
					}
					$strTemplate.=$strOutput;
				}
			}
		}else{
			// Sektion existiert nicht
			echo  "<span style='color:#ff0000;font-weight:bold;'>Sektion '$strSection' existiert nicht!</span><br>";
		}
		return $strOutput;
	}

	function StringToString($strText) {
		$this->SetDefaultAssign();
		$strOutput="";
		// Template ausgeben
		$strOutput.=preg_replace_callback("/{[$]([a-zA-z0-9]*)}/",array( &$this,"DataReplace"),$strText);
		if (count($this->ActiveOutputFilter)>0) {
			for ($i=0;$i<count($this->ActiveOutputFilter);$i++) {
				$strOutput.=preg_replace($this->Filter[$this->ActiveOutputFilter[$i]][0],$this->Filter[$this->ActiveOutputFilter[$i]][1],$strOutput);
			}
		}
		return $strOutput;
	}

// ########################################## Standard-Assignments setzen ##########################################
	protected function SetDefaultAssign() {
		$this->arrData["TPL_CurrentDate"]=@date("d.m.Y");
		$this->arrData["TPL_CurrentTime"]=@date("H:i:s");
		$this->arrData["TPL_Timestamp"]=@time();
		isset($_SESSION['LANGUAGE']) ? $this->arrData["TPL_Language"]=$_SESSION['LANGUAGE'] : $this->arrData["TPL_Language"]='';
		isset($_SESSION["LOGIN_AUTO_LOGOUT_TIME"]) ? $this->arrData["TPL_MinutesToLogout"]=$_SESSION["LOGIN_AUTO_LOGOUT_TIME"] : $this->arrData["TPL_MinutesToLogout"]='';
		isset($_SESSION["LOGIN_AUTO_LOGOUT_TIME"]) ? 	$this->arrData["TPL_SecondsToAutoLogout"]=$_SESSION["LOGIN_AUTO_LOGOUT_TIME"] : 	$this->arrData["TPL_SecondsToAutoLogout"]='';
		isset($_SESSION["LOGIN_AUTO_LOGOUT_TIME"]) ? $this->arrData["TPL_LogoutTimestamp"]=time()+$_SESSION["LOGIN_AUTO_LOGOUT_TIME"] : $this->arrData["TPL_LogoutTimestamp"]='';
		isset($_SESSION["LOGIN_AUTO_LOGOUT_TIME"]) ? $this->arrData["TPL_LogoutUhrzeit"]=date("H:i",time()+$_SESSION["LOGIN_AUTO_LOGOUT_TIME"]) :  $this->arrData["TPL_LogoutUhrzeit"]='';
		isset($_SESSION["LOGIN_LOGOUT_SCRIPT"]) ? $this->arrData["TPL_LogoutScript"]=$_SESSION["LOGIN_LOGOUT_SCRIPT"] : $this->arrData["TPL_LogoutScript"]='';
		isset($_SESSION["LOGIN_LOGOUT_URL"]) ? $this->arrData["TPL_LogoutURL"]=$_SESSION["LOGIN_LOGOUT_URL"] : $this->arrData["TPL_LogoutURL"]='';
		isset($_SESSION["LOGIN_VORNAME"]) ? $this->arrData["TPL_LoginVorname"]=$_SESSION["LOGIN_VORNAME"] : $this->arrData["TPL_LoginVorname"]='';
		isset($_SESSION["LOGIN_NACHNAME"]) ? $this->arrData["TPL_LoginNachname"]=$_SESSION["LOGIN_NACHNAME"] : $this->arrData["TPL_LoginNachname"]='';
		isset($_SESSION["LOGIN_BENUTZERNAME"]) ? $this->arrData["TPL_LoginBenutzername"]=$_SESSION["LOGIN_BENUTZERNAME"] : $this->arrData["TPL_LoginBenutzername"]='';
		isset($_SERVER['HTTP_USER_AGENT']) ? $this->arrData["TPL_UserAgent"] = $_SERVER['HTTP_USER_AGENT'] : $this->arrData["TPL_UserAgent"]='';
		$this->arrData["TPL_ScriptName"]=basename($_SERVER['PHP_SELF']);

		if (isset($_SESSION["LOGIN_USER_DATA"])) {
			foreach ($_SESSION["LOGIN_USER_DATA"] as $Key=>$Value){
				$this->arrData['TPL_LOGIN_'.strtoupper($Key)] = $Value;
			}
		}
		//$this->arrData['TPL_LOGIN_NAME']=$_SESSION["LOGIN_NACHNAME"].' '.$_SESSION["LOGIN_VORNAME"];
		if (eregi('MSIE',$_SERVER['HTTP_USER_AGENT'])) {
			$this->arrData["TPL_Browser"]="msie";
		}

	}

// ############################################## Replace für Display ##############################################
  	protected function DataReplace($arrData) {
// Nicht gewünschte Zeichen entfernen
		$strData=str_replace('{$',"",$arrData[0]);
    	$strData=str_replace("}","",$strData);
// Rückgabe des Replace-Wertes aus dem Eingabe-Array
    	if (isset($this->arrData[$strData])) {
			$strReturn=$this->arrData[$strData];
			return $strReturn;
    	}else{
    		if ($this->Config["ShowAssignErrors"]===True) {
	    		return "<span style='color:#ff0000;font-weight:bold;'>".$arrData[0]."</span>";
    		}else{
				$strReturn="";
				return $strReturn;
			}
		}
  }

// ############################################ Template aus Datenbank laden ############################################
	function LoadTemplateFromDB(){
	 /*
    $this->Config["DBTemplateType"]
    $this->Config["DBTemplateDatabase"]
		$this->Config["DBTemplateLogin"]
		$this->Config["DBTemplatePassword"]
		$this->Config["DBTemplateTable"]
		$this->Config["DBTemplateSection"]
		$this->Config["DBTemplateContent"]
  */
  }


// ############################################ Template aus Datei laden ############################################
	function LoadTemplateFromFile($strTemplateFile){
		if (file_exists($strTemplateFile)) {
	// Template in Array laden
			$arrTemplateFile=file($strTemplateFile);
	// Start und Ende der Template-Blöcke ermitteln
			$arrBegin=preg_grep("/^!#-----(\s)*[a-zA-Z0-9_]*:Begin(\s)*-----#!/i",$arrTemplateFile);
			$arrEnd=preg_grep("/^!#-----(\s)*[a-zA-Z0-9_]*:End(\s)*-----#!/i",$arrTemplateFile);
 	// Namen der Template-Blöcke ermitteln
			$arrBegin=preg_replace("/^!#-----(\s)*|:Begin(\s)*-----#!/","" ,$arrBegin );
			$arrEnd=preg_replace("/^!#-----(\s)*|:End(\s)*-----#!/","" ,$arrEnd );
	// Alle Template-Blöcke in ein Array schreiben
			$arrData=array_intersect($arrBegin,$arrEnd);
			foreach($arrData as $strBlock){
				$this->arrTemplateBlocks[]=trim($strBlock);
			}
	// Alle Blocknamen durchlaufen
			foreach($arrData as $strBlock){
	// Anfang, Ende und Länge des Blocks bestimmen
				$intBeginLine=array_search($strBlock,$arrBegin);
				$intEndLine=array_search($strBlock,$arrEnd);
				$intLength=(($intEndLine-$intBeginLine)-1);
	// Template-Block in Array ablegen
				$this->arrTemplate[trim($strBlock)]=array_slice($arrTemplateFile,$intBeginLine+1,$intLength);
			}
	// Aufräumen
			unset($arrTemplateFile);
			unset($arrBegin);
			unset($arrEnd);
			unset($arrBegin);
			unset($arrBegin);
			unset($arrData);
			$this->TemplateIsLoaded=true;
			$this->CurrentTemplate=$strTemplateFile;
		}else{
	// Template existiert nicht
			$this->TemplateIsLoaded=false;
		}
	}

// ############################################# Templatedaten zuweisen ############################################
	function Assign($strKey,$strValue,$ToUTF=FALSE){
		if (!empty($strKey)) {
			if (count($this->ActiveInputFilter)>0) {
				foreach($this->ActiveInputFilter AS $key=>$value){
					$strValue=preg_replace($this->Filter[$value][0],$this->Filter[$value][1],$strValue);
				}
			}
			if ($ToUTF===TRUE) {
				$this->arrData[$strKey]=utf8_encode($strValue);
			}else{
				$this->arrData[$strKey]=$strValue;
			}

		}
	}

// ######################################## Templatedaten aus Array zuweisen #######################################
	function AssignArray($arrData,$ToUTF=FALSE){
		if (is_array($arrData)) {
			foreach( $arrData as $strKey=>$strValue) {
				if (!empty($strKey)) {
					if (count($this->ActiveInputFilter)>0) {
						foreach($this->ActiveInputFilter AS $key=>$value){
							$strValue=preg_replace($this->Filter[$value][0],$this->Filter[$value][1],$strValue);
						}
					}
					if ($ToUTF===TRUE) {
						$this->arrData[$strKey]=utf8_encode($strValue);
					}else{
						$this->arrData[$strKey]=$strValue;
					}
				}
			}
		}
	}


// ############################################# Templatedaten löschen #############################################
	function Unassign($strKey){
		if (!empty($strKey)) {
			if (array_key_exists($strKey,$this->arrData)) {
				unset($this->arrData[$strKey]);
			}
		}
	}

// ################################################## Filter setzen #################################################
	function SetFilter($strKey,$strSearch,$strReplace){
		$strKey=trim($strKey);
		if (!empty($strKey) AND !empty($strSearch) AND !empty($strReplace)) {
			$this->Filter[$strKey]=array($strSearch,$strReplace);
			return true;
		}else{
			return false;
		}
	}

// ################################################## Filter löschen ################################################
	function UnsetFilter($strKey){
		$strKey=trim($strKey);
		if (!empty($strKey)) {
			unset($this->Filter[$strKey]);
			$key=array_search($strKey,$this->ActiveInputFilter );
			if ($key!==False) {
				Echo "Lösche InputFilter";
				unset($this->ActiveInputFilter);
			}
			$key=array_search($strKey,$this->ActiveOutputFilter );
			if ($key!==False) {
				unset($this->ActiveOutputFilter);
			}
		}
	}


// ############################################## Eingabefilter setzen ##############################################
	function EnableInputFilter($strKey){
		$strKey=trim($strKey);
		if (!empty($strKey) AND !in_array($strKey,$this->ActiveInputFilter) AND array_key_exists($strKey,$this->Filter)) {
			$this->ActiveInputFilter[]=$strKey;
			return true;
		}else{
			return false;
		}
	}

// ############################################ Eingabefilter deaktivieren ###########################################
	function DisableInputFilter($strValue){
		$strValue=trim($strValue);
		if ($strValue=="All") {
			unset($this->ActiveInputFilter);
			return true;
		}
		if (!empty($strValue)) {
			$strKey=array_search($strValue,$this->ActiveInputFilter );
			if ($strKey!==False) {
				unset($this->ActiveInputFilter[$strKey]);
				return true;
			}else{
				return false;
			}
			return false;
		}
	}

// ############################################## Ausgabefilter setzen ##############################################
	function EnableOutputFilter($strKey){
		$strKey=trim($strKey);
		if (!empty($strKey) AND !in_array($strKey,$this->ActiveOutputFilter) AND array_key_exists($strKey,$this->Filter)) {
			$this->ActiveOutputFilter[]=$strKey;
			return true;
		}else{
			return false;
		}
	}

// ############################################ Ausgabefilter deaktivieren ###########################################
	function DisableOutputFilter($strValue){
		$strValue=trim($strValue);
		if ($strValue=="All") {
			unset($this->ActiveOutputFilter);
			return true;
		}
		if (!empty($strValue)) {
			$strKey=array_search($strValue,$this->ActiveOutputFilter );
			if ($strKey!==False) {
				unset($this->ActiveOutputFilter[$strKey]);
				return true;
			}else{
				return false;
			}
			return false;
		}
	}


// ############################################ Ausgabefilter zurückgeben ###########################################
	function showOutputFilter(){
		return $this->ActiveOutputFilter;
	}
	function showInputFilter(){
		return $this->ActiveInputFilter;
	}
	function showFilter(){
		return $this->Filter;
	}

// ########################################### Alle Templatedaten löschen ###########################################
	function ClearAssign(){
		if (is_array($this->arrData)) {
			unset($this->arrData);
		}
	}


// ############################################ Templatedaten zurückgeben ###########################################
	function showAssign() {
		if (isset($this->arrData) AND is_array($this->arrData)) {
			return $this->arrData;
		}
	}


// ########################################### Templateblöcke zurückgeben ##########################################
	function showBlocks() {
		if ($this->TemplateIsLoaded===True) {
			return $this->arrTemplateBlocks;
		}
	}

// ############################################ Template wurde geladen? ############################################
	function isLoaded() {
		return $this->TemplateIsLoaded;
	}


// ############################################## Konfiguration setzen ###############################################
	function SetConfig($strKey="NULL",$strValue="NULL"){
		$this->Config[$strKey]=$strValue;
	}

// ############################################# Konfiguration ausgeben ##############################################
	function showConfig(){
		echo "<pre>"; print_r($this->Config);echo "</pre>";
	}

// ############################################## Ausgabepuffer starten ##############################################
	function StartGZIPOutput(){
		substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ? ob_start("ob_gzhandler") : ob_start();

	}

// ############################################## Ausgabepuffer stoppen ##############################################
	function StopGZIPOutput(){
		ob_flush();
	}

	function Pre($arrData){
		echo "<hr><pre>";print_r($arrData);echo "</pre><hr>";
	}


	// ******************************** HTML-Sicher machen  ********************************
	function MakeHTMLSafe($arrData,$arrException=array()) {
		if (is_array($arrData)) {
			foreach ($arrData as $key=>$value) {
				if (!in_array($key, $arrException)) {
					if (get_magic_quotes_gpc()) {
						$value=stripcslashes($value);
					}
					if (!is_array($value)) {
						$arrResult[$key]=htmlspecialchars($value,ENT_QUOTES,CHARSET,FALSE);
					}else{
						$arrResult[$key]=$this->MakeHTMLSafe($value,$arrException);
					}

				}else{
					if (get_magic_quotes_gpc()) {
						$value=stripcslashes($value);
					}
					$arrResult[$key]=$value;
				}
			}
		}else{
			if (get_magic_quotes_gpc()==1) {
				$arrResult=stripcslashes($arrResult);
			}
			$arrResult=htmlspecialchars($arrResult,ENT_QUOTES,CHARSET,FALSE);

		}
		return $arrResult;
	}


	function is_valid_email_address($email){


		####################################################################################
		#
		# NO-WS-CTL       =       %d1-8 /         ; US-ASCII control characters
		#                         %d11 /          ;  that do not include the
		#                         %d12 /          ;  carriage return, line feed,
		#                         %d14-31 /       ;  and white space characters
		#                         %d127
		# ALPHA          =  %x41-5A / %x61-7A   ; A-Z / a-z
		# DIGIT          =  %x30-39

		$no_ws_ctl	= "[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x7f]";
		$alpha		= "[\\x41-\\x5a\\x61-\\x7a]";
		$digit		= "[\\x30-\\x39]";
		$cr		= "\\x0d";
		$lf		= "\\x0a";
		$crlf		= "($cr$lf)";


		####################################################################################
		#
		# obs-char        =       %d0-9 / %d11 /          ; %d0-127 except CR and
		#                         %d12 / %d14-127         ;  LF
		# obs-text        =       *LF *CR *(obs-char *LF *CR)
		# text            =       %d1-9 /         ; Characters excluding CR and LF
		#                         %d11 /
		#                         %d12 /
		#                         %d14-127 /
		#                         obs-text
		# obs-qp          =       "\" (%d0-127)
		# quoted-pair     =       ("\" text) / obs-qp

		$obs_char	= "[\\x00-\\x09\\x0b\\x0c\\x0e-\\x7f]";
		$obs_text	= "($lf*$cr*($obs_char$lf*$cr*)*)";
		$text		= "([\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f]|$obs_text)";
		$obs_qp		= "(\\x5c[\\x00-\\x7f])";
		$quoted_pair	= "(\\x5c$text|$obs_qp)";


		####################################################################################
		#
		# obs-FWS         =       1*WSP *(CRLF 1*WSP)
		# FWS             =       ([*WSP CRLF] 1*WSP) /   ; Folding white space
		#                         obs-FWS
		# ctext           =       NO-WS-CTL /     ; Non white space controls
		#                         %d33-39 /       ; The rest of the US-ASCII
		#                         %d42-91 /       ;  characters not including "(",
		#                         %d93-126        ;  ")", or "\"
		# ccontent        =       ctext / quoted-pair / comment
		# comment         =       "(" *([FWS] ccontent) [FWS] ")"
		# CFWS            =       *([FWS] comment) (([FWS] comment) / FWS)

		#
		# note: we translate ccontent only partially to avoid an infinite loop
		# instead, we'll recursively strip comments before processing the input
		#

		$wsp		= "[\\x20\\x09]";
		$obs_fws	= "($wsp+($crlf$wsp+)*)";
		$fws		= "((($wsp*$crlf)?$wsp+)|$obs_fws)";
		$ctext		= "($no_ws_ctl|[\\x21-\\x27\\x2A-\\x5b\\x5d-\\x7e])";
		$ccontent	= "($ctext|$quoted_pair)";
		$comment	= "(\\x28($fws?$ccontent)*$fws?\\x29)";
		$cfws		= "(($fws?$comment)*($fws?$comment|$fws))";
		$cfws		= "$fws*";


		####################################################################################
		#
		# atext           =       ALPHA / DIGIT / ; Any character except controls,
		#                         "!" / "#" /     ;  SP, and specials.
		#                         "$" / "%" /     ;  Used for atoms
		#                         "&" / "'" /
		#                         "*" / "+" /
		#                         "-" / "/" /
		#                         "=" / "?" /
		#                         "^" / "_" /
		#                         "`" / "{" /
		#                         "|" / "}" /
		#                         "~"
		# atom            =       [CFWS] 1*atext [CFWS]

		$atext		= "($alpha|$digit|[\\x21\\x23-\\x27\\x2a\\x2b\\x2d\\x2f\\x3d\\x3f\\x5e\\x5f\\x60\\x7b-\\x7e])";
		$atom		= "($cfws?$atext+$cfws?)";


		####################################################################################
		#
		# qtext           =       NO-WS-CTL /     ; Non white space controls
		#                         %d33 /          ; The rest of the US-ASCII
		#                         %d35-91 /       ;  characters not including "\"
		#                         %d93-126        ;  or the quote character
		# qcontent        =       qtext / quoted-pair
		# quoted-string   =       [CFWS]
		#                         DQUOTE *([FWS] qcontent) [FWS] DQUOTE
		#                         [CFWS]
		# word            =       atom / quoted-string

		$qtext		= "($no_ws_ctl|[\\x21\\x23-\\x5b\\x5d-\\x7e])";
		$qcontent	= "($qtext|$quoted_pair)";
		$quoted_string	= "($cfws?\\x22($fws?$qcontent)*$fws?\\x22$cfws?)";
		$word		= "($atom|$quoted_string)";


		####################################################################################
		#
		# obs-local-part  =       word *("." word)
		# obs-domain      =       atom *("." atom)

		$obs_local_part	= "($word(\\x2e$word)*)";
		$obs_domain	= "($atom(\\x2e$atom)*)";


		####################################################################################
		#
		# dot-atom-text   =       1*atext *("." 1*atext)
		# dot-atom        =       [CFWS] dot-atom-text [CFWS]

		$dot_atom_text	= "($atext+(\\x2e$atext+)*)";
		$dot_atom	= "($cfws?$dot_atom_text$cfws?)";


		####################################################################################
		#
		# domain-literal  =       [CFWS] "[" *([FWS] dcontent) [FWS] "]" [CFWS]
		# dcontent        =       dtext / quoted-pair
		# dtext           =       NO-WS-CTL /     ; Non white space controls
		#
		#                         %d33-90 /       ; The rest of the US-ASCII
		#                         %d94-126        ;  characters not including "[",
		#                                         ;  "]", or "\"

		$dtext		= "($no_ws_ctl|[\\x21-\\x5a\\x5e-\\x7e])";
		$dcontent	= "($dtext|$quoted_pair)";
		$domain_literal	= "($cfws?\\x5b($fws?$dcontent)*$fws?\\x5d$cfws?)";


		####################################################################################
		#
		# local-part      =       dot-atom / quoted-string / obs-local-part
		# domain          =       dot-atom / domain-literal / obs-domain
		# addr-spec       =       local-part "@" domain

		$local_part	= "($dot_atom|$quoted_string|$obs_local_part)";
		$domain		= "($dot_atom|$domain_literal|$obs_domain)";
		$addr_spec	= "($local_part\\x40$domain)";


		#
		# we need to strip comments first (repeat until we can't find any more)
		#

		$done = 0;

		while(!$done){
			$new = preg_replace("!$comment!", '', $email);
			if (strlen($new) == strlen($email)){
				$done = 1;
			}
			$email = $new;
		}


		#
		# now match what's left
		#

		return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
	}

}




?>