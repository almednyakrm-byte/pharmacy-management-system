# نظام إدارة صيدليات (المنتجات، الطاقم، الطلبات، الإيرادات)
==========================

## Overview & Project Purpose
---------------------------

نظام إدارة صيدليات هو تطبيق إلكتروني يهدف إلى تسهيل إدارة الصيدليات من خلال توفير أدوات متكاملة لمراقبة المنتجات، والطاقم، والطلبات، والإيرادات. يهدف المشروع إلى تحسين كفاءة إدارة الصيدليات وتحسين تجربة العملاء.

## Project Structure Mapping
---------------------------

### Backend

* `app`: الملفات الرئيسية للبرنامج
* `config`: الإعدادات والقيم الأساسية
* `models`: تعريفات البيانات والجداول
* `routes`: واجهات برمجة التطبيقات (API)
* `services`: الخدمات والوظائف
* `utils`: الوظائف والمكتبات

### Frontend

* `public`: الملفات العامة والمتاحة للعملاء
* `src`: الملفات الأساسية للبرنامج
* `components`: المكونات والعناصر
* `containers`: الوحدات والعناصر الرئيسية
* `routes`: واجهات برمجة التطبيقات (API)

### Database

* `migrations`: التغييرات والتحديثات على الجداول
* `seeds`: البيانات المثبتة والأساسية

## Step-by-Step Instructions for Running the Environment
--------------------------------------------------------

### 1. تثبيت الحاجيات

bash
docker-compose up -d


### 2. تشغيل التطبيق

bash
docker-compose exec backend python manage.py runserver 0.0.0.0:8000


### 3. تشغيل قاعدة البيانات

bash
docker-compose exec database psql -U postgres -d pharmacy


### 4. تشغيل قاعدة البيانات باستخدام pgAdmin

* افتح pgAdmin
* انقر على "قاعدة البيانات" -> "إضافة قاعدة بيانات"
* أدخل اسم القاعدة وتاريخ التأسيس
* انقر على "إضافة"

## Modules, Tables, and Roles
---------------------------

### Modules

* `products`: إدارة المنتجات
* `staff`: إدارة الطاقم
* `orders`: إدارة الطلبات
* `revenue`: إدارة الإيرادات

### Tables

* `products`: المنتجات
* `staff`: الطاقم
* `orders`: الطلبات
* `revenue`: الإيرادات

### Roles

* `admin`: الإدارة العامة
* `staff`: الطاقم
* `customer`: العملاء

## Contact Developer Details
---------------------------

### Developer Name

* محمد عبد الله

### Developer Email

* mohamed.abdullah@example.com

### Developer Phone

* 0123456789

### Developer LinkedIn

* linkedin.com/in/mohamedabdullah

### Developer GitHub

* github.com/mohamedabdullah

---

## 📧 للتواصل (Contact)
almednyakrm@gmail.com
