<?php

include '../ayarlar/baglan.php';

if(isset($_GET['p'])){
    
    if($_GET['p']=='aday_sira'){
        
        if(is_array($_POST['item'])){
    foreach ($_POST['item'] as $key => $value){
        
        $ayarkaydet=$db->prepare("UPDATE aday SET
                aday_sira=:aday_sira 
            WHERE aday_id={$value}");
            $guncelle=$ayarkaydet->execute(array(
                'aday_sira' => $key
            ));
    }
    $returnMsg = array('islemSonuc' => true, 'islemMsj' => 'Güncellendi');
        } else {
            $returnMsg=array('islemSonuc' => fallse, 'islemMsj' => 'İşlem Başarısız');
        }
    }
}
if(isset($returnMsg)){
    echo json_encode($returnMsg);
}

?>