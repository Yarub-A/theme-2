# الخطة التقنية النهائية الكاملة لقالب **Renita University / الجامعة الأوروبية للعلوم الذكية**

## 1) ملخص تنفيذي
- **وصف المشروع:** تطوير قالب WordPress رسمي، ثنائي اللغة (العربية/الإنجليزية)، مصمم لمؤسسة أكاديمية كبرى، يعتمد على WordPress Core، Bootstrap 5.3.3، Gutenberg، وPolylang دون أي إضافات أخرى. يلتزم بتصميم Flat، تحميل محلي كامل، واستجابة لكل الأحجام.
- **المتطلبات غير الوظيفية:** أداء مرتفع (نقاط Lighthouse ≥ 90)، أمان عالي (تعطيل التسجيل، فلترة المخرجات)، قابلية تحرير كاملة عبر Gutenberg، توحيد التصميم عبر `theme.json`، دعم RTL/ LTR متكامل، إنشاء تلقائي للمحتوى، وموثوقية إعادة التفعيل دون تكرار (Smart Seeding).
- **الافتراضات:** توفر بيئة WordPress 6.4+، صلاحيات تثبيت Polylang فقط، إمكانية تشغيل أوامر WP-CLI، وإمكانية الوصول إلى خادم يدعم PHP 8.1+ وMySQL 8/ MariaDB 10.5+.
- **المخاطر:** فشل تفعيل Polylang قبل التفعيل الأول للقالب، ازدواجية المحتوى إذا أزيلت الـ meta `_renita_seeded` يدويًا، الحاجة إلى إدارة الترجمة بعناية قبل النشر، وتأثير أي تخصيص خارجي على بنية القوائم ثلاثية المستويات.

## 2) هيكل المشروع Project Structure
```
wp-content/themes/renita-university/
├─ style.css              # ترويسة القالب وتعريفات CSS العامة.
├─ rtl.css                # تخصيصات الاتجاه من اليمين إلى اليسار.
├─ theme.json             # لوحة الألوان، الخطوط، التباعد، وتوحيد المحرر.
├─ functions.php          # نقطة الدخول: استدعاء ملفات inc/ وتسجيل الميزات.
├─ front-page.php         # قالب الصفحة الرئيسية يعتمد على the_content فقط.
├─ header.php / footer.php# هيدر وفوتر bootstrap متجاوب.
├─ page.php               # القالب الافتراضي للصفحات.
├─ singular.php           # قالب عام للمفردات (news, program, college).
├─ archive-college.php    # أرشيف الكليات.
├─ single-college.php     # عرض كلية واحدة.
├─ archive-news.php / single-news.php
├─ archive-program.php / single-program.php
├─ search.php / 404.php
│
├─ inc/
│  ├─ setup.php               # دعم القالب، تسجيل القوائم، تفعيل الميزات.
│  ├─ enqueue.php             # تحميل Bootstrap والأصول المحلية.
│  ├─ theme-support.php       # خصائص Gutenberg، صورة الشعار، إلخ.
│  ├─ initial-content.php     # سكربت البذر الذكي للمحتوى الأولي.
│  ├─ polylang.php            # تعريف اللغات، التسجيل، ربط الترجمات.
│  ├─ cpt-colleges.php        # تعريف CPT الكليات.
│  ├─ cpt-news.php            # تعريف CPT الأخبار.
│  ├─ cpt-programs.php        # تعريف CPT البرامج الأكاديمية.
│  ├─ tax-departments.php     # تعريف taxonomy أقسام الكليات.
│  ├─ tax-program-type.php    # تعريف taxonomy أنواع البرامج.
│  ├─ blocks.php              # تسجيل البلوكات الديناميكية.
│  ├─ filters.php             # فلاتر الأمان، إخفاء wp-generator.
│  ├─ menus.php               # دوال بناء القوائم تلقائيًا.
│  ├─ hooks.php               # ربط الأحداث (after_switch_theme، init...).
│  ├─ helpers.php             # دوال مساعدة (renita_upsert_translated_post...).
│  └─ security.php            # سياسات أمان إضافية (HTTP headers...).
│
├─ template-parts/
│  ├─ header/topbar.php
│  ├─ navigation/primary.php
│  ├─ hero/hero.php
│  ├─ components/feature-cards.php
│  ├─ components/stats-strip.php
│  ├─ news/news-grid.php
│  ├─ components/quick-links.php
│  ├─ partners/partners-grid.php
│  └─ footer/widgets-4col.php
│
├─ assets/
│  ├─ css/
│  │  ├─ bootstrap.min.css
│  │  ├─ bootstrap-override.css
│  │  ├─ editor-style.css
│  │  └─ frontend.css
│  ├─ js/
│  │  ├─ bootstrap.bundle.min.js
│  │  └─ main.js
│  └─ img/
│     ├─ logo-ar.svg / logo-en.svg
│     ├─ hero-bg.jpg
│     └─ partners/*.svg
│
├─ languages/
│  ├─ renita-ar.po / renita-ar.mo
│  └─ renita-en_US.po / renita-en_US.mo
│
├─ bin/
│  └─ wp-cli-renita-seed.php    # أمر WP-CLI `wp renita seed`.
│
├─ README.md (هذا المستند)
└─ CHANGELOG.md                 # يتم تحديثه عند كل إصدار.
```

