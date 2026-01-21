<?php
/**
 * Шаблон архива для типа записи "Доктора"
 */

get_header(); ?>

<div class="container doctors-container">
  <h1 class="page-title doctors-title">Наши врачи</h1>







  <!-- Фильтры -->
  <form method="get" class="doctors-filters">
    <div class="filter-row">
      <!-- Специализация -->
      <div class="filter-group">
        <label>Специализация:</label>
        <select name="specialization" class="filter-select">
          <option value="">Все специализации</option>
          <?php
                    $specializations = get_terms(['taxonomy' => 'specialization', 'hide_empty' => true]);
                    foreach ($specializations as $term) :
                        $selected = isset($_GET['specialization']) && $_GET['specialization'] == $term->slug ? 'selected' : '';
                    ?>
          <option value="<?php echo $term->slug; ?>" <?php echo $selected; ?>>
            <?php echo $term->name; ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Город -->
      <div class="filter-group">
        <label>Город:</label>
        <select name="city" class="filter-select">
          <option value="">Все города</option>
          <?php
                    $cities = get_terms(['taxonomy' => 'city', 'hide_empty' => true]);
                    foreach ($cities as $term) :
                        $selected = isset($_GET['city']) && $_GET['city'] == $term->slug ? 'selected' : '';
                    ?>
          <option value="<?php echo $term->slug; ?>" <?php echo $selected; ?>>
            <?php echo $term->name; ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Сортировка -->
      <div class="filter-group">
        <label>Сортировка:</label>
        <select name="sort" class="filter-select">
          <option value="">По умолчанию</option>
          <option value="rating_desc" <?php selected(isset($_GET['sort']) && $_GET['sort'] == 'rating_desc'); ?>>
            По рейтингу (высокий → низкий)
          </option>
          <option value="price_asc" <?php selected(isset($_GET['sort']) && $_GET['sort'] == 'price_asc'); ?>>
            По цене (низкая → высокая)
          </option>
          <option value="experience_desc"
            <?php selected(isset($_GET['sort']) && $_GET['sort'] == 'experience_desc'); ?>>
            По стажу (большой → маленький)
          </option>
        </select>
      </div>

      <!-- Кнопки -->
      <div class="filter-actions">
        <button type="submit" class="filter-button">Применить</button>
        <a href="<?php echo get_post_type_archive_link('doctors'); ?>" class="filter-reset">
          Сбросить
        </a>
      </div>
    </div>
  </form>













  <div class="doctors-archive">
    <?php if (have_posts()) : ?>

    <div class="doctors-grid">
      <?php while (have_posts()) : the_post(); ?>

      <article class="doctor-card">

        <!-- Миниатюра -->
        <div class="doctor-image-wrapper">
          <?php if (has_post_thumbnail()) : ?>
          <div class="doctor-thumbnail">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium_large', array(
                                            'class' => 'doctor-photo'
                                        )); ?>
            </a>
          </div>
          <?php else : ?>
          <div class="doctor-thumbnail no-photo">
            <div class="placeholder-icon">👨‍⚕️</div>
          </div>
          <?php endif; ?>

          <!-- Рейтинг -->
          <?php if ($rating = get_field('rating')) : ?>
          <div class="doctor-rating-badge">
            <span class="rating-stars">
              <?php
                                        $full_stars = floor($rating);
                                        $half_star = ($rating - $full_stars) >= 0.5;
                                        $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

                                        for ($i = 0; $i < $full_stars; $i++) {
                                            echo '★';
                                        }
                                        if ($half_star) {
                                            echo '⯨';
                                        }
                                        for ($i = 0; $i < $empty_stars; $i++) {
                                            echo '☆';
                                        }
                                        ?>
            </span>
            <span class="rating-value"><?php echo $rating; ?></span>
          </div>
          <?php endif; ?>
        </div>

        <!-- Основная информация -->
        <div class="doctor-content">
          <!-- Имя -->
          <h2 class="doctor-name">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </h2>

          <!-- Специализация -->
          <?php
                            $specializations = get_the_terms(get_the_ID(), 'specialization');
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
            <?php if ($experience = get_field('experience')) : ?>
            <div class="doctor-detail-item">
              <span class="detail-icon">📅</span>
              <span class="detail-label">Стаж:</span>
              <span class="detail-value"><?php echo esc_html($experience); ?> лет</span>
            </div>
            <?php endif; ?>

            <?php if ($price = get_field('price')) : ?>
            <div class="doctor-detail-item">
              <span class="detail-icon">💰</span>
              <span class="detail-label">Прием от:</span>
              <span class="detail-value"><?php echo number_format($price, 0, ',', ' '); ?> ₽</span>
            </div>
            <?php endif; ?>

            <!-- Город -->
            <?php
                                $cities = get_the_terms(get_the_ID(), 'city');
                                if ($cities && !is_wp_error($cities)) :
                                ?>
            <div class="doctor-detail-item">
              <span class="detail-icon">📍</span>
              <span class="detail-label">Город:</span>
              <span class="detail-value"><?php echo esc_html($cities[0]->name); ?></span>
            </div>
            <?php endif; ?>
          </div>

          <!-- Краткое описание -->
          <?php if (has_excerpt()) : ?>
          <div class="doctor-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
          </div>
          <?php endif; ?>

          <!-- Кнопка -->
          <a href="<?php the_permalink(); ?>" class="doctor-button">
            <span>Записаться на прием</span>
            <span class="button-arrow">→</span>
          </a>
        </div>

      </article>

      <?php endwhile; ?>
    </div>

    <!-- Пагинация -->
    <div class="doctors-pagination">
      <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '← Назад',
                    'next_text' => 'Вперед →',
                ));
                ?>
    </div>

    <?php else : ?>
    <div class="no-doctors">
      <p class="no-doctors-icon">👨‍⚕️</p>
      <p>Врачей пока нет в базе</p>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>