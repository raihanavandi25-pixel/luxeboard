<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('order_number')
                    ->required(),
                Select::make('status')
                    ->options([
                        'Created' => 'Created',
                        'Paid' => 'Paid',
                        'Shipped' => 'Shipped',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('Created'),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('shipping_tier')
                    ->required(),
                TextInput::make('shipping_fee')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('payment_method')
                    ->required(),
                TextInput::make('payment_status')
                    ->required()
                    ->default('Pending'),
                Textarea::make('shipping_address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('recipient_name')
                    ->required(),
                TextInput::make('recipient_phone')
                    ->tel()
                    ->required(),
                DateTimePicker::make('payment_expires_at'),
                DateTimePicker::make('delivered_at'),
                DateTimePicker::make('cancelled_at'),
            ]);
    }
}
