<?php

\OC::$server->getNavigationManager()->add(function () {
    $urlGenerator = \OC::$server->getURLGenerator();
    return [
        'id' => 'sample_index',
        'order' => 10,
        'href' => $urlGenerator->linkToRoute('sample.page.index'),
        'icon' => $urlGenerator->imagePath('sample', 'sample.svg'),
        'name' => 'Sample',
    ];
});