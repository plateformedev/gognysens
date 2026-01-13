<?php
/**
 * Booking AI Integration Class
 *
 * Handles AI-powered booking qualification
 * Prepared for future API integration
 *
 * @package Cognisens_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Cognisens_Booking_AI {

    private static $instance = null;
    private $api_key = '';
    private $api_endpoint = '';

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Load settings
        $this->api_key = get_option('cognisens_ai_api_key', '');
        $this->api_endpoint = get_option('cognisens_ai_endpoint', '');

        // Hooks for booking integration
        add_action('cognisens_process_booking', array($this, 'process_booking'), 10, 2);
        add_filter('cognisens_booking_summary', array($this, 'generate_summary'), 10, 2);
    }

    /**
     * Process booking with AI
     */
    public function process_booking($booking_data, $form_responses) {
        if (empty($this->api_key)) {
            // AI not configured, use basic processing
            return $this->basic_processing($booking_data, $form_responses);
        }

        try {
            $ai_result = $this->call_ai_api($form_responses);

            if ($ai_result) {
                $booking_data['ai_summary'] = $ai_result['summary'] ?? '';
                $booking_data['ai_classification'] = $ai_result['classification'] ?? '';
                $booking_data['ai_priority'] = $ai_result['priority'] ?? 'normal';
            }
        } catch (Exception $e) {
            error_log('Cognisens AI Error: ' . $e->getMessage());
            // Fallback to basic processing
            return $this->basic_processing($booking_data, $form_responses);
        }

        return $booking_data;
    }

    /**
     * Basic processing without AI
     */
    private function basic_processing($booking_data, $form_responses) {
        // Extract key information
        $summary_parts = array();

        foreach ($form_responses as $key => $value) {
            if (!empty($value) && is_string($value)) {
                $summary_parts[] = ucfirst($key) . ': ' . $value;
            }
        }

        $booking_data['summary'] = implode("\n", $summary_parts);
        $booking_data['classification'] = $this->classify_request($form_responses);

        return $booking_data;
    }

    /**
     * Classify request type
     */
    private function classify_request($responses) {
        $text = strtolower(implode(' ', array_filter($responses, 'is_string')));

        $classifications = array(
            'expertise_fissure' => array('fissure', 'fissuration', 'fissures'),
            'expertise_humidite' => array('humidite', 'infiltration', 'eau'),
            'expertise_structure' => array('structure', 'deformation', 'affaissement'),
            'expertise_bois' => array('bois', 'charpente', 'merule', 'insecte'),
            'amo_copropriete' => array('copropriete', 'syndic', 'travaux'),
            'amo_particulier' => array('renovation', 'restauration'),
            'dtg' => array('dtg', 'diagnostic'),
        );

        foreach ($classifications as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($text, $keyword) !== false) {
                    return $type;
                }
            }
        }

        return 'general';
    }

    /**
     * Call AI API
     */
    private function call_ai_api($data) {
        if (empty($this->api_endpoint) || empty($this->api_key)) {
            return null;
        }

        $prompt = $this->build_prompt($data);

        $response = wp_remote_post($this->api_endpoint, array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key,
            ),
            'body' => wp_json_encode(array(
                'model' => 'claude-3-haiku-20240307',
                'max_tokens' => 500,
                'messages' => array(
                    array(
                        'role' => 'user',
                        'content' => $prompt,
                    ),
                ),
            )),
            'timeout' => 30,
        ));

        if (is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($body['content'][0]['text'])) {
            return json_decode($body['content'][0]['text'], true);
        }

        return null;
    }

    /**
     * Build AI prompt
     */
    private function build_prompt($data) {
        $data_json = wp_json_encode($data, JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
Tu es l'assistant de qualification de Cognisens, cabinet d'expertise en bati ancien.

Analyse les reponses suivantes du formulaire de prise de rendez-vous :
{$data_json}

Genere un JSON avec :
1. "summary": Resume concis de la demande (3-4 phrases max)
2. "classification": Type de demande parmi [expertise_fissure, expertise_humidite, expertise_structure, expertise_bois, amo_copropriete, amo_particulier, dtg, general]
3. "priority": Niveau d'urgence [urgent, normal, faible]
4. "key_points": Liste des points cles a aborder lors du rendez-vous

IMPORTANT : Tu resumes et classes uniquement. Tu n'analyses pas techniquement la situation.

Reponds uniquement avec le JSON, sans texte autour.
PROMPT;
    }

    /**
     * Generate booking summary
     */
    public function generate_summary($booking_id, $data) {
        $summary = '';

        if (!empty($data['ai_summary'])) {
            $summary = $data['ai_summary'];
        } else {
            // Basic summary
            $parts = array();

            if (!empty($data['name'])) {
                $parts[] = 'Client : ' . $data['name'];
            }
            if (!empty($data['type'])) {
                $parts[] = 'Type : ' . ucfirst($data['type']);
            }
            if (!empty($data['message'])) {
                $parts[] = 'Demande : ' . wp_trim_words($data['message'], 50);
            }

            $summary = implode("\n", $parts);
        }

        return $summary;
    }

    /**
     * Admin settings
     */
    public static function register_settings() {
        register_setting('cognisens_settings', 'cognisens_ai_api_key');
        register_setting('cognisens_settings', 'cognisens_ai_endpoint');

        add_settings_section(
            'cognisens_ai_section',
            __('Configuration IA', 'cognisens-core'),
            function() {
                echo '<p>' . esc_html__('Configurez l\'API IA pour la qualification automatique des demandes.', 'cognisens-core') . '</p>';
            },
            'cognisens_settings'
        );

        add_settings_field(
            'cognisens_ai_endpoint',
            __('Endpoint API', 'cognisens-core'),
            function() {
                $value = get_option('cognisens_ai_endpoint', '');
                echo '<input type="url" name="cognisens_ai_endpoint" value="' . esc_attr($value) . '" class="regular-text" />';
                echo '<p class="description">' . esc_html__('Ex: https://api.anthropic.com/v1/messages', 'cognisens-core') . '</p>';
            },
            'cognisens_settings',
            'cognisens_ai_section'
        );

        add_settings_field(
            'cognisens_ai_api_key',
            __('Cle API', 'cognisens-core'),
            function() {
                $value = get_option('cognisens_ai_api_key', '');
                echo '<input type="password" name="cognisens_ai_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
            },
            'cognisens_settings',
            'cognisens_ai_section'
        );
    }
}
