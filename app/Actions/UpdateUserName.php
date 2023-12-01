<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;


class UpdateUserName
{
    use AsAction;

    public string $commandSignature = 'user:update-name {user_id} {name}';
    public string $commandDescription = 'Updates the name of a user.';

    public function handle(User $user, string $newName)
    {
        $user->name = $newName;
        $user->save();
    }

    public function asController(Request $request)
    {
        $user = User::find(1);

        $this->handle($user , 'adminhere');
        return $user;
    }

    public function asCommand(Command $command)
    {
        $user = User::findOrFail($command->argument('user_id'));

        $this->handle($user, $command->argument('name'));

        $command->line(sprintf('Name updated for %s.', $user->name));
    }
}