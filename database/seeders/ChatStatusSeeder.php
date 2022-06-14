<?php

namespace Database\Seeders;

use App\Models\ChatStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatStatusSeeder extends Seeder
{
    /**
     * @var array $defaultStatuses
     */
    private array $defaultStatuses = [
        'chat',
        // 'group'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->defaultStatuses as $key => $status) {
            ChatStatus::factory()->create(compact('status'));
        }
    }
}
