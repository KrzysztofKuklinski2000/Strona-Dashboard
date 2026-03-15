<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Potwierdzenie Subskrypcji</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 20px;">
    <tr>
      <td align="center">
        <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
          <tr>
            <td style="background-color: #e53e3e; padding: 30px; text-align: center;">
              <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Aktywuj email! 🥋</h1>
            </td>
          </tr>
          <tr>
            <td style="padding: 40px 30px; color: #333333; line-height: 1.6; font-size: 16px;">
                <p style="margin-top: 0;">Oss!</p>
                <p>Dziękujemy za chęć zapisu do powiadomień o aktualizacjach grafiku klubu Karate Kyokushin.
                    Aby potwierdzić swój adres e-mail i aktywować subskrypcję, kliknij w poniższy przycisk:
                </p>
              
              <div style="text-align: center; margin: 30px 0;">
                <a href="<?= $confirmUrl ?>" style="background-color: #e53e3e; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 4px; font-weight: bold; display: inline-block;">POTWIERDZAM SUBSKRYPCJĘ</a>
              </div>

              <p>Jeśli link powyżej nie działa, skopiuj go do przeglądarki:<br>
              <small><?= $confirmUrl ?></small></p>

              <p>Jeśli to nie Ty zapisywałeś się na naszej stronie, zignoruj tę wiadomość.</p>
              <p style="margin-bottom: 0;">Pozdrawiamy,<br><strong>Klub Karate Kyokushin</strong></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>