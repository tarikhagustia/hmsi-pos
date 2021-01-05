<div class="row">
    <div class="col">
        <select class="form-control" wire:model="branch">
            <option value="0">-- pilih cabang --</option>
            @foreach(\App\Branch::all() as $row)
                <option value="{{$row->id}}">{{$row->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col">

        <select class="form-control" wire:model="month">
            <option value="0">-- pilih bulan --</option>
            @foreach(list_months() as $key => $row)
                <option value="{{$key}}">{{$row}}</option>
            @endforeach
        </select>
    </div>
    <div class="col">

        <select class="form-control" wire:model="year">
            <option value="0">-- pilih tahun --</option>
            @foreach(list_years() as $key => $row)
                <option value="{{$key}}">{{$row}}</option>
            @endforeach
        </select>
    </div>

</div>




