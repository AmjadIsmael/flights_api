<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ExcelController extends Controller
{
    public function exportToExcel()
    {
        // Retrieve data from the 'users' table
        $users = DB::table('users')->get();

        // Create a CSV file
        $filename = 'users.csv';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $file = fopen($tempFile, 'w');

        // Write the header row
        fputcsv($file, ['ID', 'Name', 'Email', 'Created At']);

        // Write the data rows
        foreach ($users as $user) {
            fputcsv($file, [$user->id, $user->name, $user->email, $user->created_at]);
        }

        fclose($file);

        // Set the appropriate headers for the file download
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Return the file as a response
        return new Response(file_get_contents($tempFile), 200, $headers);
    }
}
