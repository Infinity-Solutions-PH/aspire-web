<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Section Masterlist - {{ $section->name }}</title>
    <style>
        @page { 
            margin: 40px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            color: #1b0d0d;
            line-height: 1.4;
            background-color: #ffffff;
            font-size: 10px;
        }
        
        /* Header */
        .header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #800000;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo {
            width: 70px;
            height: 70px;
        }
        .brand-container {
            padding-left: 15px;
        }
        .school-name {
            font-size: 24px;
            font-weight: 900;
            color: #800000;
            text-transform: uppercase;
            letter-spacing: -1px;
            margin: 0;
            line-height: 1;
        }
        .aspire-tagline {
            font-size: 9px;
            letter-spacing: 0.5px;
            color: #800000;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .aspire-letter { font-weight: 900; }

        /* Section Info */
        .info-panel {
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #e7cfcf;
            border-radius: 8px;
            padding: 10px;
            background: #fafafa;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #800000;
            font-size: 10px;
            text-transform: uppercase;
        }
        .info-val {
            font-weight: bold;
            font-size: 12px;
        }

        /* Data Tables */
        .group-title {
            font-size: 14px;
            font-weight: bold;
            color: #800000;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            border: 1px solid #e7cfcf;
            padding: 6px;
            text-align: left;
        }
        .data-table th {
            background-color: #800000;
            color: #ffffff;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .data-table td {
            font-size: 9px;
        }
        .text-center { text-align: center; }
        
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 70px;">
                    <img src="{{ public_path('images/logo.png') }}" class="logo" alt="TNTS Logo">
                </td>
                <td class="brand-container">
                    <h1 class="school-name">Tanza National Trade School</h1>
                    <div class="aspire-tagline">
                        <span class="aspire-letter">A</span>cademic <span class="aspire-letter">S</span>tudent <span class="aspire-letter">P</span>ortal <span class="aspire-letter">I</span>nformation <span class="aspire-letter">R</span>ecords and <span class="aspire-letter">E</span>nrollment
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-bottom: 15px;">
        <h2 style="margin:0; font-size: 18px; text-transform: uppercase; letter-spacing: 1px;">SECTION MASTERLIST</h2>
    </div>

    <div class="info-panel">
        <table class="info-table">
            <tr>
                <td class="info-label" style="width: 15%;">Grade Level:</td>
                <td class="info-val" style="width: 35%;">{{ $section->grade_level }}</td>
                <td class="info-label" style="width: 20%;">Total Students:</td>
                <td class="info-val" style="width: 30%;">{{ $totalStudents }}</td>
            </tr>
            <tr>
                <td class="info-label">Section Name:</td>
                <td class="info-val">{{ $section->name }}</td>
                <td class="info-label">Total Males:</td>
                <td class="info-val">{{ $totalMales }}</td>
            </tr>
            <tr>
                <td class="info-label">Adviser:</td>
                <td class="info-val">{{ $section->adviser ? $section->adviser->name : 'N/A' }}</td>
                <td class="info-label">Total Females:</td>
                <td class="info-val">{{ $totalFemales }}</td>
            </tr>
        </table>
    </div>

    @if($males->count() > 0)
        <div class="group-title">Male Students ({{ $totalMales }})</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">LRN</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 10%;">Birthdate</th>
                    <th style="width: 15%;">Guardian Name</th>
                    <th style="width: 25%;">Current Address</th>
                    <th style="width: 10%;">Contact No.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($males as $index => $student)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $student->lrn }}</td>
                        <td><strong>{{ strtoupper($student->last_name) }}, {{ strtoupper($student->first_name) }} {{ strtoupper($student->middle_name ?? '') }}</strong></td>
                        <td>{{ $student->birthdate ? $student->birthdate->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $student->guardian_name ?? 'N/A' }}</td>
                        <td>{{ trim("{$student->current_house_no} {$student->current_street} {$student->current_barangay} {$student->current_municipality} {$student->current_province}") }}</td>
                        <td>{{ $student->contact_no ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($females->count() > 0)
        <div class="group-title">Female Students ({{ $totalFemales }})</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">LRN</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 10%;">Birthdate</th>
                    <th style="width: 15%;">Guardian Name</th>
                    <th style="width: 25%;">Current Address</th>
                    <th style="width: 10%;">Contact No.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($females as $index => $student)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $student->lrn }}</td>
                        <td><strong>{{ strtoupper($student->last_name) }}, {{ strtoupper($student->first_name) }} {{ strtoupper($student->middle_name ?? '') }}</strong></td>
                        <td>{{ $student->birthdate ? $student->birthdate->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $student->guardian_name ?? 'N/A' }}</td>
                        <td>{{ trim("{$student->current_house_no} {$student->current_street} {$student->current_barangay} {$student->current_municipality} {$student->current_province}") }}</td>
                        <td>{{ $student->contact_no ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
