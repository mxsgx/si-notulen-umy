@extends('layouts.app')

@section('title', __('Tambah Notulen'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between mb-4">
                    <a class="btn btn-outline-secondary" href="{{ route('minute.index') }}">&laquo; {{ __('Kembali') }}</a>
                </div>
                <div class="card">
                    <div class="card-header bg-umy">{{ __('Tambah Notulen') }}</div>
                    <div class="card-body">
                        <form id="form" action="{{ route('minute.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @if(auth()->user()->role === 'super-admin')
                                <div class="form-group">
                                    <label for="study_id">{{ __('Prodi') }}</label>
                                    <select name="study_id" id="study_id" required class="form-control @error('study_id') is-invalid @enderror">
                                        @foreach(\App\Faculty::all() as $faculty)
                                            <optgroup label="{{ $faculty->name }}">
                                                @foreach($faculty->studies as $study)
                                                    <option value="{{ $study->id }}">{{ $study->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('study_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            @elseif(auth()->user()->role === 'admin')
                                <input type="hidden" name="study_id" value="{{ auth()->user()->study_id }}">
                            @endif
                            <div class="form-group">
                                <label for="agenda">{{ __('Agenda') }}</label>
                                <input type="text" name="agenda" required id="agenda" class="form-control @error('agenda') is-invalid @enderror" value="{{ old('agenda') }}">
                                @error('agenda')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lecturer_id">{{ __('Pemimpin Rapat') }}</label>
                                <select name="lecturer_id" id="lecturer_id" required class="form-control @error('lecturer_id') is-invalid @enderror">
                                    @foreach(\App\Lecturer::all()->sortBy('name') as $lecturer)
                                        <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                    @endforeach
                                </select>
                                @error('lecturer_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="notulis_id">{{ __('Notulis Rapat') }}</label>
                                <select name="notulis_id" id="notulis_id" required class="form-control @error('notulis_id') is-invalid @enderror">
                                    @foreach(\App\Lecturer::all()->sortBy('name') as $lecturer)
                                        <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                    @endforeach
                                </select>
                                @error('notulis_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="presents">{{ __('Peserta Rapat') }}</label>
                                <select name="presents[]" id="presents" class="form-control @error('presents') is-invalid @enderror" multiple>
                                    @foreach(\App\Lecturer::all()->sortBy('name') as $lecturer)
                                        <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                    @endforeach
                                </select>
                                @error('presents')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="meeting_id">{{ __('Jenis Rapat') }}</label>
                                <select name="meeting_id" id="meeting_id" required class="form-control @error('meeting_id') is-invalid @enderror">
                                    @foreach(\App\Meeting::all() as $meeting)
                                        <option value="{{ $meeting->id }}">{{ $meeting->name }}</option>
                                    @endforeach
                                </select>
                                @error('meeting_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="room_id">{{ __('Ruangan') }}</label>
                                <select name="room_id" id="room_id" required class="form-control @error('room_id') is-invalid @enderror">
                                    @foreach(\App\Room::all() as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="meeting_date">{{ __('Tanggal') }}</label>
                                <input type="date" name="meeting_date" required id="meeting_date" class="form-control @error('meeting_date') is-invalid @enderror" value="{{ old('meeting_date') }}">
                                @error('meeting_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-6 form-group ">
                                    <label for="start_at">{{ __('Mulai') }}</label>
                                    <input type="time" name="start_at" required id="start_at" class="form-control @error('start_at') is-invalid @enderror" value="{{ old('start_at') }}">
                                    @error('start_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="end_at">{{ __('Sampai') }}</label>
                                    <input type="time" name="end_at" required id="end_at" class="form-control @error('end_at') is-invalid @enderror" value="{{ old('start_at') }}">
                                    @error('end_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="note">{{ __('Hasil Rapat') }}</label>
                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror">{!! old('note') !!}</textarea>
                                @error('note')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <p class="small text-muted">{{ __('Tambah Lampiran') }}</p>
                                <div id="attachments">
                                    <table class="table table-borderless table-sm">
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right" colspan="2">
                                                    <button type="button" class="btn btn-sm btn-primary" data-action="clone">{{ __('Tambah Lampiran') }}</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                @error('attachments')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ __('Tambah') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>
@endpush

@push('body')
    <script type="text/javascript">
        jQuery('select').select2({
            width: '100%'
        });
        const editor = SUNEDITOR.create((document.getElementById('note') || 'note'), {
            buttonList: [['undo', 'redo'],
                ['font', 'fontSize', 'formatBlock'],
                ['paragraphStyle', 'blockquote'],
                ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
                ['fontColor', 'hiliteColor', 'textStyle'],
                ['removeFormat'],
                ['outdent', 'indent'],
                ['align', 'horizontalRule', 'list', 'lineHeight'],
                ['table', 'link', 'image', 'video'],
                ['fullScreen', 'showBlocks', 'codeView'],
                ['preview', 'print'],
                ['save'],],
            minHeight: '250px',
            minWidth: '100%',
            maxWidth: '100%',
        });
        document.querySelector('#form').addEventListener('submit', () => {
            editor.save();
        });
        jQuery('#attachments').find('[data-action="clone"]').on('click', function (e) {
            e.preventDefault();

            let template = jQuery(`
            <tr>
                <td>
                    <input type="file" name="attachments[]" class="form-control-file" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png,.pdf">
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-danger btn-sm" data-action="delete">{{ __('Hapus') }}</button>
                </td>
            </tr>
            `);

            template.find('[data-action="delete"]').on('click', function (e) {
                e.preventDefault();
                jQuery(e.target).parent().parent().remove();
            });

            jQuery('#attachments').find('tbody').append(template);
        });
    </script>
@endpush
