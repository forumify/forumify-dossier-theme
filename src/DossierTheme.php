<?php

declare(strict_types=1);

namespace Forumify\DossierTheme;

use Forumify\ForumifyTheme;
use Forumify\Plugin\PluginMetadata;
use Forumify\Plugin\ThemeConfig;
use Forumify\Plugin\ThemeVar;
use Forumify\Plugin\ThemeVarType;

/**
 * A classified field file: typewritten sheets stacked in a manila folder, stencilled
 * headings, rubber stamps and a classification banner at the top and bottom of every
 * page. Dark mode is a carbon copy.
 *
 * forumify's own variables keep their meaning, only their defaults change, so the admin
 * panel and every plugin pick up the palette. The dossier-* variables drive the banner,
 * stamps and paper in public/style.css and can be tuned under Admin → Settings → Themes.
 */
class DossierTheme extends ForumifyTheme
{
    /**
     * New defaults for forumify's own variables, as [light, dark].
     */
    private const OVERRIDES = [
        'c-primary' => ['#1d2f6b', '#9db8ff'],
        'c-primary-accent' => ['#2f4ea8', '#c2d3ff'],
        'c-primary-text' => ['#fbf8ef', '#171c27'],
        'c-secondary' => ['#4a4f3a', '#6f7a5a'],
        'c-secondary-text' => ['#fbf8ef', '#f1f3e8'],
        'c-call-to-action' => ['#b3261e', '#ff6b5e'],
        'c-call-to-action-accent' => ['#8f1d16', '#ff8a80'],
        'c-call-to-action-text' => ['#ffffff', '#171c27'],
        'c-text-primary' => ['#23201b', '#dfe4ee'],
        'c-text-secondary' => ['#5e5848', '#9aa4b8'],
        'c-success' => ['#dfe8cc', '#22331f'],
        'c-success-text' => ['#2f4a12', '#b9dc95'],
        'c-info' => ['#dce3f2', '#1f2a44'],
        'c-info-text' => ['#1d2f6b', '#b9cbf5'],
        'c-warning' => ['#f3e2b0', '#3d3218'],
        'c-warning-text' => ['#5b4100', '#f2d58e'],
        'c-error' => ['#f2d3cc', '#40201f'],
        'c-error-text' => ['#8f1d16', '#ffaaa1'],
        'c-elevation-0' => ['#d8c592', '#171c27'],
        'c-elevation-1' => ['#fbf8ef', '#212837'],
        'c-elevation-2' => ['#f2eddd', '#283042'],
        'c-elevation-3' => ['#e9e2cc', '#303a4f'],
        'c-elevation-4' => ['#ded6bc', '#38435a'],
        'c-elevation-5' => ['#d3c9ac', '#404c66'],
        'c-hover' => ['rgba(29, 47, 107, 0.06)', 'rgba(157, 184, 255, 0.07)'],
        'border-color' => ['rgba(35, 32, 27, 0.28)', 'rgba(223, 228, 238, 0.16)'],
        'border-radius' => ['0px', '0px'],
        'button-border-radius' => ['2px', '2px'],
        'font-size' => ['16px', '16px'],
    ];

    public function getPluginMetadata(): PluginMetadata
    {
        return new PluginMetadata(
            'Dossier',
            'forumify',
            'A classified field file: stencilled headings, typewritten pages, rubber stamps and classification banners.',
            'https://forumify.net',
        );
    }

    public function getThemeConfig(): ThemeConfig
    {
        $vars = array_map(static function (ThemeVar $var): ThemeVar {
            if (!isset(self::OVERRIDES[$var->key])) {
                return $var;
            }

            [$light, $dark] = self::OVERRIDES[$var->key];
            return new ThemeVar($var->key, $var->label, $var->type, $light, $dark, $var->help);
        }, parent::getThemeConfig()->vars);

        return new ThemeConfig(true, [
            ...$vars,
            new ThemeVar(
                'color-scheme',
                'Color Scheme',
                ThemeVarType::String,
                'light',
                'dark',
                'Tells the browser whether native controls and scrollbars should be light or dark.',
            ),
            new ThemeVar(
                'dossier-banner',
                'Classification Banner',
                ThemeVarType::String,
                "'Unclassified'",
                "'Unclassified'",
                "Text of the banners at the top and bottom of every page, in quotes, e.g. 'Restricted'. Use none to hide them.",
            ),
            new ThemeVar(
                'dossier-banner-color',
                'Classification Color',
                ThemeVarType::Color,
                '#007a33',
                '#007a33',
                'Green for unclassified, blue for confidential, red for secret, orange for top secret.',
            ),
            new ThemeVar('dossier-banner-text', 'Classification Text Color', ThemeVarType::Color, '#ffffff', '#ffffff'),
            new ThemeVar('dossier-banner-height', 'Classification Banner Height', ThemeVarType::Size, '24px', '24px', 'Set to 0px together with a banner of none to remove the banners.'),
            new ThemeVar('dossier-ink', 'Typewriter Ink', ThemeVarType::Color, '#23201b', '#dfe4ee', 'Rules, outlines and form lines.'),
            new ThemeVar('dossier-stamp', 'Stamp Ink', ThemeVarType::Color, '#b3261e', '#ff6b5e', 'Rubber stamps, red pen circles and unread markers.'),
            new ThemeVar('dossier-paper-edge', 'Paper Edge', ThemeVarType::Color, '#b9a874', '#0e121a', 'Edge of the sheets stacked under every panel.'),
            new ThemeVar('dossier-redaction', 'Redaction', ThemeVarType::Color, '#111111', '#000000', 'The bar over hidden topics and selected text.'),
            new ThemeVar('dossier-display-font', 'Stencil Font', ThemeVarType::String, "'Big Shoulders Stencil Display', 'Big Shoulders Stencil', Impact, sans-serif"),
            new ThemeVar('dossier-font', 'Typewriter Font', ThemeVarType::String, "'Courier Prime', 'Courier New', monospace"),
        ]);
    }

    /**
     * Stylesheets loaded on every page while the theme is active, relative to public/.
     *
     * @return array<string>
     */
    public function getStylesheets(): array
    {
        return ['style.css'];
    }
}
