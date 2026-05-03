# Изменения на сайте за последние 24 часа

Документ составлен по истории Git в ветке `main` (`git log --since="24 hours ago"`): коммиты с **2026-05-03** по **2026-05-04** (сообщения в коммитах в основном общие — ниже сгруппировано по смыслу по затронутым файлам).

---

## Производительность, кеш и тяжёлые списки

- **`DataOutputCache`** — введён/расширен для кеширования JSON-ответов DataTables и части сводок; настройки в **`config/lagerplus.php`** (`data_output_cache`).
- **Дашборд** — `DashboardController`, `WarehouseProductsService`, `ProductProfitService`: меньше лишних запросов и дублирования работы (агрегаты, кеш на уровне сервиса).
- **Товары «упущенная выгода»** — отдельный сценарий **New** (`out-of-stock-new`): представление, маршруты, клиентский скрипт `public/plugins/products-out-of-stock-new/table.js`, команда прогрева кеша **`WarmOutOfStockNewDatatableCacheCommand`**, доработки `ProductsController`, `Products`, расчётные действия.
- **«К закупке»** (`SupplierController`, **`SuppliersDataTable`**, **`ProductsScopes::scopeSuppliersDataTable`**) — более узкие подзапросы при фильтрации по id, вынесенные HTTP-фильтры, передача **`recordsTotal` / `recordsFiltered`** в Yajra там, где это уместно, чтобы не считать лишний тяжёлый count.
- **«Поставщики»** — **`EloquentShipperRepository`**: при простой сортировке (id/name) и без SearchBuilder — отдельные лёгкие `count`, страница через `forPage` + `withShippers()` только на выборку; **`ShipperPaginationDTO`** и **`ShipperDataTablePresenter`** разделяют **recordsTotal** и **recordsFiltered**. **`ShipperService`** — пакетная подгрузка пользователей и фильтров без N+1.
- **Сотрудники / пользователи** — контроллеры и JSON-пути подготовлены к облегчённой выдаче (в т.ч. сжатый payload там, где применимо).
- Чеклист: **`docs/PERFORMANCE-CHECKLIST.md`** — зафиксированы маршруты, кеш, индексы и статусы оптимизаций.

---

## База данных и миграции

- Индексы под нагрузку: **`shipper_user`**, составной **`products (is_warehouse_item, supplier)`**, **`filters (user_id, active)`**, **`prices (product_id, name)`** — миграции `2026_05_03_12/13/140000`.
- Движения остатков — индексы по **`assortmentId`** в таблицах движений — миграция `2026_05_03_000001_...`.
- **`settings.value`** переведён в **LONGTEXT** — миграция `2026_05_04_000001_...` (устранение ошибки MySQL 1406 при больших значениях настроек).

После деплоя на стенды/прод нужно выполнить **`php artisan migrate`**.

---

## Интерфейс и маршруты «v2»

- Альтернативные страницы списков с более лёгкой загрузкой/кешем: **`index-v2`** для товаров, поставщиков («к закупке»), поставщиков (shipper), сотрудников, пользователей; классические **`index`** остаются со ссылками на v2 где настроено.
- **Настройки** — блоки: кеш вёрстки, форма бокового меню, подсказки у заголовков карточек; доработан **`SettingController`** и модель **`Setting`** (выборка по ключам).
- **Навигация** — **`SidebarMenuRegistry`**, **`AppServiceProvider`**, обновления **`navigation`**, маршруты в **`routes/uri/*.php`** и **`web.php`**.
- **Авторизация** — доработки **`RegisteredUserController`**, компоненты **`auth-brand`**, **`auth-input-group`**; страницы логина/регистрации приведены к единому стилю с эталоном из **`public/html/`** (в т.ч. правки множества HTML-шаблонов и подключение **ionicons** локально в `public/html/plugins/`).

---

## Шрифты и фронтенд-сборка

- Локальные веб-шри **Figtree** и **Source Sans 3** в **`public/fonts/`**, CSS **`public/css/figtree-local.css`**, **`source-sans-3-local.css`**; **`resources/css/app.css`**, **`custom.css`**, **`resources/js/app.js`**, **`package.json`** — подключение без внешних CDN (меньше зависимость от сети, предсказуемый First Paint).
- Скрипт **`scripts/sync-fonts.mjs`** для синхронизации шрифтов.

---

## Инфраструктура разработки

- Правило Cursor: **`.cursor/rules/ui-adminlte-html-kit.mdc`** — новый UI только из эталонов **`public/html/`**.
- Обновлены **`.env.example`**, **`phpunit.xml`**, **`DataTableRequest`**, **`ProductsTable`**, **`AppLayout`** и ряд вспомогательных файлов под перечисленные изменения.

---

## Что сознательно не детализируется здесь

- Массовые правки **`public/html/*.html`** (замена ссылок на шрифты/ресурсы) — техническая увязка с локальными ассетами, без смены бизнес-логики.
- Коммит **`кратко что сделано`** с **`lagerplus.code-workspace`** и **`.DS_Store`** — служебные файлы IDE/ОС, на поведение сайта не влияют.

---

## Как обновлять этот документ

Повторно сгенерировать обзор по Git:

```bash
git log --since="24 hours ago" --name-status --pretty=format:"=== %h %ad %s" --date=iso
```

При необходимости замените окно времени или добавьте сравнение с тегом релиза.
