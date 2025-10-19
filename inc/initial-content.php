<?php
/**
 * بذر المحتوى الأولي
 */

if ( ! function_exists( 'renita_upsert_translated_post' ) ) {
    function renita_upsert_translated_post( array $args, string $lang ): int {
        $post_type = $args['post_type'] ?? 'page';
        $slug      = $args['post_name'] ?? sanitize_title( $args['post_title'] ?? uniqid( 'renita' ) );

        $existing = get_posts( [
            'post_type'      => $post_type,
            'name'           => $slug,
            'post_status'    => 'any',
            'posts_per_page' => 1,
            'meta_key'       => '_renita_seed_lang',
            'meta_value'     => $lang,
            'fields'         => 'ids',
        ] );

        if ( ! empty( $existing ) ) {
            $existing_id = (int) $existing[0];
            wp_update_post( array_merge( $args, [
                'ID'          => $existing_id,
                'post_status' => 'publish',
                'post_name'   => $slug,
            ] ) );

            return $existing_id;
        }

        $post_id = wp_insert_post( array_merge( $args, [
            'post_status' => 'publish',
            'post_name'   => $slug,
        ] ) );

        if ( is_wp_error( $post_id ) || ! $post_id ) {
            return 0;
        }

        update_post_meta( $post_id, '_renita_seeded', 1 );
        update_post_meta( $post_id, '_renita_seed_lang', $lang );

        if ( function_exists( 'pll_set_post_language' ) ) {
            pll_set_post_language( $post_id, $lang );
        }

        return (int) $post_id;
    }
}

