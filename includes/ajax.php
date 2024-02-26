<?php
/*
add_action('wp_ajax_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');
function ql_woocommerce_ajax_add_to_cart()
{
$product_id = apply_filters('ql_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
$quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
$variation_id = absint($_POST['variation_id']);
$passed_validation = apply_filters('ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
$product_status = get_post_status($product_id);
if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
do_action('ql_woocommerce_ajax_added_to_cart', $product_id);
if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) {
wc_add_to_cart_message(array($product_id => $quantity), true);
}
WC_AJAX::get_refreshed_fragments();
}
else {
$data = array(
'error'       => true,
'product_url' => apply_filters('ql_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
);
echo wp_send_json($data);
}
wp_die();
}
*/

add_action('wp_ajax_nopriv_archive_ajax', 'archive_ajax'); // for not logged in users
add_action('wp_ajax_archive_ajax', 'archive_ajax');
function archive_ajax()
{
	$DisplayData = new DisplayData();
	$taxonomy = $_POST['taxonomy'];
	$posts_per_page_val = $_POST['posts_per_page'];
	$terms = $_POST['terms'];
	$s = $_POST['s'];
	$offset = $_POST['offset'];
	$page = $_POST['page'];
	$terms_category = $_POST['terms_category'];
	$post_types = $_POST['post_types'];
	$posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
	$is_search = $_POST['is_search'];
	$sortby = $_POST['sortby'];
	$args = array();
	if ($is_search) {
		$class = 'col-lg-4';
		if ($post_types) {
			$post_type = explode(',', $post_types);
		} else {
			$post_type = 'any';
		}
		$args['paged'] = $page;
	} else {
		$post_type = $_POST['post_type'];
		if ($post_type == 'post' || $taxonomy) {
			$class = 'col-lg-6';

			if ($post_type == 'casestudies' || $post_type == 'guides' || $post_type== 'events' || $post_type== 'webinars')  {
				$class = 'col-lg-4';
			}

			$args['paged'] = $page;
		} else {
			$class = 'col-xl-3 col-lg-4';
			if ($offset) {
				$args['offset'] = $offset;
			}
		}
	}


	$args['post_type'] = $post_type;
	$args['posts_per_page'] = $posts_per_page;
	$args['post_status'] = 'publish';

	if ($terms || $terms_category) {
		if ($taxonomy != 'category') {
			$args['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $terms . $terms_category,
				),
			);
		} else {
			$args['cat'] = $terms . $terms_category;
		}
	}

	if ($s) {
		$args['s'] = $s;
	}

	if ($sortby) {

		if ($sortby == 'name-a-z') {
			$args['order'] = 'ASC';
			$args['orderby'] = 'title';
		} else if ($sortby == 'name-z-a') {
			$args['order'] = 'DESC';
			$args['orderby'] = 'title';
		} else if ($sortby == 'date-asc') {
			$args['order'] = 'ASC';
			$args['orderby'] = 'datte';
		} else if ($sortby == 'date-desc') {
			$args['order'] = 'DESC';
			$args['orderby'] = 'date';
		}
	}


	$the_query = new WP_Query($args);

	$found_posts = $the_query->found_posts;
	$post_count = $the_query->post_count;


	if ($page == 1) {
		$post_count_val = $post_count;
	} else {
		$post_count_val = ($page - 1) * $posts_per_page + $post_count;
	}
?>
	<div class="row gy-3 product-holder product-grid post-box-PostSlider">
		<?php
		if ($the_query->have_posts()) {
			while ($the_query->have_posts()) {
				$the_query->the_post();
		?>
				<div class="<?= $class ?> col-sm-6 post-item">
					<div class="swiper-slide product-box">
						<div class="inner background-white d-block ">
							<a href="<?= get_permalink() ?>" class="box-link"></a>
							<div class="image-holder position-relative">
								<?php
								$DisplayData->image(
									array(
										'image_id'    => get_post_thumbnail_id(),
										'size'        => 'medium',
										'placeholder' => true
									),
									'position-relative image-cover-transform ' . (get_post_type() == 'post' ? 'image-post' : '')
								);
								if ($is_search) {
									if (get_post_type() == 'post') {
										$post_type_val = 'blog';
									} else {
										$post_type_val = get_post_type();
									}

									if (get_post_type() == 'post') {
										$button_text = 'Read more';
									} else if (get_post_type() == 'webinars') {
										$button_text = 'Watch webinar';
									} else if (get_post_type() == 'product') {
										$button_text = 'View product';
									} else if (get_post_type() == 'page') {
										$button_text = 'View page';
									} else if (get_post_type() == 'events') {
										$button_text = 'View events';
									}
									echo '<span class="badge"> ' . $post_type_val . ' </span>';
								}
								?>
							</div>
							<?php if (get_post_type() == 'post' || get_post_type() == 'casestudies' || get_post_type() == 'events') { ?>
								<?php

								if (get_post_type() == 'post') {
									$post_tax = 'category';
								} else if (get_post_type() == 'casestudies') {
									$post_tax = 'case_study_category';
								} else if (get_post_type() == 'events') {
									$post_tax = 'events_category';
								}
								$categories = get_the_terms(get_the_ID(), $post_tax);
								?>
								<div class="top-box">
									<div class="meta-box d-flex flex-wrap">
										<span class="date">
											<?php
											foreach ($categories as $cat) {
											?>
												<a href="<?= get_term_link($cat->term_id, $post_tax) ?>"><?= $cat->name ?></a>
											<?php
											}
											?>
										</span>

										<?php if (get_post_type() == 'post') { ?>
											<div class="bull">&bull;</div>
											<span class="author">
												<?php
												$author_id = get_post_field('post_author', get_the_ID());
												$author_name = get_the_author_meta('display_name', $author_id);
												?>
												<?= $author_name ?>
											</span>
										<?php } ?>

									</div>
								</div>
							<?php } ?>
							<div class="heading-box">
								<h4>
									<?= get_the_title() ?>
								</h4>

								<?php
								$DisplayData->description(
									array(
										'description' => custom_excerpt_length(get_the_excerpt(), 20),
									)
								);
								?>
							</div>

							<div class="bottom-box">

								<div class="link-box">
									<a href="<?= get_permalink() ?>" class="link-underline fw-medium">
										<?= $button_text ? $button_text : 'Read more' ?>
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
											<path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
										</svg>
									</a>
								</div>
							</div>

						</div>
					</div>
				</div>
			<?php }
		} else {
			?>
			<h2>No Results Found</h2>
		<?php
		}
		wp_reset_postdata();
		?>
	</div>

	<div class="pagination justify-content-center align-items-center">
		<?php
		echo paginate_links(array(
			'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
			'total'        => $the_query->max_num_pages,
			'current'      => max(1, $page),
			'format'       => '?paged=%#%',
			'show_all'     => false,
			'type'         => 'plain',
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => sprintf('<i></i> %1$s', __('< Previous', 'text-domain')),
			'next_text'    => sprintf('%1$s <i></i>', __('Next >', 'text-domain')),
			'add_args'     => false,
			'add_fragment' => '',
		));
		?>
	</div>
	<script>
		jQuery(document).ready(function() {
			jQuery('.total-post').text('<?= $found_posts ?>');
			jQuery('.result-post').text('<?= $post_count_val ?>');
		});
	</script>

