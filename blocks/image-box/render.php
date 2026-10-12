<?php
/**
 * Render Image Box Block
 *
 * @param array $attributes Block attributes.
 */

$heading = isset($attributes['image_box_heading']) ? $attributes['image_box_heading'] : '';
$bg_desktop = (!empty($attributes['image_box_image_desktop']['url'])) ? $attributes['image_box_image_desktop'] : null;
$bg_mobile = (!empty($attributes['image_box_image_mobile']['url'])) ? $attributes['image_box_image_mobile'] : null;
$has_bg_image = $bg_desktop || $bg_mobile;

$focal_desktop = !empty($attributes['image_box_focal_point_desktop']) ? $attributes['image_box_focal_point_desktop'] : ['x' => 0.5, 'y' => 0.5];
$focal_mobile = !empty($attributes['image_box_focal_point_mobile']) ? $attributes['image_box_focal_point_mobile'] : ['x' => 0.5, 'y' => 0.5];

// Both breakpoints' focal points are exposed as CSS vars on the same <img> -
// the browser swaps which file that element points to via <picture>/<source>,
// but it stays one DOM node, so the object-position switch has to happen in
// CSS (media query), not by rendering two separate <img> tags.
$img_style = sprintf(
    '--image-box-focal-desktop:%s%% %s%%;--image-box-focal-mobile:%s%% %s%%;',
    esc_attr($focal_desktop['x'] * 100),
    esc_attr($focal_desktop['y'] * 100),
    esc_attr($focal_mobile['x'] * 100),
    esc_attr($focal_mobile['y'] * 100)
);

$class_name = 'image-box';
if (!empty($attributes['className'])) {
    $class_name .= ' ' . $attributes['className'];
}

?>
<div class="<?php echo esc_attr($class_name); ?>" <?php echo !empty($attributes['anchor']) ? 'id="' . esc_attr($attributes['anchor']) . '"' : ''; ?>>
    <?php if ($has_bg_image) : ?>
        <div class="image-box__bg">
            <picture>
                <?php if ($bg_desktop) : ?>
                    <source media="(min-width: 768px)" srcset="<?php echo esc_url($bg_desktop['url']); ?>">
                <?php endif; ?>
                <img
                    src="<?php echo esc_url($bg_mobile ? $bg_mobile['url'] : $bg_desktop['url']); ?>"
                    alt="<?php echo esc_attr($bg_mobile['alt'] ?? $bg_desktop['alt'] ?? ''); ?>"
                    style="<?php echo esc_attr($img_style); ?>"
                    loading="lazy"
                >
            </picture>
        </div>
    <?php endif; ?>

    <?php if ($heading) : ?>
        <h2 class="image-box__heading"><?php echo wp_kses_post($heading); ?></h2>
    <?php endif; ?>
</div>
