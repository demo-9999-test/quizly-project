<?php

namespace App\Imports;

use App\Models\Quiz;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuizImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            Quiz::create([
                'name' => $row['name'],
                'description' => $row['description'],
                'timer' => $row['timer'],
                'status' => $row['status'],
                'reattempt' => $row['reattempt'],
                'type' => $row['type'],
                'subject' => $row['subject'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'service' => $row['service'],
                'question_order' => $row['question_order'],
            ]);
        }
    }
}
