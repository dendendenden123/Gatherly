<?php

namespace App\Jobs;

use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateMemberStatusJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->userService->recalculateMemberStatus();
        \Log::info('Reculculate member status run');
    }
}
