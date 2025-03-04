<?php

use App\Console\Commands\GenerateMonthlyFee;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/**
 * Artisan and task scheduling setup for the application.
 *
 * This file defines Artisan commands and schedules their execution. It includes
 * an inspiring quote command that is triggered hourly and a monthly task for 
 * generating monthly fees.
 */

// Artisan command to display an inspiring quote
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote()); // Display an inspiring quote
})->purpose('Display an inspiring quote')->hourly(); // Command will run every hour

// Task scheduling for generating monthly fees
Schedule::command(GenerateMonthlyFee::class)->monthly(); // Schedule 'GenerateMonthlyFee' command to run monthly
