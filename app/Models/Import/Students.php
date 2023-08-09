<?php

namespace App\Models\Import;

use Shuchkin\SimpleXLSX;

class Students
{
    private const FULL_NAME = 0;
    private const PHONE_NUMBER = 1;


    public function import(string $path): bool
    {
        if ($xlsx = SimpleXLSX::parse($path)){
            $rows = $xlsx->rows();
            for($i = 1; $i < count($rows); $i++){
                $student = [];
                $commentCols = [];
                $student = [
                    'name' => $rows[$i][self::FULL_NAME],
                    'phone' => $rows[$i][self::PHONE_NUMBER],
                ];
                for($j = 2; $j < count($rows[$i]); $j++){
                    if(!empty($rows[$i][$j]))
                        $commentCols[] = $rows[$i][$j];
                }
                $student['comment'] = implode(PHP_EOL, $commentCols);

                \App\Models\Student::updateOrInsert([
                    'name' => $student['name'],
                    'phone' => $student['phone'],
                    'comment' => $student['comment'],
                ]);
            }
        } else {
            return SimpleXLSX::parseError();
        }
        return true;
    }
}
