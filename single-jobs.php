<?php
get_header();
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
                                <img src="<?= wp_get_attachment_image_url($image, 'medium') ?>" alt="<?php the_title()?> image">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <?php the_content() ?>
            </div>
        </div>
    </section>

</main>
<?php do_action('jobs_after_main_content') ?>
<?php
get_footer();
?>