<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Livewire\Volt\Volt;

describe('Registration', function (): void {
    test('registration screen can be rendered', function (): void {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    });

    test('new users can register', function () {
        $component = Volt::test('pages.auth.register')
            ->set('last_name', 'Test')
            ->set('first_name', 'User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password');

        $component->call('register');

        $component->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    });
})->group('auth');
