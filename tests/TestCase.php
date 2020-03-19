<?php

namespace Telkins\Watchable\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as Orchestra;
use Telkins\Watchable\Tests\Support\Models\User;
use Telkins\Watchable\WatchableServiceProvider;

abstract class TestCase extends Orchestra
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            WatchableServiceProvider::class,
        ];
    }

    protected function setUpDatabase(): void
    {
        $this->loadLaravelMigrations();

        require_once __DIR__ . '/../database/migrations/create_watchables_table.php.stub';

        (new \CreateWatchablesTable())->up();

        $this->createTestTables();

        $this->seedTables();
    }

    protected function createTestTables(): void
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }

    protected function seedTables(): void
    {
        $this->createUser(['name' => 'John Doe']);
    }

    protected function createUser(array $data = []): User
    {
        return User::create(array_merge([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ], $data));
    }
}