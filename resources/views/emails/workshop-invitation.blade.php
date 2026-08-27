<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دعوة ورشة المكياج</title>
</head>
<body style="margin:0;padding:0;background:#f5ede7;font-family:'Segoe UI',Tahoma,Arial,sans-serif;-webkit-font-smoothing:antialiased;">
    <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background:#f5ede7;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="600" border="0" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border:1px solid #e9e0d4;">
                    <tr>
                        <td style="padding:0;font-size:0;line-height:0;">
                            <img src="{{ $base }}/email/lace-top.png" width="600" alt="" style="display:block;width:100%;height:auto;border:0;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 44px 24px;">
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom:10px;">
                                        <img src="{{ $base }}/email/inglot-sally-qadry.png" width="150" alt="INGLOT Sally Qadry" style="display:block;width:150px;height:auto;border:0;">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:8px 0 2px;">
                                        <div style="font-size:10px;letter-spacing:4px;color:#b08d57;text-transform:uppercase;">Makeup Workshop</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:0 0 18px;">
                                        <h1 style="margin:0;font-size:26px;font-weight:600;color:#1a1a1a;">دعوة ورشة المكياج</h1>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 18px;font-size:15px;line-height:28px;color:#444;">أهلاً {{ $registration->first_name }}،</p>
                            <p style="margin:0 0 22px;font-size:14px;line-height:26px;color:#666;">تم تأكيد حجزك لورشة المكياج مع {{ $workshop['artist'] }}. هاي تفاصيل الورشة:</p>

                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top:1px solid #eee;border-bottom:1px solid #eee;">
                                <tr>
                                    <td style="padding:12px 0;font-size:13px;color:#999;">التاريخ</td>
                                    <td align="left" style="padding:12px 0;font-size:14px;color:#1a1a1a;">{{ $workshop['dates_labels'][$registration->workshop_date] ?? $registration->workshop_date }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;font-size:13px;color:#999;border-top:1px solid #f2f2f2;">الوقت</td>
                                    <td align="left" style="padding:12px 0;font-size:14px;color:#1a1a1a;border-top:1px solid #f2f2f2;">{{ $workshop['time'] ?? '10:00 - 14:00' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;font-size:13px;color:#999;border-top:1px solid #f2f2f2;">المكان</td>
                                    <td align="left" style="padding:12px 0;font-size:14px;color:#1a1a1a;border-top:1px solid #f2f2f2;">{{ $workshop['place'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0;font-size:13px;color:#999;border-top:1px solid #f2f2f2;">العربون</td>
                                    <td align="left" style="padding:12px 0;font-size:14px;color:#1a1a1a;border-top:1px solid #f2f2f2;">{{ $registration->deposit_amount }}₪</td>
                                </tr>
                            </table>

                            <div style="margin:24px 0 0;padding:16px 18px;background:#faf6f0;border-right:2px solid #b08d57;">
                                <p style="margin:0;font-size:13px;line-height:24px;color:#777;">إذا بدك تعدّلي أو تلغي الحجز، بتقدري تتواصلي معنا عبر الواتساب.</p>
                            </div>

                            <p style="margin:24px 0 0;font-size:12px;line-height:22px;color:#aaa;">رقم الحجز: <span dir="ltr" style="color:#b08d57;">{{ $registration->id }}</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0;font-size:0;line-height:0;">
                            <img src="{{ $base }}/email/lace-bottom.png" width="600" alt="" style="display:block;width:100%;height:auto;border:0;">
                        </td>
                    </tr>
                </table>
                <p style="margin:20px 0 0;font-size:11px;color:#aaa;">INGLOT Sally Qadry — شفاعمرو</p>
            </td>
        </tr>
    </table>
</body>
</html>
