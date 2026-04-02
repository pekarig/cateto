# Laravel 13 Cateto - Production Deployment Guide

## ⚠️ FONTOS - PHP 8.3 Konfiguráció
**Minden `php` parancs a `/usr/bin/php83` binárist használja!**

A szerveren a PHP 8.3 elérési útja: `/usr/bin/php83`
- Composer: `/usr/bin/php83 ~/composer.phar`
- Artisan: `/usr/bin/php83 artisan`

## 📋 Követelmények
- PHP 8.3.0 vagy újabb ✅ (Elérési út: `/usr/bin/php83`)
- Composer telepítve ✅ (~/composer.phar)
- MySQL adatbázis
- SSH hozzáférés ✅
- Node.js 18+ (lokálisan build-hez)

## 🗂️ Mappa struktúra a szerveren

```
/web/eglogic/
├── backend/           ← Laravel app teljes forrása (Git clone ide)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/        ← Composer install ide
│   ├── .env           ← Production .env
│   ├── artisan
│   └── composer.json
│
└── cateto/            ← PUBLIC document root (cateto.net domain)
    ├── index.php      ← Módosított (lent részletezve)
    ├── .htaccess      ← Másold az eredeti public/.htaccess-ből
    ├── robots.txt
    ├── assets/        ← Statikus CSS/JS
    ├── build/         ← Vite build output
    ├── fonts/
    ├── images/
    ├── storage/       ← Symlink a storage/app/public-hoz
    │   └── (icons, ai-icons, stb.)
    └── video/
```

---

## 🚀 Telepítési lépések

### 1️⃣ LOKÁLIS ELŐKÉSZÜLETEK

#### A) Build végrehajtása
```bash
cd C:\xampp\htdocs\cateto
npm install
npm run build
```
Ez létrehozza a `public/build` mappát.

#### B) Git commit ellenőrzése
```bash
git status
git add -A
git commit -m "Production build ready"
git push origin main
```

---

### 2️⃣ SZERVER - ALAPTELEPÍTÉS

#### A) Bejelentkezés SSH-n
```bash
ssh your-username@your-server.com
cd /web/eglogic
```

#### B) Laravel projekt klónozása
```bash
git clone https://github.com/pekarig/cateto.git backend
cd backend
```

#### C) Composer telepítése (ha még nincs)

**⚠️ Ha már van ~/composer.phar, ugord át ezt a lépést!**

```bash
cd ~
/usr/bin/php83 -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
/usr/bin/php83 composer-setup.php
/usr/bin/php83 -r "unlink('composer-setup.php');"
```

Ez létrehozza a `~/composer.phar` fájlt.

#### D) Composer dependencies telepítése
```bash
cd /web/eglogic/backend

# composer.phar használata
/usr/bin/php83 ~/composer.phar install --no-dev --optimize-autoloader

# Vagy ha globális composer van a PATH-ban
composer install --no-dev --optimize-autoloader
```

⏱️ **Ez eltarthat néhány percig!**

---

### 3️⃣ .ENV FÁJL LÉTREHOZÁSA

#### A) .env másolása és szerkesztése
```bash
cd /web/eglogic/backend
cp .env.example .env
nano .env
```

#### B) .env tartalom (PRODUCTION)

```env
# === ALAPBEÁLLÍTÁSOK ===
APP_NAME="Cateto Portfolio"
APP_ENV=production
APP_KEY=base64:... # Majd a következő lépésben generálod!
APP_DEBUG=false
APP_URL=https://cateto.net

APP_LOCALE=hu
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=hu_HU

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

# === LOGGING ===
LOG_CHANNEL=stack
LOG_STACK=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# === ADATBÁZIS (CSERÉLD KI!) ===
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # Ha "No such file or directory" hiba: használj 127.0.0.1-et (NE localhost!)
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
# DB_SOCKET=/var/run/mysqld/mysqld.sock  # Opcionális: ha localhost-ot használsz

# === SESSION ===
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.cateto.net

# === CACHE ===
CACHE_STORE=database
CACHE_PREFIX=cateto_

# === QUEUE ===
QUEUE_CONNECTION=database

# === MAIL (opcionális - később) ===
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@cateto.net"
MAIL_FROM_NAME="${APP_NAME}"

# === FILAMENT ===
FILAMENT_PATH=admin
```

Mentsd: `Ctrl+O`, `Enter`, kilépés: `Ctrl+X`

