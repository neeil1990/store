<?php

namespace App\Actions;

use App\Models\Setting;
use Carbon\Carbon;

class CalculateFieldsAction
{
    protected string $message;

    public function execute(): void
    {
        $message = __('Вычисляемые поля успешно обновлены! ') . PHP_EOL;

        $occupancyCount = new UpdateOccupancyShipperAction;
        $occupancyCount->execute();

        $message .= 'Процент наполняемости: ' . $occupancyCount->getCount() . PHP_EOL;

        $quantityUpdate = new UpdateQuantityShipperAction;
        $quantityUpdate->execute();

        $message .= 'Количество товаров: ' . $quantityUpdate->getCount() . PHP_EOL;

        $purchase = new UpdateToPurchaseShipperAction;
        $purchase->execute();

        $message .= 'К закупке: ' . $purchase->getCount() . PHP_EOL;

        $purchaseTotal = new UpdatePurchaseTotalShipperAction;
        $purchaseTotal->execute();

        $message .= 'Общая сумма закупки по поставщику: ' . $purchaseTotal->getCount() . PHP_EOL;

        $this->updateComputedAt();

        $this->message = nl2br($message);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function computedAt(): string
    {
        $date = Setting::where(['key' => 'computed_at'])->value('value');

        if (!$date) {
            return '';
        }

        return Carbon::parse($date)->format('d.m.Y H:i:s');
    }

    private function updateComputedAt(): void
    {
        Setting::updateOrCreate(
            ['key' => 'computed_at'],
            ['value' => now()]
        );
    }

}
