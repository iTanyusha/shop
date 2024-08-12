<?
$product = get_field('product');
$price = get_field('price', $product->ID);
$release_date = get_field('release_date', $product->ID);
$url = wp_get_attachment_url(get_post_thumbnail_id($product->ID), 'thumbnail');

if (!$url) {
    $url = wp_get_attachment_url(291);
}

$timeZone = new DateTimeZone('Asia/Jerusalem');
$now = new DateTime("now", $timeZone);
$date = new DateTime($release_date, $timeZone);

$notReleased = $release_date && $now < $date;

$dateClass = $notReleased ? 'not-released' : '';

?>

<article class="product">
    <? if ($notReleased) { ?>
        <p class="not-released-header">Not released yet!</p>
    <? } ?>
    <h3 class="<?= $dateClass ?>"><?= $product->post_title ?? 'Select Product' ?></h3>
    <img class="image" src="<?= $url ?>" />
    <p><?= $product->post_excerpt ?>
    </p>
    <p class='price'>$<?= $price ?></p>
    <p class="<?= $dateClass ?>"><?= $release_date ?></p>
</article>