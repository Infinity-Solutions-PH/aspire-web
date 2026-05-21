<?php

test('unauthenticated users accessing admin routes are redirected to admin auth', function () {
    $response = $this->get('/admin/dashboard');

    $response->assertRedirect('/admin/auth');
});

test('unauthenticated users accessing root admin route are redirected to admin auth', function () {
    $response = $this->get('/admin');

    $response->assertRedirect('/admin/auth');
});

test('unauthenticated users accessing other routes are redirected to portal auth', function () {
    $response = $this->get('/portal/dashboard');

    $response->assertRedirect('/portal/auth');
});

test('unauthenticated users accessing generic routes are redirected to portal auth', function () {
    $response = $this->get('/settings/profile');

    $response->assertRedirect('/portal/auth');
});
