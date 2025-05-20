<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@lang('transfer.acceptance.title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 40px;
        }
        .signature {
            margin-top: 60px;
        }
        .footer {
            margin-top: 40px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo_umbb.png') }}" alt="Logo UMBB" class="logo">
        <h1>@lang('transfer.acceptance.title')</h1>
    </div>

    <div class="content">
        <p>@lang('transfer.acceptance.date'): {{ now()->format('d/m/Y') }}</p>

        <p>@lang('transfer.acceptance.dear') {{ $transferRequest->student->name }},</p>

        <p>@lang('transfer.acceptance.paragraph1')</p>

        <p>@lang('transfer.acceptance.paragraph2')</p>

        <div style="margin: 20px 0; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9;">
            <p><strong>@lang('transfer.acceptance.request_details'):</strong></p>
            <ul>
                <li>@lang('transfer.acceptance.request_id'): {{ $transferRequest->id }}</li>
                <li>@lang('transfer.acceptance.current_formation'): {{ $transferRequest->current_formation }}</li>
                <li>@lang('transfer.acceptance.desired_formation'): {{ $transferRequest->desired_formation }}</li>
                <li>@lang('transfer.acceptance.average_grade'): {{ $transferRequest->average_grade }}</li>
            </ul>
        </div>

        <p>@lang('transfer.acceptance.paragraph3')</p>

        <div style="margin: 20px 0;">
            <p><strong>@lang('transfer.acceptance.next_steps'):</strong></p>
            <ol>
                <li>@lang('transfer.acceptance.step1')</li>
                <li>@lang('transfer.acceptance.step2')</li>
                <li>@lang('transfer.acceptance.step3')</li>
            </ol>
        </div>
    </div>

    <div class="signature">
        <p>@lang('transfer.acceptance.sincerely')</p>
        <p>@lang('transfer.acceptance.director_name')</p>
        <p>@lang('transfer.acceptance.director_title')</p>
    </div>

    <div class="footer">
        <p>@lang('transfer.acceptance.footer1')</p>
        <p>@lang('transfer.acceptance.footer2')</p>
    </div>
</body>
</html> 