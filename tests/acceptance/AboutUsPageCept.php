<?php
// @group frontend

$I = new AcceptanceTester($scenario);
$I->wantTo('check About Us page');

$I->amOnPage('/about-us-2');

$I->see('Who we are', 'h1');

// TODO: Test happy point.
$I->scrollTo('#happy-point');
