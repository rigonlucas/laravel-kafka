<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function (): void {
    // imprime no stdout quando executado
    echo '[' . now()->toDateTimeString() . "] Task de teste executada em Laravel 12. Inspiring::quote()\n";
})
    ->name('task.test')
    ->everyFiveSeconds()
    ->withoutOverlapping();
