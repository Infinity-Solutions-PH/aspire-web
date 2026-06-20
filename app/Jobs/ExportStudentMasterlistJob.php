<?php

namespace App\Jobs;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Exception;
use ZipArchive;

class ExportStudentMasterlistJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;
    public $filters;

    public $timeout = 600; // 10 minutes timeout for large exports

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $filters)
    {
        $this->userId = $userId;
        $this->filters = $filters;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Cache::put('export_status_' . $this->userId, ['status' => 'processing'], now()->addHours(1));

            $query = Enrollment::query()
                ->with(['section.adviser', 'techVocSection.adviser'])
                ->whereIn('status', ['Enrolled', 'Approved', 'Rejected', 'Submitted', 'Dropped', 'Graduated']);

            if (!empty($this->filters['status']) && $this->filters['status'] !== 'All Status') {
                $query->where('status', $this->filters['status']);
            }

            if (!empty($this->filters['export_school_level'])) {
                if ($this->filters['export_school_level'] === 'JHS') {
                    $query->whereIn('grade_level', ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10']);
                } elseif ($this->filters['export_school_level'] === 'SHS') {
                    $query->whereIn('grade_level', ['Grade 11', 'Grade 12']);
                }
            }

            if (!empty($this->filters['export_school_level']) && $this->filters['export_school_level'] !== 'All' && 
                !empty($this->filters['export_grade_level']) && $this->filters['export_grade_level'] !== 'All') {
                $query->where('grade_level', $this->filters['export_grade_level']);
            }

            if (!empty($this->filters['export_school_level']) && $this->filters['export_school_level'] !== 'All' && 
                !empty($this->filters['export_grade_level']) && $this->filters['export_grade_level'] !== 'All' && 
                !empty($this->filters['export_section_id']) && $this->filters['export_section_id'] !== 'All') {
                $query->where(function ($q) {
                    $q->where('section_id', $this->filters['export_section_id'])
                        ->orWhere('tech_voc_section_id', $this->filters['export_section_id']);
                });
            }

            $students = $query->get();

            if ($students->isEmpty()) {
                Cache::put('export_status_' . $this->userId, ['status' => 'failed', 'message' => 'No student records found matching the export criteria.'], now()->addHours(1));
                return;
            }

            $males = $students->where('sex', 'Male')->sortBy('last_name')->sortBy('first_name');
            $females = $students->where('sex', 'Female')->sortBy('last_name')->sortBy('first_name');

            $csvHeaders = ['LRN', 'NAME', 'BIRTHDATE', 'GUARDIAN NAME', 'CURRENT ADDRESS', 'CONTACT NUMBER', 'GRADE LEVEL', 'SECTION', 'ADVISER'];

            $tempCsv = fopen('php://temp', 'r+');

            fputcsv($tempCsv, ['Male Students']);
            fputcsv($tempCsv, $csvHeaders);
            foreach ($males as $student) {
                fputcsv($tempCsv, $this->formatStudentRow($student));
            }

            fputcsv($tempCsv, []);

            fputcsv($tempCsv, ['Female Students']);
            fputcsv($tempCsv, $csvHeaders);
            foreach ($females as $student) {
                fputcsv($tempCsv, $this->formatStudentRow($student));
            }

            rewind($tempCsv);
            $csvContent = stream_get_contents($tempCsv);
            fclose($tempCsv);

            $zip = new ZipArchive;
            $fileName = 'Student_Masterlist_Export_'.date('Ymd_His').'.zip';
            
            // Use system temp directory for the zip building to prevent permission issues
            $tempFile = tempnam(sys_get_temp_dir(), 'export_');
            $zipPath = $tempFile . '.zip';

            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new Exception('Failed to create zip file.');
            }

            $zip->addFromString('Student_Masterlist.csv', $csvContent);

            $addedFiles = [];
            foreach ($students as $student) {
                if ($student->profile_picture && Storage::disk('public')->exists($student->profile_picture)) {
                    $filePath = Storage::disk('public')->path($student->profile_picture);
                    $ext = pathinfo($student->profile_picture, PATHINFO_EXTENSION) ?: 'jpg';

                    $middleInitial = $student->middle_name ? ' ' . strtoupper(substr($student->middle_name, 0, 1)) : '';
                    $baseName = strtoupper($student->last_name).', '.strtoupper($student->first_name).$middleInitial;
                    
                    // Sanitize file name to prevent ZipArchive close errors on invalid characters
                    $baseName = preg_replace('/[^A-Za-z0-9 \-\,\.\(\)]/', '_', $baseName);

                    $imageFileName = $baseName.'.'.$ext;

                    if (isset($addedFiles[$imageFileName])) {
                        $imageFileName = $baseName.' ('.$student->lrn.').'.$ext;
                    }

                    $addedFiles[$imageFileName] = true;
                    $zip->addFile($filePath, $imageFileName);
                }
            }

            if (!$zip->close()) {
                 throw new Exception('Failed to save zip file. Check file permissions or temp directory.');
            }

            // Move completed zip to the exports directory
            if (!file_exists(storage_path('app/exports'))) {
                mkdir(storage_path('app/exports'), 0777, true);
            }
            
            $finalPath = storage_path('app/exports/'.$fileName);
            copy($zipPath, $finalPath);
            
            // Clean up temporary files
            @unlink($zipPath);
            @unlink($tempFile);

            Cache::put('export_status_' . $this->userId, [
                'status' => 'completed', 
                'file' => $fileName
            ], now()->addHours(1));

        } catch (Exception $e) {
            Cache::put('export_status_' . $this->userId, ['status' => 'failed', 'message' => $e->getMessage()], now()->addHours(1));
        }
    }

    private function formatStudentRow($student)
    {
        $middleInitial = $student->middle_name ? ' ' . strtoupper(substr($student->middle_name, 0, 1)) : '';
        $name = strtoupper("{$student->last_name}, {$student->first_name}{$middleInitial}");

        $address = trim("{$student->current_house_no} {$student->current_street} {$student->current_barangay} {$student->current_municipality} {$student->current_province}");

        $sectionName = 'N/A';
        $adviserName = 'N/A';
        if ($student->section) {
            $sectionName = $student->section->name;
            if ($student->section->adviser) {
                $adviserName = $student->section->adviser->name;
            }
            if ($student->techVocSection) {
                $sectionName .= ' / TVL: ' . $student->techVocSection->name;
                if ($adviserName === 'N/A' && $student->techVocSection->adviser) {
                    $adviserName = $student->techVocSection->adviser->name;
                }
            }
        } elseif ($student->techVocSection) {
            $sectionName = 'TVL: ' . $student->techVocSection->name;
            if ($student->techVocSection->adviser) {
                $adviserName = $student->techVocSection->adviser->name;
            }
        }

        return [
            $student->lrn,
            $name,
            $student->birthdate ? $student->birthdate->format('Y-m-d') : 'N/A',
            $student->guardian_name ?? 'N/A',
            $address ?: 'N/A',
            $student->contact_no ?? 'N/A',
            $student->grade_level,
            $sectionName,
            $adviserName,
        ];
    }
}
