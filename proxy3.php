<?php 
/**
 * 代理服务选择类
 *
 * @author Liam
 */
class ProxySelect {
    private static $proxy_list = array(
        '27.158.158.59:8998',
        '222.188.74.218:8998',//
        '138.201.63.123:31288',//
        '115.63.186.82:8998',
        '101.70.65.94:8998',//
    );
    
    public static function requestProxyHttp($url) {
        $ran = mt_rand(0, count(self::$proxy_list)-1);
        $proxy = explode(':', self::$proxy_list[$ran]);
        return proxy_curl($url,$proxy[0],$proxy[1],'');
    }
}

function proxy_curl($url,$proxy_ip,$proxy_port,$loginpassw)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
    curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
    curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
	$UserAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.2) Gecko/2008070208 Firefox/3.0.1';
    curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);
    $data = curl_exec($ch);
    if(!$data) {
        $error = curl_error($ch).'@'.$proxy_ip;
        return $error;
    }
    curl_close($ch);
    return $proxy_ip.$data;
}

if(isset($_GET['url'])) {
	set_time_limit(60*2);   //允许超时2分钟
	$url = urldecode($_GET['url']);
	echo ProxySelect::requestProxyHttp($url);
} else {
	echo 'error!';
}

