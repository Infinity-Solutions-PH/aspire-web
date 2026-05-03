<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Admission Pass - TNTS</title>
    <style>
        @page { 
            margin: 0;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            color: #1b0d0d;
            line-height: 1.4;
            background-color: #ffffff;
        }
        .page-break {
            page-break-before: always;
            clear: both;
        }
        
        /* Layout */
        .container {
            padding: 40px 60px 80px 60px;
            position: relative;
        }
        
        /* Header */
        .header {
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e7cfcf;
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
            padding-left: 20px;
        }
        .school-name {
            font-size: 26px;
            font-weight: 900;
            color: #800000;
            text-transform: uppercase;
            letter-spacing: -1.5px;
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

        /* Titles */
        .title-section {
            text-align: center;
            margin-bottom: 40px;
        }
        .cert-title {
            font-size: 32px;
            font-weight: 900;
            color: #1b0d0d;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .cert-badge {
            display: inline-block;
            margin-top: 8px;
            background: #800000;
            color: #ffffff;
            padding: 4px 16px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Notice Box */
        .notice-card {
            background: #fffafa;
            border: 1px solid #f5e6e6;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 35px;
            text-align: center;
        }
        .notice-text {
            font-size: 12px;
            color: #6d4c41;
            margin: 0;
            font-style: italic;
        }

        /* Data Section */
        .data-section {
            background: #ffffff;
            margin-bottom: 40px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 15px 0;
            border-bottom: 1px solid #f3ecec;
        }
        .info-label {
            font-size: 10px;
            font-weight: bold;
            color: #9a8a8a;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 35%;
        }
        .info-value {
            font-size: 16px;
            font-weight: bold;
            color: #1b0d0d;
        }
        .status-pill {
            background: #f0fdf4;
            color: #166534;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 900;
            border: 1px solid #dcfce7;
        }

        /* QR / Transaction Code */
        .id-card {
            margin-top: 50px;
            border: 2px solid #800000;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            background: #fff;
        }
        .qr-code {
            width: 140px;
            height: 140px;
            margin-bottom: 15px;
        }
        .trans-label {
            font-size: 10px;
            color: #9a8a8a;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .trans-id {
            font-family: 'Courier', monospace;
            font-size: 24px;
            font-weight: 900;
            color: #800000;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 50px;
            left: 60px;
            right: 60px;
            text-align: center;
            border-top: 1px solid #f3ecec;
            padding-top: 20px;
        }
        .footer-text {
            font-size: 10px;
            color: #9a8a8a;
            line-height: 1.6;
        }

        /* Secondary Page */
        .guide-header {
            font-size: 22px;
            font-weight: 900;
            color: #800000;
            margin-bottom: 25px;
            text-transform: uppercase;
            border-left: 5px solid #800000;
            padding-left: 15px;
        }
        .guide-section {
            margin-bottom: 40px;
        }
        .guide-title {
            font-size: 14px;
            font-weight: bold;
            color: #1b0d0d;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .checklist-box {
            background: #fdfbfb;
            border: 1px solid #f3ecec;
            border-radius: 12px;
            padding: 25px;
        }
        .check-item {
            font-size: 12px;
            margin-bottom: 12px;
            padding-left: 25px;
            position: relative;
            color: #4a3f3f;
        }
        .check-item:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #800000;
            font-weight: 900;
        }
        .warning-item:before {
            content: "!";
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <!-- Page 1: Admission Pass -->
    <div class="container">
        <div class="header">
            <table class="header-table">
                <tr>
                    <td style="width: 70px;">
                        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="TNTS Logo">
                    </td>
                    <td class="brand-container">
                        <h1 class="school-name">Tanza National Trade School</h1>
                        <div class="aspire-tagline">
                            <span class="aspire-letter">A</span>cademic 
                            <span class="aspire-letter">S</span>tudent 
                            <span class="aspire-letter">P</span>ortal 
                            <span class="aspire-letter">I</span>nformation 
                            <span class="aspire-letter">R</span>ecords and 
                            <span class="aspire-letter">E</span>nrollment
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="title-section">
            <h2 class="cert-title">Certificate of Admission</h2>
            <div class="cert-badge">ENROLLMENT PASS</div>
        </div>

        <div class="notice-card">
            <p class="notice-text">
                This document serves as your official entry pass for physical document verification. 
                Please ensure you bring all required original documents listed on the next page.
            </p>
        </div>

        <div class="data-section">
            <table class="info-table">
                <tr>
                    <td class="info-label">Learner Reference No. (LRN)</td>
                    <td class="info-value">{{ $enrollment->lrn }}</td>
                </tr>
                <tr>
                    <td class="info-label">Full Name</td>
                    <td class="info-value">{{ strtoupper($enrollment->last_name) }}, {{ strtoupper($enrollment->first_name) }} {{ strtoupper($enrollment->middle_name) }}</td>
                </tr>
                <tr>
                    <td class="info-label">Grade Level</td>
                    <td class="info-value">{{ $enrollment->grade_level }}</td>
                </tr>
                @if($enrollment->specialization || $enrollment->strand)
                <tr>
                    <td class="info-label">Strand / Specialization</td>
                    <td class="info-value">{{ $enrollment->specialization ?: ($enrollment->strand ?: 'N/A') }}</td>
                </tr>
                @endif
                <tr>
                    <td class="info-label">Enrollment Status</td>
                    <td><span class="status-pill">PRE-ENROLLED</span></td>
                </tr>
                <tr>
                    <td class="info-label">Submission Date</td>
                    <td class="info-value" style="font-size: 13px;">{{ $enrollment->finalized_at->format('F d, Y h:i A') }}</td>
                </tr>
            </table>
        </div>

        <div class="id-card" style="margin-top: 30px; padding: 20px;">
            <div class="trans-label">Verification QR Code</div>
            @if($qrCode)
                <img class="qr-code" style="width: 120px; height: 120px;" src="{{ $qrCode }}" alt="QR Code">
            @else
                <div style="width: 120px; height: 120px; border: 1px solid #eee; margin: 0 auto; padding-top: 50px; font-size: 10px; color: #ccc;">QR CODE<br>PENDING</div>
            @endif
            <div class="trans-label" style="margin-top: 5px;">Transaction Reference Number</div>
            <div class="trans-id" style="font-size: 20px;">{{ $enrollment->transaction_number }}</div>
        </div>

        <div class="footer">
            <div class="footer-text">
                <strong>Tanza National Trade School - Registrar's Office</strong><br>
                Brgy. Paradahan I, Tanza, Cavite | established 1959<br>
                (046) 437-0123 | registrar@tnts.edu.ph | tnts.edu.ph
            </div>
        </div>
    </div>

    <!-- Page 2: Guide -->
    <div class="container" style="page-break-before: always;">
        <div class="header" style="border-bottom: 2px solid #1b0d0d; margin-bottom: 20px;">
            <h1 class="school-name" style="color: #1b0d0d; font-size: 20px;">Physical Verification Guide</h1>
            <div class="aspire-tagline" style="color: #888;">TNTS ASPIRE | SY 2026-2027</div>
        </div>

        <div class="guide-section" style="margin-bottom: 25px;">
            <h3 class="guide-header" style="font-size: 18px; margin-bottom: 15px;">Checklist of Requirements</h3>
            <div class="checklist-box" style="padding: 15px;">
                <div class="check-item"><strong>Printed Copy</strong> of this Certificate of Admission</div>
                <div class="check-item"><strong>Original & Photocopy</strong> of PSA Birth Certificate</div>
                <div class="check-item"><strong>Original Report Card</strong> (Form 138) from previous school year</div>
                <div class="check-item">Original <strong>Certificate of Good Moral Character</strong></div>
                <div class="check-item"><strong>Two (2) pieces 2x2 ID Pictures</strong> (White background, with name tag)</div>
                <div class="check-item"><strong>Long Brown Envelope</strong> (1 piece)</div>
                @if($enrollment->grade_level == 'Grade 11')
                <div class="check-item"><strong>NCAE Results</strong> (for SHS Applicants)</div>
                @endif
            </div>
        </div>

        <div class="guide-section" style="margin-bottom: 25px;">
            <h3 class="guide-header" style="font-size: 18px; margin-bottom: 15px;">Campus Rules & Etiquette</h3>
            <div class="checklist-box" style="background: #fff8f8; border-color: #f5e6e6; padding: 15px;">
                <div class="guide-title" style="color: #1e7e34; margin-bottom: 10px;">✓ Guidelines for Entry</div>
                <div class="check-item"><strong>Dress Code:</strong> Wear decent attire. Strictly no slippers, sando, or short shorts allowed.</div>
                <div class="check-item"><strong>Silence:</strong> Maintain silence especially near testing rooms and administrative offices.</div>
                <div class="check-item"><strong>Punctuality:</strong> Arrive at least 15 minutes before your scheduled verification time.</div>
                
                <div class="guide-title" style="color: #d32f2f; margin-top: 15px; margin-bottom: 10px;">✗ Prohibited Actions</div>
                <div class="check-item warning-item">No smoking or vaping within the school vicinity.</div>
                <div class="check-item warning-item">Do not bring sharp objects or any hazardous materials.</div>
                <div class="check-item warning-item">Avoid loitering in restricted student-only areas.</div>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center; border: 1px dashed #e7cfcf; padding: 15px; border-radius: 10px;">
            <p style="font-size: 10px; color: #9a8a8a; margin: 0; font-style: italic;">
                "Dedicated to Excellence in Technical and Vocational Education since 1959"
            </p>
        </div>

        <div class="footer">
            <div class="footer-text">
                For inquiries, visit our official Facebook page: <strong>fb.com/TNTSOfficial</strong>
            </div>
        </div>
    </div>
</body>
</html>
