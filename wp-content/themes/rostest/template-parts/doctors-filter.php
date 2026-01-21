<?php
//Фильтр врачкей

if (!defined('ABSPATH')) {
    exit;
}

$current_specialization = isset($_GET['specialization']) ? sanitize_text_field($_GET['specialization']) : '';
$current_city = isset($_GET['city']) ? sanitize_text_field($_GET['city']) : '';
$current_sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';
?>

<form method="get" class="doctors-filters" action="<?php echo esc_url(get_post_type_archive_link('doctors')); ?>">
  <div class="filter-row">
    <?php
wp_nonce_field('filter_doctors', '_wpnonce', true, true);
      ?>

    <!-- Специализация -->
    <div class="filter-group">
      <label for="specialization-filter"><?php echo esc_html__('Специализация:', 'textdomain'); ?></label>
      <select name="specialization" id="specialization-filter" class="filter-select">
        <option value=""><?php echo esc_html__('Все специализации', 'textdomain'); ?></option>
        <?php
                $specializations = get_terms([
                    'taxonomy'   => 'specialization',
                    'hide_empty' => true,
                    'orderby'    => 'name',
                    'order'      => 'ASC'
                ]);

                if (!empty($specializations) && !is_wp_error($specializations)) :
                    foreach ($specializations as $term) :
                        $selected = ($current_specialization === $term->slug) ? 'selected="selected"' : '';
                ?>
        <option value="<?php echo esc_attr($term->slug); ?>" <?php echo $selected; ?>>
          <?php echo esc_html($term->name); ?>
        </option>
        <?php endforeach; endif; ?>
      </select>
    </div>

    <!-- Город -->
    <div class="filter-group">
      <label for="city-filter"><?php echo esc_html__('Город:', 'textdomain'); ?></label>
      <select name="city" id="city-filter" class="filter-select">
        <option value=""><?php echo esc_html__('Все города', 'textdomain'); ?></option>
        <?php
                $cities = get_terms([
                    'taxonomy'   => 'city',
                    'hide_empty' => true,
                    'orderby'    => 'name',
                    'order'      => 'ASC'
                ]);

                if (!empty($cities) && !is_wp_error($cities)) :
                    foreach ($cities as $term) :
                        $selected = ($current_city === $term->slug) ? 'selected="selected"' : '';
                ?>
        <option value="<?php echo esc_attr($term->slug); ?>" <?php echo $selected; ?>>
          <?php echo esc_html($term->name); ?>
        </option>
        <?php endforeach; endif; ?>
      </select>
    </div>

    <!-- Сортировка -->
    <div class="filter-group">
      <label for="sort-filter"><?php echo esc_html__('Сортировка:', 'textdomain'); ?></label>
      <select name="sort" id="sort-filter" class="filter-select">
        <option value=""><?php echo esc_html__('По умолчанию', 'textdomain'); ?></option>
        <option value="rating_desc" <?php selected($current_sort, 'rating_desc'); ?>>
          <?php echo esc_html__('По рейтингу (высокий → низкий)', 'textdomain'); ?>
        </option>
        <option value="rating_asc" <?php selected($current_sort, 'rating_asc'); ?>>
          <?php echo esc_html__('По рейтингу (низкий → высокий)', 'textdomain'); ?>
        </option>
        <option value="price_asc" <?php selected($current_sort, 'price_asc'); ?>>
          <?php echo esc_html__('По цене (низкая → высокая)', 'textdomain'); ?>
        </option>
        <option value="price_desc" <?php selected($current_sort, 'price_desc'); ?>>
          <?php echo esc_html__('По цене (высокая → низкая)', 'textdomain'); ?>
        </option>
        <option value="experience_desc" <?php selected($current_sort, 'experience_desc'); ?>>
          <?php echo esc_html__('По стажу (большой → маленький)', 'textdomain'); ?>
        </option>
        <option value="experience_asc" <?php selected($current_sort, 'experience_asc'); ?>>
          <?php echo esc_html__('По стажу (маленький → большой)', 'textdomain'); ?>
        </option>
      </select>
    </div>

    <!-- Кнопки -->
    <div class="filter-actions">
      <button type="submit" class="filter-button">
        <?php echo esc_html__('Применить', 'textdomain'); ?>
      </button>
      <a href="<?php echo esc_url(get_post_type_archive_link('doctors')); ?>" class="filter-reset">
        <?php echo esc_html__('Сбросить', 'textdomain'); ?>
      </a>
    </div>
  </div>
</form>