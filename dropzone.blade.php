//dropzone css
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

//form
<form class="" method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group">
                <label for="details" class="">Images</label>
                <div class="needsclick dropzone" id="document-dropzone"></div>
            </div>
        </div>
    </div>

    <button class="mt-2 btn btn-primary">Submit</button>
</form>

//script
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>
    let uploadedDocumentMap = {};
    Dropzone.autoDiscover = false;
    let myDropzone = new Dropzone("div#document-dropzone", {
        url: '{{ route('uploadImageViaAjax') }}',
        autoProcessQueue: true,
        uploadMultiple: true,
        addRemoveLinks: true,
        parallelUploads: 10,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        successmultiple: function(data, response) {
            $.each(response['name'], function(key, val) {
                $('form').append('<input type="hidden" name="images[]" value="' + val + '">');
                uploadedDocumentMap[data[key].name] = val;
            });
        },
        removedfile: function(file) {
            file.previewElement.remove()
            let name = '';
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name;
            } else {
                name = uploadedDocumentMap[file.name];
            }
            $('form').find('input[name="images[]"][value="' + name + '"]').remove()
        }
    });
</script>
