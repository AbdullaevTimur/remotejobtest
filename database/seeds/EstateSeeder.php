<?php

use Illuminate\Database\Seeder;

class EstateSeeder extends Seeder
{
    /**
    * Import data from CSV file.
    *
    * @return Array
    */
    function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename)) return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Use first row as a header
                if (!$header) {
                    $header = $row;
                } else {
                    // Use "array_push alias" and "array_combine" function to create objects.
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = public_path('property-data.csv');
        // Import and build array of items.
        $arr = $this->csvToArray($file);

        // Create new models during the loop iteration.
        for ($i = 0; $i < count($arr); $i ++) {
            App\Estate::firstOrCreate($arr[$i]);
        };
    }
}
