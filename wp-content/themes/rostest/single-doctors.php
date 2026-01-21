<?php
//Шаблон страницы врача

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="container doctor-single-container">
  <article class="doctor-single">

    <header class="doctor-header">
      <h1 class="doctor-title"><?php echo esc_html(get_the_title()); ?></h1>
    </header>

    <div class="doctor-content-wrapper">
      <div class="doctor-sidebar">
        <?php if (has_post_thumbnail()) : ?>
        <div class="doctor-image-single">
          <?php
                        the_post_thumbnail('large', array(
                            'class' => 'doctor-main-photo',
                            'alt'   => esc_attr(sprintf(__('Фото врача %s', 'text-domain'), get_the_title()))
                        ));
                        ?>
        </div>
        <?php endif; ?>

        <div class="doctor-meta-box">
          <h3 class="meta-title"><?php echo esc_html__('Информация о враче', 'text-domain'); ?></h3>

          <div class="meta-grid">
            <?php
                        $rating = get_field('rating');
                        if ($rating) :
                            $rating_safe = floatval($rating);
                        ?>
            <div class="meta-item rating-item">
              <span class="meta-icon">⭐</span>
              <div class="meta-content">
                <span class="meta-label"><?php echo esc_html__('Рейтинг', 'text-domain'); ?></span>
                <div class="meta-value">
                  <span class="rating-value"><?php echo esc_html(number_format($rating_safe, 1)); ?>/5</span>
                  <div class="rating-stars">
                    <?php
                                            $full_stars = floor($rating_safe);
                                            $half_star = ($rating_safe - $full_stars) >= 0.5;
                                            $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

                                            for ($i = 0; $i < $full_stars; $i++) echo '★';
                                            if ($half_star) echo '⯨';
                                            for ($i = 0; $i < $empty_stars; $i++) echo '☆';
                                            ?>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>

            <?php
                        $experience = get_field('experience');
                        if ($experience) :
                            $experience_safe = absint($experience);
                        ?>
            <div class="meta-item">
              <span class="meta-icon">📅</span>
              <div class="meta-content">
                <span class="meta-label"><?php echo esc_html__('Стаж работы', 'text-domain'); ?></span>
                <span class="meta-value"><?php echo esc_html($experience_safe); ?>
                  <?php echo esc_html(_n('год', 'года', $experience_safe, 'text-domain')); ?></span>
              </div>
            </div>
            <?php endif; ?>

            <?php
                        $price = get_field('price');
                        if ($price) :
                            $price_safe = absint($price);
                        ?>
            <div class="meta-item">
              <span class="meta-icon">💰</span>
              <div class="meta-content">
                <span class="meta-label"><?php echo esc_html__('Стоимость приема', 'text-domain'); ?></span>
                <span class="meta-value">
                  <?php
                                        echo esc_html__('от', 'text-domain') . ' ';
                                        echo esc_html(number_format($price_safe, 0, ',', ' '));
                                        echo ' ₽';
                                        ?>
                </span>
              </div>
            </div>
            <?php endif; ?>

            <?php
                        $specializations = get_the_terms(get_the_ID(), 'specialization');
                        if ($specializations && !is_wp_error($specializations)) :
                        ?>
            <div class="meta-item">
              <span class="meta-icon">🎯</span>
              <div class="meta-content">
                <span class="meta-label"><?php echo esc_html__('Специализация', 'text-domain'); ?></span>
                <div class="meta-terms">
                  <?php foreach ($specializations as $spec) : ?>
                  <span class="term-tag"><?php echo esc_html($spec->name); ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <?php endif; ?>

            <?php
                        $cities = get_the_terms(get_the_ID(), 'city');
                        if ($cities && !is_wp_error($cities)) :
                        ?>
            <div class="meta-item">
              <span class="meta-icon">📍</span>
              <div class="meta-content">
                <span class="meta-label"><?php echo esc_html__('Город', 'text-domain'); ?></span>
                <div class="meta-terms">
                  <?php foreach ($cities as $city) : ?>
                  <span class="term-tag city-tag"><?php echo esc_html($city->name); ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>

          <button class="appointment-button" type="button">
            📝 <?php echo esc_html__('Записаться на прием', 'text-domain'); ?>
          </button>
        </div>
      </div>

      <div class="doctor-main-content">
        <?php if (has_excerpt()) : ?>
        <div class="doctor-excerpt-single">
          <h3 class="excerpt-title"><?php echo esc_html__('О враче', 'text-domain'); ?></h3>
          <p class="excerpt-text"><?php echo esc_html(get_the_excerpt()); ?></p>
        </div>
        <?php endif; ?>

        <div class="doctor-content-single">
          <?php if (get_the_content()) : ?>
          <h3 class="content-title"><?php echo esc_html__('Подробная информация', 'text-domain'); ?></h3>
          <div class="content-text">
            <?php
                            the_content();
                            ?>
          </div>
          <?php endif; ?>
        </div>

        <div class="doctor-back">
          <a href="<?php echo esc_url(get_post_type_archive_link('doctors')); ?>" class="back-link">
            ← <?php echo esc_html__('Вернуться к списку врачей', 'text-domain'); ?>
          </a>
        </div>
      </div>
    </div>

  </article>
</div>

<?php get_footer(); ?>