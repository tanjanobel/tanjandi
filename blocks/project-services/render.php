<?php
/**
 * Render Project Services Block
 */

$post_id = get_the_ID();
$services = get_field('project_service', $post_id);

// Ensure we have a clean list in the editor too
if (is_admin() && empty($services)) {
    // Optional: add placeholder text for editor
}

if (!$services && !is_admin()) {
    return;
}

$services_list = is_array($services) ? $services : array($services);
if (empty($services_list) && is_admin()) {
    $services_list = array('Dienstleistung 1', 'Dienstleistung 2');
}
sort($services_list);
?>

<div class="project-services">
    <ul class="project-services__list">
        <?php foreach ($services_list as $service) : ?>
            <li class="project-services__item"><?php echo esc_html($service); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