---

### 4️⃣ APP_KEY GENERÁLÁS

```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan key:generate
```

Ez automatikusan beírja az APP_KEY-t az .env-be.

---

### 5️⃣ STORAGE ÉS CACHE MAPPÁK BEÁLLÍTÁSA

```bash
cd /web/eglogic/backend

# Jogosultságok beállítása
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Ha szükséges, storage almappák létrehozása
mkdir -p storage/framework/sessions
mkdir -p storage/framework/cache
mkdir -p storage/framework/views
mkdir -p storage/logs
```

---

### 6️⃣ ADATBÁZIS MIGRÁLÁS

```bash
cd /web/eglogic/backend

# Migráció futtatása (FIGYELEM: ez létrehozza a táblákat!)
/usr/bin/php83 artisan migrate --force

# Cache build
/usr/bin/php83 artisan optimize
/usr/bin/php83 artisan route:cache
/usr/bin/php83 artisan config:cache
/usr/bin/php83 artisan view:cache
/usr/bin/php83 artisan filament:cache-components
```

---

### 7️⃣ STORAGE LINK LÉTREHOZÁSA

```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan storage:link
```

Ez a `backend/public/storage` → `backend/storage/app/public` symlink-et hoz létre.

**AZONBAN** neked a `/web/eglogic/cateto/storage` → `/web/eglogic/backend/storage/app/public` symlink kell!

```bash
cd /web/eglogic/cateto
ln -s ../backend/storage/app/public storage
```

---

### 8️⃣ PUBLIC MAPPA TARTALOM MÁSOLÁSA

#### A) Statikus fájlok másolása
```bash
cd /web/eglogic/backend/public

# Másold át a cateto/ (document root) mappába az összes fájlt KIVÉVE index.php
cp -r assets ../../../cateto/
cp -r build ../../../cateto/
cp -r fonts ../../../cateto/
cp -r images ../../../cateto/
cp -r video ../../../cateto/
cp -r puzzle-images ../../../cateto/
cp -r vendor ../../../cateto/
cp .htaccess ../../../cateto/
cp robots.txt ../../../cateto/
cp favicon.ico ../../../cateto/ # ha van
```

#### B) .htaccess ellenőrzése
```bash
nano /web/eglogic/cateto/.htaccess
```

Tartalom (Laravel default):
```apache
<IfModule mod_negotiation.c>
    Options -MultiViews -Indexes
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### 9️⃣ INDEX.PHP MÓDOSÍTÁSA (KRITIKUS!)

#### A) Új index.php létrehozása
```bash
nano /web/eglogic/cateto/index.php
```

#### B) index.php tartalom:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../backend/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../backend/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../backend/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

**Változások az eredetihez képest:**
- `__DIR__.'/../storage'` → `__DIR__.'/../backend/storage'`
- `__DIR__.'/../vendor'` → `__DIR__.'/../backend/vendor'`
- `__DIR__.'/../bootstrap'` → `__DIR__.'/../backend/bootstrap'`

Mentsd: `Ctrl+O`, `Enter`, kilépés: `Ctrl+X`

---

### 🔟 FILAMENT ADMIN USER LÉTREHOZÁSA

#### A) Új admin user létrehozása (ha még nincs)

```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan make:filament-user
```

Vagy használd az AdminUserSeeder-t:
```bash
/usr/bin/php83 artisan db:seed --class=AdminUserSeeder
```

#### B) Meglévő admin user módosítása (email + jelszó csere)

**⚠️ Először ellenőrizd, milyen user-ek vannak az adatbázisban:**
```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan tinker --execute="
App\Models\User::all()->each(function(\$u) { 
    echo 'ID: ' . \$u->id . ' | Email: ' . \$u->email . ' | Név: ' . \$u->name . PHP_EOL; 
});
"
```

**Módszer 1: ID alapján (legegyszerűbb - ha tudod az admin user ID-jét)**
```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan tinker --execute="
\$user = App\Models\User::find(1);
\$user->name = 'Admin';
\$user->email = 'uj-email@example.com';
\$user->password = Hash::make('uj-jelszo123');
\$user->save();
echo 'Admin user frissítve!' . PHP_EOL;
"
```

**Módszer 2: Email alapján (ha tudod a jelenlegi email címet)**
```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan tinker --execute="
\$user = App\Models\User::where('email', 'jelenlegi-email@example.com')->first();
\$user->name = 'Admin';
\$user->email = 'uj-email@example.com';
\$user->password = Hash::make('uj-jelszo123');
\$user->save();
echo 'Admin user frissítve!' . PHP_EOL;
"
```

**Módszer 3: Tinker interaktív használata**
```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan tinker
```

Majd a tinker promptban:
```php
$user = App\Models\User::find(1);  // vagy where('email', '...')->first()
$user->name = 'Admin';
$user->email = 'uj-email@example.com';
$user->password = Hash::make('uj-jelszo123');
$user->save();
exit
```

**Módszer 4: SQL közvetlen (ha MySQL hozzáférésed van)**
```bash
mysql -u your_user -p your_database
```
```sql
UPDATE users 
SET email = 'uj-email@example.com', 
    password = '$2y$12$...' -- A jelszót külön kell hash-elni!
