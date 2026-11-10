<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register with just username and password without an email', function () {
    $response = $this->post('/register', [
        'username' => 'DaggerMaster',
        'password' => 'secret-dagger-123',
        'password_confirmation' => 'secret-dagger-123',
    ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'username' => 'DaggerMaster',
        'email' => null,
    ]);
    $response->assertRedirect(route('home'));
});

test('new users can register with an optional recovery email', function () {
    $response = $this->post('/register', [
        'username' => 'RogueShadow',
        'email' => 'burner@example.com',
        'password' => 'secret-dagger-123',
        'password_confirmation' => 'secret-dagger-123',
    ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'username' => 'RogueShadow',
        'email' => 'burner@example.com',
    ]);
    $response->assertRedirect(route('home'));
});

test('users cannot register with an existing username', function () {
    User::factory()->create([
        'username' => 'TakenName',
    ]);

    $response = $this->post('/register', [
        'username' => 'TakenName',
        'password' => 'secret-dagger-123',
        'password_confirmation' => 'secret-dagger-123',
    ]);

    $response->assertSessionHasErrors('username');
    $this->assertGuest();
});

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using username and password', function () {
    $user = User::factory()->create([
        'username' => 'BraveWarrior',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'username' => 'BraveWarrior',
        'password' => 'password123',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('home'));
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create([
        'username' => 'BraveWarrior',
        'password' => bcrypt('password123'),
    ]);

    $this->post('/login', [
        'username' => 'BraveWarrior',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('authenticated users can logout', function () {
    $user = User::factory()->create([
        'username' => 'BraveWarrior',
    ]);

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('home'));
});
