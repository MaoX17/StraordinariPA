<?php
/* #### FUNZIONE PER UTF 8 #### */

/*. string .*/ function utf8_bmp_filter(/*. string .*/ $s)
/*.
    DOC Filter and sanify UTF-8 BMP string

    Only valid UTF-8 bytes encoding the Unicode Basic Multilingual Plane
    subset (codes from 0x0000 up to 0xFFFF) are passed. Any other code or
    sequence is dropped. See RFC 3629 par. 4 for details.
.*/
{
	$s=pg_escape_string($s);
    $T = "[\x80-\xBF]";

    return preg_replace("/("

        # Unicode range 0x0000-0x007F (ASCII charset):
        ."[\\x00-\x7F]"
        
        # Unicode range 0x0080-0x07FF:
        ."|[\xC2-\xDF]$T"

        # Unicode range 0x0800-0xD7FF, 0xE000-0xFFFF:
        ."|\xE0[\xA0-\xBF]$T|[\xE1-\xEC]$T$T|\xED[\x80-\x9F]$T|[\xEE-\xEF]$T$T"

        # Invalid/unsupported multi-byte sequence:
        .")|(.)/",
        
        "\$1", $s);
}


function mysqlToDate ($date) {
	$appoData = split("-", $date);
	return $appoData[2]."/".$appoData[1]."/".$appoData[0];	
} 

function dateToMysql ($date) {
	$appoData = split("/", $date);
	return $appoData[2]."-".$appoData[1]."-".$appoData[0];	
} 

function true_si($date){
	if ($date=='1'){
	return "si";
	}else{
	return "no";
	}
}

function true_risposta($date){
	if ($date==''){
	return "risposta <br /> non inserita";
	}else{
	return "risposta inserita";
	}
}

?>
