<?php
get_header();
while (have_posts()) {
    the_post();

    $JobsManager = new JobsManager;
    $terms = $JobsManager->get_terms_details('location');
    $jobs_description = $JobsManager->jobs_description();
    $meta_details = $JobsManager->get__post_meta('meta_details');
    $salary = $JobsManager->get__post_meta('salary');
    $image = $JobsManager->get__post_meta('image');
?>
    <?php do_action('jobs_before_main_content') ?>
    <main id="jobs-main">
        <section class="jobs-title-section text-center">
            <div class="container">
                <div class="inner">
                    <div class="heading-box">
                        <h1>
                            <?php the_title() ?>
                        </h1>
                    </div>
                    <?php if ($jobs_description) { ?>
                        <div class="description-box">
                            <?= wpautop($jobs_description) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <section class="job-content">
            <div class="container">
                <div class="top-content">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="heading-box">
                                <h2>
                                    <?php the_title() ?>
                                </h2>
                            </div>
                            <?php if ($meta_details) { ?>
                                <div class="meta-details-box">
                                    <?php foreach ($meta_details as $details) { ?>
                                        <p>
                                            <span class="meta-label"><?= $details['meta_label'] ?></span>
                                            <span class="meta-value"><?= $details['meata_value'] ?></span>
                                        </p>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="salary-box">
                                <span>£<?= $salary ?> per annum</span>
                            </div>
                            <?php if ($image) { ?>
                                <div class="image-box">
                                    <img src="<?= wp_get_attachment_image_url($image, 'medium') ?>" alt="<?php the_title() ?> image">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="main-content">
                    <?php the_content() ?>
                </div>
                <div class="jobs-buttons">
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
                                <button type="button" class="apply-button btn btn-primary w-100 d-flex align-items-center" data-title="<?php the_title() ?>" data-bs-toggle="modal" data-bs-target="#applyModal">
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
        </section>
    </main>
    <?php do_action('jobs_after_main_content') ?>
<?php } ?>
<?php
get_footer();
?>