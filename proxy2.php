<?php 
function curl_request($url, $https=true, $method='get', $data=null) {
    $ch = curl_init();                                  //初始化，返回资源号
    curl_setopt($ch,CURLOPT_URL,$url);			//访问的url
    curl_setopt($ch,CURLOPT_HEADER,false);		//不需要头信息
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);	//不输出到页面仅返回字串

    if($https) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不做服务器端认证（如支付时则需要）
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不做客户端认证
    }
    if($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, true);		//设置post方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    //设置post的数据
    }

    $content = curl_exec($ch);
    if($content === false) {
        echo $errmsg = curl_error($ch);
    }
    //执行访问
    curl_close($ch);					//关闭资源
    return $content;
}

if(isset($_GET['url'])) {
	$url = urldecode($_GET['url']);
	echo curl_request($url,true);
} else {
	echo 'error!';
}

