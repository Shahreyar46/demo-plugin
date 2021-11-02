<?php

/**
 * Admin class
 *
 * Manage all admin related functionality
 *
 * @package WpCommerz
 */

declare(strict_types=1);

namespace WpCommerz\Admin;

use function WpCommerz\plugin;

/**
 * Admin class.
 *
 * @package WpCommerz\Admin
 */
class Admin
{

    /**
     * Load automatically when class initiate
     *
     * @return void
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_custom_menu']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }

    /**
     * Enqueue admin scripts
     *
     * @param string $hooks Define admin pages.
     *
     * @since 1.0.0
     */
    public function admin_enqueue_scripts() {

        wp_enqueue_style(
            'admin-css', plugin()->assets_dir . 'src/css/Admin/admin.css', [],time()
        );

        wp_enqueue_script(
            'admin-employee-scripts', plugin()->assets_dir . 'src/js/Admin/admin.js', array('jquery'), time(), true
        );

        wp_enqueue_script(
            'admin-employee-settings', plugin()->assets_dir . 'src/js/Admin/settings.js', array('jquery'), time(), true
        );

		wp_localize_script( 'admin-employee-settings', 'EmployeeSetting', [
			'ajaxurl'          => admin_url( 'admin-ajax.php' ),
			'nonce'            => wp_create_nonce( 'employee-settings-nonce' ),
			'i18n_date_format' => get_option( 'date_format' )
		] );
    }

    /**
     * Add  Employee Menu
     *
     * @return void
     */
    public function add_custom_menu()
    {
        add_menu_page(
            __('Employee', 'demo-plugin'),
            __('Employee', 'demo-plugin'),
            'manage_options',
            'employee-setting',
            [$this, 'create_employee_page'],
            'dashicons-admin-users',
            6
        );
    }

    /**
     * Employee Menu Callback
     *
     * @return void
     */
    public function create_employee_page() {

        $all_employees =  get_option('settings_all_employee_names');

       ?>
        <div class="employee-wrap">
            <div class="title">
                <h2> <?php _e('List of Employees ', 'menu-test') ?></h2>
            </div>
            <div class="success-sms">

            </div>

            <form class="form-1" name="form1" method="post" action="">
                
                <table class="form-table">
                    <tbody>

                    <?php             
                        if ( ! empty( $all_employees ) ):    
                    ?>

                    <?php
                    foreach(  $all_employees as $employee_names ):
                        foreach( $employee_names as $emp_name ):

                    ?>
                        <tr>
                            <td width="30%">
                                <input class="employee-name" type="text" name="employee_name[]" placeholder="Name of Person 1 " value=" <?php echo $emp_name; ?>" >
                            </td>
                            
                            <td class="action" width="10%">
									<button class="button button-default remove-employee"><?php esc_html_e( 'Remove', 'demo-plugin' ); ?></button>
							</td>
                        </tr>
                    <?php 
                
                         endforeach; 
                    
                      endforeach;
                    ?>
                        <?php else : ?>
                            <tr>
                                <td width="30%" class="emp-name">
                                    <input class="employee-name" type="text" name="employee_name[]" placeholder="Name of Person 1 " value="" >
                                </td>

                                <td class="action" width="10%">
                                        <button class="button button-default remove-employee"><?php esc_html_e( 'Remove', 'demo-plugin' ); ?></button>
                                </td>
                                </tr>
                             <?php endif; ?>
                       
                    </tbody>
                </table>

                <a href="#"  id="add-new-employee" class="add-new-employee"><?php esc_html_e('Add More', 'demo-plugin'); ?></a>

                <p class="submit">
                    <input id="submit-settings-btn" type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Settings') ?>" />
                </p>

            </form>
        </div>

<?php
    }


}
