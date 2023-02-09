<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionsResource\Pages;
use App\Filament\Resources\TransactionsResource\RelationManagers\TransactionItemsRelationManager;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transactions;
use Closure;
use DB;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Str;

class TransactionsResource extends Resource
{
    protected static ?string $model = Transactions::class;

    protected static ?string $slug = 'transactions';

    protected static ?string $recordTitleAttribute = 'number';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')
                    ->disabled()
                    ->default(function (){
                        $transaction_prefix = 'TRX-';
                        $transaction_date = date('Y-m-d');
                        $transaction_count = DB::table('transactions')->count() + 1;

                        return $transaction_prefix . $transaction_date . '-' . str_pad($transaction_count, 5, '0', STR_PAD_LEFT);
                    })
                    ->required(),

                DatePicker::make('date')
                    ->disabled()
                    ->default(date('Y-m-d')),

                TextInput::make('total_price')
                    ->reactive()
                    ->disabled()
                    ->placeholder(function (Closure $get,Closure $set) {
                        $fields = $get('transactionItems');
                        \Log::info(json_encode($fields));
                        $sum = 0;
                        foreach($fields as $field){

                            $sum += (integer)$field['unit_price'] * (integer)$field['quantity'];

                        }
                        $set('total_price', $sum);
                        return $sum;
                    })
                    ->required()
                    ->numeric(),

                Select::make('type_payment')
                    ->options([
                        'debit' => 'Debit',
                        'cash' => 'Cash',
                        'credit' => 'Credit',
                    ])->required(),

                TextInput::make('note'),

                Repeater::make('transactionItems')
                    ->relationship()
                    ->schema([
                        Select::make('book_id')
                            ->label('Book')
                            ->reactive()
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search) => Book::where('is_visible','=',1)
                                ->where(function ($query) use ($search) {
                                $query->where('title', 'like', "%{$search}%")
                                    ->orWhere('isbn', 'like', "%{$search}%");
                            })->limit(50)->pluck('title', 'id'))
                            ->getOptionLabelUsing(fn ($value): ?string => Book::find($value)?->title)
                            ->afterStateUpdated(function ($state,Closure $get,Closure $set){
                                $set('unit_price', Book::find($state)?->selling_price ?? 0);
                            }),
                        TextInput::make('quantity')
                            ->rules([
                                function (Closure $get) {
                                    return function (string $attribute, $value, Closure $fail) use ($get) {

                                        $book = Book::find($get('book_id'));
                                        if ($book->stock < $value) {
                                            $fail("The quantity supplied exceeds the stock availability.");
                                        }
                                    };
                                },
                            ])
                            ->numeric()
                            ->reactive()
                            ->default(1),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->disabled()
                            ->reactive()
                            ->default(0),
                    ])
                    ->createItemButtonLabel('Add Items')->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date')
                    ->date(),

                TextColumn::make('total_price'),

                BadgeColumn::make('type_payment')
                    ->enum([
                        'debit' => 'Debit',
                        'cash' => 'Cash',
                        'credit' => 'Credit',
                    ])->colors([
                        'primary',
                        'secondary' => 'debit',
                        'warning' => 'cash',
                        'success' => 'credit',
                    ]),

                TextColumn::make('note'),
            ])->filters([
                SelectFilter::make('type_payment')
                    ->options([
                        'debit' => 'Debit',
                        'cash' => 'Cash',
                        'credit' => 'Credit',
                    ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TransactionItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransactions::route('/create'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'number'
        ];
    }

}
