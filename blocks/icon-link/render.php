<?php
/**
 * Render Icon Link Block
 *
 * @param array $attributes Block attributes.
 * @param string $content Block content.
 * @param WP_Block $block Block instance.
 */

$icon_class = isset($attributes['icon_class']) ? $attributes['icon_class'] : '';
$icon_link = isset($attributes['icon_link']) ? $attributes['icon_link'] : '';
$icon_target = isset($attributes['icon_target']) ? $attributes['icon_target'] : '_self';
$icon_title = isset($attributes['icon_title']) ? $attributes['icon_title'] : '';
$icon_width_mobile = isset($attributes['icon_width_mobile']) ? $attributes['icon_width_mobile'] : '24';
$icon_width = isset($attributes['icon_width']) ? $attributes['icon_width'] : '24';
$icon_symbol = isset($attributes['icon_symbol']) ? $attributes['icon_symbol'] : 'arrow-right';
$icon_color_slug = isset($attributes['icon_color']['slug']) ? $attributes['icon_color']['slug'] : 'ink';
$icon_text = isset($attributes['icon_text']) ? $attributes['icon_text'] : '';

$wrapper_class = 'icon-button';
if ($icon_class) {
    $wrapper_class .= ' ' . esc_attr($icon_class);
}
if (!empty($attributes['className'])) {
    $wrapper_class .= ' ' . esc_attr($attributes['className']);
}
?>

<div class="<?php echo $wrapper_class; ?>">
    <?php if ($icon_link) : ?>
    <a href="<?php echo esc_url($icon_link); ?>" class="icon-button__link" target="<?php echo esc_attr($icon_target); ?>" aria-label="<?php echo esc_attr($icon_title); ?>">
    <?php endif; ?>

    <?php if ($icon_width_mobile) : ?>
    <svg
        role="img"
        class="icon-button__icon icon <?php echo esc_attr($icon_color_slug); ?> hide-for-laptop"
        height="<?php echo esc_attr($icon_width_mobile); ?>"
        width="<?php echo esc_attr($icon_width_mobile); ?>"
        style="width: <?php echo esc_attr($icon_width_mobile); ?>px; height: <?php echo esc_attr($icon_width_mobile); ?>px;"
    >
        <use xlink:href="/wp-content/themes/tanjandi/static/icons/symbol/icon-sprite.svg#<?php echo esc_attr($icon_symbol); ?>"></use>
    </svg>
    <?php endif; ?>

    <?php if ($icon_width) : ?>
    <svg
        role="img"
        class="icon-button__icon icon <?php echo esc_attr($icon_color_slug); ?> show-for-laptop"
        height="<?php echo esc_attr($icon_width); ?>"
        width="<?php echo esc_attr($icon_width); ?>"
        style="width: <?php echo esc_attr($icon_width); ?>px; height: <?php echo esc_attr($icon_width); ?>px;"
    >
        <use xlink:href="/wp-content/themes/tanjandi/static/icons/symbol/icon-sprite.svg#<?php echo esc_attr($icon_symbol); ?>"></use>
    </svg>
    <?php endif; ?>

    <?php if ($icon_text) : ?>
    <span class="icon-button__text <?php echo esc_attr($icon_color_slug); ?>">
        <?php echo $icon_text; ?>
    </span>
    <?php endif; ?>

    <?php if ($icon_link) : ?>
    </a>
    <?php endif; ?>
</div>
