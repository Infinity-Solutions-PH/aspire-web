<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Statement of Account - TNTS</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #570000; padding-bottom: 10px; }
        .header h1 { color: #570000; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10px; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        
        .student-info { margin-bottom: 30px; width: 100%; border-collapse: collapse; }
        .student-info td { padding: 5px 0; vertical-align: top; }
        .student-info .label { font-weight: bold; color: #570000; width: 120px; text-transform: uppercase; font-size: 10px; }
        
        .fees-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .fees-table th { background: #f9f9f9; text-align: left; padding: 10px; border-bottom: 1px solid #eee; font-size: 10px; text-transform: uppercase; }
        .fees-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .fees-table .amount { text-align: right; font-family: 'Courier', monospace; }
        
        .footer { margin-top: 50px; }
        .total-row { background: #570000; color: white; }
        .total-row td { padding: 15px 10px; font-weight: bold; font-size: 14px; }
        
        .notice { font-size: 9px; color: #888; font-style: italic; margin-top: 40px; border-top: 1px dashed #ccc; padding-top: 10px; }
        .signature-block { margin-top: 40px; width: 200px; border-top: 1px solid #333; text-align: center; padding-top: 5px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <p>Republic of the Philippines</p>
        <p>Department of Education - Region IV-A CALABARZON</p>
        <h1>Tanza National Trade School</h1>
        <p>Tanza, Cavite | Institutional Billing Unit</p>
    </div>

    <h2 style="text-align: center; text-transform: uppercase; letter-spacing: 2px; color: #570000;">Statement of Account</h2>

    <table class="student-info">
        <tr>
            <td class="label">Student Name:</td>
            <td style="font-size: 14px; font-weight: bold;">{{ $enrollment->last_name }}, {{ $enrollment->first_name }} {{ $enrollment->middle_name }}</td>
            <td class="label">Date:</td>
            <td>{{ now()->format('F d, Y') }}</td>
        </tr>
        <tr>
            <td class="label">LRN:</td>
            <td>{{ $enrollment->lrn }}</td>
            <td class="label">Reference:</td>
            <td>#SOA-{{ $enrollment->id }}-{{ now()->format('Y') }}</td>
        </tr>
        <tr>
            <td class="label">Track/Strand:</td>
            <td>{{ $enrollment->track }} - {{ $enrollment->strand }}</td>
            <td class="label">Grade Level:</td>
            <td>Grade {{ $enrollment->grade_level }}</td>
        </tr>
    </table>

    <table class="fees-table">
        <thead>
            <tr>
                <th>Description of Fees</th>
                <th style="text-align: right;">Amount (PHP)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fees as $fee)
            <tr>
                <td>
                    <div style="font-weight: bold; text-transform: uppercase;">{{ $fee->name }}</div>
                    <div style="font-size: 9px; color: #666;">Track-specific institutional load fee</div>
                </td>
                <td class="amount">₱ {{ number_format($fee->amount, 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td style="text-transform: uppercase;">Total Balance Due</td>
                <td class="amount">₱ {{ number_format($fees->sum('amount'), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Payment Instructions:</strong></p>
        <p>Please present this Statement of Account (SOA) to the School Cashiering Office for payment processing. Check payments should be made payable to "Tanza National Trade School". For digital payments via GCash, please use the merchant code provided in the student portal.</p>
        
        <div style="margin-top: 60px; display: flex; justify-content: space-between;">
            <div class="signature-block">
                <strong>MARIA CLARA</strong><br>
                Internal Auditor / Registrar
            </div>
        </div>
    </div>

    <div class="notice">
        This is a computer-generated document. No signature is required. The authenticity of this ledger can be verified through the TNTS Living Archive Portal using the reference number provided above.
    </div>
</body>
</html>