## 3) التسجيل البرمجي Registration Specs
### 3.1) نوع المحتوى المخصص `college`
**الملف:** `// inc/cpt-colleges.php`
```php
<?php
add_action( 'init', function () {
    $labels = [
        'name'               => __( 'الكليات / Colleges', 'renita' ),
        'singular_name'      => __( 'كلية / College', 'renita' ),
        'add_new'            => __( 'إضافة كلية جديدة', 'renita' ),
        'add_new_item'       => __( 'إضافة كلية جديدة / Add New College', 'renita' ),
        'edit_item'          => __( 'تحرير الكلية / Edit College', 'renita' ),
        'new_item'           => __( 'كلية جديدة / New College', 'renita' ),
        'view_item'          => __( 'عرض الكلية / View College', 'renita' ),
        'search_items'       => __( 'بحث في الكليات / Search Colleges', 'renita' ),
        'not_found'          => __( 'لا توجد كليات', 'renita' ),
        'not_found_in_trash' => __( 'لا توجد كليات في سلة المهملات', 'renita' ),
        'all_items'          => __( 'جميع الكليات / All Colleges', 'renita' ),
        'menu_name'          => __( 'الكليات / Colleges', 'renita' ),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'colleges', 'with_front' => false ],
        'show_in_rest'       => true,
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ],
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'capability_type'    => 'page',
        'map_meta_cap'       => true,
    ];

    register_post_type( 'college', $args );
} );
```

### 3.2) نوع المحتوى `news`
**الملف:** `// inc/cpt-news.php`
```php
<?php
add_action( 'init', function () {
    $labels = [
        'name'               => __( 'الأخبار والفعاليات / News & Events', 'renita' ),
        'singular_name'      => __( 'خبر / News Item', 'renita' ),
        'add_new_item'       => __( 'إضافة خبر جديد / Add News', 'renita' ),
        'edit_item'          => __( 'تحرير الخبر / Edit News', 'renita' ),
        'view_item'          => __( 'عرض الخبر / View News', 'renita' ),
        'search_items'       => __( 'بحث في الأخبار / Search News', 'renita' ),
    ];

    register_post_type( 'news', [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'news', 'with_front' => false ],
        'show_in_rest'       => true,
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'menu_icon'          => 'dashicons-megaphone',
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
    ] );
} );
```

### 3.3) نوع المحتوى `program`
**الملف:** `// inc/cpt-programs.php`
```php
<?php
add_action( 'init', function () {
    $labels = [
        'name'               => __( 'البرامج الأكاديمية / Academic Programs', 'renita' ),
        'singular_name'      => __( 'برنامج أكاديمي / Program', 'renita' ),
        'add_new_item'       => __( 'إضافة برنامج / Add Program', 'renita' ),
        'edit_item'          => __( 'تحرير البرنامج / Edit Program', 'renita' ),
        'view_item'          => __( 'عرض البرنامج / View Program', 'renita' ),
        'search_items'       => __( 'بحث في البرامج / Search Programs', 'renita' ),
    ];

    register_post_type( 'program', [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'programs', 'with_front' => false ],
        'show_in_rest'       => true,
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ],
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
    ] );
} );
```

