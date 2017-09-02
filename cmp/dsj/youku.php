<?php
//优酷电视剧代理 作者问天 qq405129506
header("Content-type:text/xml;charset=utf-8");
$fname = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["SCRIPT_NAME"];define("URL","$fname");
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<list>\n";
if(isset ($_GET['page'])){
        $xml.=page($_GET['page']);
}elseif(isset ($_GET['id'])){
       $url='http://www.youku.com/show_page/id_'.$_GET['id'].'.html';
       $str = m_v($url);
           preg_match('/id="zySeriesTab">(.*)<\/ul>/imsU',$str,$arr);
           preg_match_all('/<li data="(.*)"/imsU',$arr[1],$id);
           if($id[1][0] == ""){$id[1][0] = "reload_1";}
    foreach ($id[1] as $reload)
    {
       $urll="http://www.youku.com/show_episode/id_".$_GET['id'].".html?dt=json&divid=" . $reload . "&__rt=1&__ro=" . $reload;
       $url=m_v($urll);
       preg_match_all('|<a href="http://v.youku.com/v_show/id_([^"]+).html|', $url, $b);
           preg_match_all('|title="([^"]+)" charset=|', $url, $c);
       $d = count($b[1]);
       for($m=0;$m<$d;$m++){
       $xml .='<m type="youku" youku_hd="2" src="' . $b[1][$m] . '" label="' . $c[1][$m] . '" />'."\n";
}}}
else{
        $xml.=page(1);
}
$xml .= '</list>';
echo $xml;
function m_v($url) {
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
function page($page){
        $a=m_v('http://www.youku.com/v_olist/c_97_g__a__sg__mt__lg__q__s_1_r__u_0_pt_0_av_0_ag_0_sg__pr__h__d_1_p_'.$page.'.html');
        preg_match_all('#class="p-meta-title"><a href="http://www.youku.com/show_page/id_([A-Za-z0-9]+).html" target="_blank" title="(.*)">#U',$a, $b);
        preg_match_all('#class="p-thumb-taglb"><span class="p-status">(.*)</span></div>#U',$a, $g);
        preg_match_all('#<img src="(.*)" alt="(.*)">#U',$a, $t);
        foreach($b[1] as $index=>$id){
        $xml .='<m label="'.$b[2][$index].'-'.$g[1][$index].'" image="'.$t[1][$index].'" text="'.$t[2][$index].'" list_src="'.URL.'?id='.$id.'" />'."\n";
}
if ($page==1){
                for ($i=2;$i<=34;$i++){
                        $xml .='<m label="第'.$i.'页" list_src="'.URL.'?page='.$i.'" />'."\n";
                }
        }
        return $xml;
}
?>