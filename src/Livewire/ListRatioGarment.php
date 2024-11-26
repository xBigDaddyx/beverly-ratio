<?php

namespace Xbigdaddyx\BeverlyRatio\Livewire;


use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Xbigdaddyx\BeverlyRatio\Models\RatioGarment;
use Filament\Tables;
use Filament\Tables\Table;
use stdClass;
use Xbigdaddyx\Beverly\Models\CartonBox;
use Xbigdaddyx\BeverlyRatio\Enums\RatioGarmentStatus;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Actions;
use Filament\Support\Enums;
use Xbigdaddyx\BeverlyRatio\Model\RatioTag;

class ListRatioGarment extends Component implements HasForms, HasTable, HasActions
{
    public CartonBox $carton;
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->action(fn() => $this->carton->delete());
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Ratio Garments')
            ->description('Scanned polybags history here.')
            ->deferLoading()
            ->striped()
            ->query(RatioTag::query()->where('carton_box_id', $this->carton->id))
            ->poll('3s')
            ->paginated([5, 10, 'all'])
            ->defaultPaginationPageOption(5)
            ->queryStringIdentifier('solid-polybags')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->state(
                        static function (Tables\Contracts\HasTable $livewire, stdClass $rowLoop): string {
                            return (string) (
                                $rowLoop->iteration +
                                ($livewire->getTableRecordsPerPage() * (
                                    $livewire->getTablePage() - 1
                                ))
                            );
                        }
                    ),
                Tables\Columns\TextColumn::make('uuid')
                    ->limit(10)
                    ->searchable()
                    ->sortable()
                    ->label('#'),
                Tables\Columns\TextColumn::make('box.box_code')
                    ->label('Box Code'),
                Tables\Columns\TextColumn::make('polybag_code')
                    ->label('Garment Code'),
                Tables\Columns\TextColumn::make('additional')
                    ->toggleable(isToggledHiddenByDefault: fn($state): bool => $state === null)
                    ->label('LPN'),
                Tables\Columns\TextColumn::make('box.attributes.color')
                    // ->hidden(fn (RelationManager $livewire): bool => $livewire->ownerRecord->type === 'RATIO' || $livewire->ownerRecord->type === 'MIX')
                    ->label('Color'),
                Tables\Columns\TextColumn::make('box.attributes.size')
                    // ->hidden(fn (RelationManager $livewire): bool => $livewire->ownerRecord->type === 'RATIO' || $livewire->ownerRecord->type === 'MIX')
                    ->label('Size'),

                Tables\Columns\TextColumn::make('box.type')
                    ->icon('tabler-badge')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'SOLID' => 'danger',
                        'MIX' => 'warning',
                        'RATIO' => 'success',
                    })
                    ->searchable()
                    ->label('Type'),
                Tables\Columns\TextColumn::make('status')
                    ->badge(RatioGarmentStatus::class)
                    ->label('Status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->icon('tabler-calendar')
                    ->iconColor('warning')
                    ->dateTime()
                    ->label('Validated At'),
                Tables\Columns\TextColumn::make('creator.name')
                    ->icon('tabler-user')
                    ->iconColor('danger')
                    ->label('Validated By'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // Actions\ViewAction::make(),
                Actions\DeleteAction::make()
                    ->tooltip('Delete this polybag')
                    ->size(Enums\ActionSize::Small)
                    ->button()
                    ->requiresConfirmation()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Garment deleted')
                            ->body('The polybag has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                    // ...
                ]),
            ]);
    }

    public function render(): View
    {
        return view('beverly-solid::livewire.list-solid-polybag');
    }
}
