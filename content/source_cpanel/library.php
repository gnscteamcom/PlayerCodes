<?php 

    function amazon_drive($link)
    {
        $curl = new cURL();

        preg_match('/share\/(.*)/', $link, $matchID);
    
        $getSource = $curl->get('https://www.amazon.com/drive/v1/shares/'.$matchID[1].'?resourceVersion=V2&ContentType=JSON&asset=ALL');

        $deJson = json_decode($getSource);

        $getTemp = $curl->get('https://www.amazon.com/drive/v1/nodes/'.$deJson->nodeInfo->id.'/children?resourceVersion=V2&ContentType=JSON&limit=200&sort=%5B%22kind+DESC%22%2C+%22modifiedDate+DESC%22%5D&asset=ALL&tempLink=true&shareId='.$matchID[1]);
        
        $deJsonTemp = json_decode($getTemp);
        
        $tempLink = (isset($deJsonTemp->data[0]->tempLink)) ? $deJsonTemp->data[0]->tempLink : 'undefined';
        
        $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$tempLink.'"}]';

        return $sources;
    }

    function archive($link)
    {
        $curl = new cURL();

        $getSource = $curl->get($link);

        preg_match('/"sources":\[(.*?)\],/', $getSource, $match);

        $deJson = json_decode('[' . $match[1] . ']');

        foreach ($deJson as $key => $value) {

            switch ($value->height) {
                case '1080':
                        $s[1080] = '{"file": "'.$curl->getOri('https://archive.org' . $value->file).'", "type": "video\/mp4", "label": "1080p"}';
                    break;

                case '720':
                        $s[720] = '{"file": "'.$curl->getOri('https://archive.org' . $value->file).'", "type": "video\/mp4", "label": "720p"}';
                    break;
                
                case '480':
                        $s[480] = '{"file": "'.$curl->getOri('https://archive.org' . $value->file).'", "type": "video\/mp4", "label": "480p"}';
                    break;

                case '360':
                        $s[360] = '{"file": "'.$curl->getOri('https://archive.org' . $value->file).'", "type": "video\/mp4", "label": "360p"}';
                    break;
            }

        }

        krsort($s);
        
        $enJson = implode(',', $s);
        
        $sources = '['.$enJson.']';

        return $sources;
    }

    function blogger($link)
    {

        $curl = new cURL();

        $checkLink = preg_match('/(www.?|)blogger.com\/.*/', $link, $match);

        if ($checkLink) {

            $getSource = $curl->get($link);

            preg_match('/VIDEO_CONFIG\s*\=\s*\{(.*?)\]\}/', $getSource, $match);
            
            $deJson = json_decode('{' . $match[1] . ']}');
            
            foreach ($deJson->streams as $key => $value) {

                switch ($value->format_id) {
                    case '37':
                            $s[1080] = '{"file": "'.$value->play_url.'", "type": "video\/mp4", "label": "1080p"}';
                        break;

                    case '22':
                            $s[720] = '{"file": "'.$value->play_url.'", "type": "video\/mp4", "label": "720p"}';
                        break;
                    
                    case '18':
                            $s[360] = '{"file": "'.$value->play_url.'", "type": "video\/mp4", "label": "360p"}';
                        break;
                }

            }

            krsort($s);
            
            $enJson = implode(',', $s);
            
            $sources = '['.$enJson.']';
        
            $checkSource = preg_match('/\[\]/', $sources, $match);
            
            if($checkSource) {
                $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';
            }
        }
        else{

            $getVideoLink = $curl->get($link);

            $dom = new DOMDocument();

            @$dom->loadHTML($getVideoLink);

            $xpath = new DOMXPath($dom);

            $nlist = $xpath->query("//iframe");

            $fileurl = $nlist[0]->getAttribute("src");

            $getSource = $curl->get($fileurl);

            preg_match('/VIDEO_CONFIG\s*\=\s*\{(.*?)\]\}/', $getSource, $match);
            
            $deJson = json_decode('{' . $match[1] . ']}');
            
            foreach ($deJson->streams as $key => $value) {

                switch ($value->format_id) {
                    case '37':
                            $s[1080] = '{"file": "'.$value->play_url.'", "type": "video\/mp4", "label": "1080p"}';
                        break;

                    case '22':
                            $s[720] = '{"file": "'.$value->play_url.'", "type": "video\/mp4", "label": "720p"}';
                        break;
                    
                    case '18':
                            $s[360] = '{"file": "'.$value->play_url.'", "type": "video\/mp4", "label": "360p"}';
                        break;
                }

            }

            krsort($s);
            
            $enJson = implode(',', $s);
            
            $sources = '['.$enJson.']';
        
            $checkSource = preg_match('/\[\]/', $sources, $match);
            
            if($checkSource) {
                $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';
            }

        }

        return $sources;
    }

    function facebook($link)
    {
        $curl = new cURL();

        preg_match('/\/videos\/([0-9]*)(\/|)/', $link, $matchID);

        $sourceURL = $curl->get('https://www.facebook.com/video/embed?video_id=' . $matchID[1]);

        //Get hd video
        preg_match('/"hd_src":"(.*?)"/', $sourceURL, $match_hd);

        //Get hd video
        preg_match('/"sd_src":"(.*?)"/', $sourceURL, $match_sd);

        if (isset($match_hd[1])) 
        {
            $sources = '[{"default":"true","label":"HD","type":"video\/mp4","file":"'.$match_hd[1].'"}, {"label":"SD","type":"video\/mp4","file":"'.$match_sd[1].'"}]';
        }
        elseif (isset($match_sd[1])) 
        {
            $sources = '[{"label":"SD","type":"video\/mp4","file":"'.$match_sd[1].'"}]';
        }
        else $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';

        return $sources;
    }

    function google_drive($link)
    {
        global $proxyDomain;

        $curl = new cURL();
        
        preg_match('/https?:\/\/(?:www\.)?(?:drive|docs)\.google\.com\/(?:file\/d\/|open\?id=)?([a-z0-9A-Z_-]+)(?:\/.+)?/is', $link, $id);

        $getSource = $curl->get( $proxyDomain . '/link/?driveId=' . $id[1]);

        $sources = $getSource;

        return $sources;
    }

    function google_photos($link)
    {
        $curl = new cURL();

        $getSource = $curl->get($link);

        $checkLink = preg_match('/photos.google.com\/share\/.*\/photo\/.*/', $link, $match);

        if ($checkLink) {

            $deSource = rawurldecode($getSource);

            preg_match_all('/https:\/\/(.*?)=m(22|18|37)/', $deSource, $matchSource);

            foreach ($matchSource[2] as $key => $value) {

                switch ($value) {
                    case '37':
                            $s[1080] = '{"file": "https://' . $matchSource[1][0] . '=m37", "type": "video\/mp4", "label": "1080p"}';
                        break;

                    case '22':
                            $s[720] = '{"file": "https://' . $matchSource[1][0] . '=m22", "type": "video\/mp4", "label": "720p"}';
                        break;
                    
                    case '18':
                            $s[360] = '{"file": "https://' . $matchSource[1][0] . '=m18", "type": "video\/mp4", "label": "360p"}';
                        break;
                }

            }
    
            krsort($s);
            
            $enJson = implode(',', $s);
            
            $sources = '['.$enJson.']';

            $checkSource = preg_match('/\[\]/', $sources, $match);
            
            if($checkSource) {
                $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';
            }
        }
        else{
            preg_match('/<meta property="og:image" content="(.*?)\=.*">/', $getSource, $matchLink);

            $f1080p = trim($matchLink[1] . '=m37');
            $f720p = trim($matchLink[1] . '=m22');
            $f360p = trim($matchLink[1] . '=m18');

            if ($curl->checkCode($f1080p) != 404) {
                $sources = '[{"label":"1080p","type":"video\/mp4","file":"'.$f1080p.'"}, {"label":"720p","type":"video\/mp4","file":"'.$f720p.'"}, {"label":"360p","type":"video\/mp4","file":"'.$f360p.'"}]';
            }
            else if ($curl->checkCode($f720p) != 404) {
                $sources = '[{"label":"720p","type":"video\/mp4","file":"'.$f720p.'"}, {"label":"360p","type":"video\/mp4","file":"'.$f360p.'"}]';
            }
            else if ($curl->checkCode($f360p) != 404) {
                $sources = '[{"label":"360p","type":"video\/mp4","file":"'.$f360p.'"}]';
            }
            else $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';
        }
        
        $sources = str_replace('lh3.googleusercontent.com', '3.bp.blogspot.com', $sources);

        return $sources;

    }

    function mp4upload($link)
    {
        
        $unpacker = new JavascriptUnpacker;
        
        $curl = new cURL();

        preg_match('/mp4upload.com\/(.*)/', $link, $matchID);

        $getSource = $curl->get('https://www.mp4upload.com/embed-'.$matchID[1].'.html'); 

        preg_match('/eval(.*?)\s*<\/script>/', $getSource, $matchSource);
                    
        $uPack = $unpacker->unpack($matchSource[0]);
        
        preg_match('/src:"(.*?)"/', $uPack, $directLink);
        
        $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$directLink[1].'"}]';

        return $sources;
    }

    function mediafire($link)
    {

        $sourceURL = file_get_contents($link, false, stream_context_create(['socket' => ['bindto' => '0:0']]));

        preg_match('/href\=\"https\:\/\/download(.*?).mediafire\.com\/(.*?)\"\>/', $sourceURL, $matchLink);

        $linkMF = (isset($matchLink[1])) ? 'https://download' . $matchLink[1] . '.mediafire.com/' . $matchLink[2] : '';
        
        if (isset($matchLink[1])) 
        {
            $sources = '[{"label":"HD","type":"video\/mp4","file":"'.stripslashes($linkMF).'"}]';
        }
        else $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';

        return $sources;
    }

    function onedrive($link)
    {

        $curl = new cURL();

        $linkOneDrive = str_replace('1drv.ms', '1drv.ws', $link);
        
        $sourceURL = $curl->get($linkOneDrive . '?txt');
        
        $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$sourceURL.'"}]';

        return $sources;
    }

    function rumble($link)
    {

        $curl = new cURL();

        $getID = $curl->get($link);

        preg_match('/"video":"(.*?)"/', $getID, $matchID);
        
        $getSource = $curl->get('https://rumble.com/embedJS/u3/?request=video&v='.$matchID[1].'&ext=%7B%22ad_count%22%3Anull%7D');

        preg_match_all('/"([0-9]*)":\["(.*?).mp4/', $getSource, $matchLink);

        foreach ($matchLink[1] as $key => $value) {
            switch ($value) {
                case '360':
                        $s[360] = '{"file": "'.$matchLink[2][$key].'.mp4", "type": "video\/mp4", "label": "360p"}';
                    break;

                case '480':
                        $s[480] = '{"file": "'.$matchLink[2][$key].'.mp4", "type": "video\/mp4", "label": "480p"}';
                    break;

                case '720':
                        $s[720] = '{"file": "'.$matchLink[2][$key].'.mp4", "type": "video\/mp4", "label": "720p"}';
                    break;

                case '1080':
                        $s[1080] = '{"file": "'.$matchLink[2][$key].'.mp4", "type": "video\/mp4", "label": "1080p"}';
                    break;

                case '1440':
                        $s[1440] = '{"file": "'.$matchLink[2][$key].'.mp4", "type": "video\/mp4", "label": "1440p"}';
                    break;

                case '2160':
                        $s[2160] = '{"file": "'.$matchLink[2][$key].'.mp4", "type": "video\/mp4", "label": "2160p"}';
                    break;
            }
        }

        krsort($s);

        $enJson = implode(',', $s);

        $sources = '['.$enJson.']';
    
        $checkSource = preg_match('/\[\]/', $sources, $match);
        
        if($checkSource) {
            $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';
        }

        return $sources;
    }

    function soundcloud($link)
    {

        global $client_id;

        $curl = new cURL();

        $getSource = $curl->get($link);
    
        preg_match('/"soundcloud:tracks:(.*?)"/', $getSource, $matchID);

        $jsonSource = $curl->get('https://api.soundcloud.com/i1/tracks/'.$matchID[1].'/streams?client_id=' . $client_id);

        $deJson = json_decode($jsonSource, true);

        if ( isset($deJson['http_mp3_128_url']) ) {

            $streamLink = $deJson['http_mp3_128_url'];
        }
        else $streamLink = 'undefined';

        $sources = '[{"label":"HD","type":"audio\/mp3","file":"'.$streamLink.'"}]';

        return $sources;
    }

    function streamable($link)
    {

        $curl = new cURL();

        $getSource = $curl->get($link);

        preg_match('/property="og:video:url"\s*content="(.*?)"/', $getSource, $matchLink);

        $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$matchLink[1].'"}]';

        return $sources;
    }

    function tiktok($link)
    {

        $curl = new cURL();

        $data = $curl->get($link);

        $start = preg_quote('<script id="__NEXT_DATA__" type="application/json" crossorigin="anonymous">', '/');
        
        $end = preg_quote('</script>', '/');

        preg_match("/$start(.*?)$end/", $data, $matches);

        if(!$matches){
            $sources = '[{"label":"HD","type":"video\/mp4","file":"undefined"}]';
            exit;
        }

        $data = json_decode($matches[1], true);

        $streamlink = $data['props']['pageProps']['videoData']['itemInfos']['video']['urls'];
        
        $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$streamlink[0].'"}]';

        return $sources;
    }

    function vimeo($link)
    {
        $curl = new cURL();
        
        preg_match('/vimeo.com\/([0-9]*)/', $link, $matchID);

        $ranServer = rand(1,15);

        $getSource = $curl->post('https://us'.$ranServer.'.proxysite.com/includes/process.php?action=update', 'server-option=us'.$ranServer.'&d='.urlencode('https://player.vimeo.com/video/'.$matchID[1].'/config').'');
        
        $deJson = json_decode($getSource);

        foreach ($deJson->request->files->progressive as $key => $value) {
            switch ($value->quality) {
                case '1080p':
                        $s[1080] = '{"file": "'.$value->url.'", "type": "video\/mp4", "label": "1080p"}';
                    break;

                case '720p':
                        $s[720] = '{"file": "'.$value->url.'", "type": "video\/mp4", "label": "720p"}';
                    break;
                
                case '540p':
                        $s[540] = '{"file": "'.$value->url.'", "type": "video\/mp4", "label": "540p"}';
                    break;

                case '360p':
                        $s[360] = '{"file": "'.$value->url.'", "type": "video\/mp4", "label": "360p"}';
                    break;

                case '270p':
                        $s[270] = '{"file": "'.$value->url.'", "type": "video\/mp4", "label": "270p"}';
                    break;
            }

        }

        krsort($s);
        
        $enJson = implode(',', $s);
        
        $sources = '['.$enJson.']';

        $checkSource = preg_match('/\[\]/', $sources, $match);
        
        if($checkSource) {
            $sources = '[{"label":"undefined","type":"video\/mp4","file":"undefined"}]';
        }

        return $sources;
    }

    function yandex($link)
    {

        $curl = new cURL();

        $getSource = file_get_contents('https://cloud-api.yandex.net/v1/disk/public/resources/download?public_key=' . $link);

        $deJson = json_decode($getSource);
        
        $oriLink = $curl->getOri($deJson->href);
        
        $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$oriLink.'"}]';

        return $sources;
    }

    function youtube($link)
    {

        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $link, $matchID);

        require('vendor/autoload.php');

        $youtube = new \YouTube\YouTubeDownloader();

        $getSource = $youtube->getDownloadLinks($link);

        $s = [];

        foreach ($getSource as $key => $value) {

              switch ($value['itag']) 
              {
                    case '37':
                        $s[] = [
                            'type'  => 'video/mp4',
                            'label' => '1080p',
                            'file'  => preg_replace(["/[^\/]+\.googlevideo\.com/"], ["redirector.googlevideo.com"], $value['url']),
                        ];
                      break;

                    case '22':
                        $s[] = [
                            'type'  => 'video/mp4',
                            'label' => '720p',
                            'file'  => preg_replace(["/[^\/]+\.googlevideo\.com/"], ["redirector.googlevideo.com"], $value['url']),
                        ];
                      break;

                     case '18':
                        $s[] = [
                            'type'  => 'video/mp4',
                            'label' => '360p',
                            'file'  => preg_replace(["/[^\/]+\.googlevideo\.com/"], ["redirector.googlevideo.com"], $value['url']),
                        ];
                      break;
              }
        }

        $sources = json_encode($s);

        return $sources;
    }

    function zippyshare($link)
    {

        $domainServer = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);

        $sources = '[{"file":"'.$domainServer.'/download.php?url='.$link.'","type":"video\/mp4"}]';

        return $sources;
    }

    function pcloud($link)
    {

        $curl = new cURL();

        $getSource = $curl->get($link);

        preg_match('/"downloadlink":\s*"(.*?)"/', $getSource, $match);

        $sources = '[{"label":"HD","type":"video\/mp4","file":"'.$match[1].'"}]';
                
        return $sources;
    }

    function decode($pData)
    {
        $encryption_key = 'apicodesdotcom';

		$decryption_iv = '9999999999999999';

        $ciphering = "AES-256-CTR"; 
        
        $pData = str_replace(' ','+', $pData);

        $decryption = openssl_decrypt($pData, $ciphering, $encryption_key, 0, $decryption_iv);

        return $decryption;
    }

    function encode($pData)
    {
        $encryption_key = 'apicodesdotcom';

        $encryption_iv = '9999999999999999';

        $ciphering = "AES-256-CTR"; 
          
        $encryption = openssl_encrypt($pData, $ciphering, $encryption_key, 0, $encryption_iv);

        return $encryption;  

    }

?>