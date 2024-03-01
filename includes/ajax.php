<?php
class Ajax
{
	function __construct()
	{
		add_action('wp_ajax_nopriv_jobs_ajax', array($this, 'jobs_ajax'));
		add_action('wp_ajax_jobs_ajax', array($this, 'jobs_ajax'));
	}
	function jobs_ajax()
	{
		$location = $_POST['location'];
		$taxonomy = 'location';
		$post_type = 'jobs';
		$offset = $_POST['offset'];
		$posts_per_page = 5;

		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $posts_per_page,
		);

		if ($offset) {
			$args['offset'] = $offset;
		}

		if ($location) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $location,
				),
			);
		}

		$the_query = new WP_Query($args);

		$count = $the_query->found_posts;

		echo $this->hide_load_more($count, $offset, $posts_per_page);

		if ($the_query->have_posts()) {

			$JobsManager = new JobsManager;
?>
			<?php if (!$offset) { ?>
				<div class="job-wrapper">
				<?php } ?>
				<?php
				while ($the_query->have_posts()) {
					$the_query->the_post(); ?>
					<?php
					$postterms = get_the_terms(get_the_ID(), 'location');
					$salary = $JobsManager->get__post_meta('salary');
					$accordion = $JobsManager->get__post_meta('accordion');
					?>

					<div class="career-holder background-white post-item">
						<div class="inner">
							<div class="body">
								<div class="row align-items-center">
									<div class="col-auto">
										<div class="job-title">
											<h3><?php the_title() ?></h3>
										</div>
									</div>
									<div class="col-auto ">
										<span class="salary">£ <?= $salary ?></span>
									</div>
									<div class="col-auto">
										<div class="location align-center">
											<svg xmlns="http://www.w3.org/2000/svg" width="10.908" height="15.583" viewBox="0 0 10.908 15.583">
												<path id="Icon_material-location-on" data-name="Icon material-location-on" d="M12.954,3A5.45,5.45,0,0,0,7.5,8.454c0,4.091,5.454,10.129,5.454,10.129s5.454-6.038,5.454-10.129A5.45,5.45,0,0,0,12.954,3Zm0,7.4A1.948,1.948,0,1,1,14.9,8.454,1.949,1.949,0,0,1,12.954,10.4Z" transform="translate(-7.5 -3)" fill="#001f2b" />
											</svg>
											<span>
												<?php foreach ($postterms as $postterm) { ?>
													<span><?= $postterm->name ?></span>
												<?php } ?>
											</span>
										</div>
									</div>
								</div>




								<div class="career-description d-none d-sm-block">
									<?php the_content() ?>
								</div>
								<?php if ($accordion) { ?>
									<div class="accordion-holder accordion-style-1">
										<div class="accordion" id="accordion-<?= get_the_ID() ?>">
											<div class="accordion-item d-block d-sm-none">
												<h2 class="accordion-header" id="heading<?= get_the_ID() . '-description'  ?>">
													<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= get_the_ID() . '-description'  ?>" aria-expanded="false" aria-controls="collapse<?= get_the_ID() . '-description'  ?>">
														<i class="fa-solid fa-plus"></i>
														<i class="fa-solid fa-minus"></i>
														<span> Job Description </span>
													</button>
												</h2>
												<div id="collapse<?= get_the_ID() . '-description'  ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= get_the_ID() . '-description'  ?>" data-bs-parent="#accordion-<?= get_the_ID() ?>">
													<div class="accordion-body">
														<?php the_content() ?>
													</div>
												</div>
											</div>
											<?php foreach ($accordion as $key => $acc) { ?>
												<div class="accordion-item">
													<h2 class="accordion-header" id="heading<?= get_the_ID() . '-' . $key ?>">
														<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= get_the_ID() . '-' . $key ?>" aria-expanded="false" aria-controls="collapse<?= get_the_ID() . '-' . $key ?>">
															<svg class="icon-inactive" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
																<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
															</svg>
															<svg class="icon-active" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
																<path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
															</svg>
															<span> <?= $acc['accordion_title'] ?></span>
														</button>
													</h2>
													<div id="collapse<?= get_the_ID() . '-' . $key ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= get_the_ID() . '-' . $key ?>" data-bs-parent="#accordion-<?= get_the_ID() ?>">
														<div class="accordion-body">
															<?= wpautop($acc['accordion_content']) ?>
														</div>
													</div>
												</div>
											<?php } ?>

										</div>
									</div>
								<?php } ?>
							</div>
							<div class="footer">
								<div class="row">
									<?php if ($JobsManager->jobs_single()) { ?>
										<div class="col">
											<div class="button-box">
												<a type="button" class="btn btn-link w-100 d-flex align-items-center" href="<?php the_permalink() ?>">
													<span class="col text-center">LEARN MORE</span>
													<span class="col-auto btn-icon">
														<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right" viewBox="0 0 16 16">
															<path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z" />
														</svg>
													</span>
												</a>
											</div>
										</div>
									<?php } ?>
									<div class="col">
										<div class="button-box">
											<button type="button" class="btn btn-primary w-100 d-flex align-items-center" data-title="<?php the_title() ?>" data-bs-toggle="modal" data-bs-target="#applyModal">
												<span class="col text-center">APPLY FOR THIS POSITION</span>
												<span class="col-auto btn-icon">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right" viewBox="0 0 16 16">
														<path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z" />
													</svg>
												</span>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php wp_reset_postdata() ?>
				<?php if (!$offset) { ?>
				</div>
			<?php } ?>
		<?php
		} else {
		?>
			<h2>No Results Found</h2>
<?php
		}
		die();
	}

	function hide_load_more($count, $offset, $posts_per_page)
	{
		if ($count == ($offset + $posts_per_page) || $count < ($offset + $posts_per_page) || $count < $posts_per_page + 1) {
			return '<style>.load-more {display: none} </style>';
		}
	}
}

new Ajax();
