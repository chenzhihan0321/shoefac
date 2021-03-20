<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/10
 * Time: 16:50
 */

namespace app\common\lib\weChat;


class WeChat
{
    public  function valid(){
        // 验证消息
        if($this->checkSignature()){
            $data = $_GET['echostr'];
            echo $data;
            exit;
        }else{
            $this->reponseMsg();
        }

    }
     // 检验签名
    public  function checkSignature(){
        $data = input("param.");
        $timestamp = $data['timestamp'];
        $nonce = $data['nonce'];
        $token = 'lianaibaodan';
        $signature = $data['signature'];
        if (isset($data['echostr'])) {
            $echostr = $data['echostr'];
        }else{
            $echostr = null;
        }
        $array = array($nonce, $timestamp, $token);
        sort($array);
        $str = implode($array);
        $str = sha1($str);
        if ($str == $signature  && $echostr) {

            return true;
//            echo $echostr;
//            exit;
        } else {
            return false;
            //$this->reponseMsg();
        }
    }
    //处理用户消息
    public function  reponseMsg(){
        //接收原生的xml字符串
        //$postArr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postArr =file_get_contents('php://input');
        if(!$postArr){
            echo "post data error";
            exit;
        }
        //把原生字符串转化成对象
        $postObj = simplexml_load_string($postArr);
        //接收消息的类型
        $MsgType = $postObj->MsgType;
        //处理消息
        $this->checkMsgType($postObj,$MsgType);
        if (strtolower($postObj->MsgType) == 'event') {
            if (strtolower($postObj->Event) == 'subscribe') {
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();
                $msgType = 'text';
                $content = '欢迎关注恋爱盒子！';
                $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
                $scene = $postObj->EventKey;
                /* $file=date("YmdHis-11111").'.php';
               file_put_contents("WechatToken/".$file,$scene);  */
                //检测数据表是否有用户
                $this->beforehand((string)$toUser,(string)$scene);
                $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
            }
            if (strtolower($postObj->Event) == 'click') {
                if ($postObj->EventKey == 'CARAT') {
                    $toUser = $postObj->FromUserName;
                    $fromuser = (string)$toUser;
                    //file_put_contents("11220814.txt",$fromuser);
                    //$text='欢迎';
                    //message($fromuser, $text);
                    //exclusive_user($fromuser);
                    $file=date("YmdHis-11111").'.php';
                    file_put_contents("WechatToken/".$file,"欢迎");
                }
            }

        }
    }
    //处理消息类型
    public function checkMsgType($postObj,$MsgType){
        switch ($MsgType){
            case  'text':
                $this->receiveText($postObj);
                break;
            case  'image':
                $mediaId = $postObj->MediaId;
                $this->replyImage($postObj,$mediaId);
                break;
            case 'event':
                $event = $postObj->Event;
                //处理事件
                    $this->checkEvent($postObj,$event);
            default:
                break;
        }

    }
    //处理关注事件的方法
    public function checkEvent($postObj,$event){
        if ($event == 'subscribe') {
            $toUser = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $time = time();
            $msgType = 'text';
            $content = '欢迎关注恋爱盒子！';
            $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
            $scene = $postObj->EventKey;
            /* $file=date("YmdHis-11111").'.php';
           file_put_contents("WechatToken/".$file,$scene);  */
            //检测数据表是否有用户
            $this->beforehand((string)$toUser,(string)$scene);
            $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
            echo $info;
    }
    }
    //处理文本消息
    public function receiveText($postObj){
         $content = $postObj->Content;
         switch ($content){
             case '点歌':
                 $str = '欢迎来到云知名点歌台';
                 $files = scandir('music');
                 $i = 1;
                 foreach ($files as $key=>$value){
                     if($value != '.' && $value !='..'){
                         $str .= $i.' '.$value."\n";
                         $i++;
                     }
                 }
                 $str .= "请输入对应的编号试听歌曲\n";
                 $this->replyText($postObj,$str);
                 break;
             case  '笑话':
                 $this->replyText($postObj,'笑话');
                 break;
             case  '新闻':
                 $data = [
                     [
                         'Title' => '',
                         'Description'=>'',
                         'PicUrl' => 'https://***',
                         'Url' => 'https://***',
                     ],[
                         'Title' => '',
                         'Description'=>'',
                         'PicUrl' => 'https://***',
                         'Url' => 'https://***',
                     ]
                 ];
                 $this->replyNews($postObj,$data);
                 break;

             default:
                 if(preg_match('/^\d{1,2}$/',$content)){
                     $files = scandir('music');
                     $i = 1;
                     foreach ($files as $key=>$value){
                         if($value != '.' && $value !='..'){
                             if($content = $i){
                                 $data = [
                                     'Title' => $value,
                                     'Description'=>$value,
                                     'MusicUrl' => 'https://***'.$value,
                                     'HQMusicUrl' => 'https://***'.$value,
                                 ];
                                 $this->replyMusic($postObj,$data);
                             }
                         }
                     }
                 }
                 break;
         }

    }
    //处理图片消息
    public function revceiveImage($postObj){
        $mediaId = $postObj->MediaId;
        $this->replyImage($postObj,$mediaId);
    }
    //回复文本消息
    public function replyText($postObj,$content){
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time = time();
        $msgType = 'text';
        $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
        $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
        echo $info;
    }
    //回复音乐
    public function replyMusic($postObj,$data){
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time = time();
         $template = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[music]]></MsgType>
                          <Music>
                            <Title><![CDATA[%s]]></Title>
                            <Description><![CDATA[%s]]></Description>
                            <MusicUrl><![CDATA[%s]]></MusicUrl>
                            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                           </Music>
                        </xml>";
        $info = sprintf($template, $toUser, $fromUser, $time, $data['Title'],$data['Description'],$data['MusicUrl'],$data['HQMusicUrl']);
        echo $info;
    }
    //回复图片消息
    public function  replyImage($postObj,$mediaId){
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time = time();
        $template = "<xml>
                           <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[image]]></MsgType>
                          <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                          </Image>
                        </xml>";
        $info = sprintf($template, $toUser, $fromUser, $time, $mediaId);
        echo $info;
    }
    //回复图文消息
    public function replyNews($postObj,$data){
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time = time();
        $str = '';
        foreach ($data as $key =>$value){
            $str .="<item>
                              <Title><![CDATA[".$value['Title']."]]></Title>
                              <Description><![CDATA[".$value['Description']."]]></Description>
                              <PicUrl><![CDATA[".$value['PicUrl']."]]></PicUrl>
                              <Url><![CDATA[".$value['Url']."]]></Url>
                            </item>";
        }
        $template = "<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime>%s</CreateTime>
                          <MsgType><![CDATA[news]]></MsgType>
                          <ArticleCount>'.count($data).'</ArticleCount>
                          <Articles>
                           '.$str.'
                          </Articles>
                        </xml>";
        $info = sprintf($template, $toUser, $fromUser, $time);
        echo $info;
    }
    public function beforehand($openid,$scene){
        $info = Db::name('user')->where(['openid' => $openid])->find();
        if (empty($info)) {
            $access_token = getWxAcess_Token($this->appid,$this->appsecret);
            $res = get_wechat_user($openid, $access_token);
            $add_data = [
                'openid' => $openid,

                'nickname' => $res['nickname'],
                'head_img' => $res['headimgurl'],
                'unionid' => $res['unionid'],
            ];
            $s = explode('_', $scene);
            if (empty($s[1])){
                $s[1] = 0;
            }
            $add_data['scene'] = $s[1];
            add_user($add_data);
        }else{ // 已经关注过用户不做处理

        }
    }
}