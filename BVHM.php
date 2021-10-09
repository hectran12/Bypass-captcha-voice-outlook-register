<?php

print "File voice: ";
$VOICE = trim(fgets(STDIN));

$LOCVOICE = LOCVOICE($VOICE); 

$RSSS = GIAI($LOCVOICE["hypotheses"][0]["utterance"]);
print "CODE: ".$RSSS;
function LOCVOICE ($FILE)
{
  $CURL = curl_init("https://api.fpt.ai/hmi/asr/general");
  $HEADER = array(
    "api-key: {YOUR_API_KEY_FPT.AI}"
  );
  $PROT   = array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_CUSTOMREQUEST  => "POST",
    CURLOPT_POSTFIELDS     => array("filename" => file_get_contents($FILE)),
    CURLOPT_HTTPHEADER     => $HEADER
  );
  curl_setopt_array($CURL, $PROT);
  $ACCESS = curl_exec($CURL);
  return json_decode($ACCESS,TRUE);
}
function CHANGE_INTEGER($str)
{
  
  $STRING_VAR = ["KHÔNG","MỘT","HAI","BA","BỐN","NĂM","SÁU","BẢY","TÁM","CHÍN","MƯỜI"];
  $STRING     = mb_strtoupper($str,"UTF-8");
  $NON = explode(' ', $STRING);
  $RES = NULL;
  foreach ($NON as $STRING)
  {
  $IN_ARRAY   = in_array($STRING, $STRING_VAR);
  if($IN_ARRAY == 1)
  {
    for($v=0;$v<=count($STRING_VAR)-1;$v++)
    {
      if ($STRING == $STRING_VAR[$v])
      {
         $RES .= $v;
      }
    }
  } else {
    $RES .= $STRING;
  }
 
}
return $RES;
}
function GIAI($char)
{
  $STR_CHAR = strlen($char);
  $STR = preg_replace('/[@\.\;\?\-\&\$\%\#]+/', '', $char);
  return CHANGE_INTEGER($STR);
}
?>