<?php

	die();
}
/*
add_action('wp_ajax_nopriv_product_modal_ajax', 'product_modal_ajax'); // for not logged in users
add_action('wp_ajax_product_modal_ajax', 'product_modal_ajax');
function product_modal_ajax()
{
	$SVG = new SVG;
	$GetData = new GetData();
	$Modules = new Modules;
	$product_id = $_POST['product_id'];
	$type = 'modal';
	$product = wc_get_product($product_id);
	$name = $product->get_name();
	$main_image = $product->get_image_id() ? $product->get_image_id() : get__theme_option('placeholder_image');
	$images = $product->get_gallery_image_ids();
	$type = $product->get_type();

?>
	<div class="product-modal-backdrop d-block d-lg-none product-modal-trigger close-button"></div>
	<div class="product-modal-header">
		<div class="container background-white">
			<div class="inner d-flex justify-content-between align-items-center">
				<h2 class="m-0 fw-bold"><?= $name ?> </h2>
				<button type="button" class="product-modal-trigger d-flex close-button align-items-center">
					<span class="close-text">CLOSE</span>
					<span class="close-icon background-body d-flex justify-content-center"><?php SVG::close() ?></span>
				</button>
			</div>
		</div>
	</div>
	<div class="product-modal-body">
		<div class="product-modal-backdrop d-none d-lg-block product-modal-trigger close-button"></div>
		<div class="container position-relative">
			<div class="inner">
				<?php
				include(get_stylesheet_directory() . '/template-parts/woocommerce/product-details/product-details.php');
				include(get_stylesheet_directory() . '/template-parts/woocommerce/product-details/product-featured-video.php');
				include(get_stylesheet_directory() . '/template-parts/woocommerce/product-details/product-specifications.php');
				$Modules->modules_section($product_id);
				?>
			</div>
		</div>
	</div>
	<div class="product-modal-footer d-none d-xl-block">
		<div class="container background-white">

			<?= $GetData->add_to_cart($product_id) ?>
		</div>
	</div>
	<?php
	if ($type == 'variable') {
		$variations = $product->get_available_variations();
	?>
		<script>
			<?php foreach ($variations as $variation) { ?>
				<?php foreach ($variation['attributes'] as $attribute) { ?>
					var $variation_name = '<?= $attribute ?>';
				<?php } ?>
				var $variation_id = '<?= $variation['variation_id']; ?>';
				var $price = '<?= $variation['display_price']; ?>';

				<?php
				if (is_user_logged_in()) {
					$customer_type = carbon_get_user_meta(get_current_user_id(), 'customer_type');
				} else {
					$customer_type = 'business';
				}
				?>
				$customer_type = '<?= $customer_type ?>';

				if ($customer_type == 'consumer') {
					$price = parseInt($price);
					$price = $price + ($price * .2);
					$price = $price.toFixed(2);
					$price = $price.toLocaleString();

					$price_val = '£' + $price + ' Incl. VAT';
				} else {
					$price_val = '£' + $price + ' Excl. VAT';
				}

				jQuery('.variations_form option[value="' + $variation_name + '"]').attr('id', $variation_id).attr('data-price', $price_val);

				jQuery('.variations_form select').change(function(e) {
					$val = jQuery(this).find(':selected').attr('id');
					if ($val == 0) {
						$pricev = 'FREE TRIAL';
					} else {
						$pricev = jQuery(this).find(':selected').attr('data-price');
					}
					jQuery('.ajax_add_to_cart').attr('data-product_id', $val);
					jQuery('.variation-price').text($pricev);

				});
			<?php } ?>
		</script>
	<?php } ?>

<?php
	die();
}
*/