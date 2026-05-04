<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Enrollment;
use App\Models\Section;
use Illuminate\Support\Facades\Artisan;

#[Signature('sections:reset')]
#[Description('Reset all sections by clearing assignments, deleting existing sections, and re-seeding the sections table')]
class ResetSections extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting section reset process...');

        $this->info('1. Detaching students from existing sections...');
        Enrollment::query()->update(['section_id' => null]);

        $this->info('2. Deleting all existing sections...');
        Section::query()->delete();

        $this->info('3. Seeding sections using JhsSectionSeeder...');
        Artisan::call('db:seed', [
            '--class' => 'JhsSectionSeeder',
            '--force' => true
        ]);
        $this->line(Artisan::output());

        $this->info('Sections reset successfully!');
    }
}
