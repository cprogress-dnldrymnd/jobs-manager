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
    $application_pack = $JobsManager->get__post_meta('application_pack');
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
                            <div class="title-box">
                                <h2>
                                    <?php the_title() ?>
                                </h2>
                            </div>
                            <?php if ($meta_details) { ?>
                                <div class="meta-details-box">
                                    <?php foreach ($meta_details as $details) { ?>
                                        <p>
                                            <span class="meta-label"><?= $details['meta_label'] ?></span>
                                            <span class="meta-value"><?= $details['meta_value'] ?></span>
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
                        <?php if ($application_pack) { ?>
                            <div class="col">
                                <div class="button-box">
                                    <a type="button" class="btn btn-link w-100 d-flex align-items-center" href="<?php the_permalink() ?>">
                                        <span class="col text-center">DOWNLOAD APPLICATION PACK</span>
                                        <span class="col-auto btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="33.638" height="30" viewBox="0 0 33.638 30">
                                                <path id="Icon_akar-download" data-name="Icon akar-download" d="M18,22.5V4.5m0,18-6-6m6,6,6-6m-21,9,.931,3.728A3,3,0,0,0,6.841,31.5H29.158a3,3,0,0,0,2.91-2.272L33,25.5" transform="translate(-1.181 -3)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col">
                            <div class="button-box">
                                <button type="button" class="apply-button btn btn-primary w-100 d-flex align-items-center" data-title="<?php the_title() ?>" data-bs-toggle="modal" data-bs-target="#applyModal">
                                    <span class="col text-center">UPLOAD YOUR APPLICATION</span>
                                    <span class="col-auto btn-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="33.75" height="34.414" viewBox="0 0 33.75 34.414">
                                            <g id="Group_618" data-name="Group 618" transform="translate(-1524.842 -2345)">
                                                <path id="Path_2262" data-name="Path 2262" d="M24.344,20.021,18,13.68l-6.342,6.342,1.591,1.591,3.626-3.626V34.875h2.25V17.986l3.626,3.626,1.591-1.591Z" transform="translate(1523.714 2344.539)" fill="currentColor" />
                                                <path id="Path_2263" data-name="Path 2263" d="M28.125,11.352v-.1a10.125,10.125,0,0,0-20.25,0v.175a8.6,8.6,0,0,0-4.415,2.3,7.692,7.692,0,0,0-2.335,5.514,8.18,8.18,0,0,0,2.532,5.869,8.547,8.547,0,0,0,5.91,2.455h4.5v-2.25h-4.5a6.294,6.294,0,0,1-6.192-6.074,5.949,5.949,0,0,1,5.7-5.706l1.045-.074V11.25a7.875,7.875,0,0,1,15.75,0V13.5l1.111.014a5.542,5.542,0,0,1,5.639,5.722,5.836,5.836,0,0,1-5.707,6.074h-4.98v2.25h4.98a7.717,7.717,0,0,0,5.705-2.493,8.516,8.516,0,0,0,2.252-5.831A7.787,7.787,0,0,0,28.125,11.352Z" transform="translate(1523.717 2343.875)" fill="currentColor" />
                                            </g>
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