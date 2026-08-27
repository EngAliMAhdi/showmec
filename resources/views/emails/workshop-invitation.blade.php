<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>دعوة ورشة المكياج</title>
</head>
<body style="margin:0;padding:0;background:#f5ede7;font-family:Tahoma,Arial,sans-serif;">
    <div style="max-width:560px;margin:0 auto;padding:32px 20px;">
        <div style="background:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #eee;">
            <div style="padding:32px;">
                <h1 style="margin:0 0 16px;font-size:22px;color:#1a1a1a;">أهلاً {{ $registration->first_name }}،</h1>
                <p style="font-size:15px;line-height:1.8;color:#444;">
                    تم تأكيد حجزك لورشة المكياج مع {{ $workshop['artist'] }}.
                </p>
                <table style="width:100%;font-size:14px;color:#333;border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px 0;color:#888;">التاريخ</td>
                        <td style="text-align:left;">{{ $workshop['dates_labels'][$registration->workshop_date] ?? $registration->workshop_date }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;color:#888;">المكان</td>
                        <td style="text-align:left;">{{ $workshop['place'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;color:#888;">العربون</td>
                        <td style="text-align:left;">{{ $registration->deposit_amount }}₪</td>
                    </tr>
                </table>
                <p style="font-size:14px;line-height:1.8;color:#777;">
                    ساعة البداية ستتأكد معك عبر الواتساب قبل الورشة.
                </p>
                <p style="font-size:13px;line-height:1.8;color:#999;">
                    رقم الحجز الخاص بك: <span dir="ltr">{{ $registration->id }}</span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
