<?php

namespace App\Imports;

use App\Models\Objective;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class Importtruefalse implements ToModel, WithHeadingRow
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
            'correct_answer'=> $row['correct_answer'],
            'image' => $row['image'],
            'audio' => $row['audio'],
            'video' => $row['video'],
            'mark' => $row['mark'],
            'ques_type' => $row['ques_type'],
            'quiz_id'=>$row['quiz_id']
        ]);
    }
}
