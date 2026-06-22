# online-store
# 🛍️ المتجر الإلكتروني — Online Store

متجر إلكتروني مصغر مبني بـ PHP وMySQL يتيح للمستخدمين تصفح المنتجات وإتمام الطلبات، مع لوحة تحكم كاملة للمسؤول.

---

## 📌 فكرة المشروع

يهدف المشروع إلى توفير منصة تسوق إلكتروني بسيطة تحل مشكلة إدارة المنتجات والطلبات والمستخدمين، حيث يستطيع العميل تصفح المنتجات وإضافتها للسلة وإتمام الشراء، بينما يتحكم المسؤول بكل شيء من لوحة تحكم مخصصة.

---

## 🛠️ التقنيات المستخدمة

- PHP
- MySQL
- HTML / CSS
- Bootstrap
- JavaScript

---

## 📁 هيكل المشروع

```
online-store/
├── admin/              # لوحة تحكم المسؤول
│   ├── dashboard.php
│   ├── manage_products.php
│   ├── manage_categories.php
│   ├── manage_orders.php
│   └── manage_users.php
├── auth/               # تسجيل الدخول والخروج
│   ├── login.php
│   ├── logout.php
│   └── register.php
├── assets/             # ملفات CSS و JS والصور
├── database/           # ملف قاعدة البيانات
│   └── online_store.sql
├── includes/           # ملفات مشتركة
│   ├── db.php
│   ├── auth.php
│   ├── header.php
│   └── footer.php
├── pages/              # صفحات الموقع
│   ├── product.php
│   ├── cart.php
│   └── checkout.php
└── index.php           # الصفحة الرئيسية
```

---

## ⚙️ طريقة تشغيل المشروع

1. تأكد أن **XAMPP** مثبت وشغّل Apache وMySQL
2. انسخ المشروع داخل مجلد `C:\xampp\htdocs\online-store`
3. افتح **phpMyAdmin** من المتصفح: `http://localhost/phpmyadmin`
4. أنشئ قاعدة بيانات باسم `online_store`
5. استورد ملف `database/online_store.sql`
6. افتح المشروع من المتصفح: `http://localhost/online-store`

---

## 🔐 بيانات تسجيل الدخول

| النوع | البريد الإلكتروني | كلمة المرور |
|-------|-------------------|-------------|
| مسؤول (Admin) | admin@store.com | password |
| عميل (Customer) | سجّل حساب جديد | - |

---

## 👨‍💻 فريق العمل

- rami-alqadi