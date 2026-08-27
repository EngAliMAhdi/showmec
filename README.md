# showmec

باك اند Laravel لنظام حجز ورشة المكياج (سوار منصور / INGLOT Sally Qadry) مع الدفع عبر **Tranzila**.

## المتطلبات

- PHP 8.3+
- Composer
- SQLite (أو MySQL)

## التثبيت المحلي

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## النشر على السيرفر

```bash
git clone https://github.com/EngAliMAhdi/showmec.git
cd showmec
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan migrate --force
```

ثم وجّه الـ web server (Nginx/Apache) إلى مجلد `public/`، وتأكد من صلاحيات الكتابة على `storage/` و `bootstrap/cache/`.

## الواجهة الأمامية (SPA)

الواجهة الأمامية (React) مبنية كملفات ثابتة ومضمّنة داخل `public/`، فتُقدَّم من نفس الدومين:
- `/` → صفحة المستخدم (صفحة الكورسات)
- `/admin` → لوحة الإدارة (دخول من `/auth` ثم رمز المالك)
- `/api/*` → الباك اند

المصدر موجود في مجلد `COURSE` (أو `ADMIN`) خارج هذا الريبو. لإعادة البناء بعد أي تعديل:

```bash
cd COURSE        # أو ADMIN
npm install
npm run build    # ينتج مجلد dist/
```

ثم انسخ محتوى `dist/` إلى `public/` في هذا المشروع وارفع التحديث.

## الإعدادات المهمة (في `.env`)

| المتغير | الوصف |
| --- | --- |
| `ADMIN_ACCESS_CODE` | رمز المالك لتفعيل صلاحية الإدارة (الافتراضي `owner123`) |
| `DB_CONNECTION` | قاعدة البيانات (`sqlite` أو `mysql`) |
| `MAIL_MAILER` | `log` محلياً، أو `smtp` مع بيانات SMTP للإنتاج |
| `APP_URL` | رابط الباك اند |

## الـ API

- **المصادقة**: `POST /api/auth/register` · `POST /api/auth/login` · `POST /api/auth/logout` · `GET /api/auth/me`
- **الورشة**: `GET /api/workshop/seats` · `GET /api/workshop/seats-left` · `POST /api/registrations` · `POST /api/registrations/status` · `POST /api/registrations/cancel` · `POST /api/waitlist`
- **الدفع (Tranzila)**: `GET /api/payment-orders/{token}` · `POST /api/payments/webhook`
- **الإدارة**: `GET /api/admin/access` · `POST /api/admin/claim` · `GET /api/admin/registrations` · `POST /api/admin/registrations/{id}/resend-invitation`

## الدفع عبر Tranzila

- الرقم الطرفي (Terminal) مضبوط في الواجهة الأمامية (`s1410596`) — غيّره لرقمك الحقيقي.
- الـ webhook: يجب أن يكون `VITE_API_URL` في الواجهة الأمامية رابطاً عاماً يصل إليه Tranzila في الإنتاج.
