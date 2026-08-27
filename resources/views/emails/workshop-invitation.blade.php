@php
    $name = trim($registration->first_name . ' ' . $registration->last_name);
    $when = $workshop['dates_labels'][$registration->workshop_date] ?? $registration->workshop_date;
    $artistAr = $workshop['artist'];
    $artistEn = $workshop['artist_en'] ?? 'Suar Mansour';

    $rows = [
        ['DATE — التاريخ', $when],
        ['TIME — الساعة', $workshop['time'] ?? '10:00 - 14:00'],
        ['LOCATION — المكان', $workshop['place']],
        ['ARTIST — الميك أب أرتيست', $artistAr],
        ['DEPOSIT — العربون', $workshop['deposit'] . '₪ — مدفوع'],
    ];
@endphp
<!doctype html>
<html dir="rtl" lang="ar">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>دعوة — {{ $name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&family=Manrope:wght@300;400;500;600&family=Amiri:ital,wght@0,400;0,700;1,400&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@300;400;500;600&family=Dancing+Script:wght@400;500;600;700&family=Parisienne&display=swap" rel="stylesheet" />
    <style>
      @page { size: A4 portrait; margin: 14mm; }
      @media print {
        html, body { background: #ffffff !important; }
        .page-pad { padding: 0 !important; }
        .invite-card { border: 1px solid #e6e0d8 !important; box-shadow: none !important; page-break-inside: avoid; break-inside: avoid; }
        .no-print { display: none !important; }
        * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      }
    </style>
  </head>
  <body style="margin:0;padding:0;background:#f7f5f2;">
    <div style="display:none;max-height:0;overflow:hidden;">دعوتك لورشة المكياج — {{ $when }}</div>
    <table role="presentation" class="page-pad" width="100%" cellpadding="0" cellspacing="0" style="background:#f7f5f2;padding:44px 14px;">
      <tr><td align="center">
        <table role="presentation" class="invite-card" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border:1px solid #ece7e0;">
          <tr>
            <td style="padding:56px 48px 0;text-align:center;">
              <div dir="ltr" style="font-size:11px;letter-spacing:9px;text-transform:uppercase;color:#2f2a25;font-family:'Sora',Helvetica,Arial,sans-serif;">INGLOT</div>
              <div dir="ltr" style="margin-top:9px;font-size:9px;letter-spacing:4px;text-transform:uppercase;color:#b0a698;font-family:'Manrope',Helvetica,Arial,sans-serif;">Sally Qadry · Makeup Workshop</div>

              <div style="margin:44px auto 0;width:36px;border-top:1px solid #e2dad0;"></div>

              <div dir="ltr" style="margin-top:38px;font-size:9px;letter-spacing:5px;text-transform:uppercase;color:#b0a698;font-family:'Manrope',Helvetica,Arial,sans-serif;">Invitation</div>
              <h1 style="margin:18px 0 0;font-size:46px;line-height:1.2;font-weight:400;letter-spacing:0.5px;color:#2f2a25;font-family:'Amiri','Noto Naskh Arabic','Noto Sans Arabic',Tahoma,Arial,sans-serif;">{{ $name }}</h1>

              <div style="margin:18px auto 0;max-width:380px;text-align:center;">
                <div dir="rtl" style="font-size:24px;line-height:1.4;color:#6b4f38;font-family:'Amiri','Noto Naskh Arabic','Noto Sans Arabic',Tahoma,Arial,sans-serif;">{{ $artistAr }}</div>
                <div dir="ltr" style="font-size:28px;line-height:1.35;font-weight:400;color:#6b4f38;font-family:'Dancing Script','Parisienne','Great Vibes',cursive;">{{ $artistEn }}</div>
                <div dir="ltr" style="margin-top:4px;font-size:8px;letter-spacing:3px;text-transform:uppercase;color:#b0a698;font-family:'Manrope',Helvetica,Arial,sans-serif;">with love, {{ $artistEn }}</div>
              </div>

              <p style="margin:24px auto 0;max-width:380px;font-size:15px;line-height:2;color:#7b7166;font-family:'Amiri','Noto Naskh Arabic','Noto Sans Arabic',Tahoma,Arial,sans-serif;">
                مكانك محجوز. استلمنا العربون وثبّتنا اسمك بورشة المكياج مع {{ $artistAr }}.
              </p>
              <p style="margin:18px auto 0;max-width:380px;font-size:14px;line-height:1.9;color:#9a8f82;font-family:'Amiri','Noto Naskh Arabic','Noto Sans Arabic',Tahoma,Arial,sans-serif;font-style:italic;text-align:center;">
                جاهزة لتكتشفي جمالك بإيدينا؟
              </p>
              <div style="margin:44px auto 0;width:36px;border-top:1px solid #e2dad0;"></div>
            </td>
          </tr>
          <tr>
            <td style="padding:30px 48px 0;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                @foreach ($rows as [$label, $value])
                <tr>
                  <td style="padding:18px 0;border-top:1px solid #ece7e0;">
                    <div dir="ltr" style="font-size:9px;letter-spacing:3.5px;text-transform:uppercase;color:#b0a698;font-family:'Manrope',Helvetica,Arial,sans-serif;">{{ $label }}</div>
                    <div dir="rtl" style="margin-top:8px;font-size:16px;color:#2f2a25;font-family:'Amiri','Noto Naskh Arabic','Noto Sans Arabic',Tahoma,Arial,sans-serif;direction:rtl;unicode-bidi:plaintext;text-align:center;">{{ $value }}</div>
                  </td>
                </tr>
                @endforeach
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:26px 48px 52px;">
              <p style="margin:0;font-size:12px;line-height:2;color:#b0a698;font-family:'Amiri','Noto Naskh Arabic','Noto Sans Arabic',Tahoma,Arial,sans-serif;text-align:center;">
                الساعة بتتأكد معك بالواتساب قبل الورشة. الإلغاء قبل أكثر من {{ $workshop['cancellation_days'] }} أيام بيرجّع العربون، وبعد هيك ما بيرجع.
              </p>
            </td>
          </tr>
          <tr>
            <td style="padding:22px 40px;border-top:1px solid #ece7e0;text-align:center;">
              <div dir="ltr" style="font-size:10px;letter-spacing:5px;text-transform:uppercase;color:#2f2a25;font-family:'Sora',Helvetica,Arial,sans-serif;">INGLOT Sally Qadry</div>
              <div style="margin-top:8px;font-size:11px;color:#b0a698;font-family:'Amiri','Noto Naskh Arabic','Noto Sans Arabic',Tahoma,Arial,sans-serif;">{{ $workshop['place'] }}</div>
            </td>
          </tr>
        </table>
      </td></tr>
    </table>
  </body>
</html>
