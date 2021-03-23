<?php

declare(strict_types=1);

namespace Page\Acceptance\Admin;

use Selector\Admin\GutenbergEditor as EditorSelector;
use Selector\Admin\GutenbergEditor\BlockName;
use Selector\Admin\GutenbergEditor\BlockSection;
use Selector\Admin\GutenbergEditor\BlockSelector;

class GutenbergEditor
{
    /**
     * @var \AcceptanceTester;
     */
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    public function addBlock(BlockSection $blockSection, BlockName $blockName): void
    {
        $I = $this->tester;
        $blockButton = (string) BlockSelector::BLOCK($blockName);

        $this->openBlockSelector();
        $I->appendField( '.block-editor-inserter__search input[type=search]', $blockSection );
        $I->click((string) BlockSelector::SECTION($blockSection));
        $I->waitForElement($blockButton, 1);
        $I->click($blockButton);
    }

    public function openBlockSelector(): void
    {
        $I = $this->tester;
        $I->click((string) BlockSelector::MAIN_BUTTON());
    }
}
