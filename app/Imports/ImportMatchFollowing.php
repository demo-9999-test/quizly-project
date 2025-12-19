<?php

namespace App\Imports;

use App\Models\Objective;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportMatchFollowing implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $options = [$row['option_a'], $row['option_b']];
        $correctAnswer = $row['correct_answer'];

        return new Objective([
            'question' => $row['question'],
            'options' => implode(',', $options),
            'correct_answer' => $correctAnswer,
            'image' => $row['image'],
            'audio' => $row['audio'],
            'video' => $row['video'],
            'mark' => $row['mark'],
            'ques_type' => $row['ques_type'],
            'quiz_id' => $row['quiz_id']
        ]);
    }
}
