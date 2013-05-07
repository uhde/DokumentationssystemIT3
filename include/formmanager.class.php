<?

Class FormManagement {
    private $FieldType;
    private $FieldDefault;

    // ************************************* Config setzen **************************************
    function SetConfig($Key,$Value) {
        $Key=strtolower($Key);
        $Value=strtolower($Value);
        $this->Config[$Key]=$Value;
    }

    function UnSetConfig($Key) {
        $Key=strtolower($Key);
        if ($Key=='all') {
            unset($this->Config);
        }
        unset($this->Config[$Key]);
    }

    function ShowConfig(){
        echo '<pre>';print_r($this->Config); echo '</pre>';
    }

    // ************************************* Formulardaten setzen **************************************
    function SetData($arrData){
        // Dateneingabe ist ein Array?
        if (isset($arrData) AND count($arrData)>0){
            // Array HTML-sicher machen
            $arrData=$this->HTMLSafe($arrData);
            // Sind Sonderfelder zu beachten (Radiobox,Checkbox,Selectlist)?
            if (isset($this->FieldType) AND is_array($this->FieldType)) {
                // Diese Felder durchlaufen
                foreach($this->FieldType as $strField=>$strType){
                    // Falls Sonderfelder in Eingabearray existiert dieses Feld bearbeiten
                    if (array_key_exists($strField,$arrData)) {
                        switch ($strType) {
                            // Typ: Radiobox
                            case "radiobutton":
                                $arrData[$strField."_".$arrData[$strField]."_checked"]="checked";
                                break;
                                // Typ: Checkbox
                            case "checkbox":
                                // Feld ist ein String
                                if (!is_array($arrData[$strField])) {
                                    strtolower($arrData[$strField])=="on" ?  $arrData[$strField."_checked"]="checked" : $arrData[$strField."_checked"]="";
                                }else{
                                    // Feld ist ein Array
                                    foreach($arrData[$strField] as $strKey=>$strValue){
                                        if (strtolower($strValue)=="on") {
                                            $arrData[$strField."_".$strKey."_checked"]="checked";
                                            $arrData[$strField."_string"].=$arrData["Test"].$strKey.",";
                                        }else{
                                            $arrData[$strField."_".$strKey."_checked"]="";
                                        }
                                    }
                                    // String mit ausgewählten Feldwerten erzeugen (z.B. für DB-Eintrag)
                                    $arrData[$strField."_string"]=substr($arrData[$strField."_string"],0,-1);
                                }
                                break;
                                // Typ: Checkbox
                            case "selectbox":
                                // Feld ist ein String
                                if (!is_array($arrData[$strField])) {
                                    $arrData[$strField."_".$arrData[$strField]."_selected"]="selected";
                                }else{
                                    // Feld ist ein Array
                                    foreach($arrData[$strField] as $strKey=>$strValue){
                                        $arrData[$strField."_".$strValue."_selected"]="selected";
                                        $arrData[$strField."_string"].=$arrData["Test"].$strValue.",";
                                    }
                                    // String mit ausgewählten Feldwerten erzeugen (z.B. für DB-Eintrag)
                                    $arrData[$strField."_string"]=substr($arrData[$strField."_string"],0,-1);
                                }
                                break;
                        }
                    }
                }
            }
        }
        // Eingabe ist kein Array
        // Es sind Standardwerte für Felder vorhanden
        if (isset($this->FieldDefault) AND is_array($this->FieldDefault)) {
            // Standardwerte durchlaufen
            foreach($this->FieldDefault as $strField=>$strValue){
                // Setzen wenn Standardwert nicht in Eingabearray vorhanden
                if (!array_key_exists($strField,$arrData)) {
                    $arrData[$strField]=$strValue;
                }
            }
        }
        // Array zurückgeben
        return $arrData;
    }

    // **************************************** Standardwerte setzen ****************************************
    function SetFieldDefault($strField,$strValue){
        // Leerzeichen aus Feldname entfernen
        $strField=trim($strField);
        // Nur wenn Feldname nicht leer ist
        if (!empty($strField)) {
            // Existiert ein Sonderfeld für den Feldnamen?
            if (isset($this->FieldType) AND array_key_exists($strField,$this->FieldType)) {
                // Dann dieses entsprechend behandeln
                switch($this->FieldType[$strField]){
                    case "radiobutton":
                        $this->FieldDefault[$strField."_".$strValue."_checked"]="checked";
                        break;
                    case "checkbox":
                        if (trim($strValue)!="") {
                            $this->FieldDefault[$strField."_".$strValue."_checked"]="checked";
                        }else{
                            $this->FieldDefault[$strField."_checked"]="checked";
                        }
                        break;
                }
            }else{
                // ansonsten Feld auf Standardwert setzen
                $this->FieldDefault[$strField]=$strValue;
            }
        }
    }

    // **************************************** Sonderfelder setzen ****************************************
    function SetFieldType($strField,$strType) {
        // Leerzeichen aus Feldname entfernen
        $strField=trim($strField);
        // Feldtyp in Kleinbuchstaben umwandeln
        $strType=strtolower($strType);
        // Liste der verfügbaren Sonderfelder
        $arrAllowedType=array("checkbox","radiobutton","selectbox");
        // Wenn Feldname nicht leer und Feldtyp  vorhanden dann Sonderfeld setzen
        if (!empty($strField) AND in_array($strType,$arrAllowedType )) {
            $this->FieldType[$strField]=$strType;
        }
    }

    // ************************************* Array HTML-sicher machen **************************************
    function HTMLSafe($arrData) {
        // Eingabe ein Array?
        if (is_array($arrData)) {
            // Dann dieses durchlaufen
            foreach ($arrData as $key=>$value) {
                // Falls Wert kein Array
                if (!is_array($value)) {
                    // Dann den String zu HTML konvertieren
                    if (get_magic_quotes_gpc()==1) {
                        $arrResult[$key]=htmlspecialchars(stripslashes($value),ENT_QUOTES,CHARSET,FALSE);
                    }else{
                        $arrResult[$key]=htmlspecialchars($value,ENT_QUOTES,CHARSET,FALSE);
                    }

                }else{
                    // Falls Wert ein Array dann dieses wieder durchlaufen
                    $arrResult[$key]=$this->HTMLSafe($value);
                }
            }
        }else{
            // Falls Eingabe kein Array den String zu HTML konvertieren
            if (get_magic_quotes_gpc()==1) {
                $arrResult=htmlspecialchars(stripslashes($arrData),ENT_QUOTES,CHARSET,FALSE);
            }else{
                $arrResult=htmlspecialchars($arrData,ENT_QUOTES,CHARSET,FALSE);
            }
        }
        // Ergebnis zurückgeben
        return $arrResult;
    }








    // ****************************** Array aus MySQL-Query erzeugen *****************************
    function SetMySQL($arrData,$arrFields) {
        // arrData  = Array der Daten
        // arrField = Array der zu bearbeitenden Felder
        // arrType  = Array der Feldtypen (radio,check,select)
        // Mehrere Datensätze bearbeiten
        if (is_array($arrData[0])) {
            // Alle Datensätze durchlaufen
            for ($i=0;$i<count($arrData);$i++) {
                // Datensätze bearbeiten
                foreach($arrData[$i] as $strKey => $strVal) {
                    // Spezialfelder angegeben
                    if (is_array($arrFields)) {
                        // Feld gefunden
                        if (isset($arrFields[$strKey])) {
                            // String -> Array
                            $strVal=explode(",",$strVal);
                            // Alle Werte durchlaufen
                            foreach ($strVal as $strVal2) {
                                switch ($arrFields[$strKey]) {
                                    // Typ: Radiobutton
                                    case "radio":
                                        $arrResult[$i][$strKey."_".$strVal2."_checked"]="checked";
                                        $arrResult[$i][$strKey]=$strVal2;
                                        break;
                                        // Typ: Checkbox
                                    case "check":
                                        $arrResult[$i][$strKey."_".$strVal2."_checked"]="checked";
                                        if (!empty($strVal2)) $arrResult[$i][$strKey."_checked"]="checked";
                                        $arrResult[$i][$strKey."_array"]=$strVal;
                                        $arrResult[$i][$strKey."_string"]=implode(",",$strVal);
                                        $arrResult[$i][$strKey]=implode(",",$strVal);
                                        break;
                                        // Typ: Selectlist
                                    case "select":
                                        $arrResult[$i][$strKey."_".$strVal2."_Selected"]="Selected";
                                        $arrResult[$i][$strKey."_array"]=$strVal;
                                        $arrResult[$i][$strKey."_string"]=implode(",",$strVal);
                                        $arrResult[$i][$strKey]=implode(",",$strVal);
                                        break;
                                        // Typ: Standard
                                    default:
                                        $arrResult[$i][$strKey]=strip_tags($strVal);
                                        break;
                                }
                                $arrResult[$i][$strKey]=$strVal;
                            }
                            // Aktuelles Feld nich in Liste = Nur org. Feld zurückgeben
                        }else{
                            $arrResult[$i][$strKey]=$strVal;
                        }
                        // Keine Spezialfelder dann Ursrpungsarray zurückgeben
                    }else{
                        $arrResult[$i]=$arrData[$i];
                    }
                }
            }
            // Nur ein Datensatz angegeben
        }else{
            if (is_array($arrFields)) {
                // Datensätze bearbeiten
                foreach($arrData as $strKey => $strVal) {
                    // Aktuelles Feld in zu bearbeitende Felder suchen
                    if (isset($arrFields[$strKey])) {
                        // String -> Array
                        $strVal=explode(",",$strVal);
                        // Alle Werte durchlaufen
                        foreach ($strVal as $strVal2) {
                            switch ($arrFields[$strKey]) {
                                // Typ: Radiobutton
                                case "radio":
                                    $arrResult[$strKey."_".$strVal2."_checked"]="checked";
                                    $arrResult[$strKey]=$strVal2;
                                    break;
                                    // Typ: Checkbox
                                case "check":
                                    $arrResult[$strKey."_".$strVal2."_checked"]="checked";
                                    if (!empty($strVal2)) $arrResult[$strKey."_checked"]="checked";
                                    $arrResult[$strKey."_array"]=$strVal;
                                    $arrResult[$strKey."_string"]=implode(",",$strVal);
                                    break;
                                    // Typ: Selectlist
                                case "select":
                                    $arrResult[$strKey."_".$strVal2."_Selected"]="Selected";
                                    $arrResult[$strKey."_string"]=implode(",",$strVal);
                                    $arrResult[$strKey."_array"]=$strVal;
                                    break;
                                    // Typ: Standard
                                default:
                                    $arrResult[$strKey]=$strVal;
                                    break;
                            }
                            $arrResult[$strKey]=$strVal;
                        }
                    }else{
                        $arrResult[$strKey]=$strVal;
                    }
                }
                // Aktuelles Feld nich in Liste = Nur org. Feld zurückgeben
            }else{
                $arrResult=$arrData;
            }
        }
        // Ergebnis zurückgeben
        return $arrResult;
    }

    // ****************************** Array aus POST-Daten erzeugen *****************************
    function SetForm($arrData,$arrFields) {
        // arrData  = Array der Daten
        // arrField = Array der zu bearbeitenden Felder
        // arrType  = Array der Feldtypen (radio,check,select)
        // Leere Felder vorhanden?
        if (empty($arrData)) return "";

        // Datensätze bearbeiten
        if (is_array($arrFields)) {
            foreach($arrData as $strKey => $strVal) {
                // Aktuelles Feld in zu bearbeitende Felder suchen
                if (isset($arrFields[$strKey])) {
                    switch ($arrFields[$strKey]) {
                        // Typ: Radiobutton
                        case "radio":
                            $arrResult[$strKey."_".$strVal."_checked"]="checked";
                            $arrResult[$strKey]=$strVal;
                            break;
                            // Typ: Checkbox
                        case "check":
                            if (!is_array($strVal)) {
                                $arrResult[$strKey."_checked"]="checked";
                                $arrResult[$strKey]=$strVal;
                            }else{
                                foreach ($strVal as $strVal2) {
                                    $arrResult[$strKey."_".$strVal2."_checked"]="checked";
                                    $arrResult[$strKey."_array"][]=$strVal2;
                                    $arrResult[$strKey."_string"].=$strVal2.",";
                                }
                                $arrResult[$strKey."_string"]=substr($arrResult[$strKey."_string"],0,-1);
                            }
                            break;
                            // Typ: Selectlist
                        case "select":
                            if (!is_array($strVal)) {
                                $arrResult[$strKey."_".$strVal."_selected"]="selected";
                                $arrResult[$strKey]=$strVal;
                            }else{
                                foreach ($strVal as $strVal2) {
                                    $arrResult[$strKey."_".$strVal2."_selected"]="selected";
                                    $arrResult[$strKey."_array"][]=$strVal2;
                                    $arrResult[$strKey."_string"].=$strVal2.",";
                                }
                                $arrResult[$strKey."_string"]=substr($arrResult[$strKey."_string"],0,-1);
                            }
                            break;
                            // Typ: Standard
                        default:
                            $arrResult[$strKey]=$strVal;
                            break;
                    }
                    $arrResult[$strKey]=$strVal;
                    // Aktuelles Feld nich in Liste = Nur org. Feld zurückgeben
                }else{
                    $arrResult[$strKey]=$strVal;
                }
            }
        }else{
            $arrResult=$arrData;
        }
        return $arrResult;
    }

    function TextSelect($Array,$Selected,$SelectedField,$TextField,$ValueField="",$LinkStyle="",$TextStyle="",$Divider="&nbsp&nbsp|&nbsp&nbsp") {
        if (!empty($TextStyle)) { $TextStyle="<span $TextStyle>{Value}</span>$Divider"; }
        if (is_array($Array)) {
            $strSelect="";
            for ($i=0;$i<count($Array);$i++) {
                if (empty($Selected)) {
                    $Selected=$Array[$i]["$SelectedField"];
                    $this->ParentID=$Selected;
                }
                if ($Array[$i]["$SelectedField"]!=$Selected) {
                    $strSelect.="<a $LinkStyle href='".$_SERVER['PHP_SELF']."?$SelectedField=".$Array[$i]["$ValueField"]."'>".$Array[$i]["$TextField"]."</a>$Divider";
                }else{
                    $strSelect.=str_replace("{Value}",$Array[$i]["$TextField"],$TextStyle);
                }
            }
        }else{
            $strSelect="";
        }
        return substr($strSelect,0,strlen($strSelect)-strlen($Divider));
    }



    function SelectList($arrItems,$arrSelected,$strValueField,$strText,$strName,$strStyle,$booGroup=False,$strGroupPrefix="",$strGroupPostfix="",$strGroupField="",$Length=1) {
        // Erstellt Selectlisten
        // $arrItems            =    Array für Inhalt
        // $arrSelected        =    Array für selektierte Objekte
        // $strValueField        =    Feld für value='', wird auch mit $arrSelected verglichen
        // $strTextField        =    Feld für Inhaltstext
        // $strName                =    Name der Selectbox
        // $strStyle            =    Weitere Attribute des Selectbox


        if (!is_array($arrSelected)) {
            $arrSelected=array($arrSelected);
        }

        unset($this->SelectListSelected);
        $strSelect="<select name='".$strName."' ".$strStyle.">\n";
        foreach ($arrItems as $Key=>$Value){
            if (is_array($strText)) {
                $strTextField='';
                foreach ($strText as $TextValue){
                    if (array_key_exists($TextValue,$Value)) {
                        $strTextField.=$Value[$TextValue];
                    }else{
                        $strTextField.=$TextValue;
                    }
                }
            }else{
                $strTextField=$Value[$strText];
            }

            if (!isset($FirstKey)) { $FirstKey=$Key; }
        //for ($i=0 ; $i<count($arrItems);$i++) {
            //if (!empty($arrItems[$i][$strValueField])) {
            if (!is_array($arrSelected)) {
                $arrSelected=array($arrSelected);
            }
            for ($j=0 ; $j<count($arrSelected);$j++) {
                $strSelected="";
                if ($arrSelected[$j]==$Value[$strValueField]) {
                    $strSelected="selected";
                    $this->SelectListSelected=$Value[$strValueField];
                    break;
                }
            }

            if ($booGroup===True) {
                if (empty($strGroupField)) {
                    if ($Length>0) {
                        $Item=htmlspecialchars(strtoupper(substr($strTextField,0,$Length)),ENT_QUOTES,CHARSET,FALSE);
                    }else{
                        $Item=htmlspecialchars($strTextField,ENT_QUOTES,CHARSET,FALSE);
                    }
                }else{
                    if ($Length>0) {
                        $Item=htmlspecialchars(strtoupper(substr($Value[$strGroupField],0,$Length)),ENT_QUOTES,CHARSET,FALSE);
                    } else {
                        $Item=htmlspecialchars($Value[$strGroupField],ENT_QUOTES,CHARSET,FALSE);
                    }
                }

                if ($Item<>$oldItem) {
                    if ($i>0) {
                        $strSelect.="</optgroup><optgroup class='opt' label='".$strGroupPrefix.$Item.$strGroupPostfix."'>\n";
                    }else{
                        $strSelect.="<optgroup class='opt' label='".$strGroupPrefix.$Item.$strGroupPostfix."'>\n";
                    }
                    $oldItem=$Item;
                }
            }

            $strSelect.="<option value='".$Value[$strValueField]."' $strSelected>".$strTextField."</option>\n";
            //}
        }
        $strSelect.="</select>\n";
        if ($booGroup===True) {
            $strSelect.="</optgroup>\n";
        }
        if (empty($arrSelected[0]) OR !isset($arrSelected[0])) {
            $this->SelectListSelected=$arrItems[$FirstKey][$strValueField];
        }
        return $strSelect;
    }


    function NewSelectList($arrItems,$arrSelected,$strValueField,$strText,$strName,$strStyle,$booGroup=False,$strGroupPrefix="",$strGroupPostfix="",$strGroupField="",$Length=1) {
        // Erstellt Selectlisten
        // $arrItems            =    Array für Inhalt
        // $arrSelected        =    Array für selektierte Objekte
        // $strValueField        =    Feld für value='', wird auch mit $arrSelected verglichen
        // $strTextField        =    Feld für Inhaltstext
        // $strName                =    Name der Selectbox
        // $strStyle            =    Weitere Attribute des Selectbox
        //echo "<pre>";print_r($arrSelected);echo "</pre>";
        unset($this->SelectListSelected);
        $strSelect='<div class="SelectBox" '.$strStyle.'>'."\n";
        $booLineClass=0;
        $Optgroup=0;

        foreach ($arrItems as $Value){
            if (is_array($strText)) {
                $strTextField='';
                foreach ($strText as $TextValue){
                    if (array_key_exists($TextValue,$Value)) {
                        $strTextField.=$Value[$TextValue];
                    }else{
                        $strTextField.=$TextValue;
                    }
                }
            }else{
                $strTextField=$Value[$strText];
            }
            if ($booGroup===True) {
                if (empty($strGroupField)) {
                    if ($Length>0) {
                        $Item=htmlspecialchars(strtoupper(substr($strTextField,0,$Length)),ENT_QUOTES,CHARSET,FALSE);
                    }else{
                        $Item=htmlspecialchars($strTextField,ENT_QUOTES,CHARSET,FALSE);
                    }
                }else{
                    $Item=htmlspecialchars($Value[$strGroupField],ENT_QUOTES,CHARSET,FALSE);
                }

                if ($Item<>$oldItem) {
                    $booLineClass=0;
                    if ($Optgroup>0) {
                        $strSelect.='<p class="OptgroupSpacer"></p>'."\n";
                    }
                    $strSelect.='<p class="Optgroup">'.$strGroupPrefix.$Item.$strGroupPostfix."</p>\n";
                    $Optgroup++;
                    $oldItem=$Item;
                }
            }
            $booLineClass=~$booLineClass;
            $LineClass=abs($booLineClass);

            if (is_array($arrSelected) AND array_key_exists($Value[$strValueField], $arrSelected)) {
                $Checked='checked';
                $LineClass='Aktiv';
            }else{
                $Checked='';
            }
            //$strSelect.='<div class="OptionContainer'.abs($LineClass).'">';

            if ($this->Config['disabled']) { $disabled='disabled'; }else{ $disabled='';}
            if ($this->Config['readonly']) { $readonly='readonly'; }else{ $readonly=''; }

            $strSelect.='<div class="Option" onmouseover="this.className=\'OptionHover\'" onmouseout="this.className=\'Option\'">';
            $strSelect.='<label class="Option'.$LineClass.'"';
            $strSelect.=' onClick="document.getElementById(\'chk'.$strName.'_'.$Value[$strValueField].'\').checked === false ? document.getElementById(\''.$strName.'_'.$Value[$strValueField].'\').className=\'Option'.abs($booLineClass).'\' : document.getElementById(\''.$strName.'_'.$Value[$strValueField].'\').className=\'OptionAktiv\';"';
            $strSelect.=' id="'.$strName.'_'.$Value[$strValueField].'">';
            $strSelect.='<input '.$readonly.' '.$disabled.' class="option" type="checkbox" name="'.$strName.'['.$Value[$strValueField].']"  id="chk'.$strName.'_'.$Value[$strValueField].'" '.$Checked.'>';
            $strSelect.='&nbsp;&nbsp;'.$strTextField."\n";
            $strSelect.='</label>';
            $strSelect.='</div>';
/*
            $strSelect.='<p class="OptionInput"><input class="option" type="checkbox" name="'.$strName.'['.$Value[$strValueField].']"  id="'.$strName.'_'.$Value[$strValueField].'" '.$Checked.'></p>';
            $strSelect.='<p class="Option" onmouseover="this.className=\'OptionAktiv\'"  onmouseout="this.className=\'Option\'"';
            $strSelect.=' onMouseUp="document.getElementById(\''.$strName.'_'.$Value[$strValueField].'\').checked === false ? document.getElementById(\''.$strName.'_'.$Value[$strValueField].'\').checked=true : document.getElementById(\''.$strName.'_'.$Value[$strValueField].'\').checked=false;">';
*/
            //$strSelect.='</div>';
        }
        $strSelect.='</div>';
        return $strSelect;
    }
    function ReturnNewSelected($arrData) {
        if (is_array($arrData)) {
            foreach ($arrData as $Key=>$Value){
                if (strtolower($Value)=="on") {
                    $arrReturn[]=$Key;
                }
            }
        }
        return $arrReturn;
    }

    function MySQLToNewSelect($arrData) {
        if (is_array($arrData)) {
            foreach ($arrData as $Key=>$Value){
                $arrReturn[$Value]="on";
            }
        }
        return $arrReturn;
    }


    function ReturnSelected() {
        return $this->SelectListSelected;
    }

    function Selected() {
        return $this->ParentID;
    }


}