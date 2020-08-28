<?php
// @group gallery

use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);

$I->wantTo('create and check check gallery block grid style');

$slug = $I->generateRandomSlug();

$I->havePageInDatabase([
	'post_name'    => $slug,
	'post_status'  => 'publish',
	'post_content' => $I->generateGutenberg('wp:planet4-blocks/gallery', [
		'gallery_block_style'       => '3',
		'gallery_block_title'       => 'Grid',
		'gallery_block_description' => 'Grid description',
		'multiple_image'            => '61,64,65,66'
	])
]);

// Navigate to the newly created page
$I->amOnPage('/' . $slug);

// Check the Gallery block
$I->see('Grid', 'h2');
$I->see('Grid description', 'div');
$I->seeNumberOfElements('.grid-item > img', 4);
