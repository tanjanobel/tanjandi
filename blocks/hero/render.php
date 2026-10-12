<?php
/**
 * Render Hero Block
 *
 * @param array $attributes Block attributes.
 * @param string $content Block content.
 * @param WP_Block $block Block instance.
 */

if ( ! isset( $content ) ) {
    $content = '';
}

$hero_bg_color = isset($attributes['hero_bg_color']) ? $attributes['hero_bg_color'] : 'white';
$hero_anchor = isset($attributes['hero_anchor']) ? $attributes['hero_anchor'] : (isset($attributes['anchor']) ? $attributes['anchor'] : '');
$hero_bg_image = isset($attributes['hero_bg_image']) ? $attributes['hero_bg_image'] : null;
$hero_bg_video = isset($attributes['hero_bg_video_url']) ? $attributes['hero_bg_video_url'] : null;
$hero_bg_video_url = '';
if (is_array($hero_bg_video) && isset($hero_bg_video['url'])) {
    $hero_bg_video_url = $hero_bg_video['url'];
} elseif (is_string($hero_bg_video)) {
    $hero_bg_video_url = $hero_bg_video;
}

$hero_bg_video_poster = isset($attributes['hero_bg_video_poster']) ? $attributes['hero_bg_video_poster'] : null;
$hero_bg_video_poster_url = (is_array($hero_bg_video_poster) && isset($hero_bg_video_poster['url'])) ? $hero_bg_video_poster['url'] : '';
$hero_intro = isset($attributes['hero_intro']) ? $attributes['hero_intro'] : 'Digital Design & Webentwicklung';
$hero_title = isset($attributes['hero_title']) ? $attributes['hero_title'] : 'Digital Design & Webentwicklung';

$class_name = 'hero bg-' . esc_attr($hero_bg_color);
if (!empty($attributes['className'])) {
    $class_name .= ' ' . esc_attr($attributes['className']);
}

?>
<div class="<?php echo $class_name; ?>" <?php echo $hero_anchor ? 'id="' . esc_attr($hero_anchor) . '"' : ''; ?>>
    <?php if ($hero_bg_video_url) : ?>
        <div class="hero__bg-wrapper">
            <video
                class="hero__video"
                autoplay
                muted
                playsinline
                <?php echo $hero_bg_video_poster_url ? 'poster="' . esc_url($hero_bg_video_poster_url) . '"' : ''; ?>
            >
                <source src="<?php echo esc_url($hero_bg_video_url); ?>" type="video/mp4">
            </video>
        </div>
    <?php elseif ($hero_bg_image && isset($hero_bg_image['url'])) : ?>
        <div class="hero__bg-wrapper">
            <div
                class="hero__bg"
                style="background-image: url('<?php echo esc_url($hero_bg_image['url']); ?>');"
            ></div>
        </div>
    <?php endif; ?>

    <div class="hero__content container large">
        <div class="hero__body">
            <p class="hero__intro"><?php echo $hero_intro; // html source ?></p>
            <h1 class="hero__heading">
                <?php echo $hero_title; // html source ?>
            </h1>
            <?php echo $content; ?>
        </div>
    </div>

    <div class="hero__cut-out">
        <svg viewBox="0 0 10 10" class="hero__corner hero__corner--top">
            <path d="M 10,0 A 10,10,0,0,1,0,10 L 10,10"></path>
        </svg>

        <div class="hero__avatar">
            <img src="/wp-content/uploads/2026/03/avatar_tanja-nobel.webp" alt="Avatar von Tanja Nobel">
            <img src="/wp-content/uploads/2026/03/avatar_philipp-nobel.webp" alt="Avatar von Philipp Nobel">
        </div>

        <div class="hero__contact">
            <h2>Persönlich & direkt</h2>
            <p>Ihre Ansprechpartner für Ihr Projekt.</p>
        </div>

        <svg viewBox="0 0 10 10" class="hero__corner hero__corner--bottom">
            <path d="M 10,0 A 10,10,0,0,1,0,10 L 10,10"></path>
        </svg>
    </div>
</div>
