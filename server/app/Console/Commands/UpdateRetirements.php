<?php

namespace App\Console\Commands;

use App\Models\Authorized;
use Illuminate\Console\Command;
use App\Models\Retired;
use App\Models\HistoricalRetired;
use App\Models\Student;

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
        $this->historicalRetired();
        $this->authorizedUpdate();
        $this->retiredUpdate();
    }



    private function historicalRetired()
    {
        $retiredRecords = Retired::with('student.course', 'student.authorized', 'student.tutor')->get();
        foreach ($retiredRecords as $record) {
            $history = new HistoricalRetired;
            $history->student_id = $record->student->id;
            $history->student_name = $record->student->name . ' ' . $record->student->last_name;
            $history->course_id = $record->student->course->id;
            $history->course_description = $record->student->course->description;
            $history->authorized_id = $record->student->authorized->id;
            $history->authorized_name = $record->student->authorized->name . ' ' . $record->student->authorized->last_name;
            $history->tutor_id = $record->student->tutor->id;
            $history->tutor_name = $record->student->tutor->name . ' ' . $record->student->tutor->last_name;
            $history->date = $record->date;
            $history->status = $record->status;
            $history->presence = $record->presence;
            $history->leave_alone = $record->leave_alone;
            $history->save();
        }

        $this->info('Tabla histórica de retiros actualizada');
    }

    private function authorizedUpdate()
    {
        $students = Student::all();

        foreach ($students as $student) {
            
            $tutor = $student->tutor;

            if ($tutor) {
                
                $authorized = $student->authorized;

                if (!$authorized) {
                    $authorized = new Authorized();
                }

                $authorized->name = $tutor->name;
                $authorized->last_name = $tutor->last_name;
                $authorized->document_number = $tutor->document_number;
                $authorized->phone = $tutor->phone;

                $authorized->tutor_id = $tutor->id;

                $authorized->save();
            }
        }
        $this->info('Tabla autorizados actualizada.');
    }

    private function retiredUpdate()
    {
        Retired::query()->update([
            'status' => false,
            'presence' => true,
            'leave_alone' => false,
        ]);

        $this->info('Estados de la tabla retired actualizados.');
    }
}
