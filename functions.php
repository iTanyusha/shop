<?
add_action('init', 'theme_customizations');

function theme_customizations()
{
    add_filter('block_categories_all', function ($categories) {
        array_unshift($categories, array(
            'title' => 'Shop Elements',
            'slug' => 'shop-elements'
        ));

        return $categories;
    });

    add_filter('wp_graphql_blocks_process_attributes', function ($attributes, $data, $post_id) {

        if ($data['blockName'] === 'shop/product') {
            $postId = $data['attrs']['data']['product'];
            $attributes['price'] = get_field('price', $postId);
            $attributes['description'] = get_field('description', $postId);
            $attributes['releaseDate'] = get_field('release_date', $postId);
            if (has_post_thumbnail($postId))
                $attributes['image'] = wp_get_attachment_url(get_post_thumbnail_id($postId), 'thumbnail');
            else
                $attributes['image'] = wp_get_attachment_url(291);
        }

        return $attributes;
    }, 0, 3);

    register_block_type(__DIR__ . "/template-parts/blocks/product/block.json");

    function my_customize_rest_cors()
    {
        remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
        add_filter('rest_pre_serve_request', function ($value) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Expose-Headers: Link', false);
            return $value;
        });
    }
    add_action('rest_pre_echo_response', 'my_customize_rest_cors', 15);
}
