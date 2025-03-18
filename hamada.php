<?php

$API_KEY = 'f9LHodD0cOIYDptabYzZ4xG2jvVTMNqV0-kPQhkO5lyTd8T-WA7EpX4fNxPOubK0HX6e1hq82qHq8Fub3csQuA';

$Dev_id = "574002697562";
$urlimg = "https://i.okcdn.ru/i?r=BDEGV1SoxFQVqRl8uRaxX9H1HFh5P_-XTC_9UC9z6An1iHgxupa5APZHBba1AQ66Z88";
$as = [574002697562];
$update_info = "55330098";

mkdir("information_");


define('API_KEY',$API_KEY);

$Adminset = json_decode(file_get_contents("information_/Ad".$update_info.".json"),true);
$settings = json_decode(file_get_contents("information_/st".$update_info.".json"),true);
$mute = json_decode(file_get_contents("information_/mute".$update_info.".json"),true);


$lock = json_decode(file_get_contents("info/lock.json"),true);


$second = json_decode(file_get_contents("information_/second".$update_info.".json"),true);
$groups = json_decode(file_get_contents("information_/groups".$update_info.".json"),true);
$Special  = json_decode(file_get_contents("information_/Special".$update_info.".json"),true);
$Admin  = json_decode(file_get_contents("information_/Admin".$update_info.".json"),true);
$owner = json_decode(file_get_contents("information_/owner".$update_info.".json"),true);
$replies = json_decode(file_get_contents("information_/replies".$update_info.".json"),true);
$public = json_decode(file_get_contents("information_/public".$update_info.".json"),true);
$true = json_decode(file_get_contents("information_/true".$update_info.".json"),true);
$dev = json_decode(file_get_contents("information_/dev".$update_info.".json"),true);
// start rank //
function is_bot($user){
global $update_info;
if($user == $update_info){
$is_bot = true;
}else{
$is_bot = false;
}
return $is_bot;
}
function is_dev($user){
global $as;
if(in_array($user,$as)){
$is_de = true;
}else{
$is_de = false;
}
return $is_de;
}
function is_deved($user){
global $dev;
if(is_bot($user)){
$is_dfe = true;
}elseif(is_dev($user)){
$is_dfe = true;
}elseif(in_array($user,$dev["dev"])){
$is_dfe = true;
}else{
$is_dfe = false;
}
return $is_dfe;
}
function is_creator($user, $chat){
global $API_KEY;
$infoad = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chat.'/members?access_token='.$API_KEY.'&user_ids='.$user));
$is_owner = $infoad->members[0]->is_owner; 
$is_admin = $infoad->members[0]->is_admin; 
$is_user_id = $infoad->members[0]->user_id;
if(is_bot($user)){
$is_cr = true;
}elseif(is_deved($user)){
$is_cr = true;
}elseif($is_owner == "true" && $is_admin =="true"){
$is_cr = true;
}else{
$is_cr = false;
}
return $is_cr;
}
function is_owner($user, $chat){
global $API_KEY;
global $owner;
$infoad = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chat.'/members?access_token='.$API_KEY.'&user_ids='.$user));
$is_owner = $infoad->members[0]->is_owner; 
$is_admin = $infoad->members[0]->is_admin; 
$is_user_id = $infoad->members[0]->user_id;
if(is_bot($user)){
$is_ow = true;
}elseif(is_creator($user, $chat)){
$is_ow = true;
}elseif(!$is_owner == "true" && $is_admin =="true"){
$is_ow = true;
}elseif(in_array($user,$owner[$chat])){
$is_ow = true;
}else{
$is_ow = false;
}
return $is_ow;
}
function is_admin($user, $chat){
global $Admin;
if(is_bot($user)){
$is_ad = true;
}elseif(is_creator($user, $chat)){
$is_ad = true;
}elseif(is_owner($user, $chat)){
$is_ad = true;
}elseif(in_array($user,$Admin[$chat])){
$is_ad = true;
}else{
$is_ad = false;
}
return $is_ad;
}
function is_Special($user, $chat){
global $Special;
if(is_dev($user)){
$is_sp = true;
}elseif(is_bot($user)){
$is_sp = true;
}elseif(is_deved($user)){
$is_sp = true;
}elseif(is_creator($user, $chat)){
$is_sp = true;
}elseif(is_owner($user, $chat)){
$is_sp = true;
}elseif(is_admin($user, $chat)){
$is_sp = true;
}elseif(in_array($user,$Special[$chat])){
$is_sp = true;
}else{
$is_sp = false;
}
return $is_sp;
}
function rank($user, $chat){
if(is_dev($user)){
$is_rank = "المطور الاساسي";
}elseif(is_bot($user)){
$is_rank = "البوت";
}elseif(is_deved($user)){
$is_rank = "المطور";
}elseif(is_creator($user,$chat)){
$is_rank = "منشئ اساسي";
}elseif(is_owner($user,$chat)){
$is_rank = "منشئ";
}elseif(is_admin($user,$chat)){
$is_rank = "ادمن";
}elseif(is_Special($user,$chat)){
$is_rank = "مميز";
}else{
$is_rank = "عضو";
}
return $is_rank;
}



// end rank //
function edit_value($message_id, $buttons, $text){
    $data = [
        'message_id' => $message_id,
        'text' => $text,
        'attachments' => [
            [
                'type' => 'inline_keyboard',
                'payload' => [
                    'buttons' => $buttons
                ]
            ]
        ],
        'format' => 'markdown'
    ];
    $url = "https://botapi.tamtam.chat/messages?access_token=" . $GLOBALS['API_KEY'] . "&message_id=" . $message_id;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($data))
    ));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if ($result === false) {
        $result = json_encode(['ok' => false, 'curl_error_code' => curl_errno($curl), 'curl_error' => curl_error($curl)]);
    }
    curl_close($curl);
    return json_decode($result, true);
}


function bot22($method,$data){
if($method){
$url = "https://botapi.tamtam.chat/messages?access_token=".API_KEY."&chat_id=".$method."&disable_link_preview=true";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
 echo $res;
}
}

function bobt($method,$data){
if($method){
$url = "https://botapi.tamtam.chat/messages?access_token=".API_KEY."&user_id=".$method."&disable_link_preview=true";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
 echo $res;
}
}
function bot($method,$data){
if($method){
$url = "https://botapi.tamtam.chat/messages?access_token=".API_KEY."&chat_id=".$method."&disable_link_preview=true";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
 echo $res;
}
}
function bot1($method,$data){
if($method){
$url = "https://botapi.tamtam.chat/answers/constructor?access_token=".API_KEY."&session_id=".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
 echo $res;
}}
function answers($callback,$data){
if($callback){
$url = "https://botapi.tamtam.chat/answers?access_token=".API_KEY."&callback_id=".$callback;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch);
 return json_decode($res);
}
}
function unpin($chat){
$url = "https://botapi.tamtam.chat/chats/".$chat."/pin?access_token=".API_KEY;
$content = ['chat_id'=>$chat];
$curl = curl_init();
$content = json_encode($content);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($content))
);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);
return json_decode($result, true);
}
function pin($chat, $msgid){
$url = "https://botapi.tamtam.chat/chats/".$chat."/pin?access_token=".API_KEY;
$data = ["message_id"=>$msgid,"notify"=>"true"];
$curl = curl_init();
$data = json_encode($data);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($data))
);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);
return json_decode($result, true);
}


function kickChatMember($user_id, $chat){
$url = "https://botapi.tamtam.chat/chats/".$chat."/members?access_token=".API_KEY."&user_id=".$user_id."&block=true";
$content = ['chat_id'=>$chat];
$curl = curl_init();
$content = json_encode($content);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($content))
);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);
return json_decode($result, true);
}

function deleteMessage($method){
    $url = "https://botapi.tamtam.chat/messages?access_token=".API_KEY."&message_id=".$method;
          $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        //curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($ch);
            echo $res;
}
function edit_bot_info($content){
$url = "https://botapi.tamtam.chat/me?access_token=".API_KEY;
$curl = curl_init();
$content = json_encode($content);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
if ($content) {
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
}
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($content))
);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
if ($result === false) {
$result = json_encode(['ok' => false, 'curl_error_code' => curl_errno($curl), 'curl_error' => curl_error($curl)]);
}
curl_close($curl);
return json_decode($result, true);
}

function CheckMk($vc,$from_id,$text=null,$message_id=null){
$stas = json_decode(file_get_contents("Adminset.json"),true);
if (count($stas["Channels"]) != 0){
foreach ($stas["Channels"] as $channel){
$Request = json_decode(file_get_contents("https://botapi.tamtam.chat/chats/".$channel['id']."/members?access_token=#&user_ids=".$from_id));
if(!$Request->members[0]->user_id){
if($text){
$text = $text;
}else{
$text = "/start";
}
$ff = [
[['type' => 'link', 'text' =>"Sources", 'url' => 'https://tt.me/culI']],
];
bot($vc,['text' =>"‎•⊱ **عذراً، يجب عليك الاشتراك في القناة أولاً: [Channel STARK - RX](https://tt.me/culI)** .",
"link"=>["type"=>"reply",
"mid"=>$message_id,],
'attachments' =>[['type' => 'inline_keyboard','payload'=>['buttons'=>$ff,]]],"format"=>"markdown"]);
return true;
}
return false;
break;
}
}
}
function CheckChannels($vc,$from_id,$text=null,$message_id=null){
global $update_info;
$stas = json_decode(file_get_contents("information_/Ad".$update_info.".json"),true);
if (count($stas["Channels"]) != 0){
foreach ($stas["Channels"] as $channel){
$Request = json_decode(file_get_contents("https://botapi.tamtam.chat/chats/".$channel['id']."/members?access_token=".API_KEY."&user_ids=".$from_id));
if(!$Request->members[0]->user_id){
if($text){
$text = $text;
}else{
$text = "/start";
}
$ff = [
[['type' => 'link', 'text' =>"Sources", 'url' => 'https://tt.me/culI']],
];
bot($vc,['text' => "‎•⊱ **عذراً، يجب عليك الاشتراك في القناة أولاً: [Channel STARK - RX](https://tt.me/culI)** .",
"link"=>["type"=>"reply",
"mid"=>$message_id,],
'attachments' =>[['type' => 'inline_keyboard','payload'=>['buttons'=>$ff,]]],"format"=>"markdown"]);
return true;
}
return false;
break;
}
}
}
function ViewChannels($ch,$message_id){
global $update_info;
$sAAS = json_decode(file_get_contents("information_/Ad".$update_info.".json"),true);
if (count($sAAS["Channels"]) != 0){
$rf = "قنوات الاشتراك الإجبارية\nانقر فوق اسم القناة لحذفه 🗑";
for ($i=0; $i < count($sAAS["Channels"]); $i++) {
$Botsid = $sAAS["Channels"][$i]["id"];
$Botsurl = $sAAS["Channels"][$i]["url"];
$Botstitle = $sAAS["Channels"][$i]["title"];
$ff[$i]= [['type' => 'callback', 'text' =>$Botstitle, 'payload' =>'delch#'.$i],['type' => 'link', 'text' =>'الرابط', 'url' =>$Botsurl]];
}
$ff[]= [['type' => 'callback', 'text' => '➕', 'payload' => 'csaddChannel']];
$ff[]= [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle']];
}else{
$rf = "لا توجد قنوات للاشتراك الإجباري\nلإضافة قناة ، اضغط على (➕)";
$ff = [
[['type' => 'callback', 'text' => '➕', 'payload' => 'csaddChannel'],],
[['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle'],],
];
}
edit_value($message_id, $ff,$rf);
}
$update = json_decode(file_get_contents('php://input'));
$update_type = $update ->update_type;
$message = $update->message;
$video= $message->body->attachments[0]->type['video'];
$photo= $message->body->attachments[0]->type['image'];
$sticker= $message->body->attachments[0]->type['sticker'];
$audio= $message->body->attachments[0]->type['audio'];
$contact= $message->body->attachments[0]->type['contact'];
$inline= $message->body->attachments[0]->type['inline_keyboard'];
$location= $message->body->attachments[0]->type['location'];
$document = $message->body->attachments[0]->type['file'];
$typddse =$message->body->attachments[0]->type;
$text = $message->body->text;
$data = $update->callback->payload;
$message_id = $update->message->body->mid;
$chat_type = $message->recipient->chat_type;
$payload = $update->payload;
$reply = $message->link->type['reply'];
$is_bot = $message->sender->is_bot;
$re_name = $message->link->sender->name;
$re_user_id = $message->link->sender->user_id;
$re_username = $message->link->sender->username;
if(!$re_username){
	$re_username = "لا يوجد";
}else{
    $re_username = "@".$re_username;
}
$re_message_id = $update->message->link->message->mid;
$attachments = $update->messagemessage->body->attachments[0]->type;
$link_type = $message->link->type;
if($update_type ==  'bot_started'){
$user_id = $update->user_id;
$chatId = $update->chat_id;
$name = $update->user->name;
$username = $update->user->username;
}elseif($update_type ==  'message_callback'){
$user_id = $update->callback->user->user_id;
$chatId = $update->message->recipient->chat_id;
$name = $update->callback->user->name;
$username = $update->callback->user->username;
}elseif($update_type ==  'message_created'){
$user_id = $update->message->sender->user_id;
$chatId = $update->message->recipient->chat_id;
$name = $update->message->sender->name;
$username = $update->message->sender->username;
}elseif($update_type ==  'message_edited'){
$user_id = $update->message->sender->user_id;
$chatId = $update->message->recipient->chat_id;
$name = $update->message->sender->name;
$username = $update->message->sender->username;
}elseif($update_type ==  'user_added'){
$user_id = $update->user->user_id;
$chatId = $update->chat_id;
$name = $update->user->name;
$username = $update->user->username;
}elseif($update_type ==  'user_removed'){
$user_id = $update->user->user_id;
$chatId = $update->chat_id;
$name = $update->user->name;
$username = $update->user->username;
}
if(!$username){
	$username = "لا يوجد";
}else{
    $username = "@".$username;
}
$isb_info = json_decode(file_get_contents('https://botapi.tamtam.chat/me?access_token='.API_KEY));
$idBot = $isb_info->user_id; 
$nameBot = $isb_info->name; 
$userBot = $isb_info->username;
if($update_type == "bot_started"){
if(isset($user_id)){
$mem = file_get_contents("information_/id".$update_info.".txt");
$memp = explode("\n",$mem);
if(!in_array($user_id,$memp)){
$endmem = fopen("information_/id".$update_info.".txt", "a") or die("Unable to open file!");
fwrite($endmem, "$user_id\n");
fclose($endmem);
}
}
if(in_array($user_id,$as)){
unset($settings[$user_id]);
file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
$ff = [
[['type' => 'callback', 'text' =>'تعيين اسم البوت بالمجموعات', 'payload' =>"Edgbot"]],
[['type' => 'callback', 'text' =>'اذاعه بالخاص', 'payload' =>"cse"],['type' => 'callback', 'text' =>"اذاعه بالمجموعات", 'payload' =>"cse2"]],
[['type' => 'callback', 'text' =>"الاشتراك الاجباري", 'payload' =>"cs"],['type' => 'callback', 'text' =>'الاحصائيات', 'payload' =>"infoM"]],
[['type' => 'callback', 'text' =>'— — — — — — — — —', 'payload' =>"— — — — — — — — —"]],
[['type' => 'callback', 'text' =>'تغير صوره البوت', 'payload' =>"Ediphbot"],['type' => 'callback', 'text' =>"تغير اسم البوت", 'payload' =>"Edinambot"]],
[['type' => 'callback', 'text' =>"تغير يوزر البوت", 'payload' =>"Ediuserbot"],['type' => 'callback', 'text' =>'تغير وصف البوت', 'payload' =>"Edibiobot"]],
];
bobt($user_id,['text' =>"• اهلا بك عزيزي المطور في بوتك الخاص",
'attachments' =>[['type' => 'inline_keyboard','payload'=>['buttons'=>$ff,]]],
]);
}
unset($settings[$user_id]);
file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
if(CheckMk($chatId,$user_id,null,null)){
return false;
}
if(CheckChannels($chatId,$user_id,null,null)){
return false;
}
bobt($user_id,['text'=>"Click here to get started :- /start",
]);
}
if($chat_type == "dialog"){
if(CheckMk($chatId,$user_id,"/start",$message_id)){
return false;
}
if(CheckChannels($chatId,$user_id,"/start",$message_id)){
return false;
}
if($text == "/start"){

$H =  [
[['type'=> 'link', 'text'=> 'developer','url'=>"https://tt.me/RRRX3"],['type'=> 'link', 'text'=> 'Source','url'=>"https://tt.me/culI"]], 
];
bobt($user_id,['text'=>"
**⌔︙ اهلاً انا بوت حماية مجمـوعات .
⌔︙ قـم بأضـافتي الى مجموعتـك .
⌔︙ لنجرب الاشياء المذهلة معاً** .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎","format"=>"markdown",'attachments'=>[[
               'type'=> 'inline_keyboard',
               'payload'=>['buttons'=>$H,

]]],

]);
}
}
if($update_type ==  'bot_added'){
$user_id = $update->user->user_id;
$chatId = $update->chat_id;
$name = $update->user->name;
$username = $update->user->username;
}

