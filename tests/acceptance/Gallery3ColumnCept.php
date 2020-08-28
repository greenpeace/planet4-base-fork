<?php
// @group gallery

use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);

$I->wantTo('create and check check gallery block 3 column style');

$slug = $I->generateRandomSlug();

$I->havePageInDatabase([
	'post_name'    => $slug,
	'post_status'  => 'publish',
	'post_content' => $I->generateGutenberg('wp:planet4-blocks/gallery', [
		'gallery_block_style'       => '2',
		'gallery_block_title'       => '3 Column',
		'gallery_block_description' => '3 Column description',
		'multiple_image'            => '64,65,66'
	])
]);

// Navigate to the newly created page
$I->amOnPage('/' . $slug);

// Check the Gallery block
$I->see('3 Column', 'h2');
$I->see('3 Column description', 'div');
$I->seeNumberOfElements('.three-column-images > .col', 3);
$I->seeNumberOfElements('.split-image > img', 3);
