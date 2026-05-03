<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Единая обёртка кеширования выдачи (JSON/DataTables): ключ = сегмент + ревизия группы + хэш запроса.
 * Сброс группы — bumpRevision(), без перебора ключей (совместимо с file/redis).
 */
final class DataOutputCache
{
    /** Товары, остатки, резервы, транзиты — общая ревизия для products.json и suppliers json. */
    public const REVISION_INVENTORY = 'inventory';

    public const SEGMENT_PRODUCTS_DATATABLE = 'products.dt';

    public const SEGMENT_SUPPLIERS_DATATABLE = 'suppliers.dt';

    public const REVISION_EMPLOYEES = 'employees';

    public const SEGMENT_EMPLOYEES_JSON = 'employees.json';

    public const REVISION_SHIPPERS = 'shippers';

    public const SEGMENT_SHIPPERS_DATATABLE = 'shippers.dt';

    /** Подсказки / описания по ключу (descriptions/json/...). */
    public const REVISION_DESCRIPTIONS = 'descriptions';

    public const SEGMENT_DESCRIPTIONS_BY_KEY = 'descriptions.by_key';

    /** Сумма цен на дашборде по имени прайса. */
    public const SEGMENT_DASHBOARD_PRICE_SUM = 'dashboard.price_sum';

    /** Сводка виджетов на странице /dashboard (счётчики, суммы, график). */
    public const REVISION_DASHBOARD_SUMMARY = 'dashboard.summary';

    public const SEGMENT_DASHBOARD_INDEX_STATS = 'dashboard.index_stats';

    /** GET /filters — payload активного фильтра пользователя. */
    public const SEGMENT_FILTERS_INDEX = 'filters.index';

    private const REV_PREFIX = 'lagerplus:docache:rev:';

    private const DATA_PREFIX = 'lagerplus:docache:data:';

    public static function enabled(): bool
    {
        return (bool) config('lagerplus.data_output_cache.enabled', true);
    }

    public static function ttlSeconds(): int
    {
        return max(1, (int) config('lagerplus.data_output_cache.ttl_seconds', 60));
    }

    public static function storeName(): string
    {
        $s = config('lagerplus.data_output_cache.store');
        if ($s !== null && $s !== '') {
            return (string) $s;
        }

        return (string) config('cache.default', 'file');
    }

    public static function bumpRevision(string $revisionDomain): void
    {
        $store = Cache::store(self::storeName());
        $key = self::REV_PREFIX.$revisionDomain;
        $v = (int) $store->get($key, 0);
        $store->forever($key, $v + 1);
    }

    public static function currentRevision(string $revisionDomain): int
    {
        return (int) Cache::store(self::storeName())->get(self::REV_PREFIX.$revisionDomain, 0);
    }

    /**
     * @template T
     *
     * @param  callable(): T  $callback
     * @return T
     */
    public static function remember(
        string $revisionDomain,
        string $cacheSegment,
        array $identityPayload,
        ?int $ttlSeconds,
        callable $callback
    ): mixed {
        if (! self::enabled()) {
            return $callback();
        }

        $ttl = $ttlSeconds ?? self::ttlSeconds();
        $rev = self::currentRevision($revisionDomain);
        $normalized = self::normalizeForKey($identityPayload);
        $hash = hash('sha256', json_encode($normalized, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
        $key = self::DATA_PREFIX.$cacheSegment.':r'.$rev.':'.$hash;

        return Cache::store(self::storeName())->remember($key, $ttl, $callback);
    }

    /**
     * Убрать из запроса поля, не влияющие на выборку, и добавить пользователя для разделения кеша.
     *
     * @param  array<string, mixed>  $request
     * @return array<string, mixed>
     */
    public static function identityFromDataTablesRequest(array $request): array
    {
        unset($request['draw'], $request['_token'], $request['_method']);
        if (Auth::check()) {
            $request['_uid'] = Auth::id();
        }

        return self::normalizeForKey($request);
    }

    /**
     * @param  array<string|int, mixed>  $data
     * @return array<string|int, mixed>
     */
    public static function normalizeForKey(array $data): array
    {
        ksort($data, SORT_STRING);
        $out = [];
        foreach ($data as $k => $v) {
            $out[$k] = is_array($v) ? self::normalizeForKey($v) : $v;
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public static function withDraw(array $payload, int $draw): array
    {
        $payload['draw'] = $draw;

        return $payload;
    }

    /** Ревизия кеша фильтров конкретного пользователя (см. Filter / FiltersController). */
    public static function revisionDomainUserFilters(int $userId): string
    {
        return 'filters.u'.$userId;
    }
}