if($update_type == "bot_added"){
bot($chatId,[
'text'=>"•⊱ **ياحلوي تم إضافتي إلى گروبك** .
•⊱ **تم رفع المنشئ والمسؤل تلقائيـاً** .
•⊱ **هسه دزل كلمــة ' ^^تفعيل^^' اولاً**  .
•⊱ **بعدين دز كلمـة ' ^^الاوامر^^ ' بعدها** .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
‎•⊱ ‏**Source of Bot The** [**Channel**](https://tt.me/culI) .",'format'=>'markdown',
'attachments'=>[
                [
                    'type'=>'image',
                    'payload'=>[
                        'url'=>$urlimg
                        ]]],
]);
}

if($update_type ==  'user_added' && !$lock[$chatId]["user_added"]){
$we = isset($second[$chatId]["user_added"]) ? $second[$chatId]["user_added"] : ". Welcome to Group .
تخلق بهل حلوين وتذب علينه 🦌🍭. 
$username 
$name";
$we = str_replace(["#username","#name"],[$username,$name],$we);
bot($chatId,['text'=>$we,
]);
}

//chat
$info = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chatId.'/members?access_token='.$API_KEY.'&user_ids='.$Dev_id));
$dev_name = $info->members[0]->name;
$dev_username = $info->members[0]->username;
$chats_info = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chatId.'?access_token='.$API_KEY));
$link = isset($chats_info->link) ? $chats_info->link : "لا يوجد";
$owner_id = $chats_info->owner_id;
$info = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chatId.'/members?access_token='.$API_KEY.'&user_ids='.$owner_id));
$owner_name = $info->members[0]->name;
$owner_username = $info->members[0]->username;
if(!$owner_username){
	$owner_username = "لا يوجد";
}else{
    $owner_username = "@".$owner_username;
}

