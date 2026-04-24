# 🎓 Edu Platform — منصة تعليمية

منصة تعليمية مبنية على **Laravel 12** و**Filament 3.2**، تدعم:
- إدارة المواد الدراسية (Subjects) والدروس (Lessons)
- لوحة تحكم باللغة العربية (RTL)
- مصادقة مستخدمين عبر Laravel Breeze
- نظام نقاط ومكافآت للطلاب

---

## 🚀 المتطلبات

| المتطلب | الإصدار |
|---|---|
| PHP | ^8.2 |
| Composer | ^2.x |
| Node.js | ^20 (يُنصح) |
| NPM | ^10 |
| SQLite / MySQL / PostgreSQL | — |

---

## ⚙️ التثبيت والإعداد السريع

```bash
# 1. استنسخ المستودع
git clone https://github.com/adel1426/edu-platform.git
cd edu-platform

# 2. شغّل سكريبت الإعداد التلقائي
composer setup

# 3. أنشئ مستخدم admin للوحة Filament
php artisan make:filament-user

# 4. شغّل الخوادم (سيرفر + vite معاً)
composer dev
```

بعد ذلك افتح المتصفح على:
- **الموقع الرئيسي:** http://localhost:8000
- **لوحة التحكم:** http://localhost:8000/admin

---

## 📁 هيكل المشروع

```
app/
├── Filament/Resources/        # موارد لوحة Filament
│   ├── SubjectResource.php    # إدارة المواد الدراسية
│   └── LessonResource.php     # إدارة الدروس
├── Models/
│   ├── Subject.php            # نموذج المادة
│   ├── Lesson.php             # نموذج الدرس
│   └── User.php               # يُطبّق FilamentUser
└── Providers/Filament/
    └── AdminPanelProvider.php # إعدادات اللوحة + RTL
```

---

## 🛠️ الأوامر المفيدة

```bash
# تطبيق migrations
php artisan migrate

# تشغيل seeders
php artisan db:seed

# إنشاء مستخدم admin
php artisan make:filament-user

# بناء الأصول للإنتاج
npm run build

# التطوير المباشر
npm run dev

# الاختبارات
composer test
```

---

## 🧪 البنية التقنية

- **Tailwind CSS v4** (CSS-first config عبر `@tailwindcss/vite`)
- **Alpine.js** لتفاعلية الواجهة الأمامية
- **Livewire** (مضمّن مع Filament)
- **SQLite** افتراضياً (يمكن تغييره في `.env`)

---

## 📄 الترخيص

MIT
