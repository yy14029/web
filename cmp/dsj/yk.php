<?php
 
error_reporting(0);
 
header("content-type:text/xml;charset=utf-8");
 
function b_d($url) {
 
       $ch = curl_init(); 
       curl_setopt($ch, CURLOPT_URL, $url);
 
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
 
       @ $file = curl_exec($ch);
 
       curl_close($ch);
 
       return $file;
 
}
 
$fname = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["SCRIPT_NAME"];
 
if(isset ($_GET['u'])){
 
       $u=$_GET['u'];
 
       for ($i = 1; $i <= $u; $i++) {
 
       $y = ''.$t[0].''.$i.'';
 
       $xml .= '<m list_src="' . $fname . '?p=' . $y . '"  label="电影-第' . $i . '页" />'."\n";
 
}}
 
elseif(isset ($_GET['p'])){
 
       $a=$_GET['p'];
 
       $b = b_d("http://www.youku.com/v_olist/c_96_s_0_d_0_g_0_a_0_r_0_u_0_pt_0_av_0_ag_0_sg_0_mt_0_lg_0_q_0_pr_0_h_0_p_$a.html");
 
       preg_match_all('#<a href="http://www.youku.com/show_page/id_(.*?).html" target="_blank" title="(.*?)"></a>#', $b, $v);
 
       $f = count($v[1]);
 
       for($m=0;$m<$f;$m++){
 
       $xml .='<m list_src="' . $fname . '?t=' . $v[1][$m] . '" label="' . $v[2][$m] . '" />'."\n";
 
}}
 
elseif(isset ($_GET['t'])){
 
       $r =''.$_GET['t'].'';
 
       $t = b_d("http://www.youku.com/show_page/id_$r.html");
 
       preg_match_all('#href="http://v.youku.com/v_show/id_(.*?).html(.*?)" target="_blank" title="(.*?)"#',$t,$a);
 
       $y = count($a[1]);
 
       for($m=0;$m<$y;$m++){
 
       $xml .='<m type="youku"  src="' . $a[1][$m] . '" label="'.$a[3][$m].'" />'."\n";
 
}}
 
else{
 
$tttmv = array (
 
       '电影' => '29',
 
);
 
foreach ($tttmv as $k => $v) {
 
       $xml .= '<m list_src="' . $fname . '?u=' . $v  . '" label="' . $k . '" />'."\n";
 
}}
 
echo "<list>\n".$xml.'</list>';