WHERE id = 1;
```
⚠️ **Fontos**: 
- SQL-nél a jelszót előbb le kell hash-elni! Használd inkább a Tinker módszert.
- Email cím keresésnél győződj meg róla, hogy létezik user azzal az email címmel!

---

### 1️⃣1️⃣ CACHE ÉS JOGOSULTSÁGOK FINOMÍTÁSA

```bash
cd /web/eglogic/backend

# Laravel optimalizálás production-re
/usr/bin/php83 artisan optimize

# Storage jogok újra
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Filament cache
/usr/bin/php83 artisan filament:cache-components
```

---

### 1️⃣2️⃣ TESZTELÉS

#### A) Böngészőben
- https://cateto.net → Főoldal betöltődik?
- https://cateto.net/admin → Filament bejelentkezés működik?

### B) Hibaelhárítás

### Cashe-k törlése és optimalizálás
```bash
cd /web/eglogic/backend

/usr/bin/php83 artisan cache:clear
/usr/bin/php83 artisan config:clear
/usr/bin/php83 artisan route:clear
/usr/bin/php83 artisan view:clear
/usr/bin/php83 artisan filament:clear-cache
/usr/bin/php83 artisan optimize:clear
/usr/bin/php83 artisan optimize
```

### Ha "500 Internal Server Error":
```bash
# Nézd meg a Laravel log-ot
tail -f /web/eglogic/backend/storage/logs/laravel.log

# Vagy a szerver hibalog-ot
tail -f /var/log/apache2/error.log  # vagy nginx: /var/log/nginx/error.log
```

Gyakori hibák:
- **Storage jogok**: `chmod -R 775 storage bootstrap/cache`
- **.env nem jó**: Ellenőrizd az adatbázis adatokat
- **APP_KEY hiányzik**: `php artisan key:generate`
- **Cache régi**: `php artisan optimize:clear`

---

## 🔄 FRISSÍTÉS (Git pull után)

```bash
cd /web/eglogic/backend

# 1. Git pull
git pull origin main

# 2. Composer update (ha composer.json változott)
/usr/bin/php83 ~/composer.phar install --no-dev --optimize-autoloader

# 3. Migráció (ha új táblák vannak)
/usr/bin/php83 artisan migrate --force

# 4. Cache clear + build
/usr/bin/php83 artisan optimize:clear
/usr/bin/php83 artisan optimize
/usr/bin/php83 artisan filament:cache-components

# 5. Statikus fájlok (ha public/-ban változott valami)
# Lokálisan: npm run build
# Szerveren: másold át a build mappát
cp -r public/build ../../../cateto/
```

---

## ⚠️ GIT KONFLIKTUSOK KEZELÉSE

### Probléma: "Your local changes would be overwritten by merge"

```bash
eglogic@s15:~/backend$ git pull origin main
error: Your local changes to the following files would be overwritten by merge:
       resources/views/components/footer.blade.php
       resources/views/components/header.blade.php
Please, commit your changes or stash them before you can merge.
Aborting
```

### Megoldás 1: Változások ellenőrzése és eldobása (AJÁNLOTT ha nem módosítottál semmit)

```bash
cd ~/backend

# 1. Nézd meg, mi a különbség (opcionális)
git diff resources/views/components/footer.blade.php | head -20
git diff resources/views/components/header.blade.php | head -20

# 2. Ha csak whitespace/line ending különbségek (nem fontos):
# Változások eldobása
git checkout -- resources/views/components/footer.blade.php
git checkout -- resources/views/components/header.blade.php

