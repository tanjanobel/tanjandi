<?php
/**
 * Render Project Card Block
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
    // In the editor, use the current post if we are editing a project, or show placeholder
    if (is_admin()) {
        $post_id = get_the_ID();
    }

    if (!$post_id) {
        return;
    }
}

$title = get_the_title($post_id);
$permalink = get_permalink($post_id);
$services = get_field('project_service', $post_id);
$company = get_field('project_company', $post_id);
$project_title = get_field('project_title', $post_id);
$project_lead = get_field('project_lead', $post_id);
$featured = get_field('project_featured', $post_id);

// Normalize services to an array of labels/strings to avoid PHP errors
$services_list = array();
if (is_array($services)) {
    $services_list = $services;
} elseif (!empty($services)) {
    $services_list = array($services);
}

// Get block classes (including custom styles)
$class_name = 'project-card';
if ($featured) {
    $class_name .= ' project-card--featured';
}
if (!empty($attributes['className'])) {
    $class_name .= ' ' . $attributes['className'];
}

$thumbnail = get_the_post_thumbnail($post_id, 'post-thumbnail', array(
    'class' => 'attachment-post-thumbnail size-post-thumbnail wp-post-image',
    'style' => 'object-fit:cover;',
    'loading' => 'lazy',
    'decoding' => 'async'
));

// Falls kein Thumbnail vorhanden ist, könnten wir ein Placeholder nutzen oder den Header weglassen.
?>
    <a href="<?php echo esc_url($permalink); ?>" class="<?php echo esc_attr($class_name); ?>">
        <?php if ($thumbnail) : ?>
            <div class="project-card__header">
                <?php echo $thumbnail; ?>
            </div>
        <?php endif; ?>

        <div class="project-card__body">
            <?php if ($company) : ?>
                <p class="project-card__company"><?php echo esc_html(trim($company)); ?></p>
            <?php endif; ?>

            <?php if ($project_title) : ?>
                <h3 class="project-card__heading"><?php echo esc_html(trim($project_title)); ?></h3>
            <?php endif; ?>

            <?php if ($featured && $project_lead) : ?>
                <p class="project-card__lead"><?php echo esc_html(trim($project_lead)); ?></p>
            <?php endif; ?>

            <?php if ($featured && !empty($services_list)) : ?>
                <ul class="project-card__tags">
                    <?php foreach ($services_list as $service) : ?>
                        <li class="project-card__tag"><?php echo esc_html($service); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="project-card__footer">
                <div class="wp-block-button is-style-outline-white-compact">
                    <span class="wp-block-button__link has-white-color has-text-color has-link-color wp-element-button">
                        <span class="wp-block-button__label">
                            <span class="visually-hidden"><?php echo esc_html(sprintf(__('Projekt %s ansehen', 'tanjandi'), $title)); ?></span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </a>
