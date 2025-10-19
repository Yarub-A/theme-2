<?php
/**
 * عرض برنامج أكاديمي
 */

get_header();
?>
<main id="primary" class="site-main container py-5">
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            $department_terms = wp_get_post_terms( get_the_ID(), 'department' );
            $program_types    = wp_get_post_terms( get_the_ID(), 'program-type' );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
                <header class="mb-4">
                    <h1 class="h2 fw-bold"><?php the_title(); ?></h1>
                    <div class="text-muted small">
                        <?php
                        if ( ! empty( $program_types ) ) {
                            echo esc_html( $program_types[0]->name );
                        }
                        ?>
                    </div>
                </header>
                <div class="entry-content mb-4">
                    <?php the_content(); ?>
                </div>
                <section class="program-meta">
                    <h2 class="h5 mb-3"><?php esc_html_e( 'معلومات البرنامج', 'renita' ); ?></h2>
                    <ul class="list-group">
                        <?php
                        $fields = [
                            'duration'      => __( 'مدة الدراسة', 'renita' ),
                            'language'      => __( 'لغة التدريس', 'renita' ),
                            'delivery_mode' => __( 'طريقة التعلم', 'renita' ),
                            'requirements'  => __( 'متطلبات القبول', 'renita' ),
                        ];

                        foreach ( $fields as $key => $label ) {
                            $value = get_post_meta( get_the_ID(), 'renita_program_' . $key, true );
                            if ( $value ) {
                                echo '<li class="list-group-item"><strong>' . esc_html( $label ) . ':</strong> ' . esc_html( $value ) . '</li>';
                            }
                        }

                        $college_id = (int) get_post_meta( get_the_ID(), 'renita_program_college_id', true );
                        if ( $college_id ) {
                            $college_title = get_the_title( $college_id );
                            $college_link  = get_permalink( $college_id );
                            if ( $college_title ) {
                                echo '<li class="list-group-item"><strong>' . esc_html__( 'الكلية', 'renita' ) . ':</strong> ';
                                if ( $college_link ) {
                                    echo '<a href="' . esc_url( $college_link ) . '">' . esc_html( $college_title ) . '</a>';
                                } else {
                                    echo esc_html( $college_title );
                                }
                                echo '</li>';
                            }
                        }

                        if ( ! empty( $department_terms ) ) {
                            $department_term = $department_terms[0];
                            $department_link = get_term_link( $department_term, 'department' );
                            echo '<li class="list-group-item"><strong>' . esc_html__( 'القسم الأكاديمي', 'renita' ) . ':</strong> ';
                            if ( ! is_wp_error( $department_link ) ) {
                                echo '<a href="' . esc_url( $department_link ) . '">' . esc_html( $department_term->name ) . '</a>';
                            } else {
                                echo esc_html( $department_term->name );
                            }
                            echo '</li>';
                        }

                        $modules = get_post_meta( get_the_ID(), 'renita_program_modules', true );
                        if ( $modules ) {
                            echo '<li class="list-group-item"><strong>' . esc_html__( 'المقررات الأساسية', 'renita' ) . ':</strong> ' . esc_html( $modules ) . '</li>';
                        }
                        ?>
                    </ul>
                </section>
            </article>
            <?php
        }
    }
    ?>
</main>
<?php
get_footer();
