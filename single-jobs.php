<?php
get_header();
$JobsManager = new JobsManager;
$terms = $JobsManager->get_terms_details('location');
$jobs_description = $JobsManager->jobs_description();
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
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<?php do_action('jobs_after_main_content') ?>
<?php
get_footer();
?>