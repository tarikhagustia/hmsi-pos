<div class="alert alert-{{ strtolower($type) }} alert-has-icon alert-dismissible">
    <div class="alert-icon"><i class="fas fa-{{ strtolower($icons[$type]) }}"></i></div>
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        <div class="alert-title">{{ $title}}</div>
        {{ $message }}
    </div>
</div>
