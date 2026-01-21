<div class="doctors-pagination">
  <?php
      the_posts_pagination(array(
        'mid_size'  => 2,
        'prev_text' => esc_html__('← Назад', 'textdomain'),
        'next_text' => esc_html__('Вперед →', 'textdomain'),
      ));
      ?>
</div>