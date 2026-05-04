<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportSectionMasterlistController extends Controller
{
    private function getSortedStudents(Section $section)
    {
        $sectionColumn = $section->track === 'TVL' ? 'tech_voc_section_id' : 'section_id';

        return Enrollment::where($sectionColumn, $section->id)
            ->orderBy('sex', 'desc') // Male before Female
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();
    }

    public function exportPdf(Section $section)
    {
        $section->load('adviser');
        $students = $this->getSortedStudents($section);
        
        $males = $students->where('sex', 'Male');
        $females = $students->where('sex', 'Female');

        $pdf = Pdf::loadView('pdf.section-masterlist', [
            'section' => $section,
            'males' => $males,
            'females' => $females,
            'totalMales' => $males->count(),
            'totalFemales' => $females->count(),
            'totalStudents' => $students->count(),
        ])->setPaper('a4', 'landscape'); // Landscape to fit address and multiple columns

        $filename = "{$section->grade_level} - {$section->name} - Masterlist.pdf";
        return $pdf->download($filename);
    }

    public function exportCsv(Section $section)
    {
        $section->load('adviser');
        $students = $this->getSortedStudents($section);
        
        $males = $students->where('sex', 'Male');
        $females = $students->where('sex', 'Female');

        $filename = "{$section->grade_level} - {$section->name} - Masterlist.csv";
        
        $response = new StreamedResponse(function() use ($males, $females, $section) {
            $handle = fopen('php://output', 'w');
            
            // Add Header Info
            fputcsv($handle, ['SECTION MASTERLIST']);
            fputcsv($handle, ['Section:', $section->name, 'Grade Level:', $section->grade_level]);
            fputcsv($handle, ['Adviser:', $section->adviser ? $section->adviser->name : 'N/A']);
            fputcsv($handle, []);
            
            $headers = ['LRN', 'NAME', 'BIRTHDATE', 'GUARDIAN NAME', 'CURRENT ADDRESS', 'CONTACT NUMBER'];
            
            // Output Males
            if ($males->count() > 0) {
                fputcsv($handle, ['MALE STUDENTS']);
                fputcsv($handle, $headers);
                $this->writeRows($handle, $males);
                fputcsv($handle, []);
            }
            
            // Output Females
            if ($females->count() > 0) {
                fputcsv($handle, ['FEMALE STUDENTS']);
                fputcsv($handle, $headers);
                $this->writeRows($handle, $females);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    private function writeRows($handle, $students)
    {
        foreach ($students as $student) {
            $name = strtoupper("{$student->last_name}, {$student->first_name} " . ($student->middle_name ?? ''));
            $address = trim("{$student->current_house_no} {$student->current_street} {$student->current_barangay} {$student->current_municipality} {$student->current_province}");
            fputcsv($handle, [
                $student->lrn,
                $name,
                $student->birthdate ? $student->birthdate->format('Y-m-d') : 'N/A',
                $student->guardian_name ?? 'N/A',
                $address,
                $student->contact_no ?? 'N/A'
            ]);
        }
    }
}
