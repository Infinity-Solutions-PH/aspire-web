<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Enrollment - TNTS</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
            line-height: 1.5;
        }
        .container {
            padding: 40px;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #800000;
            padding-bottom: 20px;
        }
        .logo-placeholder {
            font-size: 24px;
            font-weight: bold;
            color: #800000;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .school-name {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            color: #800000;
        }
        .school-info {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }
        .content {
            font-size: 12px;
        }
        .declaration {
            margin-bottom: 30px;
            text-align: justify;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .data-table td {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .label {
            font-weight: bold;
            width: 30%;
            color: #666;
            text-transform: uppercase;
            font-size: 10px;
        }
        .value {
            font-weight: bold;
            color: #000;
            font-size: 13px;
        }
        .footer {
            margin-top: 60px;
        }
        .signatures {
            width: 100%;
            margin-top: 40px;
        }
        .signature-box {
            text-align: center;
            width: 45%;
        }
        .sig-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            font-weight: bold;
            font-size: 12px;
        }
        .sig-sub {
            font-size: 10px;
            color: #666;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(128, 0, 0, 0.05);
            font-weight: bold;
            z-index: -1;
            white-space: nowrap;
        }
        .qr-placeholder {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 80px;
            height: 80px;
            border: 1px solid #eee;
            text-align: center;
            font-size: 8px;
            color: #ccc;
            padding-top: 30px;
        }
    </style>
</head>
<body>
    <div class="watermark">OFFICIAL ENROLLMENT</div>
    <div class="container">
        <div class="header">
            <div class="logo-placeholder">TNTS ASPIRE</div>
            <h1 class="school-name">Tanza National Trade School</h1>
            <p class="school-info">Brgy. Paradahan I, Tanza, Cavite | Established 1959</p>
            <p class="school-info">Tel: (046) 437-0123 | Email: registrar@tnts.edu.ph</p>
        </div>

        <h2 class="title">Certificate of Enrollment</h2>

        <div class="content">
            <p class="declaration">
                This is to certify that the student named below is officially enrolled as a 
                <strong>{{ $enrollment->type }}</strong> student for the School Year 
                <strong>2026-2027</strong>. This certificate serves as temporary proof of enrollment 
                pending the issuance of a formal School ID.
            </p>

            <table class="data-table">
                <tr>
                    <td class="label">LEARNER REFERENCE NO. (LRN)</td>
                    <td class="value">{{ $enrollment->lrn }}</td>
                </tr>
                <tr>
                    <td class="label">STUDENT NAME</td>
                    <td class="value">{{ strtoupper($enrollment->last_name) }}, {{ strtoupper($enrollment->first_name) }} {{ strtoupper($enrollment->middle_name) }}</td>
                </tr>
                <tr>
                    <td class="label">GRADE LEVEL</td>
                    <td class="value">{{ $enrollment->grade_level }}</td>
                </tr>
                @if($enrollment->specialization)
                <tr>
                    <td class="label">SPECIALIZATION / STRAND</td>
                    <td class="value">{{ $enrollment->specialization ?: ($enrollment->strand ?: 'General Curriculum') }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">ENROLLMENT STATUS</td>
                    <td class="value" style="color: #008000;">OFFICIALLY ENROLLED</td>
                </tr>
                <tr>
                    <td class="label">DATE FINALIZED</td>
                    <td class="value">{{ $enrollment->finalized_at->format('F d, Y h:i A') }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <table class="signatures">
                <tr>
                    <td class="signature-box" style="width: 50%;">
                        <div class="sig-line">AUTOMATICALLY GENERATED</div>
                        <div class="sig-sub">System-Verified Enrollment</div>
                    </td>
                    <td style="width: 10%;"></td>
                    <td class="signature-box" style="width: 40%;">
                        <div class="sig-line" style="border-top: none;">
                            <img src="data:image/svg+xml;base64,{{ base64_encode('<svg width="150" height="40" xmlns="http://www.w3.org/2000/svg"><text x="0" y="30" font-family="Arial" font-size="14" fill="#000" font-style="italic">Registrar Official</text></svg>') }}">
                        </div>
                        <div class="sig-line">SCHOOL REGISTRAR</div>
                        <div class="sig-sub">Authorized Signature</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="qr-placeholder">
            VERIFICATION QR
            <br>
            {{ $enrollment->lrn }}
        </div>
    </div>
</body>
</html>
