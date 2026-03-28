<?php

namespace App\Filament\Resources\WebServiceItemResource\Pages;

use App\Filament\Resources\WebServiceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebServiceItems extends ListRecords
{
    protected static string $resource = WebServiceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