function renita_seed_initial_content() {
    if ( get_option( 'renita_seed_version' ) === RENITA_THEME_VERSION ) {
        return;
    }

    $languages = [ 'ar', 'en' ];

    $pages = [
        'front-page' => [
            'slug'    => 'home',
            'title'   => [ 'ar' => 'الصفحة الرئيسية', 'en' => 'Home' ],
            'content' => [
                'ar' => '<!-- wp:paragraph --><p>مرحبا بكم في جامعة Renita University.</p><!-- /wp:paragraph -->',
                'en' => '<!-- wp:paragraph --><p>Welcome to Renita University.</p><!-- /wp:paragraph -->',
            ],
        ],
        'about' => [
            'slug'    => 'about',
            'title'   => [ 'ar' => 'عن الجامعة', 'en' => 'About' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-overview' => [
            'parent'  => 'about',
            'slug'    => 'overview',
            'title'   => [ 'ar' => 'نبذة عن الجامعة', 'en' => 'About Overview' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-vision' => [
            'parent'  => 'about',
            'slug'    => 'vision-mission',
            'title'   => [ 'ar' => 'الرؤية والرسالة', 'en' => 'Vision & Mission' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-certification' => [
            'parent'  => 'about',
            'slug'    => 'certification-accreditation',
            'title'   => [ 'ar' => 'الشهادة والاعتماد الأكاديمي', 'en' => 'Certification & Accreditation' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-units' => [
            'parent'  => 'about',
            'slug'    => 'presidency-units',
            'title'   => [ 'ar' => 'الوحدات التابعة', 'en' => 'Presidency Units' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-language-translation' => [
            'parent'  => 'about-units',
            'slug'    => 'language-translation',
            'title'   => [ 'ar' => 'مركز تعليم اللغات والترجمة القانونية', 'en' => 'Center for Language Teaching & Legal Translation' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-educational-development' => [
            'parent'  => 'about-units',
            'slug'    => 'educational-development',
            'title'   => [ 'ar' => 'مركز التأهيل والتطوير التربوي', 'en' => 'Educational Development Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-swedish-iraqi-center' => [
            'parent'  => 'about-units',
            'slug'    => 'swedish-iraqi-center',
            'title'   => [ 'ar' => 'المركز الثقافي السويدي العراقي', 'en' => 'Swedish-Iraqi Cultural Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-innovation-center' => [
            'parent'  => 'about-units',
            'slug'    => 'innovation-center',
            'title'   => [ 'ar' => 'مركز الإبداع والابتكار', 'en' => 'Innovation Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'presidency-psychological-counseling' => [
            'parent'  => 'about-units',
            'slug'    => 'psychological-counseling',
            'title'   => [ 'ar' => 'مركز الاستشارات النفسية', 'en' => 'Psychological Counseling Center' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-study' => [
            'parent'  => 'about',
            'slug'    => 'study-exams',
            'title'   => [ 'ar' => 'نظام الدراسة والامتحانات', 'en' => 'Study & Exams' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'about-staff' => [
            'parent'  => 'about',
            'slug'    => 'faculty-staff',
            'title'   => [ 'ar' => 'الكادر التدريسي', 'en' => 'Faculty & Staff' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'colleges' => [
            'slug'    => 'colleges',
            'title'   => [ 'ar' => 'قائمة الكليات', 'en' => 'Colleges' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'programs' => [
            'slug'    => 'programs',
            'title'   => [ 'ar' => 'جميع البرامج', 'en' => 'Programs' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions' => [
            'slug'    => 'admissions',
            'title'   => [ 'ar' => 'القبول والتسجيل', 'en' => 'Admissions' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'admissions-requirements' => [
            'parent'  => 'admissions',
            'slug'    => 'requirements',
            'title'   => [ 'ar' => 'شروط القبول', 'en' => 'Admissions Requirements' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'research' => [
            'slug'    => 'research',
            'title'   => [ 'ar' => 'البحث العلمي', 'en' => 'Research' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
        'contact' => [
            'slug'    => 'contact',
            'title'   => [ 'ar' => 'الاتصال بنا', 'en' => 'Contact' ],
            'content' => [ 'ar' => '', 'en' => '' ],
        ],
    ];

    $page_ids = [];

    foreach ( $pages as $key => $data ) {
        foreach ( $languages as $lang ) {
            $content   = $data['content'][ $lang ] ?? '';
            $parent_id = 0;

            if ( ! empty( $data['parent'] ) && ! empty( $page_ids[ $data['parent'] ][ $lang ] ) ) {
                $parent_id = $page_ids[ $data['parent'] ][ $lang ];
            }

            $post_id = renita_upsert_translated_post( [
                'post_title'   => $data['title'][ $lang ],
                'post_content' => $content,
                'post_type'    => 'page',
                'post_name'    => $data['slug'],
                'post_parent'  => $parent_id,
            ], $lang );

            if ( $post_id ) {
                $page_ids[ $key ][ $lang ] = $post_id;
            }
        }

        if ( function_exists( 'pll_save_post_translations' ) && ! empty( $page_ids[ $key ] ) ) {
            pll_save_post_translations( $page_ids[ $key ] );
        }
    }

    if ( ! empty( $page_ids['front-page'] ) ) {
        update_option( 'page_on_front', $page_ids['front-page']['ar'] ?? array_values( $page_ids['front-page'] )[0] );
        update_option( 'show_on_front', 'page' );
    }

    $colleges = [
        [
            'slug'   => 'applied-sciences',
            'title'  => [ 'ar' => 'كلية العلوم التطبيقية', 'en' => 'College of Applied Sciences' ],
            'departments' => [
                [ 'slug' => 'ai', 'name' => [ 'ar' => 'الذكاء الاصطناعي', 'en' => 'Artificial Intelligence' ] ],
                [ 'slug' => 'computer-software', 'name' => [ 'ar' => 'الحاسوب والبرمجيات', 'en' => 'Computer & Software' ] ],
                [ 'slug' => 'nursing-medical', 'name' => [ 'ar' => 'التمريض والخدمات الطبية', 'en' => 'Nursing & Medical Services' ] ],
                [ 'slug' => 'agro-industrial', 'name' => [ 'ar' => 'التصنيع الزراعي', 'en' => 'Agro-Industrial' ] ],
            ],
        ],
        [
            'slug'   => 'administration-economics',
            'title'  => [ 'ar' => 'كلية الإدارة والاقتصاد', 'en' => 'College of Administration and Economics' ],
            'departments' => [
                [ 'slug' => 'business-administration', 'name' => [ 'ar' => 'إدارة الأعمال', 'en' => 'Business Administration' ] ],
                [ 'slug' => 'information-systems', 'name' => [ 'ar' => 'نظم المعلومات', 'en' => 'Information Systems' ] ],
                [ 'slug' => 'finance-banking', 'name' => [ 'ar' => 'العلوم المالية والمصرفية', 'en' => 'Finance & Banking' ] ],
            ],
        ],
        [
            'slug'   => 'law-political-sciences',
            'title'  => [ 'ar' => 'كلية القانون والعلوم السياسية', 'en' => 'College of Law and Political Sciences' ],
            'departments' => [
                [ 'slug' => 'law', 'name' => [ 'ar' => 'القانون', 'en' => 'Law' ] ],
                [ 'slug' => 'political-science', 'name' => [ 'ar' => 'العلوم السياسية', 'en' => 'Political Science' ] ],
            ],
        ],
        [
            'slug'   => 'engineering-information-technology',
            'title'  => [ 'ar' => 'كلية الهندسة وتكنولوجيا المعلومات', 'en' => 'College of Engineering and Information Technology' ],
            'departments' => [
                [ 'slug' => 'computer-engineering', 'name' => [ 'ar' => 'هندسة الحاسبات', 'en' => 'Computer Engineering' ] ],
                [ 'slug' => 'quality-inspection', 'name' => [ 'ar' => 'هندسة الفحص والسيطرة النوعية', 'en' => 'Quality Inspection & Control Engineering' ] ],
                [ 'slug' => 'electrical-engineering', 'name' => [ 'ar' => 'الهندسة الكهربائية', 'en' => 'Electrical Engineering' ] ],
                [ 'slug' => 'engineering-projects', 'name' => [ 'ar' => 'إدارة المشاريع الهندسية', 'en' => 'Engineering Project Management' ] ],
                [ 'slug' => 'biomedical-engineering', 'name' => [ 'ar' => 'الهندسة الطبية الحيوية', 'en' => 'Biomedical Engineering' ] ],
                [ 'slug' => 'medical-devices', 'name' => [ 'ar' => 'هندسة الأجهزة والمعدات الطبية', 'en' => 'Medical Devices Engineering' ] ],
            ],
        ],
        [
            'slug'   => 'education-human-sciences',
            'title'  => [ 'ar' => 'كلية التربية والعلوم الإنسانية', 'en' => 'College of Education and Human Sciences' ],
            'departments' => [
                [ 'slug' => 'educational-sciences', 'name' => [ 'ar' => 'العلوم التربوية', 'en' => 'Educational Sciences' ] ],
                [ 'slug' => 'psychology', 'name' => [ 'ar' => 'علم النفس', 'en' => 'Psychology' ] ],
                [ 'slug' => 'counseling-guidance', 'name' => [ 'ar' => 'الإرشاد النفسي والتوجيه التربوي', 'en' => 'Counseling & Guidance' ] ],
                [ 'slug' => 'special-education', 'name' => [ 'ar' => 'التربية الخاصة', 'en' => 'Special Education' ] ],
                [ 'slug' => 'islamic-studies', 'name' => [ 'ar' => 'العلوم الشرعية', 'en' => 'Islamic Studies' ] ],
            ],
        ],
        [
            'slug'   => 'allied-medical-sciences',
            'title'  => [ 'ar' => 'كلية العلوم الطبية المساعدة', 'en' => 'College of Allied Medical Sciences' ],
            'departments' => [
                [ 'slug' => 'public-health', 'name' => [ 'ar' => 'الصحة العامة', 'en' => 'Public Health' ] ],
                [ 'slug' => 'clinical-nutrition', 'name' => [ 'ar' => 'التغذية العلاجية', 'en' => 'Clinical Nutrition' ] ],
            ],
        ],
        [
            'slug'   => 'arts-languages',
            'title'  => [ 'ar' => 'كلية الآداب واللغات', 'en' => 'College of Arts and Languages' ],
            'departments' => [
                [ 'slug' => 'arabic-native', 'name' => [ 'ar' => 'اللغة العربية للناطقين بها', 'en' => 'Arabic for Native Speakers' ] ],
                [ 'slug' => 'arabic-non-native', 'name' => [ 'ar' => 'اللغة العربية لغير الناطقين بها', 'en' => 'Arabic for Non-Native Speakers' ] ],
                [ 'slug' => 'english-language', 'name' => [ 'ar' => 'اللغة الإنجليزية', 'en' => 'English Language' ] ],
                [ 'slug' => 'swedish-language', 'name' => [ 'ar' => 'اللغة السويدية', 'en' => 'Swedish Language' ] ],
                [ 'slug' => 'french-language', 'name' => [ 'ar' => 'اللغة الفرنسية', 'en' => 'French Language' ] ],
                [ 'slug' => 'translation', 'name' => [ 'ar' => 'الترجمة', 'en' => 'Translation' ] ],
                [ 'slug' => 'sociology', 'name' => [ 'ar' => 'علم الاجتماع', 'en' => 'Sociology' ] ],
            ],
        ],
        [
            'slug'   => 'graduate-studies-research',
            'title'  => [ 'ar' => 'كلية الدراسات العليا والبحث العلمي', 'en' => 'College of Graduate Studies and Scientific Research' ],
            'departments' => [
                [ 'slug' => 'postdoctoral', 'name' => [ 'ar' => 'مرحلة ما بعد الدكتوراه', 'en' => 'Postdoctoral Studies' ] ],
            ],
        ],
    ];

    $department_term_ids = [];
    $college_ids         = [];

    foreach ( $colleges as $college ) {
        $translations = [];
        foreach ( $languages as $lang ) {
            $post_id = renita_upsert_translated_post( [
                'post_title'   => $college['title'][ $lang ],
                'post_content' => '',
                'post_type'    => 'college',
                'post_name'    => $college['slug'],
            ], $lang );

            if ( $post_id ) {
                $translations[ $lang ] = $post_id;
            }
        }

        if ( ! empty( $translations ) && function_exists( 'pll_save_post_translations' ) ) {
            pll_save_post_translations( $translations );
        }

        $college_ids[ $college['slug'] ] = $translations;

        foreach ( $college['departments'] as $department ) {
            $term_translations = [];
            foreach ( $languages as $lang ) {
                $existing_term = get_terms( [
                    'taxonomy'   => 'department',
                    'hide_empty' => false,
                    'slug'       => $department['slug'],
                    'lang'       => $lang,
                    'fields'     => 'ids',
                ] );

                if ( ! empty( $existing_term ) ) {
                    $term_id = (int) $existing_term[0];
                } else {
                    $inserted = wp_insert_term( $department['name'][ $lang ], 'department', [
                        'slug' => $department['slug'],
                    ] );

                    if ( is_wp_error( $inserted ) ) {
                        continue;
                    }

                    $term_id = (int) $inserted['term_id'];
                    update_term_meta( $term_id, '_renita_seeded', 1 );
                    update_term_meta( $term_id, '_renita_seed_lang', $lang );
                }

                if ( function_exists( 'pll_set_term_language' ) ) {
                    pll_set_term_language( $term_id, $lang );
                }

                $term_translations[ $lang ] = $term_id;
                $department_term_ids[ $department['slug'] ][ $lang ] = $term_id;

                if ( ! empty( $translations[ $lang ] ) ) {
                    wp_set_object_terms( $translations[ $lang ], $department['slug'], 'department', true );
                }
            }

            if ( function_exists( 'pll_save_term_translations' ) && ! empty( $term_translations ) ) {
                pll_save_term_translations( $term_translations );
            }
        }
    }

    $program_types = [
        'preparatory'  => [ 'ar' => 'البرامج التأهيلية', 'en' => 'Preparatory Programs' ],
        'undergraduate' => [ 'ar' => 'البكالوريوس', 'en' => 'Undergraduate' ],
        'masters'      => [ 'ar' => 'الماجستير', 'en' => 'Masters' ],
        'professional' => [ 'ar' => 'المهنية', 'en' => 'Professional' ],
        'postdoctoral' => [ 'ar' => 'ما بعد الدكتوراه', 'en' => 'Postdoctoral' ],
    ];

    $program_type_term_ids = [];

    foreach ( $program_types as $slug => $names ) {
        $term_translations = [];
        foreach ( $languages as $lang ) {
            $term = get_terms( [
                'taxonomy'   => 'program-type',
                'hide_empty' => false,
                'slug'       => $slug,
                'lang'       => $lang,
                'fields'     => 'ids',
            ] );

            if ( ! empty( $term ) ) {
                $term_id = (int) $term[0];
            } else {
                $inserted = wp_insert_term( $names[ $lang ], 'program-type', [ 'slug' => $slug ] );
                if ( is_wp_error( $inserted ) ) {
                    continue;
                }
                $term_id = (int) $inserted['term_id'];
                update_term_meta( $term_id, '_renita_seeded', 1 );
                update_term_meta( $term_id, '_renita_seed_lang', $lang );
            }

            if ( function_exists( 'pll_set_term_language' ) ) {
                pll_set_term_language( $term_id, $lang );
            }

            $term_translations[ $lang ]      = $term_id;
            $program_type_term_ids[ $slug ][ $lang ] = $term_id;
        }

        if ( function_exists( 'pll_save_term_translations' ) ) {
            pll_save_term_translations( $term_translations );
        }
    }

    $programs = [
        [
            'slug'         => 'ai-bachelor',
            'title'        => [ 'ar' => 'بكالوريوس الذكاء الاصطناعي', 'en' => 'BSc Artificial Intelligence' ],
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
            'title'        => [ 'ar' => 'بكالوريوس إدارة الأعمال', 'en' => 'BBA Business Administration' ],
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
            'title'        => [ 'ar' => 'بكالوريوس القانون', 'en' => 'LLB Law' ],
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
            'title'        => [ 'ar' => 'ماجستير العلوم السياسية', 'en' => 'MA Political Science' ],
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
                'requirements'  => [ 'ar' => 'شهادة بكالوريوس في العلوم السياسية أو المجالات ذات الصلة.', 'en' => 'Bachelor\'s degree in political science or related fields.' ],
                'modules'       => [ 'ar' => 'نظرية سياسية، تحليل السياسات، علاقات دولية.', 'en' => 'Political theory, policy analysis, international relations.' ],
            ],
        ],
        [
            'slug'         => 'software-engineering-bsc',
            'title'        => [ 'ar' => 'بكالوريوس هندسة البرمجيات', 'en' => 'BSc Software Engineering' ],
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
            'title'        => [ 'ar' => 'ماجستير الهندسة الطبية الحيوية', 'en' => 'MSc Biomedical Engineering' ],
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
            'slug'         => 'educational-sciences-diploma',
            'title'        => [ 'ar' => 'دبلوم العلوم التربوية', 'en' => 'Diploma in Educational Sciences' ],
            'type'         => 'professional',
            'college_slug' => 'education-human-sciences',
            'department'   => 'educational-sciences',
            'content'      => [
                'ar' => '<p>برنامج متخصص في تطوير مهارات التعليم الحديث.</p>',
                'en' => '<p>A specialized diploma enhancing modern teaching methodologies.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => 'سنة واحدة', 'en' => '1 Year' ],
                'language'      => [ 'ar' => 'العربية', 'en' => 'Arabic' ],
                'delivery_mode' => [ 'ar' => 'عن بعد', 'en' => 'Online' ],
                'requirements'  => [ 'ar' => 'شهادة بكالوريوس أو خبرة تدريسية.', 'en' => 'Bachelor degree or teaching experience.' ],
                'modules'       => [ 'ar' => 'تصميم المناهج، القيادة الصفية، التقييم التربوي.', 'en' => 'Curriculum design, classroom leadership, educational assessment.' ],
            ],
        ],
        [
            'slug'         => 'clinical-nutrition-bsc',
            'title'        => [ 'ar' => 'بكالوريوس التغذية العلاجية', 'en' => 'BSc Clinical Nutrition' ],
            'type'         => 'undergraduate',
            'college_slug' => 'allied-medical-sciences',
            'department'   => 'clinical-nutrition',
            'content'      => [
                'ar' => '<p>برنامج يهيئ مختصين في التغذية العلاجية والممارسات السريرية.</p>',
                'en' => '<p>A program preparing specialists in clinical nutrition and dietetic practice.</p>',
            ],
            'meta'         => [
                'duration'      => [ 'ar' => '4 سنوات', 'en' => '4 Years' ],
                'language'      => [ 'ar' => 'العربية', 'en' => 'Arabic' ],
                'delivery_mode' => [ 'ar' => 'حضوري', 'en' => 'On Campus' ],
                'requirements'  => [ 'ar' => 'شهادة ثانوية علمية مع مقررات كيمياء وأحياء.', 'en' => 'Science high school diploma with chemistry and biology.' ],
                'modules'       => [ 'ar' => 'علم التغذية، الحمية العلاجية، التدريب السريري.', 'en' => 'Nutrition science, therapeutic dietetics, clinical training.' ],
            ],
        ],
        [
            'slug'         => 'translation-master',
            'title'        => [ 'ar' => 'ماجستير الترجمة', 'en' => 'MA Translation' ],
            'type'         => 'masters',
            'college_slug' => 'arts-languages',
            'department'   => 'translation',
            'content'      => [
                'ar' => '<p>برنامج احترافي في الترجمة المتخصصة والقانونية.</p>',
                'en' => '<p>A professional master\'s in specialized and legal translation.</p>',
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
            'slug'         => 'postdoctoral-research',
            'title'        => [ 'ar' => 'برنامج ما بعد الدكتوراه في البحث العلمي', 'en' => 'Postdoctoral Program in Research' ],
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

    foreach ( $programs as $program ) {
        $translations = [];
        foreach ( $languages as $lang ) {
            $post_id = renita_upsert_translated_post( [
                'post_title'   => $program['title'][ $lang ],
                'post_content' => $program['content'][ $lang ] ?? '',
                'post_type'    => 'program',
                'post_name'    => $program['slug'],
            ], $lang );

            if ( $post_id ) {
                wp_set_object_terms( $post_id, $program['department'], 'department', false );
                wp_set_object_terms( $post_id, $program['type'], 'program-type', false );
                update_post_meta( $post_id, '_renita_program_college', $program['college_slug'] );
                $college_post = get_page_by_path( $program['college_slug'], OBJECT, 'college' );
                if ( $college_post ) {
                    $translated_college_id = $college_post->ID;
                    if ( function_exists( 'pll_get_post' ) ) {
                        $translated_college_id = pll_get_post( $college_post->ID, $lang ) ?: $college_post->ID;
                    }
                    update_post_meta( $post_id, '_renita_program_college_name', get_the_title( $translated_college_id ) );
                }
                if ( ! empty( $program['meta'] ) ) {
                    foreach ( $program['meta'] as $meta_key => $meta_value ) {
                        update_post_meta( $post_id, '_renita_program_' . $meta_key, $meta_value[ $lang ] ?? $meta_value['ar'] );
                    }
                }
                update_post_meta( $post_id, '_renita_seeded', 1 );
                $translations[ $lang ] = $post_id;
            }
        }

        if ( function_exists( 'pll_save_post_translations' ) ) {
            pll_save_post_translations( $translations );
        }
    }

    $news_items = [
        [ 'slug' => 'orientation-week', 'title' => [ 'ar' => 'أسبوع التعريف بالطلبة الجدد', 'en' => 'New Students Orientation Week' ] ],
        [ 'slug' => 'research-grant', 'title' => [ 'ar' => 'منحة بحثية جديدة', 'en' => 'New Research Grant' ] ],
        [ 'slug' => 'innovation-award', 'title' => [ 'ar' => 'جائزة الإبداع الجامعي', 'en' => 'University Innovation Award' ] ],
        [ 'slug' => 'partnership-announcement', 'title' => [ 'ar' => 'إعلان شراكة دولية', 'en' => 'International Partnership Announcement' ] ],
        [ 'slug' => 'conference-invitation', 'title' => [ 'ar' => 'دعوة للمؤتمر السنوي', 'en' => 'Annual Conference Invitation' ] ],
        [ 'slug' => 'career-fair', 'title' => [ 'ar' => 'معرض الوظائف السنوي', 'en' => 'Annual Career Fair' ] ],
    ];

    foreach ( $news_items as $news ) {
        $translations = [];
        foreach ( $languages as $lang ) {
            $post_id = renita_upsert_translated_post( [
                'post_title'   => $news['title'][ $lang ],
                'post_content' => '<p>' . esc_html__( 'محتوى افتراضي للخبر.', 'renita' ) . '</p>',
                'post_type'    => 'news',
                'post_name'    => $news['slug'],
            ], $lang );

            if ( $post_id ) {
                $translations[ $lang ] = $post_id;
            }
        }

        if ( function_exists( 'pll_save_post_translations' ) ) {
            pll_save_post_translations( $translations );
        }
    }

    renita_seed_menus( $page_ids, $college_ids, $department_term_ids, $program_type_term_ids );

    update_option( 'renita_seed_version', RENITA_THEME_VERSION );

    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'renita_seed_initial_content' );

function renita_seed_menus( array $page_ids, array $college_ids, array $department_term_ids, array $program_type_term_ids ) {
    $menus = [
        'primary_menu_ar' => 'القائمة الرئيسية',
        'primary_menu_en' => 'Primary Menu',
        'footer_menu_ar'  => 'قائمة التذييل',
        'footer_menu_en'  => 'Footer Menu',
    ];

    foreach ( $menus as $location => $menu_name ) {
        $menu_obj = wp_get_nav_menu_object( $menu_name );
        $menu_id  = $menu_obj ? $menu_obj->term_id : 0;

        if ( ! $menu_id ) {
            $menu_id = wp_create_nav_menu( $menu_name );
        }

        if ( ! $menu_id || is_wp_error( $menu_id ) ) {
            continue;
        }

        $locations = (array) get_theme_mod( 'nav_menu_locations', [] );
        $locations[ $location ] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

        $existing_items = wp_get_nav_menu_items( $menu_id );
        if ( ! empty( $existing_items ) ) {
            continue;
        }

        $lang = false !== strpos( $location, '_en' ) ? 'en' : 'ar';

        renita_menu_add_page( $menu_id, $page_ids['front-page'][ $lang ] ?? 0 );

        $about_parent = renita_menu_add_page( $menu_id, $page_ids['about'][ $lang ] ?? 0 );

        foreach ( [ 'about-overview', 'about-vision', 'about-certification', 'about-units', 'about-study', 'about-staff' ] as $child_key ) {
            $child_parent = $about_parent;
            if ( 'about-units' === $child_key ) {
                $units_parent = renita_menu_add_page( $menu_id, $page_ids['about-units'][ $lang ] ?? 0, $about_parent );
                foreach ( [
                    'presidency-language-translation',
                    'presidency-educational-development',
                    'presidency-swedish-iraqi-center',
                    'presidency-innovation-center',
                    'presidency-psychological-counseling',
                ] as $unit_key ) {
                    renita_menu_add_page( $menu_id, $page_ids[ $unit_key ][ $lang ] ?? 0, $units_parent );
                }
                continue;
            }

            renita_menu_add_page( $menu_id, $page_ids[ $child_key ][ $lang ] ?? 0, $child_parent );
        }

        $colleges_parent = renita_menu_add_page( $menu_id, $page_ids['colleges'][ $lang ] ?? 0 );

        foreach ( $college_ids as $college_slug => $translations ) {
            if ( empty( $translations[ $lang ] ) ) {
                continue;
            }

            $college_item = renita_menu_add_post( $menu_id, $translations[ $lang ], 'college', $colleges_parent );

            foreach ( $department_term_ids as $dept_slug => $dept_translations ) {
                if ( empty( $dept_translations[ $lang ] ) ) {
                    continue;
                }

                if ( ! renita_department_belongs_to_college( $dept_slug, $college_slug ) ) {
                    continue;
                }

                renita_menu_add_tax( $menu_id, $dept_translations[ $lang ], 'department', $college_item );
            }
        }

        $programs_parent = renita_menu_add_page( $menu_id, $page_ids['programs'][ $lang ] ?? 0 );
        foreach ( $program_type_term_ids as $type_slug => $type_translations ) {
            if ( empty( $type_translations[ $lang ] ) ) {
                continue;
            }

            renita_menu_add_tax( $menu_id, $type_translations[ $lang ], 'program-type', $programs_parent );
        }

        $admissions_parent = renita_menu_add_page( $menu_id, $page_ids['admissions'][ $lang ] ?? 0 );
        $admissions_page   = renita_menu_add_page( $menu_id, $page_ids['admissions-requirements'][ $lang ] ?? 0, $admissions_parent );
        if ( $admissions_page ) {
            renita_menu_add_custom( $menu_id, 'الوثائق المطلوبة', 'Required Documents', '#documents', $admissions_parent, $lang );
            renita_menu_add_custom( $menu_id, 'آلية التسجيل', 'Enrollment Process', '#process', $admissions_parent, $lang );
            renita_menu_add_custom( $menu_id, 'الرسوم الدراسية', 'Tuition Fees', '#fees', $admissions_parent, $lang );
            renita_menu_add_custom( $menu_id, 'الأسئلة الشائعة', 'FAQ', '#faq', $admissions_parent, $lang );
        }

        $research_parent = renita_menu_add_page( $menu_id, $page_ids['research'][ $lang ] ?? 0 );
        if ( $research_parent ) {
            renita_menu_add_custom( $menu_id, 'اتفاقيات التوأمة الأكاديمية', 'Academic Twinning Agreements', '#twinning', $research_parent, $lang );
            renita_menu_add_custom( $menu_id, 'المراكز البحثية', 'Research Centers', '#centers', $research_parent, $lang );
            renita_menu_add_custom( $menu_id, 'الإبداع والابتكار', 'Innovation & Creativity', '#innovation', $research_parent, $lang );
        }

        renita_menu_add_archive( $menu_id, 'news', $lang );
        renita_menu_add_post( $menu_id, $page_ids['contact'][ $lang ] ?? 0, 'page' );
    }
}

function renita_menu_add_page( int $menu_id, int $page_id, int $parent = 0 ) {
    if ( ! $page_id ) {
        return 0;
    }

    return wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => get_the_title( $page_id ),
        'menu-item-object'    => 'page',
        'menu-item-object-id' => $page_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}

function renita_menu_add_post( int $menu_id, int $object_id, string $post_type, int $parent = 0 ) {
    if ( ! $object_id ) {
        return 0;
    }

    return wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => get_the_title( $object_id ),
        'menu-item-object'    => $post_type,
        'menu-item-object-id' => $object_id,
        'menu-item-type'      => 'post_type',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}

function renita_menu_add_tax( int $menu_id, int $term_id, string $taxonomy, int $parent = 0 ) {
    if ( ! $term_id ) {
        return 0;
    }

    return wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => get_term_field( 'name', $term_id, $taxonomy ),
        'menu-item-object'    => $taxonomy,
        'menu-item-object-id' => $term_id,
        'menu-item-type'      => 'taxonomy',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}

function renita_menu_add_custom( int $menu_id, string $title_ar, string $title_en, string $url, int $parent = 0, string $lang = 'ar' ) {
    $title = 'en' === $lang ? $title_en : $title_ar;

    return wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => $title,
        'menu-item-url'       => $url,
        'menu-item-type'      => 'custom',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => $parent,
    ] );
}

function renita_menu_add_archive( int $menu_id, string $post_type, string $lang = 'ar' ) {
    $url   = get_post_type_archive_link( $post_type );
    $label = 'news' === $post_type ? ( 'en' === $lang ? 'News & Events' : 'الأخبار والفعاليات' ) : $post_type;

    return wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => $label,
        'menu-item-url'       => $url,
        'menu-item-type'      => 'custom',
        'menu-item-status'    => 'publish',
        'menu-item-parent-id' => 0,
    ] );
}

function renita_department_belongs_to_college( string $department_slug, string $college_slug ): bool {
    $mapping = [
        'applied-sciences'              => [ 'ai', 'computer-software', 'nursing-medical', 'agro-industrial' ],
        'administration-economics'      => [ 'business-administration', 'information-systems', 'finance-banking' ],
        'law-political-sciences'        => [ 'law', 'political-science' ],
        'engineering-information-technology' => [ 'computer-engineering', 'quality-inspection', 'electrical-engineering', 'engineering-projects', 'biomedical-engineering', 'medical-devices' ],
        'education-human-sciences'      => [ 'educational-sciences', 'psychology', 'counseling-guidance', 'special-education', 'islamic-studies' ],
        'allied-medical-sciences'       => [ 'public-health', 'clinical-nutrition' ],
        'arts-languages'                => [ 'arabic-native', 'arabic-non-native', 'english-language', 'swedish-language', 'french-language', 'translation', 'sociology' ],
        'graduate-studies-research'     => [ 'postdoctoral' ],
    ];

    return in_array( $department_slug, $mapping[ $college_slug ] ?? [], true );
}
