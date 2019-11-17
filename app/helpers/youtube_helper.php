<?php
if(!function_exists("download_youtube_video")){
    function download_youtube_video($video_id, $fist_video = true, $video_qualitys = array("hd720", "medium", "small"), $video_types = array("mp4")){

        $video_id = validateYoutubeVideoId($video_id);
        if(!$video_id){
            return array();
        }

        $video_info_url = 'https://www.youtube.com/get_video_info?&video_id=' . $video_id . '&asv=3&el=detailpage&hl=en_US';
        $video_info = file_get_contents($video_info_url);

        //GET TITLE AND THUMBNAIL
        $title = "Unknown";
        $thumbnail = "Unknown";
        parse_str( urldecode($video_info) , $info );
        if(isset($info['player_response'])){
            $info = json_decode($info['player_response']);
            $title = $info->videoDetails->title;
            $thumbnail = $info->videoDetails->thumbnail->thumbnails[0]->url;
        }


        $video_info = explode("url_encoded_fmt_stream_map", $video_info);
        $full_data = array();
        if(count($video_info) == 2){
            $video_info = explode("&", $video_info[1]);
            $video_info = ltrim($video_info[0], '=');
            $video_info = explode(",", urldecode($video_info));

            if(!empty($video_info)) {

                foreach ($video_info as $info) {
                    parse_str( $info , $raw_data );
                    parse_str( $raw_data['url'] , $url_info );

                    //CREATE SIGNATURE
                    $signature = '';

                    //GET QUANLITY
                    $data['quality'] = $raw_data['quality'];

                    //GET TYPE
                    $type = explode(';', $raw_data['type']);
                    $data['type'] = $type[0];
                    $video_type = str_replace("video/", "", $type[0]);
                    
                    if(isset($raw_data['quality']) && in_array($raw_data['quality'], $video_qualitys) && in_array($video_type, $video_types)){
                        if (isset($raw_data['s'])) {
                            //The video signature need to be deciphered
                            $player_info = getPlayerInfoByVideoId($video_id);
                            $playerURL = $player_info[1];

                            $opcode = loadYoutubeURL($playerURL);
                            $opcode = json_encode(extractDecipherOpcode($opcode));

                            $opcode = json_decode($opcode, true);

                            $sig = executeSignaturePattern(
                                $opcode['decipherPatterns'],
                                $opcode['deciphers'],
                                $raw_data['s']
                            );

                            if (strpos($raw_data['url'], 'ratebypass=') === false) {
                                $raw_data['url'] .= '&ratebypass=yes';
                            }

                            $signature = '&signature=' . $sig;
                        }

                        $data['title'] = $title;
                        $data['thumbnail'] = $thumbnail;
                        $data['url'] = $raw_data['url'] . $signature;
                        $data['expires'] = isset($url_info['expire']) ? date('Y-m-d G:i:s T', $url_info['expire']) : '';
                        $data['ipbits'] = isset($url_info['ipbits']) ? $url_info['ipbits'] : '';
                        $data['ip'] = isset($url_info['ip']) ? $url_info['ip'] : '';
                        $data['youtube_url'] = "https://www.youtube.com/watch?v=".$video_id;

                        $full_data[] = $data;

                    }
                }

                //Result Single Array
                if($fist_video && !empty($full_data)){
                    $full_data = $full_data[0];
                }

                return $full_data;
            }
        }

        return false;
    }
}

