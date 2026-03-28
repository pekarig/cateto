<?php

namespace App\Filament\Resources\AiToolItemResource\Pages;

use App\Filament\Resources\AiToolItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAiToolItems extends ListRecords
{
    protected static string $resource = AiToolItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
