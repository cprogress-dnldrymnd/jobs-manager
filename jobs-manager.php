<?php

/**
 * Jobs Manager
 *
 * @author            Donald Raymundo
 *
 * @wordpress-plugin
 * Plugin Name:       Jobs Manager
 * Description:       Jobs Manager by Digitally Disruptive
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Donald Raymundo
 * Text Domain:       jobsmanager
 */

define('JobsManager_Version', '1.0.0');

require plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

require plugin_dir_path(__FILE__) . 'includes/jobs-manager.php';

require plugin_dir_path(__FILE__) . 'includes/admin-page.php';

require plugin_dir_path(__FILE__) . 'includes/post-meta.php';

require plugin_dir_path(__FILE__) . 'includes/post-types.php';

require plugin_dir_path(__FILE__) . 'includes/ajax.php';