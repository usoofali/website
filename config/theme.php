<?php
// config/theme.php
// ---------------------------------------------------------------------------
// Reads THEME_* variables from $_ENV (populated by config/database.php env
// loader) and exposes a $theme array used by includes/header.php to inject
// per-environment CSS custom properties and favicon.
// ---------------------------------------------------------------------------

// Sanitize a value for safe use inside a CSS <style> block.
if (!function_exists('_safe_css')) {
    function _safe_css(string $value): string {
        return preg_replace('/[^a-zA-Z0-9 #%(),.\/\-+]/', '', $value);
    }
}

// Sanitize a relative filesystem path (no ../ traversal allowed).
if (!function_exists('_safe_path')) {
    function _safe_path(string $value): string {
        // Allow alphanumeric, /, -, _, .
        $clean = preg_replace('/[^a-zA-Z0-9\/\-_.]/', '', $value);
        // Collapse any double-slashes and remove traversal attempts
        $clean = preg_replace('/\.{2,}/', '', $clean);
        return trim($clean, '/');
    }
}

$theme = [
    // Brand colours
    'primary'      => _safe_css(env('THEME_PRIMARY',  '#4b6cb7')),
    'secondary'    => _safe_css(env('THEME_SECONDARY', '#182848')),
    'accent'       => _safe_css(env('THEME_ACCENT',    '#00d2ff')),

    // Page background gradient stops
    'bg_from'      => _safe_css(env('THEME_BG_FROM', '#f5f7fa')),
    'bg_to'        => _safe_css(env('THEME_BG_TO',   '#c3cfe2')),

    // Glass morphism surface
    'glass_bg'     => _safe_css(env('THEME_GLASS_BG',     'rgba(255,255,255,0.4)')),
    'glass_border' => _safe_css(env('THEME_GLASS_BORDER',  'rgba(255,255,255,0.6)')),

    // Favicon filename (relative to assets/images/)
    'favicon'      => basename(env('THEME_FAVICON', 'favicon.ico')),

    // Slides folder — relative to project root, e.g. assets/images/slides
    'slides_dir'   => _safe_path(env('THEME_SLIDES_DIR', 'assets/images/slides')),

    // Student portal URL — used for Apply Now / Portal links across the site
    'portal_url'   => filter_var(env('PORTAL_URL', '#'), FILTER_SANITIZE_URL),
];
