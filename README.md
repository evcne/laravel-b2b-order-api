✅ Laravel Test Case: "B2B Sipariş Yönetimi API"

🎯 Amaç

Adayın Laravel framework üzerinde REST API geliştirme, authentication, role-based erişim, Eloquent ilişkiler, pivot kullanımı ve cache becerilerini değerlendirmek.

🧩 Senaryo

Bir B2B platformunda müşteri kullanıcılarının ürünleri görüntüleyip sipariş verebildiği basit bir sistem geliştirilmesi beklenmektedir.

👤 Kullanıcı Rolleri

Rol	Yetkiler

admin	    Tüm kullanıcıları ve siparişleri görebilir, ürün yönetebilir

customer	    Sadece kendi siparişlerini görebilir ve yeni sipariş oluşturabilir

📘 Modeller

1. User
Alanlar: name, email, password, role (admin veya customer)

2. Product
Alanlar: name, sku, price, stock_quantity

3. Order
Alanlar: user_id, status (pending, approved, shipped), total_price

4. OrderItem (Pivot)
Alanlar: order_id, product_id, quantity, unit_price


🔧 Beklenen API Özellikleri

1. Authentication

Laravel Sanctum ya da Laravel Passport kullanılmalı
Aşağıdaki endpoint'ler oluşturulmalı:
POST /api/register
POST /api/login

3. Authorization

Role-based erişim sağlanmalı (middleware veya policy kullanımıyla)

4. Ürün İşlemleri
Endpoint	Erişim
GET /api/products	Herkes erişebilir
✅ Bu endpoint cache’lenmeli (file cache yeterli, Redis kullanımı artı puandır)
POST /api/products	Sadece admin
PUT /api/products/{id}	Sadece admin
DELETE /api/products/{id}	Sadece admin

5. Sipariş İşlemleri
Endpoint	Açıklama
GET /api/orders	Admin tüm siparişleri, müşteri sadece kendi siparişlerini görebilmeli
POST /api/orders	Müşteri yeni sipariş oluşturmalı
GET /api/orders/{id}	Yalnızca yetkili kullanıcı erişebilmeli

🔁 Pivot Model Kullanımı
Sipariş oluşturulurken birden fazla ürün içerecek şekilde veri gönderilmelidir.

Örnek JSON payload:

{
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 3, "quantity": 1 }
  ]
}

🚀 Projeyi Çalıştırma Talimatları


### Gereksinimler

- Docker & Docker Compose
- Git

### Adım Adım Kurulum

1. **Projeyi Klonlayın:**
   git clone https://github.com/evcne/laravel-b2b-order-api.git
   cd laravel-b2b-order-api

2. **Ortam Dosyasını Oluşturun:**
   cp .env.example .env
   
3. **Uygulamayı Docker ile Başlatın:**
   docker-compose up -d --build
   
4. **Container'a Bağlanın ve Composer Kurulumlarını Yapın:**
   docker exec -it app bash
    composer install
    php artisan key:generate
    php artisan migrate --seed
   
5. **Postman collection kullanarak çalıştırın:**


### Test Kullanıcıları 
- admin_test@gmail.com
- password : 123456
- musteri_test@gmail.com
- password: 123456
   
   
