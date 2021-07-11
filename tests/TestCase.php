<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function actingAsUser(): TestCase
    {
        $user = User::factory()->create();

        return $this->actingAs($user);
    }
}
