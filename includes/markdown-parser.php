<?php
/**
 * Markdown Image Parser
 * 
 * Converts markdown image syntax to HTML with sizing:
 * ![Alt text|widthxheight](image-url) → <img style="max-width: X; height: Y">
 * 
 * Usage:
 *   $html = renderMarkdownImages($markdownContent);
 */

function renderMarkdownImages(string $markdown): string {
    /**
     * Regex explanation:
     * !\[([^\]]+)\]\(([^)]+)\)
     * 
     * Captures:
     * 1. Alt text (with optional dimensions): "Image|600x400"
     * 2. Image URL: "/assets/images/photo.jpg"
     */
    return preg_replace_callback(
        '/!\[([^\]]+)\]\(([^)]+)\)/',
        function($matches) {
            $altAndDimensions = $matches[1];
            $imageUrl = trim($matches[2]);

            // Parse alt text and dimensions
            if (strpos($altAndDimensions, '|') !== false) {
                [$altText, $dimensions] = explode('|', $altAndDimensions, 2);
            } else {
                $altText = $altAndDimensions;
                $dimensions = '';
            }

            $altText = trim($altText);
            $dimensions = trim($dimensions);

            // Build style attributes from dimensions
            $style = 'max-width: 100%; height: auto; border-radius: 8px;';
            
            if ($dimensions) {
                if (strpos($dimensions, 'x') !== false) {
                    // Both width and height: "600x400"
                    [$width, $height] = explode('x', $dimensions);
                    $width = (int)trim($width);
                    $height = (int)trim($height);
                    
                    if ($width > 0 && $height > 0) {
                        $style = "max-width: 100%; width: {$width}px; height: {$height}px; " .
                                 "object-fit: cover; border-radius: 8px;";
                    } elseif ($width > 0) {
                        $style = "max-width: 100%; width: {$width}px; height: auto; " .
                                 "border-radius: 8px;";
                    }
                } else {
                    // Width only: "600"
                    $width = (int)$dimensions;
                    if ($width > 0) {
                        $style = "max-width: 100%; width: {$width}px; height: auto; " .
                                 "border-radius: 8px;";
                    }
                }
            }

            // Escape URL and alt text for security
            $imageUrl = htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8');
            $altText = htmlspecialchars($altText, ENT_QUOTES, 'UTF-8');

            // Return wrapped image with figure element for better semantics
            return "<figure style='margin: 1.5rem 0; display: inline-block; max-width: 100%;'>" .
                   "<img src='{$imageUrl}' alt='{$altText}' style='{$style}' loading='lazy'>" .
                   "</figure>";
        },
        $markdown
    );
}

/**
 * Convert simple markdown to HTML
 * Supports: **bold**, *italic*, headings, lists, links, images
 */
function parseMarkdown(string $markdown): string {
    // First, handle code blocks (preserve them)
    $codeBlocks = [];
    $markdown = preg_replace_callback(
        '/```(.*?)```/s',
        function($matches) use (&$codeBlocks) {
            $index = count($codeBlocks);
            $codeBlocks[$index] = '<pre><code>' . htmlspecialchars($matches[1]) . '</code></pre>';
            return "{{CODE_BLOCK_$index}}";
        },
        $markdown
    );

    // Handle headings
    $markdown = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $markdown);
    $markdown = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $markdown);

    // Handle bold
    $markdown = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $markdown);

    // Handle italic
    $markdown = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $markdown);

    // Handle inline code
    $markdown = preg_replace('/`(.*?)`/', '<code>$1</code>', $markdown);

    // Handle links
    $markdown = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>', $markdown);

    // Handle images with dimensions
    $markdown = renderMarkdownImages($markdown);

    // Handle unordered lists
    $markdown = preg_replace_callback(
        '/(?:^|\n)((?:- .*(?:\n|$))+)/m',
        function($matches) {
            $items = preg_split('/\n/', trim($matches[1]));
            $items = array_filter($items);
            $html = '<ul>';
            foreach ($items as $item) {
                $item = preg_replace('/^- /', '', $item);
                $html .= '<li>' . trim($item) . '</li>';
            }
            $html .= '</ul>';
            return "\n$html\n";
        },
        $markdown
    );

    // Handle line breaks and paragraphs
    $markdown = preg_replace('/\n\n+/', '</p><p>', $markdown);
    $markdown = '<p>' . $markdown . '</p>';

    // Clean up nested paragraphs
    $markdown = preg_replace('/<p>\s*<(h[1-3]|ul|ol|pre)/', '<$1', $markdown);
    $markdown = preg_replace('/<\/(h[1-3]|ul|ol|pre)>\s*<\/p>/', '</$1', $markdown);

    // Restore code blocks
    foreach ($codeBlocks as $index => $block) {
        $markdown = str_replace("{{CODE_BLOCK_$index}}", $block, $markdown);
    }

    return $markdown;
}

/**
 * Sanitize HTML while preserving safe tags
 * Use after parseMarkdown() to prevent XSS
 */
function sanitizeHtml(string $html): string {
    // Allowed HTML tags and attributes
    $allowed = '<p><br><strong><em><h1><h2><h3><h4><h5><h6>' .
               '<ul><ol><li><code><pre><blockquote><a><figure><img>';
    
    return strip_tags($html, $allowed);
}

/**
 * Extract plain text from markdown (for summaries)
 */
function extractPlainText(string $markdown, int $maxLength = 150): string {
    // Remove markdown syntax
    $text = preg_replace('/[*_`[\]()!#-]/m', '', $markdown);
    
    // Remove image markdown
    $text = preg_replace('/!\[.*?\]\(.*?\)/', '', $text);
    
    // Remove extra whitespace
    $text = preg_replace('/\s+/', ' ', trim($text));
    
    // Truncate
    if (strlen($text) > $maxLength) {
        $text = substr($text, 0, $maxLength) . '...';
    }
    
    return $text;
}