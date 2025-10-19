<?php
/**
 * تعريف بيانات البذر الذكي
 */

function renita_seed_languages_definition(): array {
    return [
        'ar' => [
            'name'   => 'Arabic',
            'slug'   => 'ar',
            'locale' => 'ar',
            'rtl'    => true,
            'flag'   => 'ps',
        ],
        'en' => [
            'name'   => 'English',
            'slug'   => 'en',
            'locale' => 'en_US',
            'rtl'    => false,
            'flag'   => 'gb',
        ],
    ];
}

function renita_seed_page_definitions(): array {
    return [
        'front-page' => [
            'slug'    => 'home',
            'titles'  => [ 'ar' => 'الصفحة الرئيسية', 'en' => 'Home' ],
            'content' => [
                'ar' => '<!-- wp:heading {"textAlign":"center"} --><h1 class="wp-block-heading has-text-align-center">جامعة Renita University</h1><!-- /wp:heading -->\n<!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">الجامعة الأوروبية للعلوم الذكية</p><!-- /wp:paragraph -->',
                'en' => '<!-- wp:heading {"textAlign":"center"} --><h1 class="wp-block-heading has-text-align-center">Renita University</h1><!-- /wp:heading -->\n<!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">European University for Smart Sciences</p><!-- /wp:paragraph -->',
            ],
        ],
        'about' => [
            'slug'    => 'about',
            'titles'  => [ 'ar' => 'عن الجامعة', 'en' => 'About' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-overview' => [
            'parent'  => 'about',
            'slug'    => 'overview',
            'titles'  => [ 'ar' => 'نبذة عن الجامعة', 'en' => 'About Overview' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-vision' => [
            'parent'  => 'about',
            'slug'    => 'vision-mission',
            'titles'  => [ 'ar' => 'الرؤية والرسالة', 'en' => 'Vision & Mission' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-certification' => [
            'parent'  => 'about',
            'slug'    => 'certification-accreditation',
            'titles'  => [ 'ar' => 'الشهادة والاعتماد الأكاديمي', 'en' => 'Certification & Accreditation' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-units' => [
            'parent'  => 'about',
            'slug'    => 'presidency-units',
            'titles'  => [ 'ar' => 'الوحدات التابعة', 'en' => 'Presidency Units' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-language-translation' => [
            'parent'  => 'about-units',
            'slug'    => 'language-translation',
            'titles'  => [ 'ar' => 'مركز تعليم اللغات والترجمة القانونية', 'en' => 'Center for Language Teaching & Legal Translation' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-educational-development' => [
            'parent'  => 'about-units',
            'slug'    => 'educational-development',
            'titles'  => [ 'ar' => 'مركز التأهيل والتطوير التربوي', 'en' => 'Educational Development Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-swedish-iraqi-center' => [
            'parent'  => 'about-units',
            'slug'    => 'swedish-iraqi-center',
            'titles'  => [ 'ar' => 'المركز الثقافي السويدي العراقي', 'en' => 'Swedish-Iraqi Cultural Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-innovation-center' => [
            'parent'  => 'about-units',
            'slug'    => 'innovation-center',
            'titles'  => [ 'ar' => 'مركز الإبداع والابتكار', 'en' => 'Innovation Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-psychological-counseling' => [
            'parent'  => 'about-units',
            'slug'    => 'psychological-counseling',
            'titles'  => [ 'ar' => 'مركز الاستشارات النفسية', 'en' => 'Psychological Counseling Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-study' => [
            'parent'  => 'about',
            'slug'    => 'study-exams',
            'titles'  => [ 'ar' => 'نظام الدراسة والامتحانات', 'en' => 'Study & Exams' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-staff' => [
            'parent'  => 'about',
            'slug'    => 'faculty-staff',
            'titles'  => [ 'ar' => 'الكادر التدريسي', 'en' => 'Faculty & Staff' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'colleges' => [
            'slug'    => 'colleges',
            'titles'  => [ 'ar' => 'قائمة الكليات', 'en' => 'Colleges' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'programs' => [
            'slug'    => 'programs',
            'titles'  => [ 'ar' => 'جميع البرامج', 'en' => 'Programs' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions' => [
            'slug'    => 'admissions',
            'titles'  => [ 'ar' => 'القبول والتسجيل', 'en' => 'Admissions' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions-requirements' => [
            'parent'  => 'admissions',
            'slug'    => 'requirements',
            'titles'  => [ 'ar' => 'شروط القبول', 'en' => 'Admissions Requirements' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions-documents' => [
            'parent'  => 'admissions',
            'slug'    => 'documents',
            'titles'  => [ 'ar' => 'الوثائق المطلوبة', 'en' => 'Required Documents' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions-process' => [
            'parent'  => 'admissions',
            'slug'    => 'enrollment-process',
            'titles'  => [ 'ar' => 'آلية التسجيل', 'en' => 'Enrollment Process' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions-fees' => [
            'parent'  => 'admissions',
            'slug'    => 'tuition-fees',
            'titles'  => [ 'ar' => 'الرسوم الدراسية', 'en' => 'Tuition Fees' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions-faq' => [
            'parent'  => 'admissions',
            'slug'    => 'faq',
            'titles'  => [ 'ar' => 'الأسئلة الشائعة', 'en' => 'Admissions FAQ' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'research' => [
            'slug'    => 'research',
            'titles'  => [ 'ar' => 'البحث العلمي', 'en' => 'Research' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'research-twinning' => [
            'parent'  => 'research',
            'slug'    => 'academic-twinning',
            'titles'  => [ 'ar' => 'اتفاقيات التوأمة الأكاديمية', 'en' => 'Academic Twinning Agreements' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'research-centers' => [
            'parent'  => 'research',
            'slug'    => 'research-centers',
            'titles'  => [ 'ar' => 'المراكز البحثية', 'en' => 'Research Centers' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'research-innovation' => [
            'parent'  => 'research',
            'slug'    => 'innovation-creativity',
            'titles'  => [ 'ar' => 'الإبداع والابتكار', 'en' => 'Innovation & Creativity' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'contact' => [
            'slug'    => 'contact',
            'titles'  => [ 'ar' => 'الاتصال بنا', 'en' => 'Contact' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
    ];
}

function renita_seed_college_definitions(): array {
    return [
        [
            'slug'        => 'applied-sciences',
            'titles'      => [ 'ar' => 'كلية العلوم التطبيقية', 'en' => 'College of Applied Sciences' ],
            'departments' => [
                [ 'slug' => 'ai', 'names' => [ 'ar' => 'الذكاء الاصطناعي', 'en' => 'Artificial Intelligence' ] ],
                [ 'slug' => 'computer-software', 'names' => [ 'ar' => 'الحاسوب والبرمجيات', 'en' => 'Computer & Software' ] ],
                [ 'slug' => 'nursing-medical', 'names' => [ 'ar' => 'التمريض والخدمات الطبية', 'en' => 'Nursing & Medical Services' ] ],
                [ 'slug' => 'agro-industrial', 'names' => [ 'ar' => 'التصنيع الزراعي', 'en' => 'Agro-Industrial' ] ],
            ],
        ],
        [
            'slug'        => 'administration-economics',
            'titles'      => [ 'ar' => 'كلية الإدارة والاقتصاد', 'en' => 'College of Administration and Economics' ],
            'departments' => [
                [ 'slug' => 'business-administration', 'names' => [ 'ar' => 'إدارة الأعمال', 'en' => 'Business Administration' ] ],
                [ 'slug' => 'information-systems', 'names' => [ 'ar' => 'نظم المعلومات', 'en' => 'Information Systems' ] ],
                [ 'slug' => 'finance-banking', 'names' => [ 'ar' => 'العلوم المالية والمصرفية', 'en' => 'Finance & Banking' ] ],
            ],
        ],
        [
            'slug'        => 'law-political-sciences',
            'titles'      => [ 'ar' => 'كلية القانون والعلوم السياسية', 'en' => 'College of Law and Political Sciences' ],
            'departments' => [
                [ 'slug' => 'law', 'names' => [ 'ar' => 'القانون', 'en' => 'Law' ] ],
                [ 'slug' => 'political-science', 'names' => [ 'ar' => 'العلوم السياسية', 'en' => 'Political Science' ] ],
            ],
        ],
        [
            'slug'        => 'engineering-information-technology',
            'titles'      => [ 'ar' => 'كلية الهندسة وتكنولوجيا المعلومات', 'en' => 'College of Engineering and Information Technology' ],
            'departments' => [
                [ 'slug' => 'computer-engineering', 'names' => [ 'ar' => 'هندسة الحاسبات', 'en' => 'Computer Engineering' ] ],
                [ 'slug' => 'quality-inspection', 'names' => [ 'ar' => 'هندسة الفحص والسيطرة النوعية', 'en' => 'Quality Inspection & Control Engineering' ] ],
                [ 'slug' => 'electrical-engineering', 'names' => [ 'ar' => 'الهندسة الكهربائية', 'en' => 'Electrical Engineering' ] ],
                [ 'slug' => 'engineering-projects', 'names' => [ 'ar' => 'إدارة المشاريع الهندسية', 'en' => 'Engineering Project Management' ] ],
                [ 'slug' => 'biomedical-engineering', 'names' => [ 'ar' => 'الهندسة الطبية الحيوية', 'en' => 'Biomedical Engineering' ] ],
                [ 'slug' => 'medical-devices', 'names' => [ 'ar' => 'هندسة الأجهزة والمعدات الطبية', 'en' => 'Medical Devices Engineering' ] ],
            ],
        ],
        [
            'slug'        => 'education-human-sciences',
            'titles'      => [ 'ar' => 'كلية التربية والعلوم الإنسانية', 'en' => 'College of Education and Human Sciences' ],
            'departments' => [
                [ 'slug' => 'educational-sciences', 'names' => [ 'ar' => 'العلوم التربوية', 'en' => 'Educational Sciences' ] ],
                [ 'slug' => 'psychology', 'names' => [ 'ar' => 'علم النفس', 'en' => 'Psychology' ] ],
                [ 'slug' => 'counseling-guidance', 'names' => [ 'ar' => 'الإرشاد النفسي والتوجيه التربوي', 'en' => 'Counseling & Guidance' ] ],
                [ 'slug' => 'special-education', 'names' => [ 'ar' => 'التربية الخاصة', 'en' => 'Special Education' ] ],
                [ 'slug' => 'islamic-studies', 'names' => [ 'ar' => 'العلوم الشرعية', 'en' => 'Islamic Studies' ] ],
            ],
        ],
        [
            'slug'        => 'allied-medical-sciences',
            'titles'      => [ 'ar' => 'كلية العلوم الطبية المساعدة', 'en' => 'College of Allied Medical Sciences' ],
            'departments' => [
                [ 'slug' => 'public-health', 'names' => [ 'ar' => 'الصحة العامة', 'en' => 'Public Health' ] ],
                [ 'slug' => 'clinical-nutrition', 'names' => [ 'ar' => 'التغذية العلاجية', 'en' => 'Clinical Nutrition' ] ],
            ],
        ],
        [
            'slug'        => 'arts-languages',
            'titles'      => [ 'ar' => 'كلية الآداب واللغات', 'en' => 'College of Arts and Languages' ],
            'departments' => [
                [ 'slug' => 'arabic-native', 'names' => [ 'ar' => 'اللغة العربية للناطقين بها', 'en' => 'Arabic for Native Speakers' ] ],
                [ 'slug' => 'arabic-non-native', 'names' => [ 'ar' => 'اللغة العربية لغير الناطقين بها', 'en' => 'Arabic for Non-Native Speakers' ] ],
                [ 'slug' => 'english-language', 'names' => [ 'ar' => 'اللغة الإنجليزية', 'en' => 'English Language' ] ],
                [ 'slug' => 'swedish-language', 'names' => [ 'ar' => 'اللغة السويدية', 'en' => 'Swedish Language' ] ],
                [ 'slug' => 'french-language', 'names' => [ 'ar' => 'اللغة الفرنسية', 'en' => 'French Language' ] ],
                [ 'slug' => 'translation', 'names' => [ 'ar' => 'الترجمة', 'en' => 'Translation' ] ],
                [ 'slug' => 'sociology', 'names' => [ 'ar' => 'علم الاجتماع', 'en' => 'Sociology' ] ],
            ],
        ],
        [
            'slug'        => 'graduate-studies-research',
            'titles'      => [ 'ar' => 'كلية الدراسات العليا والبحث العلمي', 'en' => 'College of Graduate Studies and Scientific Research' ],
            'departments' => [
                [ 'slug' => 'postdoctoral', 'names' => [ 'ar' => 'مرحلة ما بعد الدكتوراه', 'en' => 'Postdoctoral Studies' ] ],
            ],
        ],
    ];
}

function renita_seed_program_type_definitions(): array {
    return [
        'preparatory'   => [ 'ar' => 'البرامج التأهيلية', 'en' => 'Preparatory Programs' ],
        'undergraduate' => [ 'ar' => 'البكالوريوس', 'en' => 'Undergraduate' ],
        'masters'       => [ 'ar' => 'الماجستير', 'en' => 'Masters' ],
        'professional'  => [ 'ar' => 'المهنية', 'en' => 'Professional' ],
        'postdoctoral'  => [ 'ar' => 'ما بعد الدكتوراه', 'en' => 'Postdoctoral' ],
    ];
}

function renita_seed_program_definitions(): array {
    return [
        [
            'slug'         => 'ai-bachelor',
            'titles'       => [ 'ar' => 'بكالوريوس الذكاء الاصطناعي', 'en' => 'BSc Artificial Intelligence' ],
            'type'         => 'undergraduate',
            'college_slug' => 'applied-sciences',
            'department'   => 'ai',
            'content'      => [
                'ar' => '<p>برنامج يؤسس لمهارات الذكاء الاصطناعي وتعلم الآلة.</p>',
                'en' => '<p>A program that builds core artificial intelligence and machine learning skills.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => '4 سنوات', 'en' => '4 Years' ],
                'language'      => [ 'ar' => 'العربية والإنجليزية', 'en' => 'Arabic & English' ],
                'delivery_mode' => [ 'ar' => 'حضوري', 'en' => 'On Campus' ],
                'requirements'  => [ 'ar' => 'شهادة إعدادية أو ثانوية مع معدل مناسب.', 'en' => 'High school diploma with competitive GPA.' ],
                'modules'       => [ 'ar' => 'أساسيات البرمجة، تعلم الآلة، الرؤية الحاسوبية.', 'en' => 'Programming fundamentals, machine learning, computer vision.' ],
            ],
        ],
        [
            'slug'         => 'business-admin-bachelor',
            'titles'       => [ 'ar' => 'بكالوريوس إدارة الأعمال', 'en' => 'BBA Business Administration' ],
            'type'         => 'undergraduate',
            'college_slug' => 'administration-economics',
            'department'   => 'business-administration',
            'content'      => [
                'ar' => '<p>برنامج يلبي متطلبات سوق الأعمال والإدارة الحديثة.</p>',
                'en' => '<p>A program tailored for modern business leadership and management skills.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => '4 سنوات', 'en' => '4 Years' ],
                'language'      => [ 'ar' => 'الإنجليزية', 'en' => 'English' ],
                'delivery_mode' => [ 'ar' => 'هجين', 'en' => 'Hybrid' ],
                'requirements'  => [ 'ar' => 'شهادة ثانوية تخصص علمي أو أدبي.', 'en' => 'Secondary school certificate in science or humanities.' ],
                'modules'       => [ 'ar' => 'المحاسبة، التسويق، ريادة الأعمال.', 'en' => 'Accounting, marketing, entrepreneurship.' ],
            ],
        ],
        [
            'slug'         => 'law-bachelor',
            'titles'       => [ 'ar' => 'بكالوريوس القانون', 'en' => 'LLB Law' ],
            'type'         => 'undergraduate',
            'college_slug' => 'law-political-sciences',
            'department'   => 'law',
            'content'      => [
                'ar' => '<p>برنامج يوفر معرفة قانونية شاملة وتشريعات مقارنة.</p>',
                'en' => '<p>A comprehensive program covering comparative legal systems and legislation.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => '4 سنوات', 'en' => '4 Years' ],
                'language'      => [ 'ar' => 'العربية', 'en' => 'Arabic' ],
                'delivery_mode' => [ 'ar' => 'حضوري', 'en' => 'On Campus' ],
                'requirements'  => [ 'ar' => 'اختبار قدرات قانونية ومعدل ثانوي مرتفع.', 'en' => 'Entrance aptitude test and strong high school GPA.' ],
                'modules'       => [ 'ar' => 'القانون المدني، القانون الجنائي، القانون الدولي.', 'en' => 'Civil law, criminal law, international law.' ],
            ],
        ],
        [
            'slug'         => 'political-science-master',
            'titles'       => [ 'ar' => 'ماجستير العلوم السياسية', 'en' => 'MA Political Science' ],
            'type'         => 'masters',
            'college_slug' => 'law-political-sciences',
            'department'   => 'political-science',
            'content'      => [
                'ar' => '<p>برنامج بحثي يركز على الحوكمة والسياسات العامة.</p>',
                'en' => '<p>A research-driven program focusing on governance and public policy.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => 'سنتان', 'en' => '2 Years' ],
                'language'      => [ 'ar' => 'الإنجليزية', 'en' => 'English' ],
                'delivery_mode' => [ 'ar' => 'هجين', 'en' => 'Hybrid' ],
                'requirements'  => [ 'ar' => 'شهادة بكالوريوس في العلوم السياسية أو المجالات ذات الصلة.', 'en' => "Bachelor's degree in political science or related fields." ],
                'modules'       => [ 'ar' => 'نظرية سياسية، تحليل السياسات، علاقات دولية.', 'en' => 'Political theory, policy analysis, international relations.' ],
            ],
        ],
        [
            'slug'         => 'software-engineering-bsc',
            'titles'       => [ 'ar' => 'بكالوريوس هندسة البرمجيات', 'en' => 'BSc Software Engineering' ],
            'type'         => 'undergraduate',
            'college_slug' => 'engineering-information-technology',
            'department'   => 'computer-engineering',
            'content'      => [
                'ar' => '<p>برنامج يهتم بتصميم الأنظمة الموثوقة وخدمات البرمجيات السحابية.</p>',
                'en' => '<p>A program covering reliable system design and cloud software services.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => '4 سنوات', 'en' => '4 Years' ],
                'language'      => [ 'ar' => 'الإنجليزية', 'en' => 'English' ],
                'delivery_mode' => [ 'ar' => 'حضوري', 'en' => 'On Campus' ],
                'requirements'  => [ 'ar' => 'شهادة ثانوية علمية مع مستوى رياضيات متقدم.', 'en' => 'Science high school diploma with advanced mathematics.' ],
                'modules'       => [ 'ar' => 'تصميم البرمجيات، هندسة المتطلبات، اختبار البرمجيات.', 'en' => 'Software design, requirements engineering, software testing.' ],
            ],
        ],
        [
            'slug'         => 'biomedical-master',
            'titles'       => [ 'ar' => 'ماجستير الهندسة الطبية الحيوية', 'en' => 'MSc Biomedical Engineering' ],
            'type'         => 'masters',
            'college_slug' => 'engineering-information-technology',
            'department'   => 'biomedical-engineering',
            'content'      => [
                'ar' => '<p>برنامج يدمج بين العلوم الطبية والهندسة للتطوير الإكلينيكي.</p>',
                'en' => '<p>A program merging medical sciences and engineering for clinical innovation.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => 'سنتان', 'en' => '2 Years' ],
                'language'      => [ 'ar' => 'الإنجليزية', 'en' => 'English' ],
                'delivery_mode' => [ 'ar' => 'حضوري', 'en' => 'On Campus' ],
                'requirements'  => [ 'ar' => 'شهادة بكالوريوس في الهندسة الطبية أو المجالات الصحية.', 'en' => 'Bachelor in biomedical engineering or health sciences.' ],
                'modules'       => [ 'ar' => 'الأجهزة الطبية، المعالجة الحيوية، التحليل الإحصائي.', 'en' => 'Medical devices, bio-processing, statistical analysis.' ],
            ],
        ],
        [
            'slug'         => 'public-health-diploma',
            'titles'       => [ 'ar' => 'دبلوم الصحة العامة', 'en' => 'Diploma in Public Health' ],
            'type'         => 'professional',
            'college_slug' => 'allied-medical-sciences',
            'department'   => 'public-health',
            'content'      => [
                'ar' => '<p>برنامج مهني يركز على تعزيز صحة المجتمع.</p>',
                'en' => '<p>A professional program focused on community health promotion.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => 'سنة واحدة', 'en' => '1 Year' ],
                'language'      => [ 'ar' => 'العربية', 'en' => 'Arabic' ],
                'delivery_mode' => [ 'ar' => 'هجين', 'en' => 'Hybrid' ],
                'requirements'  => [ 'ar' => 'شهادة بكالوريوس أو دبلوم في التخصصات الصحية.', 'en' => 'Bachelor or diploma in health disciplines.' ],
                'modules'       => [ 'ar' => 'الصحة البيئية، الوبائيات، إدارة الرعاية الصحية.', 'en' => 'Environmental health, epidemiology, healthcare management.' ],
            ],
        ],
        [
            'slug'         => 'translation-ma',
            'titles'       => [ 'ar' => 'ماجستير الترجمة المتخصصة', 'en' => 'MA Specialized Translation' ],
            'type'         => 'masters',
            'college_slug' => 'arts-languages',
            'department'   => 'translation',
            'content'      => [
                'ar' => '<p>برنامج متقدم في الترجمة القانونية والفورية.</p>',
                'en' => '<p>An advanced program in legal and conference interpreting.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => 'سنتان', 'en' => '2 Years' ],
                'language'      => [ 'ar' => 'العربية والإنجليزية', 'en' => 'Arabic & English' ],
                'delivery_mode' => [ 'ar' => 'هجين', 'en' => 'Hybrid' ],
                'requirements'  => [ 'ar' => 'اختبار كفاءة لغوية وشهادة بكالوريوس ذات صلة.', 'en' => 'Language proficiency test and relevant bachelor\'s degree.' ],
                'modules'       => [ 'ar' => 'الترجمة الفورية، الترجمة القانونية، تقنيات الترجمة بمساعدة الحاسوب.', 'en' => 'Interpretation, legal translation, computer-assisted translation.' ],
            ],
        ],
        [
            'slug'         => 'special-education-bachelor',
            'titles'       => [ 'ar' => 'بكالوريوس التربية الخاصة', 'en' => 'BEd Special Education' ],
            'type'         => 'undergraduate',
            'college_slug' => 'education-human-sciences',
            'department'   => 'special-education',
            'content'      => [
                'ar' => '<p>برنامج يؤهل للعمل مع ذوي الاحتياجات الخاصة.</p>',
                'en' => '<p>A program preparing specialists to work with learners with disabilities.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => '4 سنوات', 'en' => '4 Years' ],
                'language'      => [ 'ar' => 'العربية', 'en' => 'Arabic' ],
                'delivery_mode' => [ 'ar' => 'حضوري', 'en' => 'On Campus' ],
                'requirements'  => [ 'ar' => 'مقابلة شخصية وشهادة ثانوية.', 'en' => 'Interview and secondary school certificate.' ],
                'modules'       => [ 'ar' => 'تشخيص الحالات، تصميم البرامج الفردية، مهارات التواصل.', 'en' => 'Assessment, individualized program design, communication skills.' ],
            ],
        ],
        [
            'slug'         => 'postdoctoral-research',
            'titles'       => [ 'ar' => 'برنامج ما بعد الدكتوراه في البحث العلمي', 'en' => 'Postdoctoral Program in Research' ],
            'type'         => 'postdoctoral',
            'college_slug' => 'graduate-studies-research',
            'department'   => 'postdoctoral',
            'content'      => [
                'ar' => '<p>زمالة بحثية متقدمة لدعم الابتكار العلمي.</p>',
                'en' => '<p>An advanced research fellowship supporting scientific innovation.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => '1-2 سنة', 'en' => '1-2 Years' ],
                'language'      => [ 'ar' => 'الإنجليزية', 'en' => 'English' ],
                'delivery_mode' => [ 'ar' => 'بحثي', 'en' => 'Research-Based' ],
                'requirements'  => [ 'ar' => 'شهادة دكتوراه منشورة وأبحاث سابقة.', 'en' => 'PhD degree with peer-reviewed publications.' ],
                'modules'       => [ 'ar' => 'ورش بحثية، إشراف أكاديمي، نشر علمي.', 'en' => 'Research seminars, academic supervision, scientific publishing.' ],
            ],
        ],
    ];
}

function renita_seed_news_definitions(): array {
    return [
        [ 'slug' => 'orientation-week', 'titles' => [ 'ar' => 'أسبوع التعريف بالطلبة الجدد', 'en' => 'New Students Orientation Week' ] ],
        [ 'slug' => 'research-grant', 'titles' => [ 'ar' => 'منحة بحثية جديدة', 'en' => 'New Research Grant' ] ],
        [ 'slug' => 'innovation-award', 'titles' => [ 'ar' => 'جائزة الإبداع الجامعي', 'en' => 'University Innovation Award' ] ],
        [ 'slug' => 'partnership-announcement', 'titles' => [ 'ar' => 'إعلان شراكة دولية', 'en' => 'International Partnership Announcement' ] ],
        [ 'slug' => 'conference-invitation', 'titles' => [ 'ar' => 'دعوة للمؤتمر السنوي', 'en' => 'Annual Conference Invitation' ] ],
        [ 'slug' => 'career-fair', 'titles' => [ 'ar' => 'معرض الوظائف السنوي', 'en' => 'Annual Career Fair' ] ],
    ];
}

function renita_theme_string_blueprint(): array {
    return [
        'hero_heading'        => [ 'ar' => 'جامعة Renita University', 'en' => 'Renita University' ],
        'hero_subheading'     => [ 'ar' => 'الجامعة الأوروبية للعلوم الذكية', 'en' => 'European University for Smart Sciences' ],
        'apply_now'           => [ 'ar' => 'قدّم الآن', 'en' => 'Apply Now' ],
        'research_innovation' => [ 'ar' => 'البحث والابتكار', 'en' => 'Research & Innovation' ],
        'distinguished_colleges' => [ 'ar' => 'كليات متميزة', 'en' => 'Distinguished Colleges' ],
        'global_partnerships' => [ 'ar' => 'شراكات عالمية', 'en' => 'Global Partnerships' ],
        'latest_news'         => [ 'ar' => 'آخر الأخبار', 'en' => 'Latest News' ],
    ];
}
