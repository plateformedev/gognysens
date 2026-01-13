<?php
/**
 * FAQ Block Template
 * Generates FAQ with Schema.org FAQPage markup
 *
 * @package Cognisens
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get block values
$title = get_field('faq_title') ?: 'Questions frequentes';
$questions = get_field('faq_questions');
$block_id = $block['id'] ?? 'faq-' . uniqid();

// Prepare Schema.org data
$schema_questions = array();

if ($questions): ?>

<section class="cognisens-faq" id="<?php echo esc_attr($block_id); ?>">
    <?php if ($title): ?>
        <h2 class="cognisens-faq__title"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>

    <div class="cognisens-faq__list">
        <?php foreach ($questions as $index => $item):
            $question = $item['question'] ?? '';
            $answer = $item['answer'] ?? '';

            if ($question && $answer):
                // Add to schema
                $schema_questions[] = array(
                    '@type' => 'Question',
                    'name' => $question,
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => wp_strip_all_tags($answer),
                    ),
                );
        ?>
            <details class="cognisens-faq__item">
                <summary class="cognisens-faq__question">
                    <?php echo esc_html($question); ?>
                </summary>
                <div class="cognisens-faq__answer">
                    <?php echo wp_kses_post($answer); ?>
                </div>
            </details>
        <?php
            endif;
        endforeach; ?>
    </div>
</section>

<?php
// Output Schema.org FAQPage
if (!empty($schema_questions)):
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $schema_questions,
    );
?>
<script type="application/ld+json">
<?php echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
</script>
<?php
endif;
endif;
?>
