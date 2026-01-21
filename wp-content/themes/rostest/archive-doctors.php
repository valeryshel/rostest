<?php
/**
 * Шаблон архива для типа записи "Доктора"
 */

get_header(); ?>

<div class="container doctors-container">
  <h1 class="page-title doctors-title">
    <?php echo esc_html__('Наши врачи', 'textdomain'); ?>
  </h1>

  <?php
  if (file_exists(get_template_directory() . '/template-parts/doctors-filter.php')) {
    require get_template_directory() . '/template-parts/doctors-filter.php';
  }
  ?>

  <div class="doctors-archive">
    <?php if (have_posts()) : ?>

    <div class="doctors-grid">
      <?php while (have_posts()) : the_post();
        $post_id = get_the_ID();
        $rating = floatval(get_field('rating', $post_id));//float
        $experience = intval(get_field('experience', $post_id));//integer
        $price = floatval(get_field('price', $post_id));
      ?>

      <article id="post-<?php echo esc_attr($post_id); ?>" <?php post_class('doctor-card'); ?>>

        <!-- Миниатюра -->
        <div class="doctor-image-wrapper">
          <?php if (has_post_thumbnail()) : ?>
          <div class="doctor-thumbnail">
            <a href="<?php echo esc_url(get_permalink()); ?>">
              <?php
              the_post_thumbnail('medium_large', array(
                'class' => 'doctor-photo',
                'alt' => esc_attr(get_the_title())
              ));
              ?>
            </a>
          </div>
          <?php else : ?>
          <div class="doctor-thumbnail no-photo">
            <div class="placeholder-icon">👨‍⚕️</div>
          </div>
          <?php endif; ?>

          <!-- Рейтинг -->
          <?php if ($rating > 0) : ?>
          <div class="doctor-rating-badge">
            <span class="rating-stars"
              aria-label="<?php echo esc_attr(sprintf(__('Рейтинг: %s из 5', 'textdomain'), $rating)); ?>">
              <?php
              $full_stars = floor($rating);
              $half_star = ($rating - $full_stars) >= 0.5;
              $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

              // Безопасный вывод звезд
              echo str_repeat('★', $full_stars);
              if ($half_star) {
                echo '⯨';
              }
              echo str_repeat('☆', $empty_stars);
              ?>
            </span>
            <span class="rating-value"><?php echo esc_html(number_format($rating, 1)); ?></span>
          </div>
          <?php endif; ?>
        </div>

        <!-- Основная информация -->
        <div class="doctor-content">
          <!-- Имя -->
          <h2 class="doctor-name">
            <a href="<?php echo esc_url(get_permalink()); ?>">
              <?php echo esc_html(get_the_title()); ?>
            </a>
          </h2>

          <!-- Специализация -->
          <?php
          $specializations = get_the_terms($post_id, 'specialization');
          if ($specializations && !is_wp_error($specializations)) :
          ?>
          <div class="doctor-specialization">
            <?php
            $specs = array_slice($specializations, 0, 2);
            foreach ($specs as $spec) {
              echo '<span class="specialization-tag">' . esc_html($spec->name) . '</span>';
            }
            ?>
          </div>
          <?php endif; ?>

          <!-- Доп. информация -->
          <div class="doctor-details">
            <?php if ($experience > 0) : ?>
            <div class="doctor-detail-item">
              <span class="detail-icon">📅</span>
              <span class="detail-label"><?php echo esc_html__('Стаж:', 'textdomain'); ?></span>
              <span class="detail-value"><?php echo esc_html($experience); ?>
                <?php echo esc_html(_n('год', 'года', $experience, 'textdomain')); ?></span>
            </div>
            <?php endif; ?>

            <?php if ($price > 0) : ?>
            <div class="doctor-detail-item">
              <span class="detail-icon">💰</span>
              <span class="detail-label"><?php echo esc_html__('Прием от:', 'textdomain'); ?></span>
              <span class="detail-value"><?php echo esc_html(number_format($price, 0, ',', ' ')); ?> ₽</span>
            </div>
            <?php endif; ?>

            <!-- Город -->
            <?php
            $cities = get_the_terms($post_id, 'city');
            if ($cities && !is_wp_error($cities)) :
            ?>
            <div class="doctor-detail-item">
              <span class="detail-icon">📍</span>
              <span class="detail-label"><?php echo esc_html__('Город:', 'textdomain'); ?></span>
              <span class="detail-value"><?php echo esc_html($cities[0]->name); ?></span>
            </div>
            <?php endif; ?>
          </div>

          <!-- Краткое описание -->
          <?php if (has_excerpt()) : ?>
          <div class="doctor-excerpt">
            <?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 15, '...')); ?>
          </div>
          <?php endif; ?>

          <!-- Кнопка -->
          <a href="<?php echo esc_url(get_permalink()); ?>" class="doctor-button">
            <span><?php echo esc_html__('Записаться на прием', 'textdomain'); ?></span>
            <span class="button-arrow" aria-hidden="true">→</span>
          </a>
        </div>

      </article>

      <?php endwhile; ?>
    </div>



    <?php
  if (file_exists(get_template_directory() . '/template-parts/doctors-pagination.php')) {
    require get_template_directory() . '/template-parts/doctors-pagination.php';
  }
  ?>

    <?php else : ?>
    <div class="no-doctors">
      <p class="no-doctors-icon">👨‍⚕️</p>
      <p><?php echo esc_html__('Врачей пока нет в базе', 'textdomain'); ?></p>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>