# 3. Most már megy a pull
git pull origin main

# 4. Cache tisztítás
/usr/bin/php83 artisan config:cache
/usr/bin/php83 artisan view:clear
```

### Megoldás 2: Változások mentése (stash)

Ha bizonytalan vagy, hogy fontosak-e a változások:

```bash
cd ~/backend

# 1. Lokális változások mentése
git stash save "Lokális footer és header módosítások - $(date +%Y-%m-%d)"

# 2. Pull
git pull origin main

# 3. Változások visszaállítása (ha szükséges)
git stash list  # Megnézed, mi van elmentve
git stash pop   # Visszaállítod (lehet konfliktus!)

# Ha konfliktus van, manuálisan feloldod:
nano resources/views/components/footer.blade.php
git add resources/views/components/footer.blade.php
git stash drop
```

### Megoldás 3: Teljes reset (VESZÉLYES! Minden lokális változás elveszik!)

```bash
cd ~/backend

# FIGYELEM: Ez törli az ÖSSZES lokális módosítást!
git fetch origin
git reset --hard origin/main

# Cache tisztítás
/usr/bin/php83 artisan optimize:clear
/usr/bin/php83 artisan optimize
```

---

## 🔧 LINE ENDING PROBLÉMÁK MEGELŐZÉSE

Ha gyakran látod a "Your local changes would be overwritten" hibát anélkül, hogy módosítottál volna bármit, valószínűleg **line ending (CRLF vs LF)** vagy **whitespace** különbségek okozzák.

### Megoldás: .gitattributes fájl hozzáadása

**A projekt gyökerében hozd létre a `.gitattributes` fájlt (ez már megtörtént a projektben):**

```bash
# Helyi gépen (Windows):
cd C:\xampp\htdocs\cateto

# Fájl létrehozása
cat > .gitattributes << 'EOF'
# Auto detect text files and perform LF normalization
* text=auto

# PHP files - always use LF
*.php text eol=lf

# Blade templates - always use LF
*.blade.php text eol=lf

# Web files
*.css text eol=lf
*.js text eol=lf
*.json text eol=lf
*.md text eol=lf
*.html text eol=lf
*.xml text eol=lf

# Config files
*.yml text eol=lf
*.yaml text eol=lf
.env* text eol=lf
.gitignore text eol=lf
.gitattributes text eol=lf

# Binary files
*.png binary
*.jpg binary
*.jpeg binary
*.gif binary
*.ico binary
*.svg binary
*.woff binary
*.woff2 binary
*.ttf binary
*.eot binary
EOF

# Commit és push
git add .gitattributes
git commit -m "Add .gitattributes for consistent line endings"
git push origin main
```

**Szerveren ezután:**
```bash
cd ~/backend
git pull origin main

# Git újranormalizálása (opcionális, ha korábbi fájlok rosszak)
git add --renormalize .
git status  # Ha mutat változásokat, commit-old
```

**Ez biztosítja, hogy:**
- Windows (CRLF) és Linux (LF) között is konzisztens legyen a formátum
- Git automatikusan LF-re normalizál minden text fájlt
- Nincs felesleges "phantom" módosítás a szerveroldali pull során

---

## 📊 KÉPEK/IKONOK FELTÖLTÉSE

Az alábbi mappák tartalma:
- `storage/app/public/icons/` (Web Service ikonok)
- `storage/app/public/ai-icons/` (AI Tools ikonok)

**Módszer 1: SCP (lokális gépről)**
```bash
# Windows (PowerShell vagy Git Bash)
scp -r C:\xampp\htdocs\cateto\storage\app\public\icons user@server:/web/eglogic/backend/storage/app/public/
scp -r C:\xampp\htdocs\cateto\storage\app\public\ai-icons user@server:/web/eglogic/backend/storage/app/public/
```

**Módszer 2: Git (ha nem túl nagy fájlok)**
Commit-old lokálisan és pull-old a szerveren.

**Módszer 3: FTP/SFTP kliens**
FileZilla, WinSCP stb.

---

## ✅ CHECKLIST

- [ ] PHP 8.3+ telepítve és beállítva (`/usr/bin/php83`)
- [ ] Composer dependencies telepítve (`/usr/bin/php83 ~/composer.phar install`)
- [ ] .env fájl létrehozva és kitöltve (DB adatok!)
- [ ] APP_KEY generálva (`/usr/bin/php83 artisan key:generate`)
- [ ] **Adatbázis kapcsolat tesztelve** (lásd "Adatbázis kapcsolódás tesztelése" részt)
- [ ] Storage/cache mappák jogosultságai (775)
- [ ] Adatbázis migrálva (`/usr/bin/php83 artisan migrate`)
- [ ] Storage link létrehozva
- [ ] Public fájlok átmásolva (assets, build, images stb.)
- [ ] index.php módosítva (backend relatív útvonalakkal)
- [ ] .htaccess átmásolva
- [ ] Cache build-elve (`/usr/bin/php83 artisan optimize`)
- [ ] Filament admin user létrehozva
- [ ] Ikonok/képek feltöltve
- [ ] Teszt: https://cateto.net betöltődik
- [ ] Teszt: https://cateto.net/admin működik

---

## 🆘 GYAKORI HIBÁK ÉS MEGOLDÁSOK

### "500 Internal Server Error"
```bash
# 1. Laravel log ellenőrzése
tail -50 /web/eglogic/backend/storage/logs/laravel.log

