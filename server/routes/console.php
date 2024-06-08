<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('clear:authorized')->everyMinute();
Schedule::command('update:retirements')->dailyAt('23:59');
