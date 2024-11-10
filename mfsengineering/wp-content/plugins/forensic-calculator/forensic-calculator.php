<?php
/*
Plugin Name: Forensic Structural Calculator
Description: Integration with Python-based structural analysis calculator
Version: 1.0
Author: Sareh Vafaei
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ForensicCalculator {
    private $api_url;
    private $api_token;

    public function __construct() {
        $this->api_url = get_option('forensic_calculator_api_url', 'http://your-api-url/api/');
        $this->api_token = get_option('forensic_calculator_api_token', '');
        
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('init', array($this, 'register_shortcode'));
        add_action('wp_ajax_calculate_structure', array($this, 'ajax_calculate'));
        add_action('wp_ajax_nopriv_calculate_structure', array($this, 'ajax_calculate'));
    }

    public function enqueue_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script(
            'forensic-calculator',
            plugins_url('js/calculator.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );
        wp_localize_script('forensic-calculator', 'calculatorAjax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('calculator_nonce')
        ));
    }

    public function register_shortcode() {
        add_shortcode('forensic_calculator', array($this, 'render_calculator'));
    }

    public function render_calculator() {
        ob_start();
        ?>
        <div class="forensic-calculator">
            <div class="calculator-section">
                <h3>Beam Deflection Calculator</h3>
                <form id="beam-deflection-form" class="calculator-form">
                    <div class="form-group">
                        <label for="length">Beam Length (m):</label>
                        <input type="number" id="length" name="length" required step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="load">Load (kN/m):</label>
                        <input type="number" id="load" name="load" required step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="elastic_modulus">Elastic Modulus (GPa):</label>
                        <input type="number" id="elastic_modulus" name="elastic_modulus" required step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="moment_of_inertia">Moment of Inertia (m⁴):</label>
                        <input type="number" id="moment_of_inertia" name="moment_of_inertia" required step="0.000001">
                    </div>
                    <button type="submit" class="calculate-button">Calculate</button>
                </form>
                <div id="beam-results" class="results"></div>
            </div>
        </div>
        <style>
            .forensic-calculator {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
            .calculator-section {
                background: #f5f5f5;
                padding: 20px;
                border-radius: 5px;
                margin-bottom: 20px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            .form-group label {
                display: block;
                margin-bottom: 5px;
            }
            .form-group input {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .calculate-button {
                background: #0073aa;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .results {
                margin-top: 20px;
                padding: 15px;
                background: white;
                border-radius: 4px;
                display: none;
            }
        </style>
        <?php
        return ob_get_clean();
    }

    public function ajax_calculate() {
        check_ajax_referer('calculator_nonce', 'nonce');
        
        $type = sanitize_text_field($_POST['type']);
        $data = array_map('sanitize_text_field', $_POST['data']);
        
        $response = wp_remote_post($this->api_url . $type, array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_token
            ),
            'body' => json_encode($data),
            'timeout' => 45
        ));

        if (is_wp_error($response)) {
            wp_send_json_error('Calculator API error');
        }

        $body = wp_remote_retrieve_body($response);
        wp_send_json_success(json_decode($body));
    }
}

// Initialize the plugin
new ForensicCalculator();