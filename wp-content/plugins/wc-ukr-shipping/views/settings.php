<?php
  if ( ! defined('ABSPATH')) {
      exit;
  }
?>

<div class="wcus-layout">

  <div id="wc-ukr-shipping-settings" class="wcus-settings">
    <div class="wcus-settings__header">
      <h1 class="wcus-settings__title"><?= __('options_page_heading', WCUS_TRANSLATE_DOMAIN); ?></h1>
      <div class="wcus-settings__head-buttons">
        <a target="_blank" href="https://kirillbdev.pro/docs/wcus-base-setup/" class="wcus-btn wcus-btn--docs wcus-btn--md wcus-settings__docs">
            <?= wc_ukr_shipping_import_svg('docs.svg'); ?>
            <?= __('top_panel_docs', WCUS_TRANSLATE_DOMAIN); ?>
        </a>
        <button type="submit" form="wc-ukr-shipping-settings-form" class="wcus-settings__submit wcus-btn wcus-btn--primary wcus-btn--md"><?= __('options_btn_save', WCUS_TRANSLATE_DOMAIN); ?></button>
      </div>
      <div id="wcus-settings-success-msg" class="wcus-settings__success wcus-message wcus-message--success"></div>
    </div>
    <div class="wcus-settings__content">
      <form id="wc-ukr-shipping-settings-form" action="/" method="POST">
        <ul class="wcus-tabs">
          <li data-pane="wcus-pane-general" class="active"><?= __('options_tab_common', WCUS_TRANSLATE_DOMAIN); ?></li>
          <li data-pane="wcus-pane-shipping"><?= __('options_tab_shipping', WCUS_TRANSLATE_DOMAIN); ?></li>
          <li data-pane="wcus-pane-translates"><?= __('options_tab_translates', WCUS_TRANSLATE_DOMAIN); ?></li>
        </ul>
        <?= \kirillbdev\WCUSCore\Foundation\View::render('partial/settings_general'); ?>
        <?= \kirillbdev\WCUSCore\Foundation\View::render('partial/settings_shipping'); ?>
        <?= \kirillbdev\WCUSCore\Foundation\View::render('partial/settings_translates'); ?>
      </form>
    </div>
  </div>

  <div class="wcus-pro-features">
    <div class="wcus-card">
      <div class="wcus-card__content">
        <div class="wcus-card__title wcus-pro-features__title">Получайте больше возможностей от нашей Premium версии</div>
        <div class="wcus-pro-features__list">
          <div class="wcus-pro-features__feature">
            Полноценная работа курьерской доставки. Ваши клиенты смогут точно указать адрес доставки курьером используя онлайн-справочник Новой Почты.
          </div>
          <div class="wcus-pro-features__feature">
            Автоматический расчет стоимости доставки. Поддерживается расчет стоимости по типу Отделение-Отделение, Отделение-Адрес, а также возможность учета наложенного платежа при расчете.
          </div>
          <div class="wcus-pro-features__feature">
            Расчет доставки в зависимости от суммы заказа.
          </div>
          <div class="wcus-pro-features__feature">
            Возможность настроить отдельный расчет стоимости для адресной доставки.
          </div>
          <div class="wcus-pro-features__feature">
            Создание экспресс-накладных. Поля из заказа подтягиваются автоматически, так что вам не придется каждый раз вбивать данные вручную. Поддерживается создание накладных как на физ. лицо, так и на организацию. Поддержка создания накладных с наложенным платежем, а также услугами "Контроль оплаты" и "Отправление не в коробке".
          </div>
          <div class="wcus-pro-features__feature">
            Массовое управление накладными. Генерируйте, печатайте или удаляйте накладные для нескольких заказов в 1 клик.
          </div>
          <div class="wcus-pro-features__feature">
            Вывод на печать накладных: A4 (1 копия), A4 (2 копии), Маркировки 85х85, Маркировки 100х100 (зебра). Поддержка возможности печатать накладные сразу для нескольких заказов.
          </div>
          <div class="wcus-pro-features__feature">
            Premium поддержка и постоянное развитие плагина.
          </div>
        </div>

        <a target="_blank" href="https://kirillbdev.pro/wc-ukr-shipping-pro/?ref=plugin" class="wcus-btn wcus-pro-features__become-pro">
            <?= wc_ukr_shipping_import_svg('star.svg'); ?>
            Стать Premium клиентом
        </a>

      </div>
    </div>
  </div>

</div>
