<?php

if(!function_exists('lang_builder')){
    function lang_builder($dir){
    	$CI = &get_instance();
    	$languages = $CI->model->fetch("*", LANGUAGE, "code = 'en'");
    	$lang_currrent = array();
    	foreach ($languages as $key => $language) {
    		$lang_currrent[$language->slug] = $language->text;
    	}

    	if(!isset($lang)){
    		$lang = array();
    	}

        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;

        $data = array();
        foreach($ffs as $ff){
        	if(stripos($ff, "_lang.php")){
        		include $dir."/".$ff;
        		foreach ($lang as $key => $text) {
                    if($text != ""){
                        $item = $CI->db->query("SELECT * FROM ".LANGUAGE." WHERE BINARY slug='".$key."' AND code = 'en'")->row();
                        if(empty($item)){
                            $CI->db->insert(LANGUAGE, array(
                                "ids"  => ids(),
                                "code" => "en",
                                "slug" => $key,
                                "text" => $text
                            ));
            			}
                    }
        		}
        	}
            
            if( !stripos($dir, "system") && 
                !stripos($dir, "assets") && 
                !stripos($dir, "libraries") && 
                !stripos($dir, "vendor") && 
                !stripos($dir, "third_party") && 
                !stripos($dir, "config") && 
                !stripos($dir, "views") &&
                !stripos($dir, "core") &&
                !stripos($dir, "install") &&
                !stripos($dir, "helpers") &&
                !stripos($dir, "menu") &&
                !stripos($dir, "cache") &&
                !stripos($dir, "logs") &&
                !stripos($dir, "hooks") &&
                !stripos($dir, "models") &&
                !stripos($dir, "controllers") &&
                !stripos($dir, "config") 
            ){
            	if(is_dir($dir.'/'.$ff)) lang_builder($dir.'/'.$ff);
        	}
        }
    }
}

function set_language($code){
    $CI = &get_instance();
    $language = $CI->db->select("*")->where("code", $code)->get(LANGUAGE_LIST)->row();

    if(empty($language) OR $language->code == "en")
    {
        $language = $CI->db->select("*")->where("code", "en")->get(LANGUAGE_LIST)->row();
    }

    set_session("lang_default", json_encode($language));

    return json_decode(session("lang_default"));
}

function get_default_language(){
    if(strpos(current_url(), "/cron") === FALSE){
        $check_default_language = json_decode(session("lang_default"));
        if(!is_object($check_default_language)){
            $CI = &get_instance();
            $language = $CI->db->select("*")->where("is_default", 1)->get(LANGUAGE_LIST)->row();

            if(empty($language) OR $language->code == "en")
            {
                $language = $CI->db->select("*")->where("code", "en")->get(LANGUAGE_LIST)->row();
            }

            set_session("lang_default", json_encode($language));
        }

        return json_decode(session("lang_default"));
    }
}


if(!function_exists('lang')){
    function lang($key = ""){
        $lang_default = get_default_language();
        $CI = &get_instance();
        if(empty($lang_default) || !file_exists(APPPATH."../assets/tmp/lang_".$lang_default->code.".txt")){
            $lang_text = $CI->lang->line($key);
            if($lang_text != ""){
                return $lang_text;
            }else{
                if(ENVIRONMENT == "development"){
                    return "<span style='color:red'>".ucfirst(str_replace("_", " ", $key))."</span>";
                }else{
                    return ucfirst(str_replace("_", " ", $key));
                }
            }
        }

        $data = file_get_contents(APPPATH."../assets/tmp/lang_".$lang_default->code.".txt");
        $data = json_decode($data, 1);
        if(isset($data['language_data'])){
            $data = $data['language_data'];
            if(isset($data[$key])){
                return $data[$key];
            }else{
                $lang_text = $CI->lang->line($key);
                if($lang_text != ""){
                    return $lang_text;
                }else{
                    if(ENVIRONMENT == "development"){
                        return "<b>".ucfirst(str_replace("_", " ", $key))."</b>";
                    }else{
                        return ucfirst(str_replace("_", " ", $key));
                    }
                    
                }
            }
        }else{
            $lang_text = $CI->lang->line($key);
            if($lang_text != ""){
                return $lang_text;
            }else{
                if(ENVIRONMENT == "development"){
                    return "<span style='color:red'>".ucfirst(str_replace("_", " ", $key))."</span>";
                }else{
                    return ucfirst(str_replace("_", " ", $key));
                }
            }
        }
    }
}

if(!function_exists('list_countries')){
    function list_countries($key = ""){
        $countries = array(
            "AF" => "Afghanistan",
            "AX" => "Åland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia, Plurinational State of",
            "BQ" => "Bonaire, Sint Eustatius and Saba",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, the Democratic Republic of the",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Côte d'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CW" => "Curaçao",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and McDonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, the former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Réunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "BL" => "Saint Barthélemy",
            "SH" => "Saint Helena, Ascension and Tristan da Cunha",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin (French part)",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SX" => "Sint Maarten (Dutch part)",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "SS" => "South Sudan",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela, Bolivarian Republic of",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.S.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        );

        if($key != ""){
            if(isset($countries[$key])){
                return $countries[$key];
            }else{
                return lang("unknown");
            }
        }

        return $countries;
    }
}