### 3.4) تصنيف `department`
**الملف:** `// inc/tax-departments.php`
```php
<?php
add_action( 'init', function () {
    $labels = [
        'name'              => __( 'أقسام الكليات / College Departments', 'renita' ),
        'singular_name'     => __( 'قسم / Department', 'renita' ),
        'search_items'      => __( 'بحث في الأقسام', 'renita' ),
        'all_items'         => __( 'جميع الأقسام / All Departments', 'renita' ),
        'parent_item'       => __( 'القسم الأب / Parent Department', 'renita' ),
        'edit_item'         => __( 'تحرير القسم / Edit Department', 'renita' ),
        'update_item'       => __( 'تحديث القسم / Update Department', 'renita' ),
        'add_new_item'      => __( 'إضافة قسم جديد / Add Department', 'renita' ),
        'new_item_name'     => __( 'اسم القسم الجديد / New Department Name', 'renita' ),
        'menu_name'         => __( 'الأقسام / Departments', 'renita' ),
    ];

    register_taxonomy( 'department', [ 'college', 'program' ], [
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'department', 'with_front' => false ],
        'show_in_rest'      => true,
    ] );
} );
```

### 3.5) تصنيف `program-type`
**الملف:** `// inc/tax-program-type.php`
```php
<?php
add_action( 'init', function () {
    register_taxonomy( 'program-type', 'program', [
        'labels' => [
            'name'          => __( 'أنواع البرامج / Program Types', 'renita' ),
            'singular_name' => __( 'نوع البرنامج / Program Type', 'renita' ),
            'search_items'  => __( 'بحث في أنواع البرامج', 'renita' ),
            'all_items'     => __( 'جميع الأنواع', 'renita' ),
            'edit_item'     => __( 'تحرير النوع', 'renita' ),
            'add_new_item'  => __( 'إضافة نوع برنامج', 'renita' ),
            'menu_name'     => __( 'أنواع البرامج', 'renita' ),
        ],
        'hierarchical'      => false,
        'show_in_rest'      => true,
        'rewrite'           => [ 'slug' => 'program-type', 'with_front' => false ],
    ] );
} );
```

## 4) Polylang
- **تعريف اللغات:** تفعيل العربية (ar) لغة أساسية في الجذر، والإنجليزية (en) لغة ثانوية بمسار `/en/` عبر `PLL()->model->languages->set_language()` أو واجهة Polylang.
- **ربط الترجمات:** كل صفحة، كلية، برنامج، خبر يرتبط بالنسخة المقابلة باستعمال `pll_save_post_translations( [ 'ar' => $ar_id, 'en' => $en_id ] );` بعد الإنشاء.
- **تسجيل النصوص:** جميع السلاسل الثابتة في القالب تُسجل بواسطة `pll_register_string( 'renita', 'قدّم الآن / Apply Now', 'Buttons' );` داخل `inc/polylang.php`.
- **سياسة الروابط:** استخدام دوال Polylang لاسترداد الروابط الديناميكية، مثال: `$url = get_permalink( pll_get_post( $page_id, pll_default_language() ) );`.

