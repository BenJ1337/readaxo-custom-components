<?php

$nav = rex_navigation::factory();
$nav->setClasses(array('nav-item', 'nav-item', 'nav-item'));
$nav->setLinkClasses(array('nav-link', 'nav-link', 'nav-link'));

$navHtml = $nav->get(0, 1, TRUE, TRUE);

$navHtml = preg_replace('/rex-current/', 'active', $navHtml);
$navHtml = preg_replace('/rex-active/', 'active', $navHtml);
$navHtml = preg_replace('/rex-normal/', '', $navHtml);
$navHtml = preg_replace('/rex-navi1\s+/', 'navbar-nav m-auto', $navHtml);
$navHtml = preg_replace('/my-currentrex-article-[0-9]+\s+/', '', $navHtml);
$navHtml = preg_replace('/rex-navi-depth-[0-9]+\s+/', '', $navHtml);
$navHtml = preg_replace('/rex-navi-has-[0-9]+\-elements/', '', $navHtml);
$navHtml = preg_replace('/rex-article-[0-9]+\s+/', '', $navHtml);
$navHtml = preg_replace('/rex-navi-[0-9]+/', '', $navHtml);

?>
<div class="fixed-top my-navbar">
    <nav class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm">
        <button class="navbar-toggler first-button" type="button" data-toggle="collapse" data-target="#mobil-nav" aria-controls="mobil-nav" aria-expanded="false" aria-label="Toggle navigation">
            <div class="animated-icon1"><span></span><span></span><span></span></div>
        </button>
        <div class="collapse navbar-collapse" id="mobil-nav">
            <?php
            echo $navHtml;
            ?>
        </div>
    </nav>
</div>