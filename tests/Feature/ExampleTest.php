<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_redirects_to_the_dashboard()
    {
        $this->get(route('home'))->assertRedirect(route('dashboard'));
    }
}