## 5) الصفحات الثابتة الأساسية (AR/EN)
| التصنيف | الاسم العربي | الاسم الإنجليزي | المسار العربي | المسار الإنجليزي | نوع القالب | موقعه في القائمة |
|---------|--------------|-----------------|---------------|------------------|------------|------------------|
| عامة | الرئيسية | Home | `/` | `/en/` | front-page | المستوى الأول (العنصر الأول) |
| عن الجامعة | نبذة عن الجامعة | About Overview | `/about/overview` | `/en/about/overview` | Page | قائمة «عن الجامعة» المستوى الثاني |
| عن الجامعة | الرؤية والرسالة | Vision & Mission | `/about/vision-mission` | `/en/about/vision-mission` | Page | «عن الجامعة» المستوى الثاني |
| عن الجامعة | الشهادة والاعتماد الأكاديمي | Certification & Accreditation | `/about/certification-accreditation` | `/en/about/certification-accreditation` | Page | «عن الجامعة» المستوى الثاني |
| عن الجامعة | الوحدات التابعة | Presidency Units | `/about/presidency-units` | `/en/about/presidency-units` | Page | «عن الجامعة» المستوى الثاني |
| عن الجامعة | نظام الدراسة والامتحانات | Study & Exams | `/about/study-exams` | `/en/about/study-exams` | Page | «عن الجامعة» المستوى الثاني |
| عن الجامعة | الكادر التدريسي | Faculty & Staff | `/about/faculty-staff` | `/en/about/faculty-staff` | Page | «عن الجامعة» المستوى الثاني |
| الكليات | قائمة الكليات | Colleges | `/colleges` | `/en/colleges` | Page | عنصر قائمة رئيسي المستوى الأول |
| البرامج الأكاديمية | جميع البرامج | Programs | `/programs` | `/en/programs` | Archive | عنصر قائمة رئيسي |
| القبول والتسجيل | الشروط | Admissions Requirements | `/admissions/requirements` | `/en/admissions/requirements` | Page | تحت «القبول والتسجيل» |
| البحث العلمي | البحث العلمي | Research | `/research` | `/en/research` | Page | عنصر قائمة رئيسي |
| الأخبار والفعاليات | أرشيف الأخبار | News | `/news` | `/en/news` | CPT Archive | عنصر قائمة رئيسي |
| الاتصال | الاتصال بنا | Contact | `/contact` | `/en/contact` | Page | عنصر قائمة رئيسي |
| القبول والتسجيل | الوثائق المطلوبة | Required Documents | `/admissions/documents` | `/en/admissions/documents` | Page | عنصر فرعي |
| القبول والتسجيل | آلية التسجيل | Registration Process | `/admissions/process` | `/en/admissions/process` | Page | عنصر فرعي |
| القبول والتسجيل | الرسوم الدراسية | Tuition Fees | `/admissions/tuition` | `/en/admissions/tuition` | Page | عنصر فرعي |
| القبول والتسجيل | الأسئلة الشائعة | FAQ | `/admissions/faq` | `/en/admissions/faq` | Page | عنصر فرعي |
| البحث العلمي والتوأمة | اتفاقيات التوأمة الأكاديمية | Academic Twinning Agreements | `/research/twinning-agreements` | `/en/research/twinning-agreements` | Page | «البحث العلمي والتوأمة» |
| البحث العلمي والتوأمة | المراكز البحثية | Research Centers | `/research/centers` | `/en/research/centers` | Page | «البحث العلمي والتوأمة» |
| البحث العلمي والتوأمة | الإبداع والابتكار | Innovation & Creativity | `/research/innovation` | `/en/research/innovation` | Page | «البحث العلمي والتوأمة» |

## 6) الكليات الثمانية بالتفصيل الكامل
1. **كلية العلوم التطبيقية — College of Applied Sciences — slug: `applied-sciences`**
   - نوع المحتوى: `college`
   - موقع القائمة: قائمة «الكليات» المستوى الثاني بالعربية والإنجليزية.
   - الأقسام (taxonomy: `department`):
     - الذكاء الاصطناعي — Artificial Intelligence — `ai`
     - الحاسوب والبرمجيات — Computer & Software — `computer-software`
     - التمريض والخدمات الطبية — Nursing & Medical Services — `nursing-medical`
     - التصنيع الزراعي — Agro-Industrial — `agro-industrial`

2. **كلية الإدارة والاقتصاد — College of Administration and Economics — `administration-economics`**
   - نوع المحتوى: `college`
   - موقع القائمة: مستوى ثانٍ تحت «الكليات».
   - الأقسام:
     - إدارة الأعمال — Business Administration — `business-administration`
     - نظم المعلومات — Information Systems — `information-systems`
     - العلوم المالية والمصرفية — Finance & Banking — `finance-banking`

3. **كلية القانون والعلوم السياسية — College of Law and Political Sciences — `law-political-sciences`**
   - نوع المحتوى: `college`
   - الأقسام:
     - القانون — Law — `law`
     - العلوم السياسية — Political Science — `political-science`

4. **كلية الهندسة وتكنولوجيا المعلومات — College of Engineering and Information Technology — `engineering-information-technology`**
   - نوع المحتوى: `college`
   - الأقسام:
     - هندسة الحاسبات — Computer Engineering — `computer-engineering`
     - هندسة الفحص والسيطرة النوعية — Quality Inspection & Control Engineering — `quality-inspection`
     - الهندسة الكهربائية — Electrical Engineering — `electrical-engineering`
     - إدارة المشاريع الهندسية — Engineering Project Management — `engineering-projects`
     - الهندسة الطبية الحيوية — Biomedical Engineering — `biomedical-engineering`
     - هندسة الأجهزة والمعدات الطبية — Medical Devices Engineering — `medical-devices`

