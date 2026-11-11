# Contact Form 7 — AMEZA

Установи Contact Form 7 и создай две формы. ID/шорткоды укажи в **Настройки сайта → Формы Contact Form 7**.

**Не оставляй исходные демонстрационные onsubmit/alert — в PHP-теме их нет.**

## 1. «Получить прайс-лист» (опт)

~~~html
<div class="form-group">
  [text* your-name autocomplete:name placeholder "Ваше имя *"]
</div>
<div class="form-group">
  [tel* your-phone autocomplete:tel placeholder "Телефон *"]
</div>
<div class="form-group">
  [email your-email autocomplete:email placeholder "Email"]
</div>
<div class="form-group">
  [text your-company placeholder "Компания"]
</div>
<div class="form-group">
  [textarea your-message placeholder "Комментарий (какая продукция интересует, объёмы)"]
</div>
<div class="form-group checkbox">
  [acceptance personal-data] Согласен с условиями обработки персональных данных и политикой конфиденциальности [/acceptance]
</div>
[submit class:btn "Отправить заявку"]
~~~

## 2. «Оставить заявку» (контакты)

~~~html
<div class="form-group">
  [text* your-name autocomplete:name placeholder "Ваше имя *"]
</div>
<div class="form-group">
  [tel* your-phone autocomplete:tel placeholder "Телефон *"]
</div>
<div class="form-group">
  [email your-email autocomplete:email placeholder "Email"]
</div>
<div class="form-group">
  [textarea your-message placeholder "Комментарий"]
</div>
<div class="form-group checkbox">
  [acceptance personal-data] Согласен с условиями обработки персональных данных и политикой конфиденциальности [/acceptance]
</div>
[submit class:btn "Отправить"]
~~~

Настрой почту получателя, тему письма, SPF/DKIM/SMTP, проверку согласия и обязательные ссылки на реальные юридические документы. Подставь актуальные ссылки в текст согласия.

**Поля письма:** [your-name], [your-phone], [your-email], [your-company] (для опта), [your-message], [_url], [_date], [_time].
