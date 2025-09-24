<?php

namespace App\Listeners\Group;

use App\Events\Group\UpdatedRequestGroup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddMemberGroup
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdatedRequestGroup $event): void
    {
        if ($event->request->status === 'approved') {
            $event->request->group->member()->create([
                'user_id' => $event->request->user_id,
                'role' => 'member',
            ]);
        }
        
        // $event->request->delete();
    }
}