5. **كلية التربية والعلوم الإنسانية — College of Education and Human Sciences — `education-human-sciences`**
   - نوع المحتوى: `college`
   - الأقسام:
     - العلوم التربوية — Educational Sciences — `educational-sciences`
     - علم النفس — Psychology — `psychology`
     - الإرشاد النفسي والتوجيه التربوي — Counseling & Guidance — `counseling-guidance`
     - التربية الخاصة — Special Education — `special-education`
     - العلوم الشرعية — Islamic Studies — `islamic-studies`

6. **كلية العلوم الطبية المساعدة — College of Allied Medical Sciences — `allied-medical-sciences`**
   - نوع المحتوى: `college`
   - الأقسام:
     - الصحة العامة — Public Health — `public-health`
     - التغذية العلاجية — Clinical Nutrition — `clinical-nutrition`

7. **كلية الآداب واللغات — College of Arts and Languages — `arts-languages`**
   - نوع المحتوى: `college`
   - الأقسام:
     - اللغة العربية للناطقين بها — Arabic for Native Speakers — `arabic-native`
     - اللغة العربية لغير الناطقين بها — Arabic for Non-Native Speakers — `arabic-non-native`
     - اللغة الإنجليزية — English Language — `english-language`
     - اللغة السويدية — Swedish Language — `swedish-language`
     - اللغة الفرنسية — French Language — `french-language`
     - الترجمة — Translation — `translation`
     - علم الاجتماع — Sociology — `sociology`

8. **كلية الدراسات العليا والبحث العلمي — College of Graduate Studies and Scientific Research — `graduate-studies-research`**
   - نوع المحتوى: `college`
   - الأقسام:
     - مرحلة ما بعد الدكتوراه — Postdoctoral Studies — `postdoctoral`

## 7) البرامج الأكاديمية (`program`)
- **أنواع البرامج (`program-type`):**
  - `preparatory` — البرامج التأهيلية.
  - `undergraduate` — برامج البكالوريوس.
  - `masters` — برامج الماجستير.
  - `professional` — البرامج المهنية.
  - `postdoctoral` — برامج ما بعد الدكتوراه.
- **الحقول الإلزامية لكل برنامج:** عنوان البرنامج، نوع البرنامج (taxonomy)، الكلية المرتبطة (`post_object` من `college`)، القسم الأكاديمي (term من `department`)، الوصف الكامل، قائمة المقررات الأساسية، متطلبات القبول، مدة الدراسة، لغة التدريس، طريقة التعلم (حضوري/عن بعد/هجين).
- **مواصفات الأرشيف والمفردة:**
  - أرشيف `/programs` يستخدم `archive-program.php` مع ترقيم صفحات، فلاتر تفاعلية حسب الكلية، القسم، نوع البرنامج (باستخدام `WP_Query` و`tax_query`).
  - Breadcrumbs منظم عبر دالة مساعدة `renita_get_breadcrumbs()`.
  - صفحة البرنامج (`single-program.php`) تعرض تفاصيل الحقول الإلزامية ضمن أقسام Bootstrap، مع روابط للكلية والقسم المرتبطين.

## 8) الأخبار والفعاليات (`news`)
- **الأرشيف:** `/news` باستخدام `archive-news.php` مع ترقيم صفحات وقسم للتصفيات حسب الشهر/السنة.
- **المفردة:** `/news/{slug}` باستخدام `single-news.php`.
- **الحقول:** العنوان، الصورة المميزة، المحتوى، مقتطف تلقائي، التاريخ، الوسوم الافتراضية.
- **الصفحة الرئيسية:** Block `renita/news-grid` يعرض آخر 6 أخبار في شبكة Bootstrap 3×2 مع أزرار «اقرأ المزيد» تربط بالخبر.

## 9) القوائم Menus
- **القوائم المسجلة:** `primary_menu_ar`, `primary_menu_en`, `footer_menu_ar`, `footer_menu_en` في `inc/setup.php`.
- **البنية المنسدلة العربية:**
  - الرئيسية
  - عن الجامعة (ست صفحات فرعية)
  - الكليات (ثماني كليات → تحت كل كلية أقسامها)
  - البرامج الأكاديمية (التأهيلية/البكالوريوس/الماجستير/المهنية/ما بعد الدكتوراه)
  - القبول والتسجيل (شروط القبول/الوثائق/آلية التسجيل/الرسوم/الأسئلة الشائعة)
  - البحث العلمي والتوأمة (اتفاقيات التوأمة/البحث العلمي/المراكز البحثية/الإبداع والابتكار)
  - الأخبار والفعاليات
  - الاتصال بنا
