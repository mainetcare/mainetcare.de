<table class="table-auto">
    @foreach($appartements as $app)
        <tr class="border border-gray-100 @if(isset($appartement) && $app->id == $appartement->id) bg-gold-300 @endif">
            <td class="p-2 py-1 w-64">
                @if(isset($appartement) && $app->id == $appartement->id)
                    <span>{{ $app->entry->title }}</span>
                    @else
                    <a class="underline" href="{{ route('sperrzeiten.edit', ['id' => $app->id]) }}">
                        {{ $app->entry->title }}
                    </a>
                @endif
            </td>
            <td class="py-1 px-3">
                @if($app->status == \App\Models\Appartement::STATUS_NOT_AVAILABLE)
                    <span class="text-center inline-block w-full py-1 px-2 bg-orange-100 text-orange-900">Zzt. geblockt</span>
                @else
                    <span class="text-center inline-block w-full py-1 px-2 bg-green-100 text-green-600">Verfügbar</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>

