<?php
class Ct_Admin_Form
{
    const ID = 'ct-admin-forms';
    public function init()
    {
        add_action('admin_menu', array($this, 'add_menu_page'), 20);
    }
    public function get_id()
    {
        return self::ID;
    }
    public function add_menu_page()
    {
        add_menu_page(
            esc_html__('My menu section', 'ct-admin'),
            esc_html__('My menu section', 'ct-admin'),
            'manage_options',
            $this->get_id(),
            array(&$this, 'load_view'),
            'dashicons-admin-page'
        );
        add_submenu_page(
            $this->get_id(),
            esc_html__('Submenu', 'ct-admin'),
            esc_html__('Submenu', 'ct-admin'),
            'manage_options',
            $this->get_id() . '_view1',
            array(&$this, 'load_view')
        );
    }

    function load_view()
    {
        $this->default_values = $this->get_defaults();
        $this->current_page = ct_admin_current_view();

        $current_views = isset($this->views[$this->current_page]) ? $this->views[$this->current_page] : $this->views['not-found'];
        $step_data_func_name = $this->current_page . '_data';
        $args = [];
        /**
         * prepare data for view
         */
        if (method_exists($this, $step_data_func_name)) {
            $args = $this->$step_data_func_name();
        }
        /**
         * Default Admin Form Template
         */
        echo '<div class="ct-admin-forms ' . $this->current_page . '">';
        echo '<div class="container container1">';
        echo '<div class="inner">';
        $this->includeWithVariables(ct_admin_template_server_path('views/alerts', false));
        $this->includeWithVariables(ct_admin_template_server_path($current_views, false), $args);
        echo '</div>';
        echo '</div>';
        echo '</div> <!-- / ct-admin-forms -->';
    }

    function includeWithVariables($filePath, $variables = array(), $print = true)
    {
        $output = NULL;
        if (file_exists($filePath)) {
            // Extract the variables to a local namespace
            extract($variables);
            // Start output buffering
            ob_start();
            // Include the template file
            include $filePath;
            // End buffering and return its contents
            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;
    }
    /**
     * Prepare data for views
     */
    private function view0_data()
    {
        $args = [];
        $values = array(
            '' => esc_html__('Select', 'ct-admin'),
            'cs' => 'Čeština',
            'de' => 'Deutsch',
            'en' => 'English',
            'es' => 'Español',
            'fr' => 'Français',
            'hr' => 'Hrvatski',
            'hu' => 'Magyar',
            'no' => 'Norwegian',
            'it' => 'Italiano',
            'nl' => 'Nederlands',
            'pl' => 'Polski',
            'pt' => 'Português',
            'ro' => 'Română',
            'ru' => 'Русский',
            'sk' => 'Slovenčina',
            'dk' => 'Danish',
            'bg' => 'Bulgarian',
            'sv' => 'Swedish'
        );
        $args['cookie_content_language'] = $this->render_select('ct-admin-cookie', 'cookie_content_language', $values);
        $args['cookie_content'] = $this->render_textarea('ct-admin-cookie', 'cookie_content');
        $args['cookie_popup_label_accept'] = $this->render_input('ct-admin-cookie', 'cookie_popup_label_accept');
        $args['forgotten_automated_forget'] = $this->render_checkbox('ct-admin-forgotten', 'forgotten_automated_forget');
        return $args;
    }
    private function view1_data()
    {
        $services_args = array(
            'post_type'        => 'any',
            'numberposts'      => -1,
            'suppress_filters' => false,
        );
        $blog_posts = get_posts($services_args);
        $args = [];
        $args['posts'] = $blog_posts;
        // add options
        $values = array(
            'manual'                     => __('Never', 'ct-admin'),
            'ct-admin-weekly'    => __('Weekly', 'ct-admin'),
            'ct-admin-monthly'   => __('Monthly', 'ct-admin'),
            'ct-admin-quarterly' => __('Quarterly', 'ct-admin')
        );
        $args['cookie_scan_period'] = $this->render_select('ct-admin-cookie', 'cookie_scan_period', $values);
        return $args;
    }
    /**
     * Form elements outputs
     */
    private function render_input($group, $key, $required = false)
    {
        $inputValue = isset($this->default_values[$group][$key]) ? stripslashes($this->default_values[$group][$key]) : '';
        $requiredAttr = ($required) ? "required" : '';
        return '<input type="text" id="' . $key . '" name="' . $group . '[' . $key . ']" class="form-control" value="' . $inputValue . '" ' . $requiredAttr . '>';
    }
    private function render_textarea($group, $key)
    {
        $defaultValue = isset($this->default_values[$group][$key]) ? stripslashes($this->default_values[$group][$key]) : '';
        return '<textarea class="form-control" rows="6" autocomplete="off" id="' . $key . '" name="' . $group . '[' . $key . ']">' . $defaultValue . '</textarea>';
    }
    private function render_select($group, $key, $options)
    {
        $selectedVal = isset($this->default_values[$group][$key]) ? $this->default_values[$group][$key] : '';
        $html = '';
        $html .= '<select class="form-control" id="' . $key . '" name="' . $group . '[' . $key . ']">';
        $html .= ($selectedVal == '') ? '<option value=""></option>' : '';
        foreach ($options as $key => $opt) {
            $selectedOpt = '';
            if ($selectedVal == $key) {
                $selectedOpt = 'selected="selected"';
            }
            $html .= '<option value="' . $key . '" ' . $selectedOpt . '>' . $opt . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    private function render_checkbox($group, $key)
    {
        $checkedVal = isset($this->default_values[$group][$key]) ? $this->default_values[$group][$key] : '';
        $checkedAttr = "";
        if ($checkedVal != '') {
            $checkedAttr = "checked";
        }
        $html = '';
        $html .= '
    <input type="hidden" name="' . $group . '[' . $key . ']" value="">
    <input class="form-check-input" type="checkbox" value="on" id="' . $key . '" name="' . $group . '[' . $key . ']" ' . $checkedAttr . '>';
        return $html;
    }
}
function run_ct_wp_admin_form()
{
    $plugin = new Ct_Admin_Form();
    $plugin->init();
}
run_ct_wp_admin_form();