- **البنية الإنجليزية:** مطابقة مع ترجمة الأسماء ووضع المسارات تحت `/en/`.
- **البناء البرمجي:** استخدام `wp_update_nav_menu_item()` داخل `inc/menus.php` لإنشاء عناصر القوائم وربطها بالصفحات/الكليات/الأقسام، مع حفظ `menu-item-parent-id` لبناء المستويات المتداخلة.

## 10) الصفحة الرئيسية front-page.php
- يعتمد القالب على Gutenberg Blocks ديناميكية بالكامل داخل محتوى الصفحة.
- **Hero Section:** Block `renita/hero` بخصائص (العنوان، الوصف، زر «قدّم الآن / Apply Now»، خلفية). يدعم الترجمة عبر `pll_register_string`.
- **Feature Cards:** Block `renita/feature-cards` بثلاث بطاقات (Global Partnerships، Research & Innovation، Distinguished Colleges) مع أيقونات نصية (بدون صور) وألوان من palette.
- **Stats Strip:** Block `renita/stats-strip` يعرض +25K طلاب، +120 برامج، +60 شركاء، 12 كلية.
- **News Grid:** Block `renita/news-grid` مع خيار عدد الأخبار.
- **Quick Links:** Block `renita/quick-links` لأزرار Apply / Admissions / Research / Visit Campus.
- **Partners Grid:** Block `renita/partners-grid` لعرض شعارات SVG من `assets/img/partners/`.
- كل Block مسجل في `inc/blocks.php` باستخدام `register_block_type` و`render_callback`, ويستعمل `wp_kses_post` لتعقيم المخرجات. يتم توفير `block.json` لكل Block في `blocks/<block-name>/`.

## 11) الأمان والسياسات
- تعطيل التعليقات عبر `add_filter( 'comments_open', '__return_false', 20, 2 );`، وإزالة نماذج التعليقات.
- تعطيل تسجيل المستخدمين من الواجهة.
- إخفاء `wp_generator` في الهيدر عبر `remove_action( 'wp_head', 'wp_generator' );`.
- تعقيم كل المخرجات باستخدام `esc_html`, `esc_attr`, `esc_url` في القوالب والبلوكات.
- تفعيل Lazy load للصور عبر `loading="lazy"` وإسناد `fetchpriority` للمحتوى الحرج.
- تحميل جميع الأصول محليًا؛ لا روابط CDN.
- تحسين الأداء: استخدام `preload` للخطوط المحلية، `defer` للسكربتات غير الحرجة، ضغط الصور، وتفعيل التخزين المؤقت عبر `.htaccess` أو إعدادات الخادم.

## 12) initial-content.php (Script للتهيئة)
- **خطوات التنفيذ عند التفعيل الأول:**
  1. التحقق من وجود الخيار `renita_seed_done`; إذا كان موجودًا، لا يتم البذر مجددًا.
  2. تفعيل اللغات عبر Polylang (`pll_languages_list` + إنشاء الإنجليزية إذا لم توجد).
  3. إنشاء الصفحات العربية والإنجليزية من مصفوفة `RENITA_PAGES` تحتوي على مفاتيح: `slug`, `title_ar`, `title_en`, `parent_slug`, `menu_location`.
  4. إنشاء الكليات من مصفوفة `RENITA_COLLEGES` وتحوي الأقسام الفرعية.
  5. إنشاء الأقسام (taxonomy) وربطها بكلية باستخدام `wp_set_post_terms`.
  6. إنشاء 6 أخبار تجريبية و10 برامج عبر مصفوفات `RENITA_SEED_NEWS` و`RENITA_SEED_PROGRAMS`.
  7. بناء القوائم العربية والإنجليزية استنادًا إلى المصفوفات، مع حفظ بنية الشجرة عبر مفاتيح parent.
  8. ربط الترجمات لكل كيان عبر `pll_save_post_translations` و`pll_save_term_translations`.
  9. تعيين الصفحة الرئيسية عبر `update_option( 'page_on_front', $front_page_ar_id );` و`update_option( 'show_on_front', 'page' );`.
 10. وضع خيار `update_option( 'renita_seed_done', 1 );` بعد الإكمال.
