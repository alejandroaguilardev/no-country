<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('update:retirements')->dailyAt('23:59');