# 2. Jogosultságok
chmod -R 775 storage bootstrap/cache

# 3. Cache törlés
/usr/bin/php83 artisan optimize:clear
```

### "Class not found" hibák
```bash
# Composer autoload újragenerálás
/usr/bin/php83 ~/composer.phar dump-autoload --optimize
```

### "No application encryption key has been specified"
```bash
/usr/bin/php83 artisan key:generate
```

### Képek/ikonok nem jelennek meg
```bash
# Storage link ellenőrzése
ls -la /web/eglogic/cateto/storage

# Ha nem symlink, hozd létre:
cd /web/eglogic/cateto
ln -s ../backend/storage/app/public storage
```

### CSS/JS nem tölt be
```bash
# Ellenőrizd a build mappát
ls -la /web/eglogic/cateto/build

# Ha hiányzik, másold át:
cp -r /web/eglogic/backend/public/build /web/eglogic/cateto/
```

### "SQLSTATE[HY000] [2002] No such file or directory" - MySQL kapcsolódási hiba
```bash
# 1. Módszer: Használj 127.0.0.1-et localhost helyett
nano /web/eglogic/backend/.env
```
Változtasd:
```env
DB_HOST=127.0.0.1  # NE localhost!
```

```bash
# 2. Módszer: MySQL socket útvonal megadása (ha localhost-ot akarsz használni)
# Találd meg a socket útvonalat:
mysql_config --socket
# vagy
mysqladmin variables | grep socket

# Majd add hozzá a .env-hez:
# DB_SOCKET=/var/run/mysqld/mysqld.sock  # vagy /tmp/mysql.sock
```

```bash
# 3. Cache clear (FONTOS a .env változtatás után!)
cd /web/eglogic/backend
/usr/bin/php83 artisan config:clear
/usr/bin/php83 artisan cache:clear
```

### Adatbázis kapcsolódás tesztelése
```bash
cd /web/eglogic/backend
/usr/bin/php83 artisan tinker --execute="
try {
    \DB::connection()->getPdo();
    echo 'Kapcsolódás sikeres!' . PHP_EOL;
} catch (\Exception \$e) {
    echo 'Kapcsolódási hiba: ' . \$e->getMessage() . PHP_EOL;
}
"
```

---

## 📌 FONTOS MEGJEGYZÉSEK

1. **NE commit-old az .env fájlt** GitHubra (már a .gitignore-ban van)
2. **Vendor mappát ne commit-old** (composer install készíti)
3. **Node_modules-t ne tölts fel** (build output elég)
4. **Storage mappát ne commit-old** (kivéve a .gitkeep fájlokat)
5. **Debug módot kapcsold ki production-ben**: `APP_DEBUG=false`
6. **HTTPS-t használj**: Let's Encrypt SSL tanúsítvány ajánlott

---

## 🎯 ÖSSZEFOGLALÁS

1. **Lokál**: Build (`npm run build`) + Git push
2. **Szerver**: Git clone → Composer install → .env + key:generate
3. **Adatbázis**: Migrate + cache
4. **Public**: Fájlok másolása + index.php módosítás
5. **Storage**: Symlink + jogosultságok
6. **Teszt**: cateto.net + admin működik

🚀 **Sikeres telepítést!**
