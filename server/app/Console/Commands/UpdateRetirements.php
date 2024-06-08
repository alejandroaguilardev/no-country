<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Retired;
use App\Models\HistoricalRetired;


class UpdateRetirements extends Command
{
    protected $signature = 'update:retirements';

    protected $description = 'Actualizar retiros y campos de la tabla de retirados';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $retiredRecords = Retired::with('student.course', 'student.authorized', 'student.tutor')->get();

        foreach ($retiredRecords as $record) {
            $teacher = $record->student->course->first();
            HistoricalRetired::create([
                'student_id' => $record->student->id,
                'student_name' => $record->student->name . ' ' . $record->student->last_name,
                'course_id' => $record->student->course->id,
                'course_description' => $record->student->course->description,
                'authorized_id' => $record->student->authorized->id,
                'authorized_name' => $record->student->authorized->name . ' ' . $record->student->authorized->last_name,
                'tutor_id' => $record->student->tutor->id,
                'tutor_name' => $record->student->tutor->name . ' ' . $record->student->tutor->last_name,
                'date' => $record->date,
                'status' => $record->status,
                'presence' => $record->presence,
                'leave_alone' => $record->leave_alone,
            ]);
        }

        // Actualizar los campos de la tabla retirados
        Retired::query()->update([
            'status' => false,
            'presence' => true,
            'leave_alone' => false,
        ]);

        $this->info('Tabla histórica de retiros actualizada y campos de retirados actualizados.');
    }
}
