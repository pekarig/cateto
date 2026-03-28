<?php

namespace App\Filament\Resources\ContactInteractionResource\Pages;

use App\Filament\Resources\ContactInteractionResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;

class ManageContactInteractions extends ManageRecords
{
    protected static string $resource = ContactInteractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ContactInteractionResource\Widgets\ContactStatsWidget::class,
        ];
    }
}
