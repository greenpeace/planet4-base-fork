<?php
// @group useraction

$I = new AcceptanceTester($scenario);
$I->wantTo('login to wordpress admin');

$I->loginAsAdminCached();

$I->see('Welcome to WordPress!');
