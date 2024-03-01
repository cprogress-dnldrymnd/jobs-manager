<?php
get_header();
$JobsManager = new JobsManager;
$terms = $JobsManager->get_terms_details('location');
?>
<?php do_action('jobs_before_main_content') ?>
<main id="jobs-main">

    <section class="jobs-title-section text-center">
        <div class="container">
            <div class="inner">
                <div class="heading-box">
                    <h1>
                        <?= get_the_title() ?>
                    </h1>
                </div>
                <?php if (get_the_excerpt()) { ?>
                    <div class="description-box">
                        <?= wpautop(get_the_excerpt()) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="job-content">
        <div class="container">
            
        </div>
    </section>

</main>
<?php do_action('jobs_after_main_content') ?>
<?php
get_footer();
?>