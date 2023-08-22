<?php
/**
 * The file that defines the Graph_Widget plugin class.
 *
 * A class definition that includes attributes and functions used for the admin area.
 *
 * @since 1.0.0
 * @package Graph_Widget
 */

/*
Plugin Name: Graph Widget
Description: A WordPress Graph Widget using ReactJS and WP REST API.
Version: 1.0
Author: Sandeep Jain
Author URI: https://sandeepjain.me/
*/

/**
 * Class Graph_Widget
 *
 * This class represents a WordPress plugin that adds a custom dashboard widget containing a graph.
 */
class Graph_Widget {

	/**
	 * Constructor function for the main class.
	 * This function sets up various actions and hooks when the class is initialized.
	 */
	public function __construct() {
		// Hook into the 'plugins_loaded' action with a priority of 0 (early) to define constants.
		add_action( 'plugins_loaded', array( $this, 'define_constants' ), 0 );

		// Register the 'graph_widget_activate' method as a callback for the plugin activation hook.
		// This ensures that the Graph Widget's activation function is executed when the plugin is activated.
		register_activation_hook( __FILE__, array( $this, 'graph_widget_activate' ) );

		// Hook into the 'admin_enqueue_scripts' action to enqueue necessary scripts for the admin area.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Add all required files.
		spl_autoload_register( array( $this, 'graph_widget_autoloader' ) );
		// Hook into the 'wp_dashboard_setup' action to add a custom dashboard widget.
		add_action( 'wp_dashboard_setup', array( $this, 'add_graph_widget' ) );
		add_action( 'plugins_loaded', array( 'Graph_Widget_Api', 'init' ) );
	}
		/**
		 * Initialize the plugin.
		 *
		 * This static method creates an instance of the current class to start the rest api functionality.
		 *
		 * @static
		 */
	public static function init() {
		$class = __CLASS__;
		new $class();
	}
	/**
	 * Activate function for the graph widget.
	 *
	 * This function is called when the graph widget is activated. It initializes and stores dummy data for the graph
	 * in the database as a serialized option value.
	 *
	 * The dummy data contains an array of associative arrays, where each inner array represents a data entry for the graph.
	 * Each data entry includes 'date', 'name', 'students', and 'fees' fields.
	 *
	 * Example:
	 * [
	 *    ['date' => '2023-06-12', 'name' => 'php', 'students' => 200, 'fees' => 2000],
	 *    ['date' => '2023-06-14', 'name' => 'java', 'students' => 200, 'fees' => 4000],
	 *    ...
	 * ]
	 *
	 * The serialized data is then saved as a single option value in the database with the name 'react_dummy_data'.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function graph_widget_activate() {
		$data            = array(
			array(
				'date'     => '2023-06-12',
				'name'     => 'php',
				'students' => 200,
				'fees'     => 2000,
			),
			array(
				'date'     => '2023-06-14',
				'name'     => 'java',
				'students' => 200,
				'fees'     => 4000,
			),
			array(
				'date'     => '2023-06-15',
				'name'     => 'react',
				'students' => 500,
				'fees'     => 6000,
			),
			array(
				'date'     => '2023-06-16',
				'name'     => 'python',
				'students' => 150,
				'fees'     => 3000,
			),
			array(
				'date'     => '2023-06-17',
				'name'     => 'javascript',
				'students' => 300,
				'fees'     => 5000,
			),
			array(
				'date'     => '2023-06-18',
				'name'     => 'c++',
				'students' => 250,
				'fees'     => 4500,
			),
			array(
				'date'     => '2023-06-19',
				'name'     => 'ruby',
				'students' => 120,
				'fees'     => 2200,
			),
			array(
				'date'     => '2023-06-20',
				'name'     => 'html',
				'students' => 180,
				'fees'     => 3200,
			),
			array(
				'date'     => '2023-06-21',
				'name'     => 'css',
				'students' => 90,
				'fees'     => 1800,
			),
			array(
				'date'     => '2023-06-22',
				'name'     => 'sql',
				'students' => 220,
				'fees'     => 4200,
			),
			array(
				'date'     => '2023-06-23',
				'name'     => 'flutter',
				'students' => 350,
				'fees'     => 5500,
			),
			array(
				'date'     => '2023-06-24',
				'name'     => 'swift',
				'students' => 280,
				'fees'     => 4800,
			),
			array(
				'date'     => '2023-06-25',
				'name'     => 'kotlin',
				'students' => 190,
				'fees'     => 3400,
			),
			array(
				'date'     => '2023-06-26',
				'name'     => 'typescript',
				'students' => 270,
				'fees'     => 4600,
			),
			array(
				'date'     => '2023-06-27',
				'name'     => 'scala',
				'students' => 110,
				'fees'     => 2400,
			),
			array(
				'date'     => '2023-06-28',
				'name'     => 'go',
				'students' => 130,
				'fees'     => 2600,
			),
			array(
				'date'     => '2023-06-29',
				'name'     => 'rust',
				'students' => 80,
				'fees'     => 1600,
			),
			array(
				'date'     => '2023-08-03',
				'name'     => 'php',
				'students' => 80,
				'fees'     => 1600,
			),
			array(
				'date'     => '2023-08-04',
				'name'     => 'react',
				'students' => 420,
				'fees'     => 2800,
			),
			array(
				'date'     => '2023-08-08',
				'name'     => 'python',
				'students' => 240,
				'fees'     => 4200,
			),
			array(
				'date'     => '2023-08-06',
				'name'     => 'javascript',
				'students' => 390,
				'fees'     => 2200,
			),
			array(
				'date'     => '2023-08-08',
				'name'     => 'c++',
				'students' => 280,
				'fees'     => 4500,
			),
			array(
				'date'     => '2023-08-08',
				'name'     => 'html',
				'students' => 170,
				'fees'     => 3000,
			),
			array(
				'date'     => '2023-08-09',
				'name'     => 'css',
				'students' => 110,
				'fees'     => 2000,
			),
			array(
				'date'     => '2023-08-10',
				'name'     => 'sql',
				'students' => 320,
				'fees'     => 5200,
			),
			array(
				'date'     => '2023-08-11',
				'name'     => 'flutter',
				'students' => 420,
				'fees'     => 6000,
			),
			array(
				'date'     => '2023-07-12',
				'name'     => 'swift',
				'students' => 320,
				'fees'     => 4800,
			),
			array(
				'date'     => '2023-07-13',
				'name'     => 'kotlin',
				'students' => 210,
				'fees'     => 3600,
			),
			array(
				'date'     => '2023-07-14',
				'name'     => 'typescript',
				'students' => 310,
				'fees'     => 2200,
			),
			array(
				'date'     => '2023-08-15',
				'name'     => 'scala',
				'students' => 130,
				'fees'     => 2400,
			),
			array(
				'date'     => '2023-08-16',
				'name'     => 'go',
				'students' => 140,
				'fees'     => 2600,
			),
			array(
				'date'     => '2023-08-20',
				'name'     => 'java',
				'students' => 190,
				'fees'     => 3800,
			),
		);
		$serialized_data = serialize( $data );

		// Save the serialized data as a single option value in the database.
		update_option( 'react_dummy_data', $serialized_data );
	}

	/**
	 * Define constants used by the plugin.
	 */
	public function define_constants() {
		// Define the plugin directory path.
		define( 'GRAPH_WIDGET_DIR', plugin_dir_path( __FILE__ ) );

		// Define the plugin directory URL.
		define( 'GRAPH_WIDGET_URL', plugin_dir_url( __FILE__ ) );
	}
	/**
	 * Enqueue ReactJS script and pass data to it using wp_localize_script.
	 *
	 * This function is called when loading the admin area of WordPress (hooked to 'admin_enqueue_scripts').
	 * It checks if the current admin page is the index.php and enqueues the 'graph-widget-script' with the provided details.
	 *
	 * The script 'graph-widget-script' is loaded from the plugin's 'js/main.js' file with version '1.0' and set to load in the footer ('true').
	 *
	 * Data is passed to the script using wp_localize_script, which makes the data available to the ReactJS script under the global variable 'graph_widget_data'.
	 * The data includes translations for various strings related to time periods and an error message in different languages ('text-domain').
	 *
	 * @param string $hook The current admin page being loaded.
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'index.php' !== $hook ) {
			return;
		}

		// Enqueue 'graph-widget-script' with its source, version, and set to load in the footer.
		wp_enqueue_script( 'graph-widget-script', GRAPH_WIDGET_URL . 'js/main.js', '', '1.9', true );

		// Data to pass to the ReactJS script using wp_localize_script.
		$data_to_pass = array(
			'site_url'            => site_url(),
		);

		// Pass the data to the ReactJS script under the variable 'graph_widget_data'.
		wp_localize_script( 'graph-widget-script', 'graph_widget_data', $data_to_pass );
	}
	/**
	 * Callback function to render the dashboard widget.
	 * This function generates the content of the dashboard widget.
	 */
	public function graph_widget() {
		// Output the HTML container for the dashboard widget.
		// The div element with the ID "dashboard-widget-container" will be used as the widget's content holder.
		echo '<div id="dashboard-widget-container"></div>';
	}


	/**
	 * Function to add graph widget.
	 * This function registers and adds a Graph dashboard widget to the WordPress dashboard.
	 */
	public function add_graph_widget() {
		wp_add_dashboard_widget(
			'dashboard_graph_widget',
			__( 'Graph Widget', 'text-domain' ),
			array( $this, 'graph_widget' )
		);
	}
	/**
	 * Autoloader function to automatically load classes as they're used.
	 *
	 * @param string $class_name The name of the class to load.
	 */
	public function graph_widget_autoloader( $class_name ) {
		$class_path = GRAPH_WIDGET_DIR . 'includes/' . $class_name . '.php';
		if ( file_exists( $class_path ) ) {
			require_once $class_path;
		}
	}
}

// Instantiate the class to initialize the plugin.
new Graph_Widget();