- **البذر الذكي:** استخدام الدالة `renita_upsert_translated_post( $args, $lang )` (المذكورة في تعليمات الأساليب) لضمان عدم التكرار.

## 13) معايير القبول والاختبار (Acceptance & QA)
- تحقق عبر WP-CLI: `wp post list --post_type=college --format=count` يجب أن يعيد 8.
- تحقق من وجود جميع الصفحات في العربية والإنجليزية مع روابط سليمة.
- اختبار القوائم ثلاثية المستويات في RTL وLTR.
- اختبار أرشيفات `college`, `news`, `program` والبحث المدمج في WordPress.
- تبديل اللغة عبر Polylang والتأكد من مسارات `/en/`.
- تشغيل Lighthouse للتأكد من الأداء (≥90)، إمكانية الوصول، أفضل الممارسات، SEO.
- التحقق من أن البلوكات الديناميكية تعرض البيانات الصحيحة في الصفحة الرئيسية.

## 14) الملاحق
- **أمثلة كود:**
  - `// inc/enqueue.php`
    ```php
    <?php
    add_action( 'wp_enqueue_scripts', function () {
        wp_enqueue_style( 'renita-bootstrap', get_theme_file_uri( 'assets/css/bootstrap.min.css' ), [], '5.3.3' );
        wp_enqueue_style( 'renita-bootstrap-override', get_theme_file_uri( 'assets/css/bootstrap-override.css' ), [ 'renita-bootstrap' ], '1.0.0' );
        wp_enqueue_style( 'renita-frontend', get_theme_file_uri( 'assets/css/frontend.css' ), [ 'renita-bootstrap-override' ], RENITA_THEME_VERSION );
        wp_enqueue_script( 'renita-bootstrap', get_theme_file_uri( 'assets/js/bootstrap.bundle.min.js' ), [], '5.3.3', true );
        wp_enqueue_script( 'renita-main', get_theme_file_uri( 'assets/js/main.js' ), [ 'renita-bootstrap' ], RENITA_THEME_VERSION, true );
    } );
    ```
  - `// inc/setup.php`
    ```php
    <?php
    add_action( 'after_setup_theme', function () {
        load_theme_textdomain( 'renita', get_template_directory() . '/languages' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'editor-styles' );
        add_editor_style( 'assets/css/editor-style.css' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
        register_nav_menus([
            'primary_menu_ar' => __( 'القائمة الرئيسية (عربي)', 'renita' ),
            'primary_menu_en' => __( 'Primary Menu (English)', 'renita' ),
            'footer_menu_ar'  => __( 'قائمة التذييل (عربي)', 'renita' ),
            'footer_menu_en'  => __( 'Footer Menu (English)', 'renita' ),
        ]);
    } );
    ```
  - `// inc/blocks.php`
    ```php
    <?php
    add_action( 'init', function () {
        register_block_type( get_template_directory() . '/blocks/hero' );
        register_block_type( get_template_directory() . '/blocks/feature-cards' );
        register_block_type( get_template_directory() . '/blocks/stats-strip' );
        register_block_type( get_template_directory() . '/blocks/news-grid', [
            'render_callback' => 'renita_render_news_grid',
        ] );
        // ... بقية البلوكات
    } );
    ```
  - `// inc/security.php`
    ```php
    <?php
    add_action( 'init', function () {
        if ( ! is_admin() ) {
            add_filter( 'xmlrpc_enabled', '__return_false' );
        }
        add_filter( 'the_generator', '__return_empty_string' );
    } );
    ```
