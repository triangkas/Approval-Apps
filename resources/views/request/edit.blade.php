<x-app-layout>
    <x-breadcrumb :title="__('Pengajuan')" :subtitle="$_action">
        <li class="breadcrumb-item"><a href="{{ route('request.index') }}">{{ __('Pengajuan') }}</a></li>
        <li class="breadcrumb-item"><a href="#">{{ $_action }}</a></li>
    </x-breadcrumb>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <form method="POST" action="{{ isset($dataForm) ? route('request.update', $dataForm->id) : route('request.store') }}" enctype="multipart/form-data">
                                @csrf
                                @if (isset($dataForm))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <x-input-label for="title" value='Judul <span class="text-danger">*</span>' />
                                                    <x-text-input id="title" name="title" type="text" class="form-control" :value="old('title', isset($dataForm) ? $dataForm->title : '')" />
                                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('title')" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <x-input-label for="title"
                                                        value='Koordinat Lokasi <span class="text-danger">*</span>' />
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <x-text-input id="latitude" name="latitude" type="text" class="form-control" placeholder="Latitude" :value="old('latitude', isset($dataForm) ? $dataForm->latitude : '')" />
                                                            <x-input-error class="mt-2 text-danger" :messages="$errors->get('latitude')" />
                                                        </div>
                                                        <div class="col-6">
                                                            <x-text-input id="longitude" name="longitude" type="text" class="form-control" placeholder="Longitude" :value="old('longitude', isset($dataForm) ? $dataForm->longitude : '')" />
                                                            <x-input-error class="mt-2 text-danger" :messages="$errors->get('longitude')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <x-input-label for="budget" value='Estimasi Budget <span class="text-danger">*</span>' />
                                                    <x-text-input id="budget" name="budget" type="text" class="form-control nominal-format" :value="old('budget',isset($dataForm) ? number_format($dataForm->budget, 0, ',', '.') : '')" />
                                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('budget')" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <x-input-label for="description" value='Keterangan <span class="text-danger">*</span>' />
                                                    <textarea class="form-control" rows="5" name="description">{{ old('description', isset($dataForm) ? $dataForm->description : '') }}</textarea>
                                                    <x-input-error class="mt-2 text-danger" :messages="$errors->get('description')" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Dokumen <span class="text-danger">*</span><small class="ml-2">(Minimal 3 dokumen yang di upload)</small></label>
                                                    <div id="document-wrapper">
                                                        <div class="document-item">
                                                            @if(isset($files) && $files->isNotEmpty())
                                                                @foreach($files as $file)
                                                                    <div class="input-group mb-2">
                                                                        <button type="button" class="btn btn-danger btn-sm delete-file mr-2" data-id="{{ $file->id }}"><i class="fas fa-trash"></i></button>
                                                                        <a href="{{ $pathFile.$file->file_path }}" target="_blank" class="form-control">{{ $file->file_path }}</a>
                                                                        <input type="hidden" name="stand_files[]" value="{{ $file->id }}" class="stand-file-id" style="display:none;">
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                            <div class="input-group mb-2">
                                                                <button type="button" class="btn btn-danger btn-sm delete-file mr-2"><i class="fas fa-trash"></i></button>
                                                                <input type="file" class="custom-file" name="files[]">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-info btn-sm pl-2 pr-2" id="add-file"><i class="fas fa-plus mr-1"></i> Tambah File</button>
                                                        </div>
                                                        <x-input-error class="mt-2 text-danger" :messages="$errors->get('files')" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="button-group mt-2">
                                            <button type="submit" class="btn btn-success" name="action" value="send"><i class="fas fa-paper-plane mr-2"></i> Kirim</button>
                                            <button type="submit" class="btn btn-primary" name="action" value="draft"><i class="fas fa-save mr-2"></i> Simpan Draft</button>
                                            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('request.index') }}'"><i class="fas fa-undo-alt mr-2"></i> Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function() {
            $('#add-file').click(function() {
                let html = `<div class="input-group mb-2"><button type="button" class="btn btn-danger btn-sm delete-file mr-2"><i class="fas fa-trash"></i></button><input type="file" class="custom-file" name="files[]"></div>`;
                $(html).insertBefore($(this).parent());
            });

            $('#document-wrapper').on('click', '.delete-file', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
</x-app-layout>
