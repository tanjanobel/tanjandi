<?php
/**
 * Render Subheader Block
 */

$post_id = get_the_ID();
$title = get_the_title($post_id);
$intro = get_field('subheader_intro'); // Vermutung der Feldnamen basierend auf Klassen
$lead = get_field('subheader_lead');

?>
<header class="subheader">
    <div class="subheader__container grid-container">
        <div class="subheader__content">
            <?php if ($intro) : ?>
                <div class="subheader__intro"><?php echo esc_html($intro); ?></div>
            <?php endif; ?>

            <h1 class="subheader__heading"><?php echo esc_html($title); ?></h1>

            <?php if ($lead) : ?>
                <div class="subheader__lead"><?php echo wp_kses_post($lead); ?></div>
            <?php endif; ?>
        </div>
    </div>
</header>