- **معايير تسمية Slugs:** أحرف إنجليزية صغيرة، فواصل بشرطة (`-`)، بدون مسافات أو أرقام في البداية.
- **مخطط بيانات YAML للبذر:**
  ```yaml
  pages:
    - slug: about/overview
      title_ar: "نبذة عن الجامعة"
      title_en: "About Overview"
      menu: about
    - slug: research
      title_ar: "البحث العلمي"
      title_en: "Research"
      menu: research
  colleges:
    - slug: applied-sciences
      title_ar: "كلية العلوم التطبيقية"
      title_en: "College of Applied Sciences"
      departments:
        - slug: ai
          name_ar: "الذكاء الاصطناعي"
          name_en: "Artificial Intelligence"
    - slug: graduate-studies-research
      title_ar: "كلية الدراسات العليا والبحث العلمي"
      title_en: "College of Graduate Studies and Scientific Research"
      departments:
        - slug: postdoctoral
          name_ar: "مرحلة ما بعد الدكتوراه"
          name_en: "Postdoctoral Studies"
  programs:
    - slug: ai-bsc
      title_ar: "بكالوريوس الذكاء الاصطناعي"
      title_en: "BSc Artificial Intelligence"
      type: undergraduate
      college: applied-sciences
      department: ai
    - slug: postdoc-research
      title_ar: "برنامج ما بعد الدكتوراه في البحث العلمي"
      title_en: "Postdoctoral Research Program"
      type: postdoctoral
      college: graduate-studies-research
      department: postdoctoral
  menus:
    primary_ar:
      - title: "الرئيسية"
        type: page
        ref: home
      - title: "عن الجامعة"
        children:
          - ref: about/overview
          - ref: about/vision-mission
    primary_en:
      - title: "Home"
        type: page
        ref: home_en
  ```

## 15) أهم الأساليب العملية لتحقيق الأهداف
1. **البذر الذكي Smart Seeding:** عدم إنشاء أي كيان إن وجد مسبقًا؛ استخدام `_renita_seeded` لضبط الحذف الآمن؛ الاعتماد على `renita_upsert_translated_post()`.
2. **بناء القوائم عبر `wp_update_nav_menu_item()`:** لضمان التحرير السلس في لوحة التحكم وتوافق Gutenberg.
3. **الاعتماد على بلوكات ديناميكية بدل الشورتكود:** كل قسم في الصفحة الرئيسية عبارة عن Block قابل للتعديل مع `render_callback` في PHP.
4. **استخدام `theme.json`:** لضمان تطابق التصميم بين الواجهة والمحرر وتحديد الألوان الرسمية والخطوط.
5. **استخدام `the_content()` في الصفحة الرئيسية:** لتسهيل التحرير الكامل عبر Gutenberg.
6. **استدعاء Polylang ديناميكيًا:** للحصول على الروابط والترجمات بدون مسارات ثابتة.
7. **اختبارات استقرار بعد كل تفعيل:** استخدام WP-CLI للتحقق من الأعداد والبنية، مع أمر مخصص `wp renita seed --force` لإعادة البذر.
8. **توثيق كامل في README وCHANGELOG:** إرشاد المحررين والمطورين وتوثيق أوامر الصيانة.

## 16) تسلسل التنفيذ المرحلي (Milestones)
1. **Milestone 1:** إعداد الهيكل الأساسي، `style.css`, `functions.php`, `theme.json`, وملفات inc/ مع دعم الترجمة.
2. **Milestone 2:** تنفيذ أنواع المحتوى والتصنيفات، وربط Polylang.
3. **Milestone 3:** تطوير البلوكات الديناميكية والصفحة الرئيسية.
4. **Milestone 4:** إنشاء سكربت البذر الذكي، القوائم، وربط الترجمات.
5. **Milestone 5:** اختبار القالب، إعداد README، وتنفيذ أوامر WP-CLI.

## 17) تعليمات التشغيل والاختبار
1. تثبيت الاعتماديات:
   ```bash
   wp plugin install polylang --activate
   wp theme activate renita-university
   ```
2. تشغيل أمر البذر:
   ```bash
   wp renita seed --force
   ```
3. اختبار البلوكات:
   ```bash
   wp post create --post_type=page --post_title="Test Blocks" --post_status=publish
   ```
4. تشغيل الفحوص:
   ```bash
   npm install
   npm run lint
   npm run build
   ```

## 18) أمثلة رسائل Commit وPR
- **Commit:** `feat: scaffold renita university theme structure`
- **Commit:** `feat: register colleges cpt and department taxonomy`
- **Commit:** `feat: implement smart seeding for bilingual content`
- **PR Description:**
  ```
  ## Summary
  - Scaffolded the Renita University theme with Gutenberg-ready setup
  - Registered CPTs (college, program, news) and taxonomies with bilingual labels
  - Implemented smart seeding script to provision pages, menus, and translations

  ## Testing
  - wp theme activate renita-university
  - wp renita seed --force
  ```

