<?php

namespace App\Filament\Resources\WebServiceItemResource\Pages;

use App\Filament\Resources\WebServiceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebServiceItem extends EditRecord
{
    protected static string $resource = WebServiceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
