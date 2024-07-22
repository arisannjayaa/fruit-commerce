
# Bu Jem Jem Project




## Spesifiakasi Sistem

**Versi Php:** 7.0 - 8.1

**Server:** Mysqli, Codeigniter 3


## Instalasi


Tata Cara Instalasi :

```bash
  Copy .env.example menjadi .env
```

```bash
  Buat database terlebih dahulu
```

```bash
  Ubah variabel env sesuai dengan data yang diperlukan
  
  DB_CONNECTION=mysqli
  DB_HOST=localhost
  DB_DATABASE=database
  DB_USERNAME=username
  DB_PASSWORD=password

  MIDTRANS_SERVER=
  MIDTRANS_CLIENT=
```


```bash
  Lalu jalankan composer untuk menginstall package yang diperlukan

  composer install
```

```bash
  Lakukan migration database dengan mengakses url dibawah ini pada web browser

  http://domain.test/migrate
```

```bash
  Selesai
```