if($text){
if($true[$chatId][$text]){
$text = $true[$chatId][$text] or $text;
}
}
if($chat_type == "chat"){
if($message) {
$msgs[$chatId][$user_id] = ($msgs[$chatId][$user_id] ? $msgs[$chatId][$user_id] : 0) +1;
file_put_contents("information_/msgs".$update_info.".json",json_encode($msgs,128|32|256));
}

$commands = [
"تويت", "تفعيل", "طرد", "كت","المنشئ", "المطور", "رفع منشئ", "رفع ادمن", "رفع مميز","كتم", "ايدي","كشف", "اضف امر", "اضف رد","ايدي","حضر","حظر","اوامر","الاوامر","اعدادات","الاعدادات", "قفل الصور", "قفل الرابط", "قفل الفايروس","قفل التوجيه","قفل الفيديو","قفل الروابط","قفل الصور","قفل الفيديو","قفل الانلاين","قفل الترحيب","قفل الهاشتاك","قفل الرسائل","قفل الدردشة","قفل الفشار","قفل البوتات","قفل اليوزرات","قفل الملفات","قفل الموقع","فتح الصور", "فتح الرابط", "فتح الفايروس","فتح التوجيه","فتح الفيديو","فتح الروابط","فتح الصور","فتح الفيديو","فتح الانلاين","فتح الترحيب","فتح الهاشتاك","فتح الرسائل","فتح الدردشة","فتح الفشار","فتح البوتات","فتح اليوزرات","فتح الملفات","فتح الموقع","قفل الكل","فتح الكل"
];

if (in_array($text, $commands)) {
    if (CheckChannels($chatId, $user_id, $text, $message_id)) {
        return false;
    }
}

if (in_array($text, $commands)) {
    if (CheckMk($chatId, $user_id, $text, $message_id)) {
        return false;
    }
}




if($text == "تفعيل" && is_owner($user_id, $chatId)){
if(!in_array($chatId, $groups["groups"])){
bot($chatId,['text'=>"
**⌔︙** شكراً يا : ^^$name^^ 
**⌔︙** ݪقد تـم تـفعيلي في گروبك .
**⌔︙** آمـݪ أن اكـون معكم في كل شيء .
","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]]);
$groups["groups"][] = $chatId;
file_put_contents("information_/groups".$update_info.".json",json_encode($groups,128|32|256));
bobt($Dev_id,['text'=>"› تم تفعيل البوت بمجموعه جديده \n\n› معلومات المنشئ :- \n› الاسم : ( $owner_name) \n› المعرف : ( $owner_username )\n› الرابط : $link"
]);
}else{
bot($chatId,['text'=>"**^^⌔︙  تـم تفعيـل الكروب من گبل .^^**","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}
}


$nbot = isset($settings["nbot"]) ? $settings["nbot"] : "سبارك";
if ($text == $nbot || $text == "بوت"){
$aa = array("ههـلاهَ عـمري يـمك 💟🤏🏼.","‹ : عــيون ؟ $nbot","خݪاص يبـوي ابـيِ أرتاحح 🤏🏼😒.","يـَهوه لاتلـح 🤨..❓🥲.","ها يبه شتريد مني");
$mesho = array_rand($aa,1);
bot($chatId,['text'=>$aa[$mesho],"link"=>["type"=>"reply","mid"=>$message_id]]);
}

if ($text == "المجموعه"){
$acccha = json_decode(file_get_contents("https://botapi.tamtam.chat/chats/".$chatId."?access_token=".$API_KEY),true);
$aa_title = $acccha[title];
$aa_chat_id = $acccha[chat_id];
$aa_messages_count = $acccha[messages_count];
$aa_participants_count = $acccha[participants_count];
bot($chatId,['text'=>"
**⌔︙** أسـم اݪـمجموعة : $aa_title
**⌔︙** أيـدي اݪـمجموعة : $aa_chat_id
**⌔︙** رسـائل اݪـمجموعة : $aa_messages_count
**⌔︙** أعـضاء اݪـمجموعة : $aa_participants_count","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]]);
}

if ($text == "الرابط"){
bot($chatId,['text'=>"✯︙ Link Group :
    $link","link"=>["type"=>"reply","mid"=>$message_id]]);
}
if ($text == "المنشئ" or $text == "المنشى") {
    $messageText = "**🔸︙ الـمـالـك الشخصي  ↯ .\n" .
                   "┉ ┉ ┉ ┉ ┉ ┉ ┉ ┉ ┉\n" .
                   "أسـم المُنشئ : $owner_name\n" .
                   "يـوزر المُنشئ** : ❲ $owner_username ❳";
    bot($chatId, [
        'text' => $messageText,
        'link' => ["type" => "reply", "mid" => $message_id],
        'format' => 'markdown'
    ]);
}

if ($text == "المطور"){
bot($chatId,['text'=>"𝗖𝗼𝗿𝗲 𝗗𝗲𝘃𝗘𝗹𝗼𝗽𝗲𝗿
━───━ ★ ━───━
**◇︰Name :**  ❲ سـہنـدبـاد ❳
**◇︰User :** ❲ @cull ❳  
**◇︰𝖲𝗍𝖺𝗌𝗍 :** ❲ ^^المطور الاساسي^^ ❳",'format'=>'markdown',"link"=>["type"=>"reply","mid"=>$message_id]]);
}


if($text == "ايدي" or $text == "ا"){
$infoad = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chatId.'/members?access_token='.$API_KEY.'&user_ids='.$user_id));
$is_name = $infoad->members[0]->name; 
$is_user_id = $infoad->members[0]->user_id;
$is_username = $infoad->members[0]->username; 
$is_bio = isset($infoad->members[0]->description) ? $infoad->members[0]->description : "لا يوجد!";
$is_rank = rank($user_id, $chatId);
$is_active = $active[$abstfal]." ".$rate[$rate1];
$sId = isset($second[$chatId]["id"]) ? $second[$chatId]["id"] : "

**◇︰Name :** $is_name .
**◇︰𝖨𝖣 :** $is_user_id  .
**◇︰User :** @$is_username .
**◇︰𝖲𝗍𝖺𝗌𝗍 :** ^^$is_rank^^ .
**◇︰𝖬𝗌𝗀𝗌 :**مثل وجهك 💕😞 .";
$sId = str_replace(["US","NAME","ID","RT"],["@$is_username",$is_name,$is_user_id,$is_rank],$sId);
bot($chatId,['text'=>$sId,"format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
}




if ($reply && $text == "رفع منشئ" && is_creator($user_id, $chatId)) {
    if (!in_array($re_user_id, $owner[$chatId])) {
        $owner[$chatId][] = $re_user_id;
        file_put_contents("information_/owner".$update_info.".json", json_encode($owner, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** تـم رفع رتـبة اݪـى منشئ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** ^^عمري المنشئ مرفوع من گبل^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}

if ($reply && $text == "تنزيل منشئ" && is_creator($user_id, $chatId)) {
    if (in_array($re_user_id, $owner[$chatId])) {
        $key = array_search($re_user_id, $owner[$chatId]);
        unset($owner[$chatId][$key]);
        $owner[$chatId] = array_values($owner[$chatId]);
        file_put_contents("information_/owner".$update_info.".json", json_encode($owner, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** ^^عمري ـنزلته رتـبة منشئ^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** اݪـمستـخدم رتـبتهہ ݪيسة ^^منشئ^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}


// رفع وتنزيل ادمن

if ($reply && $text == "رفع ادمن" && is_owner($user_id, $chatId)) {
    if (!in_array($re_user_id, $Admin[$chatId])) {
        $Admin[$chatId][] = $re_user_id;
        file_put_contents("information_/Admin".$update_info.".json", json_encode($Admin, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** عمري رفعتهه بـرتـبة ادمن .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** ^^ححيلي مرفوع ادمن من گبل^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}

if ($reply && $text == "تنزيل ادمن" && is_owner($user_id, $chatId)) {
    if (in_array($re_user_id, $Admin[$chatId])) {
        $key = array_search($re_user_id, $Admin[$chatId]);
        unset($Admin[$chatId][$key]);
        $Admin[$chatId] = array_values($Admin[$chatId]);
        file_put_contents("information_/Admin".$update_info.".json", json_encode($Admin, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** ^^عمري خلعت رتـبة الادمن^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** اݪـمستـخدم رتـبتهہ ݪيسة ^^ادمن^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}


// رفع وتنزيل مميز

if ($reply && $text == "رفع مميز" && is_admin($user_id, $chatId)) {
    if (!in_array($re_user_id, $Special[$chatId])) {
        $Special[$chatId][] = $re_user_id;
        file_put_contents("information_/Special".$update_info.".json", json_encode($Special, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** حبي ـرقيته برتـبة مميز جميل.",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** ^^حياتي اݪـمميز مرفوع من گبل^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}

if ($reply && $text == "تنزيل مميز" && is_admin($user_id, $chatId)) {
    if (in_array($re_user_id, $Special[$chatId])) {
        $key = array_search($re_user_id, $Special[$chatId]);
        unset($Special[$chatId][$key]);
        $Special[$chatId] = array_values($Special[$chatId]);
        file_put_contents("information_/Special".$update_info.".json", json_encode($Special, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** ^^حياتي خلعت رتـبة المميز واصبح غير جميل^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** اݪـمستـخدم رتـبتهہ ݪيسة ^^مميز^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}

// تنزيل الكل

if ($reply && $text == "تنزيل الكل" && is_admin($user_id, $chatId)) {
    if (is_creator($re_user_id, $chatId)) {
        $rankT = rank($re_user_id, $chatId);
        bot($chatId, [
            'text' => "**⌔︙** عـذراً اݪـمستـخدم ݪـديه رتـبهہ  : ^^$rankT^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
        return false;
    }

    if (in_array($re_user_id, $Special[$chatId]) || in_array($re_user_id, $Admin[$chatId]) || in_array($re_user_id, $owner[$chatId])) {
        if (is_creator($user_id, $chatId)) {
            if (in_array($re_user_id, $owner[$chatId])) {
                $key = array_search($re_user_id, $owner[$chatId]);
                unset($owner[$chatId][$key]);
                $owner[$chatId] = array_values($owner[$chatId]);
                file_put_contents("information_/owner".$update_info.".json", json_encode($owner, 128 | 32 | 256));
            }
            if (in_array($re_user_id, $Admin[$chatId])) {
                $key = array_search($re_user_id, $Admin[$chatId]);
                unset($Admin[$chatId][$key]);
                $Admin[$chatId] = array_values($Admin[$chatId]);
                file_put_contents("information_/Admin".$update_info.".json", json_encode($Admin, 128 | 32 | 256));
            }
            if (in_array($re_user_id, $Special[$chatId])) {
                $key = array_search($re_user_id, $Special[$chatId]);
                unset($Special[$chatId][$key]);
                $Special[$chatId] = array_values($Special[$chatId]);
                file_put_contents("information_/Special".$update_info.".json", json_encode($Special, 128 | 32 | 256));
            }
        } elseif (is_owner($user_id, $chatId)) {
            if (in_array($re_user_id, $Admin[$chatId])) {
                $key = array_search($re_user_id, $Admin[$chatId]);
                unset($Admin[$chatId][$key]);
                $Admin[$chatId] = array_values($Admin[$chatId]);
                file_put_contents("information_/Admin".$update_info.".json", json_encode($Admin, 128 | 32 | 256));
            }
            if (in_array($re_user_id, $Special[$chatId])) {
                $key = array_search($re_user_id, $Special[$chatId]);
                unset($Special[$chatId][$key]);
                $Special[$chatId] = array_values($Special[$chatId]);
                file_put_contents("information_/Special".$update_info.".json", json_encode($Special, 128 | 32 | 256));
            }
        } elseif (is_admin($user_id, $chatId)) {
            if (in_array($re_user_id, $Special[$chatId])) {
                $key = array_search($re_user_id, $Special[$chatId]);
                unset($Special[$chatId][$key]);
                $Special[$chatId] = array_values($Special[$chatId]);
                file_put_contents("information_/Special".$update_info.".json", json_encode($Special, 128 | 32 | 256));
            }
        }
        bot($chatId, [
            'text' => "**⌔︙** ^^تم خـݪـعهہ من كُل اݪـرتب^^ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** العضو فارغ ماعنده رتـبة ئطيهههه.",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}

if (is_owner($user_id, $chatId)) {
    // مسح كليشة الايدي
    if ($text == "مسح كليشه الايدي") {
        unset($second[$chatId]["id"]);
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** تم مسح كـݪيشهہ الايدي بنجـاح .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }

    // تعيين كليشة الايدي
    if ($text == "تعيين كليشه الايدي") {
        $second[$user_id]["set"] = "addid";
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
        bot($chatId, [
            'text' => "- أرسـل كليشة الايدي الان .\n- مثال :\n\nلعرض المعرف : US\nلعرض الايدي : ID\nلعرض الاسم : NAME\nلعرض الرتبه : RT",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else if (isset($second[$user_id]["set"]) && $second[$user_id]["set"] == "addid" && $text != "/start") {
        $second[$chatId]["id"] = $text;
        $second[$user_id]["set"] = false;
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
        bot($chatId, [
            'text' => "**⌔︙** تم اضـافة كـݪيشهہ الايدي .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}

// مسح الترحيب

if (is_owner($user_id, $chatId)) {
if ($text == "مسح الترحيب") {
    unset($second[$chatId]["user_added"]);
    file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
    bot($chatId, [
        'text' => "**⌔︙** تَـم مسح الترحيب بـنجاح .",
        'format' => "markdown",
        'link' => ["type" => "reply", "mid" => $message_id]
    ]);
}

// إضافة ترحيب جديد
if ($text == "اضف ترحيب") {
    $second[$user_id]["set"] = "adtr";
    file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
    bot($chatId, [
        'text' => "- أرسـل كليـشة تـرحيبك الان .\n- مثال :\n\nاهلاً بك في المجموعه .\nاسمك : #name\nيوزرك : #username",
        'format' => "markdown",
        'link' => ["type" => "reply", "mid" => $message_id]
    ]);
} else if (isset($second[$user_id]["set"]) && $second[$user_id]["set"] == "adtr" && $text != "/start") {
    $second[$chatId]["user_added"] = $text;
    $second[$user_id]["set"] = false;
    file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
    bot($chatId, [
        'text' => "**⌔︙** تَـم حفـض الترحيب بـنجاح .",
        'format' => "markdown",
        'link' => ["type" => "reply", "mid" => $message_id]
    ]);
}

// عرض الترحيب الحالي
if ($text == "الترحيب") {
    $welcomeMessage = isset($second[$chatId]["user_added"]) ? $second[$chatId]["user_added"] : "اطِݪقہ دخِوݪ شِني٘ہ ڪَٖيكَ 🐉👄.\n$username\n$name";
    bot($chatId, [
        'text' => $welcomeMessage,
        'link' => ["type" => "reply", "mid" => $message_id]
    ]);
}
}


if (is_special($user_id, $chatId)) {
    if ($text == "ردود" || $text == "الردود") {
        if (isset($replies[$chatId]["rp"]) && count($replies[$chatId]["rp"]) != 0) {
            $msg = '';
            foreach ($replies[$chatId]["rp"] as $index => $replyKey) {
                $type = '';
                if (isset($replies[$chatId]["text"][$replyKey])) {
                    $type = "(رساله)";
                } elseif (isset($replies[$chatId]["audio"][$replyKey])) {
                    $type = "(صوت)";
                }

                if ($type) {
                    $msg .= "\n" . ($index + 1) . "- " . $replyKey . " -> " . $type;
                }
            }

            $responseText = $msg ? "**^^⌔︙^^** ^^ههاك قائمه الردود ⊰ .\n﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎^^" . $msg : "**⌔︙** ماكو ردود  بـالگروب 🔹 ⊰ .";
            bot($chatId, [
                'text' => $responseText,
                'format' => "markdown",
                'link' => ["type" => "reply", "mid" => $message_id]
            ]);
        } else {
            bot($chatId, [
                'text' => "**⌔︙** ماكـكو كل ردود  بالـگروب 🔹 ⊰ .",
                'format' => "markdown",
                'link' => ["type" => "reply", "mid" => $message_id]
            ]);
        }
    }
}

function fetchUserDetails($chatId, $userId, $API_KEY) {
    $url = 'https://botapi.tamtam.chat/chats/'.$chatId.'/members?access_token='.$API_KEY.'&user_ids='.$userId;
    $response = json_decode(file_get_contents($url), true);
    return $response['members'][0];
}

function formatMessage($userDetails, $index) {
    if (!$userDetails['username']) {
        return "\n" . ($index + 1) . "- " . $userDetails['name'];
    } else {
        return "\n" . ($index + 1) . "- @" . $userDetails['username'];
    }
}

function listUsers($chatId, $users, $API_KEY, $message_id, $listType) {
    $msg = '';
    if (count($users) != 0) {
        for ($i = 0; $i < count($users); $i++) {
            $userDetails = fetchUserDetails($chatId, $users[$i], $API_KEY);
            $msg .= formatMessage($userDetails, $i);
        }
        bot($chatId, [
            'text' => "**^^⌔︙^^** ^^هـهاك قائمه {$listType} ⊰ .\n﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎^^" . $msg,
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    } else {
        bot($chatId, [
            'text' => "**⌔︙** لايـوجد {$listType} 🔹 ⊰ .",
            'format' => "markdown",
            'link' => ["type" => "reply", "mid" => $message_id]
        ]);
    }
}

// المكتومين
if ((is_admin($user_id,$chatId)) && ($text == "المكتومين")) {
    listUsers($chatId, $mute[$chatId], $API_KEY, $message_id, 'مكتومين');
}

// المميزين
if ((is_admin($user_id,$chatId)) && ($text == "المميزين")) {
    listUsers($chatId, $Special[$chatId], $API_KEY, $message_id, 'مميزين');
}

// الادمنيه
if ((is_admin($user_id, $chatId)) && ($text == "الادمنيه" || $text == "الادمنية")) {
    listUsers($chatId, $Admin[$chatId], $API_KEY, $message_id, 'ادمنية');
}

// المدراء
if ((is_admin($user_id, $chatId)) &&($text == "المدراء" || $text == "المنشئين")) {
    listUsers($chatId, $owner[$chatId], $API_KEY, $message_id, 'منشئين');
}
}




// مسح المميزين

if ($text == "مسح المميزين" && is_admin($user_id, $chatId)) {
    bot($chatId, [
        'text' => "**^^⌔︙^^** ^^تدلل مسحت قـائـمة اݪمميزين  .^^",
        'link' => ["type" => "reply", "mid" => $message_id],
        'format' => "markdown"
    ]);
    unset($Special[$chatId]);    file_put_contents("information_/Special".$update_info.".json", json_encode($Special, 128 | 32 | 256));
}

if ($text == "مسح الادمنيه" && is_owner($user_id, $chatId)) {
    bot($chatId, [
        'text' => "**^^⌔︙^^** ^^تُدلل مسحت قـائـمة اݪادمـنية  .^^",
        'link' => ["type" => "reply", "mid" => $message_id],
        'format' => "markdown"
    ]);
    unset($Admin[$chatId]);    file_put_contents("information_/Admin".$update_info.".json", json_encode($Admin, 128 | 32 | 256));
}

if (($text == "مسح المدراء" || $text == "مسح المنشئين") && is_creator($user_id, $chatId)) {
    bot($chatId, [
        'text' => "**^^⌔︙^^** ^^تُدلل مسحت قـائـمة اݪمنشئين  .^^",
        'link' => ["type" => "reply", "mid" => $message_id],
        'format' => "markdown"
    ]);
    unset($owner[$chatId]);    file_put_contents("information_/owner".$update_info.".json", json_encode($owner, 128 | 32 | 256));
}

if ($text == "مسح الردود" && is_owner($user_id, $chatId)) {
    bot($chatId, [
        'text' => "**^^⌔︙^^** ^^تدلـل مسحت قـائـمة اݪردود  .^^",
        'link' => ["type" => "reply", "mid" => $message_id],
        'format' => "markdown"
    ]);
    $typesToDelete = ['text', 'audio'];
    foreach ($typesToDelete as $type) {
        if (isset($replies[$chatId][$type])) {
            foreach ($replies[$chatId][$type] as $key => $value) {
                unset($replies[$chatId][$type][$key]);
            }
        }
    }
    file_put_contents("information_/replies".$update_info.".json", json_encode($replies, 128 | 32 | 256));
}

if($reply && $text == "كشف" || $text == "رتبته"){
$rankT = rank($re_user_id, $chatId);
bot($chatId,['text'=>"

**◇︰Name :** $re_name .
**◇︰𝖨𝖣 :** $re_user_id  .
**◇︰User :** $re_username .
**◇︰𝖲𝗍𝖺𝗌𝗍 :** ^^$rankT^^ .
**◇︰𝖬𝗌𝗀𝗌 :** لـطيفةَ مثل وجهه 😎🍬 .","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}
if($text == "معلوماتي" || $text == "رتبتي"){
$rankT = rank($user_id, $chatId);
bot($chatId,['text'=>"
**◇︰ألايدي :** $user_id  .
**◇︰رتـبتك في الـبوت :** ^^$rankT^^ .","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}


if (is_admin($user_id, $chatId)) {
    if ($second[$user_id]["set"] === "replies2") {
        // إضافة رد نصي
        if (isset($message->body->text)) {
            $replies[$chatId]["text"][$second[$user_id]["re"]] = $message->body->text;
            // تحديث قائمة الردود
            if (!in_array($second[$user_id]["re"], $replies[$chatId]["rp"])) {
                $replies[$chatId]["rp"][] = $second[$user_id]["re"];
            }
            file_put_contents("information_/replies".$update_info.".json", json_encode($replies, 128 | 32 | 256));
        }

        // إضافة رد صوتي جديد
        if (isset($message->body->attachments[0]->payload->id) && $message->body->attachments[0]->type === 'audio') {
            $replies[$chatId]["audio"][$second[$user_id]["re"]] = $message->body->attachments[0]->payload->token;
            // تحديث قائمة الردود
            if (!in_array($second[$user_id]["re"], $replies[$chatId]["rp"])) {
                $replies[$chatId]["rp"][] = $second[$user_id]["re"];
            }
            file_put_contents("information_/replies".$update_info.".json", json_encode($replies, 128 | 32 | 256));
        }

        bot($chatId, ['text' => "**^^⌔︙^^** ^^تَـدلـل حفـضت الرد بكل حب ⊁ .^^", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
        // إعادة تعيين القيم في $second
        $second[$user_id] = ["re" => false, "set" => false];
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
    } elseif ($second[$user_id]["set"] === "replies1") {
        if ($text && !in_array($text, ["/start", "اضف رد", "اضف امر"])) {
            bot($chatId, ['text' => "**⌔︙** هسَ  دز آلرد الي تࢪيدة صوتيهہَ أو نص ⊁ .", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
            $second[$user_id] = ["re" => $text, "set" => "replies2"];
            file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
        }
    } elseif ($text === "اضف رد") {
        bot($chatId, ['text' => "**^^⌔︙^^** ^^دزلي آلكلمة لـ عمل رد لها ⊁ .^^", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
        $second[$user_id]["set"] = "replies1";
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
    }
}
// الجزء الخاص بحذف الردود
if ($second[$user_id]["set"] === "repliesdel") {
    if ($text && !in_array($text, ["/start", "اضف رد", "اضف امر", "حذف رد"])) {
        bot($chatId, ['text' => "**⌔︙** ^^تَـأمر حـذفت الرد بكل لطافه ⊁ .^^", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
        $second[$user_id]["set"] = false;
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
        $key = array_search($text, $replies[$chatId]["rp"]);
        $types = ['sticker', 'audio', 'text', 'image', 'video'];
        foreach ($types as $type) {
            if (isset($replies[$chatId][$type][$replies[$chatId]["rp"][$key]])) {
                unset($replies[$chatId][$type][$replies[$chatId]["rp"][$key]]);
            }
        }
        unset($replies[$chatId]["rp"][$key]);
        $replies[$chatId]["rp"] = array_values($replies[$chatId]["rp"]);
        file_put_contents("information_/replies".$update_info.".json", json_encode($replies, 128 | 32 | 256));
    }
}

// الجزء الخاص بإضافة أو تغيير الأوامر

if (is_admin($user_id, $chatId)) {
if ($text === "حذف رد") {
    bot($chatId, ['text' => "**⌔︙**  دز آلكلمة لـ حذفها من الردود ⊁ .", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
    $second[$user_id]["set"] = "repliesdel";
    file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
}

if ($second[$user_id]["set"] === "repold2") {
    if ($text && $text !== "/start") {
        bot($chatId, ['text' => "**^^⌔︙^^** ^^ع راسـي حفـضت آلامر 🤭 ⊁ .^^", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
        $true[$chatId]["List"][] = $text;
        $true[$chatId][$second[$user_id]["re"]] = $second[$user_id]["re"];
        $true[$chatId][$text] = $second[$user_id]["re"];
        file_put_contents("information_/true".$update_info.".json", json_encode($true, 128 | 32 | 256));
        $second[$user_id] = ["re" => false, "set" => false];
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
    }
}

if ($second[$user_id]["set"] === "repold") {
    if ($text && $text !== "/start") {
        bot($chatId, ['text' => "**⌔︙** دز آلامر الجديد ولـك ⊁ .", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
        $second[$user_id]["re"] = $text;
        $second[$user_id]["set"] = "repold2";
        file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
    }
}

// إضافة أمر جديد
if (in_array($text, ["اضف امر", "تغير امر", "تغيير امر", "اظف امر", "وضع امر", "وظع امر"])) {
    bot($chatId, ['text' => "**^^⌔︙^^** ^^اوك دزلي آلامر القديم  ⊁ .^^", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
    $second[$user_id]["set"] = "repold";
    file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
}

// حذف أمر قديم
if ($second[$user_id]["set"] === "repdelold" && $text !== "/start") {
    bot($chatId, ['text' => "**^^⌔︙^^** ^^تَـأمر حـذفت آلامر شيخ ⊁ .^^", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
    $key = array_search($true[$chatId][$true[$chatId][$text]], $true[$chatId]["List"]);
    if ($key !== false) {
        unset($true[$chatId]["List"][$key], $true[$chatId][$true[$chatId][$text]], $true[$chatId][$text]);
        $true[$chatId]["List"] = array_values($true[$chatId]["List"]);
        file_put_contents("information_/true".$update_info.".json", json_encode($true, 128 | 32 | 256));
    }
    $second[$user_id]["set"] = false;
    file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
}


// حذف أمر معين
if (in_array($text, ["حذف امر", "مسح امر"])) {
    bot($chatId, ['text' => "**⌔︙** دز آلامر القديم حتى احـذفة ⊁ .", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
    $second[$user_id]["set"] = "repdelold";
    file_put_contents("information_/second".$update_info.".json", json_encode($second, 128 | 32 | 256));
}

// مسح جميع الأوامر المضافة
if (in_array($text, ["مسح الاوامر المضافه", "حذف الاوامر المظافه"])) {
    bot($chatId, ['text' => "**^^⌔︙^^** ^^طيب مسحت قـائـمة اݪاوامر بسرعه ⊰  .^^", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
    foreach ($true[$chatId]["List"] as $deal) {
        unset($true[$chatId][$deal], $true[$chatId][$true[$chatId][$deal]]);
    }
    $true[$chatId]["List"] = [];
    file_put_contents("information_/true".$update_info.".json", json_encode($true, 128 | 32 | 256));
}

// عرض جميع الأوامر المضافة
if (in_array($text, ["الاوامر المضافه", "الاوامر المظافه", "الاوامر الاحتياطيه", "الاوامر الجديده"])) {
    if (!empty($true[$chatId]["List"])) {
        $msg = "";
        foreach ($true[$chatId]["List"] as $index => $Eq) {
            $dr = $true[$chatId][$Eq];
            $msg .= "\n" . ($index + 1) . "- " . $Eq . " ~ ( " . $dr . " )";
        }
        bot($chatId, ['text' => "**^^⌔︙^^** ^^دهـاك قائمه الاوامر المضافه  ⊰ .\n﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎^^" . $msg, 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
    }else {
        bot($chatId, ['text' => "**⌔︙** **لاتـوجد اوامـر مـضافه ⊰ .**", 'format' => "markdown", 'link' => ["type" => "reply", "mid" => $message_id]]);
      }
  }
}

$allowed_texts = ["م١", "م1", "م٢", "م2", "م٣", "م3", "م٤", "م4", "م٥", "م5", "الاوامر"];

if (in_array($text, $allowed_texts) && is_admin($user_id, $chatId)) {  
    $ff = [
        [['type' => 'callback', 'text' =>'أوامر الحماية', 'payload' =>"M1"],['type' => 'callback', 'text' =>"أوامر المنشئ الاساسي", 'payload' =>"M2"]],
        [['type' => 'callback', 'text' =>"أوامر المسؤولين", 'payload' =>"M3"],['type' => 'callback', 'text' =>'أوامر الادمنية', 'payload' =>"M4"]],
        [['type' => 'callback', 'text' =>'أوامر المطورين', 'payload' =>"M5"],['type' => 'link', 'text' =>"Source Bot", 'url' =>"https://tt.me/MaXTeeM"]],
[['type' => 'callback', 'text' =>'اخفاء', 'payload' =>"fo"]],
    ];
    bot($chatId,['text'=>"•⊱ **أنت هايه  دامك اوامر البوت** .
•⊱ **أختر أحد الاقسام لعرض الاوامر** .
    ﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎","format"=>"markdown", 'attachments' =>[['type' => 'inline_keyboard','payload'=>['buttons'=>$ff,]]],
    ]);
}
if($data == "M1"){
$ff = [
[['type' => 'callback', 'text' => 'رجوع', 'payload' => 'Re']],
];
edit_value($message_id, $ff,"⌔︙**لعرض اوامر الحماية في المجموعة قم بأرسال كلمة**:
' ^^**اعدادات**^^ ' **أو** ' ^^**الاعدادات**^^ ' 
**يمكنك الضغط على الازرار للقفل والفتح حيث**:

**اذا ضغت على الزر** 🟢 **سيقوم البوت بقفل ماتريد وتحويل الاشارة الى** 🔴.

**اذا ضغت على الزر** 🔴 **سيقوم البوت بفتح ماتريد وتحويل الاشارة الى** 🟢.");
}

if($data == "M2"){
$ff = [
[['type' => 'callback', 'text' => 'رجوع', 'payload' => 'Re']],
];
edit_value($message_id, $ff,"⌔︙^^أليك أوامر المنشئ الاساسي^^ .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
ابو الگروب حبيبي شعندي غيرك
⌔︙^^رفع ← تنزيل / بالرد فقط^^
⌔︙^^طرد ← كتم / بالرد ~ باليوزر^^
⌔︙^^مسح / المنشئين ← الادمنيه^^
⌔︙^^مسح الردود^^
⌔︙^^مسح الاوامر^^
⌔︙^^اضف ← حذف / رد^^
⌔︙^^اضف ← حذف / امر^^
⌔︙^^اضف ← مسح / ترحيب^^
⌔︙^^تثبيت ← الغاء تثبيت / الرسائل^^
⌔︙^^الغاء كتم / بالرد ~ باليوزر^^
⌔︙^^مسح / لمسح الرساله^^
⌔︙^^الردود / لعرض الردود^^
⌔︙^^الاوامر المضافه / لعرض الاوامر^^
⌔︙^^تنزيل الكل^^
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
‏⌔");
}

if($data == "M3"){
$ff = [
[['type' => 'callback', 'text' => 'رجوع', 'payload' => 'Re']],
];
edit_value($message_id, $ff,"⌔︙^^دهـاك أوامر المنشئ والمسؤول^^ .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
احفضوهن مو تنسون 🐸🤭
⌔︙^^طرد ← حضر / بالرد ~ باليوزر^^
⌔︙^^رفع ← تنزيل / بالرد فقط^^
⌔︙^^مسح / الادمنيه ~ المميزين^^
⌔︙^^اضف ← حذف / رد^^
⌔︙^^اضف ← حذف / امر^^
⌔︙^^اضف ← مسح / ترحيب^^
⌔︙^^تثبيت ← الغاء تثبيت / الرسائل^^
⌔︙^^مسح / لمسح الرساله^^
⌔︙^^الردود / لعرض الردود^^
⌔︙^^الاوامر المضافه / لعرض الاوامر^^
⌔︙^^مسح الردود^^
⌔︙^^مسح الاوامر^^
⌔︙^^تنزيل الكل^^
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
‏⌔");
}

if($data == "M4"){
$ff = [
[['type' => 'callback', 'text' => 'رجوع', 'payload' => 'Re']],
];
edit_value($message_id, $ff,"⌔︙دهـاك أوامر الادمن  بـالبوت .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
الادمن ت الجميل احفضهن ❤️😃
⌔︙^^رفع ← تنزيل / بالرد^^
⌔︙^^طرد ← حضر / بالرد ~ باليوزر^^
⌔︙^^مسح / لمسح الرساله^^
⌔︙^^تثبيت ← الغاء التثبيت / الرسائل^^
⌔︙^^اضف ← حذف / رد^^
⌔︙^^اضف ← حذف / امر^^
⌔︙^^تنزيل مميز^^
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
‏⌔︙");
}

if($data == "M5"){
$ff = [
[['type' => 'callback', 'text' => 'رجوع', 'payload' => 'Re']],
];
edit_value($message_id, $ff,"⌔︙^^دهـاكك أوامر مطورين البوت^^ .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
تاج راسي استاذي شعندي غيرك 🔮🪄
⌔︙^^رفع ← تنزيل / مطور^^
⌔︙^^المطورين / لعرض المطورين^^
⌔︙^^اضف ← حذف / رد عام^^
⌔︙^^الردود العامه^^
⌔︙^^مسح الردود العامه^^
⌔︙^^جميع الاوامر في البوت يمكنه استخدامها^^
‏—————𖠹—————
⌔︙^^أليك أوامر المطور 2^^ 
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
⌔︙^^اضف ← حذف / رد عام^^
⌔︙^^الردود العامه^^
⌔︙^^مسح الردود العامه^^
⌔︙^^جميع الاوامر في البوت يمكنه استخدامها^^
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
‏⌔");
}

if($data == "Re"){

$ff = [
[['type' => 'callback', 'text' =>'أوامر الحماية', 'payload' =>"M1"],['type' => 'callback', 'text' =>"أوامر المنشئ الاساسي", 'payload' =>"M2"]],
[['type' => 'callback', 'text' =>"أوامر المسؤولين", 'payload' =>"M3"],['type' => 'callback', 'text' =>'أوامر الادمنية', 'payload' =>"M4"]],
[['type' => 'callback', 'text' =>'أوامر المطورين', 'payload' =>"M5"],['type' => 'link', 'text' =>"Source Bot", 'url' =>"https://tt.me/cull"]],
[['type' => 'callback', 'text' =>'اخفاء', 'payload' =>"fo"]],
];
edit_value($message_id, $ff,"•⊱ **أنت هسا  بـقائمة اوامر البوت** .
•⊱ **أختر أحد الاقسام لعرض الاوامر** .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎");
}

if($data == "fo" && is_admin($user_id, $chatId)){
                    deleteMessage($message_id);
}        
            
if($data && !is_admin($user_id, $chatId)){
bot($chatId,[
'text'=> "•⊱ **عذراً**: [$name](https://tt.me/$username) .
•⊱ [ ^^المسؤول^^ ، ^^المنشئ^^ ، ^^الادمن^^ ] 
•⊱ **يمكنهم التحكم في الازرار فقط** . ","format"=>"markdown"
        ]);                   
}



if (!file_exists("info")) {
    mkdir("info");
}
if (!file_exists("info/lock.json")) {
    file_put_contents("info/lock.json", json_encode([]));
}

function updateLockState($chatId, $type, $state){
    $lock = json_decode(file_get_contents("info/lock.json"), true);
    if (!isset($lock[$chatId])) {
        $lock[$chatId] = [];
    }
    $lock[$chatId][$type] = $state;
    file_put_contents("info/lock.json", json_encode($lock));
}
$com = [
"قفل الصور", "قفل الرابط", "قفل الفايروس","قفل التوجيه","قفل الفيديو","قفل الروابط","قفل الصور","قفل الفيديو","قفل الانلاين","قفل الترحيب","قفل الهاشتاك","قفل الرسائل","قفل الدردشة","قفل الفشار","قفل البوتات","قفل اليوزرات","قفل الملفات","قفل الموقع","فتح الصور", "فتح الرابط", "فتح الفايروس","فتح التوجيه","فتح الفيديو","فتح الروابط","فتح الصور","فتح الفيديو","فتح الانلاين","فتح الترحيب","فتح الهاشتاك","فتح الرسائل","فتح الدردشة","فتح الفشار","فتح البوتات","فتح اليوزرات","فتح الملفات","فتح الموقع","قفل الكل","فتح الكل"
];
if (in_array($text, $com)) {
bot($chatId,[
'text'=>"•⊱ **العزيز أرسل ' ^^الاعدادات^^ ' بدلاً من $text** .","format"=>"markdown",
        'link' => ['type' => 'reply', 'mid' => $message_id],
]);
}


function sendSettingsMessage($chatId, $message_id){
    $lock =
json_decode(file_get_contents("info/lock.json"), true);
    $lockStateImage = $lock[$chatId]['image'] ?? false;
    $lockStateStickers = $lock[$chatId]['sticker'] ?? false;
    $lockStateVideos = $lock[$chatId]['video'] ?? false;
    $lockStateLo = $lock[$chatId]['location'] ?? false;
    $lockStateAu = $lock[$chatId]['audio'] ?? false;

//جديد

    $lockStateCo = $lock[$chatId]['contact'] ?? false;
    $lockStateFi = $lock[$chatId]['file'] ?? false;
    $lockStateKe = $lock[$chatId]['keyboard'] ?? false;

    $lockStateFo = $lock[$chatId]['forward'] ?? false;
    $lockStateUs = $lock[$chatId]['username'] ?? false;
    $lockStateHa = $lock[$chatId]['hashtag'] ?? false;

    $lockStateMs = $lock[$chatId]['msg'] ?? false;
    $lockStateLi = $lock[$chatId]['link'] ?? false;
    $lockStateBo = $lock[$chatId]['is_bot'] ?? false;
    $lockStateFsh = $lock[$chatId]['offense'] ?? false;
    $lockStateFay = $lock[$chatId]['spam'] ?? false;
    $lockStateAd = $lock[$chatId]['user_added'] ?? false;

    $buttons = [
        [['type' => 'callback', 'text' => $lockStateImage ? "🔴" : "🟢", 'payload' => 'toggle_image'],['type' => 'callback', 'text' => 'الصور', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateStickers ? "🔴" : "🟢", 'payload' => 'toggle_sticker'],['type' => 'callback', 'text' => 'الملصقات', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateLo ? "🔴" : "🟢", 'payload' => 'toggle_location'],['type' => 'callback', 'text' => 'الموقع', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateAu ? "🔴" : "🟢", 'payload' => 'toggle_audio'],['type' => 'callback', 'text' => 'الصوت', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateVideos ? "🔴" : "🟢", 'payload' => 'toggle_video'],['type' => 'callback', 'text' => 'الفيديوهات', 'payload' => 'no_action']],

//جديد

[['type' => 'callback', 'text' => $lockStateCo ? "🔴" : "🟢", 'payload' => 'toggle_contact'],['type' => 'callback', 'text' => 'الجهات', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateFi ? "🔴" : "🟢", 'payload' => 'toggle_file'],['type' => 'callback', 'text' => 'الملفات', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateKe ? "🔴" : "🟢", 'payload' => 'toggle_keyboard'],['type' => 'callback', 'text' => 'الكيبورد', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateFo ? "🔴" : "🟢", 'payload' => 'toggle_forward'],['type' => 'callback', 'text' => 'التوجية', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateUs ? "🔴" : "🟢", 'payload' => 'toggle_username'],['type' => 'callback', 'text' => 'اليوزرات', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateHa ? "🔴" : "🟢", 'payload' => 'toggle_hashtag'],['type' => 'callback', 'text' => 'الهاشتاك', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateLi ? "🔴" : "🟢", 'payload' => 'toggle_link'],['type' => 'callback', 'text' => 'الروابط', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateBo ? "🔴" : "🟢", 'payload' => 'toggle_is_bot'],['type' => 'callback', 'text' => 'البوتات', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateFsh ? "🔴" : "🟢", 'payload' => 'toggle_offense'],['type' => 'callback', 'text' => 'الفشار', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateFay ? "🔴" : "🟢", 'payload' => 'toggle_spam'],['type' => 'callback', 'text' => 'الفايروس', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateAd ? "🔴" : "🟢", 'payload' => 'toggle_user_added'],['type' => 'callback', 'text' => 'الترحيب', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateMs ? "🔴" : "🟢", 'payload' => 'toggle_msg'],['type' => 'callback', 'text' => 'الرسائل', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => 'اخفاء', 'payload' => 'hig']]
];
    bot($chatId, [
        'text' => "•⊱ **شوف قائمة اعدادات الحماية** .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
•⊱ **علامة 🟢 الامـر مسمـوح به** .
•⊱ **علامة 🔴 الامر غير مسموح به** .
•⊱ **اضغط الزر للقفل أو الفتح**👇🏻.","format"=>"markdown",
        'link' => ['type' => 'reply', 'mid' => $message_id],
        'attachments' => [['type' => 'inline_keyboard', 'payload' => ['buttons' => $buttons]]]
    ]);
}

function editSettingsMessage($chatId, $message_id){
    $lock = json_decode(file_get_contents("info/lock.json"), true);
    $lockStateImage = $lock[$chatId]['image'] ?? false;
    $lockStateStickers = $lock[$chatId]['sticker'] ?? false;
    $lockStateVideos = $lock[$chatId]['video'] ?? false;
    $lockStateLo = $lock[$chatId]['location'] ?? false;
    $lockStateAu = $lock[$chatId]['audio'] ?? false;

//جديد

    $lockStateCo = $lock[$chatId]['contact'] ?? false;
    $lockStateFi = $lock[$chatId]['file'] ?? false;
    $lockStateKe = $lock[$chatId]['keyboard'] ?? false;

    $lockStateFo = $lock[$chatId]['forward'] ?? false;
    $lockStateUs = $lock[$chatId]['username'] ?? false;
    $lockStateHa = $lock[$chatId]['hashtag'] ?? false;

    $lockStateMs = $lock[$chatId]['msg'] ?? false;
    $lockStateLi = $lock[$chatId]['link'] ?? false;
    $lockStateBo = $lock[$chatId]['is_bot'] ?? false;
    $lockStateFsh = $lock[$chatId]['offense'] ?? false;
    $lockStateFay = $lock[$chatId]['spam'] ?? false;
    $lockStateAd = $lock[$chatId]['user_added'] ?? false;

    $buttons = [

        [['type' => 'callback', 'text' => $lockStateImage ? "🔴" : "🟢", 'payload' => 'toggle_image'],['type' => 'callback', 'text' => 'الصور', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateStickers ? "🔴" : "🟢", 'payload' => 'toggle_sticker'],['type' => 'callback', 'text' => 'الملصقات', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateLo ? "🔴" : "🟢", 'payload' => 'toggle_location'],['type' => 'callback', 'text' => 'الموقع', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateAu ? "🔴" : "🟢", 'payload' => 'toggle_audio'],['type' => 'callback', 'text' => 'الصوت', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateVideos ? "🔴" : "🟢", 'payload' => 'toggle_video'],['type' => 'callback', 'text' => 'الفيديوهات', 'payload' => 'no_action']],

//جديد

[['type' => 'callback', 'text' => $lockStateCo ? "🔴" : "🟢", 'payload' => 'toggle_contact'],['type' => 'callback', 'text' => 'الجهات', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateFi ? "🔴" : "🟢", 'payload' => 'toggle_file'],['type' => 'callback', 'text' => 'الملفات', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateKe ? "🔴" : "🟢", 'payload' => 'toggle_keyboard'],['type' => 'callback', 'text' => 'الكيبورد', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateFo ? "🔴" : "🟢", 'payload' => 'toggle_forward'],['type' => 'callback', 'text' => 'التوجية', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateUs ? "🔴" : "🟢", 'payload' => 'toggle_username'],['type' => 'callback', 'text' => 'اليوزرات', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateHa ? "🔴" : "🟢", 'payload' => 'toggle_hashtag'],['type' => 'callback', 'text' => 'الهاشتاك', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateLi ? "🔴" : "🟢", 'payload' => 'toggle_link'],['type' => 'callback', 'text' => 'الروابط', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateBo ? "🔴" : "🟢", 'payload' => 'toggle_is_bot'],['type' => 'callback', 'text' => 'البوتات', 'payload' => 'no_action']],

[['type' => 'callback', 'text' => $lockStateFsh ? "🔴" : "🟢", 'payload' => 'toggle_offense'],['type' => 'callback', 'text' => 'الفشار', 'payload' => 'no_action']],
        [['type' => 'callback', 'text' => $lockStateFay ? "🔴" : "🟢", 'payload' => 'toggle_spam'],['type' => 'callback', 'text' => 'الفايروس', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateAd ? "🔴" : "🟢", 'payload' => 'toggle_user_added'],['type' => 'callback', 'text' => 'الترحيب', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => $lockStateMs ? "🔴" : "🟢", 'payload' => 'toggle_msg'],['type' => 'callback', 'text' => 'الرسائل', 'payload' => 'no_action']],

        [['type' => 'callback', 'text' => 'اخفاء', 'payload' => 'hig']]
    ];

    edit_value($message_id, $buttons, "•⊱ **شووف قائمة اعدادات الحماية** .
﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎﹎
•⊱ **علامة 🟢 الامـر مسمـوح به** .
•⊱ **علامة 🔴 الامر غير مسموح به** .
•⊱ **اضغط الزر للقفل أو الفتح**👇🏻.");
}

if ((is_admin($user_id, $chatId)) && ($text == "الاعدادات" || $text == "اعدادات" || $text == "ع")) {
    sendSettingsMessage($chatId, $message_id);
} elseif($data){

    switch($data){

//الصور

        case 'toggle_image':
            $currentState = $lock[$chatId]['image'] ?? false;
            updateLockState($chatId, 'image', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//ملصقات
        case 'toggle_sticker':
            $currentState = $lock[$chatId]['sticker'] ?? false;
            updateLockState($chatId, 'sticker', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//فيديوهات

        case 'toggle_video':
            $currentState = $lock[$chatId]['video'] ?? false;
            updateLockState($chatId, 'video', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;
       

//صوت
        case 'toggle_audio':
            $currentState = $lock[$chatId]['audio'] ?? false;
            updateLockState($chatId, 'audio', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;
       

//موقع
        case 'toggle_location':
            $currentState = $lock[$chatId]['location'] ?? false;
            updateLockState($chatId, 'location', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;
       

//جهات
        case 'toggle_contact':
            $currentState = $lock[$chatId]['contact'] ?? false;
            updateLockState($chatId, 'contact', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;
       

//ملفات
        case 'toggle_file':
            $currentState = $lock[$chatId]['file'] ?? false;
            updateLockState($chatId, 'file', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;
       

//كيبورد
        case 'toggle_keyboard':
            $currentState = $lock[$chatId]['keyboard'] ?? false;
            updateLockState($chatId, 'keyboard', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//توجيه
        case 'toggle_forward':
            $currentState = $lock[$chatId]['forward'] ?? false;
            updateLockState($chatId, 'forward', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//يوزرات
        case 'toggle_username':
            $currentState = $lock[$chatId]['username'] ?? false;
            updateLockState($chatId, 'username', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//هاشتاك
        case 'toggle_hashtag':
            $currentState = $lock[$chatId]['hashtag'] ?? false;
            updateLockState($chatId, 'hashtag', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//روابط
        case 'toggle_link':
            $currentState = $lock[$chatId]['link'] ?? false;
            updateLockState($chatId, 'link', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//بوتات
        case 'toggle_is_bot':
            $currentState = $lock[$chatId]['is_bot'] ?? false;
            updateLockState($chatId, 'is_bot', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//فشار
        case 'toggle_offense':
            $currentState = $lock[$chatId]['offense'] ?? false;
            updateLockState($chatId, 'offense', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//فايروس
        case 'toggle_spam':
            $currentState = $lock[$chatId]['spam'] ?? false;
            updateLockState($chatId, 'spam', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;
//الترحيب

        case 'toggle_user_added':
            $currentState = $lock[$chatId]['user_added'] ?? false;
            updateLockState($chatId, 'user_added', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//الرسائل

        case 'toggle_msg':     
            $currentState = $lock[$chatId]['msg'] ?? false;
            updateLockState($chatId, 'msg', !$currentState);
            editSettingsMessage($chatId, $message_id);
            break;

//اخفاء

        case 'hig':

        if($data == "hig" && is_admin($user_id, $chatId)){
                    deleteMessage($message_id);
                }        
            break;

       

       
   }
}


if($reply && $text == "مسح"){
deleteMessage($message_id);
deleteMessage($re_message_id);
}elseif($reply && $text == "تثبيت"){
bot($chatId,['text'=>"**^^⌔︙^^** ^^اعلان تثبيت الرساله تامر 🔹.^^","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]]);
pin($chatId, $re_message_id);
}elseif($text == "الغاء تثبيت" || $text == "الغاء التثبيت"){
bot($chatId,['text'=>"**^^⌔︙^^** ^^تم الغاء تثبيت الرساله يبا 🔹.^^","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]]);
unpin($chatId);
}
if($reply && $text == "كتم" && is_admin($user_id, $chatId)){
if(is_special($re_user_id, $chatId)){
$rankT = rank($re_user_id, $chatId);
bot($chatId,['text'=>"**^^⌔︙^^** ^^ماتكدر كتم تاج راسك الـ $rankT^^ .","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
return false;
}
if(!in_array($re_user_id,$mute[$chatId])){
$mute[$chatId][] = $re_user_id;
file_put_contents("information_/mute".$update_info.".json",json_encode($mute,128|32|256));
bot($chatId,['text'=>"**^^⌔︙^^** ^^العضو : $re_username^^\n**^^⌔︙^^** ^^تـم لصمه ع حلكه وسكت😐   .^^","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}else{
bot($chatId,['text'=>"**⌔︙ العضو تَـم كـتمه من گبل .**","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
}
}
if(!preg_match('#الغاء(.*?)#',$text)){
if(preg_match('#كتم @(.*?)#',$text) && is_admin($user_id, $chatId)){
$user = explode('@', $text)[1];
$infoad = json_decode(file_get_contents("https://botapi.tamtam.chat/chats/".$user."?access_token=".$API_KEY));
$typeuser = $infoad->type;
$user_iduser = $infoad->dialog_with_user->user_id;
$nameuser = $infoad->dialog_with_user->name;
$usernameuser = "@".$infoad->dialog_with_user->username;
if($typeuser == "dialog"){
if(is_special($user_iduser, $chatId)){
$rankT = rank($user_iduser, $chatId);
bot($chatId,['text'=>"**^^⌔︙^^** ^^ماتكدر كتم تاج راسك الـ $rankT^^ .","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
return false;
}
if(!in_array($user_iduser,$mute[$chatId])){
$mute[$chatId][] = $user_iduser;
file_put_contents("information_/mute".$update_info.".json",json_encode($mute,128|32|256));
bot($chatId,['text'=>"**^^⌔︙^^** ^^العضو : $re_username^^\n**^^⌔︙^^** ^^تـم لصمه ع حلكه سكت,"format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
}else{
bot($chatId,['text'=>"**⌔︙ العضو تَـم كـتمه من گبل.**","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
}
}else{
bot($chatId,['text'=>"**⌔︙** عـفواً تأكد من صحة اليوزر 🎟️ .","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}
}
}
if($reply && $text == "الغاء كتم" && is_admin($user_id, $chatId)){
if(in_array($re_user_id,$mute[$chatId])){
$key = array_search($re_user_id,$mute[$chatId]);
unset($mute[$chatId][$key]);
$mute[$chatId] = array_values($mute[$chatId]);
file_put_contents("information_/mute".$update_info.".json",json_encode($mute,128|32|256));
bot($chatId,['text'=>"**^^⌔︙^^** ^^العضو : $re_username^^\n**^^⌔︙^^** ^^تـم فتح ڪتمـهہ تكدر تحجي .^^","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
}else{
bot($chatId,['text'=>"**⌔︙ عـفواً العضو ليس مكـتوم .**","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
}
}
if(preg_match('#الغاء كتم @(.*?)#',$text) && is_admin($user_id, $chatId)){
$user = explode('@', $text)[1];
$infoad = json_decode(file_get_contents("https://botapi.tamtam.chat/chats/".$user."?access_token=".$API_KEY));
$typeuser = $infoad->type;
$user_iduser = $infoad->dialog_with_user->user_id;
$nameuser = $infoad->dialog_with_user->name;
$usernameuser = "@".$infoad->dialog_with_user->username;
if($typeuser == "dialog"){
if(in_array($user_iduser,$mute[$chatId])){
$key = array_search($user_iduser,$mute[$chatId]);
unset($mute[$chatId][$key]);
$mute[$chatId] = array_values($mute[$chatId]);
file_put_contents("information_/mute".$update_info.".json",json_encode($mute,128|32|256));
bot($chatId,['text'=>"**^^⌔︙^^** ^^العضو : $re_username^^\n**^^⌔︙^^** ^^تـم فتح ڪتمـهہ تكدر تحجي .^^","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}else{
bot($chatId,['text'=>"**⌔︙ عـفواً العضو ليس مكـتوم .**","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}
}else{
bot($chatId,['text'=>"**⌔︙** عـفواً تأكد من صحة اليوزر 🎟️ .","format"=>"markdown",
"link"=>["type"=>"reply","mid"=>$message_id]
]);
}
}

if($reply && ($text == "طرد" || $text == "حظر" || $text == "حضر")){
    if(is_Special($user_id, $chatId)){
        if(!is_Special($re_user_id, $chatId)){
            kickChatMember($re_user_id, $chatId);
            bot($chatId,[
                'text'=>"**^^⌔︙^^** ^^العضو : $re_username^^\n**^^⌔︙^^** ^^امشي اطلع برا ادبسز 🩴  .^^",
                'format'=>"markdown",
                'link'=>["type"=>"reply","mid"=>$message_id]
            ]);
        } else {
            $rankT = rank($re_user_id, $chatId);
            bot($chatId,[
                'text'=>"**^^⌔︙^^** ^^عـذراً ماتكدر تطرد عنده رتـبـة $rankT^^ .",
                'format'=>"markdown",
                'link'=>["type"=>"reply","mid"=>$message_id]
            ]);
        }
    } else {
        bot($chatId,[
            'text'=>"**^^⌔︙^^** ^^عـذراً، ليس لديك الصلاحية لاستخدام هذا الأمر لأنك لا تمتلك رتبة في البوت.^^",
            'format'=>"markdown",
            'link'=>["type"=>"reply","mid"=>$message_id]
        ]);
    }
}


$A1 = array("  سؤال ينرفزك ؟🖤"," كلمه توجهها لسندباد ؟","  أكثر شيء تغيّر في أسلوب حياتك بعد كورونا ؟💞💘","  لعبة بجوالك تلعبها دايم ؟","   فيه بحياتك شخص روحه مميزة ؟","  اكثر مكان تروحه لحالك ؟"," جرح الحبيب ولا جرح الصديق ؟?", "   شي تعترف انك فاشل فيه ؟💘","  موقف مريت فيه غيّر من حياتك ؟ ","هات كلام لشخص بدون ماتحط اسمه","علمنا عن تجربه خلت شخصيتك اقوى ؟","تصنف نفسك من الاشخاص المبدعين ؟","ممثلك المفضل ؟","تقدر تكتم مشاعرك ؟","اخر فلم دخلت له ف السينما ؟","جمال المكان يعتمد ","شي تعترف انك فاشل فيه ؟","أكبر غلطات عمرك ؟","أكثر شيء يُمكن أن تقدّره في الصداقات ؟","انجاز تفتخر فيه ؟","جملة من أغنية تحبها ؟","شيء مُستحيل يتغير فيك؟","وش ينادونك في البيت ؟","فنانك المفضل ؟","راضي عن نفسك ؟","اكثر ايموجي تستخدمه هالفتره بالكيبورد ؟","موقف خلاك تعصب مره ؟","تقدر تخفي ملامح","امدح نفسك باللغه العربيه الفصحى ؟","أكره شي عندك العناد ولا البرود ؟","كم باقي على عيد ميلادك ؟","متى يخوُنك التعبير  ؟","متى صار التغيير الكبير في شخصيتك ؟","نسبة رضاك عن نفسك من 10 ؟","قولها بلهجتك ( اذهب من امامي ) ؟","شي ودك فيه بس ماتتوقع يصير ؟","كيف تعرفت على أقرب أصحابك ؟","تؤمُن بمقولة إنسان ينسيّك انسان ؟","فكرت مره تنتحر 😂😂 ؟","مع او ضد مقولة ( محد يدوم ل احد ) ؟","‏- تقبل بالعودة لشخص كسر قلبك مرتين؟","‏ تكره أحد من قلبك ؟","لو بتغير اسمك ايش بيكون الجديد ؟"," ‏- للإناث | تقدّم إليكِ رجل مليونير لكنه مُقعد، هل تقبلين به؟","تتوقع أصدقائك الحاليين بكل امانه راح يوقفون معك بوقت الشدة ؟","‏- هل سبق ووقعت في حُب الشخص الخطأ ‏","‏هل تعتقد بان اصدقائك الحاليين هم فعلا اصدقاء؟","لو مسموح لك تقتل ثلاث بحياتك مين هم ؟","اس اللي تحب الهدوء ولا الإزعاج؟ ","   برنامج تكرهه ؟ "," لو فزعت/ي لصديق/ه وقالك مالك دخل وش بتسوي/ين؟ ","   امدح نفسك باللغه العربيه الفصحى ؟ "," ما هو أمنيتك؟ ","متى يوم ميلادك؟ ووش الهدية اللي نفسك فيه؟ "," وين تشوف نفسك بعد خمس سنوات؟ "," وين تشوف نفسك بعد خمس سنوات؟ ","  مكان تتمنى تسكن فيه ؟ ","كيف حال قلبك ؟ بخير ولا مكسور؟ ","لو يسألونك وش اسم امك تجاوبهم ولا تسفل فيهم؟ "," ألطف شخص مر عليك بحياتك؟ ","نسبة النعاس عندك حاليًا؟ ","وش مشروبك المفضل؟ او قهوتك المفضلة؟ "," كذبت في الاسئلة اللي مرت عليك قبل شوي؟ "," متى اخر مره قريت قرآن؟ "," اكبر غلطة بعمرك؟ "," أخر شي اكلته وش هو؟ "," قد جربت الدخان بحياتك؟ انلكفت ولا؟ "," إيموجي يوصف مزاجك حاليًا؟ "," عندك أصحاب كثير؟ ولا ينعد بالأصابع؟ ","تفضل التيكن او السنقل؟ "," لو زعلت بقوة وش بيرضيك ؟ "," وش برجك؟ "," لو قالو لك تتخلى عن شي واحد تحبه بحياتك وش يكون؟ "," أفضل أكلة تحبه لك؟ "," شيء جميل صار لك اليوم ؟ "," وش مشروبك المفضل؟ "," ردّك على شخص قال (أنا بطلع من حياتك)؟. "," كم فلوسك حاليا وهل يكفيك ام لا؟ "," اذا شفت احد على غلط تعلمه الصح ولا تخليه بكيفه؟ "," وش اجمل لهجة تشوفها؟ "," اذا قالو لك تسافر أي مكان تبيه وتاخذ معك شخص واحد وين بتروح ومين تختار؟ "," اكثر كذبة تقولها؟ "," بالعادة متى تنام؟ "," لو عندك فلوس وش السيارة اللي بتشتريها؟ "," عندك الشخص اللي يقلب الدنيا عشان زعلك؟ "," شيء تشوفه اكثر من اهلك ؟ "," دايم قوة الصداقة تكون بإيش؟ "," لو الجنسية حسب ملامحك وش بتكون جنسيتك؟ ","تحب تطق الميانة ولا ثقيل؟ "," اول حرف من اسم شخص تقوله? بطل تفكر فيني ابي انام؟ "," أنت بعلاقة حب الحين؟ ","الغيرة الزائدة شك؟ ولا زياده الحب؟ ","لو أغمضت عينيك الآن فما هو أول شيء ستفكر به؟ ","مع او ضد : النوم افضل حل لـ مشاكل الحياة؟ "," فُرصه تتمنى لو أُتيحت لك ؟ ","لقيت الشخص اللي يفهمك واللي يقرا افكارك؟ ","جربت شعور احد يحبك بس انت مو قادر تحبه؟ "," كم مره حبيت؟ "," من الناس اللي تحب الهدوء ولا الإزعاج؟ ","   برنامج تكرهه ؟ "," لو فزعت/ي لصديق/ه وقالك مالك دخل وش بتسوي/ين؟ ","   امدح نفسك باللغه العربيه الفصحى ؟ "," ما هو أمنيتك؟ ","متى يوم ميلادك؟ ووش الهدية اللي نفسك فيه؟ "," وين تشوف نفسك بعد خمس سنوات؟ "," وين تشوف نفسك بعد خمس سنوات؟ ","  مكان تتمنى تسكن فيه ؟ ","كيف حال قلبك ؟ بخير ولا مكسور؟ ","لو يسألونك وش اسم امك تجاوبهم ولا تسفل فيهم؟ "," ألطف شخص مر عليك بحياتك؟ ","نسبة النعاس عندك حاليًا؟ ","وش مشروبك المفضل؟ او قهوتك المفضلة؟ "," كذبت في الاسئلة اللي مرت عليك قبل شوي؟ "," متى اخر مره قريت قرآن؟ "," اكبر غلطة بعمرك؟ "," أخر شي اكلته وش هو؟ "," قد جربت الدخان بحياتك؟ انلكفت ولا؟ "," إيموجي يوصف مزاجك حاليًا؟ "," عندك أصحاب كثير؟ ولا ينعد بالأصابع؟ ","تفضل التيكن او السنقل؟ "," لو زعلت بقوة وش بيرضيك ؟ "," وش برجك؟ "," لو قالو لك تتخلى عن شي واحد تحبه بحياتك وش يكون؟ "," أفضل أكلة تحبه لك؟ "," شيء جميل صار لك اليوم ؟ "," وش مشروبك المفضل؟ "," ردّك على شخص قال (أنا بطلع من حياتك)؟. "," كم فلوسك حاليا وهل يكفيك ام لا؟ "," اذا شفت احد على غلط تعلمه الصح ولا تخليه بكيفه؟ "," وش اجمل لهجة تشوفها؟ "," اذا قالو لك تسافر أي مكان تبيه وتاخذ معك شخص واحد وين بتروح ومين تختار؟ "," اكثر كذبة تقولها؟ "," بالعادة متى تنام؟ "," لو عندك فلوس وش السيارة اللي بتشتريها؟ "," عندك الشخص اللي يقلب الدنيا عشان زعلك؟ "," شيء تشوفه اكثر من اهلك ؟ "," دايم قوة الصداقة تكون بإيش؟ "," لو الجنسية حسب ملامحك وش بتكون جنسيتك؟ ","تحب تطق الميانة ولا ثقيل؟ "," اول حرف من اسم شخص تقوله? بطل تفكر فيني ابي انام؟ "," أنت بعلاقة حب الحين؟ ","الغيرة الزائدة شك؟ ولا زياده الحب؟ ","لو أغمضت عينيك الآن فما هو أول شيء ستفكر به؟ ","مع او ضد : النوم افضل حل لـ مشاكل الحياة؟ "," فُرصه تتمنى لو أُتيحت لك ؟ "," اخر همك في الحياة ؟","  أكثر شيء تغيّر في أسلوب حياتك بعد كورونا ؟💞💘","  لعبة بجوالك تلعبها دايم ؟","   فيه بحياتك شخص روحه مميزة ؟","  اكثر مكان تروحه لحالك ؟"," جرح الحبيب ولا جرح الصديق ؟?", "   شي تعترف انك فاشل فيه ؟💘","  موقف مريت فيه غيّر من حياتك ؟ ","هات كلام لشخص بدون ماتحط اسمه","علمنا عن تجربه خلت شخصيتك اقوى ؟","تصنف نفسك من الاشخاص المبدعين ؟","ممثلك المفضل ؟","تقدر تكتم مشاعرك ؟","اخر فلم دخلت له ف السينما ؟","جمال المكان يعتمد ","شي تعترف انك فاشل فيه ؟","أكبر غلطات عمرك ؟","أكثر شيء يُمكن أن تقدّره في الصداقات ؟","انجاز تفتخر فيه ؟","جملة من أغنية تحبها ؟","شيء مُستحيل يتغير فيك؟","وش ينادونك في البيت ؟","فنانك المفضل ؟","راضي عن نفسك ؟","اكثر ايموجي تستخدمه هالفتره بالكيبورد ؟","موقف خلاك تعصب مره ؟","تقدر تخفي ملامح","امدح نفسك باللغه العربيه الفصحى ؟","أكره شي عندك العناد ولا البرود ؟","كم باقي على عيد ميلادك ؟","متى يخوُنك التعبير  ؟","متى صار التغيير الكبير في شخصيتك ؟","نسبة رضاك عن نفسك من 10 ؟","قولها بلهجتك ( اذهب من امامي ) ؟","شي ودك فيه بس ماتتوقع يصير ؟","كيف تعرفت على أقرب أصحابك ؟","تؤمُن بمقولة إنسان ينسيّك انسان ؟","فكرت مره تنتحر 😂😂 ؟","مع او ضد مقولة ( محد يدوم ل احد ) ؟","‏- تقبل بالعودة لشخص كسر قلبك مرتين؟","‏ تكره أحد من قلبك ؟","لو بتغير اسمك ايش بيكون الجديد ؟"," ‏- للإناث | تقدّم إليكِ رجل مليونير لكنه مُقعد، هل تقبلين به؟","تتوقع أصدقائك الحاليين بكل امانه راح يوقفون معك بوقت الشدة ؟","‏- هل سبق ووقعت في حُب الشخص الخطأ ‏","‏هل تعتقد بان اصدقائك الحاليين هم فعلا اصدقاء؟","لو مسموح لك تقتل ثلاث بحياتك مين هم ؟ "," أكثر جملة أثرت بك في حياتك؟ "," لو جاء شخص وعترف لك كيف ترده؟ "," إحساسك في هاللحظة؟ "," عندك شخص تسميه ثالث والدينك؟ ","ما الحاسة التي تريد إضافتها للحواس الخمسة؟ "," اسم قريب لقلبك؟ "," وش الإسم اللي دايم تحطه بالبرامج؟ "," من الناس اللي تتغزل بالكل ولا بالشخص اللي تحبه بس؟ "," نسبه الندم عندك للي وثقت فيهم ؟ "," شكد صارلك بل تام ؟ "," ككم مرة خانوك ؟ "," اخر مرة اتصلت كام وي منو ؟ "," اذا تزوجت شكد ناوي تخلف جهال ؟ "," دخلت وي احد علمود مصلحة ؟ "," ما هي نقاط الضعف في شخصيتك؟ "," أفضل ممارسة بالنسبة لك؟ "," كم أعلى مبلغ جمعته؟ "," انسان م تحب تتعامل معاه ابداً ؟ "," كيف علاقتك مع اهلك؟ رسميات ولا ميانة؟ "," وش الي تفكر فيه الحين؟ "," لو المقصود يقرأ وش بتكتب له؟ "," أطول مدة نمت فيها كم ساعة؟"," انت من الناس المؤدبة ولا نص نص؟ "," عندك اصدقاء غير جنسك؟ "," برأيك كم العمر المناسب للزواج؟ "," عمرك بكيت على شخص مات في مسلسل ؟ "," تتوقع إنك بتتزوج اللي تحبه؟ "," فيه شيء م تقدر تسيطر عليه ؟ "," كيف هي أحوال قلبك؟ "," لو صار سوء فهم بينك وبين شخص هل تحب توضحه ولا تخليه كذا  لان مالك خلق توضح ؟ "," العلاقه السريه دايماً تكون حلوه؟ "," ما أول مشروع تتوقع أن تقوم بإنشائه إذا أصبحت مليونير؟ "," ردّك على شخص قال (أنا بطلع من حياتك)؟. "," أفضل صفة تحبه بنفسك؟ "," ألطف شخص مر عليك بحياتك؟ "," الصداقة ولا الحب؟ "," تتقبل النصيحة من اي شخص؟ "," تنام بـ اي مكان ، ولا بس غرفتك ؟ "," اول طفل الك شنو تسمي ؟ "," شيء جميل صار لك اليوم ؟ ","عادي تتزوج من برا المدينه؟ "," اول ماتصحى من النوم مين تكلمه؟ "," اكتب تاريخ مستحيل تنساه "," وش اسم اول شخص تعرفت عليه فلتام ؟ "," مع او ضد : يسقط جمال المراة بسبب قبح لسانها؟ "," وش حاب تقول للاشخاص اللي بيدخل حياتك؟ "," أطول مكالمة كم ساعة؟","لو خيروك تصير مليونير ولا تتزوج الشخص اللي تحبه؟ "," أفضل وقت للسفر؟ الليل ولا النهار؟ "," لو الشخص اللي تحبه قال بدخل حساباتك بتعطيه ولا تكرشه؟ "," حزنك يبان بملامحك ولا صوتك؟ "," عندك الشخص اللي يكتب لك كلام كثير وانت نايم؟ "," أجمل مدينة؟ ","  اطول علاقة كنت فيها مع شخص؟"," وش نوع جوالك؟ واذا بتغيره وش بتأخذ؟ "," اخر مره بكيت ؟ "," تحب تعبر بالكتابة ولا بالصوت؟ "," شيء مستحيل انك تاكله ؟ "," اذا غلطت وعرفت انك غلطان تحب تعترف ولا تجحد؟ ","  مين اول شخص تكلمه اذا طحت بـ مصيبة ؟ "," أجمل اسم بنت بحرف الباء؟ "," اجمل دولة بنظرك ؟ "," كم مره خانوك ؟ "," عمرك زحفت لشخص ؟ "," منو تتمنى يمك ؟ "," أغلب وقتك تكون وين؟ "," كلمة تقولها للوالدين؟ ","‏- هل تعتقد أن هنالك من يراقبك بشغف؟ "," قد تمنيت شي وتحقق؟ "," تحبني ولاتحب الفلوس؟ "," شيء مستحيل ترفضه ؟. "," تحب الفلوس ؟ "," تحب السفر ؟ "," اخر مكالمة وي منو جانت ؟"," اخر علاقة شوكت انتهت ؟"," ناوي تدخل علاقة ؟ "," معجب بشخص ؟"," تحب من طرف واحد ؟ ","تعرف الله يحبك ؟"," تعرف المطور سندبود", "تعرف المطور انس؟", "تعرف المطور حماده؟", "تعرف المطور سندباد ؟؟");
if($text =="كت" or $text == "تويت"){
$mesho = array_rand($A1, 1);
bot($chatId,['text'=>$A1[$mesho],"link"=>["type"=>"reply","mid"=>$message_id]]);
}

$RRRX = array("$text : 77% 🤍","$text : 70% 🎊","$text : 85% 💖","$text : 99% ❤️‍🔥","$text : 30% 💞","$text : 15% روح موت💔","$text : 47% 🦋","$text : 90% ✨","$text : 34% متحبك يحمار🌚");
if(preg_match('#نسبة الحب#',$text) or preg_match('#نسبه الحب#',$text) or 
preg_match('#نسبة حب#',$text) or
preg_match('#نسبه حب#',$text)){
$RRRX3 = array_rand($RRRX, 1);
bot($chatId,[
'text' =>$RRRX[$RRRX3],"link"=>["type"=>"reply","mid"=>$message_id]
]);
}

if($text == "تحبني" ){
bot($chatId,[
'text'=> "**^^افيش اموت بربك^^🤍🥹**.","format"=>"markdown","link"=>["type"=>"reply","mid"=>$message_id]
]);
}

if($text == "هلو" ){
bot($chatId,[
'text'=> "**^^ههـلاهَ يـنـضر عيـني^^**","format"=>"markdown","link"=>
["type"=>"reply","mid"=>$message_id]
]);
}

if($text == "السلام عليكم " ){
bot($chatId,[
'text'=> "**^^عليكم السلام ورحمة الله ^^**","format"=>"markdown","link"=>
["type"=>"reply","mid"=>$message_id]
]);
}

if($text == "هلاو" ){
bot($chatId,[
'text'=> "^^**ههـلاهَ يـنـضر عيـني**^^","format"=>"markdown","link"=>
["type"=>"reply","mid"=>$message_id]
]);
}

if($text == "هلا" ){
bot($chatId,[
'text'=> "^^**ههـلاهَ يـنـضر عيـني**^^","format"=>"markdown","link"=>
["type"=>"reply","mid"=>$message_id]
]);
}

if($text == "احبك" ){
bot($chatId,[
'text'=> "^^**فـديـَت الـيحبـني .🙊**^^","format"=>"markdown","link"=>
["type"=>"reply","mid"=>$message_id]
]);
}

if($text == "مح"or $text == "محح" or $text == "مححح" or $text == "محححح"or $text == "مححححح" or $text == "محه" or $text == "مححه" ){
bot($chatId,[
'text'=> "**ههَوفف م اتـحمل هلعسل .😩🥹**","format"=>"markdown","link"=>
["type"=>"reply","mid"=>$message_id]
]);
}

}



// داخل مجموعه

if(!$lock[$chatId]["replies"]){
    if($replies[$chatId]["text"][$text]){
        bot($chatId, [
            'text' => "**^^" . $replies[$chatId]["text"][$text] . "^^**",
            'link' => ["type"=>"reply", "mid"=>$message_id],
            'format' => "markdown"
        ]);
    }
}

if($replies[$chatId]["audio"][$text]){
bot($chatId,['text'=>"This is voice of the reply:",'attachments'=>[['type'=>'audio','payload'=>['token'=>$replies[$chatId]["audio"][$text]]]],"link"=>["type"=>"reply","mid"=>$message_id]]);
}



$lock2 = json_decode(file_get_contents("info/lock.json"));
$eer = $lock2->$chatId->sticker;
$eer2 = $lock2->$chatId->contact;
$eer3 = $lock2->$chatId->image;
$eer4 = $lock2->$chatId->audio;
$eer5 = $lock2->$chatId->location;
$eer6 = $lock2->$chatId->file;
$eer7 = $lock2->$chatId->video;
$eer8 = $lock2->$chatId->keyboard;
$eer9 = $lock2->$chatId->forward;
$eer10 = $lock2->$chatId->msg;
$eer11 = $lock2->$chatId->spam;



if(in_array($user_id,$mute[$chatId])){
deleteMessage($message_id);
}
if(!is_special($user_id, $chatId)){



if($message){  
    switch ($eer10) {
        case 'true':
deleteMessage($message_id);
            break;
}}

if($typddse == "sticker"){  
    switch ($eer) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if($typddse == "contact"){  
    switch ($eer2) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if($typddse == "image"){  
    switch ($eer3) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if($typddse == "audio"){  
    switch ($eer4) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if($typddse == "location"){  
    switch ($eer5) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if($typddse == "file"){  
    switch ($eer6) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if($typddse == "video"){  
    switch ($eer7) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if($typddse == "keyboard"){  
    switch ($eer8) {
        case 'true':
deleteMessage($message_id);
            break;
}}
$forward =$message->link->type;
if($forward == "forward"){  
    switch ($eer9) {
        case 'true':
deleteMessage($message_id);

            break;
}}
if(strstr($text ,"@") == true && $lock[$chatId]["username"]){
deleteMessage($message_id);
}
if(strstr($text ,"#") == true && $lock[$chatId]["hashtag"]){
deleteMessage($message_id);
}
if($text && $lock[$chatId]["link"] && (strpos($text,'tt.me') or strpos($text,'telegram.me') or strpos($text,"t.me") or strpos($text,'T.me') or strpos($text,"T.Me") or strpos($text,"T.ME") or strpos($text,'.com') or strpos($text,"Telegram.me") or strpos($text,'://') or strpos($text,'www.') or strpos($text,".org") or strpos($text,'.online') or strpos($text,".net") or strpos($text,'.ml') or strpos($text,'.cf') or strpos($text,"http") or strpos($text,'https') or strpos($text,"HTTP"))!== false){
deleteMessage($message_id);
}
if($is_bot == "true" && $lock[$chatId]["is_bot"]){
deleteMessage($message_id);
}
if(preg_match("/(گواد)|(نيچ)|(كس)|(گس)|(عير)|(گواد)|(كواد)|(كحب)|(گحب)|(قواد)|(طيز)|(فرخ)|(منيو)|(نيج)|(نيق)|(نيك)|(دحب)|(ديس)|(مصه)|(تنح)|(طوبز)|(فروخ)|(واويد)|(مناوي)|(عيوره)/",str_replace(['َ','ٕ','ُ','ُ','ِ','ٓ','ٰ','ٖ','ٔ','ْ','ٍ','ٌ','ٌ','ّ','ً','ـ','_','*','.'], null,$text)) && $lock[$chatId]["offense"]){
deleteMessage($message_id);
}
}

if($text && $lock[$chatId]["spam"]){
$plus = mb_strlen("$text");
if($text && 1000 < $plus or $plus < 0 or (strpos($text,'▓▓▓▓') or strpos($text,'●●●●') or strpos($text,"★✯✯★") or strpos($text,'═════') or strpos($text,"8.ꡓ.8.ꡓ.8.") or strpos($text,"鯳闦鱍") or strpos($text,'💣阝') or strpos($text,"鯿鰚📌🔪闪") or strpos($text,'伶〇〇侺') or strpos($text,'ぽぼ💿ぬぱざそ') or strpos($text,"ゑ💊💊ぽぼ") or strpos($text,'伶〇〇侺') or strpos($text,"💀輏陋") or strpos($text,'ぬぱざそ') or strpos($text,'ha: medal :') or strpos($text,"💉💉💉💉💉💉") or strpos($text,'ttݩ.ttݩ.ttݩ') or strpos($text,"鯿鰚📌🔪闪")or strpos($text,"نt.نt.نt.نt."))!== false){
kickChatMember($user_id, $chatId);
deleteMessage($message_id);
bot($chatId,['text'=>"› الاسم :  $name .\n› لترسل فايروس يا غبي بـ🩴  👞"]);
}
}



//// Dev ///

if(in_array($user_id,$as)){
    if($text == "/start"){
        unset($settings[$user_id]);
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        $ff = [
            [['type' => 'callback', 'text' =>'تعيين اسم البوت بالمجموعات', 'payload' =>"Edgbot"]],
            [['type' => 'callback', 'text' =>'اذاعه بالخاص', 'payload' =>"cse"],['type' => 'callback', 'text' =>"اذاعه بالمجموعات", 'payload' =>"cse2"]],
            [['type' => 'callback', 'text' =>"الاشتراك الاجباري", 'payload' =>"cs"],['type' => 'callback', 'text' =>'الاحصائيات', 'payload' =>"infoM"]],
        ];
        bobt($user_id,['text' =>"• اهلا بك عزيزي المطور .",
            "link"=>["type"=>"reply",
            "mid"=>$message_id,],
            'attachments' =>[['type' => 'inline_keyboard','payload'=>['buttons'=>$ff,]]],
        ]);
    }
    
    if($data == "cle"){
        unset($settings[$user_id]);
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        $ff = [
            [['type' => 'callback', 'text' =>'تعيين اسم البوت بالمجموعات', 'payload' =>"Edgbot"]],
            [['type' => 'callback', 'text' =>'اذاعه بالخاص', 'payload' =>"cse"],['type' => 'callback', 'text' =>"اذاعه بالمجموعات", 'payload' =>"cse2"]],
            [['type' => 'callback', 'text' =>"الاشتراك الاجباري", 'payload' =>"cs"],['type' => 'callback', 'text' =>'الاحصائيات', 'payload' =>"infoM"]],
        ];
        edit_value($message_id, $ff,"• اهلا بك عزيزي المطور .");
    }
    
    if($data == "infoM"){
        $ff = [
            [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle']],
        ];
        edit_value($message_id, $ff,"• احصائيات ( @".$userBot." )\n______\n- عدد الاعضاء :  ".count(explode("\n",file_get_contents("information_/id".$update_info.".txt")))."\n______\n- عدد المجموعات :  ".count($groups["groups"]));
    }
    
    $delch = explode('#',$data);
    if($delch[0] == "delch"){
        unset($Adminset["Channels"][$delch[1]]);
        $Adminset["Channels"] = array_values($Adminset["Channels"]);
        file_put_contents("information_/Ad".$update_info.".json",json_encode($Adminset,128|32|256));
        $ff = [
            [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle']],
        ];
        edit_value($message_id, $ff,'تم حذف القناه بنجاح');
    }
    
    if ($text && $settings[$user_id]["type"] == "csaddChannel" && !$data){
        $isb_info = json_decode(file_get_contents('https://botapi.tamtam.chat/me?access_token='.$API_KEY));
        $user_idBot = $isb_info->user_id; 
        $chats_info = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$text.'?access_token='.$API_KEY));
        $getstrpos = json_decode(file_get_contents('https://botapi.tamtam.chat/chats/'.$chats_info->chat_id.'/members?access_token='.$API_KEY.'&user_ids='.$user_idBot));
        if($getstrpos->members[0]->is_admin){
            $ff = [
                [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cs']],
            ];
            bobt($user_id,['text' =>"•  تم اضافه قناتك بنجاح",
                "link"=>["type"=>"reply",
                "mid"=>$message_id,],
                'attachments' =>[['type' => 'inline_keyboard','payload'=>['buttons'=>$ff,]]],
            ]);
            $Adminset["Channels"][] = [
                'id'=>$chats_info->chat_id,
                'title'=>mb_strimwidth($chats_info->title,0, 12, ".."),
                "url"=>$chats_info->link
            ];
            file_put_contents("information_/Ad".$update_info.".json",json_encode($Adminset,128|32|256));
            $settings[$user_id]["type"] = false;
            $settings[$user_id][$user_id] = false;
            file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        }else{
            $ff = [
                [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cs']],
            ];
            bobt($user_id,['text' =>"• حدث خطأ ما  تأكد من المعروف او من رفعي ادمن في القناة ⚠️",
                "link"=>["type"=>"reply",
                "mid"=>$message_id],
                'attachments' =>[['type' => 'inline_keyboard','payload'=>['buttons'=>$ff,]]],
            ]);
        }
    }
    
    if($data == "csaddChannel"){
        $settings[$user_id]["type"] = "csaddChannel";
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        $ff = [
            [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle']],
        ];
        edit_value($message_id, $ff,"قم برفع ( @".$usernameBot." ) مشرف بالقناه ثم ارسال معرف القناه مثال\n@culi");
    }
    
    if($data == "cs"){
        ViewChannels($user_id,$message_id);
    }
    
    if ($text && $settings[$user_id]["type"] == "cse" && !$data){
        unset($settings[$user_id]);
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        bobt($user_id,['text' =>"• جار الاذاعه الى الخاص 🔆"]);
        for($j=0;$j<count(explode("\n",file_get_contents("information_/id".$update_info.".txt"))); $j++){
            bobt(explode("\n",file_get_contents("information_/id".$update_info.".txt"))[$j],['text'=>$text]);
        }
        bobt($user_id,['text' =>"تم الاذاعه بنجاح ✅"]);
    }
    
    if($data == "cse"){
        $settings[$user_id]["type"] = "cse";
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        $ff = [
            [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle']],
        ];
        edit_value($message_id, $ff,"• ارسل رسالتك الان .");
    }
    
    if ($text && $settings[$user_id]["type"] == "cse2" && !$data){
        unset($settings[$user_id]);
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        bobt($user_id,['text' =>"• جار الاذاعه الى المجموعات 🔆"]);
        for($j=0;$j<count(explode("\n",file_get_contents("information_/id".$update_info.".txt"))); $j++){
            bot($groups["groups"][$j],['text'=>$text]);
        }
        bobt($user_id,['text' =>"تم الاذاعه بنجاح ✅"]);
    }
    
    if($data == "cse2"){
        $settings[$user_id]["type"] = "cse2";
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        $ff = [
            [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle']],
        ];
        edit_value($message_id, $ff,"• ارسل رسالتك الان .");
    }
    
    if ($text && $settings[$user_id]["type"] == "Edgbot" && !$data){
        unset($settings[$user_id]);
        $settings["nbot"] = $text;
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        bobt($user_id,['text' =>"تم حفظ اسم البوت بنجاح ( $text ) ✅"]);
    }
    
    if($data == "Edgbot"){
        $settings[$user_id]["type"] = "Edgbot";
        file_put_contents("information_/st".$update_info.".json",json_encode($settings,128|32|256));
        $ff = [
            [['type' => 'callback', 'text' => '🔙 رجوع', 'payload' => 'cle']],
        ];
        edit_value($message_id, $ff,"• ارسل اسم البوت حاليا هو بأسم ( حماده ) .");
    }
}




$is_rank = rank($user_id, $chatId);
$linktext = $message->link->message->text;
$forward =$message->link->type;

if(mb_strlen($linktext) >= 1000 and $forward == "forward" and $is_rank == "مميز"){  
    switch ($eer11) {
        case 'true':
deleteMessage($message_id);
kickChatMember($user_id, $chatId);
            break;
}}


if(mb_strlen($linktext) >= 1000 and $forward != "forward" and $is_rank == "مميز"){  
    switch ($eer11) {
        case 'true':
deleteMessage($message_id);
kickChatMember($user_id, $chatId);
            break;
}}





if(mb_strlen($linktext) >= 1000 and $forward == "forward" and $is_rank == "عضو"){  
    switch ($eer11) {
        case 'true':
deleteMessage($message_id);
kickChatMember($user_id, $chatId);
            break;
}}


if(mb_strlen($linktext) >= 1000 and $forward != "forward" and $is_rank == "عضو"){  
    switch ($eer11) {
        case 'true':
deleteMessage($message_id);
kickChatMember($user_id, $chatId);
            break;
}}

function Send($chat, $meh, $data) {
        $url = "https://botapi.tamtam.chat/" . $meh . "?access_token=" . API_KEY . "&chat_id=" . $chat;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
    function getMembers($chat_id) {
        $url = 'https://botapi.tamtam.chat/chats/' . $chat_id . '/members?access_token=' . API_KEY;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }
    function addMember($chat_id, $user_id) {
        $url = 'https://botapi.tamtam.chat/chats/' . $chat_id . '/members?access_token=' . API_KEY;
        $data = ['user_ids' => [$user_id]];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $res = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode >= 200 && $httpcode < 300);
    }



$update2 = json_decode(file_get_contents('php://input'));
$message = $update2->message ?? null;
$text = $message->body->text ?? null;
$chat_id = $message->recipient->chat_id ?? null;
$mid = $message->body->mid ?? null;

$rrrx = [
    'ضيف', 'أضافة', 'اضافة',
    'اضافه', 'أضافه', 'أضافه', 'ظيف'
];

if ($text) {
    $parts = explode(' ', trim($text), 2);
    $cmd = trim($parts[0]);
 
    if (in_array($cmd, $rrrx)) {
        if (count($parts) < 2) {
            Send($chat_id, 'messages', [
                'text' => 'يرجى كتابة الأمر بشكل صحيح: ضيف @username',
                'link' => ['type' => 'reply', 'mid' => $mid]
            ]);
            return;
        }
        
        $input = trim($parts[1]);
        $username = $input;
        
        $userId = null;

        if (isset($message->body->markup)) {
            foreach ($message->body->markup as $entity) {
                if ($entity->type == 'user_mention' && isset($entity->user_id)) {
                    $mentionedText = mb_substr($text, $entity->from, $entity->length, 'UTF-8');
                    if ($mentionedText === $input) {
                        $userId = $entity->user_id;
                        break;
                    }
                }
            }
        }

        if (!$userId && is_numeric($input)) {
            $userId = (int)$input;
            $username = "@" . $userId;
        }

        if (!$userId) {
            Send($chat_id, 'messages', [
                'text' => "تعذر العثور على المستخدم {$username}",
                'link' => ['type' => 'reply', 'mid' => $mid]
            ]);
            return;
        }

        $members = getMembers($chat_id);
        if (isset($members['members'])) {
            foreach ($members['members'] as $member) {
                if ($member['user_id'] == $userId) {
                    Send($chat_id, 'messages', [
                        'text' => "المستخدم {$username} موجود في المجموعة بالفعل",
                        'link' => ['type' => 'reply', 'mid' => $mid]
                    ]);
                    return;
                }
            }
        }

        if (addMember($chat_id, $userId)) {
            Send($chat_id, 'messages', [
                'text' => "تمت إضافة {$username} بنجاح",
                'link' => ['type' => 'reply', 'mid' => $mid]
            ]);
        } else {
            Send($chat_id, 'messages', [
                'text' => "فشل في إضافة {$username}",
                'link' => ['type' => 'reply', 'mid' => $mid]
            ]);
        }
    }
}

if($is_bot){
exit();
}
?>