<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use App\Models\User;

class CreateUser extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitdif:create-user
                            {name : Full name for this user.}
                            {email : Email address for this user.}
                            {password : Password for this user.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user on the site.';

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'Enter the full name of the user we are going to create.',
            'email' => 'Enter the email address for the user.',
            'password' => 'Enter the password for the user.',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // create the user
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => bcrypt($this->argument('password')),
        ]);

        $this->info('User created successfully.');

    }
}
