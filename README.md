# Liman Ders Bilgi Sistemi

Liman MYS altyapısı kullanılarak sistem yöneticisi, akademisyen ve öğrencilerin kullanabileceği temel düzeyde bir Ders Bilgi Sistemi eklentisi.

## Liman DBS Nedir?
- Projemizde Liman Merkezi Yönetim Sistemi’nin altyapılarını kullanarak sistem yöneticisi,
akademisyen ve öğrencilerin kullanabileceği temel düzeyde bir Ders Bilgi Sistemi (DBS)
platformu oluşturmayı amaçladık.
- Ders Bilgi Sistemi kapsamında sistem yöneticilerinin ders oluşturup akademisyenlere
atamasını, öğrencilerin ise bu derslerden dilediklerini talep etmesini sağladık. Akademisyenlere
ise öğrencilerin bu taleplerini onaylama veya reddetme seçeneklerini sunarak altyapımızı
zenginleştirdik.

## DBS Sistemi için Liman MYS Kullanmak
- Temelde Liman MYS farklı sunucular üzerinde eklenti geliştirilmesi ve bu sunucuların
yönetilmesine dayanan bir sistem olsa da biz bu projede Liman’a kullanıcı yönetimi tabanlı
bir eklenti geliştirerek Liman’a farklı bir bakış açısı kazandırdık.
- Liman’ın gerek bünyesinde barındırdığı kullanıcı özelliği ve izin alternatifleri gerekse
veritabanı yapısı DBS sistemi için fazlasıyla avantaj sağlamaktaydı. Biz de Liman’ın bu ve
daha birçok kolaylığından yararlanarak DBS platformlarına Liman üzerinde bir alternatif
geliştirmesinde bulunduk.

## DBS Sistemi için Liman MYS Avantajları
- Detaylı Kullanıcı Yönetimi
- Rol Grupları ve Yetkilendirmeleri
- Güvenlik
- Bildirim Sistemi
- Eklenti Altyapısı ve Barındırdığı Fonksiyonlar
- Arayüz Olanakları

## DBS Ortamı ve Kullanılan Teknolojiler
Ders Bilgi Sistemi platformumuzda sistemin yönetilmesi için Liman MYS dışında farklı
teknolojiler de kullanmaktayız. Platformda temel olarak
- DBS verilerinin ve bildirimlerinin tutulması için PostgreSQL veritabanı,
Veritabanı sistemine erişim ve VT işlemleri (okuma, yazma, düzenleme) için Golang
dilinde geliştirdiğimiz API ve çok sayıda Golang kütüphaneleri,
- Bilgilerin Liman arayüzünde sağlıklı ve kullanıcı dostu şekilde sunulabilmesi için VueJS
kütüphanesi
kullanılmış ve bunlar haricinde pek çok teknolojiden yararlanılmıştır

## Sistemsel Proje Mimarisi
![diyagram](https://user-images.githubusercontent.com/55782131/169019370-7644f107-3502-4f0e-be18-6172a875482d.png)

## Kullanıcı İşlemleri
![kullanici_islemleri](https://user-images.githubusercontent.com/55782131/169019705-0fcaff45-b46b-4f9f-9e61-856cc53cf4b5.png)


Ali Buğra OKKALI - Fatih Arslan TUGAY
