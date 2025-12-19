<?php

namespace App\Imports;

use App\Models\Subjective;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSubjective implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subjective([
            'question' => $row['question'],
            'mark' => $row['mark'],
            'audio' => $row['audio'],
            'video' => $row['video'],
            'image' => $row['image'],
            'quiz_id' => $row['quiz_id']
        ]);
    }
}
