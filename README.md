# Seçim Anket

Seçim anketi şahsi geliştirmeye çalıştığım bir scripttir.
Bu script içeriğinde kullanıcı istediği adaya e-mail veya sms ile oy verebilecektir.
Oy verme işlemi e-mail veya sms ile yapılırken onay kodu alarak doğrulama üzerinden gerçekleştirilir.
Yönetim paneli tarafında adaylar tarafında adayları sürekle&bırak yaparak sıralamasını değiştirebilme aday görseli,adı düzenleme silme ve aday ekleme
işlemleri yapılabilmektedir.
Ayar kısmında ayar ekleme,düzenleme,silme işlemleri yapılabilmektedir.

##Sms işlemleri
Kullandığınız sistemin bir apisi muhtemelen vardır fakat burda kullanılan api ileti merkezine aittir.
Burada üyeliğiniz var ise bilgileri gereken yerleri girmeniz yeterli olacaktır.


###Class IMVerify {
############const IM_PUBLIC_KEY = 'xxxx'; // Iletimerkezi api public key, panel ustunden olusturabilirsiniz.############
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

####im = new IMVerify();
$im->send($gsm); // Kullanicinin telefonuna dogrulama kodunu uretir ve gonderir.


## Seçim Anket
[https://i.hizliresim.com/VDllAZ.jpg]
"Seçim Anket Görünümü")

##Seçim Anket Demo 
[https://secimanket.salihbozdemir.com/]

## Dahil olan pluginler vs. :
* Bootstrap
* Font Awesome
* jQuery
* JQuery-UI
* JQuery-input-mask-phone-number
* PHP Mailer



