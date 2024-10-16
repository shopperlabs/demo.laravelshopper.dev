<?php

declare(strict_types=1);

use App\Models\User;
use Livewire\Volt\Volt;
use Shopper\Livewire\Pages\Auth\Login;

describe(Login::class, function (): void {
    test('login screen can be rendered', function (): void {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.login');
    });

    test('users can authenticate using the login screen', function (): void {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    });

    test('users can not authenticate with invalid password', function () {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    });

    test('users can logout', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('layout.navigation');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
    });
})
    ->group('auth');
