<?php

namespace App\Console\Commands;

use App\Models\Authorized;
use Illuminate\Console\Command;
use App\Models\Retired;
use App\Models\HistoricalRetired;
use App\Models\Tutor;

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
            if (is_null($record->student->id)) {
                $this->error("Registro con ID {$record->id} tiene un student_id nulo.");
                continue;
            }

            try {
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

                $this->info("Registro con student_id {$record->student->id} insertado correctamente en la tabla histórica.");
            } catch (\Exception $e) {
                $this->error("Error al insertar el registro con student_id {$record->student->id}: {$e->getMessage()}");
            }
        }
        // Actualizar los campos de la tabla retirados
        Retired::query()->update([
            'status' => false,
            'presence' => true,
            'leave_alone' => false,
        ]);

        // Asignar tutor como autorizado por defecto
        $tutors = Tutor::with('students')->get();

        foreach ($tutors as $tutor) {
            // Verificar si ya existe un autorizado para este tutor
            $authorized = Authorized::firstOrCreate(
                [
                    'name' => $tutor->name,
                    'last_name' => $tutor->last_name,
                    'document_number' => $tutor->document_number,
                    'phone' => $tutor->phone,
                    'photo' => $tutor->photo,
                    'tutor_id' => $tutor->id,
                ]
            );

            // Actualizar el campo authorized_id para cada estudiante del tutor
            foreach ($tutor->students as $student) {
                $student->update(['authorized_id' => $authorized->id]);
            }
        }

        $this->info('Tabla histórica de retiros actualizada y campos de retirados actualizados.');
    }
}
