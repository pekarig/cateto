<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentBlockResource\Pages;
use App\Models\ContentBlock;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContentBlockResource extends Resource
{
    protected static ?string $model = ContentBlock::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-square-3-stack-3d';

    protected static ?string $navigationLabel = 'Tartalom Blokkok';

    protected static ?string $modelLabel = 'tartalom blokk';

    protected static ?string $pluralModelLabel = 'tartalom blokkok';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('page_id')
                    ->label('Oldal')
                    ->relationship('page', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('key')
                    ->label('Kulcs (egyedi azonosító)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('pl: bemutatkozas_hero'),

                Forms\Components\Select::make('type')
                    ->label('Blokk típus')
                    ->options([
                        'hero' => 'Hero szekció',
                        'content' => 'Tartalom',
                        'feature' => 'Feature card',
                        'cta' => 'Call to Action',
                        'custom' => 'Egyedi HTML',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\Textarea::make('content')
                    ->label(fn (callable $get) => $get('type') === 'custom' ? 'HTML Forrás' : 'Tartalom')
                    ->required()
                    ->columnSpanFull()
                    ->rows(fn (callable $get) => $get('type') === 'custom' ? 20 : 10)
                    ->helperText(fn (callable $get) => $get('type') === 'custom'
                        ? 'Írj be HTML kódot. Használható: Tailwind CSS osztályok.'
                        : 'HTML tartalom. Használhatsz HTML tageket és Tailwind osztályokat.'),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page.title')
                    ->label('Oldal')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('key')
                    ->label('Kulcs')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Típus')
                    ->badge(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sorrend')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Létrehozva')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContentBlocks::route('/'),
            'create' => Pages\CreateContentBlock::route('/create'),
            'edit' => Pages\EditContentBlock::route('/{record}/edit'),
        ];
    }
}
