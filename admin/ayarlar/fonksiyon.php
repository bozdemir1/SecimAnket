<?php

ob_start();
session_start();
date_default_timezone_set('Europe/Istanbul');

function mailgonder($kullanici_mail, $mailKonu, $mesaj)
{
    $host = "xxxx";
    $pass = "xxxx";
    $from = "xxxx";

    $mail = new PHPMailer();
    $mail->IsSMTP(true);
    $mail->From = $from;
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = 'ssl';
    $mail->Sender = $from;
    $mail->AddAddress($kullanici_mail);
    $mail->AddReplyTo = ($kullanici_mail);
    $mail->FromName = $from;
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';
    $mail->Username = $from;
    $mail->Password = $pass;
    $mail->Subject = $mailKonu;
    $mail->isHTML(true);
    $mail->SetLanguage('tr', '../net/language');
    $mail->Body = "
    $mesaj<hr><br> <p>Anket için size özel kodunuz yukarıda paylaşılmıştır.</p><br>";
    $mail->Send();
}

Class IMVerify {

    const IM_PUBLIC_KEY = 'xxxx'; // Iletimerkezi api public key, panel ustunden olusturabilirsiniz.
    const IM_SECRET_KEY = 'xxxx.'; // Iletimerkezi api secret key, panel ustunden olusturabilirsiniz.
    const IM_SENDER = 'xxxxI'; // Mesajin iletilecegi baslik bilgisi.

    public function send($gsm)
    {


        $text = 'Dogrulama kodunuz: ';
        $p_hash = hash_hmac('sha256', self::IM_PUBLIC_KEY, self::IM_SECRET_KEY);

        $xml = '
        <request>
            <authentication>
                <key>' . self::IM_PUBLIC_KEY . '</key>
                <hash>' . $p_hash . '</hash>
            </authentication>
            <order>
                <sender>' . self::IM_SENDER . '</sender>
                <sendDateTime></sendDateTime>
                <message>
                    <text><![CDATA[' . $text . ']]></text>
                    <receipents>
                        <number>' . $gsm . '</number>
                    </receipents>
                </message>
            </order>
        </request>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.iletimerkezi.com/v1/send-sms');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);

        preg_match_all('|\<code\>.*\<\/code\>|U', $result, $matches, PREG_PATTERN_ORDER);
        if (isset($matches[0]) && isset($matches[0][0]))
        {
            if ($matches[0][0] == '<code>200</code>')
            {
                return true;
            }
        }

        return false;
    }

}

// Birinci adim kullanicinin telefonuna dogrulama kodunun iletilmesi.
$im = new IMVerify();
//$gsm = '5057023100'; //$_POST['telefon']; //Kullanicinin girdigi telefon numarasi -> 5050001122... vb
$im->send($gsm); // Kullanicinin telefonuna dogrulama kodunu uretir ve gonderir.
?>