<?php
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<list>\n";
function t_v($url) {
       $user_agent = $_SERVER['HTTP_USER_AGENT'];
       $ch = curl_init(); 
       $timeout = 30;
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
       @ $file = curl_exec($ch);
       curl_close($ch);
       return $file;
}
$fname = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["SCRIPT_NAME"];
if(isset ($_GET['page'])){
       global $fname;
       $a = 'http://list.iqiyi.com/www/2/------------2-1-'.$_GET['page'].'-1-iqiyi--.html';
       $str = t_v($a);
       preg_match_all('|data-qidanadd-albumid="([0-9]+)"|', $str, $b);
           preg_match_all('|title="([^"]+)" src="            http://([^"]+).jpg|', $str, $g);
       $d = count($b[1]);
       for($m=0;$m<$d;$m++){
       $xml .='<m list_src="'.$fname.'?aid='.$b[1][$m].'" label="'.htmlspecialchars($g[1][$m]).'" />' . "\n";
           }}
elseif (isset ($_GET['aid'])){
       $a = 'http://dispatcher.video.qiyi.com/mini/pl/'.$_GET['aid'].'/';
       $str = t_v($a);
       preg_match_all('|"videoId":"([^"]+)"|imsU',$str,$b);
       preg_match_all('|"videoOrder":"([0-9]+)"|', $str, $b1);
           preg_match_all('|"videoPic":"([^"]+)"|', $str, $b2);
       $d = count($b[1]);
       for($m=0;$m<$d;$m++){
       $xml .= '<m type="merge" src="' . $fname . '?v=' . $b[1][$m] . '" label="第' . $b1[1][$m] . '集" />'."\n";   
}}
elseif (isset ($_GET['v'])){
       $vid = $_GET['v'];
       $a = 'http://dispatcher.video.qiyi.com/mini/crumb/'.$vid;;
       $str = t_v($a);
           preg_match('|"tvId":([^<]+),"vid":"([^<]+)","sourcePic|imsU', $str, $a1);
       $app = t_v('http://cache.video.qiyi.com/vp/'.$a1[1].'/'.$vid.'/');
       preg_match('|"playLength":([0-9]+),|', $str, $d_);
       $f4v .= '<m type="" starttype="0" label="http://cmpyy.com" bytes="" duration="'.$d_[1].'" bg_video="" >'."\n";
       preg_match('|"bid":2,(.*?)\]|i', $app, $a_);
       preg_match('|"bid":96,(.*?)\]|i', $app, $ac_);
       if ($a_[1]){$a_[1] = $a_[1];}else{$a_[1] = $ac_[1];}
       preg_match_all('|"l":"(.*?)"|i', $a_[1], $b_);
       for ($i = 0; $i < count($b_[1]); $i++) {
       $f4v .= '<u bytes="" duration="" src="http://wgdcnccdn.inter.qiyi.com/videos'.$b_[1][$i].'?start={start_seconds}" />'."\n";
       }
       $f4v .= '</m>';
       echo $f4v;exit;
}
else{
for($i=1;$i<=30;$i++){
       $xml .='<m list_src="' . $fname . '?page=' . $i . '" label="爱奇艺电视剧第' . $i . '页" />'."\n";
}}
$xml .= '</list>';
echo $xml;
?>