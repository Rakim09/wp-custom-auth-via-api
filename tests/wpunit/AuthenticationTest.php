<?php

use CustomAuthViaApi\App\General\Authentication;
use Codeception\TestCase\WPTestCase;
use Helper\WPUnit;

class AuthenticationTest extends WPTestCase
{
    /**
     * @var WpunitTester
     */
    protected WpunitTester $tester;
    
    public function setUp(): void
    {
        // Before...
        parent::setUp();

        // Your set up methods here.
	    $this->user = wp_set_current_user(self::factory()->user->create(['role' => 'administrator']));

	    $this->auth = new Authentication();
    }

    public function tearDown(): void
    {
        // Your tear down methods here.

        // Then...
        parent::tearDown();
    }

    // Tests
    public function test_its_correct_class(): void {
        self::assertInstanceOf( Authentication::class, $this->auth );
    }

	public function test_authenticate_filter_is_attached(): void {
		$this->auth->init();
		self::assertTrue(WPUnit::has_filter('authenticate', $this->auth, 'authenticate'));
	}

	public function test_user_register_filter_is_attached(): void {
		$this->auth->init();
		self::assertTrue(WPUnit::has_filter('user_register', $this->auth, 'user_register'));
	}
}
