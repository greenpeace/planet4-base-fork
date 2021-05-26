<?php

declare(strict_types=1);

namespace Selector\Admin\GutenbergEditor;

/**
 * Selectors for the block selector
 */
class BlockSelector
{
    public const MAIN_BUTTON = '//button[contains(@aria-label, "Add block")]';
    public const SECTION = '//div[contains(@class, "block-editor-block-types-list")][contains(@aria-label, "%s")]';
    public const BLOCK = '//div[contains(@class, "block-editor-block-types-list")]//button/span[text()="%s"]';

    public static function section(BlockSection $sectionName): string
    {
        return sprintf(self::SECTION, (string) $sectionName);
    }

    public static function block(BlockName $blockName): string
    {
        return sprintf(self::BLOCK, (string) $blockName);
    }
}
