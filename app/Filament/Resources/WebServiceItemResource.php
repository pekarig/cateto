<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebServiceItemResource\Pages;
use App\Models\WebServiceItem;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WebServiceItemResource extends Resource
{
    protected static ?string $model = WebServiceItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Web Service Dobozok';

    protected static ?string $modelLabel = 'web service doboz';

    protected static ?string $pluralModelLabel = 'web service dobozok';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('page_id')
                    ->label('Oldal')
                    ->relationship('page', 'title')
                    ->required()
                    ->default(fn () => \App\Models\Page::where('slug', 'internetes-jelenlet')->first()?->id)
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('tagline')
                    ->label('Tagline')
                    ->required()
                    ->maxLength(255)
                    ->helperText('pl: Stack, Backend, Frontend'),

                Forms\Components\FileUpload::make('icon_path')
                    ->label('Icon')
                    ->disk('public')
                    ->directory('icons')
                    ->acceptedFileTypes(['image/svg+xml', 'image/png'])
                    ->maxSize(2048)
                    ->helperText('SVG vagy PNG ikon (max 2MB). Ha cserélni szeretnéd, töröld ki az X gombbal és tölts fel újat.')
                    ->previewable(false)
                    ->downloadable(false)
                    ->deletable(true),

                Forms\Components\TextInput::make('heading')
                    ->label('Heading')
                    ->required()
                    ->maxLength(255)
                    ->helperText('pl: Laravel, Vanilla JS'),

                Forms\Components\RichEditor::make('description')
                    ->label('Leírás')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'bulletList',
                        'orderedList',
                    ])
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('features')
                    ->label('Felsorolás (feature lista)')
                    ->schema([
                        Forms\Components\TextInput::make('text')
                            ->label('Elem')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->addActionLabel('+ Új elem hozzáadása')
                    ->defaultItems(0)
                    ->collapsible(),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0)
                    ->helperText('0-tól kezdve, balról jobbra, fentről le'),
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

                Tables\Columns\TextColumn::make('tagline')
                    ->label('Tagline')
                    ->searchable(),

                Tables\Columns\TextColumn::make('heading')
                    ->label('Heading')
                    ->searchable(),

                Tables\Columns\TextColumn::make('icon_path')
                    ->label('Icon')
                    ->formatStateUsing(fn (string $state = null): string => $state 
                        ? '<img src="' . asset('storage/' . $state) . '" style="width: 40px; height: 40px; object-fit: contain;" alt="Icon">'
                        : '-'
                    )
                    ->html(),

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
                Tables\Filters\SelectFilter::make('page')
                    ->relationship('page', 'title'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebServiceItems::route('/'),
            'create' => Pages\CreateWebServiceItem::route('/create'),
            'edit' => Pages\EditWebServiceItem::route('/{record}/edit'),
        ];
    }
}
