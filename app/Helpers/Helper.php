<?php

namespace App\Helpers;

use Exception;

class Helper
{
    const CREATE_SUCCESS_TEXT = "Kayıt oluşturma işleminiz başarıyla gerçekleştirilmiştir.";
    const CREATE_FAILED_TEXT = "Kayıt oluşturulurken bir hatayla karşılaşıldı. Lütfen daha sonra tekrar deneyiniz.";

    const READ_SUCCESS_TEXT = "Kayıt listeleme işlemi başarılı.";
    const READ_FAILED_TEXT = "Kayıt listeleme işlemi başarısız.";

    const UPDATE_SUCCESS_TEXT = "Kayıt güncelleme işleminiz başarıyla gerçekleştirilmiştir.";
    const UPDATE_FAILED_TEXT = "Kayıt güncelleştirilirken bir hatayla karşılaşıldı. Lütfen daha sonra tekrar deneyiniz.";

    const DELETE_SUCCESS_TEXT = "Kayıt silme işleminiz başarıyla gerçekleştirilmiştir.";
    const DELETE_FAILED_TEXT = "Kayıt silinirken bir hatayla karşılaşıldı. Lütfen daha sonra tekrar deneyiniz.";

    const AUTH_SUCCESS_TEXT = "Oturum açma işlemi başarılı.";
    const AUTH_FAILED_TEXT = "Oturum açma işlemi başarısız.";
    const AUTH_EXPIRED_TOKEN = "Oturumunuzun süresi dolmuştur.";
    const AUTH_LOGOUT_SUCCESS_TEXT = "Oturum kapatma işlemi başarılı.";
    const AUTH_LOGOUT_FAILED_TEXT = "Oturum kapatma işlemi başarısız.";

    const USER_DOES_NOT_EXIST = "Kayıtlı kullanıcı bulunamadı.";

    public const USER_ROLE_CUSTOMER = 'customer';
    public const USER_ROLE_ADMIN = 'admin';


    public const C000 = "C000"; // Kayıt Ekleme İşlemi Başarılı
    public const C001 = "C001"; // Kayıt Ekleme İşlemi Başarısız (Mesajı göster)
    public const C002 = "C002"; // Kayıt Ekleme İşlemi Başarısız (Mesajı gösterme)

    public const R000 = "R000"; // Kayıt Çekme İşlemi Başarılı
    public const R001 = "R001"; // Kayıt Çekme İşlemi Başarısız (Mesajı göster)
    public const R002 = "R002"; // Kayıt Çekme İşlemi Başarısız (Mesajı gösterme)

    public const U000 = "U000"; // Kayıt Güncelleme İşlemi Başarılı
    public const U001 = "U001"; // Kayıt Güncelleme İşlemi Başarısız (Mesajı göster)
    public const U002 = "U002"; // Kayıt Güncelleme İşlemi Başarısız (Mesajı göster)

    public const D000 = "D000"; // Kayıt Silme İşlemi Başarılı
    public const D001 = "D001"; // Kayıt Silme İşlemi Başarısız (Mesajı göster)
    public const D002 = "D002"; // Kayıt Silme İşlemi Başarısız (Mesajı göster)

    public const A000 = "A000"; // Auth işlemi başarılı
    public const A001 = "A001"; // Auth işlemi başarısız (Mesajı göster)
    public const A002 = "A002"; // Auth işlemi başarısız (Yetkisiz işlem)
    public const A003 = "A003"; // Auth işlemi başarısız (Süresi dolmuş token)
    public const A004 = "A004"; // Auth işlemi başarısız (Pasif kullanıcı)

    public const S000 = "S000"; // Rastgele Başarılı data + mesaj
    public const S001 = "S001"; // Rastgele Başarısız data + mesaj
    public const S002 = "S002"; // Sistem Hatası
    public const S003 = "S003"; // Validasyon Hatası

    public static function gelfOutput(mixed $data, bool $success = true, string $message = '', string $code = ''): array
    {
        return [
            'success' => $success,
            'message' => $message,
            'code' => $code,
            'data' => $data
        ];
    }


}