if(!function_exists("loadYoutubeURL")){
    function loadYoutubeURL($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}

if(!function_exists("getPlayerInfoByVideoId")){
    function getPlayerInfoByVideoId($videoID)
    {
        $data = loadYoutubeURL('https://www.youtube.com/watch?v=' . $videoID);
        $data = explode('/yts/jsbin/player', $data)[1];
        $data = explode('"', $data)[0];
        $playerURL = 'https://www.youtube.com/yts/jsbin/player' . $data;

        try {
            $playerID = explode('-', explode('/', $data)[0]);
            $playerID = $playerID[count($playerID)-1];
        } catch (\Exception $e) {
            throw new \Exception(sprintf(
                'Failed to retrieve player script for video id: %s',
                $videoID
            ));

            return false;
        }

        return [
            $playerID,
            $playerURL,
        ];
    }
}

if(!function_exists("extractDecipherOpcode")){
    function extractDecipherOpcode($decipherScript)
    {
        $decipherPatterns = explode('.split("")', $decipherScript);
        unset($decipherPatterns[0]);
        foreach ($decipherPatterns as $value) {

            // Make sure it's inside a function and also have join
            $value = explode('.join("")', explode('}', $value)[0]);
            if (count($value) === 2) {
                $value = explode(';', $value[0]);

                // Remove first and last index
                array_pop($value);
                unset($value[0]);

                $decipherPatterns = implode(';', $value);

                break;
            }
        }

        preg_match_all('/(?<=;).*?(?=\[|\.)/', $decipherPatterns, $deciphers);
        if ($deciphers && count($deciphers[0]) >= 2) {
            $deciphers = $deciphers[0][0];
        } else {
            throw new \Exception('Failed to get deciphers function');

            return false;
        }

        $deciphersObjectVar = $deciphers;
        $decipher = explode($deciphers . '={', $decipherScript)[1];
        $decipher = str_replace(["\n", "\r"], '', $decipher);
        $decipher = explode('}};', $decipher)[0];
        $decipher = explode('},', $decipher);

        // Convert deciphers to object
        $deciphers = [];

        foreach ($decipher as &$function) {
            $deciphers[explode(':function', $function)[0]] = explode('){', $function)[1];
        }

        // Convert pattern to array
        $decipherPatterns = str_replace($deciphersObjectVar . '.', '', $decipherPatterns);
        $decipherPatterns = str_replace($deciphersObjectVar . '[', '', $decipherPatterns);
        $decipherPatterns = str_replace(['](a,', '(a,'], '->(', $decipherPatterns);
        $decipherPatterns = explode(';', $decipherPatterns);

        return [
            'decipherPatterns' => $decipherPatterns,
            'deciphers' => $deciphers,
        ];
    }
}

if(!function_exists("executeSignaturePattern")){
    function executeSignaturePattern($patterns, $deciphers, $signature)
    {
        // Execute every $patterns with $deciphers dictionary
        $processSignature = str_split($signature);
        for ($i=0; $i < count($patterns); $i++) {
            // This is the deciphers dictionary, and should be updated if there are different pattern
            // as PHP can't execute javascript

            //Separate commands
            $executes = explode('->', $patterns[$i]);

            // This is parameter b value for 'function(a,b){}'
            $number = intval(str_replace(['(', ')'], '', $executes[1]));
            // Parameter a = $processSignature

            $execute = $deciphers[$executes[0]];

            switch ($execute) {
                case 'a.reverse()':
                    $processSignature = array_reverse($processSignature);
                break;
                case 'var c=a[0];a[0]=a[b%a.length];a[b]=c':
                    $c = $processSignature[0];
                    $processSignature[0] = $processSignature[$number%count($processSignature)];
                    $processSignature[$number] = $c;
                break;
                case 'var c=a[0];a[0]=a[b%a.length];a[b%a.length]=c':
                    $c = $processSignature[0];
                    $processSignature[0] = $processSignature[$number%count($processSignature)];
                    $processSignature[$number%count($processSignature)] = $c;
                break;
                case 'a.splice(0,b)':
                    $processSignature = array_slice($processSignature, $number);
                break;
                default:
                    die("\n==== Decipher dictionary was not found ====");

                break;
            }
        }

        return implode('', $processSignature);
    }
}

if(!function_exists("validateYoutubeVideoId")){
    function validateYoutubeVideoId($video_id)
    {
        if (strlen($video_id) <= 11) {
            return $video_id;
        }

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_id, $match)) {
            if (is_array($match) && count($match) > 1) {
                return $match[1];
            }
        }

        return false;
    }
}