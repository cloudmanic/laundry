<?php

/**
 * File: RegistrationTest.php
 * Description: Feature tests for user registration functionality
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the registration page renders correctly.
     */
    public function test_registration_page_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Create Your Account');
        $response->assertSee('First Name');
        $response->assertSee('Last Name');
        $response->assertSee('Email Address');
        $response->assertSee('Phone Number');
        $response->assertSee('Password');
    }

    /**
     * Test that the registration page contains sales elements.
     */
    public function test_registration_page_contains_sales_elements(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);

        // Check for progress indicator
        $response->assertSee('Create Account');
        $response->assertSee('Choose Pickup Day');
        $response->assertSee('Payment');

        // Check for trust signals
        $response->assertSee('Secure checkout');
        $response->assertSee('Cancel anytime');

        // Check for value proposition elements
        $response->assertSee('Get Your Sundays Back');
        $response->assertSee('Next-Day Turnaround');
    }

    /**
     * Test successful user registration via Livewire.
     */
    public function test_new_user_can_register(): void
    {
        Event::fake([Registered::class]);

        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john.doe@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertRedirect('/onboarding');

        // Verify user was created
        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);

        // Verify Registered event was fired
        Event::assertDispatched(Registered::class);

        // Verify user is logged in
        $this->assertAuthenticated();
    }

    /**
     * Test registration with phone number formatting.
     */
    public function test_phone_number_is_formatted_correctly(): void
    {
        Event::fake([Registered::class]);

        Livewire::test('auth.register')
            ->set('first_name', 'Jane')
            ->set('last_name', 'Smith')
            ->set('email', 'jane.smith@example.com')
            ->set('phone', '1-503-555-9876')
            ->set('password', 'SecurePass123!')
            ->set('password_confirmation', 'SecurePass123!')
            ->set('terms', true)
            ->call('register')
            ->assertRedirect('/onboarding');

        // Verify phone was formatted
        $user = User::where('email', 'jane.smith@example.com')->first();
        $this->assertEquals('(503) 555-9876', $user->phone);
    }

    /**
     * Test that email must be unique.
     */
    public function test_registration_fails_with_duplicate_email(): void
    {
        // Create existing user
        User::factory()->create(['email' => 'existing@example.com']);

        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'existing@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['email']);
    }

    /**
     * Test that first name is required.
     */
    public function test_first_name_is_required(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', '')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['first_name']);
    }

    /**
     * Test that last name is required.
     */
    public function test_last_name_is_required(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', '')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['last_name']);
    }

    /**
     * Test that email is required.
     */
    public function test_email_is_required(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', '')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['email']);
    }

    /**
     * Test that email must be valid format.
     */
    public function test_email_must_be_valid(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'not-an-email')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['email']);
    }

    /**
     * Test that phone is required.
     */
    public function test_phone_is_required(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['phone']);
    }

    /**
     * Test that password is required.
     */
    public function test_password_is_required(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', '')
            ->set('password_confirmation', '')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['password']);
    }

    /**
     * Test that password must be at least 8 characters.
     */
    public function test_password_must_be_minimum_length(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['password']);
    }

    /**
     * Test that password confirmation must match.
     */
    public function test_password_confirmation_must_match(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'DifferentPassword!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['password']);
    }

    /**
     * Test that terms must be accepted.
     */
    public function test_terms_must_be_accepted(): void
    {
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', false)
            ->call('register')
            ->assertHasErrors(['terms']);
    }

    /**
     * Test that email is lowercased during registration.
     */
    public function test_email_is_lowercased(): void
    {
        Event::fake([Registered::class]);

        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'JOHN.DOE@EXAMPLE.COM')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register');

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);
    }

    /**
     * Test that password is hashed.
     */
    public function test_password_is_hashed(): void
    {
        Event::fake([Registered::class]);

        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register');

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotEquals('Password123!', $user->password);
        $this->assertTrue(Hash::check('Password123!', $user->password));
    }

    /**
     * Test that user is assigned the correct region.
     */
    public function test_user_is_assigned_correct_region(): void
    {
        Event::fake([Registered::class]);

        // Set the active city config
        config(['city.active' => 'sherwood']);

        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register');

        $user = User::where('email', 'john@example.com')->first();
        $this->assertEquals('sherwood', $user->region_key);
    }

    /**
     * Test that UUID is auto-generated for new user.
     */
    public function test_uuid_is_auto_generated(): void
    {
        Event::fake([Registered::class]);

        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register');

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $user->uuid
        );
    }

    /**
     * Test real-time email validation.
     */
    public function test_real_time_email_validation(): void
    {
        // Create existing user
        User::factory()->create(['email' => 'taken@example.com']);

        Livewire::test('auth.register')
            ->set('email', 'taken@example.com')
            ->assertHasErrors(['email']);
    }

    /**
     * Test password strength calculation.
     */
    public function test_password_strength_is_calculated(): void
    {
        $component = Livewire::test('auth.register');

        // Weak password
        $component->set('password', 'password');
        $this->assertEquals(1, $component->get('passwordStrength'));

        // Medium password
        $component->set('password', 'Password1');
        $this->assertEquals(3, $component->get('passwordStrength'));

        // Strong password
        $component->set('password', 'Password123!@#');
        $this->assertEquals(4, $component->get('passwordStrength'));
    }

    /**
     * Test that authenticated users are redirected from registration.
     */
    public function test_authenticated_users_cannot_access_registration(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        // Authenticated users should be redirected away from registration
        // The specific redirect location depends on the guest middleware configuration
        $response->assertRedirect();
    }

    /**
     * Test plan is passed through query string.
     */
    public function test_selected_plan_is_captured_from_url(): void
    {
        $response = $this->get('/register?plan=family');

        $response->assertStatus(200);
        $response->assertSee('Your Selected Plan');
        $response->assertSee('The Family Plan');
    }

    /**
     * Test registration with selected plan redirects with plan parameter.
     */
    public function test_registration_with_plan_redirects_with_plan(): void
    {
        Event::fake([Registered::class]);

        Livewire::test('auth.register', ['selectedPlan' => 'family'])
            ->set('selectedPlan', 'family')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertRedirect('/onboarding?plan=family');
    }

    /**
     * Test password visibility toggle.
     */
    public function test_password_visibility_toggle_works(): void
    {
        $component = Livewire::test('auth.register');

        $this->assertFalse($component->get('showPassword'));

        $component->call('togglePasswordVisibility');
        $this->assertTrue($component->get('showPassword'));

        $component->call('togglePasswordVisibility');
        $this->assertFalse($component->get('showPassword'));
    }

    /**
     * Test that successful registration completes without errors.
     */
    public function test_registration_completes_successfully(): void
    {
        Event::fake([Registered::class]);

        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'john@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasNoErrors()
            ->assertRedirect('/onboarding');

        // Verify user exists
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    /**
     * Test validation failure is logged - verifies validation errors are captured.
     */
    public function test_validation_failure_produces_error(): void
    {
        // Create existing user
        User::factory()->create(['email' => 'existing@example.com']);

        // Attempt to register with duplicate email
        Livewire::test('auth.register')
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('email', 'existing@example.com')
            ->set('phone', '5035551234')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register')
            ->assertHasErrors(['email']);

        // Verify no user was created with this attempt
        $this->assertDatabaseCount('users', 1);
    }
}
