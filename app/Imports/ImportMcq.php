<?php

namespace App\Imports;

use App\Models\Objective;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ImportMcq implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new Objective([
            'question'=> $row['question'],
            'option_a'=> $row['option_a'],
            'option_b'=> $row['option_b'],
            'option_c'=> $row['option_c'],
            'option_d'=> $row['option_d'],
            'correct_answer'=> $row['correct_answer'],
            'image'=> $row['image'],
            'audio' => $row['audio'],
            'video' => $row['video'],
            'mark' => $row['video'],
            'ques_type' => $row['ques_type'],
            'quiz_id'=>$row['quiz_id']
        ]);
    }
}
