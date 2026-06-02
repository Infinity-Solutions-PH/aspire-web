<?php

use App\Models\User;
use App\Models\Faculty;
use Laravel\Socialite\Facades\Socialite;

test('google login redirect works', function () {
    $response = $this->get(route('google.redirect'));
    $response->assertRedirect();
    expect($response->headers->get('Location'))->toContain('accounts.google.com');
});

test('google callback redirects unregistered user with error', function () {
    $googleUser = Mockery::mock('Laravel\Socialite\Two\User');
    $googleUser->shouldReceive('getId')->andReturn('google-id-123');
    $googleUser->shouldReceive('getEmail')->andReturn('notregistered@example.com');
    $googleUser->shouldReceive('getName')->andReturn('Not Registered');
    $googleUser->shouldReceive('getAvatar')->andReturn('http://avatar.url');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')->andReturn($googleUser);

    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('google.callback'));

    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHasErrors(['email' => 'This Google account is not registered.']);
    $this->assertGuest();
});

test('google callback links and authenticates existing user', function () {
    $user = User::factory()->create([
        'email' => 'existing@example.com',
        'role' => 'admin',
    ]);

    $googleUser = Mockery::mock('Laravel\Socialite\Two\User');
    $googleUser->shouldReceive('getId')->andReturn('google-id-123');
    $googleUser->shouldReceive('getEmail')->andReturn('existing@example.com');
    $googleUser->shouldReceive('getName')->andReturn('Existing Admin');
    $googleUser->shouldReceive('getAvatar')->andReturn('http://avatar.url');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')->andReturn($googleUser);

    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('google.callback'));

    $response->assertRedirect(route('dashboard'));
    $user->refresh();
    expect($user->google_id)->toBe('google-id-123');
    $this->assertAuthenticatedAs($user);
});

test('google callback rejects inactive faculty user', function () {
    $user = User::factory()->create([
        'email' => 'faculty@example.com',
        'role' => 'teacher',
    ]);
    
    // Create inactive faculty profile
    Faculty::create([
        'user_id' => $user->id,
        'faculty_id' => 'FAC-001',
        'status' => 'Inactive',
    ]);

    $googleUser = Mockery::mock('Laravel\Socialite\Two\User');
    $googleUser->shouldReceive('getId')->andReturn('google-id-123');
    $googleUser->shouldReceive('getEmail')->andReturn('faculty@example.com');
    $googleUser->shouldReceive('getName')->andReturn('Faculty Member');
    $googleUser->shouldReceive('getAvatar')->andReturn('http://avatar.url');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')->andReturn($googleUser);

    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('google.callback'));

    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHasErrors(['email' => 'Your account is inactive.']);
    $this->assertGuest();
});

test('google callback allows active faculty user', function () {
    $user = User::factory()->create([
        'email' => 'faculty-active@example.com',
        'role' => 'teacher',
    ]);
    
    // Create active faculty profile
    Faculty::create([
        'user_id' => $user->id,
        'faculty_id' => 'FAC-002',
        'status' => 'Active',
    ]);

    $googleUser = Mockery::mock('Laravel\Socialite\Two\User');
    $googleUser->shouldReceive('getId')->andReturn('google-id-123');
    $googleUser->shouldReceive('getEmail')->andReturn('faculty-active@example.com');
    $googleUser->shouldReceive('getName')->andReturn('Active Faculty');
    $googleUser->shouldReceive('getAvatar')->andReturn('http://avatar.url');

    $provider = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
    $provider->shouldReceive('user')->andReturn($googleUser);

    Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

    $response = $this->get(route('google.callback'));

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);
});
