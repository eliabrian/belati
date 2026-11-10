<?php

test('home screen can be rendered', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('license and attribution screen can be rendered', function () {
    $response = $this->get('/license');

    $response->assertStatus(200);
});
