<?php

namespace WGU\WOO\Controllers;

class WC_REST_Product_Categories_Controller_Upgrade extends \WC_REST_Product_Categories_Controller
{
  /**
   * Добавил permalink
   *
   * @param WP_Term         $item    Term object.
   * @param WP_REST_Request $request Request instance.
   * @return WP_REST_Response
   */
  public function prepare_item_for_response($item, $request)
  {
    // Get category display type.
    $display_type = get_term_meta($item->term_id, 'display_type', true);

    // Get category order.
    $menu_order = get_term_meta($item->term_id, 'order', true);

    $data = array(
      'id'          => (int) $item->term_id,
      'name'        => $item->name,
      'slug'        => $item->slug,
      'parent'      => (int) $item->parent,
      'description' => $item->description,
      'display'     => $display_type ? $display_type : 'default',
      'image'       => null,
      'menu_order'  => (int) $menu_order,
      'count'       => (int) $item->count,
      'permalink'       => (string) get_term_link($item->term_id, 'product_cat'),
    );

    // Get category image.
    $image_id = get_term_meta($item->term_id, 'thumbnail_id', true);
    if ($image_id) {
      $attachment = get_post($image_id);

      $data['image'] = array(
        'id'                => (int) $image_id,
        'date_created'      => wc_rest_prepare_date_response($attachment->post_date),
        'date_created_gmt'  => wc_rest_prepare_date_response($attachment->post_date_gmt),
        'date_modified'     => wc_rest_prepare_date_response($attachment->post_modified),
        'date_modified_gmt' => wc_rest_prepare_date_response($attachment->post_modified_gmt),
        'src'               => wp_get_attachment_url($image_id),
        'name'              => get_the_title($attachment),
        'alt'               => get_post_meta($image_id, '_wp_attachment_image_alt', true),
      );
    }

    $context = !empty($request['context']) ? $request['context'] : 'view';
    $data    = $this->add_additional_fields_to_object($data, $request);
    $data    = $this->filter_response_by_context($data, $context);

    $response = rest_ensure_response($data);

    $response->add_links($this->prepare_links($item, $request));

    /**
     * Filter a term item returned from the API.
     *
     * Allows modification of the term data right before it is returned.
     *
     * @param WP_REST_Response  $response  The response object.
     * @param object            $item      The original term object.
     * @param WP_REST_Request   $request   Request used to generate the response.
     */
    return apply_filters("woocommerce_rest_prepare_{$this->taxonomy}", $response, $item, $request);
  }
}
