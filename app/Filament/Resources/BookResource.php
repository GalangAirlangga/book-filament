<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $slug = 'books';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()
                    ->schema([
                        Card::make()->schema([
                            Grid::make()->schema([
                                TextInput::make('title')
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->disabled()
                                    ->unique(Book::class, 'slug', fn ($record) => $record),

                                MarkdownEditor::make('description')->columnSpan('full'),
                            ])
                        ]),
                        Section::make('Images')
                            ->schema([
                                FileUpload::make('image')
                                    ->required()
                                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, callable $get): string {
                                        return (string) str($file->getClientOriginalName())->prepend($get('isbn') . '-');
                                    })
                                    ->rules(['mimes:jpg,jpeg,png', 'max:1024'])
                                    ->directory('books')
                                    ->visibility('public')
                                    ->image(),
                            ])
                            ->collapsible(),

                        Section::make('Price')
                            ->schema([
                                TextInput::make('selling_price')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'Rp.', thousandsSeparator: '.', decimalPlaces: 0))
                                    ->numeric()
                                    ->required(),

                                TextInput::make('buying_price')
                                    ->numeric()
                                    ->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'Rp.', thousandsSeparator: '.', decimalPlaces: 0))
                                    ->required(),
                            ])
                            ->columns(),
                        Section::make('Inventory')
                            ->schema([
                                TextInput::make('isbn')
                                    ->label('ISBN')
                                    ->maxLength(13)
                                    ->numeric()
                                    ->required(),

                                TextInput::make('stock')
                                    ->label('Stock')
                                    ->required()
                                    ->default(0)
                                    ->minValue(0)
                                    ->numeric(),


                                TextInput::make('book_page')
                                    ->label('Total Page')
                                    ->default(0)
                                    ->minValue(0)
                                    ->numeric(),

                                TextInput::make('weight')
                                    ->label('Weight in gram')
                                    ->default(0)
                                    ->minValue(0)
                                    ->numeric(),
                                Radio::make('type_cover')
                                    ->in(['soft_cover', 'hard_cover'])
                                    ->options([
                                        'soft_cover' => 'Soft Cover',
                                        'hard_cover' => 'Hard Cover'
                                    ])->required(),
                            ])
                            ->columns(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_visible')
                                    ->label('Visible')
                                    ->helperText('This product will be hidden from users')
                                    ->default(true),
                            ]),

                        Section::make('Associations')
                            ->schema([
                                Select::make('publisher_id')
                                    ->relationship('publisher', 'name')
                                    ->searchable()
                                    ->required(),

                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),




            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('isbn')
                    ->sortable()
                    ->label('ISBN'),

                ImageColumn::make('image')
                    ->label('Cover')
                    ->toggleable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('publisher.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('selling_price'),

                TextColumn::make('buying_price')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('stock')
                    ->sortable(),

                TextColumn::make('description')
                    ->toggleable(isToggledHiddenByDefault: true),



                TextColumn::make('book_page')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('weight')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('type_cover')
                    ->enum([
                        'soft_cover' => 'Soft Cover',
                        'hard_cover' => 'Hard Cover'
                    ])
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_visible')
                    ->boolean()
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Visibility')
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category', 'publisher']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'category.name', 'publisher.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->category) {
            $details['Category'] = $record->category->name;
        }

        if ($record->publisher) {
            $details['Publisher'] = $record->publisher->name;
        }

        return $details;
    }

    protected static function getNavigationBadge(): ?string
    {
        return self::$model::where('stock', '<', 5)->count();
    }
}
