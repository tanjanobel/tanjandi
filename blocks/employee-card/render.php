<?php
/**
 * Render Employee Card Block
 *
 * @param array $attributes Block attributes.
 * @param string $content Block content.
 * @param WP_Block $block Block instance.
 */

$post_id = null;
if (isset($block->context['postId'])) {
    $post_id = $block->context['postId'];
} elseif (isset($context['postId'])) {
    $post_id = $context['postId'];
} else {
    $post_id = get_the_ID();
}

if (!$post_id) {
    // In the editor, use the current post if we are editing a employee, or show placeholder
    if (is_admin()) {
        $post_id = get_the_ID();
    }

    if (!$post_id) {
        return;
    }
}

$title = get_the_title($post_id);
$permalink = get_permalink($post_id);
$excerpt = get_the_excerpt($post_id);
// Ensure we have a clean excerpt without [...] or "Read More" links if core adds them
$excerpt = wp_strip_all_tags($excerpt);
$employee_name = get_field('employee_name', $post_id);
$employee_job = get_field('employee_job', $post_id);
$employee_linkedin = get_field('employee_linkedin', $post_id);
$employee_email = get_field('employee_email', $post_id);

// Get block classes (including custom styles)
$class_name = 'employee-card';
if (!empty($attributes['className'])) {
    $class_name .= ' ' . $attributes['className'];
}

$thumbnail = get_the_post_thumbnail($post_id, 'post-thumbnail', array(
    'class' => 'attachment-post-thumbnail size-post-thumbnail wp-post-image',
    'style' => 'object-fit:cover;',
    'loading' => 'lazy',
    'decoding' => 'async'
));

?>
    <div class="<?php echo esc_attr($class_name); ?>">
        <?php if ($thumbnail) : ?>
            <div class="employee-card__header">
                <?php echo $thumbnail; ?>
            </div>
        <?php endif; ?>

        <div class="employee-card__body">
            <?php if ($employee_name) : ?>
                <h3 class="employee-card__heading"><?php echo esc_html(trim($employee_name)); ?></h3>
            <?php endif; ?>

            <?php if ($employee_job) : ?>
                <p class="employee-card__lead"><?php echo esc_html(trim($employee_job)); ?></p>
            <?php endif; ?>

            <?php if ($employee_linkedin || $employee_email) : ?>
                <div class="employee-card__socials">
                    <?php if ($employee_linkedin) : ?>
                        <a
                            href="<?php echo esc_url($employee_linkedin); ?>"
                            class="employee-card__social-link"
                            target="_blank"
                            rel="noopener"
                            aria-label="LinkedIn-Profil von <?php echo esc_attr(trim($employee_name)); ?>"
                        >
                            <svg role="img" class="employee-card__social-icon" width="14" height="14">
                                <use xlink:href="/wp-content/themes/tanjandi/static/icons/symbol/icon-sprite.svg#linkedin"></use>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ($employee_email) : ?>
                        <a
                            href="mailto:<?php echo esc_attr($employee_email); ?>"
                            class="employee-card__social-link"
                            aria-label="E-Mail an <?php echo esc_attr(trim($employee_name)); ?>"
                        >
                            <svg role="img" class="employee-card__social-icon" width="18" height="18">
                                <use xlink:href="/wp-content/themes/tanjandi/static/icons/symbol/icon-sprite.svg#envelope"></use>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
