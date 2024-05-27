<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('clear:authorized')->everyMinute();
