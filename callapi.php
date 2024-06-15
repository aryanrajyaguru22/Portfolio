<?php
class SendRequest{
    function setJsonEmail($email,$name,$email_of_applicant,$subject,$message){
        $message_string="There is a new inquery on your website the data is : 
                            name : $name<br>
                            email : $email_of_applicant<br>
                            subject : $subject<br>
                            message : $message<br>";
        $arr1= json_encode(array(
                                    "api_key"=>"need 69",
                                    "type"=>"3",
                                    "from_email"=>"vidya.gmit@gmail.com",
                                    "application_pass"=>"uwrxrdoyqcrbgecb",
                                    "message"=>"A new inquery on your website",
                                    "subject"=>"Inquery on Website",
                                    array("email"=>"$email")));
        return $arr1;
    }
    function sendRequest($jsonArray)
    {
        // echo $jsonArray;
        // echo http_build_query(array("json" => $jsonArray));
        $url = 'https://maillooper.000webhostapp.com/mailer.php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);

        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonArray);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array("json" => $jsonArray)));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        // echo $response;


        // Check for errors
        if ($response === false) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        curl_close($ch);

        $jsonRes = $response;
        // echo $jsonRes;

        // $jsonAsoc = json_decode($jsonRes,true);            
        
        return json_decode($jsonRes,true);
    }
}
?>