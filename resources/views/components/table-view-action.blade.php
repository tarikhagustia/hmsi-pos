<div class="text-center">
    @if (!is_null($show))
        <a class="btn btn-info btn-sm d-inline-block" href="{{ $show }}" data-toggle="tooltip" data-placement="top" title="Detail">
            <i class="fas fa-eye"></i>
        </a>
    @endif

    @if (!is_null($edit))
        <a class="btn btn-warning btn-sm d-inline-block" href="{{ $edit }}" data-toggle="tooltip" data-placement="top" title="Sunting">
            <i class="fas fa-edit"></i>
        </a>
    @endif

    @if (!is_null($delete))
        <form class="d-inline-block" action="{{ $delete }}" method="POST" onsubmit="return confirm('Apakah anda yakin?')">
            @csrf
            {{ method_field('DELETE') }}
            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Invactive">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    @endif

    @if (!is_null($inactive) && $inactive != false)
        <form class="d-inline-block" action="{{ $inactive }}" method="POST"
              onsubmit="return confirm('Apakah anda yakin ingin menonaktifkan data ini?')">
            @csrf
            {{ method_field('POST') }}
            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Nonaktif">
                <i class="fas fa-times-circle"></i>
            </button>
        </form>
    @endif

    @if (!is_null($publish) && $publish != false)
        <form class="d-inline-block" action="{{ $publish }}" method="POST"
              onsubmit="return confirm('Apakah anda yakin ingin mempublish data ini?')">
            @csrf
            {{ method_field('POST') }}
            <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Publish">
                <i class="fas fa-check"></i>
            </button>
        </form>
    @endif

    {{ $slot }}
</div>
