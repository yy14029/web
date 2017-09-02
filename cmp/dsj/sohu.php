<?php
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<list>\n";
function g_contents($url) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        @ $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}
$fname ='http://'.$_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"];
if(isset ($_GET['id'])){
       global $fname;
       $ur='http://hot.vrs.sohu.com/vrs_videolist.action?playlist_id='.$_GET['id'].'';
       $url=g_contents($ur);
       preg_match_all('|"videoImage":"(.*?)","relativeVideoId":|',$url, $img);
       preg_match_all('|"videoId":(.*?),"isNeedCaption":|',$url, $arr);
       preg_match_all('|"videoName":"(.*?)","videoSubName":|',$url, $name);
       $ids=$arr[1];
       $title=$name[1];
       $pic=$img[1];
       foreach ($ids as $k => $v){
       $xml.='<m type="sohu" src="'.$v.'" label="'.$title[$k].'" />'."\n";
}}
$xml .= '</list>';
echo $xml;
?>